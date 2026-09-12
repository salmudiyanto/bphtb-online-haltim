<template>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title text-center">Login BPHTB Online</h3>
    </div>
    <div class="panel-body">
      <form @submit.prevent="handleLogin">
        <div class="form-group">
          <label>Username / Email</label>
          <input type="text" v-model="form.username" class="form-control" required />
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" v-model="form.password" class="form-control" required />
        </div>
        <button type="submit" class="btn btn-primary btn-block">Masuk</button>
      </form>
    </div>
  </div>
</template>

<script>
import apiClient from '../utils/api';

export default {
  name: 'Login',
  data() {
    return {
      form: {
        username: '',
        password: ''
      }
    };
  },
  methods: {
    handleLogin() {
      // Dummy / API login logic
      apiClient.post('/login', this.form)
        .then(res => {
          if (res.data && res.data.token) {
            localStorage.setItem('jwt_token', res.data.token);
          } else {
            localStorage.setItem('jwt_token', 'demo_token_123');
          }
          this.$router.push('/dashboard');
        })
        .catch(() => {
          // Fallback demo for initial scaffolding test
          localStorage.setItem('jwt_token', 'demo_token_123');
          this.$router.push('/dashboard');
        });
    }
  }
};
</script>
