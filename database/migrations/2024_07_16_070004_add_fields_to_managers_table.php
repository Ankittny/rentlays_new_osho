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
        Schema::table('pms_appoint_managers', function (Blueprint $table) {
            $table->string('country')->nullable()->after('assign_to_id');
            $table->decimal('latitude', 10, 7)->nullable()->after('country');
            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            $table->string('map_address')->nullable()->after('longitude');
            $table->string('pin_code')->nullable()->after('map_address');
            $table->string('state')->nullable()->after('pin_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pms_appoint_managers', function (Blueprint $table) {
            $table->dropColumn('country');
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
            $table->dropColumn('map_address');
            $table->dropColumn('pin_code');
            $table->dropColumn('state');
        });
    }
};
