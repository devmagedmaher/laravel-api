<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Language;
use Illuminate\Validation\Rule;
use Validator;

class LanguageController extends Controller
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
        return view('admin.language.home', [

            'languages' => Language::all(), 

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

        $image = $request->image ? true : false;
        $imageName = null;

        if ($image) 
        {
            $imageName = time(). rand(100,900) . $request->code . '.png';
            $upload = $request->image->storeAs('public/languages', $imageName);

            if (!$upload) 
            {
                return back()->withErrors(['image' => 'File upload error.']);
            }
        }

        Language::add($request->code, $request->name, $imageName);

        return back()->with('status', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Language $language)
    {
        //
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

        $image = $request->image ? true : false;

        if ($image) 
        {
            $imageName = time(). rand(100,900) . $request->code . '.png';
            $upload = $request->image->storeAs('public/languages', $imageName);

            if (!$upload) 
            {
                return back()->withErrors(['image' => 'File upload error.']);
            }
        }

        $language->code = $request->code;
        $language->name = $request->name;
        if ($image) $language->image = $imageName;
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
    public function upload(Request $request, Language $language)
    {
        $validator = Validator::make($request->all(), [

            'image' => 'required|image|mimes:png|max:500'

        ]);

        if ($validator->fails()) 
        {
            $route = route('admin.language.edit', ['language' => $language->id]);
            return redirect($route)->withErrors($validator);
        }

        $imageName = time() . rand(100,900) . $language->code . '.png';
        $upload = $request->image->storeAs('public/languages', $imageName);

        if (!$upload) 
        {
            $route = route('admin.language.edit', ['language' => $language->id]);
            return redirect($route)->withErrors(['image' => 'File upload error.']);
        }

        $language->image = $imageName;
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
