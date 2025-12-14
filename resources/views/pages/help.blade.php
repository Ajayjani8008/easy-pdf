@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <div class="text-center py-12 sm:py-20 bg-gray-50">
        <h1 class="text-3xl sm:text-5xl font-bold text-gray-900 mb-6 px-4">
            Help Center
        </h1>
        <p class="text-lg sm:text-xl text-gray-600 max-w-3xl mx-auto mb-8 px-4">
            Find answers to common questions and get help with EasyPDF Pro tools.
        </p>
    </div>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
        <!-- Quick Help Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="bg-white rounded-xl border border-gray-200 p-6 text-center">
                <div class="w-12 h-12 mx-auto mb-4">
                    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        <rect x="8" y="8" width="32" height="32" rx="4" fill="#4DABF7" />
                        <path d="M24 16V24" stroke="white" stroke-width="3" stroke-linecap="round" />
                        <circle cx="24" cy="30" r="2" fill="white" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Getting Started</h3>
                <p class="text-gray-600 text-sm">Learn the basics of using EasyPDF Pro tools</p>
            </div>
            
            <div class="bg-white rounded-xl border border-gray-200 p-6 text-center">
                <div class="w-12 h-12 mx-auto mb-4">
                    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        <rect x="8" y="8" width="32" height="32" rx="4" fill="#51CF66" />
                        <path d="M18 24L22 28L30 20" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Best Practices</h3>
                <p class="text-gray-600 text-sm">Tips for optimal PDF processing results</p>
            </div>
            
            <div class="bg-white rounded-xl border border-gray-200 p-6 text-center">
                <div class="w-12 h-12 mx-auto mb-4">
                    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        <rect x="8" y="8" width="32" height="32" rx="4" fill="#F06595" />
                        <path d="M24 16V32" stroke="white" stroke-width="3" stroke-linecap="round" />
                        <path d="M16 24H32" stroke="white" stroke-width="3" stroke-linecap="round" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Troubleshooting</h3>
                <p class="text-gray-600 text-sm">Solve common issues and errors</p>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="bg-white rounded-xl border border-gray-200 p-8 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Frequently Asked Questions</h2>
            
            <div class="space-y-6">
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">How do I convert a PDF to Word?</h3>
                    <p class="text-gray-600">
                        1. Go to our <a href="{{ route('tools.pdf-to-word') }}" class="text-blue-600 hover:text-blue-700">PDF to Word</a> tool<br>
                        2. Click "Choose File" and select your PDF<br>
                        3. Wait for the conversion to complete<br>
                        4. Download your Word document
                    </p>
                </div>

                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Are my files secure?</h3>
                    <p class="text-gray-600">
                        Yes! All files are processed using SSL encryption and automatically deleted within 1 hour. 
                        We never store, access, or share your documents. EasyPDF Pro is powered by 
                        <a href="https://avrtechnology.com" class="text-blue-600 hover:text-blue-700">AVR Technology</a> 
                        with enterprise-grade security.
                    </p>
                </div>

                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">What file formats do you support?</h3>
                    <p class="text-gray-600">
                        We support PDF, Word (DOC/DOCX), Excel (XLS/XLSX), PowerPoint (PPT/PPTX), 
                        and image formats (JPG, PNG, GIF, BMP, TIFF).
                    </p>
                </div>

                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Is there a file size limit?</h3>
                    <p class="text-gray-600">
                        Yes, the maximum file size is 100MB per file. For larger files, consider using our 
                        <a href="{{ route('tools.compress-pdf') }}" class="text-blue-600 hover:text-blue-700">PDF Compress</a> 
                        tool first to reduce the size.
                    </p>
                </div>

                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Do I need to create an account?</h3>
                    <p class="text-gray-600">
                        No! All our tools are completely free and don't require registration. Simply upload your file, 
                        process it, and download the result.
                    </p>
                </div>

                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Why is my conversion taking so long?</h3>
                    <p class="text-gray-600">
                        Processing time depends on file size and complexity. Large files or files with many images 
                        may take longer. If you experience issues, try refreshing the page or 
                        <a href="{{ route('pages.contact') }}" class="text-blue-600 hover:text-blue-700">contact our support</a>.
                    </p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Can I process multiple files at once?</h3>
                    <p class="text-gray-600">
                        Currently, our tools process one file at a time for optimal quality and speed. 
                        You can use multiple browser tabs to process several files simultaneously.
                    </p>
                </div>
            </div>
        </div>

        <!-- Contact Support -->
        <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl p-8 text-center">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Still Need Help?</h2>
            <p class="text-gray-600 mb-6">
                Can't find what you're looking for? Our support team at AVR Technology is here to help!
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('pages.contact') }}" 
                   class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    Contact Support
                </a>
                <a href="mailto:support@avrtechnology.com" 
                   class="inline-flex items-center px-6 py-3 bg-white text-blue-600 font-medium rounded-lg border border-blue-600 hover:bg-blue-50 transition-colors">
                    Email Us
                </a>
            </div>
        </div>
    </div>
@endsection