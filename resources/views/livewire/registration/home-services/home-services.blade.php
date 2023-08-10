<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0">Search Home Services
                    </h4>
                </div>
            </div>
            <div class="card-body">
              
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
                <div class="row">
                    <div class="col">
                        <label for="inputName" class="control-label">Reg. Date From: </label>
                        <div class="input-group ">
                            <input class="form-control" format="YYYY-MM-DD" min="2022-01-01T08:30" type="datetime-local"
                                wire:model="dateFrom" required>
                        </div>
                        @error('DOB')
                        <span class="error text-danger ">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col">
                        <label for="inputName" class="control-label">Reg. Date To: </label>
                        <div class="input-group ">
                            <input class="form-control" format="YYYY-MM-DD" min="2022-01-01T08:30" type="datetime-local"
                                wire:model="dateTo" required>
                        </div>
                        @error('DOB')
                        <span class="error text-danger ">{{ $message }}</span>
                        @enderror
                    </div>

                  

                    <div class="col">
                        <label for="inputName" class="control-label">HC ACC No.:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" wire:model="ACC" wire:keydown.enter="searchData" />
                        </div>
                    </div>

                    
                </div>

                <br>
             <div class="row">
                    
 
                <div class="col">
                    <label for="inputName" class="control-label">Areas:</label>
                    <select wire:model.defer="area_id" class="form-control">
                        <option value="" selected>
                            -- Select Area --
                        </option>
                        @foreach ($branches as $branche)
                        <option value="{{ $branche->id }}">
                            {{ $branche->name_en }}
                        </option>
                        @endforeach

                    </select>
                </div>
                    <div class="col">
                        <label for="inputName" class="control-label">Payer:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="{{ $Payer_placeholder }}"
                                wire:model="queryPayer" wire:keydown.escape="mount"
                                wire:keydown.tab="mount" />

                        </div>
                        <div wire:loading wire:target="queryPayer">
                            Searching ...
                        </div>
                        @error('selected_payers')
                        <span class="error text-danger ">{{ $message }}</span>
                        @enderror
                        @if (!empty($queryPayer))
                        <div class="fixed top-0 bottom-0 left-0 right-0" wire:click="mount">
                        </div>
                        <div class="absolute z-10 w-full bg-light rounded-t-none  list-group ">
                            @if (!empty($payers))
                            <ul>
                                @foreach ($payers as $i => $payer)
                                <li style="cursor: pointer;">
                                    <i class="text-success fas fa-check-circle"></i>
                                    <a wire:click="get_Payer_Contract({{ $i }},{{ $payer['id'] }})"
                                        class=" hover:bg-gray-700 list-item {{ $highlightIndex === $i ? 'highlight' : '' }}">

                                        {{ $payer['code'] }} -
                                        {{ $payer['name_en'] }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                            @else
                            <div class="list-item">No payer!</div>
                            @endif
                        </div>
                        @endif
                    </div>

                    <div class="col">
                        <label for="inputName" class="control-label">Contract:</label>
                        <select wire:model="selected_contract" class="form-control">
                            <option value="" selected>
                                -- Select contract --
                            </option>
                            @foreach ($payer_contracts as $contract)
                            <option value="{{ $contract->id }}">
                                {{ $contract->name_en }}
                            </option>
                            @endforeach
                        </select>
                    </div>
{{-- 
                    <div class="col">
                        <label for="inputName" class="control-label">Request status:</label>
                        <select wire:model.defer="selected_booking_status" class="form-control" multiple>
                            @foreach ($booking_status as $status)
                            <option value="{{ $loop->index }}">
                                {{ $status }}
                            </option>
                            @endforeach
    
                        </select>
                    </div>
 --}}                   
                </div>
                <br>
               
                <label for="inputName" class="control-label">Request status:&nbsp;&nbsp; 
                    @if ($selected_booking_status)
                    <button wire:click="unselect_all" class="btn btn-danger">Uncheck all</button>
                    @else
                    <button wire:click="select_all" class="btn btn-primary">Check all</button>
                    @endif
                    </label>
                <div class="row row-sm">
                    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                        <div class="card overflow-hidden sales-card bg-warning"> 
                            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                                <div class="">
                                    <h6 class="mb-3 tx-12 text-white">
                                        <input type="checkbox" wire:model="selected_booking_status" value="0">                                        
                                    </h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <div class="">
                                            <h6 class="mb-3 tx-12 text-white">{{ $booking_status[0] }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                        <div class="card overflow-hidden sales-card bg-purple">
                            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                                <div class="">
                                    <h6 class="mb-3 tx-12 text-white">
                                        <input type="checkbox" wire:model="selected_booking_status" value="1">                                        
                                    </h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <div class="">
                                            <h6 class="mb-3 tx-12 text-white">{{ $booking_status[1] }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                        <div class="card overflow-hidden sales-card bg-success-gradient">
                            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                                <div class="">
                                    <h6 class="mb-3 tx-12 text-white">
                                        <input type="checkbox" wire:model="selected_booking_status" value="2">                                        
                                    </h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <div class="">
                                            <h6 class="mb-3 tx-12 text-white">{{ $booking_status[2] }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                        <div class="card overflow-hidden sales-card bg-warning-gradient">
                            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                                <div class="">
                                    <h6 class="mb-3 tx-12 text-white">
                                        <input type="checkbox" wire:model="selected_booking_status" value="3">                                        
                                    </h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <div class="">
                                            <h6 class="mb-3 tx-12 text-white">{{ $booking_status[3] }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                        <div class="card overflow-hidden sales-card bg-primary-gradient">
                            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                                <div class="">
                                    <h6 class="mb-3 tx-12 text-white">
                                        <input type="checkbox" wire:model="selected_booking_status" value="4">                                        
                                    </h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <div class="">
                                            <h6 class="mb-3 tx-12 text-white">{{ $booking_status[4] }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                        <div class="card overflow-hidden sales-card bg-success">
                            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                                <div class="">
                                    <h6 class="mb-3 tx-12 text-white">
                                        <input type="checkbox" wire:model="selected_booking_status" value="5">                                        
                                    </h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <div class="">
                                            <h6 class="mb-3 tx-12 text-white">{{ $booking_status[5] }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                        <div class="card overflow-hidden sales-card bg-danger">
                            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                                <div class="">
                                    <h6 class="mb-3 tx-12 text-white">
                                        <input type="checkbox" wire:model="selected_booking_status" value="6">                                        
                                    </h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <div class="">
                                            <h6 class="mb-3 tx-12 text-white">{{ $booking_status[6] }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                        <div class="card overflow-hidden sales-card bg-danger">
                            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                                <div class="">
                                    <h6 class="mb-3 tx-12 text-white">
                                        <input type="checkbox" wire:model="selected_booking_status" value="7">                                        
                                    </h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <div class="">
                                            <h6 class="mb-3 tx-12 text-white">{{ $booking_status[7] }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-center">
                    <div wire:loading wire:target="searchData">
                        Searching ...
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <button wire:click="searchData" class="btn btn-primary">Search</button>&nbsp;&nbsp;
                    <button type="button" class="btn btn-danger" wire:click="mount">Rest</button>
                </div>

            </div>
        </div>
    </div>


    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0">Search results
                    </h4>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered mg-b-0 text-md-nowrap">
                        <thead>
                            <tr style="text-align: center">
                                <th>Acc.No.</th>
                                <th>Patient Name(s)</th>
                                <th>Area</th>
                                <th>Patient Phones</th>
                                <th>Visit Date</th>
                                <th>Date & Time</th>
                                <th>Status</th>
                                <th>OPS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <div wire:poll.visible>
                              
                            @if ($search_clicked)
                           
                                {{ now() }}
                                                          
                            @foreach ($registration_details as $key => $registration_detail)
                            <tr style="text-align: center" class="
                            @if ($registration_detail->status == 0)
                            bg-warning
                            @elseif ($registration_detail->status == 2)
                            bg-success-gradient   
                            @elseif ($registration_detail->status == 3)
                            bg-warning-gradient
                              
                            @elseif ($registration_detail->status == 4)
                            bg-primary-gradient   
                            @elseif ($registration_detail->status == 5)
                            bg-success  
                            @elseif ($registration_detail->status == 6)
                            bg-danger   
                            @elseif ($registration_detail->status == 7)
                            bg-danger   
                            @elseif ($registration_detail->status == 1)
                            bg-purple   
                            @endif">
                                <td>{{ $registration_detail->booking_acc }}</td>
                                <td>{{ $registration_detail->p_name }}</td>
                                <td>{{ $registration_detail->area->name_en }}</td>
                                <td>{{ $registration_detail->p_phone1 }} - {{ $registration_detail->p_phone2 }}</td>
                                <td>{{ date('d-m-Y', strtotime($registration_detail->visit_date)) }}</td>
                                <td>{{ date('d-m-Y H:i', strtotime($registration_detail->created_at)) }}</td>
                                <td><b>{{ $registration_detail->status_en }}</b></td>
                                <td>
                                    <a title="patient info." href="homeservices?booking_id={{ $registration_detail->id }}&pagename=registrationDetails" target="_blank"><i
                                class="text-white fas fa-edit"></i></a>
                                &nbsp;&nbsp;
                                <a title="patient services" href="homeservices?booking_id={{ $registration_detail->id }}&pagename=servicesDetails" target="_blank"><i
                                    class="text-white fas fa-info"></i></a>

                                    
                                   {{--  <a href="homeservices?booking_id={{ $registration_detail->id }}&pagename=booking_details" onclick="var popup =window.open(this.href, 'mywin',
                                                    'left=20,top=20,width=900,height=700'); return false; "><i
                                            class="text-info fas fa-info"></i></a>  --}} 
                                </td>
                            </tr>
                            
                            @endforeach
                                 
                            @endif
                        </div>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>