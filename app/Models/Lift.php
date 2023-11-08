<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Lift
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Lift newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Lift newQuery()
 * @method static \Illuminate\Database\Query\Builder|Lift onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Lift query()
 * @method static \Illuminate\Database\Eloquent\Builder|Lift whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lift whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lift whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lift whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lift whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lift whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Lift withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Lift withoutTrashed()
 *
 * @mixin \Eloquent
 */
class Lift extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
    ];
}
