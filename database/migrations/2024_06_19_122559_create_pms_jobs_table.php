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
        Schema::create('pms_jobs', function (Blueprint $table) {
            $table->id();
            $table->integer('property_id');
            $table->integer('helpdesk_id');
            $table->integer('user_id')->nullable();
            $table->text('upload_before_image')->nullable();
            $table->text('upload_after_image')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->integer('start_time_otp')->nullable();
            $table->integer('end_time_otp')->nullable();
            $table->integer('price')->default(0);
            $table->integer('price_amount')->default(0);
            $table->enum('status', ['Active','Completed','Ongoing'])->default('Active');
            $table->enum('type', ['recurring','onetime'])->default('onetime');
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
        Schema::dropIfExists('pms_jobs');
    }
};
