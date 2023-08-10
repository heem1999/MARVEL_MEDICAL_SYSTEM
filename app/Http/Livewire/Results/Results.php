<?php

namespace App\Http\Livewire\Results;

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

class Results extends Component
{
    protected $listeners = ['update_cultuer_test' => 'get_service_tests'];

    public $query;
    public $contacts;
    public $highlightIndex;
    public $ACC;
    public $Payer_placeholder;
    public $queryPayer;
    public $payers;
    public $payer_contracts=[];
    public $selected_contract;
    public $dateFrom;
    public $dateTo;
    public $branches;
    public $branch_id;
    public $Patient_id;
    public $Mobile_Number;
    public $registration_details=[];
    public $registration_detail=[];
    public $patient_placeholder;
    public $search_clicked=false;
    public $Search_By_Sample_ID=false;
    public $Sample_ID;
    public $service_tests=[];
    public $reg_samples_barcode_servs_test=[];
    public $Units=[];
    public $tests_configurations_numeric=[];
    public $Tests_configurations_option_list=[];
    public $selected_clinicla_unit;
    //save values
    public $test_result= [];
    public $index_patient= 0;
    public $show_sample_ids= [];
    //delevry result
    public $patient_data=[];
    public $page= '';
    public $Delivery_Details_ACC= '';
    public $patient_services;
    public $total_amout=0;
    public $total_cash=0;
    public $total_credit=0;
    public $Discount_mark='';
    public $test_comment='';
    public $test_comment_type='';
    public $test_name='';
    public $can_print_result=false;
    public $selected_test_comment_id='';
    public $antibiotics;
    public $organisms;
    
    public $selected_organism='';
    public $selected_antibiotics=[];
    public $result_clutuer_org_antis=[];
    public $result_clutuer_tests=[];
    public $selected_sensitivity='';
    public $selected_modifier=[];

    public $selected_clinical_color='';
    public $Cultuer_test_comment='';
    
    public $SampleTrack_data=[];
    public $xx=0;
    public $show_regisration_comment=false;
    
    //pdf option
    public $generalOptions=['footer-center'=>'[page]','footer-left'=>'All Rights Reseved © Dara Solutions','footer-right'=>'Powered by LMS www.dara.sd','header-right'=>'Printed date: [time] [date]','header-line'=>true,'footer-line'=>true,'footer-font-size'=>7,'header-font-size'=>7];

    public $last_tests_results=false;
    public $current_tests= [];

    public $processing_units= [];
    public $selected_processing_units_id;

    public $registration_samples_barcode_services = [];
    public $registration_samples_barcodes= [];
    public $quickEdit=1;
    public $Error_permisson='';
    public function mount()
    {
        $this->Error_permisson='';
        $this->selected_processing_units_id = null;
        $this->processing_units= [];
        $this->show_sample_ids= [];
        $this->current_tests= [];
        $this->dateFrom = '';
        $this->test_comment = '';
        $this->selected_test_comment_id = '';
        $this->can_print_result=false;
        $this->dateTo = '';
        $this->ACC='';
        $this->branches = Branches::all();
        $this->Mobile_Number='';
        $this->branch_id='';
        $this->Patient_id='';

        $this->registration_details=[];
        $this->registration_detail=[];
        
        $this->show_regisration_comment=false;

        $this->reset_values();
        $this->reset_queryPayer();
        $this->search_clicked=false;
        $this->index_patient= 0;

        $this->quickEdit=1;
        $page=request('pagename');
        if (!$this->page) {
            $this->page=$page;
        }
        

        if ($page=='Delivery_Details') {
            $this->can_print_result=false;
            $this->page=$page;
            $this->Delivery_Details_ACC=request('acc');
            $this->get_jobOrder_services($this->Delivery_Details_ACC);
        }
        if ($page=='Culture_result') {
            $this->page=$page;
            $this->Culture_result(request('rsbst_id'));
        }
        if ($page=='SampleTrack') {
            $this->page=$page;
            $this->SampleTrack(request('rsb_id'));
        }
        
        if ($page=='WorkLists') {
            $this->page=$page;
            $this->registration_samples_barcodes=registration_samples_barcodes::all();
            $this->registration_samples_barcode_services=registration_samples_barcode_services::all();
        }

        if (request('pagename1')=='quickEdit') {
            $this->quickEdit=0;
            $this->ACC=request('acc');
            $this->searchData();
        }
    }

    public function reset_values()
    {
        $this->patient_placeholder='';
        $this->query='';
    }
    public function reset_queryPayer()
    {
        $this->payer_contracts=[];
        $this->selected_contract='';
        $this->payers=[];
        $this->queryPayer='';
        $this->Payer_placeholder ='';
        $this->registration_details=[];
        $this->service_tests=[];
        $this->reg_samples_barcode_servs_test=[];
    }

