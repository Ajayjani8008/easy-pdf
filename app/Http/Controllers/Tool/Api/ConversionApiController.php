<?php

namespace App\Http\Controllers\Tool\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadFileRequest;
use App\Jobs\ProcessConversion;
use App\Models\ConversionJob;
use App\Models\UploadedFile;
use App\Services\PdfConverter\PdfToWordConverter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ConversionApiController extends Controller
{
    /**
     * Upload a PDF file
     */
    public function upload(UploadFileRequest $request): JsonResponse
    {
        try {
            $file = $request->file('file');
            $fileId = Str::uuid()->toString();
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $storedName = "{$fileId}.{$extension}";
            
            // Store file
            $path = $file->storeAs('uploads', $storedName, 'local');
            $fullPath = storage_path("app/{$path}");

            // Create database record
            $uploadedFile = UploadedFile::create([
                'file_id' => $fileId,
                'original_name' => $originalName,
                'stored_name' => $storedName,
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
                'path' => $fullPath,
                'type' => 'pdf',
                'expires_at' => now()->addHour(),
            ]);

            return response()->json([
                'success' => true,
                'file' => [
                    'id' => $fileId,
                    'name' => $originalName,
                    'size' => $uploadedFile->human_readable_size,
                    'preview_url' => route('api.files.preview', $fileId),
                ],
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'File upload failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Start conversion process
     */
    public function convert(Request $request, string $type): JsonResponse
    {
        $request->validate([
            'file_id' => 'required|string|exists:uploaded_files,file_id',
        ]);

        try {
            $uploadedFile = UploadedFile::where('file_id', $request->file_id)->firstOrFail();
            
            // Get appropriate converter based on type
            $converter = $this->getConverter($type);
            
            if (!$converter) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid conversion type',
                ], 400);
            }

            // Create conversion job
            $jobId = Str::uuid()->toString();
            $conversionJob = ConversionJob::create([
                'job_id' => $jobId,
                'uploaded_file_id' => $uploadedFile->id,
                'conversion_type' => $type,
                'status' => 'pending',
            ]);

            // Dispatch conversion job
            ProcessConversion::dispatch($conversionJob, $converter);

            return response()->json([
                'success' => true,
                'job' => [
                    'id' => $jobId,
                    'status' => 'pending',
                    'status_url' => route('api.conversions.status', $jobId),
                ],
            ], 202);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Conversion failed to start: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get conversion status
     */
    public function status(string $jobId): JsonResponse
    {
        $job = ConversionJob::where('job_id', $jobId)->firstOrFail();

        $response = [
            'success' => true,
            'job' => [
                'id' => $job->job_id,
                'status' => $job->status,
            ],
        ];

        if ($job->status === 'completed') {
            $outputFile = $job->outputFile;
            $response['job']['output_file'] = [
                'id' => $outputFile->file_id,
                'name' => $outputFile->original_name,
                'size' => $outputFile->human_readable_size,
                'download_url' => route('api.files.download', $outputFile->file_id),
            ];
            $response['job']['metadata'] = $job->metadata;
        } elseif ($job->status === 'failed') {
            $response['job']['error'] = $job->error_message;
        }

        return response()->json($response);
    }

    /**
     * Download converted file
     */
    public function download(string $fileId): \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
    {
        $file = UploadedFile::where('file_id', $fileId)->firstOrFail();

        if (!file_exists($file->path)) {
            return response()->json([
                'success' => false,
                'message' => 'File not found',
            ], 404);
        }

        return response()->download($file->path, $file->original_name);
    }

    /**
     * Preview uploaded file (return file info)
     */
    public function preview(string $fileId): JsonResponse
    {
        $file = UploadedFile::where('file_id', $fileId)->firstOrFail();

        return response()->json([
            'success' => true,
            'file' => [
                'id' => $file->file_id,
                'name' => $file->original_name,
                'size' => $file->human_readable_size,
                'type' => $file->type,
                'preview_url' => route('api.files.preview', $fileId),
            ],
        ]);
    }

    /**
     * Get converter instance based on type
     */
    protected function getConverter(string $type): ?object
    {
        return match ($type) {
            'word', 'pdf-to-word' => new PdfToWordConverter(),
            // Add more converters here as needed
            // 'excel', 'pdf-to-excel' => new PdfToExcelConverter(),
            // 'powerpoint', 'pdf-to-powerpoint' => new PdfToPowerPointConverter(),
            default => null,
        };
    }
}

