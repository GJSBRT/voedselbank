<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Spatie\Searchable\Search;

class ProductController extends Controller
{
    public function search(Request $request) 
    {
        $results = (new Search())
            ->registerModel(Product::class, ['name', 'ean_number'])
            ->search($request->input('query'));

        return response()->json($results);
    }

}
