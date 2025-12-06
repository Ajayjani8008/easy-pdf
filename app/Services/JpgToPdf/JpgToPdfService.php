<?php

namespace App\Services\JpgToPdf;

use setasign\Fpdi\Fpdi;
use Exception;
use Illuminate\Support\Facades\Log;

class JpgToPdfService
{
    protected int $maxFileSize = 50 * 1024 * 1024; // 50MB per image

    // Page sizes (in mm)
    const PAGE_SIZE_A4 = 'a4';
    const PAGE_SIZE_LETTER = 'letter';
    const PAGE_SIZE_ORIGINAL = 'original';
    const PAGE_SIZE_CUSTOM = 'custom';

    // Orientations
    const ORIENTATION_PORTRAIT = 'portrait';
    const ORIENTATION_LANDSCAPE = 'landscape';

    // Fit modes
    const FIT_FIT = 'fit';           // Fit to page (maintains aspect ratio)
    const FIT_FILL = 'fill';         // Fill page (crop if needed)
    const FIT_ORIGINAL = 'original'; // Original size

    // Margin presets
    const MARGIN_NONE = 'none';
    const MARGIN_SMALL = 'small';
    const MARGIN_MEDIUM = 'medium';
    const MARGIN_CUSTOM = 'custom';

    // Compression levels
    const COMPRESSION_HIGH = 'high';
    const COMPRESSION_BALANCED = 'balanced';
    const COMPRESSION_SMALL = 'small';

    /**
     * Convert images to PDF
     *
     * @param array $imagePaths Array of image file paths
     * @param string $outputPath Path where PDF should be saved
     * @param array $options Conversion options
     * @return array Metadata about the conversion
     * @throws Exception If conversion fails
     */
    public function convert(array $imagePaths, string $outputPath, array $options = []): array
    {
        if (empty($imagePaths)) {
            throw new Exception('No images provided for conversion.');
        }

        // Validate all images
        foreach ($imagePaths as $imagePath) {
            $this->validateImage($imagePath);
        }

        // Set default options
        $pageSize = $options['page_size'] ?? self::PAGE_SIZE_A4;
        $orientation = $options['orientation'] ?? self::ORIENTATION_PORTRAIT;
        $fitMode = $options['fit_mode'] ?? self::FIT_FIT;
        $margin = $options['margin'] ?? self::MARGIN_SMALL;
        $customMargin = $options['custom_margin'] ?? 10; // mm
        $customWidth = $options['custom_width'] ?? null; // mm
        $customHeight = $options['custom_height'] ?? null; // mm
        $compression = $options['compression'] ?? self::COMPRESSION_BALANCED;

        try {
            $pdf = new Fpdi();

            foreach ($imagePaths as $index => $imagePath) {
                // Get image dimensions
                $imageInfo = $this->getImageInfo($imagePath);
                if (!$imageInfo) {
                    throw new Exception("Failed to read image: {$imagePath}");
                }

                // Calculate page dimensions
                $pageDimensions = $this->calculatePageDimensions(
                    $imageInfo,
                    $pageSize,
                    $orientation,
                    $customWidth,
                    $customHeight
                );

                // Calculate margins
                $margins = $this->calculateMargins($margin, $customMargin);

                // Add page with calculated dimensions
                $pdf->AddPage(
                    $orientation === self::ORIENTATION_LANDSCAPE ? 'L' : 'P',
                    [$pageDimensions['width'], $pageDimensions['height']]
                );

                // Calculate image position and size based on fit mode
                $imagePosition = $this->calculateImagePosition(
                    $imageInfo,
                    $pageDimensions,
                    $margins,
                    $fitMode
                );

                // Insert image
                $pdf->Image(
                    $imagePath,
                    $imagePosition['x'],
                    $imagePosition['y'],
                    $imagePosition['width'],
                    $imagePosition['height']
                );
            }

            // Save PDF
            $pdf->Output('F', $outputPath);

            if (!file_exists($outputPath)) {
                throw new Exception('PDF file was not created.');
            }

            $this->log('Images converted to PDF successfully', [
                'image_count' => count($imagePaths),
                'output_path' => $outputPath,
                'file_size' => filesize($outputPath),
            ]);

            return [
                'file_path' => $outputPath,
                'file_size' => filesize($outputPath),
                'page_count' => count($imagePaths),
                'image_count' => count($imagePaths),
                'converted_at' => now()->toIso8601String(),
            ];

        } catch (Exception $e) {
            $this->log('Image to PDF conversion failed', [
                'error' => $e->getMessage(),
                'image_count' => count($imagePaths),
            ]);
            throw new Exception('Conversion failed: ' . $e->getMessage());
        }
    }

    /**
     * Get image information (dimensions, type)
     */
    protected function getImageInfo(string $imagePath): ?array
    {
        if (!file_exists($imagePath) || !is_readable($imagePath)) {
            return null;
        }

        $imageInfo = @getimagesize($imagePath);
        if (!$imageInfo) {
            return null;
        }

        return [
            'width' => $imageInfo[0],
            'height' => $imageInfo[1],
            'type' => $imageInfo[2], // IMAGETYPE_JPEG, IMAGETYPE_PNG, etc.
            'mime' => $imageInfo['mime'],
        ];
    }

