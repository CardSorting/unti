import './bootstrap';
import Alpine from 'alpinejs';
import axios from 'axios';

window.Alpine = Alpine;
window.axios = axios;

// Set default headers for Axios
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found');
}

// Initialize Alpine.js
Alpine.start();

// Handle form submissions
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function() {
            const token = document.head.querySelector('meta[name="csrf-token"]');
            if (token && !this.querySelector('input[name="_token"]')) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = '_token';
                input.value = token.content;
                this.appendChild(input);
            }
        });
    });

    // Refresh CSRF token periodically
    setInterval(async () => {
        try {
            const response = await axios.get('/csrf-token');
            const token = document.head.querySelector('meta[name="csrf-token"]');
            if (token && response.data.token) {
                token.content = response.data.token;
                window.axios.defaults.headers.common['X-CSRF-TOKEN'] = response.data.token;
            }
        } catch (error) {
            console.error('Failed to refresh CSRF token:', error);
        }
    }, 1800000); // 30 minutes
});

// Handle session timeouts
document.addEventListener('alpine:init', () => {
    Alpine.data('sessionHandler', () => ({
        showExpiredAlert: false,
        init() {
            this.$watch('showExpiredAlert', value => {
                if (value) {
                    setTimeout(() => {
                        this.showExpiredAlert = false;
                    }, 5000);
                }
            });
        },
        handleSessionExpired() {
            this.showExpiredAlert = true;
            setTimeout(() => {
                window.location.reload();
            }, 3000);
        }
    }));
});
