<?php

namespace App\Models;

use App\Enums\ProductType;
use App\Enums\ReservationType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
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
        'type',
        'source',
        'note',
        'appointment_date',
        'appointment_time',
        'amount_of_time_slot',
        'lift_id',
        'price',
        'deposit',
        'deposit_received_at',
        'payment_type',
        'payed',
        'created_by',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'deposit_received_at' => 'datetime',
    ];

    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = str_replace(' ', '', $value);
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = str_replace(' ', '', $value);
    }

    public function registry(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Registry::class);
    }

    public function tires(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Tire::class)->withPivot('id', 'price_override');
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->HasMany(Product::class);
    }

    public function services(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Service::class)->withPivot('id', 'amount', 'price_override');
    }

    public function deposits(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Deposit::class, 'reservation_deposit')->withPivot('id', 'amount');
    }

    public function lift(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Lift::class);
    }

    public function createdBy(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function updateLabour()
    {
        if ($this->type == ReservationType::Assembly) {
            $amount = $this->tires->sum('amount') + $this->products()->where('type', '!=', ProductType::GENERIC)->get()->sum('amount');

            $service = Service::where('code', 'MI')->first();
            if ($service) {
                if ($amount > 0) {
                    if ($this->services()->where('code', 'MI')->first()) {
                        $this->services()->updateExistingPivot($service, ['amount' => $amount], false);
                    } else {
                        $this->services()->attach([$service->id], ['amount' => $amount]);
                    }
                } else {
                    $this->services()->detach($service);
                }
            }
        } else {
            $service = Service::where('code', 'MI')->first();
            if ($service) {
                $this->services()->detach($service);
            }
        }
    }
}
