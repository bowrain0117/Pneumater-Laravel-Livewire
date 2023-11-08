<?php

namespace App\Http\Livewire\Tables;

use App\Enums\ShipmentStatus;
use App\Models\Shipment;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class Shipments extends Component
{
    use withPagination;

    public $identifier;

    public $ddt_number;

    public $name;

    public $phone;

    public $email;

    public $status;

    public $estimated_departure_from;

    public $estimated_departure_to;

    public $source;

    public $created_at_from;

    public $created_at_to;

    public $order_by;

    public $order_direction;

    public $warning_confirmation = false;

    public $some_shipments_need_confirmation = false;

    public $select_all;

    public $shipment_selected = [];

    public $storedIdentifiers = [];

    protected $listeners = [
        'checkShipment',
        'uncheckShipment',
    ];

    public function mount()
    {
        $this->order_by = 'created_at';
        $this->order_direction = 'ASC';

        $this->storedIdentifiers = [];
    }

    public function render()
    {
        $shipments = $this->prepareQuery();

        return view('livewire.tables.shipments', [
            'shipments' => $shipments->orderBy($this->order_by, $this->order_direction)->paginate(20),
        ]);
    }

    private function prepareQuery()
    {
        $shipments = Shipment::query();
        if ($this->identifier != null && count($this->storedIdentifiers) == 0) {
            $shipments->where('id', $this->identifier);
        }
        if (count($this->storedIdentifiers) > 0) {
            $shipments->whereIn('id', $this->storedIdentifiers);
        }
        $shipments->where(function ($q2) {
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
            $shipments->where(function ($q) {
                $q->where('email', $this->email)
                    ->orWhereHas(
                        'registry',
                        function (Builder $query) {
                            $query->where('email', 'LIKE', '%'.$this->email.'%');
                        }
                    );
            });
        }
        if ($this->ddt_number != null) {
            $shipments->where('ddt_number', $this->ddt_number);
        }
        if ($this->status != null) {
            $shipments->where('status', $this->status);
        } else {
            $shipments->where('status', '!=', ShipmentStatus::Concluded);
        }
        if ($this->estimated_departure_from != null && $this->estimated_departure_to != null) {
            $shipments->where('estimated_departure', '>=', $this->estimated_departure_from);
            $shipments->where('estimated_departure', '<=', $this->estimated_departure_to);
        } elseif ($this->estimated_departure_from != null) {
            $shipments->where('estimated_departure', $this->estimated_departure_from);
        }
        if ($this->source != null) {
            $shipments->where('source', 'LIKE', '%'.$this->source.'%');
        }
        if ($this->created_at_from != null && $this->created_at_to != null) {
            $shipments->where('created_at', '>=', $this->created_at_from);
            $shipments->where('created_at', '<=', $this->created_at_to);
        } elseif ($this->created_at_from != null) {
            $shipments->where('created_at', $this->created_at_from);
        }

        if (auth()->user()->isA('customer')) {
            $shipments->where('created_by', auth()->user()->id);
        }

        if (with(clone $shipments)->where('is_confirmation_needed', true)->count() > 0) {
            $this->some_shipments_need_confirmation = true;
        } else {
            $this->some_shipments_need_confirmation = false;
        }

        return $shipments;
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->shipment_selected = $this->prepareQuery()->pluck('id')->toArray();

            if ($this->some_shipments_need_confirmation) {
                $this->warning_confirmation = true;
            } else {
                $this->warning_confirmation = false;
            }
        } else {
            $this->shipment_selected = [];

            $this->warning_confirmation = false;
        }
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

    public function checkShipment($value)
    {
        $this->shipment_selected[] = $value;
    }

    public function uncheckShipment($value)
    {
        $this->shipment_selected = array_diff($this->shipment_selected, [$value]);
    }

    public function confirmAll()
    {
        $this->prepareQuery()->update(['is_confirmation_needed' => false]);
    }
}
