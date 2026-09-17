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

    /**
     * Simpan data pendaftaran secara transaksional
     */
    public function simpanPendaftaran(Request $request)
    {
        $form = $request->input('form', []);
        $dokumenChecked = $request->input('dokumenChecked', []);

        try {
            DB::connection($this->connection)->beginTransaction();

            $currentMonth = date('m');
            $currentYear = date('Y');

            // 1. Generate no_pelayanan
            $result = DB::connection($this->connection)->select("
                SELECT MAX(RIGHT(no_pelayanan, 4)) as vmax 
                FROM pst_daftar_bphtb 
                WHERE convert(integer, substr(no_pelayanan, 6, 2)) = ? 
                AND convert(integer, left(no_pelayanan, 4)) = ?
            ", [(int)$currentMonth, (int)$currentYear]);

            $vmax = (!empty($result) && isset($result[0]->vmax)) ? (int) $result[0]->vmax : 0;
            $xambil = $vmax + 1;
            
            $urut = str_pad($xambil, 4, '0', STR_PAD_LEFT);
            $noPelayanan = "{$currentYear}.{$currentMonth}.{$urut}";

            // Extract NOP parts
            $nop = str_replace('.', '', $form['nop'] ?? '');
            if (strlen($nop) !== 18) {
                throw new \Exception("Format NOP tidak valid (harus 18 digit angka).");
            }

            $kdProp = substr($nop, 0, 2);
            $kdKab = substr($nop, 2, 2);
            $kdKec = substr($nop, 4, 3);
            $kdKel = substr($nop, 7, 3);
            $kdBlok = substr($nop, 10, 3);
            $noUrut = substr($nop, 13, 4);
            $kdJenOp = substr($nop, 17, 1);

            // 2. Insert pst_daftar_BPHTB
            DB::connection($this->connection)->insert("
                INSERT INTO pst_daftar_BPHTB (
                    no_pelayanan, kol_stat, srtnopmhn, ply_kode, nop, tahun, namawp, alamatop,
                    jnspengurangan, pct, ppmhn, skuasa, fcktp, fcstanah, sppt, fcimb, fcajb, fcskpen, fcsppt, stts, fckurang, fcberat, fcskkpp, fcspmkp, lain2,
                    tglterima, tglselesai, srttglpmhn, keterangan, stat, letak_op,
                    kd_prop, kd_kab, kd_kec, kd_kel, kd_blok, no_urut, kd_jen_op,
                    nama_pemohon, us_kode, ponsel, kd_verifikasi, tgl_verifikasi, nip_verifikasi, kd_layanan
                ) VALUES (
                    ?, ?, ?, ?, ?, ?, ?, ?,
                    ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
                    ?, ?, ?, ?, ?, ?,
                    ?, ?, ?, ?, ?, ?, ?,
                    ?, ?, ?, ?, ?, ?, ?
                )
            ", [
                $noPelayanan, '0', $form['noSuratPengantar'], $form['jenisTransaksi'], $nop, date('Y'), $form['namaWpSppt'], $form['alamatPemohon'],
                null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null,
                $form['tanggalPenerimaan'], $form['perkiraanSelesai'], $form['tanggalSurat'], $form['keteranganTambahan'], 'B', $form['alamatObjekPajak'],
                $kdProp, $kdKab, $kdKec, $kdKel, $kdBlok, $noUrut, $kdJenOp,
                $form['namaWajibPajak'], '73', $form['nomorKontak'], '0', null, null, null
            ]);

            // 3. Insert t_syarat_mohon_bphtb
            if (!empty($dokumenChecked)) {
                foreach ($dokumenChecked as $kdSyarat => $isChecked) {
                    $status = $isChecked ? '1' : '0';
                    DB::connection($this->connection)->insert("
                        INSERT INTO t_syarat_mohon_bphtb (
                            no_pelayanan, jenis_transaksi, kd_syarat, status, us_kode
                        ) VALUES (
                            ?, ?, ?, ?, ?
                        )
                    ", [
                        $noPelayanan, $form['jenisTransaksi'], $kdSyarat, $status, '73'
                    ]);
                }
            }

            // 4. Delete & Insert rf_urut_nop_bphtb
            $nurut = (int) $noUrut;

            DB::connection($this->connection)->delete("
                DELETE FROM rf_urut_nop_bphtb WHERE kd_kec = ? AND kd_kel = ? AND kd_blok = ?
            ", [$kdKec, $kdKel, $kdBlok]);

            DB::connection($this->connection)->insert("
                INSERT INTO rf_urut_nop_bphtb (
                    kd_kec, kd_kel, kd_blok, nurut, no_pelayanan
                ) VALUES (
                    ?, ?, ?, ?, ?
                )
            ", [$kdKec, $kdKel, $kdBlok, $nurut, $noPelayanan]);

            DB::connection($this->connection)->commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Data pendaftaran berhasil disimpan.',
                'no_pelayanan' => $noPelayanan
            ]);

        } catch (\Exception $e) {
            DB::connection($this->connection)->rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan pendaftaran: ' . $e->getMessage()
            ], 500);
        }
    }
}
