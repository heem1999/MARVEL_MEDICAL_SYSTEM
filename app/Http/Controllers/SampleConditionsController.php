<?php

namespace App\Http\Controllers;

use App\Sample_conditions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SampleConditionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'name_en' => 'required:Sample_types|max:255',
        ],[

            'name_en.required' =>'Please enter the Sample condition name.',
        ]);

        Sample_conditions::create([
                'sample_type_id' => $request->sample_type_id,
                'name_en' => $request->name_en,
                'description' => $request->description,
                'Created_by' => (Auth::user()->name),
            ]);
            session()->flash('Add', 'Sample condition add successfully!! ');
            return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sample_conditions  $sample_conditions
     * @return \Illuminate\Http\Response
     */
    public function show(Sample_conditions $sample_conditions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sample_conditions  $sample_conditions
     * @return \Illuminate\Http\Response
     */
    public function edit(Sample_conditions $sample_conditions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sample_conditions  $sample_conditions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sample_conditions $sample_conditions)
    {
        $Sample_conditions = Sample_conditions::findOrFail($request->id);
        $Sample_conditions->update([
            'name_en' => $request->name_en,
            'description' => $request->description,
            'Created_by' => (Auth::user()->name),
        ]);

        session()->flash('edit', 'Edited successfully!!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sample_conditions  $sample_conditions
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Sample_conditions $sample_conditions)
    {
        $id = $request->sample_condition_id;
        Sample_conditions::find($id)->delete();
        session()->flash('delete','Deleted successfully!!');
        return redirect()->back();
    }
}
