<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEgmMoneyreceiptDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('egm_moneyreceipt_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('moneyreceipt_id');
            $table->string('particular');
            $table->float('amount', 10, 2);
            $table->timestamps();
            $table->foreign('moneyreceipt_id')->references('id')->on('moneyreceipts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('egm_moneyreceipt_details');
    }
}
