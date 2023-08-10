<?php

namespace App\Http\Controllers;

use App\Treasuries;
use App\Branches;
use App\treasury_requests;
use App\Treasury_mac_address;



use Illuminate\Http\Request;
use  Illuminate\Support\Facades\Auth;

class TreasuriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $treasuries = Treasuries::all();
        $branches = Branches::all();
        return view('administration.financial.treasuries.treasuries', compact('branches', 'treasuries'));
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
        $isActive = 0;
        if (isset($request-> isActive)) {
            $isActive = 1;
        }

        $validatedData = $request->validate([
            'name_en' => 'required:treasuries|max:255',
        ], [
            'name_en.required' =>'Please enter the treasury name.',
        ]);
        
        $serv1_name_en = Treasuries::where('name_en', $request->name_en)->where('branch_id', $request->branch_id)->get();
        if (count($serv1_name_en)>0) {
            $name_en_name=$serv1_name_en[0]->branch->name_en;
            return back()->withErrors(["other10"=>"Sorry, this branch ($name_en_name) has the same treasury name ($request->name_en)."]);
        } else {
            treasuries::create([
                'active' => $isActive,
                'name_en' => $request->name_en,
                'branch_id' => $request->branch_id,
                'Created_by' => (Auth::user()->name),
            ]);
            session()->flash('Add', 'Treasury add successfully!! ');
            return redirect()->back();
        }
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
        $isActive = 0;
        if (isset($request-> isActive)) {
            $isActive = 1;
        }

        $validatedData = $request->validate([
            'name_en' => 'required:treasuries|max:255',
        ], [
            'name_en.required' =>'Please enter the treasury name.',
        ]);

        $serv1_name_en = Treasuries::where('name_en', $request->name_en)->where('branch_id', $request->branch_id)->get();
        if (count($serv1_name_en)>0) {
            $name_en_name=$serv1_name_en[0]->branch->name_en;
            return back()->withErrors(["other10"=>"Sorry, this branch ($name_en_name) has the same treasury name ($request->name_en)."]);
        } else {
            $treasuries= Treasuries::find($request->treasury_id);

            $treasuries->update([
                'active' => $isActive,
                'name_en' => $request->name_en,
                'branch_id' => $request->branch_id,
                'Created_by' => (Auth::user()->name),
            ]);
            session()->flash('Edit', 'Treasury edited successfully!! ');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Treasuries  $treasuries
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->treasury_id;
        Treasuries::find($id)->delete();
        session()->flash('delete', 'Treasury deleted successfully!!');
        return redirect()->back();
    }

    public function open_treasuries_requests()
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
        
        $pc_macAddress = $macs;
        return view('administration.financial.treasuries.treasuries_requests', compact('branches', 'pc_macAddress'));
    }

    public function get_branch_treasuries($branch_id)
    {
        $branch_treasuries = Treasuries::where('branch_id', $branch_id)->get();
        return json_encode($branch_treasuries);
    }

    public function new_treasury_request(Request $request)
    {
        $validatedData = $request->validate([
              'treasury_id' => 'required:treasury_requests|max:255',
              'pc_macAddress' => 'required:Treasury_mac_address|max:255',
          ], [
              'treasury_id.required' =>'Please enter the treasury name.',
              'pc_macAddress.required' =>'Please provide the treasury MAC addres.',
          ]);

        //check if this pc have valid treasury
        foreach ($request->pc_macAddress as $key => $pc_macAddr) {
            $Treasury_mac_address = Treasury_mac_address::where('mac_addres', $pc_macAddr)->first();
            if ($Treasury_mac_address) {
                break;
            }
        }
        if ($Treasury_mac_address) {
            $mac_add=$Treasury_mac_address->mac_addres;
            $treasurie_request_id=$Treasury_mac_address->treasurie_request_id;
            //check if the treasury previous status
            $treasurie_previous_request = treasury_requests::where('id', $treasurie_request_id)->where('request_status', 1)->first();
            if ($treasurie_previous_request) {
                $treasury= Treasuries::where('id', $treasurie_previous_request->treasurie_id)->first();
                $name_en= $treasury->name_en;
                $branch_name_en= $treasury->branch->name_en;
                
                return back()->withErrors(["other10"=>"Sorry, this PC is already belong to this treasury ($name_en) on this  ($branch_name_en) branch an it's active."]);
            } else {
                return back()->withErrors(["other10"=>"Sorry, this PC ($mac_add) has make a treasury request before, you can use it or delete that request."]);
            }
        } else {
            treasury_requests::create([
                'request_status' => 0,
                'treasurie_id' => $request->treasury_id,
                'Created_by' => (Auth::user()->name),
            ]);
            $T_request = treasury_requests::where('treasurie_id', $request->treasury_id)->orderBy('id', 'DESC')->first();
           
            foreach ($request->pc_macAddress as $key => $pc_macAddr) {
                Treasury_mac_address::create([
                    'mac_addres' => $pc_macAddr,
                    'treasurie_request_id' => $T_request->id,
                ]);
            }
            session()->flash('Add', 'Treasury request send successfully!! ');
            return redirect()->back();
        }
    }

    public function open_handle_treasuries_requests()
    {
        $branches = Branches::all();
        $treasuries = Treasuries::all();
        $treasury_requests = treasury_requests::all();
        return view('administration.financial.treasuries.handle_treasuries_requests', compact('branches', 'treasuries', 'treasury_requests'));
    }

    public function Search_treasuries_requests($treasury_id)
    {
        $treasury = Treasuries::where('id', $treasury_id)->first();
        $t_request = treasury_requests::where('treasurie_id', $treasury_id)->first();
        if ($t_request) {
            $t_mac_address = Treasury_mac_address::where('treasurie_request_id', $t_request->id)->get();
            $Treasury_details=[
                "Treasury"=> $treasury,
                "t_request"=> $t_request,
                "t_mac_address"=> $t_mac_address,
                "treasury_branch"=> $treasury['branch'],
            ];
            return json_encode($Treasury_details);
        } else {
            return json_encode(null);
        }
    }

    public function update_treasury_request(Request $request)
    {
        $treasury_requests= treasury_requests::find($request->rq_id);
        $rq_old_value=0;
        if ($request->rq_old_value==0) {
            $rq_old_value=1;
        }
        $treasury_requests->update([
            'request_status' => $rq_old_value,
        ]);
        session()->flash('Edit', "Treasury status were changed successfully!!");
        return redirect()->back();
    }

    public function delete_treasury_request(Request $request)
    {
        treasury_requests::find($request->rq_id)->delete();
        Treasury_mac_address::where('treasurie_request_id', $request->rq_id)->delete();
        session()->flash('delete', "Treasury request were deleted successfully!!");
        return redirect()->back();
    }
}
