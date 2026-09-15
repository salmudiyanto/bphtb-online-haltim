
window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {
    // ignore
}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Axios Authorization Header Interceptor
 */
window.axios.interceptors.request.use(config => {
    const jwtToken = localStorage.getItem('jwt_token');
    if (jwtToken) {
        config.headers['Authorization'] = 'Bearer ' + jwtToken;
    }
    return config;
}, error => {
    return Promise.reject(error);
});

/**
 * Axios 401 Silent Refresh Interceptor
 */
let isRefreshing = false;
let failedQueue = [];

const processQueue = (error, token = null) => {
    failedQueue.forEach(prom => {
        if (error) {
            prom.reject(error);
        } else {
            prom.resolve(token);
        }
    });
    failedQueue = [];
};

window.axios.interceptors.response.use(response => {
    return response;
}, error => {
    const originalRequest = error.config;

    if (error.response && error.response.status === 401 && originalRequest && !originalRequest._retry && !originalRequest.url.includes('/api/v1/login')) {
        if (isRefreshing) {
            return new Promise((resolve, reject) => {
                failedQueue.push({ resolve, reject });
            }).then(token => {
                originalRequest.headers['Authorization'] = 'Bearer ' + token;
                return window.axios(originalRequest);
            }).catch(err => {
                return Promise.reject(err);
            });
        }

        originalRequest._retry = true;
        isRefreshing = true;

        const refreshToken = localStorage.getItem('refresh_token');
        if (!refreshToken) {
            isRefreshing = false;
            localStorage.removeItem('jwt_token');
            localStorage.removeItem('refresh_token');
            localStorage.removeItem('user_info');
            if (!window.location.pathname.includes('/auth/login')) {
                window.location.href = '/auth/login';
            }
            return Promise.reject(error);
        }

        return new Promise((resolve, reject) => {
            window.axios.post('/api/v1/refresh', { refresh_token: refreshToken })
                .then(({ data }) => {
                    if (data.status === 'success' && data.access_token) {
                        localStorage.setItem('jwt_token', data.access_token);
                        if (data.refresh_token) {
                            localStorage.setItem('refresh_token', data.refresh_token);
                        }
                        window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + data.access_token;
                        originalRequest.headers['Authorization'] = 'Bearer ' + data.access_token;
                        processQueue(null, data.access_token);
                        resolve(window.axios(originalRequest));
                    } else {
                        throw new Error('Refresh token invalid');
                    }
                })
                .catch(err => {
                    processQueue(err, null);
                    localStorage.removeItem('jwt_token');
                    localStorage.removeItem('refresh_token');
                    localStorage.removeItem('user_info');
                    if (!window.location.pathname.includes('/auth/login')) {
                        window.location.href = '/auth/login';
                    }
                    reject(err);
                })
                .finally(() => {
                    isRefreshing = false;
                });
        });
    }

    return Promise.reject(error);
});

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });
