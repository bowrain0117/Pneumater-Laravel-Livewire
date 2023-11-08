<?php

namespace App\Http\Controllers\Shipment;

use App\Enums\Shop;
use App\Enums\TireCategory;
use App\Enums\TireStatus;
use App\Http\Controllers\Controller;
use App\Models\Shipment;
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
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Shipment $shipment): Renderable
    {
        return view('shipments.tire.create', compact('shipment'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Shipment $shipment): RedirectResponse
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

            $shipment->tires()->attach($tire, ['price_override' => $request->price_override]);
        } else {
            $tire->status = TireStatus::ToShip;
            $shipment->tires()->attach($tire, ['price_override' => $request->price_override]);
        }

        $tire->save();

        if ($request->price_override) {
            $shipment->price += $request->price_override;
        } elseif ($tire->category == TireCategory::NEW) {
            $shipment->price += $tire->getKijijiPrice() * $tire->amount;
        } else {
            $shipment->price += $tire->getKijijiPrice();
        }

        $shipment->save();
        $shipment->recalculatePackages();

        if ($request->has('redirectToBill')) {
            $destination = route('shipments.bill', ['shipment' => $shipment]);
        } else {
            $destination = route('shipments.edit', ['shipment' => $shipment]);
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
    public function edit(Shipment $shipment, Tire $tire): RedirectResponse|Renderable
    {
        if (auth()->user()->lock_price_edit) {
            return redirect()->route('shipments.edit', $shipment)->with('error', 'You are not allowed to edit prices');
        }

        $pivot = DB::table('shipment_tire')
            ->where('tire_id', $tire->id)
            ->where('shipment_id', $shipment->id)
            ->first();

        return view('shipments.tire.edit', compact('shipment', 'tire', 'pivot'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shipment $shipment, Tire $tire): RedirectResponse
    {
        $request->validate([
            'price_override' => 'nullable|numeric',
        ]);

        $pivot = DB::table('shipment_tire')
            ->where('tire_id', $tire->id)
            ->where('shipment_id', $shipment->id)
            ->first();

        if ($pivot->price_override) {
            $shipment->price -= $pivot->price_override;
        } elseif ($tire->category == TireCategory::NEW) {
            $shipment->price -= $tire->getKijijiPrice() * $tire->amount;
        } else {
            $shipment->price -= $tire->getKijijiPrice();
        }

        if ($request->price_override) {
            $shipment->price += $request->price_override;
        } elseif ($tire->category == TireCategory::NEW) {
            $shipment->price += $tire->getKijijiPrice() * $tire->amount;
        } else {
            $shipment->price += $tire->getKijijiPrice();
        }

        $shipment->save();

        $shipment->tires()->updateExistingPivot($tire, ['price_override' => $request->price_override], false);

        if ($request->has('redirectToBill')) {
            $destination = route('shipments.bill', ['shipment' => $shipment]);
        } else {
            $destination = route('shipments.edit', ['shipment' => $shipment]);
        }

        return redirect($destination);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shipment $shipment, Tire $tire): RedirectResponse
    {
        $pivot = DB::table('shipment_tire')
            ->where('tire_id', $tire->id)
            ->where('shipment_id', $shipment->id)
            ->first();

        if ($pivot->price_override) {
            $shipment->price -= $pivot->price_override;
        } elseif ($tire->category == TireCategory::NEW) {
            $shipment->price -= $tire->getKijijiPrice() * $tire->amount;
        } else {
            $shipment->price -= $tire->getKijijiPrice();
        }

        $shipment->tires()->detach($tire);

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

        $shipment->save();
        $shipment->recalculatePackages();

        if (request()->has('redirectToBill')) {
            $destination = route('shipments.bill', ['shipment' => $shipment]);
        } else {
            $destination = route('shipments.edit', ['shipment' => $shipment]);
        }

        return redirect($destination);
    }
}
