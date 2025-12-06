{{-- Global Toast Notification Container --}}
<div id="toast-container" class="fixed bottom-0 left-0 right-0 z-[9999] flex flex-col items-center pb-4 pointer-events-none">
    {{-- Toasts will be dynamically inserted here --}}
</div>

{{-- Toast Styles --}}
<style>
    .toast {
        min-width: 400px;
        max-width: 500px;
        margin-bottom: 1rem;
        padding: 1rem 1.25rem;
        border-radius: 0.75rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        opacity: 0;
        transform: translateY(20px) scale(0.95);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        pointer-events: auto;
        position: relative;
        z-index: 10000;
    }

    .toast-enter {
        opacity: 1;
        transform: translateY(0) scale(1);
    }

    .toast-exit {
        opacity: 0;
        transform: translateY(20px) scale(0.95);
    }

    .toast-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        background-color: #10b981 !important;
    }

    .toast-error {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
        background-color: #ef4444 !important;
    }

    .toast-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
        background-color: #f59e0b !important;
    }

    .toast-info {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
        background-color: #3b82f6 !important;
    }

    .toast-validation {
        background: linear-gradient(135deg, #eab308 0%, #ca8a04 100%) !important;
        background-color: #eab308 !important;
    }

    /* Animation for multiple toasts */
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    @keyframes slideOutDown {
        from {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
        to {
            opacity: 0;
            transform: translateY(20px) scale(0.95);
        }
    }

    /* Responsive */
    @media (max-width: 640px) {
        .toast {
            min-width: calc(100% - 2rem);
            max-width: calc(100% - 2rem);
            margin-left: 1rem;
            margin-right: 1rem;
        }
    }
</style>

