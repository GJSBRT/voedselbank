<?php

namespace App\Http\Controllers;

use App\Classes\Role;
use App\Http\Requests\RegisterCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use App\Models\FoodPackage;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\Searchable\Search;

class CustomerController extends Controller
{
    //Get a full list of all customers
    public function index(Request $request)
    {
        $permission = Role::checkPermission($request->user(), 'customers:read');
        if ($permission) { return $permission; }

        // Return the costumers depending on the queries.
        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('first_name', 'LIKE', "%{$value}%")
                        ->orWhere('last_name', 'LIKE', "%{$value}%")
                        ->orWhere('phone_number', 'LIKE', "%{$value}%");
                });
            });
        });

        $customers = QueryBuilder::for(Customer::class)
            ->allowedFilters([$globalSearch])
            ->where('first_name', '!=', 'deleted')
            ->paginate()
            ->withQueryString();

        return Inertia::render("Customers/Show", [
            'customers' => $customers,
        ]);
    }

    //This function sends you straight to the register form for creating customers
    public function new(Request $request)
    {
        $permission = Role::checkPermission($request->user(), 'customers:create');
        if ($permission) { return $permission; }

        return Inertia::render("Customers/New");
    }

    //This function let's you create a customer
    public function create(RegisterCustomerRequest $request)
    {
        $permission = Role::checkPermission($request->user(), 'customers:create');
        if ($permission) { return $permission; }

        Customer::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'address' => $request->input('address'),
            'adult_amount' => $request->input('adult_amount'),
            'child_amount' => $request->input('child_amount'),
            'baby_amount' => $request->input('baby_amount'),
            'notes' => $request->input('notes'),
        ]);

        return redirect()->route('customers.index')->banner('Klant toegevoegd');

    }

    public function delete(Request $request, $customerId)
    {
        $permission = Role::checkPermission($request->user(), 'customers:delete');
        if ($permission) { return $permission; }

        //search the customer you want to delete
        $customer = Customer::where('id', $customerId)->firstOrFail();
        $customer->update([
            'first_name' => 'Deleted',
            'last_name' => 'Deleted',
        ]);

        return redirect()->route('customers.index')->banner('Klant is succesvol verwijderd');
    }

    public function view(Request $request, $customerId)
    {
        $permission = Role::checkPermission($request->user(), 'customers:read');
        if ($permission) { return $permission; }

        // Try to get the customer, else gives a 404 back instead of a 500 error.
        $customer = Customer::where('id', $customerId)->firstOrFail();

        return Inertia::render('Customers/View', [
            'customer' => $customer
        ]);
    }

    //Update customers in the same form as the register function
    public function update(UpdateCustomerRequest $request, $customerId)
    {
        $permission = Role::checkPermission($request->user(), 'customers:update');
        if ($permission) { return $permission; }

        // Try to get the customer, else gives a 404 back instead of a 500 error.
        $customer = Customer::where('id', $customerId,)->firstOrFail();

        // Updates the customer
        $input = $request->all();
        $customer->fill($input)->save();

        return redirect()->route('customers.index')->banner('Klant gewijzigd');
    }

    public function search(Request $request)
    {
        $results = (new Search())
            ->registerModel(Customer::class, ['first_name', 'last_name'])
            ->search($request->input('query'));

        return response()->json($results);
    }

    // Returns a PDF of the user data
    public function export(Request $request, $customerId)
    {
        $permission = Role::checkPermission($request->user(), 'customers:read');
        if ($permission) { return $permission; }

        // Try to get the customer, else gives a 404 back instead of a 500 error.
        $customer = Customer::where('id', $customerId)->with('foodPackages')->firstOrFail();
        $foodPackages = FoodPackage::where('customer_id', $customerId)->with('items')->get();

        foreach($foodPackages as $foodPackage) {
            foreach($foodPackage->items as $item) {
                $item->product = Product::where('id', $item->product_id)->first();
            }
        }

        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadView('pdf/pdf', compact('customer', 'foodPackages'));
        return $pdf->stream('account_gegevens_' . $customer->first_name . '_' . $customer->id . '.pdf');
    }
}
