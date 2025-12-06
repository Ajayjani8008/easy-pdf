<?php

namespace App\Http\Controllers\Tool\Api;

use App\Http\Controllers\Controller;
use App\Models\UploadedFile;
use App\Services\PdfToJpg\PdfToJpgService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PdfToJpgApiController extends Controller
{
    protected PdfToJpgService $converterService;

    public function __construct(PdfToJpgService $converterService)
    {
        $this->converterService = $converterService;
    }

    /**
     * Get PDF page count
     */
    public function getPageCount(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'file_id' => 'required|string|exists:uploaded_files,file_id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        try {
            $uploadedFile = UploadedFile::where('file_id', $request->input('file_id'))->first();
            $media = $uploadedFile->getFileMedia();

            if (!$media || !$media->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'File not found.',
                ], 404);
            }

            $pageCount = $this->converterService->getPageCount($media->getPath());

            return response()->json([
                'success' => true,
                'page_count' => $pageCount,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get page count: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Convert PDF to JPG
     */
    public function convert(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'file_id' => 'required|string|exists:uploaded_files,file_id',
            'mode' => 'required|string|in:pages,images',
            'quality' => 'required|string|in:high,medium,low',
            'dpi' => 'required|integer|in:72,150,300',
            'page_ranges' => 'nullable|array',
            'page_ranges.*' => 'nullable|array|min:1|max:2',
            'page_ranges.*.*' => 'nullable|integer|min:1',
        ], [
            'mode.required' => 'Please select a conversion mode.',
            'mode.in' => 'Invalid conversion mode. Must be: pages or images.',
            'quality.required' => 'Please select image quality.',
            'quality.in' => 'Invalid quality. Must be: high, medium, or low.',
            'dpi.required' => 'Please select DPI setting.',
            'dpi.in' => 'Invalid DPI. Must be: 72, 150, or 300.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $uploadedFile = UploadedFile::where('file_id', $request->input('file_id'))->first();
            $media = $uploadedFile->getFileMedia();

            if (!$media || !$media->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'File not found.',
                ], 404);
            }

            $mode = $request->input('mode');
            $quality = $request->input('quality');
            $dpi = (int)$request->input('dpi');
            $pageRanges = $request->input('page_ranges');
            $pdfPath = $media->getPath();

            // Generate output directory
            $outputFileId = Str::uuid()->toString();
            $outputDir = storage_path("app/jpg_conversions/{$outputFileId}");

            // Ensure directory exists
            if (!is_dir($outputDir)) {
                mkdir($outputDir, 0755, true);
            }

            // Perform conversion
            $metadata = $this->converterService->convert(
                $pdfPath,
                $outputDir,
                $mode,
                $quality,
                $dpi,
                $pageRanges
            );

            // Create output file record
            $outputFile = UploadedFile::create([
                'file_id' => $outputFileId,
                'original_name' => $mode === PdfToJpgService::MODE_PAGES 
                    ? 'pdf_pages_' . now()->format('Y-m-d_His') . '.zip'
                    : 'pdf_images_' . now()->format('Y-m-d_His') . '.zip',
                'type' => 'zip',
                'expires_at' => now()->addHour(),
            ]);

            // Determine which file to store (ZIP if multiple, single JPG if one)
            $fileToStore = null;
            $fileName = null;

            if ($metadata['zip_path'] && file_exists($metadata['zip_path'])) {
                $fileToStore = $metadata['zip_path'];
                $fileName = $outputFile->original_name;
            } elseif (count($metadata['files']) === 1) {
                $fileToStore = $metadata['files'][0]['path'];
                $fileName = $metadata['files'][0]['name'];
                $outputFile->original_name = $fileName;
                $outputFile->type = 'jpg';
                $outputFile->save();
            } else {
                throw new Exception('No output files generated.');
            }

            // Store file using Spatie Media Library
            $outputFile
                ->addMedia($fileToStore)
                ->usingName($outputFile->original_name)
                ->usingFileName($fileName)
                ->toMediaCollection('files');

            // Clean up temporary files
            $this->cleanupDirectory($outputDir);

            return response()->json([
                'success' => true,
                'file' => [
                    'id' => $outputFileId,
                    'name' => $outputFile->original_name,
                    'size' => $this->formatBytes(filesize($fileToStore)),
                    'download_url' => route('api.files.download', $outputFileId),
                ],
                'conversion' => [
                    'mode' => $metadata['mode'],
                    'quality' => $metadata['quality'],
                    'dpi' => $metadata['dpi'] ?? null,
                    'converted_count' => $metadata['converted_count'] ?? $metadata['extracted_count'] ?? 0,
                    'total_pages' => $metadata['total_pages'] ?? 0,
                    'is_zip' => $metadata['zip_path'] !== null,
                ],
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Conversion failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Clean up directory
     */
    protected function cleanupDirectory(string $dir): void
    {
        if (is_dir($dir)) {
            $files = array_diff(scandir($dir), ['.', '..']);
            foreach ($files as $file) {
                $filePath = $dir . '/' . $file;
                if (is_file($filePath)) {
                    unlink($filePath);
                }
            }
            rmdir($dir);
        }
    }

    /**
     * Format bytes to human readable format
     */
    protected function formatBytes(int $bytes): string
    {
        if ($bytes === 0) return '0 Bytes';
        $k = 1024;
        $sizes = ['Bytes', 'KB', 'MB', 'GB'];
        $i = floor(log($bytes) / log($k));
        return round($bytes / pow($k, $i), 2) . ' ' . $sizes[$i];
    }
}

