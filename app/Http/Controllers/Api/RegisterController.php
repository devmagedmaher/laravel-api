<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UserResource as Resource;
use App\User;

class RegisterController extends Controller
{

	/**
	 * register new user
	 * 
	 * @return JSON
	 */
    public function index(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) 
        {
        	$json['msg'] = 'Registration failed';
        	$json['status'] = false;
        	$json['result'] = ['errors' => $validator->errors()];

	        return response()->json($json);
        }

        $imageUploaded = $this->upload($request->image);

        if ($imageUploaded === false) 
        {
        	$json['msg'] = 'File upload failed';
        	$json['status'] = false;
        	$json['result'] = [];

	        return response()->json($json);
        }

        $user = $this->create($request->all(), $imageUploaded);

        $json['msg'] 	= $user ? 'Registration is successfull.' : 'Database failed';
        $json['status'] = $user ? true : false;
        $json['result'] = $user ? [new Resource($user)] : [];

        return response()->json($json);
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20|regex:/^[0-9 -+]*$/',
            'password' => 'required|string|min:6',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:500',
        ]);
    }

    /**
     * Upload user's profile picture
     *
     * @param file $image
     * @return boolean|string
     */
    public function upload($image) 
    {
    	$imageName = time() . rand(100, 900) . Str::random(10) . '.' . $image->getClientOriginalExtension();

    	$upload = $image->storeAs('users', $imageName, 's3');

    	if (!$upload) 
    	{
    		return false;
    	}

    	return $imageName;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @param  string  $image
     * @return \App\User
     */
    protected function create(array $data, $image)
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'image' => $image,
        ]);
    }

}
