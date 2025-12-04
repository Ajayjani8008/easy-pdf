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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('home');
})->name('home');

Route::prefix('tools')->group(function () {
    Route::get('/pdf-to-word', [ToolController::class, 'pdfToWord'])->name('tools.pdf_to_word');
    // Future:
    // Route::get('/word-to-pdf', [ToolController::class, 'wordToPdf'])->name('tools.word_to_pdf');
    // Route::get('/jpg-to-pdf', [ToolController::class, 'jpgToPdf'])->name('tools.jpg_to_pdf');
});

Route::get('/pdf-to-word', [PdfToWordController::class, 'index'])->name('tools.pdf-to-word');
