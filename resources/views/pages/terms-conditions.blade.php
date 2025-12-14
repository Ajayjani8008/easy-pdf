@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <div class="text-center py-12 sm:py-20 bg-gray-50">
        <h1 class="text-3xl sm:text-5xl font-bold text-gray-900 mb-6 px-4">
            Terms & Conditions
        </h1>
        <p class="text-lg sm:text-xl text-gray-600 max-w-3xl mx-auto mb-8 px-4">
            Please read these terms carefully before using EasyPDF Pro services.
        </p>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
        <div class="prose prose-lg max-w-none">
            <div class="bg-white rounded-xl border border-gray-200 p-8 mb-8">
                <p class="text-gray-600 mb-6">
                    <strong>Last updated:</strong> {{ date('F j, Y') }}
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mb-4">Agreement to Terms</h2>
                <p class="text-gray-600 mb-6">
                    By accessing and using EasyPDF Pro, a service provided by <a href="https://avrtechnology.com" class="text-blue-600 hover:text-blue-700">AVR Technology</a>, 
                    you agree to be bound by these Terms and Conditions and our Privacy Policy.
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mb-4">Service Description</h2>
                <p class="text-gray-600 mb-4">EasyPDF Pro provides online PDF processing tools including:</p>
                <ul class="list-disc pl-6 text-gray-600 mb-6">
                    <li>PDF to Word, Excel, PowerPoint conversion</li>
                    <li>PDF merging, splitting, and compression</li>
                    <li>Image to PDF conversion and PDF to image extraction</li>
                    <li>PDF editing, signing, and watermarking tools</li>
                </ul>

                <h2 class="text-2xl font-bold text-gray-900 mb-4">Acceptable Use</h2>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">You May:</h3>
                <ul class="list-disc pl-6 text-gray-600 mb-4">
                    <li>Use our services for personal and commercial purposes</li>
                    <li>Process documents you own or have permission to modify</li>
                    <li>Share processed files as needed for your work</li>
                </ul>

                <h3 class="text-xl font-semibold text-gray-900 mb-3">You May Not:</h3>
                <ul class="list-disc pl-6 text-gray-600 mb-6">
                    <li>Upload copyrighted material without permission</li>
                    <li>Process illegal, harmful, or malicious content</li>
                    <li>Attempt to reverse engineer or hack our services</li>
                    <li>Use automated tools to overload our servers</li>
                </ul>

                <h2 class="text-2xl font-bold text-gray-900 mb-4">File Security & Privacy</h2>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold text-blue-900 mb-3">🛡️ Your Data Protection</h3>
                    <ul class="list-disc pl-6 text-blue-800">
                        <li>Files are processed securely using SSL encryption</li>
                        <li>Automatic deletion within 1 hour of processing</li>
                        <li>No human access to your uploaded documents</li>
                        <li>No sharing or selling of your data</li>
                    </ul>
                </div>

                <h2 class="text-2xl font-bold text-gray-900 mb-4">Service Availability</h2>
                <p class="text-gray-600 mb-6">
                    While we strive for 99.9% uptime, we cannot guarantee uninterrupted service. We may perform 
                    maintenance, updates, or experience technical issues that temporarily affect availability.
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mb-4">Limitation of Liability</h2>
                <p class="text-gray-600 mb-6">
                    EasyPDF Pro and AVR Technology provide services "as is" without warranties. We are not liable for:
                </p>
                <ul class="list-disc pl-6 text-gray-600 mb-6">
                    <li>Data loss or corruption during processing</li>
                    <li>Service interruptions or downtime</li>
                    <li>Indirect or consequential damages</li>
                    <li>Third-party actions or content</li>
                </ul>

                <h2 class="text-2xl font-bold text-gray-900 mb-4">Intellectual Property</h2>
                <p class="text-gray-600 mb-6">
                    The EasyPDF Pro platform, including its design, code, and features, is owned by AVR Technology. 
                    You retain all rights to your uploaded files and processed documents.
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mb-4">Changes to Terms</h2>
                <p class="text-gray-600 mb-6">
                    We may update these terms periodically. Continued use of our services after changes constitutes 
                    acceptance of the new terms. We'll notify users of significant changes via our website.
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mb-4">Termination</h2>
                <p class="text-gray-600 mb-6">
                    We reserve the right to terminate or suspend access to our services for violations of these terms 
                    or for any reason at our discretion.
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mb-4">Contact Information</h2>
                <p class="text-gray-600 mb-4">
                    For questions about these Terms & Conditions:
                </p>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-700">
                        <strong>AVR Technology</strong><br>
                        Email: <a href="mailto:legal@avrtechnology.com" class="text-blue-600 hover:text-blue-700">legal@avrtechnology.com</a><br>
                        Website: <a href="https://avrtechnology.com" class="text-blue-600 hover:text-blue-700">avrtechnology.com</a><br>
                        Support: <a href="{{ route('pages.contact') }}" class="text-blue-600 hover:text-blue-700">Contact Us</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection