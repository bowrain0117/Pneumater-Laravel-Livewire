<?php

namespace App\Console\Commands;

use App\Enums\Couriers;
use App\Enums\PaymentType;
use App\Enums\ReservationStatus;
use App\Enums\ReservationType;
use App\Enums\TireStatus;
use App\Models\Reservation;
use App\Models\Shipment;
use App\Models\Tire;
use App\Models\User;
use DB;
use Illuminate\Console\Command;

class MigrateFromLegacy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'legacy:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        echo "Fetching tires...\n";

        $tires = DB::connection('lagacy-mysql')->table('tires')->get();

        echo 'Found '.$tires->count()." tires\n";

        echo "Migrating...\n";

        foreach ($tires as $tire) {
            switch ($tire->status) {
                case 1:
                case 2:
                    $status = TireStatus::Available;
                    break;
                case 3:
                    $status = TireStatus::Sold;
                    break;
                case 4:
                    $status = TireStatus::Reserved;
                    break;
                case 5:
                    $status = TireStatus::ToShip;
                    break;
                default:
                    $status = TireStatus::Available;

            }

            switch ($tire->season) {
                case 'Estiva':
                    $season = 1;
                    break;
                case 'Invernale':
                    $season = 2;
                    break;
                case '4 Stagioni':
                    $season = 3;
                    break;
                case 'Estiva (m+s)':
                    $season = 4;
                    break;
                default:
                    $season = 1;
            }

            switch ($tire->type) {
                case 1:
                    $type = 1;
                    break;
                case 3:
                case 2:
                    $type = 2;
                    break;
                case 4:
                    $type = 5;
                    break;
                default:
                    $type = 2;
            }

            $n_tire = new Tire;
            $n_tire->fill([
                'ean' => '',
                'category_id' => $type,
                'millimeters' => $tire->millimeters,
                'millimeters_2' => $tire->millimeters_2,
                'millimeters_new_by_manufacturer' => $tire->millimeters_manufacturer,
                'width' => $tire->width,
                'profile' => $tire->profile,
                'diameter' => $tire->diameter,
                'brand' => $tire->brand,
                'model' => $tire->model,
                'type_id' => $season,
                'load_index' => $tire->load_index,
                'speed_index' => $tire->speed,
                'is_commercial' => $tire->load_c,
                'dot' => $tire->construction_year,
                'amount' => $tire->amount,
                'rack_identifier' => $tire->rack,
                'rack_position' => $tire->rack_position,
                'price' => $tire->price,
                'price_not_discounted' => $tire->price_not_discounted,
                'price_ebay' => $tire->price_ebay,
                'status' => $status,
                'created_by' => User::first()->id,
                'created_at' => $tire->advertisement_date,
                'updated_at' => $tire->advertisement_date,
            ]);

            $n_tire->id = $tire->id;
            $n_tire->ebay_selling_id = ($tire->id_ebay == -1 ? null : $tire->id_ebay);
            $n_tire->is_for_sale_on_kijiji = $tire->id_kijiji;
            $n_tire->is_for_sale_on_subito = $tire->id_subito;

            if ($type == 5 && $tire->new_price != 0) {
                $price = $tire->new_price;
                $amount = ($tire->amount != 0) ? $tire->amount : 1;

                switch ($tire->diameter) {
                    case 13:
                    case 14:
                        $price += 5;
                        break;
                    case 15:
                    case 16:
                        $price += 6.25;
                        break;
                    case 17:
                    case 18:
                        $price += 7.5;
                        break;
                    case 19:
                    case 20:
                        $price += 8.75;
                        break;
                    default:
                        $price += 10;
                }

                $price = $price * $amount;

                $n_tire->price = $tire->new_price;
                $n_tire->price_list = $price;
                $n_tire->price_ebay = round(
                    $price * 1.07, 1, PHP_ROUND_HALF_UP
                );
            }

            $n_tire->save();

            if ($status == TireStatus::Reserved) {
                $reservation = DB::connection('lagacy-mysql')->table('reservations')->where('id_tire', $tire->id)->first();

                if ($reservation) {
                    switch ($reservation->type) {
                        case 1:
                            $reservation_type = ReservationType::Assembly;
                            break;
                        case 2:
                            $reservation_type = ReservationType::Pickup;
                            break;
                        case 3:
                            $reservation_type = ReservationType::NotDefined;
                            break;
                        default:
                            $reservation_type = ReservationType::NotDefined;
                    }

                    $n_reservation = new Reservation();
                    $n_reservation->fill([
                        'name' => $reservation->name,
                        'phone' => $reservation->phone,
                        'email' => $reservation->email,
                        'type' => $reservation_type,
                        'source' => '',
                        'price' => 0,
                        'deposit' => $reservation->deposit,
                        'created_by' => User::first()->id,
                    ]);
                    if ($reservation->date) {
                        $n_reservation->appointment_date = $reservation->date;
                        $n_reservation->appointment_time = date('G:i', strtotime($reservation->date));
                        $n_reservation->status = ReservationStatus::Confirmed;
                    } else {
                        $n_reservation->status = ReservationStatus::ToBeConfirmed;
                    }
                    $n_reservation->save();
                    $n_reservation->tires()->sync($n_tire);
                } else {
                    $n_tire->status = TireStatus::Sold;
                    $n_tire->save();
                }
            } elseif ($status == TireStatus::ToShip) {
                $shipment = DB::connection('lagacy-mysql')->table('shipments')->where('id_tire', $tire->id)->first();

                if ($shipment) {
                    $n_shipment = new Shipment();
                    $n_shipment->fill([
                        'name' => 'N/D',
                        'payment_type' => PaymentType::PayPal,
                        'note' => $shipment->note,
                        'price' => 0,
                        'deposit' => 0,
                        'courier' => Couriers::BRT,
                        'created_by' => User::first()->id,
                    ]);
                    $n_shipment->save();
                    $n_shipment->tires()->sync($n_tire);
                } else {
                    $n_tire->status = TireStatus::Sold;
                    $n_tire->save();
                }
            }
        }

        echo "Migration completed\n";

        return 0;
    }
}
