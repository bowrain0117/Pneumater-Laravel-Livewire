<?php

namespace App\Http\Livewire\Registry;

use App\Models\Registry;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use withPagination;

    public $type;

    public $role;

    public $code;

    public $fiscal_code;

    public $vat_number;

    public $denomination;

    public $address;

    public $city;

    public $postal_code;

    public $province;

    public $region;

    public $nation;

    public $phone;

    public $email;

    public $order_by = 'code';

    public $order_direction = 'ASC';

    public function mount($role)
    {
        $this->role = $role;
    }

    public function render()
    {
        return view('livewire.registry.table', ['registries' => $this->prepareQuery()->paginate(20)]);
    }

    public function prepareQuery()
    {
        $query = Registry::query();
        if (auth()->user()->isA('customer')) {
            $query->where('created_by', auth()->id());
        }
        $query->where(function ($q) {
            $q->where('role', $this->role)
                ->orWhere('role', \App\Enums\RegistryRoleType::CUSTOMER_AND_SUPPLIER);
        });
        if ($this->type) {
            $query->where('type', $this->type);
        }
        if ($this->code) {
            $query->where('code', 'LIKE', '%'.$this->code.'%');
        }
        if ($this->fiscal_code) {
            $query->where('fiscal_code', 'LIKE', '%'.$this->fiscal_code.'%');
        }
        if ($this->vat_number) {
            $query->where('vat_number', 'LIKE', '%'.$this->vat_number.'%');
        }
        $query->where(function ($q2) {
            if ($this->denomination) {
                $q2->orWhere(function ($q3) {
                    foreach (explode(' ', $this->denomination) as $word) {
                        $q3->where(function ($q) use ($word) {
                            $q->orWhere('denomination', 'LIKE', '%'.$word.'%')
                                ->orWhere('name', 'LIKE', '%'.$word.'%')
                                ->orWhere('surname', 'LIKE', '%'.$word.'%');
                        });
                    }
                });
            }
            if ($this->phone) {
                $q2->orWhere(function ($q) {
                    $q->orWhere('phone', 'LIKE', '%'.$this->phone.'%')
                        ->orWhere('cellular', 'LIKE', '%'.$this->phone.'%')
                        ->orWhere('phone', 'LIKE', '%'.str_replace(' ', '', $this->phone).'%')
                        ->orWhere('cellular', 'LIKE', '%'.str_replace(' ', '', $this->phone).'%');
                });
            }

        });
        if ($this->address) {
            $query->where('address', 'LIKE', '%'.$this->address.'%');
        }
        if ($this->city) {
            $query->where('city', 'LIKE', '%'.$this->city.'%');
        }
        if ($this->postal_code) {
            $query->where('postal_code', 'LIKE', '%'.$this->postal_code.'%');
        }
        if ($this->province) {
            $query->where('province', 'LIKE', '%'.$this->province.'%');
        }
        if ($this->region) {
            $query->where('region', 'LIKE', '%'.$this->region.'%');
        }
        if ($this->nation) {
            $query->where('nation', 'LIKE', '%'.$this->nation.'%');
        }
        if ($this->email) {
            $query->where('email', 'LIKE', '%'.$this->email.'%');
        }
        $query->orderBy($this->order_by, $this->order_direction);

        return $query;
    }
}
