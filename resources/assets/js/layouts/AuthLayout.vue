<template>
  <div class="auth-wrapper">
    <router-view></router-view>
  </div>
</template>

<script>
export default {
  name: 'AuthLayout'
};
</script>

<style scoped>
/* Let the page component handle its own layout container */
.auth-wrapper {
  width: 100%;
  min-height: 100vh;
}
</style>
