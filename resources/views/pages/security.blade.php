@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <div class="text-center py-12 sm:py-20 bg-gradient-to-br from-blue-50 to-indigo-100">
        <div class="max-w-4xl mx-auto px-4">
            <div class="w-20 h-20 mx-auto mb-6 bg-blue-600 rounded-full flex items-center justify-center">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h1 class="text-3xl sm:text-5xl font-bold text-gray-900 mb-6">
                Your Security is Our Priority
            </h1>
            <p class="text-lg sm:text-xl text-gray-600 max-w-3xl mx-auto">
                At EasyPDF Pro, we implement enterprise-grade security measures to protect your documents and privacy. Learn about our comprehensive security infrastructure.
            </p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Security Overview -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-16">
            <div class="bg-green-50 border border-green-200 rounded-xl p-6 text-center">
                <div class="w-12 h-12 mx-auto mb-4 bg-green-600 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-green-900 mb-2">SSL Encryption</h3>
                <p class="text-green-700">All data transfers are protected with 256-bit SSL encryption</p>
            </div>
            
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 text-center">
                <div class="w-12 h-12 mx-auto mb-4 bg-blue-600 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-blue-900 mb-2">Auto-Delete</h3>
                <p class="text-blue-700">Files automatically deleted within 1 hour of processing</p>
            </div>
            
            <div class="bg-purple-50 border border-purple-200 rounded-xl p-6 text-center">
                <div class="w-12 h-12 mx-auto mb-4 bg-purple-600 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-purple-900 mb-2">No Human Access</h3>
                <p class="text-purple-700">Fully automated processing with zero human intervention</p>
            </div>
        </div>

        <!-- Detailed Security Measures -->
        <div class="space-y-12">
            <!-- Data Protection -->
            <section>
                <h2 class="text-3xl font-bold text-gray-900 mb-8">Data Protection & Privacy</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div class="flex items-start space-x-4">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-2">End-to-End Encryption</h3>
                                <p class="text-gray-600">Your files are encrypted during upload, processing, and download using industry-standard AES-256 encryption.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-2">Automatic File Deletion</h3>
                                <p class="text-gray-600">All uploaded and processed files are permanently deleted from our servers within 60 minutes.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-2">No Registration Required</h3>
                                <p class="text-gray-600">Use all our tools without creating an account. We don't collect or store personal information.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-6">
                        <div class="flex items-start space-x-4">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-2">Secure Cloud Infrastructure</h3>
                                <p class="text-gray-600">Hosted on enterprise-grade cloud servers with 99.9% uptime and advanced DDoS protection.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-2">GDPR Compliant</h3>
                                <p class="text-gray-600">Fully compliant with GDPR, CCPA, and other international privacy regulations.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-2">Regular Security Audits</h3>
                                <p class="text-gray-600">Our systems undergo regular security assessments and penetration testing.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Technical Security -->
            <section class="bg-gray-50 rounded-2xl p-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-8">Technical Security Measures</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-lg p-6 border border-gray-200">
                        <h3 class="font-bold text-gray-900 mb-3">Network Security</h3>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li>• TLS 1.3 encryption</li>
                            <li>• WAF protection</li>
                            <li>• DDoS mitigation</li>
                            <li>• IP rate limiting</li>
                        </ul>
                    </div>
                    
                    <div class="bg-white rounded-lg p-6 border border-gray-200">
                        <h3 class="font-bold text-gray-900 mb-3">Server Security</h3>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li>• Isolated processing</li>
                            <li>• Encrypted storage</li>
                            <li>• Access logging</li>
                            <li>• Automated backups</li>
                        </ul>
                    </div>
                    
                    <div class="bg-white rounded-lg p-6 border border-gray-200">
                        <h3 class="font-bold text-gray-900 mb-3">Application Security</h3>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li>• Input validation</li>
                            <li>• CSRF protection</li>
                            <li>• XSS prevention</li>
                            <li>• Secure headers</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- AVR Technology -->
            <section class="text-center bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl p-8 text-white">
                <h2 class="text-2xl font-bold mb-4">Powered by AVR Technology</h2>
                <p class="text-blue-100 mb-6 max-w-2xl mx-auto">
                    EasyPDF Pro is developed and maintained by AVR Technology, a trusted leader in secure web applications and digital document processing solutions.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="https://avrtechnology.com" target="_blank" 
                       class="inline-flex items-center px-6 py-3 bg-white text-blue-600 font-medium rounded-lg hover:bg-gray-100 transition-colors">
                        Visit AVR Technology
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                    <a href="{{ route('pages.contact') }}" 
                       class="inline-flex items-center px-6 py-3 bg-transparent text-white font-medium rounded-lg border border-white hover:bg-white hover:text-blue-600 transition-colors">
                        Contact Security Team
                    </a>
                </div>
            </section>
        </div>
    </div>
@endsection