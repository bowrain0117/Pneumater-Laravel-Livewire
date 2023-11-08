<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static Available()
 * @method static static Mounted()
 * @method static static Picked_Up()
 * @method static static Scraped()
 */
final class DepositStatus extends Enum implements LocalizedEnum
{
    const Available = 1;

    const Mounted = 2;

    const Picked_Up = 3;

    const Scraped = 4;
}
