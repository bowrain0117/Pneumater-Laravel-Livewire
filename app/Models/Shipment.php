<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'registry_id',
        'status',
        'payment_type',
        'source',
        'estimated_departure',
        'note',
        'price',
        'deposit',
        'packages',
        'courier',
        'tracking_code',
        'ddt_number',
        'ddt_date',
        'contextual_pickup',
        'stationary_storage',
        'to_invoice',
        'is_confirmation_needed',
        'created_by',
    ];

    protected $casts = [
        'estimated_departure' => 'date',
        'ddt_date' => 'date',
    ];

    public function registry(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Registry::class);
    }

    public function tires(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Tire::class)->withPivot('id', 'price_override', 'ebay_listing_id', 'ebay_listing_user_id');
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->HasMany(Product::class);
    }

    public function createdBy(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function brtParcels(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(BrtParcel::class);
    }

    public function recalculatePackages(): void
    {
        $indexed_amount = [];
        $packages = 0;

        foreach ($this->tires as $tire) {
            $index = $tire->profile.'$'.$tire->width.'$'.$tire->diameter.'$'.$tire->is_commercial;
            $indexed_amount[$index] = isset($indexed_amount[$index]) ? $indexed_amount[$index] + $tire->amount : $tire->amount;
        }

        foreach ($indexed_amount as $index => $amount) {
            $tire_specs = explode('$', $index);
            $packages += getTirePackages($tire_specs[0], $tire_specs[1], $tire_specs[2], $tire_specs[3], $amount);
        }

        $this->packages = round($packages, 0, PHP_ROUND_HALF_UP);
        $this->save();
    }
}
