<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKijijiSubitoFlagToTiresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tires', function (Blueprint $table) {
            $table->boolean('is_for_sale_on_kijiji')->default(0)->after('ebay_selling_id');
            $table->boolean('is_for_sale_on_subito')->default(0)->after('is_for_sale_on_kijiji');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tires', function (Blueprint $table) {
            $table->dropColumn('is_for_sale_on_kijiji');
            $table->dropColumn('is_for_sale_on_subito');
        });
    }
}
