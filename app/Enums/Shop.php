<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Ebay()
 * @method static static Subito()
 */
final class Shop extends Enum
{
    const Ebay = 1;

    const Subito = 2;
}
