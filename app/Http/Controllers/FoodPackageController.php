<?php

namespace App\Http\Controllers;

use App\Classes\Role;
use App\Http\Requests\CreateFoodPackageRequest;
use App\Models\FoodPackage;
use App\Models\FoodPackageItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\QueryBuilder\QueryBuilder;

class FoodPackageController extends Controller
{
    public function index(Request $request)
    {
        $permission = Role::checkPermission($request->user(), 'food-packages:read');
        if ($permission) { return $permission; }

        $packages = QueryBuilder::for(FoodPackage::class)
            ->with(['customer', 'items'])
            ->allowedSorts(['created_at'])
            ->orderBy('retrieved_at')
            ->paginate()
            ->withQueryString();

        return Inertia::render('FoodPackages/Show', [
            'packages' => $packages,
        ]);
    }

    public function new(Request $request)
    {
        $permission = Role::checkPermission($request->user(), 'food-packages:create');
        if ($permission) { return $permission; }

        return Inertia::render('FoodPackages/New');
    }

    public function view(Request $request, $foodPackageId)
    {
        $permission = Role::checkPermission($request->user(), 'food-packages:read');
        if ($permission) { return $permission; }


        $foodPackage = FoodPackage::with(['customer'])->where('id', $foodPackageId)->firstOrFail();
        $packageItems = $foodPackage->items();
        $products = [];

        foreach($packageItems as $packageItem) {
            array_push($products, $packageItem->product);
        }

        return Inertia::render('FoodPackages/View', [
            'foodPackage' => $foodPackage,
            'notes' => $foodPackage->notes,
            'customer' => $foodPackage->customer,
            'products' => $products,
        ]);
    }

    public function create(CreateFoodPackageRequest $request)
    {
        $permission = Role::checkPermission($request->user(), 'food-packages:create');
        if ($permission) { return $permission; }

        $notes = $request->input('notes');
        $customer = $request->input('customer');
        $products = $request->input('products');

        $foodPackage = FoodPackage::create([
            'customer_id' => $customer['id'],
            'notes' => $notes,
        ]);

        foreach($products as $product) {
            $dbProduct = Product::find($product['id']);

            if ($dbProduct->quantity < 1) {
                continue;
            }

            $foodPackage->addItem($product['id']);
            $dbProduct->decrement('quantity', 1);
        }

        return redirect()->route('food-packages.index')->banner('Pakket is successvol aangemaakt!');
    }

    public function update(Request $request, $foodPackageId)
    {
        $permission = Role::checkPermission($request->user(), 'food-packages:update');
        if ($permission) { return $permission; }

        $foodPackage = FoodPackage::where('id', $foodPackageId)->firstOrFail();
        $notes = $request->input('notes') ?? null;
        $customer = $request->input('customer') ?? null;
        $items = $request->input('products') ?? null;

        if ($notes) {
            $foodPackage->notes = $notes;
        }

        if ($customer) {
            $foodPackage->customer_id = $customer['id'];
        }

        $dbFoodPackages = FoodPackageItem::where('food_package_id', $foodPackageId)->get();
        foreach($dbFoodPackages as $dbFoodPackage) {
            $dbProduct = Product::find($dbFoodPackage->product_id);
            $dbProduct->increment('quantity', 1);
            $dbFoodPackage->delete();
        }

        foreach($items as $item) {
            $dbProduct = Product::where('id', $item['id'])->first();

            if ($dbProduct->quantity < 1) {
                continue;
            }

            $foodPackage->addItem($item['id']);
            $dbProduct->decrement('quantity', 1);
        }

        return redirect()->route('food-packages.index')->banner('Pakket is successvol aangepast!');
    }
}
