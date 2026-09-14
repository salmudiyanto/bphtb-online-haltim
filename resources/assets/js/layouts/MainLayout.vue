<template>
  <div class="main-wrapper bg-surface font-body-md text-on-surface min-h-screen">
    <!-- Backdrop overlay for mobile when sidebar is open -->
    <div 
      v-if="isSidebarOpen" 
      @click="isSidebarOpen = false" 
      class="fixed inset-0 bg-[#264332]/50 z-40 xl:hidden backdrop-blur-sm transition-opacity"
    ></div>

    <Sidebar :isOpen="isSidebarOpen" @close="isSidebarOpen = false" />
    
    <div class="xl:pl-sidebar-width pl-0 transition-all duration-300">
      <Navbar @toggle-sidebar="isSidebarOpen = !isSidebarOpen" />
      <main class="w-full pt-16 bg-surface min-h-screen px-container-padding-mobile lg:px-container-padding-desktop py-gutter-lg">
        <router-view></router-view>
      </main>
    </div>
  </div>
</template>

<script>
import Navbar from '../components/Navbar.vue';
import Sidebar from '../components/Sidebar.vue';

export default {
  name: 'MainLayout',
  components: {
    Navbar,
    Sidebar
  },
  data() {
    return {
      isSidebarOpen: false
    };
  }
};
</script>

<style scoped>
/* Scoped styles can be minimal since we use Tailwind */
</style>
