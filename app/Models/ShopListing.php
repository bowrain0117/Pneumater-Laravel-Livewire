<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'tire_id',
        'shop',
        'listing_id',
        'user_id',
    ];

    public function tire()
    {
        return $this->belongsTo(Tire::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
