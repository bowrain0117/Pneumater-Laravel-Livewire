<?php

namespace App\Http\Livewire\Shipment;

use App\Models\Registry;
use App\Models\Shipment;
use Livewire\Component;

class Form extends Component
{
    public $estimated_departure;

    public $payment_type;

    public $source;

    public $note;

    public $courier;

    public $tracking_code;

    public $price;

    public $deposit;

    public $packages;

    public $contextual_pickup;

    public $stationary_storage;

    public $to_invoice;

    public $shipment;

    public $registry;

    public function mount(Shipment $shipment)
    {
        $this->estimated_departure = old('estimated_departure', $shipment->id ? $shipment->estimated_departure : now());
        $this->payment_type = old('payment_type', $shipment->payment_type ?? null);
        $this->source = old('source', $shipment->source ?? null);
        $this->note = old('note', $shipment->note ?? null);
        $this->courier = old('courier', $shipment->courier ?? null);
        $this->tracking_code = old('tracking_code', $shipment->tracking_code ?? null);
        $this->price = old('price', $shipment->price ?? 0);
        $this->deposit = old('deposit', $shipment->deposit ?? 0);
        $this->packages = old('packages', $shipment->packages ?? 0);
        $this->contextual_pickup = old('contextual_pickup', $shipment->contextual_pickup ?? false);
        $this->stationary_storage = old('stationary_storage', $shipment->stationary_storage ?? false);
        $this->to_invoice = old('to_invoice', $shipment->to_invoice ?? false);

        $this->shipment = $shipment;
        $this->registry = Registry::find(old('registry_id', $shipment->registry->id ?? null));
    }

    public function render()
    {
        return view('livewire.shipment.form');
    }
}
