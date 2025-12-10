<?php

namespace App\Services\PdfConverter;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use setasign\Fpdi\Fpdi;
use Exception;
use Illuminate\Support\Facades\Log;

class PdfToExcelConverter extends BasePdfConverter
{
    /**
     * Convert PDF to Excel with table detection and extraction
     * 
     * @param string $pdfPath Path to the PDF file
     * @param string $outputPath Path where Excel file should be saved
     * @param array $options Conversion options:
     *   - extraction_mode: 'automatic', 'manual', 'entire_page' (default: 'automatic')
     *   - pages: array of page numbers or 'all' (default: 'all')
     *   - output_format: 'xlsx', 'csv' (default: 'xlsx')
     *   - keep_formatting: bool (default: true)
     *   - merge_headers: bool (default: true)
     *   - detect_dates: bool (default: true)
     *   - detect_currency: bool (default: true)
     *   - remove_empty_rows: bool (default: true)
     *   - remove_empty_columns: bool (default: true)
     *   - ocr_enabled: bool (default: false)
     *   - ocr_language: string (default: 'eng')
     * @return array Metadata about the conversion
     * @throws Exception If conversion fails
     */
    public function convert(string $pdfPath, string $outputPath, array $options = []): array
    {
        $this->validatePdf($pdfPath);

        // Set default options
        $options = array_merge([
            'extraction_mode' => 'automatic',
            'pages' => 'all',
            'output_format' => 'xlsx',
            'keep_formatting' => true,
            'merge_headers' => true,
            'detect_dates' => true,
            'detect_currency' => true,
            'remove_empty_rows' => true,
            'remove_empty_columns' => true,
            'ocr_enabled' => false,
            'ocr_language' => 'eng',
        ], $options);

        try {
            // Extract text/data from PDF
            $extractedData = $this->extractDataFromPdf($pdfPath, $options);
            
            // Create spreadsheet
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            // Process extracted data based on extraction mode
            if ($options['extraction_mode'] === 'automatic') {
                $this->processAutomaticExtraction($sheet, $extractedData, $options);
            } elseif ($options['extraction_mode'] === 'entire_page') {
                $this->processEntirePageExtraction($sheet, $extractedData, $options);
            } else {
                // Manual mode - similar to automatic but with user-selected area
                $this->processAutomaticExtraction($sheet, $extractedData, $options);
            }

            // Apply formatting if requested
            if ($options['keep_formatting']) {
                $this->applyFormatting($sheet, $options);
            }

            // Clean up empty rows/columns
            if ($options['remove_empty_rows']) {
                $this->removeEmptyRows($sheet);
            }
            if ($options['remove_empty_columns']) {
                $this->removeEmptyColumns($sheet);
            }

            // Save based on output format
            if ($options['output_format'] === 'csv') {
                $writer = new Csv($spreadsheet);
                $writer->setEnclosure('"');
                $writer->setDelimiter(',');
            } else {
                $writer = new Xlsx($spreadsheet);
            }
            
            $writer->save($outputPath);

            // Get statistics
            $stats = $this->getConversionStats($sheet);

            $this->log('PDF converted to Excel successfully', [
                'pdf_path' => $pdfPath,
                'output_path' => $outputPath,
                'format' => $options['output_format'],
                'rows' => $stats['rows'],
                'columns' => $stats['columns'],
            ]);

            return [
                'file_size' => filesize($outputPath),
                'pages' => $extractedData['pages'] ?? 1,
                'rows' => $stats['rows'],
                'columns' => $stats['columns'],
                'converted_at' => now()->toIso8601String(),
            ];
        } catch (Exception $e) {
            $this->log('PDF to Excel conversion failed', [
                'error' => $e->getMessage(),
                'pdf_path' => $pdfPath,
                'options' => $options,
            ]);
            throw new Exception('Conversion failed: ' . $e->getMessage());
        }
    }

    /**
     * Extract data from PDF
     */
    protected function extractDataFromPdf(string $pdfPath, array $options): array
    {
        // Get pages to process
        $pageNumbers = $this->getPageNumbers($pdfPath, $options['pages']);

        // Extract text from each page
        $allText = [];
        $pages = [];

        if (class_exists('\Smalot\PdfParser\Parser')) {
            try {
                $parser = new \Smalot\PdfParser\Parser();
                $pdf = $parser->parseFile($pdfPath);
                $pdfPages = $pdf->getPages();

                foreach ($pageNumbers as $pageNum) {
                    if (isset($pdfPages[$pageNum - 1])) {
                        $page = $pdfPages[$pageNum - 1];
                        $pageText = $page->getText();
                        $allText[] = $pageText;
                        $pages[] = $pageNum;
                    }
                }
            } catch (Exception $e) {
                Log::warning('PDF text extraction failed', [
                    'error' => $e->getMessage(),
                ]);
            }
        }

        // If OCR is enabled and no text found, try OCR
        if ($options['ocr_enabled'] && empty($allText)) {
            // Note: OCR implementation would require additional library (e.g., Tesseract)
            // For now, this is a placeholder
            Log::info('OCR requested but not implemented yet');
        }

        return [
            'text' => implode("\n\n", $allText),
            'pages' => $pages,
            'page_count' => count($pages),
        ];
    }

