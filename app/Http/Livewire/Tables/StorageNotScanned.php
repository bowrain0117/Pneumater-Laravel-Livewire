<?php

namespace App\Http\Livewire\Tables;

use App\Enums\TireCategory;
use App\Enums\TireStatus;
use App\Models\StorageScan;
use App\Models\StorageScanTire;
use App\Models\Tire;
use Livewire\Component;

class StorageNotScanned extends Component
{
    public StorageScan $storageScan;

    public $scanned_tires_id;

    public function mount(StorageScan $storageScan)
    {
        $this->storageScan = $storageScan;
        $this->scanned_tires_id = StorageScanTire::where('storage_scan_id', $storageScan->id)->select('tire_id')->get()->toArray();
    }

    public function render()
    {
        return view('livewire.tables.storage-not-scanned', [
            'notScannedTires' => Tire::whereNotIn('id', $this->scanned_tires_id)
                ->where('status', '!=', TireStatus::Sold)
                ->where('category', '!=', TireCategory::NEW)
                ->where('category', '!=', TireCategory::NEW_EXTRA)
                ->get(),
        ]);
    }
}
