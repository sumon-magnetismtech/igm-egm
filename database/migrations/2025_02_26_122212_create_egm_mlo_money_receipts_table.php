<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEgmMloMoneyReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('egm_mlo_money_receipts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('bolRef')->nullable(); //bolRef is the foreign key of mloblinformations table
            $table->integer('extensionNo')->nullable();
            $table->date('fromDate')->nullable();
            $table->date('uptoDate')->nullable();
            $table->integer('duration')->nullable();
            $table->integer('freeTime')->nullable();
            $table->integer('freeTimeLeft')->nullable();
            $table->integer('chargeableDays')->nullable();
            $table->integer('client_id')->nullable();
            $table->string('payMode')->nullable();
            $table->string('payNumber')->nullable();
            $table->date('issueDate')->nullable();
            $table->string('remarks')->nullable();
            $table->text('moneyReceiptDetails')->nullable();
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
        Schema::dropIfExists('egm_mlo_money_receipts');
    }
}
