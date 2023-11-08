<?php

namespace App\Http\Livewire\Tables;

use App\Models\StorageScan as StorageScanModel;
use Livewire\Component;
use Livewire\WithPagination;

class StorageScan extends Component
{
    use WithPagination;

    public StorageScanModel $storageScan;

    public $onlyError;

    public function mount(StorageScanModel $storageScan)
    {
        $this->storageScan = $storageScan;
        $this->onlyError = false;
    }

    public function render()
    {
        return view('livewire.tables.storage-scan', [
            'scanTires' => $this->onlyError ? $this->storageScan->scanTires()->paginate(10000) : $this->storageScan->scanTires()->paginate(30),
        ]);
    }
}
