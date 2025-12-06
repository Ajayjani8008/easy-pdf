<?php

namespace App\Http\Controllers\Tool\Api;

use App\Http\Controllers\Controller;
use App\Models\UploadedFile;
use App\Services\PdfCompressor\PdfCompressorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class CompressApiController extends Controller
{
    protected PdfCompressorService $compressorService;

    public function __construct(PdfCompressorService $compressorService)
    {
        $this->compressorService = $compressorService;
    }

    /**
     * Get file info and compression estimate
     */
    public function getFileInfo(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'file_id' => 'required|string|exists:uploaded_files,file_id',
            'level' => 'nullable|string|in:high,balanced,low',
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

            $fileInfo = $this->compressorService->getFileInfo($media->getPath());
            $level = $request->input('level', PdfCompressorService::LEVEL_BALANCED);
            $estimate = $this->compressorService->estimateCompression($media->getPath(), $level);

            return response()->json([
                'success' => true,
                'file_info' => $fileInfo,
                'estimate' => $estimate,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get file info: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Compress PDF
     */
    public function compress(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'file_id' => 'required|string|exists:uploaded_files,file_id',
            'level' => 'required|string|in:high,balanced,low',
        ], [
            'level.required' => 'Please select a compression level.',
            'level.in' => 'Invalid compression level. Must be: high, balanced, or low.',
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

            $level = $request->input('level');
            $pdfPath = $media->getPath();

            // Generate output file path
            $outputFileId = Str::uuid()->toString();
            $outputFileName = "{$outputFileId}.pdf";
            $outputPath = storage_path("app/compressed/{$outputFileName}");

            // Ensure directory exists
            $outputDir = dirname($outputPath);
            if (!is_dir($outputDir)) {
                mkdir($outputDir, 0755, true);
            }

            // Perform compression
            $metadata = $this->compressorService->compress($pdfPath, $outputPath, $level);

            // Create output file record
            $outputFile = UploadedFile::create([
                'file_id' => $outputFileId,
                'original_name' => 'compressed_' . now()->format('Y-m-d_His') . '.pdf',
                'type' => 'pdf',
                'expires_at' => now()->addHour(),
            ]);

            // Store compressed file using Spatie Media Library
            $outputFile
                ->addMedia($outputPath)
                ->usingName($outputFile->original_name)
                ->usingFileName($outputFileName)
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
                    'original_size' => $this->formatBytes($metadata['original_size']),
                    'saved_bytes' => $this->formatBytes($metadata['saved_bytes']),
                    'saved_percentage' => $metadata['saved_percentage'],
                    'compression_level' => $metadata['compression_level'],
                    'pages' => $metadata['pages'],
                    'download_url' => route('api.files.download', $outputFileId),
                ],
                'compression' => [
                    'original_size' => $metadata['original_size'],
                    'compressed_size' => $metadata['file_size'],
                    'saved_bytes' => $metadata['saved_bytes'],
                    'saved_percentage' => $metadata['saved_percentage'],
                ],
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Compression failed: ' . $e->getMessage(),
            ], 500);
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

