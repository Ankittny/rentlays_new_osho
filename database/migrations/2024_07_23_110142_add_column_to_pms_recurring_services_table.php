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
        Schema::table('pms_recurring_services', function (Blueprint $table) {
            $table->integer('duration_time')->after('duration_type')->nullable()->comment('Duration time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pms_recurring_services', function (Blueprint $table) {
            $table->dropColumn('duration_time');
        });
    }
};