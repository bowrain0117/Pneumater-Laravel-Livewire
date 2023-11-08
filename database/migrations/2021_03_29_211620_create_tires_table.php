<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTiresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tires', function (Blueprint $table) {
            $table->id();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->double('millimeters');
            $table->double('millimeters_2');
            $table->double('millimeters_new_by_manufacturer');
            $table->double('width');
            $table->integer('profile');
            $table->integer('diameter');
            $table->string('brand', 250);
            $table->string('model', 250);
            $table->unsignedBigInteger('type_id'); // Like 'Estiva', 'Invernale', ...
            $table->string('load_index', 20);
            $table->string('speed_index', 2);
            $table->boolean('is_commercial');
            $table->string('dot', 250);
            $table->integer('amount');
            $table->string('rack_identifier', 4);
            $table->integer('rack_position');
            $table->double('price_new');
            $table->double('price_new_with_iva');
            $table->double('price');
            $table->double('price_not_discounted');
            $table->double('price_ebay');
            $table->integer('status');
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('type_id')->references('id')->on('types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tires');
    }
}
