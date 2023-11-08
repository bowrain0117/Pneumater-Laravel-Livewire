<?php

namespace App\Http\Livewire\Tables;

use App\Models\Shipment;
use Livewire\Component;

class ShipmentRow extends Component
{
    public $shipment;

    public $checked;

    public $field_in_edit;

    public $field_in_edit_value;

    public $edit_lock = true;

    public function mount(Shipment $shipment)
    {
        $this->shipment = $shipment;

        $this->field_in_edit = '';
    }

    public function render()
    {
        return view('livewire.tables.shipment-row');
    }

    public function updating($name, $value)
    {
        if ($name == 'field_in_edit_value') {
            if ($value == '') {
                $value = null;
            }

            $this->shipment[$this->field_in_edit] = $value;
            $this->shipment->save();
        } elseif ($name == 'field_in_edit') {
            if ($value == 'estimated_departure') {
                $this->field_in_edit_value = $this->shipment->estimated_departure->format('Y-m-d') ?? Carbon::today()->format('Y-m-d');
            } else {
                $this->field_in_edit_value = $this->shipment[$value];
            }
        } elseif ($name == 'checked' && $value == 1) {
            $this->emit('checkShipment', $this->shipment->id);
        } elseif ($name == 'checked' && $value != 1) {
            $this->emit('uncheckShipment', $this->shipment->id);
        }
    }

    public function alternateLockStatus()
    {
        $this->edit_lock = ! $this->edit_lock;
    }

    public function confirm()
    {
        $this->shipment->is_confirmation_needed = false;
        $this->shipment->save();
        $this->shipment->refresh();
    }
}
