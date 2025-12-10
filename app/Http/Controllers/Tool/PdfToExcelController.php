<?php

namespace App\Http\Controllers\Tool;

class PdfToExcelController extends BaseConverterController
{
    protected function getConversionType(): string
    {
        return 'pdf-to-excel';
    }

    protected function getToolName(): string
    {
        return 'PDF to Excel Converter';
    }

    protected function getShortBenefit(): string
    {
        return 'Excel Converter';
    }

    protected function getMetaDescription(): string
    {
        return 'Convert PDF to Excel spreadsheets for free. Extract tables and data from PDFs to XLSX or CSV format. Fast, secure, automatic table detection. No registration required.';
    }

    protected function getKeywords(): string
    {
        return 'pdf to excel, pdf to xlsx, pdf to csv, convert pdf to excel, pdf table extractor, pdf to spreadsheet, free pdf to excel, online pdf converter, extract tables from pdf';
    }
}

