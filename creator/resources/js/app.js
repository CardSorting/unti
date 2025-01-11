import './bootstrap';
import Alpine from 'alpinejs';

// Wait for CSRF token to be available before initializing
const waitForCSRF = () => {
    const token = document.head.querySelector('meta[name="csrf-token"]');
    if (token) {
        window.Alpine = Alpine;
        Alpine.start();
    } else {
        setTimeout(waitForCSRF, 100);
    }
};

// Start initialization
document.addEventListener('DOMContentLoaded', waitForCSRF);

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

            // Add form submit handler to ensure CSRF token is present
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', () => {
                    const token = document.head.querySelector('meta[name="csrf-token"]');
                    if (token && !form.querySelector('input[name="_token"]')) {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = '_token';
                        input.value = token.content;
                        form.appendChild(input);
                    }
                });
            }
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
