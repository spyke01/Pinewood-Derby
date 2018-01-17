<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsForContestants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table('contestants', function (Blueprint $table) {
		    $table->unsignedInteger('group_id');
		    $table->unsignedInteger('den_id');
		    $table->string('car_name', 255);
		    $table->smallInteger('car_number' );
		    $table->string('car_picture', 255);
		    $table->boolean('car_passed_inspection' );
		    $table->string('email', 255);
		    $table->smallInteger('age' );
		    $table->smallInteger('sex' );
		    $table->string('picture', 255);
		    $table->boolean('present' );
		    $table->boolean('exclude' );
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
		    $table->dropColumn('group_id');
		    $table->dropColumn('den_id');
		    $table->dropColumn('car_name');
		    $table->dropColumn('car_number');
		    $table->dropColumn('car_picture');
		    $table->dropColumn('car_passed_inspection');
		    $table->dropColumn('email');
		    $table->dropColumn('age');
		    $table->dropColumn('sex');
		    $table->dropColumn('picture');
		    $table->dropColumn('present');
		    $table->dropColumn('exclude');
	    });
    }
}
