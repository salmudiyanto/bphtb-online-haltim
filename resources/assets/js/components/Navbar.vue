<template>
  <header class="fixed top-0 xl:left-sidebar-width left-0 right-0 h-16 bg-surface-container-lowest border-b border-[#e0ece3] shadow-[0_1px_6px_rgba(0,0,0,0.03)] z-40 flex items-center justify-between px-4 lg:px-gutter-lg transition-all duration-300">
    <div class="flex items-center gap-3 lg:gap-4">
      <button @click="$emit('toggle-sidebar')" class="xl:hidden p-1.5 -ml-1 text-on-surface-variant hover:bg-[#ebf6ee] rounded-lg transition-colors">
        <span class="material-symbols-outlined text-[24px]">menu</span>
      </button>
      
      <div class="flex flex-col">
        <div class="flex items-center gap-2">
          <span class="font-headline-sm text-[16px] lg:text-headline-sm text-[#264332] font-semibold hidden sm:block">Sistem Informasi BPHTB Online</span>
          <span class="font-headline-sm text-[16px] text-[#264332] font-semibold sm:hidden">BPHTB Online</span>
        </div>
        <div class="flex items-center gap-2">
          <span class="font-body-sm text-[11px] lg:text-body-sm text-on-surface-variant">BPKAD Kab. Haltim</span>
          <span class="text-outline text-[10px] lg:text-body-sm hidden xs:inline-block">•</span>
          <div class="hidden xs:flex items-center gap-1 text-[#2e7d32]">
            <span class="w-1.5 h-1.5 lg:w-2 lg:h-2 rounded-full bg-[#4CAF50] inline-block"></span>
            <span class="font-label-sm text-[10px] lg:text-label-sm font-semibold">SISMIOP PBB Online</span>
          </div>
        </div>
      </div>
    </div>
    
    <div class="flex items-center gap-2 lg:gap-4">
      <button aria-label="Notifikasi Sistem" class="relative p-1.5 lg:p-2 rounded-lg text-on-surface-variant hover:bg-[#ebf6ee] hover:text-[#264332] transition-colors" type="button">
        <span class="material-symbols-outlined text-[20px] lg:text-[22px]">notifications</span>
        <span class="absolute top-1 lg:top-1.5 right-1 lg:right-1.5 w-2 h-2 lg:w-2.5 lg:h-2.5 bg-[#4CAF50] rounded-full ring-2 ring-surface-container-lowest"></span>
      </button>
      
      <div class="hidden sm:block h-8 w-[1px] bg-[#e0ece3]"></div>
      
      <div class="flex items-center gap-2 lg:gap-3 sm:pl-1">
        <div class="hidden md:flex flex-col text-right">
          <span class="font-label-lg text-label-lg text-[#264332] leading-tight">{{ user.username || 'Petugas BPHTB' }}</span>
          <span class="font-body-sm text-body-sm text-on-surface-variant">{{ user.email || 'Verifikator Pajak' }}</span>
        </div>
        <div class="relative cursor-pointer" ref="userDropdownRef">
          <button @click.stop="toggleDropdown" type="button" class="w-7 h-7 lg:w-8 lg:h-8 rounded-full bg-[#4CAF50] hover:bg-[#43a047] flex items-center justify-center text-white focus:outline-none focus:ring-2 focus:ring-[#4CAF50]/50 transition-all">
            <span class="material-symbols-outlined text-[16px] lg:text-[18px]">person</span>
          </button>
          <div v-if="dropdownOpen" class="absolute right-0 mt-2 w-48 py-2 bg-surface-container-lowest rounded-xl shadow-lg border border-[#cfe0d4] flex flex-col z-50">
            <a class="px-4 py-2 font-body-md text-body-md !text-on-surface-variant hover:bg-[#ebf6ee] hover:!text-[#264332] flex items-center gap-2 no-underline" href="#">
              <span class="material-symbols-outlined text-[18px]">manage_accounts</span>Profil Petugas
            </a>
            <a class="px-4 py-2 font-body-md text-body-md !text-on-surface-variant hover:bg-[#ebf6ee] hover:!text-[#264332] flex items-center gap-2 no-underline" href="#">
              <span class="material-symbols-outlined text-[18px]">history</span>Log Aktivitas
            </a>
            <div class="h-[1px] bg-[#e0ece3] my-1"></div>
            <a @click.prevent="logout" class="px-4 py-2 font-body-md text-body-md !text-error hover:bg-error-container hover:!text-on-error-container flex items-center gap-2 cursor-pointer no-underline">
              <span class="material-symbols-outlined text-[18px]">logout</span>Keluar Sistem
            </a>
          </div>
        </div>
      </div>
    </div>
  </header>
</template>

<script>
import Swal from 'sweetalert2';

export default {
  name: 'Navbar',
  data() {
    return {
      dropdownOpen: false,
      user: {
        username: 'Petugas BPHTB',
        email: 'petugas@bphtb.go.id'
      }
    };
  },
  mounted() {
    const userInfo = localStorage.getItem('user_info');
    if (userInfo) {
      try {
        this.user = JSON.parse(userInfo);
      } catch (e) {}
    }
    document.addEventListener('click', this.closeDropdown);
  },
  beforeDestroy() {
    document.removeEventListener('click', this.closeDropdown);
  },
  methods: {
    toggleDropdown() {
      this.dropdownOpen = !this.dropdownOpen;
    },
    closeDropdown(e) {
      if (this.$refs.userDropdownRef && !this.$refs.userDropdownRef.contains(e.target)) {
        this.dropdownOpen = false;
      }
    },
    logout() {
      this.dropdownOpen = false;
      Swal.fire({
        title: 'Konfirmasi Keluar',
        text: 'Apakah Anda yakin ingin keluar dari sistem BPHTB Online?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Keluar',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          const refreshToken = localStorage.getItem('refresh_token');
          axios.post('/api/v1/logout', { refresh_token: refreshToken })
            .finally(() => {
              localStorage.removeItem('jwt_token');
              localStorage.removeItem('refresh_token');
              localStorage.removeItem('user_info');
              this.$router.push({ name: 'login' }).catch(() => {});
            });
        }
      });
    }
  }
};
</script>

<style scoped>
a {
  text-decoration: none !important;
}
</style>
