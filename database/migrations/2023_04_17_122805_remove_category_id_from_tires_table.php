<?php

use App\Models\Tire;
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
        foreach (Tire::get() as $tire) {
            $tire->category = $tire->category_id;
            $tire->save();
        }

        Schema::table('tires', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
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
            $table->unsignedBigInteger('category_id')->after('description');
            $table->foreign('category_id')->references('id')->on('categories');
        });

        foreach (Tire::get() as $tire) {
            $tire->category_id = $tire->category;
            $tire->save();
        }
    }
};
