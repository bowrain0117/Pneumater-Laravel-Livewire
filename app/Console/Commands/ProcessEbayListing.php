<?php

namespace App\Console\Commands;

use App\Enums\Shop;
use App\Enums\TireStatus;
use App\Http\Controllers\EbayController;
use App\Models\ShopListing;
use Illuminate\Console\Command;

class ProcessEbayListing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:ebay-listing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process Ebay Listing status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach (ShopListing::where('shop', Shop::Ebay)->get() as $listing) {
            if ($listing->tire->status == TireStatus::Available) {
                EbayController::checkItemSellingStatus($listing);
            } else {
                $listing->delete();
            }
        }
    }
}
