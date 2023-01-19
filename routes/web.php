<?php

use App\Http\Controllers\FoodPackageController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use \App\Http\Controllers\Customer\CustomerController;

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/food-packages', [FoodPackageController::class, 'index'])->name('food-package.index');
    Route::get('/customers', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('/customers/new', [CustomerController::class, 'add'])->name('customer.add');
    Route::post('/customers/new', [CustomerController::class, 'registerCustomer'])->name('customer.registercustomer');
    Route::get('/customers/{customerId}', [CustomerController::class, 'view'])->name('customer.view');
    Route::patch('/customers/{customerId}', [CustomerController::class, 'update'])->name('customer.update');
    Route::get('/customers/{customerId}/delete', [CustomerController::class, 'confirmation'])->name('customer.confirmation');
    Route::delete('/customers/{customerId}/delete', [CustomerController::class, 'delete'])->name('customer.delete');
});
