<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceListRules extends Model
{
    use HasFactory;

    protected $fillable = [
        'price_list_id',
        'field',
        'operator',
        'value',
    ];
}
