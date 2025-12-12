<div x-data="wordToPdfPanel()"  class="bg-white rounded-xl shadow-lg p-6 space-y-6">
    {{-- Initial State: Show Upload Message --}}
    <div x-show="!uploadedFileId" class="text-center py-8">
        <div class="text-gray-400 mb-4">
            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
            </svg>
        </div>
        <p class="text-gray-500">Upload a Word document to get started</p>
    </div>

    {{-- Conversion Options --}}
    <div x-show="uploadedFileId && !converting && !converted" x-cloak class="space-y-6">
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Conversion Options</h3>
            
            {{-- Page Size --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Page Size</label>
                <select x-model="pageSize" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="a4">A4</option>
                    <option value="letter">Letter</option>
                    <option value="legal">Legal</option>
                </select>
            </div>

            {{-- Orientation --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Orientation</label>
                <div class="flex gap-4">
                    <label class="flex items-center">
                        <input type="radio" x-model="orientation" value="portrait" class="mr-2">
                        <span class="text-sm text-gray-700">Portrait</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" x-model="orientation" value="landscape" class="mr-2">
                        <span class="text-sm text-gray-700">Landscape</span>
                    </label>
                </div>
            </div>

            {{-- Margins --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Margins</label>
                <select x-model="margin" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="default">Default (1 inch)</option>
                    <option value="narrow">Narrow (0.5 inch)</option>
                    <option value="wide">Wide (2 inches)</option>
                </select>
            </div>
        </div>

        {{-- Convert Button --}}
        <button 
            @click="startConvert()" 
            :disabled="!canConvert()"
            :class="canConvert() 
                ? 'w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors' 
                : 'w-full bg-gray-300 text-gray-500 font-semibold py-3 px-6 rounded-lg cursor-not-allowed'">
            Convert to PDF
        </button>
    </div>

    {{-- Converting State --}}
    <div x-show="converting" x-cloak class="text-center py-8">
        <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-blue-500 border-t-transparent mb-4"></div>
        <p class="text-gray-600 font-medium">Converting Word to PDF...</p>
        <p class="text-sm text-gray-500 mt-2">Please wait while we process your document</p>
    </div>

    {{-- Converted State --}}
    <div x-show="converted && outputFile" x-cloak class="space-y-4">
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-center mb-2">
                <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <h3 class="text-lg font-semibold text-green-800">Conversion Complete!</h3>
            </div>
            <p class="text-sm text-green-700">Your Word document has been successfully converted to PDF.</p>
        </div>

        <div class="bg-gray-50 rounded-lg p-4 space-y-2">
            <div class="flex justify-between">
                <span class="text-sm text-gray-600">File Name:</span>
                <span class="text-sm font-medium text-gray-900" x-text="outputFile.name"></span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm text-gray-600">File Size:</span>
                <span class="text-sm font-medium text-gray-900" x-text="outputFile.size"></span>
            </div>
            <div class="flex justify-between" x-show="metadata && metadata.pages">
                <span class="text-sm text-gray-600">Pages:</span>
                <span class="text-sm font-medium text-gray-900" x-text="metadata.pages"></span>
            </div>
        </div>

        <button 
            @click="downloadFile()" 
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
            Download PDF
        </button>

        {{-- Convert Again Button --}}
        <button 
            @click="converted = false; outputFile = null; metadata = null;" 
            class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-6 rounded-lg transition-colors text-sm">
            Adjust Settings & Convert Again
        </button>
    </div>

    {{-- Security Note --}}
    <div x-show="uploadedFileId" x-cloak class="mt-6 pt-6 border-t border-gray-200">
        <p class="text-xs text-gray-500 text-center">
            <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
            </svg>
            Files are automatically deleted after processing.
        </p>
    </div>
</div>

