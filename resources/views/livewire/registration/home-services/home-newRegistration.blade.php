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
                                    <li><a href="#tab1" class="nav-link active" data-toggle="tab">Patient
                                            Info.</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body tabs-menu-body main-content-body-right border">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab1">

                                    @if ($error_message)
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ $error_message }}
                                    </div>
                                    @endif
                                    @if ($success_message)
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>{{ $success_message }}</strong>
                                    </div>
                                    @endif

                                    <div wire:poll.visible>

                                    <div class="row">
                                        <div class="col">
                                            <label for="inputName" class="control-label">Patient Name: <b
                                                    class="text-danger fas">*</b></label>
                                            <input type="text" class="form-control"
                                                wire:model="p_data.p_name" required>
                                            @error('patient_name')
                                                <span class="error text-danger ">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col">
                                            <label for="inputName" class="control-label">Gender: <b
                                                    class="text-danger fas">*</b></label>
                                            <select wire:model.defer="p_data.p_sex" class="form-control ">
                                                <option value="" selected>
                                                    -- Select Patient Gender  --
                                                </option>
                                                @foreach ($list_of_gender as $gender)
                                                    <option value="{{ $gender }}" >
                                                        {{ $gender }}
                                                    </option>
                                                @endforeach

                                            </select>
                                            @error('gender')
                                                <span class="error text-danger ">{{ $message }}</span>
                                            @enderror
                                        </div>
                                       
                                        <div class="col">
                                            <label for="inputName" class="control-label">Areas: <b
                                                    class="text-danger fas">*</b></label>
                                            <select wire:model.defer="p_data.area_id" wire:change="home_servicePrice_byArea" class="form-control ">
                                                <option value="" selected>
                                                    -- Select Area  --
                                                </option>
                                                @foreach ($branches as $area)
                                                    <option value="{{ $area->id }}">
                                                        {{ $area->name_en }}
                                                    </option>
                                                @endforeach

                                            </select>
                                            @error('gender')
                                                <span class="error text-danger ">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col">
                                            <label for="inputName" class="control-label">Age:<b
                                                class="text-danger fas">*</b></label>
                                            <input type="text" class="form-control"
                                                wire:model.lazy="p_data.p_age" required>
                                        </div>
                                        <div class="col">
                                            <label for="inputName" class="control-label">Phone1:<b
                                                class="text-danger fas">*</b></label>
                                            <input type="text" class="form-control"
                                                wire:model.lazy="p_data.p_phone1" required>
                                        </div>
                                        <div class="col">
                                            <label for="inputName" class="control-label">Phone2:</label>
                                            <input type="text" class="form-control"
                                                wire:model.lazy="p_data.p_phone2">
                                        </div>
                                        <div class="col">
                                            <label for="inputName" class="control-label">Visit Date:<b
                                                class="text-danger fas">*</b></label>
                                           
                                                <div class="input-group ">
                                                    <input class="form-control" type="date" wire:model="p_data.visit_date"
                                                    required>
                                                </div>
                                        </div>
                                    </div>
                               <br>
                               <div class="row">
                                    <hr>
                                    <div class="row">
                                        <div class="col">
                                            <label for="inputName" class="control-label">Payer: <b
                                                    class="text-danger fas">*</b></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control"
                                                    placeholder="{{ $Payer_placeholder }}"
                                                    wire:model="queryPayer"
                                                     />

                                            </div>
                                            @error('selected_payers')
                                                <span class="error text-danger ">{{ $message }}</span>
                                            @enderror
                                            @if (!empty($queryPayer))
                                               
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
                                            <select wire:model.defer="selected_contract" class="form-control">
                                                <option value="">
                                                    -- Select item --
                                                </option>
                                                @foreach ($payer_contracts as $contract)
                                                    <option value="{{ $contract->id }}">
                                                        {{ $contract->name_en }}
                                                    </option>
                                                @endforeach

                                            </select>
                                            @error('selected_contract')
                                                <span class="error text-danger ">{{ $message }}</span>
                                            @enderror
                                        </div>  
                                       
                                    </div>
                        </div>
                        <br>
                       
                        @if ($selected_area)
                        <label for="inputName" class="control-label">
                            <b>Home visit price calculation according to the appointment area is as follows:</b>
                        </label>
                        <div class="row">
                            
                            <div class="col">
                                <div class="col">
                                    <label for="inputName" class="control-label">Area:
                                    </label>
                                    <b>
                                        <label for="inputName" class="control-label">{{ $selected_area->name_en }}
                                        </label>
                                    </b>
                                </div>
                            </div>

                            <div class="col">
                                <div class="col">
                                    <label for="inputName" class="control-label">Fixed price (Minimum):
                                    </label>
                                    <b>
                                        <label for="inputName" class="control-label">{{number_format ($selected_area->home_visit_fixed_price) }}
                                        </label>
                                    </b>
                                </div>
                            </div>
                            
                            <div class="col">
                                <div class="col">
                                    <label for="inputName" class="control-label">Fixed zoon (Minimum):
                                    </label>
                                    <b>
                                        <label for="inputName" class="control-label">{{ $selected_area->zone_radius_km/1000 }} KM
                                        </label>
                                    </b>
                                </div>
                            </div>

                            <div class="col">
                                <div class="col">
                                    <label for="inputName" class="control-label">Extra KM price:
                                    </label>
                                    <b>
                                        <label for="inputName" class="control-label">{{ number_format($selected_area->ex_km_price) }} SDG
                                        </label>
                                    </b>
                                </div>
                            </div>

                            <hr>
                        </div>

                        <div class="row">
                            
                            <div class="col">
                                <div class="col">
                                    <label for="inputName" class="control-label">Extra KM's:
                                    </label>
                                    <input type="number" class="form-control" min="0"
                                    wire:model.lazy="extra_km" wire:change="calculate_home_servicePrice" >
                                </div>
                            </div>
                                <div class="col">
                                    <label for="inputName" class="control-label">Home visit price at:
                                    </label>
                                    <b>
                                        <label for="inputName" class="control-label">{{ number_format($p_data['home_vist_price']) }} SDG
                                        </label>
                                    </b>
                                </div>
                                <div class="col">
                                    <label for="inputName" class="control-label">Total destance:
                                    </label>
                                    <b>
                                        <label for="inputName" class="control-label">{{ $p_data['order_destanceKm']}} KM
                                        </label>
                                    </b>
                                </div>
                            
                        </div>
                        <hr>
                        <br>
                        @endif
                        
                        <div wire:loading wire:target="save_booking_newRegistration" >
                            Creating...
                        </div>
                                    <div class="d-flex justify-content-center">
                                        <button wire:click="save_booking_newRegistration" class="btn btn-success">Create</button>&nbsp;&nbsp;
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