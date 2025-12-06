<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Converter Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for PDF conversion tools
    |
    */

    /*
    | Maximum file size in bytes (default: 50MB)
    */
    'max_file_size' => env('CONVERTER_MAX_FILE_SIZE', 50 * 1024 * 1024),

    /*
    | File expiration time in hours (default: 1 hour)
    */
    'file_expiration_hours' => env('CONVERTER_FILE_EXPIRATION_HOURS', 1),

    /*
    | Storage disk for uploaded files
    */
    'upload_disk' => env('CONVERTER_UPLOAD_DISK', 'local'),

    /*
    | Storage path for conversions
    */
    'conversion_path' => env('CONVERTER_CONVERSION_PATH', 'conversions'),

    /*
    | Allowed file types for upload
    */
    'allowed_types' => [
        'pdf' => ['application/pdf'],
    ],

    /*
    | Conversion types and their settings
    */
    'conversion_types' => [
        'word' => [
            'extension' => 'docx',
            'mime_type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'class' => \App\Services\PdfConverter\PdfToWordConverter::class,
        ],
        // Add more conversion types here
        // 'excel' => [
        //     'extension' => 'xlsx',
        //     'mime_type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        //     'class' => \App\Services\PdfConverter\PdfToExcelConverter::class,
        // ],
    ],
];

