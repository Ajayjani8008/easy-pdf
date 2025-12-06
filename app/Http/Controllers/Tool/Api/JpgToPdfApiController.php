<?php

namespace App\Http\Controllers\Tool\Api;

use App\Http\Controllers\Controller;
use App\Models\UploadedFile;
use App\Services\JpgToPdf\JpgToPdfService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class JpgToPdfApiController extends Controller
{
    protected JpgToPdfService $converterService;

    public function __construct(JpgToPdfService $converterService)
    {
        $this->converterService = $converterService;
    }

    /**
     * Upload multiple images
     */
    public function uploadMultiple(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'files' => 'required|array|min:1|max:50',
            'files.*' => 'required|file|mimes:jpeg,jpg,png,webp|max:51200', // 50MB per file
        ], [
            'files.required' => 'Please select at least one image file.',
            'files.min' => 'Please select at least one image file.',
            'files.max' => 'Maximum 50 images allowed.',
            'files.*.mimes' => 'Only JPG, JPEG, PNG, and WebP images are allowed.',
            'files.*.max' => 'Each image must be smaller than 50MB.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $uploadedFiles = [];
            $files = $request->file('files');

            foreach ($files as $file) {
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
                    'type' => 'image',
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

                $uploadedFiles[] = [
                    'id' => $fileId,
                    'name' => $originalName,
                    'size' => $this->formatBytes($finalSize),
                    'type' => $mimeType,
                ];
            }

            return response()->json([
                'success' => true,
                'files' => $uploadedFiles,
                'count' => count($uploadedFiles),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Convert images to PDF
     */
    public function convert(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'file_ids' => 'required|array|min:1|max:50',
            'file_ids.*' => 'required|string|exists:uploaded_files,file_id',
            'page_size' => 'nullable|string|in:a4,letter,original,custom',
            'orientation' => 'nullable|string|in:portrait,landscape',
            'fit_mode' => 'nullable|string|in:fit,fill,original',
            'margin' => 'nullable|string|in:none,small,medium,custom',
            'custom_margin' => 'nullable|numeric|min:0|max:50',
            'custom_width' => 'nullable|numeric|min:50|max:500',
            'custom_height' => 'nullable|numeric|min:50|max:500',
            'compression' => 'nullable|string|in:high,balanced,small',
        ], [
            'file_ids.required' => 'Please select at least one image.',
            'file_ids.min' => 'Please select at least one image.',
            'file_ids.max' => 'Maximum 50 images allowed.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $fileIds = $request->input('file_ids');
            $imagePaths = [];

            // Get all image file paths
            foreach ($fileIds as $fileId) {
                $uploadedFile = UploadedFile::where('file_id', $fileId)->first();
                if (!$uploadedFile) {
                    continue;
                }

                $media = $uploadedFile->getFileMedia();
                if ($media && $media->exists()) {
                    $imagePaths[] = $media->getPath();
                }
            }

            if (empty($imagePaths)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No valid image files found.',
                ], 404);
            }

            // Generate output file
            $outputFileId = Str::uuid()->toString();
            $outputPath = storage_path("app/pdf_conversions/{$outputFileId}.pdf");

            // Ensure directory exists
            $outputDir = dirname($outputPath);
            if (!is_dir($outputDir)) {
                mkdir($outputDir, 0755, true);
            }

            // Prepare options
            $options = [
                'page_size' => $request->input('page_size', 'a4'),
                'orientation' => $request->input('orientation', 'portrait'),
                'fit_mode' => $request->input('fit_mode', 'fit'),
                'margin' => $request->input('margin', 'small'),
                'custom_margin' => $request->input('custom_margin', 10),
                'custom_width' => $request->input('custom_width'),
                'custom_height' => $request->input('custom_height'),
                'compression' => $request->input('compression', 'balanced'),
            ];

            // Perform conversion
            $metadata = $this->converterService->convert($imagePaths, $outputPath, $options);

            // Create output file record
            $outputFile = UploadedFile::create([
                'file_id' => $outputFileId,
                'original_name' => 'images_to_pdf_' . now()->format('Y-m-d_His') . '.pdf',
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
                'file' => [
                    'id' => $outputFileId,
                    'name' => $outputFile->original_name,
                    'size' => $this->formatBytes($metadata['file_size']),
                    'download_url' => route('api.files.download', $outputFileId),
                ],
                'conversion' => [
                    'image_count' => $metadata['image_count'],
                    'page_count' => $metadata['page_count'],
                    'file_size' => $this->formatBytes($metadata['file_size']),
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

