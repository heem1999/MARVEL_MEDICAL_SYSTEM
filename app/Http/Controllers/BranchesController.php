<?php

namespace App\Http\Controllers;

use App\Branches;
use App\Regions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Processing_units;
use App\Clinical_units;

class BranchesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Branches', ['only' => ['index']]);
        $this->middleware('permission:Add branch', ['only' => ['create','store']]);
        $this->middleware('permission:Edit branch', ['only' => ['edit','update']]);
        $this->middleware('permission:Delete branch', ['only' => ['destroy']]);
    }
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branches = branches::all();
        return view('administration.branches.branches', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $regions = regions::all();
        return view('administration.branches.add_branches', compact('regions'));
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
            'name_en' => 'required:branches|max:255',
            'email' => 'nullable|email',
        ], [
            'name_en.required' =>'Branche name is required.',
        ]);
        branches::create([
            'name_en' => $request->name_en,
            'code' => $request->code,
            'region_id' => $request->Section,
            'phone' => $request->phone,
            'email' => $request->email,
            'lacation_lat' => $request->lat,
            'lacation_lng' => $request->lng,
            'address' => $request->address,
            'Created_by' => (Auth::user()->name),
        ]);

        session()->flash('Add', 'Branch add successfully!! ');
        return redirect('/branches');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Branches  $branches
     * @return \Illuminate\Http\Response
     */
    public function show(Branches $branches)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Branches  $branches
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $branches = branches::where('id', $id)->first();
        $regions = regions::all();
        $processing_units = processing_units::where('branch_id', $id)->get();
        $samble_status=['Ordered','Collected','Pre-analytical','Received','Rejected','Reserved'];
        return view('administration.branches.edit_branch', compact('branches', 'regions', 'processing_units', 'samble_status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Branches  $branches
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Branches $branches)
    {
        $show_time_to_receive_result = 0;

        if (isset($request->show_time_to_receive_result)) {
            $show_time_to_receive_result = 1;
        }

        $show_result_date_receipt = 0;

        if (isset($request->show_result_date_receipt)) {
            $show_result_date_receipt = 1;
        }
        
        $validatedData = $request->validate([
            'name_en' => 'required:branches|max:255',
            'email' => 'nullable|email',
        ], [
            'name_en.required' =>'Branche name is required.',
        ]);
        $branches = branches::findOrFail($request->branch_id);
        $branches->update([
            'name_en' => $request->name_en,
            'code' => $request->code,
            'region_id' => $request->region_id,
            'phone' => $request->phone,
            'email' => $request->email,
            'lacation_lat' => $request->lat,
            'lacation_lng' => $request->lng,
            'address' => $request->address,
            'Created_by' => (Auth::user()->name),
            'show_time_to_receive_result' => $show_time_to_receive_result,
            'show_result_date_receipt' => $show_result_date_receipt,
        ]);

        session()->flash('Edit', 'Branch Edit successfully!! ');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Branches  $branches
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Branches $branches)
    {
        $id = $request->branche_id;
        branches::find($id)->delete();
        session()->flash('delete', 'Deleted successfully!!');
        return redirect('/branches');
    }


    public function add_Processing_units(Request $request)
    {
        processing_units::create([
            'name_en' => $request->name_en,
            'defualt_samble_status' => $request->defualt_samble_status,
            'branch_id' => $request->branch_id,
            'Created_by' => (Auth::user()->name),
        ]);
       
        session()->flash('Add', 'Processing unit add successfully!! ');
      
        return redirect()->back();
    }

    public function delete_processing_unit(Request $request, Processing_units $Processing_units)
    {
        $id = $request->Processing_unit_id;
        processing_units::find($id)->delete();
        session()->flash('delete', 'Processing unit deleted successfully!!');
       
        return redirect()->back();
    }
    
    public function update_processing_unit(Request $request, Processing_units $Processing_units)
    {
        $Processing_units = processing_units::findOrFail($request->id);
        $Processing_units->update([
            'name_en' => $request->name_en,
            'defualt_samble_status' => $request->defualt_samble_status,
            'Created_by' => (Auth::user()->name),
        ]);

        session()->flash('Edit', 'Processing unit edit successfully!! ');
        return redirect()->back();
    }


    
    public function open_Clinical_units()
    {
        $Clinical_units = Clinical_units::all();
       
        return view('administration.branches.Clinical_units', compact('Clinical_units'));
    }

    
    public function add_Clinical_unit(Request $request)
    {
        $validatedData = $request->validate([
            'name_en' => 'required|unique:Clinical_units|max:255',
            'name_ar' => 'required|unique:Clinical_units|max:255',
        ], [
            'name_en.required' =>'Please enter the Clinical unit name(en).',
            'name_en.unique' =>'This Clinical unit is already existed.',
            'name_ar.required' =>'Please enter the Clinical unit name(ar).',
            'name_ar.unique' =>'This Clinical unit is already existed.',
        ]);
        
        Clinical_units::create([
            'name_en' => $request->name_en,
            'name_ar' => $request->name_ar,
            'Created_by' => (Auth::user()->name),
        ]);
       
        session()->flash('Add', 'Clinical unit add successfully!! ');
      
        return redirect()->back();
    }

    public function delete_Clinical_unit(Request $request, Clinical_units $Clinical_units)
    {
        $id = $request->clinical_unit_id;
        Clinical_units::find($id)->delete();
        session()->flash('delete', 'Clinical unit deleted successfully!!');
       
        return redirect()->back();
    }
    
    public function update_Clinical_unit(Request $request, Clinical_units $Clinical_units)
    {
        $Clinical_units = Clinical_units::findOrFail($request->id);
        $Clinical_units->update([
            'name_en' => $request->name_en,
            'name_ar' => $request->name_ar,
            'Created_by' => (Auth::user()->name),
        ]);

        session()->flash('Edit', 'Clinical unit edit successfully!! ');
        return redirect()->back();
    }
}