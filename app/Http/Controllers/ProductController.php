<?php

namespace App\Http\Controllers;

use App\Enums\ProductType;
use App\Models\Product;
use App\Models\Reservation;
use App\Models\Shipment;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function create()
    {
        if (request()->input('reservation') || request()->input('shipment')) {
            return view('products.create');
        } else {
            return redirect()->back();
        }
    }

    public function edit(Product $product)
    {
        return view('products.edit', ['product' => $product]);
    }

    /**
     * @throws \Exception
     */
    public function destroy(Product $product): \Illuminate\Http\RedirectResponse
    {
        $reservation = Reservation::find($product->reservation_id);
        if ($reservation) {
            $reservation->price -= $product->price;
            $reservation->save();
            $reservation->updateLabour();
        }
        $shipment = Shipment::find($product->shipment_id);
        if ($shipment) {
            $shipment->price -= $product->price;
            $shipment->save();
        }

        $product->delete();

        if ($reservation) {
            $reservation->updateLabour();
        }

        if ($product->shipment_id) {
            if (request()->has('redirectToBill')) {
                $destination = route('shipments.bill', ['shipment' => $product->shipment_id]);
            } else {
                $destination = route('shipments.edit', ['shipment' => $product->shipment_id]);
            }
        } else {
            if (request()->has('redirectToBill')) {
                $destination = route('reservations.bill', ['reservation' => $product->reservation_id]);
            } else {
                $destination = route('reservations.edit', ['reservation' => $product->reservation_id]);
            }
        }

        return redirect($destination);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'code' => 'sometimes|nullable|string',
            'description' => 'required|string',
            'pfu_contribution' => 'sometimes|nullable|numeric',
            'price' => 'required|int',
            'amount' => 'required|int',
            'type' => ['required', new EnumValue(ProductType::class, false)],
            'rack_identifier' => 'sometimes|nullable|string',
            'rack_position' => 'sometimes|nullable|int',
            'shipment_id' => 'sometimes|exists:App\Models\Shipment,id',
            'reservation_id' => 'sometimes|exists:App\Models\Reservation,id',
        ]);

        Product::create($validate);
        $reservation = Reservation::find($request->reservation_id);
        if ($reservation) {
            $reservation->price += $request->price;
            $reservation->save();
            $reservation->updateLabour();
        }

        $shipment = Shipment::find($request->shipment_id);
        if ($shipment) {
            $shipment->price += $request->price;
            $shipment->save();
        }

        if ($request->shipment_id) {
            if ($request->has('redirectToBill')) {
                $destination = route('shipments.bill', ['shipment' => $request->shipment_id]);
            } else {
                $destination = route('shipments.edit', ['shipment' => $request->shipment_id]);
            }
        } else {
            if ($request->has('redirectToBill')) {
                $destination = route('reservations.bill', ['reservation' => $request->reservation_id]);
            } else {
                $destination = route('reservations.edit', ['reservation' => $request->reservation_id]);
            }
        }

        return redirect($destination);
    }

    public function update(Request $request, Product $product)
    {
        $validate = $request->validate([
            'code' => 'sometimes|nullable|string',
            'description' => 'required|string',
            'pfu_contribution' => 'sometimes|nullable|numeric',
            'price' => 'required|int',
            'amount' => 'required|int',
            'type' => ['required', new EnumValue(ProductType::class, false)],
            'rack_identifier' => 'sometimes|nullable|string',
            'rack_position' => 'sometimes|nullable|int',
        ]);

        $product->update($validate);

        $reservation = Reservation::find($product->reservation_id);
        if ($reservation) {
            $reservation->price -= $product->price;
            $reservation->price += $request->price;
            $reservation->save();
            $reservation->updateLabour();
        }
        $shipment = Shipment::find($product->shipment_id);
        if ($shipment) {
            $shipment->price -= $product->price;
            $shipment->price += $request->price;
            $shipment->save();
        }

        if ($product->shipment_id) {
            if ($request->has('redirectToBill')) {
                $destination = route('shipments.bill', ['shipment' => $product->shipment_id]);
            } else {
                $destination = route('shipments.edit', ['shipment' => $product->shipment_id]);
            }
        } else {
            if ($request->has('redirectToBill')) {
                $destination = route('reservations.bill', ['reservation' => $product->reservation_id]);
            } else {
                $destination = route('reservations.edit', ['reservation' => $product->reservation_id]);
            }
        }

        return redirect($destination);
    }
}
