<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCofficecodeToHousebls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('housebls', function (Blueprint $table) {
            $table->integer('cofficecode')->after('arrival')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('housebls', function (Blueprint $table) {
            $table->dropColumn('cofficecode');
        });
    }
}
