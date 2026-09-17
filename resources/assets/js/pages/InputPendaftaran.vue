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

</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
<!-- Nomor Pelayanan -->
<div class="flex flex-col gap-1.5 md:col-span-2 lg:col-span-1">
<label class="text-xs font-semibold text-slate-700 flex items-center justify-between">
<span>Nomor Pelayanan BPHTB <span class="text-red-500">*</span></span>
<span class="text-[11px] text-[#388e3c] font-semibold">Tersinkron Otomatis</span>
</label>
<div class="relative flex items-center">
<input class="w-full bg-slate-50 border border-slate-200 text-slate-800 font-mono text-sm px-3.5 py-2.5 rounded-lg outline-none cursor-not-allowed select-all uppercase" readonly="" type="text" v-model="form.nomorPelayanan"/>
</div>
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
Perkiraan Selesai
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
<input @input="form.namaWajibPajak = $event.target.value.toUpperCase()" class="w-full bg-white border border-slate-300 text-slate-800 text-sm pl-10 pr-3.5 py-2.5 rounded-lg outline-none focus:border-[#4CAF50] focus:ring-2 focus:ring-[#4CAF50]/20 transition-all uppercase" id="nama-pemohon" type="text" v-model="form.namaWajibPajak"/>
</div>
</div>
<!-- Baris 2: Alamat Pemohon -->
<div class="flex flex-col gap-1.5">
<label class="text-xs font-semibold text-slate-700" for="alamat-pemohon">
Alamat Domisili Pemohon Sesuai KTP <span class="text-red-500">*</span>
</label>
<textarea @input="form.alamatPemohon = $event.target.value.toUpperCase()" class="w-full bg-white border border-slate-300 text-slate-800 text-sm px-3.5 py-2.5 rounded-lg outline-none focus:border-[#4CAF50] focus:ring-2 focus:ring-[#4CAF50]/20 transition-all resize-none uppercase" id="alamat-pemohon" placeholder="" rows="2" v-model="form.alamatPemohon"></textarea>
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
<p class="text-xs text-slate-400" v-else="">Format 18 digit: 82.06.###.###.###.####.#</p>
</div>
<!-- Nama Subjek Pajak Terdaftar SPPT -->
<div class="md:col-span-5 flex flex-col gap-1.5">
<label class="text-xs font-semibold text-slate-700" for="nama-subjek-pbb">
Nama Wajib Pajak <span class="text-red-500">*</span>
</label>
<div class="relative flex items-center">
<span class="material-symbols-outlined absolute left-3 text-slate-400 text-[18px]">account_box</span>
<input @input="form.namaWpSppt = $event.target.value.toUpperCase()" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm pl-10 pr-3.5 py-2.5 rounded-lg outline-none font-medium uppercase" id="nama-subjek-pbb" type="text" v-model="form.namaWpSppt"/>
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
<textarea @input="form.alamatObjekPajak = $event.target.value.toUpperCase()" class="w-full bg-white border border-slate-300 text-slate-800 text-sm px-3.5 py-2.5 rounded-lg outline-none focus:border-[#4CAF50] focus:ring-2 focus:ring-[#4CAF50]/20 transition-all resize-none uppercase" id="alamat-objek-pajak" rows="2" v-model="form.alamatObjekPajak"></textarea>
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
</div>
<div class="md:col-span-7 flex flex-col gap-1.5">
<label class="text-xs font-semibold text-slate-700" for="keterangan-riwayat">
Keterangan Tambahan
</label>
<input @input="form.keteranganTambahan = $event.target.value.toUpperCase()" class="w-full bg-white border border-slate-300 text-slate-800 text-sm px-3.5 py-2.5 rounded-lg outline-none focus:border-[#4CAF50] focus:ring-2 focus:ring-[#4CAF50]/20 transition-all uppercase" id="keterangan-riwayat" type="text" v-model="form.keteranganTambahan"/>
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
Semua berkas fisik diverifikasi saat serah terima di Loket Pelayanan BPHTB BPKAD Kab. Haltim.
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
<span class="px-2.5 py-0.5 rounded-full bg-[#edf7ee] text-[#2e7d32] border border-[#c8e6c9] text-[11px] font-semibold" v-if="nopVerified &amp;&amp; !hasTunggakan">
Terbaca
</span>
<span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-500 border border-slate-200 text-[11px] font-medium" v-else="">
Belum Input NOP
</span>
</div>
<p class="text-xs text-slate-500">
Kalkulasi otomatis berdasarkan data NOP PBB-P2 dan Nilai Pasar yang diinput.
</p>

