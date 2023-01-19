<?php

namespace App\Http\Controllers;

use App\Models\FoodPackage;
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
                Product::create([
                    'name' => $request->input('name'),
                    'ean_number' => $request->input('ean_number'),
                    'product_category_id' => $request->input('product_category_id'),
                    'quantity' => $request->input('quantity'),  
                ]);

                return redirect()->route('product.index')->banner('Product opgeslagen!');
        }

        public function Edit(int $productId)
        {
            $products = Product::all()->find($productId);

            return Inertia::render('Products/Edit',[
                'products' => $products
            ]);
        }

        // Edit a product
        Public function EditProduct(Request $request, int $productId)
        {
            $products = Product::where('id', $productId)->firstOrFail();
            $products->name = $request->input('name');
            $products->ean_number = $request->input('ean_number');
            $products->product_category_id = $request->input('product_category_id');
            $products->quantity = $request->input('quantity');
            $products->save();

            return redirect()->route('product.index')->banner('Product Veranderd!');

        }

        // Delete a product
        Public function DeleteProduct(Request $request, int $productId)
        {

            $product = Product::find($productId);

            try
            {
                $product->delete();
                
            }catch(\Exception $error)
            {
                return redirect()->route('product.index')->dangerBanner('Product kan niet verwijderd worden, Dit product is verwerkt in een voedselpakket');
            }
            
            return redirect()->route('product.index')->banner('Product Verwijderd!');
        }
}
