<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0">Search
                    </h4>
                </div>
            </div>
            <div class="card-body">
                @if (session()->has('Add'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session()->get('Add') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

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
                        <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                            <label for="inputName" class="control-label">Sample ID: <b
                                    class="text-danger fas">*</b></label>
                            <input type="text" class="form-control" name="Sample_barcode" id="Sample_barcode" autofocus
                                wire:model="Sample_ID" wire:keydown.enter="get_sample_plitting_DATA">
                        </div>
                    </div>
                    <div class="col">
                    <form action="{{ route('print_sample_details') }}" method="post" enctype="multipart/form-data"
                    autocomplete="off">
                    {{ csrf_field() }}
                        
                            <label for="inputName" class="control-label">New Sample ID: </label> &nbsp;
                            <div class="d-flex">
                            <input class="col-lg-4 mg-t-20 mg-lg-t-0 form-control" type="text"  name="Sample_ID" id="Sample_ID"
                                wire:model="new_sample_barcode" readonly>
                                &nbsp;&nbsp;<button type="submit" class="btn btn-success"  {{ $new_sample_barcode==''?'disabled':'' }}>Print Sample</button>
                        </div>
                    </form>
                </div>
                    <div class="d-flex justify-content-center">
                        <div wire:loading wire:target="get_sample_plitting_DATA">
                            Searching ...
                        </div>
                    </div>

                    <br>
                    <div class="d-flex justify-content-center">
                        <button wire:click="get_sample_plitting_DATA" class="btn btn-primary">Load</button>&nbsp;&nbsp;
                        <button type="button" class="btn btn-danger" wire:click="mount">Rest</button>
                    </div>
                </div>
              
            </div>
            <div class="card-body">
                <b class="text-danger fas">For multiple selections hold the (Ctrl) key.</b>
                <div class="table-responsive">
                    <table class="table table-bordered mg-b-0 text-md-nowrap table-hover">
                        <thead>
                            <tr style="text-align: center">
                                <th>Acc.No.</th>
                                <th>Patient Name</th>
                                <th>Services</th>
                                <th>Tests</th>
                                <th>Sample ID</th>
                                <th>Processing Branch</th>
                                <th>Processing Unit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ( $registration_details_data)
                            <tr style="text-align: center">
                                
                                  <td>{{ $registration_details_data['registration_detail']['acc'] }}</td>                                
                                <td>{{ $registration_details_data['registration_detail']['patient']['patient_name'] }}</td>
                                <td>
                                    @foreach ($registration_details_data['samples_services'] as $service)
                                    {{$service}},
                                    @endforeach
                                 </td>
                                 
                                 <td> 
                                    
                                    <select wire:model.defer="SamplesTests" class="form-control" multiple>
                                        @foreach($registration_details_data['samples_tests'] as $test)
                                        
                                        <option value="{{ $test['test']['id'] }}">{{ $test['test']['name_en'] }}</option>
                                        @endforeach
                                    </select>
                                    
                                </td>
                                <td>{{ $registration_details_data['sample_barcode']['sample_barcode'] }}</td>
                                <td>
                                    {{ $registration_details_data['BranchName']['name_en'] }}
                                </td>
                                <td>
                                    {{ $registration_details_data['sample_barcode']['processing_unit']['name_en'] }}
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
<br>

<div class="d-flex justify-content-center">
    <button wire:click="Save_sample_plitting" class="btn btn-success">Save</button>
</div>
             
            </div>

        </div>
    </div>


</div>
