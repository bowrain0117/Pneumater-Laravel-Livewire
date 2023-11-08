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
     */
    public function up(): void
    {
        $user = User::first();

        $tires = Tire::where('is_for_sale_on_kijiji', 1)->get();
        foreach ($tires as $tire) {
            $tire->listings()->create([
                'listing_id' => 1,
                'user_id' => $user->id,
                'shop' => \App\Enums\Shop::Subito,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('store_listing', function (Blueprint $table) {
            //
        });
    }
};
