<?php

namespace App\Http\Livewire\Tire;

use App\Http\Controllers\EbayController;
use App\Models\Lift;
use App\Models\Registry;
use Carbon\Carbon;
use Livewire\Component;

class SellForm extends Component
{
    public $sellType;

    public $type;

    public $source;

    public $note;

    public $courier;

    public $price;

    public $deposit;

    public $estimated_departure;

    public $payment_type;

    public $contextual_pickup;

    public $stationary_storage;

    public $to_invoice;

    public $lift_id;

    public $appointment_date;

    public $appointment_time;

    public $amount_of_time_slot;

    public $registry;

    public $tires;

    public $tire_sell_status = [];

    public $tire_sell_warning = false;

    public function mount($tires = [])
    {
        $this->sellType = old('sellType', auth()->user()->isNotA('customer') ? 1 : 3);

        $this->type = old('type');
        $this->source = old('source');
        $this->note = old('note');
        $this->courier = old('courier');
        $this->price = old('price', 0);
        $this->deposit = old('deposit', 0);
        $this->estimated_departure = old('estimated_departure', now());
        $this->payment_type = old('payment_type');
        $this->contextual_pickup = old('contextual_pickup', false);
        $this->stationary_storage = old('stationary_storage', false);
        $this->to_invoice = old('to_invoice', auth()->user()->isA('customer') ? true : false);
        $this->lift_id = Lift::first()->id;
        $this->appointment_date = old('appointment_date', Carbon::now()->format('Y-m-d'));
        $this->appointment_time = old('appointment_time', '');

        $this->registry = Registry::find(old('registry_id'));

        $this->tires = $tires;

        $amount_of_time_slot = 0;

        foreach ($this->tires as $tire) {
            $amount_of_time_slot += $tire->calculateLabourTimeSlot();
            if (EbayController::isTireSold($tire)) {
                $this->tire_sell_status[$tire->id] = true;
                $this->tire_sell_warning = true;
            } else {
                $this->tire_sell_status[$tire->id] = false;
            }
        }

        $this->amount_of_time_slot = old('amount_of_time_slot', round($amount_of_time_slot, 0, PHP_ROUND_HALF_UP));
    }

    public function removeTire($tire_id)
    {
        $this->tires = $this->tires->filter(function ($tire) use ($tire_id) {
            return $tire->id != $tire_id;
        });

        $amount_of_time_slot = 0;

        foreach ($this->tires as $tire) {
            $amount_of_time_slot += $tire->calculateLabourTimeSlot();
        }

        $this->amount_of_time_slot = round($amount_of_time_slot, 0, PHP_ROUND_HALF_UP);
    }

    public function render()
    {
        return view('livewire.tire.sell-form');
    }
}
