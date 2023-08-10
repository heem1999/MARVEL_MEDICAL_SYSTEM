
<div class="row row-sm">
    <div class="col-xl-12">
        <!-- div -->
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
        <div class="card mg-b-20" id="tabs-style2">
            <div class="text-wrap">
                <div class="example">
                    <div class="panel panel-primary tabs-style-2">
                        <div class=" tab-menu-heading">
                            <div class="tabs-menu1">
                                <!-- Tabs -->
                                <ul class="nav panel-tabs main-nav-line">
                                    <li><a href="#tab1" class="nav-link active" data-toggle="tab">Patient Services</a>
                                    </li>
                                    <li><a href="#tab2" class="nav-link" data-toggle="tab">Attachments</a>
                                    </li>
                                    <li><a href="#tab3" class="nav-link" data-toggle="tab">Appointment Transactions </a>
                                    </li>
                                    <li><a href="#tab4" class="nav-link" data-toggle="tab">Payments Transactions </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body tabs-menu-body main-content-body-right border">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab1">
                                   
                                    <div class="row">
                                        <div class="col">
                                            <div class="col">
                                                <label for="inputName" class="control-label">Patient Name:
                                                </label>
                                                <b>
                                                    <label for="inputName" class="control-label">{{ $registration_details->p_name }}
                                                    </label>
                                                </b>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label for="inputName" class="control-label">HS-ACC:
                                            </label>
                                            <b>
                                                <label for="inputName"
                                                    class="control-label">{{ $registration_details->booking_acc}}
                                                </label>
                                            </b>
                                        </div>
                                        <div class="col">
                                            <label for="inputName" class="control-label">Payer:
                                            </label>
                                            <b>
                                                <label for="inputName"
                                                    class="control-label">{{ $registration_details->payer->name_en }}
                                                </label>
                                            </b>
                                        </div>
                                        <div class="col">
                                            <label for="inputName" class="control-label">Contract:
                                            </label>
                                            <b>
                                                <label for="inputName"
                                                    class="control-label">{{ $registration_details->contract->name_en }}
                                                </label>
                                            </b>
                                        </div>
                                        <hr>
                                    </div>
                                    <div wire:poll.visible>
                                    <div class="row">
                                        <div class="col">
                                            <label for="inputName" class="control-label">Processing by (Home service lab technician): 
                                            </label>
                                            <b>
                                                @if ($registration_details->LabTech_id!==0)
                                                <label for="inputName"
                                                class="control-label">{{ $registration_details->LabTechUser->name_en }}
                                            </label>
                                                @else
                                                <label for="inputName"
                                                class="control-label"> -- Not assigned yet -- 
                                            </label>
                                                @endif
                                               
                                            </b>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                                            <div class="card overflow-hidden sales-card 
                                            
                        @if ($registration_details->status == 0)
                        bg-warning
                        @elseif ($registration_details->status == 2)
                        bg-success-gradient   
                        @elseif ($registration_details->status == 3)
                        bg-warning-gradient
                          
                        @elseif ($registration_details->status == 4)
                        bg-primary-gradient   
                        @elseif ($registration_details->status == 5)
                        bg-success  
                        @elseif ($registration_details->status == 6)
                        bg-danger   
                        @elseif ($registration_details->status == 7)
                        bg-danger   
                        @elseif ($registration_details->status == 1)
                        bg-purple   
                        @endif">
                                                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                                                    <div class="">
                                                        <h6 class="mb-3 tx-12 text-white">Status: </h6>
                                                    </div>
                                                    <div class="pb-0 mt-0">
                                                        <div class="d-flex">
                                                            <div class="">
                                                                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $registration_details->status_en }}</h4>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                       </div>
                                </div>
                                           
                                            <label for="inputName" class="control-label">
                                                <b>Home visit price calculation according to the appointment area is as follows:</b>
                                            </label>
                                            <div class="row">
                                                
                                                <div class="col">
                                                    <div class="col">
                                                        <label for="inputName" class="control-label">Area:
                                                        </label>
                                                        <b>
                                                            <label for="inputName" class="control-label">{{ $registration_details->area->name_en }}
                                                            </label>
                                                        </b>
                                                    </div>
                                                </div>
        
                                                <div class="col">
                                                    <div class="col">
                                                        <label for="inputName" class="control-label">Fixed price (Minimum):
                                                        </label>
                                                        <b>
                                                            <label for="inputName" class="control-label">{{ number_format($registration_details->area->home_visit_fixed_price) }}
                                                            </label>
                                                        </b>
                                                    </div>
                                                </div>
                                                
                                                <div class="col">
                                                    <div class="col">
                                                        <label for="inputName" class="control-label">Fixed zoon (Minimum):
                                                        </label>
                                                        <b>
                                                            <label for="inputName" class="control-label">{{ $registration_details->area->zone_radius_km/1000 }} KM
                                                            </label>
                                                        </b>
                                                    </div>
                                                </div>

                                                <div class="col">
                                                    <div class="col">
                                                        <label for="inputName" class="control-label">Extra KM price:
                                                        </label>
                                                        <b>
                                                            <label for="inputName" class="control-label">{{ number_format($registration_details->area->ex_km_price) }} SDG
                                                            </label>
                                                        </b>
                                                    </div>
                                                </div>

                                                <hr>
                                            </div>

                                    <div class="row">
                                        <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                                            <label for="inputName" class="control-label">Service code:</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control"
                                                    wire:model.defer="service_code" placeholder="Service code..."
                                                    wire:keydown.enter="search_service_by_code" /><button
                                                    class="btn btn-primary" type="button"><span
                                                        class="input-group-btn"><i
                                                            class="fa fa-search"></i></span></button></span>

                                            </div>
                                            <div wire:loading wire:target="search_service_by_code">
                                                Processing ...
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label for="inputName" class="control-label">Service name:</label>
                                            <div class="input-group">
                                                <input class="form-control" placeholder="Service code or name..."
                                                    type="text" wire:model="queryService"> <span
                                                    class="input-group-btn"><button class="btn btn-primary"
                                                        type="button"><span class="input-group-btn"><i
                                                                class="fa fa-search"></i></span></button></span>
                                            </div>
                                            <div wire:loading wire:target="queryService">
                                                Processing ...
                                            </div>
                                            @if (!empty($queryService))
                                                <div class="absolute z-10 w-full bg-light rounded-t-none  list-group ">
                                                    @if (!empty($services))
                                                        <ul>
                                                            @foreach ($services as $i => $service)
                                                                @if ($service->active == 1)
                                                                    <li style="cursor: pointer;">
                                                                        <i class="text-success fas fa-check-circle"></i>
                                                                        <a wire:click="search_service_by_naame({{ $service->id }})"
                                                                            class=" hover:bg-gray-700 list-item {{ $highlightIndex === $i ? 'highlight' : '' }}">

                                                                            {{ $service['code'] }} -
                                                                            {{ $service['name_en'] }}
                                                                        </a>
                                                                    </li>
                                                                @else
                                                                    <li style="cursor: not-allowed;">
                                                                        <i class="text-danger fas fa-minus-circle"></i>
                                                                        {{ $service['code'] }} -
                                                                        {{ $service['name_en'] }}
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <div class="list-item">No results!</div>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>

                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="example1" class="table table-hover  mb-0 text-md-nowrap"
                                                    data-page-length='50' style="text-align: center">
                                                    <thead>
                                                        <tr>
                                                            <th class="border-bottom-0">Code</th>
                                                            <th class="border-bottom-0">Service name</th>
                                                            <th class="border-bottom-0">Cash</th>
                                                            <th class="border-bottom-0">Credit</th>
                                                            <th class="border-bottom-0">Operations</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <tr>
                                                            <td> - </td>
                                                            <td> Home visit service ({{$registration_details->order_destanceKm/1000 }} KM) </td>
                                                            <td> {{number_format($registration_details->home_vist_price) }}
                                                            </td>
                                                            <td> 0 </td>
                                                            <td> 
                                                                -
                                                            </td>
                                                        </tr>

                                                        @foreach ($previous_patient_services as $key => $service)
                                                            <tr>
                                                                <td> {{ $service['service']['code'] }}</td>
                                                                <td> {{ $service['service']['name_en'] }}</td>
                                                                <td> {{number_format($service['service_price']) }}
                                                                </td>
                                                                <td> {{ number_format($service['service_price_credit'] ) }}
                                                                </td>
                                                                <td> 
                                                                     <a title="Delete service" style="cursor: pointer;"
                                                                        wire:click="delete_previous_service({{ $key }})"><i
                                                                            class="text-danger fas fa-trash-alt "></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        @foreach ($patient_services as $key => $service)
                                                        <tr>
                                                            <td> {{ $service['service']['code'] }}</td>
                                                            <td> {{ $service['service']['name_en'] }}</td>
                                                            <td> {{number_format( ($service['current_price'] * $selected_cpls['cash_ratio']) / 100) }}
                                                            </td>
                                                            <td> {{ number_format( ($service['current_price'] * $selected_cpls['credit_ratio']) / 100) }}
                                                            </td>
                                                            <td> 
                                                                 <a title="Delete service" style="cursor: pointer;"
                                                                    wire:click="delete_service({{ $key }})"><i
                                                                        class="text-danger fas fa-trash-alt "></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>


                                    <hr>
                                    <div class="row">
                                        <div class="col">
                                            <div class="col">
                                                <label for="inputName" class="control-label">Number of chosen services:
                                                </label>
                                                <b>
                                                    <label for="inputName"
                                                        class="control-label">{{ count($patient_services) }}
                                                    </label>
                                                </b>
                                                Service(s)
                                            </div>
                                        </div>

                                        <div class="col">
                                            <label for="inputName" class="control-label">Total Cash Required:
                                            </label>
                                            <b>
                                                <label for="inputName"
                                                    class="control-label">{{ number_format($Total_Cash_Required) }}
                                                </label>
                                            </b>
                                            SDG
                                        </div>

                                        <div class="col">
                                            <label for="inputName" class="control-label">Total Credit Required:
                                            </label>
                                            <b>
                                                <label for="inputName"
                                                    class="control-label">{{ number_format($Total_Credit_Required) }}
                                                </label>
                                            </b>
                                            SDG
                                        </div>


                                    </div>
                                    <br>

                                    <div wire:loading wire:target="save_booking_servicesDetails" >
                                        Saving...
                                    </div>

                                    <div class="d-flex justify-content-center">
                                        <button wire:click="save_booking_servicesDetails" class="btn btn-success"
                                            {{ count($patient_services) > 0 || count($previous_patient_services) > 0 ? '' : 'disabled' }}>Save</button>&nbsp;&nbsp;
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

                                <div class="tab-pane" id="tab4">
                                    <br>
                                    <div class="row">
                                        <div class="col">
                                            <label for="inputName" class="control-label">Total cash required:
                                            </label>
                                            <b>
                                                <label for="inputName"
                                                    class="control-label">{{ number_format($registration_details->total) }}
                                                </label>
                                            </b>
                                        </div>

                                        <div class="col">
                                            <label for="inputName"
                                                class={{ $registration_details->remaining > 0 ? 'text-danger control-label' : 'control-label' }}>Remaining:
                                            </label>
                                            <b>
                                                <label for="inputName"
                                                    class={{ $registration_details->remaining > 0 ? 'text-danger control-label' : 'control-label' }}>{{ number_format($registration_details->remaining) }}
                                                </label>
                                            </b>
                                        </div>

                                            <div class="col">
                                                <label for="inputName" class="control-label">Paid:
                                                </label>
                                                <b>
                                                    <label for="inputName"
                                                        class="control-label">{{ number_format($registration_details->paid) }}
                                                    </label>
                                                </b>
                                            </div>
                                            <div class="col">
                                                <button wire:click="receive_home_visit"
                                                class="btn bg-success"
                                                {{  $registration_details->status == 4 ? '' : 'disabled' }}>
                                                <h4 class="mb-3 tx-12 text-white"><b>Samples received in lab</b></h4>
                                            </button>
                                            </div>

                                        

                                    </div>
                                    <br>
                                    <div class="col-xl-12">
                                        <div class="card mg-b-20">
                                            <div class="card-header pb-0">
                                                <div class="d-flex justify-content-between">
                                                    <h4 class="card-title mg-b-0">Payment:
                                                    </h4>
                                                </div>
                                            </div>
                                            <div class="card-body">

                                                <div class="d-flex justify-content-center">
                                                    <div class="col">
                                                        <label for="inputName" class="control-label">Transaction
                                                            type:
                                                            <b class="text-danger fas">*</b></label>

                                                        <select wire:model.lazy="transaction_type"
                                                            class="form-control ">
                                                            <option value="" selected>
                                                                -- Select transaction type --
                                                            </option>
                                                            <option value="Payment">
                                                                Payment
                                                            </option>
                                                            <option value="Refund">
                                                                Refund
                                                            </option>
                                                        </select>

                                                    </div>
                                                    <div class="col">
                                                        <label for="inputName" class="control-label">Payment
                                                            method:
                                                            <b class="text-danger fas">*</b></label>
                                                        <select wire:model.lazy="payment_method"
                                                            class="form-control ">
                                                            <option value="" selected>
                                                                -- Select payment type --
                                                            </option>
                                                            <option value="Cash">
                                                                Cash
                                                            </option>
                                                            <option value="Bank">
                                                                Bank
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <div class="col">
                                                        <label for="inputName"
                                                            class="control-label">Amount:</label>
                                                        <input type="text" class="form-control" id="inputName"
                                                            wire:model.lazy="payment_amount">
                                                    </div>

                                                    <div class="col">
                                                        <div class="d-flex justify-content-center">
                                                            <div wire:loading wire:target="add_payment">
                                                                Calculating ...
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-center">
                                                            <button wire:click="add_payment"
                                                                class="btn btn-primary"
                                                                {{ $payment_method !== '' && $transaction_type !== '' && $payment_amount > 0 ? '' : 'disabled' }}>Add
                                                                payment</button>
                                                        </div>


                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                   
                                    <div class="col-xl-12">
                                        <div class="card mg-b-20">
                                            <div class="card-header pb-0">
                                                <div class="d-flex justify-content-between">
                                                    <h4 class="card-title mg-b-0">Payments Transaction history
                                                    </h4>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered mg-b-0 text-md-nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>Date & Time</th>
                                                                <th>Transaction type</th>
                                                                <th>Payment Method</th>
                                                                <th>Amount</th>
                                                                <th>Done By</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($payment_transactions as $key => $transaction)
                                                                <tr>
                                                                    <th scope="row">
                                                                        {{ $transaction->created_at }}</th>
                                                                    <td>
                                                                        {{ $transaction->transaction_type }}
                                                                        @if ($transaction->transaction_type == 'Discount')
                                                                            <i class="text-danger fas fa-trash-alt"
                                                                                wire:click="delete_discount({{ $transaction }})"></i>
                                                                        @else
                                                                        @endif

                                                                    </td>
                                                                    <td>
                                                                        {{ $transaction->payment_method }}
                                                                    </td>
                                                                    <td>{{ number_format($transaction->amount) }}
                                                                    </td>
                                                                    <td>{{ $transaction->created_by_user->full_name }}</td>
                                                                    </td>
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

        </div>



    </div>
</div>
