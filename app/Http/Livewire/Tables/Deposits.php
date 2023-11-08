<?php

namespace App\Http\Livewire\Tables;

use App\Models\Deposit;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class Deposits extends Component
{
    use WithPagination;

    public $identifier;

    public $name;

    public $phone;

    public $email;

    public $car_model;

    public $license_plate;

    public $status;

    public function render()
    {
        return view('livewire.tables.deposits', ['deposits' => $this->prepareQuery()->paginate(20)]);
    }

    public function prepareQuery()
    {
        $query = Deposit::with('tires');

        if ($this->identifier != null) {
            $query->where('id', $this->identifier);
        }
        if ($this->car_model) {
            $query->where('car_model', 'like', '%' . $this->car_model . '%');
        }
        if ($this->license_plate) {
            $query->where('license_plate', 'like', '%' . $this->license_plate . '%');
        }
        if ($this->status) {
            $query->where('status', 'like', $this->status);
        }
        $query->where(function ($q2) {
            if ($this->name) {
                $q2->where(function ($q_name_new) {
                    foreach (explode(' ', $this->name) as $word) {
                        $q_name_new->whereHas(
                            'registry',
                            function (Builder $query) use ($word) {
                                $query->where('denomination', 'LIKE', '%' . $word . '%')
                                    ->orWhere('name', 'LIKE', '%' . $word . '%')
                                    ->orWhere('surname', 'LIKE', '%' . $word . '%');
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
                            $query->where('phone', 'LIKE', '%' . str_replace(' ', '', $this->phone) . '%')
                                ->orWhere('cellular', 'LIKE', '%' . str_replace(' ', '', $this->phone) . '%');
                        }
                    );
                });
            }
        });

        return $query;
    }
}
