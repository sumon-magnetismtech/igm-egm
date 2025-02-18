<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForwardingRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forwarding_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type'); //[frd, extension, e-frd]
            $table->string('mblno')->nullable();
            $table->string('bolreference')->nullable();
            $table->string('client')->nullable();
            $table->string('deliveryLocation')->nullable();
            $table->string('freeTime')->nullable();
            $table->string('mloLineNo')->nullable();
            $table->text('mloCommodity')->nullable();
            $table->string('contMode')->nullable();
            $table->string('to')->nullable();
            $table->string('cc')->nullable();
            $table->string('date')->nullable();
            $table->string('contref')->nullable();
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('forwarding_records');
    }
}
