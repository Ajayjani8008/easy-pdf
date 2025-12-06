<?php

namespace App\Services\PdfSplitter;

use setasign\Fpdi\Fpdi;
use Exception;
use Illuminate\Support\Facades\Log;

class PdfSplitterService
{
    protected int $maxFileSize = 50 * 1024 * 1024; // 50MB

    /**
     * Split PDF by page range
     *
     * @param string $pdfPath Source PDF file path
     * @param string $outputPath Path where split PDF should be saved
     * @param array $pageRanges Array of page ranges, e.g., [[1, 3], [5, 10]] or [[1, 1]] for single page
     * @return array Metadata about the split (file size, pages, etc.)
     * @throws Exception If split fails
     */
    public function splitByRanges(string $pdfPath, string $outputPath, array $pageRanges): array
    {
        $this->validatePdf($pdfPath);

        try {
            // Create source PDF instance to get page count
            $sourcePdf = new Fpdi();
            $pageCount = $sourcePdf->setSourceFile($pdfPath);

            // Validate page ranges
            $this->validatePageRanges($pageRanges, $pageCount);

            // Create new PDF with selected pages
            // IMPORTANT: Set source file in new PDF so templates can be imported correctly
            $newPdf = new Fpdi();
            $newPdf->setSourceFile($pdfPath);
            $totalPages = 0;
            $errors = [];

            foreach ($pageRanges as $rangeIndex => $range) {
                $startPage = $range[0];
                $endPage = $range[1] ?? $range[0]; // If single page, end = start

                for ($pageNo = $startPage; $pageNo <= $endPage; $pageNo++) {
                    if ($pageNo > $pageCount) {
                        $errors[] = "Page {$pageNo} does not exist (PDF has {$pageCount} pages)";
                        continue; // Skip if page doesn't exist
                    }

                    if ($pageNo < 1) {
                        $errors[] = "Page {$pageNo} is invalid (must be >= 1)";
                        continue;
                    }

                    try {
                        // Import page in the new PDF instance (source file already set above)
                        // Use MediaBox to ensure proper page size
                        $templateId = $newPdf->importPage($pageNo, '/MediaBox');
                        $size = $newPdf->getTemplateSize($templateId);

                        if (!$size || !isset($size['width']) || !isset($size['height'])) {
                            throw new Exception("Could not determine page size for page {$pageNo}");
                        }

                        // Add page with appropriate orientation
                        $orientation = ($size['width'] > $size['height']) ? 'L' : 'P';
                        $newPdf->AddPage($orientation, [$size['width'], $size['height']]);

                        // Use the template (from the same instance)
                        $newPdf->useTemplate($templateId);

                        $totalPages++;
                    } catch (Exception $e) {
                        $errorMsg = "Failed to import page {$pageNo}: " . $e->getMessage();
                        $errors[] = $errorMsg;
                        $this->log('Page import failed', [
                            'page' => $pageNo,
                            'error' => $e->getMessage(),
                        ]);
                        // Continue with next page instead of failing completely
                        continue;
                    }
                }
            }

            if ($totalPages === 0) {
                throw new Exception('No pages could be extracted. ' . implode(' ', $errors));
            }

            // Save split PDF
            $newPdf->Output('F', $outputPath);

            if (!file_exists($outputPath) || filesize($outputPath) === 0) {
                throw new Exception('Failed to create output PDF file.');
            }

            $this->log('PDF split completed successfully', [
                'output_path' => $outputPath,
                'total_pages' => $totalPages,
                'ranges' => $pageRanges,
                'warnings' => $errors,
            ]);

            return [
                'file_size' => filesize($outputPath),
                'pages' => $totalPages,
                'ranges' => $pageRanges,
                'warnings' => $errors,
                'split_at' => now()->toIso8601String(),
            ];

        } catch (Exception $e) {
            $this->log('PDF split failed', [
                'error' => $e->getMessage(),
                'pdf_path' => $pdfPath,
                'ranges' => $pageRanges,
            ]);
            throw new Exception('Split failed: ' . $e->getMessage());
        }
    }

    /**
     * Split PDF into individual pages (one file per page)
     *
     * @param string $pdfPath Source PDF file path
     * @param string $outputDir Directory where split PDFs should be saved
     * @return array Array of output file paths and metadata
     * @throws Exception If split fails
     */
    public function splitIntoPages(string $pdfPath, string $outputDir): array
    {
        $this->validatePdf($pdfPath);

        if (!is_dir($outputDir)) {
            mkdir($outputDir, 0755, true);
        }

        try {
            $sourcePdf = new Fpdi();
            $pageCount = $sourcePdf->setSourceFile($pdfPath);

            $outputFiles = [];

            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $outputPath = $outputDir . '/page_' . $pageNo . '.pdf';
                
                $newPdf = new Fpdi();
                $templateId = $sourcePdf->importPage($pageNo);
                $size = $sourcePdf->getTemplateSize($templateId);

                $orientation = ($size['width'] > $size['height']) ? 'L' : 'P';
                $newPdf->AddPage($orientation, [$size['width'], $size['height']]);
                $newPdf->useTemplate($templateId);
                $newPdf->Output('F', $outputPath);

                $outputFiles[] = [
                    'path' => $outputPath,
                    'page' => $pageNo,
                    'size' => filesize($outputPath),
                ];
            }

            $this->log('PDF split into pages completed', [
                'pdf_path' => $pdfPath,
                'total_pages' => $pageCount,
                'output_files' => count($outputFiles),
            ]);

            return [
                'files' => $outputFiles,
                'total_pages' => $pageCount,
                'split_at' => now()->toIso8601String(),
            ];

        } catch (Exception $e) {
            $this->log('PDF split into pages failed', [
                'error' => $e->getMessage(),
                'pdf_path' => $pdfPath,
            ]);
            throw new Exception('Split failed: ' . $e->getMessage());
        }
    }

    /**
     * Get PDF page count
     */
    public function getPageCount(string $pdfPath): int
    {
        try {
            $pdf = new Fpdi();
            return $pdf->setSourceFile($pdfPath);
        } catch (Exception $e) {
            throw new Exception('Failed to read PDF: ' . $e->getMessage());
        }
    }

    /**
     * Validate page ranges
     */
    protected function validatePageRanges(array $pageRanges, int $totalPages): void
    {
        if (empty($pageRanges)) {
            throw new Exception('No page ranges provided.');
        }

        foreach ($pageRanges as $range) {
            if (!is_array($range) || count($range) < 1) {
                throw new Exception('Invalid page range format.');
            }

            $startPage = $range[0];
            $endPage = $range[1] ?? $range[0];

            if ($startPage < 1 || $startPage > $totalPages) {
                throw new Exception("Start page {$startPage} is out of range (1-{$totalPages}).");
            }

            if ($endPage < 1 || $endPage > $totalPages) {
                throw new Exception("End page {$endPage} is out of range (1-{$totalPages}).");
            }

            if ($startPage > $endPage) {
                throw new Exception("Start page ({$startPage}) cannot be greater than end page ({$endPage}).");
            }
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
     * Log split activity
     */
    protected function log(string $message, array $context = []): void
    {
        Log::info("PDF Splitter: {$message}", $context);
    }
}

