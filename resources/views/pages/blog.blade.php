@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <div class="text-center py-12 sm:py-20 bg-gray-50">
        <h1 class="text-3xl sm:text-5xl font-bold text-gray-900 mb-6 px-4">
            EasyPDF Pro Blog
        </h1>
        <p class="text-lg sm:text-xl text-gray-600 max-w-3xl mx-auto mb-8 px-4">
            Latest news, tips, and insights about PDF processing and document management.
        </p>
    </div>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
        <!-- Featured Article -->
        <div class="bg-white rounded-xl border border-gray-200 p-8 mb-12">
            <div class="flex items-center mb-4">
                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">Featured</span>
                <span class="text-gray-500 text-sm ml-3">{{ date('F j, Y') }}</span>
            </div>
            <h2 class="text-3xl font-bold text-gray-900 mb-4">
                Welcome to EasyPDF Pro: Your Complete PDF Solution
            </h2>
            <p class="text-gray-600 text-lg mb-6">
                Discover how EasyPDF Pro, powered by AVR Technology, is revolutionizing the way people work with PDF documents. 
                From simple conversions to advanced editing, we're making PDF processing accessible to everyone.
            </p>
            <div class="flex items-center">
                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold">
                    AT
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">AVR Technology Team</p>
                    <p class="text-sm text-gray-500">Product Development</p>
                </div>
            </div>
        </div>

        <!-- Blog Posts Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            <!-- Post 1 -->
            <article class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
                <div class="h-48 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-3">
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">Tips</span>
                        <span class="text-gray-500 text-sm ml-3">December 10, 2024</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">
                        10 Essential PDF Tips for Professionals
                    </h3>
                    <p class="text-gray-600 text-sm mb-4">
                        Master these PDF techniques to boost your productivity and create professional documents that stand out.
                    </p>
                    <a href="#" class="text-blue-600 hover:text-blue-700 font-medium text-sm">Read More →</a>
                </div>
            </article>

            <!-- Post 2 -->
            <article class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
                <div class="h-48 bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center">
                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-3">
                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Security</span>
                        <span class="text-gray-500 text-sm ml-3">December 8, 2024</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">
                        How We Keep Your PDFs Secure
                    </h3>
                    <p class="text-gray-600 text-sm mb-4">
                        Learn about the advanced security measures AVR Technology implements to protect your documents.
                    </p>
                    <a href="#" class="text-blue-600 hover:text-blue-700 font-medium text-sm">Read More →</a>
                </div>
            </article>

            <!-- Post 3 -->
            <article class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
                <div class="h-48 bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center">
                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-3">
                        <span class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded">Performance</span>
                        <span class="text-gray-500 text-sm ml-3">December 5, 2024</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">
                        Speed Improvements in 2024
                    </h3>
                    <p class="text-gray-600 text-sm mb-4">
                        Discover how we've made EasyPDF Pro 3x faster with our latest infrastructure upgrades.
                    </p>
                    <a href="#" class="text-blue-600 hover:text-blue-700 font-medium text-sm">Read More →</a>
                </div>
            </article>
        </div>

        <!-- Coming Soon Section -->
        <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl p-8 text-center">
            <div class="w-16 h-16 mx-auto mb-4">
                <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                    <rect x="8" y="8" width="32" height="32" rx="4" fill="#3B82F6" />
                    <path d="M24 16V24" stroke="white" stroke-width="3" stroke-linecap="round" />
                    <circle cx="24" cy="30" r="2" fill="white" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-4">More Content Coming Soon!</h2>
            <p class="text-gray-600 mb-6">
                We're working on exciting new blog posts about PDF best practices, industry insights, and product updates. 
                Stay tuned for regular updates from the AVR Technology team.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('pages.contact') }}" 
                   class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    Subscribe to Updates
                </a>
                <a href="{{ url('/') }}" 
                   class="inline-flex items-center px-6 py-3 bg-white text-blue-600 font-medium rounded-lg border border-blue-600 hover:bg-blue-50 transition-colors">
                    Try Our Tools
                </a>
            </div>
        </div>
    </div>
@endsection