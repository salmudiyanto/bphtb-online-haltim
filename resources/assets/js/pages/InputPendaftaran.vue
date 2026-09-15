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
Perekaman berkas dan pendataan permohonan baru Bea Perolehan Hak atas Tanah dan Bangunan (BPHTB) wilayah kerja BPKAD Kab. Haltim.
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
<p class="text-xs text-slate-500">Penomoran berkas registrasi resmi loket pendaftaran BPKAD Kab. Haltim</p>
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
<!-- Jenis Pelayanan / Transaksi -->
<div class="flex flex-col gap-1.5 md:col-span-2 lg:col-span-1">
<label class="text-xs font-semibold text-slate-700" for="select-jenis-pelayanan">
Jenis Transaksi / Pelayanan <span class="text-red-500">*</span>
</label>
<div class="relative">
<select @change="onJenisTransaksiChange" class="w-full bg-white border border-slate-300 text-slate-800 text-sm px-3.5 py-2.5 pr-10 rounded-lg outline-none focus:border-[#4CAF50] focus:ring-2 focus:ring-[#4CAF50]/20 transition-all appearance-none cursor-pointer" id="select-jenis-pelayanan" v-model="form.jenisTransaksi">
<option disabled value="" v-if="jenisTransaksiList.length === 0">Memuat jenis transaksi...</option>
<option :key="item.kode" :value="item.kode" v-for="item in jenisTransaksiList">
{{ item.nama }}
</option>
</select>
<span class="material-symbols-outlined absolute right-3 top-2.5 text-slate-400 pointer-events-none text-[20px]">expand_more</span>
</div>
<p class="text-xs text-slate-400">Menentukan threshold NPOPTKP &amp; berkas yang diberlakukan sistem</p>
</div>
<!-- No Surat Permohonan (Auto-Generated & Readonly) -->
<div class="flex flex-col gap-1.5 md:col-span-2 lg:col-span-1">
<label class="text-xs font-semibold text-slate-700" for="no-surat-ppat">
No. Surat Permohonan <span class="text-red-500">*</span>
</label>
<div class="relative flex items-center">
<span class="material-symbols-outlined absolute left-3 text-slate-400 text-[18px]">receipt</span>
<input class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm pl-10 pr-3.5 py-2.5 rounded-lg outline-none cursor-not-allowed font-mono font-semibold" id="no-surat-ppat" placeholder="Otomatis terisi (Contoh: 0001.09.2026)" readonly="" type="text" v-model="form.noSuratPengantar"/>
<span class="material-symbols-outlined absolute right-3 text-slate-400 text-[18px] animate-spin" v-if="isGeneratingNoSurat">rotate_right</span>
</div>
<p class="text-xs text-slate-400">Format otomatis: 4 digit urutan.2 digit bulan.4 digit tahun</p>
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
<p class="text-xs text-slate-400">Tanggal penandatanganan berkas permohonan</p>
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
<p class="text-xs text-slate-400">Sesuai jam loket registrasi kantor BPKAD Kab. Haltim</p>
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
<!-- Baris 3: NOP PBB & Auto-Check Tunggakan (On Blur) -->
<div class="grid grid-cols-1 md:grid-cols-12 gap-4">
<!-- NOP Input with Masking & @blur Cek Tunggakan -->
<div class="md:col-span-7 flex flex-col gap-1.5">
<label class="text-xs font-semibold text-slate-700 flex items-center justify-between" for="input-nop">
<span>Nomor Objek Pajak (NOP PBB-P2) <span class="text-red-500">*</span></span>
<span class="inline-flex items-center gap-1 text-[11px] font-semibold text-[#388e3c]">
<span class="w-1.5 h-1.5 rounded-full bg-[#4CAF50]"></span> Cek Tunggakan Otomatis (On Blur)
</span>
</label>
<div class="relative flex items-center">
<span class="material-symbols-outlined absolute left-3 text-slate-400 text-[18px]">domain_verification</span>
<input @blur="cekTunggakanPbb" @input="onNopInput" class="w-full bg-white border border-slate-300 text-slate-800 font-mono text-sm pl-10 pr-10 py-2.5 rounded-lg outline-none focus:border-[#4CAF50] focus:ring-2 focus:ring-[#4CAF50]/20 transition-all font-semibold tracking-wider" id="input-nop" maxlength="24" placeholder="82.06.001.001.003.0548.0" type="text" v-model="form.nop"/>
<span class="material-symbols-outlined absolute right-3 text-slate-400 text-[18px] animate-spin" v-if="isCheckingTunggakan">refresh</span>
<span class="material-symbols-outlined absolute right-3 text-[#2e7d32] text-[18px]" v-if="!isCheckingTunggakan &amp;&amp; nopVerified &amp;&amp; !hasTunggakan">check_circle</span>
<span class="material-symbols-outlined absolute right-3 text-rose-500 text-[18px]" v-if="!isCheckingTunggakan &amp;&amp; hasTunggakan">warning</span>
</div>
<p class="text-xs text-rose-600 font-medium flex items-center gap-1" v-if="hasTunggakan">
<span class="material-symbols-outlined text-[14px]">error</span> {{ tunggakanMsg }}
</p>
<p class="text-xs text-[#2e7d32] font-medium flex items-center gap-1" v-else-if="nopVerified &amp;&amp; !hasTunggakan">
<span class="material-symbols-outlined text-[14px]">check_circle</span> NOP Bebas Tunggakan PBB
</p>
<p class="text-xs text-slate-400" v-else="">Format 18 digit: 82.06.###.###.###.####.# (otomatis masking saat mengetik)</p>
</div>
<!-- Nama Subjek Pajak Terdaftar SPPT -->
<div class="md:col-span-5 flex flex-col gap-1.5">
<label class="text-xs font-semibold text-slate-700" for="nama-subjek-pbb">
Nama Wajib Pajak pada SPPT <span class="text-red-500">*</span>
</label>
<div class="relative flex items-center">
<span class="material-symbols-outlined absolute left-3 text-slate-400 text-[18px]">account_box</span>
<input class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm pl-10 pr-3.5 py-2.5 rounded-lg outline-none font-medium" id="nama-subjek-pbb" placeholder="Diisi sesuai SPPT" type="text" v-model="form.namaWpSppt"/>
</div>
<p class="text-xs text-[#388e3c] font-medium flex items-center gap-1">
<span class="material-symbols-outlined text-[14px]">check_circle</span> Sesuai database BPKAD Kab. Haltim
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
<!-- CARD 3: Checklist Persyaratan Dokumen (Dinamis dari Database) -->
<div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 lg:p-7 flex flex-col gap-6">
<div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-100 gap-4">
<div class="flex items-center gap-3.5">
<div class="w-10 h-10 rounded-lg bg-[#edf7ee] border border-[#c8e6c9] flex items-center justify-center text-[#4CAF50]">
<span class="material-symbols-outlined text-[24px]">folder_check</span>
</div>
<div class="flex flex-col">
<h2 class="text-base font-bold text-slate-900">3. Persyaratan Berkas yang Dilampirkan</h2>
<p class="text-xs text-slate-500">Checklist validasi kelengkapan berkas dinamis sesuai jenis transaksi terpilih</p>
</div>
</div>
<div :class="checklistBadgeClass">
<span class="material-symbols-outlined text-[18px] text-[#4CAF50]">verified</span>
<span id="doc-counter-status">{{ dokumenStatusText }}</span>
</div>
</div>