    public function incrementHighlight()
    {
        if ($this->highlightIndex === count($this->contacts) - 1) {
            $this->highlightIndex = 0;
            return;
        }
        $this->highlightIndex++;
    }
 
    public function decrementHighlight()
    {
        if ($this->highlightIndex === 0) {
            $this->highlightIndex = count($this->contacts) - 1;
            return;
        }
        $this->highlightIndex--;
    }
 

    public function updatedQuery()
    {
        $this->contacts=null;
        if (Str::length($this->query) >= 1) {
            $this->contacts = registrations::where('patient_name', 'like', '%' . $this->query . '%')->orWhere('phone', 'like', '%'.$this->query. '%')->orWhere('patient_no', 'like', '%'.$this->query. '%')->get();
            if (count($this->contacts) == 0) {
                $this->contacts =null;
            }
        }
    }

    public function updatedQueryPayer()
    {
        $this->payers =null;
       
        if (Str::length($this->queryPayer) >= 1) {
            $this->payers = Payers::where('name_en', 'like', '%' . $this->queryPayer . '%')->orWhere('code', 'like', '%'.$this->queryPayer. '%')->get();
            if (count($this->payers) == 0) {
                $this->payers =null;
            }
        }
    }

  

    public function selectedPatient($Patient)
    {
        $this->Patient_id= $Patient['id'];
        $this->patient_placeholder= $Patient['patient_no'].' - '.$Patient['patient_name'];
        $this->query='';
        $this->searchData();
    }

    public function get_Payer_Contract($i, $Payer_id)
    {
        $this->payer_contracts=[];
        $this->selected_contract='';
        $this->Payer_placeholder = $this->payers[$i]['code'];
        $this->payer_contracts = Payer_contracts::where('payer_id', $this->payers[$i]['id'])->get();
        $this->queryPayer='';
    }

    public function searchData()
    {
        $this->Error_permisson='';
        $this->index_patient= 0;
        $this->show_sample_ids= [];
        $this->registration_details=[];
        $this->registration_detail=[];
        $this->show_regisration_comment=false;

        session()->flash('Error', null);
        $this->search_clicked=false;
        
        if ($this->Mobile_Number) {//search by mobile overwirte othe search cratiria
            $registrations=registrations::where('phone', $this->Mobile_Number)->orderBy('created_at', 'ASC')->get();
            $patient_ids=[];
            foreach ($registrations as $key => $value) {
                $patient_ids[]=$value['id'];
            }
            $this->registration_details= registrations_details::whereIn('patient_id', $patient_ids)->orderBy('created_at', 'ASC')->get();
        } else {
            $x=['acc'=>$this->ACC,'patient_id'=> $this->Patient_id,'branch_id'=> $this->branch_id,'contract_id'=>$this->selected_contract];
    
            if (!$this->ACC) {
                unset($x['acc']);
            }
            if (!$this->Patient_id) {
                unset($x['patient_id']);
            }
            if (!$this->branch_id) {
                unset($x['branch_id']);
            }
            if (!$this->selected_contract) {
                unset($x['contract_id']);
            }
            if (!$this->selected_contract) {
                unset($x['contract_id']);
            }
            if ($x && $this->dateFrom=='') {
                $this->registration_details=registrations_details::where($x)->orderBy('created_at', 'ASC')->get();
            } elseif ($this->dateFrom) {
                $dateFrom=Carbon::parse(Carbon::parse($this->dateFrom)->toDateString())->format('Y-m-d');
                $time = strtotime($dateFrom);
                $dateFrom = date('Y-m-d 00:00', $time);
                $dateFrom_to = date('Y-m-d 23:59', $time);
        
                if ($this->dateTo) {
                    $dateTo=Carbon::parse(Carbon::parse($this->dateTo)->toDateString())->format('Y-m-d');
                    $time = strtotime($dateTo);
                    $dateTo = date('Y-m-d 23:59', $time);
                    $this->registration_details=registrations_details::whereBetween('created_at', [$dateFrom, $dateTo])->where($x)->orderBy('created_at', 'ASC')->get();
                   
                } else {
                    $this->registration_details=registrations_details::whereBetween('created_at', [$dateFrom, $dateFrom_to])->where($x)->orderBy('created_at', 'ASC')->get();
                }
            }
        }
     
    
        if (count($this->registration_details)>0) {
            $this->search_clicked=true;
            $this->registration_detail=$this->registration_details[$this->index_patient];
            
            $this->get_samples_ID_DATA_by_ACC($this->registration_detail->acc);
        } else {
            session()->flash('Error', 'No data found.');
        }

        
    }

