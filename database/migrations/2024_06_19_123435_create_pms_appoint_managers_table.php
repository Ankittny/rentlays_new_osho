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
        Schema::create('pms_appoint_managers', function (Blueprint $table) {
            $table->id();
            $table->integer('assign_by_id');
            $table->text('department_ids');
            $table->string('service_provider');
            $table->string('city');
            $table->integer('assign_to_id');
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
        Schema::dropIfExists('pms_appoint_managers');
    }
};
