/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

// Set up axios defaults
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.withCredentials = true;

// Get CSRF token from meta tag
const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
//     wsHost: import.meta.env.VITE_PUSHER_HOST ? import.meta.env.VITE_PUSHER_HOST : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });

/**
 * Handle CSRF token refresh and session management
 */
let tokenRefreshInterval;

function startTokenRefresh() {
    // Clear any existing interval
    if (tokenRefreshInterval) {
        clearInterval(tokenRefreshInterval);
    }

    // Set up new interval
    tokenRefreshInterval = setInterval(async () => {
        try {
            const response = await axios.get('/csrf-token');
            const token = document.querySelector('meta[name="csrf-token"]');
            if (token && response.data.token) {
                token.setAttribute('content', response.data.token);
                window.axios.defaults.headers.common['X-CSRF-TOKEN'] = response.data.token;
            }
        } catch (error) {
            console.error('Failed to refresh CSRF token:', error);
            if (error.response && error.response.status === 419) {
                window.dispatchEvent(new CustomEvent('session-expired'));
            }
        }
    }, 1800000); // 30 minutes
}

// Start token refresh when page loads
document.addEventListener('DOMContentLoaded', startTokenRefresh);

// Handle session expiration
window.addEventListener('session-expired', () => {
    const event = new CustomEvent('handle-session-expired');
    window.dispatchEvent(event);
});

// Add interceptor to handle 419 responses
axios.interceptors.response.use(
    response => response,
    error => {
        if (error.response && error.response.status === 419) {
            window.dispatchEvent(new CustomEvent('session-expired'));
        }
        return Promise.reject(error);
    }
);
