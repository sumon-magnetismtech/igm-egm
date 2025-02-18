<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDelayreasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delayreasons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('mloblinformation_id');
            $table->string('reason');
            $table->date('noted_date');
            $table->integer('noted_by');
            $table->timestamps();

            $table->foreign('mloblinformation_id')->references('id')->on('mloblinformations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delayreasons');
    }
}
