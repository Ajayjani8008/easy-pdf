@props(['toolName', 'toolDescription'])

<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-8 relative overflow-hidden">
    {{-- Animated Background Elements --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-purple-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-indigo-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        {{-- Header with Animation --}}
        <div class="text-center mb-8 animate-fade-in">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4 bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-purple-600">
                {{ $toolName }}
            </h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                {{ $toolDescription }}
            </p>
        </div>

        {{-- Main Content Area with Smooth Transitions --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Left: Upload & Preview Section (2 columns) --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="animate-slide-up">
                    <x-file-upload-area />
                </div>
                <div class="animate-slide-up animation-delay-200">
                    <x-pdf-preview-section />
                </div>
            </div>

            {{-- Right: Conversion Panel (1 column) --}}
            <div class="lg:col-span-1">
                <div class="animate-slide-up animation-delay-400">
                    <x-conversion-panel />
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Custom Animations --}}
<style>
    @keyframes blob {
        0%, 100% {
            transform: translate(0, 0) scale(1);
        }
        33% {
            transform: translate(30px, -50px) scale(1.1);
        }
        66% {
            transform: translate(-20px, 20px) scale(0.9);
        }
    }

    .animate-blob {
        animation: blob 7s infinite;
    }

    .animation-delay-2000 {
        animation-delay: 2s;
    }

    .animation-delay-4000 {
        animation-delay: 4s;
    }

    .animation-delay-200 {
        animation-delay: 200ms;
    }

    .animation-delay-400 {
        animation-delay: 400ms;
    }

    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fade-in 0.6s ease-out;
    }

    @keyframes slide-up {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-slide-up {
        animation: slide-up 0.6s ease-out;
    }

    @keyframes morph {
        0%, 100% {
            border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
        }
        50% {
            border-radius: 30% 60% 70% 40% / 50% 60% 30% 60%;
        }
    }

    .animate-morph {
        animation: morph 8s ease-in-out infinite;
    }

    @keyframes pulse-glow {
        0%, 100% {
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.5);
        }
        50% {
            box-shadow: 0 0 40px rgba(59, 130, 246, 0.8);
        }
    }

    .animate-pulse-glow {
        animation: pulse-glow 2s ease-in-out infinite;
    }

    @keyframes shimmer {
        0% {
            transform: translateX(-100%);
        }
        100% {
            transform: translateX(100%);
        }
    }

    .animate-shimmer {
        animation: shimmer 2s infinite;
    }
</style>

