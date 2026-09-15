<template>
<div><div class="flex flex-col w-full gap-6 select-none">
<!-- Top Action & Filter Bar -->
<div class="flex flex-col xl:flex-row items-start xl:items-center justify-between gap-4 pb-2">
<div>
<div class="flex items-center gap-3">
<h1 class="font-headline-lg text-headline-lg text-[#264332] tracking-tight">Dashboard</h1>
<span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-label-sm font-label-sm bg-[#ebf6ee] text-[#2e7d32] border border-[#cfe0d4]">
<span class="w-1.5 h-1.5 rounded-full bg-[#4CAF50] animate-pulse"></span>
          Data Real-Time PAD
        </span>
</div>
<p class="font-body-md text-body-md text-on-surface-variant mt-0.5">Ringkasan informasi permohonan dan penerimaan BPHTB.</p>
</div>
<!-- Filters & State Controls -->
<div class="flex flex-wrap items-center gap-2.5 bg-surface-container-lowest p-2 rounded-xl border border-[#cfe0d4] shadow-sm w-full xl:w-auto">
<div class="flex items-center gap-1.5 px-3 py-1.5 bg-[#f0f6f2] border border-[#dce9df] rounded-lg text-on-surface-variant text-label-md font-label-md">
<span class="material-symbols-outlined text-[18px] text-[#4CAF50]">location_city</span>
<select class="bg-transparent text-on-surface font-label-md outline-none cursor-pointer pr-2" id="kecamatanFilter" v-model="selectedKecamatan">
<option value="all">Semua Kecamatan</option>
<option value="lowokwaru">Kec. Lowokwaru</option>
<option value="klojen">Kec. Klojen</option>
<option value="blimbing">Kec. Blimbing</option>
<option value="sukun">Kec. Sukun</option>
<option value="kedungkandang">Kec. Kedungkandang</option>
</select>
</div>
<div class="flex items-center gap-1.5 px-3 py-1.5 bg-[#f0f6f2] border border-[#dce9df] rounded-lg text-on-surface-variant text-label-md font-label-md">
<span class="material-symbols-outlined text-[18px] text-[#4CAF50]">date_range</span>
<span class="text-on-surface">{{ dateRange }}</span>
</div>
<div class="flex items-center gap-1.5 px-3 py-1.5 bg-[#f0f6f2] border border-[#dce9df] rounded-lg text-on-surface-variant text-label-md font-label-md">
<span class="material-symbols-outlined text-[18px] text-[#4CAF50]">calendar_month</span>
<select class="bg-transparent text-on-surface font-label-md outline-none cursor-pointer" id="tahunFilter" v-model="selectedTahun">
<option value="2026">TA 2026</option>
<option value="2025">TA 2025</option>
<option value="2024">TA 2024</option>
</select>
</div>
<button @click="applyFilter" class="inline-flex items-center gap-2 px-4 py-2 bg-[#4CAF50] text-white rounded-lg font-label-md text-label-md hover:bg-[#3d9140] transition-all active:scale-95 shadow-xs" id="btnApplyFilter">
<span class="material-symbols-outlined text-[18px]">filter_alt</span>
        Terapkan Filter
      </button>
<button @click="resetDashboardState" class="p-2 bg-[#f0f6f2] hover:bg-[#e4eee6] text-on-surface-variant rounded-lg border border-[#dce9df] transition-colors" title="Muat Ulang / Reset">
<span class="material-symbols-outlined text-[20px]">refresh</span>
</button>
<!-- Testing State Simulator Triggers -->
<div class="h-6 w-[1px] bg-[#dce9df] mx-1 hidden sm:block"></div>
<button @click="toggleEmptyState" class="px-2.5 py-1.5 rounded-lg bg-[#f0f6f2] hover:bg-[#e4eee6] text-on-surface-variant text-label-sm font-label-sm flex items-center gap-1 border border-[#dce9df]" id="btnToggleEmpty" title="Uji Acceptance Criteria Bagian 16: Empty State">
<span class="material-symbols-outlined text-[16px] text-[#4CAF50]">hourglass_empty</span>
<span id="emptyBtnText">{{ isEmptyState ? 'Pulihkan Tampilan' : 'Simulasi Empty State' }}</span>
</button>
</div>
</div>
<!-- Empty State Alert Banner -->
<div :class="{'flex': isEmptyState, 'hidden': !isEmptyState}" class="flex-col items-center justify-center p-6 md:p-12 bg-surface-container-lowest rounded-xl border border-[#cfe0d4] shadow-sm text-center" id="emptyStateBanner">
<div class="w-16 h-16 rounded-full bg-[#ebf6ee] flex items-center justify-center text-[#4CAF50] mb-4 border border-[#cfe0d4]">
<span class="material-symbols-outlined text-[36px]">folder_off</span>
</div>
<h3 class="font-headline-md text-headline-md text-[#264332] mb-1">Belum Ada Data Ditemukan</h3>
<p class="font-body-md text-body-md text-on-surface-variant max-w-md mb-5">Tidak terdapat transaksi permohonan ataupun ketetapan SKP BPHTB pada filter kriteria yang dipilih.</p>
<button @click="toggleEmptyState" class="px-4 py-2 bg-[#4CAF50] text-white rounded-lg font-label-md text-label-md flex items-center gap-2 hover:bg-[#3d9140] transition-colors shadow-xs">
<span class="material-symbols-outlined text-[18px]">restart_alt</span>
      Kembalikan Tampilan Normal
    </button>
</div>
<!-- Loading State Overlay Modal (Simulasi SweetAlert2) -->
<div :class="{'flex': isLoading, 'hidden': !isLoading}" class="fixed inset-0 z-50 bg-[#264332]/30 backdrop-blur-xs items-center justify-center" id="loadingOverlay">
<div class="bg-surface-container-lowest p-6 rounded-2xl shadow-xl flex flex-col items-center max-w-sm mx-4 text-center border border-[#cfe0d4]">
<div class="w-12 h-12 rounded-full border-4 border-[#cfe0d4] border-t-[#4CAF50] animate-spin mb-4"></div>
<span class="font-headline-sm text-headline-sm text-[#264332] font-semibold">Sinkronisasi Data...</span>
<p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Mengambil transaksi SISMIOP PBB &amp; validasi host to host ATR/BPN terkini.</p>
</div>
</div>
<!-- Main Dashboard Content Grid Container -->
<div :class="{'hidden': isEmptyState}" class="flex flex-col gap-6" id="dashboardMainArea">
<!-- 2. KPI Summary Cards (3 Kolom Utama) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
<!-- Card 1: Permohonan Hari Ini -->
<div class="bg-surface-container-lowest rounded-xl p-card-padding shadow-xs border border-[#cfe0d4] flex flex-col justify-between relative overflow-hidden group hover:shadow-md hover:border-[#81c784] transition-all">

<div class="flex items-start justify-between">
<div class="flex items-center gap-3">
<div class="w-10 h-10 rounded-lg bg-[#ebf6ee] border border-[#cfe0d4] flex items-center justify-center text-[#4CAF50]">
<span class="material-symbols-outlined text-[24px]">today</span>
</div>
<div>
<span class="font-label-sm text-label-sm uppercase tracking-wider text-outline font-semibold">Statistik Harian</span>
<h2 class="font-headline-sm text-headline-sm text-[#264332] font-semibold">Permohonan Hari Ini</h2>
</div>
</div>
</div>
<div class="mt-5 flex items-baseline justify-between">
<div>
<div class="flex items-baseline gap-2">
<span class="font-display-lg text-display-lg text-[#264332] font-bold tracking-tight">{{ kpi.hariIni.berkas }}</span>
<span class="font-label-lg text-label-lg text-on-surface-variant">Berkas Masuk</span>
</div>
<p class="font-financial-tabular text-financial-tabular text-[#2e7d32] font-bold mt-1">{{ kpi.hariIni.nilai }}</p>
</div>
<div class="text-right">
<span class="font-body-sm text-body-sm text-outline block">Periode</span>
<span class="font-label-sm text-label-sm text-on-surface font-medium">{{ kpi.hariIni.tanggal }}</span>
</div>
</div>
</div>
<!-- Card 2: Permohonan Bulan Ini -->
<div class="bg-surface-container-lowest rounded-xl p-card-padding shadow-xs border border-[#cfe0d4] flex flex-col justify-between relative overflow-hidden group hover:shadow-md hover:border-[#81c784] transition-all">

<div class="flex items-start justify-between">
<div class="flex items-center gap-3">
<div class="w-10 h-10 rounded-lg bg-[#ebf6ee] border border-[#cfe0d4] flex items-center justify-center text-[#4CAF50]">
<span class="material-symbols-outlined text-[24px]">calendar_month</span>
</div>
<div>
<span class="font-label-sm text-label-sm uppercase tracking-wider text-outline font-semibold">Statistik Bulanan</span>
<h2 class="font-headline-sm text-headline-sm text-[#264332] font-semibold">Permohonan Bulan Ini</h2>
</div>
</div>
</div>
<div class="mt-5 flex items-baseline justify-between">
<div>
<div class="flex items-baseline gap-2">
<span class="font-display-lg text-display-lg text-[#264332] font-bold tracking-tight">{{ kpi.bulanIni.berkas }}</span>
<span class="font-label-lg text-label-lg text-on-surface-variant">Ketetapan Valid</span>
</div>
<p class="font-financial-tabular text-financial-tabular text-[#2e7d32] font-bold mt-1">{{ kpi.bulanIni.nilai }}</p>
</div>
<div class="text-right">
<span class="font-body-sm text-body-sm text-outline block">Bulan Berjalan</span>
<span class="font-label-sm text-label-sm text-on-surface font-medium">{{ kpi.bulanIni.bulan }}</span>
</div>
</div>
</div>
<!-- Card 3: Permohonan Tahun Ini -->
<div class="bg-surface-container-lowest rounded-xl p-card-padding shadow-xs border border-[#cfe0d4] flex flex-col justify-between relative overflow-hidden group hover:shadow-md hover:border-[#81c784] transition-all">

<div class="flex items-start justify-between">
<div class="flex items-center gap-3">
<div class="w-10 h-10 rounded-lg bg-[#ebf6ee] border border-[#cfe0d4] flex items-center justify-center text-[#4CAF50]">
<span class="material-symbols-outlined text-[24px]">account_balance_wallet</span>
</div>
<div>
<span class="font-label-sm text-label-sm uppercase tracking-wider text-outline font-semibold">Tahun Anggaran Berjalan</span>
<h2 class="font-headline-sm text-headline-sm text-[#264332] font-semibold">Permohonan Tahun Ini</h2>
</div>
</div>
</div>
<div class="mt-5 flex items-baseline justify-between">
<div>
<div class="flex items-baseline gap-2">
<span class="font-display-lg text-display-lg text-[#264332] font-bold tracking-tight">{{ kpi.tahunIni.berkas }}</span>
<span class="font-label-lg text-label-lg text-on-surface-variant">SSPD Terealisasi</span>
</div>
<p class="font-financial-tabular text-financial-tabular text-[#2e7d32] font-bold mt-1">{{ kpi.tahunIni.nilai }}</p>
</div>
<div class="text-right">
<span class="font-body-sm text-body-sm text-outline block">Tahun Fiskal</span>
<span class="font-label-sm text-label-sm text-on-surface font-medium">Tahun Anggaran {{ kpi.tahunIni.tahun }}</span>
</div>
</div>
</div>
</div>
<!-- 3. Charts Grid Row 1 (Target vs Realisasi Berjalan & 3 Tahun Terakhir) -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
<!-- Chart 1: Target vs Realisasi Tahun Berjalan (2026) -->
<div class="lg:col-span-7 bg-surface-container-lowest rounded-xl p-card-padding shadow-xs border border-[#cfe0d4] flex flex-col justify-between">
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-4">
<div>
<div class="flex items-center gap-2">
<h3 class="font-headline-sm text-headline-sm text-[#264332] font-semibold">Target vs Realisasi Tahun Berjalan (2026)</h3>
<span class="px-2 py-0.5 rounded text-label-sm font-label-sm bg-[#ebf6ee] text-[#2e7d32] border border-[#cfe0d4] font-medium">Bulanan</span>
</div>
<p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">Monitoring target APBD murni vs realisasi penerimaan kas daerah.</p>
</div>
<div class="flex items-center gap-3 bg-[#f0f6f2] border border-[#dce9df] px-3 py-1.5 rounded-lg text-label-sm font-label-sm">
<div class="flex items-center gap-1.5">
<span class="w-3 h-3 rounded bg-[#4CAF50]"></span>
<span class="text-on-surface">Realisasi</span>
</div>
<div class="flex items-center gap-1.5">
<span class="w-3 h-1 bg-[#8b9e90] rounded-full"></span>
<span class="text-outline">Target</span>
</div>
</div>
</div>
<!-- Target Metrics Banner -->
<div class="grid grid-cols-3 gap-2 py-3 px-4 bg-[#f0f6f2] border border-[#dce9df] rounded-xl mb-4 text-center">
<div>
<span class="font-label-sm text-label-sm text-outline uppercase block">Target APBD</span>
<span class="font-financial-tabular text-financial-tabular text-[#264332] font-bold">{{ targetTahunan.target }}</span>
</div>
<div>
<span class="font-label-sm text-label-sm text-outline uppercase block">Realisasi Kas</span>
<span class="font-financial-tabular text-financial-tabular text-[#2e7d32] font-bold">{{ targetTahunan.realisasi }}</span>
</div>
<div>
<span class="font-label-sm text-label-sm text-outline uppercase block">Pencapaian</span>
<span class="font-financial-tabular text-financial-tabular text-[#4CAF50] font-bold">{{ targetTahunan.persentase }}</span>
</div>
</div>
<!-- Bar/Line Visualization Vector SVG -->
<div class="relative w-full h-56 flex items-end justify-between pt-6 px-2">
<!-- Y-Axis Grid Lines -->
<div class="absolute inset-0 flex flex-col justify-between pointer-events-none opacity-40">
<div class="w-full h-[1px] bg-[#d3e0d6]"></div>
<div class="w-full h-[1px] bg-[#d3e0d6]"></div>
<div class="w-full h-[1px] bg-[#d3e0d6]"></div>
<div class="w-full h-[1px] bg-[#d3e0d6]"></div>
</div>
<!-- Monthly Bars (Jan - Des 2026) -->
<!-- Jan -->
<div class="flex flex-col items-center gap-1.5 z-10 w-1/12 group">
<div class="w-full flex items-end justify-center h-44 gap-1">
<div class="w-2.5 bg-[#d3e0d6] rounded-t h-[60%]" title="Target Jan: Rp 20,8M"></div>
<div class="w-2.5 bg-[#4CAF50] group-hover:bg-[#2e7d32] rounded-t h-[65%] transition-all" title="Realisasi Jan: Rp 22,4M"></div>
</div>
<span class="font-label-sm text-label-sm text-on-surface-variant">Jan</span>
</div>
<!-- Feb -->
<div class="flex flex-col items-center gap-1.5 z-10 w-1/12 group">
<div class="w-full flex items-end justify-center h-44 gap-1">
<div class="w-2.5 bg-[#d3e0d6] rounded-t h-[60%]" title="Target Feb: Rp 20,8M"></div>
<div class="w-2.5 bg-[#4CAF50] group-hover:bg-[#2e7d32] rounded-t h-[58%] transition-all" title="Realisasi Feb: Rp 19,9M"></div>
</div>
<span class="font-label-sm text-label-sm text-on-surface-variant">Feb</span>
</div>
<!-- Mar -->
<div class="flex flex-col items-center gap-1.5 z-10 w-1/12 group">
<div class="w-full flex items-end justify-center h-44 gap-1">
<div class="w-2.5 bg-[#d3e0d6] rounded-t h-[60%]" title="Target Mar: Rp 20,8M"></div>
<div class="w-2.5 bg-[#4CAF50] group-hover:bg-[#2e7d32] rounded-t h-[72%] transition-all" title="Realisasi Mar: Rp 24,1M"></div>
</div>
<span class="font-label-sm text-label-sm text-on-surface-variant">Mar</span>
</div>
<!-- Apr -->
<div class="flex flex-col items-center gap-1.5 z-10 w-1/12 group">
<div class="w-full flex items-end justify-center h-44 gap-1">
<div class="w-2.5 bg-[#d3e0d6] rounded-t h-[60%]" title="Target Apr: Rp 20,8M"></div>
<div class="w-2.5 bg-[#4CAF50] group-hover:bg-[#2e7d32] rounded-t h-[70%] transition-all" title="Realisasi Apr: Rp 23,8M"></div>
</div>
<span class="font-label-sm text-label-sm text-on-surface-variant">Apr</span>
</div>
<!-- Mei -->
<div class="flex flex-col items-center gap-1.5 z-10 w-1/12 group">
<div class="w-full flex items-end justify-center h-44 gap-1">
<div class="w-2.5 bg-[#d3e0d6] rounded-t h-[60%]" title="Target Mei: Rp 20,8M"></div>
<div class="w-2.5 bg-[#4CAF50] group-hover:bg-[#2e7d32] rounded-t h-[78%] transition-all" title="Realisasi Mei: Rp 26,5M"></div>
</div>
<span class="font-label-sm text-label-sm text-on-surface-variant">Mei</span>
</div>
<!-- Jun -->
<div class="flex flex-col items-center gap-1.5 z-10 w-1/12 group">
<div class="w-full flex items-end justify-center h-44 gap-1">
<div class="w-2.5 bg-[#d3e0d6] rounded-t h-[60%]" title="Target Jun: Rp 20,8M"></div>
<div class="w-2.5 bg-[#4CAF50] group-hover:bg-[#2e7d32] rounded-t h-[84%] transition-all" title="Realisasi Jun: Rp 28,3M"></div>
</div>
<span class="font-label-sm text-label-sm text-on-surface-variant">Jun</span>
</div>
<!-- Jul -->
<div class="flex flex-col items-center gap-1.5 z-10 w-1/12 group">
<div class="w-full flex items-end justify-center h-44 gap-1">
<div class="w-2.5 bg-[#d3e0d6] rounded-t h-[60%]" title="Target Jul: Rp 20,8M"></div>
<div class="w-2.5 bg-[#4CAF50] group-hover:bg-[#2e7d32] rounded-t h-[80%] transition-all" title="Realisasi Jul: Rp 27,1M"></div>
</div>
<span class="font-label-sm text-label-sm text-on-surface-variant">Jul</span>
</div>
<!-- Agu -->
<div class="flex flex-col items-center gap-1.5 z-10 w-1/12 group">
<div class="w-full flex items-end justify-center h-44 gap-1">
<div class="w-2.5 bg-[#d3e0d6] rounded-t h-[60%]" title="Target Agu: Rp 20,8M"></div>
<div class="w-2.5 bg-[#4CAF50] group-hover:bg-[#2e7d32] rounded-t h-[86%] transition-all" title="Realisasi Agu: Rp 28,7M"></div>
</div>
<span class="font-label-sm text-label-sm text-on-surface-variant">Agu</span>
</div>
<!-- Sep (Berjalan) -->
<div class="flex flex-col items-center gap-1.5 z-10 w-1/12 group">
<div class="w-full flex items-end justify-center h-44 gap-1">
<div class="w-2.5 bg-[#d3e0d6] rounded-t h-[60%]" title="Target Sep: Rp 20,8M"></div>
<div class="w-2.5 bg-[#81c784] rounded-t h-[45%] transition-all animate-pulse" title="Realisasi Sep (Berjalan): Rp 14,9M"></div>
</div>
<span class="font-label-sm text-label-sm text-[#2e7d32] font-bold">Sep*</span>
</div>
<!-- Okt -->
<div class="flex flex-col items-center gap-1.5 z-10 w-1/12 opacity-40">
<div class="w-full flex items-end justify-center h-44 gap-1">
<div class="w-2.5 bg-[#d3e0d6] rounded-t h-[60%]"></div>
<div class="w-2.5 bg-[#4CAF50]/30 rounded-t h-[0%]"></div>
</div>
<span class="font-label-sm text-label-sm text-on-surface-variant">Okt</span>
</div>
<!-- Nov -->
<div class="flex flex-col items-center gap-1.5 z-10 w-1/12 opacity-40">
<div class="w-full flex items-end justify-center h-44 gap-1">
<div class="w-2.5 bg-[#d3e0d6] rounded-t h-[60%]"></div>
<div class="w-2.5 bg-[#4CAF50]/30 rounded-t h-[0%]"></div>
</div>
<span class="font-label-sm text-label-sm text-on-surface-variant">Nov</span>
</div>
<!-- Des -->
<div class="flex flex-col items-center gap-1.5 z-10 w-1/12 opacity-40">
<div class="w-full flex items-end justify-center h-44 gap-1">
<div class="w-2.5 bg-[#d3e0d6] rounded-t h-[60%]"></div>
<div class="w-2.5 bg-[#4CAF50]/30 rounded-t h-[0%]"></div>
</div>
<span class="font-label-sm text-label-sm text-on-surface-variant">Des</span>
</div>
</div>
</div>
<!-- Chart 2: Target vs Realisasi 3 Tahun Terakhir (Historis) -->
<div class="lg:col-span-5 bg-surface-container-lowest rounded-xl p-card-padding shadow-xs border border-[#cfe0d4] flex flex-col justify-between">
<div class="flex items-center justify-between pb-2">
<div>
<h3 class="font-headline-sm text-headline-sm text-[#264332] font-semibold">Target vs Realisasi 3 Tahun</h3>
<p class="font-body-sm text-body-sm text-on-surface-variant">Pertumbuhan PAD BPHTB 2024 - 2026</p>
</div>
<span class="material-symbols-outlined text-[20px] text-outline">history</span>
</div>
<!-- Grouped Bar Comparison Chart -->
<div class="flex flex-col gap-5 my-auto py-2">
<!-- 2024 -->
<div class="flex flex-col gap-1.5">
<div class="flex justify-between items-center text-label-sm font-label-sm">
<span class="font-bold text-on-surface">Tahun 2024 (Lunas 102.6%)</span>
<span class="text-[#2e7d32] font-financial-tabular">Rp 195,0 M / Rp 190,0 M</span>
</div>
<div class="w-full h-3 bg-[#e6efe8] rounded-full overflow-hidden flex">
<div class="h-full bg-[#4CAF50]" style="width: 76%"></div>
<div class="h-full bg-[#81c784]" style="width: 26%"></div>
</div>
</div>
<!-- 2025 -->
<div class="flex flex-col gap-1.5">
<div class="flex justify-between items-center text-label-sm font-label-sm">
<span class="font-bold text-on-surface">Tahun 2025 (Lunas 103.6%)</span>
<span class="text-[#2e7d32] font-financial-tabular">Rp 228,0 M / Rp 220,0 M</span>
</div>
<div class="w-full h-3 bg-[#e6efe8] rounded-full overflow-hidden flex">
<div class="h-full bg-[#4CAF50]" style="width: 88%"></div>
<div class="h-full bg-[#81c784]" style="width: 15%"></div>
</div>
</div>
<!-- 2026 (Berjalan) -->
<div class="flex flex-col gap-1.5">
<div class="flex justify-between items-center text-label-sm font-label-sm">
<span class="font-bold text-[#264332]">Tahun 2026 (Progres 86.2%)</span>
<span class="text-[#2e7d32] font-financial-tabular">Rp 215,6 M / Rp 250,0 M</span>
</div>
<div class="w-full h-3 bg-[#e6efe8] rounded-full overflow-hidden flex">
<div class="h-full bg-[#4CAF50]" style="width: 86.2%"></div>
</div>
</div>
</div>
<div class="pt-3 border-t border-[#e0ece3] flex items-center justify-between text-label-sm font-label-sm">
<div class="flex items-center gap-2">
<span class="w-2.5 h-2.5 rounded bg-[#4CAF50]"></span>
<span class="text-on-surface-variant">Target Kuota APBD</span>
</div>
<div class="flex items-center gap-2">
<span class="w-2.5 h-2.5 rounded bg-[#81c784]"></span>
<span class="text-on-surface-variant">Surplus Realisasi Kas</span>
</div>
</div>
</div>
</div>
<!-- 4. Charts Grid Row 2 (Nilai per Kecamatan & Masuk vs Terbayar Donut) -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
<!-- Chart 3: Nilai Permohonan per Kecamatan (Horizontal Progress Bars) -->
<div class="lg:col-span-7 bg-surface-container-lowest rounded-xl p-card-padding shadow-xs border border-[#cfe0d4] flex flex-col justify-between">
<div class="flex items-center justify-between pb-3">
<div>
<h3 class="font-headline-sm text-headline-sm text-[#264332] font-semibold">Nilai Permohonan per Kecamatan</h3>
<p class="font-body-sm text-body-sm text-on-surface-variant">Distribusi volume berkas &amp; potensi penerimaan per wilayah</p>
</div>
<span class="px-2.5 py-1 rounded bg-[#ebf6ee] text-[#2e7d32] border border-[#cfe0d4] font-label-sm text-label-sm font-semibold">5 Kecamatan</span>
</div>
<div class="flex flex-col gap-4 py-2">
<div :key="index" class="flex flex-col gap-1" v-for="(item, index) in kecamatanList">
<div class="flex justify-between items-center text-label-sm font-label-sm">
<div class="flex items-center gap-2">
<span :class="[index === 0 ? 'bg-[#4CAF50] text-white' : index === 1 ? 'bg-[#5c8d67] text-white' : index === 2 ? 'bg-[#6ba378] text-white' : index === 3 ? 'bg-[#81c784] text-[#264332]' : 'bg-[#a5d6a7] text-[#264332]']" class="w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold">{{ item.rank }}</span>
<span class="font-semibold text-on-surface">{{ item.nama }}</span>
<span class="text-outline text-body-sm">({{ item.berkas }})</span>
</div>
<span class="font-financial-tabular text-financial-tabular text-[#2e7d32] font-bold">{{ item.nilai }}</span>
</div>
<div class="w-full h-2.5 bg-[#e6efe8] rounded-full overflow-hidden">
<div :class="[index === 0 ? 'bg-[#4CAF50]' : index === 1 ? 'bg-[#5c8d67]' : index === 2 ? 'bg-[#6ba378]' : index === 3 ? 'bg-[#81c784]' : 'bg-[#a5d6a7]']" :style="{ width: item.persen + '%' }" class="h-full rounded-full transition-all duration-500"></div>
</div>
</div>
</div>
</div>
<!-- Chart 4: Perbandingan Nilai Masuk vs Terbayar (Donut Chart & Status Breakdown) -->
<div class="lg:col-span-5 bg-surface-container-lowest rounded-xl p-card-padding shadow-xs border border-[#cfe0d4] flex flex-col justify-between">
<div class="flex items-center justify-between pb-2">
<div>
<h3 class="font-headline-sm text-headline-sm text-[#264332] font-semibold">Nilai Masuk vs Terbayar</h3>
<p class="font-body-sm text-body-sm text-on-surface-variant">Rasio realisasi pembayaran &amp; outstanding</p>
</div>
<span class="material-symbols-outlined text-[20px] text-[#4CAF50]">pie_chart</span>
</div>
<div class="flex flex-col sm:flex-row items-center gap-6 my-2">
<!-- Donut SVG Diagram -->
<div class="relative w-36 h-36 flex-shrink-0 flex items-center justify-center">
<svg class="w-full h-full -rotate-90" viewbox="0 0 36 36">
<!-- Background Circle -->
<path class="text-[#e6efe8]" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="4.5"></path>
<!-- Segment 1: Terbayar (82.5%) - Primary #4CAF50 -->
<path class="text-[#4CAF50]" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-dasharray="82.5, 100" stroke-width="4.5"></path>
<!-- Segment 2: Proses Validasi (14.7%) - Muted Sage/Teal #81c784 -->
<path class="text-[#81c784]" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-dasharray="14.7, 100" stroke-dashoffset="-82.5" stroke-width="4.5"></path>
</svg>
<div class="absolute flex flex-col items-center justify-center text-center">
<span class="font-headline-sm text-headline-sm text-[#264332] font-bold">82.5%</span>
<span class="font-label-sm text-label-sm text-outline">Terbayar</span>
</div>
</div>
<!-- Breakdown List -->
<div class="flex flex-col gap-2.5 w-full">
<div class="flex items-center justify-between text-label-sm font-label-sm p-2 rounded-lg bg-[#f0f6f2] border border-[#dce9df]">
<div class="flex items-center gap-2">
<span class="w-2.5 h-2.5 rounded-full bg-[#4CAF50]"></span>
<span class="text-on-surface">Lunas / Terbayar</span>
</div>
<span class="font-financial-tabular text-[#2e7d32] font-bold">Rp 215,60 M</span>
</div>
<div class="flex items-center justify-between text-label-sm font-label-sm p-2 rounded-lg bg-[#f0f6f2] border border-[#dce9df]">
<div class="flex items-center gap-2">
<span class="w-2.5 h-2.5 rounded-full bg-[#81c784]"></span>
<span class="text-on-surface">Verifikasi / Proses</span>
</div>
<span class="font-financial-tabular text-[#264332] font-bold">Rp 38,40 M</span>
</div>
<div class="flex items-center justify-between text-label-sm font-label-sm p-2 rounded-lg bg-[#f0f6f2] border border-[#dce9df]">
<div class="flex items-center gap-2">
<span class="w-2.5 h-2.5 rounded-full bg-[#e57373]"></span>
<span class="text-on-surface">Koreksi / Ditolak</span>
</div>
<span class="font-financial-tabular text-[#c62828] font-bold">Rp 7,30 M</span>
</div>
</div>
</div>
<div class="pt-3 border-t border-[#e0ece3] flex items-center justify-between text-body-sm font-body-sm text-on-surface-variant">
<span>Rata-rata Waktu Verifikasi:</span>
<span class="font-label-md text-label-md text-[#2e7d32] font-semibold">1.8 Hari Kerja</span>
</div>
</div>
</div>
<!-- 5. Peta Persebaran Permohonan BPHTB (Map Leaflet Container) -->
<div class="bg-surface-container-lowest rounded-xl p-card-padding shadow-xs border border-[#cfe0d4] flex flex-col gap-4">
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
<div>
<div class="flex items-center gap-2">
<h3 class="font-headline-sm text-headline-sm text-[#264332] font-semibold">Peta Persebaran Permohonan BPHTB</h3>
<span class="px-2 py-0.5 rounded text-label-sm font-label-sm bg-[#ebf6ee] text-[#2e7d32] border border-[#cfe0d4] font-semibold">GIS Spasial</span>
</div>
<p class="font-body-sm text-body-sm text-on-surface-variant">Distribusi koordinat permohonan validasi hak tanah dan bangunan</p>
</div>
<!-- Map Layer Toggles -->
<div class="flex items-center gap-2">
<div class="flex items-center gap-1 bg-[#f0f6f2] border border-[#dce9df] p-1 rounded-lg text-label-sm font-label-sm">
<button :class="[filterMapActive === 'all' ? 'bg-surface-container-lowest text-[#2e7d32] border border-[#cfe0d4] rounded shadow-xs font-semibold' : 'text-on-surface-variant hover:text-on-surface']" @click="setMapFilter('all')" class="px-2.5 py-1">Semua (128 Titik)</button>
<button :class="[filterMapActive === 'lunas' ? 'bg-surface-container-lowest text-[#2e7d32] border border-[#cfe0d4] rounded shadow-xs font-semibold' : 'text-on-surface-variant hover:text-on-surface']" @click="setMapFilter('lunas')" class="px-2.5 py-1">Lunas</button>
<button :class="[filterMapActive === 'verifikasi' ? 'bg-surface-container-lowest text-[#2e7d32] border border-[#cfe0d4] rounded shadow-xs font-semibold' : 'text-on-surface-variant hover:text-on-surface']" @click="setMapFilter('verifikasi')" class="px-2.5 py-1">Verifikasi</button>
</div>
<button class="p-1.5 bg-[#f0f6f2] hover:bg-[#e4eee6] text-[#2e7d32] border border-[#dce9df] rounded-lg transition-colors" title="Fullscreen Peta">
<span class="material-symbols-outlined text-[18px]">fullscreen</span>
</button>
</div>
</div>
<!-- Map Interactive Canvas Simulator with Spatial UI -->
<div class="relative w-full h-[380px] rounded-xl overflow-hidden bg-surface-container border border-[#cfe0d4] flex items-center justify-center group" data-location="Malang, Jawa Timur, Indonesia" style="">
<!-- Background Satellite / Cartographic Map Render -->
<div class="absolute inset-0 bg-cover bg-center opacity-85" data-alt="High quality aerial cartographic GIS city map view of Malang Indonesia with zoning districts, streets, parcel boundaries, institutional navy blue and teal overlay accents, clean and modern cadastral tax map." style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuATQpBit58PUeR66MChMIvtjN2srLuU9IjqkjvPsQM8CR2O5Ly23jzSZM4uWE8koxx58e5BnSQAn9GS1ySE3YiXP2ZQhADXwA3ZnIb1G8pCKrmO-1YRDbBjgfCTF3zLCff-IBgohxHajJdAagxaNHQOpmBqwOmyIJfxtu-F6eBOVWNJlbRZm6Zc3_IQULyguWvtnF2Ysq1gxzkjtFQZbm55ibfpM9r_AEhdshs_OUxmT5yTt-Jitjte')"></div>
<div class="absolute inset-0 bg-[#4CAF50]/10 backdrop-blur-[0.5px]"></div>
<!-- Geographical Street Grid Overlay -->
<svg class="absolute inset-0 w-full h-full pointer-events-none opacity-20" xmlns="http://www.w3.org/2000/svg">
<defs>
<pattern height="60" id="grid" patternunits="userSpaceOnUse" width="60">
<path d="M 60 0 L 0 0 0 60" fill="none" stroke="#4CAF50" stroke-width="0.75"></path>
</pattern>
</defs>
<rect fill="url(#grid)" height="100%" width="100%"></rect>
</svg>
<!-- Map Controls (Leaflet Style) -->
<div class="absolute top-4 left-4 z-20 flex flex-col bg-surface-container-lowest rounded-lg shadow-sm border border-[#cfe0d4] overflow-hidden">
<button class="w-8 h-8 flex items-center justify-center text-on-surface hover:bg-[#ebf6ee] transition-colors border-b border-[#cfe0d4]">
<span class="material-symbols-outlined text-[18px]">add</span>
</button>
<button class="w-8 h-8 flex items-center justify-center text-on-surface hover:bg-[#ebf6ee] transition-colors">
<span class="material-symbols-outlined text-[18px]">remove</span>
</button>
</div>
<!-- Spatial Marker 1 (Lowokwaru - Active Popup) -->
<div class="absolute top-1/3 left-1/3 z-20 -translate-x-1/2 -translate-y-1/2 cursor-pointer flex flex-col items-center">
<div class="relative">
<div class="w-7 h-7 rounded-full bg-[#4CAF50] text-white flex items-center justify-center shadow-md ring-4 ring-[#4CAF50]/30">
<span class="material-symbols-outlined text-[16px]">check_circle</span>
</div>
<div class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-2 h-2 bg-[#4CAF50] rotate-45"></div>
</div>
<span class="mt-1 px-2 py-0.5 rounded bg-surface-container-lowest/95 border border-[#cfe0d4] text-[#264332] text-[10px] font-bold shadow-xs">Lowokwaru</span>
</div>
<!-- Spatial Marker 2 (Blimbing - Pending) -->
<div class="absolute top-1/4 right-1/3 z-20 cursor-pointer flex flex-col items-center">
<div class="w-6 h-6 rounded-full bg-[#5c8d67] text-white flex items-center justify-center shadow-md ring-4 ring-[#5c8d67]/30">
<span class="material-symbols-outlined text-[14px]">hourglass_top</span>
</div>
<span class="mt-1 px-1.5 py-0.5 rounded bg-surface-container-lowest/95 border border-[#cfe0d4] text-[#264332] text-[10px] font-medium shadow-xs">Blimbing</span>
</div>
<!-- Spatial Marker 3 (Sukun - Process) -->
<div class="absolute bottom-1/4 left-1/4 z-20 cursor-pointer flex flex-col items-center">
<div class="w-6 h-6 rounded-full bg-[#4CAF50] text-white flex items-center justify-center shadow-md ring-4 ring-[#4CAF50]/30">
<span class="material-symbols-outlined text-[14px]">check</span>
</div>
<span class="mt-1 px-1.5 py-0.5 rounded bg-surface-container-lowest/95 border border-[#cfe0d4] text-[#264332] text-[10px] font-medium shadow-xs">Sukun</span>
</div>
<!-- Floating Card Info Popup: NOP Terpilih (Sesuai Spesifikasi PRD Bagian 13) -->
<div class="absolute bottom-4 right-4 z-30 max-w-sm w-full bg-surface-container-lowest/95 backdrop-blur-md p-4 rounded-xl shadow-lg border border-[#cfe0d4] transition-all">
<div class="flex items-start justify-between gap-2 pb-2 border-b border-[#e0ece3]">
<div>
<span class="font-label-sm text-label-sm uppercase tracking-wider text-outline font-semibold">Detail NOP Terpilih</span>
<div class="font-financial-tabular text-financial-tabular text-[#264332] font-bold">{{ selectedNop.nop }}</div>
</div>
<span class="px-2 py-0.5 rounded-full text-label-sm font-label-sm bg-[#ebf6ee] text-[#2e7d32] border border-[#cfe0d4] font-semibold">
              {{ selectedNop.status }}
            </span>
</div>
<div class="grid grid-cols-2 gap-2 py-2.5 text-body-sm font-body-sm">
<div>
<span class="text-outline text-label-sm block">Pemohon:</span>
<span class="font-medium text-[#264332]">{{ selectedNop.pemohon }}</span>
</div>
<div>
<span class="text-outline text-label-sm block">PPAT / Notaris:</span>
<span class="font-medium text-[#264332] truncate block">{{ selectedNop.notaris }}</span>
</div>
<div>
<span class="text-outline text-label-sm block">Nilai Transaksi:</span>
<span class="font-financial-tabular text-financial-tabular text-[#264332] font-semibold">{{ selectedNop.nilaiTransaksi }}</span>
</div>
<div>
<span class="text-outline text-label-sm block">Nilai BPHTB:</span>
<span class="font-financial-tabular text-financial-tabular text-[#2e7d32] font-bold">{{ selectedNop.nilaiBphtb }}</span>
</div>
</div>
<div class="pt-2 flex items-center justify-between text-label-sm font-label-sm border-t border-[#e0ece3]">
<span class="text-on-surface-variant flex items-center gap-1">
<span class="material-symbols-outlined text-[16px] text-[#4CAF50]">pin_drop</span>
              {{ selectedNop.kecamatan }}
            </span>
<button class="text-[#2e7d32] hover:text-[#4CAF50] hover:underline font-semibold flex items-center gap-0.5">
              Lihat Detail SSPD
              <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
</button>
</div>
</div>
<!-- Map Legend in Left Bottom -->
<div class="absolute bottom-4 left-4 z-20 bg-surface-container-lowest/95 backdrop-blur-sm px-3 py-2 rounded-lg shadow-sm border border-[#cfe0d4] flex flex-col gap-1.5 text-label-sm font-label-sm">
<span class="font-semibold text-[#264332] text-[11px] uppercase tracking-wider">Status Berkas</span>
<div class="flex items-center gap-2">
<span class="w-2.5 h-2.5 rounded-full bg-[#4CAF50]"></span>
<span class="text-on-surface-variant">Lunas (82)</span>
</div>
<div class="flex items-center gap-2">
<span class="w-2.5 h-2.5 rounded-full bg-[#81c784]"></span>
<span class="text-on-surface-variant">Verifikasi (34)</span>
</div>
<div class="flex items-center gap-2">
<span class="w-2.5 h-2.5 rounded-full bg-[#e57373]"></span>
<span class="text-on-surface-variant">Koreksi (12)</span>
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
  name: 'Dashboard',
  data() {
    return {
      selectedKecamatan: 'all',
      selectedTahun: '2026',
      dateRange: '01 Jan 2026 - 31 Des 2026',
      isEmptyState: false,
      isLoading: false,
      filterMapActive: 'all',
      kpi: {
        hariIni: { berkas: 28, nilai: 'Rp 1,42 Miliar', tanggal: '09 September 2026' },
        bulanIni: { berkas: 462, nilai: 'Rp 24,85 Miliar', bulan: 'September 2026' },
        tahunIni: { berkas: '4.820', nilai: 'Rp 215,60 Miliar', tahun: '2026' }
      },
      targetTahunan: {
        target: 'Rp 250,00 M',
        realisasi: 'Rp 215,60 M',
        persentase: '86,24%'
      },
      kecamatanList: [
        { rank: 1, nama: 'Kec. Lowokwaru', berkas: '1.420 Berkas', nilai: 'Rp 74,5 Miliar', persen: 100 },
        { rank: 2, nama: 'Kec. Klojen', berkas: '1.180 Berkas', nilai: 'Rp 58,2 Miliar', persen: 78 },
        { rank: 3, nama: 'Kec. Blimbing', berkas: '960 Berkas', nilai: 'Rp 42,6 Miliar', persen: 57 },
        { rank: 4, nama: 'Kec. Sukun', berkas: '740 Berkas', nilai: 'Rp 25,1 Miliar', persen: 34 },
        { rank: 5, nama: 'Kec. Kedungkandang', berkas: '520 Berkas', nilai: 'Rp 15,2 Miliar', persen: 20 }
      ],
      selectedNop: {
        nop: '35.73.010.005.012-0045.0',
        status: 'Terbayar (Lunas)',
        pemohon: 'PT Graha Sentosa Mulia',
        notaris: 'Siti Rahmawati, S.H.',
        nilaiTransaksi: 'Rp 3.850.000.000',
        nilaiBphtb: 'Rp 182.500.000',
        kecamatan: 'Kec. Lowokwaru'
      }
    };
  },
  mounted() {
    this.initCharts();
    this.initMap();
  },
  methods: {
    applyFilter() {
      this.simulateDataLoad();
    },
    simulateDataLoad() {
      this.isLoading = true;
      setTimeout(() => {
        this.isLoading = false;
      }, 650);
    },
    toggleEmptyState() {
      this.isEmptyState = !this.isEmptyState;
    },
    resetDashboardState() {
      this.selectedKecamatan = 'all';
      this.selectedTahun = '2026';
      this.isEmptyState = false;
      this.simulateDataLoad();
    },
    setMapFilter(filter) {
      this.filterMapActive = filter;
    },
    initCharts() {
      // Chart container initialization ready for Chart.js
    },
    initMap() {
      // Leaflet GIS Map spatial initialization ready
    }
  }
};
</script>
<style scoped>
/* Specific styling if needed */
</style>