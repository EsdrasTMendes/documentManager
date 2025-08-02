<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ProductLoanController;
use App\Http\Controllers\ProductController;


Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', [DocumentController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::resource('documents', DocumentController::class);
    Route::get('documents/{document}/download/{type}', [DocumentController::class, 'download'])->name('documents.download');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('product_loans', ProductLoanController::class)->except(['edit', 'update']);
});

Route::middleware(['auth'])->group(function () {
    Route::resource('products', ProductController::class)->only(['create', 'store']);
});

require __DIR__.'/auth.php';
