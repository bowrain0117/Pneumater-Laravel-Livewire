<?php

namespace App\Http\Controllers;

use App\Enums\Shop;
use App\Models\ShopListing;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class KijijiController extends Controller
{
    public function index()
    {
        $user_id = request()->get('user_id', null);

        $ads = [];

        if (User::find($user_id)) {
            $listings = ShopListing::where('user_id', $user_id)->where('shop', Shop::Subito)->get();

            foreach ($listings as $listing) {
                $tire = $listing->tire;

                $ad = [];
                $ad['ID'] = $tire->id;
                $ad['PROGRAMMA'] = 'subito.it.bsell';
                $ad['CATEGORIA'] = 5;

                $ad['QUANTITÀ'] = $tire->amount;
                $ad['PREZZO'] = $tire->getKijijiPrice();
                $ad['TITOLO'] = substr($tire->getKijijiTitle(), 0, 50);
                $ad['TESTO'] = str_replace('<br />', "\n", $tire->getUniversalDescription());

                $index = 1;
                foreach ($tire->photos as $photo) {
                    $ad['FOTO'.$index] = config('app.url').Storage::url($photo->path);
                    $index++;
                }
                $ads[] = $ad;
            }
        }

        return $ads;
    }
}
