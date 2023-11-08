<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $name;

    public $email;

    public $role;

    public $order_by = 'created_at';

    public $order_direction = 'ASC';

    public function render()
    {
        return view('livewire.users.table', ['users' => $this->prepareQuery()->paginate(20)]);
    }

    public function prepareQuery()
    {
        $query = User::query();
        if ($this->name) {
            $query->where('name', 'LIKE', '%'.$this->name.'%');
        }
        if ($this->email) {
            $query->where('email', 'LIKE', '%'.$this->email.'%');
        }
        if ($this->role) {
            $query->whereIs($this->role);
        }
        $query->orderBy($this->order_by, $this->order_direction);

        return $query;
    }
}
