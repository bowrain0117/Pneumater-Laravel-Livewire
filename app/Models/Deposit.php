<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_model',
        'license_plate',
        'status',
        'note',
        'registry_id',
    ];

    public function tires()
    {
        return $this->belongsToMany(Tire::class);
    }

    public function registry()
    {
        return $this->belongsTo(Registry::class);
    }
}
