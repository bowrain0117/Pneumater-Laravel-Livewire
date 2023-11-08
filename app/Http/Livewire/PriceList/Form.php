<?php

namespace App\Http\Livewire\PriceList;

use App\Models\PriceList;
use App\Models\PriceListRules;
use Livewire\Component;

class Form extends Component
{
    public $priceList;

    public $name;

    public $field;

    public $operator;

    public $value;

    public $pricelist_rules;

    protected $rules = [
        'name' => 'required',
    ];

    public function mount(PriceList $priceList)
    {
        $this->priceList = $priceList;

        $this->name = old('name', $priceList->name ?? '');
        $this->field = \DB::getSchemaBuilder()->getColumnListing('tires')[0];
        $this->operator = '=';

        $this->pricelist_rules = $priceList->rules;
    }

    public function render()
    {
        return view('livewire.price-list.form');
    }

    public function submit()
    {
        $this->priceList->fill($this->validate());
        $this->priceList->save();
    }

    public function saveAndClose()
    {
        $this->submit();

        return redirect()->route('admin.price-list.index');
    }

    public function addRule()
    {
        if ($this->value != '') {
            $this->priceList->rules()->create([
                'field' => $this->field,
                'operator' => $this->operator,
                'value' => $this->value,
            ]);

            $this->operator = '=';
            $this->value = '';

            $this->pricelist_rules = PriceListRules::where('price_list_id', $this->priceList->id)->get();
        }
    }

    public function removeRule($id)
    {
        $this->priceList->rules()->where('id', $id)->delete();
        $this->pricelist_rules = PriceListRules::where('price_list_id', $this->priceList->id)->get();
    }
}
