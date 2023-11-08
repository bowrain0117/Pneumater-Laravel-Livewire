<?php

namespace App\Http\Livewire\Shipment\Tire;

use App\Models\Shipment;
use App\Models\Tire;
use Livewire\Component;

class AddForm extends Component
{
    public $tire;

    public $shipment;

    public function mount(Tire $tire, Shipment $shipment)
    {
        $this->tire = $tire;
        $this->shipment = $shipment;
    }

    public function render()
    {
        return view('livewire.shipment.tire.add-form');
    }
}
