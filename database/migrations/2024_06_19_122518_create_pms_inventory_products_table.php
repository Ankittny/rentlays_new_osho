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
        Schema::create('pms_inventory_products', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('brand_id');
            $table->integer('category_id');
            $table->integer('sub_category_id');
            $table->text('image');  
            $table->text('description');
            $table->integer('price');
            $table->integer('sellprice');
            $table->string('sku');
            $table->enum('status',[0,1]);
            $table->integer('qty');

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
        Schema::dropIfExists('pms_inventory_products');
    }
};
