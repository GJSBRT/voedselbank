<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\EditProductRequest;
use App\Models\FoodPackage;
use Illuminate\Http\Request;
use App\Models\Product;
use Inertia\Inertia;
use Spatie\Searchable\Search;

class ProductController extends Controller
{

        //===============================================================================

        // Get all products and render them in the Show page in vue

        //===============================================================================
        public function index() 
        {
            $products = Product::with('category')->paginate();
    
            return Inertia::render('Products/Show',[
                'products' => $products
            ]);
        }

        //===============================================================================

        // This is a get function for the products
        // This makes you able to navigate to the new ( create product ) page in vue

        //===============================================================================
        public function new()
        {
            return Inertia::render('Products/New');
        }
        
        //===============================================================================

        // Validate the inputs of the fields by the requests
        // Then create the following product and redirect to the main products page with a banner message succes
        
        //===============================================================================
        public function create(CreateProductRequest $request)
        {
  
                Product::create([
                    'name' => $request->input('name'),
                    'ean_number' => $request->input('ean_number'),
                    'product_category_id' => $request->input('product_category_id'),
                    'quantity' => $request->input('quantity'),  
                ]);                

                return redirect()->route('products.index')->banner('Product opgeslagen!');
        }

        //===============================================================================

        // Get all the products, then find the specific product by its ID
        // Then render ( bring ) the product to the Update page in vue

        //===============================================================================
        public function view(int $productId)
        {
            $products = Product::all()->find($productId);

            return Inertia::render('Products/View',[
                'products' => $products
            ]);
        }

        //===============================================================================

        // Get the specific product by its ID otherwise fail the request
        // Validate all fields by the requests
        // Change the original field text to the input that has been filled and submitted
        // Redirect to the main page of products with a banner message succes

        //===============================================================================
        Public function update(EditProductRequest $request, int $productId)
        {
            $products = Product::where('id', $productId)->firstOrFail();
            $products->name = $request->input('name');
            $products->ean_number = $request->input('ean_number');
            $products->product_category_id = $request->input('product_category_id');
            $products->quantity = $request->input('quantity');
            $products->save();

            return redirect()->route('products.index')->banner('Product Veranderd!');

        }

        //===============================================================================

        // Get the specific product by its ID using the find function
        // Try to delete the product, if not possible then redirect to main page products with banner message why it failed
        // If try deleting succesfull then delete the product and proceed to the main page products with banner message succes

        //===============================================================================
        Public function delete(Request $request, int $productId)
        {

            $product = Product::find($productId);

            try
            {
                $product->delete();
                
            }catch(\Exception $error)
            {
                return redirect()->route('products.index')->dangerBanner('Product kan niet verwijderd worden, Dit product is verwerkt in een voedselpakket');
            }
            
            return redirect()->route('products.index')->banner('Product Verwijderd!');
        }

        public function search(Request $request) 
        {
            $results = (new Search())
                ->registerModel(Product::class, ['name', 'ean_number'])
                ->search($request->input('query'));

            return response()->json($results);
        }



    }