<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static PRIVATE()
 * @method static static COMPANY()
 */
final class RegistryType extends Enum implements LocalizedEnum
{
    const PRIVATE = 0;

    const COMPANY = 1;
}
