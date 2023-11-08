<?php

declare(strict_types=1);

namespace App\Enums\User;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static BusinessToBusiness()
 * @method static static Dropshipping()
 */
final class CustomerType extends Enum implements LocalizedEnum
{
    const BusinessToBusiness = 1;

    const Dropshipping = 2;
}
