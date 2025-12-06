<div x-data="fileUpload()" x-init="init()" class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
    <div 
        @dragover.prevent="isDragging = true"
        @dragleave.prevent="isDragging = false"
        @drop.prevent="handleDrop($event)"
        :class="{ 'border-blue-500 bg-blue-50': isDragging }"
        class="border-2 border-dashed rounded-lg p-12 text-center transition-colors cursor-pointer"
        :class="isDragging ? 'border-blue-500 bg-blue-50' : 'border-gray-300 bg-gray-50'"
        @click="$refs.fileInput.click()"
    >
        <input 
            type="file" 
            x-ref="fileInput"
            @change="handleFileSelect($event)"
            accept=".pdf,application/pdf"
            class="hidden"
        >
        
        <div class="text-gray-500">
            <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v20c0 4.418 7.163 8 16 8 1.381 0 2.721-.087 4-.252M8 14c0 4.418 7.163 8 16 8s16-3.582 16-8M8 14c0-4.418 7.163-8 16-8s16 3.582 16 8m0 0v14m0-4c0 4.418-7.163 8-16 8S8 28.418 8 24m32 10v6m0 0v6m0-6h6m-6 0h-6" />
            </svg>
            <p class="text-lg font-medium text-gray-900 mb-2">
                <span x-show="!selectedFile">Drop your PDF here, or click to browse</span>
                <span x-show="selectedFile" x-text="selectedFile.name"></span>
            </p>
            <p class="text-sm text-gray-500" x-show="selectedFile" x-text="selectedFile.sizeText"></p>
        </div>
    </div>

    <div x-show="selectedFile" class="mt-6 flex justify-center">
        <button 
            @click="uploadFile()"
            :disabled="uploading"
            class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all disabled:opacity-50 disabled:cursor-not-allowed"
        >
            <span x-show="!uploading">Upload PDF</span>
            <span x-show="uploading" class="flex items-center">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Uploading...
            </span>
        </button>
    </div>
</div>

