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
                                    <li><a href="#tab1" class="nav-link active" data-toggle="tab">Patient Details</a>
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
                                                    <label for="inputName"
                                                        class="control-label">{{ $Delivery_Details_ACC }}
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
                                                <label for="inputName" class="control-label">Registration Date:
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
                                                        class="control-label">{{ count($patient_services) }}
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
                                                                <th class="border-bottom-0">Service name</th>
                                                                <th class="border-bottom-0">Service status</th>
                                                                <th class="border-bottom-0">Result Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($patient_services as $key => $service)
                                                                <tr>
                                                                    <td> {{ $service['service']['service']['name_en'] }}
                                                                    </td>
                                                                    <td>
                                                                        @if ($service['service']['service_status'] == 'Reviewed')
                                                                            <label for="inputName"
                                                                                class='text-success control-label'>
                                                                                <b> {{ $service['service']['service_status'] }}
                                                                                </b>
                                                                            </label>
                                                                        @else
                                                                            <label for="inputName"
                                                                                class='text-danger control-label'>
                                                                                <b> Pending </b>
                                                                            </label>
                                                                        @endif


                                                                    </td>
                                                                    <td>
                                                                        {{ $service['service']['updated_at'] }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="d-flex justify-content-center">
                                            @if ($can_print_result)
                                                <a href="/print_result_Silent?acc={{ $Delivery_Details_ACC }}"><button
                                                        type="submit" class="btn btn-primary"
                                                        {{ !$can_print_result ? 'disabled' : '' }}><i
                                                            class="fas fa-print"></i> Print
                                                        All</button></a>&nbsp;&nbsp;
                                                <a href="/download_result?acc={{ $Delivery_Details_ACC }}"> <button
                                                        type="submit" class="btn btn-info"
                                                        {{ !$can_print_result ? 'disabled' : '' }}><i
                                                            class="fas fa-download"></i>
                                                        Download</button></a>
                                            @else
                                                <button type="submit" class="btn btn-primary" disabled><i
                                                        class="fas fa-print"></i> Print
                                                    All</button>&nbsp;&nbsp;
                                                <button type="submit" class="btn btn-info" disabled><i
                                                        class="fas fa-download"></i>
                                                    Download</button></a>
                                            @endif

                                        </div>
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
