<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveryorders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('moneyrecept_id');
            $table->string('BE_No');
            $table->date('BE_Date');
            $table->date('issue_date');
            $table->date('upto_date')->nullable();
            $table->string('bl_type')->nullable();
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
        Schema::dropIfExists('deliveryorders');
    }
}
