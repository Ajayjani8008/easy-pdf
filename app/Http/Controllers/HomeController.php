<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $seo = [
            'title' => 'EasyPDF - Online PDF Tools for Everyone',
            'description' => 'Every tool you need to work with PDFs in one place. Merge, split, compress, convert, rotate, unlock and watermark PDFs with just a few clicks.',
            'keywords' => 'pdf tools, merge pdf, split pdf, compress pdf, convert pdf',
            'canonical' => url('/'),
            'og_type' => 'website',
        ];

        return view('home', compact('seo'));
    }
}
