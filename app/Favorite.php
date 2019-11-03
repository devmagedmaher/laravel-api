<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
	/**
	 * Fillable properties to allow mass assignment
	 * 
	 * @var array
	 */
	protected $fillable = [

		'user_id', 'item_id', 

	];

	/**
	 * relationship to items
	 * 
	 * @return relationship
	 */
	public function item() 
	{
		return $this->belongsTo(Item::class);
	}
}
