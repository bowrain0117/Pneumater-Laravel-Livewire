<?php

namespace App\Http\Controllers;

use App\Enums\RegistryRoleType;
use App\Enums\RegistryType;
use App\Models\Registry;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RegistryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Renderable
    {
        return view('registries.index', [
            'role' => request()->input('role', RegistryRoleType::CUSTOMER),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Renderable
    {
        return view('registries.create', [
            'role' => request()->input('role', RegistryRoleType::CUSTOMER),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $rules = [
            'role' => 'required|integer',
            'type' => 'required|integer',
            'code' => 'required|string',
            'fiscal_code' => 'nullable|string',
            'vat_number' => 'nullable|string',
            'sdi' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'province' => 'nullable|string',
            'region' => 'nullable|string',
            'nation' => 'nullable|string',
            'is_shipment_on_different_location' => 'nullable|boolean',
            'denomination_shipment' => 'nullable|string',
            'address_shipment' => 'nullable|string',
            'city_shipment' => 'nullable|string',
            'postal_code_shipment' => 'nullable|string',
            'province_shipment' => 'nullable|string',
            'region_shipment' => 'nullable|string',
            'nation_shipment' => 'nullable|string',
            'phone' => 'nullable|string',
            'cellular' => 'nullable|string',
            'email' => 'nullable|string',
            'note' => 'nullable|string',
        ];

        if ($request->input('type') == RegistryType::COMPANY) {
            $rules = array_merge($rules, [
                'denomination' => 'required|string',
            ]);
        } else {
            $rules = array_merge($rules, [
                'name' => 'required|string',
                'surname' => 'required|string',
            ]);
        }

        $validated = $request->validate($rules);

        $registry = new Registry();
        $registry->fill($validated);
        $registry->created_by = auth()->user()->id;
        $registry->save();

        if ($request->input('user_id')) {
            $user = User::find($request->input('user_id'));
            $user->registry_id = $registry->id;
            $user->save();

            return redirect()->route('admin.users.index');
        }

        return redirect()->route('registries.index', ['role' => $registry->role == RegistryRoleType::CUSTOMER_AND_SUPPLIER ? RegistryRoleType::CUSTOMER : $registry->role])->with('success', 'Registry created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Registry $registry): Renderable
    {
        return view('registries.edit', [
            'registry' => $registry,
            'role' => $registry->role,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Registry $registry): RedirectResponse
    {
        $rules = [
            'role' => 'required|integer',
            'type' => 'required|integer',
            'code' => 'required|string',
            'fiscal_code' => 'nullable|string',
            'vat_number' => 'nullable|string',
            'sdi' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'province' => 'nullable|string',
            'region' => 'nullable|string',
            'nation' => 'nullable|string',
            'is_shipment_on_different_location' => 'nullable|boolean',
            'denomination_shipment' => 'nullable|string',
            'address_shipment' => 'nullable|string',
            'city_shipment' => 'nullable|string',
            'postal_code_shipment' => 'nullable|string',
            'province_shipment' => 'nullable|string',
            'region_shipment' => 'nullable|string',
            'nation_shipment' => 'nullable|string',
            'phone' => 'nullable|string',
            'cellular' => 'nullable|string',
            'email' => 'nullable|string',
            'note' => 'nullable|string',
        ];

        if ($request->input('type') == RegistryType::COMPANY) {
            $rules = array_merge($rules, [
                'denomination' => 'required|string',
            ]);
        } else {
            $rules = array_merge($rules, [
                'name' => 'required|string',
                'surname' => 'required|string',
            ]);
        }

        $validated = $request->validate($rules);
        $registry->update($validated);

        if (! $request->get('is_shipment_on_different_location', null)) {
            $registry->is_shipment_on_different_location = false;
            $registry->save();
        }

        if ($registry->user) {
            return redirect()->route('admin.users.index');
        }

        if ($request->has('redirectToReservationBill')) {
            return redirect()->route('reservations.bill', ['reservation' => $request->get('redirectToReservationBill')]);
        } elseif ($request->has('redirectToReservationEdit')) {
            return redirect()->route('reservations.edit', ['reservation' => $request->get('redirectToReservationEdit')]);
        } elseif ($request->has('redirectToShipmentBill')) {
            return redirect()->route('shipments.bill', ['shipment' => $request->get('redirectToShipmentBill')]);
        } elseif ($request->has('redirectToShipmentEdit')) {
            return redirect()->route('shipments.edit', ['shipment' => $request->get('redirectToShipmentEdit')]);
        } else {
            return redirect()->route('registries.index', ['role' => $registry->role == RegistryRoleType::CUSTOMER_AND_SUPPLIER ? RegistryRoleType::CUSTOMER : $registry->role])->with('success', 'Registry updated successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Registry $registry): RedirectResponse
    {
        $registry->delete();

        return redirect()->route('registries.index', ['role' => $registry->role == RegistryRoleType::CUSTOMER_AND_SUPPLIER ? RegistryRoleType::CUSTOMER : $registry->role])->with('success', 'Registry deleted successfully.');
    }
}
