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
        Schema::create('pms_job_approval', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assign_to_id')->nullable();
            $table->unsignedBigInteger('job_id')->nullable();
            $table->unsignedBigInteger('supervisor_id')->nullable();
            $table->decimal('payable_amount', 10,2)->nullable();
            $table->dateTime('timedate')->nullable();
            $table->enum('status', ['pending', 'approved', 'completed'])->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
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
        Schema::dropIfExists('pms_job_approval');
    }
};
