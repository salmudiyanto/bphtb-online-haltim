<template>
<div>

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
<span class="text-[#4CAF50] font-semibold">Input Pendaftaran BPHTB</span>
</nav>
<div class="flex items-center gap-3 mt-1">
<h1 class="text-2xl font-bold text-slate-900 tracking-tight">Input Pendaftaran BPHTB</h1>
<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#edf7ee] text-[#2e7d32] border border-[#c8e6c9] text-xs font-semibold shadow-xs">
<span class="w-1.5 h-1.5 rounded-full bg-[#4CAF50]"></span>
Mode Input Petugas
</span>
</div>
<p class="text-sm text-slate-600 max-w-3xl">
Perekaman berkas dan pendataan permohonan baru Bea Perolehan Hak atas Tanah dan Bangunan (BPHTB) wilayah kerja BAPENDA Daerah.
</p>
</div>
<div class="flex items-center gap-3">
<div class="flex items-center gap-2.5 bg-white border border-slate-200 px-3.5 py-2 rounded-lg shadow-sm">
<span class="material-symbols-outlined text-[#4CAF50] text-[20px]">draft</span>
<div class="flex flex-col text-left">
<span class="text-[11px] text-slate-400 font-medium">Nomor Draft Sesi</span>
<span class="font-mono text-xs font-semibold text-slate-800 tracking-wide">{{ nomorDraftSesi }}</span>
</div>
</div>
<button @click="panduanSingkat" class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-lg bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-all duration-150 text-xs font-semibold shadow-sm" type="button">
<span class="material-symbols-outlined text-[18px] text-[#4CAF50]">help_outline</span>
<span>Panduan Singkat</span>
</button>
</div>
</div>
<!-- Main Grid Layout -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
<!-- Primary Data Entry Stack (8 Cols) -->
<div class="lg:col-span-8 flex flex-col gap-8">
<!-- CARD 1: Nomor Pelayanan (Administratif) -->
<div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 lg:p-7 flex flex-col gap-6">
<div class="flex items-center justify-between pb-4 border-b border-slate-100">
<div class="flex items-center gap-3.5">
<div class="w-10 h-10 rounded-lg bg-[#edf7ee] border border-[#c8e6c9] flex items-center justify-center text-[#4CAF50]">
<span class="material-symbols-outlined text-[24px]">assignment_turned_in</span>
</div>
<div class="flex flex-col">
<h2 class="text-base font-bold text-slate-900">1. Nomor &amp; Status Pelayanan</h2>
<p class="text-xs text-slate-500">Penomoran berkas registrasi resmi loket pendaftaran BAPENDA</p>
</div>
</div>
<span class="px-2.5 py-1 rounded bg-slate-100 border border-slate-200 font-mono text-xs text-slate-600 font-medium">SYS-AUTO-ID</span>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
<!-- Nomor Pelayanan -->
<div class="flex flex-col gap-1.5 md:col-span-2 lg:col-span-1">
<label class="text-xs font-semibold text-slate-700 flex items-center justify-between">
<span>Nomor Pelayanan BPHTB <span class="text-red-500">*</span></span>
<span class="text-[11px] text-[#388e3c] font-semibold">Tersinkron Otomatis</span>
</label>
<div class="relative flex items-center">
<input class="w-full bg-slate-50 border border-slate-200 text-slate-800 font-mono text-sm px-3.5 py-2.5 rounded-lg outline-none cursor-not-allowed select-all" readonly="" type="text" v-model="form.nomorPelayanan"/>
<button @click="refreshNomorPelayanan" class="absolute right-2 px-2.5 py-1 rounded bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-medium flex items-center gap-1 transition-colors shadow-xs" id="btn-regenerate" title="Generate nomor acak baru" type="button">
<span class="material-symbols-outlined text-[16px] text-[#4CAF50]">refresh</span>
<span>Refresh</span>
</button>
</div>
<p class="text-xs text-slate-400">Format baku register: PLY-BPHTB/TAHUN/BULAN/URUT</p>
</div>
<!-- Jenis Pelayanan -->
<div class="flex flex-col gap-1.5 md:col-span-2 lg:col-span-1">
<label class="text-xs font-semibold text-slate-700" for="select-jenis-pelayanan">
Jenis Transaksi / Pelayanan <span class="text-red-500">*</span>
</label>
<div class="relative">
<select class="w-full bg-white border border-slate-300 text-slate-800 text-sm px-3.5 py-2.5 pr-10 rounded-lg outline-none focus:border-[#4CAF50] focus:ring-2 focus:ring-[#4CAF50]/20 transition-all appearance-none cursor-pointer" id="select-jenis-pelayanan" v-model="form.jenisTransaksi">
<option value="jual-beli">Jual Beli (Peralihan Hak Pokok)</option>
<option value="hibah">Hibah (Pemberian Sukarela)</option>
<option value="waris">Waris (Surat Keterangan Waris Sah)</option>
<option value="hibah-wasiat">Hibah Wasiat</option>
<option value="tukar-menukar">Tukar Menukar (Ruislag)</option>
<option value="pemasukan-perseroan">Pemasukan dalam Perseroan (Inbreng)</option>
<option value="pemisahan-hak">Pemisahan Hak Bersama</option>
</select>
<span class="material-symbols-outlined absolute right-3 top-2.5 text-slate-400 pointer-events-none text-[20px]">expand_more</span>
</div>
<p class="text-xs text-slate-400">Menentukan threshold NPOPTKP yang diberlakukan sistem</p>
</div>
<!-- No Surat Permohonan PPAT -->
<div class="flex flex-col gap-1.5 md:col-span-2 lg:col-span-1">
<label class="text-xs font-semibold text-slate-700" for="no-surat-ppat">
No. Surat Pengantar PPAT / Permohonan <span class="text-red-500">*</span>
</label>
<div class="relative flex items-center">
<span class="material-symbols-outlined absolute left-3 text-slate-400 text-[18px]">receipt</span>
<input class="w-full bg-white border border-slate-300 text-slate-800 text-sm pl-10 pr-3.5 py-2.5 rounded-lg outline-none focus:border-[#4CAF50] focus:ring-2 focus:ring-[#4CAF50]/20 transition-all" id="no-surat-ppat" placeholder="Contoh: 005/SP-PPAT/IX/2026" type="text" v-model="form.noSuratPengantar"/>
</div>
<p class="text-xs text-slate-400">Nomor agenda surat pengantar notaris/PPAT pembuat akta</p>
</div>
<!-- Tanggal Surat Permohonan -->
<div class="flex flex-col gap-1.5 md:col-span-2 lg:col-span-1">
<label class="text-xs font-semibold text-slate-700" for="tgl-surat-ppat">
Tanggal Surat Permohonan <span class="text-red-500">*</span>
</label>
<div class="relative flex items-center">
<span class="material-symbols-outlined absolute left-3 text-slate-400 text-[18px]">calendar_today</span>
<input class="w-full bg-white border border-slate-300 text-slate-800 text-sm pl-10 pr-3.5 py-2.5 rounded-lg outline-none focus:border-[#4CAF50] focus:ring-2 focus:ring-[#4CAF50]/20 transition-all" id="tgl-surat-ppat" type="date" v-model="form.tanggalSurat"/>
</div>
<p class="text-xs text-slate-400">Tanggal penandatanganan berkas pengantar</p>
</div>
<!-- Tanggal Penerimaan Loket -->
<div class="flex flex-col gap-1.5">
<label class="text-xs font-semibold text-slate-700" for="tgl-terima-loket">
Tanggal Penerimaan Berkas <span class="text-red-500">*</span>
</label>
<div class="relative flex items-center">
<span class="material-symbols-outlined absolute left-3 text-[#4CAF50] text-[18px]">event_available</span>
<input class="w-full bg-white border border-slate-300 text-slate-800 text-sm pl-10 pr-3.5 py-2.5 rounded-lg outline-none focus:border-[#4CAF50] focus:ring-2 focus:ring-[#4CAF50]/20 transition-all" id="tgl-terima-loket" type="date" v-model="form.tanggalPenerimaan"/>
</div>
<p class="text-xs text-slate-400">Sesuai jam loket registrasi kantor BAPENDA</p>
</div>
<!-- Tanggal Perkiraan Selesai -->
<div class="flex flex-col gap-1.5">
<label class="text-xs font-semibold text-slate-700" for="tgl-selesai-est">
Perkiraan Selesai (SLA Standar 3 Hari)
</label>
<div class="relative flex items-center">
<span class="material-symbols-outlined absolute left-3 text-slate-500 text-[18px]">timer</span>
<input class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm pl-10 pr-3.5 py-2.5 rounded-lg outline-none cursor-default" id="tgl-selesai-est" type="date" v-model="form.perkiraanSelesai"/>
</div>
<p class="text-xs text-slate-400">Target verifikasi dokumen &amp; penetapan validasi</p>
</div>
</div>
</div>
<!-- CARD 2: Data Wajib & Objek Pajak -->
<div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 lg:p-7 flex flex-col gap-6">
<div class="flex items-center justify-between pb-4 border-b border-slate-100">
<div class="flex items-center gap-3.5">
<div class="w-10 h-10 rounded-lg bg-[#edf7ee] border border-[#c8e6c9] flex items-center justify-center text-[#4CAF50]">
<span class="material-symbols-outlined text-[24px]">real_estate_agent</span>
</div>
<div class="flex flex-col">
<h2 class="text-base font-bold text-slate-900">2. Data Wajib / Objek Pajak &amp; Keterangan</h2>
<p class="text-xs text-slate-500">Identitas subjek pemohon serta spesifikasi legalitas objek tanah &amp; bangunan</p>
</div>
</div>
</div>
<div class="flex flex-col gap-5">
<!-- Baris 1: Nama Pemohon -->
<div class="flex flex-col gap-1.5">
<label class="text-xs font-semibold text-slate-700 flex items-center justify-between" for="nama-pemohon">
<span>Nama Lengkap Wajib Pajak / Pemohon <span class="text-red-500">*</span></span>
<span class="text-[11px] text-slate-400 font-normal">Sesuai KTP Pemohon</span>
</label>
<div class="relative flex items-center">
<span class="material-symbols-outlined absolute left-3 text-slate-400 text-[18px]">badge</span>
<input class="w-full bg-white border border-slate-300 text-slate-800 text-sm pl-10 pr-3.5 py-2.5 rounded-lg outline-none focus:border-[#4CAF50] focus:ring-2 focus:ring-[#4CAF50]/20 transition-all" id="nama-pemohon" placeholder="Contoh: Ir. Muhammad Rizky Kurniawan, M.Eng." type="text" v-model="form.namaWajibPajak"/>
</div>
</div>
<!-- Baris 2: Alamat Pemohon -->
<div class="flex flex-col gap-1.5">
<label class="text-xs font-semibold text-slate-700" for="alamat-pemohon">
Alamat Domisili Pemohon Sesuai KTP <span class="text-red-500">*</span>
</label>
<textarea class="w-full bg-white border border-slate-300 text-slate-800 text-sm px-3.5 py-2.5 rounded-lg outline-none focus:border-[#4CAF50] focus:ring-2 focus:ring-[#4CAF50]/20 transition-all resize-none" id="alamat-pemohon" placeholder="Tuliskan nama jalan, nomor rumah, RT/RW, kelurahan, dan kota domisili pemohon..." rows="2" v-model="form.alamatPemohon"></textarea>
</div>
<div class="h-[1px] bg-slate-200 my-1"></div>
<!-- Baris 3: NOP PBB & Nama Subjek Pajak (SISMIOP) -->
<div class="grid grid-cols-1 md:grid-cols-12 gap-4">
<!-- NOP Input with Sync Action -->
<div class="md:col-span-7 flex flex-col gap-1.5">
<label class="text-xs font-semibold text-slate-700 flex items-center justify-between" for="input-nop">
<span>Nomor Objek Pajak (NOP PBB-P2) <span class="text-red-500">*</span></span>
<span class="inline-flex items-center gap-1 text-[11px] font-semibold text-[#388e3c]">
<span class="w-1.5 h-1.5 rounded-full bg-[#4CAF50]"></span> Terhubung SISMIOP
</span>
</label>
<div class="flex gap-2">
<div class="relative flex-1 flex items-center">
<span class="material-symbols-outlined absolute left-3 text-slate-400 text-[18px]">domain_verification</span>
<input class="w-full bg-white border border-slate-300 text-slate-800 font-mono text-sm pl-10 pr-3.5 py-2.5 rounded-lg outline-none focus:border-[#4CAF50] focus:ring-2 focus:ring-[#4CAF50]/20 transition-all font-semibold tracking-wider" id="input-nop" placeholder="35.73.xxx.xxx.xxx-xxxx.x" type="text" v-model="form.nop"/>
</div>
<button :disabled="isSyncingNop" @click="cekDataNop" class="px-4 py-2.5 rounded-lg bg-[#4CAF50] text-white hover:bg-[#43a047] font-semibold text-xs flex items-center gap-1.5 shadow-sm transition-all shrink-0" id="btn-sync-nop" type="button">
<span class="material-symbols-outlined text-[18px]" v-if="!isSyncingNop &amp;&amp; !isNopSynced">sync_alt</span>
<span class="material-symbols-outlined text-[18px] animate-spin" v-if="isSyncingNop">refresh</span>
<span class="material-symbols-outlined text-[18px]" v-if="isNopSynced">check</span>
<span>{{ syncButtonLabel }}</span>
</button>
</div>
<p class="text-xs text-slate-400">Masking 18 digit NOP terdaftar pada SPPT PBB tahun berjalan</p>
</div>
<!-- Nama Subjek Pajak Terdaftar SPPT -->
<div class="md:col-span-5 flex flex-col gap-1.5">
<label class="text-xs font-semibold text-slate-700" for="nama-subjek-pbb">
Nama Wajib Pajak pada SPPT <span class="text-red-500">*</span>
</label>
<div class="relative flex items-center">
<span class="material-symbols-outlined absolute left-3 text-slate-400 text-[18px]">account_box</span>
<input class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm pl-10 pr-3.5 py-2.5 rounded-lg outline-none cursor-default font-medium" id="nama-subjek-pbb" readonly="" type="text" v-model="form.namaWpSppt"/>
</div>
<p class="text-xs text-[#388e3c] font-medium flex items-center gap-1">
<span class="material-symbols-outlined text-[14px]">check_circle</span> Sesuai database BAPENDA
</p>
</div>
</div>
<!-- Baris 4: Alamat Objek Pajak -->
<div class="flex flex-col gap-1.5">
<label class="text-xs font-semibold text-slate-700" for="alamat-objek-pajak">
Alamat Lokasi Objek Pajak (Letak Tanah / Bangunan) <span class="text-red-500">*</span>
</label>
<textarea class="w-full bg-white border border-slate-300 text-slate-800 text-sm px-3.5 py-2.5 rounded-lg outline-none focus:border-[#4CAF50] focus:ring-2 focus:ring-[#4CAF50]/20 transition-all resize-none" id="alamat-objek-pajak" rows="2" v-model="form.alamatObjekPajak"></textarea>
</div>
<!-- Baris 5: Nomor HP/WA & Keterangan Tambahan -->
<div class="grid grid-cols-1 md:grid-cols-12 gap-4">
<div class="md:col-span-5 flex flex-col gap-1.5">
<label class="text-xs font-semibold text-slate-700" for="no-hp-pemohon">
Nomor Kontak / WhatsApp Pemohon <span class="text-red-500">*</span>
</label>
<div class="relative flex items-center">
<span class="absolute left-3 font-mono text-sm font-semibold text-slate-400 select-none">+62</span>
<input class="w-full bg-white border border-slate-300 text-slate-800 font-mono text-sm pl-12 pr-3.5 py-2.5 rounded-lg outline-none focus:border-[#4CAF50] focus:ring-2 focus:ring-[#4CAF50]/20 transition-all" id="no-hp-pemohon" placeholder="812xxxxxxxx" type="tel" v-model="form.nomorKontak"/>
</div>
<p class="text-xs text-slate-400">Nomor aktif untuk notifikasi billing kode bayar</p>
</div>
<div class="md:col-span-7 flex flex-col gap-1.5">
<label class="text-xs font-semibold text-slate-700" for="keterangan-riwayat">
Keterangan Tambahan / Catatan Peralihan Hak
</label>
<input class="w-full bg-white border border-slate-300 text-slate-800 text-sm px-3.5 py-2.5 rounded-lg outline-none focus:border-[#4CAF50] focus:ring-2 focus:ring-[#4CAF50]/20 transition-all" id="keterangan-riwayat" placeholder="Catatan transaksi, riwayat akta terdahulu, nomor sertifikat..." type="text" v-model="form.keteranganTambahan"/>
<p class="text-xs text-slate-400">Opsional: isi riwayat singkat alas hak sertifikat</p>
</div>
</div>
</div>
</div>
<!-- CARD 3: Checklist Persyaratan Dokumen -->
<div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 lg:p-7 flex flex-col gap-6">
<div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-100 gap-4">
<div class="flex items-center gap-3.5">
<div class="w-10 h-10 rounded-lg bg-[#edf7ee] border border-[#c8e6c9] flex items-center justify-center text-[#4CAF50]">
<span class="material-symbols-outlined text-[24px]">folder_check</span>
</div>
<div class="flex flex-col">
<h2 class="text-base font-bold text-slate-900">3. Persyaratan Berkas yang Dilampirkan</h2>
<p class="text-xs text-slate-500">Checklist validasi kelengkapan fisik dan berkas digital sesuai juknis</p>
</div>
</div>
<div :class="checklistBadgeClass">
<span class="material-symbols-outlined text-[18px] text-[#4CAF50]">verified</span>
<span id="doc-counter-status">{{ dokumenStatusText }}</span>
</div>
</div>
<div class="flex flex-col gap-3.5">
<!-- Item Checklist 1 -->
<label class="group relative flex items-start gap-4 p-4 rounded-xl bg-white hover:bg-slate-50 border border-slate-200 transition-colors cursor-pointer select-none">
<div class="flex items-center h-6">
<input class="doc-checklist w-5 h-5 accent-[#4CAF50] rounded cursor-pointer" id="doc-chk-ktp" type="checkbox" v-model="form.dokumenKtp"/>
</div>
<div class="flex-1 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
<div class="flex flex-col">
<span class="text-sm text-slate-900 font-semibold group-hover:text-[#4CAF50] transition-colors">
Fotokopi KTP Penjual &amp; Pembeli (Atau Ahli Waris / Kuasa)
</span>
<span class="text-xs text-slate-500">
Identitas KTP-el sah yang masih berlaku, diverifikasi dengan data kependudukan Dukcapil.
</span>
</div>
<div class="flex items-center gap-2">
<span class="px-2.5 py-1 rounded bg-[#edf7ee] text-[#2e7d32] border border-[#c8e6c9] text-xs font-semibold">
Terverifikasi
</span>
<span class="material-symbols-outlined text-slate-400 text-[20px]">attach_file</span>
</div>
</div>
</label>
<!-- Item Checklist 2 -->
<label class="group relative flex items-start gap-4 p-4 rounded-xl bg-white hover:bg-slate-50 border border-slate-200 transition-colors cursor-pointer select-none">
<div class="flex items-center h-6">
<input class="doc-checklist w-5 h-5 accent-[#4CAF50] rounded cursor-pointer" id="doc-chk-pbb" type="checkbox" v-model="form.dokumenSppt"/>
</div>
<div class="flex-1 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
<div class="flex flex-col">
<span class="text-sm text-slate-900 font-semibold group-hover:text-[#4CAF50] transition-colors">
Fotokopi Lampiran Bukti Lunas SPPT PBB (Tahun Berjalan &amp; Histori)
</span>
<span class="text-xs text-slate-500">
PBB Tahun Pajak 2026 lunas tidak ada tunggakan masa lalu (Kolektibilitas Nihil).
</span>
</div>
<div class="flex items-center gap-2">
<span class="px-2.5 py-1 rounded bg-[#edf7ee] text-[#2e7d32] border border-[#c8e6c9] text-xs font-semibold">
Lunas 2026
</span>
<span class="material-symbols-outlined text-slate-400 text-[20px]">task_alt</span>
</div>
</div>
</label>
<!-- Item Checklist 3 -->
<label class="group relative flex items-start gap-4 p-4 rounded-xl bg-white hover:bg-slate-50 border border-slate-200 transition-colors cursor-pointer select-none">
<div class="flex items-center h-6">
<input class="doc-checklist w-5 h-5 accent-[#4CAF50] rounded cursor-pointer" id="doc-chk-alas" type="checkbox" v-model="form.dokumenSertifikat"/>
</div>
<div class="flex-1 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
<div class="flex flex-col">
<span class="text-sm text-slate-900 font-semibold group-hover:text-[#4CAF50] transition-colors">
Fotokopi Sertifikat Tanah / Surat Ukur / Dokumen Alas Hak
</span>
<span class="text-xs text-slate-500">
Sertifikat Hak Milik (SHM) No. 04112 atau Surat Keterangan Riwayat Tanah dari Kelurahan.
</span>
</div>
<div class="flex items-center gap-2">
<span class="px-2.5 py-1 rounded bg-[#edf7ee] text-[#2e7d32] border border-[#c8e6c9] text-xs font-semibold">
SHM Valid
</span>
<span class="material-symbols-outlined text-slate-400 text-[20px]">verified_user</span>
</div>
</div>
</label>
</div>
<div class="flex items-center gap-3 p-3.5 bg-slate-50 border border-slate-200 rounded-lg text-slate-600">
<span class="material-symbols-outlined text-[#4CAF50] text-[22px] shrink-0">info</span>
<p class="text-xs leading-relaxed">
Semua berkas fisik diverifikasi saat serah terima di Loket Pelayanan BPHTB. Pastikan cap basah PPAT tercantum pada berkas pengantar.
</p>
</div>
</div>
</div>
<!-- Persistent Calculation & Summary Sidebar (4 Cols) -->
<div class="lg:col-span-4 flex flex-col gap-6 sticky top-24">
<!-- Tax Calculation Breakdown -->
<div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
<div class="h-1.5 w-full bg-[#4CAF50]"></div>
<div class="p-6 flex flex-col gap-4">
<div class="flex items-center justify-between">
<div class="flex items-center gap-2.5">
<span class="material-symbols-outlined text-[#4CAF50] text-[22px]">calculate</span>
<h3 class="text-base font-bold text-slate-900">Simulasi Terutang</h3>
</div>
<span class="font-mono text-xs bg-slate-100 border border-slate-200 px-2.5 py-0.5 rounded text-slate-700 font-semibold">Tarif 5%</span>
</div>
<p class="text-xs text-slate-500">
Kalkulasi otomatis berdasarkan estimasi nilai transaksi dan NJOP sistem PBB.
</p>
<div class="flex flex-col gap-2 pt-2">
<!-- NPOP -->
<div class="flex items-center justify-between p-2.5 rounded-lg bg-slate-50 border border-slate-200">
<div class="flex flex-col">
<span class="text-xs font-semibold text-slate-800">Nilai Transaksi (NPOP)</span>
<span class="text-[11px] text-slate-400">Harga Akta Pasar</span>
</div>
<span class="font-mono text-sm font-semibold text-slate-900">Rp {{ formatRupiah(simulasi.npop) }}</span>
</div>
<!-- NJOP Total PBB -->
<div class="flex items-center justify-between p-2.5 rounded-lg bg-slate-50/70 border border-slate-200">
<div class="flex flex-col">
<span class="text-xs font-semibold text-slate-800">Total NJOP PBB</span>
<span class="text-[11px] text-slate-400">Luas Bumi &amp; Bangunan</span>
</div>
<span class="font-mono text-sm text-slate-600">Rp {{ formatRupiah(simulasi.njopTotal) }}</span>
</div>
<!-- NPOPTKP -->
<div class="flex items-center justify-between p-2.5 rounded-lg bg-slate-50 border border-slate-200">
<div class="flex flex-col">
<span class="text-xs font-semibold text-amber-700">NPOPTKP Daerah</span>
<span class="text-[11px] text-slate-400">Pengurang Standar Jual Beli</span>
</div>
<span class="font-mono text-sm font-semibold text-amber-700">- Rp {{ formatRupiah(npoptkpDaerah) }}</span>
</div>
<!-- NPOPKP -->
<div class="flex items-center justify-between p-2.5 rounded-lg bg-slate-50/70 border border-slate-200">
<div class="flex flex-col">
<span class="text-xs font-semibold text-slate-800">NPOP Kena Pajak</span>
<span class="text-[11px] text-slate-400">(NPOP - NPOPTKP)</span>
</div>
<span class="font-mono text-sm font-bold text-slate-900">Rp {{ formatRupiah(npopKenaPajak) }}</span>
</div>
<div class="h-[1px] bg-slate-200 my-1"></div>
<!-- Total BPHTB Terutang Highlight Box -->
<div class="p-4 rounded-xl bg-[#4CAF50] text-white flex flex-col gap-1 shadow-sm">
<span class="text-xs text-white/90 tracking-wide uppercase font-semibold">BPHTB Terutang (5% x NPOPKP)</span>
<span class="text-2xl font-bold font-mono tracking-tight text-white">Rp {{ formatRupiah(bphtbTerutang) }}</span>
<span class="text-xs text-white/90 mt-1 flex items-center gap-1.5">
<span class="material-symbols-outlined text-[16px]">verified</span> Nilai penetapan sementara
</span>
</div>
</div>
</div>
<!-- Petugas Validasi Quick Info -->
<div class="p-5 bg-slate-50 border-t border-slate-200 flex flex-col gap-3">
<div class="flex items-center gap-3">
<div class="w-9 h-9 rounded-full bg-slate-700 text-white flex items-center justify-center shrink-0">
<span class="material-symbols-outlined text-[20px]">admin_panel_settings</span>
</div>
<div class="flex flex-col">
<span class="text-xs font-bold text-slate-900">Petugas Penerima Berkas</span>
<span class="text-[11px] text-slate-500 font-mono">NIP: 19840512 200801 1 003</span>
</div>
</div>
<div class="flex items-center justify-between text-slate-500 text-xs pt-2 border-t border-slate-200">
<span>Status Dokumen:</span>
<span class="font-semibold text-[#2e7d32]">{{ statusDokumenLabel }}</span>
</div>
</div>
</div>
<!-- PPAT Authority Quick Card -->
<div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 flex flex-col gap-3">
<div class="flex items-center justify-between">
<span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Mitra PPAT Terdaftar</span>
<span class="material-symbols-outlined text-slate-500 text-[20px]">gavel</span>
</div>
<div class="flex flex-col gap-1">
<span class="text-sm font-bold text-slate-900">Kantor Notaris &amp; PPAT Farida Hanum, S.H., M.Kn.</span>
<span class="text-xs text-slate-500">SK BPN RI No. 12/KEP-BPN/2018</span>
<span class="font-mono text-xs text-slate-400">Kode PPAT: PPAT-MLG-084</span>
</div>
<div class="pt-2 flex items-center gap-2 border-t border-slate-100">
<span class="w-2 h-2 rounded-full bg-[#4CAF50]"></span>
<span class="text-xs text-[#2e7d32] font-semibold">Akun IPPAT Aktif &amp; Terverifikasi</span>
</div>
</div>
</div>
</div>
<!-- STICKY BOTTOM ACTION BAR (Desktop Only) -->
<div class="static mt-8 lg:mt-0 lg:sticky lg:bottom-4 z-30 w-full bg-white/95 backdrop-blur-md rounded-2xl border border-slate-200 p-4 lg:p-5 shadow-lg flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
<div class="flex items-center gap-3">
<div class="w-9 h-9 rounded-lg bg-[#edf7ee] border border-[#c8e6c9] flex items-center justify-center text-[#4CAF50] shrink-0">
<span class="material-symbols-outlined text-[20px]">security</span>
</div>
<div class="flex flex-col">
<span class="text-xs font-bold text-slate-900">Validasi Formulir Pra-Simpan</span>
<span class="text-xs text-slate-500">Pastikan NOP PBB, nama subjek, dan nominal akta sudah sesuai dengan berkas fisik.</span>
</div>
</div>
<div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full sm:w-auto justify-end">
<!-- Tombol Batal -->
<button @click="batalForm" class="px-5 py-2.5 rounded-lg bg-slate-100 border border-slate-200 text-slate-700 hover:bg-slate-200 transition-colors text-xs font-semibold flex justify-center items-center gap-2" id="btn-batal" type="button">
<span class="material-symbols-outlined text-[18px]">close</span>
<span>Batal</span>
</button>