    /**
     * Get page numbers to process
     */
    protected function getPageNumbers(string $pdfPath, $pages): array
    {
        if ($pages === 'all') {
            $totalPages = $this->getPdfPageCount($pdfPath);
            return range(1, $totalPages);
        }

        if (is_array($pages)) {
            return $pages;
        }

        if (is_numeric($pages)) {
            return [(int)$pages];
        }

        // Parse range like "2-6"
        if (is_string($pages) && preg_match('/^(\d+)-(\d+)$/', $pages, $matches)) {
            return range((int)$matches[1], (int)$matches[2]);
        }

        // Default to all pages
        $totalPages = $this->getPdfPageCount($pdfPath);
        return range(1, $totalPages);
    }

    /**
     * Process automatic table detection and extraction
     */
    protected function processAutomaticExtraction($sheet, array $extractedData, array $options): void
    {
        $text = $extractedData['text'] ?? '';
        
        // Detect tables in text
        $tables = $this->detectTables($text);

        if (empty($tables)) {
            // No tables detected, treat as plain text
            $this->processPlainText($sheet, $text);
            return;
        }

        // Process each detected table
        $rowOffset = 1;
        foreach ($tables as $tableIndex => $table) {
            if ($tableIndex > 0) {
                // Add spacing between tables
                $rowOffset += 2;
            }

            // Process table rows
            foreach ($table as $rowIndex => $row) {
                foreach ($row as $colIndex => $cell) {
                    $cellValue = $this->processCellValue($cell, $options);
                    // Convert column index (0-based) to column letter (A, B, C, etc.)
                    $columnLetter = Coordinate::stringFromColumnIndex($colIndex + 1);
                    $rowNumber = $rowOffset + $rowIndex;
                    $sheet->setCellValue($columnLetter . $rowNumber, $cellValue);
                }
            }

            $rowOffset += count($table);
        }
    }

    /**
     * Process entire page extraction (page → rows → columns)
     */
    protected function processEntirePageExtraction($sheet, array $extractedData, array $options): void
    {
        $text = $extractedData['text'] ?? '';
        
        // Split text into lines
        $lines = explode("\n", $text);
        
        $row = 1;
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) {
                continue;
            }

            // Try to split line into columns (by tabs, multiple spaces, or delimiters)
            $columns = $this->splitIntoColumns($line);
            
            foreach ($columns as $colIndex => $cell) {
                $cellValue = $this->processCellValue($cell, $options);
                // Convert column index (0-based) to column letter (A, B, C, etc.)
                $columnLetter = Coordinate::stringFromColumnIndex($colIndex + 1);
                $sheet->setCellValue($columnLetter . $row, $cellValue);
            }
            
