<?php

namespace App\Http\Livewire\Shipment;

use App\Models\Shipment;
use Livewire\Component;
use Livewire\WithFileUploads;

class ImportEasyfatt extends Component
{
    use WithFileUploads;

    public $easyfatt_file;

    public function render()
    {
        return view('livewire.shipment.import-easyfatt');
    }

    public function processFile()
    {
        $xml = simplexml_load_string(file_get_contents($this->easyfatt_file->getRealPath()));
        foreach ($xml->Documents->Document as $document) {
            if ($document->DocumentType == 'D') {
                $ddt_number = $document->Number;
                $shipment_number = $document->CustomField4;

                if (str_contains($shipment_number, '#')) {
                    $shipment_number = explode('#', $shipment_number)[1];
                    $shipment = Shipment::find($shipment_number);
                    if ($shipment) {
                        $shipment->ddt_number = $ddt_number;
                        $shipment->ddt_date = $document->Date;
                        $shipment->save();
                    }
                }
            }
        }

        return redirect()->route('shipments.index');
    }
}
