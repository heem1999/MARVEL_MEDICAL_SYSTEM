<?php

namespace App\Http\Livewire\Tools;

use Livewire\Component;

use Illuminate\Support\Facades\Validator;
use  Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Session;
use PDF;
use Dompdf\Dompdf;
use Dompdf\Options;

use App\registrations;
use App\Services;
use App\Payers;
use App\Payer_contracts;
use App\Contracts_price_list_settings;
use App\Contract_branches;
use App\Price_lists;
use App\Price_list_services;
use App\Service_tests;
use App\AssignSerToProUnits;
use App\service_nested_services;
use App\Test_branch_samples_branches;
use App\registered_serv_prices;
use App\registrations_details;
use App\registration_samples_barcodes;
use App\registration_samples_barcode_services;
use App\cancel_reasons;
use App\registration_payment_transaction;
use App\Processing_units;
use App\reg_samples_barcode_servs_test;
use App\Branches;
use App\Units;
use App\Tests_configurations_numeric;
use App\Tests_configurations_option_list;
use App\result_clutuer_org_antis;
use App\result_clutuer_tests;
use App\antibiotics;
use App\organisms;
use App\Sample_traking_transactions;


class Tools extends Component
{
    public $default_sample_barcode=10000;

    public $page= '';
    public $Sample_ID;
    public $ACC;
    public $registration_details_data;
    public $selected_processing_units_id='';
    public $defalt_processing_units_id;
    public $SelectedBranch;
    public $processing_units;
    public $branches;
    public $SamplesTests=[];
    public $new_sample_barcode;
    public $old_registration_samples_barcodes_id;
    public $selected_SamplesTests;
    
    
    public function mount()
    {
        $page=request('pagename');
        if (!$this->page) {
            $this->page=$page;
        }
        if ($page=='change_processing_unit') {
            $this->page=$page;
        }

        if ($page=='sample_plitting') {
            $this->page=$page;
        }

      


        $this->Sample_ID='';
        $this->registration_details_data=[];
        $this->selected_processing_units_id='';

        $this->SamplesTests=[];
        $this->new_sample_barcode=null;
        $this->old_registration_samples_barcodes_id=null;
        $this->selected_SamplesTests=[];
    }

    public function get_sample_ID_DATA()
    {
        $this->branches = Branches::all();
        $this->processing_units = Processing_units::all();

        $this->registration_details_data=[];
        session()->flash('Error', null);
        if ($this->Sample_ID) {
            $this->registration_details_data=[];

            $registration_samples_barcodes=registration_samples_barcodes::where('sample_barcode', $this->Sample_ID)->first();

            if ($registration_samples_barcodes) {
                $registration_samples_barcode_services=registration_samples_barcode_services::where('samples_barcode_id', $registration_samples_barcodes->id)->get();
                foreach ($registration_samples_barcode_services as $key => $registration_samples_barcode_service) {
                    $samples_services[]=$registration_samples_barcode_service->service->name_en;
                    $reg_samples_barcode_servs_tests[]=reg_samples_barcode_servs_test::where('rsbs_id', $registration_samples_barcode_service->id)->get();
                }
                $x=[];
                foreach ($reg_samples_barcode_servs_tests as $key => $variable) {
                    foreach ($variable as $key => $value) {
                        $x[]= $value;
                    }
                }
                $reg_samples_barcode_servs_tests=$x;

                $registrations_details=registrations_details::where('acc', $registration_samples_barcodes->acc)->first();
                $final_result=array('registration_detail'=>$registrations_details,
                'sample_barcode'=>$registration_samples_barcodes,
                'samples_services'=>$samples_services,
                'samples_tests'=>$reg_samples_barcode_servs_tests,
        );
                $this->registration_details_data=$final_result;
                $defalt_processing_units_id=$this->registration_details_data['sample_barcode']->Processing_unit->id;
                $this->defalt_processing_units_id=$defalt_processing_units_id;

                //get branch id
                $processing_units_branch = Processing_units::where('id', $defalt_processing_units_id)->first();
                $this->SelectedBranch=(string)$processing_units_branch->branch_id;

                $this->updatedSelectedBranch();
            } else {
                $this->registration_details_data=[];
                session()->flash('Error', 'Not found sample ID.');
            }
        } else {
            session()->flash('Error', 'Please enter the sample ID.');
        }
    }

    public function updatedSelectedBranch()
    {
        $this->selected_processing_units_id=' ';
        $this->processing_units= [];
        $this->processing_units = Processing_units::where('branch_id', $this->SelectedBranch)->get();

        foreach ($this->processing_units as  $value) {
            if ($this->defalt_processing_units_id==$value->id) {
                $this->selected_processing_units_id=$value->id;
            }
        }
    }


    public function Save_data()
    {
        //dd($this->selected_processing_units_id,$this->defalt_processing_units_id);
        session()->flash('Error', null);
        session()->flash('Add', null);
        if ($this->selected_processing_units_id>0&&$this->selected_processing_units_id<>$this->defalt_processing_units_id) {
            $defualt_samble_status= Processing_units::where('id', $this->selected_processing_units_id)->first();

            $registration_samples_barcodes=registration_samples_barcodes::where('sample_barcode', $this->Sample_ID)->first();
            $registration_samples_barcodes->update([
                'processing_unit_id'=>$this->selected_processing_units_id,
                'samples_barcode_status'=>$defualt_samble_status->defualt_samble_status,
            ]);
            $this-> get_sample_ID_DATA();
            session()->flash('Add', 'The processing unit changed successfully!!');
        } else {
            session()->flash('Error', "You haven't made any modification.");
        }
    }

