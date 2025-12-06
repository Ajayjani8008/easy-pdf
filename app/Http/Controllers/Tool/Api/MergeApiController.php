<?php

namespace App\Http\Controllers\Tool\Api;

use App\Http\Controllers\Controller;
use App\Models\UploadedFile;
use App\Services\PdfMerger\PdfMergerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class MergeApiController extends Controller
{
    protected PdfMergerService $mergerService;

    public function __construct(PdfMergerService $mergerService)
    {
        $this->mergerService = $mergerService;
    }

    /**
     * Upload multiple PDF files
     */
    public function uploadMultiple(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'files.*' => 'required|file|mimes:pdf|max:51200', // 50MB max
        ], [
            'files.*.mimes' => 'All files must be PDF format.',
            'files.*.max' => 'Each file must not exceed 50MB.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $files = $request->file('files');
        $fileCount = count($files);

        // Validate file count (allow single file uploads, but limit max)
        if ($fileCount < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Please select at least one PDF file.',
            ], 422);
        }

        if ($fileCount > 10) {
            return response()->json([
                'success' => false,
                'message' => 'Maximum 10 PDF files allowed per upload. You can upload files one by one.',
            ], 422);
        }

        try {
            $uploadedFiles = [];

            foreach ($files as $index => $file) {
                $fileId = Str::uuid()->toString();
                $originalName = $file->getClientOriginalName();

                // Create database record
                $uploadedFile = UploadedFile::create([
                    'file_id' => $fileId,
                    'original_name' => $originalName,
                    'type' => 'pdf',
                    'expires_at' => now()->addHour(),
                ]);

                // Store file using Spatie Media Library
                // Move uploaded file to media library
                $uploadedFile
                    ->addMedia($file->getRealPath())
                    ->usingName($originalName)
                    ->usingFileName($fileId . '.pdf')
                    ->toMediaCollection('files');

                $media = $uploadedFile->getFileMedia();
                $fileSize = $media ? $media->size : $file->getSize();

                $uploadedFiles[] = [
                    'id' => $fileId,
                    'name' => $originalName,
                    'size' => $this->formatBytes($fileSize),
                ];
            }

            return response()->json([
                'success' => true,
                'files' => $uploadedFiles,
                'count' => count($uploadedFiles),
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'File upload failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Merge PDF files
     */
    public function merge(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'file_ids' => 'required|array|min:2|max:10',
            'file_ids.*' => 'required|string|exists:uploaded_files,file_id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        try {
            $fileIds = $request->input('file_ids');
            $uploadedFiles = UploadedFile::whereIn('file_id', $fileIds)
                ->orderByRaw('FIELD(file_id, "' . implode('","', $fileIds) . '")')
                ->get();

            if ($uploadedFiles->count() !== count($fileIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'One or more files not found.',
                ], 404);
            }

            // Get file paths
            $pdfPaths = [];
            foreach ($uploadedFiles as $uploadedFile) {
                $media = $uploadedFile->getFileMedia();
                if (!$media || !$media->exists()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'File not found: ' . $uploadedFile->original_name,
                    ], 404);
                }
                $pdfPaths[] = $media->getPath();
            }

            // Generate output file path
            $outputFileId = Str::uuid()->toString();
            $outputFileName = "{$outputFileId}.pdf";
            $outputPath = storage_path("app/merges/{$outputFileName}");

            // Ensure directory exists
            $outputDir = dirname($outputPath);
            if (!is_dir($outputDir)) {
                mkdir($outputDir, 0755, true);
            }

            // Perform merge
            $metadata = $this->mergerService->merge($pdfPaths, $outputPath);

            // Create output file record
            $outputFile = UploadedFile::create([
                'file_id' => $outputFileId,
                'original_name' => 'merged_' . now()->format('Y-m-d_His') . '.pdf',
                'type' => 'pdf',
                'expires_at' => now()->addHour(),
            ]);

            // Store merged file using Spatie Media Library
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
                    'size' => $outputFile->human_readable_size ?? $this->formatBytes($metadata['file_size']),
                    'pages' => $metadata['pages'],
                    'files_merged' => $metadata['files_merged'],
                    'download_url' => route('api.files.download', $outputFileId),
                ],
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Merge failed: ' . $e->getMessage(),
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

