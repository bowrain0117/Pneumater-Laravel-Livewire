<?php

namespace App\View\Components\Reservation;

use App\Models\Reservation;
use Illuminate\View\Component;

class ModalInfo extends Component
{
    public Reservation $reservation;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.reservation.modal-info');
    }
}
