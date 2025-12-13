@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <div class="text-center py-12 sm:py-20 bg-gray-50">
        <h1 class="text-3xl sm:text-5xl font-bold text-gray-900 mb-6 px-4">
            {{ $title }}
        </h1>
        <p class="text-lg sm:text-xl text-gray-600 max-w-3xl mx-auto mb-8 px-4">
            {{ $description }}
        </p>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
        <!-- Coming Soon Notice -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-8 text-center mb-8">
            <div class="w-16 h-16 mx-auto mb-4">
                <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                    <rect x="8" y="8" width="32" height="32" rx="4" fill="#3B82F6" />
                    <path d="M24 16V24" stroke="white" stroke-width="3" stroke-linecap="round" />
                    <circle cx="24" cy="30" r="2" fill="white" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-blue-900 mb-4">Coming Soon!</h2>
            <p class="text-blue-700 mb-6">
                We're working on this page to provide you with the best information and resources. Check back soon for updates!
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('pages.contact') }}" 
                   class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    Contact Us for More Info
                </a>
                <a href="{{ url('/') }}" 
                   class="inline-flex items-center px-6 py-3 bg-white text-blue-600 font-medium rounded-lg border border-blue-600 hover:bg-blue-50 transition-colors">
                    Back to Home
                </a>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="bg-gray-50 rounded-xl p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Explore Our Tools</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('tools.pdf-to-word') }}" class="group p-4 bg-white rounded-lg border border-gray-200 hover:shadow-md transition-all">
                    <div class="w-8 h-8 mb-2">
                        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                            <rect x="8" y="8" width="32" height="32" rx="4" fill="#4DABF7" />
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-900 text-sm group-hover:text-blue-600">PDF to Word</h4>
                </a>
                
                <a href="{{ route('tools.merge-pdf') }}" class="group p-4 bg-white rounded-lg border border-gray-200 hover:shadow-md transition-all">
                    <div class="w-8 h-8 mb-2">
                        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                            <rect x="8" y="8" width="32" height="32" rx="4" fill="#FF6B6B" />
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-900 text-sm group-hover:text-red-600">Merge PDF</h4>
                </a>
                
                <a href="{{ route('tools.compress-pdf') }}" class="group p-4 bg-white rounded-lg border border-gray-200 hover:shadow-md transition-all">
                    <div class="w-8 h-8 mb-2">
                        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                            <rect x="8" y="8" width="32" height="32" rx="4" fill="#51CF66" />
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-900 text-sm group-hover:text-green-600">Compress PDF</h4>
                </a>
                
                <a href="{{ route('tools.pdf-to-jpg') }}" class="group p-4 bg-white rounded-lg border border-gray-200 hover:shadow-md transition-all">
                    <div class="w-8 h-8 mb-2">
                        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                            <rect x="8" y="8" width="32" height="32" rx="4" fill="#FFD43B" />
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-900 text-sm group-hover:text-yellow-600">PDF to JPG</h4>
                </a>
            </div>
        </div>
    </div>
@endsection