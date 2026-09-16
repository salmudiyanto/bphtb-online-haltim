<template>
  <div class="login-wrapper">
    <div class="bg-pattern"></div>
    <div class="login-container">
      <div class="card main-card">
        <div class="row g-0">
          
          <!-- LEFT BRANDING SIDE -->
          <div class="col-lg-5 brand-side d-none d-lg-flex">
            <div>
              <div class="d-flex align-items-center gap-3 mb-4">
                <img alt="Logo BPHTB Online" class="logo-badge" src="/images/logo_haltim.png"/>
                <div>
                  <h4 class="fw-bold mb-0 text-white">BPHTB Online</h4>
                  <small class="text-white-50">BPKAD Kab. Haltim</small>
                </div>
              </div>
              <div class="my-4">
                <h5 class="fw-bold text-white mb-2">Pelayanan Pajak Daerah Transparan &amp; Cepat</h5>
                <p class="text-white-50 small mb-4">
                  Sistem Informasi Validasi &amp; Pembayaran Bea Perolehan Hak atas Tanah dan Bangunan untuk mewujudkan tata kelola perpajakan daerah yang akuntabel dan modern.
                </p>


              </div>
            </div>

          </div>

          <!-- RIGHT FORM SIDE -->
          <div class="col-lg-7 form-side d-flex flex-column justify-content-center">
            
            <div class="text-center p-3 py-4" v-if="isLoggedIn">
              <div class="mb-4">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center p-3 mb-3" style="width: 80px; height: 80px; background-color: #e8f5e9; color: #4CAF50;">
                  <i class="bi bi-check2-circle display-5"></i>
                </div>
                <h3 class="fw-bold" style="color: #233b2e;">Autentikasi Berhasil</h3>
                <p class="text-muted">Selamat datang, <b>{{ form.username }}</b>! Anda telah terhubung ke Sistem Informasi BPHTB Online.</p>
              </div>
              <div class="p-3 rounded-3 mb-4 d-inline-block mx-auto text-start w-100" style="max-width: 440px; font-size: 0.875rem; background-color: #f6faf7; border: 1px solid #d0ded4;">
                <div class="d-flex justify-content-between py-1 border-bottom" style="border-color: #e2ece5 !important;">
                  <span class="text-muted">Status Sesi:</span>
                  <span class="badge" style="background-color: #4CAF50;">Aktif (Terverifikasi)</span>
                </div>
                <div class="d-flex justify-content-between py-1 border-bottom" style="border-color: #e2ece5 !important;">
                  <span class="text-muted">Hak Akses:</span>
                  <span class="fw-semibold" style="color: #233b2e;">Petugas Verifikator / PPAT</span>
                </div>
                <div class="d-flex justify-content-between py-1">
                  <span class="text-muted">Waktu Login:</span>
                  <span style="color: #233b2e;">{{ loginTime }} WIB</span>
                </div>
              </div>
              <div>
                <button @click="resetLogin" class="btn px-4 py-2" style="border: 1.5px solid #4CAF50; color: #2e5939; font-weight: 600; background: #ffffff;">
                  <i class="bi bi-arrow-counterclockwise me-1" style="color: #4CAF50;"></i> Kembali ke Form Login
                </button>
              </div>
            </div>

            <div v-else>
              <!-- Mobile Brand Header -->
              <div class="d-lg-none text-center mb-4">
                <img alt="Logo BPHTB" class="mb-2" src="/images/logo_haltim.png" style="width: 60px; height: 60px;"/>
                <h5 class="fw-bold mb-0" style="color: #2e5939;">SISTEM INFORMASI BPHTB ONLINE</h5>
                <small class="text-muted">BPKAD Kab. Haltim / Pemerintah Daerah</small>
              </div>

              <!-- Header Section -->
              <div class="mb-3">
                <h2 class="form-header-title mb-1">Masuk ke Sistem</h2>
                <p class="form-header-subtitle mb-0">
                  Silakan masukkan kredensial akun Anda untuk mengakses dashboard BPHTB Online.
                </p>
              </div>

              <!-- Login Form -->
              <form @submit.prevent="handleLogin" class="needs-validation">
                <!-- Username -->
                <div class="mb-3">
                  <div class="form-floating input-icon-group">
                    <i class="bi bi-person input-leading-icon"></i>
                    <input type="text" id="username" v-model="form.username" required :disabled="isLoading"
                      class="form-control" :class="{'is-invalid': errors.username}" placeholder="Username atau NIP" @input="errors.username = false" />
                    <label for="username">Username / NIP / Email</label>
                    <div class="invalid-feedback" v-if="errors.username">
                      <i class="bi bi-exclamation-circle me-1"></i> Username wajib diisi.
                    </div>
                  </div>
                </div>

                <!-- Password -->
                <div class="mb-3">
                  <div class="form-floating input-icon-group">
                    <i class="bi bi-shield-lock input-leading-icon"></i>
                    <input :type="showPassword ? 'text' : 'password'" id="password" v-model="form.password" required :disabled="isLoading"
                      class="form-control" :class="{'is-invalid': errors.password}" placeholder="Kata Sandi" @input="errors.password = false" />
                    <label for="password">Kata Sandi</label>
                    <button type="button" class="password-toggle-btn" @click="showPassword = !showPassword">
                      <i class="bi" :class="showPassword ? 'bi-eye-slash' : 'bi-eye'"></i>
                    </button>
                    <div class="invalid-feedback" v-if="errors.password">
                      <i class="bi bi-exclamation-circle me-1"></i> Password wajib diisi.
                    </div>
                  </div>
                </div>

                <!-- Remember Me -->
                <div class="mb-4">
                  <div class="form-check">
                    <input class="form-check-input" id="rememberMe" type="checkbox" v-model="form.remember" :disabled="isLoading" />
                    <label class="form-check-label select-none" for="rememberMe">Ingat sesi saya</label>
                  </div>
                </div>

                <!-- Submit Button -->
                <div class="d-grid mb-3">
                  <button type="submit" :disabled="isLoading" class="btn btn-submit-login">
                    <span v-if="!isLoading"><i class="bi bi-box-arrow-in-right me-2"></i> Masuk Sekarang</span>
                    <span v-else>
                      <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                      Sedang memproses login...
                    </span>
                  </button>
                </div>


              </form>

              <!-- Footer -->
              <div class="footer-text mt-3 pt-3 border-top">
                &copy; {{ new Date().getFullYear() }} BPKAD Kab. Haltim. Seluruh hak cipta dilindungi undang-undang.
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Swal from 'sweetalert2';

