<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use App\Models\User;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class SupplierController extends Controller
{
    public function index()
    {

        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('id', 'LIKE', "%{$value}%")
                        ->orWhere('company_name', 'LIKE', "%{$value}%")
                        ->orWhere('phone_number', 'LIKE', "%{$value}%")
                        ->orWhere('contact_name', 'LIKE', "%{$value}%")
                        ->orWhere('email', 'LIKE', "%{$value}%");
                });
            });
        });

        $suppliers = QueryBuilder::for(Supplier::class)
            ->with('nextDeliveries')
            ->defaultSort('created_at')
            ->allowedSorts(['id','company_name', 'phone_number', 'contact_name','email'])
            ->allowedFilters(['id','company_name', 'phone_number', 'contact_name','email', $globalSearch])
            ->paginate()
            ->withQueryString();


        return Inertia::render('Suppliers/Show', [
            'suppliers' => $suppliers
        ])->table(function (InertiaTable $table) {
            $table->withGlobalSearch()
                ->column(key: 'id', label: '#', searchable: true, sortable: true)
                ->column(key: 'company_name', label: 'Bedrijfsnaam', searchable: true, sortable: true)
                ->column(key: 'phone_number', label: 'Telefoonnummer', searchable: true, sortable: true)
                ->column(key: 'contact_name', label: 'Contact persoon', searchable: true, sortable: true)
                ->column(key: 'email', label: 'E-mailadres', searchable: true, sortable: true)
                ->column(key: 'next_deliveries', label: 'Volgende levering' );
        });
    }

    public function new()
    {
        return Inertia::render('Suppliers/New');
    }

    public function create(Request $request)
    {
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

    public function view($id)
    {
        $supplier = Supplier::with('deliveries')->find($id);
        $deliveries = $supplier->deliveries()
            ->orderBy('expected_at', 'desc')
            ->paginate(5);

        return Inertia::render('Suppliers/View', [
            'supplier' => $supplier,
            'deliveries' => $deliveries
        ]);
    }

    public function update($id, Request $request)
    {
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

    public function delete($id)
    {
        $supplier = Supplier::find($id);
        $company_name = $supplier->company_name;
        $supplier->delete();

        return redirect()->route('suppliers.index')->banner('De Leverancier ' . $company_name . ' is succesvol verwijderd!');
    }
}
