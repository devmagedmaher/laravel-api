<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Item;
use App\ItemDetails;
use App\Category;
use App\Language;

class ItemController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.item.home', [

            'items' => Item::all(),

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.item.create', [

            'langs' => Language::allOrderedById(),
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
            'price' => 'required|numeric', 
            'category' => 'required|numeric',

        ]);

        $item = Item::create([

            'price' => $request->price,
            'category_id' => $request->category

        ]);

        foreach ($request->language as $k => $lang) {

            ItemDetails::create([

                'item_id' => $item->id,
                'language_id' => $lang,
                'name'        => $request->name[$k],
                'description' => $request->description[$k],

            ]);

        }

        return redirect()->route('admin.image.upload', ['item' => $item->id])->with(['fromItemForm' => true]);
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
    public function edit(Item $item)
    {
        return view('admin.item.edit', [

            'langs' => Language::allOrderedById(),
            'categories' => Category::parents(),
            'item' => $item

        ]);
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
    public function destroy(Item $item)
    {
        $item->nestDelete();

        return back();
    }
}
