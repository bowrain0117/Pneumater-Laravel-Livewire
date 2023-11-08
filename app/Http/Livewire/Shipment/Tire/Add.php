<?php

namespace App\Http\Livewire\Shipment\Tire;

use App\Enums\TireStatus;
use App\Models\Shipment;
use App\Models\Tire;
use Livewire\Component;
use Livewire\WithPagination;

class Add extends Component
{
    use WithPagination;

    public $shipment;

    public $shipment_id;

    public $identifier;

    public $ean;

    public $category;

    public $model;

    public $commercial;

    public $type;

    public $width;

    public $profile;

    public $diameter;

    public function mount(Shipment $shipment = null)
    {
        $this->shipment = $shipment;
        $this->shipment_id = $shipment->id ?? '';
    }

    public function updated($name, $value)
    {
        $this->resetPage();
    }

    private function prepareQuery()
    {
        $query = Tire::where('status', TireStatus::Available);
        if ($this->identifier) {
            $query->where('id', '=', $this->identifier);
        }
        if ($this->ean != '') {
            $query->where('ean', 'LIKE', '%'.$this->ean.'%');
        }
        if ($this->model != '') {
            $query->where('model', 'LIKE', '%'.$this->model.'%');
        }
        if ($this->category) {
            $query->where('category', $this->category);
        }
        if ($this->type) {
            $query->where('type_id', $this->type);
        }
        if ($this->width) {
            $query->where('width', $this->width);
        }
        if ($this->profile) {
            $query->where('profile', $this->profile);
        }
        if ($this->diameter) {
            $query->where('diameter', $this->diameter);
        }
        if ($this->commercial) {
            $query->where('is_commercial', true);
        }

        return $query;
    }

    public function render()
    {
        return view('livewire.shipment.tire.add', ['tires' => $this->prepareQuery()->paginate(20)]);
    }
}