            $row++;
        }
    }

    /**
     * Detect tables in text
     */
    protected function detectTables(string $text): array
    {
        $tables = [];
        $lines = explode("\n", $text);

        $currentTable = [];
        $expectedColumns = null;

        foreach ($lines as $line) {
            $line = trim($line);
            
            // Skip empty lines
            if (empty($line)) {
                if (!empty($currentTable)) {
                    // End of table
                    $tables[] = $currentTable;
                    $currentTable = [];
                    $expectedColumns = null;
                }
                continue;
            }

            // Try to detect if line is part of a table
            $columns = $this->splitIntoColumns($line);
            
            if (count($columns) >= 2) {
                // Likely a table row
                if ($expectedColumns === null) {
                    $expectedColumns = count($columns);
                }
                
                // If column count matches, add to current table
                if (count($columns) === $expectedColumns || count($columns) >= 2) {
                    $currentTable[] = $columns;
                } else {
                    // Column count changed, save current table and start new one
                    if (!empty($currentTable)) {
                        $tables[] = $currentTable;
                    }
                    $currentTable = [$columns];
                    $expectedColumns = count($columns);
                }
            } else {
                // Not a table row, save current table if exists
                if (!empty($currentTable)) {
                    $tables[] = $currentTable;
                    $currentTable = [];
                    $expectedColumns = null;
                }
            }
        }

        // Save last table if exists
        if (!empty($currentTable)) {
            $tables[] = $currentTable;
        }

        return $tables;
    }

    /**
     * Split line into columns
     */
    protected function splitIntoColumns(string $line): array
    {
        // Try multiple delimiters
        // First try tabs
        if (strpos($line, "\t") !== false) {
            return array_map('trim', explode("\t", $line));
        }

        // Try multiple spaces (2+ spaces)
        if (preg_match('/\s{2,}/', $line)) {
            return preg_split('/\s{2,}/', $line);
        }

        // Try pipe delimiter
        if (strpos($line, '|') !== false) {
            return array_map('trim', explode('|', $line));
        }

        // Try comma (if not in quotes)
        if (strpos($line, ',') !== false && !preg_match('/".*".*".*"/', $line)) {
            return array_map('trim', explode(',', $line));
        }

        // Default: return as single column
        return [$line];
    }

    /**
     * Process cell value with intelligent detection
     */
    protected function processCellValue($value, array $options): mixed
    {
        // Handle null or non-string values
        if ($value === null || $value === '') {
            return '';
        }

        $value = trim((string)$value);

        // Detect numeric values
        if (is_numeric($value)) {
            return (float)$value;
        }

        // Detect dates
        if ($options['detect_dates']) {
            $date = $this->detectDate($value);
            if ($date) {
                return $date;
            }
        }

        // Detect currency
        if ($options['detect_currency']) {
            $currency = $this->detectCurrency($value);
            if ($currency !== null) {
                return $currency;
            }
        }

        return $value;
    }

    /**
     * Detect date in string
     */
    protected function detectDate(string $value): ?string
    {
        // Common date formats
        $formats = [
            'Y-m-d',
            'm/d/Y',
            'd/m/Y',
            'Y/m/d',
            'd-m-Y',
            'm-d-Y',
        ];

        foreach ($formats as $format) {
            $date = \DateTime::createFromFormat($format, $value);
            if ($date && $date->format($format) === $value) {
                return $date->format('Y-m-d');
            }
        }

        return null;
    }

    /**
     * Detect currency in string
     */
    protected function detectCurrency(string $value): ?float
    {
        // Remove currency symbols and extract number
        $cleaned = preg_replace('/[^\d.,-]/', '', $value);
        $cleaned = str_replace(',', '', $cleaned);
        
        if (is_numeric($cleaned)) {
            return (float)$cleaned;
        }

        return null;
    }

    /**
     * Process plain text (no tables detected)
     */
    protected function processPlainText($sheet, string $text): void
    {
        $lines = explode("\n", $text);
        $row = 1;

        foreach ($lines as $line) {
            $line = trim($line);
            if (!empty($line)) {
                $sheet->setCellValue('A' . $row, $line);
                $row++;
            }
        }
    }

    /**
     * Apply formatting to spreadsheet
     */
    protected function applyFormatting($sheet, array $options): void
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $highestColumnIndex = Coordinate::columnIndexFromString($highestColumn);

        // Apply borders
        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'CCCCCC'],
                ],
            ],
        ];

        $sheet->getStyle('A1:' . $highestColumn . $highestRow)->applyFromArray($borderStyle);

        // Format header row (if exists)
        if ($highestRow > 0) {
            $headerStyle = [
                'font' => [
                    'bold' => true,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E0E0E0'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
            ];

            $sheet->getStyle('A1:' . $highestColumn . '1')->applyFromArray($headerStyle);
        }

        // Auto-size columns
        for ($col = 1; $col <= $highestColumnIndex; $col++) {
            $sheet->getColumnDimensionByColumn($col)->setAutoSize(true);
        }
    }

    /**
     * Remove empty rows
     */
    protected function removeEmptyRows($sheet): void
    {
        $highestRow = $sheet->getHighestRow();

        for ($row = $highestRow; $row >= 1; $row--) {
            $isEmpty = true;
            $highestColumn = $sheet->getHighestColumn();
            $highestColumnIndex = Coordinate::columnIndexFromString($highestColumn);

            for ($col = 1; $col <= $highestColumnIndex; $col++) {
                $columnLetter = Coordinate::stringFromColumnIndex($col);
                $cellValue = $sheet->getCell($columnLetter . $row)->getValue();
                if ($cellValue !== null && $cellValue !== '') {
                    $isEmpty = false;
                    break;
                }
            }

            if ($isEmpty) {
                $sheet->removeRow($row);
            }
        }
    }

    /**
     * Remove empty columns
     */
    protected function removeEmptyColumns($sheet): void
    {
        $highestColumn = $sheet->getHighestColumn();
        $highestColumnIndex = Coordinate::columnIndexFromString($highestColumn);
        $highestRow = $sheet->getHighestRow();

        for ($col = $highestColumnIndex; $col >= 1; $col--) {
            $isEmpty = true;

            for ($row = 1; $row <= $highestRow; $row++) {
                $columnLetter = Coordinate::stringFromColumnIndex($col);
                $cellValue = $sheet->getCell($columnLetter . $row)->getValue();
                if ($cellValue !== null && $cellValue !== '') {
                    $isEmpty = false;
                    break;
                }
            }

            if ($isEmpty) {
                $sheet->removeColumn($columnLetter);
            }
        }
    }

    /**
     * Get conversion statistics
     */
    protected function getConversionStats($sheet): array
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $highestColumnIndex = Coordinate::columnIndexFromString($highestColumn);

        return [
            'rows' => (int)$highestRow,
            'columns' => $highestColumnIndex,
        ];
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
            return 1;
        }
    }

    /**
     * Get target file extension
     */
    public function getTargetExtension(): string
    {
        return 'xlsx';
    }

    /**
     * Get target MIME type
     */
    public function getTargetMimeType(): string
    {
        return 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
    }
}

