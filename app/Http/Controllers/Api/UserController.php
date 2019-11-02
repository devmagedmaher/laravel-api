<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource as Resource;
use App\User;

class UserController extends Controller
{
	/**
	 * Display users resources
	 * 
	 * @return Json
	 */
	public function index() 
	{
		return Resource::collection(User::all());
	}
}
