<?php

namespace App\Http\Controllers;

use App\Classes\Role;
use App\Http\Requests\CreateDeliveryRequest;
use App\Http\Requests\UpdateDeliveryRequest;
use App\Models\Delivery;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DeliveryController extends Controller
{
    public function index(Request $request)
    {
        $permission = Role::checkPermission($request->user(), 'deliveries:read');
        if ($permission) { return $permission; }

        $page = substr($request->query('page'), 0, 1);

        $showDelivered = $request->query('show-delivered') ?? true;

        $delivered = Delivery::with('supplier')
            ->whereNotNull('delivered_at')
            ->orderBy('expected_at')
            ->paginate();

        $notDelivered = Delivery::with('supplier')
            ->whereNull('delivered_at')
            ->orderBy('expected_at')
            ->paginate();

        $deliveries = [
            'delivered' => $delivered,
            'not_delivered' => $notDelivered,
        ];

        return Inertia::render('Deliveries/Show', [
            'deliveries' => $deliveries,
            'page' => $page,
            'show_delivered' => $showDelivered
        ]);
    }

    public function new(Request $request)
    {
        $permission = Role::checkPermission($request->user(), 'deliveries:create');
        if ($permission) { return $permission; }

        $suppliers = Supplier::all();

        return Inertia::render('Deliveries/New', [
            'suppliers' => $suppliers
        ]);
    }

    public function create(CreateDeliveryRequest $request)
    {
        $permission = Role::checkPermission($request->user(), 'deliveries:create');
        if ($permission) { return $permission; }

        $delivery = Delivery::create([
            'supplier_id' => $request->get('supplier_id'),
            'delivered_at' => $request->get('delivered_at'),
            'expected_at' => $request->get('expected_at'),
            'notes' => $request->get('notes'),
        ]);

        $supplier = $delivery->supplier()->first();

        return redirect()->route('deliveries.index')->banner('De levering van ' . $supplier->company_name . ' is succesvol ingepland!');
    }

    public function view(Request $request, $id)
    {
        $permission = Role::checkPermission($request->user(), 'deliveries:read');
        if ($permission) { return $permission; }

        $delivery = Delivery::with('supplier')->find($id);
        $suppliers = Supplier::all();

        return Inertia::render('Deliveries/View', [
            'delivery' => $delivery,
            'suppliers' => $suppliers,
        ]);
    }

    public function update($id, UpdateDeliveryRequest $request)
    {
        $permission = Role::checkPermission($request->user(), 'deliveries:update');
        if ($permission) { return $permission; }

        $request->validate([
            'supplier_id' => 'required',
            'expected_at' => 'required',
        ], [
            'supplier_id.required' => 'Dit is een verplicht veld.',
            'expected_at.required' => 'Het is verplicht om een verwachte bezorgdatum in te voeren.',
        ]);

        $delivery = Delivery::find($id);
        $supplier = $delivery->supplier()->first();

        $delivery->supplier_id = $request->get('supplier_id');

        if ($request->get('delivered_at') !== null) {
            $delivery->delivered_at = Carbon::parse($request->get('expected_at'))->toDateTimeString();
        }

        $delivery->expected_at = Carbon::parse($request->get('expected_at'))->toDateTimeString();
        $delivery->notes = $request->get('notes');

        $delivery->save();

        return redirect()->route('deliveries.index')->banner('De levering van ' . $supplier->company_name . ' is succesvol aangepast!');
    }

    public function delete(Request $request, $id)
    {
        $permission = Role::checkPermission($request->user(), 'deliveries:delete');
        if ($permission) { return $permission; }

        $delivery = Delivery::find($id);
        $delivery->delete();

        return redirect()->route('deliveries.index')->banner('De levering is succesvol geannuleerd!');
    }
}
