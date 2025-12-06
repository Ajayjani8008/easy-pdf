/**
 * Global Toast Notification System
 * Supports: success, error, warning, info, validation
 */

class ToastManager {
    constructor() {
        this.toasts = [];
        this.container = null;
        this.init();
    }

    init() {
        // Wait for DOM to be ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.setupContainer());
        } else {
            this.setupContainer();
        }
    }

    setupContainer() {
        // Use existing container from blade component if available
        this.container = document.getElementById('toast-container');
        
        if (!this.container) {
            // Create container if it doesn't exist
            this.container = document.createElement('div');
            this.container.id = 'toast-container';
            this.container.className = 'fixed bottom-0 left-0 right-0 z-[9999] flex flex-col items-center pb-4 pointer-events-none';
            document.body.appendChild(this.container);
        }
    }

    show(type, title, message, duration = 5000) {
        const toast = this.createToast(type, title, message, duration);
        this.container.appendChild(toast);
        this.toasts.push(toast);

        // Animate in
        setTimeout(() => {
            toast.classList.add('toast-enter');
        }, 10);

        // Auto remove after duration
        setTimeout(() => {
            this.remove(toast);
        }, duration);
    }

    createToast(type, title, message, duration) {
        const toast = document.createElement('div');
        toast.className = `toast toast-${type} pointer-events-auto`;
        
        const config = this.getToastConfig(type);
        const toastId = 'toast-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9);
        toast.id = toastId;
        
        toast.innerHTML = `
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    ${config.icon}
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-semibold text-white">${this.escapeHtml(title)}</p>
                    <p class="mt-1 text-sm text-white opacity-90">${this.escapeHtml(message)}</p>
                </div>
                <div class="ml-4 flex-shrink-0">
                    <button 
                        type="button" 
                        class="inline-flex rounded-md bg-white bg-opacity-20 text-white hover:bg-opacity-30 focus:outline-none focus:ring-2 focus:ring-white transition-all p-1"
                        onclick="window.toastManager.remove(document.getElementById('${toastId}'))"
                    >
                        <span class="sr-only">Close</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        `;

        return toast;
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    getToastConfig(type) {
        const configs = {
            success: {
                color: 'green',
                icon: `
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-green-500">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                `
            },
            error: {
                color: 'red',
                icon: `
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-red-500">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                `
            },
            warning: {
                color: 'orange',
                icon: `
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-orange-500">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                `
            },
            info: {
                color: 'blue',
                icon: `
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-500">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                `
            },
            validation: {
                color: 'yellow',
                icon: `
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-yellow-500">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                `
            }
        };

        return configs[type] || configs.info;
    }

    remove(toast) {
        toast.classList.add('toast-exit');
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
            this.toasts = this.toasts.filter(t => t !== toast);
        }, 300);
    }
}

// Initialize toast manager
const toastManager = new ToastManager();

// Make toastManager available globally
window.toastManager = toastManager;

// Global function to show toast
function showToast(type, title, message, duration) {
    toastManager.show(type, title, message, duration);
}

// Make showToast available globally
window.showToast = showToast;

// Export for module use
export { toastManager, showToast };

