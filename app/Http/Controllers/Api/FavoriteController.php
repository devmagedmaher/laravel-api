<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Favorite;
use App\Item;
use App\Language;
use App\User;

class FavoriteController extends Controller
{
    /**
     * language ID
     * 
     * @var int
     */
    private $lang;

    /**
     * initialize parameters values
     * 
     * @return void
     */
    public function initLang($request)
    {    
        $lang_code = $request->lang ? $request->lang : 'en';

        $language = Language::where('code', $lang_code)->first();

        $this->lang = $language ? $language->id : 1;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $user_id)
    {
        $this->initLang($request);

        $user = User::find($user_id);

        if (!$user)
        {
            return response()->json([

                'msg' => 'User does not exists.',
                'status' => false,
                'result' => [],

            ], 404);
        }

        $favorites = $user->favorites;

        if ($favorites->isEmpty())
        {
            return response()->json([

                'msg' => 'No favorites found.',
                'status' => false,
                'result' => [],

            ], 204);
        }

        return response()->json([

            'msg' => 'Data retrieved successfully.',
            'status' => true,
            'result' => $this->resource($favorites)

        ], 200);
    }

    /**
     * resource alternative function
     * 
     * @param collection $data
     * @return array
     */
    public function resource($data) 
    {
        foreach ($data as $favorite) {
            $item = $favorite->item;
            $output[] = [

                'id' => $favorite->item_id,
                'name' => $item->lang($this->lang)->name ?? $item->name,
                'image' => $item->first_image ?? "",

            ];
        }

        return $output;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatorErrors = $this->validator($request);

        if ($validatorErrors) 
        {
            return response()->json([

                'msg' => 'Validation failed.',
                'status' => false,
                'result' => [$validatorErrors],

            ], 400);
        }

        $finderErrors = $this->finder($request);

        if ($finderErrors) 
        {
            return response()->json([

                'msg' => 'Add favorite failed.',
                'status' => false,
                'result' => [$finderErrors],

            ], 404);
        }

        if (Favorite::exists($request->user, $request->item)) 
        {
            return response()->json([

                'msg' => 'Favorite already exists.',
                'status' => false,
                'result' => [],

            ], 400);
        }

        $create = Favorite::create([

            'user_id' => $request->user,
            'item_id' => $request->item,

        ]);

        if (!$create) 
        {
            return response()->json([

                'msg' => 'Server failed.',
                'status' => false,
                'result' => [],

            ], 500);
        }

        return response()->json([

            'msg' => 'Favorite added successfully.',
            'status' => true,
            'result' => [],

        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $validatorErrors = $this->validator($request);

        if ($validatorErrors) 
        {
            return response()->json([

                'msg' => 'Validation failed.',
                'status' => false,
                'result' => [$validatorErrors],

            ], 400);
        }

        $finderErrors = $this->finder($request);

        if ($finderErrors) 
        {
            return response()->json([

                'msg' => 'Add favorite failed.',
                'status' => false,
                'result' => [$finderErrors],

            ], 404);
        }

        if (!Favorite::exists($request->user, $request->item)) 
        {
            return response()->json([

                'msg' => 'Favorite does not exists.',
                'status' => false,
                'result' => [],

            ], 404);
        }

        $delete = Favorite::remove($request->user ,$request->item);

        if (!$delete) 
        {
            return response()->json([

                'msg' => 'Server failed.',
                'status' => false,
                'result' => [],

            ]);
        }

        return response()->json([

            'msg' => 'Favorite removed successfully.',
            'status' => true,
            'result' => [],

        ]);
    }

    /**
     * check if item and user parameters exists
     * 
     * @return array
     */
    public function validator($request) 
    {
        if (!$request->item)
        {
            $errors['item'] = 'The `item` parameter is missing.';
        }
        else 
        {
        }  

        if (!$request->user) 
        {
            $errors['user'] = 'The `user` parameter is missing.';
        }

        return isset($errors) ? $errors : null;
    }


    /**
     * find if user or item exists
     * 
     * @return array
     */
    public function finder($request) 
    {
        $item = Item::find($request->item);

        if (!$item)
        {
            $errors['item'] = 'Item does not exist.';
        }
     
        $user = User::find($request->user);

        if (!$user)
        {
            $errors['user'] = 'User does not exist.';
        }

        return isset($errors) ? $errors : null;
    }
}
