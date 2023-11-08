<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static ToBeConfirmed()
 * @method static static Confirmed()
 * @method static static PartiallyProcessed()
 * @method static static Processed()
 * @method static static Concluded()
 * @method static static Returned()
 */
final class ReservationStatus extends Enum implements LocalizedEnum
{
    const ToBeConfirmed = 0;

    const Confirmed = 1;

    const PartiallyProcessed = 2;

    const Processed = 3;

    const Concluded = 4;

    const Returned = 5;
}
