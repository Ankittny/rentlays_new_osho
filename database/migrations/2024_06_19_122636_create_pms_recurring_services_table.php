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
        Schema::create('pms_recurring_services', function (Blueprint $table) {
            $table->id();
            $table->integer('service_id');
            $table->enum('duration_type',[0,1]);
            $table->integer('price');
            $table->enum('status',[0,1]);

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
        Schema::dropIfExists('pms_recurring_services');
    }
};
