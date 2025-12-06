<?php

namespace App\Http\Controllers\Tool;

class JpgToPdfController extends BaseConverterController
{
    protected function getConversionType(): string
    {
        return 'jpg-to-pdf';
    }

    protected function getToolName(): string
    {
        return 'JPG to PDF';
    }

    protected function getShortBenefit(): string
    {
        return 'PDF Creator';
    }

    protected function getMetaDescription(): string
    {
        return 'Convert JPG, JPEG, PNG, and WebP images to PDF for free. Combine multiple images into one PDF with customizable page size, orientation, and margins. Fast, secure, no signup required.';
    }

    protected function getKeywords(): string
    {
        return 'jpg to pdf, jpeg to pdf, png to pdf, image to pdf, convert images to pdf, combine images to pdf, create pdf from images, free jpg to pdf converter, online image to pdf';
    }
}