    public function Previous()
    {
        $this->index_patient--;
        $this->registration_detail=$this->registration_details[$this->index_patient];
        $this->get_samples_ID_DATA_by_ACC($this->registration_detail->acc);
    }

    public function Next()
    {
        $this->index_patient++;
        
        $this->registration_detail=$this->registration_details[$this->index_patient];
        $this->get_samples_ID_DATA_by_ACC($this->registration_detail->acc);
    }
    public function Edit_search()
    {
        $this->Error_permisson='';
        $this->registration_details=[];
        $this->registration_detail=[];
        $this->search_clicked=false;
        $this->Sample_ID=null;
    }

    public function get_samples_ID_DATA_by_ACC($acc)
    {
        $this->reg_samples_barcode_servs_test=[];
        $this->Units=Units::all();
        $this->test_result=[];
        $this->show_sample_ids= [];
        $service_tests=[];
        $service_tests_finals=[];
        $this->service_tests=[];
        $this->test_comment = '';
        $this->selected_test_comment_id = '';
        $this->test_name = '';
        
        $registration_samples_barcodes=registration_samples_barcodes::where('acc', $acc)->get();
        foreach ($registration_samples_barcodes as $key => $rsb) {
            $this->show_sample_ids[]=$rsb->sample_barcode;
            //samples_barcode_status
            $registration_samples_barcode_services=registration_samples_barcode_services::where('samples_barcode_id', $rsb->id)->get();
            foreach ($registration_samples_barcode_services as $key => $registration_samples_barcode_service) {
                //get the services tests
                $rsbs_id=$registration_samples_barcode_service->id;
                $x=['service_tests'=>reg_samples_barcode_servs_test::where('rsbs_id', $rsbs_id)->get(),'clinical_unit'=>$registration_samples_barcode_service->service->clinical_unit->name_en];
                $service_tests[]=$x;
            }
        }
        $service_tests = collect($service_tests)->groupBy('clinical_unit');
        $xx=[];
                    
        $cc=['test_result'=>'','unit'=>'','from'=>'','to'=>'','non_num_ref'=>'','analyzer_id'=>'','test_status'=>'','test_comment'=>''];
        $show_first_key='';
        foreach ($service_tests as $key => $service_test) {
            if ($show_first_key=='') {
                $show_first_key=$key;
            }
            $xx=[];
            foreach ($service_test as $key1=> $value) {
                $xx[]=$value['service_tests'];
                $this->test_result[]=$cc;
            }
            $service_tests_finals[]=[$key=> $xx];
        }
        // dd($service_tests_finals);
        $this->service_tests =$service_tests_finals;
       
        $this->get_service_tests($show_first_key) ;
    }

    public function get_sample_ID_DATA()
    {
        $this->reg_samples_barcode_servs_test=[];
        $this->Units=Units::all();
        $this->test_result=[];

        $this->registration_details=[];
        $this->registration_detail=[];

        session()->flash('Error', null);
        if ($this->Sample_ID) {
            $service_tests=[];
            $service_tests_finals=[];
            $this->show_sample_ids=[];
            $this->search_clicked=true;
            $this->index_patient=0;

            $registration_samples_barcodes=registration_samples_barcodes::where('sample_barcode', $this->Sample_ID)->first();
            if ($registration_samples_barcodes) {
                $this->show_sample_ids[]=$registration_samples_barcodes->sample_barcode;
                //samples_barcode_status
                $registration_samples_barcode_services=registration_samples_barcode_services::where('samples_barcode_id', $registration_samples_barcodes->id)->get();
                //to show samples ids on top of table
                
                foreach ($registration_samples_barcode_services as $key => $registration_samples_barcode_service) {
                    // $this->service_tests[]=$registration_samples_barcode_service->service;//->name_en;
                    //get the services tests
                    $rsbs_id=$registration_samples_barcode_service->id;
                   
                    $x=['service_tests'=>reg_samples_barcode_servs_test::where('rsbs_id', $rsbs_id)->get(),'clinical_unit'=>$registration_samples_barcode_service->service->clinical_unit->name_en];
                    $service_tests[]=$x;
                }
                // reg_samples_barcode_servs_test
                $service_tests = collect($service_tests)->groupBy('clinical_unit');
                $xx=[];
                
                $cc=['test_result'=>'','unit'=>'','from'=>'','to'=>'','non_num_ref'=>'','analyzer_id'=>'','test_comment'=>''];
                $show_first_key='';
                foreach ($service_tests as $key => $service_test) {
                    if ($show_first_key=='') {
                        $show_first_key=$key;
                    }
                    $xx=[];
                    foreach ($service_test as $key1=> $value) {
                        $xx[]=$value['service_tests'];
                        $this->test_result[]=$cc;
                    }
                    $service_tests_finals[]=[$key=> $xx];
                }
                 
                $this->service_tests =$service_tests_finals;
                // dd($this->service_tests);
                $this->registration_details=registrations_details::where('acc', $registration_samples_barcodes->acc)->get();
                $this->registration_detail=$this->registration_details[0];

                
                //to show the containt of the first clinical unit
                $this->get_service_tests($show_first_key) ;
            } else {
                session()->flash('Error', 'No data found.');
            }
        } else {
            session()->flash('Error', 'Please enter the sample ID.');
        }
    }

