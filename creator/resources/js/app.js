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

// Initialize Alpine.js components
document.addEventListener('alpine:init', () => {
    // Session handler component
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

    // Form data component
    Alpine.data('formData', () => ({
        isSubmitting: false,
        cardData: {
            name: '',
            type: '',
            hp: '',
            category: '',
            length: '',
            weight: '',
            description: '',
            weakness: '',
            resistance: '',
            retreat_cost: '',
            card_number: '',
            artist: '',
            set: '',
            year: new Date().getFullYear(),
            attacks: []
        },
        attacks: [],
        init() {
            // Initialize with one empty attack
            this.attacks = [{ name: '', damage: '0', energyCount: 1, description: '' }];
            this.cardData.attacks = this.attacks;
        },
        addAttack() {
            this.attacks.push({ name: '', damage: '0', energyCount: 1, description: '' });
        },
        removeAttack(index) {
            this.attacks.splice(index, 1);
            if (this.attacks.length === 0) {
                this.addAttack();
            }
        }
    }));
});

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
