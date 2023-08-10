@if ($page == 'change_processing_unit')
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
                                wire:model="Sample_ID" wire:keydown.enter="get_sample_ID_DATA">
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <div wire:loading wire:target="get_sample_ID_DATA">
                            Searching ...
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button wire:click="get_sample_ID_DATA" class="btn btn-primary">Load</button>&nbsp;&nbsp;
                        <button type="button" class="btn btn-danger" wire:click="mount">Rest</button>
                    </div>
                </div>
              
            </div>
            <div class="card-body">
              
                <div class="table-responsive">
                    <table class="table table-bordered mg-b-0 text-md-nowrap table-hover">
                        <thead>
                            <tr style="text-align: center">
                                <th>Acc.No.</th>
                                <th>Patient Name</th>
                                <th>Services</th>
                                <th>Tests</th>
                                <th>Sample ID</th>
                                <th>Current Processing Branch</th>
                                <th>Current Processing Unit</th>
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
                                    @foreach ($registration_details_data['samples_tests'] as $test)
                                    {{$test['test']['name_en']}},
                                    @endforeach
                                </td>
                                <td>{{ $registration_details_data['sample_barcode']['sample_barcode'] }}</td>
                                <td>
                                    {{-- class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm rounded-md" --}}
                                    <select wire:model="SelectedBranch" class="form-control">
                                        @foreach($branches as $region)
                                        @if ( $region->id === $SelectedBranch)
                                        <option value="{{ $region->id }}" selected>{{ $region['name_en'] }}</option>
                                        @else
                                        <option value="{{ $region->id }}">{{ $region['name_en'] }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                
                                </td>
                                <td>
                                    <select wire:model="selected_processing_units_id" class="form-control">
                                        <option value=" ">Select processing units</option>
                                        @foreach($processing_units as $region)
                                        @if ( $region->id === $defalt_processing_units_id)
                                        <option value="{{ $region->id }}" selected>{{ $region['name_en'] }}</option>
                                        @else
                                        <option value="{{ $region->id }}">{{ $region['name_en'] }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>         
<br>

<div class="d-flex justify-content-center">
    <button wire:click="Save_data" class="btn btn-success">Save</button>&nbsp;&nbsp;
</div>
             
            </div>

        </div>
    </div>
</div>
@elseif ($page == 'sample_plitting')
@include('livewire.tools.sample_plitting')
@endif
