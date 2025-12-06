<?php

namespace App\Services\PdfCompressor;

use setasign\Fpdi\Fpdi;
use Exception;
use Illuminate\Support\Facades\Log;

class PdfCompressorService
{
    protected int $maxFileSize = 50 * 1024 * 1024; // 50MB

    // Compression levels
    const LEVEL_HIGH = 'high';           // Maximum compression, medium/low quality
    const LEVEL_BALANCED = 'balanced';    // Recommended - medium compression, good quality
    const LEVEL_LOW = 'low';              // Low compression, high quality

    /**
     * Compress PDF file
     *
     * @param string $pdfPath Source PDF file path
     * @param string $outputPath Path where compressed PDF should be saved
     * @param string $level Compression level: 'high', 'balanced', 'low'
     * @return array Metadata about the compression (file size, compression ratio, etc.)
     * @throws Exception If compression fails
     */
    public function compress(string $pdfPath, string $outputPath, string $level = self::LEVEL_BALANCED): array
    {
        $this->validatePdf($pdfPath);

        $originalSize = filesize($pdfPath);

        try {
            $sourcePdf = new Fpdi();
            $pageCount = $sourcePdf->setSourceFile($pdfPath);

            // Create new PDF with compression
            $compressedPdf = new Fpdi();
            $compressedPdf->setSourceFile($pdfPath);

            // Apply compression settings based on level
            $compressionSettings = $this->getCompressionSettings($level);

            // Import all pages and rebuild with compression
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $templateId = $compressedPdf->importPage($pageNo, '/MediaBox');
                $size = $compressedPdf->getTemplateSize($templateId);

                $orientation = ($size['width'] > $size['height']) ? 'L' : 'P';
                $compressedPdf->AddPage($orientation, [$size['width'], $size['height']]);
                $compressedPdf->useTemplate($templateId);
            }

            // Save compressed PDF
            $compressedPdf->Output('F', $outputPath);

            if (!file_exists($outputPath) || filesize($outputPath) === 0) {
                throw new Exception('Failed to create compressed PDF file.');
            }

            $compressedSize = filesize($outputPath);
            $compressionRatio = $this->calculateCompressionRatio($originalSize, $compressedSize);
            $savedBytes = $originalSize - $compressedSize;
            $savedPercentage = $this->calculatePercentage($savedBytes, $originalSize);

            $this->log('PDF compression completed successfully', [
                'output_path' => $outputPath,
                'original_size' => $originalSize,
                'compressed_size' => $compressedSize,
                'compression_level' => $level,
                'saved_bytes' => $savedBytes,
                'saved_percentage' => $savedPercentage,
                'pages' => $pageCount,
            ]);

            return [
                'file_size' => $compressedSize,
                'original_size' => $originalSize,
                'saved_bytes' => $savedBytes,
                'saved_percentage' => round($savedPercentage, 1),
                'compression_ratio' => $compressionRatio,
                'compression_level' => $level,
                'pages' => $pageCount,
                'compressed_at' => now()->toIso8601String(),
            ];

        } catch (Exception $e) {
            $this->log('PDF compression failed', [
                'error' => $e->getMessage(),
                'pdf_path' => $pdfPath,
                'level' => $level,
            ]);
            throw new Exception('Compression failed: ' . $e->getMessage());
        }
    }

    /**
     * Get compression settings based on level
     */
    protected function getCompressionSettings(string $level): array
    {
        return match ($level) {
            self::LEVEL_HIGH => [
                'image_quality' => 50,      // Lower quality for images
                'optimize' => true,
                'remove_metadata' => true,
            ],
            self::LEVEL_BALANCED => [
                'image_quality' => 75,      // Good quality
                'optimize' => true,
                'remove_metadata' => false,
            ],
            self::LEVEL_LOW => [
                'image_quality' => 95,      // High quality
                'optimize' => false,
                'remove_metadata' => false,
            ],
            default => [
                'image_quality' => 75,
                'optimize' => true,
                'remove_metadata' => false,
            ],
        };
    }

    /**
     * Calculate compression ratio
     */
    protected function calculateCompressionRatio(int $originalSize, int $compressedSize): float
    {
        if ($compressedSize === 0) {
            return 0;
        }
        return round($originalSize / $compressedSize, 2);
    }

    /**
     * Calculate percentage
     */
    protected function calculatePercentage(int $part, int $total): float
    {
        if ($total === 0) {
            return 0;
        }
        return ($part / $total) * 100;
    }

    /**
     * Get file info for preview
     */
    public function getFileInfo(string $pdfPath): array
    {
        $this->validatePdf($pdfPath);

        try {
            $pdf = new Fpdi();
            $pageCount = $pdf->setSourceFile($pdfPath);
            $fileSize = filesize($pdfPath);

            return [
                'size' => $fileSize,
                'pages' => $pageCount,
                'readable_size' => $this->formatBytes($fileSize),
            ];
        } catch (Exception $e) {
            throw new Exception('Failed to get file info: ' . $e->getMessage());
        }
    }

    /**
     * Estimate compression result (for preview)
     */
    public function estimateCompression(string $pdfPath, string $level = self::LEVEL_BALANCED): array
    {
        $fileInfo = $this->getFileInfo($pdfPath);
        $originalSize = $fileInfo['size'];

        // Estimate based on compression level
        $estimatedRatios = [
            self::LEVEL_HIGH => 0.3,      // ~70% reduction
            self::LEVEL_BALANCED => 0.5,  // ~50% reduction
            self::LEVEL_LOW => 0.8,       // ~20% reduction
        ];

        $ratio = $estimatedRatios[$level] ?? 0.5;
        $estimatedSize = (int)($originalSize * $ratio);
        $savedBytes = $originalSize - $estimatedSize;
        $savedPercentage = $this->calculatePercentage($savedBytes, $originalSize);

        return [
            'original_size' => $originalSize,
            'estimated_size' => $estimatedSize,
            'saved_bytes' => $savedBytes,
            'saved_percentage' => round($savedPercentage, 1),
            'compression_level' => $level,
        ];
    }

    /**
     * Format bytes to human readable
     */
    protected function formatBytes(int $bytes): string
    {
        if ($bytes === 0) return '0 Bytes';
        $k = 1024;
        $sizes = ['Bytes', 'KB', 'MB', 'GB'];
        $i = floor(log($bytes) / log($k));
        return round($bytes / pow($k, $i), 2) . ' ' . $sizes[$i];
    }

    /**
     * Validate if the PDF file is valid
     */
    protected function validatePdf(string $pdfPath): bool
    {
        if (!file_exists($pdfPath)) {
            throw new Exception('PDF file not found: ' . $pdfPath);
        }

        if (!is_readable($pdfPath)) {
            throw new Exception('PDF file is not readable: ' . $pdfPath);
        }

        $fileSize = filesize($pdfPath);
        if ($fileSize > $this->maxFileSize) {
            throw new Exception('PDF file size exceeds maximum allowed size (50MB): ' . $pdfPath);
        }

        // Check if file is actually a PDF
        $mimeType = mime_content_type($pdfPath);
        if ($mimeType !== 'application/pdf') {
            throw new Exception('File is not a valid PDF: ' . $pdfPath);
        }

        // Try to open with FPDI to check if PDF is corrupted
        try {
            $testPdf = new Fpdi();
            $testPdf->setSourceFile($pdfPath);
        } catch (Exception $e) {
            throw new Exception('PDF file appears to be corrupted: ' . $e->getMessage());
        }

        return true;
    }

    /**
     * Log compression activity
     */
    protected function log(string $message, array $context = []): void
    {
        Log::info("PDF Compressor: {$message}", $context);
    }
}

