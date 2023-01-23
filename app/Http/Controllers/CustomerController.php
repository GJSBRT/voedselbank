<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Searchable\Search;

class CustomerController extends Controller
{
    //Get a full list of all customers
    public function index()
    {
        $customers = Customer::where('first_name', '!=', 'deleted')->paginate();
        return Inertia::render("Customers/Show", [
            'customers' => $customers,
        ]);
    }

    //This function sends you straight to the register form for creating customers
    public function new()
    {
        return Inertia::render("Customers/New");

    }

    //This function let's you create a customer
    public function create(RegisterCustomerRequest $request)
    {
        $customer = Customer::create([
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

    public function delete(int $customerId)
    {
        //search the customer you want to delete
        $customer = Customer::all()->find($customerId);
        $customer->update([
            'first_name' => 'Deleted',
            'last_name' => 'Deleted',
        ]);

        return redirect()->route('customers.index')->banner('Klant is succesvol verwijderd');
    }

    public function view(int $customerId)
    {
        $customer = Customer::all()->find($customerId);

        return Inertia::render('Customers/View', [
            'customer' => $customer
        ]);
    }

    //Update customers in the same form as the register function
    public function update(UpdateCustomerRequest $request, int $customerId)
    {
        //Updates every column of costumer
        $customer = Customer::where('id', $customerId,)->firstOrFail();
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

    public function export($customerId)
    {
        $customer = Customer::where('id', $customerId)->firstOrFail();

        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadView('pdf/pdf', compact('customer'));
        return $pdf->stream('account_gegevens_' . $customer->first_name . '_' . $customer->id . '.pdf');
    }
}
