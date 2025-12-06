<div x-data="conversionStatus()" x-init="init()" class="space-y-4">
    {{-- Uploading Status --}}
    <div x-show="status === 'uploading'" class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-center">
            <svg class="animate-spin h-5 w-5 text-blue-600 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <div>
                <p class="text-sm font-medium text-blue-900">Uploading...</p>
                <p class="text-xs text-blue-700" x-text="message"></p>
            </div>
        </div>
    </div>

    {{-- Converting Status --}}
    <div x-show="status === 'converting'" class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
        <div class="flex items-center">
            <svg class="animate-spin h-5 w-5 text-yellow-600 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <div>
                <p class="text-sm font-medium text-yellow-900">Converting...</p>
                <p class="text-xs text-yellow-700" x-text="message"></p>
            </div>
        </div>
    </div>

    {{-- Error Status --}}
    <div x-show="status === 'error'" class="bg-red-50 border border-red-200 rounded-lg p-4">
        <div class="flex items-center">
            <svg class="h-5 w-5 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <p class="text-sm font-medium text-red-900">Error</p>
                <p class="text-xs text-red-700" x-text="message"></p>
            </div>
        </div>
    </div>

    {{-- Convert Button (shown when file is uploaded) --}}
    <div x-show="status === 'ready'" class="space-y-2">
        <button 
            @click="startConversion()"
            class="w-full px-4 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all"
        >
            Convert to Word
        </button>
    </div>
</div>

