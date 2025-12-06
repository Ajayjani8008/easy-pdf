<?php

namespace App\Http\Controllers\Tool;

class PdfToJpgController extends BaseConverterController
{
    protected function getConversionType(): string
    {
        return 'pdf-to-jpg';
    }

    protected function getToolName(): string
    {
        return 'PDF to JPG';
    }

    protected function getShortBenefit(): string
    {
        return 'JPG Converter';
    }

    protected function getMetaDescription(): string
    {
        return 'Convert PDF pages to JPG images or extract images from PDFs for free. Choose quality, DPI, and page ranges. Fast, secure, no signup required.';
    }

    protected function getKeywords(): string
    {
        return 'pdf to jpg, pdf to image, convert pdf to jpg, pdf to jpeg, extract images from pdf, pdf page to image, free pdf to jpg converter, online pdf to jpg';
    }
}

