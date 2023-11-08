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
        TireStatus::Available => 'Disponibile',
        TireStatus::Reserved => 'Prenotato',
        TireStatus::ToShip => 'Spedizione',
        TireStatus::Sold => 'Venduto',
        TireStatus::Deposit => 'Deposito',
    ],
    ReservationType::class => [
        ReservationType::NotDefined => 'Non definito',
        ReservationType::Assembly => 'Montaggio',
        ReservationType::Pickup => 'Ritiro',
    ],
    PaymentType::class => [
        PaymentType::BankTransfer => 'Bonifico',
        PaymentType::PayPal => 'Paypal',
        PaymentType::CashOnDelivery => 'Contrassegno',
        PaymentType::Cash => 'Contanti',
        PaymentType::Cards => 'Carte',
        PaymentType::Check => 'Assegno',
        PaymentType::Pagodil => 'Pagodil',
    ],
    ShipmentStatus::class => [
        ShipmentStatus::ToBeConfirmed => 'Da confermare',
        ShipmentStatus::Confirmed => 'Confermata',
        ShipmentStatus::PartiallyProcessed => 'Evasa parzialmente',
        ShipmentStatus::Processed => 'Evasa',
        ShipmentStatus::Concluded => 'Conclusa',
        ShipmentStatus::Returned => 'Reso',
    ],
    ReservationStatus::class => [
        ReservationStatus::ToBeConfirmed => 'Da confermare',
        ReservationStatus::Confirmed => 'Confermata',
        ReservationStatus::PartiallyProcessed => 'Evasa parzialmente',
        ReservationStatus::Processed => 'Evasa',
        ReservationStatus::Concluded => 'Conclusa',
        ReservationStatus::Returned => 'Reso',
    ],
    Couriers::class => [
        Couriers::BRT => 'BRT',
        Couriers::GLS => 'GLS',
        Couriers::SDA => 'SDA',
        Couriers::PUA => 'Penumatici Adriatica',
    ],
    ProductType::class => [
        ProductType::GENERIC => 'Generico',
        ProductType::USED_TIRE => 'Pneumatico usato (PU)',
        ProductType::NEW_TIRE => 'Pneumatico nuovo',
    ],
    TireCategory::class => [
        TireCategory::HIGH_PROFILE => 'Alto profilo',
        TireCategory::PROFILE => 'Profilo',
        TireCategory::NEW => 'Nuovo',
        TireCategory::NEW_AGED => 'Nuovo datato',
        TireCategory::NEW_EXTRA => 'Nuovo extra',
        TireCategory::REPAIRED => 'Calabria',
    ],
    RegistryType::class => [
        RegistryType::PRIVATE => 'Privato',
        RegistryType::COMPANY => 'Azienda',
    ],
    RegistryRoleType::class => [
        RegistryRoleType::CUSTOMER => 'Cliente',
        RegistryRoleType::SUPPLIER => 'Fornitore',
        RegistryRoleType::CUSTOMER_AND_SUPPLIER => 'Cliente e fornitore',
    ],
    UserCustomerType::class => [
        UserCustomerType::BusinessToBusiness => 'B2B',
        UserCustomerType::Dropshipping => 'Dropshipping',
    ],
];
