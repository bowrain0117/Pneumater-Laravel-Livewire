<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TirePhoto extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tire_id',
        'path',
    ];

    public function tire()
    {
        return $this->belongsTo(Tire::class);
    }

    public function customPhotos()
    {
        return $this->hasMany(TireCustomPhoto::class);
    }
}
