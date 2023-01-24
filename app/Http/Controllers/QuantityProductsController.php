<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Inertia\Inertia;

class QuantityProductsController extends Controller
{
    public function index() {
        $products = Product::with(['category'])->paginate();

        return Inertia::render('QuantityProducts/Show', [
            'products' => $products,
        ]);
    }
}
