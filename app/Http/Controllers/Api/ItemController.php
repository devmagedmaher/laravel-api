<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ItemResource as Resource;
use App\Item;
use App\Language;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $category_id, $lang_code = 'en')
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

        $items = Item::allByCategory($category_id);

        $json['msg'] = 'Data retrieved successfully.';
        $json['status'] = true;
        $json['result'] = $this->indexResource($items, $language->id, $user_id);

        return response()->json($json);
    }

    /**
     * resource alternative function
     * 
     * @param collection $data
     * @return array
     */
    public function indexResource($data, $lang, $user_id) 
    {
        $output = [];
        foreach ($data as $item) {
            $output[] = [

                'id' => $item->id,
                'name' => $item->lang($lang)->name ?? $item->name,
                'has_favorite' => $item->favorites->where('user_id', $user_id)->first() ? true : false,
                'image' => $item->images->first() ? $item->images->first()->url() : '',

            ];
        }

        return $output;
    }


    /**
     * get specific item
     * 
     * @return Json
     */
    public function show(Request $request, $item_id, $lang_code = 'en') 
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

        $item = Item::find($item_id);

        if (!$item) 
        {
            $json['msg'] = 'Item not found.';
            $json['status'] = false;
            $json['result'] = [];

            return response()->json($json);
        }

        $json['msg'] = 'Data retrieved successfully.';
        $json['status'] = true;
        $json['result'] = $this->showResource($item, $language->id, $user_id);

        return response()->json($json);
    }

    /**
     * resource alternative function
     * 
     * @param collection $data
     * @return array
     */
    public function showResource($item, $lang, $user_id) 
    {
        return [

            'id' => $item->id,
            'name' => $item->lang($lang)->name ?? $item->name,
            'description' => $item->lang($lang)->description ?? $item->description,
            'has_favorite' => $item->favorites->where('user_id', $user_id)->first() ? true : false,
            'images' => $item->images_array,

        ];
    }

}
