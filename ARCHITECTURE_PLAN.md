# PDF Conversion Tool - Architecture Plan

## Overview
This document outlines the reusable architecture for PDF conversion tools that can be easily extended for other conversion types (PDF to Excel, PowerPoint, JPG, etc.).

## Architecture Components

### 1. Service Layer (Reusable)
```
app/Services/PdfConverter/
├── PdfConverterInterface.php          # Interface for all converters
├── BasePdfConverter.php               # Base converter with common functionality
├── PdfToWordConverter.php             # PDF to Word implementation
├── PdfToExcelConverter.php            # Future: PDF to Excel
├── PdfToPowerPointConverter.php       # Future: PDF to PowerPoint
└── PdfToImageConverter.php            # Future: PDF to Image
```

### 2. Controllers (Reusable Pattern)
```
app/Http/Controllers/Tool/
├── BaseConverterController.php        # Base controller with common methods
├── PdfToWordController.php           # Extends BaseConverterController
├── PdfToExcelController.php          # Future: Extends BaseConverterController
└── Api/
    └── ConversionApiController.php   # API endpoints for upload/convert/download
```

### 3. Reusable Blade Components
```
resources/views/components/
├── converter-layout.blade.php         # Main layout wrapper
├── file-upload-area.blade.php         # Drag & drop upload area
├── pdf-preview-section.blade.php     # PDF preview/edit section
├── conversion-panel.blade.php         # Right side download/action panel
└── conversion-status.blade.php       # Status indicator (uploading/converting/done)
```

### 4. API Routes
```
routes/api.php
- POST /api/upload                    # Upload PDF file
- POST /api/convert/{type}           # Convert PDF (type: word, excel, etc.)
- GET  /api/download/{fileId}        # Download converted file
- GET  /api/status/{jobId}           # Check conversion status
```

### 5. JavaScript Modules (Reusable)
```
resources/js/
├── converters/
│   ├── base-converter.js            # Base converter class
│   ├── pdf-to-word.js               # PDF to Word specific logic
│   └── converter-factory.js         # Factory to create converters
└── components/
    ├── file-upload.js               # File upload handler
    ├── pdf-preview.js               # PDF preview renderer
    └── conversion-status.js         # Status management
```

### 6. Models
```
app/Models/
├── ConversionJob.php                # Track conversion jobs
└── UploadedFile.php                 # Track uploaded files
```

### 7. Database Migrations
```
database/migrations/
├── create_conversion_jobs_table.php
└── create_uploaded_files_table.php
```

## Workflow

1. **Upload Phase**
   - User selects/drops PDF file
   - File uploaded to server via API
   - Server validates file (size, type)
   - Returns file ID and preview URL

2. **Conversion Phase**
   - User clicks convert button
   - API endpoint receives conversion request
   - Background job processes conversion
   - Status updates via polling/websockets

3. **Result Phase**
   - Conversion completes
   - User sees preview of converted file
   - Download button appears
   - File available for download

## File Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   └── Tool/
│   │       ├── BaseConverterController.php
│   │       ├── PdfToWordController.php
│   │       └── Api/
│   │           └── ConversionApiController.php
│   └── Requests/
│       └── UploadFileRequest.php
├── Services/
│   └── PdfConverter/
│       ├── PdfConverterInterface.php
│       ├── BasePdfConverter.php
│       └── PdfToWordConverter.php
├── Models/
│   ├── ConversionJob.php
│   └── UploadedFile.php
└── Jobs/
    └── ProcessConversion.php

resources/
├── views/
│   ├── components/
│   │   ├── converter-layout.blade.php
│   │   ├── file-upload-area.blade.php
│   │   ├── pdf-preview-section.blade.php
│   │   ├── conversion-panel.blade.php
│   │   └── conversion-status.blade.php
│   └── tools/
│       └── pdf-to-word.blade.php
└── js/
    ├── converters/
    │   ├── base-converter.js
    │   ├── pdf-to-word.js
    │   └── converter-factory.js
    └── components/
        ├── file-upload.js
        ├── pdf-preview.js
        └── conversion-status.js

routes/
├── web.php
└── api.php

database/
└── migrations/
    ├── create_conversion_jobs_table.php
    └── create_uploaded_files_table.php
```

## Dependencies to Add

### PHP Packages (composer.json)
- `spatie/pdf` or `setasign/fpdi` - PDF manipulation
- `phpoffice/phpword` - Word document generation
- `intervention/image` - Image processing (for PDF to Image)

### JavaScript Packages (package.json)
- `pdf-lib` or `pdfjs-dist` - PDF rendering in browser
- `axios` - Already included for API calls

## Key Features

1. **Reusable Components**: All components can be reused for other converters
2. **Type Safety**: Interface-based design ensures consistency
3. **Background Processing**: Queue jobs for heavy conversions
4. **Real-time Updates**: Status polling or websockets
5. **File Management**: Automatic cleanup after 1 hour
6. **Error Handling**: Comprehensive error handling and user feedback
7. **Validation**: File type, size, and security validation

## Implementation Steps

1. Create database migrations
2. Create models
3. Create service layer (interfaces and base classes)
4. Create PDF to Word converter service
5. Create base controller
6. Create API controller
7. Create Blade components
8. Create JavaScript modules
9. Update routes
10. Update PDF to Word view to use components
11. Test end-to-end workflow

## Notes

- Files stored in `storage/app/conversions/` with unique IDs
- Conversion jobs stored in database for tracking
- Automatic cleanup job runs every hour
- Maximum file size: 50MB (configurable)
- Supported formats: PDF input, various outputs (Word, Excel, etc.)

