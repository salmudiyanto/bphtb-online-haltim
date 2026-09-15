<template>
  <div class="flex flex-col w-full">
    <div class="w-full max-w-[1440px] mx-auto px-6 lg:px-10 py-8 flex flex-col gap-8">
      <!-- Top Meta Breadcrumb & Action Banner -->
      <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 pb-4 border-b border-slate-200">
        <div class="flex flex-col gap-1.5">
          <nav class="flex items-center gap-2 text-slate-500 text-xs">
            <span class="hover:text-[#4CAF50] cursor-pointer transition-colors flex items-center gap-1">
              <span class="material-symbols-outlined text-[16px]">home</span> Beranda
            </span>
            <span class="text-slate-300">/</span>
            <span class="hover:text-[#4CAF50] cursor-pointer transition-colors">Pelayanan BPHTB</span>
            <span class="text-slate-300">/</span>
            <span class="text-[#4CAF50] font-semibold">Upload Persyaratan BPHTB</span>
          </nav>
          <div class="flex items-center gap-3 mt-1">
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Upload Persyaratan BPHTB</h1>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#edf7ee] text-[#2e7d32] border border-[#c8e6c9] text-xs font-semibold shadow-xs">
              <span class="w-1.5 h-1.5 rounded-full bg-[#4CAF50]"></span>
              Tahap Kelengkapan Berkas
            </span>
          </div>
          <p class="text-sm text-slate-600 max-w-3xl">
            Kelola dan verifikasi berkas digital persyaratan permohonan BPHTB sebelum diproses ke penetapan validasi oleh tim pemeriksa BPKAD Kab. Haltim.
          </p>
        </div>
        <!-- Progress Ring Mini -->
        <div class="flex items-center gap-4 bg-white border border-slate-200 rounded-xl p-3 shadow-sm">
          <div class="relative w-12 h-12 flex items-center justify-center">
            <svg class="w-12 h-12 transform -rotate-90" viewBox="0 0 36 36">
              <path class="text-slate-200" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3"></path>
              <path :stroke-dasharray="progressPercent + ', 100'" class="text-[#4CAF50] transition-all duration-700 ease-in-out" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-dasharray="60, 100" stroke-width="3"></path>
            </svg>
            <span class="absolute text-[11px] font-bold text-slate-700">{{ progressPercent }}%</span>
          </div>
          <div class="flex flex-col">
            <span class="text-xs text-slate-500 font-medium">Kelengkapan</span>
            <span class="text-sm font-bold text-slate-800">{{ uploadedCount }} dari {{ totalCount }} Berkas</span>
          </div>
        </div>
      </div>

      <!-- Main Body Content Grid -->
      <div class="flex flex-col gap-6 w-full">
<!-- Card 1: Detail Pendaftaran (Read-only, 3 Columns) -->
<div class="w-full bg-white rounded-xl border border-slate-200 shadow-xs overflow-hidden">
<div class="px-6 py-3.5 bg-slate-50/80 border-b border-slate-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-[#4CAF50] text-[20px]">assignment</span>
<span class="text-[14px] text-slate-900 font-bold">Identitas Pendaftaran &amp; Objek Pajak</span>
</div>
<span class="font-mono text-[11px] font-semibold text-slate-500 bg-white border border-slate-200 px-2.5 py-0.5 rounded">TERCATAT SISMIOP</span>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6">
<!-- Col 1 -->
<div class="flex flex-col gap-4">
<div class="flex flex-col">
<span class="text-[11.5px] font-semibold text-slate-400 uppercase tracking-wider">Nomor Pelayanan</span>
<span class="text-[15px] font-bold text-slate-900 mt-1 font-mono">{{ pendaftaran.nomorPelayanan }}</span>
</div>
<div class="flex flex-col">
<span class="text-[11.5px] font-semibold text-slate-400 uppercase tracking-wider">NOP PBB</span>
<div class="flex items-center gap-2 mt-1">
<span class="font-mono text-[14px] font-bold text-emerald-700">{{ pendaftaran.nopPbb }}</span>
<button @click="viewNopDetail" class="text-slate-600 hover:text-[#4CAF50] transition-colors flex items-center gap-0.5 text-[12px] font-medium" type="button">
<span>Lihat Data PBB</span>
<span class="material-symbols-outlined text-[15px]">open_in_new</span>
</button>
</div>
</div>
</div>
<!-- Col 2 -->
<div class="flex flex-col gap-4">
<div class="flex flex-col">
<span class="text-[11.5px] font-semibold text-slate-400 uppercase tracking-wider">Jenis Perolehan Hak</span>
<span class="text-[15px] font-bold text-slate-900 mt-1">{{ pendaftaran.jenisPerolehan }}</span>
</div>
<div class="flex flex-col">
<span class="text-[11.5px] font-semibold text-slate-400 uppercase tracking-wider">Nama Wajib Pajak (Pemohon)</span>
<span class="text-[14px] font-semibold text-slate-800 mt-1">{{ pendaftaran.namaWajibPajak }}</span>
</div>
</div>
<!-- Col 3 -->
<div class="flex flex-col gap-4">
<div class="flex flex-col">
<span class="text-[11.5px] font-semibold text-slate-400 uppercase tracking-wider">Tanggal Pendaftaran</span>
<span class="text-[14px] text-slate-800 mt-1 font-medium">{{ pendaftaran.tanggalPendaftaran }}</span>
</div>
<div class="flex flex-col">
<span class="text-[11.5px] font-semibold text-slate-400 uppercase tracking-wider">Mitra PPAT Pembuat Akta</span>
<div class="flex items-center gap-1.5 mt-1">
<span class="material-symbols-outlined text-emerald-600 text-[18px]">verified</span>
<span class="text-[14px] font-semibold text-slate-800">{{ pendaftaran.mitraPpat }}</span>
</div>
</div>
</div>
</div>
</div>
<!-- Summary Kelengkapan Berkas (Alert & Progress Banner) -->
<div class="w-full bg-[#f0fdf4] border border-[#bbf7d0] rounded-xl p-6 shadow-xs flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
<div class="flex items-center gap-4">
<div class="w-12 h-12 rounded-xl bg-[#4CAF50] text-white flex items-center justify-center shrink-0 shadow-xs">
<span class="material-symbols-outlined text-[26px]">fact_check</span>
</div>
<div class="flex flex-col gap-1">
<div class="flex items-center gap-2.5">
<h2 class="text-[17px] font-bold text-[#166534]">{{ uploadedCount }} dari {{ totalCount }} Persyaratan Telah Diupload</h2>
<span class="px-2.5 py-0.5 rounded-full bg-emerald-100 border border-emerald-300 text-emerald-800 text-[12px] font-bold">{{ progressPercent }}% Lengkap</span>
</div>
<p class="text-[13.5px] text-[#166534]/90">
<template v-if="pendingCount &gt; 0">
                  Berkas permohonan masih memerlukan <strong class="text-amber-800 underline decoration-amber-400">{{ pendingCount }} dokumen legal</strong> tambahan agar proses penetapan SKPD-BPHTB dapat diajukan ke Verifikator Pajak.
                </template>
