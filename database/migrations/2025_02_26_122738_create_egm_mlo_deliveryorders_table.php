<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEgmMloDeliveryordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('egm_mlo_deliveryorders', function (Blueprint $table) {
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
        Schema::dropIfExists('egm_mlo_deliveryorders');
    }
}
