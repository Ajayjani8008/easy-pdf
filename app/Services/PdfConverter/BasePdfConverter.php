<?php

namespace App\Services\PdfConverter;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

abstract class BasePdfConverter implements PdfConverterInterface
{
    protected int $maxFileSize = 50 * 1024 * 1024; // 50MB default

    /**
     * Validate if the PDF file can be converted
     */
    public function validatePdf(string $pdfPath): bool
    {
        if (!file_exists($pdfPath)) {
            throw new \Exception('PDF file not found');
        }

        if (!is_readable($pdfPath)) {
            throw new \Exception('PDF file is not readable');
        }

        $fileSize = filesize($pdfPath);
        if ($fileSize > $this->maxFileSize) {
            throw new \Exception('PDF file size exceeds maximum allowed size');
        }

        // Check if file is actually a PDF
        $mimeType = mime_content_type($pdfPath);
        if ($mimeType !== 'application/pdf') {
            throw new \Exception('File is not a valid PDF');
        }

        return true;
    }

    /**
     * Get storage disk for conversions
     */
    protected function getStorageDisk(): string
    {
        return 'local';
    }

    /**
     * Generate unique file ID
     */
    protected function generateFileId(): string
    {
        return uniqid('file_', true);
    }

    /**
     * Log conversion activity
     */
    protected function log(string $message, array $context = []): void
    {
        Log::info("PDF Converter: {$message}", $context);
    }
}

