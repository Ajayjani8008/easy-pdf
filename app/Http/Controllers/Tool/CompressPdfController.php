<?php

namespace App\Http\Controllers\Tool;

class CompressPdfController extends BaseConverterController
{
    protected function getConversionType(): string
    {
        return 'compress-pdf';
    }

    protected function getToolName(): string
    {
        return 'Compress PDF';
    }

    protected function getShortBenefit(): string
    {
        return 'PDF Compressor';
    }

    protected function getMetaDescription(): string
    {
        return 'Compress PDF files to reduce size while maintaining quality. Choose from high compression, balanced, or best quality modes. Free, secure, no signup required.';
    }

    protected function getKeywords(): string
    {
        return 'compress pdf, reduce pdf size, pdf compressor, shrink pdf, optimize pdf, pdf size reducer, free pdf compressor, online pdf compression';
    }
}

