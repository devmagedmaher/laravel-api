<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Category;
use App\CategoryDetails;
use App\Language;

class CategoryController extends Controller
{

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

            'langs' => Language::allOrderedById(),
            'categories' => Category::parents(),

        ]);
    }

    /**
     * upload Image
     * 
     * @param file $image
     * @return string
     */
    public function uploadImage($image) 
    {
        if ($image == null) return null;

        $image_name = time() . rand(100, 900) . Str::random(11) . '.' . $image->getClientOriginalExtension();

        $upload = $image->storeAs('categories', $image_name);

        if (!$upload) 
        {
            return back()->withErrors(['image' => 'File upload error.']);
        }

        return $image_name;
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
            'image' => 'nullable|bail|image|mimes:jpg,jpeg,png|max:500',

        ]);

        $uploaded_image = $this->uploadImage($request->image);

        if ($uploaded_image instanceof \Illuminate\Http\RedirectResponse)
        {
            return $uploaded_image;
        }

        $category = Category::create([

            'parent_id' => $request->parent,
            'image' => $uploaded_image,

        ]);

        foreach ($request->language as $k => $lang) {

            CategoryDetails::create([

                'category_id' => $category->id,
                'language_id' => $lang,
                'name'        => $request->name[$k],
                'description' => $request->description[$k],

            ]);

        }

        return back()->with(['status' => 'success']);
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

            'langs' => Language::allOrderedById(),
            'categories' => Category::where('parent_id', null)->get(),
            'category' => $category,

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Category $category
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
            'image' => 'nullable|bail|image|mimes:jpg,jpeg,png|max:500',

        ]);

        $uploaded_image = $this->uploadImage($request->image);

        if ($uploaded_image instanceof \Illuminate\Http\RedirectResponse)
        {
            return $uploaded_image;
        }

        $category->parent_id = $request->parent;
        $category->image = $uploaded_image;
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


        return back()->with(['status' => 'success']);
    }

    /**
     * upload image
     * 
     * @return \Illluminate\Http\Response
     */
    public function upload(Request $request, Category $category)
    {
        $request->validate([

            'image' => 'required|bail|image|mimes:jpg,jpeg,png|max:500',

        ]);

        $uploaded_image = $this->uploadImage($request->image);

        if ($uploaded_image instanceof \Illuminate\Http\RedirectResponse)
        {
            return $uploaded_image;
        }

        $category->image = $uploaded_image;
        $category->save();

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
