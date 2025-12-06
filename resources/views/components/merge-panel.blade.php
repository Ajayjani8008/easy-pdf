<div x-data="typeof mergePanel === 'function' ? mergePanel() : { 
    merging: false, 
    merged: false, 
    outputFile: null, 
    progress: 0, 
    init() {}, 
    startMerge() {}, 
    downloadFile() {} 
}" 
x-init="init()" 
class="bg-white rounded-xl shadow-xl border border-gray-200 p-6 sticky top-6">
    
    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
        <svg class="w-6 h-6 mr-2 text-red-500" fill="currentColor" viewBox="0 0 24 24">
            <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
        </svg>
        Merge PDF
    </h2>

    {{-- Initial State --}}
    <div x-show="!merging && !merged" class="text-center py-8">
        <div class="mb-4">
            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
            </svg>
        </div>
        <p class="text-sm text-gray-600 mb-6">Upload at least 2 PDF files to start merging</p>
        
        {{-- Merge Button --}}
        <button 
            @click="startMerge()"
            :disabled="!canMerge()"
            class="w-full px-6 py-4 bg-gradient-to-r from-red-600 to-pink-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:from-red-700 hover:to-pink-700 focus:outline-none focus:ring-4 focus:ring-red-300 focus:ring-offset-2 transition-all duration-300 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none relative overflow-hidden group"
            x-show="canMerge()"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100">
            <span class="relative z-10 flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                </svg>
                Merge PDFs
            </span>
            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
        </button>
    </div>

    {{-- Merging Status with Progress --}}
    <div x-show="merging" 
         class="space-y-4"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100">
        
        <div class="bg-gradient-to-r from-yellow-50 to-orange-50 border-2 border-yellow-300 rounded-xl p-6 shadow-lg">
            <div class="text-center mb-4">
                <div class="relative inline-block mb-4">
                    <svg class="animate-spin h-12 w-12 text-yellow-600" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-6 h-6 bg-yellow-500 rounded-full animate-ping"></div>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-yellow-900 mb-2">Merging PDFs...</h3>
                <p class="text-sm text-yellow-700">Please wait while we combine your files</p>
            </div>

            {{-- Progress Bar --}}
            <div class="w-full bg-yellow-200 rounded-full h-3 overflow-hidden shadow-inner mb-4">
                <div class="bg-gradient-to-r from-yellow-500 to-orange-500 h-3 rounded-full transition-all duration-500 ease-out relative overflow-hidden"
                     :style="'width: ' + progress + '%'">
                    <div class="absolute inset-0 bg-white opacity-30 animate-shimmer"></div>
                </div>
            </div>

            <div class="text-center">
                <span class="text-2xl font-bold text-yellow-600" x-text="progress"></span>
                <span class="text-yellow-600">%</span>
            </div>

            {{-- Steps Indicator --}}
            <div class="mt-6 space-y-2">
                <div class="flex items-center text-sm">
                    <div class="w-6 h-6 rounded-full bg-green-500 flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <span class="text-gray-700">Validating PDF files</span>
                </div>
                <div class="flex items-center text-sm" :class="progress > 30 ? 'text-gray-700' : 'text-gray-400'">
                    <div class="w-6 h-6 rounded-full mr-3 flex items-center justify-center"
                         :class="progress > 30 ? 'bg-green-500' : 'bg-gray-300'">
                        <svg x-show="progress > 30" class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <div x-show="progress <= 30" class="w-2 h-2 bg-white rounded-full"></div>
                    </div>
                    <span>Reading PDF content</span>
                </div>
                <div class="flex items-center text-sm" :class="progress > 60 ? 'text-gray-700' : 'text-gray-400'">
                    <div class="w-6 h-6 rounded-full mr-3 flex items-center justify-center"
                         :class="progress > 60 ? 'bg-green-500' : 'bg-gray-300'">
                        <svg x-show="progress > 60" class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <div x-show="progress <= 60" class="w-2 h-2 bg-white rounded-full"></div>
                    </div>
                    <span>Combining pages</span>
                </div>
                <div class="flex items-center text-sm" :class="progress >= 100 ? 'text-gray-700' : 'text-gray-400'">
                    <div class="w-6 h-6 rounded-full mr-3 flex items-center justify-center"
                         :class="progress >= 100 ? 'bg-green-500' : 'bg-gray-300'">
                        <svg x-show="progress >= 100" class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <div x-show="progress < 100" class="w-2 h-2 bg-white rounded-full"></div>
                    </div>
                    <span>Finalizing merged PDF</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Completed Status --}}
    <div x-show="merged && !merging" 
         class="space-y-4"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100">
        
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-300 rounded-xl p-6 shadow-lg">
            <div class="text-center mb-4">
                <div class="relative inline-block mb-4">
                    <svg class="h-16 w-16 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="absolute inset-0 bg-green-400 rounded-full animate-ping opacity-75"></div>
                </div>
                <h3 class="text-xl font-bold text-green-900 mb-2">Merge Complete!</h3>
                <p class="text-sm text-green-700 mb-4" x-text="outputFile?.name || 'Your merged PDF is ready'"></p>
            </div>

            <button 
                @click="downloadFile()"
                class="w-full px-6 py-4 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-4 focus:ring-green-300 focus:ring-offset-2 transition-all duration-300 transform hover:scale-105 flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Download Merged PDF
            </button>
        </div>
    </div>
</div>

<style>
    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }
    .animate-shimmer {
        animation: shimmer 2s infinite;
    }
</style>

