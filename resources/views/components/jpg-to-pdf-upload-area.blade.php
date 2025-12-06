<div x-data="typeof jpgToPdfUpload === 'function' ? jpgToPdfUpload() : { 
    isDragging: false, 
    selectedFiles: [], 
    uploading: false, 
    uploadedImages: [],
    maxFiles: 50,
    init() {},
    handleDrop() {},
    handleFileSelect() {},
    removeImage() {},
    reorderImages() {},
    moveUp() {},
    moveDown() {}
}" 
x-init="init()" 
class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
    
    {{-- Upload Area --}}
    <div 
        @dragover.prevent="isDragging = true"
        @dragleave.prevent="isDragging = false"
        @drop.prevent="handleDrop($event)"
        :class="{ 'border-blue-500 bg-blue-50': isDragging }"
        class="border-2 border-dashed rounded-lg p-12 text-center transition-all duration-300 cursor-pointer"
        :class="isDragging ? 'border-blue-500 bg-blue-50 scale-105' : 'border-gray-300 bg-gray-50'"
        @click="$refs.fileInput.click()"
    >
        <input 
            type="file" 
            x-ref="fileInput"
            @change="handleFileSelect($event)"
            accept="image/jpeg,image/jpg,image/png,image/webp"
            class="hidden"
        >
        
        <div class="text-gray-500">
            <svg class="mx-auto h-16 w-16 text-gray-400 mb-4 transition-transform duration-300" 
                 :class="{ 'scale-110': isDragging }"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <p class="text-lg font-medium text-gray-900 mb-2">
                <span x-show="uploadedImages.length === 0">Drop images here, or click to select</span>
                <span x-show="uploadedImages.length > 0" x-text="`${uploadedImages.length} image(s) uploaded`"></span>
            </p>
            <p class="text-sm text-gray-500">
                <span x-show="uploadedImages.length === 0">Click to select one image at a time (JPG, PNG, WebP)</span>
                <span x-show="uploadedImages.length > 0" x-cloak class="text-green-600 font-medium">
                    <span x-text="uploadedImages.length"></span> image(s) ready - Click to add more
                </span>
            </p>
            <p class="text-xs text-gray-400 mt-2">Max 50MB per image • Max 50 images</p>
        </div>
    </div>

    {{-- Uploading Files --}}
    <div x-show="selectedFiles.length > 0" x-cloak class="mt-6 space-y-2">
        <template x-for="file in selectedFiles" :key="file.id">
            <div class="flex items-center justify-between p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                <div class="flex items-center space-x-3">
                    <div x-show="file.preview" class="w-12 h-12 rounded overflow-hidden">
                        <img :src="file.preview" :alt="file.name" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900" x-text="file.name"></p>
                        <p class="text-xs text-gray-500" x-text="file.sizeText"></p>
                    </div>
                </div>
                <div x-show="file.uploading" class="flex items-center">
                    <svg class="animate-spin h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </div>
        </template>
    </div>

    {{-- Uploaded Images Grid --}}
    <div x-show="uploadedImages.length > 0" x-cloak
         class="mt-6 space-y-4"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-4"
         x-transition:enter-end="opacity-100 transform translate-y-0">
        
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">
                Uploaded Images (<span x-text="uploadedImages.length"></span>)
            </h3>
            <p class="text-sm text-gray-500">Drag to reorder</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <template x-for="(image, index) in uploadedImages" :key="image.id">
                <div 
                    class="relative group bg-white border-2 border-gray-200 rounded-lg p-3 hover:border-blue-400 hover:shadow-lg transition-all cursor-move"
                    draggable="true"
                    @dragstart="$dispatch('drag-start', { index: index })"
                    @dragover.prevent="$dispatch('drag-over', { index: index })"
                    @drop.prevent="reorderImages({ detail: { draggedIndex: $event.dataTransfer.getData('text/plain'), targetIndex: index } })"
                >
                    {{-- Image Preview --}}
                    <div class="aspect-square mb-2 rounded overflow-hidden bg-gray-100">
                        <img :src="image.preview || '/placeholder.jpg'" :alt="image.name" class="w-full h-full object-cover">
                    </div>
                    
                    {{-- Image Info --}}
                    <div class="mb-2">
                        <p class="text-xs font-medium text-gray-900 truncate" :title="image.name" x-text="image.name"></p>
                        <p class="text-xs text-gray-500" x-text="image.size"></p>
                    </div>

                    {{-- Order Badge --}}
                    <div class="absolute top-2 left-2 bg-blue-500 text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center" x-text="index + 1"></div>

                    {{-- Remove Button --}}
                    <button 
                        @click="removeImage(image.id)"
                        class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity"
                        title="Remove image"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>

                    {{-- Move Buttons --}}
                    <div class="absolute bottom-2 right-2 flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button 
                            @click="moveUp(index)"
                            :disabled="index === 0"
                            class="bg-blue-500 text-white rounded p-1 disabled:opacity-50 disabled:cursor-not-allowed"
                            title="Move up"
                        >
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                            </svg>
                        </button>
                        <button 
                            @click="moveDown(index)"
                            :disabled="index === uploadedImages.length - 1"
                            class="bg-blue-500 text-white rounded p-1 disabled:opacity-50 disabled:cursor-not-allowed"
                            title="Move down"
                        >
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>