<template v-else="">
<span class="text-emerald-800 font-semibold">Seluruh dokumen digital telah lengkap diupload dan siap diajukan ke Verifikator Pajak BPKAD Kab. Haltim.</span>
</template>
</p>
</div>
</div>
<!-- Linear Visual Progress Bar -->
<div class="w-full md:w-72 flex flex-col gap-1.5 shrink-0">
<div class="flex justify-between items-center text-[12px] text-[#166534] font-medium">
<span>Kesiapan Verifikasi</span>
<span class="font-mono text-[13px] text-[#166534] font-bold">{{ uploadedCount }} / {{ totalCount }} Dokumen</span>
</div>
<div class="w-full h-3 bg-emerald-100 rounded-full overflow-hidden p-0.5 border border-emerald-200">
<div :style="{ width: progressPercent + '%' }" class="h-full bg-[#4CAF50] rounded-full transition-all duration-500 shadow-xs"></div>
</div>
</div>
</div>
<!-- Main Section: Document Requirements Table & Dropzone Grid -->
<div class="grid grid-cols-1 xl:grid-cols-12 gap-6">
<!-- Left / Primary: Berkas Persyaratan List (Spans 8 cols) -->
<div class="xl:col-span-8 flex flex-col gap-4">
<div class="bg-white rounded-xl border border-slate-200 shadow-xs overflow-hidden flex flex-col">
<!-- Filter Tabs & Header -->
<div class="p-4 sm:px-6 bg-slate-50/70 border-b border-slate-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-[#4CAF50] text-[22px]">description</span>
<h2 class="text-[15px] font-bold text-slate-900">Daftar Berkas Persyaratan</h2>
</div>
<!-- Tab Filters -->
<div class="flex flex-wrap items-center gap-1 bg-slate-200/80 p-1 rounded-lg border border-slate-200 w-full sm:w-auto">
<button :class="activeFilter === 'all' ? 'bg-white text-[#4CAF50] font-bold shadow-xs' : 'text-slate-600 hover:text-slate-900 font-medium'" @click="activeFilter = 'all'" class="px-3.5 py-1 rounded-md text-[12px] transition-all" type="button">
                    Semua ({{ totalCount }})
                  </button>
<button :class="activeFilter === 'uploaded' ? 'bg-white text-[#4CAF50] font-bold shadow-xs' : 'text-slate-600 hover:text-slate-900 font-medium'" @click="activeFilter = 'uploaded'" class="px-3.5 py-1 rounded-md text-[12px] transition-all" type="button">
                    Terupload ({{ uploadedCount }})
                  </button>
<button :class="activeFilter === 'pending' ? 'bg-white text-[#4CAF50] font-bold shadow-xs' : 'text-slate-600 hover:text-slate-900 font-medium'" @click="activeFilter = 'pending'" class="px-3.5 py-1 rounded-md text-[12px] transition-all" type="button">
                    Belum Terupload ({{ pendingCount }})
                  </button>
