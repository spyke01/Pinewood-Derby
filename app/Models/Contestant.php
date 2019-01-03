<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contestant extends Model {
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'group_id',
		'den_id',
		'name',
		'email',
		'age',
		'sex',
		'picture',
		'car_name',
		'car_number',
		'car_picture',
		'car_passed_inspection',
		'present',
		'exclude',
		'retired',
	];

	/**
	 * The validation for our items.
	 *
	 * @var array
	 */
	protected $rules = array(
		'name' => 'required',
	);

	/**
	 * Our Relationships
	 */
	public function den() {
		return $this->belongsTo( 'App\Models\Den' );
	}

	public function group() {
		return $this->belongsTo( 'App\Models\Group' );
	}

	public function heats() {
		return $this->hasMany( 'App\Models\Heat' );
	}

	public function runs() {
		return $this->hasMany( 'App\Models\Run' );
	}

	/**
	 * Our Scopes
	 */
	public function scopeInspected( $query ) {
		return $query->where( 'car_passed_inspection', '=', 1 );
	}

	public function scopeByGroupAndDen( $query ) {
		return $query->leftJoin( 'groups', 'groups.id', '=', 'contestants.group_id' )
		             ->leftJoin( 'dens', 'dens.id', '=', 'contestants.den_id' )
		             ->orderBy( 'groups.name' )
		             ->orderBy( 'dens.name' )
		             ->orderBy( 'contestants.name' )
		             ->select(
			             'contestants.*',
			             'dens.name AS den_name',
			             'dens.picture AS den_picture',
			             'groups.name AS group_name',
			             'groups.picture AS group_picture'
		             );
	}
}
