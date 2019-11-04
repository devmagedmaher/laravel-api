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
	        return response()->json([

                'msg' => 'Registration failed.',
                'status' => false,
                'result' => [$validator->errors()],

            ], 400);
        }

        $created_user = $this->create($request->all());

        if (!$created_user) 
        {
            return response()->json([

                'msg' => 'Server failed',
                'status' => false,
                'result' => [],

            ], 500);
        }

        return response()->json([

            'msg' => 'Registration is successfull.',
            'status' => true,
            'result' => [new Resource($created_user)],

        ], 201);
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
            'phone' => 'nullable|string|max:20|regex:/^[0-9 -+]*$/',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @param  string  $image
     * @return \App\User
     */
    protected function create(array $data)
    {
        $values['first_name'] = $data['first_name'];
        $values['last_name'] = $data['last_name'];
        if (isset($data['phone']) && $data['phone'] != null) $values['phone'] = $data['phone'];
        $values['email'] = $data['email'];
        $values['password'] = Hash::make($data['password']);

        return User::create($values);
    }

}
