<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TireCustomPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'tire_photo_id',
        'user_id',
        'path',
    ];
}
