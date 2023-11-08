<?php

namespace App\Http\Controllers;

use App\Models\Tire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TireMergeController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Tire $tire)
    {
        return view('tires.merge.create', ['tire' => $tire]);
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'tire_id' => 'required|exists:App\Models\Tire,id',
            'tire_to_merge' => 'required|array',
        ]);

        $tire = Tire::findOrFail($request->tire_id);
        $tiresToMerge = Tire::whereIn('id', $request->tire_to_merge)->get();

        foreach ($tiresToMerge as $tireToMerge) {
            $tireToMerge->removeFromEbay();
            $tire->amount += $tireToMerge->amount;

            foreach ($tireToMerge->photos as $photo) {
                Storage::delete($photo->path);
                $photo->delete();
            }

            $tire->unified = true;
            $tire->unification_note .= ($tire->unification_note != '' ? ' / ' : '').'Unito con id '.$tireToMerge->id.' - '.$tireToMerge->rack_identifier.$tireToMerge->rack_position;

            $tireToMerge->delete();
        }

        foreach ($tire->photos as $photo) {
            Storage::delete($photo->path);
            $photo->delete();
        }

        $tire->millimeters = 0;
        $tire->millimeters_2 = 0;

        $tire->price = 0;
        $tire->price_list = 0;
        $tire->price_ebay = 0;
        $this->price_discount = 0;
        $this->discount_at = null;
        $this->number_of_discount = 0;

        $tire->save();

        return redirect()->route('tires.indexAvailable');
    }
}
