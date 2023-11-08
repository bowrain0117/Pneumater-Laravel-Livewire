<?php

namespace App\Http\Livewire\Tire;

use App\Models\Tire;
use Livewire\Component;

class TableActions extends Component
{
    public $tire;

    public function mount(Tire $tire)
    {
        $this->tire = $tire;
    }

    public function render()
    {
        return view('livewire.tire.table-actions');
    }
}
