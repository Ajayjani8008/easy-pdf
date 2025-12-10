<?php

namespace App\Http\Controllers\Tool\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadFileRequest;
use App\Models\UploadedFile;
use App\Services\PdfConverter\PdfToExcelConverter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Exception;

class PdfToExcelApiController extends Controller
{
    protected PdfToExcelConverter $converter;

    public function __construct()
    {
        $this->converter = new PdfToExcelConverter();
    }

    /**
     * Get PDF info (page count)
     */
    public function getPdfInfo(string $fileId): JsonResponse
    {
        try {
            $uploadedFile = UploadedFile::where('file_id', $fileId)->firstOrFail();
            $media = $uploadedFile->getFileMedia();

            if (!$media || !$media->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'File not found.',
                ], 404);
            }

            $pdfPath = $media->getPath();
            
            // Get page count using FPDI
            $pageCount = $this->getPageCount($pdfPath);

            return response()->json([
                'success' => true,
                'file_id' => $uploadedFile->file_id,
                'file_name' => $uploadedFile->original_name,
                'file_size' => $this->formatBytes($media->size),
                'page_count' => $pageCount,
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get PDF info: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Convert PDF to Excel
     */
    public function convert(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'file_id' => 'required|string|exists:uploaded_files,file_id',
            'extraction_mode' => 'nullable|string|in:automatic,manual,entire_page',
            'pages' => 'nullable|string', // 'all', '1', '2-5', or JSON array
            'output_format' => 'nullable|string|in:xlsx,csv',
            'keep_formatting' => 'nullable|boolean',
            'merge_headers' => 'nullable|boolean',
            'detect_dates' => 'nullable|boolean',
            'detect_currency' => 'nullable|boolean',
            'remove_empty_rows' => 'nullable|boolean',
            'remove_empty_columns' => 'nullable|boolean',
            'ocr_enabled' => 'nullable|boolean',
            'ocr_language' => 'nullable|string|in:eng,spa,fra,deu,ita,por,chi,jpn',
        ], [
            'file_id.required' => 'Please select a PDF file.',
            'file_id.exists' => 'File not found.',
            'extraction_mode.in' => 'Invalid extraction mode.',
            'output_format.in' => 'Invalid output format.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $uploadedFile = UploadedFile::where('file_id', $request->input('file_id'))->firstOrFail();
            $media = $uploadedFile->getFileMedia();

            if (!$media || !$media->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'File not found.',
                ], 404);
            }

            $pdfPath = $media->getPath();

            // Parse pages parameter
            $pages = $this->parsePages($request->input('pages', 'all'));

            // Prepare options
            $options = [
                'extraction_mode' => $request->input('extraction_mode', 'automatic'),
                'pages' => $pages,
                'output_format' => $request->input('output_format', 'xlsx'),
                'keep_formatting' => $request->boolean('keep_formatting', true),
                'merge_headers' => $request->boolean('merge_headers', true),
                'detect_dates' => $request->boolean('detect_dates', true),
                'detect_currency' => $request->boolean('detect_currency', true),
                'remove_empty_rows' => $request->boolean('remove_empty_rows', true),
                'remove_empty_columns' => $request->boolean('remove_empty_columns', true),
                'ocr_enabled' => $request->boolean('ocr_enabled', false),
                'ocr_language' => $request->input('ocr_language', 'eng'),
            ];

            // Generate output file
            $outputFileId = Str::uuid()->toString();
            $extension = $options['output_format'];
            $outputPath = storage_path("app/pdf_conversions/{$outputFileId}.{$extension}");

            // Ensure directory exists
            $outputDir = dirname($outputPath);
            if (!is_dir($outputDir)) {
                mkdir($outputDir, 0755, true);
            }

            // Perform conversion
            $metadata = $this->converter->convert($pdfPath, $outputPath, $options);
            
            // dd($pages);
            // Create output file record
            $outputFile = UploadedFile::create([
                'file_id' => $outputFileId,
                'original_name' => pathinfo($uploadedFile->original_name, PATHINFO_FILENAME) . ".{$extension}",
                'type' => $extension,
                'expires_at' => now()->addHour(),
            ]);
            // Store file using Spatie Media Library
            $outputFile
                ->addMedia($outputPath)
                ->usingName($outputFile->original_name)
                ->usingFileName($outputFileId . ".{$extension}")
                ->toMediaCollection('files');

            // Clean up temporary file
            if (file_exists($outputPath)) {
                unlink($outputPath);
            }

            return response()->json([
                'success' => true,
                'file' => [
                    'id' => $outputFileId,
                    'name' => $outputFile->original_name,
                    'size' => $this->formatBytes($metadata['file_size']),
                    'download_url' => route('api.files.download', $outputFileId),
                ],
                'metadata' => [
                    'pages' => $metadata['pages'],
                    'rows' => $metadata['rows'] ?? 0,
                    'columns' => $metadata['columns'] ?? 0,
                ],
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Conversion failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Parse pages parameter
     */
    protected function parsePages($pages)
    {
        if ($pages === 'all' || $pages === null) {
            return 'all';
        }

        // Try to decode JSON array
        if (is_string($pages)) {
            $decoded = json_decode($pages, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded;
            }

            // Try to parse range like "2-6"
            if (preg_match('/^(\d+)-(\d+)$/', $pages, $matches)) {
                return range((int)$matches[1], (int)$matches[2]);
            }

            // Try single number
            if (is_numeric($pages)) {
                return [(int)$pages];
            }
        }

        // If it's already an array, return it
        if (is_array($pages)) {
            return $pages;
        }

        return 'all';
    }

    /**
     * Get PDF page count
     */
    protected function getPageCount(string $pdfPath): int
    {
        try {
            $pdf = new \setasign\Fpdi\Fpdi();
            return $pdf->setSourceFile($pdfPath);
        } catch (Exception $e) {
            return 1;
        }
    }

    /**
     * Format bytes to human readable
     */
    protected function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}

