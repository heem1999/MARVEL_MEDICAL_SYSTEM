<?php

namespace App\Http\Controllers;

use App\cancel_reasons;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CancelReasonsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cancel_reasons = cancel_reasons::all();
        return view('general_settings.cancel_reasons', compact('cancel_reasons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
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
            'reason_en' => 'required|unique:cancel_reasons|max:255',
            'reason_ar' => 'required|unique:cancel_reasons|max:255',
        ],[
            'reason_en.unique' =>'Sorry, this reason already exist in english.',
            'reason_ar.unique' =>'Sorry, this reason already exist in arabic.',
        ]);

        cancel_reasons::create([
                'reason_en' => $request->reason_en,
                'reason_ar' => $request->reason_ar,
            ]);
            session()->flash('Add', 'Question add successfully!! ');
            return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\cancel_reasons  $cancel_reasons
     * @return \Illuminate\Http\Response
     */
    public function show(cancel_reasons $cancel_reasons)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\cancel_reasons  $cancel_reasons
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, cancel_reasons $cancel_reasons)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\cancel_reasons  $cancel_reasons
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, cancel_reasons $cancel_reasons)
    {
        $cancel_reasons = cancel_reasons::findOrFail($request->reason_id);
        $cancel_reasons->update([
            'reason_en' => $request->reason_en,
            'reason_ar' => $request->reason_ar,
        ]);
        session()->flash('Edit', 'Edit successfully!!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\cancel_reasons  $cancel_reasons
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->reason_id;
        cancel_reasons::find($id)->delete();
        session()->flash('delete','Deleted successfully!!');
        return redirect()->back();
    }
}
