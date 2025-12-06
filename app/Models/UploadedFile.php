<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class UploadedFile extends Model
{
    protected $fillable = [
        'file_id',
        'original_name',
        'stored_name',
        'mime_type',
        'size',
        'path',
        'type',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'size' => 'integer',
    ];

    /**
     * Get all conversion jobs for this file
     */
    public function conversionJobs(): HasMany
    {
        return $this->hasMany(ConversionJob::class);
    }

    /**
     * Check if file has expired
     */
    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Get human readable file size
     */
    public function getHumanReadableSizeAttribute(): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $size = $this->size;
        $unit = 0;
        
        while ($size >= 1024 && $unit < count($units) - 1) {
            $size /= 1024;
            $unit++;
        }
        
        return round($size, 2) . ' ' . $units[$unit];
    }
}

