<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static HIGH_PROFILE()
 * @method static static PROFILE()
 * @method static static NEW()
 * @method static static NEW_AGED()
 * @method static static NEW_EXTRA()
 * @method static static REPAIRED()
 */
final class TireCategory extends Enum implements LocalizedEnum
{
    const HIGH_PROFILE = 1;

    const PROFILE = 2;

    const REPAIRED = 6;

    const NEW = 3;

    const NEW_AGED = 4;

    const NEW_EXTRA = 5;
}
