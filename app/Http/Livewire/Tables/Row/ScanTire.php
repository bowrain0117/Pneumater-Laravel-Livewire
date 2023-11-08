<?php

namespace App\Http\Livewire\Tables\Row;

use App\Enums\TireStatus;
use App\Models\StorageScanTire;
use Livewire\Component;

class ScanTire extends Component
{
    public StorageScanTire $scanTire;

    public function mount(StorageScanTire $scanTire)
    {
        $this->scanTire = $scanTire;
    }

    public function render()
    {
        return view('livewire.tables..row.scan-tire');
    }

    public function updatePosition()
    {
        if ($this->scanTire->tire) {
            $this->scanTire->tire->rack_identifier = $this->scanTire->rack_identifier;
            $this->scanTire->tire->rack_position = $this->scanTire->rack_position;
            $this->scanTire->tire->save();
        }
    }

    public function updateScanPosition()
    {
        if ($this->scanTire->tire) {
            $this->scanTire->rack_identifier = $this->scanTire->tire->rack_identifier;
            $this->scanTire->rack_position = $this->scanTire->tire->rack_position;
            $this->scanTire->save();
        }
    }

    public function moveToSold()
    {
        if ($this->scanTire->tire) {
            if ($this->scanTire->tire->ebay_selling_id) {
                $this->scanTire->tire->removeFromEbay();
            }
            $this->scanTire->tire->status = TireStatus::Sold;
            $this->scanTire->tire->save();
        }
    }

    public function moveToAvailable()
    {
        if ($this->scanTire->tire) {
            $this->scanTire->tire->status = TireStatus::Available;
            $this->scanTire->tire->save();
        }
    }

    public function disableStatusError()
    {
        $this->scanTire->ignore_status = true;
        $this->scanTire->save();
    }
}
