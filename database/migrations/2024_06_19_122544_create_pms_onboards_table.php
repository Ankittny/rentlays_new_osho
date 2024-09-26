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
        Schema::create('pms_onboards', function (Blueprint $table) {
            $table->id();
            $table->integer('property_id');
            $table->integer('assing_by_id');
            $table->integer('assing_to_id');
            $table->enum('subscription_type',['on-demand','requrring']);
            $table->text('remarks');
            $table->enum('status',['rentlays','PMS']);
            $table->enum('source',['onboard,verified','reject','onhold~']);
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
        Schema::dropIfExists('pms_onboards');
    }
};
