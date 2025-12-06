# Easy PDF - Tool Development Guide

## 📋 Table of Contents
1. [Architecture Overview](#architecture-overview)
2. [Complete Functionality Flow](#complete-functionality-flow)
3. [How to Add a New Tool](#how-to-add-a-new-tool)
4. [File Structure](#file-structure)
5. [Step-by-Step Example](#step-by-step-example)

---

## 🏗️ Architecture Overview

### System Components

```
┌─────────────────────────────────────────────────────────────┐
│                    Frontend (Alpine.js)                      │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐     │
│  │ File Upload  │  │ PDF Preview  │  │  Conversion  │     │
│  │  Component   │  │  Component   │  │   Status     │     │
│  └──────┬───────┘  └──────┬───────┘  └──────┬───────┘     │
│         │                 │                  │              │
│         └─────────────────┴──────────────────┘              │
│                           │                                  │
│                    Converter Manager                         │
└───────────────────────────┼──────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│                    Backend (Laravel)                         │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐     │
│  │   API Routes │  │ Controllers  │  │   Services   │     │
│  │   (api.php)  │  │              │  │  (Converters)│     │
│  └──────┬───────┘  └──────┬───────┘  └──────┬───────┘     │
│         │                 │                  │              │
│         └─────────────────┴──────────────────┘              │
│                           │                                  │
│                    Queue Jobs                                │
│                    (ProcessConversion)                       │
└───────────────────────────┼──────────────────────────────────┘
                            │
                            ▼
                    ┌──────────────┐
                    │ Media Library│
                    │  (Spatie)    │
                    └──────────────┘
```

---

## 🔄 Complete Functionality Flow

### Step 1: User Uploads File
```
User Action: Drag & Drop or Click to Upload PDF
    ↓
Frontend: file-upload.js component
    ↓
API Call: POST /api/upload
    ↓
Backend: ConversionApiController@upload
    ↓
Storage: Spatie Media Library saves file
    ↓
Response: Returns file ID, name, size
    ↓
Frontend: Dispatches 'file-uploaded' event
    ↓
Components: pdf-preview & conversion-status update
```

### Step 2: User Clicks Convert
```
User Action: Click "Convert to Word" button
    ↓
Frontend: conversion-status.js@startConversion()
    ↓
Event: Dispatches 'start-conversion' event
    ↓
Frontend: converter-manager.js listens & handles
    ↓
API Call: POST /api/convert/word
    ↓
Backend: ConversionApiController@convert
    ↓
Creates: ConversionJob record (status: pending)
    ↓
Dispatches: ProcessConversion Job to Queue
    ↓
Response: Returns job ID
    ↓
Frontend: Starts polling /api/conversions/{jobId}/status
```

### Step 3: Background Processing
```
Queue Worker: Processes ProcessConversion job
    ↓
Job: Gets uploaded file from Media Library
    ↓
Service: PdfToWordConverter@convert()
    ↓
Extracts: PDF text with formatting
    ↓
Creates: Word document using PhpWord
    ↓
Saves: Converted file to Media Library
    ↓
Updates: ConversionJob status to 'completed'
```

### Step 4: Status Updates
```
Frontend: Polls /api/conversions/{jobId}/status every 2s
    ↓
Backend: Returns job status (pending/processing/completed/failed)
    ↓
Frontend: Updates UI with progress
    ↓
When Completed: Shows download button
    ↓
User: Clicks download
    ↓
API Call: GET /api/files/{fileId}/download
    ↓
Backend: Returns file download
```

---

## ➕ How to Add a New Tool

### Example: Adding "PDF to Excel" Converter

### Step 1: Create Service Converter

**File:** `app/Services/PdfConverter/PdfToExcelConverter.php`

```php
<?php

namespace App\Services\PdfConverter;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Exception;
use Illuminate\Support\Facades\Log;

class PdfToExcelConverter extends BasePdfConverter
{
    public function convert(string $pdfPath, string $outputPath): array
    {
        $this->validatePdf($pdfPath);

        try {
            // Extract text from PDF
            $extractedContent = $this->extractTextFromPdf($pdfPath);
            
            // Create Excel spreadsheet
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Add data to Excel
            $rows = explode("\n", $extractedContent['text']);
            foreach ($rows as $index => $row) {
                $cells = explode("\t", $row);
                foreach ($cells as $colIndex => $cell) {
                    $sheet->setCellValueByColumnAndRow($colIndex + 1, $index + 1, $cell);
                }
            }
            
            // Save Excel file
            $writer = new Xlsx($spreadsheet);
            $writer->save($outputPath);

            return [
                'file_size' => filesize($outputPath),
                'pages' => $extractedContent['pages'] ?? 1,
                'converted_at' => now()->toIso8601String(),
            ];
        } catch (Exception $e) {
            $this->log('PDF to Excel conversion failed', [
                'error' => $e->getMessage(),
                'pdf_path' => $pdfPath,
            ]);
            throw new Exception('Conversion failed: ' . $e->getMessage());
        }
    }

    protected function extractTextFromPdf(string $pdfPath): array
    {
        // Use smalot/pdfparser to extract text
        if (class_exists('\Smalot\PdfParser\Parser')) {
            $parser = new \Smalot\PdfParser\Parser();
            $pdf = $parser->parseFile($pdfPath);
            $text = $pdf->getText();
            $pages = $pdf->getPages();
            
            return [
                'text' => $text,
                'pages' => count($pages),
            ];
        }
        
        return ['text' => '', 'pages' => 1];
    }

    public function getTargetExtension(): string
    {
        return 'xlsx';
    }

    public function getTargetMimeType(): string
    {
        return 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
    }
}
```

### Step 2: Register Converter in API Controller

**File:** `app/Http/Controllers/Tool/Api/ConversionApiController.php`

Update the `getConverter()` method:

```php
protected function getConverter(string $type): ?object
{
    return match ($type) {
        'word', 'pdf-to-word' => new PdfToWordConverter(),
        'excel', 'pdf-to-excel' => new PdfToExcelConverter(), // ← Add this
        default => null,
    };
}
```

Don't forget to add the import at the top:

```php
use App\Services\PdfConverter\PdfToExcelConverter;
```

### Step 3: Create Frontend Converter

**File:** `resources/js/converters/pdf-to-excel.js`

```javascript
import { BaseConverter } from './base-converter.js';

export class PdfToExcelConverter extends BaseConverter {
    constructor() {
        super();
        this.conversionType = 'excel';
    }
}
```

### Step 4: Register in Converter Factory

**File:** `resources/js/converters/converter-factory.js`

```javascript
import { PdfToWordConverter } from './pdf-to-word.js';
import { PdfToExcelConverter } from './pdf-to-excel.js'; // ← Add this

export class ConverterFactory {
    static create(type) {
        switch (type) {
            case 'word':
            case 'pdf-to-word':
                return new PdfToWordConverter();
            case 'excel':
            case 'pdf-to-excel':
                return new PdfToExcelConverter(); // ← Add this
            default:
                throw new Error(`Unknown converter type: ${type}`);
        }
    }
}
```

### Step 5: Create Controller

**File:** `app/Http/Controllers/Tool/PdfToExcelController.php`

```php
<?php

namespace App\Http\Controllers\Tool;

class PdfToExcelController extends BaseConverterController
{
    protected function getConversionType(): string
    {
        return 'pdf-to-excel';
    }

    protected function getToolName(): string
    {
        return 'PDF to Excel Converter';
    }
}
```

### Step 6: Add Web Route

**File:** `routes/web.php`

```php
Route::prefix('tools')->name('tools.')->group(function () {
    Route::get('/pdf-to-word', [PdfToWordController::class, 'index'])->name('pdf-to-word');
    Route::get('/pdf-to-excel', [PdfToExcelController::class, 'index'])->name('pdf-to-excel'); // ← Add this
});
```

### Step 7: Create View

**File:** `resources/views/tools/pdf-to-excel.blade.php`

```php
@extends('layouts.app')

@section('content')
    <x-converter-layout 
        tool-name="PDF to Excel Converter"
        tool-description="Convert your PDF files to Excel spreadsheets (XLSX) for free. Extract tables and data easily."
    />
@endsection
```

### Step 8: Update Converter Manager (if needed)

**File:** `resources/js/converter-panel.js` or `resources/js/converters/converter-manager.js`

If your tool needs different behavior, update the initialization:

```javascript
// In converter-panel.js
init() {
    if (!this.converterManager) {
        this.converterManager = new ConverterManager('excel'); // ← Change type
        this.converterManager.init();
    }
}
```

---

## 📁 File Structure

```
app/
├── Http/
│   └── Controllers/
│       └── Tool/
│           ├── Api/
│           │   └── ConversionApiController.php  ← Handles all API requests
│           ├── BaseConverterController.php      ← Base controller for tools
│           └── PdfToWordController.php           ← Tool-specific controller
│
├── Jobs/
│   └── ProcessConversion.php                    ← Background job processor
│
└── Services/
    └── PdfConverter/
        ├── PdfConverterInterface.php            ← Interface all converters implement
        ├── BasePdfConverter.php                 ← Base class with common methods
        └── PdfToWordConverter.php               ← Specific converter implementation

resources/
├── js/
│   ├── components/
│   │   ├── file-upload.js                       ← File upload component
│   │   ├── pdf-preview.js                       ← Preview component
│   │   └── conversion-status.js                 ← Status component
│   │
│   └── converters/
│       ├── base-converter.js                    ← Base converter class
│       ├── converter-factory.js                 ← Factory to create converters
│       ├── converter-manager.js                  ← Manages conversion workflow
│       └── pdf-to-word.js                       ← Tool-specific converter
│
└── views/
    ├── components/
    │   ├── converter-layout.blade.php           ← Main layout component
    │   ├── file-upload-area.blade.php            ← Upload UI
    │   ├── pdf-preview-section.blade.php         ← Preview UI
    │   ├── conversion-status.blade.php           ← Status UI
    │   └── conversion-panel.blade.php           ← Control panel
    │
    └── tools/
        └── pdf-to-word.blade.php                ← Tool page

routes/
├── api.php                                       ← API routes
└── web.php                                       ← Web routes
```

---

## 📝 Step-by-Step Example: Adding PDF to PowerPoint

### 1. Create Converter Service

```bash
# Create file: app/Services/PdfConverter/PdfToPowerPointConverter.php
```

**Implementation:**
- Extend `BasePdfConverter`
- Implement `convert()`, `getTargetExtension()`, `getTargetMimeType()`
- Use PhpOffice\PhpPresentation for PowerPoint creation

### 2. Register in API Controller

```php
// In ConversionApiController@getConverter()
'excel', 'pdf-to-excel' => new PdfToExcelConverter(),
'powerpoint', 'pdf-to-powerpoint' => new PdfToPowerPointConverter(), // ← Add
```

### 3. Create Frontend Converter

```javascript
// resources/js/converters/pdf-to-powerpoint.js
import { BaseConverter } from './base-converter.js';

export class PdfToPowerPointConverter extends BaseConverter {
    constructor() {
        super();
        this.conversionType = 'powerpoint';
    }
}
```

### 4. Update Factory

```javascript
// In converter-factory.js
case 'powerpoint':
case 'pdf-to-powerpoint':
    return new PdfToPowerPointConverter();
```

### 5. Create Controller

```php
// app/Http/Controllers/Tool/PdfToPowerPointController.php
class PdfToPowerPointController extends BaseConverterController
{
    protected function getConversionType(): string
    {
        return 'pdf-to-powerpoint';
    }
    
    protected function getToolName(): string
    {
        return 'PDF to PowerPoint Converter';
    }
}
```

### 6. Add Route

```php
// routes/web.php
Route::get('/pdf-to-powerpoint', [PdfToPowerPointController::class, 'index'])
    ->name('pdf-to-powerpoint');
```

### 7. Create View

```php
// resources/views/tools/pdf-to-powerpoint.blade.php
@extends('layouts.app')

@section('content')
    <x-converter-layout 
        tool-name="PDF to PowerPoint Converter"
        tool-description="Convert PDF to PowerPoint presentations."
    />
@endsection
```

---

## 🔑 Key Points to Remember

### Backend (PHP/Laravel)
1. **Service Layer**: All converters must implement `PdfConverterInterface`
2. **Base Class**: Use `BasePdfConverter` for common functionality
3. **API Controller**: Register new converter in `getConverter()` method
4. **Queue Jobs**: `ProcessConversion` job handles all conversions automatically
5. **Media Library**: Spatie handles file storage - no manual file management needed

### Frontend (JavaScript/Alpine.js)
1. **Components**: Reusable components (file-upload, pdf-preview, conversion-status)
2. **Converter Manager**: Handles conversion workflow
3. **Factory Pattern**: Use `ConverterFactory` to create converters
4. **Events**: Uses CustomEvent API for component communication
5. **Base Converter**: All frontend converters extend `BaseConverter`

### Routes
1. **API Routes**: All tools share the same API endpoints (`/api/convert/{type}`)
2. **Web Routes**: Each tool has its own route (`/tools/{tool-name}`)
3. **Type Parameter**: The `{type}` in API route determines which converter to use

### Views
1. **Layout Component**: `converter-layout` is reusable for all tools
2. **Tool Page**: Each tool has a simple blade file that uses the layout
3. **Components**: All UI components are shared across tools

---

## 🎯 Quick Checklist for New Tool

- [ ] Create converter service class extending `BasePdfConverter`
- [ ] Register converter in `ConversionApiController@getConverter()`
- [ ] Create frontend converter class extending `BaseConverter`
- [ ] Register in `ConverterFactory`
- [ ] Create controller extending `BaseConverterController`
- [ ] Add web route in `routes/web.php`
- [ ] Create view file in `resources/views/tools/`
- [ ] Test upload → convert → download flow

---

## 📚 Additional Resources

### Required Composer Packages
- `phpoffice/phpword` - Word document creation
- `phpoffice/phpspreadsheet` - Excel/Spreadsheet creation
- `phpoffice/phppresentation` - PowerPoint creation
- `smalot/pdfparser` - PDF text extraction
- `spatie/laravel-medialibrary` - File storage

### Key Models
- `UploadedFile` - Stores file metadata
- `ConversionJob` - Tracks conversion status

### Event Flow
1. `file-uploaded` - Dispatched when file is uploaded
2. `start-conversion` - Dispatched when user clicks convert
3. `conversion-update` - Dispatched when status changes
4. `conversion-completed` - Dispatched when conversion finishes

---

## 💡 Tips

1. **Reuse Components**: The UI components are designed to work with any converter type
2. **Follow Patterns**: Use existing converters as templates
3. **Test Incrementally**: Test each step (upload, convert, download) separately
4. **Error Handling**: Always handle exceptions in converter services
5. **Logging**: Use `$this->log()` in converters for debugging
6. **Validation**: BasePdfConverter handles PDF validation automatically

---

## 🚀 Summary

Adding a new tool is straightforward:
1. Create the converter service (backend logic)
2. Register it in the API controller
3. Create frontend converter class
4. Add controller, route, and view
5. Done! The existing UI components work automatically

The architecture is designed for **maximum reusability** - most of the code is shared, you only need to implement the specific conversion logic.

---

**Last Updated:** December 2024
**Version:** 1.0

