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
        <div class="flex items-center gap-4 bg-white border border-slate-200 rounded-xl p-3 shadow-sm" v-if="hasData">
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
        <!-- Card 1: Identitas Pendaftaran & Form Pencarian -->
        <div class="w-full bg-white rounded-xl border border-slate-200 shadow-xs overflow-hidden">
          <div class="px-6 py-3.5 bg-slate-50/80 border-b border-slate-200 flex items-center justify-between gap-2">
            <div class="flex items-center gap-2">
              <span class="material-symbols-outlined text-[#4CAF50] text-[20px]">assignment</span>
              <span class="text-[14px] text-slate-900 font-bold">Identitas Pendaftaran &amp; Objek Pajak</span>
            </div>
          </div>
          
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 p-6">
            <!-- Form Input Nomor Pelayanan dengan Tombol Cari di dalam Input -->
            <div class="flex flex-col gap-1.5">
              <label class="text-[11.5px] font-semibold text-slate-500 uppercase tracking-wider">Nomor Pelayanan</label>
              <div class="relative flex items-center mt-0.5">
                <input 
                  type="text" 
                  v-model="searchNoPelayanan" 
                  @keyup.enter="cariNoPelayanan" 
                  placeholder="Contoh: 2026.09.0001" 
                  class="w-full pl-3.5 pr-11 py-2 bg-slate-50 focus:bg-white border border-slate-300 rounded-lg text-[13.5px] font-mono font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#4CAF50] focus:border-transparent transition-all shadow-2xs"
                />
                <button 
                  type="button" 
                  @click="cariNoPelayanan" 
                  :disabled="isLoading"
                  class="absolute right-1.5 p-1.5 rounded-md bg-[#4CAF50] hover:bg-[#43A047] active:scale-95 text-white transition-all flex items-center justify-center disabled:opacity-50 shadow-2xs"
                  title="Cari Nomor Pelayanan"
                >
                  <span class="material-symbols-outlined text-[18px]" :class="{ 'animate-spin': isLoading }">
                    {{ isLoading ? 'refresh' : 'search' }}
                  </span>
                </button>
              </div>
              <span class="text-[11px] text-slate-400">Tekan Enter atau klik tombol cari</span>
            </div>

            <!-- NOP PBB -->
            <div class="flex flex-col justify-center">
              <span class="text-[11.5px] font-semibold text-slate-400 uppercase tracking-wider">NOP PBB</span>
              <span class="font-mono text-[14px] font-bold text-emerald-700 mt-1">{{ formattedNop }}</span>
            </div>

            <!-- Jenis Perolehan Hak -->
            <div class="flex flex-col justify-center">
              <span class="text-[11.5px] font-semibold text-slate-400 uppercase tracking-wider">Jenis Perolehan Hak</span>
              <span class="text-[14px] font-bold text-slate-900 mt-1 truncate">{{ pendaftaran.jenisPerolehan || '-' }}</span>
            </div>

            <!-- Nama Wajib Pajak (Pemohon) -->
            <div class="flex flex-col justify-center">
              <span class="text-[11.5px] font-semibold text-slate-400 uppercase tracking-wider">Nama Wajib Pajak (Pemohon)</span>
              <span class="text-[14px] font-semibold text-slate-800 mt-1 truncate">{{ pendaftaran.namaWajibPajak || '-' }}</span>
            </div>

            <!-- Tanggal Pendaftaran -->
            <div class="flex flex-col justify-center lg:col-span-1">
              <span class="text-[11.5px] font-semibold text-slate-400 uppercase tracking-wider">Tanggal Pendaftaran</span>
              <span class="text-[14px] text-slate-800 mt-1 font-medium">{{ pendaftaran.tanggalPendaftaran || '-' }}</span>
            </div>
          </div>
        </div>

        <!-- Empty State Prompt when no data searched yet -->
        <div v-if="!hasData && !isLoading" class="w-full bg-slate-50 border-2 border-dashed border-slate-200 rounded-xl p-10 flex flex-col items-center justify-center text-center gap-3">
          <div class="w-14 h-14 rounded-full bg-emerald-50 text-[#4CAF50] flex items-center justify-center border border-emerald-200 shadow-2xs">
            <span class="material-symbols-outlined text-[32px]">manage_search</span>
          </div>
          <h3 class="text-base font-bold text-slate-800">Cari Data Pendaftaran BPHTB</h3>
          <p class="text-xs text-slate-500 max-w-md">
            Masukkan Nomor Pelayanan (misal: <strong class="text-slate-700 font-mono">2026.09.0001</strong>) pada form pencarian di atas untuk menampilkan detail permohonan dan kelengkapan dokumen persyaratan.
          </p>
        </div>

        <!-- Content Area when data is loaded -->
        <template v-if="hasData">
          <!-- Summary Kelengkapan Berkas Banner -->
          <div class="w-full bg-[#f0fdf4] border border-[#bbf7d0] rounded-xl p-6 shadow-xs flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
              <div class="w-12 h-12 rounded-xl bg-[#4CAF50] text-white flex items-center justify-center shrink-0 shadow-xs">
                <span class="material-symbols-outlined text-[26px]">fact_check</span>
              </div>
              <div class="flex flex-col gap-1">
                <div class="flex items-center gap-2.5">
                  <h2 class="text-[17px] font-bold text-[#166534]">{{ uploadedCount }} dari {{ totalCount }} Persyaratan Telah Diupload</h2>
                </div>
                <p class="text-[13.5px] text-[#166534]/90">
                  <template v-if="pendingCount > 0">
                    Berkas permohonan masih memerlukan <strong class="text-amber-800 underline decoration-amber-400">{{ pendingCount }} dokumen legal</strong> tambahan agar proses penetapan SKPD-BPHTB dapat diajukan.
                  </template>
                  <template v-else>
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
                        <span class="material-symbols-outlined text-[22px]">{{ item.icon || 'description' }}</span>
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
                          <span class="bg-amber-50 border border-amber-200 text-amber-800 px-2.5 py-0.5 rounded-full text-[11px] font-semibold flex items-center gap-1" v-else>
                            <span class="material-symbols-outlined text-[14px]">error</span> Belum Terupload
                          </span>
                        </div>
                        <span class="text-[12px] text-slate-500">{{ item.formatInfo }}</span>
                        <!-- Detail berkas jika terupload (Ukuran & Tanggal Upload) -->
                        <div class="flex flex-wrap items-center gap-3 mt-1.5 text-[12px]" v-if="item.status === 'uploaded'">
                          <span class="font-mono font-semibold text-slate-700 bg-slate-100 border border-slate-200 px-2 py-0.5 rounded text-[11px]" v-if="item.filesize">
                            Ukuran: {{ item.filesize }}
                          </span>
                          <span class="text-slate-500 flex items-center gap-1" v-if="item.uploadedDate">
                            <span class="material-symbols-outlined text-[15px] text-slate-400">schedule</span>
                            Diupload pada {{ item.uploadedDate }}
                          </span>
                        </div>
                      </div>
                    </div>

                    <!-- Actions per Document Row -->
                    <div class="flex items-center gap-2 self-end lg:self-center">
                      <template v-if="item.status === 'uploaded'">
                        <button @click="openDocPreview(item)" class="px-3.5 py-1.5 rounded-lg bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-[12.5px] font-semibold flex items-center gap-1.5 shadow-xs transition-colors" type="button" title="Lihat Preview Berkas">
                          <span class="material-symbols-outlined text-[17px] text-slate-500">visibility</span> Preview
                        </button>
                        <button @click="downloadDocFile(item)" class="p-1.5 rounded-lg text-slate-600 hover:text-emerald-700 hover:bg-emerald-50 transition-colors border border-transparent hover:border-emerald-200" title="Unduh Berkas" type="button">
                          <span class="material-symbols-outlined text-[19px]">download</span>
                        </button>
                        <button @click="triggerReupload(item)" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-colors border border-transparent hover:border-slate-200" title="Ganti File (Re-upload)" type="button">
                          <span class="material-symbols-outlined text-[19px]">sync</span>
                        </button>
                        <button @click="removeDocumentFile(item)" class="p-1.5 rounded-lg text-rose-600 hover:bg-rose-50 transition-colors border border-transparent hover:border-rose-200" title="Hapus Berkas" type="button">
                          <span class="material-symbols-outlined text-[19px]">delete</span>
                        </button>
                      </template>
                      <template v-else>
                        <button @click="selectDocumentForUpload(item)" class="px-4 py-2 rounded-lg bg-[#4CAF50] hover:bg-[#43A047] text-white text-[13px] font-bold flex items-center gap-1.5 shadow-xs transition-all hover:scale-[1.02]" type="button">
                          <span class="material-symbols-outlined text-[18px]">cloud_upload</span> Upload Berkas
                        </button>
                      </template>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Right: Dropzone Container & Upload Manager (Spans 4 cols) -->
            <div class="xl:col-span-4 flex flex-col gap-6">
              <!-- Interactive Dropzone Component -->
              <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-xs flex flex-col gap-4" id="dropzone-box">
                <div class="flex items-center justify-between gap-2">
                  <div class="flex items-center gap-2 min-w-0">
                    <span class="material-symbols-outlined text-[#4CAF50] text-[20px]">upload_file</span>
                    <h3 class="text-[14px] font-bold text-slate-900 truncate">Unggah Berkas</h3>
                  </div>
                  <span class="text-[11px] px-2.5 py-0.5 rounded bg-emerald-50 text-emerald-800 font-semibold border border-emerald-200 truncate max-w-[150px]">
                    {{ currentTargetDoc ? currentTargetDoc.targetLabel : 'Pilih Dokumen' }}
                  </span>
                </div>

                <!-- Drag and Drop Canvas Area -->
                <div 
                  :class="{ 'border-[#4CAF50] bg-emerald-50/50': isDragging }" 
                  @dragleave.prevent="isDragging = false" 
                  @dragover.prevent="isDragging = true" 
                  @drop.prevent="handleFileDrop" 
                  @click="openFilePicker"
                  class="relative group cursor-pointer bg-slate-50 hover:bg-slate-100/80 border-2 border-dashed border-slate-200 hover:border-[#4CAF50] transition-all duration-200 rounded-xl p-8 flex flex-col items-center justify-center text-center"
                >
                  <input 
                    type="file" 
                    ref="fileInputRef" 
                    @change="handleFileInput" 
                    accept=".pdf,.jpg,.jpeg,.png" 
                    class="hidden" 
                    id="file-input-element"
                  />
                  <div class="w-14 h-14 rounded-full bg-emerald-50 border border-emerald-200 flex items-center justify-center text-[#4CAF50] group-hover:scale-110 group-hover:bg-[#4CAF50] group-hover:text-white transition-all duration-200 mb-3 shadow-xs">
                    <span class="material-symbols-outlined text-[30px]">cloud_upload</span>
                  </div>
                  <p class="text-[13.5px] font-bold text-slate-800">
                    Tarik berkas ke sini atau <span class="text-[#4CAF50] underline">Pilih Berkas</span>
                  </p>
                  <p class="text-[11.5px] text-slate-500 mt-1">
                    Mendukung format PDF, JPG, PNG (Maksimal 5MB per berkas)
                  </p>
                  <div class="flex items-center gap-2 mt-4 px-3 py-1 bg-white border border-slate-200 rounded-full text-slate-600 text-[11px] font-medium shadow-2xs">
                    <span class="material-symbols-outlined text-[15px] text-emerald-600">security</span>
                    <span>Enkripsi Host-to-Host Aktif</span>
                  </div>
                </div>

                <!-- Dynamic Upload Progress Bar -->
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
            </div>
          </div>
        </template>
      </div>
    </div>

    <!-- Document Preview Modal -->
    <div @click.self="closeDocPreview" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4" v-if="previewModalOpen">
      <div class="bg-white rounded-2xl w-full max-w-4xl max-h-[92vh] flex flex-col shadow-2xl border border-slate-200 overflow-hidden">
        <!-- Modal Header Toolbar -->
        <div class="p-4 bg-slate-50 border-b border-slate-200 flex flex-wrap items-center justify-between gap-3">
          <div class="flex items-center gap-3 min-w-0">
            <div class="w-9 h-9 rounded-lg bg-emerald-50 border border-emerald-200 text-[#4CAF50] flex items-center justify-center shrink-0">
              <span class="material-symbols-outlined text-[20px]">description</span>
            </div>
            <div class="flex flex-col min-w-0">
              <span class="text-[11px] text-slate-500 font-medium">Preview Dokumen Terupload</span>
              <span class="text-[14px] font-bold text-slate-900 truncate">{{ currentPreviewDoc ? currentPreviewDoc.nama : '' }}</span>
            </div>
          </div>
          
          <div class="flex items-center gap-2">
            <!-- Zoom Toolbar for Image Preview -->
            <div v-if="!isPdfPreview" class="flex items-center bg-white border border-slate-200 rounded-lg p-0.5 shadow-2xs">
              <button 
                @click="zoomOut" 
                :disabled="zoomLevel <= 0.5" 
                class="p-1.5 hover:bg-slate-100 disabled:opacity-30 rounded text-slate-700 transition-colors flex items-center justify-center" 
                title="Perkecil (Zoom Out)" 
                type="button"
              >
                <span class="material-symbols-outlined text-[18px]">zoom_out</span>
              </button>
              <span class="font-mono text-[12px] font-bold px-2 text-slate-800 min-w-[45px] text-center select-none">
                {{ Math.round(zoomLevel * 100) }}%
              </span>
              <button 
                @click="zoomIn" 
                :disabled="zoomLevel >= 3.0" 
                class="p-1.5 hover:bg-slate-100 disabled:opacity-30 rounded text-slate-700 transition-colors flex items-center justify-center" 
                title="Perbesar (Zoom In)" 
                type="button"
              >
                <span class="material-symbols-outlined text-[18px]">zoom_in</span>
              </button>
              <button 
                @click="resetZoom" 
                v-if="zoomLevel !== 1.0"
                class="p-1.5 hover:bg-slate-100 rounded text-slate-500 hover:text-slate-800 transition-colors flex items-center justify-center ml-0.5 border-l border-slate-200" 
                title="Reset Ukuran (100%)" 
                type="button"
              >
                <span class="material-symbols-outlined text-[18px]">restart_alt</span>
              </button>
            </div>

            <button @click="downloadDocFile(currentPreviewDoc)" class="px-3 py-1.5 rounded-lg bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-[12.5px] font-semibold flex items-center gap-1.5 shadow-2xs transition-colors" title="Unduh Berkas" type="button">
              <span class="material-symbols-outlined text-[18px]">download</span> Unduh
            </button>
            <button @click="closeDocPreview" class="p-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors" title="Tutup" type="button">
              <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
          </div>
        </div>

        <!-- Modal Body Preview Viewer -->
        <div 
          @wheel.prevent="handleWheelZoom"
          class="flex-1 overflow-auto bg-slate-900 min-h-[500px] relative flex p-2"
        >
          <template v-if="previewUrl">
            <iframe 
              v-if="isPdfPreview" 
              :src="previewUrl" 
              class="w-full h-[650px] border-0 rounded-lg bg-white"
            ></iframe>
            <div 
              v-else 
              :class="zoomLevel > 1.0 ? 'items-start justify-start p-8' : 'items-center justify-center p-4'"
              class="w-full min-h-[600px] overflow-auto flex m-auto transition-all duration-200"
            >
              <div class="relative max-w-full flex items-center justify-center m-auto">
                <img 
                  :src="previewUrl" 
                  :style="imageZoomStyle" 
                  class="rounded-lg shadow-2xl transition-all duration-150" 
                  alt="Preview Dokumen"
                />
              </div>
            </div>
          </template>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
