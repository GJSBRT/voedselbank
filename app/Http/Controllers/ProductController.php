<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Inertia\Inertia;

class ProductController extends Controller
{
        // Get all products
        public function index() 
        {
            $products = Product::with('category')->paginate();
    
            return Inertia::render('Products/Show',[
                'products' => $products
            ]);
        }

        // Get product by ID
        public function getProduct($id)
        {
            $products = Product::find($id);
            
            return Inertia::render('Products/Show',[
                'products' => $products
            ]);
        }

        // This is a get function for the products
        // This makes you able to navigate to the add page in vue
        public function Add()
        {
            return Inertia::render('Products/Add');
        }

        // Create a new product
        public function CreateProduct(Request $request)
        {
            $products = new Product();
            $products->name = $request->name;
            $products->ean_number = $request->ean_number;
            $products->product_category_id = $request->product_category;
            $products->quantity = $request->quantity;
            $products->save();

            return Inertia::render('Products/Add',[
                'products' => $products
            ]);
        }

        // Edit a product
        Public function EditProduct()
        {

        }

        // Delete a product
        Public function DeleteProduct()
        {

        }
}
