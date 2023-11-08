<?php

namespace App\Http\Controllers;

use App\Enums\Couriers;
use App\Enums\Shipment\PrintType;
use App\Enums\ShipmentStatus;
use App\Enums\TireStatus;
use App\Enums\User\CustomerType;
use App\Models\Shipment;
use App\Models\Tire;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ShipmentController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('verified');
    }

    public function index(): Renderable
    {
        return view('shipments.index');
    }

    public function create(): Renderable
    {
        return view('shipments.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validate = $request->validate([
            'registry_id' => 'required|exists:App\Models\Registry,id',
            'source' => 'sometimes|nullable|string',
            'estimated_departure' => 'sometimes|nullable|date',
            'payment_type' => 'nullable|numeric',
            'note' => 'sometimes|nullable|string',
            'courier' => 'sometimes|nullable|integer',
            'price' => 'required',
            'deposit' => 'required',
            'packages' => 'required|numeric',
            'contextual_pickup' => 'nullable|boolean',
            'stationary_storage' => 'nullable|boolean',
            'to_invoice' => 'nullable|boolean',
        ]);
        $shipment = new Shipment();
        $shipment->fill($validate);
        $shipment->created_by = auth()->user()->id;
        if ($shipment->estimated_departure != null) {
            $shipment->status = ShipmentStatus::Confirmed;
        }
        $shipment->save();

        return redirect()->route('shipments.edit', $shipment);
    }

    /**
     * Print details of today shipments
     */
    public function print(): Renderable
    {
        $shipments = Shipment::where('status', ShipmentStatus::Confirmed);

        switch (request()->get('type')) {
            case PrintType::EXTERNAL_SHIPMENT:
                $shipments->where('courier', '!=', Couriers::PUA);
                break;
            case PrintType::INTERNAL_SHIPMENT:
                $shipments->where('courier', '=', Couriers::PUA);
                break;
        }
        $shipments = $shipments->where('estimated_departure', Carbon::today())->get();
        foreach ($shipments as $shipment) {
            $shipment->status = ShipmentStatus::PartiallyProcessed;
            $shipment->save();
        }

        return view('shipments.print', ['shipments' => $shipments]);
    }

    /**
     * Re-print details of today shipments
     */
    public function reprint(): Renderable
    {
        $shipments = Shipment::where('status', ShipmentStatus::PartiallyProcessed);

        switch (request()->get('type')) {
            case PrintType::EXTERNAL_SHIPMENT:
                $shipments->where('courier', '!=', Couriers::PUA);
                break;
            case PrintType::INTERNAL_SHIPMENT:
                $shipments->where('courier', '=', Couriers::PUA);
                break;
        }

        $shipments = $shipments->where('estimated_departure', Carbon::today())->get();

        return view('shipments.print', ['shipments' => $shipments]);
    }

    public function importEasyfatt(): Renderable
    {
        return view('shipments.import-easyfatt');
    }

    public function bill(Shipment $shipment): Renderable
    {
        return view('shipments.bill', ['shipment' => $shipment]);
    }

    public function track(Shipment $shipment): Renderable
    {
        return view('shipments.track', ['events' => BrtController::trackShipment($shipment->brtParcels()->first()), 'shipment' => $shipment]);
    }

    public function ship(Shipment $shipment): RedirectResponse
    {
        BrtController::createShipment($shipment);

        return redirect()->route('shipments.track', $shipment);
    }

    public function cancel_shipment(Shipment $shipment): RedirectResponse
    {
        BrtController::deleteShipment($shipment->brtParcels()->first());

        return redirect()->route('shipments.index');
    }

    public function edit(Shipment $shipment): Renderable
    {
        if (auth()->user()->isA('customer') && auth()->user()->customer_type != CustomerType::Dropshipping) {
            return view('shipments.customer.edit', ['shipment' => $shipment]);
        }

        return view('shipments.edit', ['shipment' => $shipment]);
    }

    public function update(Request $request, Shipment $shipment): RedirectResponse
    {
        $validated = $request->validate([
            'registry_id' => 'required|exists:App\Models\Registry,id',
            'source' => 'sometimes|nullable|string',
            'estimated_departure' => 'sometimes|nullable|date',
            'payment_type' => 'nullable|numeric',
            'note' => 'sometimes|nullable|string',
            'courier' => 'sometimes|nullable|integer',
            'tracking_code' => 'sometimes|nullable|string|max:255',
            'price' => 'required',
            'deposit' => 'required',
            'packages' => 'required|numeric',
            'contextual_pickup' => 'nullable|boolean',
            'stationary_storage' => 'nullable|boolean',
            'to_invoice' => 'nullable|boolean',
        ]);

        $shipment->fill($validated);
        if (! $request->contextual_pickup) {
            $shipment->contextual_pickup = false;
        }
        if (! $request->stationary_storage) {
            $shipment->stationary_storage = false;
        }
        if (! $request->to_invoice) {
            $shipment->to_invoice = false;
        }
        if ($shipment->isDirty('tracking_code') && $shipment->tracking_code != null) {
            $shipment->status = ShipmentStatus::Concluded;
            EbayController::updateItemTrackingCode($shipment);
        } elseif ($shipment->isDirty('tracking_code') && $shipment->tracking_code == null) {
            $shipment->status = ShipmentStatus::Processed;
        } elseif ($shipment->isDirty('estimated_departure') && $shipment->estimated_departure != null) {
            $shipment->status = ShipmentStatus::Confirmed;
        } elseif ($shipment->isDirty('estimated_departure') && $shipment->estimated_departure == null) {
            $shipment->status = ShipmentStatus::ToBeConfirmed;
        }
        if ($request->get('dateNotDefined', false)) {
            $shipment->estimated_departure = null;
            $shipment->status = ShipmentStatus::ToBeConfirmed;
        }
        $shipment->save();

        if ($shipment->status == ShipmentStatus::Concluded) {
            $shipment->tires()->update(['status' => TireStatus::Sold]);
        } else {
            $shipment->tires()->update(['status' => TireStatus::ToShip]);
        }

        return redirect(route('shipments.index'));
    }

    /**
     * @throws \Exception
     */
    public function destroy(Shipment $shipment): RedirectResponse
    {
        if ($shipment->status != ShipmentStatus::Returned) {
            foreach ($shipment->tires as $tire) {
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
            }
        }

        foreach ($shipment->products as $product) {
            $product->delete();
        }

        if ($shipment->brtParcels()->count() > 0) {
            BrtController::deleteShipment($shipment->brtParcels()->first());
        }

        $shipment->brtParcels()->delete();
        $shipment->delete();

        return back();
    }
}
