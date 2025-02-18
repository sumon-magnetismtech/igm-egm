<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVatregsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vatregs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('BIN')->nullable();
            $table->string('NAME')->nullable();
            $table->string('EMAIL')->nullable();
            $table->string('ADD1')->nullable();
            $table->string('ADD2')->nullable();
            $table->string('ADD3')->nullable();
            $table->string('ADD4')->nullable();
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
        Schema::dropIfExists('vatregs');
    }
}
