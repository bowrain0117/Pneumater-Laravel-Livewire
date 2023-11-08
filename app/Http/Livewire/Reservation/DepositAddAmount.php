<?php

namespace App\Http\Livewire\Reservation;

use App\Models\Reservation;
use App\Models\Deposit;
use Livewire\Component;

class DepositAddAmount extends Component
{
    public $deposit;

    public $reservation;

    public function mount(Deposit $deposit, Reservation $reservation)
    {
        $this->deposit = $deposit;
        $this->reservation = $reservation;
    }

    public function render()
    {
        return view('livewire.reservation.deposit-add-amount');
    }
}
