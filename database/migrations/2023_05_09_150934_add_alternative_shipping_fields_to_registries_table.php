<?php

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
        Schema::table('registries', function (Blueprint $table) {
            $table->boolean('is_shipment_on_different_location')->after('nation')->default(false);
            $table->string('denomination_shipment')->after('is_shipment_on_different_location')->nullable();
            $table->string('address_shipment')->after('denomination_shipment')->nullable();
            $table->string('city_shipment')->after('address_shipment')->nullable();
            $table->string('postal_code_shipment')->after('city_shipment')->nullable();
            $table->string('province_shipment')->after('postal_code_shipment')->nullable();
            $table->string('region_shipment')->after('province_shipment')->nullable();
            $table->string('nation_shipment')->after('region_shipment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('registries', function (Blueprint $table) {
            $table->dropColumn('denomination_shipment');
            $table->dropColumn('address_shipment');
            $table->dropColumn('city_shipment');
            $table->dropColumn('postal_code_shipment');
            $table->dropColumn('province_shipment');
            $table->dropColumn('region_shipment');
            $table->dropColumn('nation_shipment');
        });
    }
};
