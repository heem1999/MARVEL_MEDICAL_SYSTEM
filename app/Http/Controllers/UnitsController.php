<?php

namespace App\Http\Controllers;

use App\Units;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnitsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Units = Units::all();
       
        return view('administration.tests.units', compact('Units'));
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
        ],[

            'name_en.required' =>'Please enter the Sample type name.',
            'name_en.unique' =>'This Sample type is already existed.',
        ]);

        Units::create([
                'name_en' => $request->name_en,
                'Created_by' => (Auth::user()->name),
            ]);
            session()->flash('Add', 'Unit add successfully!! ');
            return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Units  $units
     * @return \Illuminate\Http\Response
     */
    public function show(Units $units)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Units  $units
     * @return \Illuminate\Http\Response
     */
    public function edit(Units $units)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Units  $units
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Units $units)
    {
        $Units = Units::findOrFail($request->id);
        $Units->update([
            'name_en' => $request->name_en,
            'Created_by' => (Auth::user()->name),
        ]);

        session()->flash('edit', 'Unit edited successfully!!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Units  $units
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Units $units)
    {
        $id = $request->unit_id;
        Units::find($id)->delete();
        session()->flash('delete','Unit deleted successfully!!');
        return redirect()->back();
    }


    
}