<!-- Render List Persyaratan Berkas Dinamis -->
<div class="flex flex-col gap-3.5" v-if="listPersyaratan.length > 0">
<label :key="item.kd_syarat" class="group relative flex items-start gap-4 p-4 rounded-xl bg-white hover:bg-slate-50 border border-slate-200 transition-colors cursor-pointer select-none" v-for="item in listPersyaratan">
<div class="flex items-center h-6">
<input :id="'doc-chk-' + item.kd_syarat" class="doc-checklist w-5 h-5 accent-[#4CAF50] rounded cursor-pointer" type="checkbox" v-model="dokumenChecked[item.kd_syarat]"/>
</div>
<div class="flex-1 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
<div class="flex flex-col">
<span class="text-sm text-slate-900 font-semibold group-hover:text-[#4CAF50] transition-colors">
{{ item.persyaratan }}
</span>
<span class="text-xs text-slate-500">
Kode Syarat: {{ item.kd_syarat }} - Lampiran Wajib Jenis Transaksi {{ form.jenisTransaksi }}
</span>
</div>
<div class="flex items-center gap-2">
<span class="px-2.5 py-1 rounded bg-[#edf7ee] text-[#2e7d32] border border-[#c8e6c9] text-xs font-semibold" v-if="dokumenChecked[item.kd_syarat]">
Terverifikasi
</span>
<span class="px-2.5 py-1 rounded bg-slate-100 text-slate-500 border border-slate-200 text-xs font-medium" v-else="">
Belum Dicentang
</span>
</div>
</div>
</label>
</div>

