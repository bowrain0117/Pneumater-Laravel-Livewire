<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTirePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tire_photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tire_id');
            $table->string('path');
            $table->timestamps();

            $table->foreign('tire_id')->references('id')->on('tires');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tire_photos');
    }
}
