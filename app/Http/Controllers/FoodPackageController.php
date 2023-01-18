<?php

namespace App\Http\Controllers;

use App\Models\FoodPackage;
use Inertia\Inertia;

class FoodPackageController extends Controller
{
    public function index() 
    {
        $packages = FoodPackage::with(['customer', 'items'])->paginate();
        
        return Inertia::render('FoodPackages/Show', [
            'packages' => $packages,
        ]);
    }
}
