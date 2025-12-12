@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <div class="text-center py-12 sm:py-20 bg-gray-50">
        <h1 class="text-3xl sm:text-5xl font-bold text-gray-900 mb-6 px-4">
            Every tool you need to work with PDFs in one place
        </h1>
        <p class="text-lg sm:text-xl text-gray-600 max-w-3xl mx-auto mb-8 px-4">
            Every tool you need to use PDFs, at your fingertips. All are 100% FREE and easy to use! Merge, split, compress,
            convert, rotate, unlock and watermark PDFs with just a few clicks.
        </p>
    </div>

    <!-- Tools Grid -->
    <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 pb-20">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">

            <!-- PDF to Word -->
            <a href="{{ route('tools.pdf-to-word') }}"
                class="group p-6 bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-all duration-200 flex flex-col items-start text-left h-full hover:-translate-y-1">
                <div class="w-12 h-12 mb-4">
                    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        <rect x="8" y="8" width="32" height="32" rx="4" fill="#4DABF7" />
                        <path d="M14 16H22V24H14V16Z" fill="white" />
                        <path d="M26 18H34" stroke="white" stroke-width="2" stroke-linecap="round" />
                        <path d="M26 22H34" stroke="white" stroke-width="2" stroke-linecap="round" />
                        <path d="M14 28H34" stroke="white" stroke-width="2" stroke-linecap="round" />
                        <path d="M14 32H24" stroke="white" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-blue-500 transition-colors">PDF to Word
                </h3>
                <p class="text-sm text-gray-500 leading-relaxed">Easily convert your PDF files into easy to edit DOC and
                    DOCX documents.</p>
            </a>
            <!-- Merge PDF -->
            <a href="{{ route('tools.merge-pdf') }}"
                class="group p-6 bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-all duration-200 flex flex-col items-start text-left h-full hover:-translate-y-1">
                <div class="w-12 h-12 mb-4">
                    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        <rect x="8" y="8" width="32" height="32" rx="4" fill="#FF6B6B" />
                        <path d="M16 24H32" stroke="white" stroke-width="3" stroke-linecap="round" />
                        <path d="M24 16L28 20L24 24" stroke="white" stroke-width="3" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M24 32L20 28L24 24" stroke="white" stroke-width="3" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-red-500 transition-colors">Merge PDF</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Combine PDFs in the order you want with the easiest PDF
                    merger available.</p>
            </a>

            <!-- Split PDF -->
            <a href="{{ route('tools.split-pdf') }}"
                class="group p-6 bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-all duration-200 flex flex-col items-start text-left h-full hover:-translate-y-1">
                <div class="w-12 h-12 mb-4">
                    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        <rect x="8" y="8" width="32" height="32" rx="4" fill="#FF6B6B" />
                        <path d="M24 14V34" stroke="white" stroke-width="3" stroke-linecap="round" stroke-dasharray="4 4" />
                        <path d="M14 24H34" stroke="white" stroke-width="3" stroke-linecap="round" />
                        <path d="M18 20L14 24L18 28" stroke="white" stroke-width="3" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M30 20L34 24L30 28" stroke="white" stroke-width="3" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-red-500 transition-colors">Split PDF</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Separate one page or a whole set for easy conversion into
                    independent PDF files.</p>
            </a>

            <!-- Compress PDF -->
            <a href="{{ route('tools.compress-pdf') }}"
                class="group p-6 bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-all duration-200 flex flex-col items-start text-left h-full hover:-translate-y-1">
                <div class="w-12 h-12 mb-4">
                    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        <rect x="8" y="8" width="32" height="32" rx="4" fill="#51CF66" />
                        <path d="M24 14V34" stroke="white" stroke-width="3" stroke-linecap="round" />
                        <path d="M32 26L24 34L16 26" stroke="white" stroke-width="3" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M16 14H32" stroke="white" stroke-width="3" stroke-linecap="round" />
                        <path d="M32 22L24 14L16 22" stroke="white" stroke-width="3" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-green-500 transition-colors">Compress PDF
                </h3>
                <p class="text-sm text-gray-500 leading-relaxed">Reduce file size while optimizing for maximal PDF quality.
                </p>
            </a>
            <!-- PDF to JPG -->
            <a href="{{ route('tools.pdf-to-jpg') }}"
                class="group p-6 bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-all duration-200 flex flex-col items-start text-left h-full hover:-translate-y-1">
                <div class="w-12 h-12 mb-4">
                    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        <rect x="8" y="8" width="32" height="32" rx="4" fill="#FFD43B" />
                        <rect x="14" y="14" width="20" height="20" rx="2" stroke="white"
                            stroke-width="3" />
                        <circle cx="20" cy="20" r="2" fill="white" />
                        <path d="M34 28L28 22L14 34" stroke="white" stroke-width="3" stroke-linejoin="round" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-yellow-500 transition-colors">PDF to JPG
                </h3>
                <p class="text-sm text-gray-500 leading-relaxed">Convert each PDF page into a JPG or extract all images
                    contained in a PDF.</p>
            </a>
            <!-- PDF to PowerPoint -->
            <a href="#"
                class="group p-6 bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-all duration-200 flex flex-col items-start text-left h-full hover:-translate-y-1">
                <div class="w-12 h-12 mb-4">
                    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        <rect x="8" y="8" width="32" height="32" rx="4" fill="#FF922B" />
                        <path d="M14 16H22V24H14V16Z" fill="white" />
                        <path d="M26 18H34" stroke="white" stroke-width="2" stroke-linecap="round" />
                        <path d="M26 22H34" stroke="white" stroke-width="2" stroke-linecap="round" />
                        <path d="M14 28H34" stroke="white" stroke-width="2" stroke-linecap="round" />
                        <path d="M14 32H24" stroke="white" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-orange-500 transition-colors">PDF to
                    PowerPoint</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Turn your PDF files into easy to edit PPT and PPTX
                    slideshows.</p>
            </a>

            <!-- PDF to Excel -->
            <a href="{{ route('tools.pdf-to-excel') }}"
                class="group p-6 bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-all duration-200 flex flex-col items-start text-left h-full hover:-translate-y-1">
                <div class="w-12 h-12 mb-4">
                    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        <rect x="8" y="8" width="32" height="32" rx="4" fill="#69DB7C" />
                        <path d="M14 16H22V24H14V16Z" fill="white" />
                        <path d="M26 18H34" stroke="white" stroke-width="2" stroke-linecap="round" />
                        <path d="M26 22H34" stroke="white" stroke-width="2" stroke-linecap="round" />
                        <path d="M14 28H34" stroke="white" stroke-width="2" stroke-linecap="round" />
                        <path d="M14 32H24" stroke="white" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-green-500 transition-colors">PDF to Excel
                </h3>
                <p class="text-sm text-gray-500 leading-relaxed">Extract tables and data from PDFs to Excel spreadsheets (XLSX) or CSV format.</p>
            </a>

            <!-- Word to PDF -->
            <a href="{{ route('tools.word-to-pdf') }}"
                class="group p-6 bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-all duration-200 flex flex-col items-start text-left h-full hover:-translate-y-1">
                <div class="w-12 h-12 mb-4">
                    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        <rect x="8" y="8" width="32" height="32" rx="4" fill="#74C0FC" />
                        <path d="M34 16H26V24H34V16Z" fill="white" />
                        <path d="M22 18H14" stroke="white" stroke-width="2" stroke-linecap="round" />
                        <path d="M22 22H14" stroke="white" stroke-width="2" stroke-linecap="round" />
                        <path d="M34 28H14" stroke="white" stroke-width="2" stroke-linecap="round" />
                        <path d="M34 32H24" stroke="white" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-blue-500 transition-colors">Word to PDF
                </h3>
                <p class="text-sm text-gray-500 leading-relaxed">Make DOC and DOCX files easy to read by converting them to
                    PDF.</p>
            </a>

            <!-- PowerPoint to PDF -->
            <a href="#"
                class="group p-6 bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-all duration-200 flex flex-col items-start text-left h-full hover:-translate-y-1">
                <div class="w-12 h-12 mb-4">
                    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        <rect x="8" y="8" width="32" height="32" rx="4" fill="#FFA94D" />
                        <path d="M34 16H26V24H34V16Z" fill="white" />
                        <path d="M22 18H14" stroke="white" stroke-width="2" stroke-linecap="round" />
                        <path d="M22 22H14" stroke="white" stroke-width="2" stroke-linecap="round" />
                        <path d="M34 28H14" stroke="white" stroke-width="2" stroke-linecap="round" />
                        <path d="M34 32H24" stroke="white" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-orange-500 transition-colors">PowerPoint
                    to PDF</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Make PPT and PPTX slideshows easy to view by converting
                    them to PDF.</p>
            </a>

            <!-- Excel to PDF -->
            <a href="#"
                class="group p-6 bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-all duration-200 flex flex-col items-start text-left h-full hover:-translate-y-1">
                <div class="w-12 h-12 mb-4">
                    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        <rect x="8" y="8" width="32" height="32" rx="4" fill="#8CE99A" />
                        <path d="M34 16H26V24H34V16Z" fill="white" />
                        <path d="M22 18H14" stroke="white" stroke-width="2" stroke-linecap="round" />
                        <path d="M22 22H14" stroke="white" stroke-width="2" stroke-linecap="round" />
                        <path d="M34 28H14" stroke="white" stroke-width="2" stroke-linecap="round" />
                        <path d="M34 32H24" stroke="white" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-green-500 transition-colors">Excel to PDF
                </h3>
                <p class="text-sm text-gray-500 leading-relaxed">Make EXCEL spreadsheets easy to read by converting them to
                    PDF.</p>
            </a>

            <!-- Edit PDF -->
            <a href="{{ url('/tools/edit') }}"
                class="group p-6 bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-all duration-200 flex flex-col items-start text-left h-full hover:-translate-y-1 relative overflow-hidden">
                <div class="absolute top-4 right-4 bg-red-100 text-red-600 text-xs font-bold px-2 py-1 rounded-full">New!
                </div>
                <div class="w-12 h-12 mb-4">
                    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        <rect x="8" y="8" width="32" height="32" rx="4" fill="#B197FC" />
                        <path d="M16 32H32" stroke="white" stroke-width="3" stroke-linecap="round" />
                        <path d="M24 16V28" stroke="white" stroke-width="3" stroke-linecap="round" />
                        <path d="M18 16H30" stroke="white" stroke-width="3" stroke-linecap="round" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-purple-500 transition-colors">Edit PDF
                </h3>
                <p class="text-sm text-gray-500 leading-relaxed">Add text, images, shapes or freehand annotations to a PDF
                    document.</p>
            </a>           

            <!-- JPG to PDF -->
            <a href="{{ route('tools.jpg-to-pdf') }}"
                class="group p-6 bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-all duration-200 flex flex-col items-start text-left h-full hover:-translate-y-1">
                <div class="w-12 h-12 mb-4">
                    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        <rect x="8" y="8" width="32" height="32" rx="4" fill="#FCC419" />
                        <path d="M14 14H34V34H14V14Z" stroke="white" stroke-width="3" stroke-linejoin="round" />
                        <path d="M24 20V28" stroke="white" stroke-width="3" stroke-linecap="round" />
                        <path d="M20 24H28" stroke="white" stroke-width="3" stroke-linecap="round" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-yellow-500 transition-colors">JPG to PDF
                </h3>
                <p class="text-sm text-gray-500 leading-relaxed">Convert JPG images to PDF in seconds. Easily adjust
                    orientation and margins.</p>
            </a>

            <!-- Sign PDF -->
            <a href="{{ url('/tools/sign') }}"
                class="group p-6 bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-all duration-200 flex flex-col items-start text-left h-full hover:-translate-y-1">
                <div class="w-12 h-12 mb-4">
                    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        <rect x="8" y="8" width="32" height="32" rx="4" fill="#748FFC" />
                        <path d="M28 14L34 20L20 34H14V28L28 14Z" stroke="white" stroke-width="3"
                            stroke-linejoin="round" />
                        <path d="M14 34H34" stroke="white" stroke-width="3" stroke-linecap="round" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-indigo-500 transition-colors">Sign PDF
                </h3>
                <p class="text-sm text-gray-500 leading-relaxed">Sign yourself or request electronic signatures from
                    others.</p>
            </a>

            <!-- Watermark -->
            <a href="#"
                class="group p-6 bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-all duration-200 flex flex-col items-start text-left h-full hover:-translate-y-1">
                <div class="w-12 h-12 mb-4">
                    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        <rect x="8" y="8" width="32" height="32" rx="4" fill="#F06595" />
                        <circle cx="24" cy="24" r="10" stroke="white" stroke-width="3" />
                        <path d="M18 24H30" stroke="white" stroke-width="3" stroke-linecap="round" />
                        <path d="M24 18V30" stroke="white" stroke-width="3" stroke-linecap="round" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-pink-500 transition-colors">Watermark</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Stamp an image or text over your PDF in seconds. Choose
                    typography, transparency and position.</p>
            </a>

            <!-- Rotate PDF -->
            <a href="#"
                class="group p-6 bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-all duration-200 flex flex-col items-start text-left h-full hover:-translate-y-1">
                <div class="w-12 h-12 mb-4">
                    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        <rect x="8" y="8" width="32" height="32" rx="4" fill="#20C997" />
                        <path d="M24 14V22" stroke="white" stroke-width="3" stroke-linecap="round" />
                        <path d="M24 26V34" stroke="white" stroke-width="3" stroke-linecap="round" />
                        <path d="M34 24H26" stroke="white" stroke-width="3" stroke-linecap="round" />
                        <path d="M22 24H14" stroke="white" stroke-width="3" stroke-linecap="round" />
                        <path d="M32 16L16 32" stroke="white" stroke-width="3" stroke-linecap="round" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-teal-500 transition-colors">Rotate PDF
                </h3>
                <p class="text-sm text-gray-500 leading-relaxed">Rotate your PDFs the way you need them. You can even
                    rotate multiple PDFs at once!</p>
            </a>
        </div>
    </div>
@endsection
