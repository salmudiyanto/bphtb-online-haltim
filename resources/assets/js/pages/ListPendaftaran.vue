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
            <span class="text-[#4CAF50] font-semibold">List Pendaftaran BPHTB</span>
          </nav>
          <div class="flex items-center gap-3 mt-1">
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">List Pendaftaran BPHTB</h1>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#e3f2fd] text-[#1976d2] border border-[#bbdefb] text-xs font-semibold shadow-xs">
              <span class="w-1.5 h-1.5 rounded-full bg-[#2196f3]"></span>
              Belum Diproses
            </span>
          </div>
          <p class="text-sm text-slate-600 max-w-3xl">
            Daftar permohonan BPHTB yang sudah memiliki Nomor Pelayanan namun belum dilanjutkan ke proses pendaftaran (belum terdaftar sebagai SSPD).
          </p>
        </div>
        <div class="flex items-center gap-3">
          <button @click="fetchData" class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 text-sm font-semibold rounded-lg shadow-sm transition-colors">
            <span class="material-symbols-outlined text-[18px]" :class="{ 'animate-spin': isLoading }">refresh</span>
            Segarkan
          </button>
        </div>
      </div>

      <!-- Main Content: Table -->
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
        <!-- Top Toolbar -->
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50/50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
          <h2 class="text-base font-bold text-slate-800 flex items-center gap-2">
            <span class="material-symbols-outlined text-[#4CAF50] text-[20px]">table_rows</span>
            Data Pendaftaran
          </h2>
          <div class="flex items-center gap-4 w-full sm:w-auto">
            <!-- Search Bar -->
            <div class="relative w-full sm:w-72">
              <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="material-symbols-outlined text-slate-400 text-[18px]">search</span>
              </span>
              <input 
                v-model="searchQuery" 
                type="text" 
                placeholder="Cari No Pelayanan, Nama WP, NOP..." 
                class="block w-full pl-9 pr-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-[#4CAF50] focus:border-[#4CAF50] outline-none"
              >
            </div>
          </div>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse min-w-[1000px]">
            <thead>
              <tr class="bg-slate-50 border-b border-slate-200">
                <th class="py-3 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider w-16 text-center">No</th>
                <th class="py-3 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider w-20 text-center">Aksi</th>
                
                <!-- Header: No. Pendaftaran -->
                <th 
                  @click="sortBy('no_pelayanan')" 
                  class="py-3 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider cursor-pointer select-none hover:bg-slate-100 transition-colors"
                >
                  <div class="flex items-center gap-1.5">
                    <span>No. Pendaftaran</span>
                    <span class="material-symbols-outlined text-[16px] text-slate-400" v-if="sortKey !== 'no_pelayanan'">unfold_more</span>
                    <span class="material-symbols-outlined text-[16px] text-[#4CAF50]" v-else-if="sortOrder === 'asc'">arrow_upward</span>
                    <span class="material-symbols-outlined text-[16px] text-[#4CAF50]" v-else>arrow_downward</span>
                  </div>
                </th>

                <!-- Header: Tanggal -->
                <th 
                  @click="sortBy('srttglpmhn')" 
                  class="py-3 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider cursor-pointer select-none hover:bg-slate-100 transition-colors"
                >
                  <div class="flex items-center gap-1.5">
                    <span>Tanggal</span>
                    <span class="material-symbols-outlined text-[16px] text-slate-400" v-if="sortKey !== 'srttglpmhn'">unfold_more</span>
                    <span class="material-symbols-outlined text-[16px] text-[#4CAF50]" v-else-if="sortOrder === 'asc'">arrow_upward</span>
                    <span class="material-symbols-outlined text-[16px] text-[#4CAF50]" v-else>arrow_downward</span>
                  </div>
                </th>

                <!-- Header: Nama Pemohon -->
                <th 
                  @click="sortBy('nama_pemohon')" 
                  class="py-3 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider cursor-pointer select-none hover:bg-slate-100 transition-colors"
                >
                  <div class="flex items-center gap-1.5">
                    <span>Nama Pemohon</span>
                    <span class="material-symbols-outlined text-[16px] text-slate-400" v-if="sortKey !== 'nama_pemohon'">unfold_more</span>
                    <span class="material-symbols-outlined text-[16px] text-[#4CAF50]" v-else-if="sortOrder === 'asc'">arrow_upward</span>
                    <span class="material-symbols-outlined text-[16px] text-[#4CAF50]" v-else>arrow_downward</span>
                  </div>
                </th>

                <!-- Header: Alamat Pemohon -->
                <th 
                  @click="sortBy('alamat_pemohon')" 
                  class="py-3 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider cursor-pointer select-none hover:bg-slate-100 transition-colors"
                >
                  <div class="flex items-center gap-1.5">
                    <span>Alamat Pemohon</span>
                    <span class="material-symbols-outlined text-[16px] text-slate-400" v-if="sortKey !== 'alamat_pemohon'">unfold_more</span>
                    <span class="material-symbols-outlined text-[16px] text-[#4CAF50]" v-else-if="sortOrder === 'asc'">arrow_upward</span>
                    <span class="material-symbols-outlined text-[16px] text-[#4CAF50]" v-else>arrow_downward</span>
                  </div>
                </th>

                <!-- Header: Nama WP -->
                <th 
                  @click="sortBy('namawp')" 
                  class="py-3 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider cursor-pointer select-none hover:bg-slate-100 transition-colors"
                >
                  <div class="flex items-center gap-1.5">
                    <span>Nama WP</span>
                    <span class="material-symbols-outlined text-[16px] text-slate-400" v-if="sortKey !== 'namawp'">unfold_more</span>
                    <span class="material-symbols-outlined text-[16px] text-[#4CAF50]" v-else-if="sortOrder === 'asc'">arrow_upward</span>
                    <span class="material-symbols-outlined text-[16px] text-[#4CAF50]" v-else>arrow_downward</span>
                  </div>
                </th>

                <!-- Header: NOP PBB -->
                <th 
                  @click="sortBy('nop')" 
                  class="py-3 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider cursor-pointer select-none hover:bg-slate-100 transition-colors"
                >
                  <div class="flex items-center gap-1.5">
                    <span>NOP PBB</span>
                    <span class="material-symbols-outlined text-[16px] text-slate-400" v-if="sortKey !== 'nop'">unfold_more</span>
                    <span class="material-symbols-outlined text-[16px] text-[#4CAF50]" v-else-if="sortOrder === 'asc'">arrow_upward</span>
                    <span class="material-symbols-outlined text-[16px] text-[#4CAF50]" v-else>arrow_downward</span>
                  </div>
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
              <tr v-if="isLoading" class="bg-white">
                <td colspan="8" class="py-12 text-center">
                  <div class="flex flex-col items-center justify-center gap-3">
                    <div class="w-8 h-8 border-4 border-slate-200 border-t-[#4CAF50] rounded-full animate-spin"></div>
                    <span class="text-slate-500 text-sm">Memuat data pendaftaran...</span>
                  </div>
                </td>
              </tr>
              <tr v-else-if="sortedData.length === 0" class="bg-white">
                <td colspan="8" class="py-12 text-center text-slate-500 text-sm">
                  Tidak ada data pendaftaran yang belum diproses.
                </td>
              </tr>
              <tr v-else v-for="(item, index) in paginatedData" :key="item.no_pelayanan" class="bg-white hover:bg-slate-50 transition-colors">
                <td class="py-3 px-4 text-sm text-slate-600 text-center">{{ (currentPage - 1) * perPage + index + 1 }}</td>
                <td class="py-3 px-4 text-center">
                  <button 
                    @click="lihatPendaftaran(item.no_pelayanan)" 
                    title="Proses Pendaftaran"
                    class="inline-flex items-center justify-center w-8 h-8 bg-[#eef5f0] text-[#2e7d32] hover:bg-[#4CAF50] hover:text-white rounded-lg transition-colors border border-[#c8e6c9] hover:border-[#4CAF50] shadow-xs"
                  >
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                  </button>
                </td>
                <td class="py-3 px-4 text-sm font-medium text-slate-900">{{ item.no_pelayanan }}</td>
                <td class="py-3 px-4 text-sm text-slate-600">{{ formatDate(item.srttglpmhn) }}</td>
                <td class="py-3 px-4 text-sm text-slate-800">{{ item.nama_pemohon }}</td>
                <td class="py-3 px-4 text-sm text-slate-600 max-w-xs truncate" :title="item.alamat_pemohon">{{ item.alamat_pemohon }}</td>
                <td class="py-3 px-4 text-sm text-slate-800 font-medium">{{ item.namawp }}</td>
                <td class="py-3 px-4 text-sm text-slate-600 font-mono text-[13px] tracking-tight">{{ formatNOP(item.nop) }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        
        <!-- Table Footer: Pagination & Per Page -->
        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50 flex flex-col sm:flex-row items-center justify-between gap-4">
          <div class="flex flex-wrap items-center gap-4 text-sm text-slate-600">
            <span>
              Menampilkan <span class="font-semibold text-slate-900">{{ startItem }}</span> - <span class="font-semibold text-slate-900">{{ endItem }}</span> dari <span class="font-semibold text-slate-900">{{ sortedData.length }}</span> data
            </span>
            <div class="flex items-center gap-2">
              <label for="perPageSelect" class="text-xs text-slate-500 font-medium">Tampilkan:</label>
              <select 
                id="perPageSelect"
                v-model.number="perPage" 
                class="bg-white border border-slate-300 text-slate-700 text-xs rounded-lg px-2 py-1 focus:ring-[#4CAF50] focus:border-[#4CAF50] outline-none shadow-xs cursor-pointer"
              >
                <option :value="20">20</option>
                <option :value="50">50</option>
                <option :value="100">100</option>
              </select>
              <span class="text-xs text-slate-500">baris</span>
            </div>
          </div>

          <!-- Pagination Navigation -->
          <div v-if="totalPages > 1" class="flex items-center gap-1">
            <button 
              @click="goToPage(currentPage - 1)" 
              :disabled="currentPage === 1"
              class="inline-flex items-center justify-center p-1.5 rounded-lg border border-slate-300 bg-white text-slate-600 hover:bg-slate-50 disabled:opacity-40 disabled:cursor-not-allowed transition-colors"
              title="Halaman Sebelumnya"
            >
              <span class="material-symbols-outlined text-[18px]">chevron_left</span>
            </button>

            <template v-for="(page, idx) in displayedPages">
              <span v-if="page === '...'" :key="'dots-' + idx" class="px-2 py-1 text-slate-400 text-sm select-none">...</span>
              <button 
                v-else 
                :key="page"
                @click="goToPage(page)"
                :class="[
                  'px-3 py-1 rounded-lg text-xs font-semibold transition-colors',
                  currentPage === page 
                    ? 'bg-[#4CAF50] text-white shadow-xs' 
                    : 'bg-white border border-slate-300 text-slate-700 hover:bg-slate-50'
                ]"
              >
                {{ page }}
              </button>
            </template>

            <button 
              @click="goToPage(currentPage + 1)" 
              :disabled="currentPage === totalPages"
              class="inline-flex items-center justify-center p-1.5 rounded-lg border border-slate-300 bg-white text-slate-600 hover:bg-slate-50 disabled:opacity-40 disabled:cursor-not-allowed transition-colors"
              title="Halaman Berikutnya"
            >
              <span class="material-symbols-outlined text-[18px]">chevron_right</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'ListPendaftaran',
  data() {
    return {
      items: [],
      isLoading: false,
      searchQuery: '',
      sortKey: 'srttglpmhn',
      sortOrder: 'desc',
      currentPage: 1,
      perPage: 20
    };
  },
  computed: {
    filteredData() {
      if (!this.searchQuery) return this.items;
      const q = this.searchQuery.toLowerCase();
      return this.items.filter(item => {
        return (
          (item.no_pelayanan && item.no_pelayanan.toLowerCase().includes(q)) ||
          (item.nama_pemohon && item.nama_pemohon.toLowerCase().includes(q)) ||
          (item.alamat_pemohon && item.alamat_pemohon.toLowerCase().includes(q)) ||
          (item.namawp && item.namawp.toLowerCase().includes(q)) ||
          (item.nop && item.nop.toLowerCase().includes(q))
        );
      });
    },
    sortedData() {
      let list = [...this.filteredData];
      if (!this.sortKey) return list;
      return list.sort((a, b) => {
        let valA = a[this.sortKey] || '';
        let valB = b[this.sortKey] || '';

        if (typeof valA === 'string') valA = valA.toLowerCase();
        if (typeof valB === 'string') valB = valB.toLowerCase();

        if (valA < valB) return this.sortOrder === 'asc' ? -1 : 1;
        if (valA > valB) return this.sortOrder === 'asc' ? 1 : -1;
        return 0;
      });
    },
    totalPages() {
      return Math.ceil(this.sortedData.length / this.perPage) || 1;
    },
    paginatedData() {
      const start = (this.currentPage - 1) * this.perPage;
      return this.sortedData.slice(start, start + this.perPage);
    },
    startItem() {
      if (this.sortedData.length === 0) return 0;
      return (this.currentPage - 1) * this.perPage + 1;
    },
    endItem() {
      return Math.min(this.currentPage * this.perPage, this.sortedData.length);
    },
    displayedPages() {
      const total = this.totalPages;
      const current = this.currentPage;
      if (total <= 7) {
        return Array.from({ length: total }, (_, i) => i + 1);
      }
      if (current <= 4) {
        return [1, 2, 3, 4, 5, '...', total];
      }
      if (current >= total - 3) {
        return [1, '...', total - 4, total - 3, total - 2, total - 1, total];
      }
      return [1, '...', current - 1, current, current + 1, '...', total];
    }
  },
  watch: {
    searchQuery() {
      this.currentPage = 1;
    },
    perPage() {
      this.currentPage = 1;
    }
  },
  methods: {
    sortBy(key) {
      if (this.sortKey === key) {
        this.sortOrder = this.sortOrder === 'asc' ? 'desc' : 'asc';
      } else {
        this.sortKey = key;
        this.sortOrder = 'asc';
      }
    },
    goToPage(page) {
      if (page === '...' || page < 1 || page > this.totalPages) return;
      this.currentPage = page;
    },
    formatNOP(nop) {
      if (!nop || nop.length !== 18) return nop;
      return `${nop.substring(0,2)}.${nop.substring(2,4)}.${nop.substring(4,7)}.${nop.substring(7,10)}.${nop.substring(10,13)}-${nop.substring(13,17)}.${nop.substring(17,18)}`;
    },
    formatDate(dateString) {
      if (!dateString) return '-';
      const date = new Date(dateString);
      return new Intl.DateTimeFormat('id-ID', {
        day: '2-digit',
        month: 'short',
        year: 'numeric'
      }).format(date);
    },
    async fetchData() {
      this.isLoading = true;
      try {
        const response = await axios.get('/api/v1/pendaftaran/unregistered');
        if (response.data && response.data.success) {
          this.items = response.data.data;
        } else {
          this.items = [];
        }
      } catch (error) {
        console.error("Error fetching list pendaftaran:", error);
      } finally {
        this.isLoading = false;
      }
    },
    lihatPendaftaran(no_pelayanan) {
      this.$router.push({
        path: '/input-sspd',
        query: { no_pelayanan: no_pelayanan }
      });
    }
  },
  mounted() {
    this.fetchData();
  }
};
</script>

<style scoped>
/* Optional specific styles if needed */
</style>
