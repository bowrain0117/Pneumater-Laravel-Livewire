<?php

namespace App\Http\Livewire\Shipment\Customer;

use App\Models\Shipment;
use Livewire\Component;

class Form extends Component
{
    public $shipment;

    public $estimated_departure;

    public $note;

    public function mount(Shipment $shipment)
    {
        $this->shipment = $shipment;
        $this->estimated_departure = old('estimated_departure', $shipment->id ? $shipment->estimated_departure : now());
        $this->note = old('note', $shipment->note ?? null);
    }

    public function render()
    {
        return view('livewire.shipment.customer.form');
    }

    public function submit()
    {
        $this->shipment->fill([
            'estimated_departure' => $this->estimated_departure,
            'note' => $this->note,
        ]);
        $this->shipment->save();

        return redirect()->route('shipments.index');
    }
}
