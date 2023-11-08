<?php

namespace App\Models;

use App\Enums\TireStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StorageScanTire extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'storage_scan_id',
        'tire_id',
        'ean',
        'rack_identifier',
        'rack_position',
        'ignore_status',
    ];

    public function tire(): BelongsTo
    {
        return $this->belongsTo(Tire::class);
    }

    public function isWrong(): bool
    {
        if ($this->tire == null ||
            ($this->tire && ($this->tire->rack_identifier != $this->rack_identifier || $this->tire->rack_position != $this->rack_position)) ||
            ($this->tire && $this->tire->status == TireStatus::Sold && ! $this->ignore_status)
        ) {
            return true;
        } else {
            return false;
        }
    }
}
