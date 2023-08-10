<?php

namespace App\Http\Livewire\Registration;

use Illuminate\Support\Facades\Validator;
use  Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Session;
use App\sample_traking_transactions;

use Livewire\Component;

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
use App\processing_units;
use App\reg_samples_barcode_servs_test;
use App\NonClinicalUsers;
use App\extra_services;
use App\registered_serv_ex_prices;
use App\clinic_trans_services;
use App\ReferringDoctors;

class Registration extends Component
{
    public $default_ACC_START=20000;
    public $default_sample_barcode=10000;
    public $default_PATIENT_START=30000;

    public $errors_messages=[];
    public $currentStep=0;
    public $message;
    public $registrations;
    public $list_of_gender;
    public $list_of_marital_status;
    public $phone;
    public $email;
    public $passport;
    public $DOB;
    public $age_d;
    public $age_m;
    public $age_y;
    public $query;
    public $queryPayer;
    public $contacts;
    public $payers;
    public $payer_contracts=[];
    public $highlightIndex;
    public $patient_name= 'ss';
    public $gender;
    public $marital_status;
    public $search = '';
    public $selected_contact = '';
    public $patient_no;
    public $patient_id;
    public $Payer_placeholder;
    public $insurance_id;
    public $selected_contract = [];
    public $selected_payers = [];
    public $today ;
    public $selected_cpls=[];
    public $Total_Cash_Required=0;
    public $Total_Credit_Required=0;
    public $ACC;
    public $type;
    //service page
    public $service_code;
    public $patient_services = [];
    public $patient_extra_services = [];
    public $NonClinicalUsers = [];
    public $selected_NonClinicalUser_service = [];
    public $extra_services = [];
    public $queryService;
    public $queryExtraService;
    public $services;
    public $ExtraServices;
    public $registration_details;
    public $selected_Non_Clinical_User=[];
    public $cancel_reasons;
    public $selected_reason=array();
    public $selected_extra_reason=array();
    public $selected_reason2;
    public $registration_samples_barcodes;
    public $registration_samples_barcode_services;
    public $ClinicTranactionNo;
    public $ClinicServices=[];
    public $SelectedClinicServices=[];
    public $searchByTransctionID=false;
    public $ReferringDoctors=[];
    public $selected_ReferringDoctor=1;
    public $regisration_comment='';
    public $time_to_receive_result='The result will be ready after (      ) ستكون نتيجة الفحوصات جاهزة بعد';


    public function mount()
    {
        $this->extra_services=extra_services::all();
        $this->NonClinicalUsers=NonClinicalUsers::all();
        $this->ReferringDoctors=ReferringDoctors::orderBy('id')->get();
        $this->ClinicTranactionNo=null;
        $this->today = Carbon::now();
        $this->reset_values();

        $this->ACC=request('acc');//get acc if come from search registration
        $this->type=request('type');//get type edit come from search registration
        if ($this->type == 'edit_registration') {
            $this->patient_Info();
        } elseif ($this->type == 'add_service') {
            $this->job_order_Info();
        } elseif ($this->type == 'cancel_registration') {
            $this->cancel_reasons=cancel_reasons::all();
            $this->job_order_Info2();
        } elseif ($this->type == 'sample_Info') {
            $this->registration_samples_barcodes=registration_samples_barcodes::where('acc', $this->ACC)->get();
            $this->registration_samples_barcode_services=registration_samples_barcode_services::all();
        }
    }

