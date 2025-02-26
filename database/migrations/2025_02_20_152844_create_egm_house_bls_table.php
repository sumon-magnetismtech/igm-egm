<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEgmHouseBlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('egm_house_bls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('consolidated')->nullable();
            $table->string('dg')->nullable();
            $table->string('qccontainer')->nullable();
            $table->integer('igm');
            $table->integer('line');
            $table->string('bolreference');
            $table->string('exportername');
            $table->string('exporteraddress');
            $table->string('consigneebin');
            $table->string('consigneename');
            $table->string('consigneeaddress');
            $table->string('notifybin');
            $table->string('notifyname');
            $table->string('notifyaddress');
            $table->text('shippingmark');
            $table->integer('packageno');
            $table->string('packagecode');
            $table->string('packagetype');
            $table->text('description');
            $table->float('grosswt');
            $table->float('measurement');
            $table->integer('containernumber');
            $table->string('remarks')->nullable();
            $table->string('freightstatus')->nullable();
            $table->string('freightvalue')->nullable();
            $table->string('coloader')->nullable();
            $table->string('note')->nullable();
            $table->string('blNote')->nullable();
            $table->string('moneyreceiptStatus')->default(0);            
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
        Schema::dropIfExists('egm_house_bls');
    }
}
