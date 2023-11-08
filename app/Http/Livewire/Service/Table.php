<?php

namespace App\Http\Livewire\Service;

use App\Models\Service;
use Livewire\Component;

class Table extends Component
{
    public $services;

    public $code = '';

    public $name = '';

    public function mount()
    {
        $this->services = Service::get();
    }

    public function updatedCode()
    {
        if ($this->code != '') {
            $this->services = Service::where('code', 'LIKE', '%'.$this->code.'%');
            if ($this->name != '') {
                $this->services = $this->services->where('name', 'LIKE', '%'.$this->name.'%');
            }
            $this->services = $this->services->get();
        } else {
            $this->services = Service::get();
        }
    }

    public function updatedName()
    {
        if ($this->name != '') {
            $this->services = Service::where('name', 'LIKE', '%'.$this->name.'%');
            if ($this->code != '') {
                $this->services = $this->services->where('code', 'LIKE', '%'.$this->code.'%');
            }
            $this->services = $this->services->get();
        } else {
            $this->services = Service::get();
        }
    }

    public function render()
    {
        return view('livewire.service.table');
    }
}
