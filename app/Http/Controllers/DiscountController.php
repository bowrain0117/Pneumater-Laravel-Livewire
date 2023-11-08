<?php

namespace App\Http\Controllers;

use App\Models\Tire;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiscountController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create(Request $request)
    {
        if (isset($request->tires)) {
            $tires = Tire::findMany($request->tires);

            return view('tires.discount', ['tires' => $tires]);
        } else {
            return back();
        }
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $tires = Tire::findMany($request->tires);

        if (isset($request->tires)) {
            if (isset($request->percentage)) {
                $percentage = $request->percentage / 100;

                foreach ($tires as $tire) {
                    $tire->price_discount = $tire->price_full * $percentage;
                    $tire->save();
                }
            } elseif (isset($request->discount)) {
                foreach ($tires as $tire) {
                    if ($tire->price_discount) {
                        $tire->price_discount += $request->discount;
                    } else {
                        $tire->price_discount = $request->discount;
                    }
                    $tire->save();
                }
            }

            Tire::whereIn('id', $request->tires)->update([
                'number_of_discount' => DB::raw('number_of_discount + 1'),
                'discount_at' => Carbon::now(),
            ]);

            foreach ($tires as $tire) {
                $tire->recalculatePrices();
                if ($tire->ebay_selling_id) {
                    $tire->removeFromEbay();
                    $tire->sellOnEbay();
                }
                $tire->save();
            }
        }

        return redirect()->route('tires.index');
    }
}
