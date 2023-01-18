<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//Route::middleware([
//    'auth:sanctum',
//    config('jetstream.auth_session'),
//    'verified',
//])->group(function () {
    Route::get('/', function () {

        $role = \App\Models\FoodPackage::with('foodPackages')->find(2);

        dd($role);
        return Inertia::render('Dashboard');
    })->name('dashboard');
//});
