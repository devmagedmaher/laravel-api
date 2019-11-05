<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Validator;
use App\Language;

class LanguageController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.language.home', [

            'languages' => Language::allOrderedById(), 

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.language.create');
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

        $upload = $image->storeAs('languages', $image_name);

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

            'code' => 'required|string|size:2|unique:languages',
            'name' => 'required|string|min:3',
            'image' => 'nullable|image|mimes:png|max:500',

        ]);

        $uploaded_image = $this->uploadImage($request->image);

        if ($uploaded_image instanceof \Illuminate\Http\RedirectResponse)
        {
            return $uploaded_image;
        }

        Language::add($request->code, $request->name, $uploaded_image);

        return back()->with('status', 'success');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Language $language)
    {
        return view('admin.language.edit', [

            'language' => $language,

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Language $language)
    {
        $request->validate([

            'code' => [
                'required', 'string', 'size:2', 
                Rule::unique('languages')->ignore($request->code, 'code')
            ],
            'name' => 'required|string|min:3',
            'image' => 'nullable|bail|image|mimes:png|max:500',

        ]);


        $uploaded_image = $this->uploadImage($request->image);

        if ($uploaded_image instanceof \Illuminate\Http\RedirectResponse)
        {
            return $uploaded_image;
        }

        $language->code = $request->code;
        $language->name = $request->name;
        if ($uploaded_image) $language->image = $uploaded_image;
        $language->save();

        return back()->with('status', 'success');
    }

    /**
     * Upload the specified resource's image in storage
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editImage(Request $request, Language $language)
    {
        $validator = Validator::make($request->all(), [

            'image' => 'required|image|mimes:png|max:500'

        ]);

        if ($validator->fails()) 
        {
            $route = route('admin.language.edit', ['language' => $language->id]);
            return redirect($route)->withErrors($validator);
        }

        $uploaded_image = $this->uploadImage($request->image);

        if ($uploaded_image instanceof \Illuminate\Http\RedirectResponse)
        {
            return $uploaded_image;
        }

        $language->image = $uploaded_image;
        $language->save();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Language $language)
    {
        $language->nestDelete();

        return back();
    }
}
