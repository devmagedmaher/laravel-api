<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\CategoryDetails;
use App\Language;

class CategoryController extends Controller
{
    /**
     * Implementing middleware auth
     * 
     * @return void
     */
    public function __construct() 
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.category.home', [

            'categories' => Category::parents(),

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create', [

            'langs' => Language::all(),
            'categories' => Category::parents(),

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([

            'language.*' => 'required|numeric',
            'name.*' => 'required|string|min:3',
            'description.*' => 'required|string|min:10',
            'parent' => 'nullable|numeric',

        ]);

        $category = Category::create([

            'parent_id' => $request->parent

        ]);

        foreach ($request->language as $k => $lang) {

            CategoryDetails::create([

                'category_id' => $category->id,
                'language_id' => $lang,
                'name'        => $request->name[$k],
                'description' => $request->description[$k],

            ]);

        }

        $request->session()->flash('status', 'success');

        return back();
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
    public function edit(Category $category)
    {
        return view('admin.category.edit', [

            'langs' => Language::all(),
            'categories' => Category::where('parent_id', null)->get(),
            'category' => $category,

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([

            'language' => 'required|array|min:1',
            'language.*' => 'required|numeric',
            'name.*' => 'required|string|min:3',
            'description.*' => 'required|string|min:10',
            'parent' => 'nullable|numeric',

        ]);

        $category->parent_id = $request->parent;
        $category->save();

        foreach ($request->language as $k => $id) {

            $detail = $category->lang($id);
            
            if ($detail->exists)
            {
                $detail->update([

                    'name'        => $request->name[$k],
                    'description' => $request->description[$k],

                ]);
            }
            else 
            {
                CategoryDetails::create([

                'category_id' => $category->id,
                'language_id' => $request->language[$k],
                'name'        => $request->name[$k],
                'description' => $request->description[$k],

            ]);
            }
        }

        $request->session()->flash('status', 'success');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->nestDelete();

        return back();
    }
}