import Swal from 'sweetalert2';
import axios from 'axios';

export default {
  name: 'UploadPersyaratan',
  data() {
    return {
      searchNoPelayanan: '',
      isLoading: false,
      hasData: false,
      pendaftaran: {
        nomorPelayanan: '',
        nopPbb: '',
        plyKode: '',
        jenisPerolehan: '',
        namaWajibPajak: '',
        tanggalPendaftaran: ''
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
      previewUrl: '',
      isPdfPreview: false,
      zoomLevel: 1.0,
      dokumenList: []
    };
  },
  computed: {
    imageZoomStyle() {
      if (this.zoomLevel === 1.0) {
        return {
          maxWidth: '100%',
          maxHeight: '580px',
          objectFit: 'contain'
        };
      }
      return {
        width: `${Math.round(this.zoomLevel * 100)}%`,
        maxWidth: 'none',
        maxHeight: 'none',
        height: 'auto'
      };
    },
    formattedNop() {
      if (!this.pendaftaran.nopPbb) return '-';
      const clean = this.pendaftaran.nopPbb.replace(/\D/g, '');
      if (clean.length !== 18) return this.pendaftaran.nopPbb;
      return `${clean.substr(0,2)}.${clean.substr(2,2)}.${clean.substr(4,3)}.${clean.substr(7,3)}.${clean.substr(10,3)}-${clean.substr(13,4)}.${clean.substr(17,1)}`;
    },
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
      if (this.totalCount === 0) return 0;
      return Math.round((this.uploadedCount / this.totalCount) * 100);
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

    const queryNoPelayanan = this.$route.query.no_pelayanan;
    if (queryNoPelayanan) {
      this.searchNoPelayanan = queryNoPelayanan;
      this.cariNoPelayanan();
    }
  },
  methods: {
    cariNoPelayanan() {
      if (!this.searchNoPelayanan || !this.searchNoPelayanan.trim()) {
        Swal.fire({
          icon: 'warning',
          title: 'Nomor Pelayanan Kosong',
          text: 'Masukkan Nomor Pelayanan untuk melakukan pencarian.'
        });
        return;
      }

      const noPel = this.searchNoPelayanan.trim();
      this.isLoading = true;

      axios.get('/api/v1/persyaratan/detail', { params: { no_pelayanan: noPel } })
        .then(res => {
          this.isLoading = false;
          if (res.data && res.data.status === 'success') {
            const data = res.data.data;
            this.pendaftaran.nomorPelayanan = data.pendaftaran.no_pelayanan;
            this.pendaftaran.nopPbb = data.pendaftaran.nop;
            this.pendaftaran.plyKode = data.pendaftaran.ply_kode;
            this.pendaftaran.jenisPerolehan = data.pendaftaran.jenis_perolehan;
            this.pendaftaran.namaWajibPajak = data.pendaftaran.nama_pemohon;
            this.pendaftaran.tanggalPendaftaran = data.pendaftaran.tanggal_pendaftaran;
            
            this.dokumenList = data.persyaratan || [];
            this.hasData = true;

            this.currentTargetDoc = this.dokumenList.find(d => d.status === 'pending') || this.dokumenList[0];
          } else {
            this.hasData = false;
            Swal.fire({
              icon: 'error',
              title: 'Data Tidak Ditemukan',
              text: res.data ? res.data.message : 'Nomor pelayanan tidak ditemukan.'
            });
          }
        })
        .catch(err => {
          this.isLoading = false;
          this.hasData = false;
          const msg = err.response && err.response.data && err.response.data.message 
            ? err.response.data.message 
            : 'Gagal mengambil data pendaftaran.';
          Swal.fire({
            icon: 'error',
            title: 'Terjadi Kesalahan',
            text: msg
          });
        });
    },
    openFilePicker() {
      if (this.$refs.fileInputRef) {
        this.$refs.fileInputRef.click();
      }
    },
    selectDocumentForUpload(doc) {
      this.currentTargetDoc = doc;
      this.openFilePicker();
    },
    triggerReupload(doc) {
      this.currentTargetDoc = doc;
      this.openFilePicker();
    },
    handleFileInput(event) {
      const files = event.target.files;
      if (files && files.length > 0) {
        this.processFileUpload(files[0]);
      }
      event.target.value = '';
    },
    handleFileDrop(event) {
      this.isDragging = false;
      const files = event.dataTransfer.files;
      if (files && files.length > 0) {
        this.processFileUpload(files[0]);
      }
    },
    processFileUpload(file) {
      if (!this.hasData || !this.pendaftaran.nomorPelayanan) {
        Swal.fire({
          icon: 'warning',
          title: 'Belum Memilih Pendaftaran',
          text: 'Silakan cari Nomor Pelayanan terlebih dahulu.'
        });
        return;
      }

      const target = this.currentTargetDoc || this.dokumenList.find(d => d.status === 'pending') || this.dokumenList[0];
      if (!target) {
        Swal.fire({ icon: 'warning', title: 'Pilih Dokumen', text: 'Silakan pilih dokumen persyaratan yang akan diunggah.' });
        return;
      }

      if (file.size > 5 * 1024 * 1024) {
        Swal.fire({ icon: 'error', title: 'Ukuran File Terlalu Besar', text: 'Maksimal ukuran file adalah 5 MB.' });
        return;
      }

      const allowedExts = ['pdf', 'jpg', 'jpeg', 'png'];
      const ext = file.name.split('.').pop().toLowerCase();
      if (!allowedExts.includes(ext)) {
        Swal.fire({ icon: 'error', title: 'Format File Tidak Diizinkan', text: 'Hanya mendukung file format PDF, JPG, JPEG, dan PNG.' });
        return;
      }

      const formData = new FormData();
      formData.append('no_pelayanan', this.pendaftaran.nomorPelayanan);
      formData.append('jenis_transaksi', target.jenis_transaksi || this.pendaftaran.plyKode);
      formData.append('kd_syarat', target.kd_syarat);
      formData.append('file', file);

      this.uploadProgress.active = true;
      this.uploadProgress.fileName = file.name;
      this.uploadProgress.percentage = 0;

      axios.post('/api/v1/persyaratan/upload', formData, {
        headers: { 'Content-Type': 'multipart/form-data' },
        onUploadProgress: (progressEvent) => {
          if (progressEvent.total > 0) {
            this.uploadProgress.percentage = Math.round((progressEvent.loaded * 100) / progressEvent.total);
          }
        }
      })
      .then(res => {
        this.uploadProgress.active = false;
        if (res.data && res.data.status === 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Unggah Berhasil!',
            text: 'Dokumen "' + target.nama + '" telah berhasil disimpan.',
            timer: 2000,
            showConfirmButton: false
          });
          this.cariNoPelayanan();
        } else {
          Swal.fire({ icon: 'error', title: 'Gagal Unggah', text: res.data ? res.data.message : 'Gagal mengunggah file.' });
        }
      })
      .catch(err => {
        this.uploadProgress.active = false;
        const msg = err.response && err.response.data && err.response.data.message ? err.response.data.message : 'Terjadi kesalahan saat mengunggah berkas.';
        Swal.fire({ icon: 'error', title: 'Gagal Unggah', text: msg });
      });
    },
    removeDocumentFile(doc) {
      Swal.fire({
        title: 'Hapus Berkas?',
        text: 'Apakah Anda yakin ingin menghapus berkas "' + doc.nama + '"?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          axios.post('/api/v1/persyaratan/delete', {
            no_pelayanan: this.pendaftaran.nomorPelayanan,
            jenis_transaksi: doc.jenis_transaksi || this.pendaftaran.plyKode,
            kd_syarat: doc.kd_syarat
          })
          .then(res => {
            if (res.data && res.data.status === 'success') {
              Swal.fire({
                icon: 'success',
                title: 'Terhapus!',
                text: 'Berkas berhasil dihapus.',
                timer: 1500,
                showConfirmButton: false
              });
              this.cariNoPelayanan();
            } else {
              Swal.fire({ icon: 'error', title: 'Gagal Hapus', text: res.data ? res.data.message : 'Gagal menghapus berkas.' });
            }
          })
          .catch(err => {
            const msg = err.response && err.response.data && err.response.data.message ? err.response.data.message : 'Terjadi kesalahan server.';
            Swal.fire({ icon: 'error', title: 'Gagal Hapus', text: msg });
          });
        }
      });
    },
    zoomIn() {
      if (this.zoomLevel < 3.0) {
        this.zoomLevel = Math.min(3.0, Math.round((this.zoomLevel + 0.25) * 100) / 100);
      }
    },
    zoomOut() {
      if (this.zoomLevel > 0.5) {
        this.zoomLevel = Math.max(0.5, Math.round((this.zoomLevel - 0.25) * 100) / 100);
      }
    },
    resetZoom() {
      this.zoomLevel = 1.0;
    },
    handleWheelZoom(event) {
      if (this.isPdfPreview) return;
      if (event.deltaY < 0) {
        this.zoomIn();
      } else {
        this.zoomOut();
      }
    },
    openDocPreview(doc) {
      this.currentPreviewDoc = doc;
      const url = `/api/v1/persyaratan/file?no_pelayanan=${encodeURIComponent(this.pendaftaran.nomorPelayanan)}&jenis_transaksi=${encodeURIComponent(doc.jenis_transaksi || this.pendaftaran.plyKode)}&kd_syarat=${encodeURIComponent(doc.kd_syarat)}&t=${Date.now()}`;
      this.previewUrl = url;
      const filename = doc.filename || doc.file_simpan || '';
      const ext = filename.split('.').pop().toLowerCase();
      this.isPdfPreview = (ext === 'pdf');
      this.zoomLevel = 1.0;
      this.previewModalOpen = true;
    },
    closeDocPreview() {
      this.previewModalOpen = false;
      this.previewUrl = '';
      this.zoomLevel = 1.0;
    },
    downloadDocFile(doc) {
      if (!doc) return;
      const link = `/api/v1/persyaratan/file?no_pelayanan=${encodeURIComponent(this.pendaftaran.nomorPelayanan)}&jenis_transaksi=${encodeURIComponent(doc.jenis_transaksi || this.pendaftaran.plyKode)}&kd_syarat=${encodeURIComponent(doc.kd_syarat)}&download=1`;
      window.open(link, '_blank');
    }
  }
}
</script>
