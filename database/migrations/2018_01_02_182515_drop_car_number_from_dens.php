<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropCarNumberFromDens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table('contestants', function (Blueprint $table) {
		    $table->dropColumn('car_number');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table('contestants', function (Blueprint $table) {
		    $table->smallInteger('car_number' );
	    });
    }
}
