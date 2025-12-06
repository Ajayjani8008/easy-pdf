<div x-data="typeof compressPanel === 'function' ? compressPanel() : { 
    uploadedFileId: null,
    fileInfo: null,
    compressionLevel: 'balanced',
    estimate: null,
    compressing: false,
    compressed: false,
    outputFile: null,
    compression: null,
    loadingInfo: false,
    init() {}, 
    resetState() {},
    loadFileInfo() {},
    onLevelChange() {},
    startCompress() {},
    downloadFile() {},
    recompress() {},
    formatBytes() {}
}" 
x-init="init()" 
class="bg-white rounded-xl shadow-xl border border-gray-200 p-6 sticky top-6">
    
    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
        <svg class="w-6 h-6 mr-2 text-green-500" fill="currentColor" viewBox="0 0 24 24">
            <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
        </svg>
        Compress PDF
    </h2>

    {{-- Initial State --}}
    <div x-show="!uploadedFileId" x-cloak class="text-center py-8">
        <div class="mb-4">
            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
            </svg>
        </div>
        <p class="text-sm text-gray-600 mb-6">Upload a PDF file to start compressing</p>
        <p class="text-xs text-gray-500">Max file size: 50MB</p>
    </div>

    {{-- Compression Level Selection & Preview --}}
    <div x-show="uploadedFileId && !compressing && !compressed" x-cloak class="space-y-4">
        {{-- File Info --}}
        <div x-show="fileInfo" class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4 animate-fade-in">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-blue-900">Original Size:</span>
                <span class="text-lg font-bold text-blue-600" x-text="fileInfo?.readable_size || 'Loading...'"></span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm font-medium text-blue-900">Pages:</span>
                <span class="text-sm font-semibold text-blue-600" x-text="fileInfo?.pages || '0'"></span>
            </div>
        </div>

        {{-- Compression Levels --}}
        <div class="space-y-3">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Compression Level</h3>
            
            {{-- High Compression --}}
            <label class="flex items-start p-4 border-2 rounded-lg cursor-pointer transition-all hover:shadow-md"
                   :class="compressionLevel === 'high' ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-green-300'">
                <input type="radio" name="compression_level" value="high" x-model="compressionLevel" @change="onLevelChange()" class="mt-1 mr-3">
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-1">
                        <span class="font-semibold text-gray-900">High Compression</span>
                        <span class="text-xs px-2 py-1 bg-red-100 text-red-600 rounded">Maximum</span>
                    </div>
                    <p class="text-xs text-gray-600 mb-2">Maximum reduction, Medium/Low quality</p>
                    <p class="text-xs text-gray-500">Ideal for: Email, WhatsApp</p>
                </div>
            </label>

            {{-- Balanced (Recommended) --}}
            <label class="flex items-start p-4 border-2 rounded-lg cursor-pointer transition-all hover:shadow-md"
                   :class="compressionLevel === 'balanced' ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-green-300'">
                <input type="radio" name="compression_level" value="balanced" x-model="compressionLevel" @change="onLevelChange()" class="mt-1 mr-3">
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-1">
                        <span class="font-semibold text-gray-900">Recommended (Balanced)</span>
                        <span class="text-xs px-2 py-1 bg-green-100 text-green-600 rounded">Recommended</span>
                    </div>
                    <p class="text-xs text-gray-600 mb-2">Medium reduction, Good quality</p>
                    <p class="text-xs text-gray-500">Ideal for: Official work</p>
                </div>
            </label>

            {{-- Low Compression (Best Quality) --}}
            <label class="flex items-start p-4 border-2 rounded-lg cursor-pointer transition-all hover:shadow-md"
                   :class="compressionLevel === 'low' ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-green-300'">
                <input type="radio" name="compression_level" value="low" x-model="compressionLevel" @change="onLevelChange()" class="mt-1 mr-3">
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-1">
                        <span class="font-semibold text-gray-900">Low Compression (Best Quality)</span>
                        <span class="text-xs px-2 py-1 bg-blue-100 text-blue-600 rounded">Best Quality</span>
                    </div>
                    <p class="text-xs text-gray-600 mb-2">Small reduction, High quality</p>
                    <p class="text-xs text-gray-500">Ideal for: Printing, Office docs</p>
                </div>
            </label>
        </div>

        {{-- Compression Preview --}}
        <div x-show="estimate" class="bg-gradient-to-r from-purple-50 to-pink-50 border-2 border-purple-200 rounded-xl p-4 animate-slide-up">
            <h4 class="text-sm font-semibold text-purple-900 mb-3 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                </svg>
                Compression Preview
            </h4>
            <div class="space-y-2">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-700">From:</span>
                    <span class="font-bold text-gray-900" x-text="formatBytes(estimate?.original_size)"></span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-700">To (estimated):</span>
                    <span class="font-bold text-green-600" x-text="formatBytes(estimate?.estimated_size)"></span>
                </div>
                <div class="flex items-center justify-between text-sm pt-2 border-t border-purple-200">
                    <span class="text-gray-700">Savings:</span>
                    <span class="font-bold text-purple-600" x-text="estimate?.saved_percentage + '% smaller'"></span>
                </div>
            </div>
        </div>

        {{-- Compress Button --}}
        <button 
            @click="startCompress()"
            :disabled="loadingInfo || !estimate"
            class="w-full px-6 py-4 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-4 focus:ring-green-300 focus:ring-offset-2 transition-all duration-300 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none relative overflow-hidden group">
            <span class="relative z-10 flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Compress PDF
            </span>
            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
        </button>

        {{-- Security Message --}}
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 mt-4">
            <p class="text-xs text-gray-600 flex items-center">
                <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                </svg>
                Your files are deleted automatically after processing.
            </p>
        </div>
    </div>

    {{-- Compressing Status --}}
    <div x-show="compressing" x-cloak
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
                <h3 class="text-lg font-bold text-yellow-900 mb-2">Compressing PDF...</h3>
                <div class="space-y-2 text-sm text-yellow-700">
                    <p class="animate-pulse">Analyzing PDF...</p>
                    <p class="animate-pulse animation-delay-200">Optimizing images...</p>
                    <p class="animate-pulse animation-delay-400">Rebuilding compressed PDF...</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Completed Status --}}
    <div x-show="compressed && !compressing" x-cloak
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
                <h3 class="text-xl font-bold text-green-900 mb-2">Compression Complete!</h3>
                <p class="text-sm text-green-700 mb-4" x-text="outputFile?.name || 'Your compressed PDF is ready'"></p>
            </div>

            {{-- Compare View --}}
            <div x-show="compression" class="bg-white rounded-lg p-4 mb-4 border border-green-200">
                <h4 class="text-sm font-semibold text-gray-900 mb-3 text-center">Size Comparison</h4>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Original Size:</span>
                        <span class="text-sm font-bold text-gray-900" x-text="compression?.original_size || '0 Bytes'"></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Compressed Size:</span>
                        <span class="text-sm font-bold text-green-600" x-text="outputFile?.size || '0 Bytes'"></span>
                    </div>
                    <div class="flex items-center justify-between pt-2 border-t border-gray-200">
                        <span class="text-sm font-semibold text-gray-900">Saved:</span>
                        <span class="text-sm font-bold text-purple-600" 
                              x-text="compression?.saved_percentage + '% (' + outputFile?.saved_bytes + ' smaller!)'"></span>
                    </div>
                </div>
            </div>

            <button 
                @click="downloadFile()"
                class="w-full px-6 py-4 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-4 focus:ring-green-300 focus:ring-offset-2 transition-all duration-300 transform hover:scale-105 flex items-center justify-center mb-3">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Download Compressed PDF
            </button>

            {{-- Re-Compress Options --}}
            <div class="border-t border-green-200 pt-4 mt-4">
                <p class="text-xs text-gray-600 mb-2 text-center">Try different compression:</p>
                <div class="grid grid-cols-2 gap-2">
                    <button 
                        @click="recompress('high')"
                        class="px-3 py-2 text-xs bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                        Try Stronger
                    </button>
                    <button 
                        @click="recompress('low')"
                        class="px-3 py-2 text-xs bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                        Try Higher Quality
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in { animation: fade-in 0.6s ease-out; }
    @keyframes slide-up {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-slide-up { animation: slide-up 0.6s ease-out; }
    .animation-delay-200 { animation-delay: 200ms; }
    .animation-delay-400 { animation-delay: 400ms; }
</style>

