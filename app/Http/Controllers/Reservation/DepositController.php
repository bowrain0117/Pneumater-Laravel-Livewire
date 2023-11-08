<?php

namespace App\Http\Controllers\Reservation;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Deposit;
use App\Enums\DepositStatus;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepositController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('verified');
    }

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
        return view('reservations.deposit.create', ['reservation' => $reservation]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Reservation $reservation): RedirectResponse
    {
        $request->validate([
            'deposit_id' => 'required|exists:App\Models\Deposit,id',
        ]);

        $reservation->deposits()->attach([$request->deposit_id]);

        $deposit = Deposit::findOrFail($request->deposit_id);
        $deposit->status = DepositStatus::Picked_Up;
        $reservation->save();
        $deposit->save();

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
    public function destroy(Reservation $reservation, Deposit $deposit): RedirectResponse
    {
        $pivot = DB::table('reservation_deposit')
            ->where('deposit_id', $deposit->id)
            ->where('reservation_id', $reservation->id)
            ->first();
        $reservation->save();
        $deposit->status = DepositStatus::Available;
        $deposit->save();
        $reservation->deposits()->detach($deposit);

        if (request()->has('redirectToBill')) {
            $destination = route('reservations.bill', ['reservation' => $reservation]);
        } else {
            $destination = route('reservations.edit', ['reservation' => $reservation]);
        }

        return redirect($destination);
    }
}
