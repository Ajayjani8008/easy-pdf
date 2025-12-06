<div x-data="typeof window.conversionStatus === 'function' ? window.conversionStatus() : { status: 'idle', message: '', _converting: false, _conversionTimeout: null, conversionProgress: 0, conversionTime: '0s', startTime: null, progressInterval: null, init() {}, startConversion() {} }" 
x-init="init()" 
class="space-y-4">
    {{-- Uploading Status --}}
    <div x-show="status === 'uploading'" class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-center">
            <svg class="animate-spin h-5 w-5 text-blue-600 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <div>
                <p class="text-sm font-medium text-blue-900">Uploading...</p>
                <p class="text-xs text-blue-700" x-text="message || ''"></p>
            </div>
        </div>
    </div>

    {{-- Converting Status with Progress --}}
    <div x-show="status === 'converting'" x-cloak
         class="bg-gradient-to-r from-yellow-50 to-orange-50 border-2 border-yellow-300 rounded-xl p-6 shadow-lg animate-pulse-glow"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100">
        <div class="space-y-4">
            <div class="flex items-center justify-between">
        <div class="flex items-center">
                    <div class="relative">
                        <svg class="animate-spin h-6 w-6 text-yellow-600 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-2 h-2 bg-yellow-500 rounded-full animate-ping"></div>
                        </div>
                    </div>
            <div>
                        <p class="text-sm font-bold text-yellow-900">Converting PDF to Word...</p>
                        <p class="text-xs text-yellow-700 mt-1" x-text="message || 'Processing your document...'"></p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold text-yellow-600" x-text="conversionProgress || '0'">0</div>
                    <div class="text-xs text-yellow-600">%</div>
                </div>
            </div>
            
            {{-- Animated Progress Bar --}}
            <div class="w-full bg-yellow-200 rounded-full h-3 overflow-hidden shadow-inner">
                <div class="bg-gradient-to-r from-yellow-500 to-orange-500 h-3 rounded-full transition-all duration-500 ease-out relative overflow-hidden"
                     :style="'width: ' + (conversionProgress || 0) + '%'">
                    <div class="absolute inset-0 bg-white opacity-30 animate-shimmer"></div>
                </div>
            </div>
            
            {{-- Time Elapsed --}}
            <div class="flex items-center justify-between text-xs text-yellow-700">
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span x-text="'Time: ' + (conversionTime || '0s')">Time: 0s</span>
                </span>
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Processing...
                </span>
            </div>
        </div>
    </div>

    {{-- Completed Status --}}
    <div x-show="status === 'completed'" x-cloak
         class="bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-300 rounded-xl p-6 shadow-lg"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100">
        <div class="flex items-center">
            <div class="relative">
                <svg class="h-8 w-8 text-green-600 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="absolute inset-0 bg-green-400 rounded-full animate-ping opacity-75"></div>
            </div>
            <div class="flex-1">
                <p class="text-sm font-bold text-green-900 text-lg">Conversion Complete!</p>
                <p class="text-xs text-green-700 mt-1" x-text="message || 'Your document is ready to download'"></p>
            </div>
        </div>
    </div>

    {{-- Error Status --}}
    <div x-show="status === 'error'" x-cloak
         class="bg-gradient-to-r from-red-50 to-pink-50 border-2 border-red-300 rounded-xl p-6 shadow-lg"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100">
        <div class="flex items-center">
            <svg class="h-6 w-6 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <p class="text-sm font-bold text-red-900">Error</p>
                <p class="text-xs text-red-700 mt-1" x-text="message || 'Something went wrong. Please try again.'"></p>
            </div>
        </div>
    </div>

    {{-- Convert Button (shown when file is uploaded) --}}
    <div x-show="status === 'ready'" x-cloak    
         class="space-y-2"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100">
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-xl p-4 mb-4 shadow-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-blue-600 mr-2 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                <p class="text-sm text-blue-700 font-medium" x-text="message || 'Ready to convert'"></p>
            </div>
        </div>
        <button 
            @click="startConversion()"
            :disabled="status !== 'ready' || _converting"
            class="w-full px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-4 focus:ring-blue-300 focus:ring-offset-2 transition-all duration-300 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none relative overflow-hidden group"
        >
            <span class="relative z-10 flex items-center justify-center">
                <span x-show="!(_converting || status === 'converting')" x-cloak class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
            Convert to Word
                </span>
                <span x-show="_converting || status === 'converting'" x-cloak class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Converting...
                </span>
            </span>
            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
        </button>
    </div>
    
    {{-- Debug info (remove in production) --}}
    <div class="mt-4 text-xs text-gray-400" x-show="false" x-cloak>
        Status: <span x-text="status"></span>
    </div>
</div>

