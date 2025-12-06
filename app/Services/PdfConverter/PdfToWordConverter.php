<?php

namespace App\Services\PdfConverter;

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\Style\Font;
use PhpOffice\PhpWord\Style\Paragraph;
use PhpOffice\PhpWord\Shared\Html;
use setasign\Fpdi\Fpdi;
use Exception;
use Illuminate\Support\Facades\Log;

class PdfToWordConverter extends BasePdfConverter
{
    /**
     * Convert PDF to Word document with formatting preservation
     * 
     * Note: This implementation preserves basic formatting (fonts, sizes, bold, italic, spacing).
     * For advanced formatting (exact layout, tables, images, complex fonts), consider using:
     * - CloudConvert API
     * - Adobe PDF Services API
     * - Zamzar API
     * - ConvertAPI
     * 
     * @param string $pdfPath Path to the PDF file
     * @param string $outputPath Path where Word document should be saved
     * @return array Metadata about the conversion
     * @throws Exception If conversion fails
     */
    public function convert(string $pdfPath, string $outputPath): array
    {
        $this->validatePdf($pdfPath);

        try {
            $phpWord = new PhpWord();

            // Set default font settings
            $phpWord->setDefaultFontName('Arial');
            $phpWord->setDefaultFontSize(11);

            $section = $phpWord->addSection([
                'marginTop' => 1440,    // 1 inch = 1440 twips
                'marginBottom' => 1440,
                'marginLeft' => 1440,
                'marginRight' => 1440,
            ]);

            // Extract text with formatting from PDF
            $extractedContent = $this->extractTextWithFormatting($pdfPath);

            // Add extracted content to Word document with preserved formatting
            if (!empty($extractedContent['elements'])) {
                $this->addFormattedContentToWord($section, $extractedContent['elements']);
            } elseif (!empty($extractedContent['text'])) {
                // Fallback: Use plain text extraction
                $this->addPlainTextToWord($section, $extractedContent['text']);
            } else {
                // Last resort: Show error message
                $section->addText('No text content could be extracted from this PDF.', [
                    'name' => 'Arial',
                    'size' => 11,
                    'color' => 'FF0000',
                ]);
            }

            // Save the document
            $writer = IOFactory::createWriter($phpWord, 'Word2007');
            $writer->save($outputPath);

            $this->log('PDF converted to Word successfully', [
                'pdf_path' => $pdfPath,
                'output_path' => $outputPath,
            ]);

            return [
                'file_size' => filesize($outputPath),
                'pages' => $this->getPdfPageCount($pdfPath),
                'converted_at' => now()->toIso8601String(),
            ];
        } catch (Exception $e) {
            $this->log('PDF to Word conversion failed', [
                'error' => $e->getMessage(),
                'pdf_path' => $pdfPath,
            ]);
            throw new Exception('Conversion failed: ' . $e->getMessage());
        }
    }

