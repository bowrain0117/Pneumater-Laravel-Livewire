<?php

namespace Database\Seeders;

use App\Models\Lift;
use App\Models\Product;
use App\Models\Reservation;
use App\Models\Service;
use App\Models\Shipment;
use App\Models\Tire;
use App\Models\TirePhoto;
use Bouncer;
use Illuminate\Database\Seeder;

class BouncerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bouncer::allow('admin')->everything();

        Bouncer::allow('operator')->toManage(Tire::class);
        Bouncer::allow('operator')->toManage(Product::class);
        Bouncer::allow('operator')->toManage(Reservation::class);
        Bouncer::allow('operator')->toManage(Service::class);
        Bouncer::allow('operator')->toManage(Shipment::class);
        Bouncer::allow('operator')->toManage(TirePhoto::class);
        Bouncer::allow('operator')->toManage(Lift::class);

        Bouncer::allow('customer')->to('view', Tire::class);
    }
}
