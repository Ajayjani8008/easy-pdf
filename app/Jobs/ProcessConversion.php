<?php

namespace App\Jobs;

use App\Models\ConversionJob;
use App\Models\UploadedFile;
use App\Services\PdfConverter\PdfConverterInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProcessConversion implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public ConversionJob $conversionJob,
        public PdfConverterInterface $converter
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->conversionJob->markAsProcessing();

        try {
            $uploadedFile = $this->conversionJob->uploadedFile;
            
            if (!$uploadedFile || !file_exists($uploadedFile->path)) {
                throw new \Exception('Source file not found');
            }

            // Generate output file path
            $outputFileId = Str::uuid()->toString();
            $extension = $this->converter->getTargetExtension();
            $outputFileName = "{$outputFileId}.{$extension}";
            $outputPath = storage_path("app/conversions/{$outputFileName}");

            // Ensure directory exists
            $outputDir = dirname($outputPath);
            if (!is_dir($outputDir)) {
                mkdir($outputDir, 0755, true);
            }

            // Perform conversion
            $metadata = $this->converter->convert($uploadedFile->path, $outputPath);

            // Create output file record
            $outputFile = UploadedFile::create([
                'file_id' => $outputFileId,
                'original_name' => pathinfo($uploadedFile->original_name, PATHINFO_FILENAME) . ".{$extension}",
                'stored_name' => $outputFileName,
                'mime_type' => $this->converter->getTargetMimeType(),
                'size' => filesize($outputPath),
                'path' => $outputPath,
                'type' => $extension,
                'expires_at' => now()->addHour(),
            ]);

            // Mark job as completed
            $this->conversionJob->markAsCompleted($outputFileId, $metadata);

        } catch (\Exception $e) {
            $this->conversionJob->markAsFailed($e->getMessage());
            throw $e;
        }
    }
}

