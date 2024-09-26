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
        Schema::table('pms_jobs', function (Blueprint $table) {
            $table->string('service')->after('type')->nullable();
            $table->string('addon_inventory')->after('type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pms_jobs', function (Blueprint $table) {
            $table->string('service')->after('type')->nullable();
            $table->string('addon_inventory')->after('type')->nullable();
        });
    }
};