</div>
</div>
<!-- Document List Items (Vue v-for) -->
<div class="divide-y divide-slate-100 flex flex-col" id="document-list">
<div :data-status="item.status" :key="item.id" class="doc-row p-5 sm:px-6 flex flex-col lg:flex-row lg:items-center justify-between gap-4 hover:bg-slate-50/70 transition-colors" v-for="(item, index) in filteredDokumenList">
<div class="flex items-start gap-4">
<div :class="item.status === 'uploaded' ? 'bg-emerald-50 border-emerald-200 text-emerald-700' : 'bg-amber-50 border-amber-200 text-amber-700'" class="w-10 h-10 rounded-lg border flex items-center justify-center shrink-0 mt-0.5">
<span class="material-symbols-outlined text-[22px]">{{ item.icon }}</span>
</div>
<div class="flex flex-col gap-1">
<div class="flex items-center gap-2 flex-wrap">
<span class="text-[14px] font-bold text-slate-900">{{ item.urutan }}. {{ item.nama }}</span>
<span :class="item.wajib ? 'bg-rose-50 border-rose-200 text-rose-700' : 'bg-slate-100 border-slate-200 text-slate-600'" class="border px-2 py-0.5 rounded text-[11px] font-semibold">
                          {{ item.wajib ? 'Wajib' : 'Tambahan' }}
                        </span>
<span class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-2.5 py-0.5 rounded-full text-[11px] font-semibold flex items-center gap-1" v-if="item.status === 'uploaded'">
<span class="material-symbols-outlined text-[14px]">check_circle</span> Terupload
                        </span>
<span class="bg-amber-50 border border-amber-200 text-amber-800 px-2.5 py-0.5 rounded-full text-[11px] font-semibold flex items-center gap-1" v-else="">
<span class="material-symbols-outlined text-[14px]">error</span> Belum Terupload
                        </span>
</div>
<span class="text-[12px] text-slate-500">{{ item.formatInfo }}</span>
<!-- Detail file jika terupload -->
<div class="flex flex-wrap items-center gap-2 mt-1 text-slate-500 font-mono text-[12px]" v-if="item.status === 'uploaded'">
<span class="material-symbols-outlined text-[16px] text-[#4CAF50]">attach_file</span>
<span class="text-slate-800 font-medium">{{ item.filename }}</span>
<span>•</span>
<span>{{ item.filesize }}</span>
<span>•</span>
<span class="text-slate-400">{{ item.uploadedDate }}</span>
</div>
<!-- Catatan jika belum terupload -->
<span class="text-[12px] text-amber-700 flex items-center gap-1 mt-0.5 font-medium" v-else-if="item.keterangan">
<span class="material-symbols-outlined text-[15px]">priority_high</span> {{ item.keterangan }}
                      </span>
<span class="text-[12px] text-slate-500" v-else-if="item.note">{{ item.note }}</span>
</div>
</div>
<!-- Actions -->
<div class="flex items-center gap-2 self-end lg:self-center">
<template v-if="item.status === 'uploaded'">
<button @click="openDocPreview(item)" class="px-3.5 py-1.5 rounded-lg bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-[12.5px] font-semibold flex items-center gap-1.5 shadow-xs transition-colors" type="button">
<span class="material-symbols-outlined text-[17px] text-slate-500">visibility</span> Preview
                      </button>
<button @click="selectDocumentForUpload(item)" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-colors border border-transparent hover:border-slate-200" title="Ganti File" type="button">
<span class="material-symbols-outlined text-[19px]">sync</span>
</button>
<button @click="removeDocumentFile(item)" class="p-1.5 rounded-lg text-rose-600 hover:bg-rose-50 transition-colors border border-transparent hover:border-rose-200" title="Hapus Berkas" type="button">
<span class="material-symbols-outlined text-[19px]">delete</span>
</button>
</template>
<template v-else="">
<button @click="selectDocumentForUpload(item)" class="px-4 py-2 rounded-lg bg-[#4CAF50] hover:bg-[#43A047] text-white text-[13px] font-bold flex items-center gap-1.5 shadow-xs transition-all hover:scale-[1.02]" type="button">
<span class="material-symbols-outlined text-[18px]">cloud_upload</span> Upload Berkas
                      </button>
</template>
</div>
</div>
</div>
</div>
<!-- Official Guidelines Alert Box -->
<div class="bg-white border border-slate-200 rounded-xl p-4 shadow-xs flex items-start gap-3">
<span class="material-symbols-outlined text-slate-500 text-[22px] shrink-0 mt-0.5">info</span>
<div class="flex flex-col gap-0.5">
<span class="text-[13px] font-bold text-slate-900">Ketentuan Unggah Berkas Digital e-BPHTB</span>
<p class="text-[12.5px] text-slate-600 leading-relaxed">
                  Pastikan seluruh hasil pemindaian (scan) jelas terbaca, tidak buram, dan tidak terpotong. Sesuai Peraturan Daerah tentang Pajak Daerah, manipulasi dokumen perpajakan dapat dikenakan sanksi administrasi dan hukum sesuai undang-undang yang berlaku.
                </p>
