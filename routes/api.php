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
