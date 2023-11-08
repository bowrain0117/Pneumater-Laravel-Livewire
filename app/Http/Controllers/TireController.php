<?php

namespace App\Http\Controllers;

use App\Enums\ReservationStatus;
use App\Enums\ShipmentStatus;
use App\Enums\Shop;
use App\Enums\TireStatus;
use App\Enums\User\CustomerType;
use App\Models\Reservation;
use App\Models\Shipment;
use App\Models\Tire;
use App\Models\TirePhoto;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TireController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->authorizeResource(Tire::class, 'tire');
    }

    public function index()
    {
        if (auth()->user()->isA('customer') && auth()->user()->customer_type != CustomerType::Dropshipping) {
            return view(
                'tires.customer.index', [
                    'status' => TireStatus::Available,
                ]);
        }

        return view(
            'tires.index', [
                'status' => request()->input('status', TireStatus::Available),
            ]);
    }

    public function show(Tire $tire)
    {
        return view('tires.show', ['tire' => $tire]);
    }

    public function create()
    {
        return view('tires.create');
    }

    public function edit(Tire $tire)
    {
        return view('tires.edit', ['tire' => $tire]);
    }

    public function importView()
    {
        return view('tires.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'csv' => 'required|file',
            'delete_tires' => 'sometimes|boolean',
        ]);

        $handle = fopen($request->csv->getPathName(), 'r');
        $header = true;

        $inserted_ean = [];

        while ($csvLine = fgetcsv($handle, 1000, ',')) {
            if ($header) {
                $header = false;
            } else {
                $inserted_ean[] = $csvLine[0];

                $tire = Tire::where('ean', $csvLine[0])->where('status', TireStatus::Available)->first();
                if ($tire) {
                    $tire->description = $csvLine[1];
                    $tire->amount = $csvLine[11];
                    $tire->price_list = str_replace(',', '.', $csvLine[12]);
                    $tire->pfu_contribution = str_replace(',', '.', $csvLine[13]);
                    $tire->discount_immediate_payment = str_replace(',', '.', $csvLine[14]);
                    $tire->discount_supplier = str_replace(',', '.', $csvLine[15]);
                } else {
                    switch ($csvLine[10]) {
                        case 'Estiva':
                            $type_id = 1;
                            break;
                        case 'Invernale':
                            $type_id = 2;
                            break;
                        case '4 Stagioni':
                            $type_id = 3;
                            break;
                        case 'Estiva (m+s)':
                            $type_id = 4;
                            break;
                        default:
                            $type_id = 1;
                    }

                    $tire = new Tire;
                    $tire->fill([
                        'ean' => $csvLine[0],
                        'description' => $csvLine[1],
                        'category' => 3,
                        'millimeters' => 0,
                        'millimeters_2' => 0,
                        'millimeters_new_by_manufacturer' => 0,
                        'width' => $csvLine[2],
                        'profile' => $csvLine[3] != '' ? $csvLine[3] : null,
                        'diameter' => $csvLine[4],
                        'load_index' => intval($csvLine[6]),
                        'speed_index' => $csvLine[7],
                        'is_commercial' => $csvLine[5] == 'LTR',
                        'dot' => '',
                        'brand' => $csvLine[8],
                        'model' => $csvLine[9],
                        'type_id' => $type_id,
                        'amount' => $csvLine[11],
                        'price_list' => str_replace(',', '.', $csvLine[12]),
                        'pfu_contribution' => str_replace(',', '.', $csvLine[13]),
                        'discount_immediate_payment' => str_replace(',', '.', $csvLine[14]),
                        'discount_supplier' => str_replace(',', '.', $csvLine[15]),
                    ]);
                    $tire->save();
                }

                $price = ($tire->price_list * ((100 - $tire->discount_immediate_payment) / 100)) * 1.22;

                switch ($tire->diameter) {
                    case 13:
                    case 14:
                        $price -= 5;
                        break;
                    case 15:
                    case 16:
                        $price -= 6.25;
                        break;
                    case 17:
                    case 18:
                        $price -= 7.5;
                        break;
                    case 19:
                    case 20:
                        $price -= 8.75;
                        break;
                    default:
                        $price -= 10;
                }

                $tire->price = ceil($price + ($tire->pfu_contribution * 1.22));

                $price_ebay = ($tire->price_list * ((100 - $tire->discount_immediate_payment) / 100)) * 1.22;
                $price_ebay = round($price_ebay + ($tire->pfu_contribution * 1.22), 1);

                switch ($tire->diameter) {
                    case 13:
                    case 14:
                    case 15:
                    case 16:
                    case 17:
                    case 18:
                        $price_ebay_increment = 15;
                        break;
                    case 19:
                    case 20:
                        $price_ebay_increment = 20;
                        break;
                    default:
                        $price_ebay_increment = 20;
                }

                $price_ebay = ($price_ebay_increment + ($price_ebay * 2)) * 1.07;
                $tire->price_ebay = round($price_ebay, 1);
                $tire->save();

                if (
                    $csvLine[16] != ''
                    || $csvLine[17] != ''
                    || $csvLine[18] != ''
                ) {
                    foreach ($tire->photos as $photo) {
                        Storage::delete($photo->path);
                        $photo->delete();
                    }
                }

                if ($csvLine[16] != '') {
                    try {
                        $contents = file_get_contents($csvLine[16]);
                        $filename_remote = basename($csvLine[16]);
                        $filename_splitted = explode('.', $filename_remote);
                        $filename = 'IMP_'.Str::random(10).'.'.$filename_splitted[1];
                        Storage::put('public/tire-photo/'.$filename, $contents);

                        TirePhoto::create([
                            'tire_id' => $tire->id,
                            'path' => 'public/tire-photo/'.$filename,
                        ]);
                    } catch (ErrorException $e) {
                        report($e);
                    }
                }

                if ($csvLine[17] != '') {
                    try {
                        $contents = file_get_contents($csvLine[17]);
                        $filename_remote = basename($csvLine[17]);
                        $filename_splitted = explode('.', $filename_remote);
                        $filename = 'IMP_'.Str::random(10).'.'.$filename_splitted[1];
                        Storage::put('public/tire-photo/'.$filename, $contents);

                        TirePhoto::create([
                            'tire_id' => $tire->id,
                            'path' => 'public/tire-photo/'.$filename,
                        ]);
                    } catch (ErrorException $e) {
                        report($e);
                    }
                }

                if ($csvLine[18] != '') {
                    try {
                        $contents = file_get_contents($csvLine[18]);
                        $filename_remote = basename($csvLine[18]);
                        $filename_splitted = explode('.', $filename_remote);
                        $filename = 'IMP_'.Str::random(10).'.'.$filename_splitted[1];
                        Storage::put('public/tire-photo/'.$filename, $contents);

                        TirePhoto::create([
                            'tire_id' => $tire->id,
                            'path' => 'public/tire-photo/'.$filename,
                        ]);
                    } catch (ErrorException $e) {
                        report($e);
                    }
                }
            }
        }

        if ($request->delete_tires) {
            $tires = Tire::whereNotIn('ean', $inserted_ean)->where('category', 3)->where('status', TireStatus::Available)->get();
            foreach ($tires as $tire) {
                foreach ($tire->photos as $photo) {
                    Storage::delete($photo->path);
                    $photo->delete();
                }
                $tire->delete();
            }
        }

        return redirect(route('tires.index'));
    }

    public function buy(Request $request)
    {
        if (! isset($request->tires)) {
            return back();
        }

        return view('tires.customer.buy', [
            'tires' => Tire::findMany($request->tires),
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function sell(Request $request)
    {
        if (isset($request->tires)) {
            $tires = Tire::findMany($request->tires);

            return view('tires.sell', ['tires' => $tires]);
        } else {
            return back();
        }
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function restore(Tire $tire)
    {
        if ($tire->ean && Tire::where('ean', $tire->ean)->where('status', TireStatus::Available)->count() > 0) {
            $merging_tire = Tire::where('ean', $tire->ean)->where('status', TireStatus::Available)->first();
            $merging_tire->amount = $merging_tire->amount + $tire->amount;
            $merging_tire->save();
            $tire->delete();
        } else {
            $tire->status = TireStatus::Available;
            $tire->save();
        }

        return back();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function sellSubmit(Request $request)
    {
        $destination = route('tires.index');

        // if tires array, amount array or sellType is not
        //in request nothing will be processed
        if (
            isset($request->tires) &&
            isset($request->sellType) &&
            isset($request->amounts)
        ) {
            $tires = Tire::findMany($request->tires);

            switch ($request->sellType) {
                // direct sell
                case 1:
                    foreach ($tires as $tire) {
                        // removing tire form all shops
                        if ($tire->listings()->where('shop', Shop::Subito)->count() > 0) {
                            $tire->listings()->where('shop', Shop::Subito)->delete();
                        }

                        $tire->removeAllFromEbay();
                        $tire->save();

                        // if less than full amount is sold tire is splitted in two sets
                        // 1 ($tire_duplicate) -> new tire contain remaining amount left
                        // 2 ($tire) -> tire set that represet sold amount
                        if ($tire->amount != $request->amounts[$tire->id] || $tire->category == 3) {
                            $tire_duplicate = self::duplicate($tire);
                            $tire_duplicate->amount -= $request->amounts[$tire->id];
                            $tire_duplicate->millimeters = 0;
                            $tire_duplicate->millimeters_2 = 0;
                            $tire_duplicate->dot = '';
                            $tire_duplicate->rack_identifier = null;
                            $tire_duplicate->rack_position = null;

                            $tire_duplicate->recalculatePrices();
                            $tire_duplicate->save();

                            $tire->amount = $request->amounts[$tire->id];
                            $tire->status = TireStatus::Sold;
                            $tire->recalculatePrices();
                            if (
                                $tire->category == 3
                                || $tire->category == 4
                                || $tire->category == 5
                            ) {
                                $tire->duplicatePhotos($tire_duplicate);
                            }
                        } else {
                            $tire->status = TireStatus::Sold;
                        }

                        $tire->save();
                    }
                    $destination = route('tires.index', ['status' => TireStatus::Sold]);
                    break;
                    // reservation
                case 2:
                    $validate = $request->validate([
                        'registry_id' => 'required|exists:App\Models\Registry,id',
                        'type' => 'required|integer',
                        'appointment_date' => 'sometimes|nullable|date',
                        'appointment_time' => 'sometimes|nullable',
                        'amount_of_time_slot' => 'required|int',
                        'lift_id' => 'sometimes|nullable|int',
                        'source' => 'sometimes|nullable|string',
                        'note' => 'sometimes|nullable|string',
                        'price' => 'required',
                        'deposit' => 'required',
                    ]);
                    $reservation = new Reservation();
                    $reservation->fill($validate);
                    if (! $request->get('appointmentNotDefined', false)) {
                        $reservation->status = ReservationStatus::Confirmed;
                    } else {
                        $reservation->status = ReservationStatus::ToBeConfirmed;
                    }
                    if ($reservation->appointment_time != null) {
                        $reservation->appointment_time = date('G:i', strtotime($reservation->appointment_time));
                    }
                    $reservation->created_by = Auth::id();
                    $reservation->save();

                    foreach ($tires as $tire) {
                        // removing tire form all shops
                        if ($tire->listings()->where('shop', Shop::Subito)->count() > 0) {
                            $tire->listings()->where('shop', Shop::Subito)->delete();
                        }

                        $tire->removeAllFromEbay();
                        $tire->save();

                        // if less than full amount is sold tire is splitted in two sets
                        // 1 ($tire) -> contain remaining amount left
                        // 2 ($tire_duplicate) -> new tire set that represet sold amount
                        if ($tire->amount != $request->amounts[$tire->id] || $tire->category == 3) {
                            $tire_duplicate = self::duplicate($tire);
                            $tire_duplicate->amount -= $request->amounts[$tire->id];
                            $tire_duplicate->millimeters = 0;
                            $tire_duplicate->millimeters_2 = 0;
                            $tire_duplicate->dot = '';
                            $tire_duplicate->rack_identifier = null;
                            $tire_duplicate->rack_position = null;
                            $tire_duplicate->recalculatePrices();
                            $tire_duplicate->save();

                            $tire->amount = $request->amounts[$tire->id];
                            $tire->status = TireStatus::Reserved;
                            $tire->recalculatePrices();
                            if (
                                $tire->category == 3
                                || $tire->category == 4
                                || $tire->category == 5
                            ) {
                                $tire->duplicatePhotos($tire_duplicate);
                            }

                            $reservation->tires()->attach([$tire->id], ['price_override' => $request->prices[$tire->id]]);
                        } else {
                            $tire->status = TireStatus::Reserved;
                            $reservation->tires()->attach([$tire->id], ['price_override' => $request->prices[$tire->id]]);
                        }

                        $reservation->price += $request->prices[$tire->id];
                        $tire->save();
                    }

                    $reservation->save();
                    $reservation->updateLabour();

                    if ($request->redirecToEdit) {
                        $destination = route('reservations.edit', ['reservation' => $reservation]);
                    } elseif ($request->redirecToPrint) {
                        $destination = route('reservations.print', ['reservation' => $reservation]);
                    } else {
                        $destination = route('reservations.index');
                    }
                    break;
                    // sold with shipping
                case 3:
                    $validate = $request->validate([
                        'registry_id' => 'required|exists:App\Models\Registry,id',
                        'source' => 'sometimes|nullable|string',
                        'estimated_departure' => 'sometimes|nullable|date',
                        'payment_type' => 'nullable|numeric',
                        'note' => 'sometimes|nullable|string',
                        'courier' => 'sometimes|nullable|integer',
                        'price' => 'required',
                        'deposit' => 'required',
                        'contextual_pickup' => 'nullable|boolean',
                        'stationary_storage' => 'nullable|boolean',
                        'to_invoice' => 'nullable|boolean',
                    ]);

                    $shipment = new Shipment();
                    $shipment->fill($validate);
                    $shipment->created_by = Auth::id();
                    if ($request->get('dateNotDefined', false)) {
                        $shipment->estimated_departure = null;
                    } else {
                        $shipment->status = ShipmentStatus::Confirmed;
                    }
                    $shipment->save();

                    foreach ($tires as $tire) {
                        // removing tire form all shops
                        if ($tire->listings()->where('shop', Shop::Subito)->count() > 0) {
                            $tire->listings()->where('shop', Shop::Subito)->delete();
                        }

                        $tire->removeAllFromEbay();
                        $tire->save();

                        // if less than full amount is sold tire is splitted in two sets
                        // 1 ($tire) -> contain remaining amount left
                        // 2 ($tire_duplicate) -> new tire set that represet sold amount
                        if ($tire->amount != $request->amounts[$tire->id] || $tire->category == 3) {
                            $tire_duplicate = self::duplicate($tire);
                            $tire_duplicate->amount -= $request->amounts[$tire->id];
                            $tire_duplicate->millimeters = 0;
                            $tire_duplicate->millimeters_2 = 0;
                            $tire_duplicate->dot = '';
                            $tire_duplicate->rack_identifier = null;
                            $tire_duplicate->rack_position = null;
                            $tire_duplicate->recalculatePrices();
                            $tire_duplicate->save();

                            $tire->amount = $request->amounts[$tire->id];
                            $tire->status = TireStatus::Reserved;
                            $tire->recalculatePrices();
                            if (
                                $tire->category == 3
                                || $tire->category == 4
                                || $tire->category == 5
                            ) {
                                $tire->duplicatePhotos($tire_duplicate);
                            }

                            $shipment->tires()->attach([$tire->id], ['price_override' => $request->prices[$tire->id]]);
                        } else {
                            $tire->status = TireStatus::Reserved;
                            $shipment->tires()->attach([$tire->id], ['price_override' => $request->prices[$tire->id]]);
                        }

                        $shipment->price += $request->prices[$tire->id];
                        $shipment->save();

                        $tire->save();
                    }

                    $shipment->recalculatePackages();

                    if ($request->redirecToEdit) {
                        $destination = route('shipments.edit', ['shipment' => $shipment]);
                    } else {
                        $destination = route('shipments.index');
                    }
                    break;
            }
        }

        return redirect($destination);
    }

    /**
     * Generate new tire base on given tire
     *
     * @return Tire
     */
    public function duplicate(Tire $tireToDuplicate)
    {
        $tire = Tire::create($tireToDuplicate->toArray());

        return $tire;
    }

    public function destroy(Tire $tire)
    {
        $tire->destory();

        return back();
    }

    public function update(Request $request, Tire $tire)
    {
        $validated = $request->validate([
            'description' => 'nullable|sometimes|string',
            'ean' => 'nullable|string|max:20',
            'category' => 'required',
            'width' => 'required|integer',
            'profile' => 'required|integer',
            'diameter' => 'required|integer',
            'brand' => 'required|string|max:250',
            'model' => 'required|string|max:250',
            'type_id' => 'required',
            'load_index' => 'required|string|max:20',
            'speed_index' => 'required|string|max:2',
            'is_commercial' => 'required|boolean',
            'dot' => 'nullable|string|max:250',
            'amount' => 'required|integer',
            'rack_identifier' => 'nullable|string|max:4',
            'rack_position' => 'nullable|integer',
            'pfu_contribution' => 'numeric',
            'discount_immediate_payment' => 'numeric',
            'discount_supplier' => 'numeric',
            'price' => 'numeric',
            'price_list' => 'numeric',
            'price_ebay' => 'numeric',
            'millimeters' => 'required|numeric',
            'millimeters_2' => 'numeric',
            'millimeters_new_by_manufacturer' => 'required|numeric',
        ]);

        $tire->update($validated);

        if ($tire->millimeters != 0 || $tire->millimeters_2 != 0) {
            $tire->unified = false;
            $tire->unification_note = '';
            $tire->save();
        }

        if ($request->input('print', false)) {
            $destination = redirect()->route('labels.tire', ['tires' => [$tire->id]]);
        } else {
            $destination = redirect()->route('tires.index');
        }

        return $destination;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'nullable|sometimes|string',
            'ean' => 'nullable|string|max:20',
            'category' => 'required|integer',
            'width' => 'required|integer',
            'profile' => 'required|integer',
            'diameter' => 'required|integer',
            'brand' => 'required|string|max:250',
            'model' => 'required|string|max:250',
            'type_id' => 'required',
            'load_index' => 'required|string|max:20',
            'speed_index' => 'required|string|max:2',
            'is_commercial' => 'required|boolean',
            'dot' => 'nullable|string|max:250',
            'amount' => 'required|integer',
            'rack_identifier' => 'nullable|string|max:4',
            'rack_position' => 'nullable|integer',
            'pfu_contribution' => 'numeric',
            'discount_immediate_payment' => 'numeric',
            'discount_supplier' => 'numeric',
            'price' => 'numeric',
            'price_list' => 'numeric',
            'price_ebay' => 'numeric',
            'millimeters' => 'sometimes|numeric',
            'millimeters_2' => 'sometimes|numeric',
            'millimeters_new_by_manufacturer' => 'sometimes|numeric',
        ]);

        $tire = new Tire;
        $tire->fill($validated);
        $tire->dot = $request->dot ?? '';
        $tire->created_by = Auth::id();
        $tire->save();

        if ($request->input('print', false)) {
            $destination = redirect()->route('labels.tire', ['tires' => [$tire->id]]);
        } else {
            $destination = redirect()->route('tires.index');
        }

        return $destination;
    }
}
