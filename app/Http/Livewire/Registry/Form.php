<?php

namespace App\Http\Livewire\Registry;

use App\Enums\RegistryRoleType;
use App\Enums\RegistryType;
use App\Models\Registry;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Form extends Component
{
    public $identifier;

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

    public $show_all_fields;

    public $create_mode;

    public $warning_duplicated_denomination;

    public $warning_duplicated_fiscal_code;

    public $warning_duplicated_vat_number;

    public $warning_duplicated_phone;

    public $warning_duplicated_cellular;

    public $warning_duplicated_email;

    public $cities_found;

    public $cities_found_shipment;

    public $duplicates_found;

    public $edit_redirect_field_name;

    public $edit_redirect_field_value;

    public function mount(int $role, Registry $registry)
    {
        $last_registry = Registry::orderBy('id', 'desc')->first();

        $this->identifier = $registry->id ?? null;
        $this->role = old('role', $registry->role ?? $role);
        $this->type = old('type', $registry->type ?? $role == RegistryRoleType::SUPPLIER ? RegistryType::COMPANY : RegistryType::PRIVATE);
        $this->code = old('code', $registry->code ?? ($last_registry ? 'PN-'.$last_registry->id + 1 : 'PN-1'));
        $this->fiscal_code = old('fiscal_code', $registry->fiscal_code ?? null);
        $this->vat_number = old('vat_number', $registry->vat_number ?? null);
        $this->sdi = old('sdi', $registry->sdi ?? null);
        $this->denomination = old('denomination', $registry->denomination ?? null);
        $this->name = old('name', $registry->name ?? null);
        $this->surname = old('surname', $registry->surname ?? null);
        $this->address = old('address', $registry->address ?? null);
        $this->city = old('city', $registry->city ?? null);
        $this->postal_code = old('postal_code', $registry->postal_code ?? null);
        $this->province = old('province', $registry->province ?? null);
        $this->region = old('region', $registry->region ?? null);
        $this->nation = old('nation', $registry->nation ?? null);
        $this->is_shipment_on_different_location = old('is_shipment_on_different_location', $registry->is_shipment_on_different_location ?? false);
        $this->denomination_shipment = old('denomination_shipment', $registry->denomination_shipment ?? null);
        $this->address_shipment = old('address_shipment', $registry->address_shipment ?? null);
        $this->city_shipment = old('city_shipment', $registry->city_shipment ?? null);
        $this->postal_code_shipment = old('postal_code_shipment', $registry->postal_code_shipment ?? null);
        $this->province_shipment = old('province_shipment', $registry->province_shipment ?? null);
        $this->region_shipment = old('region_shipment', $registry->region_shipment ?? null);
        $this->nation_shipment = old('nation_shipment', $registry->nation_shipment ?? null);
        $this->phone = old('phone', $registry->phone ?? null);
        $this->cellular = old('cellular', $registry->cellular ?? null);
        $this->email = old('email', $registry->email ?? null);
        $this->note = old('note', $registry->note ?? null);

        $this->cities_found = collect();
        $this->cities_found_shipment = collect();
        $this->duplicates_found = collect();

        $this->create_mode = is_null($registry->id);

        if (request()->has('redirectToReservationBill')) {
            $this->edit_redirect_field_name = 'redirectToReservationBill';
            $this->edit_redirect_field_value = request()->get('redirectToReservationBill');
        } elseif (request()->has('redirectToReservationEdit')) {
            $this->edit_redirect_field_name = 'redirectToReservationEdit';
            $this->edit_redirect_field_value = request()->get('redirectToReservationEdit');
        } elseif (request()->has('redirectToShipmentBill')) {
            $this->edit_redirect_field_name = 'redirectToShipmentBill';
            $this->edit_redirect_field_value = request()->get('redirectToShipmentBill');
        } elseif (request()->has('redirectToShipmentEdit')) {
            $this->edit_redirect_field_name = 'redirectToShipmentEdit';
            $this->edit_redirect_field_value = request()->get('redirectToShipmentEdit');
        }
    }

    public function updated($field, $value)
    {
        $this->findDuplicates();
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
    }

    public function updatedPostalCode($value)
    {
        $this->cities_found = $this->foundCityFromPostalCode($value);
        if (count($this->cities_found) == 1) {
            $this->selectCity(0);
        }

    }

    public function selectCityShipment($value)
    {
        $cities = json_decode(json_encode($this->cities_found_shipment), true);
        $this->city_shipment = $cities[$value]['comune'];
        $this->province_shipment = $cities[$value]['provincia'];
        $this->region_shipment = $cities[$value]['regione'];
        $this->nation_shipment = 'Italia';

        $this->cities_found_shipment = collect();
    }

    public function updatedPostalCodeShipment($value)
    {
        $this->cities_found_shipment = $this->foundCityFromPostalCode($value);
        if (count($this->cities_found_shipment) == 1) {
            $this->selectCityShipment(0);
        }

    }

    private function foundCityFromPostalCode($postal_code)
    {
        $cities = DB::connection('istat')->select('SELECT * FROM italy_cap JOIN italy_cities ON italy_cap.istat = italy_cities.istat WHERE italy_cap.cap = ?', [$postal_code]);
        if (count($cities) == 0) {
            $cities = DB::connection('istat')->select('SELECT * FROM italy_multicap JOIN italy_cities ON italy_multicap.istat = italy_cities.istat WHERE italy_multicap.cap = ?', [$postal_code]);
        }

        return $cities;
    }

    public function findDuplicates()
    {
        $query = Registry::query();

        if (auth()->user()->isA('customer')) {
            $query->where('created_by', auth()->id());
        }

        if ($this->type == RegistryType::COMPANY && $this->denomination != '') {
            $this->warning_duplicated_denomination = Registry::where(function ($q2) {
                foreach (explode(' ', $this->denomination) as $word) {
                    $q2->where(function ($q) use ($word) {
                        $q->orWhere('denomination', 'LIKE', '%'.$word.'%')
                            ->orWhere('name', 'LIKE', '%'.$word.'%')
                            ->orWhere('surname', 'LIKE', '%'.$word.'%');
                    });
                }
            })->where('id', '!=', $this->identifier)->count() > 0;

            $query->orWhere(function ($q2) {
                foreach (explode(' ', $this->denomination) as $word) {
                    $q2->where(function ($q) use ($word) {
                        $q->orWhere('denomination', 'LIKE', '%'.$word.'%')
                            ->orWhere('name', 'LIKE', '%'.$word.'%')
                            ->orWhere('surname', 'LIKE', '%'.$word.'%');
                    });
                }
            });
        } elseif ($this->type == RegistryType::PRIVATE && $this->name != '' && $this->surname != '') {
            $this->warning_duplicated_denomination = Registry::where(function ($q) {
                $q->where('name', 'LIKE', '%'.$this->name.'%');
                $q->where('surname', 'LIKE', '%'.$this->surname.'%');
            })->orWhere(function ($q) {
                $q->where('name', 'LIKE', '%'.$this->surname.'%');
                $q->where('surname', 'LIKE', '%'.$this->name.'%');
            })->where('id', '!=', $this->identifier)->count() > 0;

            $query->orWhere(function ($q) {
                $q->where('name', 'LIKE', '%'.$this->name.'%');
                $q->where('surname', 'LIKE', '%'.$this->surname.'%');
            });
            $query->orWhere(function ($q) {
                $q->where('name', 'LIKE', '%'.$this->surname.'%');
                $q->where('surname', 'LIKE', '%'.$this->name.'%');
            });
        } else {
            $this->warning_duplicated_denomination = false;
        }

        if ($this->fiscal_code != '') {
            $this->warning_duplicated_fiscal_code = Registry::where('fiscal_code', $this->fiscal_code)->where('id', '!=', $this->identifier)->count() > 0;
            $query->orWhere('fiscal_code', $this->fiscal_code);
        } else {
            $this->warning_duplicated_fiscal_code = false;
        }

        if ($this->vat_number != '') {
            $this->warning_duplicated_vat_number = Registry::where('vat_number', $this->vat_number)->where('id', '!=', $this->identifier)->count() > 0;
            $query->orWhere('vat_number', $this->vat_number);
        } else {
            $this->warning_duplicated_vat_number = false;
        }

        if ($this->phone != '') {
            $this->warning_duplicated_phone = Registry::where('phone', $this->phone)->where('id', '!=', $this->identifier)->count() > 0;
            $query->orWhere('phone', $this->phone);
        } else {
            $this->warning_duplicated_phone = false;
        }

        if ($this->cellular != '') {
            $this->warning_duplicated_cellular = Registry::where('cellular', $this->cellular)->where('id', '!=', $this->identifier)->count() > 0;
            $query->orWhere('cellular', $this->cellular);
        } else {
            $this->warning_duplicated_cellular = false;
        }

        if ($this->email != '') {
            $this->warning_duplicated_email = Registry::where('email', $this->email)->where('id', '!=', $this->identifier)->count() > 0;
            $query->orWhere('email', $this->email);
        } else {
            $this->warning_duplicated_email = false;
        }

        if ($this->warning_duplicated_denomination || $this->warning_duplicated_fiscal_code || $this->warning_duplicated_vat_number || $this->warning_duplicated_phone || $this->warning_duplicated_cellular || $this->warning_duplicated_email) {
            $this->duplicates_found = $query->get();
        } else {
            $this->duplicates_found = collect();
        }

    }

    public function render()
    {
        return view('livewire.registry.form');
    }
}
