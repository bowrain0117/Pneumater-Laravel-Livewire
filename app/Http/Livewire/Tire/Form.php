<?php

namespace App\Http\Livewire\Tire;

use App\Enums\TireCategory;
use App\Models\Tire;
use Livewire\Component;

class Form extends Component
{
    public $description;

    public $category;

    public $ean;

    public $width;

    public $profile;

    public $diameter;

    public $is_commercial;

    public $brand;

    public $model;

    public $dot;

    public $load_index;

    public $speed_index;

    public $type_id;

    public $millimeters;

    public $millimeters_2;

    public $millimeters_new_by_manufacturer;

    public $price_list;

    public $pfu_contribution;

    public $discount_immediate_payment;

    public $discount_supplier;

    public $price;

    public $price_ebay;

    public $rack_identifier;

    public $rack_position;

    public $amount;

    public $categories;

    public function mount(Tire $tire = null)
    {
        $this->description = old('description', $tire->description ?? '');
        $this->category = old('category', $tire->category ?? '');
        $this->ean = old('ean', $tire->ean ?? '');
        $this->width = old('width', $tire->width ?? '');
        $this->profile = old('profile', $tire->profile ?? '');
        $this->diameter = old('diameter', $tire->diameter ?? '');
        $this->is_commercial = old('is_commercial', $tire->is_commercial ?? false);
        $this->brand = old('brand', $tire->brand ?? '');
        $this->model = old('model', $tire->model ?? '');
        $this->dot = old('dot', $tire->dot ?? '');
        $this->load_index = old('load_index', $tire->load_index ?? '');
        $this->speed_index = old('speed_index', $tire->speed_index ?? '');
        $this->type_id = old('type_id', $tire->type_id ?? '');
        $this->millimeters = old('millimeters', $tire->millimeters ?? '');
        $this->millimeters_2 = old('millimeters_2', $tire->millimeters_2 ?? '');
        $this->millimeters_new_by_manufacturer = old('millimeters_new_by_manufacturer', $tire->millimeters_new_by_manufacturer ?? '');
        $this->price_list = old('price_list', $tire->price_list ?? 0);
        $this->pfu_contribution = old('pfu_contribution', $tire->pfu_contribution ?? 0);
        $this->discount_immediate_payment = old('discount_immediate_payment', $tire->discount_immediate_payment ?? 0);
        $this->discount_supplier = old('discount_supplier', $tire->discount_supplier ?? 0);
        $this->price = old('price', $tire->price ?? 0);
        $this->price_ebay = old('price_ebay', $tire->price_ebay ?? 0);
        $this->rack_identifier = old('rack_identifier', $tire->rack_identifier ?? '');
        $this->rack_position = old('rack_position', $tire->rack_position ?? '');
        $this->amount = old('amount', $tire->amount ?? 2);
    }

    public function render()
    {
        return view('livewire.tire.form');
    }

    public function updatedCategory()
    {
        $this->calculatePrice();
    }

    public function updatedDiameter()
    {
        $this->calculatePrice();
    }

    public function updatedPrice()
    {
        if ($this->category != TireCategory::NEW_EXTRA) {
            $this->calculatePrice();
        } else {
            $this->calculatePriceNewExtraTireInverse();
        }
    }

    public function updatedAmount()
    {
        $this->calculatePrice();
    }

    public function updatedPriceList()
    {
        $this->calculatePrice();
    }

    public function updatedPfuContribution()
    {
        $this->calculatePrice();
    }

    public function updatedDiscountImmediatePayment()
    {
        $this->calculatePrice();
    }

    public function updatedDiscountSupplier()
    {
        $this->calculatePrice();
    }

    private function calculatePrice()
    {
        if ($this->category == 3) {
            $this->calculatePriceNewTire();
        } elseif ($this->category == 5) {
            $this->calculatePriceNewExtraTire();
        } else {
            $this->calculatePriceUsedTire();
        }
    }

    private function calculatePriceUsedTire()
    {
        $price = $this->price != '' ? intval($this->price) : 0;
        $amount = $this->amount != '' ? intval($this->amount) : 0;
        $diameter = $this->diameter != '' ? intval($this->diameter) : 0;

        $this->price_ebay = round(
            $this->calculateEbayPrice(
                $price,
                $amount,
                $diameter
            ), 1, PHP_ROUND_HALF_UP
        );
    }

