<?php

namespace App\Http\Livewire\Deposit;

use App\Models\Deposit;
use Livewire\Component;

class Form extends Component
{
    public $car_model;

    public $license_plate;

    public $status;

    public $note;

    public $tire;

    public $registry;

    public $deposit;

    public $reservation;

    public $redirectToBill;

    public function mount(Deposit $deposit, $reservation = null)
    {
        $this->redirectToBill = request()->has('redirectToBill') ? request()->input('redirectToBill') : false;

        $this->car_model = old('car_model', $deposit->car_model ?? '');
        $this->license_plate = old('license_plate', $deposit->license_plate ?? '');
        $this->status = old('status', $deposit->status ?? '');
        $this->note = old('note', $deposit->note ?? '');

        $this->deposit = $deposit;
        $this->registry = $deposit->registry;

        $this->reservation = $reservation;
    }

    public function render()
    {
        return view('livewire.deposit.form');
    }
}
