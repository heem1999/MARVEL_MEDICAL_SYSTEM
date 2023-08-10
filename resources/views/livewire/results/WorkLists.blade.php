<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0">Clinical Data
                    </h4>
                </div>
            </div>
            <div class="card-body">
                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                @if (session()->has('Error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session()->get('Error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <div class="row">

                    <div class="col">
                        <label for="inputName" class="control-label">Processing Branch:</label>
                        <select wire:model.defer="branch_id" wire:change="get_branch_Processing_Unit"
                            class="form-control">
                            <option value="" selected>
                                -- All Processing branches --
                            </option>
                            @foreach ($branches as $branche)
                            <option value="{{ $branche->id }}">
                                {{ $branche->name_en }}
                            </option>
                            @endforeach

                        </select>
                    </div>
                    <div class="col">
                        <label for="inputName" class="control-label">Processing Unit:</label>
                        <select wire:model.defer="selected_processing_units_id" class="form-control">
                            <option value="" selected>
                                -- All Processing Units --
                            </option>
                            @foreach ($processing_units as $processing_unit)
                            <option value="{{ $processing_unit->id }}">
                                {{ $processing_unit->name_en }}
                            </option>
                            @endforeach

                        </select>
                    </div>
                    <div class="col">
                        <label for="inputName" class="control-label">ACC No.:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" wire:model="ACC" id="acc_no" autofocus />
                        </div>
                    </div>
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

                </div>

                <br>

                <div class="d-flex justify-content-center">
                    <div wire:loading wire:target="getWorkList">
                        Searching ...
                    </div>
                </div>
                <div class="d-flex justify-content-center" >
                    <button wire:click="getWorkList" class="btn btn-primary">Search</button>&nbsp;&nbsp;
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
                    <table class="table table-bordered mg-b-0 text-md-nowrap table-hover">
                        <thead>
                            <tr style="text-align: center">
                                <th>Patient No(s)</th>
                                <th>Acc.No.</th>
                                <th>Patient Name(s)</th>
                                <th>S. ID(s)</th>
                                <th>Service</th>
                                <th>Reg. Branch</th>
                                <th>Reg. Date</th>
                                <th>Service Status</th>
                                <th>Sample status</th>
                                <th>Processing Unit</th>
                                <th>ST</th>
                            </tr>
                        </thead>
                        <tbody>
                            <div wire:poll.visible>
                            @if ($search_clicked)
                            @foreach ($registration_details as $key => $registration_detail)
                            @if ($selected_processing_units_id)
                            @foreach($registration_samples_barcodes->where('acc',$registration_detail->acc)->where('processing_unit_id',$selected_processing_units_id)
                            as $samples_barcode)
                            @foreach($registration_samples_barcode_services->where('samples_barcode_id',$samples_barcode->id)
                            as
                            $registration_samples_barcode_service)
                            <tr style="text-align: center">
                                <td>{{ $registration_detail->patient->patient_no }}</td>
                                <td>{{ $registration_detail->acc }}</td>
                                <td>{{ $registration_detail->patient->patient_name }}</td>
                                <td>{{ $samples_barcode->sample_barcode }}</td>
                                <td>{{ $registration_samples_barcode_service->service->name_en }}</td>
                                <td>{{ $registration_detail->Branch->name_en }}</td>
                                <td>{{ date('m-d H:i', strtotime($registration_detail->created_at)) }}</td>
                                <td>
                                    @if ($registration_samples_barcode_service->service_status =='Reviewed')
                                    
                                    <b class="text-success fas">{{ $registration_samples_barcode_service->service_status }}</b>
                                    @else
                                    <b class="text-danger fas">Pending</b>
                                    @endif
                                </td>
                                <td>{{ $samples_barcode->samples_barcode_status }}</td>
                                <td>{{ $samples_barcode->Processing_unit->name_en }}</td>
                                <td>
                                    <a href="results?pagename=SampleTrack&rsb_id={{ $samples_barcode->id }}"
                                                onclick="var popup =window.open(this.href, 'mywin',
                                                            'left=20,top=20,width=900,height=700'); return false; ">
                                            <i class="fas fa-clipboard-list"></i></a>
                                                                        </td>
                            </tr>
                            @endforeach
                            @endforeach
                            @else
                            @foreach ($registration_samples_barcodes->where('acc',$registration_detail->acc) as
                            $samples_barcode)
                            @foreach($registration_samples_barcode_services->where('samples_barcode_id',$samples_barcode->id)
                            as
                            $registration_samples_barcode_service)
                            <tr style="text-align: center">
                                <td>{{ $registration_detail->patient->patient_no }}</td>
                                <td>{{ $registration_detail->acc }}</td>
                                <td>{{ $registration_detail->patient->patient_name }}</td>
                                <td>{{ $samples_barcode->sample_barcode }}</td>
                                <td>{{ $registration_samples_barcode_service->service->name_en }}</td>
                                <td>{{ $registration_detail->Branch->name_en }}</td>
                                <td>{{ date('m-d H:i', strtotime($registration_detail->created_at)) }}</td>
                                <td>
                                    @if ($registration_samples_barcode_service->service_status =='Reviewed')
                                    <b class="text-success fas">{{ $registration_samples_barcode_service->service_status }}</b>
                                    @else
                                    <b class="text-danger fas">Pending</b>
                                    @endif
                                </td>
                                <td>{{ $samples_barcode->samples_barcode_status }}</td>
                                <td>{{ $samples_barcode->Processing_unit->name_en }}</td>
                                <td >
                                    <a alt="Sun" href="results?pagename=SampleTrack&rsb_id={{ $samples_barcode->id }}"
                                                onclick="var popup =window.open(this.href, 'mywin',
                                                            'left=20,top=20,width=900,height=700'); return false; ">
                                            <i class="fas fa-clipboard-list" alt="Sun"></i></a>
                                </td>
                            </tr>
                            @endforeach
                            @endforeach
                            @endif
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