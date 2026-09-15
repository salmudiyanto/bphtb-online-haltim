<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PbbController extends Controller
{
    protected $connection = 'odbc';

    /**
     * Cek tunggakan PBB berdasarkan NOP (on blur).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cekTunggakan(Request $request)
    {
        $kdKec = $request->input('kd_kecamatan');
        $kdKel = $request->input('kd_kelurahan');
        $kdBlok = $request->input('kd_blok');
        $noUrut = $request->input('no_urut');
        $kdJnsOp = $request->input('kd_jns_op');
        $nopFormatted = $request->input('nop'); // Misal: 82.06.001.001.003.0548.0

        // Sanitize NOP 18 digit angka utuh
        $nopBaruRaw = preg_replace('/[^0-9]/', '', $nopFormatted ?? '');

        // Jika komponen NOP tidak dikirim langsung, coba ekstrak dari NOP 18 digit
        if (strlen($nopBaruRaw) === 18) {
            $kdKec = ($kdKec !== null && $kdKec !== '') ? $kdKec : substr($nopBaruRaw, 4, 3);
            $kdKel = ($kdKel !== null && $kdKel !== '') ? $kdKel : substr($nopBaruRaw, 7, 3);
            $kdBlok = ($kdBlok !== null && $kdBlok !== '') ? $kdBlok : substr($nopBaruRaw, 10, 3);
            $noUrut = ($noUrut !== null && $noUrut !== '') ? $noUrut : substr($nopBaruRaw, 13, 4);
            $kdJnsOp = ($kdJnsOp !== null && $kdJnsOp !== '') ? $kdJnsOp : substr($nopBaruRaw, 17, 1);
        }

        if ($kdKec === null || $kdKec === '' || 
            $kdKel === null || $kdKel === '' || 
            $kdBlok === null || $kdBlok === '' || 
            $noUrut === null || $noUrut === '' || 
            $kdJnsOp === null || $kdJnsOp === '') {
            return response()->json([
                'status' => 'error',
                'message' => 'Format NOP tidak valid (harus 18 digit angka).'
            ], 422);
        }

        try {
            // Query 1: Tabel trx_tagihan
            $jr = DB::connection($this->connection)->select("
                SELECT COUNT(*) as jml  
                FROM trx_tagihan  
                WHERE kd_kec = ? AND kd_kel = ? AND kd_blok = ? 
                AND no_urut = ? AND kd_jns_op = ? AND tgl_bayar is null
            ", [$kdKec, $kdKel, $kdBlok, $noUrut, $kdJnsOp]);

            // Query 2: Tabel trx_tagihan_lama
            $jr1 = DB::connection($this->connection)->select("
                SELECT COUNT(*) as jml  
                FROM trx_tagihan_lama  
                WHERE nop_baru = ? AND status = '0'
            ", [$nopBaruRaw]);

            $jml1 = (!empty($jr) && isset($jr[0]->jml)) ? (int) $jr[0]->jml : 0;
            $jml2 = (!empty($jr1) && isset($jr1[0]->jml)) ? (int) $jr1[0]->jml : 0;
            $totalTunggakan = $jml1 + $jml2;

            $hasTunggakan = ($totalTunggakan > 0);
            $dataOp = null;

            // Jika bebas tunggakan, ambil detail data SPPT & Objek Pajak dari PowerBuilder Query
            if (!$hasTunggakan && strlen($nopBaruRaw) === 18) {
                $kdProp = substr($nopBaruRaw, 0, 2);
                $kdKab = substr($nopBaruRaw, 2, 2);

                try {
                    $opResults = DB::connection($this->connection)->select("
                        SELECT dat_subjek_pajak.nm_wp,   
                               dat_objek_pajak.jalan_op,   
                               isnull(dat_objek_pajak.blok_kav_no_op, '') as blok_op,   
                               dat_objek_pajak.rw_op,   
                               dat_objek_pajak.rt_op,   
                               rf_kecamatan.kec_nama,   
                               rf_keldesa.keld_nama  
                        FROM dat_objek_pajak,   
                             dat_subjek_pajak,   
                             rf_kecamatan,   
                             rf_keldesa  
                       WHERE ( dat_objek_pajak.subjek_pajak_id = dat_subjek_pajak.subjek_pajak_id ) and  
                             ( dat_objek_pajak.kd_propinsi = rf_kecamatan.prop_kode ) and  
                             ( dat_objek_pajak.kd_dati2 = rf_kecamatan.kabk_kode ) and  
                             ( dat_objek_pajak.kd_kecamatan = rf_kecamatan.kec_kode ) and  
                             ( dat_objek_pajak.kd_propinsi = rf_keldesa.prop_kode ) and  
                             ( dat_objek_pajak.kd_dati2 = rf_keldesa.kabk_kode ) and  
                             ( dat_objek_pajak.kd_kecamatan = rf_keldesa.kec_kode ) and  
                             ( dat_objek_pajak.kd_kelurahan = rf_keldesa.keld_kode ) and  
                             ( ( dat_objek_pajak.kd_propinsi = ? ) AND  
                             ( dat_objek_pajak.kd_dati2 = ? ) AND  
                             ( dat_objek_pajak.kd_kecamatan = ? ) AND  
                             ( dat_objek_pajak.kd_kelurahan = ? ) AND  
                             ( dat_objek_pajak.kd_blok = ? ) AND  
                             ( dat_objek_pajak.no_urut = ? ) AND  
                             ( dat_objek_pajak.kd_jns_op = ? ) )
                    ", [$kdProp, $kdKab, $kdKec, $kdKel, $kdBlok, $noUrut, $kdJnsOp]);

                    if (!empty($opResults)) {
                        $row = $opResults[0];
                        $namaWp = trim($row->nm_wp ?? '');

                        $addressParts = [];
                        if (!empty(trim($row->jalan_op ?? ''))) {
                            $addressParts[] = trim($row->jalan_op);
                        }
                        if (!empty(trim($row->blok_op ?? ''))) {
                            $addressParts[] = 'BLOK/NO. ' . trim($row->blok_op);
                        }
                        $rtRw = [];
                        if (!empty(trim($row->rt_op ?? ''))) {
                            $rtRw[] = 'RT ' . trim($row->rt_op);
                        }
                        if (!empty(trim($row->rw_op ?? ''))) {
                            $rtRw[] = 'RW ' . trim($row->rw_op);
                        }
                        if (!empty($rtRw)) {
                            $addressParts[] = implode('/', $rtRw);
                        }
                        if (!empty(trim($row->keld_nama ?? ''))) {
                            $addressParts[] = 'KEL. ' . trim($row->keld_nama);
                        }
                        if (!empty(trim($row->kec_nama ?? ''))) {
                            $addressParts[] = 'KEC. ' . trim($row->kec_nama);
                        }

                        $dataOp = [
                            'nama_wp_sppt' => $namaWp,
                            'alamat_objek_pajak' => implode(', ', $addressParts)
                        ];
                    }
                } catch (\Exception $exOp) {
                    // Fallback silent error handling
                }
            }

            return response()->json([
                'status' => 'success',
                'has_tunggakan' => $hasTunggakan,
                'total_tunggakan' => $totalTunggakan,
                'data_op' => $dataOp,
                'message' => $hasTunggakan 
                    ? "NOP tersebut mempunyai tunggakan selama {$totalTunggakan} tahun, tidak dapat melakukan Proses BPHTB, untuk informasi selanjutnya silahkan ke Pelayanan PBB" 
                    : 'NOP bebas dari tunggakan PBB.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengecek tunggakan PBB: ' . $e->getMessage()
            ], 500);
        }
    }
}
