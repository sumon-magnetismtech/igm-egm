<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmptyContainersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empty_containers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('blcontainer_id')->nullable();
            $table->string('contref')->nullable();
            $table->string('bolreference')->nullable();

            $table->string('movementType')->nullable();

            $table->date('date')->nullable();
            $table->string('location')->nullable();
            $table->string('depoName')->nullable();
            $table->tinyInteger('chassisDelivery')->default(false);
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
        Schema::dropIfExists('empty_containers');
    }
}
