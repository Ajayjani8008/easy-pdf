<?php

namespace App\Http\Controllers\Tool;

class MergePdfController extends BaseConverterController
{
    protected function getConversionType(): string
    {
        return 'merge'; // View file name: merge.blade.php
    }

    protected function getToolName(): string
    {
        return 'Merge PDF';
    }

    protected function getShortBenefit(): string
    {
        return 'PDF Merger';
    }

    protected function getMetaDescription(): string
    {
        return 'Merge multiple PDF files into one document for free. Combine 2-10 PDFs online. Fast, secure, no signup required. Drag and drop to reorder.';
    }

    protected function getKeywords(): string
    {
        return 'merge pdf, combine pdf, pdf merger, merge pdf files, join pdf, pdf combiner, free pdf merger, online pdf merge';
    }
}

