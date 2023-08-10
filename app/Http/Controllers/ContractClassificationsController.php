<?php

namespace App\Http\Controllers;

use App\Contract_classifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContractClassificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contract_classifications = contract_classifications::all();

        return view('administration.financial.contract_classifications.contract_classifications', compact('contract_classifications'));
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
            'name_en' => 'required|unique:Contract_classifications|max:255',
            'name_ar' => 'required|unique:Contract_classifications|max:255',
        ], [
            'name_en.unique' =>'Sorry, Currence name already exist.',
            'name_en.required' =>'Sorry, Contract classification name is required.',
            'name_ar.unique' =>'Sorry, Currence name already exist.',
            'name_ar.required' =>'Sorry, Contract classification name is required.',
        ]);

        Contract_classifications::create([
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'Created_by' => (Auth::user()->name),
            ]);
        session()->flash('Add', 'Contract classification add successfully!! ');
        return redirect('/contract_classifications');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contract_classifications  $contract_classifications
     * @return \Illuminate\Http\Response
     */
    public function show(Contract_classifications $contract_classifications)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contract_classifications  $contract_classifications
     * @return \Illuminate\Http\Response
     */
    public function edit(Contract_classifications $contract_classifications)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contract_classifications  $contract_classifications
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contract_classifications $contract_classifications)
    {
        $validatedData = $request->validate([
            'name_en' => 'required:Contract_classifications|max:255',
            'name_ar' => 'required:Contract_classifications|max:255',
        ], [
            'name_en.required' =>'Contract classification name in (EN) is required.',
            'name_ar.required' =>'Contract classification name in (AR) is required.',
        ]);

        $Contract_classifications = Contract_classifications::findOrFail($request->contract_classification_id);
        $Contract_classifications->update([
            'name_en' => $request->name_en,
            'name_ar' => $request->name_ar,
            'Created_by' => (Auth::user()->name),
        ]);
        session()->flash('Edit', 'Contract classification Edit successfully!! ');
        return redirect('/contract_classifications');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contract_classifications  $contract_classifications
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Contract_classifications $contract_classifications)
    {
        $id = $request->contract_classification_id;
        contract_classifications::find($id)->delete();
        session()->flash('delete', 'Contract classification deleted successfully!!');
        return redirect('/contract_classifications');
    }
}
