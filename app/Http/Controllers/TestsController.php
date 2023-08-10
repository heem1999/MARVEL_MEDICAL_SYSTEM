<?php

namespace App\Http\Controllers;

use App\Tests;
use App\Processing_units;
use App\Clinical_units;
use App\Branches;
use App\Sample_types;
use App\Sample_conditions;
use App\Units;
use App\Tests_configurations_numeric;
use App\Preparation_questions;
use App\Tests_questions;
use App\Tests_configurations_option_list;
use App\Test_branch_samples;
use App\Test_branch_samples_branches;
use App\antibiotics;
use App\organisms;


use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tests = tests::all();
        return view('administration.tests.tests', compact('tests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $processing_units = processing_units::all();
        $clinical_units = clinical_units::all();
        $units = units::all();
        $sample_types = sample_types::all();
        $sample_conditions = sample_conditions::all();
        $preparation_questions = Preparation_questions::all();

        return view('administration.tests.add_test', compact('preparation_questions', 'units', 'clinical_units', 'sample_types', 'sample_conditions', 'processing_units'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $isActive = 0;

        if (isset($request-> isActive)) {
            $isActive = 1;
        }

        $validatedData = $request->validate([
            'name_en' => 'required|unique:tests|max:255',
            'code' => 'required|unique:tests|max:255',
        ], [
            'name_en.unique' =>'Sorry, test name already exist.',
            'code.unique' =>'Sorry, test code already used, use another code.',
        ]);

        tests::create([
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'report_name' => $request->report_name,
                'code' => $request-> code,
                'clinical_unit_id' => $request-> clinical_unit_id,
                'sample_type_id' => $request-> sample_type_id,
                'sample_condition_id' => $request-> sample_condition_id,
                'unit_id' => $request-> unit_id,
                'active' => $isActive,
                'gender' => $request-> gender,
                'test_type' => $request-> test_type,
                'Created_by' => (Auth::user()->name),
            ]);
        session()->flash('Add', 'Test add successfully!! ');
        return redirect('/tests');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tests  $tests
     * @return \Illuminate\Http\Response
     */
    public function show(Tests $tests)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tests  $tests
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $alreadySelectedBranches=[];

        //test types on system
        $list_of_test_types=['Numeric','Optional List' ,'Culture' ];
        $list_of_gender=['All','Male' ,'Female' ];
       
        $preparation_questions = Preparation_questions::all();
        $branches = branches::all();
        $test_branch_samples = Test_branch_samples::where('test_id', $id)->get();
        $test_branch_samples_branches = Test_branch_samples_branches::all();
        if ($test_branch_samples) {
            $test_branch_samples_branches1 = $test_branch_samples_branches ;
            foreach ($test_branch_samples as $key => $value) {
                foreach ($test_branch_samples_branches1 as $key1 => $value1) {
                    if ($value->id==$value1->test_branch_sample_id) {
                        $alreadySelectedBranches[]=$value1->branch_id;
                    }
                }
            }
        }
        

        foreach ($alreadySelectedBranches as $key => $branche_id) {
            foreach ($branches as $key1 => $branche) {
                if ($branche_id==$branche->id) {
                    unset($branches[$key1]);
                }
            }
        }

        
        //get the test questions
        $test_questions = Tests_questions::where('test_id', $id)->get();
      
        $clinical_units = clinical_units::all();
        $units = units::all();
        $sample_types = sample_types::all();
        $sample_conditions = sample_conditions::all();
        $test = tests::where('id', $id)->first();
        $test_configurations_numeric = Tests_configurations_numeric::where('test_id', $id)->get();
        $test_configuration_option_list = Tests_configurations_option_list::where('test_id', $id)->get();
        return view('administration.tests.edit_test', compact('list_of_test_types', 'test_questions', 'preparation_questions', 'test', 'units', 'clinical_units', 'sample_types', 'sample_conditions', 'test_configurations_numeric', 'test_configuration_option_list', 'list_of_gender', 'branches', 'test_branch_samples', 'test_branch_samples_branches', 'alreadySelectedBranches'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tests  $tests
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tests $tests)
    {
        $validatedData = $request->validate([
            'name_en' => 'required:tests|max:255',
            'code' => 'required:tests|max:255',
        ], [
            'name_en.required' =>'test name is required.',
            'code.required' =>'test code is required.',
        ]);

        //check if code or service name is already exist
        $serv1_name_en = tests::where('name_en', $request->name_en)->where('id', '<>', $request->test_id)->get();
        $serv1_code = tests::where('code', $request->code)->where('id', '<>', $request->test_id)->get();

        if (count($serv1_name_en)>0) {
            return back()->withErrors(["other10"=>"Sorry, this test name $request->name_en is already exist."]);
        } elseif (count($serv1_code)>0) {
            return back()->withErrors(['other10'=>'Sorry, test code already used, use another code.']);
        } else {
            $tests = tests::findOrFail($request->test_id);
            $isActive = 0;

            if (isset($request-> isActive)) {
                $isActive = 1;
            }
            $tests->update([
            'name_en' => $request->name_en,
            'name_ar' => $request->name_ar,
            'report_name' => $request->report_name,
            'code' => $request-> code,
            'clinical_unit_id' => $request-> clinical_unit_id,
            'sample_type_id' => $request-> sample_type_id,
            'sample_condition_id' => $request-> sample_condition_id,
            'unit_id' => $request-> unit_id,
            'active' => $isActive,
            'gender' => $request-> gender,
            'test_type' => $request-> test_type,
            'Created_by' => (Auth::user()->name),
        ]);
            session()->flash('Edit', 'Test edit successfully!!');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tests  $tests
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tests $tests)
    {
        //
    }


    public function get_sample_conditions($id)
    {
        $sample_conditions = sample_conditions::where('sample_type_id', $id)->get();
        return json_encode($sample_conditions);
    }

    //test configurations
    public function add_configurations_numeric(Request $request)
    {
        Tests_configurations_numeric::create([
                    'test_id' => $request->test_id,
                    'age_Form_d' => $request->age_Form_d,
                    'age_Form_m' => $request->age_Form_m,
                    'age_Form_y' => $request-> age_Form_y,
                    'age_To_d' => $request-> age_To_d,
                    'age_To_m' => $request-> age_To_m,
                    'age_To_y' => $request-> age_To_y,
                    'range_From' => $request-> range_From,
                    'range_To' => $request->range_To,
                    'gender' => $request-> gender,
                    'reference_range_comment' => $request-> reference_range_comment,
                    'Created_by' => (Auth::user()->name),
                ]);
        session()->flash('Add', 'Test configuration add successfully!! ');
        return redirect()->back();
    }
   
    public function edit_configurations_numeric(Request $request)
    {
        $test_configuration_numeric = Tests_configurations_numeric::findOrFail($request->test_conf_numeric_id);
        $test_configuration_numeric->update([
            'id' => $request->test_conf_numeric_id,
            'age_Form_d' => $request->age_Form_d,
            'age_Form_m' => $request->age_Form_m,
            'age_Form_y' => $request-> age_Form_y,
            'age_To_d' => $request-> age_To_d,
            'age_To_m' => $request-> age_To_m,
            'age_To_y' => $request-> age_To_y,
            'range_From' => $request-> range_From,
            'range_To' => $request->range_To,
            'gender' => $request-> gender,
            'reference_range_comment' => $request-> reference_range_comment,
            'Created_by' => (Auth::user()->name),
        ]);
        session()->flash('Edit', 'Test configuration edit successfully!!');
        return redirect()->back();
    }

    public function delete_configurations_numeric(Request $request)
    {
        $id = $request->test_conf_numeric_id;
        Tests_configurations_numeric::find($id)->delete();
        session()->flash('delete', 'Test configuration deleted successfully!!');
        return redirect()->back();
    }
    

    public function add_configurations_option_list(Request $request)
    {
        Tests_configurations_option_list::create([
            'test_id' => $request->test_id,
            'option_list_value' => $request->option_list_value,
                ]);
        session()->flash('Add', 'Test configuration add successfully!! ');
        return redirect()->back();
    }
   
    public function edit_configurations_option_list(Request $request)
    {
        $tests_configurations_option_list = Tests_configurations_option_list::findOrFail($request->test_conf_option_list_id);
        $tests_configurations_option_list->update([
            'option_list_value' => $request->option_list_value,
        ]);
        session()->flash('Edit', 'Test configuration edit successfully!!');
        return redirect()->back();
    }

    public function delete_configurations_option_list(Request $request)
    {
        $id = $request->test_conf_option_list_id;
        Tests_configurations_option_list::find($id)->delete();
        session()->flash('delete', 'Test configuration deleted successfully!!');
        return redirect()->back();
    }
    



    //test questions
    public function add_question_to_test(Request $request)
    {
        Tests_questions::create([
                    'test_id' => $request->test_id,
                    'question_id' => $request->question_id,
                ]);
        session()->flash('Add', 'Question add successfully to the test!! ');
        return redirect()->back();
    }

    public function delete_question_from_test(Request $request)
    {
        $id = $request->question_id;
        Tests_questions::find($id)->delete();
        session()->flash('delete', 'Question deleted successfully from the test!!');
        return redirect()->back();
    }

    public function add_branch_sample(Request $request)
    {
      
        //delete all branches and add new ones
        // Test_branch_samples::where('test_id', $request->test_id)->where('sample_type_id', $request->sample_type_id2)->where('sample_condition_id', $request->sample_condition_id2)->delete();

        //get the id of new insert

        $Test_branch_sample=Test_branch_samples::where('test_id', $request->test_id)->where('sample_type_id', $request->sample_type_id2)->where('sample_condition_id', $request->sample_condition_id2)->first();

        if ($Test_branch_sample) { //this branch sample is exist
            foreach ($request->branches_ids as $key => $branch_id) {
                //get the id of new insert
                $Test_branch_samples_branches=Test_branch_samples_branches::where('branch_id', $branch_id)->where('test_branch_sample_id', $Test_branch_sample->id)->get();

                if ($Test_branch_samples_branches) {
                    Test_branch_samples_branches::create([
                        'branch_id' => $branch_id ,
                        'test_branch_sample_id' => $Test_branch_sample->id ,
                            ]);
                }
            }
        } else {
            Test_branch_samples::create([
                'test_id' => $request->test_id,
                'sample_type_id' => $request->sample_type_id2,
                'sample_condition_id' => $request->sample_condition_id2,
                    ]);
            //get the id of new insert
            $Test_branch_sample=Test_branch_samples::where('test_id', $request->test_id)->where('sample_type_id', $request->sample_type_id2)->where('sample_condition_id', $request->sample_condition_id2)->first();
            foreach ($request->branches_ids as $key => $branch_id) {
                Test_branch_samples_branches::create([
                    'branch_id' => $branch_id ,
                    'test_branch_sample_id' => $Test_branch_sample->id ,
                        ]);
            }
        }
        session()->flash('Add', 'Branch sample add successfully to the test!! ');
        return redirect()->back();
    }


    public function delete_test_branch_sample(Request $request)
    {
        $id = $request->test_branch_sample_id;
        Test_branch_samples::find($id)->delete();
        Test_branch_samples_branches::where('test_branch_sample_id', $id)->delete();
        session()->flash('delete', 'Branch sample deleted successfully form the test!!');
        return redirect()->back();
    }

    public function delete_single_branch_sample(Request $request)
    {
        $id = $request->test_branch_samples_branche_id;
        $test_branch_sample_id =$request->test_branch_sample;
        
        Test_branch_samples_branches::find($id)->delete();
        $Test_branch_sample=Test_branch_samples_branches::where('test_branch_sample_id', $test_branch_sample_id)->first();
        
        if (is_null($Test_branch_sample)) {
            Test_branch_samples::where('id', $test_branch_sample_id)->delete();
        }
        session()->flash('delete', 'Branch sample deleted successfully form the test!!');
        return redirect()->back();
    }

    //organisms
    public function organisms()
    {
        $organisms = organisms::all();
        return view('administration.tests.organisms.organisms', compact('organisms'));
    }

    public function add_organism(Request $request)
    {
        $validatedData = $request->validate([
            'name_en' => 'required|unique:organisms|max:255',
        ], [
            'name_en.unique' =>'Sorry, Organism name already exist.',
            'name_en.required' =>'Organism name is required.',
        ]);
        organisms::create([
                'name_en' => $request->name_en,
            ]);
        session()->flash('Add', 'organism add successfully!!');
        return redirect()->back();
    }
    public function edit_organism(Request $request)
    {
        $organisms = organisms::findOrFail($request->id);
        $organisms->update([
            'name_en' => $request->name_en,
        ]);
        session()->flash('Edit', 'Organism edit successfully!!');
        return redirect()->back();
    }
    public function delete_organism(Request $request)
    {
        $id = $request->organism_id;
        organisms::find($id)->delete();
        session()->flash('delete', 'Organism deleted successfully!!');
        return redirect()->back();
    }

    // antibiotics
    public function antibiotics()
    {
        $antibiotics = antibiotics::all();
        return view('administration.tests.antibiotics.antibiotics', compact('antibiotics'));
    }

    public function add_antibiotic(Request $request)
    {
        $validatedData = $request->validate([
            'name_en' => 'required|unique:antibiotics|max:255',
        ], [
            'name_en.unique' =>'Sorry, Antibiotic name already exist.',
            'name_en.required' =>'Antibiotic name is required.',
        ]);
        antibiotics::create([
                'name_en' => $request->name_en,
            ]);
        session()->flash('Add', 'Antibiotic add successfully!!');
        return redirect()->back();
    }
    public function edit_antibiotic(Request $request)
    {
        $antibiotics = antibiotics::findOrFail($request->id);
        $antibiotics->update([
            'name_en' => $request->name_en,
        ]);
        session()->flash('Edit', 'Antibiotic edit successfully!!');
        return redirect()->back();
    }
    public function delete_antibiotic(Request $request)
    {
        $id = $request->antibiotic_id;
        antibiotics::find($id)->delete();
        session()->flash('delete', 'Antibiotic deleted successfully!!');
        return redirect()->back();
    }
}
