<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeContestantSexColToString extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table('contestants', function (Blueprint $table) {
		    $table->string('sex' )->nullable()->change();
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
		    $table->smallInteger('sex' )->nullable()->change();
	    });
    }
}
