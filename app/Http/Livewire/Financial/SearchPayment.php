<?php

namespace App\Http\Livewire\Financial;

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
use App\Branches;
use App\user;

class SearchPayment extends Component
{
    public $link_data;
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
    public $page='';
    public $selectedbranchid;
    public $payment_method='';
    public $transaction_type='';
    public $selected_user_id='';
    
    
    public $users=[];
    public $registered_serv_prices=[];
    public $excluded_services=[];

    public $Report_Form_Types=['View_Financial_Brief'=>'Financial Claim Brief','View_Financial_Claim'=>'Financial Claim Details'];
    public $selected_Report_Form_Type='View_Financial_Brief';
    public function mount()
    {
        $this->link_data = '';
        $this->payment_method = '';
        $this->transaction_type = '';
        $this->selected_user_id = '';
        $this->selectedbranchid = '';
        
        $this->dateFrom = '';
        $this->dateTo = '';
        $this->ACC='';
        $this->branches = Branches::all();
        
        $this->branch_id='';
        $this->Patient_id='';

        $this->users=[];

        $this->registration_details=[];
        $this->reset_values();
        $this->reset_queryPayer();
        $this->search_clicked=false;

        $page=request('pagename');
        if (!$this->page) {
            $this->page=$page;
        }
        
        if ($page=='Receipt_List') {
            $this->page=$page;
            
            // $this->Culture_result(request('rsbst_id'));
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

        $x=['acc'=>$this->ACC,'patient_id'=> $this->Patient_id,'branch_id'=> $this->branch_id];
       // $x=['payer_id'=>$payer_contracts[0]['payer_id'] ,'acc'=>$this->ACC,'patient_id'=> $this->Patient_id,'branch_id'=> $this->branch_id,'contract_id'=>$this->selected_contract];
        
        if (!$this->ACC) {
            unset($x['acc']);
        }
        if (!$this->Patient_id) {
            unset($x['patient_id']);
        }
        if (!$this->branch_id) {
            unset($x['branch_id']);
        }
        /*if (!$this->selected_contract) {
            unset($x['contract_id']);
        }
        if (!$this->payer_contracts) {
            unset($x['payer_id']);
        }*/
        if ($x && $this->dateFrom=='') {
            $this->registration_details=registrations_details::where($x)->get();
        } elseif ($this->dateFrom) {
            if ($this->dateTo) {
                $this->dateFrom=Carbon::parse(Carbon::parse($this->dateFrom))->format('Y-m-d 00:00');
                $this->dateTo=Carbon::parse(Carbon::parse($this->dateTo))->format('Y-m-d 23:59');
                $this->registration_details=registrations_details::whereBetween('created_at', [$this->dateFrom, $this->dateTo])->where($x)->get();
            } else {
                session()->flash('Error', "Reg. date field (To) is empty.");
            }
        }
       
        if (count($this->registration_details)>0) {
            $this->search_clicked=true;
        }else{
            session()->flash('Error', "No data found.");
        }
    }

    public function searchData_Financial_Claim()
    {
        session()->flash('Error', null);
        $this->registration_details=[];
        $this->search_clicked=false;
        $this->registered_serv_prices=registered_serv_prices::all();
        $this->excluded_services=[];
        
        if (!$this->payer_contracts) {
            session()->flash('Error', "Payer field is required.");
        } else {
            $x=['payer_id'=> $this->payer_contracts[0]['payer_id'],'branch_id'=> $this->branch_id,'contract_id'=>$this->selected_contract];
        
            if (!$this->branch_id) {
                unset($x['branch_id']);
            }
            if (!$this->selected_contract) {
                unset($x['contract_id']);
            }
            if ($this->dateFrom) {
                if ($this->dateTo) {
                    $this->dateFrom=Carbon::parse(Carbon::parse($this->dateFrom))->format('Y-m-d 00:00');
                    $this->dateTo=Carbon::parse(Carbon::parse($this->dateTo))->format('Y-m-d 23:59');
                    $this->registration_details=registrations_details::whereBetween('created_at', [$this->dateFrom, $this->dateTo])->where($x)->get();
                } else {
                    session()->flash('Error', "Reg. date field (TO) is empty.");
                }
            } else {
                session()->flash('Error', "Reg. date field (From) is empty.");
            }
        }
        
        if (count($this->registration_details)>0) {
            $this->search_clicked=true;
        }else{
            session()->flash('Error', "No data found.");
        }
    }

    public function excluded_services_from_Claim($id)
    {
        $flag=-1;
        foreach ($this->excluded_services as $key => $excluded_service_id) {
            if ($excluded_service_id==$id) {
                $flag=$key;
                break;
            }
        }
        if ($flag==-1) {
            $this->excluded_services[]=$id;
        } else {
            unset($this->excluded_services[$flag]);
        }
    }
    
    public function updatedSelectedbranchid()
    {
        $this->users=[];
        $this->users=user::Where('branch_id', $this->selectedbranchid)->get();
    }
  
    public function render()
    {
        return view('livewire.financial.search-payment');
    }
}
