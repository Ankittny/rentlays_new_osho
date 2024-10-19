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
        Schema::create('pms_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('property_id');
            $table->integer('helpdesk_user_id');
            $table->integer('assign_to_supervisor');
            $table->integer('assign_to_sitemanager');
            $table->string('name', 100);
            $table->string('slug', 100);
            $table->string('url_name', 100)->nullable();
            $table->tinyInteger('bedrooms')->nullable();
            $table->tinyInteger('beds')->nullable();
            $table->integer('bed_type')->unsigned()->nullable();
            $table->float('bathrooms')->nullable();
            $table->string('amenities')->nullable();
            $table->string('property_square')->nullable();
            $table->string('number_of_floor')->nullable();
            $table->string('number_of_rooms')->nullable();
            $table->integer('property_type')->default(0);
            $table->integer('space_type')->default(0);
            $table->tinyInteger('accommodates')->nullable();
            $table->enum('booking_type',['instant', 'request'])->default('request');
            $table->string('cancellation', 50)->default('Flexible');
            $table->enum('status',['Unlisted', 'Listed'])->default('Unlisted');
            $table->tinyInteger('recomended')->nullable();
            $table->string('is_verified')->nullable();
            $table->string('for_property')->nullable();
            $table->string('floor')->nullable();
            $table->string('super_area')->nullable();
            $table->string('property_age')->nullable();
            $table->string('is_verified_pms')->nullable();
            $table->string('date_times')->nullable();
            $table->softDeletes();      
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        schema::dropIfExists('pms_history');
    }
};
