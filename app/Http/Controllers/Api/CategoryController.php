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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang_code = 'en')
    {
        $language = Language::where('code', $lang_code)->first();

        if (!$language) 
        {
            $json['msg'] = 'Incorrect Language provieded.';
            $json['status'] = false;
            $json['result'] = [];

            return response()->json($json);
        }

        $categories = Category::parents();

        $json['msg'] = 'Categories retrieved successfully.';
        $json['status'] = true;
        $json['result'] = $this->resource($categories, $language->id);

        return response()->json($json);
    }

    /**
     * resource alternative function
     * 
     * @param collection $data
     * @return array
     */
    public function resource($data, $lang) 
    {
        foreach ($data as $category) {
            $output[] = [

                'id' => $category->id,
                'name' => $category->lang($lang)->name ?? $category->name,
                'image' => $category->image,

            ];
        }

        return $output;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
