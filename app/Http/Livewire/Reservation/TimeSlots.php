<?php

namespace App\Http\Livewire\Reservation;

use App\Http\Controllers\ReservationController;
use App\Models\Reservation;
use Carbon\Carbon;
use Livewire\Component;

class TimeSlots extends Component
{
    public $reservation_id;

    public $dateNotDefined;

    public $appointment_date;

    public $appointment_time;

    public $amount_of_time_slot;

    public $available_slots;

    public $lift_id;

    public $archive_appointment_date;

    public function mount($lift_id, $appointment_date, $appointment_time, $amount_of_time_slot)
    {
        $this->lift_id = $lift_id;
        $this->appointment_date = $appointment_date;
        $this->appointment_time = $appointment_time;
        $this->amount_of_time_slot = $amount_of_time_slot;

        if (
            $this->appointment_date == null
            && $this->appointment_time == null
        ) {
            $this->dateNotDefined = 1;
            $this->appointment_date = '';
            $this->archive_appointment_date = Carbon::now()->format('Y-m-d');
        } else {
            $this->archive_appointment_date = '';
            $this->updatedAppointmentDate();
        }
        if ($this->appointment_date instanceof Carbon) {
            $this->appointment_date = $this->appointment_date->format('Y-m-d');
        }
    }

    public function render()
    {
        return view('livewire.reservation.time-slots');
    }

    public function updatedDateNotDefined()
    {
        if ($this->dateNotDefined == 1) {
            $this->archive_appointment_date = $this->appointment_date;
            $this->appointment_date = '';
        } else {
            $this->appointment_date = $this->archive_appointment_date;
            $this->archive_appointment_date = '';
            $this->updatedAppointmentDate();
        }
    }

    public function updatedAmountOfTimeSlot()
    {
        $this->updatedAppointmentDate();
    }

    public function updatedLiftId()
    {
        $this->updatedAppointmentDate();
    }

    public function updatedAppointmentDate()
    {
        $this->available_slots = ReservationController::TIME_SLOTS;
        foreach (Reservation::where('appointment_date', $this->appointment_date)->where('lift_id', $this->lift_id)->where('appointment_time', '!=', $this->appointment_time)->get() as $reservation) {
            $current_slot_key = array_search($reservation->appointment_time, $this->available_slots);
            for ($i = 0; $i < $reservation->amount_of_time_slot; $i++) {
                if (array_key_exists($current_slot_key + (1 * $i), $this->available_slots)) {
                    $this->available_slots = array_diff($this->available_slots, [$this->available_slots[$current_slot_key + (1 * $i)]]);
                }
            }
        }

        if ($this->amount_of_time_slot > 1) {
            foreach ($this->available_slots as $key => $slot) {
                $invalid_slot = false;
                for ($i = 0; $i < $this->amount_of_time_slot; $i++) {
                    if (! array_key_exists($key + (1 * $i), $this->available_slots)) {
                        $invalid_slot = true;
                    }
                }

                if ($invalid_slot) {
                    $this->available_slots = array_diff($this->available_slots, [$slot]);
                }
            }
        }

    }
}
