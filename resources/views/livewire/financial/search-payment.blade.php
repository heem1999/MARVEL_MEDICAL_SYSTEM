<div>
    @if ($page == '')
        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card mg-b-20">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-0">Search Criteria
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
                                <label for="inputName" class="control-label">Patient
                                    No./name/phone:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="{{ $patient_placeholder }}"
                                        wire:model="query" wire:keydown.escape="reset_values"
                                        wire:keydown.tab="reset_values" />
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
                                <label for="inputName" class="control-label">ACC No.:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" wire:model="ACC"
                                        wire:keydown.enter="searchData" />
                                </div>
                            </div>


                            <div class="col">
                                <label for="inputName" class="control-label">Reg. Date From: </label>
                                <div class="input-group ">
                                    <input class="form-control" format="YYYY-MM-DD" min="2022-01-01T08:30"
                                        type="datetime-local" wire:model="dateFrom" required>
                                </div>
                                @error('DOB')
                                    <span class="error text-danger ">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">Reg. Date To: </label>
                                <div class="input-group ">
                                    <input class="form-control" format="YYYY-MM-DD" min="2022-01-01T08:30"
                                        type="datetime-local" wire:model="dateTo" required>
                                </div>
                                @error('DOB')
                                    <span class="error text-danger ">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        <br>
                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">Reg. Branch:</label>
                                <select wire:model.defer="branch_id" class="form-control">
                                    <option value="" selected>
                                        -- Select branch --
                                    </option>
                                    @foreach ($branches as $branche)
                                        <option value="{{ $branche->id }}">
                                            {{ $branche->name_en }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">Payer:</label>
                                <div class="input-group">
                                    <input disabled type="text" class="form-control" placeholder="{{ $Payer_placeholder }}"
                                        wire:model="queryPayer" wire:keydown.escape="reset_queryPayer"
                                        wire:keydown.tab="reset_queryPayer" />

                                </div>
                                <div wire:loading wire:target="queryPayer">
                                    Searching ...
                                </div>
                                @error('selected_payers')
                                    <span class="error text-danger ">{{ $message }}</span>
                                @enderror
                                @if (!empty($queryPayer))
                                    <div class="fixed top-0 bottom-0 left-0 right-0" wire:click="reset_queryPayer">
                                    </div>
                                    <div class="absolute z-10 w-full bg-light rounded-t-none  list-group ">
                                        @if (!empty($payers))
                                            <ul>
                                                @foreach ($payers as $i => $payer)
                                                    <li style="cursor: pointer;">
                                                        <i class="text-success fas fa-check-circle"></i>
                                                        <a wire:click="get_Payer_Contract({{ $i }},{{ $payer['id'] }})"
                                                            class=" hover:bg-gray-700 list-item {{ $highlightIndex === $i ? 'highlight' : '' }}">

                                                            {{ $payer['code'] }} -
                                                            {{ $payer['name_en'] }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <div class="list-item">No payer!</div>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">Contract:</label>
                                <select disabled wire:model="selected_contract" class="form-control">
                                    <option value="" selected>
                                        -- Select contract --
                                    </option>
                                    @foreach ($payer_contracts as $contract)
                                        <option value="{{ $contract->id }}">
                                            {{ $contract->name_en }}
                                        </option>
                                    @endforeach
                                </select>
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
                                        <th>Date & Time</th>
                                        <th>payer & contract</th>
                                        <th>Reg. Branch</th>
                                        <th>Payment Details</th>
                                        <th>Reprint Receipt</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($search_clicked)


                                        @foreach ($registration_details as $key => $registration_detail)
                                            <tr style="text-align: center">
                                                <td>{{ $registration_detail->acc }}</td>
                                                <td>{{ $registration_detail->patient->patient_name }}</td>
                                                <td>{{ $registration_detail->created_at }}</td>
                                                <td>{{ $registration_detail->payer->name_en }} ,
                                                    {{ $registration_detail->payer_contract->name_en }}
                                                </td>
                                                <td>{{ $registration_detail->branch->name_en }}</td>
                                                <td><a href="SubmitPatientPayments?acc={{ $registration_detail->acc }}"
                                                        target="_blank" data-effect="effect-scale"
                                                        title="View payment"><i class="fas fa-dollar-sign"></i> View
                                                        payments</a>
                                                </td>
                                                <td>
                                                    <a href="Reprint_Receipt_number?acc={{ $registration_detail->acc }}"
                                                        onclick="var openedWindow =window.open(this.href, 'mywin',
                                                        'left=20,top=20,width=900,height=700');
 setTimeout(function () { openedWindow.close(); }, 2000);  return false; ">
                                                        <i class="fas fa-receipt"></i>
                                                        </i>Reprint Receipt</a>
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
    @elseif($page == 'Receipt_List')
        @include('livewire.financial.Receipt_List')
    @elseif($page == 'Financial_Claim')
        @include('livewire.financial.Financial_Claim')
    @endif
</div>