<!-- Fallback jika belum memilih jenis transaksi / data kosong -->
<div class="p-6 bg-slate-50 border border-slate-200 rounded-xl text-center text-slate-500 text-xs" v-else="">
Pilih Jenis Transaksi / Pelayanan di atas untuk menampilkan daftar persyaratan berkas secara otomatis.
</div>

<div class="flex items-center gap-3 p-3.5 bg-slate-50 border border-slate-200 rounded-lg text-slate-600">
<span class="material-symbols-outlined text-[#4CAF50] text-[22px] shrink-0">info</span>
<p class="text-xs leading-relaxed">
Semua berkas fisik diverifikasi saat serah terima di Loket Pelayanan BPHTB BPKAD Kab. Haltim. Pastikan cap basah Notaris/PPAT tercantum pada berkas permohonan.
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
<span class="text-[11px] text-slate-400">Pengurang Standar Transaksi</span>
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
<span class="text-[11px] text-slate-500 font-mono">BPKAD Kab. Haltim</span>
</div>
</div>
<div class="flex items-center justify-between text-slate-500 text-xs pt-2 border-t border-slate-200">
<span>Status Dokumen:</span>
<span class="font-semibold text-[#2e7d32]">{{ statusDokumenLabel }}</span>
</div>
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
<span class="text-xs text-slate-500">Pastikan NOP PBB bebas tunggakan dan seluruh persyaratan berkas telah dicentang.</span>
</div>
</div>
<div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full sm:w-auto justify-end">
<!-- Tombol Batal -->
<button @click="batalForm" class="px-5 py-2.5 rounded-lg bg-slate-100 border border-slate-200 text-slate-700 hover:bg-slate-200 transition-colors text-xs font-semibold flex justify-center items-center gap-2" id="btn-batal" type="button">
<span class="material-symbols-outlined text-[18px]">close</span>
<span>Batal</span>
</button>

<!-- Tombol Simpan Pendaftaran Utama -->
<button :disabled="isSubmitDisabled" @click="simpanPendaftaran" class="px-6 py-2.5 rounded-lg bg-[#4CAF50] text-white hover:bg-[#43a047] disabled:bg-slate-300 disabled:cursor-not-allowed transition-all text-xs font-semibold flex justify-center items-center gap-2.5 shadow-sm hover:shadow" id="btn-simpan-pendaftaran" type="button">
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
import Swal from 'sweetalert2';

