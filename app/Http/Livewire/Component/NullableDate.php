<?php

namespace App\Http\Livewire\Component;

use Carbon\Carbon;
use DateTime;
use Livewire\Component;

class NullableDate extends Component
{
    public $dateNotDefined;

    public $name_date;

    public $name_time;

    public $name_not_defined;

    public $value_date;

    public $value_time;

    public $show_time;

    public function mount($name, $value, $time = false)
    {
        $this->show_time = $time;
        if ($this->show_time) {
            $this->name_date = $name.'_date';
            $this->name_time = $name.'_time';

            $datetime = new DateTime($value);
            $this->value_date = old($this->name_date, $datetime->format('Y-m-d'));
            $this->value_time = old($this->name_time, $datetime->format('H:i:s'));
        } else {
            $this->name_date = $name;
            $this->name_time = '';
            $this->value_date = ($value instanceof Carbon) ? $value->format('Y-m-d') : $value;
            $this->value_time = '';
        }

        if ($value == ' ' || $value == '') {
            $this->dateNotDefined = 1;
        }

        $this->name_not_defined = $name.'NotDefined';
    }

    public function render()
    {
        return view('livewire.component.nullable-date');
    }

    public function updatedValueDate()
    {
        $this->dispatchBrowserEvent('updatedNullableDate');
    }
}
