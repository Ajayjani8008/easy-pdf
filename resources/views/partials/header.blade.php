<header class="sticky top-0 z-50 bg-white shadow-sm border-b border-gray-100" x-data="{ mobileMenuOpen: false }">
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
            <nav class="hidden md:flex space-x-1 items-center">
                <!-- Tools Dropdown -->
                <div class="relative" x-data="{ open: false }" x-cloak @click.outside="open = false">
                    <button @click="open = !open"
                        class="group inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none transition-colors duration-200">
                        <svg class="mr-2 h-5 w-5 text-gray-500 group-hover:text-gray-700" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        <span>Tools</span>
                        <svg class="ml-1 h-4 w-4 text-gray-400 group-hover:text-gray-600 transition-transform duration-200"
                            :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-1"
                        class="absolute left-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                        <div class="py-1">
                            <a href="{{ url('/tools/compress') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">Compress
                                PDF</a>
                            <a href="{{ url('/tools/convert') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">PDF
                                Converter</a>
                            <a href="{{ url('/tools/merge') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">Merge
                                PDF</a>
                            <a href="{{ url('/tools/edit') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">Edit
                                PDF</a>
                            <a href="{{ url('/tools/sign') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">eSign
                                PDF</a>
                        </div>
                    </div>
                </div>

                <a href="{{ url('/tools/compress') }}"
                    class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 transition-colors duration-200">Compress</a>
                <a href="{{ url('/tools/convert') }}"
                    class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 transition-colors duration-200">Convert</a>
                <a href="{{ url('/tools/merge') }}"
                    class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 transition-colors duration-200">Merge</a>
                <a href="{{ url('/tools/edit') }}"
                    class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 transition-colors duration-200">Edit</a>
                <a href="{{ url('/tools/sign') }}"
                    class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 transition-colors duration-200">Sign</a>
                <a href="{{ url('/tools/ai-pdf') }}"
                    class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 transition-colors duration-200">AI
                    PDF</a>
            </nav>

            <!-- Mobile menu button -->
            <div class="flex items-center md:hidden">
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

    <!-- Mobile menu, show/hide based on menu state. -->
    <div class="md:hidden" id="mobile-menu" x-show="mobileMenuOpen" x-cloak
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
        style="display: none;">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 border-t border-gray-200 shadow-lg bg-white">
            <a href="{{ url('/') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Home</a>
            <a href="{{ url('/tools/compress') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Compress</a>
            <a href="{{ url('/tools/convert') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Convert</a>
            <a href="{{ url('/tools/merge') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Merge</a>
            <a href="{{ url('/tools/edit') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Edit</a>
            <a href="{{ url('/tools/sign') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Sign</a>
            <a href="{{ url('/tools/ai-pdf') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">AI
                PDF</a>
        </div>
    </div>
</header>
