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

class SearchRegistration extends Component
{
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
    public $registration_details=[];
    public $patient_placeholder;
    public $search_clicked=false;

    public function mount()
    {
        $this->dateFrom = '';
        $this->dateTo = '';
        $this->ACC='';
        $this->branches = Branches::all();
        
        $this->branch_id='';
        $this->Patient_id='';

        $this->registration_details=[];
        $this->reset_values();
        $this->reset_queryPayer();
        $this->search_clicked=false;
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
        session()->flash('Error', null);
        $this->registration_details=[];
        $this->search_clicked=false;
        $payer_id='';
        if ($this->payer_contracts) {
            $payer_id=$this->payer_contracts[0]['payer_id'];
        }
        $x=['payer_id'=>$payer_id ,'acc'=>$this->ACC,'patient_id'=> $this->Patient_id,'branch_id'=> $this->branch_id,'contract_id'=>$this->selected_contract];

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

        if (!$this->payer_contracts) {
            unset($x['payer_id']);
        }


        if ($x && $this->dateFrom=='') {
            $this->registration_details=registrations_details::where($x)->orWhere('created_at', '>=', $this->dateFrom)->Where('created_at', '<=', $this->dateTo)->get();
        } elseif ($this->dateFrom) {
            $dateFrom=Carbon::parse(Carbon::parse($this->dateFrom)->toDateString())->format('Y-m-d');
            $time = strtotime($dateFrom);
            $dateFrom = date('Y-m-d 00:00', $time);
            $dateFrom_to = date('Y-m-d 23:59', $time);

            if ($this->dateTo) {
                $dateTo=Carbon::parse(Carbon::parse($this->dateTo)->toDateString())->format('Y-m-d');
                $time = strtotime($dateTo);
                $dateTo = date('Y-m-d 23:59', $time);
                $this->registration_details=registrations_details::whereBetween('created_at', [$dateFrom, $dateTo])->where($x)->get();
            } else {
                $this->registration_details=registrations_details::whereBetween('created_at', [$dateFrom, $dateFrom_to])->where($x)->get();
            }
        }
       

        if (count($this->registration_details)>0) {
            $this->search_clicked=true;
        }
    }
    public function render()
    {
        return view('livewire.registration.search-registration');
    }
}