<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registry extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'role',
        'code',
        'fiscal_code',
        'vat_number',
        'sdi',
        'denomination',
        'name',
        'surname',
        'address',
        'city',
        'postal_code',
        'province',
        'region',
        'nation',
        'is_shipment_on_different_location',
        'denomination_shipment',
        'address_shipment',
        'city_shipment',
        'postal_code_shipment',
        'province_shipment',
        'region_shipment',
        'nation_shipment',
        'phone',
        'cellular',
        'email',
        'note',
        'created_by',
    ];

    protected function denomination(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => ucwords(strtolower($value)),
        );
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => ucwords(strtolower($value)),
        );
    }

    protected function surname(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => ucwords(strtolower($value)),
        );
    }

    protected function address(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => ucwords(strtolower($value)),
        );
    }

    protected function city(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => ucwords(strtolower($value)),
        );
    }

    protected function province(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => strtoupper($value),
        );
    }

    protected function region(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => ucwords(strtolower($value)),
        );
    }

    protected function nation(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => ucwords(strtolower($value)),
        );
    }

    protected function denominationShipment(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => ucwords(strtolower($value)),
        );
    }

    protected function addressShipment(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => ucwords(strtolower($value)),
        );
    }

    protected function cityShipment(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => ucwords(strtolower($value)),
        );
    }

    protected function provinceShipment(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => strtoupper($value),
        );
    }

    protected function regionShipment(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => ucwords(strtolower($value)),
        );
    }

    protected function nationShipment(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => ucwords(strtolower($value)),
        );
    }

    protected function phone(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => strtolower(str_replace(' ', '', $value)),
        );
    }

    protected function cellular(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => strtolower(str_replace(' ', '', $value)),
        );
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }

    public function getLastOperationAttribute()
    {
        $last_reservation = $this->reservations()->orderBy('created_at', 'DESC')->first();
        $last_shipment = $this->shipments()->orderBy('created_at', 'DESC')->first();

        $last_operation = null;

        if ($last_reservation != null && $last_shipment != null) {
            if ($last_reservation->created_at > $last_shipment->created_at) {
                $last_operation = $last_reservation;
            } else {
                $last_operation = $last_shipment;
            }
        } elseif ($last_reservation != null && $last_shipment == null) {
            $last_operation = $last_reservation;
        } elseif ($last_reservation == null && $last_shipment != null) {
            $last_operation = $last_shipment;
        }

        return $last_operation;
    }
}
