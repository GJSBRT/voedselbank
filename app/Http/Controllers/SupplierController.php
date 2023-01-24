<?php

namespace App\Http\Controllers;

use App\Classes\Role;
use App\Http\Requests\CreateSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $permission = Role::checkPermission($request->user(), 'suppliers:read');
        if ($permission) { return $permission; }

        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('company_name', 'LIKE', "%{$value}%")
                        ->orWhere('phone_number', 'LIKE', "%{$value}%")
                        ->orWhere('contact_name', 'LIKE', "%{$value}%");
                });
            });
        });

        $suppliers = QueryBuilder::for(Supplier::class)
            ->with('nextDeliveries')
            ->allowedFilters($globalSearch)
            ->paginate()
            ->withQueryString();

        $permission = Role::checkPermission($request->user(), 'suppliers:read');
        if ($permission) { return $permission; }

        return Inertia::render('Suppliers/Show', [
            'suppliers' => $suppliers
        ]);
    }

    public function new(Request $request)
    {
        $permission = Role::checkPermission($request->user(), 'suppliers:create');
        if ($permission) { return $permission; }

        return Inertia::render('Suppliers/New');
    }

    public function create(CreateSupplierRequest $request)
    {
        $permission = Role::checkPermission($request->user(), 'suppliers:create');
        if ($permission) { return $permission; }

        $supplier = Supplier::create([
            'company_name' => $request->get('company_name'),
            'address' => $request->get('address'),
            'email' => $request->get('email'),
            'phone_number' => $request->get('phone_number'),
            'contact_name' => $request->get('contact_name'),
            'notes' => $request->get('notes'),
        ]);

        return redirect()->route('suppliers.index')->banner('De Leverancier ' . $supplier->company_name . ' is succesvol toegevoegd!');
    }

    public function view(Request $request, $id)
    {
        $permission = Role::checkPermission($request->user(), 'suppliers:read');
        if ($permission) { return $permission; }

        // Try to get the supplier, else gives a 404 back instead of a 500 error.
        $supplier = Supplier::with('deliveries')->where('id', $id)->firstOrFail();

        $deliveries = $supplier->deliveries()
            ->orderBy('expected_at', 'desc')
            ->paginate(5);

        return Inertia::render('Suppliers/View', [
            'supplier' => $supplier,
            'deliveries' => $deliveries
        ]);
    }

    public function update($id, UpdateSupplierRequest $request)
    {
        $permission = Role::checkPermission($request->user(), 'suppliers:update');
        if ($permission) { return $permission; }

        // Try to get the supplier, else gives a 404 back instead of a 500 error.
        $supplier = Supplier::where('id', $id)->firstOrFail();

        $input = $request->all();
        $supplier->fill($input)->save();

        return redirect()->route('suppliers.index')->banner('De Leverancier ' . $supplier->company_name . ' is succesvol aangepast!');
    }

    public function delete(Request $request, $id)
    {
        $permission = Role::checkPermission($request->user(), 'suppliers:delete');
        if ($permission) { return $permission; }

        // Try to get the supplier, else gives a 404 back instead of a 500 error.
        $supplier = Supplier::where('id', $id)->firstOrFail();

        $company_name = $supplier->company_name;
        $supplier->delete();

        return redirect()->route('suppliers.index')->banner('De Leverancier ' . $company_name . ' is succesvol verwijderd!');
    }
}