<div class="flex flex-col gap-2 pt-1">
<!-- Rincian Objek Pajak (Tanah & Bangunan) -->
<div class="p-3 rounded-lg bg-slate-50 border border-slate-200 flex flex-col gap-2">
<span class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
<span class="material-symbols-outlined text-[16px] text-[#4CAF50]">landscape</span>
Rincian NJOP PBB Objek Pajak
</span>
<!-- Tanah -->
<div class="flex items-center justify-between text-xs pt-1 border-t border-slate-200/80">
<div class="flex flex-col">
<span class="font-medium text-slate-700">Bumi / Tanah</span>
<span class="text-[11px] text-slate-400">Luas: {{ formatRupiah(simulasi.luasBumi) }} m² × Rp {{ formatRupiah(simulasi.njopBumi) }}</span>
</div>
<span class="font-mono text-xs font-semibold text-slate-800">Rp {{ formatRupiah(simulasi.totalNjopBumi) }}</span>
</div>
<!-- Bangunan -->
<div class="flex items-center justify-between text-xs pt-1 border-t border-slate-200/80">
<div class="flex flex-col">
<span class="font-medium text-slate-700">Bangunan</span>
<span class="text-[11px] text-slate-400">Luas: {{ formatRupiah(simulasi.luasBng) }} m² × Rp {{ formatRupiah(simulasi.njopBng) }}</span>
</div>
<span class="font-mono text-xs font-semibold text-slate-800">Rp {{ formatRupiah(simulasi.totalNjopBng) }}</span>
</div>
<!-- Total NJOP PBB -->
<div class="flex items-center justify-between text-xs pt-1.5 border-t border-slate-300 font-bold">
<span class="text-slate-900">Total NJOP PBB</span>
<span class="font-mono text-slate-900">Rp {{ formatRupiah(simulasi.totalNjopPbb) }}</span>
</div>
</div>

<!-- Form Input Nilai Pasar / Harga Transaksi -->
<div class="flex flex-col gap-1.5 p-3 rounded-lg bg-emerald-50/60 border border-emerald-200">
<label class="text-xs font-bold text-slate-800 flex items-center justify-between" for="input-nilai-pasar-sidebar">
<span class="flex items-center gap-1.5">
<span class="material-symbols-outlined text-[16px] text-[#4CAF50]">payments</span>
Nilai Pasar / Transaksi
</span>
<span class="text-[10px] text-emerald-700 font-semibold uppercase">Input Simulasi</span>
</label>
<div class="relative flex items-center">
<span class="absolute left-3 font-mono text-xs font-bold text-slate-400 select-none">Rp</span>
<input @input="onNilaiPasarInput" class="w-full bg-white border border-slate-300 text-slate-800 font-mono text-sm pl-9 pr-3 py-1.5 rounded-md outline-none focus:border-[#4CAF50] focus:ring-2 focus:ring-[#4CAF50]/20 transition-all font-bold" id="input-nilai-pasar-sidebar" placeholder="0" type="text" v-model="formattedNilaiPasar"/>
</div>
<p class="text-[11px] text-slate-500">Nilai pasar akta / risalah lelang (opsional / pembanding)</p>
</div>

