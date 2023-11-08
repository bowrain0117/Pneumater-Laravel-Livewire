<?php

namespace App\Http\Livewire\Registry;

use App\Enums\RegistryRoleType;
use App\Enums\RegistryType;
use App\Models\Registry;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Picker extends Component
{
    public $type;

    public $role;

    public $code;

    public $fiscal_code;

    public $vat_number;

    public $sdi;

    public $denomination;

    public $name;

    public $surname;

    public $address;

    public $city;

    public $postal_code;

    public $province;

    public $region;

    public $nation;

    public $is_shipment_on_different_location;

    public $denomination_shipment;

    public $address_shipment;

    public $city_shipment;

    public $postal_code_shipment;

    public $province_shipment;

    public $region_shipment;

    public $nation_shipment;

    public $phone;

    public $cellular;

    public $email;

    public $note;

    public $registry;

    public $registries_found;

    public $cities_found;

    public $cities_found_shipment;

    public $search_mode;

    public $allow_create;

    public $shipment_mode;

    public $show_all_fields;

    public $edit_redirect_field_name;

    public $edit_redirect_field_value;

    protected $rules = [
        'role' => 'required|integer',
        'type' => 'required|integer',
        'fiscal_code' => 'nullable|string',
        'vat_number' => 'nullable|string',
        'sdi' => 'nullable|string',
        'address' => 'nullable|string',
        'city' => 'nullable|string',
        'postal_code' => 'nullable|string',
        'province' => 'nullable|string',
        'region' => 'nullable|string',
        'nation' => 'nullable|string',
        'is_shipment_on_different_location' => 'nullable|boolean',
        'denomination_shipment' => 'nullable|string',
        'address_shipment' => 'nullable|string',
        'city_shipment' => 'nullable|string',
        'postal_code_shipment' => 'nullable|string',
        'province_shipment' => 'nullable|string',
        'region_shipment' => 'nullable|string',
        'nation_shipment' => 'nullable|string',
        'phone' => 'nullable|string',
        'cellular' => 'nullable|string',
        'email' => 'nullable|string',
        'note' => 'nullable|string',
    ];

    public function mount(Registry $registry, $shipment_mode = false, $edit_redirect_field_name = null, $edit_redirect_field_value = null)
    {
        $this->role = old('role', RegistryRoleType::CUSTOMER);
        $this->type = old('type', $registry->type ?? RegistryType::PRIVATE);
        $this->code = old('code', '');
        $this->fiscal_code = old('fiscal_code', '');
        $this->vat_number = old('vat_number', '');
        $this->sdi = old('sdi', '');
        $this->denomination = old('denomination', '');
        $this->name = old('name', '');
        $this->surname = old('surname', '');
        $this->address = old('address', '');
        $this->city = old('city', '');
        $this->postal_code = old('postal_code', '');
        $this->province = old('province', '');
        $this->region = old('region', '');
        $this->nation = old('nation', '');
        $this->denomination_shipment = old('denomination_shipment', '');
        $this->address_shipment = old('address_shipment', '');
        $this->city_shipment = old('city_shipment', '');
        $this->postal_code_shipment = old('postal_code_shipment', '');
        $this->province_shipment = old('province_shipment', '');
        $this->region_shipment = old('region_shipment', '');
        $this->nation_shipment = old('nation_shipment', '');
        $this->phone = old('phone', '');
        $this->cellular = old('cellular', '');
        $this->email = old('email', '');
        $this->note = old('note', '');

        $this->show_all_fields = false;
        $this->is_shipment_on_different_location = old('is_shipment_on_different_location', false);

        $this->registry = $registry;
        $this->cities_found = collect();
        $this->cities_found_shipment = collect();
        $this->registries_found = collect();

        $this->shipment_mode = $shipment_mode;
        $this->search_mode = $registry->id == null;
        $this->allow_create = false;

        $this->edit_redirect_field_name = $edit_redirect_field_name;
        $this->edit_redirect_field_value = $edit_redirect_field_value;
    }

    public function updated($field, $value)
    {
        if ($field == 'type') {
            $this->denomination = '';
            $this->name = '';
            $this->surname = '';
        }

        if ($field != 'show_all_fields') {
            $this->registries_found = $this->findRegisty();
        }

        $this->checkForCreateButton();
    }

    private function checkForCreateButton(): void
    {
        if (
            (
                ($this->denomination != '' || ($this->name != '' && $this->surname != '')) &&
                ($this->cellular != '' || $this->phone != '' || $this->email != '') && ! $this->shipment_mode
            ) || (
                ($this->denomination != '' || ($this->name != '' && $this->surname != '')) &&
                ($this->cellular != '' || $this->phone != '' || $this->email != '') &&
                $this->address != '' &&
                $this->postal_code != '' &&
                $this->city != '' &&
                $this->province != '' &&
                $this->region != '' &&
                $this->nation != '' &&
                $this->shipment_mode
            )
        ) {
            $this->allow_create = true;
        } else {
            $this->allow_create = false;
        }
    }

    public function updatedIsShipmentOnDifferentLocation($value)
    {
        if ($value == 1) {
            if ($this->type == RegistryType::COMPANY) {
                $this->denomination_shipment = $this->denomination;
            } else {
                $this->denomination_shipment = $this->name.' '.$this->surname;
            }

            $this->address_shipment = $this->address;
            $this->postal_code_shipment = $this->postal_code;
            $this->city_shipment = $this->city;
            $this->province_shipment = $this->province;
            $this->region_shipment = $this->region;
            $this->nation_shipment = $this->nation;
        }
    }

    public function selectCity($value)
    {
        $cities = json_decode(json_encode($this->cities_found), true);
        $this->city = $cities[$value]['comune'];
        $this->province = $cities[$value]['provincia'];
        $this->region = $cities[$value]['regione'];
        $this->nation = 'Italia';

        $this->cities_found = collect();
        $this->checkForCreateButton();
    }

    public function updatedPostalCode($value)
    {
        $this->cities_found = $this->foundCityFromPostalCode($value);
        if (count($this->cities_found) == 1) {
            $this->selectCity(0);
        }

        $this->checkForCreateButton();
    }

    public function selectCityShipment($value)
    {
        $cities = json_decode(json_encode($this->cities_found_shipment), true);
        $this->city_shipment = $cities[$value]['comune'];
        $this->province_shipment = $cities[$value]['provincia'];
        $this->region_shipment = $cities[$value]['regione'];
        $this->nation_shipment = 'Italia';

        $this->cities_found_shipment = collect();
        $this->checkForCreateButton();
    }

    public function updatedPostalCodeShipment($value)
    {
        $this->cities_found_shipment = $this->foundCityFromPostalCode($value);
        if (count($this->cities_found_shipment) == 1) {
            $this->selectCityShipment(0);
        }

        $this->checkForCreateButton();
    }

    private function foundCityFromPostalCode($postal_code)
    {
        $cities = DB::connection('istat')->select('SELECT * FROM italy_cap JOIN italy_cities ON italy_cap.istat = italy_cities.istat WHERE italy_cap.cap = ?', [$postal_code]);
        if (count($cities) == 0) {
            $cities = DB::connection('istat')->select('SELECT * FROM italy_multicap JOIN italy_cities ON italy_multicap.istat = italy_cities.istat WHERE italy_multicap.cap = ?', [$postal_code]);
        }

        return $cities;
    }

    public function findRegisty()
    {
        $query = Registry::query();
        $query->where('role', $this->role);

        if (auth()->user()->isA('customer')) {
            $query->where('created_by', auth()->id());
        }

        $query->where(function ($q) {
            if ($this->code != '') {
                $q->orWhere('code', 'LIKE', '%'.$this->code.'%');
            }
            if ($this->denomination != '') {
                foreach (explode(' ', $this->denomination) as $word) {
                    $q->where(function ($q2) use ($word) {
                        $q2->orWhere('denomination', 'LIKE', '%'.$word.'%')
                            ->orWhere('name', 'LIKE', '%'.$word.'%')
                            ->orWhere('surname', 'LIKE', '%'.$word.'%');
                    });
                }
            }
            if ($this->name != '' && $this->surname != '') {
                $q->orWhere(function ($q2) {
                    $q2->where('name', 'LIKE', '%'.$this->name.'%');
                    $q2->where('surname', 'LIKE', '%'.$this->surname.'%');
                });
                $q->orWhere(function ($q2) {
                    $q2->where('name', 'LIKE', '%'.$this->surname.'%');
                    $q2->where('surname', 'LIKE', '%'.$this->name.'%');
                });
                $q->orWhere(function ($q2) {
                    $q2->where('denomination', 'LIKE', '%'.$this->name.'%');
                    $q2->where('denomination', 'LIKE', '%'.$this->surname.'%');
                });
            } elseif ($this->name != '') {
                $q->orWhere('name', 'LIKE', '%'.$this->name.'%');
                $q->orWhere('surname', 'LIKE', '%'.$this->name.'%');
                $q->orWhere(function ($q2) {
                    $q2->where('denomination', 'LIKE', '%'.$this->name.'%');
                });
            } elseif ($this->surname != '') {
                $q->orWhere('surname', 'LIKE', '%'.$this->surname.'%');
                $q->orWhere('name', 'LIKE', '%'.$this->surname.'%');
                $q->orWhere(function ($q2) {
                    $q2->where('denomination', 'LIKE', '%'.$this->surname.'%');
                });
            }
            if ($this->fiscal_code != '') {
                $q->orWhere('fiscal_code', 'LIKE', '%'.$this->fiscal_code.'%');
            }
            if ($this->vat_number != '') {
                $q->orWhere('vat_number', 'LIKE', '%'.$this->vat_number.'%');
            }
            if ($this->phone != '') {
                $q->orWhere('phone', 'LIKE', '%'.$this->phone.'%');
                if ($this->phone != str_replace(' ', '', $this->phone)) {
                    $q->orWhere('phone', 'LIKE', '%'.str_replace(' ', '', $this->phone).'%');
                }
            }
            if ($this->cellular != '') {
                $q->orWhere('cellular', 'LIKE', '%'.$this->cellular.'%');
                if ($this->cellular != str_replace(' ', '', $this->cellular)) {
                    $q->orWhere('cellular', 'LIKE', '%'.str_replace(' ', '', $this->cellular).'%');
                }
            }
            if ($this->email != '') {
                $q->orWhere('email', 'LIKE', '%'.$this->email.'%');
            }
        });

        if (
            $this->code != '' ||
            $this->denomination != '' ||
            $this->name != '' ||
            $this->surname != '' ||
            $this->fiscal_code != '' ||
            $this->vat_number != '' ||
            $this->phone != '' ||
            $this->cellular != '' ||
            $this->email != ''
        ) {
            $query = $query->limit(20)->get();
        } else {
            $query = collect();
        }

        return $query;
    }

    public function enterSearchMode()
    {
        $this->search_mode = true;
    }

    public function selectRegistry(Registry $registry)
    {
        $this->registry = $registry;
        $this->registries_found = collect();
        $this->search_mode = false;
    }

    public function createRegistry()
    {
        if ($this->type == RegistryType::COMPANY) {
            $rules = array_merge($this->rules, [
                'denomination' => 'required|string',
            ]);
        } else {
            $rules = array_merge($this->rules, [
                'name' => 'required|string',
                'surname' => 'required|string',
            ]);
        }

        $last_registry = Registry::orderBy('id', 'desc')->first();

        $validated = $this->validate($rules);
        $this->registry = new Registry;
        $this->registry->fill($validated);
        $this->registry->code = $last_registry ? 'PN-'.$last_registry->id + 1 : 'PN-1';
        $this->registry->created_by = auth()->id();
        $this->registry->save();

        $this->registries_found = collect();
        $this->search_mode = false;
    }

    public function render()
    {
        return view('livewire.registry.picker');
    }
}
