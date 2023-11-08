<?php

namespace App\Http\Livewire\Tables;

use App\Models\Tire;
use App\Models\User;
use Livewire\Component;

class TireRow extends Component
{
    public $tire;

    public $rack_identifier;

    public $listings;

    public $checked;

    public $field_in_edit;

    public $field_in_edit_value;

    public $edit_lock = true;

    public $discount_mode;

    protected $listeners = ['discountModeChange'];

    public function mount(Tire $tire, $discount_mode)
    {
        $this->tire = $tire;

        $user_id = auth()->user()->isA('customer') ? auth()->user()->id : User::first()->id;
        $this->listings = $tire->listings()->where('user_id', $user_id)->get();

        $this->rack_identifier = $tire->rack_identifier;

        $this->field_in_edit = '';
        $this->discount_mode = $discount_mode ?? false;
    }

    public function render()
    {
        return view('livewire.tables.tire-row');
    }

    public function updating($name, $value)
    {
        if ($name == 'field_in_edit_value') {
            if ($value == '') {
                $value = null;
            }

            if (
                (
                    $value == null
                    && $this->field_in_edit != 'width'
                    && $this->field_in_edit != 'profile'
                    && $this->field_in_edit != 'diameter'
                    && $this->field_in_edit != 'load_index'
                    && $this->field_in_edit != 'speed_index'
                ) || $value != null
            ) {
                $this->tire[$this->field_in_edit] = $value;
                $this->tire->save();
            }
        } elseif ($name == 'field_in_edit') {
            $this->field_in_edit_value = $this->tire[$value];
        } elseif ($name == 'checked' && $value == 1) {
            $this->emit('checkTire', $this->tire->id);
        } elseif ($name == 'checked' && $value != 1) {
            $this->emit('uncheckTire', $this->tire->id);
        }
    }

    public function alternateLockStatus()
    {
        $this->edit_lock = ! $this->edit_lock;
    }

    public function discountModeChange($value)
    {
        $this->discount_mode = $value;
    }
}