    public function get_service_tests($clinical_unit)
    {
        $this->test_comment = '';
        $this->selected_test_comment_id = '';
        $this->test_name = '';
        $this->selected_clinical_color=$clinical_unit;

        $rsbst_ids=[];
        $rsbs_ids=[];
        $this->tests_configurations_numeric=tests_configurations_numeric::all();
        $this->Tests_configurations_option_list=Tests_configurations_option_list::all();
        $this->selected_clinicla_unit=$clinical_unit;
       
        foreach ($this->service_tests as $key => $value) {
            if ($key==$clinical_unit) {
                foreach ($value as $key1 => $value1) {
                    foreach ($value1 as $key1 => $value2) {
                        foreach ($value2 as $key1 => $value3) {
                            $rsbs_ids[]=$value3['rsbs_id'];
                            $rsbst_ids[]=$value3['id'];
                        }
                    }
                }
            }
        }
        // get the processing unit barcodes
        $rsbs= registration_samples_barcode_services::whereIn('id', $rsbs_ids)->get('samples_barcode_id');
        $this->show_sample_ids= registration_samples_barcodes::whereIn('id', $rsbs)->get();
       
        $this->reg_samples_barcode_servs_test= reg_samples_barcode_servs_test::whereIn('id', $rsbst_ids)->get();
        
        //auto fill field
        foreach ($this->reg_samples_barcode_servs_test as $key => $value) {
            //get the test configurations type ['Numeric','Optional List' ,'Culture' ];
            
           
            if ($value->test->test_type=='Numeric') {
                if ($value->non_num_ref) {
                    $this->test_result[$key]['non_num_ref']= $value->non_num_ref;
                } else {
                    if (count(tests_configurations_numeric::where('test_id', $value->test_id)->get())>0) {
                        $this->test_result[$key]['non_num_ref']= tests_configurations_numeric::where('test_id', $value->test_id)->where('gender', $this->registration_details[0]['patient']->gender)->first();
                        if (!$this->test_result[$key]['non_num_ref']) {
                            if(count(tests_configurations_numeric::where('test_id', $value->test_id)->get())>0){
                                $this->test_result[$key]['non_num_ref']= tests_configurations_numeric::where('test_id', $value->test_id)->where('gender', 'All')->first()->reference_range_comment;
                            }
                            
                        } else {

                            $this->test_result[$key]['non_num_ref']= tests_configurations_numeric::where('test_id', $value->test_id)->where('gender', $this->registration_details[0]['patient']->gender)->first()->reference_range_comment;
                        }
                    }
                    
                }

                if ($value->unit) {
                    $this->test_result[$key]['unit']= $value->unit;
                } else {
                    if (count(tests_configurations_numeric::where('test_id', $value->test_id)->get())>0) {
                        
                        $this->test_result[$key]['unit']= tests_configurations_numeric::where('test_id', $value->test_id)->first()->test->unit->name_en;
                    }
                    
                }
                
                if ($value->from) {
                    $this->test_result[$key]['from']= $value->from;
                } else {
                    if (count(tests_configurations_numeric::where('test_id', $value->test_id)->get())>0) {
                    $this->test_result[$key]['from']= tests_configurations_numeric::where('test_id', $value->test_id)->first()->range_From;
                    }
                }

                if ($value->to) {
                    $this->test_result[$key]['to']= $value->to;
                } else {
                    if (count(tests_configurations_numeric::where('test_id', $value->test_id)->get())>0) {
                    $this->test_result[$key]['to']= tests_configurations_numeric::where('test_id', $value->test_id)->first()->range_To;
                }
            }

                if ($value->result) {
                    $this->test_result[$key]['test_result']= $value->result;
                }
                
            } elseif ($value->test->test_type=='Optional List') {
                if ($value->result) {
                    $this->test_result[$key]['test_result']= $value->result;
                }
            } elseif ($value->test->test_type=='Culture') {
            }
            
        }
        
        $this->Patient_Last_Results();
    }

