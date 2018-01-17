<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Run extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'contestant_id', 'heat_id', 'time', 'position', 'lane'
	];

	/**
	 * The validation for our items.
	 *
	 * @var arrayw
	 */
	protected $rules = array(
		'position' => 'required',
	);

	/**
	 * Our Relationships
	 */
	public function contestant() {
		return $this->belongsTo( 'App\Models\Contestant' );
	}
	public function heat() {
		return $this->belongsTo( 'App\Models\Heat' );
	}
	public function score() {
		return $this->hasOne( 'App\Models\ScoreForPosition', 'position', 'position' );
	}

	public function totalScore() {
		return $this->scoreForPosition()->sum('score' );
	}

	/**
	 * Our Scopes
	 */
	public function scopeComplete( $query ) {
		return $query->join('heats', 'runs.heat_id', '=', 'heats.id')->where( 'heats.status', 'complete' );
	}
	public function scopeUpcoming( $query ) {
		return $query->join('heats', 'runs.heat_id', '=', 'heats.id')->where( 'heats.status', 'upcoming' );
	}
}
