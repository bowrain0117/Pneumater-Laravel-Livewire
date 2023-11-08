<?php

namespace App\Http\Livewire\Shipment;

use App\Models\Shipment;
use Illuminate\Contracts\Support\Renderable;
use Livewire\Component;

class BillForm extends Component
{
    public $shipment;

    public $note;

    public $price;

    public $deposit;

    public $payment_type;

    public $show_saved_message;

    protected $rules = [
        'note' => 'sometimes|nullable|string',
        'price' => 'required',
        'deposit' => 'required',
        'payment_type' => 'nullable|numeric',
    ];

    public function mount(Shipment $shipment): void
    {
        $this->shipment = $shipment;

        $this->note = $shipment->note ?? '';
        $this->price = $shipment->price ?? 0;
        $this->deposit = $shipment->deposit ?? 0;
        $this->payment_type = $shipment->payment_type ?? null;

        $this->show_saved_message = false;
    }

    public function updated($name, $value): void
    {
        $this->show_saved_message = false;
    }

    public function submit(): void
    {
        $validated = $this->validate();
        $this->shipment->update($validated);

        $this->show_saved_message = true;
    }

    public function render(): Renderable
    {
        return view('livewire.shipment.bill-form');
    }
}
