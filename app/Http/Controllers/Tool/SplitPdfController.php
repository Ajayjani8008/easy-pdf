<?php

namespace App\Http\Controllers\Tool;

class SplitPdfController extends BaseConverterController
{
    protected function getConversionType(): string
    {
        return 'split-pdf';
    }

    protected function getToolName(): string
    {
        return 'Split PDF';
    }

    protected function getShortBenefit(): string
    {
        return 'PDF Splitter';
    }

    protected function getMetaDescription(): string
    {
        return 'Split PDF files into separate pages or extract specific page ranges for free. Fast, secure, no signup required. Select pages to split easily.';
    }

    protected function getKeywords(): string
    {
        return 'split pdf, extract pdf pages, pdf splitter, separate pdf pages, split pdf file, extract pages from pdf, free pdf splitter, online pdf split';
    }
}