</div>
</div>
</div>
<!-- Right: Dropzone Container & Upload Manager (Spans 4 cols) -->
<div class="xl:col-span-4 flex flex-col gap-6">
<!-- Interactive Dropzone Component -->
<div class="bg-white rounded-xl p-6 border border-slate-200 shadow-xs flex flex-col gap-4" id="dropzone-box">
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-[#4CAF50] text-[20px]">upload_file</span>
<h3 class="text-[14px] font-bold text-slate-900">Unggah Berkas Baru</h3>
</div>
<span class="text-[11px] px-2 py-0.5 rounded bg-slate-100 text-slate-700 font-semibold border border-slate-200">{{ currentTargetDoc ? currentTargetDoc.targetLabel : 'AJB / PPJB' }}</span>
</div>
<!-- Drag and Drop Canvas Area -->
<div :class="{ 'border-[#4CAF50] bg-emerald-50/50': isDragging }" @dragleave.prevent="isDragging = false" @dragover.prevent="isDragging = true" @drop.prevent="handleFileDrop" class="relative group cursor-pointer bg-slate-50 hover:bg-slate-100/80 border-2 border-dashed border-slate-200 hover:border-[#4CAF50] transition-all duration-200 rounded-xl p-8 flex flex-col items-center justify-center text-center">
<input @change="handleFileInput" accept=".pdf,.jpg,.jpeg,.png" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full" id="file-input-element" type="file"/>
<div class="w-14 h-14 rounded-full bg-emerald-50 border border-emerald-200 flex items-center justify-center text-[#4CAF50] group-hover:scale-110 group-hover:bg-[#4CAF50] group-hover:text-white transition-all duration-200 mb-3 shadow-xs">
<span class="material-symbols-outlined text-[30px]">cloud_upload</span>
</div>
<p class="text-[13.5px] font-bold text-slate-800">
                  Tarik berkas ke sini atau <span class="text-[#4CAF50] underline">Pilih Berkas</span>
</p>
<p class="text-[11.5px] text-slate-500 mt-1">
                  Mendukung dokumen format PDF, JPG, PNG (Maksimal 20MB per berkas)
                </p>
<div class="flex items-center gap-2 mt-4 px-3 py-1 bg-white border border-slate-200 rounded-full text-slate-600 text-[11px] font-medium shadow-2xs">
<span class="material-symbols-outlined text-[15px] text-emerald-600">security</span>
<span>Enkripsi Host-to-Host Aktif</span>
</div>
</div>
<!-- Dynamic Upload Simulation Progress Bar -->
<div class="flex flex-col gap-2 p-3 bg-slate-50 border border-slate-200 rounded-lg" v-if="uploadProgress.active">
<div class="flex items-center justify-between text-[12px]">
<span class="font-medium text-slate-800 truncate max-w-[180px]">{{ uploadProgress.fileName }}</span>
<span class="font-mono text-[#4CAF50] font-bold">{{ uploadProgress.percentage }}%</span>
</div>
<div class="w-full h-2 bg-slate-200 rounded-full overflow-hidden">
<div :style="{ width: uploadProgress.percentage + '%' }" class="h-full bg-[#4CAF50] rounded-full transition-all duration-300"></div>
</div>
</div>
</div>
<!-- Dokumen Validasi Visual Card (BPKAD Kab. Haltim Official Seal) -->
<div class="bg-white rounded-xl p-5 border border-slate-200 shadow-xs flex flex-col gap-4">
<div class="flex items-center gap-3">
<img alt="Logo BPHTB" class="h-10 w-auto object-contain" src="https://lh3.googleusercontent.com/aida/AEtjO1UTvogIAOKCALCGyAp4MHlChPHgCFdXhmY6VBhWkgeCj19PRqa-DTVG7qY7u12CHOYFp0rubTYdGowQ4bVQRaCcCBAz1eJ8bLLgo2AxbDmP5POjyX1xxsfeNDKSH6VgAmle3bgSsWiFtYu-d3hPsGafbmDCm1ErBPGPHzTtRsR9W7oZ2MORswhDoJeu4nrNc_0TIVe2JUlahjOvq4QJb81NMifMu5tA6xdeVeLIme_AEK9nrH88VmotBaQ"/>
<div class="flex flex-col">
<span class="text-[13.5px] font-bold text-slate-900">Validasi Integritas Berkas</span>
<span class="text-[11px] text-slate-500">Sistem Verifikasi Otomatis BPKAD Kab. Haltim</span>
</div>
</div>
<div class="flex flex-col gap-2 text-[12px]">
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-1 py-2 bg-slate-50 border border-slate-100 px-3 rounded-lg">
<span class="text-slate-600">Kesesuaian NOP - SISMIOP</span>
<span class="text-emerald-700 font-bold flex items-center gap-1">
<span class="material-symbols-outlined text-[15px]">done</span> Sinkron
                  </span>
</div>
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-1 py-2 bg-slate-50 border border-slate-100 px-3 rounded-lg">
<span class="text-slate-600">Cek Tunggakan PBB (5 Thn)</span>
<span class="text-emerald-700 font-bold flex items-center gap-1">
<span class="material-symbols-outlined text-[15px]">done</span> Nihil Tunggakan
                  </span>
</div>
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-1 py-2 bg-slate-50 border border-slate-100 px-3 rounded-lg">
<span class="text-slate-600">Sertifikat Tanah ATR/BPN</span>
<span class="text-emerald-700 font-bold flex items-center gap-1">
<span class="material-symbols-outlined text-[15px]">check</span> Valid Terdata
                  </span>
</div>
</div>
</div>
</div>
</div>
<!-- Bagian 3: Action Pendaftaran Bottom Bar -->
<div class="w-full bg-white rounded-xl p-5 border border-slate-200 shadow-xs flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4 static mt-8 lg:mt-0 lg:sticky lg:bottom-4 z-30">
<!-- Left Action: Edit / Batal / Hapus -->
<div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 w-full sm:w-auto">
<button @click="handleEdit" class="flex-1 sm:flex-initial px-4 py-2.5 rounded-lg bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors text-[13px] font-semibold flex items-center justify-center gap-2 shadow-xs" type="button">
<span class="material-symbols-outlined text-[18px] text-slate-500">edit</span> Edit Pendaftaran
            </button>
<button @click="handleDelete" class="flex-1 sm:flex-initial px-4 py-2.5 rounded-lg text-rose-600 hover:bg-rose-50 transition-colors text-[13px] font-semibold flex items-center justify-center gap-2 border border-transparent hover:border-rose-200" type="button">
<span class="material-symbols-outlined text-[18px]">delete</span> Hapus Pendaftaran
            </button>
</div>
<!-- Right Action: Status Information & Proceed Button -->
<div class="flex items-center gap-4 w-full sm:w-auto justify-end">
<div class="hidden md:flex flex-col text-right">
<span class="text-[12px] text-amber-700 font-bold flex items-center justify-end gap-1" v-if="!isComplete">
<span class="material-symbols-outlined text-[16px]">pending_actions</span> Masih ada {{ pendingCount }} berkas yang belum diupload
              </span>
<span class="text-[12px] text-emerald-700 font-bold flex items-center justify-end gap-1" v-else="">
<span class="material-symbols-outlined text-[16px]">check_circle</span> Seluruh berkas wajib lengkap
              </span>
<span class="text-[11.5px] text-slate-500">Lengkapi seluruh berkas wajib untuk proses penetapan</span>
</div>
<button :class="isComplete ? 'bg-[#4CAF50] hover:bg-[#43A047] cursor-pointer shadow-md hover:scale-[1.02]' : 'bg-[#4CAF50]/60 cursor-not-allowed shadow-none'" :disabled="!isComplete" @click="handleProses" class="w-full sm:w-auto px-6 py-2.5 rounded-lg text-white text-[13px] font-bold flex items-center justify-center gap-2 transition-all" id="btn-submit-registration" type="button">
<span class="material-symbols-outlined text-[20px]">done_all</span>
              Proses Pendaftaran
              <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
</button>
</div>
</div>
</div>
<!-- PDF.js Document Preview Modal -->
<div @click.self="closeDocPreview" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4" v-if="previewModalOpen">
<div class="bg-white rounded-2xl w-full max-w-4xl max-h-[92vh] flex flex-col shadow-2xl border border-slate-200 overflow-hidden">
<!-- Modal Header & Toolbar -->
<div class="p-4 bg-slate-50 border-b border-slate-200 flex items-center justify-between gap-3">
<div class="flex items-center gap-3 min-w-0">
<div class="w-9 h-9 rounded-lg bg-emerald-50 border border-emerald-200 text-[#4CAF50] flex items-center justify-center shrink-0">
<span class="material-symbols-outlined text-[20px]">picture_as_pdf</span>
</div>
<div class="flex flex-col min-w-0">
<span class="text-[11px] text-slate-500 font-medium">Preview Dokumen Terverifikasi</span>
<span class="text-[14px] font-bold text-slate-900 truncate">Preview: {{ currentPreviewDoc ? currentPreviewDoc.namaPreview : '' }} ({{ currentPreviewDoc ? currentPreviewDoc.filename : '' }})</span>
</div>
</div>
<!-- PDF Interactive Control Toolbar -->
<div class="flex items-center gap-1.5">
<div class="hidden sm:flex items-center gap-1 bg-white border border-slate-200 px-2 py-1 rounded-lg">
<button @click="zoomOut" class="p-1 hover:bg-slate-100 rounded text-slate-600 transition-colors" title="Perkecil" type="button">
<span class="material-symbols-outlined text-[18px]">zoom_out</span>
</button>
<span class="font-mono text-[12px] px-1.5 text-slate-600 font-semibold">{{ Math.round(previewZoom * 100) }}%</span>
<button @click="zoomIn" class="p-1 hover:bg-slate-100 rounded text-slate-600 transition-colors" title="Perbesar" type="button">
<span class="material-symbols-outlined text-[18px]">zoom_in</span>
</button>
</div>
<div class="hidden sm:flex items-center gap-1 text-slate-500 text-[12px] px-2">
<span>Hal</span>
<span class="font-mono font-bold text-slate-800">1</span>
<span>dari</span>
<span class="font-mono">2</span>
</div>
<button @click="downloadDoc" class="p-2 hover:bg-slate-100 rounded-lg text-slate-600 transition-colors" title="Unduh Berkas" type="button">
<span class="material-symbols-outlined text-[20px]">download</span>
</button>
<button @click="printDoc" class="p-2 hover:bg-slate-100 rounded-lg text-slate-600 transition-colors" title="Cetak Berkas" type="button">
<span class="material-symbols-outlined text-[20px]">print</span>
</button>
<button @click="closeDocPreview" class="ml-2 p-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors" title="Tutup" type="button">
<span class="material-symbols-outlined text-[20px]">close</span>
</button>
</div>
</div>
<!-- Modal Body Canvas -->
<div class="flex-1 overflow-auto bg-slate-100 p-6 flex justify-center items-center">
<div :style="{ transform: 'scale(' + previewZoom + ')' }" class="w-full max-w-2xl bg-white rounded-lg shadow-md border border-slate-200 min-h-[520px] p-8 relative flex flex-col justify-between transition-transform duration-200">
<!-- Mock Watermark -->
<div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-5 rotate-[-25deg]">
<span class="text-[32px] font-black text-slate-900 tracking-widest uppercase">
                  BPKAD KAB. HALTIM e-BPHTB DIGITAL ARCHIVE
                </span>
</div>
<!-- Document Header Section in PDF -->
<div class="flex items-center justify-between pb-4 border-b border-slate-200">
<div class="flex items-center gap-3">
<img alt="Logo Watermark" class="h-8 w-auto" src="https://lh3.googleusercontent.com/aida/AEtjO1UTvogIAOKCALCGyAp4MHlChPHgCFdXhmY6VBhWkgeCj19PRqa-DTVG7qY7u12CHOYFp0rubTYdGowQ4bVQRaCcCBAz1eJ8bLLgo2AxbDmP5POjyX1xxsfeNDKSH6VgAmle3bgSsWiFtYu-d3hPsGafbmDCm1ErBPGPHzTtRsR9W7oZ2MORswhDoJeu4nrNc_0TIVe2JUlahjOvq4QJb81NMifMu5tA6xdeVeLIme_AEK9nrH88VmotBaQ"/>
<div class="flex flex-col">
<span class="text-[12px] font-bold tracking-wider uppercase text-slate-900">Pemerintah Daerah Terpadu</span>
<span class="font-mono text-[10px] text-slate-500">ARSIP PERSYARATAN ELEKTRONIK RESMI</span>
</div>
</div>
<span class="font-mono text-[11px] text-slate-400">KODE REG: {{ currentPreviewDoc ? currentPreviewDoc.regCode : '2026-09-482-REG' }}</span>
</div>
<!-- Document Content Presentation Area -->
<div class="flex-1 py-8 flex flex-col gap-5">
<div class="flex flex-col gap-1 items-center text-center">
<h4 class="text-[15px] font-bold text-slate-900 uppercase tracking-wide">REPUBLIK INDONESIA</h4>
<p class="text-[12px] text-slate-600 font-semibold">{{ currentPreviewDoc ? currentPreviewDoc.docHeading : 'DOKUMEN PERSYARATAN RESMI' }}</p>
</div>
<!-- Identity Card Visualization inside PDF -->
<div class="mx-auto w-full max-w-md bg-slate-50 border border-slate-200 rounded-xl p-5 shadow-xs flex gap-4 items-start">
<div class="w-24 h-32 rounded bg-slate-200 flex flex-col items-center justify-center text-slate-400 shrink-0">
<span class="material-symbols-outlined text-[44px]">account_box</span>
<span class="text-[9px] mt-1 uppercase font-semibold text-slate-500">Pasfoto</span>
</div>
<div class="flex flex-col gap-1 text-[11px] leading-tight text-slate-800">
<div class="flex"><span class="w-24 text-slate-500">NIK</span><span class="font-mono font-bold">: 3573021908850001</span></div>
<div class="flex"><span class="w-24 text-slate-500">Nama</span><span class="font-bold">: IR. MUHAMMAD RIZKY KURNIAWAN, M.ENG.</span></div>
<div class="flex"><span class="w-24 text-slate-500">Tempat/Tgl Lahir</span><span>: MALANG, 19-08-1985</span></div>
<div class="flex"><span class="w-24 text-slate-500">Jenis Kelamin</span><span>: LAKI-LAKI</span></div>
<div class="flex"><span class="w-24 text-slate-500">Alamat</span><span>: JL. IJEN BESAR NO. 44 RT 03 RW 02</span></div>
<div class="flex"><span class="w-24 text-slate-500">Pekerjaan</span><span>: KARYAWAN SWASTA</span></div>
<div class="flex"><span class="w-24 text-slate-500">Kewarganegaraan</span><span>: WNI</span></div>
</div>
</div>
<div class="text-center text-[11.5px] text-slate-500">
                  Dokumen ini diverifikasi secara elektronik melalui interkoneksi e-KTP DUKCAPIL &amp; BPKAD Kab. Haltim.
                </div>
</div>
<!-- Document Footer with Stamp -->
<div class="pt-4 border-t border-slate-200 flex items-center justify-between">
<div class="flex items-center gap-2">
<div class="w-12 h-12 rounded-full bg-emerald-50 border border-emerald-300 flex items-center justify-center text-emerald-700 text-[10px] font-bold text-center leading-none p-1">
                    VALID BPKAD
                  </div>
<div class="flex flex-col">
<span class="text-[10px] text-slate-400">Divalidasi Oleh:</span>
<span class="text-[11px] font-semibold text-slate-800">Sistem Verifikasi e-BPHTB</span>
</div>
</div>
<div class="text-right">
<span class="font-mono text-[10px] text-slate-400">SHA-256: 8f9b7c6d...e31a04</span>
</div>
</div>
</div>
</div>
<!-- Modal Footer -->
<div class="px-6 py-3 bg-slate-50 border-t border-slate-200 flex items-center justify-between">
<span class="text-[12px] text-slate-600 font-medium">Status Berkas: Terverifikasi Digital</span>
<button @click="closeDocPreview" class="px-4 py-1.5 rounded-lg bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 text-[12.5px] font-semibold transition-colors shadow-xs" type="button">
              Tutup
            </button>
</div>
</div>
</div>
</div>
</div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'UploadPersyaratan',
  data() {
    return {
      pendaftaran: {
        nomorPelayanan: 'PLY-BPHTB/2026/09/00482',
        nopPbb: '35.73.010.005.012-0045.0',
        jenisPerolehan: 'Jual Beli / Peralihan Hak Pokok',
        namaWajibPajak: 'Ir. Muhammad Rizky Kurniawan, M.Eng.',
        tanggalPendaftaran: '19 September 2026 • 09:15 WIB',
        mitraPpat: 'Kantor Notaris Farida Hanum, S.H., M.Kn.'
      },
      activeFilter: 'all',
      currentTargetDoc: null,
      isDragging: false,
      uploadProgress: {
        active: false,
        fileName: '',
        percentage: 0
      },
      previewModalOpen: false,
      currentPreviewDoc: null,
      previewZoom: 1,
      dokumenList: [
        {
          id: 'doc-1',
          urutan: 1,
          nama: 'KTP Pemohon / Kuasa',
          wajib: true,
          status: 'uploaded',
          icon: 'badge',
          formatInfo: 'Format: PDF, JPG, PNG • Maks. 5MB',
          filename: 'ktp_pemohon_rizky_kurniawan.pdf',
          filesize: '1.8 MB',
          uploadedDate: '19 Sep 2026, 09:20 WIB',
          targetLabel: 'KTP Pemohon',
          namaPreview: 'KTP Pemohon - Ir. Muhammad Rizky Kurniawan',
          regCode: '2026-09-482-KTP',
          docHeading: 'KARTU TANDA PENDUDUK ELEKTRONIK (e-KTP)'
        },
        {
          id: 'doc-2',
          urutan: 2,
          nama: 'Surat Keterangan / Sertifikat Tanah (SHM/HGB)',
          wajib: true,
          status: 'uploaded',
          icon: 'verified_user',
          formatInfo: 'Format: PDF • Maks. 15MB',
          filename: 'sertifikat_tanah_shm_04112.pdf',
          filesize: '4.2 MB',
          uploadedDate: '19 Sep 2026, 09:22 WIB',
          targetLabel: 'Sertifikat Tanah',
          namaPreview: 'Sertifikat Hak Milik (SHM) No. 04112',
          regCode: '2026-09-482-SHM',
          docHeading: 'SERTIFIKAT HAK ATAS TANAH (SHM)'
        },
        {
          id: 'doc-3',
          urutan: 3,
          nama: 'Bukti Lunas SPPT PBB Tahun Berjalan (2026)',
          wajib: true,
          status: 'uploaded',
          icon: 'receipt',
          formatInfo: 'Format: PDF, JPG • Maks. 5MB',
          filename: 'bukti_lunas_pbb_2026.pdf',
          filesize: '950 KB',
          uploadedDate: '19 Sep 2026, 09:25 WIB',
          targetLabel: 'Bukti SPPT PBB',
          namaPreview: 'Bukti Lunas SPPT PBB Tahun 2026',
          regCode: '2026-09-482-PBB',
          docHeading: 'SURAT PEMBERITAHUAN PAJAK TERHUTANG (SPPT PBB)'
        },
        {
          id: 'doc-4',
          urutan: 4,
          nama: 'Akta Jual Beli (AJB) / PPJB Notaris',
          wajib: true,
          status: 'pending',
          icon: 'draw',
          formatInfo: 'Format Dokumen: Dokumen PDF Asli Bertanda Tangan Notaris PPAT • Maks. 20MB',
          keterangan: 'Diperlukan untuk memvalidasi dasar nilai perolehan objek pajak (NPOP)',
          filename: '',
          filesize: '',
          uploadedDate: '',
          targetLabel: 'AJB / PPJB',
          namaPreview: 'Akta Jual Beli (AJB) PPAT',
          regCode: '2026-09-482-AJB',
          docHeading: 'SALINAN RESMI AKTA JUAL BELI (AJB) NOTARIS'
        },
        {
          id: 'doc-5',
          urutan: 5,
          nama: 'Surat Pernyataan NPOPTKP & Riwayat Perolehan',
          wajib: false,
          status: 'pending',
          icon: 'history_edu',
          formatInfo: 'Format Dokumen: PDF • Maks. 5MB',
          note: 'Formulir pernyataan perolehan hak pertama atau riwayat kepemilikan sebelumnya bermeterai Rp 10.000',
          filename: '',
          filesize: '',
          uploadedDate: '',
          targetLabel: 'Surat Pernyataan NPOPTKP',
          namaPreview: 'Surat Pernyataan Bebas NPOPTKP',
          regCode: '2026-09-482-NPOPTKP',
          docHeading: 'SURAT PERNYATAAN RIWAYAT KEPEMILIKAN OBJEK'
        }
      ]
    };
  },
  computed: {
    totalCount() {
      return this.dokumenList.length;
    },
    uploadedCount() {
      return this.dokumenList.filter(d => d.status === 'uploaded').length;
    },
    pendingCount() {
      return this.dokumenList.filter(d => d.status === 'pending').length;
    },
    progressPercent() {
      return Math.round((this.uploadedCount / this.totalCount) * 100);
    },
    isComplete() {
      return this.dokumenList.every(d => !d.wajib || d.status === 'uploaded');
    },
    filteredDokumenList() {
      if (this.activeFilter === 'uploaded') {
        return this.dokumenList.filter(d => d.status === 'uploaded');
      }
      if (this.activeFilter === 'pending') {
        return this.dokumenList.filter(d => d.status === 'pending');
      }
      return this.dokumenList;
    }
  },
  mounted() {
    window.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && this.previewModalOpen) {
        this.closeDocPreview();
      }
    });
    this.currentTargetDoc = this.dokumenList.find(d => d.status === 'pending') || this.dokumenList[3];
  },
  methods: {
    selectDocumentForUpload(doc) {
      this.currentTargetDoc = doc;
      const dropArea = document.getElementById('drag-drop-area') || document.getElementById('dropzone-box');
      if (dropArea) {
        dropArea.scrollIntoView({ behavior: 'smooth', block: 'center' });
        dropArea.classList.add('ring-2', 'ring-[#4CAF50]');
        setTimeout(() => {
          dropArea.classList.remove('ring-2', 'ring-[#4CAF50]');
        }, 1500);
      }
    },
    handleFileInput(event) {
      const files = event.target.files;
      if (files && files.length > 0) {
        this.simulateUpload(files[0]);
      }
    },
    handleFileDrop(event) {
      this.isDragging = false;
      const files = event.dataTransfer.files;
      if (files && files.length > 0) {
        this.simulateUpload(files[0]);
      }
    },
    simulateUpload(file) {
      const target = this.currentTargetDoc || this.dokumenList.find(d => d.status === 'pending') || this.dokumenList[3];
      this.uploadProgress.active = true;
      this.uploadProgress.fileName = file.name || (target.targetLabel.toLowerCase().replace(/\s+/g, '_') + '.pdf');
      this.uploadProgress.percentage = 0;

      const interval = setInterval(() => {
        this.uploadProgress.percentage += 20;
        if (this.uploadProgress.percentage >= 100) {
          this.uploadProgress.percentage = 100;
          clearInterval(interval);
          setTimeout(() => {
            target.status = 'uploaded';
            target.filename = this.uploadProgress.fileName;
            target.filesize = (file.size ? (file.size / (1024 * 1024)).toFixed(1) + ' MB' : '2.4 MB');
            const now = new Date();
            target.uploadedDate = now.getDate() + ' Sep 2026, ' + String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0') + ' WIB';
            this.uploadProgress.active = false;
            this.uploadProgress.percentage = 0;
            
            alert('Dokumen ' + target.nama + ' berhasil diunggah!');
          }, 400);
        }
      }, 100);
    },
    removeDocumentFile(doc) {
      if (confirm('Apakah Anda yakin ingin menghapus ' + doc.nama + '?')) {
        doc.status = 'pending';
        doc.filename = '';
        doc.filesize = '';
        doc.uploadedDate = '';
        alert('Berkas berhasil dihapus.');
      }
    },
    openDocPreview(doc) {
      this.currentPreviewDoc = doc;
      this.previewZoom = 1;
      this.previewModalOpen = true;
    },
    closeDocPreview() {
      this.previewModalOpen = false;
    },
    zoomIn() {
      if (this.previewZoom < 1.4) {
        this.previewZoom += 0.1;
      }
    },
    zoomOut() {
      if (this.previewZoom > 0.8) {
        this.previewZoom -= 0.1;
      }
    },
    downloadDoc() {
      alert('Dokumen ' + (this.currentPreviewDoc ? this.currentPreviewDoc.filename : '') + ' sedang diunduh.');
    },
    printDoc() {
      window.print();
    },
    viewNopDetail() {
      alert('Detail SISMIOP:\nNOP: ' + this.pendaftaran.nopPbb + '\nWajib Pajak: ' + this.pendaftaran.namaWajibPajak + '\nStatus: LUNAS 2026');
    },
    handleEdit() {
      alert('Membuka formulir perubahan identitas objek dan pemohon.');
    },
    handleDelete() {
      if (confirm('Data berkas dan draft permohonan ' + this.pendaftaran.nomorPelayanan + ' akan dibatalkan. Lanjutkan?')) {
        alert('Pendaftaran dibatalkan.');
      }
    },
    handleProses() {
      if (!this.isComplete) {
        alert('Persyaratan Belum Lengkap. Silakan lengkapi seluruh dokumen wajib.');
        return;
      }
      alert('Permohonan Berhasil Diproses! Berkas telah diteruskan ke tim Verifikator.');
    }
  }
}
</script>

