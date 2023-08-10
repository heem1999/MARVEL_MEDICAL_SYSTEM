<?php

namespace App\Http\Livewire\Registration;

use Livewire\Component;

use Illuminate\Support\Facades\DB;


use Illuminate\Support\Facades\Validator;
use  Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use App\registrations;
use App\Services;
use App\Payers;
use App\Payer_contracts;
use App\contracts_price_list_settings;
use App\contract_branches;
use App\Price_lists;
use App\Price_list_services;
use App\service_tests;
use App\AssignSerToProUnits;
use App\service_nested_services;
use App\Test_branch_samples_branches;
use App\registered_serv_prices;
use App\registrations_details;
use App\registration_payment_transaction;
use App\Branches;
use App\Review;

use App\registration_samples_barcodes;
use App\registration_samples_barcode_services;
use App\cancel_reasons;
use App\processing_units;
use App\reg_samples_barcode_servs_test;
use App\NonClinicalUsers;
use App\extra_services;
use App\registered_serv_ex_prices;
use App\clinic_trans_services;
use App\ReferringDoctors;

use App\AppBookingSerPrices;

use App\AppBooking;
use App\Areas;
use App\AppUsers;
use App\lab_tech_users;
use App\MedicalAttachments;
use App\app_bookingTransactions;
use App\appPaymentTransactions;

class HomeServices extends Component
{
    public $list_of_gender;
    public $query;
    public $contacts;
    public $highlightIndex;
    public $ACC;
    public $Payer_placeholder;
    public $queryPayer;
    public $payers;
    public $payer_contracts=[];
    public $selected_contract;
    public $selected_payer;
    public $dateFrom;
    public $dateTo;
    public $branches;
    public $area_id;
    public $registration_details=[];
    public $search_clicked=false;
    public $page='';
    public $services;
    public $patient_services=[];
    public $previous_patient_services=[];
    public $patient_registrationDetails=[];
    public $patient_MedicalAttachments=[];
    public $lab_tech_users=[];

    public $p_data=[];
    public $today ;
    public $Total_Cash_Required=0;
    public $Total_Credit_Required=0;
    public $booking_status=[0=>"UNDER REVIEWING",1=>"Confirmed",2=>"Approved",3=>"Processing",4=>"Collected",5=>"Completed",6=>"Canceled",7=>"Rejected",];
    public $selected_booking_status=[];

    public $error_message ;
    public $success_message ;
    public $extra_km ;
    public $queryService='';
    public $service_code='';
    public $selected_cpls=[];
    public $selected_area=[];
    public $SelectedClinicServices=[];

    public $bookingTransactions=[];
    public $payment_transactions=[];
    public $Discount_mark='';
    public $discount_amount=0;
    public $payment_amount=0;
    public $payment_method='';
    public $transaction_type='';

    public $users_reviews=[];

    public function mount()
    {
        $this->selected_area=[];
        $this->success_message='';
        $this->queryService='';
        $this->service_code='';
        $this->today = Carbon::now();
        $this->error_message= '';
        $this->dateFrom = '';
        $this->dateTo = '';
        $this->ACC='';
        $this->branches = Areas::all();
        $this->Total_Cash_Required=0;
        $this->Total_Credit_Required=0;
        $this->area_id='';
        $this->payment_transactions=[];
        $this->bookingTransactions=[];
        $this->users_reviews=[];
        
        $this->registration_details=[];
        $this->selected_booking_status=[];
        $this->patient_MedicalAttachments=[];

        $this->selected_payer=[];
        $this->SelectedClinicServices=[];

        $this->patient_services=[];
        $this->previous_patient_services=[];

        $this->search_clicked=false;

        $page=request('pagename');

        if ($page) {
            $this->page=$page;
        }
        if ($this->page=='registrationDetails') {
            $this->page=$page;
            $this->booking_registrationDetails(request('booking_id'));
        }
        if ($this->page=='servicesDetails') {
            $this->page=$page;
            $this->booking_servicesDetails(request('booking_id'));
        }

        if ($this->page=='newRegistration') {
            $this->page=$page;
            $this->booking_newRegistration();
        }

        if ($this->page=='AppReviews') {
            $this->page=$page;
            $this->AppReviews();
        }

        
    }


