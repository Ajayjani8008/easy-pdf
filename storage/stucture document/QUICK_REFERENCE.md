# Quick Reference - Adding a New Tool

## 🚀 5-Minute Quick Start

### Step 1: Create Converter Service (Backend)
```php
// File: app/Services/PdfConverter/PdfToExcelConverter.php
class PdfToExcelConverter extends BasePdfConverter {
    public function convert($pdfPath, $outputPath): array {
        // Your conversion logic here
    }
    public function getTargetExtension(): string { return 'xlsx'; }
    public function getTargetMimeType(): string { return '...'; }
}
```

### Step 2: Register in API Controller
```php
// File: app/Http/Controllers/Tool/Api/ConversionApiController.php
protected function getConverter(string $type): ?object {
    return match ($type) {
        'word' => new PdfToWordConverter(),
        'excel' => new PdfToExcelConverter(), // ← Add this line
        default => null,
    };
}
```

### Step 3: Create Frontend Converter
```javascript
// File: resources/js/converters/pdf-to-excel.js
export class PdfToExcelConverter extends BaseConverter {
    constructor() {
        super();
        this.conversionType = 'excel';
    }
}
```

### Step 4: Register in Factory
```javascript
// File: resources/js/converters/converter-factory.js
case 'excel': return new PdfToExcelConverter(); // ← Add this
```

### Step 5: Create Controller
```php
// File: app/Http/Controllers/Tool/PdfToExcelController.php
class PdfToExcelController extends BaseConverterController {
    protected function getConversionType(): string { return 'pdf-to-excel'; }
    protected function getToolName(): string { return 'PDF to Excel Converter'; }
}
```

### Step 6: Add Route
```php
// File: routes/web.php
Route::get('/pdf-to-excel', [PdfToExcelController::class, 'index'])
    ->name('pdf-to-excel');
```

### Step 7: Create View
```php
// File: resources/views/tools/pdf-to-excel.blade.php
@extends('layouts.app')
@section('content')
    <x-converter-layout 
        tool-name="PDF to Excel Converter"
        tool-description="Convert PDF to Excel"
    />
@endsection
```

**Done!** Your tool is ready at `/tools/pdf-to-excel`

---

## 📊 Request Flow Diagram

```
┌─────────────┐
│   User      │
│  Uploads    │
│    PDF      │
└──────┬──────┘
       │
       ▼
┌─────────────────┐     POST /api/upload
│  file-upload.js │ ────────────────────┐
└────────┬────────┘                     │
         │                               ▼
         │                    ┌──────────────────────┐
         │                    │ ConversionApiController│
         │                    │      @upload          │
         │                    └──────────┬───────────┘
         │                               │
         │                               ▼
         │                    ┌──────────────────────┐
         │                    │  Spatie Media Library│
         │                    │    (File Storage)     │
         │                    └──────────┬───────────┘
         │                               │
         │                               ▼
         │                    Returns: file_id, name, size
         │                               │
         │                               │
         ▼                               ▼
┌─────────────────┐              ┌──────────────┐
│ Dispatches      │              │  Database    │
│ 'file-uploaded' │              │  UploadedFile │
│     event       │              │    Record     │
└────────┬────────┘              └──────────────┘
         │
         ▼
┌─────────────────┐
│ pdf-preview.js  │
│ Updates UI      │
└─────────────────┘

┌─────────────┐
│   User      │
│  Clicks     │
│  Convert    │
└──────┬──────┘
       │
       ▼
┌─────────────────┐     POST /api/convert/excel
│conversion-status│ ────────────────────┐
│  @startConversion│                     │
└────────┬────────┘                     │
         │                               ▼
         │                    ┌──────────────────────┐
         │                    │ ConversionApiController│
         │                    │      @convert         │
         │                    └──────────┬───────────┘
         │                               │
         │                               ▼
         │                    ┌──────────────────────┐
         │                    │  Creates ConversionJob│
         │                    │  (status: pending)    │
         │                    └──────────┬───────────┘
         │                               │
         │                               ▼
         │                    ┌──────────────────────┐
         │                    │  Dispatches Job      │
         │                    │  ProcessConversion   │
         │                    └──────────┬───────────┘
         │                               │
         │                               ▼
         │                    ┌──────────────────────┐
         │                    │  Queue Worker        │
         │                    │  Processes Job       │
         │                    └──────────┬───────────┘
         │                               │
         │                               ▼
         │                    ┌──────────────────────┐
         │                    │ PdfToExcelConverter  │
         │                    │    @convert()        │
         │                    └──────────┬───────────┘
         │                               │
         │                               ▼
         │                    ┌──────────────────────┐
         │                    │  Saves Excel File    │
         │                    │  to Media Library     │
         │                    └──────────┬───────────┘
         │                               │
         │                               ▼
         │                    ┌──────────────────────┐
         │                    │  Updates ConversionJob│
         │                    │  (status: completed) │
         │                    └──────────┬───────────┘
         │                               │
         │                               │
         ▼                               ▼
┌─────────────────┐              ┌──────────────┐
│ Polls Status     │◄────────────│  GET /api/   │
│ Every 2 seconds │              │conversions/  │
│                 │              │ {jobId}/status│
└────────┬────────┘              └──────────────┘
         │
         ▼
┌─────────────────┐
│ Updates UI      │
│ Shows Progress  │
└─────────────────┘
```