<!-- Tombol Simpan Pendaftaran Utama -->
<button :disabled="isSaving" @click="simpanPendaftaran" class="px-6 py-2.5 rounded-lg bg-[#4CAF50] text-white hover:bg-[#43a047] transition-all text-xs font-semibold flex justify-center items-center gap-2.5 shadow-sm hover:shadow" id="btn-simpan-pendaftaran" type="button">
<span class="material-symbols-outlined text-[20px]" v-if="!isSaving &amp;&amp; !isSaved">send_and_archive</span>
<span class="material-symbols-outlined text-[20px] animate-spin" v-if="isSaving">rotate_right</span>
<span class="material-symbols-outlined text-[20px]" v-if="isSaved">done_all</span>
<span>{{ saveButtonLabel }}</span>
</button>
</div>
</div>
</div>
</div>
</template>

<script>
export default {
  name: 'InputPendaftaran',
  data() {
    return {
      form: {
        nomorPelayanan: '',
        jenisTransaksi: 'jual-beli',
        noSuratPengantar: '',
        tanggalSurat: '',
        tanggalPenerimaan: new Date().toISOString().split('T')[0],
        perkiraanSelesai: '',
        namaWajibPajak: '',
        alamatPemohon: '',
        nop: '',
        namaWpSppt: '',
        alamatObjekPajak: '',
        nomorKontak: '',
        keteranganTambahan: '',
        dokumenKtp: false,
        dokumenSppt: false,
        dokumenSertifikat: false
      },
      simulasi: {
        npop: 450000000,
        njopTotal: 315000000
      },
      isSyncingNop: false,
      isNopSynced: false,
      isSaving: false,
      isSaved: false
    };
  },
  computed: {
    npoptkpDaerah() {
      if (this.form.jenisTransaksi === 'waris' || this.form.jenisTransaksi === 'hibah-wasiat') {
        return 300000000;
      }
      return 60000000;
    },
    npopKenaPajak() {
      const p = this.simulasi.npop - this.npoptkpDaerah;
      return p > 0 ? p : 0;
    },
    bphtbTerutang() {
      return this.npopKenaPajak * 0.05;
    },
    syncButtonLabel() {
      if (this.isSyncingNop) return 'Sinkronisasi...';
      if (this.isNopSynced) return 'Tersinkronisasi';
      return 'Tarik Data PBB';
    },
    jumlahDokumenTercentang() {
      let count = 0;
      if (this.form.dokumenKtp) count++;
      if (this.form.dokumenSppt) count++;
      if (this.form.dokumenSertifikat) count++;
      return count;
    },
    dokumenStatusText() {
      return 'Dokumen Fisik ' + this.jumlahDokumenTercentang + ' dari 3 Valid';
    },
    checklistBadgeClass() {
      if (this.jumlahDokumenTercentang === 3) {
        return 'flex items-center gap-1.5 px-3 py-1.5 bg-[#edf7ee] text-[#2e7d32] border border-[#c8e6c9] rounded-lg font-semibold text-xs shadow-sm';
      }
      return 'flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 text-amber-700 border border-amber-200 rounded-lg font-semibold text-xs shadow-sm';
    },
    saveButtonLabel() {
      if (this.isSaving) return 'Memproses...';
      if (this.isSaved) return 'Berhasil Disimpan';
      return 'Simpan & Daftarkan Berkas';
    },
    statusDokumenLabel() {
      return this.jumlahDokumenTercentang === 3 ? 'Lengkap & Memenuhi Syarat' : 'Belum Lengkap';
    }
  },
  watch: {
    'form.tanggalPenerimaan'(val) {
      if (val) {
        const d = new Date(val);
        d.setDate(d.getDate() + 3);
        this.form.perkiraanSelesai = d.toISOString().split('T')[0];
      }
    }
  },
  mounted() {
    this.refreshNomorPelayanan();
    const d = new Date(this.form.tanggalPenerimaan);
    d.setDate(d.getDate() + 3);
    this.form.perkiraanSelesai = d.toISOString().split('T')[0];
  },
  methods: {
    formatRupiah(value) {
      return new Intl.NumberFormat('id-ID').format(value);
    },
    cekDataNop() {
      if (!this.form.nop) {
        alert('Masukkan NOP PBB terlebih dahulu!');
        return;
      }
      this.isSyncingNop = true;
      setTimeout(() => {
        this.isSyncingNop = false;
        this.isNopSynced = true;
        this.form.namaWpSppt = 'BAPAK JONATAN DOE';
        this.form.alamatObjekPajak = 'JL. PAHLAWAN NO. 12, KEC. KLOJEN, KOTA MALANG';
      }, 1500);
    },
    refreshNomorPelayanan() {
      const rand = Math.floor(Math.random() * 9000) + 1000;
      this.form.nomorPelayanan = 'PLY-BPHTB/2026/09/' + rand;
    },
    panduanSingkat() {
      alert('Mode Panduan Singkat: Isikan semua form dengan tanda bintang merah.');
    },
    batalForm() {
      if (confirm('Apakah Anda yakin ingin membatalkan pendaftaran ini? Data yang telah diisi akan hilang.')) {
        this.$router.push('/dashboard');
      }
    },
    simpanPendaftaran() {
      if (this.jumlahDokumenTercentang < 3) {
        alert('Mohon lengkapi semua checklist dokumen fisik sebelum mendaftarkan berkas!');
        return;
      }
      this.isSaving = true;
      setTimeout(() => {
        this.isSaving = false;
        this.isSaved = true;
        alert('Data pendaftaran berhasil disimpan! Anda akan diarahkan ke halaman unggah persyaratan digital.');
        this.$router.push('/upload-persyaratan');
      }, 1500);
    }
  }
};
</script>
