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
                        'name' => 'Is the JPG to PDF converter tool really free?',
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text'  => 'Yes. You can convert JPG, JPEG, PNG, and WebP images to PDF online for free with no signup required. Convert instantly.',
                        ],
                    ],
                    [
                        '@type' => 'Question',
                        'name' => 'Can I combine multiple images into one PDF?',
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text'  => 'Yes, you can upload multiple images and combine them into a single PDF. You can also reorder images before converting.',
                        ],
                    ],
                    [
                        '@type' => 'Question',
                        'name' => 'Are my image files safe when converting to PDF?',
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text'  => 'Yes. Files are transferred over secure HTTPS and are automatically deleted from our servers after a short period of time.',
                        ],
                    ],
                ],
            ],
            [
                '@type'               => 'SoftwareApplication',
                'name'                => 'Online JPG to PDF Converter',
                'applicationCategory' => 'BusinessApplication',
                'operatingSystem'     => 'Any',
                'url'                 => $seo['canonical'] ?? url()->current(),
                'description'         => $seo['description'] ?? 'Convert JPG, JPEG, PNG, and WebP images to PDF for free.',
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
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-8 relative overflow-hidden">
    {{-- Animated Background Elements --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-indigo-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-purple-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        {{-- Header with H1 --}}
        <div class="text-center mb-8 animate-fade-in">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4 bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-600">
                Convert Images to PDF
            </h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Convert JPG, JPEG, PNG, and WebP images to PDF. Combine multiple images into one PDF with customizable page size, orientation, and margins.
            </p>
        </div>

        {{-- Main Content --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Left: Upload Section (2 columns) --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="animate-slide-up">
                    <x-jpg-to-pdf-upload-area />
                </div>
            </div>

            {{-- Right: Conversion Panel (1 column) --}}
            <div class="lg:col-span-1">
                <div class="animate-slide-up animation-delay-200">
                    <x-jpg-to-pdf-panel />
                </div>
            </div>
        </div>
    </div>

    {{-- SEO Content Section (200-300 words) --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Convert Images to PDF for Free - Create PDFs from Photos Instantly</h2>
            
            <div class="prose prose-lg max-w-none text-gray-700 space-y-4">
                <p>
                    Our free JPG to PDF converter tool allows you to convert JPG, JPEG, PNG, and WebP images into PDF documents. Whether you need to convert a single image or combine multiple images into one PDF, this online tool makes it simple. No software installation required - just upload your images, choose your PDF settings (page size, orientation, margins, fit mode), and click convert. Your PDF will be ready in seconds.
                </p>
                
                <p>
                    This tool offers flexible options to customize your PDF output. Choose from standard page sizes (A4, Letter) or use the original image size. Select portrait or landscape orientation, and control how images fit on the page (fit to page, fill page, or original size). Adjust margins from none to custom values, and choose compression levels to balance quality and file size. You can upload up to 50 images and combine them into a single PDF, with drag-and-drop reordering to arrange images in your preferred order.
                </p>
                
                <p>
                    All conversion happens securely in your browser. We use HTTPS encryption to protect your files during upload and processing. Your images are automatically deleted from our servers after a short period, ensuring your privacy and security. The tool is 100% free to use with no hidden costs, no registration required, and no watermarks added to your PDFs.
                </p>
                
                <p>
                    The conversion process is fast and efficient. Simply upload your images (up to 50MB each, maximum 50 images), configure your PDF settings, and click the convert button. Within moments, you'll have your PDF ready to download. Perfect for creating photo albums, document scanning, archiving images, or any other purpose where you need images in PDF format.
                </p>
            </div>
        </div>
    </div>

    {{-- FAQ Section --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Frequently Asked Questions</h2>
            
            <div class="space-y-6">
                <div class="border-l-4 border-blue-500 pl-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Is the JPG to PDF converter tool really free?</h3>
                    <p class="text-gray-600">Yes, our JPG to PDF converter is 100% free to use with no hidden limits. You can convert images to PDF without any cost, registration, or watermarks.</p>
                </div>

                <div class="border-l-4 border-blue-500 pl-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Can I combine multiple images into one PDF?</h3>
                    <p class="text-gray-600">Yes, you can upload multiple images (up to 50) and combine them into a single PDF. You can also drag and drop to reorder images before converting.</p>
                </div>

                <div class="border-l-4 border-blue-500 pl-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Are my image files safe when converting to PDF?</h3>
                    <p class="text-gray-600">Absolutely. We use SSL encryption for all file transfers. Your images are processed securely and automatically deleted from our servers after a short period. We never store or share your files.</p>
                </div>

                <div class="border-l-4 border-blue-500 pl-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">What image formats are supported?</h3>
                    <p class="text-gray-600">We support JPG, JPEG, PNG, and WebP image formats. Each image can be up to 50MB in size, and you can upload up to 50 images at once.</p>
                </div>

                <div class="border-l-4 border-blue-500 pl-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Can I customize the PDF page size and orientation?</h3>
                    <p class="text-gray-600">Yes, you can choose from A4, Letter, Original image size, or set custom dimensions. You can also select portrait or landscape orientation and control how images fit on the page.</p>
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
                <a href="{{ route('tools.pdf-to-jpg') }}" class="bg-white rounded-lg p-4 hover:shadow-md transition-shadow border border-gray-200">
                    <h3 class="font-semibold text-gray-900 mb-2">PDF to JPG</h3>
                    <p class="text-sm text-gray-600">Convert PDF pages to JPG images</p>
                </a>
                <a href="{{ route('tools.merge-pdf') }}" class="bg-white rounded-lg p-4 hover:shadow-md transition-shadow border border-gray-200">
                    <h3 class="font-semibold text-gray-900 mb-2">Merge PDF</h3>
                    <p class="text-sm text-gray-600">Combine multiple PDF files into one</p>
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
    import { jpgToPdfPanel } from '/js/components/jpg-to-pdf-panel.js';
    window.jpgToPdfPanel = jpgToPdfPanel;
</script>
@endpush

