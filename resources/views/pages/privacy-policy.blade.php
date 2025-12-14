@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <div class="text-center py-12 sm:py-20 bg-gray-50">
        <h1 class="text-3xl sm:text-5xl font-bold text-gray-900 mb-6 px-4">
            Privacy Policy
        </h1>
        <p class="text-lg sm:text-xl text-gray-600 max-w-3xl mx-auto mb-8 px-4">
            Your privacy is important to us. Learn how we protect your data at EasyPDF Pro.
        </p>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
        <div class="prose prose-lg max-w-none">
            <div class="bg-white rounded-xl border border-gray-200 p-8 mb-8">
                <p class="text-gray-600 mb-6">
                    <strong>Last updated:</strong> {{ date('F j, Y') }}
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mb-4">Introduction</h2>
                <p class="text-gray-600 mb-6">
                    EasyPDF Pro, powered by <a href="https://avrtechnology.com" class="text-blue-600 hover:text-blue-700">AVR Technology</a>, 
                    is committed to protecting your privacy. This Privacy Policy explains how we collect, use, and safeguard your information 
                    when you use our PDF processing services.
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mb-4">Information We Collect</h2>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Files You Upload</h3>
                <ul class="list-disc pl-6 text-gray-600 mb-6">
                    <li>PDF files and other documents you upload for processing</li>
                    <li>Temporary processing data required for conversion</li>
                    <li>File metadata (size, type, creation date)</li>
                </ul>

                <h3 class="text-xl font-semibold text-gray-900 mb-3">Usage Information</h3>
                <ul class="list-disc pl-6 text-gray-600 mb-6">
                    <li>IP address and browser information</li>
                    <li>Pages visited and features used</li>
                    <li>Error logs and performance data</li>
                </ul>

                <h2 class="text-2xl font-bold text-gray-900 mb-4">How We Use Your Information</h2>
                <ul class="list-disc pl-6 text-gray-600 mb-6">
                    <li><strong>File Processing:</strong> To convert, merge, split, and edit your PDF files</li>
                    <li><strong>Service Improvement:</strong> To enhance our tools and user experience</li>
                    <li><strong>Security:</strong> To protect against abuse and maintain service integrity</li>
                    <li><strong>Support:</strong> To respond to your questions and provide assistance</li>
                </ul>

                <h2 class="text-2xl font-bold text-gray-900 mb-4">Data Security</h2>
                <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold text-green-900 mb-3">🔒 Your Files Are Safe</h3>
                    <ul class="list-disc pl-6 text-green-800">
                        <li>All file uploads use SSL/TLS encryption</li>
                        <li>Files are automatically deleted after processing</li>
                        <li>No permanent storage of your documents</li>
                        <li>Secure servers with regular security updates</li>
                    </ul>
                </div>

                <h2 class="text-2xl font-bold text-gray-900 mb-4">File Retention</h2>
                <p class="text-gray-600 mb-6">
                    Your uploaded files are automatically deleted from our servers within <strong>1 hour</strong> of processing. 
                    We do not store, share, or access your documents beyond what's necessary for the conversion process.
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mb-4">Third-Party Services</h2>
                <p class="text-gray-600 mb-6">
                    We may use third-party services for analytics and performance monitoring. These services are bound by 
                    their own privacy policies and do not have access to your uploaded files.
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mb-4">Your Rights</h2>
                <ul class="list-disc pl-6 text-gray-600 mb-6">
                    <li>Right to know what data we collect</li>
                    <li>Right to request deletion of your data</li>
                    <li>Right to opt-out of analytics tracking</li>
                    <li>Right to contact us about privacy concerns</li>
                </ul>

                <h2 class="text-2xl font-bold text-gray-900 mb-4">Contact Us</h2>
                <p class="text-gray-600 mb-4">
                    If you have questions about this Privacy Policy, please contact us:
                </p>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-700">
                        <strong>AVR Technology</strong><br>
                        Email: <a href="mailto:privacy@avrtechnology.com" class="text-blue-600 hover:text-blue-700">privacy@avrtechnology.com</a><br>
                        Website: <a href="https://avrtechnology.com" class="text-blue-600 hover:text-blue-700">avrtechnology.com</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection