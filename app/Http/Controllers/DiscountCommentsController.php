<?php

namespace App\Http\Controllers;

use App\Discount_comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscountCommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discount_comments = discount_comments::all();

        return view('administration.financial.discount_comments.discount_comments', compact('discount_comments'));
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
        $validatedData = $request->validate([
            'name_en' => 'required|unique:discount_comments|max:255',
        ], [
            'name_en.unique' =>'Sorry, discount_comments name already exist.',
            'name_en.required' =>'Sorry, discount comment name is required.',
        ]);

        discount_comments::create([
                'name_en' => $request->name_en,
                'Created_by' => (Auth::user()->name),
            ]);
        session()->flash('Add', 'discount comments add successfully!! ');
        return redirect('/discount_comments');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Discount_comments  $discount_comments
     * @return \Illuminate\Http\Response
     */
    public function show(Discount_comments $discount_comments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Discount_comments  $discount_comments
     * @return \Illuminate\Http\Response
     */
    public function edit(Discount_comments $discount_comments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Discount_comments  $discount_comments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Discount_comments $discount_comments)
    {
        $validatedData = $request->validate([
            'name_en' => 'required:discount_comments|max:255',
        ], [
            'name_en.required' =>'discount comment name is required.',
        ]);

        $discount_comments = discount_comments::findOrFail($request->discount_comment_data_id);
        $discount_comments->update([
            'name_en' => $request->name_en,
            'Created_by' => (Auth::user()->name),
        ]);
        session()->flash('Edit', 'discount comment Edit successfully!! ');
        return redirect('/discount_comments');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Discount_comments  $discount_comments
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Discount_comments $discount_comments)
    {
        $id = $request->discount_comment_data_id;
        discount_comments::find($id)->delete();
        session()->flash('delete', 'discount comment deleted successfully!!');
        return redirect('/discount_comments');
    }
}
