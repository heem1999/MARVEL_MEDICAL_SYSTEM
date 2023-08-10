<?php

namespace App\Http\Controllers;

use App\Payers;
use App\Currencies;
use App\payer_contracts;
use App\contract_classifications;
use App\contracts_price_list_settings;
use App\Branches;
use App\Contract_branches;
use App\Price_lists;

use  Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class PayersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payers = Payers::all();
        $currencies = Currencies::all();

        return view('administration.financial.payers.payers', compact('payers', 'currencies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $currencies = Currencies::all();

        return view('administration.financial.payers.add_payer', compact('currencies'));
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
        $is_insurance_ID_required= 0;
        $print_money_receipt= 0;
        $print_result_receipt= 0;
        $print_invoice= 0;
        $patient_email_is_required= 0;
        $send_result_to_patient= 0;
        $send_result_to_payer= 0;
        $credit_limit= 0;
        $expiry_date= null;
        $apply_date= null;
        
        if (isset($request-> isActive)) {
            $isActive = 1;
        }
        if (isset($request-> is_insurance_ID_required)) {
            $is_insurance_ID_required = 1;
        }
       
        if (isset($request-> print_money_receipt)) {
            $print_money_receipt = 1;
        }
        if (isset($request-> print_result_receipt)) {
            $print_result_receipt = 1;
        }
        if (isset($request-> print_invoice)) {
            $print_invoice = 1;
        }
        if (isset($request-> patient_email_is_required)) {
            $patient_email_is_required = 1;
        }
        if (isset($request-> send_result_to_patient)) {
            $send_result_to_patient = 1;
        }
        if (isset($request-> send_result_to_payer)) {
            $send_result_to_payer = 1;
        }
        if (isset($request-> credit_limit)) {
            $credit_limit = $request-> credit_limit;
        }

        if (isset($request-> expiry_date)) {
            $expiry_date = $request-> expiry_date;
            $expiry_date = strtotime($expiry_date);
            $expiry_date = date('Y-m-d', $expiry_date);
        }
        if (isset($request-> apply_date)) {
            $apply_date = $request-> apply_date;
            $apply_date = strtotime($apply_date);
            $apply_date = date('Y-m-d', $apply_date);
        }
        
        
        $validatedData = $request->validate([
            'name_ar' => 'required|unique:payers|max:255',
            'name_en' => 'required|unique:payers|max:255',
            'code' => 'required|unique:payers|max:255',
            'email' => 'nullable|email',
        ], [
            'name_en.unique' =>'Sorry, payers name already exist.',
            'code.unique' =>'Sorry, payers code already used, use another code.',
            'name_en.required' =>'Please enter the payer Name.',
            'code.required' =>'Please enter the payer code.',
            'name_ar.unique' =>'Sorry, payers name already exist.',
            'name_ar.required' =>'Please enter the payer Name.',
        ]);

        payers::create([
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'credit_limit' => $credit_limit,
                'apply_date' => $apply_date,
                'code' => $request->code,
                'expiry_date' => $expiry_date ,
                'is_insurance_ID_required' => $is_insurance_ID_required ,
                'phone' => $request->phone ,
                'email' => $request->email ,
                'active' => $isActive,
                'currency_id' => $request->currency_id ,
                'web_result_password' => $request->web_result_password,
                'print_money_receipt' => $print_money_receipt,
                'print_result_receipt' => $print_result_receipt,
                'print_invoice' => $print_invoice,
                'patient_email_is_required' => $patient_email_is_required,
                'send_result_to_patient' => $send_result_to_patient,
                'send_result_to_payer' => $send_result_to_payer,
                'Created_by' => (Auth::user()->name),
            ]);
        session()->flash('Add', 'Payer add successfully!! ');
        return redirect('/payers');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Payers  $payers
     * @return \Illuminate\Http\Response
     */
    public function show(Payers $payers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Payers  $payers
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $payer = Payers::where('id', $id)->first();
        $currencies = Currencies::all();
        $payer_contracts = payer_contracts::where('payer_id', $id)->get();
        $contract_classifications = contract_classifications::all();
       
        
        return view('administration.financial.payers.edit_payer', compact('payer', 'currencies', 'payer_contracts', 'contract_classifications'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payers  $payers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payers $payers)
    {
        $validatedData = $request->validate([
            'name_en' => 'required:payers|max:255',
            'name_ar' => 'required:payers|max:255',
            'code' => 'required:payers|max:255',
            'email' => 'nullable|email',
        ], [
            'name_en.required' =>'Please enter the payer Name.',
            'code.required' =>'Please enter the payer code.',
            'name_ar.required' =>'Please enter the payer Name.',
        ]);

        //check if code or service name is already exist
        $serv1_name_en = payers::where('name_en', $request->name_en)->where('id', '<>', $request->payer_id)->get();
        $serv1_code = payers::where('code', $request->code)->where('id', '<>', $request->payer_id)->get();

        if (count($serv1_name_en)>0) {
            return back()->withErrors(["other10"=>"Sorry, this service name $request->name_en is already exist."]);
        } elseif (count($serv1_code)>0) {
            return back()->withErrors(['other11'=>'Sorry, service code already used, use another code.']);
        } else {
            $payers = payers::findOrFail($request->payer_id);
            $isActive = 0;
            $is_insurance_ID_required= 0;
            $print_money_receipt= 0;
            $print_result_receipt= 0;
            $print_invoice= 0;
            $patient_email_is_required= 0;
            $send_result_to_patient= 0;
            $send_result_to_payer= 0;
            $credit_limit= 0;
            $expiry_date= null;
            $apply_date= null;
        
            if (isset($request-> isActive)) {
                $isActive = 1;
            }
            if (isset($request-> is_insurance_ID_required)) {
                $is_insurance_ID_required = 1;
            }
            
            if (isset($request-> print_money_receipt)) {
                $print_money_receipt = 1;
            }
            if (isset($request-> print_result_receipt)) {
                $print_result_receipt = 1;
            }
            if (isset($request-> print_invoice)) {
                $print_invoice = 1;
            }
            if (isset($request-> patient_email_is_required)) {
                $patient_email_is_required = 1;
            }
            if (isset($request-> send_result_to_patient)) {
                $send_result_to_patient = 1;
            }
            if (isset($request-> send_result_to_payer)) {
                $send_result_to_payer = 1;
            }
            if (isset($request-> credit_limit)) {
                $credit_limit = $request-> credit_limit;
            }

            if (isset($request-> expiry_date)) {
                $expiry_date = $request-> expiry_date;
                $expiry_date = strtotime($expiry_date);
                $expiry_date = date('Y-m-d', $expiry_date);
            }
            if (isset($request-> apply_date)) {
                $apply_date = $request-> apply_date;
                $apply_date = strtotime($apply_date);
                $apply_date = date('Y-m-d', $apply_date);
            }
            $payers->update([
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'credit_limit' => $credit_limit,
                'apply_date' => $apply_date,
                'code' => $request->code,
                'expiry_date' => $expiry_date ,
                'is_insurance_ID_required' => $is_insurance_ID_required ,
                'phone' => $request->phone ,
                'email' => $request->email ,
                'active' => $isActive,
                'currency_id' => $request->currency_id ,
                'web_result_password' => $request->web_result_password,
                'print_money_receipt' => $print_money_receipt,
                'print_result_receipt' => $print_result_receipt,
                'print_invoice' => $print_invoice,
                'patient_email_is_required' => $patient_email_is_required,
                'send_result_to_patient' => $send_result_to_patient,
                'send_result_to_payer' => $send_result_to_payer,
                'Created_by' => (Auth::user()->name),
            ]);
            session()->flash('Edit', 'Payer edited successfully!! ');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payers  $payers
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->payer_id;
        payers::find($id)->delete();
        session()->flash('delete', 'Payer deleted successfully!!');
        return redirect()->back();
    }

    
    public function add_payer_contract(Request $request)
    {
        $validatedData = $request->validate([
             'name_en' => 'required|unique:payer_contracts|max:255',
             'name_ar' => 'required|unique:payer_contracts|max:255',
             'code' => 'required|unique:payer_contracts|max:255',
         ], [
             'name_en.required' =>'Please enter the contract name.',
             'name_en.unique' =>'This contract is already existed.',
             'code.unique' =>'Sorry, contract code already used, use another code.',
             'code.required' =>'Please enter the contract code.',
             'name_ar.required' =>'Please enter the contract name.',
             'name_ar.unique' =>'This contract is already existed.',
         ]);

        $isActive = 0;
    
        if (isset($request-> isActive)) {
            $isActive = 1;
        }

        payer_contracts::create([
                'name_en' => $request->name_en ,
                'name_ar' => $request->name_en ,
                'code' => $request->code ,
                'payer_id' => $request->payer_id ,
                'classification_id' => $request->classification_id ,
                'max_credit_amount_per_visit' =>  $request->max_credit_amount_per_visit,
                'active' => $isActive,
                'Created_by' => (Auth::user()->name),
                    ]);
        session()->flash('Add', 'Contract add successfully!!');
        return redirect()->back();
    }

    
    public function delete_payer_contract(Request $request)
    {
        $id = $request->contract_id;
        payer_contracts::find($id)->delete();
        session()->flash('delete', 'Contract deleted successfully!!');
        return redirect()->back();
    }
    
    public function edit_payer_contract(Request $request)
    {
        $validatedData = $request->validate([
             'name_en' => 'required:payer_contracts|max:255',
             'name_ar' => 'required:payer_contracts|max:255',
             'code' => 'required:payer_contracts|max:255',
         ], [
             'name_en.required' =>'Please enter the contract name.',
             'name_ar.required' =>'Please enter the contract name.',
             'code.required' =>'Please enter the contract code.',
         ]);


         
        //check if code or service name is already exist
        $serv1_name_en = payer_contracts::where('name_en', $request->name_en)->where('id', '<>', $request->contract_id)->get();
        $serv1_code = payer_contracts::where('code', $request->code)->where('id', '<>', $request->contract_id)->get();

        if (count($serv1_name_en)>0) {
            return back()->withErrors(["other10"=>"Sorry, this contract name $request->name_en is already exist."]);
        } elseif (count($serv1_code)>0) {
            return back()->withErrors(['other11'=>'Sorry, contract code already used, use another code.']);
        } else {
            $payer_contracts = payer_contracts::findOrFail($request->contract_id);

            $isActive = 0;
    

            if (isset($request-> isActive)) {
                $isActive = 1;
            }

            $payer_contracts->update([
                'name_en' => $request->name_en ,
                'code' => $request->code ,
                'name_ar' => $request->name_ar ,
                //'payer_id' => $request->payer_id ,
                'classification_id' => $request->classification_id ,
                'max_credit_amount_per_visit' =>  $request->max_credit_amount_per_visit,
                'active' => $isActive,
                'Created_by' => (Auth::user()->name),
                    ]);
            session()->flash('Edit', 'Contract edited successfully!!');
            return redirect()->back();
        }
    }

    public function contract_price_list_settings($id)
    {
        $branches = Branches::all();
        $contract = payer_contracts::where('id', $id)->first();
        $contract_price_list_settings = contracts_price_list_settings::where('contract_id', $id)->get();
        $Contract_branches = contract_branches::all();
        $price_lists= Price_lists::all();
        
        return view('administration.financial.payers.contract_price_list_settings', compact('contract', 'branches', 'contract_price_list_settings', 'Contract_branches', 'price_lists'));
    }
    
    
    public function add_price_list_to_contract(Request $request)
    {
        $cash_ratio= $request->cash_ratio*100;
        $credit_ratio= $request->credit_ratio*100;
        contracts_price_list_settings::create([
                'contract_id' => $request->contract_id ,
                'price_list_id' => $request->price_list_id ,
                'cash_ratio' => $cash_ratio ,
                'credit_ratio' => $credit_ratio ,
                    ]);

        $contract_price_list_setting_id= contracts_price_list_settings::where('contract_id', $request->contract_id)->where('price_list_id', $request->price_list_id)->first();
        foreach ($request->branches_ids as $key => $branch_id) {
            contract_branches::create([
                'branch_id' => $branch_id ,
                'contract_price_list_setting_id' => $contract_price_list_setting_id->id ,
                    ]);
        }
        session()->flash('Add', 'Price list add successfully to the contract!!');
        return redirect()->back();
    }

    public function delete_price_list_from_contract(Request $request)
    {
        $id = $request->cpls_id;
        contracts_price_list_settings::find($id)->delete();
        contract_branches::where('contract_price_list_setting_id', $id)->delete();
        session()->flash('delete', 'Price list deleted successfully form the contract!!');
        return redirect()->back();
    }

    public function edit_price_list_contract(Request $request)
    {
        $contracts_price_list_settings= contracts_price_list_settings::find($request->cpls_id);
        
        $cash_ratio= $request->cash_ratio*100;
        $credit_ratio= $request->credit_ratio*100;
        $contracts_price_list_settings->update([
                'price_list_id' => $request->price_list_id ,
                'cash_ratio' => $cash_ratio ,
                'credit_ratio' => $credit_ratio ,
                    ]);

        //delete all branches and add new ones
        contract_branches::where('contract_price_list_setting_id', $request->cpls_id)->delete();

        foreach ($request->branches_ids as $key => $branch_id) {
            contract_branches::create([
                'branch_id' => $branch_id ,
                'contract_price_list_setting_id' => $request->cpls_id ,
                    ]);
        }
        session()->flash('Edit', 'Price list edited successfully for the contract!!');
        return redirect()->back();
    }
}
