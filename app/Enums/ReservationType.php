<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static NotDefined()
 * @method static static Assembly()
 * @method static static Pickup()
 */
final class ReservationType extends Enum implements LocalizedEnum
{
    const NotDefined = 0;

    const Assembly = 1;

    const Pickup = 2;
}
