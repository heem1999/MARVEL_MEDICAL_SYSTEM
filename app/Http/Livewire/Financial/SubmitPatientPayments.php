<?php

namespace App\Http\Livewire\Financial;

use  Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

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
use App\registration_payment_transaction;
use App\extra_services;
use App\registered_serv_ex_prices;


use Illuminate\Http\Request;

class SubmitPatientPayments extends Component
{
    public $ACC;
    public $registration_details;
    public $patient_services;
    public $patient_extra_services;
    public $patient_data=[];
    public $total_amout=0;
    public $total_cash=0;
    public $total_credit=0;
    public $Discount_mark='';
    public $discount_amount=0;
    public $payment_amount=0;
    public $payment_method='';
    public $transaction_type='';
    public $payment_transactions=[];

    
    public function mount()
    {
        if (request('acc')) {
            $this->ACC=request('acc');
        }
       
        //get job order details be ACC
        $this->registration_details = registrations_details::where('acc', $this->ACC)->first();
        if ($this->registration_details) {
            //get Patient details
            $this->patient_data = registrations::where('id', $this->registration_details->patient_id)->first();

            //get job order services details ->Where('isCanceled', false)
            $this->patient_services = registered_serv_prices::where('acc', $this->ACC)->get();
            //get job order services details ->Where('isCanceled', false)
            $this->patient_extra_services = registered_serv_ex_prices::where('acc', $this->ACC)->get();

            //get job order payment transactions details
            $this->payment_transactions=registration_payment_transaction::where('acc', $this->ACC)->orderBy('id', 'DESC')->get();

            //calculate the total job order amount
            $this->total_amout=0;
            foreach ($this->patient_services as $key => $patient_service) {
                $this->total_amout=$this->total_amout+$patient_service['current_price'];
                // $this->total_cash=$this->total_cash+$patient_service['service_price_cash'];
                // $this->total_credit=$this->total_credit+$patient_service['service_price_credit'];
            }
            foreach ($this->patient_extra_services as $key => $patient_extra_service) {
                $this->total_amout=$this->total_amout+$patient_extra_service['current_price'];
            }
        } else {
            session()->flash('Error', "Wrong payment details.");
        }
    }

    public function Discount_type($type)
    {
        $this->discount_amount=0;
        if ($type=="Absolute") {
            $this->Discount_mark='SDG';
        } else {
            $this->Discount_mark='%';
        }
    }

    public function add_payment()
    {
        if ($this->payment_amount>0) {

            //Transaction type
            if ($this->transaction_type=="Payment") {

//updaet the main jobe order detals
                if ($this->payment_amount<=$this->registration_details->remaining) {
                    $registration_details = registrations_details::where('acc', $this->ACC);
                    $registration_details->update([
                    'remaining' =>abs($this->registration_details->remaining -  $this->payment_amount) ,
                    'paid' =>  $this->payment_amount + $this->registration_details->paid
                        ]);

                    registration_payment_transaction::create([
                                'acc' => $this->ACC,
                                'transaction_type' => $this->transaction_type,
                                'payment_method' =>  $this->payment_method,
                                'amount' =>  $this->payment_amount,
                                'Created_by' =>  (Auth::user()->id),
                                'branch_id' => (Auth::user()->branch->id)
                            ]);
                    //reset value of payments
                    $this->transaction_type='';
                    $this->payment_method='';
                    $this->payment_amount=0;
                    $this->mount();
                    session()->flash('add', "Operation Successful!");
                } else {
                    session()->flash('Error', "Payment transaction error.");
                }
            } else {//Refund transaction

                //updaet the main jobe order detals
                if ($this->payment_amount<=$this->registration_details->paid) {
                    $registration_details = registrations_details::where('acc', $this->ACC);
                    $registration_details->update([
                    'remaining' =>abs($this->payment_amount +  $this->registration_details->remaining),
                    'paid' => abs($this->payment_amount - $this->registration_details->paid)
                        ]);

                    registration_payment_transaction::create([
                    'acc' => $this->ACC,
                    'transaction_type' => $this->transaction_type,
                    'payment_method' =>  $this->payment_method,
                    'amount' =>  $this->payment_amount,
                    'Created_by' =>  (Auth::user()->id),
                    'branch_id' => (Auth::user()->branch->id)
                ]);
                    //reset value of payments
                    $this->transaction_type='';
                    $this->payment_method='';
                    $this->payment_amount=0;

                    $this->mount();
                    session()->flash('add', "Operation Successful!");
                } else {
                    session()->flash('Error', "Payment transaction error.");
                }
            }
                
            //$this->registration_details->total_Credit_Required
        }
    }

    public function Calculate_discount()
    {
        //make the discoun Absolute
        if ($this->Discount_mark=="%") {
            //$this->registration_details->remaining-
            $this->discount_amount=($this->registration_details->remaining*$this->discount_amount)/100 ;
            //dd($this->discount_amount);
        }

        if ($this->discount_amount<=$this->registration_details->remaining) {
        
        //updaet the main jobe order detals
            $registration_details = registrations_details::where('acc', $this->ACC);
            $registration_details->update([
        'remaining' =>$this->registration_details->remaining -  $this->discount_amount,
        'discount' =>  $this->discount_amount
            ]);
            
            registration_payment_transaction::create([
                    'acc' => $this->ACC,
                    'transaction_type' => 'Discount',
                    'payment_method' =>  '-',
                    'amount' =>  $this->discount_amount,
                    'Created_by' =>  (Auth::user()->id),
                    'branch_id' => (Auth::user()->branch->id)
                ]);
            //reset value of payments
            $this->Discount_mark='';
            $this->discount_amount=0;
            $this->mount();
            session()->flash('add', "Operation Successful!");
        } else {
            session()->flash('Error', "Erorr, The remaing payment is less than this discount amount.");
        }
    }
    
    
    public function delete_discount($discount_data)
    {
        $registration_details = registrations_details::where('acc', $discount_data['acc']);
        $registration_details->update([
    'remaining' =>$this->registration_details->remaining +$discount_data['amount'],
    'discount' => 0
        ]);

        registration_payment_transaction::where('id', $discount_data['id'])->delete();
        $this->mount();
        session()->flash('add', "Operation Successful!");
    }

    public function print_Receipt_number()
    {
        Redirect::to('Reprint_Receipt_number?acc='.$this->ACC.'&redirect=reg');
    }
    public function render()
    {
        return view('livewire.financial.submit-patient-payments');
    }
}
