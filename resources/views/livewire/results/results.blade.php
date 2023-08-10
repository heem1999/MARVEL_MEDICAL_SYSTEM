@if ($page == '')
<div class="row row-sm">
    @if (!$Search_By_Sample_ID && !$search_clicked)
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
                        <label for="inputName" class="control-label">Patient
                            No:</label>
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
                        <label for="inputName" class="control-label">Contract:</label>
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
                <div class="row">
                    <div class="col">
                        <input type="checkbox" name="isActive" value="{{ $Search_By_Sample_ID }}"
                            wire:model="Search_By_Sample_ID" onclick="autofucs_sample()">
                        <label for="inputName" class="control-label">Search By Sample ID</label>
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
    @endif

    @if ($Search_By_Sample_ID)
    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0"><input type="checkbox" name="isActive"
                            value="{{ $Search_By_Sample_ID }}" wire:model="Search_By_Sample_ID"
                            onclick="autofucs_sample1()"> Search By Sample
                        ID
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
                        <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                            <label for="inputName" class="control-label">Sample ID: <b
                                    class="text-danger fas">*</b></label>
                            <input type="text" class="form-control" name="Sample_barcode" id="Sample_barcode" autofocus
                                wire:model="Sample_ID" wire:keydown.enter="get_sample_ID_DATA">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif


    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0">Search results
                    </h4>
                </div>
            </div>
            <div class="card-body">
                @if ($registration_details && $search_clicked)
                <div id="SampleDetails">
                    @if ($quickEdit)
                    <div class="row">
                        <div class=" justify-content-center">
                            Registration ({{ $index_patient }}) of
                            ({{ count($registration_details) }}) Registrations &nbsp;&nbsp;
                            <button {{ $index_patient==0 ? 'disabled' : '' }} title="Previous" wire:click="Previous"
                                class="btn btn-primary"><i class="fas fa-angle-left"></i></button>&nbsp;&nbsp;
                            <button {{ $index_patient !==count($registration_details) - 1 ? '' : 'disabled' }}
                                title="Next" wire:click="Next" class="btn btn-primary"><i
                                    class="fas fa-angle-right"></i></button>&nbsp;&nbsp;
                            <button title="Edit search" wire:click="Edit_search" class="btn btn-info"><i
                                    class="fas fa-edit"></i></i></i></button>&nbsp;&nbsp;
                        </div>
                    </div>
                    @endif

                    <div style="width: 100%; height: 20px; border-bottom: 1px solid black; text-align: center">
                        <span style="font-size: 15px; background-color: #F3F5F6; padding: 0 10px;">
                            Patient Details
                        </span>
                    </div>
                    <br>
                    {{-- @foreach ($registration_details as $key => $registration_detail) --}}
                    @if ($registration_detail)
                    <div class="row">
                        <div class="col">
                            <label for="inputName" class="control-label">Patient name:
                            </label>
                            <b id="patient_name">{{ $registration_detail->patient->patient_name }} </b>
                        </div>

                        <div class="col">
                            <label for="inputName" class="control-label">Gender:
                            </label>
                            <b id="gender">{{ $registration_detail->patient->gender }}</b>
                        </div>

                        <div class="col">
                            <label for="inputName" class="control-label">Age:
                            </label>
                            <b id="acc">{{ $registration_detail->patient->age_d }}</b> D -
                            <b id="acc">{{ $registration_detail->patient->age_m }}</b> M -
                            <b id="acc">{{ $registration_detail->patient->age_y }}</b> Y
                        </div>

                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="inputName" class="control-label">Payer:
                            </label>
                            <b id="patient_name">{{ $registration_detail->payer->name_en }} </b>
                        </div>
                        <div class="col">
                            <label for="inputName" class="control-label">Contract:
                            </label>
                            <b id="patient_name">
                                {{ $registration_detail->payer_contract->name_en }} </b>
                        </div>

                        <div class="col">
                            <label for="inputName" class="control-label">ACC No.:
                            </label>
                            <b id="patient_name"> {{ $registration_detail->acc }} </b>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="inputName" class="control-label">Branch:
                            </label>
                            <b id="registrationDate">{{ $registration_detail->branch->name_en }}</b>
                        </div>
                        <div class="col">
                            <label for="inputName" class="control-label">Registration Date:
                            </label>
                            <b id="registrationDate">{{ $registration_detail->created_at }}</b>
                        </div>
                        <div class="col">
                            <label for="inputName" class="control-label">Referring Doctor:
                            </label>
                            <b id="registrationDate">{{ $registration_detail->referringDoctor->name_en }}</b>
                        </div>
                    </div>
                    @endif
                    {{-- @endforeach --}}
                </div>

                <br>
                <div class="text-wrap">
                    <div class="example">
                        <div class="panel panel-primary tabs-style-2">
                            <div class=" tab-menu-heading">
                                <div class="tabs-menu1">
                                    @foreach ($service_tests as $key => $service_test)
                                    @foreach ($service_test as $key1 => $service_test2)
                                    @if ($selected_clinical_color == $key)
                                    <button style=" border: 2px solid black;" class="btn btn-danger"
                                        wire:click="get_service_tests('{{ $key }}')">{{ $key1 }}</button>

                                    &nbsp;&nbsp;
                                    @else
                                    <button class="btn btn-primary" wire:click="get_service_tests('{{ $key }}')">{{
                                        $key1 }}</button>
                                    &nbsp;&nbsp;
                                    @endif
                                    @endforeach
                                    @endforeach

                                    <div
                                        style="width: 100%; height: 20px; border-bottom: 1px solid black; text-align: center">
                                        <span style="font-size: 15px; background-color: #F3F5F6; padding: 0 10px;">
                                            Samples Ids
                                        </span>
                                    </div>
                                    <div style=" background-color: #F3F5F6;" class="d-flex justify-content-center">
                                        <br>
                                        @foreach ($show_sample_ids as $sample_id)
                                        <h4>{{ $sample_id->sample_barcode }}</h4>&nbsp;,&nbsp;
                                        @endforeach
                                        {{-- @foreach ($show_sample_ids as $sample_id)
                                        <h4>{{ $sample_id->processing_unit->name_en }}</h4> ,
                                        @endforeach --}}

                                    </div>

                                    <a href="View_Patient_Last_Results?patient_id={{ $this->registration_detail->patient->id }}&current_tests={{ serialize($current_tests) }}"
                                        onclick="var popup =window.open(this.href, 'mywin',
                                        'left=20,top=20,width=900,height=700'); return false; "> <button {{
                                            $last_tests_results ? '' : 'disabled' }} type="submit"
                                            class="btn btn-success">
                                            <i class="fas fa-poll"></i>
                                             Patient Last Results</button></a>
                                            <button wire:click="view_regisration_comment" class="btn btn-primary"> <i class="fas fa-comment-dots"></i> Show Patient Regisration Comments</button>
                                </div>
