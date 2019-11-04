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

	/**
	 * get all favorites of certain user
	 * 
	 * @var collection
	 */
	static public function ofUser($user_id) 
	{
		return Parent::where('user_id', $user_id)->get();
	}

	/**
	 * check if favorite already exists
	 * 
	 * @var boolean
	 */
	static public function exists($user_id, $item_id) 
	{
		return Parent::where('user_id', $user_id)->where('item_id', $item_id)->first() ? true : false;
	}

	/**
	 * remove existing favorit
	 * 
	 * @var boolean
	 */
	static public function remove($user_id, $item_id) 
	{
		return Parent::where('user_id', $user_id)->where('item_id', $item_id)->delete();
	}
}
