@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <div class="text-center py-12 sm:py-20 bg-gray-50">
        <h1 class="text-3xl sm:text-5xl font-bold text-gray-900 mb-6 px-4">
            About EasyPDF Pro
        </h1>
        <p class="text-lg sm:text-xl text-gray-600 max-w-3xl mx-auto mb-8 px-4">
            Your trusted partner for all PDF needs. We make working with PDFs simple, fast, and secure.
        </p>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
        <!-- Our Story Section -->
        <div class="bg-white rounded-xl border border-gray-200 p-8 mb-8">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 mr-4">
                    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        <rect x="8" y="8" width="32" height="32" rx="4" fill="#4DABF7" />
                        <path d="M24 16V32" stroke="white" stroke-width="3" stroke-linecap="round" />
                        <path d="M16 24H32" stroke="white" stroke-width="3" stroke-linecap="round" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Our Story</h2>
            </div>
            <p class="text-gray-600 leading-relaxed mb-4">
                EasyPDF Pro was born from a simple idea: working with PDFs shouldn't be complicated or expensive. 
                We noticed that many online PDF tools were either too complex, too expensive, or compromised user privacy.
            </p>
            <p class="text-gray-600 leading-relaxed">
                That's why we created a platform that combines powerful functionality with an intuitive interface, 
                all while keeping your documents secure and your experience smooth.
            </p>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Security First -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="w-12 h-12 mb-4">
                    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        <rect x="8" y="8" width="32" height="32" rx="4" fill="#51CF66" />
                        <path d="M24 14L30 20V34H18V20L24 14Z" stroke="white" stroke-width="3" stroke-linejoin="round" />
                        <path d="M21 26L23 28L27 24" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Security First</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Your files are processed securely and deleted automatically after conversion. 
                    We never store or share your documents.
                </p>
            </div>

            <!-- Fast Processing -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="w-12 h-12 mb-4">
                    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        <rect x="8" y="8" width="32" height="32" rx="4" fill="#FFD43B" />
                        <path d="M16 24L24 16L32 24" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M24 16V32" stroke="white" stroke-width="3" stroke-linecap="round" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Lightning Fast</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Our optimized servers ensure quick processing times, so you can get your work done faster.
                </p>
            </div>

            <!-- Easy to Use -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="w-12 h-12 mb-4">
                    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        <rect x="8" y="8" width="32" height="32" rx="4" fill="#FF922B" />
                        <circle cx="24" cy="24" r="8" stroke="white" stroke-width="3" />
                        <path d="M21 24L23 26L27 22" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Easy to Use</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    No registration required. Simply upload your file, choose your settings, and download the result.
                </p>
            </div>

            <!-- Free Tools -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="w-12 h-12 mb-4">
                    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        <rect x="8" y="8" width="32" height="32" rx="4" fill="#F06595" />
                        <path d="M24 14V34" stroke="white" stroke-width="3" stroke-linecap="round" />
                        <path d="M18 20L24 14L30 20" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M18 28L30 28" stroke="white" stroke-width="3" stroke-linecap="round" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">100% Free</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    All our core tools are completely free to use with no hidden fees or subscription requirements.
                </p>
            </div>
        </div>

        <!-- Mission Statement -->
        <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl p-8 text-center">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Our Mission</h2>
            <p class="text-lg text-gray-700 max-w-2xl mx-auto leading-relaxed">
                To democratize PDF tools by making them accessible, secure, and free for everyone. 
                We believe that powerful document processing shouldn't be a luxury.
            </p>
        </div>
    </div>
@endsection