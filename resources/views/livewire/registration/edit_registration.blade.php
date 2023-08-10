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

                                    @if (session()->has('Error'))
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            {{ session()->get('Error') }}
                                            <button type="button" class="close" data-dismiss="alert"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                    @if (session()->has('Edit'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>{{ session()->get('Edit') }}</strong>
                                            <button type="button" class="close" data-dismiss="alert"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                    <div class="row">
                                        <div class="col">
                                            <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                                                <label for="inputName" class="control-label">Patient No:</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control"
                                                        value="{{ $patient_no }}" disabled />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                                                <label for="inputName" class="control-label">ACC No:</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control"
                                                        value="{{ $ACC }}" disabled />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col">
                                            <label for="inputName" class="control-label">Patient Name: <b
                                                    class="text-danger fas">*</b></label>
                                            <input type="text" class="form-control" wire:model="patient_name">
                                            @error('patient_name')
                                                <span class="error text-danger ">{{ $message }}</span>
                                            @enderror
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
                                            @error('gender')
                                                <span class="error text-danger ">{{ $message }}</span>
                                            @enderror
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
                                            @error('DOB')
                                                <span class="error text-danger ">{{ $message }}</span>
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
                                            @error('email')
                                                <span class="error text-danger ">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col">

                                            <label for="inputName" class="control-label">Passport
                                                ID:</label>
                                            <input type="text" class="form-control" wire:model.lazy="passport">
                                        </div>
                                    </div>
                                    <br>

                                    <div class="d-flex justify-content-center">
                                        <button wire:click="update_Patient_info" class="btn btn-primary">Save
                                            data</button>
                                        {{-- - 
                                        <button type="button" class="btn btn-danger"
                                            wire:click="reset_values">Rest</button> --}}
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
