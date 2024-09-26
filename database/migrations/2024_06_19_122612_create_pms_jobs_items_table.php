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
        Schema::create('pms_jobs_items', function (Blueprint $table) {
            $table->id();
            $table->integer('pms_job_id');
            $table->integer('pms_inventory_product_id');
            $table->integer('price');
            $table->integer('payable_amount');
            $table->enum('status',['Approved','Rejected','Pending']);
            $table->integer('approved_by')->nullable();
            $table->timestamp('approved_at');
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
        Schema::dropIfExists('pms_jobs_items');
    }
};
