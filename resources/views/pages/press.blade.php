@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <div class="text-center py-12 sm:py-20 bg-gradient-to-br from-indigo-50 to-blue-100">
        <div class="max-w-4xl mx-auto px-4">
            <div class="w-20 h-20 mx-auto mb-6 bg-indigo-600 rounded-full flex items-center justify-center">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
            </div>
            <h1 class="text-3xl sm:text-5xl font-bold text-gray-900 mb-6">
                Press & Media
            </h1>
            <p class="text-lg sm:text-xl text-gray-600 max-w-3xl mx-auto">
                Media resources, press releases, and company information for journalists, bloggers, and media professionals covering EasyPDF Pro and AVR Technology.
            </p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Quick Facts -->
        <section class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Quick Facts</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 text-center">
                    <div class="text-3xl font-bold text-blue-600 mb-2">10M+</div>
                    <div class="text-gray-700 font-medium">Monthly Users</div>
                </div>
                
                <div class="bg-green-50 border border-green-200 rounded-xl p-6 text-center">
                    <div class="text-3xl font-bold text-green-600 mb-2">100M+</div>
                    <div class="text-gray-700 font-medium">Files Processed</div>
                </div>
                
                <div class="bg-purple-50 border border-purple-200 rounded-xl p-6 text-center">
                    <div class="text-3xl font-bold text-purple-600 mb-2">16</div>
                    <div class="text-gray-700 font-medium">PDF Tools</div>
                </div>
                
                <div class="bg-orange-50 border border-orange-200 rounded-xl p-6 text-center">
                    <div class="text-3xl font-bold text-orange-600 mb-2">2019</div>
                    <div class="text-gray-700 font-medium">Founded</div>
                </div>
            </div>
        </section>

        <!-- Press Releases -->
        <section class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8">Latest Press Releases</h2>
            <div class="space-y-6">
                <article class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">EasyPDF Pro Reaches 10 Million Monthly Users Milestone</h3>
                            <p class="text-gray-600 mb-3">
                                AVR Technology announces that EasyPDF Pro has surpassed 10 million monthly active users, making it one of the fastest-growing PDF processing platforms globally.
                            </p>
                            <div class="flex items-center text-sm text-gray-500">
                                <span>December 10, 2024</span>
                                <span class="mx-2">•</span>
                                <span>Company News</span>
                            </div>
                        </div>
                        <button class="ml-4 px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors">
                            Read More
                        </button>
                    </div>
                </article>

                <article class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">AVR Technology Launches Enhanced Security Features for Enterprise Users</h3>
                            <p class="text-gray-600 mb-3">
                                New enterprise-grade security measures include advanced encryption, audit logs, and compliance certifications to meet growing business demands.
                            </p>
                            <div class="flex items-center text-sm text-gray-500">
                                <span>November 15, 2024</span>
                                <span class="mx-2">•</span>
                                <span>Product Update</span>
                            </div>
                        </div>
                        <button class="ml-4 px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors">
                            Read More
                        </button>
                    </div>
                </article>

                <article class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">EasyPDF Pro Wins "Best Productivity Tool" Award at TechCrunch Disrupt</h3>
                            <p class="text-gray-600 mb-3">
                                Recognition for innovation in document processing and user experience design highlights the platform's impact on digital productivity.
                            </p>
                            <div class="flex items-center text-sm text-gray-500">
                                <span>October 8, 2024</span>
                                <span class="mx-2">•</span>
                                <span>Awards</span>
                            </div>
                        </div>
                        <button class="ml-4 px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors">
                            Read More
                        </button>
                    </div>
                </article>
            </div>
        </section>

        <!-- Media Kit -->
        <section class="mb-16 bg-gray-50 rounded-2xl p-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Media Kit & Resources</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white rounded-lg p-6 border border-gray-200">
                    <div class="w-12 h-12 mb-4 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-3">Brand Assets</h3>
                    <p class="text-gray-600 text-sm mb-4">High-resolution logos, brand colors, and usage guidelines</p>
                    <button class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        Download ZIP
                    </button>
                </div>

                <div class="bg-white rounded-lg p-6 border border-gray-200">
                    <div class="w-12 h-12 mb-4 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-3">Fact Sheet</h3>
                    <p class="text-gray-600 text-sm mb-4">Company overview, key statistics, and executive bios</p>
                    <button class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition-colors">
                        Download PDF
                    </button>
                </div>

                <div class="bg-white rounded-lg p-6 border border-gray-200">
                    <div class="w-12 h-12 mb-4 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-3">Product Screenshots</h3>
                    <p class="text-gray-600 text-sm mb-4">High-quality screenshots and product demos</p>
                    <button class="w-full bg-purple-600 text-white py-2 rounded-lg hover:bg-purple-700 transition-colors">
                        View Gallery
                    </button>
                </div>
            </div>
        </section>

        <!-- Leadership Team -->
        <section class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Leadership Team</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-32 h-32 mx-auto mb-4 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center">
                        <span class="text-2xl font-bold text-white">AK</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-1">Alex Kumar</h3>
                    <p class="text-blue-600 font-medium mb-2">CEO & Founder</p>
                    <p class="text-gray-600 text-sm">Former Google engineer with 10+ years in document processing and cloud infrastructure.</p>
                </div>

                <div class="text-center">
                    <div class="w-32 h-32 mx-auto mb-4 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center">
                        <span class="text-2xl font-bold text-white">SM</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-1">Sarah Martinez</h3>
                    <p class="text-purple-600 font-medium mb-2">CTO</p>
                    <p class="text-gray-600 text-sm">Technology leader with expertise in scalable web applications and machine learning.</p>
                </div>

                <div class="text-center">
                    <div class="w-32 h-32 mx-auto mb-4 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center">
                        <span class="text-2xl font-bold text-white">DJ</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-1">David Johnson</h3>
                    <p class="text-green-600 font-medium mb-2">VP of Product</p>
                    <p class="text-gray-600 text-sm">Product strategist focused on user experience and growth, previously at Adobe and Dropbox.</p>
                </div>
            </div>
        </section>

        <!-- Awards & Recognition -->
        <section class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Awards & Recognition</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white border border-gray-200 rounded-xl p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Best Productivity Tool 2024</h3>
                            <p class="text-gray-600 text-sm">TechCrunch Disrupt</p>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm">Recognized for innovation in document processing and exceptional user experience design.</p>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Top 50 SaaS Companies</h3>
                            <p class="text-gray-600 text-sm">SaaS Magazine</p>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm">Listed among the fastest-growing SaaS companies in the productivity software category.</p>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Security Excellence Award</h3>
                            <p class="text-gray-600 text-sm">CyberSecurity Awards</p>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm">Honored for implementing industry-leading security practices and data protection measures.</p>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">User Choice Award</h3>
                            <p class="text-gray-600 text-sm">Product Hunt</p>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm">Voted by users as the most helpful PDF processing tool with highest satisfaction ratings.</p>
                </div>
            </div>
        </section>

        <!-- Media Contact -->
        <section class="text-center bg-gradient-to-r from-indigo-600 to-blue-600 rounded-2xl p-8 text-white">
            <h2 class="text-2xl font-bold mb-4">Media Inquiries</h2>
            <p class="text-indigo-100 mb-6 max-w-2xl mx-auto">
                For press inquiries, interview requests, or additional information about EasyPDF Pro and AVR Technology, please contact our media team.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="mailto:press@avrtechnology.com" 
                   class="inline-flex items-center px-6 py-3 bg-white text-indigo-600 font-medium rounded-lg hover:bg-gray-100 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    press@avrtechnology.com
                </a>
                <a href="{{ route('pages.contact') }}" 
                   class="inline-flex items-center px-6 py-3 bg-transparent text-white font-medium rounded-lg border border-white hover:bg-white hover:text-indigo-600 transition-colors">
                    Contact Form
                </a>
            </div>
            <div class="mt-6 text-indigo-200 text-sm">
                <p>Media Response Time: Within 24 hours</p>
                <p>Available for interviews: Monday - Friday, 9 AM - 6 PM PST</p>
            </div>
        </section>
    </div>
@endsection