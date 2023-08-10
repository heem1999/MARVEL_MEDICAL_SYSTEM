<?php

namespace App\Http\Livewire\Services;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use  Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\AssignSerToProUnits;
use App\Branches;
use App\Services;
use App\Processing_units;

class AssignServiceToProcessingUnit extends Component
{
    public $services;
    public $branches;
    public $processing_units;
    public $queryService;
    public $queryService_done=false;
    
    public $selected_service_id;
    public $selected_reg_branche_id;
    public $selected_processing_units_id;
    public $done=true;
    public $old_service_processing_units=[];

    public $old_service_processing_units2;

    public function render()
    {
        // $this->services = Services::where('is_nested_services',0)->get();
        $this->branches = Branches::all();
        $this->processing_units = Processing_units::all();
        //$this->old_service_processing_units2 = AssignSerToProUnits::all();
        return view('livewire.services.assign-service-to-processing-unit');
    }

    public function updatedQueryService()
    {
        if (Str::length($this->queryService) >= 1) {
            $this->queryService_done=false;
            $services =  Services::where('is_nested_services', 0)->where('name_en', 'like', '%' . $this->queryService . '%')->orWhere('code', 'like', '%'.$this->queryService. '%')->where('is_nested_services', 0)->get();
            $this->services =$services;
            if (count($this->services) == 0) {
                $this->services =null;
                $this->selected_service_id=0;
                $this->done=true;
            }
        } else {
            $this->queryService_done=true;
            $this->selected_service_id=0;
            $this->done=true;
            //$this->Search();
        }
    }

    public function search_service_by_name($service_id, $code, $service_name)
    {
        $this->queryService=$code.' - '.$service_name;
        $this->queryService_done=true;
        $this->selected_service_id=$service_id;
        $this->Search();
        $this->services =[];
    }

    public function Search()
    {
        if ($this->selected_service_id>0 && $this->selected_reg_branche_id>0) {
            $this->old_service_processing_units = AssignSerToProUnits::where('service_id', $this->selected_service_id)->where('branch_id', $this->selected_reg_branche_id)->get();
            
            if (count($this->old_service_processing_units) == 0) {
                $this->selected_processing_units_id=0;
            } else {
                //get the processing_unit
                $this->selected_processing_units_id=$this->old_service_processing_units->toArray()[0]['processing_unit_id'];
            }
            $this->done=0;
        } else {
            $this->selected_processing_units_id=0;
            $this->done=true;
        }
    }

    public function save()
    {
        if ($this->selected_processing_units_id) {
            if (count($this->old_service_processing_units)>0) {//update the service processing unit
               
                $id=(int)$this->old_service_processing_units->toArray()[0]['id'];
                $AssignSerToProUnits = AssignSerToProUnits::findOrFail($id);
                $AssignSerToProUnits->update([
                    'processing_unit_id' => $this->selected_processing_units_id,
                    'service_id' => $this->selected_service_id,
                    'branch_id' => $this->selected_reg_branche_id,
                ]);
                // $this->selected_service_id=0;
                $this->done=true;
                session()->flash('Add', 'Service was assign successfully to the processing unit!!');
            } else {
                //add the service processing unit
                AssignSerToProUnits::create([
                'processing_unit_id' => $this->selected_processing_units_id,
                'service_id' => $this->selected_service_id,
                'branch_id' => $this->selected_reg_branche_id,
            ]);
                // $this->selected_service_id=0;
                $this->done=true;
                session()->flash('Add', 'Service was assign successfully to the processing unit!! ');
            }
            $this->Search();
        }
    }
}
