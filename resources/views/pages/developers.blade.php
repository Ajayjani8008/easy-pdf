@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <div class="text-center py-12 sm:py-20 bg-gray-50">
        <h1 class="text-3xl sm:text-5xl font-bold text-gray-900 mb-6 px-4">
            Developer Resources
        </h1>
        <p class="text-lg sm:text-xl text-gray-600 max-w-3xl mx-auto mb-8 px-4">
            Integrate EasyPDF Pro's powerful PDF processing capabilities into your applications.
        </p>
    </div>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
        <!-- API Overview -->
        <div class="bg-white rounded-xl border border-gray-200 p-8 mb-8">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">EasyPDF Pro API</h2>
                    <p class="text-gray-600">Powered by AVR Technology</p>
                </div>
            </div>
            
            <p class="text-gray-600 mb-6">
                Our RESTful API provides programmatic access to all EasyPDF Pro features. Built with enterprise-grade 
                security and scalability, it's perfect for integrating PDF processing into your applications.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="text-3xl font-bold text-blue-600 mb-2">99.9%</div>
                    <div class="text-gray-600">Uptime SLA</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-green-600 mb-2">&lt;2s</div>
                    <div class="text-gray-600">Average Response</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-purple-600 mb-2">15+</div>
                    <div class="text-gray-600">PDF Operations</div>
                </div>
            </div>
        </div>

        <!-- API Features -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <!-- Conversion APIs -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Document Conversion</h3>
                <ul class="text-gray-600 space-y-2 text-sm">
                    <li>• PDF to Word, Excel, PowerPoint</li>
                    <li>• Office documents to PDF</li>
                    <li>• Image to PDF conversion</li>
                    <li>• PDF to image extraction</li>
                </ul>
            </div>

            <!-- Manipulation APIs -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">PDF Manipulation</h3>
                <ul class="text-gray-600 space-y-2 text-sm">
                    <li>• Merge and split PDFs</li>
                    <li>• Compress and optimize</li>
                    <li>• Add watermarks and signatures</li>
                    <li>• Rotate and reorder pages</li>
                </ul>
            </div>
        </div>

        <!-- Code Example -->
        <div class="bg-white rounded-xl border border-gray-200 p-8 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Quick Start Example</h2>
            
            <div class="bg-gray-900 rounded-lg p-6 overflow-x-auto">
                <pre class="text-green-400 text-sm"><code>// Convert PDF to Word using EasyPDF Pro API
const response = await fetch('https://api.easypdfpro.com/v1/convert/pdf-to-word', {
  method: 'POST',
  headers: {
    'Authorization': 'Bearer YOUR_API_KEY',
    'Content-Type': 'multipart/form-data'
  },
  body: formData
});

const result = await response.json();
console.log('Conversion completed:', result.download_url);</code></pre>
            </div>
            
            <div class="mt-4 flex flex-wrap gap-2">
                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">JavaScript</span>
                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Python</span>
                <span class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded">PHP</span>
                <span class="bg-orange-100 text-orange-800 text-xs font-medium px-2.5 py-0.5 rounded">cURL</span>
            </div>
        </div>

        <!-- Documentation Links -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <a href="#" class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition-shadow group">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mb-4 group-hover:bg-blue-200 transition-colors">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">API Documentation</h3>
                <p class="text-gray-600 text-sm">Complete API reference and guides</p>
            </a>

            <a href="#" class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition-shadow group">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mb-4 group-hover:bg-green-200 transition-colors">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Code Examples</h3>
                <p class="text-gray-600 text-sm">Ready-to-use code snippets</p>
            </a>

            <a href="#" class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition-shadow group">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mb-4 group-hover:bg-purple-200 transition-colors">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">SDKs & Libraries</h3>
                <p class="text-gray-600 text-sm">Official SDKs for popular languages</p>
            </a>

            <a href="#" class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition-shadow group">
                <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mb-4 group-hover:bg-orange-200 transition-colors">
                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Support</h3>
                <p class="text-gray-600 text-sm">Developer support and community</p>
            </a>
        </div>

        <!-- Coming Soon -->
        <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl p-8 text-center">
            <div class="w-16 h-16 mx-auto mb-4">
                <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                    <rect x="8" y="8" width="32" height="32" rx="4" fill="#3B82F6" />
                    <path d="M24 16V24" stroke="white" stroke-width="3" stroke-linecap="round" />
                    <circle cx="24" cy="30" r="2" fill="white" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-4">API Coming Soon!</h2>
            <p class="text-gray-600 mb-6">
                We're putting the finishing touches on our developer API. Built by AVR Technology with enterprise-grade 
                security and performance. Join our waitlist to be the first to know when it launches.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('pages.contact') }}" 
                   class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    Join API Waitlist
                </a>
                <a href="mailto:developers@avrtechnology.com" 
                   class="inline-flex items-center px-6 py-3 bg-white text-blue-600 font-medium rounded-lg border border-blue-600 hover:bg-blue-50 transition-colors">
                    Contact Dev Team
                </a>
            </div>
        </div>
    </div>
@endsection