<!-- Nilai Transaksi (NPOP) -->
<div class="flex items-center justify-between p-2.5 rounded-lg bg-slate-50 border border-slate-200">
<div class="flex flex-col">
<span class="text-xs font-semibold text-slate-800">Nilai Perolehan (NPOP)</span>
<span class="text-[11px] text-slate-400">MAX (NJOP PBB, Nilai Pasar)</span>
</div>
<span class="font-mono text-sm font-bold text-slate-900">Rp {{ formatRupiah(npop) }}</span>
</div>

<!-- Status Pemotongan NIK Switch Tab -->
<div class="flex flex-col gap-1.5 p-2 bg-slate-100 rounded-lg">
<span class="text-[11px] font-bold text-slate-700 px-1">Status Pemotongan NIK Pemohon:</span>
<div class="grid grid-cols-2 gap-1 text-xs font-semibold">
<button :class="statusPemotonganNIK === 'belum' ? 'bg-white text-[#2e7d32] shadow-xs font-bold border border-slate-200' : 'text-slate-500 hover:text-slate-800'" @click="statusPemotonganNIK = 'belum'" class="py-1.5 px-2 rounded-md transition-all text-center text-[11px]" type="button">
Tidak Pernah
</button>
<button :class="statusPemotonganNIK === 'sudah' ? 'bg-white text-rose-700 shadow-xs font-bold border border-slate-200' : 'text-slate-500 hover:text-slate-800'" @click="statusPemotonganNIK = 'sudah'" class="py-1.5 px-2 rounded-md transition-all text-center text-[11px]" type="button">
Sudah Pernah
</button>
</div>
</div>

<!-- NPOPTKP Daerah -->
<div class="flex items-center justify-between p-2.5 rounded-lg bg-slate-50 border border-slate-200">
<div class="flex flex-col">
<span class="text-xs font-semibold text-amber-700">NPOPTKP Daerah</span>
<span class="text-[11px] text-slate-400">{{ activeNpoptkpLabel }}</span>
</div>
<span class="font-mono text-sm font-semibold text-amber-700">- Rp {{ formatRupiah(activeNpoptkp) }}</span>
</div>

<!-- NPOPKP -->
<div class="flex items-center justify-between p-2.5 rounded-lg bg-slate-50/70 border border-slate-200">
<div class="flex flex-col">
<span class="text-xs font-semibold text-slate-800">NPOP Kena Pajak (NPOPKP)</span>
<span class="text-[11px] text-slate-400">NPOP - NPOPTKP</span>
</div>
<span class="font-mono text-sm font-bold text-slate-900">Rp {{ formatRupiah(activeNpopKenaPajak) }}</span>
</div>

<div class="h-[1px] bg-slate-200 my-0.5"></div>

<!-- BPHTB Terutang -->
<div class="flex items-center justify-between p-3 rounded-lg bg-slate-100 border border-slate-300">
<div class="flex flex-col">
<span class="text-xs font-bold text-slate-900">BPHTB Terutang</span>
<span class="text-[11px] text-slate-500">Tarif {{ (tarifBphtb.persen * 100).toFixed(0) }}% × NPOPKP</span>
</div>
<span class="font-mono text-base font-bold text-[#2e7d32]">Rp {{ formatRupiah(activeBphtbTerutang) }}</span>
</div>

<!-- BPHTB Yang Harus Dibayar -->
<div :class="statusPemotonganNIK === 'sudah' ? 'bg-amber-800' : 'bg-[#2e7d32]'" class="flex items-center justify-between p-3.5 rounded-xl text-white shadow-sm transition-colors">
<div class="flex flex-col">
<span class="text-xs text-white/90 font-semibold tracking-wide uppercase">BPHTB Harus Dibayar</span>
<span class="text-[11px] text-white/80">{{ activeStatusText }}</span>
</div>
<span class="font-mono text-xl font-bold tracking-tight text-white">Rp {{ formatRupiah(activeBphtbHarusDibayar) }}</span>
</div>

