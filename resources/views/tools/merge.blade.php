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
                        'name' => 'Is the PDF merger tool really free?',
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text'  => 'Yes. You can merge PDF files online for free with no signup required. Combine up to 10 PDF files into one document instantly.',
                        ],
                    ],
                    [
                        '@type' => 'Question',
                        'name' => 'How many PDF files can I merge at once?',
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text'  => 'You can merge between 2 to 10 PDF files at once. Simply upload your files, drag to reorder them, and click merge.',
                        ],
                    ],
                    [
                        '@type' => 'Question',
                        'name' => 'Are my PDF files safe when merging?',
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text'  => 'Yes. Files are transferred over secure HTTPS and are automatically deleted from our servers after a short period of time.',
                        ],
                    ],
                ],
            ],
            [
                '@type'               => 'SoftwareApplication',
                'name'                => 'Online PDF Merger',
                'applicationCategory' => 'BusinessApplication',
                'operatingSystem'     => 'Any',
                'url'                 => $seo['canonical'] ?? url()->current(),
                'description'         => $seo['description'] ?? 'Merge multiple PDF files into one document for free.',
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
<div class="min-h-screen bg-gradient-to-br from-red-50 via-pink-50 to-purple-50 py-8 relative overflow-hidden">
    {{-- Animated Background Elements --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-red-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-pink-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-purple-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        {{-- Header with H1 --}}
        <div class="text-center mb-8 animate-fade-in">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4 bg-clip-text text-transparent bg-gradient-to-r from-red-600 to-pink-600">
                Merge PDF Files Online
            </h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Combine multiple PDF files into one document. Drag and drop to reorder files before merging.
            </p>
        </div>

        {{-- Main Content --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Left: Upload Section (2 columns) --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="animate-slide-up">
                    <x-merge-file-upload-area />
                </div>
            </div>

            {{-- Right: Merge Panel (1 column) --}}
            <div class="lg:col-span-1">
                <div class="animate-slide-up animation-delay-200">
                    <x-merge-panel />
                </div>
            </div>
        </div>
    </div>

    {{-- SEO Content Section (200-300 words) --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Merge PDF Files for Free - Combine Multiple PDFs Instantly</h2>
            
            <div class="prose prose-lg max-w-none text-gray-700 space-y-4">
                <p>
                    Our free PDF merger tool allows you to combine multiple PDF files into a single document with ease. Whether you need to merge 2 PDFs or up to 10 files, this online tool makes it simple. No software installation required - just upload your PDF files, drag and drop to reorder them in the sequence you want, and click merge. Your combined PDF will be ready in seconds.
                </p>
                
                <p>
                    This tool is perfect for various use cases. Students can combine multiple lecture notes or research papers into one document. Professionals can merge reports, invoices, or contracts. Businesses can combine multiple documents for presentations or archives. The drag-and-drop interface makes it easy to arrange files in the exact order you need before merging.
                </p>
                
                <p>
                    All merging happens securely in your browser. We use HTTPS encryption to protect your files during upload and processing. Your PDFs are automatically deleted from our servers after a short period, ensuring your privacy and security. The tool is 100% free to use with no hidden costs, no registration required, and no watermarks added to your merged PDF.
                </p>
                
                <p>
                    The merge process is fast and efficient. Simply select your PDF files (each up to 50MB), arrange them in your preferred order using our intuitive drag-and-drop interface, and click the merge button. Within moments, you'll have a single, combined PDF file ready to download. Perfect for organizing documents, creating comprehensive reports, or consolidating multiple files into one convenient document.
                </p>
            </div>
        </div>
    </div>

    {{-- FAQ Section --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Frequently Asked Questions</h2>
            
            <div class="space-y-6">
                <div class="border-l-4 border-red-500 pl-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Is the PDF merger tool really free?</h3>
                    <p class="text-gray-600">Yes, our PDF merger is 100% free to use with no hidden limits. You can merge up to 10 PDF files at once without any cost, registration, or watermarks.</p>
                </div>

                <div class="border-l-4 border-red-500 pl-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">How many PDF files can I merge at once?</h3>
                    <p class="text-gray-600">You can merge between 2 to 10 PDF files in a single operation. Each file can be up to 50MB in size. Simply upload your files, reorder them as needed, and merge.</p>
                </div>

                <div class="border-l-4 border-red-500 pl-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Are my PDF files safe when merging?</h3>
                    <p class="text-gray-600">Absolutely. We use SSL encryption for all file transfers. Your PDFs are processed securely and automatically deleted from our servers after a short period. We never store or share your files.</p>
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
                <a href="#" class="bg-white rounded-lg p-4 hover:shadow-md transition-shadow border border-gray-200">
                    <h3 class="font-semibold text-gray-900 mb-2">Compress PDF</h3>
                    <p class="text-sm text-gray-600">Reduce PDF file size without losing quality</p>
                </a>
                <a href="#" class="bg-white rounded-lg p-4 hover:shadow-md transition-shadow border border-gray-200">
                    <h3 class="font-semibold text-gray-900 mb-2">Split PDF</h3>
                    <p class="text-sm text-gray-600">Separate PDF pages into individual files</p>
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
    import { mergeFileUpload } from '/js/components/merge-file-upload.js';
    window.mergeFileUpload = mergeFileUpload;
</script>
@endpush

