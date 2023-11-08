<?php

namespace App\Http\Livewire\Lift;

use App\Models\Lift;
use Livewire\Component;

class Table extends Component
{
    public $lifts;

    public function mount()
    {
        $this->lifts = Lift::get();
    }

    public function render()
    {
        return view('livewire.lift.table');
    }
}