<!-- Perbandingan 2 Skenario (Belum Pernah vs Sudah Pernah Pemotongan) -->
<div class="p-3 rounded-lg bg-slate-50 border border-slate-200 flex flex-col gap-2 mt-1">
<span class="text-[11px] font-bold text-slate-700 uppercase tracking-wider flex items-center gap-1">
<span class="material-symbols-outlined text-[14px] text-slate-500">compare_arrows</span>
Perbandingan 2 Skenario NIK:
</span>
<div class="grid grid-cols-2 gap-2 text-[11px]">
<!-- Skenario 1: Tidak Pernah Pemotongan -->
<div class="p-2 rounded bg-white border border-slate-200 flex flex-col gap-1">
<span class="font-semibold text-[#2e7d32]">1. Tidak Pernah</span>
<span class="text-[10px] text-slate-400">NPOPTKP Rp {{ formatRupiah(npoptkpDaerah) }}</span>
<div class="flex justify-between text-[10px] text-slate-600 pt-1 border-t border-slate-100">
<span>NPOPKP:</span>
<span class="font-mono">Rp {{ formatRupiah(npopKenaPajak) }}</span>
</div>
<div class="flex justify-between text-[10px] text-slate-600">
<span>Terutang:</span>
<span class="font-mono">Rp {{ formatRupiah(bphtbTerutang) }}</span>
</div>
<div class="flex justify-between text-[11px] font-bold text-[#2e7d32] pt-1 border-t border-slate-200">
<span>Harus Dibayar:</span>
<span class="font-mono">Rp {{ formatRupiah(bphtbHarusDibayar) }}</span>
</div>
</div>

