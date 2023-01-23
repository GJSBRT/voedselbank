<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\EditProductRequest;
use App\Models\Customer;
use App\Models\FoodPackage;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\Searchable\Search;

class ProductController extends Controller
{
        // Get all products
        public function index()
        {
            $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
                $query->where(function ($query) use ($value) {
                    Collection::wrap($value)->each(function ($value) use ($query) {
                        $query
                            ->orWhere('id', 'LIKE', "%{$value}%")
                            ->orWhere('name', 'LIKE', "%{$value}%")
                            ->orWhere('ean_number', 'LIKE', "%{$value}%");
                    });
                });
            });

            $products = QueryBuilder::for(Product::class)
                ->with('category')
                ->defaultSort('created_at')
                ->allowedSorts(['id','name', 'ean_number'])
                ->allowedFilters(['id','name', 'ean_number', $globalSearch])
                ->paginate()
                ->withQueryString();

//            $products = Product::with('category')->paginate();

            return Inertia::render('Products/Show',[
                'products' => $products
            ]);
        }

        // This is a get function for the products
        // This makes you able to navigate to the add page in vue
        public function new()
        {
            return Inertia::render('Products/New');
        }

        // Create a new product
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

        // Get the products find them by id and Make the edit page accesible in vue
        public function view(int $productId)
        {
            $products = Product::all()->find($productId);

            return Inertia::render('Products/View',[
                'products' => $products
            ]);
        }

        // Edit a product
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

        // Find a product by id and delete that product
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
