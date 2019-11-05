<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource as Resource;
use App\Category;
use App\Language;

class CategoryController extends Controller
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
    public function initParams($request)
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
    public function index(Request $request)
    {
        $this->initParams($request);

        $categories = Category::parents();

        if ($categories->isEmpty()) 
        {
            return response()->json([

                'msg' => 'No categories found.',
                'status' => false,
                'result' => [],

            ], 204);
        }

        return response()->json([

            'msg' => 'Data retrieved successfully.',
            'status' => true,
            'result' =>  $this->resource($categories),

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
        foreach ($data as $category) {
            $output[] = [

                'id' => $category->id,
                'name' => $category->lang($this->lang)->name ?? $category->name,
                'image' => $category->image_url ?? '',

            ];
        }

        return $output;
    }
}
