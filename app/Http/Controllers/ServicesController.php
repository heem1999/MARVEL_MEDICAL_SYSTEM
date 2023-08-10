<?php

namespace App\Http\Controllers;

use App\Services;
use Illuminate\Http\Request;

use App\Clinical_units;
use App\Tests;
use  Illuminate\Support\Facades\Auth;
use App\Service_tests;
use App\service_nested_services;
use App\extra_services;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = services::all();
        return view('administration.services.services', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clinical_units = clinical_units::all();

        return view('administration.services.add_service', compact('clinical_units'));
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
        $is_nested_services = 0;
        
        //  $clinical_unit_id=$request-> clinical_unit_id;
        $service_type=null;
        if (isset($request-> isActive)) {
            $isActive = 1;
        }
        if (isset($request-> is_nested_services)) {
            $is_nested_services = 1;
            $service_type="Package";
        }
        if (isset($request->clinical_unit_id)) {
            $service_type="Test";
        } elseif ($is_nested_services == 0) {
            return back()->withErrors(["other10"=>"Sorry, please select the clinical unit that the test belongs to it."]);
        }

        $validatedData = $request->validate([
            'name_en' => 'required|unique:services|max:255',
            'code' => 'required|unique:services|max:255',
        ], [
            'name_en.unique' =>'Sorry, service name already exist.',
            'code.unique' =>'Sorry, service code already used, use another code.',
        ]);

        services::create([
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'report_name' => $request->report_name,
                'code' => $request-> code,
                'clinical_unit_id' =>$request->clinical_unit_id,
                'short_name' => $request-> short_name,
                'service_type' => $service_type,
                'active' => $isActive,
                'is_nested_services' => $is_nested_services,
                'processing_time' => $request->processing_time,
                'Created_by' => (Auth::user()->name),
            ]);
        session()->flash('Add', 'Service add successfully!! ');
        return redirect('/services');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function show(Services $services)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tes=0;
        $clinical_units = clinical_units::all();
        $tests = tests::all();
        $service = services::where('id', $id)->first();
        $service_tests = service_tests::where('service_id', $id)->get();
        
        //get this package nested services
        $current_nested_services = service_nested_services::where('service_id', $id)->get();

        $other_services = services::where('is_nested_services', 0)->where('id', '<>', $id)->get();

        //execlude services already selected on this package
        if (count($current_nested_services)>0) {
            $other_services1=$other_services;
            foreach ($current_nested_services as $key => $nested_service) {
                foreach ($other_services1 as $key1 => $other_service) {
                    if ($nested_service->nested_service_id==$other_service->id) {
                        unset($other_services[$key1]);
                    }
                }
            }
        }

        //get all tests belong to the service clinical unit
        if ($service->clinical_unit_id) {
            $tests = tests::where('clinical_unit_id', $service->clinical_unit_id)->get();
        }
        
        //execlude tests already selected on this service
        if (count($service_tests)>0) {
            $tests1=$tests;
            foreach ($tests1 as $key => $test) {
                foreach ($service_tests as $key1 => $service_test) {
                    if ($service_test->test->id==$test->id) {
                        unset($tests[$key]);
                    }
                }
            }
            $tes=$service_tests;
        }
        return view('administration.services.edit_service', compact('service_tests', 'service', 'tests', 'clinical_units', 'other_services', 'current_nested_services'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Services $services)
    {
        $validatedData = $request->validate([
            'name_en' => 'required:services|max:255',
            'code' => 'required:services|max:255',
        ], [
            'name_en.required' =>'service name is required.',
            'code.required' =>'service code is required.',
        ]);

        //check if code or service name is already exist
        $serv1_name_en = services::where('name_en', $request->name_en)->where('id', '<>', $request->service_id)->get();
        $serv1_code = services::where('code', $request->code)->where('id', '<>', $request->service_id)->get();

        if (count($serv1_name_en)>0) {
            return back()->withErrors(["other10"=>"Sorry, this service name $request->name_en is already exist."]);
        } elseif (count($serv1_code)>0) {
            return back()->withErrors(['other11'=>'Sorry, service code already used, use another code.']);
        } else {
            $services = services::findOrFail($request->service_id);

            $isActive = 0;
            $is_nested_services = 0;
            $service_type;
            if (isset($request-> is_nested_services)) {
                $is_nested_services = 1;
                $service_type="Package";
            } else {
                $current_nested_services = service_nested_services::where('service_id', $request->service_id)->get();

                if (count($current_nested_services)>0) {
                    return back()->withErrors(["other10"=>"Sorry, please delete all nested services inside this package."]);
                }
            }

            if (isset($request->clinical_unit_id)) {
                $service_type="Test";
            } elseif ($is_nested_services == 0) {
                return back()->withErrors(["other10"=>"Sorry, please select the clinical unit that the test belongs to it."]);
            }
            if (isset($request-> isActive)) {
                $isActive = 1;
            }

            /*if (isset($request-> clinical_unit_id)) {
                $clinical_unit_id=$request-> clinical_unit_id;
                //check if clinical units change from multi to spacefic clinical_units
                $old_service_value = services::where('id', $request->service_id)->first();
                $service_tests = service_tests::where('service_id', $request->service_id)->get();
                if ($old_service_value->service_type=="Package") {//it was Package means its muti clinical_units
                    foreach ($service_tests as $key => $value) {
                        if ($value->test->clinical_unit_id!==$request->clinical_unit_id) {
                            $v=$value->test->clinical_unit_id;
                            return back()->withErrors(["other13"=>"Sorry, this service contains tests belonging to another clinical unit, please delete them and try again!"]);
                        }
                    }
                }
            }*/

            $services->update([
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'report_name' => $request->report_name,
                'code' => $request-> code,
                'clinical_unit_id' =>$request->clinical_unit_id,
                'service_type' => $service_type,
                'short_name' => $request-> short_name,
                'active' => $isActive,
                'is_nested_services' => $is_nested_services,
                'processing_time' => $request->processing_time,
                
                'Created_by' => (Auth::user()->name),
            ]);
            session()->flash('Edit', 'Service edited successfully!! ');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->service_id;
        services::find($id)->delete();
        session()->flash('delete', 'Services deleted successfully!!');
        return redirect()->back();
    }


    public function add_service_test(Request $request)
    {
        /* $validatedData = $request->validate([
             'name_en' => 'required|unique:Clinical_units|max:255',
         ],[

             'name_en.required' =>'Please enter the Clinical unit name.',
             'name_en.unique' =>'This Clinical unit is already existed.',
         ]);
*/
        foreach ($request->tests_ids as $key => $test_id) {
            service_tests::create([
                'test_id' => $test_id,
                'service_id' => $request->service_id,
                    ]);
        }
       
        session()->flash('Add', 'Test add successfully from the service!! ');
        return redirect()->back();
    }
   
    
    public function add_service_package(Request $request)
    {
        /* $validatedData = $request->validate([
             'package_services_ids' => 'required|unique:service_nested_services|max:255',
         ], [
             'package_services_ids.required' =>'Please select service to add to this package.',
             'package_services_ids.unique' =>'This service is already added to this package.',
         ]);
*/
         $total_processing_time=0;
        foreach ($request->package_services_ids as $key => $service_id) {
            $new_service=services::find($service_id)->first();
            $total_processing_time=$total_processing_time+$new_service->processing_time;
            service_nested_services::create([
                'nested_service_id' => $service_id,
                'service_id' => $request->service_id,
                    ]);
        }
       //update the service package processing_time
       $service = services::findOrFail($request->service_id);
       $service->update([
        'processing_time' => $total_processing_time,
    ]);
        session()->flash('Add', 'Test add successfully from the service!! ');
        return redirect()->back();
    }

    public function delete_service_test(Request $request)
    {
        $test_id = $request->test_id;
        $service_id = $request->service_id;
        service_tests::where('service_id', $service_id)->where('test_id', $test_id)->delete();
        session()->flash('delete', 'Test deleted successfully from the service!!');
        return redirect()->back();
    }

    public function delete_nested_service(Request $request)
    {
        $nested_service_id = $request->nested_service_id;
        $service_id = $request->service_id;
        service_nested_services::where('nested_service_id', $nested_service_id)->where('service_id', $service_id)->delete();
        session()->flash('delete', 'Service deleted successfully from the package!!');
        return redirect()->back();
    }


    // extra_services
    public function extra_services()
    {
        $extra_services = extra_services::all();
        return view('administration.services.extra_services', compact('extra_services'));
    }
 
    public function add_extra_service(Request $request)
    {
        $validatedData = $request->validate([
             'name_en' => 'required|unique:extra_services|max:255',
         ], [
             'name_en.unique' =>'Sorry, extra service name already exist.',
             'name_en.required' =>'extra service name is required.',
         ]);
        $isActive = 0;
        
        if (isset($request-> isActive)) {
            $isActive = 1;
        }
 
        $ex_code= extra_services::orderBy('id', 'desc')->first();
        
        if (!$ex_code) {
            $ex_code='ex1';
        } else {
            $new_id=$ex_code->id+1;
            $ex_code='ex'.$new_id;
        }
        

        extra_services::create([
                 'name_en' => $request->name_en,
                 'active' => $isActive,
                 'ex_code' => $ex_code,
             ]);
        session()->flash('Add', 'extra service add successfully!!');
        return redirect()->back();
    }
    public function edit_extra_service(Request $request)
    {
        $isActive = 0;
        
        if (isset($request-> isActive)) {
            $isActive = 1;
        }

        $extra_services = extra_services::findOrFail($request->id);
        $extra_services->update([
             'name_en' => $request->name_en,
             'active' => $isActive,
         ]);
        session()->flash('Edit', 'extra service edit successfully!!');
        return redirect()->back();
    }
    public function delete_extra_service(Request $request)
    {
        $id = $request->extra_service_id;
        extra_services::find($id)->delete();
        session()->flash('delete', 'extra service deleted successfully!!');
        return redirect()->back();
    }


    public function get_services()
    {
        $services = services::all('id','code','name_en','name_ar');
        return $services;
    }

    
}
