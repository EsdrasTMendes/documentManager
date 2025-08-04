<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ProductLoanController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DocumentController::class, 'index'])->name('dashboard');


    Route::get('/documents/{id}/download/{type}', [DocumentController::class, 'download'])->name('documents.download');
    Route::get('/documents/{id}/edit', [DocumentController::class, 'edit'])->name('documents.edit');
    Route::put('/documents/{id}/update', [DocumentController::class, 'update'])->name('documents.update');
    Route::delete('/documents/{id}', [DocumentController::class, 'destroy'])->name('documents.destroy');


    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');



    Route::get('/product_loans', [ProductLoanController::class, 'index'])->name('product_loans.index');
    Route::get('/product_loans/{productLoan}', [ProductLoanController::class, 'show'])->name('product_loans.show');
});


require __DIR__.'/auth.php';
