<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('vesselName');
            $table->string('vesselCode');
            $table->date('exportDate');
            $table->string('voyageNo')->nullable();
            $table->string('rotationNo')->nullable();
            $table->date('sailingDate')->nullable();
            $table->date('etaDate')->nullable();
            $table->string('eStatus')->nullable();
            $table->string('commodity')->nullable();
            $table->string('destination')->nullable();
            $table->string('sealNo')->nullable();
            $table->string('transhipmentPort')->nullable();
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
        Schema::dropIfExists('exports');
    }
}
