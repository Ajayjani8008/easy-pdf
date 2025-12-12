<?php

namespace App\Http\Controllers\Tool;

class WordToPdfController extends BaseConverterController
{
    protected function getConversionType(): string
    {
        return 'word-to-pdf';
    }

    protected function getToolName(): string
    {
        return 'Word to PDF';
    }

    protected function getShortBenefit(): string
    {
        return 'PDF Converter';
    }

    protected function getMetaDescription(): string
    {
        return 'Convert Word documents (DOC, DOCX, RTF) to PDF for free. Preserve fonts, margins, images, tables, and formatting. Fast, secure, no signup required.';
    }

    protected function getKeywords(): string
    {
        return 'word to pdf, doc to pdf, docx to pdf, convert word to pdf, word converter, doc converter, rtf to pdf, free word to pdf, online word to pdf converter, word document to pdf';
    }
}

