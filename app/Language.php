<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Language extends Model
{
	use SoftDeletes;

	/**
	 * Fillable properties to allow mass assignment
	 * 
	 * @var array
	 */
	protected $fillable = [

		'code', 'name', 'image', 

	];

	/**
	 * Add new language
	 * 
	 * @param string $code 
	 * @param string $name 
	 * @param string $image 
	 * @return Boolean
	 */
	static public function add($code, $name, $image = null) 
	{

		if (!isset($code) || !isset($name)) return false;
		
		$values['code'] = $code;
		$values['name'] = $name;
		$values['image'] = $image;

		return Parent::create($values);
	}

	/**
	 * Get Categories
	 * 
	 * @return Illuminate\Database\Eloquent\Builder
	 */
	public function categories() 
	{
		return $this->hasMany(\App\CategoryDetails::class);
	}

	/**
	 * Get Items
	 * 
	 * @return Illuminate\Database\Eloquent\Builder
	 */
	public function items() 
	{
		return $this->hasMany(\App\ItemDetails::class);
	}

	/**
	 * get all ordered by id
	 * 
	 * @return collection
	 */
	static public function allOrderedById() 
	{
		return Parent::orderBy('id', 'ASC')->get();
	}

	/**
	 * Get total entries
	 * 
	 * @return int
	 */
	public function getEntriesAttribute() 
	{
		return $this->categories->count() + $this->items->count();
	}

	/**
	 * get image url
	 * 
	 * @return string
	 */
	public function getImageUrlAttribute() 
	{
		return $this->image ? Storage::url("languages/$this->image") : null;
	}

	/**
	 * Check if language has image
	 * 
	 * @return int
	 */
	public function hasImage() 
	{
		return $this->image ? true : false;
	}

	/**
	 * nest delete
	 * 
	 * @return boolean
	 */
	public function nestDelete() 
	{
		foreach ($this->categories as $category) 
		{
			$category->delete();	
		}
		foreach ($this->items as $item) 
		{
			$item->delete();	
		}

		$this->trashImage();		

		$this->delete();
	}

	/**
	 * move image to trash directory
	 * 
	 * @return boolean
	 */
	public function trashImage()
	{
		$public = "languages";
		$trash = "trash/languages";

		if (Storage::exists($public . $this->image))
		{
			Storage::move($public . $this->image, $trash . $this->image);
		}
	}
}