    public function reset_values()
    {
        $this->selected_NonClinicalUser_service=[];
        $this->selected_Non_Clinical_User=[];

        $this->currentStep=0;
        $this->query='';
        $this->patient_name='';
        $this->gender='';
        $this->marital_status='';
        $this->DOB=Carbon::now()->toDateString();
        $this->DateOfBirh();
        $this->phone='';
        $this->email='';
        $this->passport='';
        $this->patient_no= '';
        $this->selected_contact = '';
        $this->selected_ReferringDoctor=1;
        $this->time_to_receive_result='The result will be ready after (      ) ستكون نتيجة الفحوصات جاهزة بعد';
        $this->regisration_comment= '';

        $this->patient_id= 0;
        $this->reset_queryPayer();
        
        $this->ClinicServices=[];
        $this->SelectedClinicServices=[];
        $this->searchByTransctionID=false;
    }
    public function reset_queryPayer()
    {
        $this->queryPayer='';
        $this->Payer_placeholder='';
        $this->insurance_id='';
        $this->payers =null;
        $this->payer_contracts =[];
        $this->selected_contract=[];
        $this->selected_payers=[];
        $this->Total_Cash_Required=0;
        $this->Total_Credit_Required=0;
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

    public function selectContact($ii)
    {
        $this->selected_contact = $this->contacts[$ii];
        $this->patient_id = $this->selected_contact['id'];
        $this->patient_name = $this->selected_contact['patient_name'];
        $this->patient_no = $this->selected_contact['patient_no'];
        $this->gender=$this->selected_contact['gender'];
        $this->marital_status=$this->selected_contact['marital_status'];
        $this->DOB=$this->selected_contact['DOB'];
        $this->DateOfBirh();
        $this->phone=$this->selected_contact['phone'];
        $this->email=$this->selected_contact['email'];
        $this->passport=$this->selected_contact['passport'];

        $this->query='';
    }



    public function get_Payer_Contract($i, $Payer_id)
    {
        $this->Payer_placeholder = $this->payers[$i]['code'].' - '.$this->payers[$i]['name_en'];
        $this->selected_payers =$this->payers[$i];
        $this->payer_contracts = Payer_contracts::where('payer_id', $this->payers[$i]['id'])->get();


        $this->queryPayer='';
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

    public function updatedQueryService()
    {
        if (Str::length($this->queryService) >= 1) {
            $this->services =  Services::where('name_en', 'like', '%' . $this->queryService . '%')->orWhere('code', 'like', '%'.$this->queryService. '%')->get();
            if (count($this->services) == 0) {
                $this->services =null;
            }
        }
    }

    public function updatedQueryExtraService()
    {
        if (Str::length($this->queryExtraService) >= 1) {
            $this->ExtraServices =  extra_services::where('name_en', 'like', '%' . $this->queryExtraService . '%')->get();
            if (count($this->ExtraServices) == 0) {
                $this->ExtraServices =null;
            }
        }
    }

    public function updatedsearchByTransctionID()
    {
        $this-> reset_patient_services();
    }

    public function search_service_by_TranactionNo()
    {
       
        session()->flash('Error', null);
        if (count($this->getErrorBag()->all()) > 0) {//reset validation error message
            $this->resetErrorBag();
        }
        $ClinicServices=[];
        $this->ClinicServices=[];
        if ($this->ClinicTranactionNo) {
            $ClinicServices = clinic_trans_services::where('clinic_trans_no', $this->ClinicTranactionNo)->get();
            if (count($ClinicServices)==0) {
                session()->flash('Error', 'This Clinic Tranaction No. not found!!');
            } else {
                $this->SelectedClinicServices=[];
                $this->ClinicServices=$ClinicServices;
                foreach ($this->ClinicServices as $key1 => $ClinicService) {
                    foreach ($this->patient_services as $key => $patient_service) {
                        if ($patient_service['service']['id'] == $ClinicService['service']['id']) {
                            $this->delete_service($key);
                        }
                    }
                }
            }
        } else {
            session()->flash('Error', 'Please enter the Clinic Tranaction No.');
        }
    }
    public function get_patient_by_TranactionNo()
    { 
        $this->contacts=null;
        $this->reset_values();
        if (Str::length($this->ClinicTranactionNo) >= 1) {
            $registrations_details = registrations_details::where('clinic_trans_no', $this->ClinicTranactionNo)->first();
            if( $registrations_details){
                $this->contacts = registrations::where('id', $registrations_details->patient_id)->get();
                if (count($this->contacts) == 0) {
                    $this->contacts =null;
                }else{
                    $this->selectContact(0);
                    $this->search_service_by_TranactionNo();
                }
            }
        }else {
            session()->flash('Error', 'No data.');
        }
    }


    public function addSelectedClinicServices($service)
    {
        $flage=0;

        foreach ($this->patient_services as $key => $patient_service) {
            if ($patient_service['service']['id'] == $service['id']) {
                $this->delete_service($key);
                $flage=1;
            }
        }
        if ($flage==0) {//add service to  patient_services
            $this->add_service($service);
        }
    }


    public function year()
    {
        if (is_numeric($this-> age_y)) {
            //$this-> age_y=0;
            $this->DOB=Carbon::parse($this->DOB)->subYears($this-> age_y)->toDateString();
        } else {
            $this-> age_y=0;
            $this->DOB=Carbon::parse($this->DOB)->subYears($this-> age_y)->toDateString();
        }
    }
    public function month()
    {
        if (is_numeric($this-> age_m)) {
            //$this-> age_m=0;
            $this->DOB=Carbon::parse($this->DOB)->subMonths($this-> age_m)->toDateString();
        } else {
            $this-> age_m=0;
            $this->DOB=Carbon::parse($this->DOB)->subMonths($this-> age_m)->toDateString();
        }
    }
    public function day()
    {
        if (is_numeric($this-> age_d)) {
            //$this-> age_d=0;
            $this->DOB=Carbon::parse($this->DOB)->subDays($this-> age_d)->toDateString();
        } else {
            $this-> age_d=0;
            $this->DOB=Carbon::parse($this->DOB)->subDays($this-> age_d)->toDateString();
        }
    }
    public function DateOfBirh()
    {
        $this-> age_d =\Carbon\Carbon::parse($this->DOB)->diff(\Carbon\Carbon::now())->format('%d');
        $this-> age_m =\Carbon\Carbon::parse($this->DOB)->diff(\Carbon\Carbon::now())->format('%m');
        $this-> age_y =\Carbon\Carbon::parse($this->DOB)->diff(\Carbon\Carbon::now())->format('%y');
    }


    public function previous()
    {
        $this->selected_contract=[];
        $this->Total_Cash_Required=0;
        $this->Total_Credit_Required=0;
        $this->patient_services=[];
        $this->patient_extra_services=[];
        $this->currentStep--;
    }

    public function ShowServicePage()
    {
        $validatedData = Validator::make(
            [
              'patient_name' => $this->patient_name,
              'DOB' => $this->DOB,
              'email' => $this->email,
              'gender' => $this->gender,
              'selected_payers' => $this->selected_payers,
              'selected_contract' => $this->selected_contract,
          ],
            [
              'patient_name' => 'required',
              'DOB' => 'required',
              'gender' => 'required',
              'email' => 'email|nullable',
              'selected_payers' => 'required',
              'selected_contract' => 'required',
          ],
            [
              'patient_name.required' => 'Patient name is required.',
              'DOB.required' => 'DOB is required.',
              'gender.required' => 'Gender is required.',
              'email.email' => 'Email format is not right.',
              'selected_payers.required' => 'Payer is required.',
              'selected_contract.required' => 'Contract field is required.',
          ],
        )->validate();

        if (count($this->getErrorBag()->all()) > 0) {//reset validation error message
            $this->resetErrorBag();
        }

        //payer required fields
        if ($this->selected_payers->is_insurance_ID_required) {
            $validatedData = Validator::make(
                ['Insurance_Id' => $this->insurance_id,],
                ['Insurance_Id' => 'required',],
                ['Insurance_Id.required' => 'Insurance Id is required by the payer.',],
            )->validate();
        }

        if ($this->selected_payers->patient_email_is_required) {
            $validatedData = Validator::make(
                ['email' => $this->insurance_id,],
                ['email' => 'required',],
                ['email.required' => 'Email is required by the payer.',],
            )->validate();
        }

        //got ot next page
        $this->currentStep++;
    }

    public function check_contract()
    {
        $this->selected_contract= json_decode($this->selected_contract, true);

        if ($this->selected_contract) {
            //check the selected payer have at least on contract belong to the user registration branch, after the get the contract price list
            $Contract_branche=[];
            $this->selected_cpls=[];
            $user_branch_id=(Auth::user()->branch->id);

            $this->selected_cpls = Contracts_price_list_settings::where('contract_id', $this->selected_contract['id'])->first();
            //check if the contract work on the user branch
            $Contract_branche = Contract_branches::where('contract_price_list_setting_id', $this->selected_cpls->id)->where('branch_id', $user_branch_id)->get();
            if (count($Contract_branche) ==0) {
                session()->flash('Error', 'Sorry, this contract is not valid at your branch.');
                $this->selected_contract=[];
            } else {
                // $price_lists= Price_lists::where('id', $this->selected_cpls->price_list_id)->first();


                // dd($this->selected_cpls->contract_id, $this->selected_cpls->price_list->name_en);
            }
        }
    }


    public function search_service_by_code()
    {
        $search_service=[];
        if (Str::length($this->service_code) >= 1) {
            $search_service = Services::where('code', $this->service_code)->first();
            //dd($search_service);
            if ($search_service==null) {
                session()->flash('Error', 'Service code not found!! ');
            } else {
                $this->add_service($search_service);
            }
            $this-> service_code='';
        }
    }

    public function search_service_by_naame($service_id)
    {
        $search_service=[];
        $search_service = Services::where('id', $service_id)->first();
        if ($search_service==null) {
            session()->flash('Error', 'Service code not found!! ');
        } else {
            $this->add_service($search_service);
        }
        $this->queryService='';
    }

    public function Selected_NonClinicalUser_extra_service($extra_service_ex_code, $i)
    {
        foreach ($this->selected_NonClinicalUser_service  as $key => $value) {
            $this->selected_NonClinicalUser_service[$key]['non_user_id']= $this->selected_Non_Clinical_User[$i];
            $this->selected_NonClinicalUser_service[$key]['ex_code']= $extra_service_ex_code;
        }
    }

    public function Add_Extra_service($extra_service_ex_code)
    {
        if (count($this->getErrorBag()->all()) > 0) {//reset validation error message
            $this->resetErrorBag();
        }
        $flag=0;

        $add_extra_service=Price_list_services::where('price_list_id', $this->selected_cpls->price_list->id)->where('ex_code', $extra_service_ex_code)->first();
        foreach ($this->patient_extra_services as $key => $patient_extra_service) {
            if ($patient_extra_service['ex_code']==$extra_service_ex_code) {
                $flag=1;
                break;
            }
        }

        if ($flag==0) {
            $this->patient_extra_services[]=$add_extra_service;

            $this->selected_NonClinicalUser_service[]=['non_user_id'=>'','ex_code'=>''];
            $this->selected_Non_Clinical_User[]=[];

            $this->calculate_total();
        } else {
            session()->flash('Error', "Sorry, This extra service has already added !!");
        }
        $this->queryExtraService='';
    }


    public function add_service($service)
    {
        if (count($this->getErrorBag()->all()) > 0) {//reset validation error message
            $this->resetErrorBag();
        }

        //check service price according to payer list contract
        $addservice=Price_list_services::where('price_list_id', $this->selected_cpls->price_list->id)->where('service_id', $service['id'])->first();

        if ($service['is_nested_services']== 0) {//check if the added service is package service or not
            //get the tests belongs to the service
            $new_service_tests = Service_tests::where('service_id', $service['id'])->get();
            $flag=0; //if the new service is already add to the patient add

            $is_service_have_processing_u = AssignSerToProUnits::where('service_id', $service['id'])->get();

            if ($addservice==null) {
                $flag=1;
                session()->flash('Error', "Sorry, this service (".$service['name_en'].") contains zero fee!! ");
            } elseif (count($new_service_tests)==0) {
                $flag=1;
                session()->flash('Error', "Sorry, this service (".$service['name_en'].") does not contain at least one test belonging to it!!");
            } elseif (count($is_service_have_processing_u)==0) {
                $flag=1;
                session()->flash('Error', "Sorry, this service (".$service['name_en'].") is not belonging to any processing unit!!");
            } else {
                foreach ($new_service_tests as $new_service_test) {
                    if (!$new_service_test['test']['active']) {
                        session()->flash('Error', "Sorry, the test at (".$service['name_en'].") service is not active!!");
                        $flag=1;
                        break;
                    }
                    if ($new_service_test['test']['gender']!==$this->gender && $new_service_test['test']['gender']!=="All") {
                        $flag=1;
                        session()->flash('Error', "Sorry, the test at (".$service['name_en'].") service is not available to this kind of gender (".$this->gender.")!!");
                        $flag=1;
                        break;
                    }
                }
                //check if the service is add befor
                foreach ($this->patient_services as $key => $patient_service) {
                    // is_service_in_add_package()
                    if ($patient_service['service']['is_nested_services']==1) {
                        $nested_services= service_nested_services::where('service_id', $patient_service['service']['id'])->get();

                        foreach ($nested_services as $key => $service) {
                            $patient_service_tests = Service_tests::where('service_id', $service['nested_service']['id'])->get();

                            foreach ($new_service_tests as $new_service_test) {
                                foreach ($patient_service_tests as $patient_service_test) {
                                    if ($patient_service_test['test_id']==$new_service_test['test_id']) {
                                        $flag=1;
                                        session()->flash('Error', "Sorry, the test at (".$service['nested_service']['name_en'].") has already added on (".$patient_service['service']['name_en'].") service !!");
                                        break;
                                    }
                                }
                            }
                        }
                    } else {
                        $patient_service_tests = Service_tests::where('service_id', $patient_service['service_id'])->get();

                        foreach ($new_service_tests as $new_service_test) {
                            foreach ($patient_service_tests as $patient_service_test) {
                                if ($patient_service_test['test_id']==$new_service_test['test_id']) {
                                    $flag=1;
                                    session()->flash('Error', "Sorry, this test at (".$service['name_en'].") has already added on (".$patient_service['service']['name_en'].") service !!");
                                    break;
                                }
                            }
                        }
                    }
                }

                if ($flag==0) {
                    $this->patient_services[]=$addservice;

                    $this->calculate_total();
                }
            }

            if ($flag==1&&count($this->SelectedClinicServices)>0) {
                foreach ($this->SelectedClinicServices as $key => $SelectedClinicService) {
                    if ($service['id'] == $SelectedClinicService) {
                        unset($this->SelectedClinicServices[$key]);
                    }
                }
            }
        } else {//this service is package
            $service_name_en=$service['name_en'];
            $nested_services= service_nested_services::where('service_id', $service['id'])->get();
            $flag=0; //if the new service is already add to the patient add

            foreach ($nested_services as $key => $service) {
                //get the tests belongs to the service
                $new_service_tests = Service_tests::where('service_id', $service['nested_service_id'])->get();


                $is_service_have_processing_u = AssignSerToProUnits::where('service_id', $service['nested_service_id'])->get();

                if ($addservice==null) {
                    $flag=1;
                    session()->flash('Error', "Sorry, this service (".$service['nested_service']['name_en'].") contains zero fee!! ");
                } elseif (count($new_service_tests)==0) {
                    $flag=1;
                    session()->flash('Error', "Sorry, this service (".$service['nested_service']['name_en'].") does not contain at least one test belonging to it!!");
                } elseif (count($is_service_have_processing_u)==0) {
                    $flag=1;
                    session()->flash('Error', "Sorry, this service (".$service['nested_service']['name_en'].") is not belonging to any processing unit!!");
                } else {
                    foreach ($new_service_tests as $new_service_test) {
                        if (!$new_service_test['test']['active']) {
                            session()->flash('Error', "Sorry, the test at (".$service['nested_service']['name_en'].") service is not active!!");
                            $flag=1;
                            break;
                        }
                        if ($new_service_test['test']['gender']!==$this->gender && $new_service_test['test']['gender']!=="All") {
                            session()->flash('Error', "Sorry, the test at (".$service['nested_service']['name_en'].") service is not available to this kind of gender (".$this->gender.")!!");
                            $flag=1;
                            break;
                        }
                    }
                    //check if the service is add befor
                    foreach ($this->patient_services as $key => $patient_service) {
                        // is_service_in_add_package()
                        if ($patient_service['service']['is_nested_services']==1) {
                            $nested_services= service_nested_services::where('service_id', $patient_service['service']['id'])->get();

                            foreach ($nested_services as $key => $service) {
                                $patient_service_tests = Service_tests::where('service_id', $service['nested_service']['id'])->get();

                                foreach ($new_service_tests as $new_service_test) {
                                    foreach ($patient_service_tests as $patient_service_test) {
                                        if ($patient_service_test['test_id']==$new_service_test['test_id']) {
                                            $flag=1;
                                            session()->flash('Error', "Sorry, the test at (".$service['nested_service']['name_en'].") has already added on (".$patient_service['service']['name_en'].") service !!");
                                            break;
                                        }
                                    }
                                }
                            }
                        } else {
                            $patient_service_tests = Service_tests::where('service_id', $patient_service['service_id'])->get();

                            foreach ($new_service_tests as $new_service_test) {
                                foreach ($patient_service_tests as $patient_service_test) {
                                    if ($patient_service_test['test_id']==$new_service_test['test_id']) {
                                        $flag=1;
                                        session()->flash('Error', "Sorry, the test at (".$service_name_en.") has already added on (".$patient_service['service']['name_en'].") service !!");
                                        break;
                                    }
                                }
                            }
                        }
                    }
                    //check if the service is add befor
                    /*foreach ($this->patient_services as $key => $patient_service) {
                        $patient_service_tests = Service_tests::where('service_id', $patient_service['service_id'])->get();
                        foreach ($new_service_tests as $new_service_test) {
                            foreach ($patient_service_tests as $patient_service_test) {
                                if ($patient_service_test['test_id']==$new_service_test['test_id']) {
                                    $flag=1;
                                    session()->flash('Error', "Sorry, this test at (".$service['name_en'].") has already added on (".$patient_service['service']['name_en'].") service !!");
                                    break;
                                }
                            }
                        }
                    }*/
                }
            }
            if ($flag==0) {
                $this->patient_services[]=$addservice;
                $this->calculate_total();
            }
            if ($flag==1&&count($this->SelectedClinicServices)>0) {
                foreach ($this->SelectedClinicServices as $key => $SelectedClinicService) {
                    if ($service['id'] == $SelectedClinicService) {
                        unset($this->SelectedClinicServices[$key]);
                    }
                }
            }
        }
    }




    public function calculate_total()
    {
        if (count($this->getErrorBag()->all()) > 0) {//reset validation error message
            $this->resetErrorBag();
        }

        $this->Total_Cash_Required=0;
        $this->Total_Credit_Required=0;

        $Credit_amount=0;
        $i=0;
        foreach ($this->patient_services as $key => $service) {
            $this->Total_Cash_Required=$this->Total_Cash_Required + ($service['current_price'] * $this->selected_cpls['cash_ratio']) / 100;
            $Credit_amount=($service['current_price'] * $this->selected_cpls['credit_ratio']) / 100;
            $this->Total_Credit_Required=$this->Total_Credit_Required + $Credit_amount;
            $i=$key;
        }
        foreach ($this->patient_extra_services as $key => $extra_service) {
            $this->Total_Cash_Required=$this->Total_Cash_Required + $extra_service['current_price'];
        }

        if ($this->selected_contract) {
            if ($this->selected_contract['max_credit_amount_per_visit']<$this->Total_Credit_Required) {
                unset($this->patient_services[$i]);
                session()->flash('Error', "Sorry, Service price is ".number_format($Credit_amount)." SDG the job order will reached the maximum credit amount per visit for this payer contract.");
                $this->calculate_total();
            }
        }
    }

    public function delete_service($i)
    {
        foreach ($this->SelectedClinicServices as $key => $SelectedClinicService) {
            if ($this->patient_services[$i]['service']['id'] == $SelectedClinicService) {
                unset($this->SelectedClinicServices[$key]);
            }
        }
        unset($this->patient_services[$i]);

        $this->calculate_total();
    }

    public function delete_extra_service($i)
    {
        unset($this->patient_extra_services[$i]);
        unset($this->selected_NonClinicalUser_service[$i]);
        unset($this->selected_Non_Clinical_User[$i]);

        $this->calculate_total();
    }

    public function cancel_service($i)
    {
        if (count($this->getErrorBag()->all()) > 0) {//reset validation error message
            $this->resetErrorBag();
        }


        $selected_reason=$this->selected_reason[$i];
        if ($this->patient_services[$i]['service']['is_nested_services']==0) {//not package service
            $registration_samples_barcodes=registration_samples_barcodes::where('acc', $this->ACC)->get();
            $sample_ids=[];
            foreach ($registration_samples_barcodes as $key => $sample_id) {
                $sample_ids[]=$sample_id->id;
            }
            $registration_samples_barcode_service=registration_samples_barcode_services::whereIn('samples_barcode_id', $sample_ids)->where('service_id', $this->patient_services[$i]['service']['id'])->first();
            if ($registration_samples_barcode_service->service_status == 'Reserved') {
                //check if user make the refun to client
                //  $payment_transactions=registration_payment_transaction::where('acc', $this->ACC)->where('transaction_type', $this->ACC)->where('amount', $this->ACC)->get();

                $registered_serv_prices=registered_serv_prices::Where('acc', $this->ACC)->where('service_id', $this->patient_services[$i]['service']['id'])->first();
                $registered_serv_prices->update([
                'isCanceled' => true,
                'canceled_reasone' => $selected_reason,
             'canceled_by' => (Auth::user()->id),
            ]);
                $this->job_order_Info2();
            } else {
                $this->selected_reason[$i]='';
                session()->flash('Error', "Sorry, the sample status of this service is ".$registration_samples_barcode_service->service_status.", so please Reserve the sample ID at first and cancel the service !!");
            }
        } else {//this is a package service
            $registration_samples_barcodes=registration_samples_barcodes::where('acc', $this->ACC)->get();
            $sample_ids=[];
            $flag=0;
            foreach ($registration_samples_barcodes as $key => $sample_id) {
                $sample_ids[]=$sample_id->id;
            }

            $service_nested_services=service_nested_services::where('service_id', $this->patient_services[$i]['service']['id'])->get();
            foreach ($service_nested_services as $key => $service_nested_service) {
                $service_nested_services_id=$service_nested_service->nested_service_id;

                $registration_samples_barcode_service=registration_samples_barcode_services::whereIn('samples_barcode_id', $sample_ids)->where('service_id', $service_nested_services_id)->first();
                if ($registration_samples_barcode_service->service_status !== 'Reserved') {
                    $flag=1;
                    $this->selected_reason[$i]='';

                    session()->flash('Error', "Sorry, the sample status of ".$service_nested_service->nested_service->name_en." service in this package is ".$registration_samples_barcode_service->service_status.", so please Reserve the sample ID at first and cancel the service !!");
                    break;
                }
            }
            if ($flag==0) {//update table
                $registered_serv_prices=registered_serv_prices::Where('acc', $this->ACC)->where('service_id', $this->patient_services[$i]['service']['id'])->first();
                $registered_serv_prices->update([
                'isCanceled' => true,
                'canceled_reasone' => $selected_reason,
             'canceled_by' => (Auth::user()->id),
            ]);
                $this->job_order_Info2();
            }
        }
    }

    public function uncancel_service($i)
    {
        $registered_serv_prices=registered_serv_prices::Where('acc', $this->ACC)->where('service_id', $this->patient_services[$i]['service']['id'])->first();
        $registered_serv_prices->update([
                'isCanceled' => false,
                'canceled_reasone' => '',
            ]);
        $this->job_order_Info2();
    }

    public function cancel_extra_service($i)
    {
        if (count($this->getErrorBag()->all()) > 0) {//reset validation error message
            $this->resetErrorBag();
        }

        $selected_extra_reason=$this->selected_extra_reason[$i];

        $registered_serv_ex_prices=registered_serv_ex_prices::Where('acc', $this->ACC)->where('ex_serv_id', $this->patient_extra_services[$i]['ex_serv_id'])->first();

        $registered_serv_ex_prices->update([
        'isCanceled' => true,
        'canceled_reasone' => $selected_extra_reason,
     'canceled_by' => (Auth::user()->id),
    ]);

        $this->job_order_Info2();
    }

    public function uncancel_extra_service($i)
    {
        $registered_serv_ex_prices=registered_serv_ex_prices::Where('acc', $this->ACC)->where('ex_serv_id', $this->patient_extra_services[$i]['ex_serv_id'])->first();

        $registered_serv_ex_prices->update([
                'isCanceled' => false,
                'canceled_reasone' => '',
            ]);
        $this->job_order_Info2();
    }

    public function togel_service_status($i)
    {
        $registration_samples_barcode_service=registration_samples_barcode_services::where('id', $i)->first();
        //get the defualt sample status from it's processing unit
        $registration_samples_barcodes=registration_samples_barcodes::where('id', $registration_samples_barcode_service->samples_barcode_id)->first();
        $defualt_samble_status=$registration_samples_barcodes->Processing_unit->defualt_samble_status;

        if ($registration_samples_barcode_service->service_status == $defualt_samble_status) {
            $registration_samples_barcode_service->update([
                'service_status' => 'Reserved',
             'updated_by' => (Auth::user()->id),
            ]);
        } else {
            $registration_samples_barcode_service->update([
                'service_status' => $defualt_samble_status,
             'updated_by' => (Auth::user()->id),
            ]);
        }
        $this->registration_samples_barcode_services=registration_samples_barcode_services::all();
    }


    public function reset_patient_services()
    {
        $this->Total_Cash_Required=0;
        $this->Total_Credit_Required=0;
        $this->patient_services=[];

        $this->ClinicTranactionNo=null;
        $this->ClinicServices=[];
        $this->SelectedClinicServices=[];
    }

    public function savePatientRegistrationData()
    {
        // $this->patient_no = (Auth::user()->branch->code).'-'.$this->generateBarcodeNumber();
        $acc=(Auth::user()->branch->code).$this->generateACCNumber();//create ne ACC no for this job order

        //save patient personal data on registrations table
       // check if it's new patient or exsistace patient
        if ($this->patient_id==0) { //create new user first
            $this->patient_id=  $this->creatNewPatient(); //return the new patient ID
        }
        //save the contract details for this job order
        registrations_details::create([
            'acc' => $acc,
            'patient_id' => $this->patient_id,
            'payer_id' =>  $this->selected_payers->id,
            'contract_id' =>  $this->selected_contract['id'],
            'insurance_id' =>  $this->insurance_id,
            'total_Cash_Required' =>  $this->Total_Cash_Required,
            'total_Credit_Required' =>  $this->Total_Credit_Required,
            'remaining' =>  $this->Total_Cash_Required,
            'branch_id' => (Auth::user()->branch->id),
            'clinic_trans_no' =>  $this->ClinicTranactionNo,
            'created_by' => (Auth::user()->id),
            'referringDoctors_id' => $this->selected_ReferringDoctor,
            'time_to_receive_result' => $this->time_to_receive_result,
            'regisration_comment' => $this->regisration_comment,
        ]);

        //save the selected services prices and name
        foreach ($this->patient_services as $key => $patient_service) {
            $service_price_cash=   ($patient_service['current_price'] * $this->selected_cpls['cash_ratio']) / 100;
            $service_price_credit=   ($patient_service['current_price'] * $this->selected_cpls['credit_ratio']) / 100;
            registered_serv_prices::create([
            'acc' => $acc,
            'service_id' =>  $patient_service['service']['id'],
            'current_price' =>  $patient_service['current_price'],
            'service_price_cash' =>  $service_price_cash,
            'service_price_credit' =>  $service_price_credit,
            'result_date' =>  Carbon::now()->addMinutes($patient_service['service']['processing_time'])->format('Y-m-d H:i'),
        ]);
        }


        //save the selected services prices and name
        foreach ($this->patient_extra_services as $key => $patient_extra_service) {
            //get extra service id
            $non_user_id=$this->selected_NonClinicalUser_service[$key]['non_user_id'];
            if (!$non_user_id) {
                $non_user_id=0;
            }
            $extra_service_id= extra_services::where('ex_code', $patient_extra_service['ex_code'])->first();
            registered_serv_ex_prices::create([
            'acc' => $acc,
            'ex_serv_id' =>  $extra_service_id['id'],
            'current_price' =>  $patient_extra_service['current_price'],
            'service_price_cash' =>  $patient_extra_service['current_price'],
            'done_by' => $non_user_id,
        ]);
        }

        //get all selected sevices and also the nested on package to make sort
        //sort job order accourdig to the processing_unit_id

        $service_processing_u22=[];
        $new_service_tests_final=[];
        foreach ($this->patient_services as $key => $patient_service) {
            //check if it's package services
            if ($patient_service['service']['is_nested_services']==1) {//it's package services
                      //get the package nested services
                $nested_services= service_nested_services::where('service_id', $patient_service['service']['id'])->get();

                foreach ($nested_services as $key => $nested_service) {
                    $service_processing_u22[]= AssignSerToProUnits::where('service_id', $nested_service['nested_service']['id'])->first();
                }
            } else {//it's service
                $service_processing_u22[]= AssignSerToProUnits::where('service_id', $patient_service['service']['id'])->first();
            }
        }
        $user_branch_id=(Auth::user()->branch->id);
        $branch_smaple_setting= Test_branch_samples_branches::where('branch_id', $user_branch_id)->get();

        $arr2 = collect($service_processing_u22)->groupBy('processing_unit_id');


        //creat sample id(barcode for group of processing_unit)
        $sample_barcode =$this->sample_Barcode();
        $new_service_tests_final2=[];
        foreach ($arr2 as $processing_unit_id => $new_service_test) {
            //get the defualt samble status
            $defualt_samble_status= processing_units::where('id', $processing_unit_id)->first();
            registration_samples_barcodes::create([
                'acc' => $acc,
                'sample_barcode' =>  $sample_barcode,
                'processing_unit_id' =>  $processing_unit_id,
                'samples_barcode_status'=>   $defualt_samble_status->defualt_samble_status,
            ]);
            //get the new id created perviouslly
            $samples_barcode_id= registration_samples_barcodes::where('sample_barcode', $sample_barcode)->first();

            //save this transaction on sample traking transactions
            sample_traking_transactions::create([
               'sample_status' => $defualt_samble_status->defualt_samble_status,
               'rsb_id' => $samples_barcode_id->id,
               'location_id' => 0,//that is mean the loaction is registration desk
               'Created_by' => (Auth::user()->id),
               'analyzer_id' => 0,
            ]);

            foreach ($new_service_test as $new_service_test22) {
                registration_samples_barcode_services::create([
                    'samples_barcode_id' => $samples_barcode_id->id,
                    'service_id' =>  $new_service_test22->service_id,
                    'service_status'=> $defualt_samble_status->defualt_samble_status,
                ]);

                //add the service tests to table by registration_samples_barcode_services_id
                $Service_tests=Service_tests::where('service_id', $new_service_test22->service_id)->get();
                $registration_samples_barcode_service= registration_samples_barcode_services::where('service_id', $new_service_test22->service_id)->where('samples_barcode_id', $samples_barcode_id->id)->first();
                //dd($Service_tests);
                foreach ($Service_tests as $key => $Service_test) {
                    reg_samples_barcode_servs_test::create([
                        'test_id' => $Service_test->test->id,
                        'rsbs_id' => $registration_samples_barcode_service->id ,
                    ]);
                }
            }
            $sample_barcode =$this->sample_Barcode();
        }

        //print sample info A4 , barcode

        //share acc no. with next page
        //Redirect::to('SubmitPatientPayments?acc='.$acc);
        Redirect::to('printSampleDetails_Silent?acc='.$acc);


        //store job order on tables
        // $arr22 = collect($new_service_tests_final2)->groupBy(['barcode','processing_unit','acc']);
        //  dd($new_service_tests_final2);
    }

    public function updatePatientRegistrationData()
    {
        //update the contract details for this job order
        $registrations_details = registrations_details::Where('acc', $this->ACC)->first();

        $registrations_details_updat = registrations_details::findOrFail($registrations_details['id']);

        // $refund=($this->Total_Cash_Required-$registrations_details['paid']-$registrations_details['discount']);

        //  if ($refund<=0) {//one service is deleted, make the refund first and edit the job order
        //delete all previous added services and insert new one

        $registrations_details_updat->update([
            'total_Cash_Required' =>  $this->Total_Cash_Required,
            'total_Credit_Required' =>  $this->Total_Credit_Required,
            'remaining' =>  ($this->Total_Cash_Required-$registrations_details['paid']-$registrations_details['discount']),
        ]);
        //save the selected services prices and name
        $new_patient_service=[];
        foreach ($this->patient_services as $key => $patient_service) {
            $registered_serv_prices=registered_serv_prices::Where('acc', $this->ACC)->Where('service_id', $patient_service['service']['id'])->first();

            if (!$registered_serv_prices) {//check if the service is already add before to add just the new services\
                $new_patient_service[]=$patient_service;
                $service_price_cash=   ($patient_service['current_price'] * $this->selected_cpls['cash_ratio']) / 100;
                $service_price_credit=   ($patient_service['current_price'] * $this->selected_cpls['credit_ratio']) / 100;
                registered_serv_prices::create([
            'acc' => $this->ACC,
            'service_id' =>  $patient_service['service']['id'],
            'current_price' =>  $patient_service['current_price'],
            'service_price_cash' =>  $service_price_cash,
            'service_price_credit' =>  $service_price_credit,
        ]);
            }
        }
        if ($new_patient_service) {//the registration has add new services
            $service_processing_u22=[];
            $new_service_tests_final=[];
            foreach ($new_patient_service as $key => $patient_service) {
                //check if it's package services
                if ($patient_service['service']['is_nested_services']==1) {//it's package services
                      //get the package nested services
                    $nested_services= service_nested_services::where('service_id', $patient_service['service']['id'])->get();

                    foreach ($nested_services as $key => $nested_service) {
                        $service_processing_u22[]= AssignSerToProUnits::where('service_id', $nested_service['nested_service']['id'])->first();
                    }
                } else {//it's service
                    $service_processing_u22[]= AssignSerToProUnits::where('service_id', $patient_service['service']['id'])->first();
                }
            }
            $user_branch_id=(Auth::user()->branch->id);
            $branch_smaple_setting= Test_branch_samples_branches::where('branch_id', $user_branch_id)->get();

            $arr2 = collect($service_processing_u22)->groupBy('processing_unit_id');


            //creat sample id(barcode for group of processing_unit)
            $sample_barcode =$this->sample_Barcode();
            $new_service_tests_final2=[];
            foreach ($arr2 as $processing_unit_id => $new_service_test) {
                //get the defualt samble status
                $defualt_samble_status= processing_units::where('id', $processing_unit_id)->first();
                registration_samples_barcodes::create([
                'acc' => $this->ACC,
                'sample_barcode' =>  $sample_barcode,
                'processing_unit_id' =>  $processing_unit_id,
                'samples_barcode_status'=>   $defualt_samble_status->defualt_samble_status,
            ]);
                //get the new id created perviouslly
                $samples_barcode_id= registration_samples_barcodes::where('sample_barcode', $sample_barcode)->first();
                foreach ($new_service_test as $new_service_test22) {
                    registration_samples_barcode_services::create([
                    'samples_barcode_id' => $samples_barcode_id->id,
                    'service_id' =>  $new_service_test22->service_id,
                    'service_status'=> $defualt_samble_status->defualt_samble_status,
                ]);

                    //add the service tests to table by registration_samples_barcode_services_id
                    $Service_tests=Service_tests::where('service_id', $new_service_test22->service_id)->get();
                    $registration_samples_barcode_service= registration_samples_barcode_services::where('service_id', $new_service_test22->service_id)->where('samples_barcode_id', $samples_barcode_id->id)->first();

                    foreach ($Service_tests as $key => $Service_test) {
                        reg_samples_barcode_servs_test::create([
                        'test_id' => $Service_test->test->id,
                        'rsbs_id' => $registration_samples_barcode_service->id ,
                    ]);
                    }
                }
                $sample_barcode =$this->sample_Barcode();
                //  $new_service_tests_final2[]= ['sample_main_data'=>['acc'=>$acc,'barcode'=>$sample_barcode,'processing_unit'=>$key], 'sample_services'=>$sample_services];
            }

            //print sample info A4 , barcode

            //share acc no. with next page
            //Redirect::to('SubmitPatientPayments?acc='.$acc);
            Redirect::to('printSampleDetails_Silent?acc='.$this->ACC);
        } else {
            session()->flash('Error', 'No services add.');
        }
    }


    public function creatNewPatient()
    {
        $this->patient_no = (Auth::user()->branch->code).'-'.$this->generateBarcodeNumber();
        registrations::create([
            'patient_name' => $this->patient_name,
            'patient_no' =>  $this->patient_no,
            'gender' =>  $this->gender,
            'marital_status' =>  $this->marital_status,
            'DOB' => $this->DOB,
            'phone' => $this->phone ,
            'age_y' => $this->age_y ,
            'age_m' => $this->age_m ,
            'age_d' => $this->age_d ,
            'email' => $this->email ,
            'passport' =>  $this->passport,
            'Created_by' => (Auth::user()->id),
        ]);

        $this->patient_id= registrations::orderBy('id', 'desc')->first()->id;

        return  $this->patient_id;
    }

    public function generateBarcodeNumber()
    {
        $last_sample_id= registrations::orderBy('created_at', 'DESC')->first();
        if ($last_sample_id) {
            $new_sample_id= $last_sample_id->id+1;
        } else {
            $new_sample_id= 1;
        }

        $number =$this->default_PATIENT_START+$new_sample_id;


        // call the same function if the barcode exists already
        /*  if ($this->barcodeNumberExists($number)) {
              return  $this->generateBarcodeNumber();
          }*/

        // otherwise, it's valid and can be used
        return $number;
    }



    public function barcodeNumberExists($number)
    {
        // query the database and return a boolean
        // for instance, it might look like this in Laravel
        return registrations::where('patient_no', $number)->exists();
    }


    public function generateACCNumber()
    {
        $last_sample_id= registrations_details::orderBy('created_at', 'DESC')->first();
        if ($last_sample_id) {
            $new_sample_id= $last_sample_id->id+1;
        } else {
            $new_sample_id= 1;
        }

        $number =$this->default_ACC_START+$new_sample_id;

        // call the same function if the barcode exists already
        /* if ($this->ACCNumberExists($number)) {
             return  $this->generateACCNumber();
         }*/

        // otherwise, it's valid and can be used
        return $number;
    }
    public function ACCNumberExists($number)
    {
        // query the database and return a boolean
        // for instance, it might look like this in Laravel
        return registrations_details::where('acc', $number)->exists();
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

        // call the same function if the barcode exists already
        /* if ($this->sample_BarcodeExists($number)) {
             return  $this->sample_Barcode();
         }*/
        // otherwise, it's valid and can be used
        return $number;
    }

    public function sample_BarcodeExists($number)
    {
        // query the database and return a boolean
        // for instance, it might look like this in Laravel
        return registration_samples_barcodes::where('sample_barcode', $number)->exists();
    }


    // search registration -- edit personal data --
    public function patient_Info()
    {
        //get patient data via ACC NO.
        $this->registration_details=registrations_details::Where('acc', $this->ACC)->first();
        //dd($this->registration_details->patient->id);
        $this->patient_id = $this->registration_details->patient->id;
        $this->patient_name = $this->registration_details->patient->patient_name;
        $this->patient_no = $this->registration_details->patient->patient_no;
        $this->gender=$this->registration_details->patient->gender;
        $this->marital_status=$this->registration_details->patient->marital_status;
        $this->DOB=$this->registration_details->patient->DOB;
        $this->DateOfBirh();
        $this->phone=$this->registration_details->patient->phone;
        $this->email=$this->registration_details->patient->email;
        $this->passport=$this->registration_details->patient->passport;
    }

    public function update_Patient_info()
    {
        if (count($this->getErrorBag()->all()) > 0) {//reset validation error message
            $this->resetErrorBag();
        }

        $validatedData = Validator::make(
            [
              'patient_name' => $this->patient_name,
              'DOB' => $this->DOB,
              'email' => $this->email,
              'gender' => $this->gender,
          ],
            [
              'patient_name' => 'required',
              'DOB' => 'required',
              'gender' => 'required',
              'email' => 'email|nullable',
          ],
            [
              'patient_name.required' => 'Patient name is required.',
              'DOB.required' => 'DOB is required.',
              'gender.required' => 'Gender is required.',
              'email.email' => 'Email format is not right.',
          ],
        )->validate();

        $registrations = registrations::findOrFail($this->patient_id);

        $registrations->update([
        'patient_name' => $this->patient_name,
        'gender' =>  $this->gender,
        'marital_status' =>  $this->marital_status,
        'DOB' => $this->DOB,
        'phone' => $this->phone ,
        'age_y' => $this->age_y ,
        'age_m' => $this->age_m ,
        'age_d' => $this->age_d ,
        'email' => $this->email ,
        'passport' =>  $this->passport,
        'Edited_by' => (Auth::user()->id),
            ]);
        session()->flash('Edit', 'Contract edited successfully!!');
    }

    public function job_order_Info()
    {
        $this->patient_services=[];
        //get job order data via ACC NO.
        $this->registration_details=registrations_details::Where('acc', $this->ACC)->first();
        $this->selected_cpls = Contracts_price_list_settings::where('contract_id', $this->registration_details->payer_contract->id)->first();
        //get job order services
        $registered_serv_prices=registered_serv_prices::Where('acc', $this->ACC)->Where('isCanceled', false)->get();
        //dd($registered_serv_prices);
        foreach ($registered_serv_prices as $key => $registered_serv) {
            $this->patient_services[]=$registered_serv;
            $this->selected_reason[]=$key;
        }


        $this->calculate_total();
    }

    public function job_order_Info2()
    {
        $this->patient_services=[];
        $this->patient_extra_services=[];

        //get job order data via ACC NO.
        $this->registration_details=registrations_details::Where('acc', $this->ACC)->first();
        $this->selected_cpls = Contracts_price_list_settings::where('contract_id', $this->registration_details->payer_contract->id)->first();
        //get job order services
        $registered_serv_prices=registered_serv_prices::Where('acc', $this->ACC)->get();
        foreach ($registered_serv_prices as $key => $registered_serv) {
            $this->patient_services[]=$registered_serv;
            $this->selected_reason[]=$key;
        }

        $registered_serv_ex_prices=registered_serv_ex_prices::Where('acc', $this->ACC)->get();

        foreach ($registered_serv_ex_prices as $key => $registered_serv) {
            $this->patient_extra_services[]=$registered_serv;
            $this->selected_extra_reason[]=$key;
        }

        $this->calculate_total();
    }

    public function render()
    {
        $this->registrations = registrations::all();
        $this->list_of_gender=['Male' ,'Female'];
        $this->list_of_marital_status=['Single', 'Married'];
        return view('livewire.registration.registration');
    }
}
