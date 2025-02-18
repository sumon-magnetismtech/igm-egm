<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoneyreceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moneyreceipts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('hblno');
            $table->string('client_name');
            $table->string('client_mobile');
            $table->string('accounts');
            $table->integer('quantity');
            $table->date('issue_date');
            $table->string('pay_mode');
            $table->string('pay_number')->nullable();
            $table->string('source_name')->nullable();
            $table->date('dated')->nullable();

            $table->text('mr_details')->nullable();

            //new column added for calculating free time.
            $table->integer('extension_no')->nullable();
            $table->date('from_date')->nullable();
            $table->date('upto_date')->nullable();
            $table->integer('duration')->nullable();
            $table->integer('free_time')->nullable();
            $table->integer('free_time_left')->nullable();
            $table->integer('chargeable_days')->nullable();
            $table->text('remarks')->nullable();

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
        Schema::dropIfExists('moneyreceipts');
    }
}
