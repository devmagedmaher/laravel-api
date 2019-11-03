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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Item $item, $lang_code = 'en')
    {
        $language = Language::where('code', $lang_code)->first();

        if (!$language) 
        {
            $json['msg'] = 'Incorrect Language provieded.';
            $json['status'] = false;
            $json['result'] = [];

            return response()->json($json);
        }

        $user_id = $request->user_id ? $request->user_id : null;

        if (!$user_id)
        {
            $json['msg'] = '`User id` is not provided.';
            $json['status'] = false;
            $json['result'] = [];

            return response()->json($json);            
        }

        $favorites = Favorite::where('user_id', $user_id)->get();

        return $this->resource($favorites, $language->id, $user_id);

    }

    /**
     * resource alternative function
     * 
     * @param collection $data
     * @return array
     */
    public function resource($data, $lang, $user_id) 
    {        
        $output = [];
        foreach ($data as $favorite) {
            $output[] = [

                'id' => $favorite->item_id,
                'name' => $favorite->item->lang($lang)->name ?? $favorite->item->name,
                'image' => $favorite->item->images->first() ? $favorite->item->images->first()->url() : '',

            ];
        }

        return $output;    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $item_id)
    {
        $item = Item::find($item_id);

        if (!$item) 
        {
            $json['msg'] = 'Item not found.';
            $json['status'] = false;
            $json['result'] = [];

            return response()->json($json);
        }  

        $user_id = $request->user_id ?? null;

        if (!$user_id) 
        {
            $json['msg'] = 'User id is not provided.';
            $json['status'] = false;
            $json['result'] = [];

            return response()->json($json);
        } 

        $user = User::find($user_id);

        if (!$user) 
        {
            $json['msg'] = 'User not found.';
            $json['status'] = false;
            $json['result'] = [];

            return response()->json($json);
        } 

        $exists = Favorite::where('user_id', $user_id)->where('item_id', $item_id)->first();

        if ($exists) 
        {
            $json['msg'] = 'User had already added this item to his favorite.';
            $json['status'] = false;
            $json['result'] = [];

            return response()->json($json);
        } 

        $create = Favorite::create([

            'user_id' => $user_id,
            'item_id' => $item_id,

        ]);

        $json['msg'] = $create ? 'User added item to his favorite successfully.' : 'Database failed';
        $json['status'] = $create ? true : false;
        $json['result'] = [];

        return response()->json($json);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $item_id)
    {
        $item = Item::find($item_id);

        if (!$item) 
        {
            $json['msg'] = 'Item not found.';
            $json['status'] = false;
            $json['result'] = [];

            return response()->json($json);
        }  

        $user_id = $request->user_id ?? null;

        if (!$user_id) 
        {
            $json['msg'] = 'User id is not provided.';
            $json['status'] = false;
            $json['result'] = [];

            return response()->json($json);
        } 

        $user = User::find($user_id);

        if (!$user) 
        {
            $json['msg'] = 'User not found.';
            $json['status'] = false;
            $json['result'] = [];

            return response()->json($json);
        } 

        $favorite = Favorite::where('user_id', $user_id)->where('item_id', $item_id)->first();

        if (!$favorite) 
        {
            $json['msg'] = 'User does not have this item in his favorite.';
            $json['status'] = false;
            $json['result'] = [];

            return response()->json($json);
        } 

        $delete = $favorite->delete();

        $json['msg'] = $delete ? 'User added item to his favorite successfully.' : 'Database failed';
        $json['status'] = $delete ? true : false;
        $json['result'] = [];

        return response()->json($json);
    }
}
