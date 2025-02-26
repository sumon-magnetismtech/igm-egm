<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEgmMloBlcontainersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('egm_mlo_blcontainers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('mloblinformation_id');
            $table->string('contref');
            $table->string('type');
            $table->string('status');
            $table->string('sealno');
            $table->integer('pkgno');
            $table->float('grosswt');
            $table->float('verified_gross_mass');
            $table->float('imco')->nullable();
            $table->float('un')->nullable();
            $table->string('location')->nullable();
            $table->integer('commodity');
            $table->string('containerStatus');
            $table->tinyInteger('payment')->default(false);
            $table->timestamps();
            $table->foreign('mloblinformation_id')->references('id')->on('egm_mloblinformations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('egm_mlo_blcontainers');
    }
}
