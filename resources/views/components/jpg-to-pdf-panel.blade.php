<div x-data="typeof jpgToPdfPanel === 'function' ? jpgToPdfPanel() : { 
    uploadedImages: [],
    converting: false,
    converted: false,
    outputFile: null,
    conversion: null,
    pageSize: 'a4',
    orientation: 'portrait',
    fitMode: 'fit',
    margin: 'small',
    customMargin: 10,
    customWidth: null,
    customHeight: null,
    compression: 'balanced',
    showCustomSize: false,
    showCustomMargin: false,
    init() {},
    canConvert() { return false; },
    startConvert() {},
    downloadFile() {}
}" 
x-init="init()" 
class="bg-white rounded-xl shadow-xl border border-gray-200 p-6 sticky top-6 max-h-[90vh] overflow-y-auto">
    
    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
        <svg class="w-6 h-6 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
            <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
        </svg>
        JPG to PDF
    </h2>

    {{-- Initial State --}}
    <div x-show="uploadedImages.length === 0" x-cloak class="text-center py-8">
        <div class="mb-4">
            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
        </div>
        <p class="text-sm text-gray-600 mb-6">Upload images to start converting</p>
        <p class="text-xs text-gray-500">Max 50MB per image • Max 50 images</p>
    </div>

    {{-- Conversion Options --}}
    <div x-show="uploadedImages.length > 0 && !converting" x-cloak class="space-y-4">
        {{-- Images Count --}}
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4 animate-fade-in">
            <div class="flex items-center justify-between">
                <span class="text-sm font-medium text-blue-900">Images:</span>
                <span class="text-lg font-bold text-blue-600" x-text="uploadedImages.length"></span>
            </div>
        </div>

        {{-- Page Size --}}
        <div class="space-y-3">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Page Size</h3>
            <div class="grid grid-cols-2 gap-2">
                <label class="flex flex-col items-center p-3 border-2 rounded-lg cursor-pointer transition-all"
                       :class="pageSize === 'a4' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-blue-300'">
                    <input type="radio" name="page_size" value="a4" x-model="pageSize" class="mb-2">
                    <span class="text-xs font-semibold text-gray-900">A4</span>
                </label>
                <label class="flex flex-col items-center p-3 border-2 rounded-lg cursor-pointer transition-all"
                       :class="pageSize === 'letter' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-blue-300'">
                    <input type="radio" name="page_size" value="letter" x-model="pageSize" class="mb-2">
                    <span class="text-xs font-semibold text-gray-900">Letter</span>
                </label>
                <label class="flex flex-col items-center p-3 border-2 rounded-lg cursor-pointer transition-all"
                       :class="pageSize === 'original' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-blue-300'">
                    <input type="radio" name="page_size" value="original" x-model="pageSize" class="mb-2">
                    <span class="text-xs font-semibold text-gray-900">Original</span>
                </label>
                <label class="flex flex-col items-center p-3 border-2 rounded-lg cursor-pointer transition-all"
                       :class="pageSize === 'custom' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-blue-300'"
                       @click="showCustomSize = !showCustomSize">
                    <input type="radio" name="page_size" value="custom" x-model="pageSize" class="mb-2">
                    <span class="text-xs font-semibold text-gray-900">Custom</span>
                </label>
            </div>
            {{-- Custom Size Inputs --}}
            <div x-show="pageSize === 'custom'" x-cloak class="mt-2 grid grid-cols-2 gap-2">
                <input type="number" x-model="customWidth" placeholder="Width (mm)" class="px-3 py-2 border border-gray-300 rounded-lg text-sm" min="50" max="500">
                <input type="number" x-model="customHeight" placeholder="Height (mm)" class="px-3 py-2 border border-gray-300 rounded-lg text-sm" min="50" max="500">
            </div>
        </div>

        {{-- Orientation --}}
        <div class="space-y-3">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Orientation</h3>
            <div class="grid grid-cols-2 gap-2">
                <label class="flex flex-col items-center p-3 border-2 rounded-lg cursor-pointer transition-all"
                       :class="orientation === 'portrait' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-blue-300'">
                    <input type="radio" name="orientation" value="portrait" x-model="orientation" class="mb-2">
                    <span class="text-xs font-semibold text-gray-900">Portrait</span>
                </label>
                <label class="flex flex-col items-center p-3 border-2 rounded-lg cursor-pointer transition-all"
                       :class="orientation === 'landscape' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-blue-300'">
                    <input type="radio" name="orientation" value="landscape" x-model="orientation" class="mb-2">
                    <span class="text-xs font-semibold text-gray-900">Landscape</span>
                </label>
            </div>
        </div>

        {{-- Fit Mode --}}
        <div class="space-y-3">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Image Fit</h3>
            <div class="space-y-2">
                <label class="flex items-start p-3 border-2 rounded-lg cursor-pointer transition-all"
                       :class="fitMode === 'fit' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-blue-300'">
                    <input type="radio" name="fit_mode" value="fit" x-model="fitMode" class="mt-1 mr-3">
                    <div>
                        <span class="text-sm font-semibold text-gray-900">Fit to Page</span>
                        <p class="text-xs text-gray-600">Maintains aspect ratio</p>
                    </div>
                </label>
                <label class="flex items-start p-3 border-2 rounded-lg cursor-pointer transition-all"
                       :class="fitMode === 'fill' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-blue-300'">
                    <input type="radio" name="fit_mode" value="fill" x-model="fitMode" class="mt-1 mr-3">
                    <div>
                        <span class="text-sm font-semibold text-gray-900">Fill Page</span>
                        <p class="text-xs text-gray-600">May crop if needed</p>
                    </div>
                </label>
                <label class="flex items-start p-3 border-2 rounded-lg cursor-pointer transition-all"
                       :class="fitMode === 'original' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-blue-300'">
                    <input type="radio" name="fit_mode" value="original" x-model="fitMode" class="mt-1 mr-3">
                    <div>
                        <span class="text-sm font-semibold text-gray-900">Original Size</span>
                        <p class="text-xs text-gray-600">May exceed page margins</p>
                    </div>
                </label>
            </div>
        </div>

        {{-- Margins --}}
        <div class="space-y-3">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Margins</h3>
            <div class="grid grid-cols-2 gap-2">
                <label class="flex flex-col items-center p-3 border-2 rounded-lg cursor-pointer transition-all"
                       :class="margin === 'none' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-blue-300'">
                    <input type="radio" name="margin" value="none" x-model="margin" class="mb-2">
                    <span class="text-xs font-semibold text-gray-900">None</span>
                </label>
                <label class="flex flex-col items-center p-3 border-2 rounded-lg cursor-pointer transition-all"
                       :class="margin === 'small' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-blue-300'">
                    <input type="radio" name="margin" value="small" x-model="margin" class="mb-2">
                    <span class="text-xs font-semibold text-gray-900">Small</span>
                </label>
                <label class="flex flex-col items-center p-3 border-2 rounded-lg cursor-pointer transition-all"
                       :class="margin === 'medium' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-blue-300'">
                    <input type="radio" name="margin" value="medium" x-model="margin" class="mb-2">
                    <span class="text-xs font-semibold text-gray-900">Medium</span>
                </label>
                <label class="flex flex-col items-center p-3 border-2 rounded-lg cursor-pointer transition-all"
                       :class="margin === 'custom' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-blue-300'"
                       @click="showCustomMargin = !showCustomMargin">
                    <input type="radio" name="margin" value="custom" x-model="margin" class="mb-2">
                    <span class="text-xs font-semibold text-gray-900">Custom</span>
                </label>
            </div>
            {{-- Custom Margin Input --}}
            <div x-show="margin === 'custom'" x-cloak class="mt-2">
                <input type="number" x-model="customMargin" placeholder="Margin (mm)" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" min="0" max="50">
            </div>
        </div>

        {{-- Compression --}}
        <div class="space-y-3">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Compression</h3>
            <div class="grid grid-cols-3 gap-2">
                <label class="flex flex-col items-center p-3 border-2 rounded-lg cursor-pointer transition-all"
                       :class="compression === 'high' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-blue-300'">
                    <input type="radio" name="compression" value="high" x-model="compression" class="mb-2">
                    <span class="text-xs font-semibold text-gray-900">High Quality</span>
                </label>
                <label class="flex flex-col items-center p-3 border-2 rounded-lg cursor-pointer transition-all"
                       :class="compression === 'balanced' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-blue-300'">
                    <input type="radio" name="compression" value="balanced" x-model="compression" class="mb-2">
                    <span class="text-xs font-semibold text-gray-900">Balanced</span>
                </label>
                <label class="flex flex-col items-center p-3 border-2 rounded-lg cursor-pointer transition-all"
                       :class="compression === 'small' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-blue-300'">
                    <input type="radio" name="compression" value="small" x-model="compression" class="mb-2">
                    <span class="text-xs font-semibold text-gray-900">Small Size</span>
                </label>
            </div>
        </div>

        {{-- Convert Button --}}
        <button 
            @click="startConvert()"
            :disabled="!canConvert()"
            class="w-full px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-4 focus:ring-blue-300 focus:ring-offset-2 transition-all duration-300 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none relative overflow-hidden group">
            <span class="relative z-10 flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Convert to PDF
            </span>
            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
        </button>

        {{-- Security Message --}}
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
            <p class="text-xs text-gray-600 flex items-center">
                <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                </svg>
                Files are automatically deleted after processing.
            </p>
        </div>
    </div>

    {{-- Converting Status --}}
    <div x-show="converting" x-cloak
         class="space-y-4"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100">
        
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-300 rounded-xl p-6 shadow-lg">
            <div class="text-center mb-4">
                <div class="relative inline-block mb-4">
                    <svg class="animate-spin h-12 w-12 text-blue-600" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-6 h-6 bg-blue-500 rounded-full animate-ping"></div>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-blue-900 mb-2">Converting Images to PDF...</h3>
                <div class="space-y-2 text-sm text-blue-700">
                    <p class="animate-pulse">Processing images...</p>
                    <p class="animate-pulse animation-delay-200">Building PDF...</p>
                    <p class="animate-pulse animation-delay-400">Finalizing...</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Completed Status --}}
    <div x-show="converted && !converting" x-cloak
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
                <h3 class="text-xl font-bold text-green-900 mb-2">Conversion Complete!</h3>
                <p class="text-sm text-green-700 mb-4" x-text="outputFile?.name || 'Your PDF is ready'"></p>
            </div>

            {{-- Conversion Summary --}}
            <div x-show="conversion" class="bg-white rounded-lg p-4 mb-4 border border-green-200">
                <h4 class="text-sm font-semibold text-gray-900 mb-3 text-center">Conversion Summary</h4>
                <div class="space-y-2 text-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Images:</span>
                        <span class="font-semibold text-green-600" x-text="conversion?.image_count || 0"></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Pages:</span>
                        <span class="font-semibold text-gray-900" x-text="conversion?.page_count || 0"></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">File Size:</span>
                        <span class="font-semibold text-gray-900" x-text="conversion?.file_size || '0 Bytes'"></span>
                    </div>
                </div>
            </div>

            <div class="space-y-3">
                <button 
                    @click="downloadFile()"
                    class="w-full px-6 py-4 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-4 focus:ring-green-300 focus:ring-offset-2 transition-all duration-300 transform hover:scale-105 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Download PDF
                </button>
                
                <button 
                    @click="resetState()"
                    class="w-full px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 focus:outline-none focus:ring-4 focus:ring-gray-300 focus:ring-offset-2 transition-all duration-300">
                    Adjust Settings & Convert Again
                </button>
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
    .animation-delay-200 { animation-delay: 200ms; }
    .animation-delay-400 { animation-delay: 400ms; }
</style>

