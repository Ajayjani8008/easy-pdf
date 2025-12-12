<?php

namespace App\Services\WordToPdf;

use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use Exception;
use Illuminate\Support\Facades\Log;

class WordToPdfService
{
    protected int $maxFileSize = 50 * 1024 * 1024; // 50MB

    // Page sizes
    const PAGE_SIZE_A4 = 'a4';
    const PAGE_SIZE_LETTER = 'letter';
    const PAGE_SIZE_LEGAL = 'legal';

    // Orientations
    const ORIENTATION_PORTRAIT = 'portrait';
    const ORIENTATION_LANDSCAPE = 'landscape';

    // Margin presets
    const MARGIN_DEFAULT = 'default';
    const MARGIN_NARROW = 'narrow';
    const MARGIN_WIDE = 'wide';

    /**
     * Convert Word document to PDF
     *
     * @param string $wordPath Path to the Word document
     * @param string $outputPath Path where PDF should be saved
     * @param array $options Conversion options
     * @return array Metadata about the conversion
     * @throws Exception If conversion fails
     */
    public function convert(string $wordPath, string $outputPath, array $options = []): array
    {
        $this->validateWordFile($wordPath);

        // Set default options
        $pageSize = $options['page_size'] ?? self::PAGE_SIZE_A4;
        $orientation = $options['orientation'] ?? self::ORIENTATION_PORTRAIT;
        $margin = $options['margin'] ?? self::MARGIN_DEFAULT;

        try {
            // Load Word document
            $phpWord = IOFactory::load($wordPath);

            // Configure PDF rendering
            // Note: PhpWord uses DomPDF for PDF rendering
            // Make sure dompdf/dompdf is installed: composer require dompdf/dompdf
            if (class_exists('\Dompdf\Dompdf')) {
                Settings::setPdfRendererName('DomPDF');
                Settings::setPdfRendererPath(base_path('vendor/dompdf/dompdf'));
            } else {
                throw new Exception('DomPDF library is required for PDF conversion. Please install it with: composer require dompdf/dompdf');
            }

            // Save as PDF
            // Note: PhpWord's PDF writer requires DomPDF
            $pdfWriter = IOFactory::createWriter($phpWord, 'PDF');
            $pdfWriter->save($outputPath);

            // Get page count from Word document
            $pageCount = $this->getWordPageCount($phpWord);

            $this->log('Word document converted to PDF successfully', [
                'word_path' => $wordPath,
                'output_path' => $outputPath,
                'page_count' => $pageCount,
            ]);

            return [
                'file_size' => filesize($outputPath),
                'pages' => $pageCount,
                'converted_at' => now()->toIso8601String(),
            ];
        } catch (Exception $e) {
            $this->log('Word to PDF conversion failed', [
                'error' => $e->getMessage(),
                'word_path' => $wordPath,
                'trace' => $e->getTraceAsString(),
            ]);

            // Fallback: Try alternative method if DomPDF is not available
            if (strpos($e->getMessage(), 'DomPDF') !== false || strpos($e->getMessage(), 'PDF') !== false) {
                throw new Exception('PDF conversion requires DomPDF library. Please install it with: composer require dompdf/dompdf');
            }

            throw new Exception('Conversion failed: ' . $e->getMessage());
        }
    }

    /**
     * Validate Word file
     *
     * @param string $filePath
     * @throws Exception
     */
    protected function validateWordFile(string $filePath): void
    {
        if (!file_exists($filePath)) {
            throw new Exception('Word file not found: ' . $filePath);
        }

        if (!is_readable($filePath)) {
            throw new Exception('Word file is not readable: ' . $filePath);
        }

        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        $allowedExtensions = ['doc', 'docx', 'rtf', 'odt'];

        if (!in_array($extension, $allowedExtensions)) {
            throw new Exception('Unsupported file format. Allowed formats: ' . implode(', ', $allowedExtensions));
        }

        $fileSize = filesize($filePath);
        if ($fileSize > $this->maxFileSize) {
            throw new Exception('File size exceeds maximum allowed size of ' . ($this->maxFileSize / 1024 / 1024) . 'MB');
        }

        if ($fileSize === 0) {
            throw new Exception('Word file is empty');
        }
    }

    /**
     * Get page dimensions based on page size and orientation
     *
     * @param string $pageSize
     * @param string $orientation
     * @return array
     */
    protected function getPageDimensions(string $pageSize, string $orientation): array
    {
        // Dimensions in points (1 inch = 72 points)
        $dimensions = [
            self::PAGE_SIZE_A4 => ['width' => 595.276, 'height' => 841.890],      // A4: 210mm x 297mm
            self::PAGE_SIZE_LETTER => ['width' => 612, 'height' => 792],          // Letter: 8.5" x 11"
            self::PAGE_SIZE_LEGAL => ['width' => 612, 'height' => 1008],         // Legal: 8.5" x 14"
        ];

        $size = $dimensions[$pageSize] ?? $dimensions[self::PAGE_SIZE_A4];

        if ($orientation === self::ORIENTATION_LANDSCAPE) {
            return [
                'width' => $size['height'],
                'height' => $size['width'],
            ];
        }

        return $size;
    }

    /**
     * Get margin values based on margin preset
     *
     * @param string $margin
     * @return array
     */
    protected function getMargins(string $margin): array
    {
        // Margins in points (1 inch = 72 points)
        $margins = [
            self::MARGIN_DEFAULT => ['top' => 72, 'right' => 72, 'bottom' => 72, 'left' => 72],      // 1 inch
            self::MARGIN_NARROW => ['top' => 36, 'right' => 36, 'bottom' => 36, 'left' => 36],     // 0.5 inch
            self::MARGIN_WIDE => ['top' => 144, 'right' => 144, 'bottom' => 144, 'left' => 144],   // 2 inches
        ];

        return $margins[$margin] ?? $margins[self::MARGIN_DEFAULT];
    }

    /**
     * Get page count from Word document
     *
     * @param \PhpOffice\PhpWord\PhpWord $phpWord
     * @return int
     */
    protected function getWordPageCount($phpWord): int
    {
        try {
            $sections = $phpWord->getSections();
            $pageCount = 0;

            foreach ($sections as $section) {
                $elements = $section->getElements();
                // Estimate pages based on content
                // This is a rough estimate - actual page count depends on content
                $pageCount += max(1, ceil(count($elements) / 20));
            }

            return max(1, $pageCount);
        } catch (Exception $e) {
            Log::warning('Failed to get Word page count', [
                'error' => $e->getMessage(),
            ]);
            return 1; // Default to 1 page
        }
    }

    /**
     * Log message
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    protected function log(string $message, array $context = []): void
    {
        Log::info('[WordToPdfService] ' . $message, $context);
    }
}

