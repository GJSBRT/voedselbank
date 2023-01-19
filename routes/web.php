<?php

use App\Http\Controllers\FoodPackageController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/food-packages', [FoodPackageController::class, 'index'])->name('food-package.index');
    Route::get('/quantity-products', [QuantityProductsController::class, 'index'])->name('quantity-products.index');
});