<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConversionJob extends Model
{
    protected $fillable = [
        'job_id',
        'uploaded_file_id',
        'conversion_type',
        'status',
        'error_message',
        'output_file_id',
        'metadata',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Get the uploaded file
     */
    public function uploadedFile(): BelongsTo
    {
        return $this->belongsTo(UploadedFile::class);
    }

    /**
     * Get the output file
     */
    public function outputFile(): BelongsTo
    {
        return $this->belongsTo(UploadedFile::class, 'output_file_id');
    }

    /**
     * Mark job as processing
     */
    public function markAsProcessing(): void
    {
        $this->update([
            'status' => 'processing',
            'started_at' => now(),
        ]);
    }

    /**
     * Mark job as completed
     */
    public function markAsCompleted(string $outputFileId, array $metadata = []): void
    {
        $this->update([
            'status' => 'completed',
            'output_file_id' => $outputFileId,
            'metadata' => $metadata,
            'completed_at' => now(),
        ]);
    }

    /**
     * Mark job as failed
     */
    public function markAsFailed(string $errorMessage): void
    {
        $this->update([
            'status' => 'failed',
            'error_message' => $errorMessage,
            'completed_at' => now(),
        ]);
    }
}

