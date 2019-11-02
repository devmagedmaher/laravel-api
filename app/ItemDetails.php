<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemDetails extends Model
{

	use SoftDeletes;

	/**
	 * Fillable properties to allow mass assignment
	 * 
	 * @var array
	 */
	protected $fillable = [

		'name', 'description', 'language_id', 'item_id', 

	];

	/**
	 * relationship with language
	 * 
	 * @return
	 */
	public function language() 
	{
		return $this->belongsTo(\App\Language::class);
	}
}
