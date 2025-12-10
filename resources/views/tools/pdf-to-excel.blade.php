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
                        'name' => 'Is this PDF to Excel converter really free?',
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text'  => 'Yes. You can convert PDF to Excel online for free with no signup required. Extract tables and data from PDFs to XLSX or CSV format without any cost.',
                        ],
                    ],
                    [
                        '@type' => 'Question',
                        'name' => 'Can I extract tables from PDF files automatically?',
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text'  => 'Yes, our tool automatically detects and extracts tables from PDF files. It intelligently identifies table structures, rows, and columns, making it easy to convert PDF tables to Excel spreadsheets.',
                        ],
                    ],
                    [
                        '@type' => 'Question',
                        'name' => 'Are my PDF files safe when converting to Excel?',
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text'  => 'Absolutely. We use SSL encryption for all file transfers. Your PDFs are processed securely and automatically deleted from our servers after a short period. We never store or share your files.',
                        ],
                    ],
                ],
            ],
            [
                '@type'               => 'SoftwareApplication',
                'name'                => 'Online PDF to Excel Converter',
                'applicationCategory' => 'BusinessApplication',
                'operatingSystem'     => 'Any',
                'url'                 => $seo['canonical']   ?? url()->current(),
                'description'         => $seo['description'] ?? 'Convert PDF to Excel free online.',
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
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        {{-- Header --}}
        <div class="text-center mb-12 animate-fade-in">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">PDF to Excel Converter</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Convert your PDF files to Excel spreadsheets (XLSX) or CSV format for free. Extract tables and data with automatic detection.
            </p>
        </div>

        {{-- Main Tool Interface --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
            {{-- Left: Upload Area --}}
            <div class="lg:col-span-2">
                <x-file-upload-area />
            </div>

            {{-- Right: Options Panel --}}
            <div class="lg:col-span-1">
                <x-pdf-to-excel-panel />
            </div>
        </div>
    </div>
</div>

{{-- SEO Content Section (200-300 words) --}}
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Convert PDF to Excel Online - Free PDF to XLSX Converter</h2>
        
        <div class="prose prose-lg max-w-none text-gray-700 space-y-4">
            <p>
                Our free PDF to Excel converter allows you to transform PDF files into editable Excel spreadsheets (XLSX) or CSV format instantly. Whether you need to extract tables from PDF documents, convert invoices to spreadsheets, or transfer data from PDF forms to Excel, this online tool makes it simple. No software installation required - just upload your PDF file, choose your extraction mode, and within seconds, you'll have a fully editable Excel file ready to download. The conversion process uses intelligent table detection to automatically identify and extract table structures, preserving your data organization and formatting.
            </p>
            
            <p>
                This tool is perfect for various use cases. Business professionals can convert PDF invoices, receipts, or financial reports into Excel for data analysis and accounting. Students can extract tables from PDF research papers or lecture notes into spreadsheets for easier manipulation. Data analysts can convert PDF data tables into Excel format for further processing and visualization. The tool handles complex PDFs with multiple pages, various table formats, and different data types, making it ideal for both simple and advanced document conversion needs. It supports automatic table detection, entire page conversion, and intelligent data extraction including date and currency detection.
            </p>
            
            <p>
                All conversions happen securely in your browser. We use HTTPS encryption to protect your files during upload and processing. Your PDFs and converted Excel files are automatically deleted from our servers after a short period, ensuring your privacy and security. The tool is 100% free to use with no hidden costs, no registration required, and no watermarks added to your converted documents. Simply upload your PDF, configure your extraction options, and download your Excel file. The tool supports multiple output formats including Excel (.xlsx) and CSV, giving you flexibility in how you use your converted data.
            </p>
            
            <p>
                The conversion process is fast and efficient. Our advanced PDF parsing technology automatically detects table structures, extracts rows and columns, and converts them into Excel format. The tool supports intelligent data extraction features including automatic date format detection, currency recognition, and empty row/column removal. You can choose from automatic table detection (which intelligently identifies and extracts tables), entire page conversion (which converts the whole page into rows and columns), or manual area selection. Simply select your PDF file (up to 50MB), configure your extraction options, click convert, and within moments, you'll have an Excel spreadsheet ready to use in Microsoft Excel, Google Sheets, or any compatible spreadsheet application.
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
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Is the PDF to Excel converter really free?</h3>
                <p class="text-gray-600">Yes, our PDF to Excel converter is 100% free to use with no hidden limits. You can convert unlimited PDF files to Excel spreadsheets without any cost, registration, or watermarks.</p>
            </div>

            <div class="border-l-4 border-green-500 pl-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Can I extract tables from PDF files automatically?</h3>
                <p class="text-gray-600">Yes, our tool automatically detects and extracts tables from PDF files. It intelligently identifies table structures, rows, and columns, making it easy to convert PDF tables to Excel spreadsheets. You can also choose to convert entire pages or manually select areas.</p>
            </div>

            <div class="border-l-4 border-green-500 pl-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Are my PDF files safe when converting to Excel?</h3>
                <p class="text-gray-600">Absolutely. We use SSL encryption for all file transfers. Your PDFs are processed securely and automatically deleted from our servers after a short period. We never store or share your files.</p>
            </div>

            <div class="border-l-4 border-green-500 pl-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">What output formats are supported?</h3>
                <p class="text-gray-600">You can convert PDFs to Excel (.xlsx) format or CSV format. Both formats are compatible with Microsoft Excel, Google Sheets, and other spreadsheet applications.</p>
            </div>

            <div class="border-l-4 border-green-500 pl-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Can I select specific pages to convert?</h3>
                <p class="text-gray-600">Yes, you can choose to convert all pages, specific pages, or page ranges. Simply select your preferred option in the conversion settings before converting.</p>
            </div>
        </div>
    </div>
</div>

{{-- Internal Linking Section --}}
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-gray-50 rounded-xl p-8">
        <h2 class="text-xl font-bold mb-4 text-center">Try Our Other Free PDF Tools</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            <a href="{{ route('tools.pdf-to-word') }}" class="text-center p-4 bg-white rounded-lg hover:shadow-md transition-shadow">
                <span class="text-sm font-medium text-gray-900">PDF to Word</span>
            </a>
            <a href="{{ route('tools.merge-pdf') }}" class="text-center p-4 bg-white rounded-lg hover:shadow-md transition-shadow">
                <span class="text-sm font-medium text-gray-900">Merge PDF</span>
            </a>
            <a href="{{ route('tools.split-pdf') }}" class="text-center p-4 bg-white rounded-lg hover:shadow-md transition-shadow">
                <span class="text-sm font-medium text-gray-900">Split PDF</span>
            </a>
            <a href="{{ route('tools.compress-pdf') }}" class="text-center p-4 bg-white rounded-lg hover:shadow-md transition-shadow">
                <span class="text-sm font-medium text-gray-900">Compress PDF</span>
            </a>
            <a href="{{ route('tools.pdf-to-jpg') }}" class="text-center p-4 bg-white rounded-lg hover:shadow-md transition-shadow">
                <span class="text-sm font-medium text-gray-900">PDF to JPG</span>
            </a>
            <a href="{{ route('tools.jpg-to-pdf') }}" class="text-center p-4 bg-white rounded-lg hover:shadow-md transition-shadow">
                <span class="text-sm font-medium text-gray-900">JPG to PDF</span>
            </a>
        </div>
    </div>
</div>
@endsection

