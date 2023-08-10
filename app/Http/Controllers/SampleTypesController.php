<?php

namespace App\Http\Controllers;

use App\Sample_types;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Sample_conditions;

class SampleTypesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Administrator', ['only' => ['index']]);
        $this->middleware('permission:Administrator', ['only' => ['create','store']]);
        $this->middleware('permission:Administrator', ['only' => ['edit','update']]);
        $this->middleware('permission:Administrator', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sample_types = Sample_types::all();
        return view('administration.samples.sample_types', compact('sample_types'));
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
            'name_en' => 'required|unique:Sample_types|max:255',
        ], [

            'name_en.required' =>'Please enter the Sample type name.',
            'name_en.unique' =>'This Sample type is already existed.',
        ]);

        Sample_types::create([
                'name_en' => $request->name_en,
                'Created_by' => (Auth::user()->name),
            ]);
        session()->flash('Add', 'Sample type add successfully!! ');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sample_types  $sample_types
     * @return \Illuminate\Http\Response
     */
    public function show(Sample_types $sample_types)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sample_types  $sample_types
     * @return \Illuminate\Http\Response
     */
    public function edit(Sample_types $sample_types)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sample_types  $sample_types
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sample_types $sample_types)
    {
        $regions = Sample_types::findOrFail($request->id);
        $regions->update([
            'name_en' => $request->name_en,
            'Created_by' => (Auth::user()->name),
        ]);

        session()->flash('edit', 'Edited successfully!!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sample_types  $sample_types
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Sample_types $sample_types)
    {
        $id = $request->sample_type_id;
        Sample_types::find($id)->delete();
        session()->flash('delete', 'Deleted successfully!!');
        return redirect()->back();
    }


    public function show_sample_conditions($id)
    {
        $Sample_type = Sample_types::where('id', $id)->first();
        $Sample_conditions = Sample_conditions::where('sample_type_id', $id)->get();
        return view('administration.samples.sample_conditions', compact('Sample_type', 'Sample_conditions'));
    }
}