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
                                    <li><a href="#tab1" class="nav-link active" data-toggle="tab">Add Services</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body tabs-menu-body main-content-body-right border">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab1">
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
                                    @if (session()->has('Edit'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>{{ session()->get('Edit') }}</strong>
                                            <button type="button" class="close" data-dismiss="alert"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif

                                    <div class="row">
                                        <div class="col">
                                            <div class="col">
                                                <label for="inputName" class="control-label">Patient Name:
                                                </label>
                                                <b>
                                                    <label for="inputName" class="control-label">{{ $registration_details->patient->patient_name }}
                                                    </label>
                                                </b>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <label for="inputName" class="control-label">Gender:
                                            </label>
                                            <b>
                                                <label for="inputName" class="control-label">{{ $registration_details->patient->gender }}
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
                                                <div class="fixed top-0 bottom-0 left-0 right-0" wire:click="">
                                                </div>
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

                                                        @foreach ($patient_services as $key => $service)
                                                            <tr>
                                                                <td> {{ $service['service']['code'] }}</td>
                                                                <td> {{ $service['service']['name_en'] }}</td>
                                                                <td> {{number_format( ($service['current_price'] * $selected_cpls['cash_ratio']) / 100) }}
                                                                </td>
                                                                <td> {{ number_format( ($service['current_price'] * $selected_cpls['credit_ratio']) / 100) }}
                                                                </td>
                                                                <td> -
                                                                    {{-- <a title="Delete service" style="cursor: pointer;"
                                                                        wire:click="delete_service({{ $key }})"><i
                                                                            class="text-danger fas fa-trash-alt "></i>
                                                                    </a>--}}
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

                                    <div class="d-flex justify-content-center">

                                        <button wire:click="updatePatientRegistrationData" class="btn btn-success"
                                            {{ count($patient_services) > 0 ? '' : 'disabled' }}>Save</button>&nbsp;&nbsp;
                                        <button type="button" class="btn btn-danger" wire:click="reset_patient_services"
                                            {{ count($patient_services) > 0 ? '' : 'disabled' }}>Rest</button>
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
