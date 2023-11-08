<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceList extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function rules()
    {
        return $this->hasMany(PriceListRules::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
