<?php

namespace App\Http\Controllers;

use App\Models\FoodPackage;
use App\Models\FoodPackageItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FoodPackageController extends Controller
{
    public function index() {
        $packages = FoodPackage::with(['customer', 'items'])->orderBy('retrieved_at')->paginate();   
        
        return Inertia::render('FoodPackages/Show', [
            'packages' => $packages,
        ]);
    }
    
    public function new() {
        return Inertia::render('FoodPackages/New');
    }
    
    public function view(int $foodPackageId) {
        $foodPackage = FoodPackage::with(['customer'])->find($foodPackageId);
        $packageItems = FoodPackageItem::where('food_package_id', $foodPackageId)->get();
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

    public function create(Request $request) {
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

        $packages = FoodPackage::with(['customer', 'items'])->paginate(); 

        return Inertia::render('FoodPackages/Show', [
            'packages' => $packages,
        ]);
    }

    public function update(Request $request, int $foodPackageId) {
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

        $packages = FoodPackage::with(['customer', 'items'])->paginate(); 

        return Inertia::render('FoodPackages/Show', [
            'packages' => $packages,
        ]);
    }
}
