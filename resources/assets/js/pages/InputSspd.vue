<template>
  <div class="w-full">

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
        <span class="hover:text-[#4CAF50] cursor-pointer transition-colors">Pendaftaran Baru</span>
        <span class="text-slate-300">/</span>
        <span class="text-[#4CAF50] font-semibold">Input Surat Setoran BPHTB</span>
      </nav>
      <div class="flex items-center gap-3 mt-1">
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Input Data Surat Setoran BPHTB</h1>
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#edf7ee] text-[#2e7d32] border border-[#c8e6c9] text-xs font-semibold shadow-xs">
          <span class="w-1.5 h-1.5 rounded-full bg-[#4CAF50] animate-pulse"></span>
          Tahap Perhitungan & Surat Setoran
        </span>
      </div>
      <p class="text-sm text-slate-600 max-w-3xl">
        Perekaman data wajib pajak, objek tanah & bangunan, kalkulasi NJOP PBB, serta penetapan jumlah setoran BPHTB terutang.
      </p>
    </div>
    <!-- Action summary shortcut -->
    <div class="flex items-center gap-2.5">
      <button class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors font-label-md text-label-md shadow-sm" type="button">
        <span class="material-symbols-outlined text-[18px] text-slate-500">history</span>
        Log Rekam
      </button>
      <button class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg bg-[#4CAF50] text-white hover:bg-[#3d8b40] transition-colors font-label-md text-label-md shadow-sm font-medium" type="button">
        <span class="material-symbols-outlined text-[18px]">document_scanner</span>
        Tarik Data SPPT
      </button>
    </div>
  </div>

<!-- Quick Context Panel / Metadata Banner -->
<div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 bg-slate-50 p-3 rounded-xl border border-slate-200">
<div class="flex items-center gap-3 bg-white p-3 rounded-lg border border-slate-200 shadow-sm">
<div class="w-10 h-10 rounded-lg bg-[#e8f5e9] flex items-center justify-center text-[#4CAF50]">
<span class="material-symbols-outlined text-[22px]">confirmation_number</span>
</div>
<div class="flex flex-col min-w-0">
<span class="font-label-sm text-label-sm text-slate-500 uppercase tracking-wider truncate">No. Pelayanan</span>
<span class="font-code-md text-code-md text-slate-900 font-semibold truncate">PLY-BPHTB/2026/09/00482</span>
</div>
</div>
<div class="flex items-center gap-3 bg-white p-3 rounded-lg border border-slate-200 shadow-sm">
<div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center text-slate-600">
<span class="material-symbols-outlined text-[22px]">calendar_today</span>
</div>
<div class="flex flex-col min-w-0">
<span class="font-label-sm text-label-sm text-slate-500 uppercase tracking-wider truncate">Tanggal Proses</span>
<span class="font-title-sm text-title-sm text-slate-900 font-semibold truncate">19 September 2026</span>
</div>
</div>
<div class="flex items-center gap-3 bg-white p-3 rounded-lg border border-slate-200 shadow-sm">
<div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center text-slate-600">
<span class="material-symbols-outlined text-[22px]">pin_invoke</span>
</div>
<div class="flex flex-col min-w-0">
<span class="font-label-sm text-label-sm text-slate-500 uppercase tracking-wider truncate">NOP PBB Terkait</span>
<span class="font-code-md text-code-md text-slate-900 font-semibold truncate">35.73.010.005.012-0045.0</span>
</div>
</div>
<div class="flex items-center gap-3 bg-white p-3 rounded-lg border border-slate-200 shadow-sm">
<div class="w-10 h-10 rounded-lg bg-[#e8f5e9] flex items-center justify-center text-[#4CAF50]">
<span class="material-symbols-outlined text-[22px]">verified</span>
</div>
<div class="flex flex-col min-w-0">
<span class="font-label-sm text-label-sm text-slate-500 uppercase tracking-wider truncate">Status Dokumen</span>
<span class="font-title-sm text-title-sm text-[#4CAF50] font-bold truncate">Siap Hitung &amp; Cetak SSPD</span>
</div>
</div>
</div>
<!-- Form Container Body -->
<div class="flex flex-col gap-6 pb-32 w-full">
<!-- SECTION 1: Data Pembeli / Wajib Pajak -->
<section class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden"><div class="px-6 py-4 bg-slate-50/80 border-b border-slate-200 flex flex-wrap items-center justify-between gap-3"><div class="flex items-center gap-3"><div class="w-8 h-8 rounded-lg bg-[#e8f5e9] text-[#4CAF50] flex items-center justify-center font-bold"><span class="material-symbols-outlined text-[20px]">badge</span></div><div><h2 class="font-title-lg text-title-lg font-bold text-slate-900">1. Data Pembeli / Wajib Pajak</h2><p class="font-body-sm text-body-sm text-slate-500">Identitas subjek pajak pembeli perolehan hak sesuai identitas KTP &amp; NPWP valid.</p></div></div><div class="flex items-center gap-2"><span class="inline-flex items-center gap-1 text-[#2e7d32] bg-[#e8f5e9] border border-[#c8e6c9] px-2.5 py-1 rounded-full font-label-sm text-label-sm font-semibold"><span class="material-symbols-outlined text-[15px]">verified_user</span>Dukcapil Verified</span></div></div><div class="p-6 lg:p-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"><div class="flex flex-col gap-1.5"><label class="font-label-md text-label-md text-slate-700 font-semibold flex items-center justify-between"><span class="">No. Dokumen SSPD <span class="text-rose-500">*</span></span><span class="font-body-sm text-body-sm text-slate-400 font-normal">Otomatis Terbit</span></label><div class="relative"><input class="w-full bg-slate-50 text-slate-700 font-code-md text-code-md px-3.5 py-2.5 rounded-lg border border-slate-200 focus:outline-none" readonly="" type="text" v-model="form.noDokumenSspd"/><span class="material-symbols-outlined absolute right-3 top-2.5 text-slate-400 text-[18px]">lock</span></div></div><div class="flex flex-col gap-1.5"><label class="font-label-md text-label-md text-slate-700 font-semibold flex items-center justify-between"><span class="">Nomor Induk Kependudukan (NIK) <span class="text-rose-500">*</span></span><span class="font-code-md text-code-md text-[#4CAF50] font-semibold">16 Digit</span></label><div class="relative"><input class="w-full bg-white text-slate-900 font-code-md text-code-md px-3.5 py-2.5 rounded-lg border border-slate-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#4CAF50] focus:border-[#4CAF50]" maxlength="16" type="text" v-model="form.nik"/><span class="material-symbols-outlined absolute right-3 top-2.5 text-[#4CAF50] text-[20px]">check_circle</span></div></div><div class="flex flex-col gap-1.5"><label class="font-label-md text-label-md text-slate-700 font-semibold">Nomor Pokok Wajib Pajak (NPWP)</label><div class="relative"><input class="w-full bg-white text-slate-900 font-code-md text-code-md px-3.5 py-2.5 rounded-lg border border-slate-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#4CAF50] focus:border-[#4CAF50]" type="text" v-model="form.npwp"/><span class="material-symbols-outlined absolute right-3 top-2.5 text-slate-400 text-[20px]">id_card</span></div></div><div class="flex flex-col gap-1.5 md:col-span-2 lg:col-span-3"><label class="font-label-md text-label-md text-slate-700 font-semibold">Nama Lengkap Wajib Pajak Sesuai KTP <span class="text-rose-500">*</span></label><input class="w-full bg-white text-slate-900 font-title-sm text-title-sm px-3.5 py-2.5 rounded-lg border border-slate-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#4CAF50] focus:border-[#4CAF50]" type="text" v-model="form.namaWajibPajak"/></div><div class="flex flex-col gap-1.5 md:col-span-2 lg:col-span-3"><label class="font-label-md text-label-md text-slate-700 font-semibold">Alamat Domisili Pembeli <span class="text-rose-500">*</span></label><textarea class="w-full bg-white text-slate-900 font-body-md text-body-md px-3.5 py-2.5 rounded-lg border border-slate-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#4CAF50] focus:border-[#4CAF50] resize-none" rows="2" v-model="form.alamatDomisili"></textarea></div><div class="flex flex-col gap-1.5"><label class="font-label-md text-label-md text-slate-700 font-semibold">Provinsi</label><select class="w-full bg-white text-slate-900 font-body-md text-body-md px-3.5 py-2.5 rounded-lg border border-slate-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#4CAF50] focus:border-[#4CAF50]" v-model="form.provinsi"><option value="Jawa Timur">Jawa Timur</option><option value="Jawa Tengah">Jawa Tengah</option><option value="DKI Jakarta">DKI Jakarta</option></select></div><div class="flex flex-col gap-1.5"><label class="font-label-md text-label-md text-slate-700 font-semibold">Kabupaten / Kota</label><select class="w-full bg-white text-slate-900 font-body-md text-body-md px-3.5 py-2.5 rounded-lg border border-slate-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#4CAF50] focus:border-[#4CAF50]" v-model="form.kabupaten"><option value="Kota Malang">Kota Malang</option><option value="Kab. Malang">Kab. Malang</option><option value="Kota Batu">Kota Batu</option></select></div><div class="flex flex-col gap-1.5"><label class="font-label-md text-label-md text-slate-700 font-semibold">Kecamatan</label><select class="w-full bg-white text-slate-900 font-body-md text-body-md px-3.5 py-2.5 rounded-lg border border-slate-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#4CAF50] focus:border-[#4CAF50]" v-model="form.kecamatan"><option value="Klojen">Klojen</option><option value="Lowokwaru">Lowokwaru</option><option value="Blimbing">Blimbing</option><option value="Kedungkandang">Kedungkandang</option><option value="Sukun">Sukun</option></select></div><div class="flex flex-col gap-1.5"><label class="font-label-md text-label-md text-slate-700 font-semibold">Kelurahan</label><select class="w-full bg-white text-slate-900 font-body-md text-body-md px-3.5 py-2.5 rounded-lg border border-slate-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#4CAF50] focus:border-[#4CAF50]" v-model="form.kelurahan"><option value="Oro-Oro Dowo">Oro-Oro Dowo</option><option value="Kaudan">Kaudan</option><option value="Gadingkasri">Gadingkasri</option><option value="Bareng">Bareng</option></select></div><div class="flex gap-3"><div class="flex flex-col gap-1.5 w-1/2"><label class="font-label-md text-label-md text-slate-700 font-semibold">RT</label><input class="w-full bg-white text-slate-900 font-code-md text-code-md px-3 py-2.5 rounded-lg border border-slate-200 shadow-sm text-center focus:outline-none focus:ring-2 focus:ring-[#4CAF50] focus:border-[#4CAF50]" type="text" v-model="form.rt"/></div><div class="flex flex-col gap-1.5 w-1/2"><label class="font-label-md text-label-md text-slate-700 font-semibold">RW</label><input class="w-full bg-white text-slate-900 font-code-md text-code-md px-3 py-2.5 rounded-lg border border-slate-200 shadow-sm text-center focus:outline-none focus:ring-2 focus:ring-[#4CAF50] focus:border-[#4CAF50]" type="text" v-model="form.rw"/></div></div><div class="flex flex-col gap-1.5"><label class="font-label-md text-label-md text-slate-700 font-semibold">Kode Pos</label><input class="w-full bg-white text-slate-900 font-code-md text-code-md px-3.5 py-2.5 rounded-lg border border-slate-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#4CAF50] focus:border-[#4CAF50]" maxlength="5" type="text" v-model="form.kodePos"/></div></div></section>
<!-- SECTION 2: Data Objek Tanah dan Bangunan -->
<section class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden"><div class="px-6 py-4 bg-slate-50/80 border-b border-slate-200 flex flex-wrap items-center justify-between gap-3"><div class="flex items-center gap-3"><div class="w-8 h-8 rounded-lg bg-[#e8f5e9] text-[#4CAF50] flex items-center justify-center font-bold"><span class="material-symbols-outlined text-[20px]">location_on</span></div><div><h2 class="font-title-lg text-title-lg font-bold text-slate-900">2. Data Objek Tanah dan Bangunan</h2><p class="font-body-sm text-body-sm text-slate-500">Data letak geografis dan rincian objek perolehan hak sesuai register SISMIOP PBB.</p></div></div><div class="inline-flex items-center gap-2 px-3 py-1 bg-slate-100 text-slate-700 border border-slate-200 rounded-lg font-label-sm text-label-sm font-medium"><span class="material-symbols-outlined text-[#4CAF50] text-[18px]">verified</span>Zona Perumahan Utama AA (ZNT Valid)</div></div><div class="p-6 lg:p-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"><div class="flex flex-col gap-1.5 md:col-span-2 lg:col-span-3"><label class="font-label-md text-label-md text-slate-700 font-semibold flex items-center justify-between"><span class="">Nama Wajib Pajak Lama / Tertera di SPPT PBB <span class="text-rose-500">*</span></span><span class="font-body-sm text-body-sm text-slate-400 font-normal">Sumber Database PBB-P2</span></label><div class="relative"><input class="w-full bg-slate-50 text-slate-700 font-title-sm text-title-sm px-3.5 py-2.5 rounded-lg border border-slate-200 focus:outline-none" readonly="" type="text" v-model="form.namaWpLama"/><span class="material-symbols-outlined absolute right-3 top-2.5 text-slate-400 text-[20px]">person_check</span></div></div><div class="flex flex-col gap-1.5 md:col-span-2 lg:col-span-3"><label class="font-label-md text-label-md text-slate-700 font-semibold">Letak Tanah dan / atau Bangunan Objek Pajak <span class="text-rose-500">*</span></label><textarea class="w-full bg-white text-slate-900 font-body-md text-body-md px-3.5 py-2.5 rounded-lg border border-slate-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#4CAF50] focus:border-[#4CAF50] resize-none" rows="2" v-model="form.letakTanahBangunan"></textarea></div><div class="flex gap-3"><div class="flex flex-col gap-1.5 w-1/2"><label class="font-label-md text-label-md text-slate-700 font-semibold">RT Objek</label><input class="w-full bg-white text-slate-900 font-code-md text-code-md px-3 py-2.5 rounded-lg border border-slate-200 shadow-sm text-center focus:outline-none focus:ring-2 focus:ring-[#4CAF50] focus:border-[#4CAF50]" type="text" v-model="form.rtObjek"/></div><div class="flex flex-col gap-1.5 w-1/2"><label class="font-label-md text-label-md text-slate-700 font-semibold">RW Objek</label><input class="w-full bg-white text-slate-900 font-code-md text-code-md px-3 py-2.5 rounded-lg border border-slate-200 shadow-sm text-center focus:outline-none focus:ring-2 focus:ring-[#4CAF50] focus:border-[#4CAF50]" type="text" v-model="form.rwObjek"/></div></div><div class="flex flex-col gap-1.5"><label class="font-label-md text-label-md text-slate-700 font-semibold">Kelurahan / Desa</label><input class="w-full bg-white text-slate-900 font-body-md text-body-md px-3.5 py-2.5 rounded-lg border border-slate-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#4CAF50] focus:border-[#4CAF50]" type="text" v-model="form.kelurahanObjek"/></div><div class="flex flex-col gap-1.5"><label class="font-label-md text-label-md text-slate-700 font-semibold">Kecamatan</label><input class="w-full bg-white text-slate-900 font-body-md text-body-md px-3.5 py-2.5 rounded-lg border border-slate-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#4CAF50] focus:border-[#4CAF50]" type="text" v-model="form.kecamatanObjek"/></div><div class="flex flex-col gap-1.5"><label class="font-label-md text-label-md text-slate-700 font-semibold">Kabupaten / Kota</label><input class="w-full bg-white text-slate-900 font-body-md text-body-md px-3.5 py-2.5 rounded-lg border border-slate-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#4CAF50] focus:border-[#4CAF50]" type="text" v-model="form.kabupatenObjek"/></div><div class="flex flex-col gap-1.5"><label class="font-label-md text-label-md text-slate-700 font-semibold">Kode Pos Objek</label><input class="w-full bg-white text-slate-900 font-code-md text-code-md px-3.5 py-2.5 rounded-lg border border-slate-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#4CAF50] focus:border-[#4CAF50]" maxlength="5" type="text" v-model="form.kodePosObjek"/></div><div class="flex items-center gap-3 p-3.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-600"><span class="material-symbols-outlined text-[#4CAF50] text-[24px]">map</span><div class="flex flex-col"><span class="font-label-sm text-label-sm font-semibold text-slate-900">Zona Nilai Tanah (ZNT): AA</span><span class="font-body-sm text-body-sm text-slate-500">Nilai Indikasi Rata-rata Terverifikasi BPN</span></div></div></div></section>
<!-- SECTION 3: Perhitungan NJOP PBB -->
<section class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden"><div class="px-6 py-4 bg-slate-50/80 border-b border-slate-200 flex flex-wrap items-center justify-between gap-3"><div class="flex items-center gap-3"><div class="w-8 h-8 rounded-lg bg-[#e8f5e9] text-[#4CAF50] flex items-center justify-center font-bold"><span class="material-symbols-outlined text-[20px]">calculate</span></div><div><h2 class="font-title-lg text-title-lg font-bold text-slate-900">3. Perhitungan Nilai Jual Objek Pajak (NJOP)</h2><p class="font-body-sm text-body-sm text-slate-500">Matriks perhitungan luas bidang tanah dan bangunan dengan tarif dasar PBB-P2.</p></div></div><span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#e8f5e9] text-[#2e7d32] border border-[#c8e6c9] font-label-sm text-label-sm font-semibold"><span class="material-symbols-outlined text-[16px]">sync</span>Otomatis &amp; Terintegrasi SISMIOP</span></div><div class="p-6 lg:p-8"><div class="overflow-x-auto rounded-xl border border-slate-200 bg-white"><table class="w-full border-collapse text-left"><thead><tr class="bg-slate-50 text-slate-700 font-label-md text-label-md border-b border-slate-200"><th class="p-4 align-middle text-left font-semibold" rowspan="2">Uraian Objek</th><th class="p-3 text-center font-semibold bg-slate-100/70 border-x border-slate-200" colspan="5">Luas Fisik (m²)</th><th class="p-4 align-middle text-right font-semibold" rowspan="2">NJOP PBB per m² (Rp)</th><th class="p-4 align-middle text-right font-semibold bg-slate-100/40 border-l border-slate-200" rowspan="2">Luas × NJOP PBB (Total)</th></tr><tr class="bg-slate-50/90 text-slate-500 font-label-sm text-label-sm text-center border-b border-slate-200"><th class="py-2.5 px-3 border-l border-slate-200">Panjang (m)</th><th class="py-2.5 px-1 font-bold">×</th><th class="py-2.5 px-3">Lebar (m)</th><th class="py-2.5 px-1 font-bold">=</th><th class="py-2.5 px-3 font-semibold text-slate-800 border-r border-slate-200">Total Luas (m²)</th></tr></thead><tbody class="divide-y divide-slate-100"><tr class="hover:bg-slate-50/60 transition-colors"><td class="p-4"><div class="flex items-center gap-2"><span class="material-symbols-outlined text-[#4CAF50] text-[20px]">landscape</span><span class="font-title-sm text-title-sm font-semibold text-slate-900">Tanah (Bumi)</span></div></td><td class="p-2 text-center"><input @input="updateLuasTanah" class="w-24 text-center font-code-md text-code-md bg-white border border-slate-200 px-2 py-1.5 rounded-lg shadow-sm focus:ring-2 focus:ring-[#4CAF50] focus:border-[#4CAF50] focus:outline-none" step="0.01" type="number" v-model.number="form.tanahPanjang"/></td><td class="p-1 text-center font-code-md text-code-md text-slate-400 font-bold">×</td><td class="p-2 text-center"><input @input="updateLuasTanah" class="w-24 text-center font-code-md text-code-md bg-white border border-slate-200 px-2 py-1.5 rounded-lg shadow-sm focus:ring-2 focus:ring-[#4CAF50] focus:border-[#4CAF50] focus:outline-none" step="0.01" type="number" v-model.number="form.tanahLebar"/></td><td class="p-1 text-center font-code-md text-code-md text-slate-400 font-bold">=</td><td class="p-2 text-center"><input class="w-28 text-center font-code-md text-code-md font-semibold bg-[#f0fdf4] text-[#2e7d32] border border-[#c8e6c9] px-2 py-1.5 rounded-lg focus:outline-none" step="0.01" type="number" v-model.number="form.tanahLuas"/></td><td class="p-4 text-right font-code-md text-code-md text-slate-800"><span class="text-slate-400 text-body-sm mr-1">Rp</span><span>{{ formatRupiah(form.tanahNjopPerM2) }}</span></td><td class="p-4 text-right font-code-md text-code-md font-semibold text-slate-900 bg-slate-50/40 border-l border-slate-100"><span class="text-slate-400 text-body-sm mr-1">Rp</span><span>{{ formatRupiah(totalTanahNjop) }}</span></td></tr><tr class="hover:bg-slate-50/60 transition-colors"><td class="p-4"><div class="flex items-center gap-2"><span class="material-symbols-outlined text-[#4CAF50] text-[20px]">apartment</span><span class="font-title-sm text-title-sm font-semibold text-slate-900">Bangunan</span></div></td><td class="p-2 text-center"><input @input="updateLuasBangunan" class="w-24 text-center font-code-md text-code-md bg-white border border-slate-200 px-2 py-1.5 rounded-lg shadow-sm focus:ring-2 focus:ring-[#4CAF50] focus:border-[#4CAF50] focus:outline-none" step="0.01" type="number" v-model.number="form.bangunanPanjang"/></td><td class="p-1 text-center font-code-md text-code-md text-slate-400 font-bold">×</td><td class="p-2 text-center"><input @input="updateLuasBangunan" class="w-24 text-center font-code-md text-code-md bg-white border border-slate-200 px-2 py-1.5 rounded-lg shadow-sm focus:ring-2 focus:ring-[#4CAF50] focus:border-[#4CAF50] focus:outline-none" step="0.01" type="number" v-model.number="form.bangunanLebar"/></td><td class="p-1 text-center font-code-md text-code-md text-slate-400 font-bold">=</td><td class="p-2 text-center"><input class="w-28 text-center font-code-md text-code-md font-semibold bg-[#f0fdf4] text-[#2e7d32] border border-[#c8e6c9] px-2 py-1.5 rounded-lg focus:outline-none" step="0.01" type="number" v-model.number="form.bangunanLuas"/></td><td class="p-4 text-right font-code-md text-code-md text-slate-800"><span class="text-slate-400 text-body-sm mr-1">Rp</span><span>{{ formatRupiah(form.bangunanNjopPerM2) }}</span></td><td class="p-4 text-right font-code-md text-code-md font-semibold text-slate-900 bg-slate-50/40 border-l border-slate-100"><span class="text-slate-400 text-body-sm mr-1">Rp</span><span>{{ formatRupiah(totalBangunanNjop) }}</span></td></tr></tbody><tfoot><tr class="bg-slate-50 border-t border-slate-200"><td class="p-4 text-slate-500 font-body-sm text-body-sm" colspan="6"><div class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px] text-[#4CAF50]">info</span><span class="">Catatan: Bisa diisi langsung pada kolom Luas bila data panjang dan lebar tidak ditemukan pada peta ukur.</span></div></td><td class="p-4 text-right font-title-sm text-title-sm font-semibold text-slate-800">Total NJOP PBB:</td><td class="p-4 text-right font-headline-md text-headline-md font-bold text-[#2e7d32] bg-[#f0fdf4] border-l border-slate-200"><span class="text-sm font-normal text-slate-600 mr-1">Rp</span><span>{{ formatRupiah(totalNjopPbb) }}</span></td></tr></tfoot></table></div><div class="mt-8 pt-6 bg-slate-50 border border-slate-200 p-6 rounded-xl"><div class="flex items-center gap-2 mb-4"><span class="material-symbols-outlined text-[#4CAF50] text-[20px]">contract</span><h3 class="font-title-sm text-title-sm font-bold text-slate-900">Detail Perolehan Hak Atas Tanah &amp; Bangunan</h3></div><div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5"><div class="flex flex-col gap-1.5"><label class="font-label-md text-label-md text-slate-700 font-semibold">Jenis Perolehan Hak <span class="text-rose-500">*</span></label><select class="w-full bg-white text-slate-900 font-body-md text-body-md px-3.5 py-2.5 rounded-lg border border-slate-200 shadow-sm focus:ring-2 focus:ring-[#4CAF50] focus:border-[#4CAF50] focus:outline-none" v-model="form.jenisPerolehanHak"><option value="Jual Beli">Jual Beli</option><option value="Tukar Menukar">Tukar Menukar</option><option value="Hibah / Hibah Wasiat">Hibah / Hibah Wasiat</option><option value="Waris">Waris</option><option value="Pemasukan dalam Perseroan (Inbreng)">Pemasukan dalam Perseroan (Inbreng)</option></select></div><div class="flex flex-col gap-1.5"><label class="font-label-md text-label-md text-slate-700 font-semibold">Nomor Sertifikat Tanah <span class="text-rose-500">*</span></label><input class="w-full bg-white text-slate-900 font-body-md text-body-md px-3.5 py-2.5 rounded-lg border border-slate-200 shadow-sm focus:ring-2 focus:ring-[#4CAF50] focus:border-[#4CAF50] focus:outline-none" type="text" v-model="form.nomorSertifikat"/></div><div class="flex flex-col gap-1.5"><label class="font-label-md text-label-md text-slate-700 font-semibold">Tanggal Sertifikat</label><input class="w-full bg-white text-slate-900 font-body-md text-body-md px-3.5 py-2.5 rounded-lg border border-slate-200 shadow-sm focus:ring-2 focus:ring-[#4CAF50] focus:border-[#4CAF50] focus:outline-none" type="date" v-model="form.tanggalSertifikat"/></div><div class="flex flex-col gap-1.5"><label class="font-label-md text-label-md text-slate-700 font-semibold">Nama Notaris Pembuat Akta</label><select class="w-full bg-white text-slate-900 font-body-md text-body-md px-3.5 py-2.5 rounded-lg border border-slate-200 shadow-sm focus:ring-2 focus:ring-[#4CAF50] focus:border-[#4CAF50] focus:outline-none" v-model="form.namaNotaris"><option value="Farida Hanum, S.H., M.Kn.">Farida Hanum, S.H., M.Kn.</option><option value="Anwar Sanusi, S.H., M.Kn.">Anwar Sanusi, S.H., M.Kn.</option><option value="Dewi Sartika, S.H., Sp.N.">Dewi Sartika, S.H., Sp.N.</option></select></div><div class="flex flex-col gap-1.5 sm:col-span-2"><label class="font-label-md text-label-md text-slate-700 font-semibold">Nama Pejabat / PPAT / PPATS Wilayah</label><select class="w-full bg-white text-slate-900 font-body-md text-body-md px-3.5 py-2.5 rounded-lg border border-slate-200 shadow-sm focus:ring-2 focus:ring-[#4CAF50] focus:border-[#4CAF50] focus:outline-none" v-model="form.namaPejabat"><option value="Drs. Bambang Sudiro (Camat / PPATS Klojen)">Drs. Bambang Sudiro (Camat / PPATS Klojen)</option><option value="Kantor Pertanahan Kota Malang (BPN)">Kantor Pertanahan Kota Malang (BPN)</option></select></div></div></div></div></section>
<!-- SECTION 4: Perhitungan BPHTB & Kalkulator Pajak -->
<section class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden"><div class="px-6 py-4 bg-slate-50/80 border-b border-slate-200 flex flex-wrap items-center justify-between gap-3"><div class="flex items-center gap-3"><div class="w-8 h-8 rounded-lg bg-[#e8f5e9] text-[#4CAF50] flex items-center justify-center font-bold"><span class="material-symbols-outlined text-[20px]">payments</span></div><div><h2 class="font-title-lg text-title-lg font-bold text-slate-900">4. Perhitungan Bea Perolehan Hak atas Tanah dan Bangunan (BPHTB)</h2><p class="font-body-sm text-body-sm text-slate-500">Rincian formula penentuan dasar pengenaan pajak (NPOP vs NJOP) dan nilai terutang.</p></div></div><div class="flex items-center gap-1.5 font-label-sm text-label-sm text-[#2e7d32] bg-[#e8f5e9] border border-[#c8e6c9] px-3 py-1 rounded-full font-semibold"><span class="material-symbols-outlined text-[16px] text-[#4CAF50]">verified</span>Tarif Perda Berlaku: {{ (tarifBphtb * 100).toFixed(0) }}%</div></div><div class="p-6 lg:p-8"><div class="grid grid-cols-1 lg:grid-cols-12 gap-8"><div class="lg:col-span-7 flex flex-col gap-5"><div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex flex-col gap-2"><div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3"><span class="font-title-sm text-title-sm font-bold text-slate-900 flex items-start sm:items-center gap-2"><span class="w-6 h-6 shrink-0 rounded-full bg-[#4CAF50] text-white text-center leading-6 font-code-md text-code-md font-bold">1</span><span>Nilai Perolehan Objek Pajak (NPOP) / Transaksi Pasar</span></span><span class="font-label-sm text-label-sm px-2 py-0.5 rounded bg-slate-200 text-slate-700 font-medium self-start sm:self-auto ml-8 sm:ml-0">Input Real Transaksi</span></div><p class="font-body-sm text-body-sm text-slate-600">Nilai riil berdasarkan Akta Jual Beli. Jika NPOP &gt; Total NJOP PBB, maka NPOP yang digunakan sebagai dasar.</p><div class="relative mt-1"><span class="absolute left-3.5 top-2.5 font-code-md text-code-md font-semibold text-slate-500">Rp</span><input :value="formatRupiah(form.npop)" @input="onNpopInput($event.target.value)" class="w-full bg-white text-slate-900 font-headline-md text-headline-md font-semibold pl-12 pr-4 py-2 rounded-lg border border-slate-200 shadow-sm focus:ring-2 focus:ring-[#4CAF50] focus:border-[#4CAF50] focus:outline-none" type="text"/></div><div class="flex items-center gap-2 text-[#2e7d32] font-body-sm text-body-sm mt-1 font-medium"><span class="material-symbols-outlined text-[16px] text-[#4CAF50]">check_circle</span><span v-if="form.npop &gt;= totalNjopPbb">NPOP (Rp {{ formatRupiah(form.npop) }}) lebih tinggi dari Total NJOP (Rp {{ formatRupiah(totalNjopPbb) }}) → Sesuai Ketentuan Pajak.</span><span class="text-amber-700 font-semibold" v-else="">Total NJOP (Rp {{ formatRupiah(totalNjopPbb) }}) lebih tinggi dari NPOP → Digunakan NJOP sebagai dasar hitung.</span></div></div><div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex flex-col gap-2"><div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3"><span class="font-title-sm text-title-sm font-bold text-slate-900 flex items-start sm:items-center gap-2"><span class="w-6 h-6 shrink-0 rounded-full bg-slate-200 text-slate-700 text-center leading-6 font-code-md text-code-md font-semibold">2</span><span>NPOP Tidak Kena Pajak (NPOPTKP)</span></span><span class="font-label-sm text-label-sm px-2 py-0.5 rounded bg-slate-200 text-slate-600 self-start sm:self-auto ml-8 sm:ml-0">Ketetapan Perda</span></div><div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 bg-white p-3 rounded-lg border border-slate-200 shadow-sm"><span class="font-body-md text-body-md text-slate-600">Standar Perolehan Hak Jual Beli Pertama</span><div class="font-code-md text-code-md font-semibold text-slate-900"><span class="text-body-sm text-slate-400 mr-1">Rp</span><span>{{ formatRupiah(form.npoptkp) }}</span></div></div></div><div class="grid grid-cols-1 sm:grid-cols-2 gap-4"><div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex flex-col gap-2"><span class="font-title-sm text-title-sm font-bold text-slate-900 flex items-center gap-2"><span class="w-6 h-6 rounded-full bg-slate-200 text-slate-700 text-center leading-6 font-code-md text-code-md font-semibold">3</span>NPOP Kena Pajak (NPOPKP)</span><span class="font-body-sm text-body-sm text-slate-500">(Dasar Pajak − NPOPTKP)</span><div class="bg-white p-3 rounded-lg border border-slate-200 shadow-sm font-code-md text-code-md font-semibold text-slate-900"><span class="text-body-sm text-slate-400 mr-1">Rp</span><span>{{ formatRupiah(npopkp) }}</span></div></div><div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex flex-col gap-2"><span class="font-title-sm text-title-sm font-bold text-slate-900 flex items-center gap-2"><span class="w-6 h-6 rounded-full bg-slate-200 text-slate-700 text-center leading-6 font-code-md text-code-md font-semibold">4</span>Tarif Pajak BPHTB</span><span class="font-body-sm text-body-sm text-slate-500">Tarif Tunggal Daerah</span><div class="bg-white p-3 rounded-lg border border-slate-200 shadow-sm font-code-md text-code-md font-bold text-[#4CAF50]">{{ (tarifBphtb * 100).toFixed(1) }} % (Persen)</div></div></div><div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3"><div class="flex items-start sm:items-center gap-3"><span class="w-6 h-6 shrink-0 rounded-full bg-slate-200 text-slate-700 text-center leading-6 font-code-md text-code-md font-semibold">5</span><div class="flex flex-col"><span class="font-title-sm text-title-sm font-bold text-slate-900">BPHTB yang Terutang</span><span class="font-body-sm text-body-sm text-slate-500">5% × Nilai NPOPKP</span></div></div><div class="font-headline-md text-headline-md font-bold text-slate-900 font-code-md self-start sm:self-auto ml-9 sm:ml-0"><span class="text-body-sm text-slate-400 font-normal mr-1">Rp</span><span>{{ formatRupiah(bphtbTerutang) }}</span></div></div></div><div class="lg:col-span-5 flex flex-col justify-between p-6 lg:p-8 rounded-2xl bg-white border border-slate-200 shadow-sm"><div class="flex flex-col gap-4"><div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 pb-3 bg-slate-50 border border-slate-200 px-3 py-2 rounded-lg"><div class="flex items-start sm:items-center gap-2"><span class="material-symbols-outlined shrink-0 text-[#4CAF50] text-[22px]">account_balance_wallet</span><span class="font-label-md text-label-md font-bold text-slate-900">6. BPHTB Yang Harus Dibayar</span></div><span class="px-2 py-0.5 rounded bg-[#4CAF50] text-white font-label-sm text-label-sm font-bold self-start sm:self-auto ml-8 sm:ml-0">FINAL</span></div><div class="flex flex-col gap-1 my-2"><span class="font-label-sm text-label-sm text-slate-500 uppercase tracking-wider font-semibold">Total Pokok Pajak Terutang</span><div class="text-3xl lg:text-display-lg font-bold text-[#4CAF50] tracking-tight font-code-md flex items-baseline break-all"><span class="text-xl lg:text-headline-md font-normal text-slate-400 mr-2">Rp</span><span>{{ formatRupiah(bphtbYangHarusDibayar) }}</span></div></div><div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 flex flex-col gap-1"><span class="font-label-sm text-label-sm text-slate-500 font-medium">Terbilang:</span><p class="font-body-md text-body-md text-slate-800 font-semibold italic capitalize leading-relaxed">“{{ terbilang }}”</p></div><div class="flex flex-col gap-2 mt-2 pt-3 border-t border-slate-200 font-body-sm text-body-sm"><div class="flex justify-between text-slate-600"><span class="">NPOP (Dasar Hitung)</span><span class="font-code-md text-code-md text-slate-900 font-medium">Rp {{ formatRupiah(dasarPengenaanPajak) }}</span></div><div class="flex justify-between text-slate-600"><span class="">Pengurang (NPOPTKP)</span><span class="font-code-md text-code-md text-slate-900 font-medium">− Rp {{ formatRupiah(form.npoptkp) }}</span></div><div class="flex justify-between text-slate-600"><span class="">Pengenaan Pajak (5%)</span><span class="font-code-md text-code-md text-[#4CAF50] font-bold">Rp {{ formatRupiah(bphtbTerutang) }}</span></div><div class="flex justify-between text-slate-600"><span class="">Sanksi Administrasi / Denda</span><span class="font-code-md text-code-md text-slate-900">Rp 0 (Nihil)</span></div></div></div><div class="mt-6 pt-4 border-t border-slate-200 flex items-center gap-3"><div class="w-8 h-8 rounded-full bg-[#e8f5e9] text-[#4CAF50] flex items-center justify-center shrink-0"><span class="material-symbols-outlined text-[18px]">verified</span></div><p class="font-body-sm text-body-sm text-slate-500 leading-tight">Kalkulasi otomatis disinkronkan dengan Modul Validasi BPKAD Kab. Haltim.</p></div></div></div></div></section>
<!-- SECTION 5: Dasar Pengenaan & Setoran Pajak -->
<section class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden"><div class="px-6 py-4 bg-slate-50/80 border-b border-slate-200 flex flex-wrap items-center justify-between gap-3"><div class="flex items-center gap-3"><div class="w-8 h-8 rounded-lg bg-[#e8f5e9] text-[#4CAF50] flex items-center justify-center font-bold"><span class="material-symbols-outlined text-[20px]">fact_check</span></div><div><h2 class="font-title-lg text-title-lg font-bold text-slate-900">5. Dasar Pengenaan &amp; Setoran Pajak</h2><p class="font-body-sm text-body-sm text-slate-500">Legalitas landasan penetapan kewajiban penyetoran bea perolehan hak.</p></div></div></div><div class="p-6 lg:p-8 flex flex-col gap-6"><div class="grid grid-cols-1 md:grid-cols-2 gap-4"><label :class="['relative flex items-start gap-4 p-4 rounded-xl cursor-pointer transition-all', form.dasarPengenaan === 'self_assessment' ? 'bg-[#f0fdf4] border-2 border-[#4CAF50]' : 'bg-white hover:bg-slate-50 border border-slate-200']"><input class="mt-1 w-4 h-4 text-[#4CAF50] focus:ring-[#4CAF50]" name="dasar_setoran" type="radio" v-model="form.dasarPengenaan" value="self_assessment"/><div class="flex flex-col gap-1"><span class="font-title-sm text-title-sm font-bold text-slate-900">Perhitungan Wajib Pajak (Self Assessment)</span><p class="font-body-sm text-body-sm text-slate-600">Dihitung sendiri oleh Wajib Pajak atau melalui Pejabat Pembuat Akta Tanah (PPAT/PPATS) berdasarkan harga transaksi wajar.</p></div></label><label :class="['relative flex items-start gap-4 p-4 rounded-xl cursor-pointer transition-all', form.dasarPengenaan === 'ketetapan_resmi' ? 'bg-[#f0fdf4] border-2 border-[#4CAF50]' : 'bg-white hover:bg-slate-50 border border-slate-200']"><input class="mt-1 w-4 h-4 text-[#4CAF50] focus:ring-[#4CAF50]" name="dasar_setoran" type="radio" v-model="form.dasarPengenaan" value="ketetapan_resmi"/><div class="flex flex-col gap-1"><span class="font-title-sm text-title-sm font-bold text-slate-900">Berdasarkan Ketetapan Resmi (SKPDKB / SKPDKBT / STPD)</span><p class="font-body-sm text-body-sm text-slate-600">Penerbitan surat ketetapan oleh pejabat berwenang atas adanya kurang bayar atau temuan pemeriksaan lapangan.</p></div></label></div><div class="p-5 rounded-xl bg-slate-50 border border-slate-200 grid grid-cols-1 md:grid-cols-2 gap-4" v-show="form.dasarPengenaan === 'ketetapan_resmi'"><div class="flex flex-col gap-1.5"><label class="font-label-md text-label-md text-slate-700 font-semibold">Nomor Surat Ketetapan (SKPDKB/SKPDKBT)</label><input class="w-full bg-white text-slate-900 font-body-md text-body-md px-3.5 py-2.5 rounded-lg border border-slate-200 shadow-sm focus:ring-2 focus:ring-[#4CAF50] focus:border-[#4CAF50] focus:outline-none" placeholder="Contoh: 973/048/SKPDKB/2026" type="text" v-model="form.nomorSkp"/></div><div class="flex flex-col gap-1.5"><label class="font-label-md text-label-md text-slate-700 font-semibold">Tanggal Terbit Ketetapan</label><input class="w-full bg-white text-slate-900 font-body-md text-body-md px-3.5 py-2.5 rounded-lg border border-slate-200 shadow-sm focus:ring-2 focus:ring-[#4CAF50] focus:border-[#4CAF50] focus:outline-none" type="date" v-model="form.tanggalSkp"/></div></div><div class="flex flex-col gap-3 pt-2"><label class="inline-flex items-center gap-2.5 cursor-pointer"><input class="w-4 h-4 text-[#4CAF50] rounded focus:ring-[#4CAF50]" type="checkbox" v-model="form.dihitungSendiri"/><span class="font-label-md text-label-md text-slate-800 font-semibold">Perhitungan Dihitung Sendiri oleh Wajib Pajak / Kuasa Wajib Pajak</span></label><div class="flex flex-col gap-1.5 pl-6"><label class="font-label-md text-label-md text-slate-600">Alasan / Catatan Dasar Perhitungan:</label><textarea class="w-full bg-white text-slate-900 font-body-md text-body-md px-3.5 py-2.5 rounded-lg border border-slate-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#4CAF50] focus:border-[#4CAF50] resize-none" rows="2" v-model="form.alasanDasarPerhitungan"></textarea></div></div></div></section>
</div>
<!-- STICKY BOTTOM ACTION BAR (Desktop Only) -->
<div class="static mt-8 lg:mt-0 lg:sticky lg:bottom-4 z-30 w-full bg-white/95 backdrop-blur-md rounded-2xl border border-slate-200 p-4 lg:p-5 shadow-lg flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
  <div class="flex items-center gap-3">
    <div class="w-9 h-9 rounded-lg bg-[#edf7ee] border border-[#c8e6c9] flex items-center justify-center text-[#4CAF50] shrink-0">
      <span class="material-symbols-outlined text-[20px]">payments</span>
    </div>
    <div class="flex flex-col">
      <span class="text-xs font-bold text-slate-900">Total Setoran BPHTB</span>
      <span class="text-[11px] text-slate-500">Rp {{ formatRupiah(bphtbYangHarusDibayar) }}</span>
    </div>
  </div>
  <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full sm:w-auto justify-end">
    <!-- Tombol Batal -->
    <button @click="batal" class="px-5 py-2.5 rounded-lg bg-slate-100 border border-slate-200 text-slate-700 hover:bg-slate-200 transition-colors text-xs font-semibold flex justify-center items-center gap-2" type="button">
      <span class="material-symbols-outlined text-[18px]">close</span>
      <span>Batal</span>
    </button>
    
    <!-- Tombol Cetak Pratinjau -->
    <button @click="cetakPratinjau" class="px-5 py-2.5 rounded-lg bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors text-xs font-semibold flex justify-center items-center gap-2 shadow-sm" type="button">
      <span class="material-symbols-outlined text-[18px]">print</span>
      <span>Cetak Pratinjau</span>
    </button>

    <!-- Tombol Simpan & Terbitkan -->
    <button @click="simpanDanTerbitkan" class="px-6 py-2.5 rounded-lg bg-[#4CAF50] text-white hover:bg-[#43a047] transition-all text-xs font-semibold flex justify-center items-center gap-2.5 shadow-sm hover:shadow" type="button">
      <span class="material-symbols-outlined text-[20px]">check_circle</span>
      <span>Simpan &amp; Terbitkan (SSPD)</span>
    </button>
  </div>
</div>
</div>
</div>
</template>


<script>
export default {
  name: 'InputSspd',
  data() {
    return {
      nomorPelayanan: 'PLY-BPHTB/2026/09/00482',
      form: {
        noDokumenSspd: 'SYS-AUTO',
        nik: '3573012345678901',
        npwp: '01.234.567.8-901.000',
        namaWajibPajak: 'Ir. Muhammad Rizky Kurniawan, M.Eng.',
        alamatDomisili: 'Jl. Ijen Boulevard No. 45',
        provinsi: 'Jawa Timur',
        kabupaten: 'Kota Malang',
        kecamatan: 'Klojen',
        kelurahan: 'Oro-Oro Dowo',
        rt: '04',
        rw: '08',
        kodePos: '65112',
        
        namaWpLama: 'Bpk. H. Soetomo',
        letakTanahBangunan: 'Kav. Perumahan Ijen Nirwana Res. Blok A-12',
        rtObjek: '01',
        rwObjek: '05',
        kelurahanObjek: 'Bareng',
        kecamatanObjek: 'Klojen',
        kabupatenObjek: 'Kota Malang',
        kodePosObjek: '65116',
        
        tanahPanjang: 20,
        tanahLebar: 10,
        tanahLuas: 200,
        tanahNjopPerM2: 1250000,
        
        bangunanPanjang: 15,
        bangunanLebar: 8,
        bangunanLuas: 120,
        bangunanNjopPerM2: 754545,
        
        jenisPerolehanHak: 'Jual Beli',
        nomorSertifikat: 'SHM. 04112 / Bareng',
        tanggalSertifikat: '2026-09-01',
        namaNotaris: 'Farida Hanum, S.H., M.Kn.',
        namaPejabat: 'Drs. Bambang Sudiro (Camat / PPATS Klojen)',
        
        npop: 850000000,
        npoptkp: 80000000,
        
        dasarPengenaan: 'self_assessment',
        nomorSkp: '',
        tanggalSkp: '',
        persyaratanValid: false
      },
      tarifBphtb: 0.05
    }
  },
  computed: {
    totalTanahNjop() {
      return Math.round(this.form.tanahLuas * this.form.tanahNjopPerM2);
    },
    totalBangunanNjop() {
      return Math.round(this.form.bangunanLuas * this.form.bangunanNjopPerM2);
    },
    totalNjopPbb() {
      return this.totalTanahNjop + this.totalBangunanNjop;
    },
    dasarPengenaanPajak() {
      return Math.max(this.form.npop, this.totalNjopPbb);
    },
    npopkp() {
      return Math.max(0, this.dasarPengenaanPajak - this.form.npoptkp);
    },
    bphtbTerutang() {
      return Math.round(this.npopkp * this.tarifBphtb);
    },
    bphtbYangHarusDibayar() {
      return this.bphtbTerutang; // Asumsi tidak ada denda
    },
    terbilang() {
      // Sederhana untuk keperluan demo UI
      return "Tiga Puluh Delapan Juta Lima Ratus Ribu Rupiah";
    }
  },
  methods: {
    formatRupiah(value) {
      if (!value) return '0';
      return parseInt(value, 10).toLocaleString('id-ID');
    },
    onNpopInput(val) {
      let raw = val.replace(/\D/g, '');
      this.form.npop = parseInt(raw, 10) || 0;
    },
    updateLuasTanah() {
      this.form.tanahLuas = this.form.tanahPanjang * this.form.tanahLebar;
    },
    updateLuasBangunan() {
      this.form.bangunanLuas = this.form.bangunanPanjang * this.form.bangunanLebar;
    },
    previewSSPDModal() {
      window.print();
    },
    cetakPratinjau() {
      this.previewSSPDModal();
    },
    batal() {
      if (confirm('Apakah Anda yakin ingin membatalkan pengisian formulir SSPD? Semua isian akan hilang.')) {
        this.$router.push({ name: 'dashboard' }).catch(() => {});
      }
    },
    simpanDanTerbitkan() {
      this.submitSSPD();
    },
    submitSSPD() {
      if (!this.form.persyaratanValid && this.form.dasarPengenaan === 'self_assessment' && !this.form.dihitungSendiri) {
        alert('Pastikan kelengkapan dan dasar perhitungan sudah terisi dengan benar.');
      } else {
        alert('Dokumen Surat Setoran BPHTB berhasil diverifikasi & diterbitkan.');
      }
    }
  }
}
</script>
