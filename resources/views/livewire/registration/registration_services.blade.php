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


                                    <div class="row">
                                        @if ($currentStep > 0)
                                            <div class="col">
                                                <div class="col">
                                                    <label for="inputName" class="control-label">Patient Name:
                                                    </label>
                                                    <b>
                                                        <label for="inputName"
                                                            class="control-label">{{ $patient_name }}
                                                        </label>
                                                    </b>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <label for="inputName" class="control-label">Gender:
                                                </label>
                                                <b>
                                                    <label for="inputName" class="control-label">{{ $gender }}
                                                    </label>
                                                </b>
                                            </div>

                                            <div class="col">
                                                <label for="inputName" class="control-label">Payer:
                                                </label>
                                                <b>
                                                    <label for="inputName"
                                                        class="control-label">{{ $selected_payers->name_en }}
                                                    </label>
                                                </b>
                                            </div>
                                            <div class="col">
                                                <label for="inputName" class="control-label">Contract:
                                                </label>
                                                <b>
                                                    <label for="inputName"
                                                        class="control-label">{{ $selected_contract['name_en'] }}
                                                    </label>
                                                </b>
                                            </div>
                                            <hr>
                                        @endif
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <label for="inputName" class="control-label">Service code:</label>
                                            <div class="input-group">
                                                <input  {{ $searchByTransctionID ? 'disabled' : '' }} type="text" class="form-control"
                                                    wire:model.defer="service_code" placeholder="Service code..."
                                                    wire:keydown.enter="search_service_by_code" /><button
                                                    class="btn btn-primary" type="button"><span
                                                        class="input-group-btn"><i
                                                            class="fa fa-search"></i></span></button></span>

                                            </div>
                                            <div wire:loading wire:target="search_service_by_code">
                                                Loading...
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label for="inputName" class="control-label">Service name:</label>
                                            <div class="input-group">
                                                <input {{ $searchByTransctionID ? 'disabled' : '' }} class="form-control" placeholder="Service code or name..."
                                                    type="text" wire:model="queryService"> <span
                                                    class="input-group-btn"><button class="btn btn-primary"
                                                        type="button"><span class="input-group-btn"><i
                                                                class="fa fa-search"></i></span></button></span>
                                            </div>
                                            <div wire:loading wire:target="queryService">
                                                Loading...
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

                                        <div class="col">
                                            <label for="inputName" class="control-label">Extra Service name:</label>
                                            <div class="input-group">
                                                <input class="form-control" placeholder="Extra Service name..."
                                                    type="text" wire:model="queryExtraService"> <span
                                                    class="input-group-btn"><button class="btn btn-success"
                                                        type="button"><span class="input-group-btn"><i
                                                                class="fa fa-search"></i></span></button></span>
                                            </div>
                                            <div wire:loading wire:target="queryExtraService">
                                                Loading...
                                            </div>
                                            @if (!empty($queryExtraService))
                                                <div class="fixed top-0 bottom-0 left-0 right-0" wire:click="">
                                                </div>
                                                <div class="absolute z-10 w-full bg-light rounded-t-none  list-group ">
                                                    @if (!empty($ExtraServices))
                                                        <ul>
                                                            @foreach ($ExtraServices as $i => $service)
                                                                @if ($service->active == 1)
                                                                    <li style="cursor: pointer;">
                                                                        <i class="text-success fas fa-check-circle"></i>
                                                                        <a wire:click="Add_Extra_service('{{ $service->ex_code }}')"
                                                                            class=" hover:bg-gray-700 list-item {{ $highlightIndex === $i ? 'highlight' : '' }}">
                                                                            {{ $service['name_en'] }}
                                                                        </a>
                                                                    </li>
                                                                @else
                                                                    <li style="cursor: not-allowed;">
                                                                        <i class="text-danger fas fa-minus-circle"></i>
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
                                    <!--clinic services -->
                                    @if (!empty($ClinicServices))
                                    <div class="absolute z-10 w-full bg-light rounded-t-none  list-group ">
                                        <h5>&nbsp;&nbsp;Clinic Services (Requested by doctor)</h5>
                                       
                                            <ul>
                                                @foreach ($ClinicServices as $service)
                                                <input type="checkbox" wire:model="SelectedClinicServices" value="{{ $service->service->id  }}" wire:click="addSelectedClinicServices({{ $service->service }})">
                                                <label class="control-label">{{ $service->service->name_en  }}</label>
                                                &nbsp;&nbsp;
                                                @endforeach
                                            </ul>
                                        <div class="d-flex justify-content-center">
                                        <div  wire:loading wire:target="addSelectedClinicServices">
                                            processing...
                                        </div>
                                        </div>
                                    </div>
                                    @endif
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
                                                            <th class="border-bottom-0">Reult Date</th>
                                                            <th class="border-bottom-0">Operations</th>
                                                            <th class="border-bottom-0">done by</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($patient_services as $key => $service)
                                                            <tr>
                                                                <td> {{ $service['service']['code'] }}</td>
                                                                <td> {{ $service['service']['name_en'] }}</td>
                                                                <td> {{ number_format(($service['current_price'] * $selected_cpls['cash_ratio']) / 100) }}
                                                                </td>
                                                                <td> {{ number_format(($service['current_price'] * $selected_cpls['credit_ratio']) / 100) }}
                                                                </td>
                                                                <td>
                                                                    {{  Carbon\Carbon::now()->addMinutes($service['service']['processing_time'])->format('Y-m-d H:i')  }}
                                                                </td>
                                                                <td>
                                                                    <a title="Delete service" style="cursor: pointer;"
                                                                        wire:click="delete_service({{ $key }})"><i
                                                                            class="text-danger fas fa-trash-alt "></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        @foreach ($patient_extra_services as $key => $extra_service)
                                                            <tr>
                                                                <td> - </td>
                                                                <td> {{ $extra_services->where('ex_code', $extra_service['ex_code'])->first()->name_en }}
                                                                </td>
                                                                <td> {{ number_format($extra_service['current_price']) }}
                                                                </td>
                                                                <td> - </td>
                                                                <td>
                                                                    <a title="Delete service" style="cursor: pointer;"
                                                                        wire:click="delete_extra_service({{ $key }})"><i
                                                                            class="text-danger fas fa-trash-alt "></i>
                                                                    </a>
                                                                </td>
                                                                <td>
                                                                    <select
                                                                        wire:model="selected_Non_Clinical_User.{{ $key }}"
                                                                        wire:change="Selected_NonClinicalUser_extra_service('{{ $extra_service['ex_code'] }}',{{ $key }})"
                                                                        class="form-control">
                                                                        <option value="0" selected>
                                                                            -- Select Non-Clinical User --
                                                                        </option>
                                                                        @foreach ($NonClinicalUsers as $NonClinicalUser)
                                                                            <option
                                                                                value="{{ $NonClinicalUser->id }}">
                                                                                {{ $NonClinicalUser->name_en }}
                                                                            </option>
                                                                        @endforeach

                                                                    </select>
                                                                </td>

                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                  @if (Auth::user()->branch->show_time_to_receive_result)
                                  <hr>
                                  
                                  <div class="row">
                                      <div class="col">
                                          <label for="inputName" class="control-label">Result run time comment: (How long the patient will receive his result)</label><br>
                                          <textarea wire:model.defer="time_to_receive_result" style="border: ridge 2px;
                                          padding: 5px;
                                          width: 100%;
                                          min-height: 5em;
                                          overflow: auto;">
                                          </textarea>
                                      </div>
                                  </div>
                                  @endif
                                   
                                    
                                    <hr>
                                   
                                    <div class="row">
                                        <div class="col">
                                            <div class="col">
                                                <label for="inputName" class="control-label">Number of chosen services:
                                                </label>
                                                <b>
                                                    <label for="inputName"
                                                        class="control-label">{{ count($patient_services) + count($patient_extra_services) }}
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
                                        <button wire:click="previous"
                                            class="btn btn-primary">Previous</button>&nbsp;&nbsp;
                                        <button wire:click="savePatientRegistrationData" class="btn btn-success"
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