export default {
  name: 'InputPendaftaran',
  data() {
    return {
      nomorDraftSesi: 'DRF-' + Math.random().toString(36).substring(2, 8).toUpperCase(),
      jenisTransaksiList: [],
      listPersyaratan: [],
      dokumenChecked: {},
      form: {
        nomorPelayanan: '',
        jenisTransaksi: '',
        noSuratPengantar: '',
        tanggalSurat: new Date().toISOString().split('T')[0],
        tanggalPenerimaan: new Date().toISOString().split('T')[0],
        perkiraanSelesai: '',
        namaWajibPajak: '',
        alamatPemohon: '',
        nop: '',
        namaWpSppt: '',
        alamatObjekPajak: '',
        nomorKontak: '',
        keteranganTambahan: ''
      },
      simulasi: {
        npop: 450000000,
        njopTotal: 315000000
      },
      isGeneratingNoSurat: false,
      isCheckingTunggakan: false,
      nopVerified: false,
      hasTunggakan: false,
      tunggakanMsg: '',
      isSaving: false,
      isSaved: false
    };
  },
  computed: {
    npoptkpDaerah() {
      if (this.form.jenisTransaksi === '04' || this.form.jenisTransaksi === '05') {
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
    jumlahDokumenTercentang() {
      let count = 0;
      Object.keys(this.dokumenChecked).forEach(key => {
        if (this.dokumenChecked[key]) count++;
      });
      return count;
    },
    totalDokumenSyarat() {
      return this.listPersyaratan.length;
    },
    dokumenStatusText() {
      if (this.totalDokumenSyarat === 0) return 'Memuat Persyaratan...';
      return `Dokumen Fisik ${this.jumlahDokumenTercentang} dari ${this.totalDokumenSyarat} Valid`;
    },
    checklistBadgeClass() {
      if (this.totalDokumenSyarat > 0 && this.jumlahDokumenTercentang === this.totalDokumenSyarat) {
        return 'flex items-center gap-1.5 px-3 py-1.5 bg-[#edf7ee] text-[#2e7d32] border border-[#c8e6c9] rounded-lg font-semibold text-xs shadow-sm';
      }
      return 'flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 text-amber-700 border border-amber-200 rounded-lg font-semibold text-xs shadow-sm';
    },
    isSubmitDisabled() {
      if (this.isSaving || this.hasTunggakan) return true;
      if (this.totalDokumenSyarat > 0 && this.jumlahDokumenTercentang < this.totalDokumenSyarat) {
        return true;
      }
      return false;
    },
    saveButtonLabel() {
      if (this.isSaving) return 'Memproses...';
      if (this.isSaved) return 'Berhasil Disimpan';
      if (this.hasTunggakan) return 'Kunci Simpan (Tunggakan PBB)';
      return 'Simpan & Daftarkan Berkas';
    },
    statusDokumenLabel() {
      if (this.totalDokumenSyarat === 0) return 'Belum Dipilih';
      return this.jumlahDokumenTercentang === this.totalDokumenSyarat ? 'Lengkap & Memenuhi Syarat' : 'Belum Lengkap';
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

    // Load Jenis Transaksi dari API
    this.fetchJenisTransaksi();
  },
  methods: {
    formatRupiah(value) {
      return new Intl.NumberFormat('id-ID').format(value);
    },
    /**
     * Centralized Error Handler for API responses using SweetAlert2.
     */
    showApiError(err, defaultTitle = 'Gagal Memuat Data API') {
      let statusCode = '';
      let errorMessage = 'Terjadi kesalahan saat berkomunikasi dengan server.';

      if (err && err.response) {
        if (err.response.status) {
          statusCode = ` (HTTP ${err.response.status})`;
        }
        if (err.response.data && err.response.data.message) {
          errorMessage = err.response.data.message;
        }
      } else if (err && err.message) {
        errorMessage = err.message;
      } else if (typeof err === 'string') {
        errorMessage = err;
      }

      Swal.fire({
        icon: 'error',
        title: `${defaultTitle}${statusCode}`,
        text: errorMessage,
        confirmButtonColor: '#4CAF50',
        confirmButtonText: 'Tutup'
      });
    },

    fetchJenisTransaksi() {
      axios.get('/api/v1/referensi/jenis-transaksi')
        .then(res => {
          if (res.data && res.data.status === 'success') {
            this.jenisTransaksiList = res.data.data || [];
            if (this.jenisTransaksiList.length > 0) {
              this.form.jenisTransaksi = this.jenisTransaksiList[0].kode;
              this.onJenisTransaksiChange();
            }
          } else {
            this.showApiError(res.data ? res.data.message : 'Gagal mengambil jenis transaksi', 'Gagal Memuat Jenis Transaksi');
          }
        })
        .catch(err => {
          this.showApiError(err, 'Gagal Memuat Jenis Transaksi');
        });
    },

    onJenisTransaksiChange() {
      if (!this.form.jenisTransaksi) return;

      // 1. Generate No. Surat Permohonan
      this.isGeneratingNoSurat = true;
      const m = new Date().toISOString().substring(5, 7);
      const y = new Date().getFullYear().toString();

      axios.get('/api/v1/pendaftaran/generate-no-surat', {
        params: {
          kode_transaksi: this.form.jenisTransaksi,
          bulan: m,
          tahun: y
        }
      })
      .then(res => {
        this.isGeneratingNoSurat = false;
        if (res.data && res.data.status === 'success') {
          this.form.noSuratPengantar = res.data.no_surat;
        } else {
          this.showApiError(res.data ? res.data.message : 'Gagal generate nomor surat permohonan', 'Gagal Auto-Generate No. Surat');
        }
      })
      .catch(err => {
        this.isGeneratingNoSurat = false;
        this.showApiError(err, 'Gagal Auto-Generate No. Surat');
      });

      // 2. Fetch List Persyaratan Berkas Dinamis
      axios.get(`/api/v1/referensi/persyaratan/${this.form.jenisTransaksi}`)
        .then(res => {
          if (res.data && res.data.status === 'success') {
            this.listPersyaratan = res.data.data || [];
            // Reset checked state
            this.dokumenChecked = {};
            this.listPersyaratan.forEach(item => {
              this.$set(this.dokumenChecked, item.kd_syarat, false);
            });
          } else {
            this.showApiError(res.data ? res.data.message : 'Gagal mengambil daftar persyaratan berkas', 'Gagal Memuat Persyaratan');
          }
        })
        .catch(err => {
          this.showApiError(err, 'Gagal Memuat Persyaratan');
        });
    },

    onNopInput(e) {
      let val = e.target.value.replace(/[^0-9]/g, '');
      if (val.length > 18) val = val.substring(0, 18);

      // Masking: ##.##.###.###.###.####.# (24 chars)
      let masked = '';
      if (val.length > 0) masked += val.substring(0, 2);
      if (val.length >= 3) masked += '.' + val.substring(2, 4);
      if (val.length >= 5) masked += '.' + val.substring(4, 7);
      if (val.length >= 8) masked += '.' + val.substring(7, 10);
      if (val.length >= 11) masked += '.' + val.substring(10, 13);
      if (val.length >= 14) masked += '.' + val.substring(13, 17);
      if (val.length >= 18) masked += '.' + val.substring(17, 18);

      this.form.nop = masked;
      this.nopVerified = false;
      this.hasTunggakan = false;
      this.tunggakanMsg = '';
    },

    cekTunggakanPbb() {
      const cleanDigits = (this.form.nop || '').replace(/[^0-9]/g, '');
      if (cleanDigits.length < 18) {
        this.nopVerified = false;
        return;
      }

      this.isCheckingTunggakan = true;
      this.hasTunggakan = false;
      this.tunggakanMsg = '';

      axios.post('/api/v1/pbb/cek-tunggakan', {
        nop: this.form.nop
      })
      .then(res => {
        this.isCheckingTunggakan = false;
        if (res.data && res.data.status === 'success') {
          this.nopVerified = true;
          this.hasTunggakan = res.data.has_tunggakan;
          this.tunggakanMsg = res.data.message;

          if (this.hasTunggakan) {
            Swal.fire({
              icon: 'warning',
              title: 'Peringatan Tunggakan PBB-P2',
              text: this.tunggakanMsg,
              confirmButtonColor: '#d33',
              confirmButtonText: 'Tutup'
            });
          } else {
            // Otomatis isi Nama WP SPPT & Alamat Objek Pajak dari data_op jika ditemukan
            if (res.data.data_op) {
              if (res.data.data_op.nama_wp_sppt) {
                this.form.namaWpSppt = res.data.data_op.nama_wp_sppt;
              }
              if (res.data.data_op.alamat_objek_pajak) {
                this.form.alamatObjekPajak = res.data.data_op.alamat_objek_pajak;
              }
            }

            Swal.fire({
              icon: 'success',
              title: 'NOP Bebas Tunggakan',
              text: 'Data Wajib Pajak pada SPPT & Alamat Lokasi Objek Pajak berhasil dimuat otomatis.',
              timer: 2200,
              showConfirmButton: false
            });
          }
        } else {
          this.showApiError(res.data ? res.data.message : 'Gagal mengecek tunggakan PBB', 'Error Pengecekan PBB');
        }
      })
      .catch(err => {
        this.isCheckingTunggakan = false;
        this.showApiError(err, 'Error Pengecekan PBB');
      });
    },

    refreshNomorPelayanan() {
      const rand = Math.floor(Math.random() * 9000) + 1000;
      this.form.nomorPelayanan = 'PLY-BPHTB/2026/09/' + rand;
    },

    panduanSingkat() {
      Swal.fire({
        icon: 'info',
        title: 'Panduan Singkat Pendaftaran BPHTB',
        html: '<div class="text-left text-sm"><p>1. Isikan semua field form bertanda bintang merah (*).</p><p>2. Pilih Jenis Transaksi untuk memuat nomor permohonan & persyaratan.</p><p>3. Input NOP 18-digit untuk cek tunggakan otomatis (On Blur).</p><p>4. Centang seluruh berkas fisik sebelum menekan tombol simpan.</p></div>',
        confirmButtonColor: '#4CAF50',
        confirmButtonText: 'Saya Mengerti'
      });
    },

    batalForm() {
      Swal.fire({
        title: 'Batalkan Pendaftaran?',
        text: 'Data yang telah Anda isi akan hilang.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Batalkan',
        cancelButtonText: 'Kembali'
      }).then((result) => {
        if (result.isConfirmed) {
          this.$router.push('/dashboard');
        }
      });
    },

    simpanPendaftaran() {
      if (this.hasTunggakan) {
        Swal.fire({
          icon: 'error',
          title: 'Tidak Dapat Menyimpan (Tunggakan PBB)',
          text: this.tunggakanMsg,
          confirmButtonColor: '#d33',
          confirmButtonText: 'Tutup'
        });
        return;
      }
      if (this.totalDokumenSyarat > 0 && this.jumlahDokumenTercentang < this.totalDokumenSyarat) {
        Swal.fire({
          icon: 'warning',
          title: 'Persyaratan Belum Lengkap',
          text: 'Mohon lengkapi seluruh checklist dokumen fisik sebelum mendaftarkan berkas!',
          confirmButtonColor: '#f59e0b',
          confirmButtonText: 'Lengkapi Sekarang'
        });
        return;
      }

      this.isSaving = true;
      setTimeout(() => {
        this.isSaving = false;
        this.isSaved = true;

        Swal.fire({
          icon: 'success',
          title: 'Pendaftaran Berhasil!',
          text: 'Data pendaftaran berhasil disimpan! Anda akan diarahkan ke halaman unggah persyaratan digital.',
          timer: 2000,
          showConfirmButton: false
        }).then(() => {
          this.$router.push('/upload-persyaratan');
        });
      }, 1200);
    }
  }
};
</script>
