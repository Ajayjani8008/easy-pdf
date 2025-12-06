<?php

namespace App\Http\Controllers\Tool;

class PdfToWordController extends BaseConverterController
{
    protected function getConversionType(): string
    {
        return 'pdf-to-word';
    }

    protected function getToolName(): string
    {
        return 'PDF to Word Converter';
    }

    protected function getShortBenefit(): string
    {
        return 'DOCX Converter';
    }

    protected function getMetaDescription(): string
    {
        return 'Convert PDF to Word documents for free. Fast, secure, and easy to use. No registration required. Preserve formatting and layout.';
    }

    protected function getKeywords(): string
    {
        return 'pdf to word, pdf to docx, convert pdf to word, pdf converter, free pdf to word, online pdf converter, pdf to word online, pdf to doc converter';
    }
}
