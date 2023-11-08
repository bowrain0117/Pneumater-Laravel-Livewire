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
            $table->foreignId('ebay_listing_user_id')->after('ebay_listing_id')->nullable()->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipment_tire', function (Blueprint $table) {
            $table->dropForeign(['ebay_listing_user_id']);
            $table->dropColumn('ebay_listing_user_id');
        });
    }
};