---

## 🔄 Component Communication

```
┌─────────────────┐
│ file-upload.js  │
│                 │
│ Dispatches:     │
│ 'file-uploaded' │──────────┐
└─────────────────┘          │
                             │
                             ▼
                    ┌─────────────────┐
                    │ pdf-preview.js  │
                    │ Listens & Updates│
                    └─────────────────┘
                             │
                             ▼
                    ┌─────────────────┐
                    │conversion-status│
                    │ Listens & Updates│
                    └─────────────────┘

┌─────────────────┐
│conversion-status│
│                 │
│ Dispatches:     │
│'start-conversion'│──────────┐
└─────────────────┘          │
                             │
                             ▼
                    ┌─────────────────┐
                    │converter-manager│
                    │ Handles Request │
                    └─────────────────┘
                             │
                             ▼
                    ┌─────────────────┐
                    │  API Call        │
                    │  /api/convert/   │
                    └─────────────────┘
```

---

## 📁 File Locations Quick Reference

| Component | File Location |
|-----------|--------------|
| **Backend Converter** | `app/Services/PdfConverter/{ToolName}Converter.php` |
| **API Controller** | `app/Http/Controllers/Tool/Api/ConversionApiController.php` |
| **Tool Controller** | `app/Http/Controllers/Tool/{ToolName}Controller.php` |
| **Frontend Converter** | `resources/js/converters/{tool-name}.js` |
| **Converter Factory** | `resources/js/converters/converter-factory.js` |
| **Tool View** | `resources/views/tools/{tool-name}.blade.php` |
| **Web Route** | `routes/web.php` |
| **API Route** | `routes/api.php` (usually no changes needed) |

---

## 🎯 Key Methods to Implement

### Backend Converter
```php
class YourConverter extends BasePdfConverter {
    // Required methods:
    public function convert($pdfPath, $outputPath): array
    public function getTargetExtension(): string
    public function getTargetMimeType(): string
    
    // Optional (inherited from BasePdfConverter):
    public function validatePdf($pdfPath): bool  // Already implemented
    protected function log($message, $context): void  // Already implemented
}
```

### Frontend Converter
```javascript
class YourConverter extends BaseConverter {
    constructor() {
        super();
        this.conversionType = 'your-type';  // Must match API route
    }
    // All other methods inherited from BaseConverter
}
```

### Tool Controller
```php
class YourController extends BaseConverterController {
    protected function getConversionType(): string {
        return 'your-conversion-type';  // Must match API route
    }
    
    protected function getToolName(): string {
        return 'Your Tool Name';
    }
}
```

---

## 🔍 Testing Checklist

After adding a new tool, test:

- [ ] **Check case studies** - Review existing tools (PDF to Word, Merge PDF, Split PDF, JPG to PDF) for patterns and edge cases
- [ ] File upload works
- [ ] File preview shows correctly
- [ ] Convert button appears
- [ ] Conversion starts when clicked
- [ ] Progress bar updates
- [ ] Status polling works
- [ ] Conversion completes successfully
- [ ] Download button appears
- [ ] File downloads correctly
- [ ] Error handling works (try invalid file)
- [ ] **State reset works** - Upload new file after completion resets UI properly
- [ ] **Multiple operations** - Can perform multiple conversions/splits/merges in sequence
- [ ] **Re-conversion works** - After download, settings remain available for adjustment and re-conversion (see JPG to PDF case study)
- [ ] **Settings persistence** - Settings are preserved when resetting conversion state

---

## 💡 Common Patterns

### Pattern 1: Simple Text Extraction
```php
// Extract text and save to target format
$text = $this->extractTextFromPdf($pdfPath);
// Process $text and save to $outputPath
```

### Pattern 2: Format-Specific Library
```php
// Use library like PhpWord, PhpSpreadsheet, etc.
$document = new LibraryClass();
// Add content from PDF
$writer = new Writer($document);
$writer->save($outputPath);
```

### Pattern 3: External API
```php
// Call external service
$response = $apiClient->convert($pdfPath);
file_put_contents($outputPath, $response);
```

---

## 🐛 Troubleshooting

| Issue | Solution |
|-------|----------|
| Converter not found | Check `getConverter()` method in API controller |
| Frontend not working | Check converter factory registration |
| Route not found | Check `routes/web.php` |
| File not downloading | Check Media Library file exists |
| Conversion fails | Check converter service logs |

---

**For detailed information, see `TOOL_DEVELOPMENT_GUIDE.md`**

