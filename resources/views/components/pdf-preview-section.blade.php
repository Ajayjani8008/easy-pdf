<div x-data="typeof pdfPreview === 'function' ? pdfPreview() : { uploadedFileId: null, fileName: '', fileSize: '', loading: false, converting: false, converted: false, init() {} }" 
     x-init="init()" 
     class="bg-white rounded-xl shadow-xl border border-gray-200 p-8 transition-all duration-500"
     x-show="uploadedFileId" x-cloak
     x-transition:enter="transition ease-out duration-500"
     x-transition:enter-start="opacity-0 transform translate-y-4"
     x-transition:enter-end="opacity-100 transform translate-y-0">
    
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-gray-900 flex items-center">
            <span x-show="!converting && !converted" x-cloak class="flex items-center">
                <svg class="w-6 h-6 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
                </svg>
                PDF Preview
            </span>
            <span x-show="converting" x-cloak class="flex items-center animate-pulse">
                <svg class="w-6 h-6 mr-2 text-yellow-500 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Converting...
            </span>
            <span x-show="converted" x-cloak class="flex items-center">
                <svg class="w-6 h-6 mr-2 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
                </svg>
                Word Document
            </span>
        </h2>
        <div class="flex items-center space-x-2">
            <span x-show="!converting && !converted" x-cloak class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full animate-pulse-glow">
                PDF
            </span>
            <span x-show="converting" x-cloak class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full animate-pulse">
                CONVERTING
            </span>
            <span x-show="converted" x-cloak class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">
                DOCX
            </span>
        </div>
    </div>
    
    <div x-show="loading" x-cloak class="text-center py-12">
        <div class="inline-block relative">
            <svg class="animate-spin h-16 w-16 text-blue-500 mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="w-8 h-8 bg-blue-500 rounded-full animate-ping"></div>
            </div>
        </div>
        <p class="text-gray-600 font-medium animate-pulse">Loading PDF preview...</p>
    </div>

    <div x-show="!loading && uploadedFileId" x-cloak class="space-y-4">
        {{-- Document Preview Container with Morphing Effect --}}
        <div class="border-2 border-gray-200 rounded-xl p-6 bg-gradient-to-br from-gray-50 to-blue-50 min-h-[400px] flex items-center justify-center transition-all duration-700"
             :class="{
                 'border-blue-300 bg-gradient-to-br from-blue-50 to-indigo-50': !converting && !converted,
                 'border-yellow-300 bg-gradient-to-br from-yellow-50 to-orange-50 animate-pulse': converting,
                 'border-green-300 bg-gradient-to-br from-green-50 to-emerald-50': converted
             }">
            <div class="text-center transform transition-all duration-700"
                 :class="{
                     'scale-100': !converting,
                     'scale-110 animate-morph': converting,
                     'scale-100': converted
                 }">
                {{-- PDF Icon (shown when not converting) --}}
                <div x-show="!converting && !converted" 
                     class="relative inline-block mb-4 transition-all duration-500"
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 scale-90"
                     x-transition:enter-end="opacity-100 scale-100">
                    <div class="relative">
                        <svg class="w-32 h-32 text-blue-500 drop-shadow-lg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <svg class="w-20 h-20 text-white drop-shadow-md" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M7,9.5C7,8.7 7.7,8 8.5,8C9.3,8 10,8.7 10,9.5C10,10.3 9.3,11 8.5,11C7.7,11 7,10.3 7,9.5M17,9.5C17,8.7 17.7,8 18.5,8C19.3,8 20,8.7 20,9.5C20,10.3 19.3,11 18.5,11C17.7,11 17,10.3 17,9.5M12,17.5C9.5,17.5 7.5,15.9 7,13.8L17,13.8C16.5,15.9 14.5,17.5 12,17.5Z" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Converting Animation --}}
                <div x-show="converting" x-cloak
                     class="relative inline-block mb-4"
                     x-transition:enter="transition ease-out duration-700"
                     x-transition:enter-start="opacity-0 scale-50 rotate-180"
                     x-transition:enter-end="opacity-100 scale-100 rotate-0">
                    <div class="relative">
                        {{-- Morphing between PDF and DOC --}}
                        <div class="relative w-32 h-32 mx-auto">
                            {{-- PDF Icon fading out --}}
                            <svg class="absolute inset-0 w-32 h-32 text-blue-500 opacity-0 animate-fade-out" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
                            </svg>
                            {{-- DOC Icon fading in --}}
                            <svg class="absolute inset-0 w-32 h-32 text-green-500 animate-pulse" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
                            </svg>
                        </div>
                        {{-- Converting Spinner --}}
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-24 h-24 border-4 border-yellow-400 border-t-transparent rounded-full animate-spin"></div>
                        </div>
                    </div>
                </div>

                {{-- DOC Icon (shown when converted) --}}
                <div x-show="converted && !converting" x-cloak
                     class="relative inline-block mb-4"
                     x-transition:enter="transition ease-out duration-700"
                     x-transition:enter-start="opacity-0 scale-50"
                     x-transition:enter-end="opacity-100 scale-100">
                    <div class="relative">
                        <svg class="w-32 h-32 text-green-500 drop-shadow-lg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <svg class="w-20 h-20 text-white drop-shadow-md" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
                            </svg>
                        </div>
                        {{-- Success Checkmark --}}
                        <div class="absolute -top-2 -right-2 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center animate-bounce">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <p class="text-gray-700 font-semibold text-lg mt-4" x-text="fileName"></p>
                <p class="text-sm text-gray-500 mt-2" x-text="fileSize"></p>
            </div>
        </div>

        {{-- File Info with Animation --}}
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-4 border border-blue-200 transition-all duration-300"
             :class="{
                 'from-blue-50 to-indigo-50 border-blue-200': !converting && !converted,
                 'from-yellow-50 to-orange-50 border-yellow-200': converting,
                 'from-green-50 to-emerald-50 border-green-200': converted
             }">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-900" x-text="fileName"></p>
                    <p class="text-xs text-gray-600 mt-1" x-text="fileSize"></p>
                </div>
                <div class="flex items-center space-x-2">
                    <span x-show="!converting && !converted" x-cloak class="px-3 py-1 bg-blue-600 text-white text-xs font-bold rounded-full shadow-md">
                        PDF
                    </span>
                    <span x-show="converting" x-cloak class="px-3 py-1 bg-yellow-500 text-white text-xs font-bold rounded-full shadow-md animate-pulse">
                        <span class="inline-flex items-center">
                            <svg class="animate-spin -ml-1 mr-1 h-3 w-3 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Converting...
                        </span>
                    </span>
                    <span x-show="converted" x-cloak class="px-3 py-1 bg-green-600 text-white text-xs font-bold rounded-full shadow-md">
                        DOCX ✓
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes fade-out {
        from { opacity: 1; }
        to { opacity: 0; }
    }
    .animate-fade-out {
        animation: fade-out 1s ease-in-out;
    }
</style>

