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
        Schema::table('pms_history', function (Blueprint $table) {
            $table->string('amenities_status')->after('amenities')->nullable();
            $table->string('repair_status')->after('amenities_status')->nullable();
            $table->string('estimated_cost')->after('repair_status')->nullable();
            $table->string('remarks')->after('estimated_cost')->nullable();
            $table->string('repairing')->after('remarks')->nullable();
            $table->string('working')->after('repairing')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pms_history', function (Blueprint $table) {
            $table->dropColumn('amenities_status');
            $table->dropColumn('repair_status');
            $table->dropColumn('estimated_cost');
            $table->dropColumn('remarks');
            $table->dropColumn('repairing');
            // $table->dropColumn('working');
        });
    }
};

