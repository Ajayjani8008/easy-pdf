<?php

namespace App\Http\Controllers\Tool\Api;

use App\Http\Controllers\Controller;
use App\Models\UploadedFile;
use App\Services\WordToPdf\WordToPdfService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class WordToPdfApiController extends Controller
{
    protected WordToPdfService $converterService;

    public function __construct(WordToPdfService $converterService)
    {
        $this->converterService = $converterService;
    }

    /**
     * Upload Word file
     */
    public function upload(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:doc,docx,rtf,odt|max:51200', // 50MB
        ], [
            'file.required' => 'Please select a Word document.',
            'file.mimes' => 'Only DOC, DOCX, RTF, and ODT files are allowed.',
            'file.max' => 'File must be smaller than 50MB.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $file = $request->file('file');
            $fileId = Str::uuid()->toString();
            $originalName = $file->getClientOriginalName();

            // Get file properties BEFORE moving the file
            $fileSize = $file->getSize();
            $mimeType = $file->getMimeType();
            $extension = $file->getClientOriginalExtension();
            $tempPath = $file->getRealPath();

            // Validate temp file exists
            if (!$tempPath || !file_exists($tempPath)) {
                throw new Exception("Temporary file not found for: {$originalName}");
            }

            // Create uploaded file record
            $uploadedFile = UploadedFile::create([
                'file_id' => $fileId,
                'original_name' => $originalName,
                'type' => 'word',
                'expires_at' => now()->addHour(),
            ]);

            // Store file using Spatie Media Library
            $media = $uploadedFile
                ->addMedia($tempPath)
                ->usingName($originalName)
                ->usingFileName($fileId . '.' . $extension)
                ->toMediaCollection('files');

            // Get file size from media object (more reliable) or use original size
            $finalSize = $media ? $media->size : $fileSize;

            return response()->json([
                'success' => true,
                'file' => [
                    'id' => $fileId,
                    'name' => $originalName,
                    'size' => $this->formatBytes($finalSize),
                    'type' => $mimeType,
                ],
            ], 200);

        } catch (Exception $e) {
            Log::error('Word file upload failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Convert Word to PDF
     */
    public function convert(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'file_id' => 'required|string|exists:uploaded_files,file_id',
            'page_size' => 'nullable|string|in:a4,letter,legal',
            'orientation' => 'nullable|string|in:portrait,landscape',
            'margin' => 'nullable|string|in:default,narrow,wide',
        ], [
            'file_id.required' => 'File ID is required.',
            'file_id.exists' => 'File not found.',
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

            if (!$uploadedFile) {
                return response()->json([
                    'success' => false,
                    'message' => 'File not found.',
                ], 404);
            }

            $media = $uploadedFile->getFirstMedia('files');
            if (!$media) {
                return response()->json([
                    'success' => false,
                    'message' => 'File media not found.',
                ], 404);
            }

            $wordPath = $media->getPath();

            if (!file_exists($wordPath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Source file not found on server.',
                ], 404);
            }

            // Prepare conversion options
            $options = [
                'page_size' => $request->input('page_size', 'a4'),
                'orientation' => $request->input('orientation', 'portrait'),
                'margin' => $request->input('margin', 'default'),
            ];

            // Create temporary output path
            $outputFileId = Str::uuid()->toString();
            $outputPath = storage_path('app/temp/' . $outputFileId . '.pdf');

            // Ensure temp directory exists
            $tempDir = dirname($outputPath);
            if (!is_dir($tempDir)) {
                mkdir($tempDir, 0755, true);
            }

            // Convert Word to PDF
            $metadata = $this->converterService->convert($wordPath, $outputPath, $options);

            // Create output file record
            $outputFile = UploadedFile::create([
                'file_id' => $outputFileId,
                'original_name' => pathinfo($uploadedFile->original_name, PATHINFO_FILENAME) . '.pdf',
                'type' => 'pdf',
                'expires_at' => now()->addHour(),
            ]);

            // Store file using Spatie Media Library
            $outputFile
                ->addMedia($outputPath)
                ->usingName($outputFile->original_name)
                ->usingFileName($outputFileId . '.pdf')
                ->toMediaCollection('files');

            // Clean up temporary file
            if (file_exists($outputPath)) {
                unlink($outputPath);
            }

            return response()->json([
                'success' => true,
                'file_id' => $outputFileId,
                'file_name' => $outputFile->original_name,
                'file_size' => $this->formatBytes($metadata['file_size']),
                'pages' => $metadata['pages'],
                'converted_at' => $metadata['converted_at'],
            ], 200);

        } catch (Exception $e) {
            Log::error('Word to PDF conversion failed', [
                'error' => $e->getMessage(),
                'file_id' => $request->input('file_id'),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Conversion failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Format bytes to human-readable format
     */
    protected function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}

