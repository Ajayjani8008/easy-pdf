<div x-data="typeof mergeFileUpload === 'function' ? mergeFileUpload() : { 
    isDragging: false, 
    selectedFiles: [], 
    uploading: false, 
    uploadedFiles: [], 
    minFiles: 2, 
    maxFiles: 10,
    init() {},
    handleDrop() {},
    handleFileSelect() {},
    removeFile() {},
    canMerge() { return false; }
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
            accept=".pdf,application/pdf"
            class="hidden"
        >
        
        <div class="text-gray-500">
            <svg class="mx-auto h-16 w-16 text-gray-400 mb-4 transition-transform duration-300" 
                 :class="{ 'scale-110': isDragging }"
                 stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v20c0 4.418 7.163 8 16 8 1.381 0 2.721-.087 4-.252M8 14c0 4.418 7.163 8 16 8s16-3.582 16-8M8 14c0-4.418 7.163-8 16-8s16 3.582 16 8m0 0v14m0-4c0 4.418-7.163 8-16 8S8 28.418 8 24m32 10v6m0 0v6m0-6h6m-6 0h-6" />
            </svg>
            <p class="text-lg font-medium text-gray-900 mb-2">
                <span x-show="uploadedFiles.length === 0">Drop PDF file here, or click to select one file</span>
                <span x-show="uploadedFiles.length > 0" x-text="`${uploadedFiles.length} file(s) uploaded`"></span>
            </p>
            <p class="text-sm text-gray-500">
                <span x-show="uploadedFiles.length === 0">Click to select one PDF file at a time (2-10 files required)</span>
                <span x-show="uploadedFiles.length > 0 && uploadedFiles.length < minFiles" x-cloak
                      class="text-orange-600 font-medium">
                    Add at least <span x-text="minFiles - uploadedFiles.length"></span> more file(s) - Click to add another
                </span>
                <span x-show="uploadedFiles.length >= minFiles && uploadedFiles.length < maxFiles" x-cloak class="text-green-600 font-medium">
                      class="text-green-600 font-medium">
                    Ready to merge! (<span x-text="uploadedFiles.length"></span> files) - Click to add more
                </span>
                <span x-show="uploadedFiles.length >= maxFiles" x-cloak class="text-blue-600 font-medium">
                    Maximum files reached (<span x-text="uploadedFiles.length"></span> files) - Ready to merge!
                </span>
            </p>
        </div>
    </div>

    {{-- Uploaded Files Cards --}}
    <div x-show="uploadedFiles.length > 0" x-cloak
         class="mt-6 space-y-4"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-4"
         x-transition:enter-end="opacity-100 transform translate-y-0">
        
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">
                Uploaded Files (<span x-text="uploadedFiles.length"></span>)
            </h3>
            <p class="text-sm text-gray-500">
                Drag to reorder
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" 
             x-data="{ draggedIndex: null }"
             @dragstart.self="draggedIndex = $event.target.dataset.index"
             @dragover.prevent="$event.dataTransfer.dropEffect = 'move'"
             @drop.prevent="
                const dropIndex = $event.target.closest('[data-index]')?.dataset.index;
                if (draggedIndex !== null && dropIndex !== null && draggedIndex !== dropIndex) {
                    reorderFiles(parseInt(draggedIndex), parseInt(dropIndex));
                }
                draggedIndex = null;
             ">
            
            <template x-for="(file, index) in uploadedFiles" :key="file.id">
                <div 
                    :data-index="index"
                    draggable="true"
                    class="group relative bg-gradient-to-br from-white to-gray-50 rounded-xl border-2 border-gray-200 p-4 hover:border-blue-400 hover:shadow-lg transition-all duration-300 cursor-move transform hover:scale-105"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100">
                    
                    {{-- Drag Handle --}}
                    <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
                        </svg>
                    </div>

                    {{-- File Number Badge --}}
                    <div class="absolute top-2 left-2 w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold shadow-md">
                        <span x-text="index + 1"></span>
                    </div>

                    {{-- PDF Icon --}}
                    <div class="flex justify-center mb-3 mt-6">
                        <div class="relative">
                            <svg class="w-16 h-16 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
                            </svg>
                            <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 rounded-full border-2 border-white flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- File Info --}}
                    <div class="text-center">
                        <p class="text-sm font-semibold text-gray-900 mb-1 truncate" 
                           :title="file.name"
                           x-text="file.name"></p>
                        <p class="text-xs text-gray-500 mb-3" x-text="file.size"></p>
                        
                        {{-- Remove Button --}}
                        <button 
                            @click="removeFile(file.id)"
                            class="w-full px-3 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors text-sm font-medium flex items-center justify-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Remove
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>

