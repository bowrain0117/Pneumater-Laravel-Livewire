<?php

namespace App\Http\Livewire\Deposit;

use App\Models\Tire;
use App\Models\Type;
use Livewire\Component;

class TireAdd extends Component
{
    public $brand;

    public $model;

    public $type_id;

    public $category;

    public $width;

    public $profile;

    public $diameter;

    public $is_commercial;

    public $amount;

    public $types;

    public $tire;

    public function mount(Tire $tire)
    {
        $this->types = Type::get();
        $this->brand = old('brand', $tire->brand ?? '');
        $this->model = old('model', $tire->model ?? '');
        $this->type_id = old('type_id', $tire->type_id ?? '');
        $this->category = old('category', $tire->category ?? '');
        $this->width = old('width', $tire->width ?? '');
        $this->profile = old('profile', $tire->profile ?? '');
        $this->diameter = old('diameter', $tire->diameter ?? '');
        $this->is_commercial = old('is_commercial', $tire->is_commercial ?? 0);
        $this->amount = old('amount', $tire->amount ?? '');
    }

    public function render()
    {
        return view('livewire.deposit.tire-add');
    }
}
