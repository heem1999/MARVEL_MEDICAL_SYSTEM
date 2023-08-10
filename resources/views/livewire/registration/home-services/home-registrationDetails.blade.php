<div class="row row-sm">
    <div class="col-xl-12">
        <!-- div -->
        <div class="card mg-b-20" id="tabs-style2">
            <div class="text-wrap">
                <div class="example">
                    <div class="panel panel-primary tabs-style-2">
                        <div class=" tab-menu-heading">
                            <div class="tabs-menu1">
                                <!-- Tabs -->
                                <ul class="nav panel-tabs main-nav-line">
                                    <li><a href="#tab1" class="nav-link active" data-toggle="tab">Patient
                                            Info.</a>
                                    </li>
                                    <li><a href="#tab2" class="nav-link" data-toggle="tab">Attachments</a>
                                    </li>
                                    <li><a href="#tab3" class="nav-link" data-toggle="tab">Appointment Transactions </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body tabs-menu-body main-content-body-right border">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab1">

                                    @if ($error_message)
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ $error_message }}
                                    </div>
                                    @endif
                                    @if ($success_message)
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>{{ $success_message }}</strong>
                                    </div>
                                    @endif

                                    <div wire:poll.visible>

                                    <div class="row">
                                        <div class="col">
                                            <label for="inputName" class="control-label">Patient Name: <b
                                                    class="text-danger fas">*</b></label>
                                            <input type="text" class="form-control"
                                                wire:model="p_data.p_name" required>
                                            @error('patient_name')
                                                <span class="error text-danger ">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col">
                                            <label for="inputName" class="control-label">Gender: <b
                                                    class="text-danger fas">*</b></label>
                                            <select wire:model.defer="p_data.p_sex" class="form-control ">
                                               
                                                @foreach ($list_of_gender as $gender)
                                                    <option value="{{ $gender }}" selected>
                                                        {{ $gender }}
                                                    </option>
                                                @endforeach

                                            </select>
                                            @error('gender')
                                                <span class="error text-danger ">{{ $message }}</span>
                                            @enderror
                                        </div>
                                       
                                        <div class="col">
                                            <label for="inputName" class="control-label">Areas: <b
                                                    class="text-danger fas">*</b></label>
                                            <select wire:model.defer="p_data.area_id" class="form-control ">
                                               
                                                @foreach ($branches as $area)
                                                    <option value="{{ $area->id }}">
                                                        {{ $area->name_en }}
                                                    </option>
                                                @endforeach

                                            </select>
                                            @error('gender')
                                                <span class="error text-danger ">{{ $message }}</span>
                                            @enderror
                                        </div>
                                   
                                        
                                            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                                                <div class="card overflow-hidden sales-card 
                                                
                            @if ($patient_registrationDetails->status == 0)
                            bg-warning
                            @elseif ($patient_registrationDetails->status == 2)
                            bg-success-gradient   
                            @elseif ($patient_registrationDetails->status == 3)
                            bg-warning-gradient
                              
                            @elseif ($patient_registrationDetails->status == 4)
                            bg-primary-gradient   
                            @elseif ($patient_registrationDetails->status == 5)
                            bg-success  
                            @elseif ($patient_registrationDetails->status == 6)
                            bg-danger   
                            @elseif ($patient_registrationDetails->status == 7)
                            bg-danger   
                            @elseif ($patient_registrationDetails->status == 1)
                            bg-purple   
                            @endif">
                                                    <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                                                        <div class="">
                                                            <h6 class="mb-3 tx-12 text-white">Status: </h6>
                                                        </div>
                                                        <div class="pb-0 mt-0">
                                                            <div class="d-flex">
                                                                <div class="">
                                                                    <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $patient_registrationDetails->status_en }}</h4>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <label for="inputName" class="control-label">Change Status :</label>
                                                    <select wire:model.defer="p_data.status" class="form-control">
                                                        <option value="">
                                                            -- Select the status  --
                                                        </option>
                                                        @foreach ($booking_status as $key=> $status)
                                                        @if ($key==7||$key==1)
                                                        <option value="{{ $key }}">
                                                            {{ $status }}
                                                        </option>
                                                        @endif
                                                           
                                                        @endforeach
                
                                                    </select>
                                                    @error('selected_contract')
                                                        <span class="error text-danger ">{{ $message }}</span>
                                                    @enderror
                                                </div>  
                                            </div>
                                        

                                    </div>
                                    @if ($p_data['status']==7)
                                    <div class="row">
                                        <div class="col">
                                            <label for="inputName" class="control-label">Canceled reason:</label>
                                            <br>
                                            <textarea style="border: ridge 2px;
                                            padding: 5px;
                                            width: 100%;
                                            min-height: 5em;
                                            overflow: auto;" wire:model.defer="p_data.canceled_reason" placeholder="Comment...">
                                            </textarea>
                                        </div>
                                    </div>
                                    @endif
                                    
                                    <br>
                                
                                    <div class="row">
                                        <div class="col">
                                            <label for="inputName" class="control-label">Age:</label>
                                            <input type="text" class="form-control"
                                                wire:model.lazy="p_data.p_age" required>
                                        </div>
                                        <div class="col">
                                            <label for="inputName" class="control-label">Phone1:</label>
                                            <input type="text" class="form-control"
                                                wire:model.lazy="p_data.p_phone1" required>
                                        </div>
                                        <div class="col">
                                            <label for="inputName" class="control-label">Phone2:</label>
                                            <input type="text" class="form-control"
                                                wire:model.lazy="p_data.p_phone2">
                                        </div>
                                        <div class="col">
                                            <label for="inputName" class="control-label">Visit Date:</label>
                                           
                                                <div class="input-group ">
                                                    <input class="form-control" type="date" wire:model="p_data.visit_date"
                                                    required>
                                                </div>
                                        </div>
                                    </div>
                               <br>
                               <div class="row">
                                <div class="col">
                                    <label for="inputName" class="control-label">Processing by (Home service lab technician): 
                                    </label>
                                    <b>
                                        @if ($patient_registrationDetails->LabTech_id!==0)
                                        <label for="inputName"
                                        class="control-label">{{ $patient_registrationDetails->LabTechUser->name_en }}
                                    </label>
                                        @else
                                        <label for="inputName"
                                        class="control-label"> -- Not assigned yet -- 
                                    </label>
                                        @endif
                                       
                                    </b>
                                </div>

                                <div class="col">
                                    <label for="inputName" class="control-label">Manual assign :</label>
                                    <select wire:model.defer="p_data.LabTech_id" class="form-control">
                                        <option value="0">
                                            -- Select the technician  --
                                        </option>
                                        @foreach ($lab_tech_users as $user)
                                            <option value="{{ $user->id }}">
                                                {{ $user->name_en }}
                                            </option>
                                        @endforeach

                                    </select>
                                    @error('selected_contract')
                                        <span class="error text-danger ">{{ $message }}</span>
                                    @enderror
                                </div>  

                               </div>
                                    <br>
                                    <div class="row">
                                       
                                        <div class="col">
                                            <label for="inputName" class="control-label">Current Payer:
                                            </label>
                                            <b>
                                                <label for="inputName"
                                                    class="control-label">{{ $patient_registrationDetails->payer->name_en }} - 
                                                    {{ $patient_registrationDetails->payer->code }}
                                                </label>
                                            </b>
                                        </div>
                                        <div class="col">
                                            <label for="inputName" class="control-label">Current Contract:
                                            </label>
                                            <b>
                                                <label for="inputName"
                                                    class="control-label">{{ $patient_registrationDetails->contract->name_en }} - 
                                                    {{ $patient_registrationDetails->contract->code }}
                                                </label>
                                            </b>
                                        </div>
                                        <hr>
                                    </div>
                                    <br>
                                    <label for="inputName" class="control-label"> <b>Change payer contract:</b> (<b
                                        class="text-danger fas">Attention, changing the contract will erase previously added services, and you can add new services according to the new contract.</b>)</label>
                                    <div class="row">
                                        <div class="col">
                                            <label for="inputName" class="control-label">Payer: <b
                                                    class="text-danger fas">*</b></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control"
                                                    placeholder="{{ $Payer_placeholder }}"
                                                    wire:model="queryPayer"
                                                     />

                                            </div>
                                            @error('selected_payers')
                                                <span class="error text-danger ">{{ $message }}</span>
                                            @enderror
                                            @if (!empty($queryPayer))
                                               
                                                <div
                                                    class="absolute z-10 w-full bg-light rounded-t-none  list-group ">
                                                    @if (!empty($payers))
                                                        <ul>
                                                            @foreach ($payers as $i => $payer)
                                                                @if ($payer->active == 1 && $today <= $payer->expiry_date)
                                                                    <li style="cursor: pointer;">
                                                                        <i
                                                                            class="text-success fas fa-check-circle"></i>
                                                                        <a wire:click="get_Payer_Contract({{ $i }},{{ $payer['id'] }})"
                                                                            class=" hover:bg-gray-700 list-item {{ $highlightIndex === $i ? 'highlight' : '' }}">

                                                                            {{ $payer['code'] }} -
                                                                            {{ $payer['name_en'] }}
                                                                        </a>
                                                                    </li>
                                                                @else
                                                                    <li style="cursor: not-allowed;">
                                                                        <i
                                                                            class="text-danger fas fa-minus-circle"></i>
                                                                        {{ $payer['code'] }} -
                                                                        {{ $payer['name_en'] }}
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <div class="list-item">No payer!</div>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>

                                        <div class="col">
                                            <label for="inputName" class="control-label">Contract: <b
                                                    class="text-danger fas">*</b></label>
                                            <select wire:model.defer="selected_contract" class="form-control">
                                                <option value="">
                                                    -- Select item --
                                                </option>
                                                @foreach ($payer_contracts as $contract)
                                                    <option value="{{ $contract->id }}">
                                                        {{ $contract->name_en }}
                                                    </option>
                                                @endforeach

                                            </select>
                                            @error('selected_contract')
                                                <span class="error text-danger ">{{ $message }}</span>
                                            @enderror
                                        </div>  
                                       
                                    </div>
                        </div>
                        <br>
                                    <div class="d-flex justify-content-center">
                                        <button wire:click="save_booking_registrationDetails" class="btn btn-success">Save</button>&nbsp;&nbsp;
                                    </div>
                                </div>

                               
                                <div class="tab-pane" id="tab2" style="overflow-x: auto; scrollbar-width: thin;scrollbar-gutter: auto;scrollbar-color: rebeccapurple green;">
                                    @if (count($patient_MedicalAttachments)==0)
                                    <label for="inputName" class="control-label">There are no files attached...
                                    </label>
                                    @endif
                                    <div class="col-lg-3 d-flex">
                                    @foreach ($patient_MedicalAttachments as $key => $attachment)
                                   
                                    <a data-toggle="tooltip" data-placement="bottom" title="View attachment details"
                                        class="btn btn-sm btn-white btn-icon m-1"
                                        href="{{ $attachment->attachment }}" target="_blank">
                                        <span class="ul-btn__icon"><i class="fas fa-eye"></i></span>
                                    </a>
                                    <img class="img-thumbnail wd-100p wd-sm-200" src="{{$attachment->attachment}}">
                                    @endforeach
                                </div>
                                </div>

                                <div class="tab-pane" id="tab3">
                                    <br>
                                    
                                    <div class="table-responsive">
                                        <table id="example1" class="table table-hover  mb-0 text-md-nowrap"
                                            data-page-length='50' style="text-align: center">
                                            <thead>
                                                <tr>
                                                    <th class="border-bottom-0">Edited by</th>
                                                    <th class="border-bottom-0">patient info</th>
                                                    <th class="border-bottom-0">Service details</th>
                                                    <th class="border-bottom-0">Transaction Date</th>
                                                    <th class="border-bottom-0">Transaction type</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($bookingTransactions as $key => $Transaction)
                                                <tr>
                                                    <td> {{ $Transaction->edit_by_user->full_name }} </td>
                                                    <td> 
                                                        @if ($Transaction->patient_info==1)
                                                        <i class="text-success fas fa-check-circle"></i>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($Transaction->patient_services==1)
                                                        <i class="text-success fas fa-check-circle"></i>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>{{ date('d-m-Y H:i', strtotime($Transaction->created_at)) }}</td>
                                                    <td>{{ $Transaction->edit_type }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>



    </div>
</div>