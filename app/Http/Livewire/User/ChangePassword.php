<?php

namespace App\Http\Livewire\User;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class ChangePassword extends Component
{
    use AuthorizesRequests;

    public $saved;

    public array $state = [
        'current_password' => '',
        'password' => '',
        'password_confirmation' => '',
    ];

    public function mount()
    {
        $this->saved = false;
    }

    public function updatePassword()
    {
        $this->resetErrorBag();

        Validator::make(
            $this->state,
            [
                'current_password' => ['required', 'current_password'],
                'password' => [
                    'required',
                    'string',
                    Password::min(8)
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                        ->uncompromised(),
                    'confirmed',
                ],
            ]
        )->validateWithBag('updatePassword');

        Auth::user()->forceFill(
            [
                'password' => Hash::make($this->state['password']),
            ]
        )->save();

        $this->reset('state');

        $this->saved = true;
    }

    public function render()
    {
        return view('livewire.user.change-password');
    }
}
