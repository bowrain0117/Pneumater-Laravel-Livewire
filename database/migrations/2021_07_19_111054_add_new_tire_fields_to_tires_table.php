<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewTireFieldsToTiresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tires', function (Blueprint $table) {
            $table->string('ean', 20)->after('id')->nullable();
            $table->double('pfu_contribution')->after('rack_position')->nullable();
            $table->double('discount_immediate_payment')->after('pfu_contribution')->nullable();
            $table->double('discount_supplier')->after('discount_immediate_payment')->nullable();
            $table->double('price_list')->after('price')->nullable();

            $table->string('rack_identifier', 4)->nullable()->change();
            $table->integer('rack_position')->nullable()->change();

            // dropping legacy field
            $table->dropColumn('price_new');
            $table->dropColumn('price_new_with_iva');
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
            $table->dropColumn('ean');
            $table->dropColumn('pfu_contribution');
            $table->dropColumn('discount_immediate_payment');
            $table->dropColumn('discount_supplier');
            $table->dropColumn('price_list');

            $table->string('rack_identifier', 4)->change();
            $table->integer('rack_position')->change();

            $table->double('price_new')->after('rack_position');
            $table->double('price_new_with_iva')->after('price_new');
        });
    }
}
