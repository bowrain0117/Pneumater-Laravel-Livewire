<?php

use App\Models\Tire;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $user = User::first();

        $tires = Tire::whereNotNull('ebay_selling_id')->get();
        foreach ($tires as $tire) {
            $tire->listings()->create([
                'listing_id' => $tire->ebay_selling_id,
                'user_id' => $user->id,
                'shop' => \App\Enums\Shop::Ebay,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('store_listing', function (Blueprint $table) {
            //
        });
    }
};
