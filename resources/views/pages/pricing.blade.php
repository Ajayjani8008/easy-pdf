@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <div class="text-center py-12 sm:py-20 bg-gray-50">
        <h1 class="text-3xl sm:text-5xl font-bold text-gray-900 mb-6 px-4">
            Simple, Transparent Pricing
        </h1>
        <p class="text-lg sm:text-xl text-gray-600 max-w-3xl mx-auto mb-8 px-4">
            All EasyPDF Pro tools are completely free. No hidden fees, no subscriptions, no limits.
        </p>
    </div>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
        <!-- Free Plan -->
        <div class="max-w-2xl mx-auto mb-12">
            <div class="bg-white rounded-2xl border-2 border-blue-200 p-8 text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 to-purple-600"></div>
                
                <div class="w-16 h-16 mx-auto mb-6 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Free Forever</h2>
                <div class="text-6xl font-bold text-gray-900 mb-2">$0</div>
                <p class="text-gray-600 mb-8">All features included, no strings attached</p>
                
                <div class="space-y-4 mb-8">
                    <div class="flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-gray-700">All PDF conversion tools</span>
                    </div>
                    <div class="flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-gray-700">Unlimited file processing</span>
                    </div>
                    <div class="flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-gray-700">Files up to 100MB</span>
                    </div>
                    <div class="flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-gray-700">SSL encryption & security</span>
                    </div>
                    <div class="flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-gray-700">Auto-delete after 1 hour</span>
                    </div>
                    <div class="flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-gray-700">No registration required</span>
                    </div>
                </div>
                
                <a href="{{ url('/') }}" 
                   class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-medium rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all transform hover:scale-105">
                    Start Using Now - It's Free!
                </a>
            </div>
        </div>

        <!-- Why Free? -->
        <div class="bg-white rounded-xl border border-gray-200 p-8 mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Why is EasyPDF Pro Free?</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-12 h-12 mx-auto mb-4 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Our Mission</h3>
                    <p class="text-gray-600 text-sm">
                        We believe PDF tools should be accessible to everyone. AVR Technology is committed to 
                        democratizing document processing.
                    </p>
                </div>
                
                <div class="text-center">
                    <div class="w-12 h-12 mx-auto mb-4 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Innovation Focus</h3>
                    <p class="text-gray-600 text-sm">
                        By keeping our tools free, we can focus on innovation and building the best PDF 
                        processing experience possible.
                    </p>
                </div>
                
                <div class="text-center">
                    <div class="w-12 h-12 mx-auto mb-4 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Community First</h3>
                    <p class="text-gray-600 text-sm">
                        We're building a community of users who love working with PDFs. Your feedback 
                        helps us improve every day.
                    </p>
                </div>
            </div>
        </div>

        <!-- Enterprise Solutions -->
        <div class="bg-gradient-to-r from-gray-50 to-blue-50 rounded-xl p-8 mb-12">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Need Enterprise Solutions?</h2>
                <p class="text-gray-600 mb-6">
                    Looking for API access, custom integrations, or enterprise-grade support? 
                    AVR Technology offers tailored solutions for businesses of all sizes.
                </p>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white rounded-lg p-4">
                        <h3 class="font-semibold text-gray-900 mb-2">API Access</h3>
                        <p class="text-gray-600 text-sm">Integrate PDF processing into your applications</p>
                    </div>
                    <div class="bg-white rounded-lg p-4">
                        <h3 class="font-semibold text-gray-900 mb-2">Custom Solutions</h3>
                        <p class="text-gray-600 text-sm">Tailored PDF tools for your specific needs</p>
                    </div>
                    <div class="bg-white rounded-lg p-4">
                        <h3 class="font-semibold text-gray-900 mb-2">Priority Support</h3>
                        <p class="text-gray-600 text-sm">Dedicated support team and SLA guarantees</p>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('pages.contact') }}" 
                       class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        Contact Sales
                    </a>
                    <a href="mailto:enterprise@avrtechnology.com" 
                       class="inline-flex items-center px-6 py-3 bg-white text-blue-600 font-medium rounded-lg border border-blue-600 hover:bg-blue-50 transition-colors">
                        Email Enterprise Team
                    </a>
                </div>
            </div>
        </div>

        <!-- FAQ -->
        <div class="bg-white rounded-xl border border-gray-200 p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Frequently Asked Questions</h2>
            
            <div class="max-w-3xl mx-auto space-y-6">
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Is EasyPDF Pro really free forever?</h3>
                    <p class="text-gray-600">
                        Yes! All our PDF tools are completely free with no hidden costs, time limits, or feature restrictions. 
                        This is our commitment to making PDF processing accessible to everyone.
                    </p>
                </div>
                
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Are there any usage limits?</h3>
                    <p class="text-gray-600">
                        We have a 100MB file size limit per upload to ensure optimal performance for all users. 
                        There are no daily or monthly usage limits.
                    </p>
                </div>
                
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">How do you make money if it's free?</h3>
                    <p class="text-gray-600">
                        AVR Technology offers enterprise solutions and API services to businesses. The free consumer 
                        tools help us build a great product that enterprises want to integrate.
                    </p>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Will you ever start charging?</h3>
                    <p class="text-gray-600">
                        Our core PDF tools will always remain free. We may introduce premium features in the future, 
                        but the essential functionality you use today will never require payment.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection