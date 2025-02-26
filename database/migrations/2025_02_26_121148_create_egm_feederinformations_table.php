<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEgmFeederinformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('egm_feederinformations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('feederVessel');
            $table->string('voyageNumber');
            $table->integer('COCode');
            $table->string('COName');
            $table->date('departureDate');
            $table->date('arrivalDate')->nullable();
            $table->date('berthingDate')->nullable();
            $table->string('rotationNo')->nullable();
            $table->string('careerName');
            $table->string('careerAddress');
            $table->string('depPortCode')->nullable();
            $table->string('depPortName')->nullable();
            $table->string('desPortCode')->nullable();
            $table->string('desPortName')->nullable();
            $table->integer('mtCode');
            $table->string('mtType');
            $table->string('transportNationality');
            $table->string('depot');
            $table->integer('user_id');
            $table->string('deleted_at')->nullable();
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
        Schema::dropIfExists('egm_feederinformations');
    }
}
