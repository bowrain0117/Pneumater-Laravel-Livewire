<?php

namespace App\Http\Livewire\Reservation;

use App\Models\Reservation;
use App\Models\Tire;
use Livewire\Component;

class TireAddAmount extends Component
{
    public $tire;

    public $reservation;

    public function mount(Tire $tire, Reservation $reservation)
    {
        $this->tire = $tire;
        $this->reservation = $reservation;
    }

    public function render()
    {
        return view('livewire.reservation.tire-add-amount');
    }
}
