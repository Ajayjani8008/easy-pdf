<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Carbon\Carbon;

class UploadedFile extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $fillable = [
        'file_id',
        'original_name',
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
     * Register media collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('files')
            ->singleFile()
            ->acceptsMimeTypes(['application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/msword']);
    }

    /**
     * Get the file media
     */
    public function getFileMedia(): ?Media
    {
        return $this->getFirstMedia('files');
    }

    /**
     * Get file path (for backward compatibility)
     */
    public function getPathAttribute(): ?string
    {
        $media = $this->getFileMedia();
        return $media ? $media->getPath() : null;
    }

    /**
     * Get file size (for backward compatibility)
     */
    public function getSizeAttribute(): ?int
    {
        $media = $this->getFileMedia();
        return $media ? $media->size : null;
    }

    /**
     * Get mime type (for backward compatibility)
     */
    public function getMimeTypeAttribute(): ?string
    {
        $media = $this->getFileMedia();
        return $media ? $media->mime_type : null;
    }

    /**
     * Get stored name (for backward compatibility)
     */
    public function getStoredNameAttribute(): ?string
    {
        $media = $this->getFileMedia();
        return $media ? $media->file_name : null;
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

    /**
     * Get download URL
     */
    public function getDownloadUrlAttribute(): string
    {
        $media = $this->getFileMedia();
        return $media ? $media->getUrl() : '';
    }
}

