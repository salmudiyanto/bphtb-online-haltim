import axios from 'axios';

const apiClient = axios.create({
  baseURL: process.env.VUE_APP_API_BASE_URL || '/api/v1',
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json'
  }
});

// Request Interceptor: Attach JWT Token
apiClient.interceptors.request.use(config => {
  const token = localStorage.getItem('jwt_token');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
}, error => {
  return Promise.reject(error);
});

// Response Interceptor: Global Error Handling
apiClient.interceptors.response.use(response => {
  return response;
}, error => {
  if (error.response) {
    // 401 Unauthorized: token expired / invalid
    if (error.response.status === 401) {
      localStorage.removeItem('jwt_token');
      if (window.location.pathname !== '/login') {
        window.location.href = '/login';
      }
    }
  }
  return Promise.reject(error);
});

export default apiClient;
