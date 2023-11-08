<?php

namespace App\Http\Livewire\Registry\Modal;

use App\Models\Registry;
use Livewire\Component;

class AlternativeShipmentData extends Component
{
    public $registry;

    public function mount(Registry $registry)
    {
        $this->registry = $registry;
    }

    public function render()
    {
        return view('livewire.registry.modal.alternative-shipment-data');
    }
}
