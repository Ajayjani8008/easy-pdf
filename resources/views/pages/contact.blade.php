@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <div class="text-center py-12 sm:py-20 bg-gray-50">
        <h1 class="text-3xl sm:text-5xl font-bold text-gray-900 mb-6 px-4">
            Get in Touch
        </h1>
        <p class="text-lg sm:text-xl text-gray-600 max-w-3xl mx-auto mb-8 px-4">
            Have questions, feedback, or need support? We'd love to hear from you.
        </p>
    </div>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div class="bg-white rounded-xl border border-gray-200 p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Send us a Message</h2>
                
                <!-- Success Message -->
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <p class="text-green-700 font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                <!-- Error Message -->
                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <p class="text-red-700 font-medium">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif
                
                <form class="space-y-6" action="{{ route('pages.contact.store') }}" method="POST">
                    @csrf
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                            class="w-full px-4 py-3 border @error('name') border-red-300 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-4 py-3 border @error('email') border-red-300 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Subject -->
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                        <select id="subject" name="subject" required
                            class="w-full px-4 py-3 border @error('subject') border-red-300 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="">Select a subject</option>
                            <option value="general" {{ old('subject') == 'general' ? 'selected' : '' }}>General Inquiry</option>
                            <option value="support" {{ old('subject') == 'support' ? 'selected' : '' }}>Technical Support</option>
                            <option value="feature" {{ old('subject') == 'feature' ? 'selected' : '' }}>Feature Request</option>
                            <option value="bug" {{ old('subject') == 'bug' ? 'selected' : '' }}>Bug Report</option>
                            <option value="business" {{ old('subject') == 'business' ? 'selected' : '' }}>Business Inquiry</option>
                        </select>
                        @error('subject')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Message -->
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                        <textarea id="message" name="message" rows="5" required
                            class="w-full px-4 py-3 border @error('message') border-red-300 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            placeholder="Tell us how we can help you...">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                        Send Message
                    </button>
                </form>
            </div>

            <!-- Contact Information -->
            <div class="space-y-8">
                <!-- Contact Methods -->
                <div class="bg-white rounded-xl border border-gray-200 p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Contact Information</h2>
                    
                    <div class="space-y-6">
                        <!-- Email -->
                        <div class="flex items-start">
                            <div class="w-12 h-12 mr-4 flex-shrink-0">
                                <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                                    <rect x="8" y="8" width="32" height="32" rx="4" fill="#4DABF7" />
                                    <path d="M14 18L24 26L34 18" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                    <rect x="14" y="18" width="20" height="14" rx="2" stroke="white" stroke-width="3" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Email Support</h3>
                                <p class="text-gray-600">serviceavrtech@gmail.com</p>
                                <p class="text-sm text-gray-500 mt-1">We typically respond within 24 hours</p>
                            </div>
                        </div>

                        <!-- Response Time -->
                        <div class="flex items-start">
                            <div class="w-12 h-12 mr-4 flex-shrink-0">
                                <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                                    <rect x="8" y="8" width="32" height="32" rx="4" fill="#51CF66" />
                                    <circle cx="24" cy="24" r="8" stroke="white" stroke-width="3" />
                                    <path d="M24 18V24L28 28" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Response Time</h3>
                                <p class="text-gray-600">24 hours or less</p>
                                <p class="text-sm text-gray-500 mt-1">Monday to Friday, 9 AM - 6 PM EST</p>
                            </div>
                        </div>

                        <!-- Location -->
                        <div class="flex items-start">
                            <div class="w-12 h-12 mr-4 flex-shrink-0">
                                <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                                    <rect x="8" y="8" width="32" height="32" rx="4" fill="#FF922B" />
                                    <path d="M24 14C20 14 17 17 17 21C17 25 24 34 24 34S31 25 31 21C31 17 28 14 24 14Z" stroke="white" stroke-width="3" stroke-linejoin="round" />
                                    <circle cx="24" cy="21" r="3" stroke="white" stroke-width="3" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Location</h3>
                                <p class="text-gray-600">Global Service</p>
                                <p class="text-sm text-gray-500 mt-1">Serving users worldwide</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Section -->
                <div class="bg-white rounded-xl border border-gray-200 p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Frequently Asked Questions</h2>
                    
                    <div class="space-y-4">
                        <div class="border-b border-gray-200 pb-4">
                            <h3 class="font-semibold text-gray-900 mb-2">Is my data secure?</h3>
                            <p class="text-sm text-gray-600">Yes, all files are processed securely and automatically deleted after conversion.</p>
                        </div>
                        
                        <div class="border-b border-gray-200 pb-4">
                            <h3 class="font-semibold text-gray-900 mb-2">Are your tools really free?</h3>
                            <p class="text-sm text-gray-600">Yes, all our core PDF tools are completely free with no hidden fees.</p>
                        </div>
                        
                        <div class="border-b border-gray-200 pb-4">
                            <h3 class="font-semibold text-gray-900 mb-2">What file formats do you support?</h3>
                            <p class="text-sm text-gray-600">We support PDF, Word, Excel, PowerPoint, JPG, PNG, and many other formats.</p>
                        </div>
                        
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-2">Do I need to create an account?</h3>
                            <p class="text-sm text-gray-600">No registration required. Simply upload, convert, and download.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection