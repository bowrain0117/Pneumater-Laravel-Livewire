<?php

namespace App\Http\Livewire\Reservation;

use App\Models\Reservation;
use Illuminate\Contracts\Support\Renderable;
use Livewire\Component;

class BillForm extends Component
{
    public $reservation;

    public $note;

    public $price;

    public $deposit;

    public $payment_type;

    public $payed;

    public $show_saved_message;

    protected $rules = [
        'note' => 'sometimes|nullable|string',
        'price' => 'required',
        'deposit' => 'required',
        'payment_type' => 'nullable|numeric',
        'payed' => 'nullable|boolean',
    ];

    public function mount(Reservation $reservation): void
    {
        $this->reservation = $reservation;

        $this->note = $reservation->note ?? '';
        $this->price = $reservation->price ?? 0;
        $this->deposit = $reservation->deposit ?? 0;
        $this->payment_type = $reservation->payment_type ?? null;
        $this->payed = $reservation->payed ?? false;

        $this->show_saved_message = false;
    }

    public function updated($name, $value): void
    {
        $this->show_saved_message = false;
    }

    public function submit(): void
    {
        $validated = $this->validate();
        $this->reservation->update($validated);

        $this->show_saved_message = true;
    }

    public function render(): Renderable
    {
        return view('livewire.reservation.bill-form');
    }
}