    private function calculatePriceNewExtraTire()
    {
        $price_list = $this->price_list != '' ? intval($this->price_list) : 0;
        $amount = ($this->amount != '' && $this->amount != 0) ? intval($this->amount) : 1; // do not change this to 0, division by zero could be triggered
        $diameter = $this->diameter != '' ? intval($this->diameter) : 0;

        $price = $price_list / $amount;

        switch ($diameter) {
            case 13:
            case 14:
                $price -= 5;
                break;
            case 15:
            case 16:
                $price -= 6.25;
                break;
            case 17:
            case 18:
                $price -= 7.5;
                break;
            case 19:
            case 20:
                $price -= 8.75;
                break;
            default:
                $price -= 10;
        }

        $this->price = round(
            $price, 0, PHP_ROUND_HALF_DOWN
        );

        $this->price_ebay = round(
            $price_list * 1.07, 1, PHP_ROUND_HALF_UP
        );
    }

    private function calculatePriceNewExtraTireInverse()
    {
        $price = $this->price != '' ? intval($this->price) : 0;
        $diameter = $this->diameter != '' ? intval($this->diameter) : 0;
        $amount = ($this->amount != '' && $this->amount != 0) ? intval($this->amount) : 1; // do not change this to 0, division by zero could be triggered
        $amount = $amount <= 4 ? $amount : 4;
        $amount = $amount == 3 ? 2 : $amount;

        $price_list = $price;

        switch ($diameter) {
            case 13:
            case 14:
                $price_list += 5;
                break;
            case 15:
            case 16:
                $price_list += 6.25;
                break;
            case 17:
            case 18:
                $price_list += 7.5;
                break;
            case 19:
            case 20:
                $price_list += 8.75;
                break;
            default:
                $price_list += 10;
        }

        $price_list = $price_list * $amount;

        $this->price_list = round(
            $price_list, 0, PHP_ROUND_HALF_DOWN
        );

        $this->price_ebay = round(
            $price_list * 1.07, 1, PHP_ROUND_HALF_UP
        );
    }

    private function calculatePriceNewTire()
    {
        $price_list = $this->price_list != '' ? intval($this->price_list) : 0;
        $discount_immediate_payment = $this->discount_immediate_payment != '' ? intval($this->discount_immediate_payment) : 0;
        $pfu_contribution = $this->pfu_contribution != '' ? intval($this->pfu_contribution) : 0;
        $diameter = $this->diameter != '' ? intval($this->diameter) : 0;

        $price = ($price_list * ((100 - $discount_immediate_payment) / 100)) * 1.22;

        switch ($diameter) {
            case 13:
            case 14:
                $price -= 5;
                break;
            case 15:
            case 16:
                $price -= 6.25;
                break;
            case 17:
            case 18:
                $price -= 7.5;
                break;
            case 19:
            case 20:
                $price -= 8.75;
                break;
            default:
                $price -= 10;
        }

        $price = round(($price + ($pfu_contribution * 1.22)), 0, PHP_ROUND_HALF_UP);
        $this->price = $price >= 0 ? $price : 0;

        $price = ($price_list * ((100 - $discount_immediate_payment) / 100)) * 1.22;
        $price = round(($price + ($pfu_contribution * 1.22)), 0, PHP_ROUND_HALF_UP);
        $price_ebay = round($this->calculateEbayPrice($price, 2, $diameter), 1, PHP_ROUND_HALF_UP);
        $this->price_ebay = $price_ebay >= 0 ? $price_ebay : 0;
    }

    private function calculateEbayPrice($tire_price, $amount, $diameter)
    {
        $price = 0;

        switch (intval($diameter)) {
            case 13:
            case 14:
                if ($amount == 2) {
                    $price += 15;
                } else {
                    $price += 20;
                }
                break;
            case 15:
            case 16:
                if ($amount == 2) {
                    $price += 15;
                } else {
                    $price += 25;
                }
                break;
            case 17:
            case 18:
                if ($amount == 2) {
                    $price += 15;
                } else {
                    $price += 30;
                }
                break;
            case 19:
            case 20:
                if ($amount == 2) {
                    $price += 20;
                } else {
                    $price += 35;
                }
                break;
            default:
                if ($amount == 2) {
                    $price += 20;
                } else {
                    $price += 40;
                }
        }

        return ($price + (intval($tire_price) * $amount)) * 1.07;
    }
}