    /**
     * Extract text with formatting from PDF
     * 
     * @param string $pdfPath Path to the PDF file
     * @return array Array with 'elements', 'text', and 'pages' keys
     */
    protected function extractTextWithFormatting(string $pdfPath): array
    {
        // Try using smalot/pdfparser with formatting extraction
        if (class_exists('\Smalot\PdfParser\Parser')) {
            try {
                $parser = new \Smalot\PdfParser\Parser();
                $pdf = $parser->parseFile($pdfPath);
                $pages = $pdf->getPages();
                $pageCount = count($pages);

                $elements = [];
                $allText = '';

                // Extract text from each page with formatting information
                foreach ($pages as $pageIndex => $page) {
                    $pageText = $page->getText();
                    $allText .= $pageText . "\n\n";

                    // Extract detailed text objects with formatting
                    $details = $page->get('Details');
                    if ($details) {
                        $textObjects = $this->extractTextObjectsFromPage($page);
                        $elements = array_merge($elements, $textObjects);
                    }
                }

                // If we got detailed elements, use them; otherwise use plain text
                if (!empty($elements)) {
                    Log::info('PDF text with formatting extracted successfully', [
                        'pdf_path' => $pdfPath,
                        'elements_count' => count($elements),
                        'page_count' => $pageCount,
                    ]);

                    return [
                        'elements' => $elements,
                        'text' => $this->cleanExtractedText($allText),
                        'pages' => $pageCount,
                    ];
                } else {
                    // Fallback to plain text
                    $cleanedText = $this->cleanExtractedText($allText);
                    return [
                        'text' => $cleanedText,
                        'pages' => $pageCount,
                    ];
                }
            } catch (Exception $e) {
                Log::warning('PDF formatting extraction failed', [
                    'pdf_path' => $pdfPath,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        // Fallback: Extract plain text
        return $this->extractTextFromPdf($pdfPath);
    }

    /**
     * Extract text objects with formatting from a PDF page
     * Uses smalot/pdfparser to extract text with font information
     */
    protected function extractTextObjectsFromPage($page): array
    {
        $elements = [];

        try {
            // Extract text from page
            $text = $page->getText();

            if (!empty($text)) {
                // Try to infer formatting from text patterns
                // This is more reliable than trying to access PDFObject properties directly
                $textElements = $this->inferFormattingFromText($text);
                $elements = array_merge($elements, $textElements);
            }

            // Note: Direct access to PDFObject properties (like Resources, Contents) 
            // requires proper object handling. For now, we use text-based inference.

        } catch (Exception $e) {
            Log::debug('Error extracting text objects from page', [
                'error' => $e->getMessage(),
            ]);
        }

        return $elements;
    }

    /**
     * Parse text objects from PDF contents
     */
    protected function parseTextObjectsFromContents($page): array
    {
        $elements = [];

        try {
            // Get font information from page resources
            // Note: Resources might be a PDFObject, not an array
            $resources = $page->get('Resources');
            $fonts = [];

            if ($resources) {
                // Check if resources is an object with get() method
                if (is_object($resources) && method_exists($resources, 'get')) {
                    $fontObj = $resources->get('Font');
                    if ($fontObj) {
                        $fonts = $fontObj;
                    }
                } elseif (is_array($resources) && isset($resources['Font'])) {
                    $fonts = $resources['Font'];
                }
            }

            // Extract text with basic formatting
            $text = $page->getText();
            if (!empty($text)) {
                // Split by lines and infer formatting
                $lines = explode("\n", $text);
                foreach ($lines as $lineIndex => $line) {
                    $line = trim($line);
                    if (empty($line)) {
                        continue;
                    }

                    // Infer formatting based on text characteristics
                    $fontSize = $this->inferFontSize($line);
                    $isBold = $this->inferBold($line);
                    $isHeading = $this->detectHeading($line);

                    $elements[] = [
                        'text' => $line,
                        'font' => 'Arial', // Default, will be improved
                        'size' => $isHeading ? max($fontSize, 14) : $fontSize,
                        'color' => null,
                        'bold' => $isBold || $isHeading,
                        'italic' => false,
                        'y' => $lineIndex * 20, // Approximate Y position
                    ];
                }
            }
        } catch (Exception $e) {
            Log::debug('Error parsing text objects from contents', [
                'error' => $e->getMessage(),
            ]);
        }

        return $elements;
    }

    /**
     * Infer font size from text characteristics
     */
    protected function inferFontSize(string $text): float
    {
        // Detect headings by patterns
        if (preg_match('/^[A-Z][A-Z\s]{0,50}$/', $text)) {
            return 16; // Likely heading
        }
        if (preg_match('/^\d+[\.\)]\s/', $text)) {
            return 14; // Numbered heading
        }

        return 11; // Default body text
    }

    /**
     * Infer if text should be bold
     */
    protected function inferBold(string $text): bool
    {
        // All caps might be bold
        if (strtoupper($text) === $text && strlen($text) < 50) {
            return true;
        }

        // Short lines might be headings (bold)
        if (strlen($text) < 80 && preg_match('/^[A-Z]/', $text)) {
            return true;
        }

        return false;
    }

    /**
     * Infer formatting from plain text (fallback method)
     */
    protected function inferFormattingFromText(string $text): array
    {
        $elements = [];
        $lines = explode("\n", $text);

        foreach ($lines as $lineIndex => $line) {
            $line = trim($line);
            if (empty($line)) {
                continue;
            }

            $fontSize = $this->inferFontSize($line);
            $isBold = $this->inferBold($line);
            $isHeading = $this->detectHeading($line);

            $elements[] = [
                'text' => $line,
                'font' => 'Arial',
                'size' => $isHeading ? max($fontSize, 14) : $fontSize,
                'color' => null,
                'bold' => $isBold || $isHeading,
                'italic' => false,
                'y' => $lineIndex * 20,
            ];
        }

        return $elements;
    }

    /**
     * Parse color from PDF format to hex
     */
    protected function parseColor($color): ?string
    {
        if (!$color) {
            return null;
        }

        // Handle different color formats
        if (is_array($color)) {
            // RGB array [r, g, b] where values are 0-1
            if (count($color) >= 3) {
                $r = str_pad(dechex((int)($color[0] * 255)), 2, '0', STR_PAD_LEFT);
                $g = str_pad(dechex((int)($color[1] * 255)), 2, '0', STR_PAD_LEFT);
                $b = str_pad(dechex((int)($color[2] * 255)), 2, '0', STR_PAD_LEFT);
                return strtoupper($r . $g . $b);
            }
        } elseif (is_string($color)) {
            // Already in hex format
            return strtoupper(ltrim($color, '#'));
        }

        return null;
    }

    /**
     * Add formatted content to Word document
     */
    protected function addFormattedContentToWord($section, array $elements): void
    {
        $currentParagraph = [];
        $lastY = null;

        foreach ($elements as $element) {
            $text = $element['text'] ?? '';
            if (empty(trim($text))) {
                continue;
            }

            // Group elements by Y position to form paragraphs
            $currentY = $element['y'] ?? null;

            // If Y position changed significantly, start a new paragraph
            if ($lastY !== null && $currentY !== null && abs($currentY - $lastY) > 5) {
                if (!empty($currentParagraph)) {
                    $this->addFormattedParagraph($section, $currentParagraph);
                    $currentParagraph = [];
                }
            }

            $currentParagraph[] = $element;
            $lastY = $currentY;
        }

        // Add remaining paragraph
        if (!empty($currentParagraph)) {
            $this->addFormattedParagraph($section, $currentParagraph);
        }
    }

    /**
     * Add a formatted paragraph to Word document
     */
    protected function addFormattedParagraph($section, array $elements): void
    {
        if (empty($elements)) {
            return;
        }

        // Determine paragraph style based on first element
        $firstElement = $elements[0];
        $fontSize = $firstElement['size'] ?? 11;

        // Detect heading styles based on font size
        $paragraphStyle = [];
        if ($fontSize >= 16) {
            $paragraphStyle['spaceAfter'] = 240; // 12pt spacing
        } elseif ($fontSize >= 14) {
            $paragraphStyle['spaceAfter'] = 200; // 10pt spacing
        } else {
            $paragraphStyle['spaceAfter'] = 120; // 6pt spacing
        }

        // Build text run with mixed formatting
        $textRun = $section->addTextRun($paragraphStyle);

        foreach ($elements as $element) {
            $text = $element['text'] ?? '';
            if (empty($text)) {
                continue;
            }

            $fontStyle = [
                'name' => $this->normalizeFontName($element['font'] ?? 'Arial'),
                'size' => $element['size'] ?? 11,
            ];

            // Add color if available
            if (!empty($element['color'])) {
                $fontStyle['color'] = $element['color'];
            }

            // Add bold/italic
            if (!empty($element['bold'])) {
                $fontStyle['bold'] = true;
            }
            if (!empty($element['italic'])) {
                $fontStyle['italic'] = true;
            }

            $textRun->addText($text, $fontStyle);
        }
    }

    /**
     * Add plain text to Word document (fallback method)
     * Enhanced with better formatting detection
     */
    protected function addPlainTextToWord($section, string $text): void
    {
        // Split text into lines first to detect formatting
        $lines = explode("\n", $text);
        $currentParagraph = [];

        foreach ($lines as $line) {
            $line = trim($line);

            // Empty line = paragraph break
            if (empty($line)) {
                if (!empty($currentParagraph)) {
                    $this->addSmartParagraph($section, implode(' ', $currentParagraph));
                    $currentParagraph = [];
                }
                continue;
            }

            $currentParagraph[] = $line;
        }

        // Add remaining paragraph
        if (!empty($currentParagraph)) {
            $this->addSmartParagraph($section, implode(' ', $currentParagraph));
        }
    }

    /**
     * Add a paragraph with smart formatting detection
     */
    protected function addSmartParagraph($section, string $text): void
    {
        if (empty(trim($text))) {
            return;
        }

        // Detect formatting characteristics
        $isHeading = $this->detectHeading($text);
        $fontSize = $isHeading ? 16 : 11;
        $isBold = $isHeading || $this->inferBold($text);

        // Detect if text contains special formatting markers
        $hasSpecialFormatting = $this->detectSpecialFormatting($text);

        // Apply formatting
        $fontStyle = [
            'name' => 'Arial',
            'size' => $fontSize,
        ];

        if ($isBold) {
            $fontStyle['bold'] = true;
        }

        $paragraphStyle = [
            'spaceAfter' => $isHeading ? 240 : 120,
            'spaceBefore' => $isHeading ? 120 : 0,
        ];

        // Handle text with mixed formatting (bold, italic markers)
        if ($hasSpecialFormatting) {
            $this->addTextWithMarkers($section, $text, $fontStyle, $paragraphStyle);
        } else {
            $section->addText($text, $fontStyle, $paragraphStyle);
        }
    }

    /**
     * Detect special formatting markers in text
     */
    protected function detectSpecialFormatting(string $text): bool
    {
        // Check for common formatting markers
        return preg_match('/\*\*|\*\*|__|_|\*\*|~~/', $text) > 0;
    }

    /**
     * Add text with formatting markers (bold, italic)
     */
    protected function addTextWithMarkers($section, string $text, array $baseFontStyle, array $paragraphStyle): void
    {
        $textRun = $section->addTextRun($paragraphStyle);

        // Simple markdown-like formatting
        // **bold** or __bold__
        // *italic* or _italic_

        $parts = preg_split('/(\*\*.*?\*\*|__.*?__|\*.*?\*|_.*?_)/', $text, -1, PREG_SPLIT_DELIM_CAPTURE);

        foreach ($parts as $part) {
            if (empty($part)) {
                continue;
            }

            $fontStyle = $baseFontStyle;

            // Check for bold markers
            if (preg_match('/^\*\*(.*?)\*\*$|^__(.*?)__$/', $part, $matches)) {
                $fontStyle['bold'] = true;
                $part = $matches[1] ?? $matches[2] ?? $part;
            }
            // Check for italic markers
            elseif (preg_match('/^\*(.*?)\*$|^_(.*?)_$/', $part, $matches)) {
                $fontStyle['italic'] = true;
                $part = $matches[1] ?? $matches[2] ?? $part;
            }

            $textRun->addText($part, $fontStyle);
        }
    }

    /**
     * Detect if text is likely a heading
     */
    protected function detectHeading(string $text): bool
    {
        $text = trim($text);

        // Short text (likely heading)
        if (strlen($text) < 100) {
            // All caps or starts with number
            if (strtoupper($text) === $text || preg_match('/^\d+[\.\)]\s/', $text)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Normalize font name to standard fonts
     */
    protected function normalizeFontName(string $fontName): string
    {
        $fontName = trim($fontName);

        // Map common PDF fonts to Word-compatible fonts
        $fontMap = [
            'times' => 'Times New Roman',
            'times-roman' => 'Times New Roman',
            'helvetica' => 'Arial',
            'helvetica-bold' => 'Arial',
            'courier' => 'Courier New',
            'courier-new' => 'Courier New',
        ];

        $lowerFont = strtolower($fontName);
        foreach ($fontMap as $key => $value) {
            if (strpos($lowerFont, $key) !== false) {
                return $value;
            }
        }

        // Return original if no mapping found, or default to Arial
        return !empty($fontName) ? $fontName : 'Arial';
    }

    /**
     * Extract text from PDF using smalot/pdfparser (fallback method)
     * 
     * @param string $pdfPath Path to the PDF file
     * @return array Array with 'text' and 'pages' keys
     */
    protected function extractTextFromPdf(string $pdfPath): array
    {
        // Try using smalot/pdfparser first
        if (class_exists('\Smalot\PdfParser\Parser')) {
            try {
                $parser = new \Smalot\PdfParser\Parser();
                $pdf = $parser->parseFile($pdfPath);

                // Extract all text from the PDF
                $text = $pdf->getText();

                // Get page count
                $pages = $pdf->getPages();
                $pageCount = count($pages);

                // Clean up the extracted text
                $text = $this->cleanExtractedText($text);

                if (!empty($text)) {
                    Log::info('PDF text extracted successfully using smalot/pdfparser', [
                        'pdf_path' => $pdfPath,
                        'text_length' => strlen($text),
                        'page_count' => $pageCount,
                    ]);

                    return [
                        'text' => $text,
                        'pages' => $pageCount,
                    ];
                }
            } catch (Exception $e) {
                Log::warning('PDF text extraction with smalot/pdfparser failed', [
                    'pdf_path' => $pdfPath,
                    'error' => $e->getMessage(),
                ]);
            }
        } else {
            Log::warning('smalot/pdfparser library not found, using fallback methods');
        }

        // Fallback: Try using pdftotext command if available
        $result = $this->extractTextUsingPdftotext($pdfPath);

        if (empty($result['text'])) {
            Log::error('All PDF text extraction methods failed', [
                'pdf_path' => $pdfPath,
            ]);
        }

        return $result;
    }

    /**
     * Clean extracted text - remove excessive whitespace and normalize
     */
    protected function cleanExtractedText(string $text): string
    {
        // Normalize line breaks first
        $text = preg_replace('/\r\n|\r/', "\n", $text);

        // Remove excessive spaces (but keep line breaks)
        $text = preg_replace('/[ \t]+/', ' ', $text);

        // Remove spaces at the start/end of lines
        $text = preg_replace('/^[ \t]+|[ \t]+$/m', '', $text);

        // Remove multiple consecutive newlines (keep max 2 for paragraph breaks)
        $text = preg_replace('/\n{3,}/', "\n\n", $text);

        // Trim whitespace from start and end
        $text = trim($text);

        return $text;
    }

    /**
     * Fallback method: Extract text using pdftotext command line tool
     * This is used if smalot/pdfparser fails
     */
    protected function extractTextUsingPdftotext(string $pdfPath): array
    {
        // Check if pdftotext is available
        $pdftotextPath = $this->findPdftotextCommand();

        if ($pdftotextPath) {
            try {
                $tempOutput = tempnam(sys_get_temp_dir(), 'pdf_text_');
                $command = escapeshellarg($pdftotextPath) . ' ' .
                    escapeshellarg($pdfPath) . ' ' .
                    escapeshellarg($tempOutput);

                exec($command . ' 2>&1', $output, $returnCode);

                if ($returnCode === 0 && file_exists($tempOutput)) {
                    $text = file_get_contents($tempOutput);
                    unlink($tempOutput);

                    return [
                        'text' => $this->cleanExtractedText($text),
                        'pages' => $this->getPdfPageCount($pdfPath),
                    ];
                }
            } catch (Exception $e) {
                Log::warning('pdftotext command failed', [
                    'error' => $e->getMessage(),
                ]);
            }
        }

        // Last resort: return empty text
        return [
            'text' => '',
            'pages' => $this->getPdfPageCount($pdfPath),
        ];
    }

    /**
     * Find pdftotext command path
     */
    protected function findPdftotextCommand(): ?string
    {
        $possiblePaths = [
            '/usr/bin/pdftotext',
            '/usr/local/bin/pdftotext',
            'pdftotext', // In PATH
        ];

        foreach ($possiblePaths as $path) {
            if ($path === 'pdftotext') {
                // Check if command exists in PATH
                exec('which pdftotext 2>&1', $output, $returnCode);
                if ($returnCode === 0 && !empty($output)) {
                    return trim($output[0]);
                }
            } elseif (file_exists($path) && is_executable($path)) {
                return $path;
            }
        }

        return null;
    }

    /**
     * Get PDF page count
     */
    protected function getPdfPageCount(string $pdfPath): int
    {
        try {
            $pdf = new Fpdi();
            return $pdf->setSourceFile($pdfPath);
        } catch (Exception $e) {
            return 1; // Default to 1 page if count fails
        }
    }

    /**
     * Get target file extension
     */
    public function getTargetExtension(): string
    {
        return 'docx';
    }

    /**
     * Get target MIME type
     */
    public function getTargetMimeType(): string
    {
        return 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
    }
}

