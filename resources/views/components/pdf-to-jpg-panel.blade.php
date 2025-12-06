<div x-data="typeof pdfToJpgPanel === 'function' ? pdfToJpgPanel() : { 
    uploadedFileId: null,
    pageCount: 0,
    conversionMode: 'pages',
    quality: 'medium',
    dpi: 150,
    pageRanges: [],
    selectedPages: [],
    converting: false,
    converted: false,
    outputFile: null,
    conversion: null,
    loadingPageCount: false,
    init() {}, 
    resetState() {},
    loadPageCount() {},
    togglePageSelection() {},
    selectAllPages() {},
    deselectAllPages() {},
    getPageRanges() {},
    startConvert() {},
    downloadFile() {}
}" 
x-init="init()" 
class="bg-white rounded-xl shadow-xl border border-gray-200 p-6 sticky top-6 max-h-[90vh] overflow-y-auto">
    
    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
        <svg class="w-6 h-6 mr-2 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
            <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
        </svg>
        PDF to JPG
    </h2>

    {{-- Initial State --}}
    <div x-show="!uploadedFileId" x-cloak class="text-center py-8">
        <div class="mb-4">
            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
            </svg>
        </div>
        <p class="text-sm text-gray-600 mb-6">Upload a PDF file to start converting</p>
        <p class="text-xs text-gray-500">Max file size: 50MB</p>
    </div>

    {{-- Conversion Options --}}
    <div x-show="uploadedFileId && !converting && !converted" x-cloak class="space-y-4">
        {{-- File Info --}}
        <div x-show="pageCount > 0" class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4 animate-fade-in">
            <div class="flex items-center justify-between">
                <span class="text-sm font-medium text-blue-900">Total Pages:</span>
                <span class="text-lg font-bold text-blue-600" x-text="pageCount || 'Loading...'"></span>
            </div>
        </div>

        {{-- Conversion Mode Selection --}}
        <div class="space-y-3">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Conversion Mode</h3>
            
            {{-- Convert Every Page to JPG --}}
            <label class="flex items-start p-4 border-2 rounded-lg cursor-pointer transition-all hover:shadow-md"
                   :class="conversionMode === 'pages' ? 'border-yellow-500 bg-yellow-50' : 'border-gray-200 hover:border-yellow-300'">
                <input type="radio" name="conversion_mode" value="pages" x-model="conversionMode" class="mt-1 mr-3">
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-1">
                        <span class="font-semibold text-gray-900">Convert Every Page to JPG</span>
                        <span class="text-xs px-2 py-1 bg-yellow-100 text-yellow-600 rounded">1 JPG per page</span>
                    </div>
                    <p class="text-xs text-gray-600">Output: 1 JPG per page (ZIP if multiple pages)</p>
                </div>
            </label>

            {{-- Extract Only Images --}}
            <label class="flex items-start p-4 border-2 rounded-lg cursor-pointer transition-all hover:shadow-md"
                   :class="conversionMode === 'images' ? 'border-yellow-500 bg-yellow-50' : 'border-gray-200 hover:border-yellow-300'">
                <input type="radio" name="conversion_mode" value="images" x-model="conversionMode" class="mt-1 mr-3">
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-1">
                        <span class="font-semibold text-gray-900">Extract Only Images from PDF</span>
                        <span class="text-xs px-2 py-1 bg-blue-100 text-blue-600 rounded">Original quality</span>
                    </div>
                    <p class="text-xs text-gray-600">Output: All embedded images (ZIP if multiple)</p>
                </div>
            </label>
        </div>

        {{-- Page Range Selection (only for pages mode) --}}
        <div x-show="conversionMode === 'pages' && pageCount > 0" class="space-y-3">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-900">Page Selection</h3>
                <div class="flex gap-2">
                    <button @click="selectAllPages()" class="text-xs px-2 py-1 bg-gray-100 text-gray-700 rounded hover:bg-gray-200">All</button>
                    <button @click="deselectAllPages()" class="text-xs px-2 py-1 bg-gray-100 text-gray-700 rounded hover:bg-gray-200">None</button>
                </div>
            </div>

            {{-- Page Thumbnail Grid --}}
            <div class="grid grid-cols-5 gap-2 max-h-48 overflow-y-auto p-2 bg-gray-50 rounded-lg border border-gray-200">
                <template x-for="page in Array.from({length: pageCount}, (_, i) => i + 1)" :key="page">
                    <button 
                        @click="togglePageSelection(page)"
                        class="aspect-square border-2 rounded-lg p-2 text-xs font-semibold transition-all hover:scale-105"
                        :class="selectedPages.includes(page) ? 'border-yellow-500 bg-yellow-100 text-yellow-700' : 'border-gray-300 bg-white text-gray-600 hover:border-yellow-300'">
                        <span x-text="page"></span>
                    </button>
                </template>
            </div>
            <p class="text-xs text-gray-500 text-center" x-text="`${selectedPages.length} of ${pageCount} pages selected`"></p>
        </div>

        {{-- Image Quality Options --}}
        <div class="space-y-3">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Image Quality</h3>
            
            <div class="grid grid-cols-3 gap-2">
                <label class="flex flex-col items-center p-3 border-2 rounded-lg cursor-pointer transition-all"
                       :class="quality === 'high' ? 'border-yellow-500 bg-yellow-50' : 'border-gray-200 hover:border-yellow-300'">
                    <input type="radio" name="quality" value="high" x-model="quality" class="mb-2">
                    <span class="text-xs font-semibold text-gray-900">High</span>
                    <span class="text-xs text-gray-500">Best</span>
                </label>
                <label class="flex flex-col items-center p-3 border-2 rounded-lg cursor-pointer transition-all"
                       :class="quality === 'medium' ? 'border-yellow-500 bg-yellow-50' : 'border-gray-200 hover:border-yellow-300'">
                    <input type="radio" name="quality" value="medium" x-model="quality" class="mb-2">
                    <span class="text-xs font-semibold text-gray-900">Medium</span>
                    <span class="text-xs text-gray-500">Recommended</span>
                </label>
                <label class="flex flex-col items-center p-3 border-2 rounded-lg cursor-pointer transition-all"
                       :class="quality === 'low' ? 'border-yellow-500 bg-yellow-50' : 'border-gray-200 hover:border-yellow-300'">
                    <input type="radio" name="quality" value="low" x-model="quality" class="mb-2">
                    <span class="text-xs font-semibold text-gray-900">Low</span>
                    <span class="text-xs text-gray-500">Fastest</span>
                </label>
            </div>
        </div>

        {{-- DPI Settings --}}
        <div class="space-y-3">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">DPI Settings</h3>
            
            <div class="grid grid-cols-3 gap-2">
                <label class="flex flex-col items-center p-3 border-2 rounded-lg cursor-pointer transition-all"
                       :class="dpi == 72 ? 'border-yellow-500 bg-yellow-50' : 'border-gray-200 hover:border-yellow-300'">
                    <input type="radio" name="dpi" value="72" x-model.number="dpi" class="mb-2">
                    <span class="text-xs font-semibold text-gray-900">72 DPI</span>
                    <span class="text-xs text-gray-500">Fast, small</span>
                </label>
                <label class="flex flex-col items-center p-3 border-2 rounded-lg cursor-pointer transition-all"
                       :class="dpi == 150 ? 'border-yellow-500 bg-yellow-50' : 'border-gray-200 hover:border-yellow-300'">
                    <input type="radio" name="dpi" value="150" x-model.number="dpi" class="mb-2">
                    <span class="text-xs font-semibold text-gray-900">150 DPI</span>
                    <span class="text-xs text-gray-500">Recommended</span>
                </label>
                <label class="flex flex-col items-center p-3 border-2 rounded-lg cursor-pointer transition-all"
                       :class="dpi == 300 ? 'border-yellow-500 bg-yellow-50' : 'border-gray-200 hover:border-yellow-300'">
                    <input type="radio" name="dpi" value="300" x-model.number="dpi" class="mb-2">
                    <span class="text-xs font-semibold text-gray-900">300 DPI</span>
                    <span class="text-xs text-gray-500">Print quality</span>
                </label>
            </div>
        </div>

        {{-- Convert Button --}}
        <button 
            @click="startConvert()"
            :disabled="loadingPageCount || (conversionMode === 'pages' && selectedPages.length === 0)"
            class="w-full px-6 py-4 bg-gradient-to-r from-yellow-600 to-orange-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:from-yellow-700 hover:to-orange-700 focus:outline-none focus:ring-4 focus:ring-yellow-300 focus:ring-offset-2 transition-all duration-300 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none relative overflow-hidden group">
            <span class="relative z-10 flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Convert to JPG
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
                <h3 class="text-lg font-bold text-yellow-900 mb-2">Converting PDF to JPG...</h3>
                <div class="space-y-2 text-sm text-yellow-700">
                    <p class="animate-pulse">Reading PDF...</p>
                    <p class="animate-pulse animation-delay-200" x-show="conversionMode === 'pages'">Rendering pages...</p>
                    <p class="animate-pulse animation-delay-400">Converting to JPG...</p>
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
                <p class="text-sm text-green-700 mb-4" x-text="outputFile?.name || 'Your JPG files are ready'"></p>
            </div>

            {{-- Conversion Summary --}}
            <div x-show="conversion" class="bg-white rounded-lg p-4 mb-4 border border-green-200">
                <h4 class="text-sm font-semibold text-gray-900 mb-3 text-center">Conversion Summary</h4>
                <div class="space-y-2 text-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Mode:</span>
                        <span class="font-semibold text-gray-900" x-text="conversion?.mode === 'pages' ? 'Pages to JPG' : 'Extract Images'"></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Converted:</span>
                        <span class="font-semibold text-green-600" x-text="conversion?.converted_count + ' ' + (conversion?.mode === 'pages' ? 'pages' : 'images')"></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Quality:</span>
                        <span class="font-semibold text-gray-900" x-text="conversion?.quality"></span>
                    </div>
                    <div class="flex items-center justify-between" x-show="conversion?.dpi">
                        <span class="text-gray-600">DPI:</span>
                        <span class="font-semibold text-gray-900" x-text="conversion?.dpi"></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Format:</span>
                        <span class="font-semibold text-gray-900" x-text="conversion?.is_zip ? 'ZIP Archive' : 'Single JPG'"></span>
                    </div>
                </div>
            </div>

            <button 
                @click="downloadFile()"
                class="w-full px-6 py-4 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-4 focus:ring-green-300 focus:ring-offset-2 transition-all duration-300 transform hover:scale-105 flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Download <span x-text="conversion?.is_zip ? 'ZIP' : 'JPG'"></span>
            </button>
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