    public function save_test_result($rsbst_id, $rsbs_id, $key, $ops)
    {
       
        $this->Error_permisson='';
      
        $reg_samples_barcode_servs_test = reg_samples_barcode_servs_test::findOrFail($rsbst_id);
        
        if ($ops=='Save') {
            if (Auth::user()->can('Save')) {
                $reg_samples_barcode_servs_test->update([
                'result'=>$this->test_result[$key]['test_result'],
                'unit'=>$this->test_result[$key]['unit'],
                'from'=>$this->test_result[$key]['from'],
                'to'=>$this->test_result[$key]['to'],
                'non_num_ref'=>$this->test_result[$key]['non_num_ref'],
                //'analyzer_id'=>$this->test_result[$key]['analyzer_id'],
                'test_status'=>'Verified',
                'saved_by' => (Auth::user()->id),
            ]);
            } else {
                $this->Error_permisson='Sorry, You do not have permission to Save this result .';
            }
        }
        if ($ops=='Review') {
            if (Auth::user()->can('Review')) {
                $reg_samples_barcode_servs_test->update([
                'result'=>$this->test_result[$key]['test_result'],
                'unit'=>$this->test_result[$key]['unit'],
                'from'=>$this->test_result[$key]['from'],
                'to'=>$this->test_result[$key]['to'],
                'non_num_ref'=>$this->test_result[$key]['non_num_ref'],
                //'analyzer_id'=>$this->test_result[$key]['analyzer_id'],
                'test_status'=>'Reviewed',
                'reviewed_by' => (Auth::user()->id),
            ]);
                //check if all service tests is Reviewed or not to update the service status
                $dont_review_ids=[];
                //to change service status from pendding to review
                foreach ($this->show_sample_ids as $value) {
                  
                    $registration_samples_barcode_services=registration_samples_barcode_services::where('samples_barcode_id', $value->id)->get();
                    
                    foreach ($registration_samples_barcode_services as $value1) {
                        $reg_samples_barcode_servs_test_count = reg_samples_barcode_servs_test::where('rsbs_id', $value1->id)->where('test_status', 'Reviewed')->count();
                        if ($reg_samples_barcode_servs_test_count==0) {
                            $dont_review_ids[]=$value1->id;
                        }
                    }
                  
                    //remove services on processing in lab
                        $registration_samples_barcode_services=$registration_samples_barcode_services->whereNotIn('id',$dont_review_ids);
                            //review this services only
                        foreach ($registration_samples_barcode_services as $x) {
                                $x->update([
                                    'service_status'=>'Reviewed',
                                    'updated_by' => (Auth::user()->id),
                                ]);
                        }
                }
               
            } else {
                $this->Error_permisson='Sorry, You do not have permission to Review this result .';
            }
        }
        if ($ops=='Undo Review') {
            $reg_samples_barcode_servs_test->update([
                'test_status'=>'Verified',
                'reviewed_by' => (Auth::user()->id),
            ]);

            $registration_samples_barcode_services = registration_samples_barcode_services::findOrFail($rsbs_id);
            $registration_samples_barcode_services->update([
                'service_status'=>'Received',
                'updated_by' => (Auth::user()->id),
            ]);
        }
        $this->get_service_tests($this->selected_clinicla_unit) ;
    }

   


    public function selected_test_comment($testData)
    {
        $this->test_name=$testData['test']['name_en'];
        $this->test_comment = $testData['test_comment'];
        $this->selected_test_comment_id = $testData['id'];
        $this->test_comment_type=$testData['test_comment_type'];
    }

    public function close_test_comment()
    {
        $this->test_comment = '';
        $this->selected_test_comment_id = '';
        $this->test_name= '';
    }

    public function toggle_test_comment_type()
    {
        if ($this->test_comment_type=='Result') {
            $this->test_comment_type='Lab';
        } else {
            $this->test_comment_type='Result';
        }
    }

