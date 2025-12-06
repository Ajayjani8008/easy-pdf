<?php

namespace App\Services\PdfMerger;

use setasign\Fpdi\Fpdi;
use Exception;
use Illuminate\Support\Facades\Log;

class PdfMergerService
{
    protected int $maxFileSize = 50 * 1024 * 1024; // 50MB per file
    protected int $maxFiles = 10;
    protected int $minFiles = 2;

    /**
     * Merge multiple PDF files into one
     *
     * @param array $pdfPaths Array of PDF file paths in order
     * @param string $outputPath Path where merged PDF should be saved
     * @return array Metadata about the merge (file size, pages, etc.)
     * @throws Exception If merge fails
     */
    public function merge(array $pdfPaths, string $outputPath): array
    {
        $this->validateInputs($pdfPaths);

        try {
            $pdf = new Fpdi();
            $totalPages = 0;
            $totalSize = 0;

            foreach ($pdfPaths as $index => $pdfPath) {
                if (!file_exists($pdfPath)) {
                    throw new Exception("PDF file not found at index {$index}: {$pdfPath}");
                }

                // Validate each PDF
                $this->validatePdf($pdfPath);

                // Get page count
                $pageCount = $pdf->setSourceFile($pdfPath);
                $totalPages += $pageCount;
                $totalSize += filesize($pdfPath);

                // Import all pages from this PDF
                for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                    $templateId = $pdf->importPage($pageNo);
                    $size = $pdf->getTemplateSize($templateId);

                    // Add page with appropriate orientation
                    $orientation = ($size['width'] > $size['height']) ? 'L' : 'P';
                    $pdf->AddPage($orientation, [$size['width'], $size['height']]);
                    $pdf->useTemplate($templateId);
                }

                Log::info("Merged PDF file", [
                    'index' => $index,
                    'path' => $pdfPath,
                    'pages' => $pageCount,
                ]);
            }

            // Save merged PDF
            $pdf->Output('F', $outputPath);

            $this->log('PDF merge completed successfully', [
                'output_path' => $outputPath,
                'total_pages' => $totalPages,
                'files_merged' => count($pdfPaths),
                'total_size' => $totalSize,
            ]);

            return [
                'file_size' => filesize($outputPath),
                'pages' => $totalPages,
                'files_merged' => count($pdfPaths),
                'merged_at' => now()->toIso8601String(),
            ];

        } catch (Exception $e) {
            $this->log('PDF merge failed', [
                'error' => $e->getMessage(),
                'pdf_paths' => $pdfPaths,
            ]);
            throw new Exception('Merge failed: ' . $e->getMessage());
        }
    }

    /**
     * Validate input parameters
     */
    protected function validateInputs(array $pdfPaths): void
    {
        $fileCount = count($pdfPaths);

        if ($fileCount < $this->minFiles) {
            throw new Exception("Minimum {$this->minFiles} files required for merging. You provided {$fileCount}.");
        }

        if ($fileCount > $this->maxFiles) {
            throw new Exception("Maximum {$this->maxFiles} files allowed for merging. You provided {$fileCount}.");
        }

        if (empty($pdfPaths)) {
            throw new Exception('No PDF files provided for merging.');
        }
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
     * Log merge activity
     */
    protected function log(string $message, array $context = []): void
    {
        Log::info("PDF Merger: {$message}", $context);
    }
}

