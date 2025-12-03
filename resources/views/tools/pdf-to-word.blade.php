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
    <div class="max-w-3xl mx-auto">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4">PDF to Word Converter</h1>
            <p class="text-lg text-gray-600">
                Convert your PDF files to editable Word documents (DOCX) for free. 
                Fast, secure, and easy to use. No registration required.
            </p>
        </div>

        {{-- Tool Placeholder --}}
        <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100 text-center mb-12">
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-12 hover:border-blue-500 transition-colors cursor-pointer bg-gray-50">
                <div class="text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v20c0 4.418 7.163 8 16 8 1.381 0 2.721-.087 4-.252M8 14c0 4.418 7.163 8 16 8s16-3.582 16-8M8 14c0-4.418 7.163-8 16-8s16 3.582 16 8m0 0v14m0-4c0 4.418-7.163 8-16 8S8 28.418 8 24m32 10v6m0 0v6m0-6h6m-6 0h-6" />
                    </svg>
                    <span class="mt-2 block text-sm font-medium text-gray-900">
                        Drop your PDF here, or click to browse
                    </span>
                </div>
            </div>
            <button class="mt-6 px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all">
                Select PDF File
            </button>
        </div>

        {{-- Description --}}
        <div class="prose prose-blue max-w-none mb-12">
            <h2>How to Convert PDF to Word?</h2>
            <p>
                Our online PDF to Word converter allows you to easily transform your PDF documents into editable Word files. 
                Whether you need to edit text, extract tables, or repurpose content, our tool maintains the original formatting 
                of your document.
            </p>
            <p>
                Simply upload your file, wait for the conversion to process, and download your new DOCX file. 
                It's that simple! We prioritize your privacy and delete all files from our servers after one hour.
            </p>
        </div>

        {{-- FAQ Section --}}
        <div class="space-y-6">
            <h2 class="text-2xl font-bold text-gray-900">Frequently Asked Questions</h2>
            
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Is this tool free?</h3>
                <p class="text-gray-600">Yes, our PDF to Word converter is 100% free to use with no hidden limits.</p>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Do I need to install software?</h3>
                <p class="text-gray-600">No, this is a web-based tool. You can use it from any device with a browser.</p>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Is my data safe?</h3>
                <p class="text-gray-600">Absolutely. We use SSL encryption and automatically delete your files after conversion.</p>
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
    console.log('PDF to Word tool loaded');
</script>
@endpush
