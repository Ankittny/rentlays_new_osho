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
        Schema::create('pms_helpdesks', function (Blueprint $table) {
            $table->id();
            $table->integer('property_id');
            $table->string('issue');
            $table->text('description');
            $table->text('image');
            $table->enum('status',['Active','Completed','Ongoing'])->default('active');
            $table->enum('priority',['Low','Medium','High']);
            $table->integer('assign_to_supervisor')->unsigned()->nullable();
            $table->integer('assign_to_sitemanager')->unsigned()->nullable();
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
        Schema::dropIfExists('pms_helpdesks');
    }
};
