<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        $category = ProductCategory::paginate();
        return Inertia::render("ProductCategory/Show", [
            'category' => $category,
        ]);
    }
}
