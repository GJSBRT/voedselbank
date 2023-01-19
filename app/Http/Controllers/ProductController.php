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

        // This is a get function for the products
        // This makes you able to navigate to the add page in vue
        public function Add()
        {
            return Inertia::render('Products/Add');
        }

        // Create a new product
        public function CreateProduct(Request $request)
        {
            try
            {
                
                $request->validate([
                    'name' => 'required|unique:posts',
                    'ean_number' => 'required',
                    'product_category_id' => 'required',
                    'quantity' => 'required',
                ]);

                Product::create([
                    'name' => $request->input('name'),
                    'ean_number' => $request->input('ean_number'),
                    'product_category_id' => $request->input('product_category_id'),
                    'quantity' => $request->input('quantity'),  
                ]);
            }catch(\Exception $error)
            {
                return redirect()->route('product.Add')->dangerBanner('Dit product bestaat al');
            }
                

                return redirect()->route('product.index')->banner('Product opgeslagen!');
        }

        // Get the products find them by id and Make the edit page accesible in vue
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

        // Find a product by id and delete that product
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
