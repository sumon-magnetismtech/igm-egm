<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMloDeliveryordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mlo_deliveryorders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('mlo_money_receipt_id');
            $table->date('DO_Date');
            $table->string('BE_No');
            $table->date('BE_Date');
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
        Schema::dropIfExists('mlo_deliveryorders');
    }
}
