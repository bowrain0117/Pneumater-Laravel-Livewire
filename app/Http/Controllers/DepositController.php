<?php

namespace App\Http\Controllers;

use App\Enums\DepositStatus;
use App\Models\Deposit;
use App\Models\Reservation;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('verified');
    }

    public function index(): Renderable
    {
        return view('deposits.index');
    }

    public function create(): Renderable
    {
        return view('deposits.create');
    }

    public function edit(Request $request, Deposit $deposit): Renderable
    {
        return view('deposits.edit', ['deposit' => $deposit, 'reservation' => $request->reservation]);
    }

    public function update(Request $request, Deposit $deposit)
    {
        $validated = $request->validate([
            'registry_id' => 'required|exists:registries,id',
            'car_model' => 'required|string|max:255',
            'license_plate' => 'required|string|max:255',
            'note' => 'sometimes|nullable|string',
        ]);

        $deposit->fill($validated);
        $deposit->save();
        if ($request->has('redirectToBill')) {
            $destination = route('reservations.bill', ['reservation' => $request->reservation]);
        } else {
            $destination = route('deposits.index');
        }
        return redirect($destination);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'registry_id' => 'required|exists:registries,id',
            'car_model' => 'required|string|max:255',
            'license_plate' => 'required|string|max:255',
            'note' => 'sometimes|nullable|string',
        ]);

        $deposit = new Deposit;
        $deposit->fill($validated);
        $deposit->status = DepositStatus::Available;
        $deposit->save();

        return redirect()->route('deposits.edit', $deposit);
    }

    public function destroy(Deposit $deposit)
    {
        $deposit->tires()->delete();
        $deposit->delete();

        return redirect()->route('deposits.index');
    }
}
