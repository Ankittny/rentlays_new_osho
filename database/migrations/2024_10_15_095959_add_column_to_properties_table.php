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
        Schema::table('properties', function (Blueprint $table) {
            $table->string('property_square')->after('amenities')->nullable();
            $table->string('number_of_floor')->after('property_square')->nullable();
            $table->string('number_of_rooms')->after('number_of_floor')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('property_square');
            $table->dropColumn('number_of_floor');
            $table->dropColumn('number_of_rooms');
        });
    }
};
