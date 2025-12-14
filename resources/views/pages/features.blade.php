@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <div class="text-center py-12 sm:py-20 bg-gray-50">
        <h1 class="text-3xl sm:text-5xl font-bold text-gray-900 mb-6 px-4">
            Powerful PDF Features
        </h1>
        <p class="text-lg sm:text-xl text-gray-600 max-w-3xl mx-auto mb-8 px-4">
            Discover all the amazing features that make EasyPDF Pro the best choice for PDF processing.
        </p>
    </div>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
        <!-- Core Features -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">Core PDF Tools</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- PDF to Word -->
                <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 mb-4">
                        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                            <rect x="8" y="8" width="32" height="32" rx="4" fill="#4DABF7" />
                            <path d="M14 16H22V24H14V16Z" fill="white" />
                            <path d="M26 18H34" stroke="white" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">PDF to Word</h3>
                    <p class="text-gray-600 mb-4">Convert PDFs to editable Word documents with perfect formatting preservation.</p>
                    <ul class="text-sm text-gray-500 space-y-1">
                        <li>• Maintains text formatting</li>
                        <li>• Preserves images and tables</li>
                        <li>• Supports DOC and DOCX</li>
                    </ul>
                </div>

                <!-- Merge PDF -->
                <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 mb-4">
                        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                            <rect x="8" y="8" width="32" height="32" rx="4" fill="#FF6B6B" />
                            <path d="M16 24H32" stroke="white" stroke-width="3" stroke-linecap="round" />
                            <path d="M24 16L28 20L24 24" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Merge PDF</h3>
                    <p class="text-gray-600 mb-4">Combine multiple PDF files into a single document effortlessly.</p>
                    <ul class="text-sm text-gray-500 space-y-1">
                        <li>• Drag & drop reordering</li>
                        <li>• Unlimited file merging</li>
                        <li>• Maintains quality</li>
                    </ul>
                </div>

                <!-- Split PDF -->
                <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 mb-4">
                        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                            <rect x="8" y="8" width="32" height="32" rx="4" fill="#FF6B6B" />
                            <path d="M24 14V34" stroke="white" stroke-width="3" stroke-linecap="round" stroke-dasharray="4 4" />
                            <path d="M18 20L14 24L18 28" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Split PDF</h3>
                    <p class="text-gray-600 mb-4">Extract specific pages or split PDFs into separate documents.</p>
                    <ul class="text-sm text-gray-500 space-y-1">
                        <li>• Extract single pages</li>
                        <li>• Split by page ranges</li>
                        <li>• Bulk page extraction</li>
                    </ul>
                </div>

                <!-- Compress PDF -->
                <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 mb-4">
                        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                            <rect x="8" y="8" width="32" height="32" rx="4" fill="#51CF66" />
                            <path d="M24 14V34" stroke="white" stroke-width="3" stroke-linecap="round" />
                            <path d="M32 26L24 34L16 26" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Compress PDF</h3>
                    <p class="text-gray-600 mb-4">Reduce PDF file size while maintaining optimal quality.</p>
                    <ul class="text-sm text-gray-500 space-y-1">
                        <li>• Smart compression</li>
                        <li>• Quality preservation</li>
                        <li>• Up to 90% size reduction</li>
                    </ul>
                </div>

                <!-- PDF to JPG -->
                <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 mb-4">
                        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                            <rect x="8" y="8" width="32" height="32" rx="4" fill="#FFD43B" />
                            <rect x="14" y="14" width="20" height="20" rx="2" stroke="white" stroke-width="3" />
                            <circle cx="20" cy="20" r="2" fill="white" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">PDF to JPG</h3>
                    <p class="text-gray-600 mb-4">Convert PDF pages to high-quality JPG images.</p>
                    <ul class="text-sm text-gray-500 space-y-1">
                        <li>• High resolution output</li>
                        <li>• Batch conversion</li>
                        <li>• Multiple format support</li>
                    </ul>
                </div>

                <!-- Word to PDF -->
                <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 mb-4">
                        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                            <rect x="8" y="8" width="32" height="32" rx="4" fill="#74C0FC" />
                            <path d="M34 16H26V24H34V16Z" fill="white" />
                            <path d="M22 18H14" stroke="white" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Word to PDF</h3>
                    <p class="text-gray-600 mb-4">Convert Word documents to professional PDF files.</p>
                    <ul class="text-sm text-gray-500 space-y-1">
                        <li>• Perfect formatting</li>
                        <li>• Supports DOC/DOCX</li>
                        <li>• Print-ready output</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Security Features -->
        <div class="bg-gradient-to-r from-green-50 to-blue-50 rounded-xl p-8 mb-16">
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-8">Security & Privacy</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="w-12 h-12 mx-auto mb-4 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">SSL Encryption</h3>
                    <p class="text-gray-600 text-sm">All file uploads protected with 256-bit SSL encryption</p>
                </div>
                
                <div class="text-center">
                    <div class="w-12 h-12 mx-auto mb-4 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Auto-Delete</h3>
                    <p class="text-gray-600 text-sm">Files automatically deleted within 1 hour of processing</p>
                </div>
                
                <div class="text-center">
                    <div class="w-12 h-12 mx-auto mb-4 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">No Human Access</h3>
                    <p class="text-gray-600 text-sm">Automated processing means no one can view your files</p>
                </div>
                
                <div class="text-center">
                    <div class="w-12 h-12 mx-auto mb-4 bg-orange-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">GDPR Compliant</h3>
                    <p class="text-gray-600 text-sm">Full compliance with privacy regulations worldwide</p>
                </div>
            </div>
        </div>

        <!-- Performance Features -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">Performance & Reliability</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-xl border border-gray-200 p-8 text-center">
                    <div class="text-4xl font-bold text-blue-600 mb-2">&lt;2s</div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Lightning Fast</h3>
                    <p class="text-gray-600">Most conversions complete in under 2 seconds with our optimized processing engines.</p>
                </div>
                
                <div class="bg-white rounded-xl border border-gray-200 p-8 text-center">
                    <div class="text-4xl font-bold text-green-600 mb-2">99.9%</div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Uptime</h3>
                    <p class="text-gray-600">Reliable service powered by AVR Technology's enterprise infrastructure.</p>
                </div>
                
                <div class="bg-white rounded-xl border border-gray-200 p-8 text-center">
                    <div class="text-4xl font-bold text-purple-600 mb-2">100MB</div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">File Size Limit</h3>
                    <p class="text-gray-600">Process large documents up to 100MB without quality loss or compression.</p>
                </div>
            </div>
        </div>

        <!-- Coming Soon Features -->
        <div class="bg-white rounded-xl border border-gray-200 p-8">
            <h2 class="text-2xl font-bold text-gray-900 text-center mb-8">Coming Soon</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="p-6 border border-gray-200 rounded-lg">
                    <div class="w-10 h-10 mb-4 bg-gray-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Advanced PDF Editor</h3>
                    <p class="text-gray-600 text-sm">Add text, images, and shapes directly to your PDFs</p>
                </div>
                
                <div class="p-6 border border-gray-200 rounded-lg">
                    <div class="w-10 h-10 mb-4 bg-gray-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Digital Signatures</h3>
                    <p class="text-gray-600 text-sm">Sign PDFs electronically with legally binding signatures</p>
                </div>
                
                <div class="p-6 border border-gray-200 rounded-lg">
                    <div class="w-10 h-10 mb-4 bg-gray-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Watermark Tools</h3>
                    <p class="text-gray-600 text-sm">Add custom watermarks and branding to your documents</p>
                </div>
            </div>
            
            <div class="text-center mt-8">
                <p class="text-gray-600 mb-4">
                    Want to be notified when new features launch? 
                </p>
                <a href="{{ route('pages.contact') }}" 
                   class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    Get Feature Updates
                </a>
            </div>
        </div>
    </div>
@endsection