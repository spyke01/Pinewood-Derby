<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'picture'
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
	public function contestants() {
		return $this->hasMany( 'App\Models\Contestant' );
	}
}
