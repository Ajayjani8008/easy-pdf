@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <div class="text-center py-12 sm:py-20 bg-gradient-to-br from-purple-50 to-pink-100">
        <div class="max-w-4xl mx-auto px-4">
            <div class="w-20 h-20 mx-auto mb-6 bg-purple-600 rounded-full flex items-center justify-center">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <h1 class="text-3xl sm:text-5xl font-bold text-gray-900 mb-6">
                Join Our Team
            </h1>
            <p class="text-lg sm:text-xl text-gray-600 max-w-3xl mx-auto">
                Help us make PDF processing easier for millions of users worldwide. Join AVR Technology and be part of building the future of document management.
            </p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Why Join Us -->
        <section class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Why Work at AVR Technology?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-4 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Innovation First</h3>
                    <p class="text-gray-600">Work on cutting-edge technologies and shape the future of document processing with millions of users.</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-4 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Competitive Benefits</h3>
                    <p class="text-gray-600">Comprehensive health coverage, flexible PTO, stock options, and professional development budget.</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-4 bg-purple-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Remote Friendly</h3>
                    <p class="text-gray-600">Work from anywhere with flexible hours and a strong remote-first culture that values work-life balance.</p>
                </div>
            </div>
        </section>

        <!-- Open Positions -->
        <section class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8">Open Positions</h2>
            <div class="space-y-6">
                <!-- Senior Full Stack Developer -->
                <div class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-lg transition-shadow">
                    <div class="flex flex-col md:flex-row md:items-center justify-between mb-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Senior Full Stack Developer</h3>
                            <div class="flex flex-wrap gap-2 mb-2">
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full">Full-time</span>
                                <span class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full">Remote</span>
                                <span class="px-3 py-1 bg-purple-100 text-purple-800 text-sm rounded-full">Senior Level</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-gray-900">$120k - $160k</div>
                            <div class="text-sm text-gray-500">+ Equity</div>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4">
                        Lead the development of EasyPDF Pro's core features. Work with Laravel, Vue.js, and modern cloud infrastructure to serve millions of users.
                    </p>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">Laravel</span>
                        <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">Vue.js</span>
                        <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">AWS</span>
                        <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">Docker</span>
                        <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">MySQL</span>
                    </div>
                    <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        Apply Now
                    </button>
                </div>

                <!-- DevOps Engineer -->
                <div class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-lg transition-shadow">
                    <div class="flex flex-col md:flex-row md:items-center justify-between mb-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">DevOps Engineer</h3>
                            <div class="flex flex-wrap gap-2 mb-2">
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full">Full-time</span>
                                <span class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full">Remote</span>
                                <span class="px-3 py-1 bg-orange-100 text-orange-800 text-sm rounded-full">Mid Level</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-gray-900">$100k - $140k</div>
                            <div class="text-sm text-gray-500">+ Equity</div>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4">
                        Scale our infrastructure to handle millions of PDF processing requests. Build robust CI/CD pipelines and monitoring systems.
                    </p>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">Kubernetes</span>
                        <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">AWS</span>
                        <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">Terraform</span>
                        <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">Monitoring</span>
                        <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">CI/CD</span>
                    </div>
                    <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        Apply Now
                    </button>
                </div>

                <!-- Product Designer -->
                <div class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-lg transition-shadow">
                    <div class="flex flex-col md:flex-row md:items-center justify-between mb-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Product Designer</h3>
                            <div class="flex flex-wrap gap-2 mb-2">
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full">Full-time</span>
                                <span class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full">Remote</span>
                                <span class="px-3 py-1 bg-orange-100 text-orange-800 text-sm rounded-full">Mid Level</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-gray-900">$90k - $120k</div>
                            <div class="text-sm text-gray-500">+ Equity</div>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4">
                        Design intuitive user experiences for our PDF tools. Create beautiful, accessible interfaces that make complex tasks simple.
                    </p>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">Figma</span>
                        <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">UI/UX</span>
                        <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">Prototyping</span>
                        <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">User Research</span>
                        <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">Design Systems</span>
                    </div>
                    <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        Apply Now
                    </button>
                </div>

                <!-- Marketing Manager -->
                <div class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-lg transition-shadow">
                    <div class="flex flex-col md:flex-row md:items-center justify-between mb-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Marketing Manager</h3>
                            <div class="flex flex-wrap gap-2 mb-2">
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full">Full-time</span>
                                <span class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full">Remote</span>
                                <span class="px-3 py-1 bg-orange-100 text-orange-800 text-sm rounded-full">Mid Level</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-gray-900">$80k - $110k</div>
                            <div class="text-sm text-gray-500">+ Equity</div>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4">
                        Drive growth and user acquisition for EasyPDF Pro. Develop marketing strategies, content campaigns, and partnerships.
                    </p>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">Digital Marketing</span>
                        <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">SEO/SEM</span>
                        <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">Content Strategy</span>
                        <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">Analytics</span>
                        <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">Growth Hacking</span>
                    </div>
                    <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        Apply Now
                    </button>
                </div>
            </div>
        </section>

        <!-- Company Culture -->
        <section class="mb-16 bg-gray-50 rounded-2xl p-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Our Culture & Values</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">🚀 Innovation & Excellence</h3>
                        <p class="text-gray-600">We're passionate about building the best PDF tools in the world. Every team member contributes to our mission of making document processing effortless.</p>
                    </div>
                    
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">🤝 Collaboration & Respect</h3>
                        <p class="text-gray-600">We believe diverse perspectives make us stronger. Our inclusive environment welcomes all backgrounds and encourages open communication.</p>
                    </div>
                </div>
                
                <div class="space-y-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">📈 Growth & Learning</h3>
                        <p class="text-gray-600">Continuous learning is part of our DNA. We provide mentorship, conference budgets, and opportunities to work on challenging projects.</p>
                    </div>
                    
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">⚖️ Work-Life Balance</h3>
                        <p class="text-gray-600">We understand that great work comes from well-rested, happy people. Flexible schedules and unlimited PTO help you do your best work.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Application Process -->
        <section class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Application Process</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="w-12 h-12 mx-auto mb-4 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">1</div>
                    <h3 class="font-bold text-gray-900 mb-2">Apply Online</h3>
                    <p class="text-sm text-gray-600">Submit your application with resume and portfolio</p>
                </div>
                
                <div class="text-center">
                    <div class="w-12 h-12 mx-auto mb-4 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">2</div>
                    <h3 class="font-bold text-gray-900 mb-2">Phone Screen</h3>
                    <p class="text-sm text-gray-600">30-minute call with our talent team</p>
                </div>
                
                <div class="text-center">
                    <div class="w-12 h-12 mx-auto mb-4 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">3</div>
                    <h3 class="font-bold text-gray-900 mb-2">Technical Interview</h3>
                    <p class="text-sm text-gray-600">Technical discussion and coding challenge</p>
                </div>
                
                <div class="text-center">
                    <div class="w-12 h-12 mx-auto mb-4 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">4</div>
                    <h3 class="font-bold text-gray-900 mb-2">Final Interview</h3>
                    <p class="text-sm text-gray-600">Meet the team and discuss culture fit</p>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="text-center bg-gradient-to-r from-purple-600 to-blue-600 rounded-2xl p-8 text-white">
            <h2 class="text-2xl font-bold mb-4">Ready to Join AVR Technology?</h2>
            <p class="text-purple-100 mb-6 max-w-2xl mx-auto">
                Don't see a position that fits? We're always looking for talented individuals. Send us your resume and let us know how you'd like to contribute.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('pages.contact') }}" 
                   class="inline-flex items-center px-6 py-3 bg-white text-purple-600 font-medium rounded-lg hover:bg-gray-100 transition-colors">
                    Send Your Resume
                </a>
                <a href="https://avrtechnology.com" target="_blank"
                   class="inline-flex items-center px-6 py-3 bg-transparent text-white font-medium rounded-lg border border-white hover:bg-white hover:text-purple-600 transition-colors">
                    Learn About AVR Technology
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </a>
            </div>
        </section>
    </div>
@endsection