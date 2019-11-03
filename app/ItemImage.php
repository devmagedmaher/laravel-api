<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class ItemImage extends Model
{

	use SoftDeletes;

	/**
	 * Fillable properties to allow mass assignment
	 * 
	 * @var array
	 */
	protected $fillable = [

		'item_id', 'name'

	];

	/**
	 * Nest delete
	 * 
	 * @return boolean
	 */
	public function nestDelete() 
	{
        $this->trashImage();

		$this->delete();
	}

	/**
	 * move image to trash
	 * 
	 * @return boolean
	 */
	public function trashImage() 
	{
		$public = 'items/';
		$trash = 'trash/items/';

		if (Storage::disk('s3')->exists($public . $this->name))
		{
	        Storage::disk('s3')->move($public . $this->name, $trash . $this->name);
		}
	}
}
