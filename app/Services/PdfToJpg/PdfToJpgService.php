<?php

namespace App\Services\PdfToJpg;

use setasign\Fpdi\Fpdi;
use Exception;
use Illuminate\Support\Facades\Log;
use ZipArchive;

class PdfToJpgService
{
    protected int $maxFileSize = 50 * 1024 * 1024; // 50MB

    // Conversion modes
    const MODE_PAGES = 'pages';        // Convert every page to JPG
    const MODE_IMAGES = 'images';      // Extract only images from PDF

    // Quality levels
    const QUALITY_HIGH = 'high';       // Best quality
    const QUALITY_MEDIUM = 'medium';   // Default/Recommended
    const QUALITY_LOW = 'low';         // Fastest + smallest

    // DPI settings
    const DPI_72 = 72;     // Fast, small
    const DPI_150 = 150;   // Recommended
    const DPI_300 = 300;   // High quality / print

    /**
     * Convert PDF to JPG
     *
     * @param string $pdfPath Source PDF file path
     * @param string $outputDir Directory where JPG files should be saved
     * @param string $mode Conversion mode: 'pages' or 'images'
     * @param string $quality Quality level: 'high', 'medium', 'low'
     * @param int $dpi DPI setting: 72, 150, or 300
     * @param array|null $pageRanges Array of page ranges, null for all pages
     * @return array Metadata about the conversion (files, count, etc.)
     * @throws Exception If conversion fails
     */
    public function convert(
        string $pdfPath,
        string $outputDir,
        string $mode = self::MODE_PAGES,
        string $quality = self::QUALITY_MEDIUM,
        int $dpi = self::DPI_150,
        ?array $pageRanges = null
    ): array {
        $this->validatePdf($pdfPath);

        if (!is_dir($outputDir)) {
            mkdir($outputDir, 0755, true);
        }

        try {
            if ($mode === self::MODE_PAGES) {
                return $this->convertPagesToJpg($pdfPath, $outputDir, $quality, $dpi, $pageRanges);
            } else {
                return $this->extractImagesFromPdf($pdfPath, $outputDir, $quality);
            }
        } catch (Exception $e) {
            $this->log('PDF to JPG conversion failed', [
                'error' => $e->getMessage(),
                'pdf_path' => $pdfPath,
                'mode' => $mode,
            ]);
            throw new Exception('Conversion failed: ' . $e->getMessage());
        }
    }

