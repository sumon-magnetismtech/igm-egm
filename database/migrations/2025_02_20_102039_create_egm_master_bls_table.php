<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEgmMasterBlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('egm_master_bls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('noc')->default(0);
            $table->integer('cofficecode');
            $table->string('cofficename');
            $table->string('mblno');
            $table->integer('blnaturecode');
            $table->string('blnaturetype');
            $table->string('bltypecode');
            $table->string('bltypename');
            $table->string('fvessel');
            $table->string('voyage');
            $table->string('rotno')->nullable();
            $table->string('principal');
            $table->date('departure');
            $table->date('arrival');
            $table->date('berthing')->nullable();
            $table->integer('freetime')->nullable();
            $table->string('pocode');
            $table->string('poname');
            $table->string('pucode');
            $table->string('puname');
            $table->string('carrier');
            $table->string('carrieraddress');
            $table->string('depot')->nullable();
            $table->string('mv')->nullable();
            $table->string('mlocode')->nullable();
            $table->string('mloname')->nullable();
            $table->string('mloaddress')->nullable();

            $table->string('mloLineNo')->nullable();
            $table->text('mloCommodity')->nullable();
            $table->string('contMode')->nullable();
            $table->string('jetty')->nullable();
            $table->text('remarks')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('egm_master_bls');
    }
}
