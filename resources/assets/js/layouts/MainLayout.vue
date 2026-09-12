<template>
  <div class="main-layout">
    <Navbar />
    <div class="main-content">
      <Sidebar />
      <div class="page-container">
        <router-view></router-view>
      </div>
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
  }
};
</script>

<style scoped>
.main-content {
  display: flex;
}
.page-container {
  flex: 1;
  padding: 20px;
  background-color: #f8f9fa;
  min-height: calc(100vh - 50px);
}
</style>
