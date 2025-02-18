<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExportContainersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('export_containers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('export_id');
            $table->unsignedBigInteger('blcontainer_id');
            $table->string('contRef');
            $table->timestamps();

            $table->foreign('export_id')->references('id')->on('exports')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('export_containers');
    }
}
