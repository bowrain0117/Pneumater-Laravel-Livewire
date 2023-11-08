<?php

namespace App\Http\Livewire\Deposit\Tire;

use App\Models\Tire;
use Livewire\Component;

class Form extends Component
{
    public function mount(Tire $tire)
    {
        $this->brand = old('brand', $tire->brand ?? '');
        $this->model = old('model', $tire->model ?? '');
        $this->type_id = old('type_id', $tire->type_id ?? '');
        $this->width = old('width', $tire->width ?? '');
        $this->profile = old('profile', $tire->profile ?? '');
        $this->diameter = old('diameter', $tire->diameter ?? '');
        $this->is_commercial = old('is_commercial', $tire->is_commercial ?? 0);
        $this->amount = old('amount', $tire->amount ?? '');
        $this->load_index = old('load_index', $tire->load_index ?? '');
        $this->speed_index = old('speed_index', $tire->speed_index ?? '');
        $this->millimeters = old('millimeters', $tire->millimeters ?? '');
        $this->rack_identifier = old('rack_identifier', $tire->rack_identifier ?? '');
        $this->rack_position = old('rack_position', $tire->rack_position ?? '');
    }

    public function render()
    {
        return view('livewire.deposit.tire.form');
    }
}
