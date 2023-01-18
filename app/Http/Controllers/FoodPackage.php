<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class FoodPackage extends Controller
{
    public function index() {
        return Inertia::render('FoodPackages/Show');
    }
}
