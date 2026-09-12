<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    // Public Routes
    Route::post('/login', function (Request $request) {
        return response()->json([
            'status' => 'success',
            'token' => 'demo_token_123',
            'message' => 'Login berhasil (Scaffolding Demo)'
        ]);
    });

    Route::post('/register', function (Request $request) {
        return response()->json([
            'status' => 'success',
            'message' => 'Registrasi berhasil'
        ]);
    });

    Route::get('/test-db', function () {
        try {
            $pdo = \DB::connection()->getPdo();
            
            return response()->json([
                'status' => 'success',
                'message' => 'Koneksi database berhasil!',
                'dsn' => env('DB_DSN', 'odbc:simpada'),
                'driver' => 'odbc',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal koneksi ke database: ' . $e->getMessage(),
                'dsn' => env('DB_DSN', 'odbc:simpada')
            ], 500);
        }
    });

    // Protected Routes (JWT Auth)
    Route::middleware('auth:api')->group(function () {
        Route::get('/me', function (Request $request) {
            return response()->json($request->user());
        });

        Route::post('/logout', function () {
            return response()->json(['message' => 'Logout berhasil']);
        });

        Route::get('/dashboard/stats', function () {
            return response()->json([
                'total_transaksi' => 0,
                'terverifikasi' => 0,
                'pending' => 0
            ]);
        });
    });
});
