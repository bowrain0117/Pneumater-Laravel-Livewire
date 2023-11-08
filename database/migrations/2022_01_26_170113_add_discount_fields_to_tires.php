<?php

use App\Models\Tire;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiscountFieldsToTires extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tires', function (Blueprint $table) {
            $table->double('price_discount')->after('price')->nullable();
            $table->dateTime('discount_at')->after('created_at')->nullable();
            $table->integer('number_of_discount')->after('price_discount')->default(0);
        });

        $tires_to_migrate = Tire::where('price_not_discounted', '>', 0)->get();
        foreach ($tires_to_migrate as $tire) {
            $tire->price_discount = $tire->price_not_discounted - $tire->price;
            $tire->price = $tire->price_not_discounted;
            $tire->save();
        }

        Schema::table('tires', function (Blueprint $table) {
            $table->dropColumn('price_not_discounted');
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
            $table->double('price_not_discounted')->after('price')->default(-1);
            $table->dropColumn('price_discount');
            $table->dropColumn('discount_at');
            $table->dropColumn('number_of_discount');
        });
    }
}
