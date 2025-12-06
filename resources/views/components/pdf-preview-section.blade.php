<div x-data="pdfPreview()" x-init="init()" class="bg-white rounded-xl shadow-lg border border-gray-200 p-8" x-show="uploadedFileId">
    <h2 class="text-xl font-bold text-gray-900 mb-4">PDF Preview</h2>
    
    <div x-show="loading" class="text-center py-12">
        <svg class="animate-spin h-12 w-12 text-blue-500 mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <p class="text-gray-600">Loading PDF preview...</p>
    </div>

    <div x-show="!loading && uploadedFileId" class="space-y-4">
        {{-- PDF Preview Container --}}
        <div class="border border-gray-200 rounded-lg p-4 bg-gray-50 min-h-[400px] flex items-center justify-center">
            <div class="text-center">
                {{-- PDF Icon with Document --}}
                <div class="relative inline-block mb-4">
                    <svg class="w-32 h-32 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
                    </svg>
                    {{-- Smiley face overlay --}}
                    <div class="absolute inset-0 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M7,9.5C7,8.7 7.7,8 8.5,8C9.3,8 10,8.7 10,9.5C10,10.3 9.3,11 8.5,11C7.7,11 7,10.3 7,9.5M17,9.5C17,8.7 17.7,8 18.5,8C19.3,8 20,8.7 20,9.5C20,10.3 19.3,11 18.5,11C17.7,11 17,10.3 17,9.5M12,17.5C9.5,17.5 7.5,15.9 7,13.8L17,13.8C16.5,15.9 14.5,17.5 12,17.5Z" />
                        </svg>
                    </div>
                </div>
                <p class="text-gray-600 font-medium" x-text="fileName"></p>
                <p class="text-sm text-gray-500 mt-2" x-text="fileSize"></p>
            </div>
        </div>

        {{-- File Info --}}
        <div class="bg-blue-50 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-900" x-text="fileName"></p>
                    <p class="text-xs text-blue-700" x-text="fileSize"></p>
                </div>
                <div class="px-3 py-1 bg-blue-600 text-white text-xs font-bold rounded-full">
                    PDF
                </div>
            </div>
        </div>
    </div>
</div>

