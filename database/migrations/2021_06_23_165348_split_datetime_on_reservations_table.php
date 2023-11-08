<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SplitDatetimeOnReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('appointment');
            $table->date('appointment_date')->nullable()->after('source');
            $table->time('appointment_time')->nullable()->after('appointment_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('appointment_date');
            $table->dropColumn('appointment_time');
            $table->datetime('appointment')->nullable()->after('source');
        });
    }
}
