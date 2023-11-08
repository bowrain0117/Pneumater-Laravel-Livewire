<?php

namespace App\Http\Livewire\Reservation;

use App\Models\Lift;
use App\Models\Registry;
use App\Models\Reservation;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Form extends Component
{
    public $type;

    public $source;

    public $note;

    public $price;

    public $deposit;

    public $reservation;

    public $registry;

    public $lift_id;

    public $appointment_date;

    public $appointment_time;

    public $amount_of_time_slot;

    public function mount(Reservation $reservation)
    {
        $this->type = old('type', $reservation->type ?? null);
        $this->source = old('source', $reservation->source ?? null);
        $this->note = old('note', $reservation->note ?? null);
        $this->price = old('price', $reservation->price ?? 0);
        $this->deposit = old('deposit', $reservation->deposit ?? 0);
        $this->lift_id = $reservation->lift_id ?? Lift::first()->id;
        $this->appointment_date = old('appointment_date', $reservation->appointment_date ?? Carbon::now()->format('Y-m-d'));
        $this->appointment_time = old('appointment_time', $reservation->appointment_time ?? '');
        $this->amount_of_time_slot = old('amount_of_time_slot', $reservation->amount_of_time_slot ?? 1);

        $this->reservation = $reservation;
        $this->registry = Registry::find(old('registry_id', $reservation->registry->id ?? null));
    }

    public function render()
    {
        return view('livewire.reservation.form');
    }
}