    public function save_test_comment()
    {
      
       // session()->flash('Add', null);
        // $this->test_comment = nl2br($this->test_comment);
        if ($this->selected_test_comment_id!=='') {
            $reg_samples_barcode_servs_test = reg_samples_barcode_servs_test::findOrFail($this->selected_test_comment_id);
            $reg_samples_barcode_servs_test->update([
                'test_comment'=>$this->test_comment,
                'test_comment_type'=>$this->test_comment_type,
            ]);
            //   session()->flash('Add', 'Test comment saved successfully!! ');
        }
   
        $this->get_service_tests($this->selected_clinicla_unit) ;
        $this->test_comment = '';
        $this->selected_test_comment_id = '';
        $this->test_name= '';
    }
    
     
    public function Patient_Last_Results()
    {
        //get patient ACC's
        $registrations_details=registrations_details::where('patient_id', $this->registration_detail->patient->id)->get();
        $sample_barcodes_ids=[];
        $last_tests_results=[];
        $this->last_tests_results=false;
        $this->current_tests=[];

        foreach ($this->reg_samples_barcode_servs_test as $key => $current_test) {
            $this->current_tests[]=$current_test->test_id;
        }

        foreach ($registrations_details as $key => $registrations_detail) {
            $registration_samples_barcodes= registration_samples_barcodes::where('acc', $registrations_detail->acc)->get();
            foreach ($registration_samples_barcodes as $key => $registration_samples_barcode) {
                $sample_barcodes_ids[]= $registration_samples_barcode->id;
            }
        }
        
        foreach ($sample_barcodes_ids as  $samples_barcode_id) {
            $rsbs_ids=  registration_samples_barcode_services::where('samples_barcode_id', $samples_barcode_id)->get();
            foreach ($rsbs_ids as $key => $rsbs) {
                foreach ($this->reg_samples_barcode_servs_test as $key => $current_tests) {
                    $last_test=reg_samples_barcode_servs_test::where('rsbs_id', $rsbs->id)->where('test_id', $current_tests->test_id)->first();
                    //->where('id', '<>', $current_tests->id)
                    if ($last_test) {
                        //check if the test is Culture
                        if ($last_test->test->test_type !== 'Culture') {
                            $last_tests_results[]=$last_test;
                        }
                    }
                }
            }
        }
        if ($last_tests_results) {
            $this->last_tests_results=true;
        }
       
        // $this->current_tests = http_build_query(array('aParam' => $this->current_tests));
        
       /* $last_tests_results = collect($last_tests_results)->groupBy(function($item, $key) {
            return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item['created_at'])->format('d/m/Y');
        });*/
        //$this->last_tests_results = collect($last_tests_results)->groupBy('test_id');
        //dd($this->last_tests_results);
    }
    
    //Delivery_Details
    public function get_jobOrder_services($Delivery_Details_ACC)
    {
        session()->flash('Error', null);
        $this->registration_details = registrations_details::where('acc', $Delivery_Details_ACC)->first();
        
        if ($this->registration_details) {
            //get Patient details
            $this->patient_data = registrations::where('id', $this->registration_details->patient_id)->first();

            //get job order services details
            $patient_services = registered_serv_prices::where('acc', $Delivery_Details_ACC)->Where('isCanceled', false)->get();

            //calculate the total job order amount
            $this->total_amout=0;
            foreach ($patient_services as $key => $patient_service) {
                $this->total_amout=$this->total_amout+$patient_service['current_price'];
                // $this->total_cash=$this->total_cash+$patient_service['service_price_cash'];
       // $this->total_credit=$this->total_credit+$patient_service['service_price_credit'];
            }
        }
        $flag=0;
        $flag1=0;
        $registration_samples_barcodes=registration_samples_barcodes::where('acc', $Delivery_Details_ACC)->get();
        foreach ($registration_samples_barcodes as $key => $rsb) {
            $registration_samples_barcode_services=registration_samples_barcode_services::where('samples_barcode_id', $rsb->id)->get();
            foreach ($registration_samples_barcode_services as $key => $registration_samples_barcode_service) {
                if ($registration_samples_barcode_service->service_status=='Reviewed') {
                    $this->can_print_result=true;
                    $flag=1;
                }else{
                    $flag1=1; 
                }
                // $this->patient_services[]=$registration_samples_barcode_service;
                $rsbs_id=$registration_samples_barcode_service->id;
                $x=['service'=>$registration_samples_barcode_service,'clinical_unit'=>$registration_samples_barcode_service->service->clinical_unit->name_en];
                $this->patient_services[]=$x;
            }
        }
       
        if ($this->registration_details->remaining>0) {
            $this->can_print_result=false;
            session()->flash('Error', "Sorry, this patient should pay the remaining money.");
        }else{
            if ($this->can_print_result) {
                //$this->can_print_result=true;
                if($flag1!==0){//to show warring message that their is at least on service not reviewed
                    session()->flash('Error', "Be aware that not all the patient results are ready.");
                }
            }  else {
                session()->flash('Error', "Sorry, the patient results are not ready yet.");
               // $this->can_print_result=true;
            }
        }

       
    }

    
    public function Culture_result($rsbst_id)
    {
        $this->selected_organism='';
        $this->selected_antibiotics=[];
       
        $this->reg_samples_barcode_servs_test= reg_samples_barcode_servs_test::where('id', $rsbst_id)->first();
        $this->Cultuer_test_comment=$this->reg_samples_barcode_servs_test->test_comment;
        $this->antibiotics= antibiotics::all();
        $this->organisms= organisms::all();

        $this->result_clutuer_tests= result_clutuer_tests::where('rsbst_id', $rsbst_id)->get();
        $this->result_clutuer_org_antis= result_clutuer_org_antis::all();

        foreach ($this->result_clutuer_tests as $key1=> $value) {
            $this->selected_modifier[]='';
        }

    }

