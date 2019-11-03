<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UserResource as Resource;
use App\User;

class UserController extends Controller
{

	/**
	 * update user profile
	 * 
	 * @param \Illuminate\Http\Request
	 * @return Response
	 */
	public function edit(Request $request, $id) 
	{

		$user = $this->userExists($id);

		if (!$user) 
		{
			$json['msg'] = 'User does not exists.';
			$json['status'] = false;
			$json['result'] = [];

			return response()->json($json);
		}

		if ($user->isAdmin()) 
		{
			$json['msg'] = 'Permission denied.';
			$json['status'] = false;
			$json['result'] = [];

			return response()->json($json);
		}

		$validator = $this->validator($request->all());

		if ($validator->fails()) 
		{
			$json['msg'] = 'Update failed.';
			$json['status'] = false;
			$json['result'] = ['errors' => $validator->errors()];

			return response()->json($json);
		}

		$update = $this->update($user, $request->all());

		$json['msg'] = $update ? 'User updated successfully.' : 'Database failed';
		$json['status'] = $update ? true : false;
		$json['result'] = $update ? [new Resource($user)] : [];

		return response()->json($json);
	}

	/**
	 * upload image
	 * 
	 * @param \Illluminate\Http\Request
	 * @return Json
	 */
	public function upload(Request $request, $id) 
	{

		$user = $this->userExists($id);

		if (!$user) 
		{
			$json['msg'] = 'User does not exists.';
			$json['status'] = false;
			$json['result'] = [];

			return response()->json($json);
		}

		if ($user->isAdmin()) 
		{
			$json['msg'] = 'Permission denied.';
			$json['status'] = false;
			$json['result'] = [];

			return response()->json($json);
		}

		$validator = $this->imageValidator($request->all());

		if ($validator->fails()) 
		{
			$json['msg'] = 'Update failed.';
			$json['status'] = false;
			$json['result'] = ['errors' => $validator->errors()];

			return response()->json($json);
		}

        $imageUploaded = $this->imageUpload($request->image);

        if ($imageUploaded === false) 
        {
        	$json['msg'] = 'File upload failed';
        	$json['status'] = false;
        	$json['result'] = [];

	        return response()->json($json);
        }

		$update = $this->update($user, ['image' => $imageUploaded]);

		$json['msg'] = $update ? 'User updated successfully.' : 'Database failed';
		$json['status'] = $update ? true : false;
		$json['result'] = $update ? [new Resource($user)] : [];

		return response()->json($json);
	}

	/**
	 * check if user exists
	 * 
	 * @return boolean
	 */
	public function userExists($id) 
	{
		return User::where('id', '=', $id)->get()->first();
	}

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20|regex:/^[0-9 -+]*$/',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  \App\User  $user
     * @param  array  $data
     * @return \App\User
     */
    protected function update(User $user, array $data)
    {
        return $user->update($data);
    }

    /**
     * Get a validator for an incoming upload image request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function imageValidator(array $data)
    {
        return Validator::make($data, [
            'image' => 'required|image|mimes:jpg,jpeg,png|max:500',
        ]);
    }


    /**
     * Upload user's profile picture
     *
     * @param file $image
     * @return boolean|string
     */
    public function imageUpload($image) 
    {
    	$imageName = time() . rand(100, 900) . Str::random(10) . '.' . $image->getClientOriginalExtension();

    	$upload = $image->storeAs('users', $imageName, 's3');

    	if (!$upload) 
    	{
    		return false;
    	}

    	return $imageName;
    }
}
