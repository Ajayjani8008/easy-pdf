<header class="sticky top-0 z-50 bg-white shadow-sm border-b border-gray-100" x-data="{ mobileMenuOpen: false, toolsOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ url('/') }}" class="flex items-center gap-2">
                    <!-- Colorful Grid Icon -->
                    <div class="grid grid-cols-2 gap-0.5 w-8 h-8">
                        <div class="bg-orange-500 rounded-tl-sm"></div>
                        <div class="bg-yellow-400 rounded-tr-sm"></div>
                        <div class="bg-purple-600 rounded-bl-sm"></div>
                        <div class="bg-pink-500 rounded-br-sm"></div>
                    </div>
                    <span class="text-xl font-bold text-gray-900 tracking-tight">EasyPDF <span
                            class="font-normal text-gray-500">Pro</span></span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden lg:flex space-x-1 items-center">
                <!-- Tools Mega Menu -->
                <div class="relative group" x-data="{ open: false }">
                    <button @mouseenter="open = true" @mouseleave="open = false"
                        class="group inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none transition-colors duration-200">
                        <svg class="mr-2 h-5 w-5 text-gray-500 group-hover:text-gray-700" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        <span>Tools</span>
                        <svg class="ml-1 h-4 w-4 text-gray-400 group-hover:text-gray-600 transition-transform duration-200"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Full Width Mega Menu - Screen Centered -->
                    <div @mouseenter="open = true" @mouseleave="open = false" x-show="open" x-cloak 
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-1"
                        class="fixed top-16 left-1/2 transform -translate-x-1/2 rounded-xl shadow-2xl bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50 max-h-[80vh] overflow-y-auto"
                        style="width: 95vw; max-width: 1100px; min-width: 320px;">
                        
                        <div class="p-4 lg:p-5">
                            <div class="mb-4 text-center">
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">PDF Tools</h3>
                                <p class="text-xs text-gray-600">All the tools you need to work with PDFs - completely free and secure</p>
                            </div>
                            
                            <!-- Tools Grid - Responsive & Compact -->
                            <div class="grid grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 2xl:grid-cols-8 gap-2 lg:gap-3">
                                <!-- PDF to Word -->
                                <a href="{{ route('tools.pdf-to-word') }}" class="group p-2 lg:p-3 rounded-lg hover:bg-gray-50 transition-colors text-center">
                                    <div class="w-8 h-8 lg:w-10 lg:h-10 mb-1 lg:mb-2 mx-auto">
                                        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                                            <rect x="8" y="8" width="32" height="32" rx="4" fill="#4DABF7" />
                                            <path d="M14 16H22V24H14V16Z" fill="white" />
                                            <path d="M26 18H34" stroke="white" stroke-width="2" stroke-linecap="round" />
                                            <path d="M26 22H34" stroke="white" stroke-width="2" stroke-linecap="round" />
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-gray-900 text-xs group-hover:text-blue-600">PDF to Word</h4>
                                    <p class="text-xs text-gray-500 hidden xl:block">Convert to DOC</p>
                                </a>

                                <!-- Merge PDF -->
                                <a href="{{ route('tools.merge-pdf') }}" class="group p-2 lg:p-3 rounded-lg hover:bg-gray-50 transition-colors text-center">
                                    <div class="w-8 h-8 lg:w-10 lg:h-10 mb-1 lg:mb-2 mx-auto">
                                        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                                            <rect x="8" y="8" width="32" height="32" rx="4" fill="#FF6B6B" />
                                            <path d="M16 24H32" stroke="white" stroke-width="3" stroke-linecap="round" />
                                            <path d="M24 16L28 20L24 24" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-gray-900 text-xs group-hover:text-red-600">Merge PDF</h4>
                                    <p class="text-xs text-gray-500 hidden xl:block">Combine PDFs</p>
                                </a>

                                <!-- Split PDF -->
                                <a href="{{ route('tools.split-pdf') }}" class="group p-2 lg:p-3 rounded-lg hover:bg-gray-50 transition-colors text-center">
                                    <div class="w-8 h-8 lg:w-10 lg:h-10 mb-1 lg:mb-2 mx-auto">
                                        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                                            <rect x="8" y="8" width="32" height="32" rx="4" fill="#FF6B6B" />
                                            <path d="M24 14V34" stroke="white" stroke-width="3" stroke-linecap="round" stroke-dasharray="4 4" />
                                            <path d="M18 20L14 24L18 28" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-gray-900 text-xs group-hover:text-red-600">Split PDF</h4>
                                    <p class="text-xs text-gray-500 hidden xl:block">Extract pages</p>
                                </a>

                                <!-- Compress PDF -->
                                <a href="{{ route('tools.compress-pdf') }}" class="group p-2 lg:p-3 rounded-lg hover:bg-gray-50 transition-colors text-center">
                                    <div class="w-8 h-8 lg:w-10 lg:h-10 mb-1 lg:mb-2 mx-auto">
                                        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                                            <rect x="8" y="8" width="32" height="32" rx="4" fill="#51CF66" />
                                            <path d="M24 14V34" stroke="white" stroke-width="3" stroke-linecap="round" />
                                            <path d="M32 26L24 34L16 26" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-gray-900 text-xs group-hover:text-green-600">Compress PDF</h4>
                                    <p class="text-xs text-gray-500 hidden xl:block">Reduce size</p>
                                </a>

                                <!-- PDF to JPG -->
                                <a href="{{ route('tools.pdf-to-jpg') }}" class="group p-2 lg:p-3 rounded-lg hover:bg-gray-50 transition-colors text-center">
                                    <div class="w-8 h-8 lg:w-10 lg:h-10 mb-1 lg:mb-2 mx-auto">
                                        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                                            <rect x="8" y="8" width="32" height="32" rx="4" fill="#FFD43B" />
                                            <rect x="14" y="14" width="20" height="20" rx="2" stroke="white" stroke-width="3" />
                                            <circle cx="20" cy="20" r="2" fill="white" />
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-gray-900 text-xs group-hover:text-yellow-600">PDF to JPG</h4>
                                    <p class="text-xs text-gray-500 hidden xl:block">To images</p>
                                </a>

                                <!-- JPG to PDF -->
                                <a href="{{ route('tools.jpg-to-pdf') }}" class="group p-2 lg:p-3 rounded-lg hover:bg-gray-50 transition-colors text-center">
                                    <div class="w-8 h-8 lg:w-10 lg:h-10 mb-1 lg:mb-2 mx-auto">
                                        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                                            <rect x="8" y="8" width="32" height="32" rx="4" fill="#FCC419" />
                                            <path d="M14 14H34V34H14V14Z" stroke="white" stroke-width="3" stroke-linejoin="round" />
                                            <path d="M24 20V28" stroke="white" stroke-width="3" stroke-linecap="round" />
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-gray-900 text-xs group-hover:text-yellow-600">JPG to PDF</h4>
                                    <p class="text-xs text-gray-500 hidden xl:block">Images to PDF</p>
                                </a>

                                <!-- PDF to Excel -->
                                <a href="{{ route('tools.pdf-to-excel') }}" class="group p-2 lg:p-3 rounded-lg hover:bg-gray-50 transition-colors text-center">
                                    <div class="w-8 h-8 lg:w-10 lg:h-10 mb-1 lg:mb-2 mx-auto">
                                        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                                            <rect x="8" y="8" width="32" height="32" rx="4" fill="#69DB7C" />
                                            <path d="M14 16H22V24H14V16Z" fill="white" />
                                            <path d="M26 18H34" stroke="white" stroke-width="2" stroke-linecap="round" />
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-gray-900 text-xs group-hover:text-green-600">PDF to Excel</h4>
                                    <p class="text-xs text-gray-500 hidden xl:block">Extract tables</p>
                                </a>

                                <!-- Word to PDF -->
                                <a href="{{ route('tools.word-to-pdf') }}" class="group p-2 lg:p-3 rounded-lg hover:bg-gray-50 transition-colors text-center">
                                    <div class="w-8 h-8 lg:w-10 lg:h-10 mb-1 lg:mb-2 mx-auto">
                                        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                                            <rect x="8" y="8" width="32" height="32" rx="4" fill="#74C0FC" />
                                            <path d="M34 16H26V24H34V16Z" fill="white" />
                                            <path d="M22 18H14" stroke="white" stroke-width="2" stroke-linecap="round" />
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-gray-900 text-xs group-hover:text-blue-600">Word to PDF</h4>
                                    <p class="text-xs text-gray-500 hidden xl:block">DOC to PDF</p>
                                </a>

                                <!-- PDF to PowerPoint -->
                                <a href="{{ route('tools.pdf-to-powerpoint') }}" class="group p-2 lg:p-3 rounded-lg hover:bg-gray-50 transition-colors text-center">
                                    <div class="w-8 h-8 lg:w-10 lg:h-10 mb-1 lg:mb-2 mx-auto">
                                        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                                            <rect x="8" y="8" width="32" height="32" rx="4" fill="#FF922B" />
                                            <path d="M14 16H22V24H14V16Z" fill="white" />
                                            <path d="M26 18H34" stroke="white" stroke-width="2" stroke-linecap="round" />
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-gray-900 text-xs group-hover:text-orange-600">PDF to PowerPoint</h4>
                                    <p class="text-xs text-gray-500 hidden xl:block">To PPT</p>
                                </a>

                                <!-- PowerPoint to PDF -->
                                <a href="{{ route('tools.powerpoint-to-pdf') }}" class="group p-2 lg:p-3 rounded-lg hover:bg-gray-50 transition-colors text-center">
                                    <div class="w-8 h-8 lg:w-10 lg:h-10 mb-1 lg:mb-2 mx-auto">
                                        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                                            <rect x="8" y="8" width="32" height="32" rx="4" fill="#FFA94D" />
                                            <path d="M34 16H26V24H34V16Z" fill="white" />
                                            <path d="M22 18H14" stroke="white" stroke-width="2" stroke-linecap="round" />
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-gray-900 text-xs group-hover:text-orange-600">PowerPoint to PDF</h4>
                                    <p class="text-xs text-gray-500 hidden xl:block">PPT to PDF</p>
                                </a>

                                <!-- Excel to PDF -->
                                <a href="{{ route('tools.excel-to-pdf') }}" class="group p-2 lg:p-3 rounded-lg hover:bg-gray-50 transition-colors text-center">
                                    <div class="w-8 h-8 lg:w-10 lg:h-10 mb-1 lg:mb-2 mx-auto">
                                        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                                            <rect x="8" y="8" width="32" height="32" rx="4" fill="#8CE99A" />
                                            <path d="M34 16H26V24H34V16Z" fill="white" />
                                            <path d="M22 18H14" stroke="white" stroke-width="2" stroke-linecap="round" />
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-gray-900 text-xs group-hover:text-green-600">Excel to PDF</h4>
                                    <p class="text-xs text-gray-500 hidden xl:block">XLS to PDF</p>
                                </a>

                                <!-- Edit PDF -->
                                <a href="{{ route('tools.edit-pdf') }}" class="group p-2 lg:p-3 rounded-lg hover:bg-gray-50 transition-colors text-center">
                                    <div class="w-8 h-8 lg:w-10 lg:h-10 mb-1 lg:mb-2 mx-auto">
                                        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                                            <rect x="8" y="8" width="32" height="32" rx="4" fill="#B197FC" />
                                            <path d="M16 32H32" stroke="white" stroke-width="3" stroke-linecap="round" />
                                            <path d="M24 16V28" stroke="white" stroke-width="3" stroke-linecap="round" />
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-gray-900 text-xs group-hover:text-purple-600">Edit PDF</h4>
                                    <p class="text-xs text-gray-500 hidden xl:block">Add text</p>
                                </a>

                                <!-- Sign PDF -->
                                <a href="{{ route('tools.sign-pdf') }}" class="group p-2 lg:p-3 rounded-lg hover:bg-gray-50 transition-colors text-center">
                                    <div class="w-8 h-8 lg:w-10 lg:h-10 mb-1 lg:mb-2 mx-auto">
                                        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                                            <rect x="8" y="8" width="32" height="32" rx="4" fill="#748FFC" />
                                            <path d="M28 14L34 20L20 34H14V28L28 14Z" stroke="white" stroke-width="3" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-gray-900 text-xs group-hover:text-indigo-600">Sign PDF</h4>
                                    <p class="text-xs text-gray-500 hidden xl:block">E-signature</p>
                                </a>

                                <!-- Watermark PDF -->
                                <a href="{{ route('tools.watermark-pdf') }}" class="group p-2 lg:p-3 rounded-lg hover:bg-gray-50 transition-colors text-center">
                                    <div class="w-8 h-8 lg:w-10 lg:h-10 mb-1 lg:mb-2 mx-auto">
                                        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                                            <rect x="8" y="8" width="32" height="32" rx="4" fill="#F06595" />
                                            <circle cx="24" cy="24" r="10" stroke="white" stroke-width="3" />
                                            <path d="M18 24H30" stroke="white" stroke-width="3" stroke-linecap="round" />
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-gray-900 text-xs group-hover:text-pink-600">Watermark PDF</h4>
                                    <p class="text-xs text-gray-500 hidden xl:block">Add watermark</p>
                                </a>

                                <!-- Rotate PDF -->
                                <a href="{{ route('tools.rotate-pdf') }}" class="group p-2 lg:p-3 rounded-lg hover:bg-gray-50 transition-colors text-center">
                                    <div class="w-8 h-8 lg:w-10 lg:h-10 mb-1 lg:mb-2 mx-auto">
                                        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                                            <rect x="8" y="8" width="32" height="32" rx="4" fill="#20C997" />
                                            <path d="M24 14V22" stroke="white" stroke-width="3" stroke-linecap="round" />
                                            <path d="M32 16L16 32" stroke="white" stroke-width="3" stroke-linecap="round" />
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-gray-900 text-xs group-hover:text-teal-600">Rotate PDF</h4>
                                    <p class="text-xs text-gray-500 hidden xl:block">Rotate pages</p>
                                </a>
                            </div>

                            <!-- View All Tools Link -->
                            <div class="mt-4 pt-4 border-t border-gray-200 text-center">
                                <a href="{{ url('/') }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-700">
                                    View all tools on homepage
                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('pages.about') }}"
                    class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 transition-colors duration-200">About</a>
                <a href="{{ route('pages.contact') }}"
                    class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 transition-colors duration-200">Contact</a>
            </nav>

            <!-- Mobile menu button -->
            <div class="flex items-center lg:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" type="button"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
                    aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <!-- Icon when menu is closed -->
                    <svg x-show="!mobileMenuOpen" x-cloak class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <!-- Icon when menu is open -->
                    <svg x-show="mobileMenuOpen" x-cloak class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div class="lg:hidden" id="mobile-menu" x-show="mobileMenuOpen" x-cloak
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
        style="display: none;">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 border-t border-gray-200 shadow-lg bg-white max-h-96 overflow-y-auto">
            <a href="{{ url('/') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Home</a>
            
            <!-- Tools Section - Collapsible -->
            <div x-data="{ toolsOpen: false }">
                <button @click="toolsOpen = !toolsOpen" class="w-full flex items-center justify-between px-3 py-2 text-left text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-md">
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">PDF Tools</span>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': toolsOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                
                <div x-show="toolsOpen" x-cloak x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-1"
                    class="ml-4 space-y-1">
                    
                    <a href="{{ route('tools.pdf-to-word') }}"
                        class="block px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50">PDF to Word</a>
                    <a href="{{ route('tools.merge-pdf') }}"
                        class="block px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50">Merge PDF</a>
                    <a href="{{ route('tools.split-pdf') }}"
                        class="block px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50">Split PDF</a>
                    <a href="{{ route('tools.compress-pdf') }}"
                        class="block px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50">Compress PDF</a>
                    <a href="{{ route('tools.pdf-to-jpg') }}"
                        class="block px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50">PDF to JPG</a>
                    <a href="{{ route('tools.jpg-to-pdf') }}"
                        class="block px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50">JPG to PDF</a>
                    <a href="{{ route('tools.pdf-to-excel') }}"
                        class="block px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50">PDF to Excel</a>
                    <a href="{{ route('tools.word-to-pdf') }}"
                        class="block px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50">Word to PDF</a>
                    <a href="{{ route('tools.pdf-to-powerpoint') }}"
                        class="block px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50">PDF to PowerPoint</a>
                    <a href="{{ route('tools.powerpoint-to-pdf') }}"
                        class="block px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50">PowerPoint to PDF</a>
                    <a href="{{ route('tools.excel-to-pdf') }}"
                        class="block px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50">Excel to PDF</a>
                    <a href="{{ route('tools.edit-pdf') }}"
                        class="block px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50">Edit PDF</a>
                    <a href="{{ route('tools.sign-pdf') }}"
                        class="block px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50">Sign PDF</a>
                    <a href="{{ route('tools.watermark-pdf') }}"
                        class="block px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50">Watermark PDF</a>
                    <a href="{{ route('tools.rotate-pdf') }}"
                        class="block px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50">Rotate PDF</a>
                </div>
            </div>
            
            <!-- Pages Section -->
            <div class="py-2 mt-4">
                <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Pages</p>
            </div>
            
            <a href="{{ route('pages.about') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">About</a>
            <a href="{{ route('pages.contact') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Contact</a>
        </div>
    </div>
</header>
