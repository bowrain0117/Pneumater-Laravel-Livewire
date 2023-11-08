<?php

namespace App\Http\Livewire\Tables;

use App\Enums\ReservationStatus;
use App\Enums\TireStatus;
use App\Models\Reservation;
use Livewire\Component;

class ReservationRow extends Component
{
    public $reservation;

    public $checked;

    public $field_in_edit;

    public $field_in_edit_value;

    public $edit_lock = true;

    public function mount(Reservation $reservation)
    {
        $this->reservation = $reservation;

        $this->field_in_edit = '';
    }

    public function render()
    {
        return view('livewire.tables.reservation-row');
    }

    public function updating($name, $value)
    {
        if ($name == 'field_in_edit_value') {
            if ($value == '') {
                $value = null;
            }

            $this->reservation[$this->field_in_edit] = $value;
            $this->reservation->save();
        } elseif ($name == 'field_in_edit') {
            $this->field_in_edit_value = $this->reservation[$value];
        }
    }

    public function alternateLockStatus()
    {
        $this->edit_lock = ! $this->edit_lock;
    }

    public function prepareForPayment()
    {
        $this->reservation->status = ReservationStatus::Processed;
        $this->reservation->save();
    }

    public function conclude()
    {
        $this->reservation->status = ReservationStatus::Concluded;
        $this->reservation->tires()->update(['status' => TireStatus::Sold]);
        $this->reservation->save();
    }
}
