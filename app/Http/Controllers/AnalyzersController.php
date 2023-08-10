<?php

namespace App\Http\Controllers;

use App\Analyzers;
use App\processing_units;
use App\Branches;
use Illuminate\Support\Facades\Auth;
use App\Tests;
use App\Analyzer_tests;
use App\registration_samples_barcodes;
use App\registration_samples_barcode_services;
use App\reg_samples_barcode_servs_test;
use App\sample_traking_transactions;


use Illuminate\Http\Request;

class AnalyzersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Analyzers = Analyzers::all();
        return view('administration.analyzers.analyzers', compact('Analyzers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $test_status=['Verified',];//'Reviewed'
        $Branches = Branches::all();
        return view('administration.Analyzers.add_Analyzer', compact('Branches', 'test_status'));
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
            'name_en' => 'required|unique:Analyzers|max:255',
        ], [
            'name_en.unique' =>'Sorry, Analyzer name already exist.',
        ]);

        $reqData = $request->all();
        unset($reqData['isActive']);
        $reqData['active'] = $isActive;
        $reqData['Created_by'] = (Auth::user()->name);
        Analyzers::create($reqData);
        session()->flash('Add', 'Analyzer add successfully!! ');
        return redirect('/Analyzers');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Analyzers  $analyzers
     * @return \Illuminate\Http\Response
     */
    public function show(Analyzers $analyzers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Analyzers  $analyzers
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $test_status=['Verified',];//'Reviewed'
        $Branches = Branches::all();
        $Analyzer = Analyzers::where('id', $id)->first();
        $processing_units=processing_units::where('branch_id', $Analyzer->branch_id)->get();

        $Analyzer_tests = Analyzer_tests::where('analyzer_id', $Analyzer->id)->get();
        $Analyzer_tests_ids = Analyzer_tests::where('analyzer_id', $Analyzer->id)->pluck('test_id');
        $Tests = Tests::whereNotIn('id', $Analyzer_tests_ids)->get();
        return view('administration.Analyzers.edit_Analyzer', compact('Analyzer', 'Branches', 'test_status', 'processing_units', 'Tests', 'Analyzer_tests'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Analyzers  $analyzers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Analyzers $analyzers)
    {
        $id = $request->analyzer_id;
        $Analyzer=Analyzers::find($id);

        $isActive = 0;

        if (isset($request-> isActive)) {
            $isActive = 1;
        }

        $validatedData = $request->validate([
            'name_en' => 'required:Analyzers|max:255',
        ], [
            'name_en.required' =>'Sorry, Analyzer name is required.',
        ]);

        $Analyzer->update([
            'name_en' => $request->name_en,
            'branch_id' => $request->branch_id,
            'comm_port' => $request-> comm_port,
            'processing_units_id' => $request-> processing_units_id,
            'lms_code' => $request-> lms_code,
            'test_status' => $request-> test_status,
            'active' => $isActive,
        ]);
        session()->flash('Edit', 'Analyzer edit successfully!! ');
        return redirect('/Analyzers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Analyzers  $analyzers
     * @return \Illuminate\Http\Response
     */
    public function destroy(Analyzers $analyzers)
    {
        $id = $request->analyzer_id;
        Analyzer_tests::where('analyzer_id', $id)->delete();
        Analyzers::find($id)->delete();
        session()->flash('delete', 'Analyzer deleted successfully!!');
        return redirect()->back();
    }


    public function addAnalyzer_test(Request $request)
    {
        $validatedData = $request->validate([
            'analyzer_test_code' => 'required:Analyzer_tests|max:255',
            'test_id' => 'required:Analyzer_tests|max:255',
        ], [
            //'name_en.unique' =>'Sorry, Analyzer name already exist.',
        ]);

        $reqData = $request->all();
        Analyzer_tests::create($reqData);
        session()->flash('Add', 'Analyzer test add successfully!! ');
        //return redirect('/Analyzers');
        return redirect()->back();
    }

    public function delete_Analyzer_test(Request $request)
    {
        $id = $request->analyzer_test_id;
        Analyzer_tests::find($id)->delete();
        session()->flash('delete', 'Analyzer test deleted successfully!!');
        return redirect()->back();
    }


    public function copy_analyzer_tests(Request $request)
    {
        $analyzer_tests = Analyzer_tests::where('analyzer_id', $request->selected_analyzer_id)->get();

        $new_analyzer =$request->new_analyzer;
        if (count($analyzer_tests)>0) {
            Analyzer_tests::where('analyzer_id', $new_analyzer)->delete();//delete old price on the new list
            foreach ($analyzer_tests as $key => $analyzer_test) {
                //add tests
                Analyzer_tests::create([
                'analyzer_id' =>$new_analyzer ,
                'test_id' => $analyzer_test->test_id,
                'analyzer_test_code' => $analyzer_test->analyzer_test_code,
            ]);
            }
            session()->flash('Add', 'Analyzer tests copied successfully!!');
            return redirect()->back();
        } else {
            return back()->withErrors(["other10"=>"Sorry, the selected analyzer don't have tests."]);
        }
    }

    /************* analyzer_services  ****************************/
    public function analyzer_service(Request $request)
    {
        if ($request->flag=='Save_results') {
            $notes='';
            $sample_host_codes='';

            //get sample id sended form analyzer
            $SampleId=$request->results['Sample_Data'][0]['SampleId'];
            $testResultList=$request->results['testResultList'];
            $analyzer_id=$request->analyzer_id;
            foreach ($testResultList as $key => $testResult) {
                $test = Analyzer_tests::where('analyzer_id', $analyzer_id)->where('analyzer_test_code', $testResult['host_code'])->first();
                if ($test) {
                    $testResultList[$key]['test_id']=$test['test_id'];
                    $testResultList[$key]['test_status']=$test->analyzer->test_status;
                    $testResultList[$key]['analyzer_id']=$test->analyzer->id;
                    $analyzer_name=$test->analyzer->name_en;
                } else {
                    $testResultList[$key]['test_id']=null;
                }
            }

            //save sample result
            $registration_samples_barcodes=registration_samples_barcodes::where('sample_barcode', $SampleId)->first();
            if ($registration_samples_barcodes) {//check if this sample id exsit in system
                $rsb_id=$registration_samples_barcodes->id;
                $rsbs_ids=registration_samples_barcode_services::where('samples_barcode_id', $rsb_id)->get();

                foreach ($testResultList as $key1 => $testResult) {
                    if ($testResult['test_id']!==null) {
                        foreach ($rsbs_ids as $key => $rsbs_id) {
                            $result_test=reg_samples_barcode_servs_test::where('test_id', $testResult['test_id'])->where('rsbs_id', $rsbs_id->id)->first();
                            if ($result_test) {
                                $result_test->update([
                                    'result' => $testResult['tets_result'],
                                    'unit' => $testResult['unit'],
                                    'analyzer_id' => $testResult['analyzer_id'],
                                    'test_status' => $testResult['test_status'],
                                ]);
                                $sample_host_codes=$testResult['test_id'].' , '.$sample_host_codes;
                                //check if the analyzer save the result before
                                $sample_traking_transactions=sample_traking_transactions::where('analyzer_id', $analyzer_id)->where('rsb_id', $rsb_id)->first();
                                if ($sample_traking_transactions) {
                                    //save this transaction on sample traking transactions
                                    $sample_traking_transactions->update([
                                        'sample_status' => 'Queried',
                                        'rsb_id' => $rsb_id,
                                        'location_id' =>0 ,
                                        'analyzer_id' => $analyzer_id,
                                        'Created_by' =>0 ,
                                    ]);
                                } else {
                                    //save this transaction on sample traking transactions
                                    sample_traking_transactions::create([
                                        'sample_status' => 'Queried',
                                        'rsb_id' => $rsb_id,
                                        'location_id' =>0 ,
                                        'analyzer_id' => $analyzer_id,
                                        'Created_by' =>0 ,
                                    ]);
                                }
                            } else {
                                continue;
                            }
                        }
                    } else {//this analyzer host_code has no test add the test host code on analyzer
                        $notes='This host code '.$testResult['host_code'].' not belong to any test on analyzer setting, \n '.$notes;
                    }
                }
                //to change service status from pendding to review
                $this->review_sampleID_test($rsb_id);

                return response()->json(['msg' => 'Result saved successfuly! for the Sample ID '.$SampleId.' | '.$sample_host_codes,'data'=>$rsbs_ids,'notes'=>$notes], 200);
            } else {//thier is no sample id
                return response()->json(['msg' => 'Unknon Sample ID '.$SampleId], 200);
            }
        } elseif ($request->flag=='Test_order_query') {
            $sample_host_codes=[];
            $notes='';
            //get sample id sended form analyzer
            $SampleId=$request->results['test_order_query'][0]['SampleId'];
            $analyzer_id=$request->analyzer_id;


            //get host Analyzer code by sampleID
            $registration_samples_barcodes=registration_samples_barcodes::where('sample_barcode', $SampleId)->first();
            $rsb_id=$registration_samples_barcodes->id;
            $rsbs_ids=registration_samples_barcode_services::where('samples_barcode_id', $rsb_id)->get();



            foreach ($rsbs_ids as $key => $rsbs_id) {
                $sample_test=reg_samples_barcode_servs_test::where('rsbs_id', $rsbs_id->id)->first();
                $host_code = Analyzer_tests::where('analyzer_id', $analyzer_id)->where('test_id', $sample_test->test_id)->first();
                if ($host_code) {
                    array_push($sample_host_codes, $host_code->analyzer_test_code);
                } else {
                    $notes='This LMS test code '.$sample_test->test->code.' has no host code, \n '.$notes;
                }
            }
            return response()->json(['msg' => 'Get host codes successfuly! for the Sample ID '.$SampleId,'sample_host_codes'=>$sample_host_codes,'SampleId'=>$SampleId,'notes'=>$notes], 200);
        } elseif ($request->flag=='analyzer_configuration') {
            $analyzer_id=$request->analyzer_id;

            $analyzer_data=analyzers::where('id', $analyzer_id)->first();
            if($analyzer_data){
                return response()->json(['msg' => 'Configuration get successfuly from LMS server! com=>'.$analyzer_data->comm_port.' LMS_code=>'.$analyzer_data->lms_code,'analyzer_data'=>$analyzer_data], 200);
            }else{
                return response()->json(['msg' => 'No analyzer available with this ID ('.$analyzer_id.')'], 200);
            }
            
        }
    }

    public function review_sampleID_test($Sample_barcode_Id)
    {
        //check if all service tests is Reviewed or not to update the service status

        $registration_samples_barcode_services=registration_samples_barcode_services::where('samples_barcode_id', $Sample_barcode_Id)->get();
        $i=0;
        foreach ($registration_samples_barcode_services as $value1) {
            $reg_samples_barcode_servs_test_count = reg_samples_barcode_servs_test::where('rsbs_id', $value1->id)->where('test_status', 'Reviewed')->count();
            if ($reg_samples_barcode_servs_test_count==0) {
                $i=1;
                break;
            }
        }

        if ($i==0) {
            foreach ($registration_samples_barcode_services as $x) {
                $x->update([
                    'service_status'=>'Verified',
                    //'updated_by' => (Auth::user()->id),
                ]);
            }
        }
    }
}
