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
            $table->integer('role')->after('type')->default(\App\Enums\RegistryRoleType::CUSTOMER);
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
            $table->dropColumn('role');
        });
    }
};
