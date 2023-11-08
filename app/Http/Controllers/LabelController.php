<?php

namespace App\Http\Controllers;

use App\Enums\TireStatus;
use App\Models\Tire;
use Illuminate\Http\Request;
use PDF;

class LabelController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('verified');
    }

    /**
     * Generate label of tires in zebra format
     *
     * @return mixed
     */
    public function generateTireLabel(Request $request)
    {
        $tires = Tire::findMany($request->tires);
        if ($tires->count() == 0) {
            $tires = Tire::where('status', TireStatus::Available)->get();
        }

        $pdf = PDF::loadView('pdf.labels', ['tires' => $tires]);
        $pdf->setPaper([0, 0, 283.465, 283.465], 'portrait');

        return $pdf->stream();
    }
}
