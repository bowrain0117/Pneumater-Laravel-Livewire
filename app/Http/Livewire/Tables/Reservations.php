<?php

namespace App\Http\Livewire\Tables;

use App\Enums\ReservationStatus;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class Reservations extends Component
{
    use withPagination;

    public $identifier;

    public $name;

    public $phone;

    public $email;

    public $status;

    public $type;

    public $lift_id;

    public $appointment_date_from;

    public $appointment_date_to;

    public $appointment_time_type; // 0 - Morning (to 1:30 PM), 1 - Afternoon

    public $created_at_from;

    public $created_at_to;

    public $order_by;

    public $order_direction;

    public $storedIdentifiers = [];

    public function mount($current_day = false)
    {
        $this->order_by = 'appointment_time';
        $this->order_direction = 'ASC';

        if ($current_day) {
            $this->appointment_date_from = Carbon::now()->format('Y-m-d');

            if (Carbon::now()->format('H:i:S') <= '13:30:00') {
                $this->appointment_time_type = 1;
            } else {
                $this->appointment_time_type = 2;
            }
        }
    }

    public function render()
    {
        $reservations = $this->prepareQuery();

        return view('livewire.tables.reservations', [
            'reservations' => $reservations->orderBy($this->order_by, $this->order_direction)->paginate(20),
        ]);
    }

    private function prepareQuery()
    {
        $reservations = Reservation::query();
        if ($this->identifier != null && count($this->storedIdentifiers) == 0) {
            $reservations->where('id', $this->identifier);
        }
        if (count($this->storedIdentifiers) > 0) {
            $reservations->whereIn('id', $this->storedIdentifiers);
        }
        $reservations->where(function ($q2) {
            if ($this->name) {
                $q2->where(function ($q_name_old) {
                    foreach (explode(' ', $this->name) as $word) {
                        $q_name_old->where('name', 'LIKE', '%'.$word.'%');
                    }
                });
                $q2->orWhere(function ($q_name_new) {
                    foreach (explode(' ', $this->name) as $word) {
                        $q_name_new->whereHas(
                            'registry',
                            function (Builder $query) use ($word) {
                                $query->where('denomination', 'LIKE', '%'.$word.'%')
                                    ->orWhere('name', 'LIKE', '%'.$word.'%')
                                    ->orWhere('surname', 'LIKE', '%'.$word.'%');
                            }
                        );
                    }
                });
            }
            if ($this->phone) {
                $q2->orWhere(function ($q) {
                    $q->where('phone', str_replace(' ', '', $this->phone));
                    $q->orWhereHas(
                        'registry',
                        function (Builder $query) {
                            $query->where('phone', 'LIKE', '%'.str_replace(' ', '', $this->phone).'%')
                                ->orWhere('cellular', 'LIKE', '%'.str_replace(' ', '', $this->phone).'%');
                        }
                    );
                });
            }
        });
        if ($this->email != null) {
            $reservations->where(function ($q) {
                $q->where('email', $this->email)
                    ->orWhereHas(
                        'registry',
                        function (Builder $query) {
                            $query->where('email', 'LIKE', '%'.$this->email.'%');
                        }
                    );
            });
        }
        if ($this->status != null) {
            $reservations->where('status', $this->status);
        } else {
            $reservations->where('status', '!=', ReservationStatus::Concluded);
        }
        if ($this->type != null) {
            $reservations->where('type', $this->type);
        }
        if ($this->lift_id != null) {
            $reservations->where('lift_id', $this->lift_id);
        }
        if ($this->appointment_date_from != null && $this->appointment_date_to != null) {
            $reservations->where('appointment_date', '>=', $this->appointment_date_from);
            $reservations->where('appointment_date', '<=', $this->appointment_date_to);
        } elseif ($this->appointment_date_from != null) {
            $reservations->where('appointment_date', $this->appointment_date_from);
        }
        if ($this->appointment_time_type == 1) {
            $reservations->where(function ($query) {
                $query->where('appointment_time', '<=', '13:30:00')->orWhere('appointment_time', null);
            });
        } elseif ($this->appointment_time_type == 2) {
            $reservations->where(function ($query) {
                $query->where('appointment_time', '>', '13:30:00')->orWhere('appointment_time', null);
            });
        }
        if ($this->created_at_from != null && $this->created_at_to != null) {
            $reservations->where('created_at', '>=', $this->created_at_from);
            $reservations->where('created_at', '<=', $this->created_at_to);
        } elseif ($this->created_at_from != null) {
            $reservations->where('created_at', $this->created_at_from);
        }

        $reservations->with('lift')->with('createdBy')->with('tires')->with('products')->with('services');

        return $reservations;
    }

    public function updatingOrderBy($value)
    {
        if ($this->order_by == $value && $this->order_direction == 'ASC') {
            $this->order_direction = 'DESC';
        } else {
            $this->order_direction = 'ASC';
        }
    }

    public function storeIdentifier()
    {
        if ($this->identifier != '') {
            $this->storedIdentifiers[] = $this->identifier;
            $this->identifier = '';
        }
    }

    public function removeIdentifier($identifier)
    {
        $this->storedIdentifiers = array_diff($this->storedIdentifiers, [$identifier]);
    }
}
