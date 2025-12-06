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
                        'name' => 'Is the PDF splitter tool really free?',
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text'  => 'Yes. You can split PDF files online for free with no signup required. Extract pages or split into separate files instantly.',
                        ],
                    ],
                    [
                        '@type' => 'Question',
                        'name' => 'How do I split a PDF into separate pages?',
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text'  => 'Upload your PDF file, select the page range you want to extract, and click split. You can split specific pages or extract a range of pages into a new PDF file.',
                        ],
                    ],
                    [
                        '@type' => 'Question',
                        'name' => 'Are my PDF files safe when splitting?',
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text'  => 'Yes. Files are transferred over secure HTTPS and are automatically deleted from our servers after a short period of time.',
                        ],
                    ],
                ],
            ],
            [
                '@type'               => 'SoftwareApplication',
                'name'                => 'Online PDF Splitter',
                'applicationCategory' => 'BusinessApplication',
                'operatingSystem'     => 'Any',
                'url'                 => $seo['canonical'] ?? url()->current(),
                'description'         => $seo['description'] ?? 'Split PDF files into separate pages for free.',
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
                Split PDF Files Online
            </h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Extract specific pages or split your PDF into separate files. Select page ranges and create new PDFs instantly.
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

            {{-- Right: Split Panel (1 column) --}}
            <div class="lg:col-span-1">
                <div class="animate-slide-up animation-delay-400">
                    <x-split-panel />
                </div>
            </div>
        </div>
    </div>

    {{-- SEO Content Section (200-300 words) --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Split PDF Files for Free - Extract Pages and Create New PDFs</h2>
            
            <div class="prose prose-lg max-w-none text-gray-700 space-y-4">
                <p>
                    Our free PDF splitter tool allows you to extract specific pages or split PDF files into separate documents with ease. Whether you need to extract a single page, a range of pages, or split a large PDF into multiple smaller files, this online tool makes it simple. No software installation required - just upload your PDF file, select the pages you want to extract, and click split. Your new PDF file will be ready in seconds.
                </p>
                
                <p>
                    This tool is perfect for various use cases. Students can extract specific pages from lecture notes or research papers. Professionals can split large reports or contracts into smaller, manageable documents. Businesses can extract pages from invoices, receipts, or forms for separate processing. The tool supports selecting individual pages or page ranges, making it easy to create exactly the PDF you need from your source document.
                </p>
                
                <p>
                    All splitting happens securely in your browser. We use HTTPS encryption to protect your files during upload and processing. Your PDFs are automatically deleted from our servers after a short period, ensuring your privacy and security. The tool is 100% free to use with no hidden costs, no registration required, and no watermarks added to your split PDF files.
                </p>
                
                <p>
                    The split process is fast and efficient. Simply upload your PDF file (up to 50MB), select the page range you want to extract using our intuitive interface, and click the split button. Within moments, you'll have a new PDF file containing only the pages you selected, ready to download. Perfect for extracting specific content, creating smaller documents, or organizing large PDF files into more manageable pieces.
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
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Is the PDF splitter tool really free?</h3>
                    <p class="text-gray-600">Yes, our PDF splitter is 100% free to use with no hidden limits. You can split PDF files and extract pages without any cost, registration, or watermarks.</p>
                </div>

                <div class="border-l-4 border-red-500 pl-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">How do I split a PDF into separate pages?</h3>
                    <p class="text-gray-600">Upload your PDF file, select the page range you want to extract (e.g., pages 1-5, or just page 3), and click split. The tool will create a new PDF file containing only the selected pages.</p>
                </div>

                <div class="border-l-4 border-red-500 pl-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Are my PDF files safe when splitting?</h3>
                    <p class="text-gray-600">Absolutely. We use SSL encryption for all file transfers. Your PDFs are processed securely and automatically deleted from our servers after a short period. We never store or share your files.</p>
                </div>

                <div class="border-l-4 border-red-500 pl-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Can I extract multiple page ranges from one PDF?</h3>
                    <p class="text-gray-600">Yes, you can select multiple page ranges (e.g., pages 1-3 and pages 10-15) and the tool will combine them into a single split PDF file containing all selected pages.</p>
                </div>

                <div class="border-l-4 border-red-500 pl-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">What file size limits apply for PDF splitting?</h3>
                    <p class="text-gray-600">You can split PDF files up to 50MB in size. For larger files, consider compressing the PDF first or splitting it into smaller parts.</p>
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
                <a href="#" class="bg-white rounded-lg p-4 hover:shadow-md transition-shadow border border-gray-200">
                    <h3 class="font-semibold text-gray-900 mb-2">Compress PDF</h3>
                    <p class="text-sm text-gray-600">Reduce PDF file size without losing quality</p>
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
    import { splitPanel } from '/js/components/split-panel.js';
    window.splitPanel = splitPanel;
</script>
@endpush

