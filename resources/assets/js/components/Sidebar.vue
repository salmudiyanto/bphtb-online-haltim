<template>
  <div class="sidebar">
    <ul class="nav nav-pills nav-stacked">
      <router-link to="/dashboard" tag="li" active-class="active" exact>
        <a>Dashboard</a>
      </router-link>
    </ul>
  </div>
</template>

<script>
export default {
  name: 'Sidebar'
};
</script>

<style scoped>
.sidebar {
  width: 220px;
  background-color: #2c3e50;
  min-height: calc(100vh - 50px);
  padding: 15px 0;
}
.sidebar .nav > li > a {
  color: #ecf0f1;
  border-radius: 0;
}
.sidebar .nav > li.active > a {
  background-color: #3498db;
}
</style>
