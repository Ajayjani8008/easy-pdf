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
}
