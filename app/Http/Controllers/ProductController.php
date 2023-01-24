<?php

namespace App\Http\Controllers;

use App\Classes\Role;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\EditProductRequest;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\Searchable\Search;

class ProductController extends Controller
{

   //================================================================================

   // Check the role of the user
   // If user does not have the right role for this action redirect to dashboard with banner message unauthorized
   // If user does have the right role for this action then render the page with products in vue

   //================================================================================
    public function index(Request $request)
    {
        $permission = Role::checkPermission($request->user(), 'products:read');
        if ($permission) {return $permission;}

        // Return the products depending on the queries.
        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('name', 'LIKE', "%{$value}%")
                        ->orWhere('ean_number', 'LIKE', "%{$value}%");
                });
            });
        });

        $products = QueryBuilder::for(Product::class)
            ->with('category')
            ->allowedFilters($globalSearch)
            ->allowedSorts(['quantity'])
            ->paginate()
            ->withQueryString();

        return Inertia::render('Products/Show', [
            'products' => $products,
        ]);
    }

   //================================================================================

   // Check the role of the user
   // If the user does have the right role for this action, redirect to the create page in vue and get all product categories
   // If the user does not have the right role for this action, redirect to dashboard with banner message unauthorized

   //================================================================================
    public function new(Request $request)
    {
        $permission = Role::checkPermission($request->user(), 'products:create');
        if ($permission)
        {
            return $permission;
        }

        $productCategories = ProductCategory::whereNot('name', 'deleted')->get();

        return Inertia::render('Products/New',[
            'product_categories' => $productCategories,
        ]);
    }

   //================================================================================

   // Check the role of the user
   // If user does not have the right role for this action redirect to dashboard with banner message
   // If user does have the right role for this action then create the product thats filled in the field and submitted
   // After succesfully creating a product redirect to the main page of products with banner message succes

   //================================================================================
    public function create(CreateProductRequest $request)
    {
        $permission = Role::checkPermission($request->user(), 'products:create');
        if ($permission)
        {
            return $permission;
        }

        Product::create([
            'name' => $request->input('name'),
            'ean_number' => $request->input('ean_number'),
            'product_category_id' => $request->input('product_category_id'),
            'quantity' => $request->input('quantity'),
        ]);

        return redirect()->route('products.index')->banner('Product opgeslagen!');
    }


   //================================================================================

   // Check the role of the user
   // If user does not have the right role for this action redirect to dashboard with banner message
   // If user does have the right role for this continue
   // Get all products and find the specific product by its ID using find function
   // Get all the product categories
   // Render all the specific product and all the categories in the edit page in vue

   //================================================================================


    public function view(Request $request, $productId)
    {
        $permission = Role::checkPermission($request->user(), 'products:read');
        if ($permission)
        {
            return $permission;
        }

        // Try to get the product, else gives a 404 back instead of a 500 error.
        $products = Product::where('id', $productId)->firstOrFail();
        $productCategories = ProductCategory::whereNot('name', 'deleted')->get();

        return Inertia::render('Products/View', [
            'products' => $products,
            'product_categories' => $productCategories,
        ]);
    }


   //================================================================================

   // Check the role of the user
   // If user does not have the right role for this action redirect to dashboard with banner message
   // If user does have the right role for this action then continue
   // Get the specific product by its ID, otherwise stop / fail the request
   // If succesfull getting the product continue
   // Get the original products value and change it to the new value thats filled in the input fields
   // After submitting redirect to main page with banner message succes

   //================================================================================

    public function update(EditProductRequest $request, $productId)

    {
        $permission = Role::checkPermission($request->user(), 'products:update');
        if ($permission)
        {
            return $permission;
        }

        // Try to get the product, else gives a 404 back instead of a 500 error.
        $products = Product::where('id', $productId)->firstOrFail();
        $products->name = $request->input('name');
        $products->ean_number = $request->input('ean_number');
        $products->product_category_id = $request->input('product_category_id');
        $products->quantity = $request->input('quantity');
        $products->save();

        return redirect()->route('products.index')->banner('Product Veranderd!');

    }


   //================================================================================

   // Check the role of the user
   // If user does not have the right role for this action redirect to dashboard with banner message
   // If user does have the right role for this action then continue
   // Find the specific product by its ID using find function
   // Try to delete that specific product
   // If succes then redirect to main products page with banner message succesfully deleted
   // If failed then redirect to main products page with banner message why it failed using Exception method ( avoids for example internal error 500 )

   //================================================================================

    public function delete(Request $request, $productId)
    {
        $permission = Role::checkPermission($request->user(), 'products:delete');
        if ($permission)
        {
            return $permission;
        }

        // Try to get the product, else gives a 404 back instead of a 500 error.
        $product = Product::where('id', $productId)->firstOrFail();

        try
        {
            $product->delete();
        } catch (\Exception $error)
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
