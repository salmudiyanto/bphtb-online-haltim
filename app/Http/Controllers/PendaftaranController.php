<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PendaftaranController extends Controller
{
    protected $connection = 'odbc';

    /**
     * Auto generate nomor surat permohonan.
     * Format: {4-digit urutan}.{2-digit bulan}.{4-digit tahun} (Contoh: 0001.09.2026)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateNoSurat(Request $request)
    {
        $kodeTransaksi = $request->input('kode_transaksi');
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        if (!$kodeTransaksi) {
            return response()->json([
                'status' => 'error',
                'message' => 'Parameter kode_transaksi wajib diisi.'
            ], 422);
        }

        // Format padding
        $bulan = str_pad($bulan, 2, '0', STR_PAD_LEFT);
        $tahun = str_pad($tahun, 4, '0', STR_PAD_LEFT);

        try {
            $result = DB::connection($this->connection)->select("
                SELECT isnull(max(left(srtnopmhn,4)),'0') as max_urut
                FROM pst_daftar_bphtb  
                WHERE ply_kode = ?  
                AND right(srtnopmhn,4) = ? 
                AND substr(srtnopmhn,6,2) = ?
            ", [$kodeTransaksi, $tahun, $bulan]);

            $maxUrut = (!empty($result) && isset($result[0]->max_urut)) ? (int) $result[0]->max_urut : 0;
            $nextUrut = str_pad($maxUrut + 1, 4, '0', STR_PAD_LEFT);
            $noSurat = "{$nextUrut}.{$bulan}.{$tahun}";

            return response()->json([
                'status' => 'success',
                'no_surat' => $noSurat,
                'urut' => $nextUrut,
                'bulan' => $bulan,
                'tahun' => $tahun
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal meng-generate nomor surat: ' . $e->getMessage()
            ], 500);
        }
    }
}
