<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static CUSTOMER()
 * @method static static SUPPLIER()
 * @method static static CUSTOMER_AND_SUPPLIER()
 */
final class RegistryRoleType extends Enum implements LocalizedEnum
{
    const CUSTOMER = 0;

    const SUPPLIER = 1;

    const CUSTOMER_AND_SUPPLIER = 2;
}
