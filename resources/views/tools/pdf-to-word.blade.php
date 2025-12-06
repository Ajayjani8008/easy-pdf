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
    
    {{-- FAQ Section --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Frequently Asked Questions</h2>
            
            <div class="space-y-4">
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
