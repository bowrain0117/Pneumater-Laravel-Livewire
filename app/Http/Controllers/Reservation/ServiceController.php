<?php

namespace App\Http\Controllers\Reservation;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Service;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Reservation $reservation)
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Reservation $reservation): Renderable
    {
        return view('reservations.service.create', ['reservation' => $reservation]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Reservation $reservation): RedirectResponse
    {
        $request->validate([
            'service_id' => 'required|exists:App\Models\Service,id',
            'amount' => 'required|integer',
            'price_override' => 'nullable|numeric',
        ]);

        $reservation->services()->attach([$request->service_id], ['amount' => $request->amount, 'price_override' => $request->price_override]);

        $service = Service::findOrFail($request->service_id);
        if ($request->price_override) {
            $reservation->price += $request->price_override;
        } else {
            $reservation->price += $service->price;
        }
        if (count($reservation->tires) == 0 && count($reservation->services) == 1) {
            $reservation->amount_of_time_slot = $service->amount_of_time_slot;
        } else {
            $reservation->amount_of_time_slot += $service->amount_of_time_slot;
        }
        $reservation->save();

        if ($request->has('redirectToBill')) {
            $destination = route('reservations.bill', ['reservation' => $reservation]);
        } else {
            $destination = route('reservations.edit', ['reservation' => $reservation]);
        }

        return redirect($destination);
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation, Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation, Service $service): Renderable
    {
        $pivot = DB::table('reservation_service')
            ->where('service_id', $service->id)
            ->where('reservation_id', $reservation->id)
            ->first();

        return view('reservations.service.edit', ['reservation' => $reservation, 'service' => $service, 'pivot' => $pivot]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation, Service $service): RedirectResponse
    {
        $request->validate([
            'amount' => 'required|integer',
            'price_override' => 'nullable|numeric',
        ]);

        $pivot = DB::table('reservation_service')
            ->where('service_id', $service->id)
            ->where('reservation_id', $reservation->id)
            ->first();

        if ($pivot->price_override) {
            $reservation->price -= $pivot->price_override;
        } else {
            $reservation->price -= $service->price;
        }

        if ($request->price_override) {
            $reservation->price += $request->price_override;
        } else {
            $reservation->price += $service->price;
        }

        $reservation->save();

        $reservation->services()->updateExistingPivot($service, ['amount' => $request->amount, 'price_override' => $request->price_override], false);

        if ($request->has('redirectToBill')) {
            $destination = route('reservations.bill', ['reservation' => $reservation]);
        } else {
            $destination = route('reservations.edit', ['reservation' => $reservation]);
        }

        return redirect($destination);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation, Service $service): RedirectResponse
    {
        $pivot = DB::table('reservation_service')
            ->where('service_id', $service->id)
            ->where('reservation_id', $reservation->id)
            ->first();

        if ($pivot->price_override) {
            $reservation->price -= $pivot->price_override;
        } else {
            $reservation->price -= $service->price;
        }
        $reservation->amount_of_time_slot -= $service->amount_of_time_slot;
        if ($reservation->price < 0) {
            $reservation->price = 0;
        }
        if ($reservation->amount_of_time_slot < 0) {
            $reservation->amount_of_time_slot = 1;
        }
        $reservation->save();

        $reservation->services()->detach($service);

        if (request()->has('redirectToBill')) {
            $destination = route('reservations.bill', ['reservation' => $reservation]);
        } else {
            $destination = route('reservations.edit', ['reservation' => $reservation]);
        }

        return redirect($destination);
    }
}
