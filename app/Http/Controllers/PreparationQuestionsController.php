<?php

namespace App\Http\Controllers;

use App\Preparation_questions;
use App\NonClinicalUsers;
use App\ReferringDoctors;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreparationQuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $preparation_questions = Preparation_questions::all();
        return view('preparation.questions', compact('preparation_questions'));
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
            'question_ar' => 'required|unique:Preparation_questions|max:255',
            'question_en' => 'required|unique:Preparation_questions|max:255',
        ], [
            'question_en.unique' =>'Sorry, this question already exist in english.',
            'question_ar.unique' =>'Sorry, this question already exist in arabic.',
        ]);

        Preparation_questions::create([
                'question_en' => $request->question_en,
                'question_ar' => $request->question_ar,
                'question_type' => $request->question_type,
                'Created_by' => (Auth::user()->name),
            ]);
        session()->flash('Add', 'Question add successfully!! ');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Preparation_questions  $preparation_questions
     * @return \Illuminate\Http\Response
     */
    public function show(Preparation_questions $preparation_questions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Preparation_questions  $preparation_questions
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Preparation_questions $preparation_questions)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Preparation_questions  $preparation_questions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Preparation_questions $preparation_questions)
    {
        $Preparation_questions = Preparation_questions::findOrFail($request->question_id);
        $Preparation_questions->update([
            'question_en' => $request->question_en,
            'question_ar' => $request->question_ar,
            'question_type' => $request->question_type,
            'Created_by' => (Auth::user()->name),
        ]);
        session()->flash('Edit', 'Question Edit successfully!!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Preparation_questions  $preparation_questions
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->question_id;
        Preparation_questions::find($id)->delete();
        session()->flash('delete', 'Question deleted successfully!!');
        return redirect()->back();
    }

    // extra services
    public function NonClinicalUsers()
    {
        $NonClinicalUsers = NonClinicalUsers::all();
        return view('preparation.NonClinicalUsers', compact('NonClinicalUsers'));
    }

    public function add_NonClinicalUser(Request $request)
    {
        $isActive = 0;
        
        if (isset($request->isActive)) {
            $isActive = 1;
        }
        $validatedData = $request->validate([
              'name_en' => 'required|unique:non_clinical_users|max:255',
          ], [
              'name_en.unique' =>'Sorry, This user name is already exist.',
              'name_en.required' =>'Sorry, User name is required.',
          ]);
      
        NonClinicalUsers::create([
                  'name_en' => $request->name_en,
                  'active' => $isActive,
              ]);
        session()->flash('Add', 'user add successfully!!');
        return redirect()->back();
    }
    public function edit_NonClinicalUser(Request $request)
    {
        $isActive = 0;
        
        if (isset($request-> isActive)) {
            $isActive = 1;
        }
        
        $NonClinicalUsers = NonClinicalUsers::findOrFail($request->id);
        $NonClinicalUsers->update([
              'name_en' => $request->name_en,
              'active' => $isActive,
          ]);
        session()->flash('Edit', 'user edit successfully!!');
        return redirect()->back();
    }
    public function delete_NonClinicalUser(Request $request)
    {
        $id = $request->NonClinicalUser_id;
        NonClinicalUsers::find($id)->delete();
        session()->flash('delete', 'user deleted successfully!!');
        return redirect()->back();
    }



    public function referringDoctors()
    {
        $ReferringDoctors = ReferringDoctors::all();
        return view('preparation.referringDoctors', compact('ReferringDoctors'));
    }

    public function add_referringDoctor(Request $request)
    {
        $isActive = 0;
        
        if (isset($request->isActive)) {
            $isActive = 1;
        }
        $validatedData = $request->validate([
              'name_en' => 'required|unique:non_clinical_users|max:255',
          ], [
              'name_en.unique' =>'Sorry, This user name is already exist.',
              'name_en.required' =>'Sorry, User name is required.',
          ]);
      
          ReferringDoctors::create([
                  'name_en' => $request->name_en,
                  'active' => $isActive,
              ]);
        session()->flash('Add', 'user add successfully!!');
        return redirect()->back();
    }
    public function edit_referringDoctor(Request $request)
    {
        $isActive = 0;
        
        if (isset($request-> isActive)) {
            $isActive = 1;
        }
        
        $ReferringDoctors = ReferringDoctors::findOrFail($request->id);
        $ReferringDoctors->update([
              'name_en' => $request->name_en,
              'active' => $isActive,
          ]);
        session()->flash('Edit', 'user edit successfully!!');
        return redirect()->back();
    }
    public function delete_referringDoctor(Request $request)
    {
        $id = $request->referringDoctor_id;
        ReferringDoctors::find($id)->delete();
        session()->flash('delete', 'user deleted successfully!!');
        return redirect()->back();
    }

}
