<template>
  <div class="auth-layout">
    <div class="auth-container">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AuthLayout'
};
</script>

<style scoped>
.auth-layout {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #f4f6f9;
}
.auth-container {
  width: 100%;
  max-width: 420px;
  padding: 20px;
}
</style>
