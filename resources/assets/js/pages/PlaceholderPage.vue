<template>
  <div class="p-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 max-w-4xl mx-auto">
      <div class="flex items-center space-x-4 mb-6">
        <div class="w-12 h-12 rounded-lg bg-green-100 text-green-700 flex items-center justify-center">
          <span class="material-symbols-outlined text-2xl">construction</span>
        </div>
        <div>
          <h1 class="text-2xl font-bold text-gray-800">{{ pageTitle }}</h1>
          <p class="text-sm text-gray-500">Fitur dalam pengembangan untuk kebutuhan sistem BPHTB Online</p>
        </div>
      </div>
      
      <div class="border-t border-gray-100 pt-6">
        <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-4 flex items-start space-x-3">
          <span class="material-symbols-outlined text-emerald-600 mt-0.5">info</span>
          <div>
            <h4 class="text-sm font-semibold text-emerald-900">Informasi Modul</h4>
            <p class="text-sm text-emerald-700 mt-1">
              Menu <strong>{{ pageTitle }}</strong> telah terdaftar di navigasi sistem. Halaman ini siap untuk diintegrasikan dengan modul logika &amp; API backend selanjutnya.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PlaceholderPage',
  computed: {
    pageTitle() {
      return (this.$route && this.$route.meta && this.$route.meta.title) 
        ? this.$route.meta.title 
        : 'Halaman Fitur';
    }
  }
}
</script>
