<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryDetails extends Model
{
	use SoftDeletes;

	/**
	 * Fillable properties to allow mass assignment
	 * 
	 * @var Array
	 */
	protected $fillable = [

		'name', 'description', 'category_id', 'language_id' 

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

	/**
	 * get language code
	 * 
	 * @return string
	 */
	public function getLanguageCodeAttribute() 
	{
		return $this->language->code;
	}
}
