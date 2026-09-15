<template>
  <aside 
    :class="[
      'fixed left-0 top-0 h-full w-sidebar-width bg-[#f6faf7] border-r border-[#e0ece3] shadow-[0_1px_6px_rgba(0,0,0,0.03)] z-50 flex flex-col justify-between select-none transition-transform duration-300 xl:translate-x-0',
      isOpen ? 'translate-x-0' : '-translate-x-full'
    ]"
  >
    <div class="flex flex-col h-full">
      <!-- Top Logo Header -->
      <div class="h-16 px-card-padding flex items-center justify-center bg-[#eef5f0] border-b border-[#e0ece3] shrink-0">
        <img alt="Logo BPHTB" class="h-12 w-auto object-contain" src="/images/logo_utama.png"/>
      </div>
      
      <!-- Scrollable Navigation Items -->
      <div class="overflow-y-auto flex-1 py-3 px-3 custom-scrollbar">
        
        <!-- Dashboard (Top standalone item) -->
        <div class="mb-2">
          <router-link to="/dashboard" :class="navClasses('/dashboard')" @click.native="$emit('close')">
            <div class="flex items-center gap-2.5">
              <span class="material-symbols-outlined text-[20px]">dashboard</span>
              <span>Dashboard</span>
            </div>
          </router-link>
        </div>

        <!-- Loop Groups -->
        <div v-for="group in groups" :key="group.id" class="mb-3">
          
          <!-- Standalone Item (e.g. Verifikasi - Tanpa Group) -->
          <template v-if="!group.isGroup">
            <router-link :to="group.path" :class="navClasses(group.path)" @click.native="$emit('close')">
              <div class="flex items-center gap-2.5">
                <span class="material-symbols-outlined text-[20px]">{{ group.icon }}</span>
                <span>{{ group.title }}</span>
              </div>
            </router-link>
          </template>

          <!-- Group Section -->
          <template v-else>
            <!-- Group Title / Accordion Header -->
            <button 
              @click="toggleGroup(group.id)"
              class="w-full flex items-center justify-between px-3 py-1.5 text-xs font-bold uppercase tracking-wider text-gray-500 hover:text-gray-800 transition-colors"
            >
              <span>{{ group.title }}</span>
              <span class="material-symbols-outlined text-[16px] transition-transform duration-200" :class="{ 'rotate-180': openGroups[group.id] }">
                expand_more
              </span>
            </button>

            <!-- Group Children Links -->
            <div v-show="openGroups[group.id]" class="flex flex-col gap-1 mt-1 pl-1">
              <router-link 
                v-for="item in group.items" 
                :key="item.path" 
                :to="item.path" 
                :class="navClasses(item.path)" 
                @click.native="$emit('close')"
              >
                <div class="flex items-center gap-2.5 truncate">
                  <span class="material-symbols-outlined text-[18px] opacity-80 shrink-0">{{ item.icon }}</span>
                  <span class="truncate">{{ item.label }}</span>
                </div>
              </router-link>
            </div>
          </template>

        </div>

      </div>
    </div>
  </aside>
</template>

<script>
export default {
  name: 'Sidebar',
  props: {
    isOpen: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      openGroups: {
        pelayanan: true,
        transaksi: true,
        pembayaran: true,
        monitoring: true,
        laporan: true,
        gantiPassword: false
      },
      groups: [
        {
          id: 'pelayanan',
          title: 'Pelayanan',
          isGroup: true,
          items: [
            { label: 'Input Nomor Pelayanan', path: '/pendaftaran-baru', icon: 'add_circle' },
            { label: 'Upload Persyaratan', path: '/upload-persyaratan', icon: 'upload_file' },
            { label: 'Edit Nomor Pelayanan', path: '/edit-nomor-pelayanan', icon: 'edit_note' }
          ]
        },
        {
          id: 'transaksi',
          title: 'Transaksi',
          isGroup: true,
          items: [
            { label: 'Input Data Surat Setoran', path: '/input-sspd', icon: 'calculate' },
            { label: 'Cetak Surat Setoran', path: '/cetak-surat-setoran', icon: 'print' },
            { label: 'Input SSPD-BPHTB KB', path: '/input-sspd-kb', icon: 'post_add' },
            { label: 'Cetak Bukti Transaksi Nihil', path: '/cetak-bukti-nihil', icon: 'receipt' },
            { label: 'Cetak Ulang Kwitansi Nihil', path: '/cetak-kwitansi-nihil', icon: 'print' },
            { label: 'Pembatalan BPHTB Nihil', path: '/pembatalan-nihil', icon: 'cancel' }
          ]
        },
        {
          id: 'verifikasi',
          title: 'Verifikasi',
          isGroup: false,
          path: '/verifikasi-berkas',
          icon: 'fact_check'
        },
        {
          id: 'pembayaran',
          title: 'Pembayaran',
          isGroup: true,
          items: [
            { label: 'Pembayaran BPHTB', path: '/pembayaran-bphtb', icon: 'payments' },
            { label: 'Pembatalan Pembayaran BPHTB', path: '/pembatalan-pembayaran', icon: 'money_off' },
            { label: 'Cetak Ulang Kwitansi Pembayaran', path: '/cetak-kwitansi-pembayaran', icon: 'receipt_long' }
          ]
        },
        {
          id: 'monitoring',
          title: 'Monitoring',
          isGroup: true,
          items: [
            { label: 'Sudah Bayar', path: '/monitoring/sudah-bayar', icon: 'check_circle' },
            { label: 'Siap Bayar', path: '/monitoring/siap-bayar', icon: 'pending_actions' }
          ]
        },
        {
          id: 'laporan',
          title: 'Laporan',
          isGroup: true,
          items: [
            { label: 'Rekap & Laporan', path: '/rekap-laporan', icon: 'assessment' }
          ]
        },
        {
          id: 'gantiPassword',
          title: 'Ganti Password',
          isGroup: true,
          items: [
            { label: 'Ganti Password', path: '/ganti-password', icon: 'lock_reset' }
          ]
        }
      ]
    };
  },
  methods: {
    toggleGroup(groupId) {
      this.$set(this.openGroups, groupId, !this.openGroups[groupId]);
    },
    navClasses(path) {
      const baseClasses = "flex items-center justify-between px-3 py-2 transition-all rounded-lg no-underline text-xs font-medium ";
      if (this.$route.path === path) {
        return baseClasses + "bg-[#4CAF50] !text-white shadow-sm font-semibold";
      } else {
        return baseClasses + "!text-gray-700 hover:bg-[#eaf4ec] hover:!text-[#1b3d22]";
      }
    }
  }
};
</script>

<style scoped>
a {
  text-decoration: none !important;
}
.custom-scrollbar::-webkit-scrollbar {
  width: 4px;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 4px;
}
</style>
