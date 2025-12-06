@props(['toolName', 'toolDescription'])

<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="text-center mb-8">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4">{{ $toolName }}</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                {{ $toolDescription }}
            </p>
        </div>

        {{-- Main Content Area --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Left: Upload & Preview Section (2 columns) --}}
            <div class="lg:col-span-2 space-y-6">
                <x-file-upload-area />
                <x-pdf-preview-section />
            </div>

            {{-- Right: Conversion Panel (1 column) --}}
            <div class="lg:col-span-1">
                <x-conversion-panel />
            </div>
        </div>
    </div>
</div>

