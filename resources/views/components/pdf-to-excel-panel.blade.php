<div x-data="typeof pdfToExcelPanel === 'function' ? pdfToExcelPanel() : { 
    uploadedFileId: null,
    pdfInfo: null,
    converting: false,
    converted: false,
    outputFile: null,
    metadata: null,
    extractionMode: 'automatic',
    pages: 'all',
    selectedPages: [],
    outputFormat: 'xlsx',
    keepFormatting: true,
    mergeHeaders: true,
    detectDates: true,
    detectCurrency: true,
    removeEmptyRows: true,
    removeEmptyColumns: true,
    ocrEnabled: false,
    ocrLanguage: 'eng',
    init() {},
    canConvert() { return false; },
    startConvert() {},
    downloadFile() {}
}" 
x-init="init()" 
class="bg-white rounded-xl shadow-xl border border-gray-200 p-6 sticky top-6 max-h-[90vh] overflow-y-auto">
    
    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
        <svg class="w-6 h-6 mr-2 text-green-500" fill="currentColor" viewBox="0 0 24 24">
            <path d="M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3M19,5V19H5V5H19M7,7H17V9H7V7M7,11H17V13H7V11M7,15H13V17H7V15Z" />
        </svg>
        PDF to Excel
    </h2>

    {{-- Initial State --}}
    <div x-show="!pdfInfo" x-cloak class="text-center py-8">
        <div class="mb-4">
            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
        </div>
        <p class="text-sm text-gray-600 mb-6">Upload a PDF file to start converting</p>
    </div>

    {{-- PDF Info --}}
    <div x-show="pdfInfo && !converting && !converted" x-cloak class="mb-6 animate-fade-in">
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-blue-900">File:</span>
                <span class="text-sm font-semibold text-blue-600" x-text="pdfInfo?.file_name || ''"></span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm font-medium text-blue-900">Pages:</span>
                <span class="text-sm font-semibold text-blue-600" x-text="pdfInfo?.page_count || 0"></span>
            </div>
        </div>
    </div>

    {{-- Conversion Options --}}
    <div x-show="pdfInfo && !converting && !converted" x-cloak class="space-y-4">
        {{-- Extraction Mode --}}
        <div class="space-y-3">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Extraction Mode</h3>
            <div class="space-y-2">
                <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer transition-all"
                       :class="extractionMode === 'automatic' ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-green-300'">
                    <input type="radio" name="extraction_mode" value="automatic" x-model="extractionMode" class="mr-3">
                    <div class="flex-1">
                        <span class="text-sm font-semibold text-gray-900 block">Automatic Table Detection</span>
                        <span class="text-xs text-gray-600">Auto-detects and extracts tables</span>
                    </div>
                </label>
                <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer transition-all"
                       :class="extractionMode === 'entire_page' ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-green-300'">
                    <input type="radio" name="extraction_mode" value="entire_page" x-model="extractionMode" class="mr-3">
                    <div class="flex-1">
                        <span class="text-sm font-semibold text-gray-900 block">Entire Page</span>
                        <span class="text-xs text-gray-600">Convert entire page to rows/columns</span>
                    </div>
                </label>
            </div>
        </div>

        {{-- Page Selection --}}
        <div class="space-y-3">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Pages</h3>
            <div class="space-y-2">
                <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer transition-all"
                       :class="pages === 'all' ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-green-300'">
                    <input type="radio" name="pages" value="all" x-model="pages" class="mr-3">
                    <span class="text-sm font-semibold text-gray-900">All Pages</span>
                </label>
                <div class="flex items-center gap-2">
                    <input type="text" x-model="pages" placeholder="e.g., 1, 2-5, or 3" 
                           class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm"
                           x-show="pages !== 'all'">
                </div>
            </div>
        </div>

        {{-- Output Format --}}
        <div class="space-y-3">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Output Format</h3>
            <div class="grid grid-cols-2 gap-2">
                <label class="flex flex-col items-center p-3 border-2 rounded-lg cursor-pointer transition-all"
                       :class="outputFormat === 'xlsx' ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-green-300'">
                    <input type="radio" name="output_format" value="xlsx" x-model="outputFormat" class="mb-2">
                    <span class="text-xs font-semibold text-gray-900">Excel (.xlsx)</span>
                </label>
                <label class="flex flex-col items-center p-3 border-2 rounded-lg cursor-pointer transition-all"
                       :class="outputFormat === 'csv' ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-green-300'">
                    <input type="radio" name="output_format" value="csv" x-model="outputFormat" class="mb-2">
                    <span class="text-xs font-semibold text-gray-900">CSV</span>
                </label>
            </div>
        </div>

        {{-- Table Formatting Options --}}
        <div class="space-y-3">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Formatting Options</h3>
            <div class="space-y-2">
                <label class="flex items-center">
                    <input type="checkbox" x-model="keepFormatting" class="mr-3">
                    <span class="text-sm text-gray-700">Keep formatting (borders, bold, colors)</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" x-model="mergeHeaders" class="mr-3">
                    <span class="text-sm text-gray-700">Merge multi-row headers</span>
                </label>
            </div>
        </div>

        {{-- Intelligent Data Extraction --}}
        <div class="space-y-3">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Data Detection</h3>
            <div class="space-y-2">
                <label class="flex items-center">
                    <input type="checkbox" x-model="detectDates" class="mr-3">
                    <span class="text-sm text-gray-700">Auto-detect dates</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" x-model="detectCurrency" class="mr-3">
                    <span class="text-sm text-gray-700">Auto-detect currency</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" x-model="removeEmptyRows" class="mr-3">
                    <span class="text-sm text-gray-700">Remove empty rows</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" x-model="removeEmptyColumns" class="mr-3">
                    <span class="text-sm text-gray-700">Remove empty columns</span>
                </label>
            </div>
        </div>

        {{-- OCR Support (Optional) --}}
        <div class="space-y-3 border-t pt-4">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">OCR (Advanced)</h3>
            <label class="flex items-center">
                <input type="checkbox" x-model="ocrEnabled" class="mr-3">
                <span class="text-sm text-gray-700">Enable OCR for scanned PDFs</span>
            </label>
            <select x-model="ocrLanguage" x-show="ocrEnabled" x-cloak
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                <option value="eng">English</option>
                <option value="spa">Spanish</option>
                <option value="fra">French</option>
                <option value="deu">German</option>
            </select>
        </div>

        {{-- Convert Button --}}
        <button 
            @click="startConvert()"
            :disabled="!canConvert()"
            class="w-full px-6 py-3 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all disabled:opacity-50 disabled:cursor-not-allowed mt-6"
        >
            Convert to Excel
        </button>
    </div>

    {{-- Converting State --}}
    <div x-show="converting" x-cloak class="text-center py-8">
        <div class="mb-4">
            <svg class="animate-spin mx-auto h-12 w-12 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
        <p class="text-sm font-medium text-gray-900 mb-2">Converting PDF to Excel...</p>
        <p class="text-xs text-gray-600">Reading your PDF...</p>
        <p class="text-xs text-gray-600">Detecting tables...</p>
        <p class="text-xs text-gray-600">Extracting rows & columns...</p>
        <p class="text-xs text-gray-600">Building Excel file...</p>
    </div>

    {{-- Completed State --}}
    <div x-show="converted && outputFile" x-cloak class="text-center py-8 animate-fade-in">
        <div class="mb-4">
            <svg class="mx-auto h-16 w-16 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                <path d="M21,7L9,19L3.5,13.5L4.91,12.09L9,16.17L19.59,5.59L21,7Z" />
            </svg>
        </div>
        <h3 class="text-lg font-bold text-gray-900 mb-2">Conversion Complete!</h3>
        
        <div x-show="metadata" class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4 text-left">
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-700">Rows extracted:</span>
                    <span class="font-semibold text-green-600" x-text="metadata?.rows || 0"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-700">Columns:</span>
                    <span class="font-semibold text-green-600" x-text="metadata?.columns || 0"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-700">Pages processed:</span>
                    <span class="font-semibold text-green-600" x-text="metadata?.pages || 0"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-700">File size:</span>
                    <span class="font-semibold text-green-600" x-text="outputFile?.size || ''"></span>
                </div>
            </div>
        </div>

        <button 
            @click="downloadFile()"
            class="w-full px-6 py-3 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all mb-4"
        >
            Download Excel File
        </button>

        <button 
            @click="resetState(); pdfInfo = null;"
            class="w-full px-4 py-2 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-all text-sm"
        >
            Convert Another PDF
        </button>
    </div>

    {{-- Security Note --}}
    <div class="mt-6 pt-6 border-t border-gray-200">
        <p class="text-xs text-gray-500 text-center">
            🔒 Files are automatically deleted after processing.
        </p>
    </div>
</div>

