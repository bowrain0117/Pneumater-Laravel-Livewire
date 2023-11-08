<?php

use App\Enums\Couriers;
use App\Enums\PaymentType;
use App\Enums\ProductType;
use App\Enums\RegistryRoleType;
use App\Enums\RegistryType;
use App\Enums\ReservationStatus;
use App\Enums\ReservationType;
use App\Enums\ShipmentStatus;
use App\Enums\TireCategory;
use App\Enums\TireStatus;
use App\Enums\User\CustomerType as UserCustomerType;

return [

    TireStatus::class => [
        TireStatus::Available => 'Available',
        TireStatus::Reserved => 'Reverved',
        TireStatus::ToShip => 'To ship',
        TireStatus::Sold => 'Sold',
        TireStatus::Deposit => 'Deposit',
    ],
    ReservationType::class => [
        ReservationType::NotDefined => 'Not defined',
        ReservationType::Assembly => 'Assemby',
        ReservationType::Pickup => 'Pickup',
    ],
    PaymentType::class => [
        PaymentType::BankTransfer => 'Bank Transfer',
        PaymentType::PayPal => 'Paypal',
        PaymentType::CashOnDelivery => 'Cash on delivery',
        PaymentType::Cash => 'Cash',
        PaymentType::Cards => 'Cards',
        PaymentType::Check => 'Check',
        PaymentType::Pagodil => 'Pagodil',
    ],
    ShipmentStatus::class => [
        ShipmentStatus::ToBeConfirmed => 'To be confirmed',
        ShipmentStatus::Confirmed => 'Confirmed',
        ShipmentStatus::PartiallyProcessed => 'Partially processed',
        ShipmentStatus::Processed => 'Processed',
        ShipmentStatus::Concluded => 'Concluded',
        ShipmentStatus::Returned => 'Returned',
    ],
    ReservationStatus::class => [
        ReservationStatus::ToBeConfirmed => 'To be confirmed',
        ReservationStatus::Confirmed => 'Confirmed',
        ReservationStatus::PartiallyProcessed => 'Partially processed',
        ReservationStatus::Processed => 'Processed',
        ReservationStatus::Concluded => 'Concluded',
        ReservationStatus::Returned => 'Returned',
    ],
    Couriers::class => [
        Couriers::BRT => 'BRT',
        Couriers::GLS => 'GLS',
        Couriers::SDA => 'SDA',
        Couriers::PUA => 'Penumatici Adriatica',
    ],
    ProductType::class => [
        ProductType::GENERIC => 'Generic',
        ProductType::USED_TIRE => 'Used tire',
        ProductType::NEW_TIRE => 'New tire',
    ],
    TireCategory::class => [
        TireCategory::HIGH_PROFILE => 'High profile',
        TireCategory::PROFILE => 'Profile',
        TireCategory::NEW => 'New',
        TireCategory::NEW_AGED => 'New aged',
        TireCategory::NEW_EXTRA => 'New extra',
        TireCategory::REPAIRED => 'Repaired',
    ],
    RegistryType::class => [
        RegistryType::PRIVATE => 'Private',
        RegistryType::COMPANY => 'Company',
    ],
    RegistryRoleType::class => [
        RegistryRoleType::CUSTOMER => 'Customer',
        RegistryRoleType::SUPPLIER => 'Supplier',
        RegistryRoleType::CUSTOMER_AND_SUPPLIER => 'Customer and supplier',
    ],
    UserCustomerType::class => [
        UserCustomerType::BusinessToBusiness => 'B2B',
        UserCustomerType::Dropshipping => 'Dropshipping',
    ],
];
