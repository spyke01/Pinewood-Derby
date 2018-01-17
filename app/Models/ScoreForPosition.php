<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScoreForPosition extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'position', 'score'
	];

	/**
	 * The validation for our items.
	 *
	 * @var array
	 */
	protected $rules = array(
		'score' => 'required',
	);
}
