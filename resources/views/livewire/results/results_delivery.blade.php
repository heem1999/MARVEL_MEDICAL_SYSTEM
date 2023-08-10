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
                        <label for="inputName" class="control-label">ACC No.:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" wire:model="ACC" id="acc_no" autofocus
                                wire:keydown.enter="searchData" />
                        </div>
                    </div>

                    <div class="col">
                        <label for="inputName" class="control-label">Patient Name/No:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="{{ $patient_placeholder }}"
                                wire:model="query" wire:keydown.escape="reset_values" wire:keydown.tab="reset_values" />
                        </div>
                        @if (!empty($query))
                            <div class="fixed top-0 bottom-0 left-0 right-0" wire:click="reset_values">
                            </div>
                            <div class="absolute z-10 w-full bg-light rounded-t-none  list-group ">
                                @if (!empty($contacts))
                                    <ul>
                                        @foreach ($contacts as $i => $contact)
                                            <li style="cursor: pointer;">
                                                <a wire:click="selectedPatient({{ $contact }})"
                                                    class=" hover:bg-gray-700 list-item {{ $highlightIndex === $i ? 'highlight' : '' }}">
                                                    {{ $contact['id'] }} -
                                                    {{ $contact['patient_name'] }} -
                                                    {{ $contact['phone'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <div class="list-item">No results!</div>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="col">
                        <label for="inputName" class="control-label">Mobile Number:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" wire:model="Mobile_Number" id="acc_no"
                                wire:keydown.enter="searchData" />
                        </div>
                    </div>


                </div>

                <br>

                <div class="d-flex justify-content-center">
                    <div wire:loading wire:target="searchData">
                        Searching ...
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <button wire:click="searchData" class="btn btn-primary">Search</button>&nbsp;&nbsp;
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
                    <table class="table table-bordered mg-b-0 text-md-nowrap">
                        <thead>
                            <tr style="text-align: center">
                                <th>Acc.No.</th>
                                <th>Patient Name(s)</th>
                                <th>Patient Number</th>
                                <th>Date & Time</th>
                                <th>Main Links</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($search_clicked)
                                @foreach ($registration_details as $key => $registration_detail)
                                    <tr style="text-align: center">
                                        <td>{{ $registration_detail->acc }}</td>
                                        <td>{{ $registration_detail->patient->patient_name }}</td>
                                        <td>{{ $registration_detail->patient->patient_no }}</td>
                                        <td>{{ $registration_detail->created_at }}</td>
                                        <td><a href="results?acc={{ $registration_detail->acc }}&pagename=Delivery_Details"
                                                target="_blank" data-effect="effect-scale" title="Details"><i
                                                    class="fas fa-info-circle"></i> Details</a>

                                                   <!-- <a href="/view_clinic_result?clinic_trans_no=123"> <button
                                                        type="submit" class="btn btn-info"><i
                                                            class="fas fa-download"></i>
                                                        clinic</button></a>-->

                                        </td>
                                    </tr>
                                @endforeach

                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
