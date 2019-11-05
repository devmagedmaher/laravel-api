<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Item;
use App\ItemImage;
use Validator;

class ImageController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.image.home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload(Item $item)
    {
        return view('admin.image.upload', [

            'item' => $item,

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Item $item)
    {
        $request->validate(['images' => 'required|array|min:1']);

        if (count($request->images) > $item->image_remaining) 
        {
            return back()->withErrors(['images' => "you have only $item->image_remaining image slots remaining on this item."]);
        }

        foreach ($request->images as $i => $image) 
        {
            $image->file_name = $image->getClientOriginalName();

            $messages["image"] = '"'.$image->file_name.'" must be an image file.';
            $messages["mimes"] = '"'.$image->file_name.'" must be a file type of :values.';
            $messages["max"] = '"'.$image->file_name.'" must be less than 500KB.';
            
            $image->validated = $this->validateImage($image, $messages);
        }

        $uploadErrors = [];
        $uploadSuccess = [];

        foreach ($request->images as $image) 
        {
            if ($image->validated)
            {
                $image_name = time() . rand(100, 900) . Str::random(11) . '.' . $image->getClientOriginalExtension();

                $upload = $image->storeAs('items', $image_name);

                if ($upload)
                {
                    ItemImage::create([

                        'item_id' => $item->id,
                        'name' => $image_name,
                    ]);

                    $uploadSuccess[] = '"' . $image->file_name . '" uploaded successfully.';
                }
                else
                {
                    $uploadErrors[] = '"' . $image->file_name . '" could not be uploaded.';
                }

            }
            else 
            {
                $uploadErrors[] = $image->errorMessage;
            }
        }

        return back()->with(['uploadSuccess' => $uploadSuccess, 'uploadErrors' => $uploadErrors]);
    }

    /**
     * validate images 
     * 
     * @param FileInput $image
     * @return boolean
     */
    public function validateImage($image, $messages) 
    {
        $validator = Validator::make(['image' => $image], [

            'image' => 'required|bail|image|mimes:jpg,jpeg,png|max:500', 

        ], $messages);

        if ($validator->fails())
        {
            $image->errorMessage = $validator->errors()->first();
            return false;
        }

        return true; 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemImage $image)
    {
        $image->nestDelete();

        return back();
    }
}
