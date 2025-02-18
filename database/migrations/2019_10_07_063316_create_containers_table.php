<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContainersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('containers', function (Blueprint $table) {
            $table->increments('id');
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
            $table->foreign('housebl_id')->references('id')->on('housebls')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('containers');
    }
}
