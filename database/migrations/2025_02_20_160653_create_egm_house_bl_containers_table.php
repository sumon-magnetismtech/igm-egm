<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEgmHouseBlContainersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('egm_house_bl_containers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('housebl_id')->unsigned();
            $table->string('contref');
            $table->string('type');
            $table->string('status');
            $table->string('sealno');
            $table->integer('pkgno');
            $table->float('grosswt');
            $table->float('imco')->nullable();
            $table->float('un')->nullable();
            $table->string('location')->nullable();
            $table->integer('commodity');
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
        Schema::dropIfExists('egm_house_bl_containers');
    }
}
