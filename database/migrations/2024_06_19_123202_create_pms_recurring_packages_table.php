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
        Schema::create('pms_recurring_packages', function (Blueprint $table) {
            $table->id();
            $table->string('package_name');
            $table->text('pms_recurring_service_ids');
            $table->integer('price');
            $table->integer('offer_price');
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
        Schema::dropIfExists('pms_recurring_packages');
    }
};