<!-- Skenario 2: Sudah Pernah Pemotongan -->
<div class="p-2 rounded bg-white border border-slate-200 flex flex-col gap-1">
<span class="font-semibold text-rose-700">2. Sudah Pernah</span>
<span class="text-[10px] text-slate-400">NPOPTKP Rp 0</span>
<div class="flex justify-between text-[10px] text-slate-600 pt-1 border-t border-slate-100">
<span>NPOPKP:</span>
<span class="font-mono">Rp {{ formatRupiah(npopKenaPajakPernah) }}</span>
</div>
<div class="flex justify-between text-[10px] text-slate-600">
<span>Terutang:</span>
<span class="font-mono">Rp {{ formatRupiah(bphtbTerutangPernah) }}</span>
</div>
<div class="flex justify-between text-[11px] font-bold text-rose-700 pt-1 border-t border-slate-200">
<span>Harus Dibayar:</span>
<span class="font-mono">Rp {{ formatRupiah(bphtbHarusDibayarPernah) }}</span>
</div>
</div>
</div>
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
<div class="static mt-8 lg:mt-0 lg:sticky lg:bottom-4 z-30 w-full bg-white/95 backdrop-blur-md rounded-2xl border border-slate-200 p-4 lg:p-5 shadow-lg flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4" v-if="!isSaved">
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
<!-- Modal Konfirmasi Hasil Inputan -->
<div v-if="showConfirmModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
  <div class="bg-white rounded-2xl shadow-2xl border border-slate-100 w-full max-w-2xl overflow-hidden flex flex-col max-h-[90vh]">
    <!-- Header Modal -->
    <div class="px-6 py-4 bg-gradient-to-r from-[#2e7d32] to-[#4CAF50] text-white flex items-center justify-between">
      <div class="flex items-center gap-3">
        <span class="material-symbols-outlined text-[24px]">assignment_turned_in</span>
        <div>
          <h3 class="font-bold text-base">Konfirmasi Hasil Input Pendaftaran</h3>
          <p class="text-xs text-emerald-100">Periksa kembali ringkasan data sebelum didaftarkan ke sistem</p>
        </div>
      </div>
      <button @click="showConfirmModal = false" class="text-white/80 hover:text-white hover:bg-white/10 rounded-lg p-1 transition-colors">
        <span class="material-symbols-outlined text-[20px]">close</span>
      </button>
    </div>

    <!-- Body Modal (Scrollable) -->
    <div class="p-6 overflow-y-auto flex flex-col gap-5 text-slate-700 text-xs">
      <!-- Section 1: Pelayanan & Subjek -->
      <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 flex flex-col gap-2.5">
        <span class="font-bold text-slate-900 text-sm border-b border-slate-200 pb-1.5 flex items-center gap-1.5">
          <span class="material-symbols-outlined text-[18px] text-[#4CAF50]">person</span> Identitas Pemohon &amp; Nomor Pelayanan
        </span>
        <div class="grid grid-cols-2 gap-x-4 gap-y-2">
          <div><span class="text-slate-400">No. Pelayanan:</span> <span class="font-mono font-bold text-slate-800 block">{{ form.nomorPelayanan }}</span></div>
          <div><span class="text-slate-400">No. Surat Permohonan:</span> <span class="font-mono font-bold text-slate-800 block">{{ form.noSuratPengantar }}</span></div>
          <div><span class="text-slate-400">Nama Pemohon:</span> <span class="font-semibold text-slate-800 block">{{ form.namaWajibPajak }}</span></div>
          <div><span class="text-slate-400">No. Kontak:</span> <span class="font-mono font-semibold text-slate-800 block">+62 {{ form.nomorKontak }}</span></div>
          <div class="col-span-2"><span class="text-slate-400">Alamat Pemohon:</span> <span class="font-medium text-slate-800 block">{{ form.alamatPemohon }}</span></div>
        </div>
      </div>

      <!-- Section 2: Objek Pajak -->
      <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 flex flex-col gap-2.5">
        <span class="font-bold text-slate-900 text-sm border-b border-slate-200 pb-1.5 flex items-center gap-1.5">
          <span class="material-symbols-outlined text-[18px] text-[#4CAF50]">home_work</span> Objek Pajak &amp; PBB
        </span>
        <div class="grid grid-cols-2 gap-x-4 gap-y-2">
          <div><span class="text-slate-400">NOP PBB-P2:</span> <span class="font-mono font-bold text-slate-800 block">{{ form.nop }}</span></div>
          <div><span class="text-slate-400">Nama WP di SPPT:</span> <span class="font-semibold text-slate-800 block">{{ form.namaWpSppt }}</span></div>
          <div class="col-span-2"><span class="text-slate-400">Alamat Objek Pajak:</span> <span class="font-medium text-slate-800 block">{{ form.alamatObjekPajak }}</span></div>
          <div class="col-span-2"><span class="text-slate-400">Keterangan:</span> <span class="font-medium text-slate-800 block">{{ form.keteranganTambahan }}</span></div>
        </div>
      </div>

      <!-- Section 3: Berkas Persyaratan -->
      <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 flex flex-col gap-2">
        <span class="font-bold text-slate-900 text-sm border-b border-slate-200 pb-1.5 flex items-center justify-between">
          <span class="flex items-center gap-1.5">
            <span class="material-symbols-outlined text-[18px] text-[#4CAF50]">folder_check</span> Persyaratan Berkas
          </span>
          <span class="text-xs font-semibold px-2 py-0.5 rounded bg-emerald-100 text-[#2e7d32]">
            {{ jumlahDokumenTercentang }} / {{ totalDokumenSyarat }} Dicentang
          </span>
        </span>
        <ul class="divide-y divide-slate-200/60" v-if="listPersyaratan.length > 0">
          <li v-for="item in listPersyaratan" :key="item.kd_syarat" class="py-1.5 flex items-center justify-between text-xs">
            <span class="text-slate-700 font-medium">{{ item.persyaratan }}</span>
            <span v-if="dokumenChecked[item.kd_syarat]" class="text-emerald-600 font-bold flex items-center gap-1">
              <span class="material-symbols-outlined text-[14px]">check_circle</span> Ada
            </span>
            <span v-else class="text-slate-400 italic">Tidak ada</span>
          </li>
        </ul>
        <div v-else class="text-slate-400 italic text-center py-2">Tidak membutuhkan berkas lampiran</div>
      </div>
    </div>

    <!-- Footer Modal -->
    <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex items-center justify-end gap-3">
      <button @click="showConfirmModal = false" class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-100 text-xs font-semibold transition-colors">
        Kembali &amp; Edit
      </button>
      <button @click="submitData" :disabled="isSaving" class="px-5 py-2 rounded-lg bg-[#4CAF50] text-white hover:bg-[#43a047] disabled:bg-slate-300 text-xs font-semibold flex items-center gap-2 shadow-sm transition-all">
        <span class="material-symbols-outlined text-[18px]" v-if="!isSaving">send</span>
        <span class="material-symbols-outlined text-[18px] animate-spin" v-if="isSaving">rotate_right</span>
        <span>{{ isSaving ? 'Memproses...' : 'Ya, Lanjutkan Simpan' }}</span>
      </button>
    </div>
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
      formattedNilaiPasar: '0',
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
        nilaiPasar: 0,
        nomorKontak: '',
        keteranganTambahan: ''
      },
      simulasi: {
        luasBumi: 0,
        njopBumi: 0,
        totalNjopBumi: 0,
        luasBng: 0,
        njopBng: 0,
        totalNjopBng: 0,
        totalNjopPbb: 0
      },
      tarifBphtb: {
        persen: 0.05,
        rek_minim1: 80000000,
        rek_minim2: 300000000
      },
      statusPemotonganNIK: 'belum', // 'belum' | 'sudah'
      isGeneratingNoSurat: false,
      isCheckingTunggakan: false,
      nopVerified: false,
      hasTunggakan: false,
      tunggakanMsg: '',
      isSaving: false,
      isSaved: false,
      showConfirmModal: false
    };
  },
  computed: {
    npoptkpDaerah() {
      // Tarif Khusus (Waris: '02', Hibah: '03', Hibah Wasiat: '04')
      if (['02', '03', '04'].includes(this.form.jenisTransaksi)) {
        return this.tarifBphtb.rek_minim2 || 300000000;
      }
      return this.tarifBphtb.rek_minim1 || 80000000;
    },
    npop() {
      const totalNjop = this.simulasi.totalNjopPbb || 0;
      const pasar = parseFloat(this.form.nilaiPasar) || 0;
      return Math.max(totalNjop, pasar);
    },
    // Skenario 1: Tidak Pernah Kena Pemotongan (Fasilitas NPOPTKP Utuh)
    npopKenaPajak() {
      const p = this.npop - this.npoptkpDaerah;
      return p > 0 ? p : 0;
    },
    bphtbTerutang() {
      return Math.round(this.npopKenaPajak * (this.tarifBphtb.persen || 0.05));
    },
    bphtbHarusDibayar() {
      return this.bphtbTerutang;
    },
    // Skenario 2: Sudah Pernah Kena Pemotongan (NPOPTKP = 0)
    npopKenaPajakPernah() {
      return this.npop;
    },
    bphtbTerutangPernah() {
      return Math.round(this.npopKenaPajakPernah * (this.tarifBphtb.persen || 0.05));
    },
    bphtbHarusDibayarPernah() {
      return this.bphtbTerutangPernah;
    },
    // Active computed based on toggle status
    activeNpoptkp() {
      return this.statusPemotonganNIK === 'sudah' ? 0 : this.npoptkpDaerah;
    },
    activeNpoptkpLabel() {
      return this.statusPemotonganNIK === 'sudah' ? 'Sudah Pernah Pemotongan (NPOPTKP Rp 0)' : 'Tidak Pernah Pemotongan';
    },
    activeNpopKenaPajak() {
      return this.statusPemotonganNIK === 'sudah' ? this.npopKenaPajakPernah : this.npopKenaPajak;
    },
    activeBphtbTerutang() {
      return this.statusPemotonganNIK === 'sudah' ? this.bphtbTerutangPernah : this.bphtbTerutang;
    },
    activeBphtbHarusDibayar() {
      return this.statusPemotonganNIK === 'sudah' ? this.bphtbHarusDibayarPernah : this.bphtbHarusDibayar;
    },
    activeStatusText() {
      return this.statusPemotonganNIK === 'sudah' ? 'Skenario: Sudah Pernah Pemotongan (Tanpa NPOPTKP)' : 'Skenario: Tidak Pernah Pemotongan (Fasilitas NPOPTKP)';
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
    isJenisTanpaBerkas() {
      // Kode jenis transaksi yang tidak memerlukan berkas lampiran
      return ['02', '06', '07', '09', '10', '11', '12', '13', '14', '16', '17'].includes(this.form.jenisTransaksi);
    },
    isFormMandatoryComplete() {
      const f = this.form;
      return !!(
        f.jenisTransaksi &&
        f.noSuratPengantar &&
        f.tanggalSurat &&
        f.tanggalPenerimaan &&
        f.namaWajibPajak && f.namaWajibPajak.trim() !== '' &&
        f.alamatPemohon && f.alamatPemohon.trim() !== '' &&
        f.nop && f.nop.trim() !== '' &&
        f.namaWpSppt && f.namaWpSppt.trim() !== '' &&
        f.alamatObjekPajak && f.alamatObjekPajak.trim() !== '' &&
        f.nomorKontak && f.nomorKontak.trim() !== '' &&
        f.keteranganTambahan && f.keteranganTambahan.trim() !== ''
      );
    },
    isSubmitDisabled() {
      if (this.isSaving || this.hasTunggakan) return true;
      // Data Wajib Pajak, Data Objek Pajak, & Keterangan belum diisi lengkap
      if (!this.isFormMandatoryComplete) return true;
      // Jika jenis transaksi mewajibkan berkas, minimal 1 berkas harus dicentang
      if (!this.isJenisTanpaBerkas && this.jumlahDokumenTercentang < 1) {
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
    const d = new Date(this.form.tanggalPenerimaan);
    d.setDate(d.getDate() + 3);
    this.form.perkiraanSelesai = d.toISOString().split('T')[0];

    // Load Jenis Transaksi & Tarif BPHTB dari API
    this.fetchJenisTransaksi();
    this.fetchTarifBphtb();
  },
  methods: {
    formatRupiah(value) {
      return new Intl.NumberFormat('id-ID').format(value || 0);
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

    fetchTarifBphtb() {
      axios.get('/api/v1/referensi/tarif-bphtb')
        .then(res => {
          if (res.data && res.data.status === 'success' && res.data.data) {
            this.tarifBphtb = res.data.data;
          }
        })
        .catch(() => {
          // Fallback silent ke default initial value
        });
    },

    onNilaiPasarInput(e) {
      let val = e.target.value.replace(/[^0-9]/g, '');
      if (!val) {
        this.form.nilaiPasar = 0;
        this.formattedNilaiPasar = '0';
        return;
      }
      this.form.nilaiPasar = parseInt(val, 10);
      this.formattedNilaiPasar = this.formatRupiah(this.form.nilaiPasar);
    },

    resetSimulasi() {
      this.simulasi.luasBumi = 0;
      this.simulasi.njopBumi = 0;
      this.simulasi.totalNjopBumi = 0;
      this.simulasi.luasBng = 0;
      this.simulasi.njopBng = 0;
      this.simulasi.totalNjopBng = 0;
      this.simulasi.totalNjopPbb = 0;
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
      this.resetSimulasi();
    },

    cekTunggakanPbb() {
      const cleanDigits = (this.form.nop || '').replace(/[^0-9]/g, '');
      if (cleanDigits.length < 18) {
        this.nopVerified = false;
        this.resetSimulasi();
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
            this.resetSimulasi();
            Swal.fire({
              icon: 'warning',
              title: 'Peringatan Tunggakan PBB-P2',
              text: this.tunggakanMsg,
              confirmButtonColor: '#d33',
              confirmButtonText: 'Tutup'
            });
          } else {
            // Otomatis isi Nama WP SPPT, Alamat Objek Pajak, & Data Simulasi Terutang dari data_op
            if (res.data.data_op) {
              if (res.data.data_op.nama_wp_sppt) {
                this.form.namaWpSppt = res.data.data_op.nama_wp_sppt;
              }
              if (res.data.data_op.alamat_objek_pajak) {
                this.form.alamatObjekPajak = res.data.data_op.alamat_objek_pajak;
              }
              this.simulasi.luasBumi = res.data.data_op.luas_bumi || 0;
              this.simulasi.njopBumi = res.data.data_op.njop_bumi || 0;
              this.simulasi.totalNjopBumi = res.data.data_op.total_njop_bumi || 0;
              this.simulasi.luasBng = res.data.data_op.luas_bng || 0;
              this.simulasi.njopBng = res.data.data_op.njop_bng || 0;
              this.simulasi.totalNjopBng = res.data.data_op.total_njop_bng || 0;
              this.simulasi.totalNjopPbb = res.data.data_op.total_njop_pbb || 0;
            }

            Swal.fire({
              icon: 'success',
              title: 'NOP Bebas Tunggakan',
              text: 'Data Wajib Pajak, Alamat, dan Detail Simulasi Terutang PBB berhasil dimuat otomatis.',
              timer: 2200,
              showConfirmButton: false
            });
          }
        } else {
          this.resetSimulasi();
          this.showApiError(res.data ? res.data.message : 'Gagal mengecek tunggakan PBB', 'Error Pengecekan PBB');
        }
      })
      .catch(err => {
        this.isCheckingTunggakan = false;
        this.resetSimulasi();
        this.showApiError(err, 'Error Pengecekan PBB');
      });
    },

    refreshNomorPelayanan() {
      const rand = Math.floor(Math.random() * 9000) + 1000;
      this.form.nomorPelayanan = 'PLY-BPHTB/2026/09/' + rand;
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

      // Jika jenis transaksi memerlukan berkas dan masih ada berkas yang belum dicentang
      if (!this.isJenisTanpaBerkas && this.totalDokumenSyarat > 0 && this.jumlahDokumenTercentang < this.totalDokumenSyarat) {
        Swal.fire({
          icon: 'warning',
          title: 'Pemberitahuan Berkas Belum Dilampirkan',
          text: `Anda baru melampirkan ${this.jumlahDokumenTercentang} dari ${this.totalDokumenSyarat} berkas persyaratan. Apakah Anda ingin tetap melanjutkan?`,
          showCancelButton: true,
          confirmButtonColor: '#4CAF50',
          cancelButtonColor: '#94a3b8',
          confirmButtonText: 'Ya, Lanjutkan Konfirmasi',
          cancelButtonText: 'Lengkapi Berkas'
        }).then((result) => {
          if (result.isConfirmed) {
            this.showConfirmModal = true;
          }
        });
      } else {
        // Berkas sudah lengkap / Jenis transaksi tanpa berkas
        this.showConfirmModal = true;
      }
    },

    submitData() {
      this.showConfirmModal = false;
      this.isSaving = true;

      const payload = {
        form: this.form,
        dokumenChecked: this.dokumenChecked
      };

      axios.post('/api/v1/pendaftaran/simpan', payload)
        .then(res => {
          this.isSaving = false;
          if (res.data && res.data.status === 'success') {
            this.isSaved = true;
            this.form.nomorPelayanan = res.data.no_pelayanan;

            Swal.fire({
              icon: 'success',
              title: 'Pendaftaran Berhasil!',
              text: 'Data pendaftaran berhasil disimpan! Anda akan diarahkan ke halaman unggah persyaratan digital.',
              timer: 2000,
              showConfirmButton: false
            }).then(() => {
              this.$router.push({ path: '/upload-persyaratan', query: { no_pelayanan: res.data.no_pelayanan } });
            });
          } else {
            this.showApiError(res.data ? res.data.message : 'Gagal menyimpan pendaftaran', 'Pendaftaran Gagal');
          }
        })
        .catch(err => {
          this.isSaving = false;
          this.showApiError(err, 'Pendaftaran Gagal');
        });
    }
  }
};
</script>
