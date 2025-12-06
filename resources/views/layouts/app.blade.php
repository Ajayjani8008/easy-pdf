<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Dynamic SEO Meta Tags --}}
    <title>{{ $seo['title'] ?? config('app.name', 'Laravel') }}</title>
    <meta name="description" content="{{ $seo['description'] ?? 'Default description for my PDF tools website.' }}">
    <meta name="keywords" content="{{ $seo['keywords'] ?? '' }}">
    <link rel="canonical" href="{{ $seo['canonical'] ?? url()->current() }}">

    {{-- Open Graph Tags --}}
    <meta property="og:title" content="{{ $seo['title'] ?? config('app.name', 'Laravel') }}">
    <meta property="og:description"
        content="{{ $seo['description'] ?? 'Default description for my PDF tools website.' }}">
    <meta property="og:type" content="{{ $seo['og_type'] ?? 'website' }}">
    <meta property="og:url" content="{{ $seo['canonical'] ?? url()->current() }}">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        // Ensure Alpine waits for our functions to be available
        document.addEventListener('alpine:init', () => {
            // Functions should be available by now from app.js
            if (typeof window.fileUpload === 'undefined') {
                console.error('fileUpload function not found!');
            }
            if (typeof window.conversionStatus === 'undefined') {
                console.error('conversionStatus function not found!');
            }
        });
    </script>

    <style>
        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
    @stack('head')
</head>

<body class="min-h-screen bg-gray-50 text-gray-900 flex flex-col">

    @include('partials.header')

    <main class="flex-grow w-full">
        @yield('content')
    </main>

    @include('partials.footer')

    @stack('scripts')
</body>

</html>
