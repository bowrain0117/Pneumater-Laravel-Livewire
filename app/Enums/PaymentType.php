<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static Cash()
 * @method static static Cards()
 * @method static static CashOnDelivery()
 * @method static static PayPal()
 * @method static static BankTransfer()
 * @method static static Check()
 * @method static static Pagodil()
 */
final class PaymentType extends Enum implements LocalizedEnum
{
    const BankTransfer = 0;

    const PayPal = 1;

    const CashOnDelivery = 2;

    const Cash = 3;

    const Cards = 4;

    const Check = 5;

    const Pagodil = 6;

    public static function getReservationInstances()
    {
        return [
            self::Cash(),
            self::Cards(),
            self::BankTransfer(),
            self::Check(),
            self::Pagodil(),
        ];
    }

    public static function getShipmentInstances()
    {
        return [
            self::BankTransfer(),
            self::PayPal(),
            self::CashOnDelivery(),
            self::Check(),
            self::Pagodil(),
        ];
    }

    public static function getEasyFattName($value)
    {
        return match ($value) {
            self::Cash => 'Contanti',
            self::Cards => 'Carta di credito',
            self::Pagodil, self::BankTransfer => 'Bonifico',
            self::Check => 'Assegno',
            self::PayPal => 'PayPal',
            self::CashOnDelivery => 'Contrassegno',
            default => '',
        };
    }
}
