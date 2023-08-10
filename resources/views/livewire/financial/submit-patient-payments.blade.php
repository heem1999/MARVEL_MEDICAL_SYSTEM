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
                                    <li><a href="#tab1" class="nav-link active" data-toggle="tab">Patient Payments
                                            Details</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body tabs-menu-body main-content-body-right border">
                            <div class="tab-content">
                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                                @if (session()->has('Error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session()->get('Error') }}
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                                @if (session()->has('add'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>{{ session()->get('add') }}</strong>
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                                <!-- if have enter right acc no -->
                                @if ($registration_details)
                                    <div class="tab-pane active" id="tab1">



                                        <div class="row">
                                            <div class="col">
                                                <label for="inputName" class="control-label">Patient Name:
                                                </label>
                                                <b>
                                                    <label for="inputName"
                                                        class="control-label">{{ $patient_data->patient_name }}
                                                    </label>
                                                </b>
                                            </div>

                                            <div class="col">
                                                <label for="inputName" class="control-label">Gender:
                                                </label>
                                                <b>
                                                    <label for="inputName"
                                                        class="control-label">{{ $patient_data->gender }}
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
                                                        class="control-label">{{ $registration_details->payer_contract->name_en }}
                                                    </label>
                                                </b>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <label for="inputName" class="control-label">Acc No.:
                                                </label>
                                                <b>
                                                    <label for="inputName" class="control-label">{{ $ACC }}
                                                    </label>
                                                </b>
                                            </div>

                                            <div class="col">
                                                <label for="inputName" class="control-label">Patient No.:
                                                </label>
                                                <b>
                                                    <label for="inputName"
                                                        class="control-label">{{ $patient_data->patient_no }}
                                                    </label>
                                                </b>
                                            </div>

                                            <div class="col">
                                                <label for="inputName" class="control-label">Contract:
                                                </label>
                                                <b>
                                                    <label for="inputName"
                                                        class="control-label">{{ $registration_details->payer->currency->name_en }}
                                                    </label>
                                                </b>
                                            </div>

                                            <div class="col">
                                                <label for="inputName" class="control-label">Transaction Date:
                                                </label>
                                                <b>
                                                    <label for="inputName"
                                                        class="control-label">{{ $registration_details->created_at }}
                                                    </label>
                                                </b>
                                            </div>
                                            <hr>
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <div class="col">
                                                    <label for="inputName" class="control-label">Total amount:
                                                    </label>
                                                    <b>
                                                        <label for="inputName"
                                                            class="control-label">{{ number_format($total_amout) }}
                                                        </label>
                                                    </b>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <label for="inputName" class="control-label">Total cash required:
                                                </label>
                                                <b>
                                                    <label for="inputName"
                                                        class="control-label">{{ number_format($registration_details->total_Cash_Required) }}
                                                    </label>
                                                </b>
                                            </div>

                                            <div class="col">
                                                <label for="inputName" class="control-label">Credit:
                                                </label>
                                                <b>
                                                    <label for="inputName"
                                                        class="control-label">{{ number_format($registration_details->total_Credit_Required) }}
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
                                                <label for="inputName" class="control-label">Total refund:
                                                </label>
                                                <b>
                                                    <label for="inputName" class="control-label">0
                                                    </label>
                                                </b>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <div class="col">
                                                    <label for="inputName" class="control-label">Paid:
                                                    </label>
                                                    <b>
                                                        <label for="inputName"
                                                            class="control-label">{{ number_format($registration_details->paid) }}
                                                        </label>
                                                    </b>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <label for="inputName" class="control-label">Total refund:
                                                </label>
                                                <b>
                                                    <label for="inputName" class="control-label">0
                                                    </label>
                                                </b>
                                            </div>

                                            <div class="col">
                                                <label for="inputName" class="control-label">Discount:
                                                </label>
                                                <b>
                                                    <label for="inputName"
                                                        class="control-label">{{ number_format($registration_details->discount) }}
                                                    </label>
                                                </b>

                                            </div>
                                            <div class="col">
                                                <label for="inputName" class="control-label">Services count:
                                                </label>
                                                <b>
                                                    <label for="inputName"
                                                        class="control-label">{{ count($patient_services) + count($patient_extra_services) }}
                                                    </label>
                                                </b>
                                                Service(s)
                                            </div>

                                            <hr>
                                        </div>
                                        <div class="row">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered mg-b-0 text-md-nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th class="border-bottom-0">Price</th>
                                                                <th class="border-bottom-0">Code</th>
                                                                <th class="border-bottom-0">Service name</th>
                                                                <th class="border-bottom-0">Cash</th>
                                                                <th class="border-bottom-0">Credit</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            @foreach ($patient_services as $key => $service)
                                                                <tr data-index="0" style="background-color:
                                                        <?php
                                                        switch ($service['isCanceled']) {
                                                            case 1:
                                                                print 'beige';
                                                                break;
                                                        }
                                                        ?>">
                                                                    <td> {{ number_format($service['current_price']) }}
                                                                    </td>
                                                                    <td> {{ $service['service']['code'] }}</td>
                                                                    <td> {{ $service['service']['name_en'] }}</td>
                                                                    <td> {{ number_format($service['service_price_cash']) }}
                                                                    </td>
                                                                    <td> {{ number_format($service['service_price_credit']) }}
                                                                    </td>

                                                                </tr>
                                                            @endforeach

                                                            @foreach ($patient_extra_services as $key => $service)
                                                                <tr data-index="0" style="background-color:
                                                    <?php
                                                    switch ($service['isCanceled']) {
                                                        case 1:
                                                            print 'beige';
                                                            break;
                                                    }
                                                    ?>">
                                                                    <td> {{ number_format($service['current_price']) }}
                                                                    </td>
                                                                    <td> - </td>
                                                                    <td> {{ $service['extra_service']['name_en'] }}
                                                                    </td>
                                                                    <td> {{ number_format($service['service_price_cash']) }}
                                                                    </td>
                                                                    <td> 0 </td>

                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>
                                        <!-- if this job order is credit payment -->
                                        {{-- @if ($registration_details->total_Credit_Required == 0 && $registration_details->total_Cash_Required > 0 && $registration_details->remaining > 0) --}}
                                        <div class="col-xl-12">
                                            <div class="card mg-b-20">
                                                <div class="card-header pb-0">
                                                    <div class="d-flex justify-content-between">
                                                        <h4 class="card-title mg-b-0">Discount:
                                                        </h4>
                                                    </div>
                                                    @if ($registration_details->discount > 0)
                                                        <p class="tx-12 tx-danger-500 mb-2">
                                                            <b class="text-danger">Note: Discount already made
                                                                for this
                                                                job order.
                                                            </b>
                                                        </p>
                                                    @endif

                                                </div>
                                                <div class="card-body">

                                                    <div class="d-flex justify-content-center">
                                                        <div class="col">
                                                            <div class="col">
                                                                <label class="rdiobox"><input name="rdio"
                                                                        type="radio"
                                                                        wire:click="Discount_type('Absolute')">
                                                                    <span>Absolute</span></label>

                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="col">

                                                                <label class="rdiobox"><input name="rdio"
                                                                        type="radio"
                                                                        wire:click="Discount_type('Percent')">
                                                                    <span>Percent</span></label>
                                                            </div>
                                                        </div>
                                                        <div class="col">

                                                            <input type="text" class="form-control" id="inputName"
                                                                name="Discount" placeholder="Discount amount"
                                                                title="Please enter the Discount"
                                                                wire:model.lazy="discount_amount">
                                                            <label class="form-control"
                                                                id="inputName">{{ $Discount_mark }}</label>
                                                        </div>

                                                        <div class="col">
                                                            <div class="d-flex justify-content-center">
                                                                <div wire:loading wire:target="Calculate_discount">
                                                                    Calculating ...
                                                                </div>
                                                            </div>
                                                            <div class="d-flex justify-content-center">
                                                                <button wire:click="Calculate_discount"
                                                                    class="btn btn-primary"
                                                                    {{ $discount_amount !== 0 && $Discount_mark !== '' && $registration_details->discount == 0 ? '' : 'disabled' }}>Calculate
                                                                    discount</button>
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
                                                        <h4 class="card-title mg-b-0">Transaction history
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
                                                                    <th>Payment Branch</th>
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
                                                                        <td>{{ $transaction->Created_by }}</td>
                                                                        <td>{{ $transaction->branch->name_en }}
                                                                        </td>
                                                                    </tr>
                                                                @endforeach

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button wire:click="print_Receipt_number"
                                                class="btn btn-success">Pay</button>
                                        </div>
                                        {{-- @endif --}}
                                        {{-- <div class="d-flex justify-content-center">
                                        <button wire:click="previous"
                                            class="btn btn-primary">Previous</button>&nbsp;&nbsp;
                                        <button wire:click="savePatientRegistrationData" class="btn btn-primary"
                                            {{ count($patient_services) > 0 ? '' : 'disabled' }}>Save</button>&nbsp;&nbsp;
                                        <button type="button" class="btn btn-danger" wire:click="reset_patient_services"
                                            {{ count($patient_services) > 0 ? '' : 'disabled' }}>Rest</button>
                                    </div> --}}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>



    </div>
</div>
