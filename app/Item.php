<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
	
	use SoftDeletes;

	/**
	 * Fillable properties to allow mass assignment
	 * 
	 * @var array
	 */
	protected $fillable = [

		'price', 'category_id', 

	];

	/**
	 * Relationship to item_details table
	 * 
	 * @return Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function details() {

		return $this->hasMany(ItemDetails::class);
	}

	/**
	 * Relationship to item_images table
	 * 
	 * @return Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function images() {

		return $this->hasMany(ItemImage::class);
	}

	/**
	 * Relationship to item_images table
	 * 
	 * @return Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function favorites() {

		return $this->hasMany(Favorite::class);
	}

	public function isFavorite($user_id) 
	{
		return $this->favorites->where('user_id', $user_id)->first() ? true : false;
	}

	/**
	 * get all items by category id
	 * 
	 * @return collection
	 */
	static public function allByCategory($id) 
	{
		return self::where('category_id', $id)->get();
	}

	/**
	 * get default name from category_details table
	 * 
	 * @return string
	 */
	public function getNameAttribute() 
	{
		return $this->details->first()['name'];

	}

	/**
	 * get default name from category_details table
	 * 
	 * @return string
	 */
	public function getDescriptionAttribute() 
	{
		return $this->details->first()['description'];

	}

	/**
	 * Relationship to categories table
	 * 
	 * @return Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function category() 
	{
		return $this->belongsTo(Category::class);
	}

	/**
	 * Relationship to categories table
	 * 
	 * @return Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function getCategoryNameAttribute() 
	{
		return $this->category->name;
	}

	/**
	 * Relationship to categories table
	 * 
	 * @return Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function getImagesArrayAttribute() 
	{
		// return ['test'];
		return $this->images->map(function($image) {

			return $image->url;

		})->toArray();
	}

	/**
	 * get image full url
	 * 
	 * @return string
	 */
	public function getFirstImageAttribute()
	{
		$first_image = $this->images->first();
		return $first_image ? $first_image->url : null;
	}

	/**
	 * get languages
	 * 
	 * @return string
	 */
	public function getLanguagesAttribute() 
	{
		$langs = [];

		foreach ($this->details as $detail) 
		{
			$langs[] = $detail->language;
		}

		return $langs;
	}
	
	/**
	 * Get remaining slots on this item
	 * 
	 * @return string
	 */
	public function getImageRemainingAttribute() 
	{
		return 10 - $this->images->count();
	}
	
	/**
	 * get languages
	 * 
	 * @return string
	 */
	public function getCheckedLangsAttribute() 
	{
		return $this->details->pluck('language_id')->toArray();
	}

	/**
	 * get details by language
	 * 
	 * @param int id
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function lang($id) 
	{

		$lang = $this->details->where('language_id', $id)->first(); 

		if (empty($lang)) {

			$lang = new \App\CategoryDetails;
			$lang->name = null;
			$lang->description = null;
			$lang->empty = true;
		}

		return $lang;
	}


	/**
	 * delete this model with its children models
	 * 
	 * @return boolean
	 */
	public function nestDelete() 
	{
		foreach ($this->details as $detail) 
		{
			$detail->delete();
		}

		foreach ($this->images as $image) 
		{
			$image->nestDelete();
		}

		$this->delete();
	}
}
