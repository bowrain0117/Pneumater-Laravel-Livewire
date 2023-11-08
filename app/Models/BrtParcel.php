<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrtParcel extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipment_id',
        'lna',
        'sender_reference_number',
        'parcel_number',
        'parcel_tracking_number',
        'label_path_pdf',
        'label_path_img',
    ];

    public function shipment(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Shipment::class);
    }
}
