<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tool\Api\ConversionApiController;
use App\Http\Controllers\Tool\Api\SplitApiController;
use App\Http\Controllers\Tool\Api\MergeApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// File upload
Route::post('/upload', [ConversionApiController::class, 'upload'])->name('api.upload');

// File operations
Route::get('/files/{fileId}/preview', [ConversionApiController::class, 'preview'])->name('api.files.preview');
Route::get('/files/{fileId}/download', [ConversionApiController::class, 'download'])->name('api.files.download');

// Conversion operations
Route::post('/convert/{type}', [ConversionApiController::class, 'convert'])->name('api.convert');
Route::get('/conversions/{jobId}/status', [ConversionApiController::class, 'status'])->name('api.conversions.status');

// Merge PDF operations

Route::post('/merge/upload', [MergeApiController::class, 'uploadMultiple'])->name('api.merge.upload');
Route::post('/merge', [MergeApiController::class, 'merge'])->name('api.merge');

// Split PDF operations
Route::get('/split/page-count', [SplitApiController::class, 'getPageCount'])->name('api.split.page-count');
Route::post('/split', [SplitApiController::class, 'split'])->name('api.split');

// Compress PDF operations
use App\Http\Controllers\Tool\Api\CompressApiController;

Route::get('/compress/file-info', [CompressApiController::class, 'getFileInfo'])->name('api.compress.file-info');
Route::post('/compress', [CompressApiController::class, 'compress'])->name('api.compress');

// PDF to JPG operations
use App\Http\Controllers\Tool\Api\PdfToJpgApiController;

Route::get('/pdf-to-jpg/page-count', [PdfToJpgApiController::class, 'getPageCount'])->name('api.pdf-to-jpg.page-count');
Route::post('/pdf-to-jpg/convert', [PdfToJpgApiController::class, 'convert'])->name('api.pdf-to-jpg.convert');

// JPG to PDF operations
use App\Http\Controllers\Tool\Api\JpgToPdfApiController;

Route::post('/jpg-to-pdf/upload', [JpgToPdfApiController::class, 'uploadMultiple'])->name('api.jpg-to-pdf.upload');
Route::post('/jpg-to-pdf/convert', [JpgToPdfApiController::class, 'convert'])->name('api.jpg-to-pdf.convert');

// PDF to Excel operations
use App\Http\Controllers\Tool\Api\PdfToExcelApiController;

Route::get('/pdf-to-excel/info/{fileId}', [PdfToExcelApiController::class, 'getPdfInfo'])->name('api.pdf-to-excel.info');
Route::post('/pdf-to-excel/convert', [PdfToExcelApiController::class, 'convert'])->name('api.pdf-to-excel.convert');