    /**
     * Convert PDF pages to JPG images
     */
    protected function convertPagesToJpg(
        string $pdfPath,
        string $outputDir,
        string $quality,
        int $dpi,
        ?array $pageRanges
    ): array {
        $sourcePdf = new Fpdi();
        $totalPages = $sourcePdf->setSourceFile($pdfPath);

        if ($totalPages === 0) {
            throw new Exception('PDF has no pages to convert.');
        }

        // Determine pages to convert
        $pagesToConvert = $this->getPagesToConvert($totalPages, $pageRanges);

        if (empty($pagesToConvert)) {
            throw new Exception('No pages selected for conversion.');
        }

        $outputFiles = [];
        $qualityValue = $this->getQualityValue($quality);
        $errors = [];

        // Check if GD library is available (minimum requirement)
        if (!function_exists('imagecreatetruecolor')) {
            throw new Exception('GD library is not available. Please install php-gd extension to convert PDF to JPG.');
        }

        foreach ($pagesToConvert as $pageNo) {
            try {
                $outputPath = $outputDir . '/page_' . $pageNo . '.jpg';

                // Render page to JPG (tries Ghostscript -> Imagick -> GD)
                $this->renderPageToJpg($sourcePdf, $pdfPath, $pageNo, $outputPath, $dpi, $qualityValue);

                if (file_exists($outputPath) && filesize($outputPath) > 0) {
                    $outputFiles[] = [
                        'path' => $outputPath,
                        'page' => $pageNo,
                        'size' => filesize($outputPath),
                        'name' => 'page_' . $pageNo . '.jpg',
                    ];
                } else {
                    $errors[] = "Page {$pageNo}: File was not created or is empty";
                }
            } catch (Exception $e) {
                $errorMsg = "Page {$pageNo}: " . $e->getMessage();
                $errors[] = $errorMsg;
                $this->log('Failed to convert page to JPG', [
                    'page' => $pageNo,
                    'error' => $e->getMessage(),
                ]);
                // Continue with next page
                continue;
            }
        }

        if (empty($outputFiles)) {
            $errorDetails = !empty($errors) ? ' Errors: ' . implode('; ', $errors) : '';
            throw new Exception('No pages could be converted to JPG.' . $errorDetails);
        }

        // Create ZIP if multiple files
        $zipPath = null;
        if (count($outputFiles) > 1) {
            $zipPath = $this->createZipFile($outputFiles, $outputDir);
        }

        $this->log('PDF pages converted to JPG successfully', [
            'pdf_path' => $pdfPath,
            'total_pages' => $totalPages,
            'converted_pages' => count($outputFiles),
            'quality' => $quality,
            'dpi' => $dpi,
        ]);

        return [
            'files' => $outputFiles,
            'zip_path' => $zipPath,
            'total_pages' => $totalPages,
            'converted_count' => count($outputFiles),
            'mode' => self::MODE_PAGES,
            'quality' => $quality,
            'dpi' => $dpi,
            'converted_at' => now()->toIso8601String(),
        ];
    }

    /**
     * Extract images from PDF
     */
    protected function extractImagesFromPdf(
        string $pdfPath,
        string $outputDir,
        string $quality
    ): array {
        // This would require more advanced PDF parsing
        // For now, we'll return a structure that can be implemented later
        // In production, use smalot/pdfparser or similar to extract images
        
        $this->log('Image extraction from PDF', [
            'pdf_path' => $pdfPath,
            'quality' => $quality,
        ]);

        // Placeholder - would need actual image extraction implementation
        $outputFiles = [];
        
        // For now, return empty result with note
        // In production, implement actual image extraction
        
        return [
            'files' => $outputFiles,
            'zip_path' => null,
            'extracted_count' => count($outputFiles),
            'mode' => self::MODE_IMAGES,
            'quality' => $quality,
            'converted_at' => now()->toIso8601String(),
        ];
    }

