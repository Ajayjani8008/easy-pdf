@extends('layouts.app')

{{-- SEO Schema Markup --}}
@push('head')
@php
    $schema = [
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'FAQPage',
                'mainEntity' => [
                    [
                        '@type' => 'Question',
                        'name' => 'Is the PDF compressor tool really free?',
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text'  => 'Yes. You can compress PDF files online for free with no signup required. Reduce file size while maintaining quality instantly.',
                        ],
                    ],
                    [
                        '@type' => 'Question',
                        'name' => 'How much can I compress a PDF file?',
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text'  => 'Compression depends on your PDF content. High compression can reduce size by up to 70%, balanced mode typically reduces by 50%, and low compression preserves quality while reducing by about 20%.',
                        ],
                    ],
                    [
                        '@type' => 'Question',
                        'name' => 'Are my PDF files safe when compressing?',
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text'  => 'Yes. Files are transferred over secure HTTPS and are automatically deleted from our servers after a short period of time.',
                        ],
                    ],
                ],
            ],
            [
                '@type'               => 'SoftwareApplication',
                'name'                => 'Online PDF Compressor',
                'applicationCategory' => 'BusinessApplication',
                'operatingSystem'     => 'Any',
                'url'                 => $seo['canonical'] ?? url()->current(),
                'description'         => $seo['description'] ?? 'Compress PDF files to reduce size while maintaining quality for free.',
                'offers'              => [
                    '@type'         => 'Offer',
                    'price'         => '0',
                    'priceCurrency' => 'USD',
                ],
            ],
        ],
    ];
@endphp
<script type="application/ld+json">
{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50 py-8 relative overflow-hidden">
    {{-- Animated Background Elements --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-green-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-emerald-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-teal-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        {{-- Header with H1 --}}
        <div class="text-center mb-8 animate-fade-in">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4 bg-clip-text text-transparent bg-gradient-to-r from-green-600 to-emerald-600">
                Compress PDF Files Online
            </h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Reduce PDF file size while optimizing for maximal quality. Choose from high compression, balanced, or best quality modes.
            </p>
        </div>

        {{-- Main Content --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Left: Upload Section (2 columns) --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="animate-slide-up">
                    <x-file-upload-area />
                </div>
                
                {{-- PDF Preview --}}
                <div class="animate-slide-up animation-delay-200">
                    <x-pdf-preview-section />
                </div>
            </div>

            {{-- Right: Compress Panel (1 column) --}}
            <div class="lg:col-span-1">
                <div class="animate-slide-up animation-delay-400">
                    <x-compress-panel />
                </div>
            </div>
        </div>
    </div>

    {{-- SEO Content Section (200-300 words) --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Compress PDF Files for Free - Reduce Size While Maintaining Quality</h2>
            
            <div class="prose prose-lg max-w-none text-gray-700 space-y-4">
                <p>
                    Our free PDF compressor tool allows you to reduce PDF file size while optimizing for maximal quality. Whether you need to compress a PDF for email, reduce storage space, or optimize for web sharing, this online tool makes it simple. No software installation required - just upload your PDF file, choose your preferred compression level, and click compress. Your optimized PDF will be ready in seconds.
                </p>
                
                <p>
                    This tool offers three compression modes to suit different needs. High compression mode provides maximum file size reduction (up to 70% smaller), ideal for email attachments and WhatsApp sharing. The recommended balanced mode offers a good balance between file size and quality, perfect for official work and general use. Low compression mode preserves the highest quality while still reducing file size by about 20%, ideal for printing and professional documents.
                </p>
                
                <p>
                    All compression happens securely in your browser. We use HTTPS encryption to protect your files during upload and processing. Your PDFs are automatically deleted from our servers after a short period, ensuring your privacy and security. The tool is 100% free to use with no hidden costs, no registration required, and no watermarks added to your compressed PDF files.
                </p>
                
                <p>
                    The compression process is fast and efficient. Simply upload your PDF file (up to 50MB), select your preferred compression level using our intuitive interface, preview the estimated size reduction, and click the compress button. Within moments, you'll have a compressed PDF file ready to download with a clear comparison showing how much space you've saved. Perfect for reducing file sizes, optimizing storage, or preparing PDFs for sharing and distribution.
                </p>
            </div>
        </div>
    </div>

    {{-- FAQ Section --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Frequently Asked Questions</h2>
            
            <div class="space-y-6">
                <div class="border-l-4 border-green-500 pl-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Is the PDF compressor tool really free?</h3>
                    <p class="text-gray-600">Yes, our PDF compressor is 100% free to use with no hidden limits. You can compress PDF files without any cost, registration, or watermarks.</p>
                </div>

                <div class="border-l-4 border-green-500 pl-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">How much can I compress a PDF file?</h3>
                    <p class="text-gray-600">Compression depends on your PDF content. High compression can reduce size by up to 70%, balanced mode typically reduces by 50%, and low compression preserves quality while reducing by about 20%.</p>
                </div>

                <div class="border-l-4 border-green-500 pl-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Are my PDF files safe when compressing?</h3>
                    <p class="text-gray-600">Absolutely. We use SSL encryption for all file transfers. Your PDFs are processed securely and automatically deleted from our servers after a short period. We never store or share your files.</p>
                </div>

                <div class="border-l-4 border-green-500 pl-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Which compression level should I choose?</h3>
                    <p class="text-gray-600">Choose high compression for email and messaging (maximum size reduction). Use balanced mode for general use and official work (recommended). Select low compression for printing and documents requiring highest quality.</p>
                </div>

                <div class="border-l-4 border-green-500 pl-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">What file size limits apply for PDF compression?</h3>
                    <p class="text-gray-600">You can compress PDF files up to 50MB in size. For larger files, consider splitting the PDF first or using our other tools to manage file size.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Internal Linking Section --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl border border-gray-200 p-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Try Our Other Free PDF Tools</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('tools.pdf-to-word') }}" class="bg-white rounded-lg p-4 hover:shadow-md transition-shadow border border-gray-200">
                    <h3 class="font-semibold text-gray-900 mb-2">PDF to Word</h3>
                    <p class="text-sm text-gray-600">Convert PDF to editable Word documents</p>
                </a>
                <a href="{{ route('tools.merge-pdf') }}" class="bg-white rounded-lg p-4 hover:shadow-md transition-shadow border border-gray-200">
                    <h3 class="font-semibold text-gray-900 mb-2">Merge PDF</h3>
                    <p class="text-sm text-gray-600">Combine multiple PDF files into one</p>
                </a>
                <a href="{{ route('tools.split-pdf') }}" class="bg-white rounded-lg p-4 hover:shadow-md transition-shadow border border-gray-200">
                    <h3 class="font-semibold text-gray-900 mb-2">Split PDF</h3>
                    <p class="text-sm text-gray-600">Extract pages or split PDF into separate files</p>
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Custom Animations --}}
<style>
    @keyframes blob {
        0%, 100% { transform: translate(0, 0) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
    }
    .animate-blob { animation: blob 7s infinite; }
    .animation-delay-2000 { animation-delay: 2s; }
    .animation-delay-4000 { animation-delay: 4s; }
    .animation-delay-200 { animation-delay: 200ms; }
    .animation-delay-400 { animation-delay: 400ms; }
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in { animation: fade-in 0.6s ease-out; }
    @keyframes slide-up {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-slide-up { animation: slide-up 0.6s ease-out; }
</style>
@endsection

@push('scripts')
<script type="module">
    import { compressPanel } from '/js/components/compress-panel.js';
    window.compressPanel = compressPanel;
</script>
@endpush

