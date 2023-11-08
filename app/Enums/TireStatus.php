<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static Available()
 * @method static Reserved()
 * @method static ToShip()
 * @method static Sold()
 * @method static Deposit()
 */
final class TireStatus extends Enum implements LocalizedEnum
{
    const Available = 1;

    const Reserved = 2;

    const ToShip = 3;

    const Sold = 4;

    const Deposit = 5;
}
