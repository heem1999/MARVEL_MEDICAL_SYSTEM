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
                                    <li><a href="#tab1" class="nav-link active" data-toggle="tab">Cancel Services</a>
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
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="example1" class="table table-hover  mb-0 text-md-nowrap"
                                                    data-page-length='50' style="text-align: center">
                                                    <thead>
                                                        <tr>
                                                            <th class="border-bottom-0">status</th>
                                                            <th class="border-bottom-0">Service name</th>
                                                            <th class="border-bottom-0">Cash</th>
                                                            <th class="border-bottom-0">Credit</th>
                                                            <th class="border-bottom-0">Operations</th>
                                                            <th class="border-bottom-0">Cancel</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($patient_services as $key => $service)
                                                            <tr>
                                                                @if (!$service['isCanceled'])
                                                                    <td><i class="text-success fas fa-check-circle"></i>
                                                                    </td>
                                                                @else
                                                                    <td>
                                                                        <i class="text-danger fas fa-window-close"></i>
                                                                    </td>
                                                                @endif

                                                                <td> {{ $service['service']['name_en'] }}</td>
                                                                <td> {{ number_format($service['current_price'] - ($service['current_price'] * $selected_cpls['cash_ratio']) / 100) }}
                                                                </td>
                                                                <td> {{ number_format($service['current_price'] - ($service['current_price'] * $selected_cpls['credit_ratio']) / 100) }}
                                                                </td>
                                                                <td>
                                                                    @if (!$service['isCanceled'])
                                                                        <select
                                                                            wire:model="selected_reason.{{ $key }}"
                                                                            wire:change="cancel_service({{ $key }})"
                                                                            class="form-control ">
                                                                            <option value="0" selected>
                                                                                -- Select reason --
                                                                            </option>
                                                                            @foreach ($cancel_reasons as $reason)
                                                                                <option
                                                                                    value="{{ $reason->reason_en }}">
                                                                                    {{ $reason->reason_en }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    @else
                                                                        {{ $service['canceled_reasone'] }}
                                                                    @endif


                                                                </td>
                                                                @if (!$service['isCanceled'])
                                                                    <td>
                                                                        <input type="checkbox" disabled>
                                                                    </td>
                                                                @else
                                                                    <td>
                                                                        <input
                                                                            wire:change="uncancel_service({{ $key }})"
                                                                            type="checkbox" checked>
                                                                    </td>
                                                                @endif

                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                <div class="d-flex justify-content-center">
                                                    <div wire:loading wire:target="cancel_service">
                                                        Saving ...
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
                                    <li><a href="#tab1" class="nav-link active" data-toggle="tab">Cancel Extra
                                            Services</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body tabs-menu-body main-content-body-right border">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab1">
                                 

                                    <div class="row">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="example1" class="table table-hover  mb-0 text-md-nowrap"
                                                    data-page-length='50' style="text-align: center">
                                                    <thead>
                                                        <tr>
                                                            <th class="border-bottom-0">status</th>
                                                            <th class="border-bottom-0">Service name</th>
                                                            <th class="border-bottom-0">Cash</th>
                                                            <th class="border-bottom-0">Credit</th>
                                                            <th class="border-bottom-0">Operations</th>
                                                            <th class="border-bottom-0">Cancel</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($patient_extra_services as $key => $service)
                                                            <tr>
                                                                @if (!$service['isCanceled'])
                                                                    <td><i class="text-success fas fa-check-circle"></i>
                                                                    </td>
                                                                @else
                                                                    <td>
                                                                        <i class="text-danger fas fa-window-close"></i>
                                                                    </td>
                                                                @endif

                                                                <td> {{ $service['extra_service']['name_en'] }}</td>
                                                                <td> {{ number_format($service['current_price']) }}
                                                                </td>
                                                                <td> 0
                                                                </td>
                                                                <td>
                                                                    @if (!$service['isCanceled'])
                                                                        <select
                                                                            wire:model="selected_extra_reason.{{ $key }}"
                                                                            wire:change="cancel_extra_service({{ $key }})"
                                                                            class="form-control ">
                                                                            <option value="0" selected>
                                                                                -- Select reason --
                                                                            </option>
                                                                            @foreach ($cancel_reasons as $reason)
                                                                                <option
                                                                                    value="{{ $reason->reason_en }}">
                                                                                    {{ $reason->reason_en }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    @else
                                                                        {{ $service['canceled_reasone'] }}
                                                                    @endif
                                                                </td>
                                                                @if (!$service['isCanceled'])
                                                                    <td>
                                                                        <input type="checkbox" disabled>
                                                                    </td>
                                                                @else
                                                                    <td>
                                                                        <input
                                                                            wire:change="uncancel_extra_service({{ $key }})"
                                                                            type="checkbox" checked>
                                                                    </td>
                                                                @endif

                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                <div class="d-flex justify-content-center">
                                                    <div wire:loading wire:target="cancel_service">
                                                        Saving ...
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
</div>
