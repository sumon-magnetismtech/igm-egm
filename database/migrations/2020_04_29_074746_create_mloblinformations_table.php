<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMloblinformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mloblinformations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('feederinformations_id');
            $table->tinyInteger('consolidated')->default(0);
            $table->tinyInteger('dg')->default(0);
            $table->tinyInteger('qccontainer')->default(0);
            $table->integer('line');
            $table->integer('principal_id');
            $table->string('bolreference');
            $table->string('pOrigin');
            $table->string('pOriginName');
            $table->string('PUloding');
            $table->string('unloadingName');
            $table->string('exportername');
            $table->string('exporteraddress');
            $table->string('consignee_id');
            $table->string('notify_id');
            $table->string('mlocode');
            $table->string('mloname');
            $table->string('mloaddress')->nullable();
            $table->integer('blnaturecode');
            $table->string('blnaturetype');
            $table->string('bltypecode');
            $table->string('bltypename');
            $table->text('shippingmark');
            $table->integer('packageno');
            $table->integer('package_id');
            $table->text('description');
            $table->float('grosswt');
            $table->float('measurement');
            $table->integer('containernumber');
            $table->string('remarks')->nullable();
            $table->string('freightstatus')->nullable();
            $table->string('freightvalue')->nullable();
            $table->string('coloader')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('mloblinformations');
    }
}
