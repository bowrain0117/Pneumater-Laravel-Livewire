<?php

namespace App\Http\Livewire\PriceList;

use App\Models\PriceList;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $order_by = 'id';

    public $order_direction = 'asc';

    public function render()
    {
        return view('livewire.price-list.table', [
            'priceLists' => $this->prepareQuery()->paginate(10),
        ]);
    }

    public function prepareQuery()
    {
        return PriceList::query();
    }
}
