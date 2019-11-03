<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UserResource as Resource;
use App\User;

class LoginController extends Controller
{

	/**
	 * login request
	 * 
	 * @return JSON
	 */
    public function index(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) 
        {
        	$json['msg'] = 'Login failed';
        	$json['status'] = false;
        	$json['result'] = ['errors' => $validator->errors()];

	        return response()->json($json);
        }


        $auth = $this->authenticate($request->all());

        $json['msg'] 	= $auth ? 'Login is successfull.' : 'Credentials are incorrect';
        $json['status'] = $auth ? true : false;
        $json['result'] = $auth ? [new Resource($auth)] : [];

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
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
    }

    /**
     * Authenticatation
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function authenticate(array $data)
    {
    	if (Auth::attempt([

    		'email' => $data['email'],
    		'password' => $data['password'],

    	]))
    	{
    		return Auth::user();
    	}

    	return false;
    }
}
