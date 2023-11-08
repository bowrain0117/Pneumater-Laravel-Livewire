<?php

namespace App\Http\Livewire\Reservation;

use App\Models\Deposit;
use App\Models\Registry;
use Livewire\Component;

class CreateDeposit extends Component
{
    public $car_model;

    public $license_plate;

    public $status;

    public $note;

    // public $tire;

    public $registry;

    public $deposit;

    public $reservation;

    public $tires;

    public function mount(Deposit $deposit, $tires, $reservation)
    {
        $this->car_model = old('car_model', $deposit->car_model ?? '');
        $this->license_plate = old('license_plate', $deposit->license_plate ?? '');
        $this->status = old('status', $deposit->status ?? '');
        $this->note = old('note', $deposit->note ?? '');

        $this->deposit = $deposit;
        $this->registry = $deposit->registry;

        $this->reservation = $reservation;
        $this->tires = $tires;
        $this->registry = Registry::find(old('registry_id', $reservation->registry->id ?? null));
    }

    public function render()
    {
        return view('livewire.reservation.create-deposit');
    }
}
