<div class="row row-sm">
    <div class="col-xl-12">
        <!-- div -->
        <div class="card mg-b-20" id="tabs-style2">
            <div class="text-wrap">
                <div class="example">
                    <div class="panel panel-primary tabs-style-2">
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
                                    @if (session()->has('Add'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>{{ session()->get('Add') }}</strong>
                                            <button type="button" class="close" data-dismiss="alert"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                    <div class="row">
                                        <div class="col">
                                            <label for="inputName" class="control-label">Reg. Branch: <b
                                                    class="text-danger fas">*</b></label>

                                            <select wire:model.defer="selected_reg_branche_id" wire:change="Search"
                                                class="form-control ">
                                                <option value="0" selected>
                                                    -- Select item --
                                                </option>
                                                @foreach ($branches as $branche)
                                                    <option value="{{ $branche->id }}">
                                                        {{ $branche->name_en }}
                                                    </option>
                                                @endforeach
                                            </select>

                                        </div>
                                        {{-- <div class="col">
                                            <label for="inputName" class="control-label">Service: <b
                                                    class="text-danger fas">*</b></label>
                                            <select class="form-control " wire:model.defer="selected_service_id"
                                                wire:change="Search">
                                                <option value="0" selected>
                                                    -- Select item --
                                                </option>
                                                @foreach ($services as $service)
                                                    <option value="{{ $service->id }}">
                                                        {{ $service->name_en }}
                                                    </option>
                                                @endforeach

                                            </select>

                                        </div>--}}
                                        <div class="col">
                                            <label for="inputName" class="control-label">Service name:</label>
                                            <div class="input-group">
                                                <input {{ $selected_reg_branche_id ? '' : 'disabled' }} class="form-control" placeholder="Service code or name..."
                                                    type="text" wire:model="queryService"> <span
                                                    class="input-group-btn"><button class="btn btn-primary"
                                                        type="button"><span class="input-group-btn"><i
                                                                class="fa fa-search"></i></span></button></span>
                                            </div>
                                            <div wire:loading wire:target="queryService">
                                                Processing ...
                                            </div>
                                            @if (!empty($queryService))
                                                <div class="fixed top-0 bottom-0 left-0 right-0" wire:click="">
                                                </div>
                                                <div class="absolute z-10 w-full bg-light rounded-t-none  list-group ">
                                                    @if (!empty($services)&& !$queryService_done)
                                                        <ul>
                                                            @foreach ($services as $i => $service)
                                                                @if ($service->active == 1)
                                                                    <li style="cursor: pointer;">
                                                                        <i class="text-success fas fa-check-circle"></i>
                                                                        <a wire:click="search_service_by_name({{ $service->id }},'{{ $service['code'] }}','{{ $service['name_en'] }}')"
                                                                            class=" hover:bg-gray-700 list-item ">
                                                                            {{ $service['code'] }} -
                                                                            {{ $service['name_en'] }}
                                                                        </a>
                                                                    </li>
                                                                @else
                                                                    <li style="cursor: not-allowed;">
                                                                        <i class="text-danger fas fa-minus-circle"></i>
                                                                        {{ $service['code'] }} -
                                                                        {{ $service['name_en'] }}
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        {{-- <div class="list-item">No results!</div>--}}
                                                    @endif
                                                </div>
                                            @endif
                                        </div>

                                        <div class="col">
                                            <label for="inputName" class="control-label">Processing Unit:</label>
                                            <select {{ !$done ? '' : 'disabled' }}
                                                wire:model.lazy="selected_processing_units_id" class="form-control ">
                                                <option value="0" selected>
                                                    -- Select item --
                                                </option>
                                                @foreach ($processing_units as $processing_unit)
                                                    <option value="{{ $processing_unit->id }}">
                                                        {{ $processing_unit->name_en }}
                                                    </option>
                                                @endforeach

                                            </select>
                                            <div wire:loading wire:target="Search">
                                                Processing ...
                                            </div>
                                        </div>

                                    </div>

                                    <br>
                                    <div class="d-flex justify-content-center">
                                        <button wire:click="save"
                                            {{ $selected_processing_units_id > 0 && !$done ? '' : 'disabled' }}
                                            class="btn btn-primary">Save</button>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <div wire:loading wire:target="save">
                                            Saving ...
                                        </div>
                                    </div>
                                    <hr>
                                    @if ($old_service_processing_units)
                                        @foreach ($old_service_processing_units as $x)
                                            <div class="row">
                                                <div class="col">
                                                    <div class="col">
                                                        <label for="inputName" class="control-label">Reg. Branch:
                                                        </label>
                                                        <b>
                                                            <label for="inputName"
                                                                class="control-label">{{ $x->branch->name_en }}
                                                            </label>
                                                        </b>
                                                    </div>
                                                </div>

                                                <div class="col">
                                                    <div class="col">
                                                        <label for="inputName" class="control-label">Service:
                                                        </label>
                                                        <b>
                                                            <label for="inputName"
                                                                class="control-label">{{ $x->service->name_en }}
                                                            </label>
                                                        </b>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <label for="inputName" class="control-label">Processing Unit:
                                                    </label>
                                                    <b>
                                                        <label for="inputName"
                                                            class="control-label">{{ $x->processing_unit->name_en }}
                                                        </label>
                                                    </b>
                                                </div>
                                            </div>
                                        @endforeach

                                    @endif




                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>



    </div>
</div>
