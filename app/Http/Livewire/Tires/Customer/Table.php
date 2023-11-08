<?php

namespace App\Http\Livewire\Tires\Customer;

use App\Enums\Shop;
use App\Models\Tire;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $shop;

    public $identifier;

    public $rack_position;

    public $rack_identifier;

    public $ean;

    public $category;

    public $width_from;

    public $width_to;

    public $profile_from;

    public $profile_to;

    public $diameter_from;

    public $diameter_to;

    public $is_commercial_yes;

    public $is_commercial_no;

    public $brand;

    public $model;

    public $type;

    public $load_index;

    public $speed_index;

    public $dot;

    public $amount;

    public $price_from;

    public $price_to;

    public $created_at_from;

    public $created_at_to;

    public $discounted_at_from;

    public $discounted_at_to;

    public $price_discount_from;

    public $price_discount_to;

    public $status;

    public $photo;

    public $tires_selected = [];

    public $tires_selected_all;

    public $order_by;

    public $order_direction;

    public $storedIdentifiers = [];

    public function mount($status)
    {
        $this->status = $status;
        $this->order_by = 'id';
        $this->order_direction = 'ASC';
    }

    public function render()
    {
        return view('livewire.tires.customer.table', [
            'tires' => $this->prepareQuery()->paginate(20),
        ]);
    }

    private function prepareQuery()
    {
        $tires = Tire::where('status', $this->status);
        if ($this->category) {
            $tires->where('category', $this->category);
        }
        if ($this->type) {
            $tires->where('type_id', $this->type);
        }
        if ($this->shop) {
            switch ($this->shop) {
                case 1:
                    $tires->whereHas('listings', function ($query) {
                        $query->where('user_id', '=', auth()->id());
                    })->withCount('listings')->having('listings_count', 0);
                    break;
                case 2:
                    $tires->whereHas('listings', function ($query) {
                        $query->where('user_id', '=', auth()->id())
                            ->where('shop', '=', Shop::Ebay);
                    })->withCount('listings')->having('listings_count', '>=', 1);
                    break;
                case 3:
                    $tires->whereHas('listings', function ($query) {
                        $query->where('user_id', '=', auth()->id())
                            ->where('shop', '=', Shop::Subito);
                    })->withCount('listings')->having('listings_count', '>=', 1);
                    break;
                case 4:
                    $tires->whereHas('listings', function ($query) {
                        $query->where('user_id', '=', auth()->id());
                    })->withCount('listings')->having('listings_count', '>', 1);
                    break;
            }
        }
        if ($this->identifier && count($this->storedIdentifiers) == 0) {
            $tires->where('id', $this->identifier);
        }
        if (count($this->storedIdentifiers) > 0) {
            $tires->whereIn('id', $this->storedIdentifiers);
        }
        if ($this->rack_identifier) {
            $tires->where('rack_identifier', 'LIKE', '%'.$this->rack_identifier.'%');
        }
        if ($this->rack_position) {
            $tires->where('rack_position', $this->rack_position);
        }
        if ($this->ean) {
            $tires->where('ean', 'LIKE', '%'.$this->ean.'%');
        }
        $tires->where('brand', 'LIKE', '%'.$this->brand.'%');
        $tires->where('model', 'LIKE', '%'.$this->model.'%');
        if ($this->load_index) {
            $tires->where('load_index', 'LIKE', '%'.$this->load_index.'%');
        }
        if ($this->speed_index) {
            $tires->where('speed_index', $this->speed_index);
        }
        if ($this->dot) {
            $tires->where('dot', 'LIKE', '%'.$this->dot.'%');
        }
        if ($this->amount != null) {
            $tires->where('amount', $this->amount);
        }
        if ($this->width_from != null && $this->width_to != null) {
            $tires->where('width', '>=', $this->width_from);
            $tires->where('width', '<=', $this->width_to);
        } elseif ($this->width_from != null) {
            $tires->where('width', $this->width_from);
        }
        if ($this->profile_from != null && $this->profile_to != null) {
            $tires->where('profile', '>=', $this->profile_from);
            $tires->where('profile', '<=', $this->profile_to);
        } elseif ($this->profile_from != null) {
            $tires->where('profile', $this->profile_from);
        }
        if ($this->diameter_from != null && $this->diameter_to != null) {
            $tires->where('diameter', '>=', $this->diameter_from);
            $tires->where('diameter', '<=', $this->diameter_to);
        } elseif ($this->diameter_from != null) {
            $tires->where('diameter', $this->diameter_from);
        }
        if ($this->price_from != null && $this->price_to != null) {
            $tires->where('price', '>=', $this->price_from);
            $tires->where('price', '<=', $this->price_to);
        } elseif ($this->price_from != null) {
            $tires->where('price', $this->price_from);
        }
        if ($this->is_commercial_yes && $this->is_commercial_yes == '1') {
            $tires->where('is_commercial', true);
        } elseif ($this->is_commercial_no && $this->is_commercial_no == '1') {
            $tires->where('is_commercial', false);
        }
        if ($this->created_at_from != null && $this->created_at_to != null) {
            $tires->where('created_at', '>=', $this->created_at_from);
            $tires->where('created_at', '<=', $this->created_at_to);
        } elseif ($this->created_at_from != null) {
            $tires->where('created_at', '>=', $this->created_at_from);
            $tires->where('created_at', '<=', Carbon::parse($this->created_at_from)->addDay()->format('Y-m-d'));
        }
        if ($this->discounted_at_from != null && $this->discounted_at_to != null) {
            $tires->where('discount_at', '>=', $this->discounted_at_from);
            $tires->where('discount_at', '<=', $this->discounted_at_to);
        } elseif ($this->discounted_at_from != null) {
            $tires->where('discount_at', '>=', $this->discounted_at_from);
            $tires->where('discount_at', '<=', Carbon::parse($this->discounted_at_from)->addDay()->format('Y-m-d'));
        }
        if ($this->price_discount_from != null && $this->price_discount_to != null) {
            $tires->where('price_discount', '>=', $this->price_discount_from);
            $tires->where('price_discount', '<=', $this->price_discount_to);
        } elseif ($this->price_discount_from != null) {
            $tires->where('price_discount', $this->price_discount_from);
        }
        $tires->where('amount', '>', 0);

        switch ($this->photo) {
            case 2:
                $tires->has('photos');
                break;
            case 3:
                $tires->doesntHave('photos');
                break;
        }

        if (auth()->user()->priceList) {
            foreach (auth()->user()->priceList->rules as $rule) {
                switch ($rule->operator) {
                    case '=':
                        $tires->where($rule->field, '!=', $rule->value);
                        break;
                    case '!=':
                        $tires->where($rule->field, '=', $rule->value);
                        break;
                    case '>':
                        $tires->where($rule->field, '<=', $rule->value);
                        break;
                    case '>=':
                        $tires->where($rule->field, '<', $rule->value);
                        break;
                    case '<':
                        $tires->where($rule->field, '>=', $rule->value);
                        break;
                    case '<=':
                        $tires->where($rule->field, '>', $rule->value);
                        break;
                    default:
                        $tires->where($rule->field, $rule->operatore, $rule->value);
                        break;
                }
            }
        }

        $tires->with('type');
        $tires->orderBy($this->order_by, $this->order_direction);

        return $tires;
    }

    public function select($value)
    {
        $this->tires_selected[] = $value;
    }

    public function unselect($value)
    {
        $this->tires_selected = array_diff($this->tires_selected, [$value]);
    }

    public function updatingOrderBy($value)
    {
        if ($this->order_by == $value && $this->order_direction == 'ASC') {
            $this->order_direction = 'DESC';
        } else {
            $this->order_direction = 'ASC';
        }
    }
}