@if ($show_regisration_comment)
<br>
<div class="form-outline mb-4">
    <textarea readonly style="outline: none !important;
    border:1px solid red;
    box-shadow: 0 0 10px #afccec;" class="form-control" id="textAreaExample6" rows="5">
        @if ($this->registration_detail->regisration_comment)
        {{ $this->registration_detail->regisration_comment }}
        @else
            N/A
        @endif
    </textarea>
  </div>       
@endif
                            </div>
                            <br>

                            @if ($Error_permisson)
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ $Error_permisson }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                                </button>
                            </div>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-bordered mg-b-0 text-md-nowrap">
                                    <thead>
                                        <tr style="text-align: center">
                                            <th>Test name</th>
                                            <th>Result</th>
                                            <th>Unit</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Non Num. Ref.</th>
                                            <th>Analyzer</th>
                                            <th>T.S.</th>
                                            <th>Operations</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reg_samples_barcode_servs_test as $key => $rsbst)
                                        @if ($rsbst->test->test_type == 'Numeric')
                                        <tr style="text-align: center">
                                            <td>{{ $rsbst->test->name_en }}</td>
                                            <td>
                                                <input type="text" class="form-control"
                                                    wire:model="test_result.{{ $key }}.test_result"
                                                    value="{{ $rsbst->result }}">
                                                @if ($rsbst->result < $rsbst->from)
                                                    <i class="text-warning fas fa-exclamation-triangle"></i>
                                                    @elseif ($rsbst->result > $rsbst->to)
                                                    <i class="text-warning fas fa-exclamation-triangle"></i>
                                                    @endif
                                            </td>
                                            <td>
                                                <select wire:model="test_result.{{ $key }}.unit" required
                                                    class="form-control ">
                                                    @foreach ($Units as $unit)
                                                    @if ($unit->name_en == $rsbst->test->unit->name_en)
                                                    <option selected value="{{ $unit->name_en }}">
                                                        {{ $unit->name_en }}</option>
                                                    @else
                                                    <option value="{{ $unit->name_en }}">
                                                        {{ $unit->name_en }}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control"
                                                    wire:model="test_result.{{ $key }}.from" value="{{ $rsbst->from }}">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control"
                                                    wire:model="test_result.{{ $key }}.to" value="{{ $rsbst->to }}">
                                            </td>
                                            <td>
                                                <textarea wire:model="test_result.{{ $key }}.non_num_ref" name="" id=""
                                                    cols="10" rows="2"> </textarea>
                                            </td>
                                            @if ( $rsbst->analyzer_id>0)
                                            <td>{{ $rsbst->analyzer->name_en }}</td>
                                            @else
                                            <td> - </td>
                                            @endif
                                            

                                            <td>{{ $rsbst->test_status }}</td>
                                            <td>
                                                @if ($rsbst->test_status == 'Received')
                                                <i title="Save" class="text-primary fas fa-check"
                                                    wire:click="save_test_result({{ $rsbst->id }},{{ $rsbst->rsbs_id }},{{ $key }},'Save')"></i>
                                                &nbsp;
                                                @elseif ($rsbst->test_status == 'Verified')
                                                <i title="Review"
                                                    wire:click="save_test_result({{ $rsbst->id }},{{ $rsbst->rsbs_id }},{{ $key }},'Review')"
                                                    class="text-success fas fa-check-double"></i>
                                                &nbsp;
                                                @elseif ($rsbst->test_status == 'Reviewed')
                                                <i title="Undo Review"
                                                    wire:click="save_test_result({{ $rsbst->id }},{{ $rsbst->rsbs_id }},{{ $key }},'Undo Review')"
                                                    class="text-danger fas fa-window-close"></i>
                                                &nbsp;
                                                @else
                                                <label for="inputName" class='text-danger control-label'>Not received
                                                    yet.
                                                    @endif

                                                    @if ($rsbst->test_status == 'Received' || $rsbst->test_status ==
                                                    'Verified' || $rsbst->test_status == 'Reviewed')
                                                    @if ($rsbst->test_comment == '')
                                                    <a data-effect="effect-scale" href="#test_comment"
                                                        wire:click="selected_test_comment({{ $rsbst }})">
                                                        <i title="Show comment"
                                                            class="text-primary far fa-comment-dots"></i></a>
                                                    @else
                                                    <a data-effect="effect-scale" href="#test_comment"
                                                        wire:click="selected_test_comment({{ $rsbst }})">
                                                        <i title="Show comment"
                                                            class="text-primary fas fa-comment-dots"></i></a>
                                                    @endif
                                                    @endif
                                            </td>
                                        </tr>
                                        @elseif($rsbst->test->test_type == 'Optional List')
                                        <tr style="text-align: center">
                                            <td>{{ $rsbst->test->name_en }}</td>
                                            <td>
                                                <select wire:model="test_result.{{ $key }}.test_result" required
                                                    class="form-control ">
                                                    <option selected value="">
                                                        -- select --
                                                    </option>
                                                    @foreach ($Tests_configurations_option_list->where('test_id',
                                                    $rsbst->test_id) as $option_value)
                                                    @if ($option_value->option_list_value == $rsbst->test_result)
                                                    <option selected value="{{ $option_value->option_list_value }}">
                                                        {{ $option_value->option_list_value }}
                                                    </option>
                                                    @else
                                                    <option selected value="{{ $option_value->option_list_value }}">
                                                        {{ $option_value->option_list_value }}
                                                    </option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            @if ( $rsbst->analyzer_id>0)
                                            <td>{{ $rsbst->analyzer->name_en }}</td>
                                            @else
                                            <td> - </td>
                                            @endif
                                            <td>{{ $rsbst->test_status }}</td>
                                            <td>
                                                @if ($rsbst->test_status == 'Received')
                                                <i title="Save" class="text-primary fas fa-check"
                                                    wire:click="save_test_result({{ $rsbst->id }},{{ $rsbst->rsbs_id }},{{ $key }},'Save')"></i>
                                                &nbsp;
                                                @elseif ($rsbst->test_status == 'Verified')
                                                <i title="Review"
                                                    wire:click="save_test_result({{ $rsbst->id }},{{ $rsbst->rsbs_id }},{{ $key }},'Review')"
                                                    class="text-success fas fa-check-double"></i>
                                                &nbsp;
                                                @elseif ($rsbst->test_status == 'Reviewed')
                                                <i title="Undo Review"
                                                    wire:click="save_test_result({{ $rsbst->id }},{{ $rsbst->rsbs_id }},{{ $key }},'Undo Review')"
                                                    class="text-danger fas fa-window-close"></i>
                                                &nbsp;
                                                @else
                                                <label for="inputName" class='text-danger control-label'>Not received
                                                    yet.
                                                    @endif
                                                    @if ($rsbst->test_status == 'Received' || $rsbst->test_status ==
                                                    'Verified' || $rsbst->test_status == 'Reviewed')
                                                    @if ($rsbst->test_comment == '')
                                                    <a data-effect="effect-scale" href="#test_comment"
                                                        wire:click="selected_test_comment({{ $rsbst }})">
                                                        <i title="Show comment"
                                                            class="text-primary far fa-comment-dots"></i></a>
                                                    @else
                                                    <a data-effect="effect-scale" href="#test_comment"
                                                        wire:click="selected_test_comment({{ $rsbst }})">
                                                        <i title="Show comment"
                                                            class="text-primary fas fa-comment-dots"></i></a>
                                                    @endif
                                                    @endif
                                            </td>
                                        </tr>
                                        @elseif($rsbst->test->test_type == 'Culture')
                                        <tr style="text-align: center">
                                            <td>{{ $rsbst->test->name_en }}</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>{{ $rsbst->test_status }}</td>
                                            <td>
                                                <a href="results?pagename=Culture_result&rsbst_id={{ $rsbst->id }}"
                                                    onclick="var popup =window.open(this.href, 'mywin',
                                                                'left=20,top=20,width=900,height=700');  popup.onbeforeunload = function(){
                                                                    Livewire.emit('update_cultuer_test',{{ $selected_clinical_color }});
                                                                        }; return false; ">
                                                    <i class="fas fa-vials"></i> Configure </a>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div id="test_comment">
                    @if ($selected_test_comment_id)
                    <div class="row row-sm">
                        <div class="col-xl-12">
                            <div class="card mg-b-20">
                                <div class="card-header pb-0">
                                    <div class="d-flex justify-content-between">
                                        <h4 class="card-title mg-b-0">Test comment for (
                                            {{ $test_name }} )
                                        </h4>
                                        <button disabled type="submit" class="btn btn-info"
                                            wire:click="save_test_comment">
                                            <i title="Show comment" class="text-primary far fa-comment-dots"></i> Insert
                                            comments</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <div class="col">
                                                <label for="recipient-name" class="col-form-label">Comment:
                                                </label>
                                                @if ($test_comment_type == 'Result')
                                                <a href="#test_comment" wire:click="toggle_test_comment_type">
                                                    (<i class="text-primary fas fa-eye"></i>) The below
                                                    comment
                                                    will appear in the patient result.
                                                </a>
                                                @else
                                                <a href="#test_comment" wire:click="toggle_test_comment_type"> (<i
                                                        class="text-danger fas fa-eye-slash"></i>)
                                                    This comment is an internal comment, it will not
                                                    appear in the patient result.</a>
                                                @endif

                                                <textarea wire:model.defer="test_comment" cols="150" rows="5">
                                                             </textarea>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="d-flex justify-content-center">
                                            <div wire:loading wire:target="save_test_comment">
                                                Saving...
                                            </div>
                                        </div>
                                        <br>

                                        <div class="d-flex justify-content-center">
                                            <button type="submit" class="btn btn-primary"
                                                wire:click="save_test_comment">Save</button>&nbsp;&nbsp;
                                            <button type="button" class="btn btn-secondary"
                                                wire:click="close_test_comment">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@elseif ($page == 'Results_Delivery')
@include('livewire.results.results_delivery')
@elseif ($page == 'Delivery_Details')
@include('livewire.results.delivery_details')
@elseif ($page == 'Culture_result')
@include('livewire.results.result_clutuer_tests')
@elseif ($page == 'WorkLists')
@include('livewire.results.WorkLists')
@elseif ($page == 'SampleTrack')
@include('livewire.results.SampleTrack')
@endif
