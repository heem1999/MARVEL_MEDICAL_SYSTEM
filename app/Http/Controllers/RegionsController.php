<?php

namespace App\Http\Controllers;

use App\regions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Regions', ['only' => ['index']]);
        $this->middleware('permission:Add Region', ['only' => ['create','store']]);
        $this->middleware('permission:Edit Region', ['only' => ['edit','update']]);
        $this->middleware('permission:Delete Region', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $regions = regions::all();
        return view('administration.regions.regions', compact('regions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('administration.regions.add_regions');
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
            'name_en' => 'required|unique:regions|max:255',
            'name_ar' => 'required|unique:regions|max:255',
        ], [

            'name_en.required' =>'"Please enter the region',
            'name_en.unique' =>'This country is already registered',
            'name_ar.required' =>'"Please enter the region',
            'name_ar.unique' =>'This country is already registered',
        ]);

        regions::create([
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'Created_by' => (Auth::user()->name),
            ]);
        session()->flash('Add', 'Region add successfully!! ');
        return redirect('/regions');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\regions  $regions
     * @return \Illuminate\Http\Response
     */
    public function show(regions $regions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\regions  $regions
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
       // $regions = regions::where('id', $id)->first();
      //  return view('administration.regions.edit_region', compact('regions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\regions  $regions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, regions $regions)
    {
        $regions = regions::findOrFail($request->id);
        $regions->update([
            'name_en' => $request->name_en,
            'name_ar' => $request->name_ar,
            'Created_by' => (Auth::user()->name),
        ]);

        session()->flash('edit', 'Edited successfully!!');
        return redirect('/regions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\regions  $regions
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, regions $regions)
    {
        $id = $request->region_id;
        regions::find($id)->delete();
        session()->flash('delete', 'Deleted successfully!!');
        return redirect('/regions');
    }
}