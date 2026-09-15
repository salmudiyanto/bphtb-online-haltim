import Vue from 'vue';
import VueRouter from 'vue-router';

import AuthLayout from '../layouts/AuthLayout.vue';
import MainLayout from '../layouts/MainLayout.vue';
import Login from '../pages/Login.vue';
import Dashboard from '../pages/Dashboard.vue';
import InputPendaftaran from '../pages/InputPendaftaran.vue';
import UploadPersyaratan from '../pages/UploadPersyaratan.vue';
import InputSspd from '../pages/InputSspd.vue';

Vue.use(VueRouter);

const routes = [
  {
    path: '/auth',
    component: AuthLayout,
    children: [
      {
        path: 'login',
        name: 'login',
        component: Login
      }
    ]
  },
  {
    path: '/login',
    redirect: '/auth/login'
  },
  {
    path: '/',
    component: MainLayout,
    meta: { requiresAuth: true },
    children: [
      {
        path: 'dashboard',
        name: 'dashboard',
        component: Dashboard
      },
      {
        path: 'pendaftaran-baru',
        name: 'pendaftaran-baru',
        component: InputPendaftaran
      },
      {
        path: 'upload-persyaratan',
        name: 'upload-persyaratan',
        component: UploadPersyaratan
      },
      {
        path: 'input-sspd',
        name: 'input-sspd',
        component: InputSspd
      },
      {
        path: '',
        redirect: '/dashboard'
      }
    ]
  },
  {
    path: '*',
    redirect: '/dashboard'
  }
];

function getBasePath() {
  const path = window.location.pathname;
  if (path.includes('/public/')) {
    return path.split('/public/')[0] + '/public/';
  }
  const knownRoutes = ['/dashboard', '/login', '/auth', '/permohonan-masuk', '/verifikasi-berkas', '/surat-ketetapan', '/rekap-laporan', '/peta-geografis', '/pengaturan-sistem', '/pendaftaran-baru', '/upload-persyaratan', '/input-sspd'];
  for (let i = 0; i < knownRoutes.length; i++) {
    if (path.indexOf(knownRoutes[i]) !== -1) {
      return path.substring(0, path.indexOf(knownRoutes[i])) + '/';
    }
  }
  return path.endsWith('/') ? path : path + '/';
}

const router = new VueRouter({
  mode: 'history',
  base: getBasePath(),
  routes
});

// Router Guard (Auth Guard Middleware)
router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('jwt_token');

  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!token) {
      next({ name: 'login' });
    } else {
      next();
    }
  } else if (to.name === 'login' && token) {
    next({ name: 'dashboard' });
  } else {
    next();
  }
});

export default router;
