@extends('layouts.app')


{{-- potential SEO benefits  --}}
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
                        'name' => 'Is this PDF to Word converter really free?',
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text'  => 'Yes. You can convert PDF to Word online for free with no signup required. We only show light ads to keep the service running.',
                        ],
                    ],
                    [
                        '@type' => 'Question',
                        'name' => 'Will the formatting be preserved when converting from PDF to Word?',
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text'  => 'In most cases, your fonts, images, tables and layout are preserved accurately. Very complex designs may need small manual adjustments inside Word.',
                        ],
                    ],
                    [
                        '@type' => 'Question',
                        'name' => 'Are my PDF and Word files safe on this website?',
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text'  => 'Yes. Files are transferred over secure HTTPS and are automatically removed from our servers after a short period of time.',
                        ],
                    ],
                ],
            ],
            [
                '@type'               => 'SoftwareApplication',
                'name'                => 'Online PDF to Word Converter',
                'applicationCategory' => 'BusinessApplication',
                'operatingSystem'     => 'Any',
                'url'                 => $seo['canonical']   ?? url()->current(),
                'description'         => $seo['description'] ?? 'Convert PDF to Word free online.',
                'offers'              => [
                    '@type'         => 'Offer',
                    'price'         => '0',
                    'priceCurrency' => 'USD',
                ],
            ],
        ],
    ];
@endphp


@section('content')
    <x-converter-layout 
        tool-name="PDF to Word Converter"
        tool-description="Convert your PDF files to editable Word documents (DOCX) for free. Fast, secure, and easy to use. No registration required."
    />
    
    {{-- SEO Content Section (200-300 words) --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Convert PDF to Word Online - Free PDF to DOCX Converter</h2>
            
            <div class="prose prose-lg max-w-none text-gray-700 space-y-4">
                <p>
                    Our free PDF to Word converter allows you to transform PDF files into editable Word documents (DOCX format) instantly. Whether you need to edit a PDF document, extract text, or modify content, this online tool makes it simple. No software installation required - just upload your PDF file, and within seconds, you'll have a fully editable Word document ready to download. The conversion process preserves your formatting, fonts, images, and layout as much as possible, ensuring your document looks professional.
                </p>
                
                <p>
                    This tool is perfect for various use cases. Students can convert PDF lecture notes or research papers into Word format for easy editing and note-taking. Professionals can transform PDF reports, contracts, or proposals into editable documents. Businesses can convert PDF forms into Word templates for customization. The tool handles complex PDFs with multiple pages, tables, images, and various formatting styles, making it ideal for both simple and advanced document conversion needs.
                </p>
                
                <p>
                    All conversions happen securely in your browser. We use HTTPS encryption to protect your files during upload and processing. Your PDFs and converted Word documents are automatically deleted from our servers after a short period, ensuring your privacy and security. The tool is 100% free to use with no hidden costs, no registration required, and no watermarks added to your converted documents. Simply upload your PDF, wait a few seconds, and download your Word file.
                </p>
                
                <p>
                    The conversion process is fast and efficient. Our advanced PDF parsing technology extracts text, formatting, and layout information from your PDF file and converts it into a Word document format. The tool supports various PDF types including scanned documents, text-based PDFs, and complex layouts. Simply select your PDF file (up to 50MB), click convert, and within moments, you'll have a Word document ready to edit in Microsoft Word, Google Docs, or any compatible word processor. Perfect for editing documents, extracting content, or converting PDFs for further processing.
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
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Is the PDF to Word converter really free?</h3>
                    <p class="text-gray-600">Yes, our PDF to Word converter is 100% free to use with no hidden limits. You can convert unlimited PDF files to Word documents without any cost, registration, or watermarks.</p>
                </div>

                <div class="border-l-4 border-blue-500 pl-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Will the formatting be preserved when converting from PDF to Word?</h3>
                    <p class="text-gray-600">In most cases, your fonts, images, tables and layout are preserved accurately. Very complex designs may need small manual adjustments inside Word, but the tool does its best to maintain the original formatting.</p>
                </div>

                <div class="border-l-4 border-blue-500 pl-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Are my PDF and Word files safe on this website?</h3>
                    <p class="text-gray-600">Absolutely. We use SSL encryption for all file transfers. Your PDFs are processed securely and automatically deleted from our servers after a short period. We never store or share your files.</p>
                </div>

                <div class="border-l-4 border-blue-500 pl-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Do I need to install software to convert PDF to Word?</h3>
                    <p class="text-gray-600">No, this is a web-based tool. You can use it from any device with a browser - no software installation required. Simply upload your PDF and download the converted Word document.</p>
                </div>

                <div class="border-l-4 border-blue-500 pl-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">What file size limits apply for PDF to Word conversion?</h3>
                    <p class="text-gray-600">You can convert PDF files up to 50MB in size. For larger files, consider splitting them into smaller parts or compressing the PDF before conversion.</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    /* Example of page-specific CSS */
    .prose h2 {
        color: #1e40af; /* blue-800 */
    }
</style>
@endpush

@push('scripts')
<script>
    // Example of page-specific JS
</script>
@endpush
