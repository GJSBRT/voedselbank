<?php

namespace App\Http\Controllers;

use App\Classes\Role;
use App\Http\Requests\CreateSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Delivery;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $permission = Role::checkPermission($request->user(), 'suppliers:read');
        if ($permission) { return $permission; }

        $suppliers = Supplier::with('nextDeliveries')->paginate();

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

        $supplier = Supplier::with('deliveries')->find($id);
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

        $request->validate([
            'company_name' => 'required',
            'address' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required|max:13',
            'contact_name' => 'required',
        ], [
            'company_name.required' => 'De bedrijfsnaam is een verplicht veld.',
            'address.required' => 'Het adres is een verplicht veld.',
            'email.required' => 'Het e-mailadres is een verplicht veld.',
            'email.email' => 'Vul een geldig e-mailadres in.',
            'phone_number.required' => 'Het telefoonnummer is een verplicht veld.',
            'phone_number.max' => 'Vul een geldig telefoonnummer in.',
            'contact_name.required' => 'Het contactpersoon is een verplicht veld.',
        ]);

        $supplier = Supplier::find($id);

        $input = $request->all();
        $supplier->fill($input)->save();

        return redirect()->route('suppliers.index')->banner('De Leverancier ' . $supplier->company_name . ' is succesvol aangepast!');
    }

    public function delete(Request $request, $id)
    {
        $permission = Role::checkPermission($request->user(), 'suppliers:delete');
        if ($permission) { return $permission; }

        $supplier = Supplier::find($id);
        $company_name = $supplier->company_name;
        $supplier->delete();

        return redirect()->route('suppliers.index')->banner('De Leverancier ' . $company_name . ' is succesvol verwijderd!');
    }
}
