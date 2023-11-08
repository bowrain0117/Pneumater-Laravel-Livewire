<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStorageScanTiresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storage_scan_tires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('storage_scan_id')->constrained();
            $table->integer('tire_id')->nullable();
            $table->string('ean', 20)->nullable();
            $table->string('rack_identifier', 4);
            $table->integer('rack_position');
            $table->boolean('ignore_status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('storage_scan_tires');
    }
}
