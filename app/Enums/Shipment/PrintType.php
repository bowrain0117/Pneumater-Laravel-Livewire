<?php

declare(strict_types=1);

namespace App\Enums\Shipment;

use BenSampo\Enum\Enum;

/**
 * @method static static ALL()
 * @method static static EXTERNAL_SHIPMENT()
 * @method static static INTERNAL_SHIPMENT()
 */
final class PrintType extends Enum
{
    const ALL = 0;

    const EXTERNAL_SHIPMENT = 1;

    const INTERNAL_SHIPMENT = 2;
}
