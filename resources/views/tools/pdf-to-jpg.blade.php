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
                        'name' => 'Is the PDF to JPG converter tool really free?',
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text'  => 'Yes. You can convert PDF pages to JPG images or extract images from PDFs online for free with no signup required. Convert instantly.',
                        ],
                    ],
                    [
                        '@type' => 'Question',
                        'name' => 'Can I convert specific pages from a PDF to JPG?',
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text'  => 'Yes, you can select specific pages or page ranges to convert. Choose individual pages, a range (e.g., pages 2-6), or convert all pages at once.',
                        ],
                    ],
                    [
                        '@type' => 'Question',
                        'name' => 'Are my PDF files safe when converting to JPG?',
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text'  => 'Yes. Files are transferred over secure HTTPS and are automatically deleted from our servers after a short period of time.',
                        ],
                    ],
                ],
            ],
            [
                '@type'               => 'SoftwareApplication',
                'name'                => 'Online PDF to JPG Converter',
                'applicationCategory' => 'BusinessApplication',
                'operatingSystem'     => 'Any',
                'url'                 => $seo['canonical'] ?? url()->current(),
                'description'         => $seo['description'] ?? 'Convert PDF pages to JPG images or extract images from PDFs for free.',
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
<div class="min-h-screen bg-gradient-to-br from-yellow-50 via-orange-50 to-amber-50 py-8 relative overflow-hidden">
    {{-- Animated Background Elements --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-yellow-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-orange-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-amber-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        {{-- Header with H1 --}}
        <div class="text-center mb-8 animate-fade-in">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4 bg-clip-text text-transparent bg-gradient-to-r from-yellow-600 to-orange-600">
                Convert PDF to JPG Images
            </h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Convert each PDF page into a JPG image or extract all images from your PDF. Choose quality, DPI, and select specific pages.
            </p>
        </div>

        {{-- Main Content --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Left: Upload Section (2 columns) --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="animate-slide-up">
                    <x-file-upload-area 
                        accept=".pdf,application/pdf"
                        :max-size="51200"
                        upload-url="/api/upload"
                        file-type-label="PDF"
                        upload-button-text="Upload PDF"
                    />
                </div>
                
                {{-- PDF Preview --}}
                <div class="animate-slide-up animation-delay-200">
                    <x-pdf-preview-section />
                </div>
            </div>

            {{-- Right: Conversion Panel (1 column) --}}
            <div class="lg:col-span-1">
                <div class="animate-slide-up animation-delay-400">
                    <x-pdf-to-jpg-panel />
                </div>
            </div>
        </div>
    </div>

    {{-- SEO Content Section (200-300 words) --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Convert PDF to JPG Images for Free - Extract Pages or Images Instantly</h2>
            
            <div class="prose prose-lg max-w-none text-gray-700 space-y-4">
                <p>
                    Our free PDF to JPG converter tool allows you to convert PDF pages into JPG images or extract all embedded images from your PDF files. Whether you need to convert every page to a separate JPG, extract only the images, or select specific pages to convert, this online tool makes it simple. No software installation required - just upload your PDF file, choose your conversion mode, select quality and DPI settings, pick the pages you want, and click convert. Your JPG images will be ready in seconds.
                </p>
                
                <p>
                    This tool offers two conversion modes to suit different needs. The "Convert Every Page to JPG" mode creates one JPG image for each selected page, perfect for creating image versions of documents, presentations, or reports. The "Extract Only Images from PDF" mode extracts all embedded images from your PDF while preserving their original quality, ideal for recovering images from PDF documents. Both modes support quality settings (high, medium, low) and DPI options (72, 150, 300) to balance file size and image quality.
                </p>
                
                <p>
                    All conversion happens securely in your browser. We use HTTPS encryption to protect your files during upload and processing. Your PDFs are automatically deleted from our servers after a short period, ensuring your privacy and security. The tool is 100% free to use with no hidden costs, no registration required, and no watermarks added to your converted images.
                </p>
                
                <p>
                    The conversion process is fast and efficient. Simply upload your PDF file (up to 50MB), select your conversion mode, choose image quality and DPI settings, select the pages you want to convert (or convert all pages), and click the convert button. For multiple pages or images, the tool automatically creates a ZIP file for easy download. Within moments, you'll have your JPG images ready to use for presentations, websites, social media, or any other purpose.
                </p>
            </div>
        </div>
    </div>

    {{-- FAQ Section --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Frequently Asked Questions</h2>
            
            <div class="space-y-6">
                <div class="border-l-4 border-yellow-500 pl-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Is the PDF to JPG converter tool really free?</h3>
                    <p class="text-gray-600">Yes, our PDF to JPG converter is 100% free to use with no hidden limits. You can convert PDF pages to JPG or extract images without any cost, registration, or watermarks.</p>
                </div>

                <div class="border-l-4 border-yellow-500 pl-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Can I convert specific pages from a PDF to JPG?</h3>
                    <p class="text-gray-600">Yes, you can select specific pages or page ranges to convert. Choose individual pages using the thumbnail grid, select a range (e.g., pages 2-6), or convert all pages at once.</p>
                </div>

                <div class="border-l-4 border-yellow-500 pl-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Are my PDF files safe when converting to JPG?</h3>
                    <p class="text-gray-600">Absolutely. We use SSL encryption for all file transfers. Your PDFs are processed securely and automatically deleted from our servers after a short period. We never store or share your files.</p>
                </div>

                <div class="border-l-4 border-yellow-500 pl-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">What's the difference between converting pages and extracting images?</h3>
                    <p class="text-gray-600">Converting pages creates JPG images from each PDF page (like taking a screenshot). Extracting images pulls out only the embedded images from the PDF while preserving their original quality.</p>
                </div>

                <div class="border-l-4 border-yellow-500 pl-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">What DPI setting should I choose?</h3>
                    <p class="text-gray-600">Use 72 DPI for web and screen use (fast, small files). Choose 150 DPI for general use and documents (recommended). Select 300 DPI for printing and high-quality output.</p>
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
    import { pdfToJpgPanel } from '/js/components/pdf-to-jpg-panel.js';
    window.pdfToJpgPanel = pdfToJpgPanel;
</script>
@endpush

