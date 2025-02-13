<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
    Route::get('/catalog/show/{id}', [CatalogController::class, 'show'])->name('catalog.show');
    Route::get('/catalog/create', [CatalogController::class, 'create'])->name('catalog.create');
    Route::get('/catalog/edit/{id}', [CatalogController::class, 'edit'])->name('catalog.edit');

    Route::post('/catalog/store', [CatalogController::class, 'store'])->name('catalog.store');
    Route::put('/catalog/update/{id}', [CatalogController::class, 'update'])->name('catalog.update');
    
    Route::put('/catalog/rent/{id}', [CatalogController::class, 'rent'])->name('catalog.rent');
    Route::put('/catalog/return/{id}', [CatalogController::class, 'return'])->name('catalog.return');
    Route::delete('/catalog/delete/{id}', [CatalogController::class, 'delete'])->name('catalog.delete');
});

require __DIR__.'/auth.php';
