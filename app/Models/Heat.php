<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Heat extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'sequence', 'group_id', 'status'
	];

	/**
	 * The validation for our items.
	 *
	 * @var array
	 */
	protected $rules = array(
		//'sequence' => 'required',
	);

	/**
	 * Our Relationships
	 */
	public function runs() {
		return $this->hasMany( 'App\Models\Run' );
	}
	public function group() {
		return $this->belongsTo( 'App\Models\Group' );
	}

	/**
	 * Our Scopes
	 */
	public function scopeCurrent( $query ) {
		return $query->where( 'status', 'current' );
	}
	public function scopeComplete( $query ) {
		return $query->where( 'status', 'complete' )->orderBy('sequence', 'DESC')->orderBy('created_at', 'DESC');
	}
	public function scopeMostRecent( $query ) {
		// TODO: Fix this, it does not properly order or limit when run by a controller
		return $query->where( 'status', 'complete' )->orderBy('sequence', 'DESC')->orderBy('created_at', 'DESC')->first();
	}
	public function scopeUpcoming( $query ) {
		return $query->where( 'status', 'upcoming' )->orderBy('sequence')->orderBy('created_at');
	}
	public function scopeUpcomingIncomplete( $query ) {
		return $query->where( 'status', 'upcoming' )->join('runs', 'runs.heat_id', '=', 'heats.id')->groupBy('heats.id')->havingRaw('count(runs.id) < ' . env('LANES_ON_TRACK' ) );
	}
}
