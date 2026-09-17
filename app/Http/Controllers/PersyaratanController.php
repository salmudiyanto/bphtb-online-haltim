<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class PersyaratanController extends Controller
{
    protected $connection = 'odbc';

    /**
     * Get detail pendaftaran and document requirements by no_pelayanan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDetailPendaftaran(Request $request)
    {
        $noPelayanan = trim($request->input('no_pelayanan', ''));

        if (empty($noPelayanan)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Nomor pelayanan tidak boleh kosong.'
            ], 422);
        }

        try {
            // 1. Fetch pendaftaran detail from pst_daftar_BPHTB
            $pendaftaran = DB::connection($this->connection)->select("
                SELECT p.no_pelayanan, p.nop, p.ply_kode, p.nama_pemohon, p.namawp, p.srttglpmhn, p.tglterima,
                       j.nama AS nama_jenis_transaksi
                FROM DBA.pst_daftar_BPHTB p
                LEFT JOIN DBA.t_jenisbphtb j ON p.ply_kode = j.kode
                WHERE p.no_pelayanan = ?
            ", [$noPelayanan]);

            if (empty($pendaftaran)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data pendaftaran dengan Nomor Pelayanan "' . $noPelayanan . '" tidak ditemukan.'
                ], 444);
            }

            $pendaftar = $pendaftaran[0];

            // 2. Fetch list of requirements from t_syarat_mohon_bphtb joined with t_syarat_bphtb & t_syarat_upload_bphtb
            $requirements = DB::connection($this->connection)->select("
                SELECT m.no_pelayanan, m.jenis_transaksi, m.kd_syarat, m.status AS status_mohon,
                       sb.persyaratan,
                       u.nama_file_asli, u.nama_file_simpan, u.file_path, u.file_size, u.file_mime, u.tgl_upload
                FROM DBA.t_syarat_mohon_bphtb m
                LEFT JOIN DBA.t_syarat_bphtb sb 
                       ON m.jenis_transaksi = sb.jenis_transaksi AND m.kd_syarat = sb.kd_syarat
                LEFT JOIN DBA.t_syarat_upload_bphtb u 
                       ON m.no_pelayanan = u.no_pelayanan 
                      AND m.jenis_transaksi = u.jenis_transaksi 
                      AND m.kd_syarat = u.kd_syarat
                WHERE m.no_pelayanan = ?
                ORDER BY convert(integer, m.kd_syarat) ASC, m.kd_syarat ASC
            ", [$noPelayanan]);

            $formattedRequirements = [];
            foreach ($requirements as $idx => $req) {
                $isUploaded = !empty($req->nama_file_simpan);
                $formattedRequirements[] = [
                    'id' => 'doc-' . ($idx + 1),
                    'kd_syarat' => trim($req->kd_syarat),
                    'jenis_transaksi' => trim($req->jenis_transaksi),
                    'urutan' => $idx + 1,
                    'nama' => trim($req->persyaratan ?? ('Persyaratan No. ' . $req->kd_syarat)),
                    'wajib' => true,
                    'status' => $isUploaded ? 'uploaded' : 'pending',
                    'icon' => $this->getIconForRequirement(trim($req->kd_syarat)),
                    'formatInfo' => 'Format: PDF, JPG, PNG • Maks. 5MB',
                    'filename' => $isUploaded ? trim($req->nama_file_asli) : '',
                    'file_simpan' => $isUploaded ? trim($req->nama_file_simpan) : '',
                    'filesize' => $isUploaded ? $this->formatBytes((int) $req->file_size) : '',
                    'uploadedDate' => $isUploaded && !empty($req->tgl_upload) ? date('d M Y, H:i \W\I\B', strtotime($req->tgl_upload)) : '',
                    'targetLabel' => trim($req->persyaratan ?? ('Persyaratan ' . $req->kd_syarat)),
                ];
            }

            return response()->json([
                'status' => 'success',
                'data' => [
                    'pendaftaran' => [
                        'no_pelayanan' => trim($pendaftar->no_pelayanan),
                        'nop' => trim($pendaftar->nop),
                        'ply_kode' => trim($pendaftar->ply_kode),
                        'jenis_perolehan' => trim($pendaftar->nama_jenis_transaksi ?? $pendaftar->ply_kode),
                        'nama_pemohon' => trim($pendaftar->nama_pemohon ?? $pendaftar->namawp ?? ''),
                        'tanggal_pendaftaran' => !empty($pendaftar->srttglpmhn) ? date('d-m-Y', strtotime($pendaftar->srttglpmhn)) : (!empty($pendaftar->tglterima) ? date('d-m-Y', strtotime($pendaftar->tglterima)) : date('d-m-Y'))
                    ],
                    'persyaratan' => $formattedRequirements
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data pendaftaran: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload or Re-upload berkas persyaratan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadBerkas(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'no_pelayanan' => 'required|string',
            'jenis_transaksi' => 'required|string',
            'kd_syarat' => 'required|string',
            'file' => 'required|file|max:5120|mimes:pdf,jpg,jpeg,png' // Max 5MB
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        $noPelayanan = trim($request->input('no_pelayanan'));
        $jenisTransaksi = trim($request->input('jenis_transaksi'));
        $kdSyarat = trim($request->input('kd_syarat'));
        $file = $request->file('file');

        try {
            DB::connection($this->connection)->beginTransaction();

            // Check if record exists in t_syarat_upload_bphtb
            $existing = DB::connection($this->connection)->select("
                SELECT no_pelayanan, jenis_transaksi, kd_syarat, nama_file_simpan, file_path
                FROM DBA.t_syarat_upload_bphtb
                WHERE no_pelayanan = ? AND jenis_transaksi = ? AND kd_syarat = ?
            ", [$noPelayanan, $jenisTransaksi, $kdSyarat]);

            $targetDir = storage_path('app/public/persyaratan/' . $noPelayanan);
            if (!File::exists($targetDir)) {
                File::makeDirectory($targetDir, 0755, true, true);
            }

            // Unlink old file if re-uploading
            if (!empty($existing) && !empty($existing[0]->nama_file_simpan)) {
                $oldFileName = trim($existing[0]->nama_file_simpan);
                $oldFilePath = $targetDir . '/' . $oldFileName;
                if (File::exists($oldFilePath)) {
                    File::delete($oldFilePath);
                }
            }

            // Prepare new file details
            $ext = strtolower($file->getClientOriginalExtension());
            $namaFileAsli = $file->getClientOriginalName();
            $timestamp = date('dmyHis');
            $namaFileSimpan = "{$kdSyarat}_{$timestamp}.{$ext}";
            $fileSize = $file->getSize();
            $fileMime = $file->getClientMimeType();
            $relativePath = 'persyaratan/' . $noPelayanan . '/' . $namaFileSimpan;

            // Save file to storage
            $file->move($targetDir, $namaFileSimpan);

            $now = date('Y-m-d H:i:s');

            if (!empty($existing)) {
                // Update
                DB::connection($this->connection)->update("
                    UPDATE DBA.t_syarat_upload_bphtb
                    SET nama_file_asli = ?,
                        nama_file_simpan = ?,
                        file_path = ?,
                        file_size = ?,
                        file_mime = ?,
                        tgl_upload = ?
                    WHERE no_pelayanan = ? AND jenis_transaksi = ? AND kd_syarat = ?
                ", [
                    $namaFileAsli, $namaFileSimpan, $relativePath, $fileSize, $fileMime, $now,
                    $noPelayanan, $jenisTransaksi, $kdSyarat
                ]);
            } else {
                // Insert
                DB::connection($this->connection)->insert("
                    INSERT INTO DBA.t_syarat_upload_bphtb (
                        no_pelayanan, jenis_transaksi, kd_syarat, nama_file_asli, nama_file_simpan,
                        file_path, file_size, file_mime, tgl_upload, us_kode, keterangan
                    ) VALUES (
                        ?, ?, ?, ?, ?,
                        ?, ?, ?, ?, ?, ?
                    )
                ", [
                    $noPelayanan, $jenisTransaksi, $kdSyarat, $namaFileAsli, $namaFileSimpan,
                    $relativePath, $fileSize, $fileMime, $now, '73', null
                ]);
            }

            // Update status in t_syarat_mohon_bphtb
            DB::connection($this->connection)->update("
                UPDATE DBA.t_syarat_mohon_bphtb
                SET status = '1'
                WHERE no_pelayanan = ? AND jenis_transaksi = ? AND kd_syarat = ?
            ", [$noPelayanan, $jenisTransaksi, $kdSyarat]);

            DB::connection($this->connection)->commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Berkas berhasil diunggah.',
                'data' => [
                    'nama_file_asli' => $namaFileAsli,
                    'nama_file_simpan' => $namaFileSimpan,
                    'file_size' => $this->formatBytes($fileSize),
                    'tgl_upload' => date('d M Y, H:i \W\I\B', strtotime($now))
                ]
            ]);

        } catch (\Exception $e) {
            DB::connection($this->connection)->rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengunggah berkas: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download or view uploaded file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\JsonResponse
     */
    public function getFile(Request $request)
    {
        $noPelayanan = trim($request->input('no_pelayanan', ''));
        $jenisTransaksi = trim($request->input('jenis_transaksi', ''));
        $kdSyarat = trim($request->input('kd_syarat', ''));
        $download = filter_var($request->input('download'), FILTER_VALIDATE_BOOLEAN);

        if (empty($noPelayanan) || empty($jenisTransaksi) || empty($kdSyarat)) {
            return response()->json(['status' => 'error', 'message' => 'Parameter tidak lengkap.'], 422);
        }

        try {
            $record = DB::connection($this->connection)->select("
                SELECT nama_file_asli, nama_file_simpan, file_mime
                FROM DBA.t_syarat_upload_bphtb
                WHERE no_pelayanan = ? AND jenis_transaksi = ? AND kd_syarat = ?
            ", [$noPelayanan, $jenisTransaksi, $kdSyarat]);

            if (empty($record) || empty($record[0]->nama_file_simpan)) {
                return response()->json(['status' => 'error', 'message' => 'File tidak ditemukan di database.'], 404);
            }

            $fileNameSimpan = trim($record[0]->nama_file_simpan);
            $fileNameAsli = trim($record[0]->nama_file_asli);
            $filePath = storage_path('app/public/persyaratan/' . $noPelayanan . '/' . $fileNameSimpan);

            if (!File::exists($filePath)) {
                return response()->json(['status' => 'error', 'message' => 'File fisik tidak ditemukan di server.'], 404);
            }

            if ($download) {
                return response()->download($filePath, $fileNameAsli);
            }

            $mimeType = !empty($record[0]->file_mime) ? trim($record[0]->file_mime) : File::mimeType($filePath);

            return response()->file($filePath, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . $fileNameAsli . '"'
            ]);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Gagal mengambil file: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Delete uploaded file and revert requirement status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteBerkas(Request $request)
    {
        $noPelayanan = trim($request->input('no_pelayanan', ''));
        $jenisTransaksi = trim($request->input('jenis_transaksi', ''));
        $kdSyarat = trim($request->input('kd_syarat', ''));

        if (empty($noPelayanan) || empty($jenisTransaksi) || empty($kdSyarat)) {
            return response()->json(['status' => 'error', 'message' => 'Parameter tidak lengkap.'], 422);
        }

        try {
            DB::connection($this->connection)->beginTransaction();

            $record = DB::connection($this->connection)->select("
                SELECT nama_file_simpan
                FROM DBA.t_syarat_upload_bphtb
                WHERE no_pelayanan = ? AND jenis_transaksi = ? AND kd_syarat = ?
            ", [$noPelayanan, $jenisTransaksi, $kdSyarat]);

            if (!empty($record) && !empty($record[0]->nama_file_simpan)) {
                $fileNameSimpan = trim($record[0]->nama_file_simpan);
                $filePath = storage_path('app/public/persyaratan/' . $noPelayanan . '/' . $fileNameSimpan);
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }
            }

            DB::connection($this->connection)->delete("
                DELETE FROM DBA.t_syarat_upload_bphtb
                WHERE no_pelayanan = ? AND jenis_transaksi = ? AND kd_syarat = ?
            ", [$noPelayanan, $jenisTransaksi, $kdSyarat]);

            DB::connection($this->connection)->update("
                UPDATE DBA.t_syarat_mohon_bphtb
                SET status = '0'
                WHERE no_pelayanan = ? AND jenis_transaksi = ? AND kd_syarat = ?
            ", [$noPelayanan, $jenisTransaksi, $kdSyarat]);

            DB::connection($this->connection)->commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Berkas berhasil dihapus.'
            ]);

        } catch (\Exception $e) {
            DB::connection($this->connection)->rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus berkas: ' . $e->getMessage()
            ], 500);
        }
    }

    private function getIconForRequirement($kdSyarat)
    {
        $icons = [
            '1' => 'badge',
            '2' => 'verified_user',
            '3' => 'receipt',
            '4' => 'draw',
            '5' => 'history_edu'
        ];
        return $icons[$kdSyarat] ?? 'description';
    }

    private function formatBytes($bytes, $precision = 1)
    {
        if ($bytes <= 0) return '0 B';
        $base = log($bytes, 1024);
        $suffixes = array('B', 'KB', 'MB', 'GB', 'TB');
        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
    }
}
