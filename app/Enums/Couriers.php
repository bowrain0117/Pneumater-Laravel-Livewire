<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static BRT()
 * @method static static GLS()
 * @method static static SDA()
 * @method static static PUA()
 */
final class Couriers extends Enum implements LocalizedEnum
{
    const BRT = 0;

    const GLS = 1;

    const SDA = 2;

    const PUA = 3;
}
