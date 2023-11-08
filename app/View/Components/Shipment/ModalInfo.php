<?php

namespace App\View\Components\Shipment;

use App\Models\Shipment;
use Illuminate\View\Component;

class ModalInfo extends Component
{
    public Shipment $shipment;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Shipment $shipment)
    {
        $this->shipment = $shipment;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.shipment.modal-info');
    }
}
