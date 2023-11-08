<?php

namespace App\Http\Controllers;

use App\Enums\ReservationStatus;
use App\Enums\TireStatus;
use App\Enums\DepositStatus;
use App\Models\Reservation;
use App\Models\Deposit;
use App\Models\Tire;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public const TIME_SLOTS = [
        0 => '07:00:00',
        1 => '07:30:00',
        2 => '08:00:00',
        3 => '08:30:00',
        4 => '09:00:00',
        5 => '09:30:00',
        6 => '10:00:00',
        7 => '10:30:00',
        8 => '11:00:00',
        9 => '11:30:00',
        10 => '12:00:00',
        11 => '12:30:00',
        12 => '13:00:00',
        13 => '13:30:00',
        14 => '14:00:00',
        15 => '14:30:00',
        16 => '15:00:00',
        17 => '15:30:00',
        18 => '16:00:00',
        19 => '16:30:00',
        20 => '17:00:00',
        21 => '17:30:00',
        22 => '18:00:00',
        23 => '18:30:00',
        24 => '19:00:00',
        25 => '19:30:00',
        26 => '20:00:00',
    ];

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
        $current = request()->input('current', 'true') == 'false' ? false : true;

        return view('reservations.index', ['current' => $current]);
    }

    public function create(): Renderable
    {
        return view('reservations.create');
    }

    public function store(Request $request): RedirectResponse
    {
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
        if (!$request->get('appointmentNotDefined', false)) {
            $reservation->status = ReservationStatus::Confirmed;
        } else {
            $reservation->status = ReservationStatus::ToBeConfirmed;
        }
        if ($reservation->appointment_time != null) {
            $reservation->appointment_time = date('G:i', strtotime($reservation->appointment_time));
        }
        $reservation->created_by = Auth::id();
        $reservation->save();

        return redirect(route('reservations.edit', ['reservation' => $reservation]));
    }

    /**
     * Print details of today reservations
     */
    public function print(Reservation $reservation): Renderable
    {
        $reservations = collect([$reservation]);
        foreach ($reservations as $reservation) {
            $reservation->status = ReservationStatus::PartiallyProcessed;
            $reservation->save();
        }

        return view('reservations.print', ['reservations' => $reservations]);
    }

    /**
     * Print details of today reservations
     */
    public function printDay(): Renderable
    {
        $reservations = Reservation::where('status', ReservationStatus::Confirmed)
            ->where('appointment_date', '>=', Carbon::today())
            ->where('appointment_date', '<', Carbon::tomorrow())->get();
        foreach ($reservations as $reservation) {
            $reservation->status = ReservationStatus::PartiallyProcessed;
            $reservation->save();
        }

        return view('reservations.print', ['reservations' => $reservations]);
    }

    /**
     * Print details of today reservations
     */
    public function printMorning(): Renderable
    {
        $reservations = Reservation::where('status', ReservationStatus::Confirmed)
            ->where('appointment_date', '>=', Carbon::today())
            ->where('appointment_date', '<', Carbon::tomorrow())
            ->where('appointment_time', '<', '13:30:00')->get();
        foreach ($reservations as $reservation) {
            $reservation->status = ReservationStatus::PartiallyProcessed;
            $reservation->save();
        }

        return view('reservations.print', ['reservations' => $reservations]);
    }

    /**
     * Print details of today reservations
     */
    public function printAfternoon(): Renderable
    {
        $reservations = Reservation::where('status', ReservationStatus::Confirmed)
            ->where('appointment_date', '>=', Carbon::today())
            ->where('appointment_date', '<', Carbon::tomorrow())
            ->where('appointment_time', '>=', '13:30:00')->get();
        foreach ($reservations as $reservation) {
            $reservation->status = ReservationStatus::PartiallyProcessed;
            $reservation->save();
        }

        return view('reservations.print', ['reservations' => $reservations]);
    }

    /**
     * Re-print details of today shipments
     */
    public function reprint(): Renderable
    {
        $reservations = Reservation::where('status', ReservationStatus::PartiallyProcessed)
            ->where('appointment_date', '>=', Carbon::today())
            ->where('appointment_date', '<', Carbon::tomorrow())->get();

        return view('shipments.print', ['shipments' => $reservations]);
    }

    public function createDeposit(Reservation $reservation): Renderable
    {
        $tires = $reservation->tires;

        return view('reservations.create-deposit', ['tires' => $tires, 'reservation' => $reservation]);
    }

    public function storeDeposit(Request $request, Reservation $reservation): RedirectResponse
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
        $deposit->tires()->sync($reservation->tires()->pluck('tires.id')->toArray());
        $reservation->deposits()->attach($deposit->id);

        return redirect(route('reservations.index'));
    }

    public function deposit(Reservation $reservation): Response
    {
        $pdf = PDF::loadView('pdf.deposit', ['reservation' => $reservation]);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream();
    }

    public function warranty(Reservation $reservation): Response
    {
        $price = $reservation->products()->where('type', \App\Enums\ProductType::USED_TIRE)->get()->sum('price');
        foreach ($reservation->tires()->whereIn('category', [\App\Enums\TireCategory::HIGH_PROFILE, \App\Enums\TireCategory::PROFILE, \App\Enums\TireCategory::REPAIRED])->get() as $tire) {
            if ($tire->pivot->price_override) {
                $price += $tire->pivot->price_override;
            } else {
                $price += $tire->price * $tire->amount;
            }
        }

        $pdf = PDF::loadView('pdf.warranty', ['reservation' => $reservation, 'price' => $price]);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream();
    }

    public function bill(Reservation $reservation): Renderable
    {
        return view('reservations.bill', ['reservation' => $reservation]);
    }

    public function edit(Reservation $reservation): Renderable
    {
        return view('reservations.edit', ['reservation' => $reservation]);
    }

    public function update(Request $request, Reservation $reservation): RedirectResponse
    {
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

        $reservation->fill($validate);
        if ($reservation->tires()->count() == 0) {
            $reservation->status = ReservationStatus::PartiallyProcessed;
        } else {
            if ($reservation->isDirty('appointment_date') && $reservation->appointment_date != null) {
                $reservation->status = ReservationStatus::Confirmed;
            } elseif ($reservation->isDirty('appointment_date') && $reservation->appointment_date == null) {
                $reservation->status = ReservationStatus::ToBeConfirmed;
            }
        }
        // removing seconds from time
        if ($reservation->isDirty('appointment_time') && $reservation->appointment_time != null) {
            $reservation->appointment_time = date('G:i', strtotime($reservation->appointment_time));
        }
        $reservation->save();
        $reservation->updateLabour();

        if ($reservation->status == ReservationStatus::Concluded) {
            $reservation->tires()->update(['status' => TireStatus::Sold]);
        } else {
            $reservation->tires()->update(['status' => TireStatus::Reserved]);
        }

        if ($request->redirecToPrint) {
            return redirect(route('reservations.print', ['reservation' => $reservation]));
        } else {
            return redirect(route('reservations.index'));
        }
    }

    /**
     * @throws \Exception
     */
    public function destroy(Reservation $reservation): RedirectResponse
    {
        foreach ($reservation->tires as $tire) {
            $reservation->tires()->detach($tire);
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

        DB::table('reservation_service')
            ->where('reservation_id', $reservation->id)
            ->delete();

        foreach ($reservation->products as $product) {
            $product->delete();
        }

        $reservation->delete();

        return redirect(route('reservations.index'));
    }
}
