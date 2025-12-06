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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('tools')->name('tools.')->group(function () {
    Route::get('/pdf-to-word', [PdfToWordController::class, 'index'])->name('pdf-to-word');
    Route::get('/merge-pdf', [MergePdfController::class, 'index'])->name('merge-pdf');
    Route::get('/split-pdf', [SplitPdfController::class, 'index'])->name('split-pdf');
});