    public function SampleTrack($rsb_id)
    {
        $this->SampleTrack_data=[];

        $registration_samples_barcodes=registration_samples_barcodes::where('id', $rsb_id)->first();
       
        if ($registration_samples_barcodes) {

            $registration_samples_barcode_services=registration_samples_barcode_services::where('samples_barcode_id', $registration_samples_barcodes->id)->get();
            
            foreach ($registration_samples_barcode_services as $key => $registration_samples_barcode_service) {
                $samples_services[]=$registration_samples_barcode_service->service->name_en;
              /* 
               //update sample services tests status
                $reg_samples_barcode_servs_tests=reg_samples_barcode_servs_test::where('rsbs_id', $registration_samples_barcode_service->id)->get();
                foreach ($reg_samples_barcode_servs_tests as $key => $reg_samples_barcode_servs_test) {
                    $reg_samples_barcode_servs_test->update([
                        'test_status' => $sample_location->current_status,
                    ]);
                }*/
            }
            $registrations_details=registrations_details::where('acc', $registration_samples_barcodes->acc)->first();
            $sample_traking_transactions=sample_traking_transactions::where('rsb_id', $rsb_id)->orderBy('created_at', 'ASC')->get();
            $final_result=array('registrations_details'=>$registrations_details,
            'sample_barcode'=>$registration_samples_barcodes->sample_barcode,
            'samples_services'=>$samples_services,
        'sample_traking_transactions'=>$sample_traking_transactions);
          //  dd( $final_result);  
            $this->SampleTrack_data=$final_result;
           
        }else{
            $this->SampleTrack_data=[];
        }
       // 
       
      

    }

    
    public function add_antibiotics()
    {
        session()->flash('Error', null);
        if ($this->selected_organism && $this->selected_antibiotics&& $this->selected_sensitivity) {
            $result_clutuer_tests= result_clutuer_tests::where('rsbst_id', $this->reg_samples_barcode_servs_test->id)->where('organism_id', $this->selected_organism)->first();
            
            if (!$result_clutuer_tests) {
                result_clutuer_tests::create([
                    'rsbst_id' => $this->reg_samples_barcode_servs_test->id,
                    'organism_id' => $this->selected_organism,
                ]);
                $result_clutuer_tests= result_clutuer_tests::where('rsbst_id', $this->reg_samples_barcode_servs_test->id)->where('organism_id', $this->selected_organism)->first();

                foreach ($this->selected_antibiotics as $key => $antibiotic_id) {
                    result_clutuer_org_antis::create([
                        'rct_org_id' => $result_clutuer_tests->id,
                        'sensitivity' => $this->selected_sensitivity,
                        'antibiotic_id'=> $antibiotic_id,
                    ]);
                }
            } else {
                foreach ($this->selected_antibiotics as $key => $antibiotic_id) {
                    //check if antibiotic add befor
                    $result_clutuer_org_antis= result_clutuer_org_antis::where('rct_org_id', $result_clutuer_tests->id)->where('antibiotic_id', $antibiotic_id)->first();
              
                    if (!$result_clutuer_org_antis) {
                        result_clutuer_org_antis::create([
                        'rct_org_id' => $result_clutuer_tests->id,
                        'sensitivity' => $this->selected_sensitivity,
                        'antibiotic_id'=> $antibiotic_id,
                    ]);
                    }
                }
            }
            $this->selected_organism ='';
            $this->selected_antibiotics='';
            $this->selected_sensitivity='';
            $this->Culture_result($this->reg_samples_barcode_servs_test->id);
        } else {
            session()->flash('Error', 'The organism, sensitivity, and antibiotics fields are required!');
        }
        //dd($this->selected_antibiotics);
    }
    
    public function add_modifier($result_clutuer_test_id, $key)
    {
        $result_clutuer_tests = result_clutuer_tests::findOrFail($result_clutuer_test_id);
        $result_clutuer_tests->update([
            'modifier' => $this->selected_modifier[$key][''],
        ]);

        $this->Culture_result($this->reg_samples_barcode_servs_test->id);
    }

