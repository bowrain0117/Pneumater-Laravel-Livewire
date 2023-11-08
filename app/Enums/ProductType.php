<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static GENERIC()
 * @method static static USED_TIRE()
 * @method static static NEW_TIRE()
 */
final class ProductType extends Enum implements LocalizedEnum
{
    const GENERIC = 0;

    const USED_TIRE = 1;

    const NEW_TIRE = 2;
}