    /**
     * Calculate page dimensions based on options
     */
    protected function calculatePageDimensions(
        array $imageInfo,
        string $pageSize,
        string $orientation,
        ?float $customWidth = null,
        ?float $customHeight = null
    ): array {
        $width = 210; // Default A4 width in mm
        $height = 297; // Default A4 height in mm

        switch ($pageSize) {
            case self::PAGE_SIZE_A4:
                $width = 210;
                $height = 297;
                break;

            case self::PAGE_SIZE_LETTER:
                $width = 216; // 8.5 inches = 216mm
                $height = 279; // 11 inches = 279mm
                break;

            case self::PAGE_SIZE_ORIGINAL:
                // Use image dimensions (convert pixels to mm at 72 DPI)
                $width = ($imageInfo['width'] / 72) * 25.4;
                $height = ($imageInfo['height'] / 72) * 25.4;
                break;

            case self::PAGE_SIZE_CUSTOM:
                if ($customWidth && $customHeight) {
                    $width = (float)$customWidth;
                    $height = (float)$customHeight;
                }
                break;
        }

        // Swap dimensions for landscape
        if ($orientation === self::ORIENTATION_LANDSCAPE) {
            $temp = $width;
            $width = $height;
            $height = $temp;
        }

        return [
            'width' => $width,
            'height' => $height,
        ];
    }

    /**
     * Calculate margins
     */
    protected function calculateMargins(string $margin, float $customMargin): array
    {
        $marginValue = 0;

        switch ($margin) {
            case self::MARGIN_NONE:
                $marginValue = 0;
                break;
            case self::MARGIN_SMALL:
                $marginValue = 5; // 5mm
                break;
            case self::MARGIN_MEDIUM:
                $marginValue = 10; // 10mm
                break;
            case self::MARGIN_CUSTOM:
                $marginValue = $customMargin;
                break;
        }

        return [
            'top' => $marginValue,
            'right' => $marginValue,
            'bottom' => $marginValue,
            'left' => $marginValue,
        ];
    }

    /**
     * Calculate image position and size based on fit mode
     */
    protected function calculateImagePosition(
        array $imageInfo,
        array $pageDimensions,
        array $margins,
        string $fitMode
    ): array {
        $availableWidth = $pageDimensions['width'] - $margins['left'] - $margins['right'];
        $availableHeight = $pageDimensions['height'] - $margins['top'] - $margins['bottom'];

        // Convert image dimensions from pixels to mm (assuming 72 DPI)
        $imageWidthMm = ($imageInfo['width'] / 72) * 25.4;
        $imageHeightMm = ($imageInfo['height'] / 72) * 25.4;

        $imageAspectRatio = $imageWidthMm / $imageHeightMm;
        $availableAspectRatio = $availableWidth / $availableHeight;

        $x = $margins['left'];
        $y = $margins['top'];
        $width = $availableWidth;
        $height = $availableHeight;

        switch ($fitMode) {
            case self::FIT_FIT:
                // Fit to page maintaining aspect ratio
                if ($imageAspectRatio > $availableAspectRatio) {
                    // Image is wider, fit to width
                    $width = $availableWidth;
                    $height = $availableWidth / $imageAspectRatio;
                } else {
                    // Image is taller, fit to height
                    $height = $availableHeight;
                    $width = $availableHeight * $imageAspectRatio;
                }
                // Center the image
                $x = $margins['left'] + ($availableWidth - $width) / 2;
                $y = $margins['top'] + ($availableHeight - $height) / 2;
                break;

            case self::FIT_FILL:
                // Fill page (may crop)
                if ($imageAspectRatio > $availableAspectRatio) {
                    // Image is wider, fill height and crop width
                    $height = $availableHeight;
                    $width = $availableHeight * $imageAspectRatio;
                    $x = $margins['left'] - ($width - $availableWidth) / 2;
                } else {
                    // Image is taller, fill width and crop height
                    $width = $availableWidth;
                    $height = $availableWidth / $imageAspectRatio;
                    $y = $margins['top'] - ($height - $availableHeight) / 2;
                }
                break;

            case self::FIT_ORIGINAL:
                // Use original size
                $width = $imageWidthMm;
                $height = $imageHeightMm;
                // Center if smaller than available space
                if ($width < $availableWidth) {
                    $x = $margins['left'] + ($availableWidth - $width) / 2;
                }
                if ($height < $availableHeight) {
                    $y = $margins['top'] + ($availableHeight - $height) / 2;
                }
                break;
        }

        return [
            'x' => $x,
            'y' => $y,
            'width' => $width,
            'height' => $height,
        ];
    }

    /**
     * Validate image file
     */
    protected function validateImage(string $imagePath): bool
    {
        if (!file_exists($imagePath)) {
            throw new Exception('Image file not found: ' . $imagePath);
        }

        if (!is_readable($imagePath)) {
            throw new Exception('Image file is not readable: ' . $imagePath);
        }

        $fileSize = filesize($imagePath);
        if ($fileSize > $this->maxFileSize) {
            throw new Exception('Image file size exceeds maximum allowed size (50MB): ' . $imagePath);
        }

        // Check if file is a valid image
        $imageInfo = @getimagesize($imagePath);
        if (!$imageInfo) {
            throw new Exception('File is not a valid image: ' . $imagePath);
        }

        // Check supported formats
        $allowedTypes = [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF];
        // WebP support check (IMAGETYPE_WEBP may not be available in all PHP versions)
        if (defined('IMAGETYPE_WEBP')) {
            $allowedTypes[] = IMAGETYPE_WEBP;
        }
        if (!in_array($imageInfo[2], $allowedTypes)) {
            $supported = 'JPG, PNG, GIF';
            if (defined('IMAGETYPE_WEBP')) {
                $supported .= ', WebP';
            }
            throw new Exception("Unsupported image format. Supported: {$supported}");
        }

        return true;
    }

    /**
     * Log conversion activity
     */
    protected function log(string $message, array $context = []): void
    {
        Log::info("JPG to PDF: {$message}", $context);
    }
}

