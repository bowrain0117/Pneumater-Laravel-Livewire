<?php

namespace App\Http\Livewire\Reservation;

use App\Enums\DepositStatus;
use App\Models\Reservation;
use App\Models\Deposit;
use Livewire\Component;
use Livewire\WithPagination;

class DepositAdd extends Component
{
    use WithPagination;

    public $reservation;

    public $reservation_id;

    public $identifier;

    public $name;

    public $phone;

    public $email;

    public $car_model;

    public $license_plate;

    public $amount;

    public $deposits;

    public $deposit_id;

    public $lock_amount_update;

    public function mount(Reservation $reservation = null)
    {
        $this->deposits = Deposit::with('registry')->get();
        $this->deposit_id = $this->deposits[0]->id;
        $this->amount = 1;
        $this->reservation = $reservation;
        $this->reservation_id = $reservation->id ?? '';

        $deposit = Deposit::findOrFail($this->deposit_id);

        $this->lock_amount_update = false;
    }

    public function updated($name, $value)
    {
        $this->resetPage();
    }

    private function prepareQuery()
    {
        $query = Deposit::where('status', DepositStatus::Available)->with('registry');
        if ($this->identifier) {
            $query->where('id', $this->identifier);
        }
        if ($this->name) {
            $query->whereHas('registry', function ($q) {
                $q->where('name', 'LIKE', '%' . $this->name . '%');
            });
        }
        if ($this->phone) {
            $query->whereHas('registry', function ($q) {
                $q->where('phone', 'LIKE', '%' . $this->phone . '%');
            });
        }
        if ($this->email) {
            $query->whereHas('registry', function ($q) {
                $q->where('email', 'LIKE', '%' . $this->email . '%');
            });
        }
        if ($this->car_model) {
            $query->where('car_model', 'like', '%' . $this->car_model . '%');
        }
        if ($this->license_plate) {
            $query->where('license_plate', 'like', '%' . $this->license_plate . '%');
        }
        return $query;
    }

    public function render()
    {
        return view('livewire.reservation.deposit-add', ['deposit_list' => $this->prepareQuery()->get()]);
    }
}