export default {
  name: 'Login',
  data() {
    return {
      form: {
        username: '',
        password: '',
        remember: false
      },
      errors: {
        username: false,
        password: false
      },
      isLoading: false,
      showPassword: false,
      isLoggedIn: false,
      loginTime: ''
    };
  },
  methods: {
    handleLogin() {
      this.errors.username = !this.form.username;
      this.errors.password = !this.form.password;

      if (this.errors.username || this.errors.password) return;

      this.isLoading = true;

      Swal.fire({
        title: 'Sedang memproses login...',
        html: '<div class="text-muted small">Memverifikasi kredensial akun ke server BPHTB...</div>',
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        didOpen: () => {
          Swal.showLoading();
        }
      });

      axios.post('/api/v1/login', {
        username: this.form.username,
        password: this.form.password
      })
      .then(response => {
        const data = response.data;
        if (data.status === 'success') {
          localStorage.setItem('jwt_token', data.access_token);
          if (data.refresh_token) {
            localStorage.setItem('refresh_token', data.refresh_token);
          }
          if (data.user) {
            localStorage.setItem('user_info', JSON.stringify(data.user));
          }

          Swal.fire({
            icon: 'success',
            title: 'Login Berhasil!',
            html: 'Selamat datang kembali di <b>Sistem Informasi BPHTB Online</b>.<br><span class="text-muted small">Mengarahkan ke Dashboard Utama...</span>',
            timer: 1500,
            timerProgressBar: true,
            showConfirmButton: false,
            willClose: () => {
              this.$router.push('/dashboard');
            }
          });
        } else {
          throw new Error(data.message || 'Login gagal.');
        }
      })
      .catch(error => {
        const msg = (error.response && error.response.data && error.response.data.message)
          ? error.response.data.message
          : (error.message || 'Terjadi kesalahan pada sistem.');

        Swal.fire({
          icon: 'error',
          title: 'Autentikasi Gagal',
          text: msg,
          confirmButtonColor: '#4CAF50',
          confirmButtonText: 'Coba Lagi'
        }).then(() => {
          this.form.password = '';
        });
      })
      .finally(() => {
        this.isLoading = false;
      });
    },
    showBantuanLogin() {
      Swal.fire({
        title: 'Bantuan Masuk Sistem BPHTB',
        html: `
          <div class="text-start small" style="color: #233b2e;">
            <p>Jika Anda mengalami kendala saat masuk ke sistem:</p>
            <ol class="ps-3 mb-3">
              <li>Pastikan huruf besar dan kecil (Caps Lock) pada kata sandi sesuai.</li>
              <li>Untuk PPAT/Notaris, pastikan akun telah diaktivasi oleh Administrator BPKAD Kab. Haltim.</li>
              <li>Jika lupa kata sandi atau akun terkunci, silakan hubungi admin teknis instansi.</li>
            </ol>
            <div class="py-2 px-3 rounded text-xs" style="background-color: #edf7ef; border: 1px solid #d0ded4; color: #2e5939;">
              <i class="bi bi-envelope-fill me-1 text-success"></i> Email bantuan: <b>support-bphtb@bpkad-haltim.go.id</b>
            </div>
          </div>
        `,
        confirmButtonColor: '#4CAF50',
        confirmButtonText: 'Mengerti'
      });
    }
  }
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
@import url('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css');

.login-wrapper {
  position: relative;
  z-index: 1;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding: 1.5rem 1rem;
  background-color: #f4f8f5;
  color: #233b2e;
}

.bg-pattern {
  position: fixed;
  inset: 0;
  background-image: 
    radial-gradient(at 10% 20%, rgba(76, 175, 80, 0.08) 0px, transparent 50%),
    radial-gradient(at 90% 80%, rgba(46, 89, 57, 0.07) 0px, transparent 50%);
  pointer-events: none;
  z-index: 0;
}

.login-container {
  max-width: 980px;
  margin: auto;
  width: 100%;
}

.main-card {
  border: 1px solid rgba(208, 222, 212, 0.7);
  border-radius: 1.25rem;
  box-shadow: 0 16px 36px -8px rgba(35, 59, 46, 0.08), 0 2px 6px rgba(35, 59, 46, 0.03);
  overflow: hidden;
  background: #ffffff;
}

.brand-side {
  background: linear-gradient(145deg, #2e5939 0%, #355e3b 55%, #274b30 100%);
  position: relative;
  overflow: hidden;
  color: #ffffff;
  padding: 3rem 2.5rem;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.brand-side::before {
  content: ''; position: absolute; width: 340px; height: 340px; border-radius: 50%;
  background: radial-gradient(circle, rgba(163, 246, 158, 0.12) 0%, transparent 70%);
  top: -90px; right: -90px; pointer-events: none;
}
.brand-side::after {
  content: ''; position: absolute; width: 260px; height: 260px; border-radius: 50%;
  background: radial-gradient(circle, rgba(76, 175, 80, 0.18) 0%, transparent 70%);
  bottom: -50px; left: -50px; pointer-events: none;
}

.logo-badge {
  width: 72px; height: 72px; object-fit: contain; filter: drop-shadow(0 4px 10px rgba(0,0,0,0.18));
  background: rgba(255, 255, 255, 0.1); border-radius: 1rem; padding: 6px; border: 1px solid rgba(255, 255, 255, 0.15);
}
.brand-badge {
  display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(255, 255, 255, 0.12);
  border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 9999px; padding: 0.35rem 0.9rem;
  font-size: 0.8rem; font-weight: 600; letter-spacing: 0.025em; color: #e2f7e6; backdrop-filter: blur(4px);
}
.brand-feature-item { display: flex; align-items: flex-start; gap: 0.85rem; margin-bottom: 1.15rem; }
.feature-icon-wrapper {
  width: 34px; height: 34px; border-radius: 8px; background: rgba(255, 255, 255, 0.14);
  border: 1px solid rgba(255, 255, 255, 0.18); display: flex; align-items: center; justify-content: center;
  flex-shrink: 0; color: #e2f7e6; font-size: 1rem;
}

.form-side { padding: 3rem 2.75rem; background: #ffffff; }

@media (max-width: 767.98px) {
  .form-side { padding: 2rem 1.5rem; }
  .brand-side { padding: 2rem 1.5rem; }
}

.form-header-title { font-size: 1.65rem; font-weight: 800; color: #233b2e; letter-spacing: -0.02em; }
.form-header-subtitle { color: #5e776a; font-size: 0.925rem; }

.form-floating {
  position: relative;
}
.form-floating > .form-control {
  border: 1.5px solid #d0ded4;
  border-radius: 0.65rem;
  height: calc(3.85rem + 2px);
  min-height: calc(3.85rem + 2px);
  padding-top: 1.65rem !important;
  padding-bottom: 0.5rem !important;
  padding-left: 0.85rem;
  padding-right: 0.85rem;
  font-size: 0.95rem;
  color: #233b2e;
  background-color: #fafdfa;
  transition: all 0.2s ease-in-out;
}
.form-floating > .form-control:focus {
  background-color: #ffffff;
  border-color: #4CAF50;
  box-shadow: 0 0 0 4px rgba(76, 175, 80, 0.15);
}
.form-floating > label {
  padding: 0.9rem 0.85rem;
  color: #5e776a;
  font-size: 0.9rem;
  font-weight: 500;
  transition: opacity 0.15s ease-in-out, transform 0.15s ease-in-out;
  pointer-events: none;
}
.form-floating > .form-control:focus ~ label,
.form-floating > .form-control:not(:placeholder-shown) ~ label {
  transform: scale(0.78) translateY(-0.65rem) translateX(0.15rem);
  opacity: 0.8;
}

.input-icon-group { position: relative; }
.input-icon-group .form-control {
  padding-left: 2.85rem !important;
  padding-right: 2.85rem !important;
}
.input-icon-group > label {
  padding-left: 2.85rem !important;
}
.input-leading-icon {
  position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #8fa395;
  font-size: 1.15rem; z-index: 5; pointer-events: none; transition: color 0.2s ease;
}
.form-floating:focus-within .input-leading-icon { color: #4CAF50; }

.password-toggle-btn {
  position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%); z-index: 5;
  background: none; border: none; color: #7b9485; padding: 0.4rem; cursor: pointer;
  display: flex; align-items: center; justify-content: center; border-radius: 6px; transition: color 0.15s ease, background-color 0.15s ease;
}
.password-toggle-btn:hover { color: #4CAF50; background-color: #eef7f0; }

.btn-submit-login {
  background-color: #4CAF50; border: none; border-radius: 0.65rem; padding: 0.9rem 1.5rem;
  font-size: 1rem; font-weight: 700; color: #ffffff; letter-spacing: 0.01em; transition: all 0.2s ease; box-shadow: 0 4px 12px rgba(76, 175, 80, 0.25);
}
.btn-submit-login:hover, .btn-submit-login:focus {
  background-color: #43a047; color: #ffffff; transform: translateY(-1px); box-shadow: 0 6px 16px rgba(76, 175, 80, 0.32);
}
.btn-submit-login:active { transform: translateY(0); }
.btn-submit-login:disabled { background-color: #a7bcae; box-shadow: none; cursor: not-allowed; }

.form-check-input:checked { background-color: #4CAF50; border-color: #4CAF50; }
.form-check-input:focus { border-color: #4CAF50; box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.2); }
.form-check-label { font-size: 0.875rem; color: #233b2e; cursor: pointer; }

.support-box { background-color: #f6faf7; border: 1px dashed #cad9ce; border-radius: 0.65rem; padding: 0.75rem 1rem; font-size: 0.825rem; color: #5e776a; }
.footer-text { font-size: 0.8rem; color: #8fa395; text-align: center; border-color: #e4eee7 !important; }

.was-validated .form-control:invalid, .form-control.is-invalid { border-color: #d32f2f; background-image: none !important; }
.was-validated .form-control:valid, .form-control.is-valid { border-color: #4CAF50; background-image: none !important; }
.invalid-feedback { font-size: 0.8rem; font-weight: 500; margin-top: 0.35rem; padding-left: 0.25rem; color: #c62828; }

.demo-credentials-bar { background: #edf5ef; border: 1px solid #d5e5d9; border-radius: 0.5rem; padding: 0.55rem 0.8rem; font-size: 0.775rem; color: #233b2e; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 1.25rem; }
.btn-demo-tag { background: #ffffff; border: 1px solid #c8dcd0; padding: 0.22rem 0.6rem; border-radius: 4px; font-size: 0.725rem; font-weight: 600; color: #2e5939; cursor: pointer; transition: all 0.15s ease; }
.btn-demo-tag:hover { background: #4CAF50; color: #ffffff; border-color: #4CAF50; }
.btn-demo-tag.tag-danger { color: #c62828; border-color: #f1c5c5; background: #fff8f8; }
.btn-demo-tag.tag-danger:hover { background: #c62828; color: #ffffff; border-color: #c62828; }
.btn-demo-tag.tag-warning { color: #9a6500; border-color: #f6e2b2; background: #fffdf5; }
.btn-demo-tag.tag-warning:hover { background: #b57c12; color: #ffffff; border-color: #b57c12; }

.text-theme-primary { color: #2e5939 !important; }
.text-theme-primary:hover { color: #4CAF50 !important; }
</style>
