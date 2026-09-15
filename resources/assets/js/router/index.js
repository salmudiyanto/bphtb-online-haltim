import Vue from 'vue';
import VueRouter from 'vue-router';

import AuthLayout from '../layouts/AuthLayout.vue';
import MainLayout from '../layouts/MainLayout.vue';
import Login from '../pages/Login.vue';
import Dashboard from '../pages/Dashboard.vue';
import InputPendaftaran from '../pages/InputPendaftaran.vue';
import UploadPersyaratan from '../pages/UploadPersyaratan.vue';
import InputSspd from '../pages/InputSspd.vue';

import PlaceholderPage from '../pages/PlaceholderPage.vue';

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
        component: Dashboard,
        meta: { title: 'Dashboard' }
      },
      // Group Pelayanan
      {
        path: 'pendaftaran-baru',
        name: 'pendaftaran-baru',
        component: InputPendaftaran,
        meta: { title: 'Input Nomor Pelayanan' }
      },
      {
        path: 'upload-persyaratan',
        name: 'upload-persyaratan',
        component: UploadPersyaratan,
        meta: { title: 'Upload Persyaratan' }
      },
      {
        path: 'edit-nomor-pelayanan',
        name: 'edit-nomor-pelayanan',
        component: PlaceholderPage,
        meta: { title: 'Edit Nomor Pelayanan' }
      },
      // Group Transaksi
      {
        path: 'input-sspd',
        name: 'input-sspd',
        component: InputSspd,
        meta: { title: 'Input Data Surat Setoran' }
      },
      {
        path: 'cetak-surat-setoran',
        name: 'cetak-surat-setoran',
        component: PlaceholderPage,
        meta: { title: 'Cetak Surat Setoran' }
      },
      {
        path: 'input-sspd-kb',
        name: 'input-sspd-kb',
        component: PlaceholderPage,
        meta: { title: 'Input SSPD-BPHTB KB' }
      },
      {
        path: 'cetak-bukti-nihil',
        name: 'cetak-bukti-nihil',
        component: PlaceholderPage,
        meta: { title: 'Cetak Bukti Transaksi Nihil' }
      },
      {
        path: 'cetak-kwitansi-nihil',
        name: 'cetak-kwitansi-nihil',
        component: PlaceholderPage,
        meta: { title: 'Cetak Ulang Kwitansi Nihil' }
      },
      {
        path: 'pembatalan-nihil',
        name: 'pembatalan-nihil',
        component: PlaceholderPage,
        meta: { title: 'Pembatalan BPHTB Nihil' }
      },
      // Verifikasi (Tanpa Group)
      {
        path: 'verifikasi-berkas',
        name: 'verifikasi-berkas',
        component: PlaceholderPage,
        meta: { title: 'Verifikasi' }
      },
      // Group Pembayaran
      {
        path: 'pembayaran-bphtb',
        name: 'pembayaran-bphtb',
        component: PlaceholderPage,
        meta: { title: 'Pembayaran BPHTB' }
      },
      {
        path: 'pembatalan-pembayaran',
        name: 'pembatalan-pembayaran',
        component: PlaceholderPage,
        meta: { title: 'Pembatalan Pembayaran BPHTB' }
      },
      {
        path: 'cetak-kwitansi-pembayaran',
        name: 'cetak-kwitansi-pembayaran',
        component: PlaceholderPage,
        meta: { title: 'Cetak Ulang Kwitansi Pembayaran BPHTB' }
      },
      // Group Monitoring
      {
        path: 'monitoring/sudah-bayar',
        name: 'monitoring-sudah-bayar',
        component: PlaceholderPage,
        meta: { title: 'Monitoring - Sudah Bayar' }
      },
      {
        path: 'monitoring/siap-bayar',
        name: 'monitoring-siap-bayar',
        component: PlaceholderPage,
        meta: { title: 'Monitoring - Siap Bayar' }
      },
      // Group Laporan
      {
        path: 'rekap-laporan',
        name: 'rekap-laporan',
        component: PlaceholderPage,
        meta: { title: 'Rekap & Laporan' }
      },
      // Group Ganti Password
      {
        path: 'ganti-password',
        name: 'ganti-password',
        component: PlaceholderPage,
        meta: { title: 'Ganti Password' }
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
  return '/';
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
