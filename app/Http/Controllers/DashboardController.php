<?php

namespace App\Http\Controllers;

use App\Classes\Role;
use App\Models\Delivery;
use App\Models\FoodPackage;
use App\Models\FoodPackageItem;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request) 
    {
        $productPermission = Role::checkPermission($request->user(), 'products:read', false);
        $foodPackagePermission = Role::checkPermission($request->user(), 'food-packages:read', false);
        $supplierPermission = Role::checkPermission($request->user(), 'suppliers:read', false);
        $deliveryPermission = Role::checkPermission($request->user(), 'deliveries:read', false);
        
        $products = [
            'labels' => [],
            'data' => [],
        ];

        $packageCount = [
            'labels' => [],
            'data' => [],
        ];

        $statistics = [
            'suppliers' => 0,
            'undeliveredDeliveries' => 0,
            'unretreivedPackages' => 0,
            'productsAvailable' => 0,
        ];

        if ($productPermission && $foodPackagePermission) {
            $items = FoodPackageItem::selectRaw('product_id, count(*) as count')
                ->where('created_at', '>=', Carbon::now()->subDays(30))
                ->groupBy('product_id')
                ->orderBy('count', 'desc')
                ->limit(10)
                ->get();
            
            foreach($items as $item) {
                $product = Product::find($item->product_id);
                $products['labels'][] = $product->name;
                $products['data'][] = $item->count;
            }
        }

        if ($productPermission) {
            $statistics['productsAvailable'] = Product::where('quantity', '!=', 0)->count();
        }

        if ($foodPackagePermission) {
            $foodPackageItems = FoodPackage::selectRaw('DATE(created_at) as date, count(*) as count')
                ->where('created_at', '>=', Carbon::now()->subDays(30))
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->get();

            foreach($foodPackageItems as $item) {
                $packageCount['labels'][] = $item->date;
                $packageCount['data'][] = $item->count;
            }    
            
            $statistics['unretreivedPackages'] = FoodPackage::whereNull('retrieved_at')->count();
        }

        if ($supplierPermission) {
            $statistics['suppliers'] = Supplier::count();
        }

        if ($deliveryPermission) {
            $statistics['undeliveredDeliveries'] = Delivery::whereNull('delivered_at')->count();
        }

        return Inertia::render('Dashboard', [
            'products' => $products,
            'packageCount' => $packageCount,
            'statistics' => $statistics,
        ]);
    }
}
