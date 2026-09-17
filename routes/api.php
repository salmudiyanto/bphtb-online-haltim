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
    Route::post('/login', 'Auth\AuthController@login');
    Route::post('/refresh', 'Auth\AuthController@refresh');
    Route::post('/logout', 'Auth\AuthController@logout');

    Route::post('/register', function (Request $request) {
        return response()->json([
            'status' => 'success',
            'message' => 'Registrasi berhasil'
        ]);
    });

    Route::get('/test-db', function () {
        try {
            $pdo = \DB::connection('odbc')->getPdo();
            
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

    // Referensi & Transaksi Routes
    Route::get('/referensi/jenis-transaksi', 'ReferensiController@getJenisTransaksi');
    Route::get('/referensi/persyaratan/{kode_transaksi}', 'ReferensiController@getPersyaratan');
    Route::get('/referensi/tarif-bphtb', 'ReferensiController@getTarifBphtb');
    Route::get('/pendaftaran/generate-no-surat', 'PendaftaranController@generateNoSurat');
    Route::post('/pbb/cek-tunggakan', 'PbbController@cekTunggakan');

    // Protected Routes (JWT Auth)
    Route::middleware('auth:api')->group(function () {
        Route::get('/me', 'Auth\AuthController@me');

        Route::get('/dashboard/stats', function () {
            return response()->json([
                'total_transaksi' => 0,
                'terverifikasi' => 0,
                'pending' => 0
            ]);
        });
    });
});

