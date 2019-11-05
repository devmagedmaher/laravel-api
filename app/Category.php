<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use App\CategoryDetails;

class Category extends Model
{

	use SoftDeletes;


	/**
	 * Fillable properties to allow mass assignment
	 * 
	 * @var array
	 */
	protected $fillable = [

		'parent_id', 'image', 

	];

	/**
	 * Relationship to category_details table
	 * 
	 * @return Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function details() 
	{
		return $this->hasMany(CategoryDetails::class);
	}

	/**
	 * Get sub categories
	 * 
	 * @return Illuminate\Database\Eloquent\Relations\HasMany
	 **/
	public function children() 
	{
		return $this->hasMany(self::class, 'parent_id');
	}

	/**
	 * Check if category has sub categories
	 * 
	 * @return boolean
	 **/
	public function hasChildren() 
	{
		return $this->children->count() ? true : false;
	}

	/**
	 * Check if category has sub categories
	 * 
	 * @return boolean
	 **/
	public function hasImage() 
	{
		// dd($this);
		return $this->image ? true : false;
	}

	/**
	 * Get parent category
	 * 
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 **/
	public function parent() 
	{
		return $this->belongsTo(self::class, 'parent_id');
	}

	/**
	 * Get parent category
	 * 
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 **/
	static public function parents() 
	{
		return self::where('parent_id', null)->get();
	}

	/**
	 * Check if category is parent.. not a sub category
	 * 
	 * @return boolean
	 */
	public function isParent() 
	{
		return $this->parent_id ? false : true;
	}
	
	/**
	 * Check if category is category
	 * 
	 * @return boolean
	 */
	public function isChild() 
	{
		return $this->parent_id ? true : false;
	}

	/**
	 * Get items
	 * 
	 * @return Illuminate\Database\Eloquent\Relations\HasMany
	 **/
	public function items() 
	{
		return $this->hasMany(Item::class);
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
     * get mutated phone value 
     * 
     * @return string
     */
    public function getImageUrlAttribute() 
    {
        return $this->image ? Storage::url("categories/$this->image") : null;
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
	 * get languages
	 * 
	 * @return string
	 */
	public function getCheckedLangsAttribute() 
	{
		return $this->details->pluck('language_id')->toArray();
	}

	/**
	 * get total entries count
	 * 
	 * @return int
	 */
	public function getEntriesAttribute() 
	{
		return $this->children->count() + $this->items->count();

	}

	/**
	 * delete model with other associated models
	 * 
	 * @return boolean
	 */
	public function nestDelete() 
	{
		foreach ($this->items as $item) 
		{
			$item->nestDelete();
		}

		foreach ($this->children as $child) 
		{
			$child->nestDelete();
		}

		foreach ($this->details as $detail) 
		{
			$detail->delete();
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
		$public = 'categories/';
		$trash = 'trash/categories/';

		if (Storage::exists($public . $this->name))
		{
	        Storage::move($public . $this->name, $trash . $this->name);
		}
	}
}
