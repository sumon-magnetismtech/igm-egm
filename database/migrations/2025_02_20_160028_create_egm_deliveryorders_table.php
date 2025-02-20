<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEgmDeliveryordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('egm_deliveryorders', function (Blueprint $table) {
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
        Schema::dropIfExists('egm_deliveryorders');
    }
}
