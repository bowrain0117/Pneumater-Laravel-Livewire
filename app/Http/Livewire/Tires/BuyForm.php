<?php

namespace App\Http\Livewire\Tires;

use App\Enums\Couriers;
use App\Enums\PaymentType;
use App\Enums\ShipmentStatus;
use App\Enums\Shop;
use App\Enums\TireStatus;
use App\Models\Shipment;
use App\Models\Tire;
use Illuminate\Support\Carbon;
use Livewire\Component;

class BuyForm extends Component
{
    public $tires;

    public $estimated_departure;

    public $note;

    public $amounts;

    public function mount($tires)
    {
        $this->tires = $tires;

        if (date('H') < '13') {
            $this->estimated_departure = Carbon::today();
        } else {
            $this->estimated_departure = Carbon::tomorrow();
        }

        foreach ($tires as $tire) {
            $this->amounts[$tire->id] = $tire->amount;
        }
    }

    public function render()
    {
        return view('livewire.tires.buy-form');
    }

    public function removeTire($tire_id)
    {
        $this->tires->pull($tire_id);
    }

    public function submit()
    {
        $shipment = new Shipment();
        $shipment->fill([
            'registry_id' => auth()->user()->registry_id,
            'source' => 'B2B',
            'estimated_departure' => $this->estimated_departure,
            'payment_type' => PaymentType::BankTransfer,
            'note' => $this->note,
            'price' => 0,
            'deposit' => 0,
            'packages' => 0,
            'contextual_pickup' => false,
            'stationary_storage' => false,
            'to_invoice' => true,
            'courier' => auth()->user()->default_courier ?? Couriers::BRT,
        ]);
        $shipment->created_by = auth()->user()->id;
        $shipment->status = ShipmentStatus::Confirmed;
        $shipment->save();

        foreach ($this->tires as $tire) {
            // removing tire form all shops
            if ($tire->listings()->where('shop', Shop::Subito)->count() > 0) {
                $tire->listings()->where('shop', Shop::Subito)->delete();
            }

            $tire->removeAllFromEbay();
            $tire->save();

            // if less than full amount is sold tire is splitted in two sets
            // 1 ($tire) -> contain remaining amount left
            // 2 ($tire_duplicate) -> new tire set that represet sold amount

            if ($tire->amount != $this->amounts[$tire->id] || $tire->category == 3) {
                $tire_duplicate = Tire::create($tire->toArray());
                $tire_duplicate->amount -= $this->amounts[$tire->id];
                $tire_duplicate->millimeters = 0;
                $tire_duplicate->millimeters_2 = 0;
                $tire_duplicate->dot = '';
                $tire_duplicate->rack_identifier = null;
                $tire_duplicate->rack_position = null;
                $tire_duplicate->recalculatePrices();
                $tire_duplicate->save();

                $tire->amount = $this->amounts[$tire->id];
                $tire->status = TireStatus::Reserved;
                $tire->recalculatePrices();
                if (
                    $tire->category == 3
                    || $tire->category == 4
                    || $tire->category == 5
                ) {
                    $tire->duplicatePhotos($tire_duplicate);
                }

                $shipment->tires()->attach([$tire->id], ['price_override' => $tire->category == \App\Enums\TireCategory::NEW ? $tire->getKijijiPrice() * $tire->amount : $tire->getKijijiPrice()]);
            } else {
                $tire->status = TireStatus::Reserved;
                $shipment->tires()->attach([$tire->id], ['price_override' => $tire->category == \App\Enums\TireCategory::NEW ? $tire->getKijijiPrice() * $tire->amount : $tire->getKijijiPrice()]);
            }

            $shipment->price += $tire->category == \App\Enums\TireCategory::NEW ? $tire->getKijijiPrice() * $tire->amount : $tire->getKijijiPrice();
            $shipment->save();
            $shipment->recalculatePackages();

            $tire->save();
        }

        return redirect()->route('tires.index');
    }
}
