<?php

namespace App\Services\PdfConverter;

interface PdfConverterInterface
{
    /**
     * Convert PDF file to target format
     *
     * @param string $pdfPath Path to the PDF file
     * @param string $outputPath Path where converted file should be saved
     * @return array Metadata about the conversion (file size, pages, etc.)
     * @throws \Exception If conversion fails
     */
    public function convert(string $pdfPath, string $outputPath): array;

    /**
     * Get the target file extension
     *
     * @return string File extension (e.g., 'docx', 'xlsx', 'pptx')
     */
    public function getTargetExtension(): string;

    /**
     * Get the MIME type of the target format
     *
     * @return string MIME type (e.g., 'application/vnd.openxmlformats-officedocument.wordprocessingml.document')
     */
    public function getTargetMimeType(): string;

    /**
     * Validate if the PDF file can be converted
     *
     * @param string $pdfPath Path to the PDF file
     * @return bool
     */
    public function validatePdf(string $pdfPath): bool;
}

