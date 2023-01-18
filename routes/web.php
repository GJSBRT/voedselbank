<?php

use App\Http\Controllers\FoodPackage;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/food-package', [FoodPackage::class, 'index'])->name('food-package.index');
});