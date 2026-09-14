<template>
  <aside 
    :class="[
      'fixed left-0 top-0 h-full w-sidebar-width bg-[#f6faf7] border-r border-[#e0ece3] shadow-[0_1px_6px_rgba(0,0,0,0.03)] z-50 flex flex-col justify-between select-none transition-transform duration-300 xl:translate-x-0',
      isOpen ? 'translate-x-0' : '-translate-x-full'
    ]"
  >
    <div class="flex flex-col">
      <div class="h-16 px-card-padding flex items-center justify-center bg-[#eef5f0] border-b border-[#e0ece3]">
        <img alt="Logo BPHTB" class="h-12 w-auto object-contain" src="/images/logo_utama.png"/>
      </div>
      
      <div class="px-gutter-md py-gutter-sm">
        <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline px-gutter-xs">Menu Navigasi</span>
      </div>
      
      <nav class="flex flex-col gap-1 px-gutter-sm">
        <router-link to="/dashboard" :class="navClasses('/dashboard')" @click.native="$emit('close')">
          <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-[20px]">dashboard</span>
            <span>Dashboard</span>
          </div>
        </router-link>
        
        <router-link to="/pendaftaran-baru" :class="navClasses('/pendaftaran-baru')" @click.native="$emit('close')">
          <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-[20px]">add_circle</span>
            <span>Pendaftaran Baru</span>
          </div>
        </router-link>

        <router-link to="/upload-persyaratan" :class="navClasses('/upload-persyaratan')" @click.native="$emit('close')">
          <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-[20px]">upload_file</span>
            <span>Upload Persyaratan</span>
          </div>
        </router-link>

        <router-link to="/input-sspd" :class="navClasses('/input-sspd')" @click.native="$emit('close')">
          <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-[20px]">calculate</span>
            <span>Input SSPD</span>
          </div>
        </router-link>
        
        <router-link to="/permohonan-masuk" :class="navClasses('/permohonan-masuk')" @click.native="$emit('close')">
          <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-[20px]">move_to_inbox</span>
            <span>Permohonan Masuk</span>
          </div>
          <span class="px-1.5 py-0.5 rounded-full font-label-sm text-label-sm bg-[#e2f2e5] text-[#1e4624] font-semibold">14</span>
        </router-link>
        
        <router-link to="/verifikasi-berkas" :class="navClasses('/verifikasi-berkas')" @click.native="$emit('close')">
          <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-[20px]">fact_check</span>
            <span>Verifikasi Berkas</span>
          </div>
        </router-link>
        
        <router-link to="/surat-ketetapan" :class="navClasses('/surat-ketetapan')" @click.native="$emit('close')">
          <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-[20px]">receipt_long</span>
            <span>SKP &amp; Bukti Bayar</span>
          </div>
        </router-link>
        
        <router-link to="/rekap-laporan" :class="navClasses('/rekap-laporan')" @click.native="$emit('close')">
          <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-[20px]">assessment</span>
            <span>Rekap &amp; Laporan</span>
          </div>
        </router-link>
        
        <router-link to="/peta-geografis" :class="navClasses('/peta-geografis')" @click.native="$emit('close')">
          <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-[20px]">map</span>
            <span>Peta Geografis ZNT</span>
          </div>
        </router-link>
        
        <router-link to="/pengaturan-sistem" :class="navClasses('/pengaturan-sistem')" @click.native="$emit('close')">
          <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-[20px]">tune</span>
            <span>Pengaturan Sistem</span>
          </div>
        </router-link>
      </nav>
    </div>
    
    <div class="p-gutter-md m-gutter-sm bg-[#eef5f0] border border-[#dce9df] rounded-xl flex flex-col gap-2">
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
          <span class="w-2 h-2 rounded-full bg-[#4CAF50]"></span>
          <span class="font-label-sm text-label-sm text-on-surface-variant">ATR / BPN Terhubung</span>
        </div>
        <span class="material-symbols-outlined text-[#4CAF50] text-[16px]">cloud_done</span>
      </div>
      <div class="h-[1px] bg-[#d3e0d6]"></div>
      <div class="flex items-center justify-between">
        <span class="font-label-sm text-label-sm text-outline">Sistem v2.4.0 Secure</span>
        <span class="px-1.5 py-0.5 rounded font-label-sm text-label-sm bg-[#4CAF50] text-white">BSrE</span>
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
  methods: {
    navClasses(path) {
      const baseClasses = "flex items-center justify-between px-3 py-2.5 transition-all rounded-lg no-underline ";
      if (this.$route.path === path) {
        return baseClasses + "bg-[#4CAF50] !text-white font-label-md shadow-sm";
      } else {
        return baseClasses + "!text-on-surface-variant hover:bg-[#eaf4ec] hover:!text-[#233327] font-body-md text-body-md";
      }
    }
  }
};
</script>

<style scoped>
a {
  text-decoration: none !important;
}
</style>
