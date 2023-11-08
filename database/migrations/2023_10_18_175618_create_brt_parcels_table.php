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
        Schema::create('brt_parcels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipment_id')->constrained();
            $table->string('lna')->nullable();
            $table->string('sender_reference_number');
            $table->string('parcel_number');
            $table->string('parcel_tracking_number');
            $table->string('label_path_pdf');
            $table->string('label_path_img');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brt_parcels');
    }
};
