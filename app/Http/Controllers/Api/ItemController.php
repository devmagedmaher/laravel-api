<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ItemResource as Resource;
use App\Item;
use App\Category;
use App\Language;

class ItemController extends Controller
{
    /**
     * user ID
     * 
     * @var int
     */
    private $user;

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
    public function initParams($request)
    {
        $lang_code = $request->lang ? $request->lang : 'en';

        $language = Language::where('code', $lang_code)->first();

        $this->lang = $language ? $language->id : 1;

        $this->user = $request->user ? $request->user : null;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $category_id)
    {
        $this->initParams($request);

        $category = Category::find($category_id);

        if (!$category) 
        {
            return response()->json([

                'msg' => 'Category does not exist.',
                'status' => false,
                'result' => [],

            ], 404);
        }

        $items = $category ? $category->items : [];

        if ($items->isEmpty()) 
        {
            return response()->json([

                'msg' => 'No items found.',
                'status' => false,
                'result' => [],

            ], 204);
        }

        return response()->json([

            'msg' => 'Data retrieved successfully.',
            'status' => true,
            'result' => $this->indexResource($items),

        ], 200);
    }

    /**
     * resource alternative function
     * 
     * @param collection $data
     * @return array
     */
    public function indexResource($data) 
    {
        foreach ($data as $item) {
            $output[] = [

                'id' => $item->id,
                'name' => $item->lang($this->lang)->name ?? $item->name,
                'has_favorite' =>  $item->isFavorite($this->user),
                'image' => $item->first_image ?? '',

            ];
        }

        return $output;
    }


    /**
     * get specific item
     * 
     * @return Json
     */
    public function show(Request $request, $item_id) 
    {
        $this->initParams($request);

        $item = Item::find($item_id);

        if (!$item) 
        {
            return response()->json([

                'msg' => 'Item does not exist.',
                'status' => false,
                'result' => [],

            ]);
        }

        return response()->json([

            'msg' => 'Data retrieved successfully.',
            'status' => true,
            'result' => [$this->showResource($item)],

        ]);
    }

    /**
     * resource alternative function
     * 
     * @param collection $data
     * @return array
     */
    public function showResource($item) 
    {
        return [

            'id' => $item->id,
            'name' => $item->lang($this->lang)->name ?? $item->name,
            'description' => $item->lang($this->lang)->description ?? $item->description,
            'has_favorite' => $item->isFavorite($this->user),
            'images' => $item->images_array,

        ];
    }

}
