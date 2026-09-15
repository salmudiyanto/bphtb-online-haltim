<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Auth\OdbcUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Database connection name.
     */
    protected $connection = 'odbc';

    /**
     * Handle user login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginInput = trim($request->input('username'));
        $password = $request->input('password');

        // Query user from t_users_bphtb via ODBC using Sybase FIRST syntax
        $users = DB::connection($this->connection)
            ->select("SELECT FIRST * FROM t_users_bphtb WHERE email = ? OR username = ?", [$loginInput, $loginInput]);

        $user = !empty($users) ? $users[0] : null;

        // Failed credentials check
        if (!$user || !Hash::check($password, $user->password_hash)) {
            $this->logLoginAttempt($user ? $user->id : null, $loginInput, $request->ip(), 'FAILED');

            return response()->json([
                'status' => 'error',
                'message' => 'Username/email atau kata sandi tidak valid.'
            ], 401);
        }

        // Check active and verified status
        if (isset($user->is_active) && (int) $user->is_active !== 1) {
            $this->logLoginAttempt($user->id, $loginInput, $request->ip(), 'FAILED');

            return response()->json([
                'status' => 'error',
                'message' => 'Akun Anda tidak aktif. Silakan hubungi administrator.'
            ], 401);
        }

        $odbcUser = new OdbcUser($user);

        // Generate JWT token
        try {
            $accessToken = JWTAuth::fromUser($odbcUser);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghasilkan token autentikasi: ' . $e->getMessage()
            ], 500);
        }

        // Generate custom refresh token
        $refreshToken = Str::random(60);

        // Insert session record to t_user_sessions_bphtb
        $sessionId = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
        try {
            DB::connection($this->connection)
                ->statement("INSERT INTO t_user_sessions_bphtb (id, user_id, refresh_token, ip_address, user_agent, expires_at, is_revoked, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", [
                    $sessionId,
                    $user->id,
                    $refreshToken,
                    $request->ip(),
                    substr($request->userAgent(), 0, 500),
                    date('Y-m-d H:i:s', strtotime('+7 days')),
                    0,
                    date('Y-m-d H:i:s'),
                ]);
        } catch (\Exception $e) {
            // Non-blocking fallback if session insert fails due to DB schema variation
        }

        // Log successful login attempt
        $this->logLoginAttempt($user->id, $user->email, $request->ip(), 'SUCCESS');

        return response()->json([
            'status' => 'success',
            'message' => 'Login berhasil',
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl', 60) * 60,
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
                'username' => $user->username,
            ]
        ]);
    }

    /**
     * Refresh access token using custom refresh token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(Request $request)
    {
        $refreshToken = $request->input('refresh_token');

        if (!$refreshToken) {
            return response()->json([
                'status' => 'error',
                'message' => 'Refresh token wajib disertakan.'
            ], 400);
        }

        $sessions = DB::connection($this->connection)
            ->select("SELECT FIRST * FROM t_user_sessions_bphtb WHERE refresh_token = ? AND is_revoked = 0", [$refreshToken]);

        $session = !empty($sessions) ? $sessions[0] : null;

        if (!$session) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sesi tidak valid atau telah dicabut.'
            ], 401);
        }

        if (!empty($session->expires_at) && strtotime($session->expires_at) < time()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sesi telah kedaluwarsa. Silakan login kembali.'
            ], 401);
        }

        $users = DB::connection($this->connection)
            ->select("SELECT FIRST * FROM t_users_bphtb WHERE id = ?", [$session->user_id]);

        $user = !empty($users) ? $users[0] : null;

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pengguna tidak ditemukan.'
            ], 404);
        }

        $odbcUser = new OdbcUser($user);
        $newAccessToken = JWTAuth::fromUser($odbcUser);
        $newRefreshToken = Str::random(60);

        DB::connection($this->connection)
            ->statement("UPDATE t_user_sessions_bphtb SET refresh_token = ?, expires_at = ?, updated_at = ? WHERE id = ?", [
                $newRefreshToken,
                date('Y-m-d H:i:s', strtotime('+7 days')),
                date('Y-m-d H:i:s'),
                $session->id
            ]);

        return response()->json([
            'status' => 'success',
            'access_token' => $newAccessToken,
            'refresh_token' => $newRefreshToken,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl', 60) * 60,
        ]);
    }

    /**
     * Handle user logout.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        try {
            if ($token = JWTAuth::getToken()) {
                JWTAuth::invalidate($token);
            }
        } catch (\Exception $e) {
            // Token already invalid or not provided
        }

        $refreshToken = $request->input('refresh_token');
        if ($refreshToken) {
            DB::connection($this->connection)
                ->statement("UPDATE t_user_sessions_bphtb SET is_revoked = 1 WHERE refresh_token = ?", [$refreshToken]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Logout berhasil'
        ]);
    }

    /**
     * Get authenticated user profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if ($user) {
                return response()->json([
                    'status' => 'success',
                    'user' => $user->toArray()
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token tidak valid atau kedaluwarsa'
            ], 401);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Pengguna tidak terautentikasi'
        ], 401);
    }

    /**
     * Log login attempt to t_login_history_bphtb.
     */
    protected function logLoginAttempt($userId, $attemptEmail, $ipAddress, $status)
    {
        try {
            DB::connection($this->connection)
                ->statement("INSERT INTO t_login_history_bphtb (user_id, attempt_email, ip_address, status, attempted_at) VALUES (?, ?, ?, ?, ?)", [
                    $userId,
                    $attemptEmail ?: 'unknown',
                    $ipAddress,
                    $status,
                    date('Y-m-d H:i:s'),
                ]);
        } catch (\Exception $e) {
            // Non-blocking fallback if log table insert fails
        }
    }
}
