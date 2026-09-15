<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReferensiController extends Controller
{
    protected $connection = 'odbc';

    /**
     * Get list of jenis transaksi BPHTB from DBA.t_jenisbphtb.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getJenisTransaksi()
    {
        try {
            $data = DB::connection($this->connection)->select("
                SELECT kode, nama, persen 
                FROM DBA.t_jenisbphtb 
                ORDER BY kode ASC
            ");

            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data jenis transaksi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get list of persyaratan berkas by jenis transaksi from DBA.t_syarat_bphtb.
     *
     * @param  string  $kodeTransaksi
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPersyaratan($kodeTransaksi)
    {
        try {
            $data = DB::connection($this->connection)->select("
                SELECT jenis_transaksi, kd_syarat, persyaratan 
                FROM DBA.t_syarat_bphtb 
                WHERE jenis_transaksi = ? 
                ORDER BY kd_syarat ASC
            ", [$kodeTransaksi]);

            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data persyaratan: ' . $e->getMessage()
            ], 500);
        }
    }
}
