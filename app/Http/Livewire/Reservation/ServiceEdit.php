<?php

namespace App\Http\Livewire\Reservation;

use App\Models\Service;
use Livewire\Component;

class ServiceEdit extends Component
{
    public $price;

    public $amount;

    public $price_override;

    public function mount(Service $service, $pivot)
    {
        $this->price = $service->price;
        $this->amount = $pivot->amount;
        $this->price_override = $pivot->price_override;
    }

    public function updatedAmount($value)
    {
        if (is_numeric($value)) {
            $this->price_override = $this->price * $value;
        }
    }

    public function render()
    {
        return view('livewire.reservation.service-edit');
    }
}