    public function get_sample_plitting_DATA()
    {
        session()->flash('Error', null);
        $this->registration_details_data=[];
        $this->new_sample_barcode=null;
        
        if ($this->Sample_ID) {
            $registration_samples_barcodes=registration_samples_barcodes::where('sample_barcode', $this->Sample_ID)->first();

            if ($registration_samples_barcodes) {
                $registration_samples_barcode_services=registration_samples_barcode_services::where('samples_barcode_id', $registration_samples_barcodes->id)->get();
                foreach ($registration_samples_barcode_services as $key => $registration_samples_barcode_service) {
                    $samples_services[]=$registration_samples_barcode_service->service->name_en;
                    $reg_samples_barcode_servs_tests[]=reg_samples_barcode_servs_test::where('rsbs_id', $registration_samples_barcode_service->id)->get();
                }

                $x=[];
                foreach ($reg_samples_barcode_servs_tests as $key => $variable) {
                    foreach ($variable as $key => $value) {
                        $x[]= $value;
                    }
                }
                $reg_samples_barcode_servs_tests=$x;

                $registrations_details=registrations_details::where('acc', $registration_samples_barcodes->acc)->first();
                $defalt_processing_units_id=$registration_samples_barcodes->Processing_unit->id;
                //get branch id
                $processing_units_branch = Processing_units::where('id', $defalt_processing_units_id)->first();
                $BranchName=Branches::where('id', $processing_units_branch->branch_id)->first();

                $final_result=array('registration_detail'=>$registrations_details,
                'sample_barcode'=>$registration_samples_barcodes,
                'samples_services'=>$samples_services,
                'samples_tests'=>$reg_samples_barcode_servs_tests,
                'BranchName'=>$BranchName
        );
                //clear last tests_ids
                $this->SamplesTests=[];
                $this->selected_SamplesTests=[];
                $this->old_registration_samples_barcodes_id=$registration_samples_barcodes->id;

                foreach ($reg_samples_barcode_servs_tests as  $value) {
                    $this->selected_SamplesTests[]=$value['test']['id'];
                    $this->SamplesTests[]=$value['test']['id'];
                }

                $this->registration_details_data=$final_result;
            } else {
                $this->registration_details_data=[];
                session()->flash('Error', 'Not found sample ID.');
            }
        } else {
            session()->flash('Error', 'Please enter the sample ID.');
        }
    }

    public function Save_sample_plitting()
    {
        session()->flash('Error', null);
        session()->flash('Add', null);
        //$this->old_registration_samples_barcodes_id
        if ((count($this->SamplesTests)>0)) {
            if ((count($this->SamplesTests) < count($this->selected_SamplesTests))) {
                //creat sample id(barcode for group of processing_unit)
                $this->new_sample_barcode =$this->sample_Barcode();

                $registration_samples_barcodes=registration_samples_barcodes::where('sample_barcode', $this->Sample_ID)->first();
                $processing_unit_id=$registration_samples_barcodes->processing_unit_id;

                $defualt_samble_status= Processing_units::where('id', $processing_unit_id)->first();
                registration_samples_barcodes::create([
                    'acc'=>$registration_samples_barcodes->acc,
                    'sample_barcode'=> $this->new_sample_barcode,
                    'processing_unit_id'=>$processing_unit_id,
                    'samples_barcode_status'=>$defualt_samble_status->defualt_samble_status,
                ]);

                //get the new id created perviouslly
                $new_sample_barcode_id= registration_samples_barcodes::where('sample_barcode', $this->new_sample_barcode)->first();
                $new_sample_barcode_id=$new_sample_barcode_id->id;

                //save this transaction on sample traking transactions
                Sample_traking_transactions::create([
                    'sample_status' => $defualt_samble_status->defualt_samble_status,
                    'rsb_id' => $new_sample_barcode_id,
                    'location_id' => 0,//that is mean the loaction is registration desk
                    'Created_by' => (Auth::user()->id),
                    'analyzer_id' => 0,
                ]);

                //update test services and tests table

                $registration_samples_barcode_services=registration_samples_barcode_services::where('samples_barcode_id', $this->old_registration_samples_barcodes_id)->get();

                foreach ($registration_samples_barcode_services as $key => $registration_samples_barcode_service) {
                    $reg_samples_barcode_servs_tests=reg_samples_barcode_servs_test::where('rsbs_id', $registration_samples_barcode_service->id)->whereIn('test_id', $this->SamplesTests)->count();
                    if ($reg_samples_barcode_servs_tests>0) {
                        $registration_samples_barcode_service->update([
                            'samples_barcode_id' => $new_sample_barcode_id,
                        ]);
                    }
                }
                
                session()->flash('Add', 'Sample test split successfully.!!');
            } else {
                session()->flash('Error', "You can't split all tests.");
            }
        } else {
            session()->flash('Error', "Please select at least one test you want to split.");
        }
    }


    public function sample_Barcode()
    {
        $last_sample_id= registration_samples_barcodes::orderBy('created_at', 'DESC')->first();
        if ($last_sample_id) {
            $new_sample_id= $last_sample_id->id+1;
        } else {
            $new_sample_id= 1;
        }

        $number =$this->default_sample_barcode+$new_sample_id;

        return $number;
    }


    public function render()
    {
        return view('livewire.tools.tools');
    }
}
