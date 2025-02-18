<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoneyReceiptContainersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('money_receipt_containers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('moneyReceipt_id');
            $table->unsignedBigInteger('blcontainer_id');
            $table->timestamps();
            $table->foreign('moneyReceipt_id')->references('id')->on('mlo_money_receipts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('money_receipt_containers');
    }
}
