<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'description',
        'pfu_contribution',
        'price',
        'amount',
        'type',
        'rack_identifier',
        'rack_position',
        'reservation_id',
        'shipment_id',
    ];
}