    public function save_test_result_Culture($rsbst_id, $rsbs_id, $ops)
    {
        $reg_samples_barcode_servs_test = reg_samples_barcode_servs_test::findOrFail($rsbst_id);
        if ($ops=='Save') {
            $reg_samples_barcode_servs_test->update([
                'test_comment'=>$this->Cultuer_test_comment,
                'test_status'=>'Verified',
                'saved_by' => (Auth::user()->id),
            ]);
        }
        if ($ops=='Review') {
            $reg_samples_barcode_servs_test->update([
                'test_comment'=>$this->Cultuer_test_comment,
                'test_status'=>'Reviewed',
                'reviewed_by' => (Auth::user()->id),
            ]);

             //check if all service tests is Reviewed or not to update the service status
                
                //to change service status from pendding to review
                foreach ($this->show_sample_ids as $value) {
                    $registration_samples_barcode_services=registration_samples_barcode_services::where('samples_barcode_id', $value->id)->get();
                    $i=0;
                    foreach ($registration_samples_barcode_services as $value1) {
                        $reg_samples_barcode_servs_test_count = reg_samples_barcode_servs_test::where('rsbs_id', $value1->id)->where('test_status', 'Reviewed')->count();
                        if ($reg_samples_barcode_servs_test_count==0) {
                            $i=1;
                            break;
                        }
                    }

                    if ($i==0) {
                        //$registration_samples_barcode_services= registration_samples_barcode_services::where('samples_barcode_id', $value->id)->get();
                        
                        foreach ($registration_samples_barcode_services as $x) {
                            $x->update([
                                'service_status'=>'Reviewed',
                                'updated_by' => (Auth::user()->id),
                            ]);
                        }
                    }
                }
           
        }
        if ($ops=='Undo Review') {
            $reg_samples_barcode_servs_test->update([
                'test_status'=>'Verified',
                'reviewed_by' => (Auth::user()->id),
            ]);
        }

        $this->Culture_result($rsbst_id);
    }


    public function delete_antibiotics($antibiotic_id)
    {
        result_clutuer_org_antis::findOrFail($antibiotic_id)->delete();
      
        $this->Culture_result($this->reg_samples_barcode_servs_test->id);
    }
    

    public function get_branch_Processing_Unit()
    {
        $this->selected_processing_units_id='';
        $this->processing_units=Processing_units::where('branch_id', $this->branch_id)->get();
    }
    
    public function getWorkList()
    {
        session()->flash('Error', null);
        $this->registration_details=[];
        $this->search_clicked=false;
        $flag=0;
        if ($this->dateFrom) {
            if ($this->dateTo) {               
                $this->dateFrom=Carbon::parse(Carbon::parse($this->dateFrom))->format('Y-m-d 00:00');
                $this->dateTo=Carbon::parse(Carbon::parse($this->dateTo))->format('Y-m-d 23:59');
           
                if ($this->selected_processing_units_id) {
                    $this->registration_details=registrations_details::whereBetween('created_at', [$this->dateFrom, $this->dateTo])->get();
                    $accs=[];
                    if(count( $this->registration_details)>0){
                        foreach ($this->registration_details as $key => $value) {
                            if(registration_samples_barcodes::where('acc', $value->acc)->count()>0){
                                array_push($accs,$value->acc);
                            }
                        }
                    }
                    $this->registration_details=$this->registration_details->whereIn('acc', $accs);
                   
                }else if ($this->branch_id) {
                    
                    $this->registration_details=registrations_details::whereBetween('created_at', [$this->dateFrom, $this->dateTo])->where('branch_id', $this->branch_id)->get();
                } else {
                    $this->registration_details=registrations_details::whereBetween('created_at', [$this->dateFrom, $this->dateTo])->get();
                }
            } else {
                session()->flash('Error', "Reg. date field (TO) is empty.");
            }
        } else if ($this->ACC>0) {
            $flag=1;
            $this->registration_details=registrations_details::where('acc',  $this->ACC)->get();
        }
        else {
            session()->flash('Error', "Reg. date field (From) is empty.");
        }

        if (count($this->registration_details)>0&&$this->ACC>0&&$flag==0) {
            $this->registration_details= $this->registration_details->where('acc',  $this->ACC);
        }
       
        if (count($this->registration_details)>0) {
        
            $this->search_clicked=true;
        }
    }

    
    public function view_regisration_comment()
    {
        if(!$this->show_regisration_comment){
            $this->show_regisration_comment=true;
        }else{
            $this->show_regisration_comment=false;
        }
       
    }

    public function render()
    {
        return view('livewire.results.results');
    }
}