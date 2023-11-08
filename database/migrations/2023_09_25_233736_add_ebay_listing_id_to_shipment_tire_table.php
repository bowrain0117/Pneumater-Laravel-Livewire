<?php

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
        Schema::table('shipment_tire', function (Blueprint $table) {
            $table->string('ebay_listing_id')->after('price_override')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipment_tire', function (Blueprint $table) {
            $table->dropColumn('ebay_listing_id');
        });
    }
};
