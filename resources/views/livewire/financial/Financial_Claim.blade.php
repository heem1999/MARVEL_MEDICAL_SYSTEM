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
                                <label for="inputName" class="control-label">Reg. Date From: <b
                                        class="text-danger fas">*</b></label>
                                <div class="input-group ">
                                    <input class="form-control" format="YYYY-MM-DD" min="2022-01-01T08:30"
                                        type="datetime-local" wire:model="dateFrom" required>
                                </div>
                                @error('DOB')
                                    <span class="error text-danger ">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">Reg. Date To: <b
                                        class="text-danger fas">*</b></label>
                                <div class="input-group ">
                                    <input class="form-control" format="YYYY-MM-DD" min="2022-01-01T08:30"
                                        type="datetime-local" wire:model="dateTo" required>
                                </div>
                                @error('DOB')
                                    <span class="error text-danger ">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="inputName" class="control-label">Reg. Branch:</label>
                                <select wire:model.defer="branch_id" class="form-control">
                                    <option value="" selected>
                                        -- All --
                                    </option>
                                    @foreach ($branches as $branche)
                                        <option value="{{ $branche->id }}">
                                            {{ $branche->name_en }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                        </div>

                        <br>
                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">Payer: <b
                                        class="text-danger fas">*</b></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="{{ $Payer_placeholder }}"
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
                                <label for="inputName" class="control-label">Contract: <b
                                        class="text-danger fas">*</b></label>
                                <select wire:model="selected_contract" class="form-control">
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
                            <div wire:loading wire:target="searchData_Financial_Claim">
                                Searching ...
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button wire:click="searchData_Financial_Claim"
                                class="btn btn-primary">Search</button>&nbsp;&nbsp;
                            <button type="button" class="btn btn-danger" wire:click="mount">Rest</button>
                        </div>

                    </div>
                </div>
            </div>
            @if ($search_clicked)
                <div class="col-xl-12">
                    <div class="card mg-b-20">
                        <div class="card-header pb-0">
                            <div class="d-flex justify-content-between">
                                <h4 class="card-title mg-b-0">Search result brief
                                </h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <label for="inputName" class="control-label">Total Visits:
                                        <b>{{ count($registration_details) }}</b></label>
                                </div>
                                <div class="col">
                                    <label for="inputName" class="control-label">Total Claim Fees: <b>
                                            <?php
                                            $total_Claim_Fees = 0;
                                            ?>
                                            @foreach ($registration_details as $registration_detail)
                                                <?php
                                                $total_Claim_Fees = $total_Claim_Fees + $registration_detail->total_Credit_Required;
                                                ?>
                                            @endforeach
                                            {{ number_format($total_Claim_Fees) }}
                                        </b>
                                    </label>
                                </div>
                                <div class="col">
                                    <label for="inputName" class="control-label">Report Form:</label>
                                    <select wire:model="selected_Report_Form_Type" class="form-control">
                                        @foreach ($Report_Form_Types as $key => $Type)
                                            <option value="{{ $key }}">
                                                {{ $Type }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="d-flex justify-content-center">
                                <a href="{{ $selected_Report_Form_Type }}?payer_id={{ $this->payer_contracts[0]['payer_id'] }}&branch_id={{ $this->branch_id }}&contract_id={{ $this->selected_contract }}&date_from={{ $this->dateFrom }}&date_To={{ $this->dateTo }}&excluded_services={{ serialize($excluded_services) }}"
                                    onclick="var popup =window.open(this.href, 'mywin',
                            'left=20,top=20,width=900,height=700'); return false; "> <button type="submit"
                                        class="btn btn-success">
                                        View Claim</button></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-12">
                    <div class="card mg-b-20">
                        <div class="card-header pb-0">
                            <div class="d-flex justify-content-between">
                                <h4 class="card-title mg-b-0">Search result data
                                </h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example1" class="table table-hover mb-0 text-md-nowrap" data-page-length='50'
                                    style="text-align: center">
                                    <thead>
                                        <tr style="text-align: center">
                                            <th>Included</th>
                                            <th>Acc.No.</th>
                                            <th>Patient Name(s)</th>
                                            <th>Service</th>
                                            <th>Service Price</th>
                                            <th>Insurance</th>
                                            <th>Patient</th>
                                            <th>payer & contract</th>
                                            <th>Reg. Branch</th>
                                            <th>Claim Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($search_clicked)
                                            @foreach ($registration_details as $key => $registration_detail)
                                                @foreach ($registered_serv_prices->where('acc', $registration_detail->acc) as $registered_serv_price)
                                                    <tr style="text-align: center">
                                                        <td>
                                                            <?php
                                                            $flag = 0;
                                                            ?>
                                                            @foreach ($excluded_services as $id)
                                                                @if ($registered_serv_price->id == $id)
                                                                    <?php
                                                                    $flag = 1;
                                                                    ?>
                                                                    @break
                                                                @endif
                                                            @endforeach
                                                            
                                                            @if ($flag == 0)
                                                                <input type="checkbox"
                                                                    wire:click="excluded_services_from_Claim({{ $registered_serv_price->id }})"
                                                                    checked>
                                                            @else
                                                                <input type="checkbox"
                                                                    wire:click="excluded_services_from_Claim({{ $registered_serv_price->id }})">
                                                            @endif
                                                        </td>
                                                        <td>{{ $registration_detail->acc }}</td>
                                                        <td>{{ $registration_detail->patient->patient_name }}</td>
                                                        <td>{{ $registered_serv_price->service->name_en }}</td>
                                                        <td>{{ number_format($registered_serv_price->current_price) }}
                                                        </td>
                                                        <td>{{ number_format($registered_serv_price->service_price_credit) }}
                                                        </td>
                                                        <td>{{ number_format($registered_serv_price->service_price_cash) }}
                                                        </td>
                                                        <td>{{ $registration_detail->payer->name_en }} ,
                                                            {{ $registration_detail->payer_contract->name_en }}
                                                        </td>
                                                        <td>{{ $registration_detail->branch->name_en }}</td>
                                                        <td>{{ $registration_detail->created_at }}</td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif


        </div>
