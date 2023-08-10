<?php

namespace App\Http\Controllers;

use App\Currencies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CurrenciesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currencies = currencies::all();

        return view('administration.financial.currencies.currencies', compact('currencies'));
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
            'name_en' => 'required|unique:currencies|max:255',
            'code' => 'required|unique:currencies|max:255',
        ], [
            'name_en.unique' =>'Sorry, Currence name already exist.',
            'code.unique' =>'Sorry, Currence code already used, use another code.',
        ]);

        currencies::create([
                'name_en' => $request->name_en,
                'code' => $request-> code,
                'Created_by' => (Auth::user()->name),
            ]);
        session()->flash('Add', 'Currence add successfully!! ');
        return redirect('/currencies');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Currencies  $currencies
     * @return \Illuminate\Http\Response
     */
    public function show(Currencies $currencies)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Currencies  $currencies
     * @return \Illuminate\Http\Response
     */
    public function edit(Currencies $currencies)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Currencies  $currencies
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Currencies $currencies)
    {
        $validatedData = $request->validate([
            'name_en' => 'required:currencies|max:255',
            'code' => 'required:currencies|max:255',
        ], [
            'name_en.required' =>'Currence name is required.',
            'code.required' =>'Currence code is required.',
        ]);

        $currencies = currencies::findOrFail($request->currence_id);
        $currencies->update([
            'name_en' => $request->name_en,
            'code' => $request-> code,
            'Created_by' => (Auth::user()->name),
        ]);
        session()->flash('Edit', 'Currence Edit successfully!! ');
        return redirect('/currencies');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Currencies  $currencies
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->currence_id;
        Currencies::find($id)->delete();
        session()->flash('delete', 'Currencies deleted successfully!!');
        return redirect('/currencies');
    }
}
