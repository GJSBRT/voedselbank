<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Searchable\Search;

class CustomerController extends Controller
{
    //Get a full list of all customers
    public function index()
    {
        $customers = Customer::paginate();
        return Inertia::render("Customers/Show", [
            'customers' => $customers,
        ]);
    }

    //This function sends you straight to the register form for creating customers
    public function add()
    {
        return Inertia::render("Customers/Add");

    }

    //This function let's you create a customer
    public function registerCustomer(Request $request)
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

        //Sends you back to the customers list
        $customers = Customer::paginate();
        return Inertia::render("Customers/Show", [
            'customers' => $customers,
        ]);
    }

    public function confirmation(int $customerId)
    {
        $costumer = Customer::all()->find($customerId);

        return Inertia::render('Customers/Confirmation', [
            'customer' => $costumer
        ]);

    }

    public function delete(int $customerId)
    {
        $costumer = Customer::all()->find($customerId);

        $costumer->delete();

        $customers = Customer::paginate();
        return Inertia::render("Customers/Show", [
            'customers' => $customers,
        ]);

    }

    public function view(int $customerId)
    {
        $customer = Customer::all()->find($customerId);

        return Inertia::render('Customers/View', [
            'customer' => $customer
        ]);
    }

    //Update customers in the same form as the register function
    public function update(Request $request, int $customerId)
    {
        $customer = Customer::where('id', $customerId,)->firstOrFail();
        $customer->first_name = $request->input('first_name');
        $customer->last_name = $request->input('last_name');
        $customer->email = $request->input('email');
        $customer->address = $request->input('address');
        $customer->adult_amount = $request->input('adult_amount');
        $customer->child_amount = $request->input('child_amount');
        $customer->baby_amount = $request->input('baby_amount') ;
        $customer->notes = $request->input('notes');
        $customer->save();



        $customers = Customer::paginate();
        return Inertia::render("Customers/Show", [
            'customers' => $customers,
        ]);


    }

    public function search(Request $request)
    {
        $results = (new Search())
            ->registerModel(Customer::class, ['first_name', 'last_name'])
            ->search($request->input('query'));

        return response()->json($results);
    }
}
