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
        Schema::table('pms_helpdesks', function (Blueprint $table) {
           $table->integer('helpdesk_user_id')->after('property_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pms_helpdesks', function (Blueprint $table) {
            $table->dropColumn('helpdesk_user_id');
        });
    }
};
