<div x-data="typeof splitPanel === 'function' ? splitPanel() : { 
    uploadedFileId: null,
    pageCount: 0,
    selectedRanges: [],
    splitting: false,
    split: false,
    outputFile: null,
    init() {}, 
    loadPageCount() {},
    addRange() {},
    removeRange() {},
    startSplit() {},
    downloadFile() {}
}" 
x-init="init()" 
class="bg-white rounded-xl shadow-xl border border-gray-200 p-6 sticky top-6">
    
    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
        <svg class="w-6 h-6 mr-2 text-red-500" fill="currentColor" viewBox="0 0 24 24">
            <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
        </svg>
        Split PDF
    </h2>

    {{-- Initial State --}}
    <div x-show="!uploadedFileId" x-cloak class="text-center py-8">
        <div class="mb-4">
            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
            </svg>
        </div>
        <p class="text-sm text-gray-600 mb-6">Upload a PDF file to start splitting</p>
    </div>

    {{-- Page Selection --}}
    <div x-show="uploadedFileId && !splitting && !split" x-cloak class="space-y-4">
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-blue-900">Total Pages:</span>
                <span class="text-lg font-bold text-blue-600" x-text="pageCount || 'Loading...'"></span>
            </div>
        </div>

        {{-- Page Ranges --}}
        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-900">Page Ranges</h3>
                <button 
                    @click="addRange()"
                    class="text-xs px-3 py-1 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors">
                    + Add Range
                </button>
            </div>

            <template x-for="(range, index) in selectedRanges" :key="index">
                <div class="flex items-center gap-2 p-3 bg-gray-50 rounded-lg border border-gray-200">
                    <input 
                        type="number" 
                        x-model="range.start"
                        :min="1"
                        :max="pageCount"
                        placeholder="Start"
                        class="w-20 px-2 py-1 text-sm border border-gray-300 rounded focus:ring-2 focus:ring-red-500 focus:border-red-500">
                    <span class="text-gray-500">to</span>
                    <input 
                        type="number" 
                        x-model="range.end"
                        :min="range.start || 1"
                        :max="pageCount"
                        placeholder="End"
                        class="w-20 px-2 py-1 text-sm border border-gray-300 rounded focus:ring-2 focus:ring-red-500 focus:border-red-500">
                    <button 
                        @click="removeRange(index)"
                        class="ml-auto text-red-600 hover:text-red-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </template>

            <p x-show="selectedRanges.length === 0" class="text-xs text-gray-500 text-center py-4">
                Click "Add Range" to select pages to extract
            </p>
        </div>

        {{-- Split Button --}}
        <button 
            @click="startSplit()"
            :disabled="selectedRanges.length === 0"
            class="w-full px-6 py-4 bg-gradient-to-r from-red-600 to-pink-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:from-red-700 hover:to-pink-700 focus:outline-none focus:ring-4 focus:ring-red-300 focus:ring-offset-2 transition-all duration-300 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none relative overflow-hidden group">
            <span class="relative z-10 flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                </svg>
                Split PDF
            </span>
            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
        </button>
    </div>

    {{-- Splitting Status --}}
    <div x-show="splitting" x-cloak
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
                <h3 class="text-lg font-bold text-yellow-900 mb-2">Splitting PDF...</h3>
                <p class="text-sm text-yellow-700">Please wait while we extract your pages</p>
            </div>
        </div>
    </div>

    {{-- Completed Status --}}
    <div x-show="split && !splitting" x-cloak
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
                <h3 class="text-xl font-bold text-green-900 mb-2">Split Complete!</h3>
                <p class="text-sm text-green-700 mb-4" x-text="outputFile?.name || 'Your split PDF is ready'"></p>
            </div>

            <button 
                @click="downloadFile()"
                class="w-full px-6 py-4 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-4 focus:ring-green-300 focus:ring-offset-2 transition-all duration-300 transform hover:scale-105 flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Download Split PDF
            </button>
        </div>
    </div>
</div>

