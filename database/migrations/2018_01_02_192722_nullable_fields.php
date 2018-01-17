<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NullableFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table('contestants', function (Blueprint $table) {
		    $table->unsignedInteger('group_id')->nullable()->change();
		    $table->unsignedInteger('den_id')->nullable()->change();
		    $table->string('name', 255)->nullable()->change();
		    $table->string('email', 255)->nullable()->change();
		    $table->smallInteger('age' )->nullable()->change();
		    $table->smallInteger('sex' )->nullable()->change();
		    $table->string('car_name', 255)->nullable()->change();
		    $table->smallInteger('car_number' )->nullable();
		    $table->string('car_picture', 255)->nullable()->change();
		    $table->boolean('car_passed_inspection' )->default(false)->change();
		    $table->string('picture', 255)->nullable()->change();
		    $table->boolean('retired')->default(false)->change();
		    $table->boolean('present' )->default(false)->change();
		    $table->boolean('exclude' )->default(false)->change();
	    });
	    Schema::table('heats', function (Blueprint $table) {
		    $table->unsignedInteger('sequence')->nullable()->change();
		    $table->string('status', 255)->nullable()->change();
	    });

	    Schema::table('groups', function (Blueprint $table) {
		    $table->string('name', 255)->nullable()->change();
		    $table->string('picture', 255)->nullable()->change();
	    });
	    Schema::table('dens', function (Blueprint $table) {
		    $table->string('name', 255)->nullable()->change();
		    $table->string('pack_name', 255)->nullable()->change();
		    $table->text('leaders')->nullable()->change();
		    $table->string('picture', 255)->nullable()->change();
		    $table->dropColumn('car_number');
	    });
	    Schema::table('score_for_positions', function (Blueprint $table) {
		    $table->unsignedSmallInteger('position' )->nullable()->change();
		    $table->unsignedSmallInteger('score')->nullable()->change();
	    });
	    Schema::table('runs', function (Blueprint $table) {
		    $table->unsignedInteger('contestant_id')->nullable()->change();
		    $table->unsignedInteger('heat_id')->nullable()->change();
		    $table->string('time', 255)->nullable()->change();
		    $table->unsignedSmallInteger('position' )->nullable()->change();
		    $table->unsignedSmallInteger('lane')->nullable()->change();
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
		    $table->unsignedInteger('group_id')->nullable(false)->change();
		    $table->unsignedInteger('den_id')->nullable(false)->change();
		    $table->string('name', 255)->nullable(false)->change();
		    $table->string('email', 255)->nullable(false)->change();
		    $table->smallInteger('age' )->nullable(false)->change();
		    $table->smallInteger('sex' )->nullable(false)->change();
		    $table->string('car_name', 255)->nullable(false)->change();
		    $table->string('car_picture', 255)->nullable(false)->change();
		    $table->boolean('car_passed_inspection' )->default(false)->change();
		    $table->string('picture', 255)->nullable(false)->change();
		    $table->boolean('retired')->default(false)->change();
		    $table->boolean('present' )->default(false)->change();
		    $table->boolean('exclude' )->default(false)->change();
		    $table->dropColumn('car_number');
	    });
	    Schema::table('contestants', function (Blueprint $table) {
		    $table->dropColumn('car_number');
	    });
	    Schema::table('heats', function (Blueprint $table) {
		    $table->unsignedInteger('sequence')->nullable(false)->change();
		    $table->string('status', 255)->nullable(false)->change();
	    });

	    Schema::table('groups', function (Blueprint $table) {
		    $table->string('name', 255)->nullable(false)->change();
		    $table->string('picture', 255)->nullable(false)->change();
	    });
	    Schema::table('dens', function (Blueprint $table) {
		    $table->string('name', 255)->nullable(false)->change();
		    $table->string('pack_name', 255)->nullable(false)->change();
		    $table->text('leaders')->nullable(false)->change();
		    $table->string('picture', 255)->nullable(false)->change();
	    });
	    Schema::table('score_for_positions', function (Blueprint $table) {
		    $table->unsignedSmallInteger('position' )->nullable(false)->change();
		    $table->unsignedSmallInteger('score')->nullable(false)->change();
	    });
	    Schema::table('runs', function (Blueprint $table) {
		    $table->unsignedInteger('contestant_id')->nullable(false)->change();
		    $table->unsignedInteger('heat_id')->nullable(false)->change();
		    $table->string('time', 255)->nullable(false)->change();
		    $table->unsignedSmallInteger('position' )->nullable(false)->change();
		    $table->unsignedSmallInteger('lane')->nullable(false)->change();
	    });
    }
}
