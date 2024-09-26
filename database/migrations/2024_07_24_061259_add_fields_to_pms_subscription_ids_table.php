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
        Schema::table('pms_subscription_ids', function (Blueprint $table) {
            $table->string('start_date_time')->nullable();
            $table->integer('end_date_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pms_subscription_ids', function (Blueprint $table) {
            $table->dropColumn(['start_date_time', 'end_date_time']);
        });
    }
};
