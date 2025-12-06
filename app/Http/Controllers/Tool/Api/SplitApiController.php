<?php

namespace App\Http\Controllers\Tool\Api;

use App\Http\Controllers\Controller;
use App\Models\UploadedFile;
use App\Services\PdfSplitter\PdfSplitterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class SplitApiController extends Controller
{
    protected PdfSplitterService $splitterService;

    public function __construct(PdfSplitterService $splitterService)
    {
        $this->splitterService = $splitterService;
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

            $pageCount = $this->splitterService->getPageCount($media->getPath());

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
     * Split PDF by page ranges
     */
    public function split(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'file_id' => 'required|string|exists:uploaded_files,file_id',
            'page_ranges' => 'required|array|min:1',
            'page_ranges.*' => 'required|array|min:1|max:2',
            'page_ranges.*.*' => 'required|integer|min:1',
        ], [
            'page_ranges.required' => 'Please specify at least one page range.',
            'page_ranges.*.required' => 'Each page range must be an array.',
            'page_ranges.*.*.required' => 'Page numbers must be integers.',
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

            $pageRanges = $request->input('page_ranges');
            $pdfPath = $media->getPath();

            // Generate output file path
            $outputFileId = Str::uuid()->toString();
            $outputFileName = "{$outputFileId}.pdf";
            $outputPath = storage_path("app/splits/{$outputFileName}");

            // Ensure directory exists
            $outputDir = dirname($outputPath);
            if (!is_dir($outputDir)) {
                mkdir($outputDir, 0755, true);
            }

            // Perform split
            $metadata = $this->splitterService->splitByRanges($pdfPath, $outputPath, $pageRanges);

            // Create output file record
            $outputFile = UploadedFile::create([
                'file_id' => $outputFileId,
                'original_name' => 'split_' . now()->format('Y-m-d_His') . '.pdf',
                'type' => 'pdf',
                'expires_at' => now()->addHour(),
            ]);

            // Store split file using Spatie Media Library
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
                    'pages' => $metadata['pages'],
                    'download_url' => route('api.files.download', $outputFileId),
                ],
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Split failed: ' . $e->getMessage(),
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

