<?php

namespace App\Http\Controllers;

use App\Branches;
use App\Treasury_mac_address;
use App\Processing_units;
use App\sample_location_requests;
use App\Sample_location_mac_address;
use App\registration_samples_barcodes;
use App\registration_samples_barcode_services;
use App\registrations_details;
use App\reg_samples_barcode_servs_test;
use App\sample_traking_transactions;



use Illuminate\Http\Request;
use  Illuminate\Support\Facades\Auth;

class SampleLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branches = Branches::all();
        $d = explode('Physical Address. . . . . . . . .', shell_exec("ipconfig/all"));
        $i=0;
        $macs=array();
        foreach ($d as $key => $value) {
            $d1 = explode(':', $d[$i]);
            $d2 = explode(' ', $d1[1]);
            $macs[]= $d2[1];
            $i++;
        }
        $samble_status=['Ordered','Collected','Pre-analytical','Received'];
        
        $pc_macAddress = $macs;
        return view('administration.samples.sampleLocation.sampleLocation_requests', compact('branches', 'pc_macAddress', 'samble_status'));
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
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Treasuries  $treasuries
     * @return \Illuminate\Http\Response
     */
    public function show(Treasuries $treasuries)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Treasuries  $treasuries
     * @return \Illuminate\Http\Response
     */
    public function edit(Treasuries $treasuries)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Treasuries  $treasuries
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Treasuries $treasuries)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Treasuries  $treasuries
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
    }

    public function get_branch_Processing_units($branch_id)
    {
        $Processing_units = Processing_units::where('branch_id', $branch_id)->get();
        return json_encode($Processing_units);
    }

    public function get_current_sampleStatus($selected_status_id)
    {
        $samble_status=['Ordered','Collected','Pre-analytical','Received'];
        $samble_status1=['Ordered','Collected','Pre-analytical','Received'];
        foreach ($samble_status as $key => $value) {
            if ($selected_status_id>=$key) {
                unset($samble_status1[$key]);
            }
        }
        return json_encode($samble_status1);
    }

    

    public function monitor_sampleLocation()
    {
        $Sample_location_mac_address = Sample_location_mac_address::all();
        $sample_location_requests = sample_location_requests::all();
        
        return view('administration.samples.sampleLocation.monitor_sampleLocation_requests', compact('sample_location_requests', 'Sample_location_mac_address'));
    }

    public function new_sampleLocation_request(Request $request)
    {
        $samble_status1=['Ordered','Collected','Pre-analytical','Received'];

        $validatedData = $request->validate([
              'previous_samble_status' => 'required',
              'current_samble_status' => 'required',
              'branch_Processing_units' => 'required',
          ], [
              //'treasury_id.required' =>'Please enter the treasury name.',
              //'pc_macAddress.required' =>'Please provide the treasury MAC addres.',
          ]);

        //check if this pc have valid sample_location_requests
        foreach ($request->pc_macAddress as $key => $pc_macAddr) {
            $sampleLocation_mac_address = Sample_location_mac_address::where('mac', $pc_macAddr)->first();
            if ($sampleLocation_mac_address) {
                break;
            }
        }
        if ($sampleLocation_mac_address) {
            $mac_add=$sampleLocation_mac_address->mac;
            return back()->withErrors(["other10"=>"Sorry, this PC ($mac_add) has make a sample location request before, you can use it or delete that request."]);
        /* $mac_add=$sampleLocation_mac_address->mac;
         $sampleLocReq_id=$sampleLocation_mac_address->sampleLocReq_id;
         //check if the treasury previous status
         $treasurie_previous_request = sample_location_requests::where('id', $sampleLocReq_id)->where('request_status', 1)->first();
         if ($treasurie_previous_request) {
             $treasury= Treasuries::where('id', $treasurie_previous_request->treasurie_id)->first();
             $name_en= $treasury->name_en;
             $branch_name_en= $treasury->branch->name_en;

             return back()->withErrors(["other10"=>"Sorry, this PC is already belong to this treasury ($name_en) on this  ($branch_name_en) branch an it's active."]);
         } else {
             return back()->withErrors(["other10"=>"Sorry, this PC ($mac_add) has make a treasury request before, you can use it or delete that request."]);
         }*/
        } else {
            sample_location_requests::create([
                'request_status' => 0,
                'current_status' => $request->current_samble_status,
                'previous_status' =>  $samble_status1[$request->previous_samble_status],
                'processing_units_id' => $request->branch_Processing_units,
                'user_id' => (Auth::user()->id),
            ]);
            $sample_location_requests = sample_location_requests::where('processing_units_id', $request->branch_Processing_units)->orderBy('id', 'DESC')->first();
           
            foreach ($request->pc_macAddress as $key => $pc_macAddr) {
                Sample_location_mac_address::create([
                    'mac' => $pc_macAddr,
                    'sampleLocReq_id' => $sample_location_requests->id,
                ]);
            }
            session()->flash('Add', 'Sample location request send successfully!! ');
            return redirect()->back();
        }
    }

    public function update_sampleLocation_request_status(Request $request)
    {
        $sample_location_request= sample_location_requests::find($request->rq_id);
        $rq_old_value=0;
        if ($request->rq_old_value==0) {
            $rq_old_value=1;
        }
        $sample_location_request->update([
            'request_status' => $rq_old_value,
        ]);
        session()->flash('Edit', "Sample location request status were changed successfully!!");
        return redirect()->back();
    }

    public function delete_sampleLocation_request(Request $request)
    {
        sample_location_requests::find($request->rq_id)->delete();
        Sample_location_mac_address::where('sampleLocReq_id', $request->rq_id)->delete();
        session()->flash('delete', 'Sample request deleted successfully!!');
        return redirect()->back();
    }

    public function receive_sample()
    {
        $Sample_location_mac_address = [];
        $sample_location_requests = [];
        $sample_location_branch= [];
        $d = explode('Physical Address. . . . . . . . .', shell_exec("ipconfig/all"));
        $i=0;
        $macs=array();
        foreach ($d as $key => $value) {
            $d1 = explode(':', $d[$i]);
            $d2 = explode(' ', $d1[1]);
            $macs[]= $d2[1];
            $i++;
        }
        
        $pc_macAddress = $macs;
        
        foreach ($pc_macAddress as $key => $pc_macAddr) {
            $pc_macAddr = str_replace("\n", "", $pc_macAddr);
            
            $Sample_location_mac_address = Sample_location_mac_address::where('mac', $pc_macAddr)->first();
            
            if ($Sample_location_mac_address) {
                $sample_location_requests = sample_location_requests::where('id', $Sample_location_mac_address->sampleLocReq_id)->where('request_status', 1)->first();
                if ($sample_location_requests) {
                    $sample_location_branch = Processing_units::where('id', $sample_location_requests->processing_units_id)->first();
                    break;
                }
            }
        }
        
        return view('administration.samples.sampleLocation.receive_sample', compact('sample_location_branch', 'sample_location_requests', 'Sample_location_mac_address'));
    }

    public function receive_Sample_barcode($Sample_barcode, $sample_location_id)
    {
        $samples_services=[];
        $samble_status=['Ordered','Collected','Pre-analytical','Received'];

        //get this processing unit defualt samble status
        $sample_location = sample_location_requests::where('id', $sample_location_id)->first();

        $registration_samples_barcodes=registration_samples_barcodes::where('sample_barcode', $Sample_barcode)->first();
        if ($registration_samples_barcodes) {
            //update sample status
            //chaeck sample id previous_status and updated with the current_status
            if ($sample_location->previous_status==$registration_samples_barcodes->samples_barcode_status) {
                $registration_samples_barcodes->update([
                    'samples_barcode_status' => $sample_location->current_status,
                ]);
                //update sample services status
                $registration_samples_barcode_services=registration_samples_barcode_services::where('samples_barcode_id', $registration_samples_barcodes->id)->get();
                foreach ($registration_samples_barcode_services as $key => $registration_samples_barcode_service) {
                    $samples_services[]=$registration_samples_barcode_service->service->name_en;
                    $registration_samples_barcode_service->update([
                        'service_status' => $sample_location->current_status,
                    ]);
                   //update sample services tests status
                    $reg_samples_barcode_servs_tests=reg_samples_barcode_servs_test::where('rsbs_id', $registration_samples_barcode_service->id)->get();
                    foreach ($reg_samples_barcode_servs_tests as $key => $reg_samples_barcode_servs_test) {
                        $reg_samples_barcode_servs_test->update([
                            'test_status' => $sample_location->current_status,
                        ]);
                    }
                }
 
                $registrations_details=registrations_details::where('acc', $registration_samples_barcodes->acc)->first();

                $final_result=[
                    'status'=>1,
                    'patient_name'=>$registrations_details->patient->patient_name,
                    'gender'=>$registrations_details->patient->gender,
                    'acc'=>$registrations_details->acc,
                    'registrationDate'=>date($registrations_details->created_at),
                    'samples_services'=>$samples_services,
                    'msg'=>'The sample is transformed successfully.'
                ];

                //save this transaction on sample traking transactions
                sample_traking_transactions::create([
                    'sample_status' => $sample_location->current_status,
                    'rsb_id' => $registration_samples_barcodes->id,
                    'location_id' => $registration_samples_barcodes->processing_unit_id,
                    'Created_by' => (Auth::user()->id),
                    'analyzer_id' => 0,
                ]);

                return json_encode($final_result);
            } else {
                $previous_status_count;
                $samples_barcode_status_current_count;
                $msg='';
                foreach ($samble_status as $key => $samble_statu) {
                    if ($samble_statu==$sample_location->previous_status) {
                        $previous_status_count=$key;
                        break;
                    }
                }
                foreach ($samble_status as $key => $samble_statu) {
                    if ($samble_statu==$registration_samples_barcodes->samples_barcode_status) {
                        $samples_barcode_status_current_count=$key;
                        break;
                    }
                }
                if ($samples_barcode_status_current_count<$previous_status_count) {
                    $msg='The current location is transforming sample form '.$sample_location->previous_status.' to '.$sample_location->current_status.' and the current sample status is not '.$sample_location->previous_status;
                } else {
                    $msg='This sample has been processed in this location before.';
                }
              
                $final_result=[
                    'status'=>0,
                    'msg'=>$msg,
                ];

                return json_encode($final_result);
            }
        } else {
            $final_result=[
                'status'=>0,
                'msg'=>'No data found!!',
            ];

            return json_encode($final_result);
        }
       
        //session()->flash('Edit', "Sample location request status were changed successfully!!");
       
        // return redirect()->back();
    }
}
