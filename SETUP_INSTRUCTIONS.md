# Setup Instructions

## Quick Start Guide

Follow these steps to get your PDF conversion tool up and running:

### 1. Install PHP Dependencies

```bash
composer install
```

This will install:
- `phpoffice/phpword` - For Word document generation
- `setasign/fpdi` - For PDF manipulation
- `setasign/fpdf` - PDF library

### 2. Install JavaScript Dependencies

```bash
npm install
```

### 3. Environment Setup

Make sure your `.env` file has the correct configuration:

```env
APP_NAME="Easy PDF"
APP_URL=http://localhost:8000

# Queue Configuration (for background processing)
QUEUE_CONNECTION=database

# File Storage
FILESYSTEM_DISK=local
```

### 4. Run Database Migrations

```bash
php artisan migrate
```

This creates:
- `uploaded_files` table - Stores uploaded PDF files
- `conversion_jobs` table - Tracks conversion progress

### 5. Create Storage Directories

```bash
# Windows (PowerShell)
New-Item -ItemType Directory -Force -Path storage\app\uploads
New-Item -ItemType Directory -Force -Path storage\app\conversions

# Linux/Mac
mkdir -p storage/app/uploads
mkdir -p storage/app/conversions
```

### 6. Build Frontend Assets

For development:
```bash
npm run dev
```

For production:
```bash
npm run build
```

### 7. Start Queue Worker

**IMPORTANT**: Conversions run in the background. You must start the queue worker:

```bash
php artisan queue:work
```

Or use Laravel's built-in queue system:
```bash
php artisan queue:listen
```

### 8. Start Development Server

In a new terminal:
```bash
php artisan serve
```

Visit: `http://localhost:8000/tools/pdf-to-word`

## Testing the Application

1. **Upload a PDF**
   - Go to `/tools/pdf-to-word`
   - Drag and drop a PDF file or click to browse
   - Click "Upload PDF"

2. **Convert**
   - After upload, click "Convert to Word"
   - Watch the status update in real-time
   - Wait for conversion to complete

3. **Download**
   - Once complete, click "Download"
   - Your converted Word document will download

## Troubleshooting

### Queue Not Processing

If conversions stay in "pending" status:
- Make sure queue worker is running: `php artisan queue:work`
- Check queue connection in `.env`: `QUEUE_CONNECTION=database`
- Check logs: `storage/logs/laravel.log`

### File Upload Fails

- Check file size (max 50MB)
- Verify `storage/app/uploads` directory exists and is writable
- Check PHP `upload_max_filesize` and `post_max_size` settings

### Conversion Fails

- Check that required PHP extensions are installed
- Verify PDF file is not corrupted
- Check `storage/logs/laravel.log` for error details

### JavaScript Not Working

- Make sure assets are built: `npm run build` or `npm run dev`
- Check browser console for errors
- Verify Alpine.js is loaded (check network tab)

## Production Deployment

1. **Set Environment**
   ```env
   APP_ENV=production
   APP_DEBUG=false
   ```

2. **Optimize**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

3. **Build Assets**
   ```bash
   npm run build
   ```

4. **Setup Queue Worker**
   - Use supervisor or systemd to keep queue worker running
   - Or use Laravel Horizon for queue management

5. **Setup File Cleanup**
   - Create a scheduled task to delete expired files
   - Or use Laravel's task scheduler

## Adding New Converters

See `ARCHITECTURE_PLAN.md` for detailed instructions on adding new conversion types.

## Support

For issues or questions, check:
- `ARCHITECTURE_PLAN.md` - Architecture overview
- `IMPLEMENTATION_SUMMARY.md` - Implementation details
- `IMPLEMENTATION_FILES.md` - Complete file list