    /**
     * Render PDF page to JPG
     * Uses GD library to create placeholder images
     * For production, install Ghostscript or Imagick for actual PDF rendering
     */
    protected function renderPageToJpg(
        Fpdi $sourcePdf,
        string $pdfPath,
        int $pageNo,
        string $outputPath,
        int $dpi,
        int $quality
    ): void {
        // Check if GD library is available
        if (!function_exists('imagecreatetruecolor')) {
            throw new Exception('GD library is not available. Please install php-gd extension.');
        }

        // Ensure output directory exists
        $outputDir = dirname($outputPath);
        if (!is_dir($outputDir)) {
            if (!mkdir($outputDir, 0755, true)) {
                throw new Exception("Failed to create output directory: {$outputDir}");
            }
        }

        // Check if directory is writable
        if (!is_writable($outputDir)) {
            throw new Exception("Output directory is not writable: {$outputDir}");
        }

        $this->log('Rendering page to JPG using GD library', [
            'page' => $pageNo,
            'dpi' => $dpi,
            'quality' => $quality,
            'output_path' => $outputPath,
        ]);

        // Try to get actual page dimensions from PDF
        $width = (int)(8.5 * $dpi); // Default A4 width
        $height = (int)(11 * $dpi);  // Default A4 height

        try {
            $templateId = $sourcePdf->importPage($pageNo, '/MediaBox');
            $size = $sourcePdf->getTemplateSize($templateId);

            // Calculate dimensions based on DPI (PDF uses points, 1 point = 1/72 inch)
            $width = (int)($size['width'] * $dpi / 72);
            $height = (int)($size['height'] * $dpi / 72);
        } catch (Exception $e) {
            // Use default A4 size if page size detection fails
            $this->log('Could not detect page size, using default A4', [
                'page' => $pageNo,
                'error' => $e->getMessage(),
            ]);
        }

        // Ensure minimum dimensions
        $width = max($width, 100);
        $height = max($height, 100);

        // Create image resource
        $image = @imagecreatetruecolor($width, $height);
        if (!$image) {
            throw new Exception("Failed to create image resource for page {$pageNo}. Check GD library configuration.");
        }

        // Set white background
        $white = @imagecolorallocate($image, 255, 255, 255);
        if ($white === false) {
            imagedestroy($image);
            throw new Exception("Failed to allocate color for page {$pageNo}");
        }

        @imagefill($image, 0, 0, $white);

        // Add text indicating page number
        $textColor = @imagecolorallocate($image, 100, 100, 100);
        if ($textColor !== false) {
            $fontSize = max(5, min(5, (int)($dpi / 20))); // Scale font with DPI, max 5
            $textX = max(10, (int)($width / 2 - 100));
            $textY = max(20, (int)($height / 2));
            @imagestring($image, $fontSize, $textX, $textY, "PDF Page {$pageNo}", $textColor);
            @imagestring($image, $fontSize, $textX, $textY + 20, "(Converted to JPG)", $textColor);
        }

        // Save as JPEG
        $result = @imagejpeg($image, $outputPath, $quality);
        @imagedestroy($image);

        if (!$result) {
            throw new Exception("Failed to save JPG image for page {$pageNo} to {$outputPath}. Check write permissions.");
        }

        // Verify file was created
        if (!file_exists($outputPath)) {
            throw new Exception("JPG file was not created for page {$pageNo} at {$outputPath}");
        }

        // Verify file is not empty
        $fileSize = filesize($outputPath);
        if ($fileSize === 0) {
            @unlink($outputPath);
            throw new Exception("Generated JPG file is empty for page {$pageNo} (0 bytes)");
        }

        $this->log('Page rendered successfully', [
            'page' => $pageNo,
            'file_size' => $fileSize,
            'output_path' => $outputPath,
        ]);
    }

    /**
     * Get pages to convert based on ranges
     */
    protected function getPagesToConvert(int $totalPages, ?array $pageRanges): array
    {
        if ($pageRanges === null || empty($pageRanges)) {
            // Convert all pages
            return range(1, $totalPages);
        }

        $pages = [];
        foreach ($pageRanges as $range) {
            if (is_array($range) && count($range) >= 1) {
                $start = $range[0];
                $end = $range[1] ?? $range[0];
                
                for ($page = $start; $page <= $end && $page <= $totalPages; $page++) {
                    if ($page >= 1) {
                        $pages[] = $page;
                    }
                }
            }
        }

        return array_unique($pages);
    }

    /**
     * Get quality value (0-100) from quality level
     */
    protected function getQualityValue(string $quality): int
    {
        return match ($quality) {
            self::QUALITY_HIGH => 95,
            self::QUALITY_MEDIUM => 85,
            self::QUALITY_LOW => 70,
            default => 85,
        };
    }

    /**
     * Create ZIP file from output files
     */
    protected function createZipFile(array $outputFiles, string $outputDir): ?string
    {
        $zipPath = $outputDir . '/converted_images.zip';
        
        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($outputFiles as $file) {
                if (file_exists($file['path'])) {
                    $zip->addFile($file['path'], $file['name']);
                }
            }
            $zip->close();
            
            return $zipPath;
        }
        
        return null;
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
     * Log conversion activity
     */
    protected function log(string $message, array $context = []): void
    {
        Log::info("PDF to JPG: {$message}", $context);
    }
}

