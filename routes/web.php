<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tool\PdfToWordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Tool\MergePdfController;
use App\Http\Controllers\Tool\SplitPdfController;
use App\Http\Controllers\Tool\CompressPdfController;
use App\Http\Controllers\Tool\PdfToJpgController;
use App\Http\Controllers\Tool\JpgToPdfController;
use App\Http\Controllers\Tool\PdfToExcelController;
use App\Http\Controllers\Tool\WordToPdfController;
use App\Http\Controllers\Tool\PlaceholderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('tools')->name('tools.')->group(function () {
    Route::get('/pdf-to-word', [PdfToWordController::class, 'index'])->name('pdf-to-word');
    Route::get('/merge-pdf', [MergePdfController::class, 'index'])->name('merge-pdf');
    Route::get('/split-pdf', [SplitPdfController::class, 'index'])->name('split-pdf');
    Route::get('/compress-pdf', [CompressPdfController::class, 'index'])->name('compress-pdf');
    Route::get('/pdf-to-jpg', [PdfToJpgController::class, 'index'])->name('pdf-to-jpg');
    Route::get('/jpg-to-pdf', [JpgToPdfController::class, 'index'])->name('jpg-to-pdf');
    Route::get('/pdf-to-excel', [PdfToExcelController::class, 'index'])->name('pdf-to-excel');
    Route::get('/word-to-pdf', [WordToPdfController::class, 'index'])->name('word-to-pdf');
});

// Placeholder tool routes
Route::prefix('tools')->name('tools.')->group(function () {
    Route::get('/pdf-to-powerpoint', [PlaceholderController::class, 'pdfToPowerpoint'])->name('pdf-to-powerpoint');
    Route::get('/powerpoint-to-pdf', [PlaceholderController::class, 'powerpointToPdf'])->name('powerpoint-to-pdf');
    Route::get('/excel-to-pdf', [PlaceholderController::class, 'excelToPdf'])->name('excel-to-pdf');
    Route::get('/edit-pdf', [PlaceholderController::class, 'editPdf'])->name('edit-pdf');
    Route::get('/sign-pdf', [PlaceholderController::class, 'signPdf'])->name('sign-pdf');
    Route::get('/watermark-pdf', [PlaceholderController::class, 'watermarkPdf'])->name('watermark-pdf');
    Route::get('/rotate-pdf', [PlaceholderController::class, 'rotatePdf'])->name('rotate-pdf');
});

Route::prefix('pages')->name('pages.')->group(function () {
    Route::get('about', function () {
        return view('pages.about');
    })->name('about');
    Route::get('contact', [ContactController::class, 'index'])->name('contact');
    Route::post('contact', [ContactController::class, 'store'])->name('contact.store');
    
    // Footer pages
    Route::get('privacy-policy', [PageController::class, 'privacyPolicy'])->name('privacy-policy');
    Route::get('terms-conditions', [PageController::class, 'termsConditions'])->name('terms-conditions');
    Route::get('help', [PageController::class, 'help'])->name('help');
    Route::get('blog', [PageController::class, 'blog'])->name('blog');
    Route::get('developers', [PageController::class, 'developers'])->name('developers');
    Route::get('pricing', [PageController::class, 'pricing'])->name('pricing');
    Route::get('features', [PageController::class, 'features'])->name('features');
    Route::get('security', [PageController::class, 'security'])->name('security');
    Route::get('careers', [PageController::class, 'careers'])->name('careers');
    Route::get('press', [PageController::class, 'press'])->name('press');
});