    public function select_all()
    {
        for ($i=0; $i <8 ; $i++) {
            $this->selected_booking_status[]=$i;
        }
    }
    public function unselect_all()
    {
        $this->selected_booking_status=[];
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
            $this->contacts = AppBooking::where('p_name', 'like', '%' . $this->query . '%')->orWhere('p_phone1', 'like', '%'.$this->query. '%')->orWhere('p_phone2', 'like', '%'.$this->query. '%')->get();
            if (count($this->contacts) == 0) {
                $this->contacts =null;
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


    public function get_Payer_Contract($i, $Payer_id)
    {
        $this->payer_contracts=[];
        $this->selected_contract='';
        $this->Payer_placeholder =$this->payers[$i]['name_en']. ' - '.$this->payers[$i]['code'];
        $this->payer_contracts = Payer_contracts::where('payer_id', $this->payers[$i]['id'])->get();
        $this->queryPayer='';
        $this->selected_payer=$this->payers[$i];
    }

    public function searchData()
    {
        $this->error_message= '';
        session()->flash('Error', null);
        $this->registration_details=[];
        $this->search_clicked=false;
        $payer_id='';
        if ($this->payer_contracts) {
            $payer_id=$this->payer_contracts[0]['payer_id'];
        }
        $x=['payer_id'=>$payer_id ,'booking_acc'=>$this->ACC,'area_id'=> $this->area_id,'contract_id'=>$this->selected_contract];

        if (!$this->ACC) {
            unset($x['booking_acc']);
        }

        if (!$this->area_id) {
            unset($x['area_id']);
        }

        if (!$this->selected_contract) {
            unset($x['contract_id']);
        }

        if (!$this->payer_contracts) {
            unset($x['payer_id']);
        }


        if ($x && $this->dateFrom=='') {
            // $this->registration_details=AppBooking::where($x)->orWhere('created_at', '>=', $this->dateFrom)->Where('created_at', '<=', $this->dateTo)->get();
            if ($this->selected_booking_status) {
                $this->registration_details=AppBooking::whereIn('status', $this->selected_booking_status)->where($x)->get();
            } else {
                $this->registration_details=AppBooking::where($x)->get();
            }
        } elseif ($this->dateFrom) {
            $dateFrom=Carbon::parse(Carbon::parse($this->dateFrom)->toDateString())->format('Y-m-d');
            $time = strtotime($dateFrom);
            $dateFrom = date('Y-m-d 00:00', $time);
            $dateFrom_to = date('Y-m-d 23:59', $time);

            if ($this->dateTo) {
                $dateTo=Carbon::parse(Carbon::parse($this->dateTo)->toDateString())->format('Y-m-d');
                $time = strtotime($dateTo);
                $dateTo = date('Y-m-d 23:59', $time);
                if ($this->selected_booking_status) {
                    $this->registration_details=AppBooking::whereBetween('created_at', [$dateFrom, $dateFrom_to])->whereIn('status', $this->selected_booking_status)->where($x)->get();
                } else {
                    $this->registration_details=AppBooking::whereBetween('created_at', [$dateFrom, $dateFrom_to])->where($x)->get();
                }
            } else {
                if ($this->selected_booking_status) {
                    $this->registration_details=AppBooking::whereBetween('created_at', [$dateFrom, $dateFrom_to])->whereIn('status', $this->selected_booking_status)->where($x)->get();
                } else {
                    $this->registration_details=AppBooking::whereBetween('created_at', [$dateFrom, $dateFrom_to])->where($x)->get();
                }
            }
        } elseif ($this->selected_booking_status) {
            $this->registration_details=AppBooking::whereIn('status', $this->selected_booking_status)->get();
        }

        if (count($this->registration_details)>0) {
            $this->search_clicked=true;
        } else {
            $this->error_message= 'No data.';
        }
    }

    public function booking_servicesDetails($booking_id)
    {
        $this->payment_transactions=[];
        $this->registration_details=[];
        $this->previous_patient_services=[];
        $this->registration_details=AppBooking::where('id', $booking_id)->first();
        $this->previous_patient_services=AppBookingSerPrices::where('booking_id', $booking_id)->get();
        $this->patient_MedicalAttachments=MedicalAttachments::where('booking_id', $booking_id)->get();
        $this->bookingTransactions=app_bookingTransactions::where('booking_id', $booking_id)->get();

        $this->payment_transactions=appPaymentTransactions::where('booking_id', $booking_id)->get();
        $this->calculate_total();
    }

    public function booking_newRegistration()
    {
        $this->lab_tech_users=lab_tech_users::all();
        $this->p_data=[
            'p_name'=> '',
            'p_phone1'=>'' ,
            'p_phone2'=>'' ,
            'p_sex'=>'' ,
            'visit_date'=>'' ,
            'p_age'=>'',
            'area_id'=>'',
           'contract_id'=>'' ,
            'payer_id'=> '',
            'home_vist_price'=>0 ,
            'order_destanceKm'=>'' ,
            'ex_km_price_at'=>'' ,
            'created_by'=>'' ,
        ];
    }

    public function home_servicePrice_byArea()
    {
        $this->selected_area=[];
        $this->extra_km=0;
        $this->selected_area=Areas::where('id', $this->p_data['area_id'])->first();
        $this->p_data['home_vist_price']=$this->selected_area->home_visit_fixed_price ;
        $this->p_data['order_destanceKm']=$this->selected_area->zone_radius_km/1000 ;
        $this->p_data['ex_km_price_at']=$this->selected_area->ex_km_price;
    }

    public function calculate_home_servicePrice()
    {
        if ($this->extra_km<=0) {
            $this->extra_km=0;
            $this->p_data['home_vist_price']=$this->selected_area->home_visit_fixed_price ;
            $this->p_data['order_destanceKm']=$this->selected_area->zone_radius_km/1000 ;
        } else {
            $this->p_data['home_vist_price']=$this->selected_area->home_visit_fixed_price+ ($this->extra_km*$this->selected_area->ex_km_price);
            $this->p_data['order_destanceKm']=($this->selected_area->zone_radius_km/1000)+$this->extra_km;
        }
    }

    public function save_booking_newRegistration()
    {
        $this->success_message='';
        $this->error_message= '';
        $flag=0;
        if (!$this->p_data['p_name']) {
            $this->error_message= 'Patient name is required.';
            $flag=1;
        } elseif (!$this->p_data['p_phone1']) {
            $this->error_message= 'Patient phone1 is required.';
            $flag=1;
        } elseif (!$this->p_data['p_sex']) {
            $this->error_message= 'Patient sex is required.';
            $flag=1;
        } elseif (!$this->p_data['visit_date']) {
            $this->error_message= 'Home visit date is required.';
            $flag=1;
        } elseif (!$this->p_data['p_age']) {
            $this->error_message= 'Patient age is required.';
            $flag=1;
        } elseif (!$this->p_data['area_id']) {
            $this->error_message= 'Patient request area is required.';
            $flag=1;
        }

        if ($this->p_data&& $flag==0) {
            if ($this->selected_contract) {
                $this->p_data['order_destanceKm']=$this->p_data['order_destanceKm']*1000;
                //if the new contract is not the same once generateACCNumber()
                $this->p_data['booking_acc']=$this->generateACCNumber();
                $this->p_data['contract_id']=$this->selected_contract;
                $this->p_data['payer_id']=$this->selected_payer['id'];
                $this->p_data['status']=2;
                $this->p_data['status_en']='Approved';
                $this->p_data['status_ar']='معتمد';
                $this->p_data['created_by']=Auth::id();

                $bookin_data=AppBooking::create($this->p_data);

                //update booking transaction table
                app_bookingTransactions::create([
                    'booking_id'=>$bookin_data['id'] ,
                    'edit_by'=>Auth::id() ,
                    'patient_info'=>1 ,
                    'edit_type'=> 'Create'
                ]);

                $this->success_message= 'Appointment added successfully!!';
                //redirect to service details
                Redirect::to('homeservices?pagename=servicesDetails&booking_id='.$bookin_data['id']);
            } else {
                $this->error_message= 'Payer contract is required.';
            }
        }
    }


    public function booking_registrationDetails($booking_id)
    {
        $this->lab_tech_users=lab_tech_users::all();
        $this->patient_registrationDetails=[];
        $this->patient_registrationDetails=AppBooking::where('id', $booking_id)->first();
        $this->p_data=[
            'p_name'=>$this->patient_registrationDetails->p_name ,
            'p_phone1'=>$this->patient_registrationDetails->p_phone1 ,
            'p_phone2'=>$this->patient_registrationDetails->p_phone2 ,
            'p_sex'=>$this->patient_registrationDetails->p_sex ,
            'visit_date'=>$this->patient_registrationDetails->visit_date ,
            'p_age'=>$this->patient_registrationDetails->p_age,
            'area_id'=>$this->patient_registrationDetails->area_id,
           'contract_id'=>$this->patient_registrationDetails->contract_id ,
            'payer_id'=> $this->patient_registrationDetails->payer_id,
            'LabTech_id'=>$this->patient_registrationDetails->LabTech_id ,
            'status'=>$this->patient_registrationDetails->status ,
            'status_en'=>$this->patient_registrationDetails->status_en ,
            'status_ar'=>$this->patient_registrationDetails->status_ar ,
            'canceled_by'=>$this->patient_registrationDetails->canceled_by ,
            'canceled_reason'=>$this->patient_registrationDetails->canceled_reason ,
        ];
        $this->patient_MedicalAttachments=MedicalAttachments::where('booking_id', $booking_id)->get();
        $this->bookingTransactions=app_bookingTransactions::where('booking_id', $booking_id)->get();
    }

    public function save_booking_registrationDetails()
    {
        $this->success_message='';
        $this->error_message= '';
        $flag=0;
        if (!$this->p_data['p_name']) {
            $this->error_message= 'Patient name is required.';
            $flag=1;
        } elseif (!$this->p_data['p_phone1']) {
            $this->error_message= 'Patient phone1 is required.';
            $flag=1;
        } elseif (!$this->p_data['p_sex']) {
            $this->error_message= 'Patient sex is required.';
            $flag=1;
        } elseif (!$this->p_data['visit_date']) {
            $this->error_message= 'Home visit date is required.';
            $flag=1;
        } elseif (!$this->p_data['p_age']) {
            $this->error_message= 'Patient age is required.';
            $flag=1;
        } elseif ($this->p_data['status']==7&&$this->p_data['canceled_reason']=='') {
            $this->error_message= 'Canceled reason field is required.';
            $flag=1;
        }

        if ($this->p_data&& $flag==0) {
            if ($this->selected_contract) {
                if ($this->selected_contract<>$this->patient_registrationDetails->contract_id) {
                    //if the new contract is not the same once
                    $this->p_data['contract_id']=$this->selected_contract;
                    $this->p_data['payer_id']=$this->selected_payer['id'];

                    //delete all services if thier is once at app booking sevice price
                    AppBookingSerPrices::where('booking_id', $this->patient_registrationDetails->id)->delete();
                }
            }
            if ($this->p_data['status']==7) {
                $this->p_data['status_en']='Rejected';
                $this->p_data['status_ar']='مرفوض';
                $this->p_data['canceled_by']=Auth::id();
            }

            if ($this->p_data['status']==1) {
                $this->p_data['status_en']='Confirmed';
                $this->p_data['status_ar']='مؤكد';
                $this->p_data['canceled_by']=0;
                $this->p_data['canceled_reason']=null;
            }

            $this->patient_registrationDetails->update($this->p_data);

            //update booking transaction table
            app_bookingTransactions::create([
                'booking_id'=>$this->patient_registrationDetails->id ,
                'edit_by'=>Auth::id() ,
                'patient_info'=>1 ,
                'edit_type'=> 'Edit'
            ]);
            $this->success_message= 'Appointment edited successfully!!';
            // refresh page
            Redirect::to('homeservices?pagename=servicesDetails&booking_id='.$this->patient_registrationDetails->id);
        }
    }


    /*********************** service data ******************* */

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


    public function add_service($service)
    {
        if (count($this->getErrorBag()->all()) > 0) {//reset validation error message
            $this->resetErrorBag();
        }

        //check id this service in add befor in previous_patient_services
        $f=0;
        foreach ($this->previous_patient_services as $key => $previous_service) {
            if ($service['id'] == $previous_service['service']['id']) {
                $f=1;
                break;
            }
        }
        if ($f==0) {
            $this->selected_cpls = Contracts_price_list_settings::where('contract_id', $this->registration_details->contract->id)->first();

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
                        if ($new_service_test['test']['gender']!==$this->registration_details->p_sex && $new_service_test['test']['gender']!=="All") {
                            $flag=1;
                            session()->flash('Error', "Sorry, the test at (".$service['name_en'].") service is not available to this kind of gender (".$this->registration_details->p_sex.")!!");
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
                            if ($new_service_test['test']['gender']!==$this->registration_details->p_sex && $new_service_test['test']['gender']!=="All") {
                                session()->flash('Error', "Sorry, the test at (".$service['nested_service']['name_en'].") service is not available to this kind of gender (".$this->registration_details->p_sex.")!!");
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
        } else {
            session()->flash('Error', "Sorry, this service (".$service['name_en'].") already added!! ");
        }
    }

    public function calculate_total()
    {
        if (count($this->getErrorBag()->all()) > 0) {//reset validation error message
            $this->resetErrorBag();
        }

        $this->Total_Cash_Required=$this->registration_details->home_vist_price;
        $this->Total_Credit_Required=0;

        $Credit_amount=0;
        $i=0;
        foreach ($this->patient_services as $key => $service) {
            $this->Total_Cash_Required=$this->Total_Cash_Required + ($service['current_price'] * $this->selected_cpls['cash_ratio']) / 100;
            $Credit_amount=($service['current_price'] * $this->selected_cpls['credit_ratio']) / 100;
            $this->Total_Credit_Required=$this->Total_Credit_Required + $Credit_amount;
            $i=$key;
        }

        foreach ($this->previous_patient_services as $key => $service) {
            $this->Total_Cash_Required=$this->Total_Cash_Required + $service['service_price'];
            $this->Total_Credit_Required=$this->Total_Credit_Required + $service['service_price_credit'];
        }

        /*foreach ($this->patient_extra_services as $key => $extra_service) {
            $this->Total_Cash_Required=$this->Total_Cash_Required + $extra_service['current_price'];
        }*/

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

    public function delete_previous_service($i)
    {
        unset($this->previous_patient_services[$i]);
        $this->calculate_total();
    }

    public function save_booking_servicesDetails()
    {
        $booking_id= $this->registration_details->id;
        //delete all services if thier is once at app booking sevice price
        if ($this->patient_services||$this->previous_patient_services) {
            AppBookingSerPrices::where('booking_id', $this->registration_details->id)->delete();
        }

        //save the selected services prices and name
        foreach ($this->patient_services as $key => $patient_service) {
            $service_price_cash=   ($patient_service['current_price'] * $this->selected_cpls['cash_ratio']) / 100;
            $service_price_credit=   ($patient_service['current_price'] * $this->selected_cpls['credit_ratio']) / 100;
            AppBookingSerPrices::create([
            'booking_id' => $this->registration_details->id,
            'service_id' =>  $patient_service['service']['id'],
            'service_price' =>  $service_price_cash,
            'service_price_credit' =>  $service_price_credit,
        ]);
        }

        foreach ($this->previous_patient_services as $key => $service) {
            AppBookingSerPrices::create([
                'booking_id' => $service['booking_id'],
                'service_id' =>  $service['service_id'],
                'service_price' =>  $service['service_price'],
                'service_price_credit' => $service['service_price_credit'],
            ]);
        }

        //edit the order status if the status 0 => new order
        if ($this->registration_details->status==0) {
            $this->registration_details->update([
                'total' =>  $this->Total_Cash_Required,
                'remaining' =>  $this->Total_Cash_Required,
                'status' => 1,
                'status_en' =>  'Confirmed',
                'status_ar' =>  'مؤكد',
            ]);
        } else {
            $this->registration_details->update([
                'total' =>  $this->Total_Cash_Required,
                'remaining' =>  $this->Total_Cash_Required,
            ]);
        }

        //update booking transaction table
        app_bookingTransactions::create([
            'booking_id'=>$this->registration_details->id ,
            'edit_by'=>Auth::id() ,
            'patient_services'=>1 ,
            'edit_type'=> 'Edit'
        ]);

        // refresh page
        Redirect::to('homeservices?pagename=servicesDetails&booking_id='.$this->registration_details->id);
        $this->success_message= 'Appointment edited successfully!!';
    }


    public function add_payment()
    {
        // $this->payment_transactions=appPaymentTransactions::where('booking_id', $booking_id)->get();


        if ($this->payment_amount>0) {
            //Transaction type
            if ($this->transaction_type=="Payment") {
                //updaet the main jobe order detals
               // dd($this->registration_details->remaining);
                if ($this->payment_amount<=$this->registration_details->remaining) {
                    $registration_details = AppBooking::where('id', $this->registration_details->id);
                    //update the payment status
                    $remaining=$this->registration_details->remaining -  $this->payment_amount;
                    $payment_status=0;
                    if ($remaining==0) {//full payment
                        $payment_status=1;
                    }
                    $registration_details->update([
                    'remaining' =>abs($this->registration_details->remaining -  $this->payment_amount) ,
                    'paid' =>  $this->payment_amount + $this->registration_details->paid,
                    'payment_status'=>  $payment_status,
                        ]);


                    appPaymentTransactions::create([
                                'booking_id' =>  $this->registration_details->id,
                                'transaction_type' => $this->transaction_type,
                                'payment_method' =>  $this->payment_method,
                                'amount' =>  $this->payment_amount,
                                'created_by' =>  Auth::id(),
                            ]);
                    //reset value of payments
                    $this->transaction_type='';
                    $this->payment_method='';
                    $this->payment_amount=0;
                    // refresh page
                    $this->success_message= 'Operation Successful!';

                    Redirect::to('homeservices?pagename=servicesDetails&booking_id='.$this->registration_details->id);
                // session()->flash('add', "Operation Successful!");
                } else {
                    //session()->flash('Error', "Payment transaction error.");
                    $this->error_message= 'Payment transaction error.';
                }
            } else {//Refund transaction
                //updaet the main jobe order detals
                if ($this->payment_amount<=$this->registration_details->paid) {
                    //$home_vist_price=$this->registration_details->total-$this->registration_details->home_vist_price-$this->registration_details->paid;

                    // if($home_vist_price<=$this->registration_details->home_vist_price){//home visit fee cant return
                    //update the payment status
                    $payment_status=0;
                    $registration_details = AppBooking::where('id', $this->registration_details->id);
                    $registration_details->update([
                    'remaining' =>abs($this->payment_amount +  $this->registration_details->remaining),
                    'paid' => abs($this->payment_amount - $this->registration_details->paid),
                    'payment_status'=>  $payment_status,
                        ]);



                    appPaymentTransactions::create([
                                'booking_id' =>  $this->registration_details->id,
                                'transaction_type' => $this->transaction_type,
                                'payment_method' =>  $this->payment_method,
                                'amount' =>  $this->payment_amount,
                                'created_by' => Auth::id()
                            ]);
                    //reset value of payments
                    $this->transaction_type='';
                    $this->payment_method='';
                    $this->payment_amount=0;
                    // refresh page
                    Redirect::to('homeservices?pagename=servicesDetails&booking_id='.$this->registration_details->id);
                    session()->flash('add', "Operation Successful!");
                // } else {
                  //      session()->flash('Error', "Home visit fee cant refund.");
                //  }
                } else {
                    $this->error_message= 'Payment transaction error.';
                }
            }

            //$this->registration_details->total_Credit_Required
        }
    }
    public function receive_home_visit()
    {
        $registration_details = AppBooking::where('id', $this->registration_details->id);
        $registration_details->update([
            'status' => 5,
            'status_en' =>  'COMPLETED',
            'status_ar' =>  'مكتمل',
                    ]);

        //update booking transaction table
        app_bookingTransactions::create([
           'booking_id'=>$this->registration_details->id ,
           'edit_by'=>Auth::id() ,
           'patient_services'=>1 ,
           'edit_type'=> 'Samples received'
        ]);
        $this->success_message= 'Samples received successfully!!';
    }


    public function generateACCNumber()
    {
        $last_sample_id= AppBooking::orderBy('created_at', 'DESC')->first();
        if ($last_sample_id) {
            $new_sample_id= $last_sample_id->id+1;
        } else {
            $new_sample_id= 1;
        }
        $number =90000+$new_sample_id;
        return $number;
    }


    public function AppReviews()
    {
        $this->users_reviews= Review::all();//orderBy('created_at', 'DESC');
        //dd($this->users_reviews);
    }
   

    public function render()
    {
        $this->list_of_gender=['Male' ,'Female'];
        return view('livewire.registration.home-services');
    }
}
