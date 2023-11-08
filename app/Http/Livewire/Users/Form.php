<?php

namespace App\Http\Livewire\Users;

use App\Enums\Couriers;
use App\Models\User;
use Livewire\Component;

class Form extends Component
{
    public $name;

    public $email;

    public $price_list_id;

    public $default_courier;

    public $roles;

    public $customer_type;

    public $lock_price_edit;

    public $ebay_auth_token;

    public $watermark_path;

    public $isEdit;

    public function mount(User $user)
    {
        $this->name = old('name', $user->name ?? '');
        $this->email = old('email', $user->email ?? '');
        $this->default_courier = old('default_courier', $user->default_courier ?? Couriers::BRT);
        $this->roles = $user->roles->first()->id ?? null;
        $this->customer_type = old('customer_type', $user->customer_type ?? null);
        $this->lock_price_edit = old('lock_price_edit', $user->lock_price_edit ?? 0);
        $this->price_list_id = old('price_list_id', $user->price_list_id ?? null);
        $this->ebay_auth_token = old('ebay_auth_token', $user->ebay_auth_token ?? '');
        $this->watermark_path = old('watermark_path', $user->watermark_path ?? '');

        $this->isEdit = $user->name != null;
    }

    public function render()
    {
        return view('livewire.users.form');
    }
}
