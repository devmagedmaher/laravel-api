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
			return response()->json([

				'msg' => 'User does not exists.',
				'status' => false,
				'result' => [],

			], 404);
		}

		if ($user->isAdmin()) 
		{
			return response()->json([

				'msg' => 'Premission denied',
				'status' => false,
				'result' => [],

			], 403);
		}

		$validator = $this->validator($request->all());

		if ($validator->fails()) 
		{
			return response()->json([

				'msg' => 'Update failed.',
				'status' => false,
				'result' => [$validator->errors()],

			], 400);
		}

		$update = $this->update($user, $request->all());

		if (!$update) 
		{
			return response()->json([

				'msg' => 'Server failed.',
				'status' => false,
				'result' => [],

			], 500);
		}

		return response()->json([

			'msg' => 'User updated successfully.',
			'status' => true,
			'result' => [new Resource($user)],

		], 200);
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
			return response()->json([

				'msg' => 'User does not exists.',
				'status' => false,
				'result' => [],

			], 404);
		}

		if ($user->isAdmin()) 
		{
			return response()->json([

				'msg' => 'Premission denied',
				'status' => false,
				'result' => [],

			], 403);
		}

		$validator = $this->imageValidator($request->all());

		if ($validator->fails()) 
		{
			return response()->json([

				'msg' => 'Update failed.',
				'status' => false,
				'result' => [$validator->errors()],

			], 400);
		}

        $imageUploaded = $this->imageUpload($request->image);

        if ($imageUploaded === false) 
        {
			return response()->json([

				'msg' => 'File Upload failed.',
				'status' => false,
				'result' => [],

			], 500);
        }

		$update = $this->update($user, ['image' => $imageUploaded]);

		if (!$update) 
		{
			return response()->json([

				'msg' => 'Server failed.',
				'status' => false,
				'result' => [],

			], 500);
		}

		return response()->json([

			'msg' => 'Image uploaded successfully.',
			'status' => true,
			'result' => [],

		], 200);
	}

	/**
	 * check if user exists
	 * 
	 * @return boolean
	 */
	public function userExists($id) 
	{
		return User::where('id', '=', $id)->first();
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

    	$upload = $image->storeAs('users', $imageName);

    	if (!$upload) 
    	{
    		return false;
    	}

    	return $imageName;
    }
}
