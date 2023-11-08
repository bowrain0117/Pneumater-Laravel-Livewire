<?php

namespace App\Http\Controllers\Reservation;

use App\Enums\Shop;
use App\Enums\TireCategory;
use App\Enums\TireStatus;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Tire;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Reservation $reservation): Renderable
    {
        return view('reservations.tire.create', compact('reservation'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Reservation $reservation): RedirectResponse
    {
        $request->validate([
            'tire_id' => 'required|exists:App\Models\Tire,id',
            'amount' => 'required|integer',
            'price_override' => 'nullable|numeric',
        ]);

        $tire = Tire::findOrFail($request->tire_id);

        // removing tire form all shops
        if ($tire->listings()->where('shop', Shop::Subito)->count() > 0) {
            $tire->listings()->where('shop', Shop::Subito)->delete();
        }

        $tire->removeAllFromEbay();

        $tire->save();

        // if less than full amount is sold tire is splitted in two sets
        // 1 ($tire) -> contain remaining amount left
        // 2 ($tire_duplicate) -> new tire set that represet sold amount
        if ($tire->amount != $request->amount) {
            $tire_duplicate = Tire::create($tire->toArray());
            $tire_duplicate->amount -= $request->amount;
            $tire_duplicate->millimeters = 0;
            $tire_duplicate->millimeters_2 = 0;
            $tire_duplicate->dot = '';
            $tire_duplicate->rack_identifier = null;
            $tire_duplicate->rack_position = null;
            $tire_duplicate->recalculatePrices();
            $tire_duplicate->save();

            $tire->amount = $request->amount;
            $tire->status = TireStatus::ToShip;
            $tire->recalculatePrices();
            if (
                $tire->category == 3
                || $tire->category == 4
                || $tire->category == 5
            ) {
                $tire->duplicatePhotos($tire_duplicate);
            }

            $reservation->tires()->attach($tire, ['price_override' => $request->price_override]);
        } else {
            $tire->status = TireStatus::ToShip;
            $reservation->tires()->attach($tire, ['price_override' => $request->price_override]);
        }

        $tire->save();

        if ($request->price_override) {
            $reservation->price += $request->price_override;
        } elseif ($tire->category == TireCategory::NEW) {
            $reservation->price += $tire->getKijijiPrice() * $tire->amount;
        } else {
            $reservation->price += $tire->getKijijiPrice();
        }

        $reservation->amount_of_time_slot += $tire->calculateLabourTimeSlot();
        $reservation->save();
        $reservation->updateLabour();

        if ($request->has('redirectToBill')) {
            $destination = route('reservations.bill', ['reservation' => $reservation]);
        } else {
            $destination = route('reservations.edit', ['reservation' => $reservation]);
        }

        return redirect($destination);
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
    public function edit(Reservation $reservation, Tire $tire): Renderable
    {
        $pivot = DB::table('reservation_tire')
            ->where('tire_id', $tire->id)
            ->where('reservation_id', $reservation->id)
            ->first();

        return view('reservations.tire.edit', compact('reservation', 'tire', 'pivot'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation, Tire $tire): RedirectResponse
    {
        $request->validate([
            'price_override' => 'nullable|numeric',
        ]);

        $pivot = DB::table('reservation_tire')
            ->where('tire_id', $tire->id)
            ->where('reservation_id', $reservation->id)
            ->first();

        if ($pivot->price_override) {
            $reservation->price -= $pivot->price_override;
        } elseif ($tire->category == TireCategory::NEW) {
            $reservation->price -= $tire->getKijijiPrice() * $tire->amount;
        } else {
            $reservation->price -= $tire->getKijijiPrice();
        }

        if ($request->price_override) {
            $reservation->price += $request->price_override;
        } elseif ($tire->category == TireCategory::NEW) {
            $reservation->price += $tire->getKijijiPrice() * $tire->amount;
        } else {
            $reservation->price += $tire->getKijijiPrice();
        }

        $reservation->save();

        $reservation->tires()->updateExistingPivot($tire, ['price_override' => $request->price_override], false);

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
    public function destroy(Reservation $reservation, Tire $tire): RedirectResponse
    {
        $pivot = DB::table('reservation_tire')
            ->where('tire_id', $tire->id)
            ->where('reservation_id', $reservation->id)
            ->first();

        if ($pivot->price_override) {
            $reservation->price -= $pivot->price_override;
        } elseif ($tire->category == TireCategory::NEW) {
            $reservation->price -= $tire->getKijijiPrice() * $tire->amount;
        } else {
            $reservation->price -= $tire->getKijijiPrice();
        }
        $reservation->amount_of_time_slot -= $tire->calculateLabourTimeSlot();
        if ($reservation->price < 0) {
            $reservation->price = 0;
        }
        if ($reservation->amount_of_time_slot < 0) {
            $reservation->amount_of_time_slot = 1;
        }

        $reservation->tires()->detach($tire);

        $reservation->updateLabour();
        $reservation->save();

        if ($tire->ean && Tire::where('ean', $tire->ean)->where('status', TireStatus::Available)->count() > 0) {
            $merging_tire = Tire::where('ean', $tire->ean)->where('status', TireStatus::Available)->first();
            $merging_tire->amount = $merging_tire->amount + $tire->amount;
            $merging_tire->save();
            $tire->photos()->delete();
            $tire->delete();
        } else {
            $tire->status = TireStatus::Available;
            $tire->save();
        }

        if (request()->has('redirectToBill')) {
            $destination = route('reservations.bill', ['reservation' => $reservation]);
        } else {
            $destination = route('reservations.edit', ['reservation' => $reservation]);
        }

        return redirect($destination);
    }
}
