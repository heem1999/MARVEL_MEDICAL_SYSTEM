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
                                    <li><a href="#tab1" class="nav-link active" data-toggle="tab">sdfsdf</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body tabs-menu-body main-content-body-right border">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab1">

                                    @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissible fade show"
                                            role="alert">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                            <button type="button" class="close" data-dismiss="alert"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif

                                    <div class="row">
                                        <div class="col">
                                            <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                                                <label for="inputName" class="control-label">Patient
                                                    No:</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control"
                                                        placeholder="{{ $patient_no }}" wire:model="query"
                                                        wire:keydown.escape="reset_values"
                                                        wire:keydown.tab="reset_values" />

                                                </div>
                                                @if (!empty($query))
                                                    <div class="fixed top-0 bottom-0 left-0 right-0"
                                                        wire:click="reset_values">
                                                    </div>
                                                    <div
                                                        class="absolute z-10 w-full bg-light rounded-t-none  list-group ">
                                                        @if (!empty($contacts))
                                                            <ul>
                                                                @foreach ($contacts as $i => $contact)
                                                                    <li>
                                                                        <a wire:click="selectContact({{ $i }})"
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
                                            </div><!-- col-4 -->
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col">
                                            <label for="inputName" class="control-label">Patient Name: <b
                                                    class="text-danger fas">*</b></label>
                                            <input type="text" class="form-control" wire:model="patient_name">
                                            @error('patient_name') <span
                                                class="error text-danger ">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="col">
                                            <label for="inputName" class="control-label">Gender: <b
                                                    class="text-danger fas">*</b></label>
                                            <select wire:model.defer="gender" class="form-control ">
                                                <option value="" selected>
                                                    -- Select item --
                                                </option>
                                                @foreach ($list_of_gender as $gender)
                                                    <option value="{{ $gender }}" selected>
                                                        {{ $gender }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="col">
                                            <label for="inputName" class="control-label">Marital Status:
                                            </label>
                                            <select wire:model.defer="marital_status" class="form-control ">

                                                <option value="" selected>
                                                    -- Select item --
                                                </option>
                                                @foreach ($list_of_marital_status as $marital_status)
                                                    <option value="{{ $marital_status }}">
                                                        {{ $marital_status }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col">
                                            <label for="inputName" class="control-label">DOB: <b
                                                    class="text-danger fas">*</b></label>
                                            <div class="input-group ">
                                                <input class="form-control" type="date" wire:model="DOB"
                                                    wire:change="DateOfBirh">
                                            </div>
                                            @error('DOB') <span
                                                    class="error text-danger ">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col">
                                            <label for="inputName" class="control-label">D:
                                                <input type="text" class="form-control" wire:change="day"
                                                    wire:model.lazy="age_d">
                                        </div>

                                        <div class="col">
                                            <label for="inputName" class="control-label">M:
                                                <input type="text" class="form-control" wire:change="month"
                                                    wire:model.lazy="age_m">
                                        </div>
                                        <div class="col">
                                            <label for="inputName" class="control-label">Y:
                                                <input type="text" class="form-control" wire:change="year"
                                                    wire:model.lazy="age_y">
                                        </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class="col">
                                            <label for="inputName" class="control-label">Phone:</label>
                                            <input type="text" class="form-control" wire:model.lazy="phone">
                                        </div>
                                        <div class="col">
                                            <label for="inputName" class="control-label">Email:</label>
                                            <input type="text" class="form-control" wire:model.lazy="email">
                                            @error('email') <span
                                                    class="error text-danger ">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col">

                                            <label for="inputName" class="control-label">Passport ID:</label>
                                            <input type="text" class="form-control"
                                                wire:model.lazy="passport">
                                        </div>
                                    </div>
                                    <br>
                                    <hr>
                                    <div class="row">
                                        <div class="col">
                                            <label for="inputName" class="control-label">Payer: <b
                                                    class="text-danger fas">*</b></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control"
                                                    placeholder="{{ $Payer_placeholder }}"
                                                    wire:model="queryPayer"
                                                    wire:keydown.escape="reset_queryPayer"
                                                    wire:keydown.tab="reset_queryPayer" />
                                            </div>
                                            @if (!empty($queryPayer))
                                                <div class="fixed top-0 bottom-0 left-0 right-0"
                                                    wire:click="reset_queryPayer">
                                                </div>
                                                <div
                                                    class="absolute z-10 w-full bg-light rounded-t-none  list-group ">
                                                    @if (!empty($payers))
                                                        <ul>
                                                            @foreach ($payers as $i => $payer)
                                                                @if ($payer->active == 1 && $today <= $payer->expiry_date)

                                                                    <li style="cursor: pointer;">
                                                                        <i
                                                                            class="text-success fas fa-check-circle"></i>
                                                                        <a wire:click="get_Payer_Contract({{ $i }},{{ $payer['id'] }})"
                                                                            class=" hover:bg-gray-700 list-item {{ $highlightIndex === $i ? 'highlight' : '' }}">

                                                                            {{ $payer['code'] }} -
                                                                            {{ $payer['name_en'] }}
                                                                        </a>
                                                                    </li>
                                                                @else
                                                                    <li style="cursor: not-allowed;">
                                                                        <i
                                                                            class="text-danger fas fa-minus-circle"></i>
                                                                        {{ $payer['code'] }} -
                                                                        {{ $payer['name_en'] }}
                                                                    </li>
                                                                @endif
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
                                            <select wire:model.defer="selected_contract_id"
                                                class="form-control ">

                                                @foreach ($payer_contracts as $contract)
                                                    <option value="{{ $contract->id }}">
                                                        {{ $contract->name_en }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="col">
                                            <label for="inputName" class="control-label">Insurance Id:</label>
                                            <input type="text" class="form-control"
                                                wire:model.lazy="Insurance_Id">
                                            @error('Insurance_Id') <span
                                                    class="error text-danger ">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <br>
                                    <div class="d-flex justify-content-center">
                                        <button wire:click="ShowServicePage"
                                            class="btn btn-primary">Next</button>&nbsp;&nbsp;
                                        <button type="button" class="btn btn-danger"
                                            wire:click="reset_values">Rest</button>
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