<?php

namespace App\Http\Livewire\Tables\Row;

use App\Enums\ReservationStatus;
use App\Enums\ShipmentStatus;
use App\Enums\TireStatus;
use App\Models\StorageScan;
use App\Models\StorageScanTire;
use App\Models\Tire;
use Livewire\Component;
use function view;

class NotScannedTire extends Component
{
    public $tire;

    public StorageScan $storageScan;

    public function mount(Tire $tire, StorageScan $storageScan)
    {
        $this->tire = $tire;
    }

    public function render()
    {
        return view('livewire.tables.row.not-scanned-tire');
    }

    public function moveToSold()
    {
        if ($this->tire->ebay_selling_id) {
            $this->tire->removeFromEbay();
        }
        $this->tire->reservations()->update(['status' => ReservationStatus::Concluded]);
        $this->tire->shipments()->update(['status' => ShipmentStatus::Concluded]);
        $this->tire->status = TireStatus::Sold;
        $this->tire->save();
    }

    public function addToScan()
    {
        StorageScanTire::create([
            'storage_scan_id' => $this->storageScan->id,
            'tire_id' => $this->tire->id,
            'ean' => '',
            'rack_identifier' => $this->tire->rack_identifier,
            'rack_position' => $this->tire->rack_position,
        ]);

        $this->tire = null;
    }
}
