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
                                    <li><a href="#tab1" class="nav-link active" data-toggle="tab">Sample Informations</a>
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
                                                <table id="example1" class="table table-bordered mg-b-0 text-md-nowrap"
                                                    data-page-length='50' style="text-align: center">
                                                    <thead>
                                                        <tr>
                                                            <th class="border-bottom-0">Sample ID(s)</th>
                                                            <th class="border-bottom-0">Service name</th>
                                                            <th class="border-bottom-0">status</th>
                                                            <th class="border-bottom-0">Reserved</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($registration_samples_barcodes as $registration_samples_barcode)
                                                            <tr>
                                                                <td
                                                                    rowspan="{{ $registration_samples_barcode_services->where('samples_barcode_id', $registration_samples_barcode->id)->count() }}">
                                                                    {{ $registration_samples_barcode->sample_barcode }}
                                                                </td>
                                                                <?php
                                                                $key_already_printed = 0;
                                                                ?>
                                                                @foreach ($registration_samples_barcode_services as $key1 => $registration_samples_barcode_service)
                                                                    @if ($registration_samples_barcode_service->samples_barcode_id == $registration_samples_barcode->id)
                                                                        <td> {{ $registration_samples_barcode_service->service->name_en }}
                                                                        </td>
                                                                        <td>{{ $registration_samples_barcode_service->service_status }} 
                                                                        </td>
                                                                        @if ($registration_samples_barcode_service->service_status !== 'Received' && $registration_samples_barcode_service->service_status == 'Reserved')
                                                                            <td><input
                                                                                    wire:change="togel_service_status({{ $registration_samples_barcode_service->id }})"
                                                                                    type="checkbox" checked>
                                                                            </td>
                                                                        @elseif ($registration_samples_barcode_service->service_status == 'Received' || $registration_samples_barcode_service->service_status =="Reviewed")
                                                                            <td><input type="checkbox" disabled>
                                                                            </td>
                                                                        @else
                                                                            <td><input
                                                                                    wire:change="togel_service_status({{ $registration_samples_barcode_service->id }})"
                                                                                    type="checkbox">
                                                                            </td>
                                                                        @endif

                                                                        <?php
                                                                        $key_already_printed = $key1;
                                                                        ?>
                                                                    @break
                                                                @endif
                                                            @endforeach
                                                        </tr>

                                                        @foreach ($registration_samples_barcode_services as $key => $registration_samples_barcode_service)
                                                            @if ($key !== $key_already_printed && $registration_samples_barcode_service->samples_barcode_id == $registration_samples_barcode->id)
                                                                <tr>
                                                                    <td> {{ $registration_samples_barcode_service->service->name_en }}
                                                                    </td>
                                                                    <td>{{ $registration_samples_barcode_service->service_status }}
                                                                    </td>
                                                                    @if ($registration_samples_barcode_service->service_status !== 'Received' && $registration_samples_barcode_service->service_status == 'Reserved')
                                                                    <td><input
                                                                            wire:change="togel_service_status({{ $registration_samples_barcode_service->id }})"
                                                                            type="checkbox" checked>
                                                                    </td>
                                                                @elseif ($registration_samples_barcode_service->service_status == 'Received' || $registration_samples_barcode_service->service_status =="Reviewed")
                                                                    <td><input type="checkbox" disabled>
                                                                    </td>
                                                                @else
                                                                    <td><input
                                                                            wire:change="togel_service_status({{ $registration_samples_barcode_service->id }})"
                                                                            type="checkbox">
                                                                    </td>
                                                                @endif

                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <div class="d-flex justify-content-center">
                                                <div wire:loading wire:target="togel_service_status">
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
