<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftDeleteUserIdToFeederinformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('feederinformations', function (Blueprint $table) {
            $table->timestamp('deleted_at')->nullable();
            $table->integer('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('feederinformations', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
            $table->dropColumn('user_id');
        });
    }
}
