<?php

namespace App\Http\Livewire\Reservation;

use App\Models\Service;
use Livewire\Component;

class ServiceAdd extends Component
{
    public $services;

    public $search;

    public $amount;

    public $price_override;

    public $service_id;

    public $lock_amount_update;

    public function mount()
    {
        $this->services = Service::get();
        $this->service_id = $this->services[0]->id;
        $this->amount = 1;

        $service = Service::findOrFail($this->service_id);
        $this->price_override = $service->price * $this->amount;

        $this->lock_amount_update = false;
    }

    public function updatedServiceId()
    {
        $service = Service::findOrFail($this->service_id);
        $this->price_override = $service->price * $this->amount;
        $this->lock_amount_update = false;
    }

    public function updatedSearch()
    {
        $this->services = Service::where('code', 'LIKE', '%' . $this->search . '%')->get();

        if (count($this->services) > 0) {
            $this->service_id = $this->services[0]->id;

            $service = Service::findOrFail($this->service_id);
            $this->price_override = $service->price * $this->amount;
            $this->lock_amount_update = false;
        }
    }

    public function updatedAmount()
    {
        if (!$this->lock_amount_update && is_numeric($this->amount)) {
            $service = Service::findOrFail($this->service_id);
            $this->price_override = $service->price * $this->amount;
        }
    }

    public function updatedPriceOverride()
    {
        $this->lock_amount_update = true;
    }

    public function render()
    {
        return view('livewire.reservation.service-add');
    }
}
