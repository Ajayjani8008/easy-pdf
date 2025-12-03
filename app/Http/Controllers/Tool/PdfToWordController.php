<?php

namespace App\Http\Controllers\Tool;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PdfToWordController extends Controller
{
    public function index()
    {
        $seo = [
            'title' => 'PDF to Word Converter | MyBrand',
            'description' => 'Free online PDF to Word converter. No signup required. Convert your PDF documents to editable Word files instantly.',
            'keywords' => 'pdf to word, convert pdf, docx, online tool, free pdf converter',
            'canonical' => url()->current(),
            'og_type' => 'website',
        ];

        return view('tools.pdf-to-word', compact('seo'));
    }
}
