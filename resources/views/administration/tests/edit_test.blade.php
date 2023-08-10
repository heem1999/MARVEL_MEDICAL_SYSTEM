@extends('layouts.master')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    <!--Internal  TelephoneInput css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
@endsection
@section('title')
    Edit Test
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Tests</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    Edit Test -<b> {{ $test->name_en }} </b>- </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('Edit'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Edit') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


    @if (session()->has('delete'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

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
                                        <li><a href="#tab1" class="nav-link active" data-toggle="tab">Basic Data</a></li>
                                        <li><a href="#tab2" id='view_test_type_configuration' class="nav-link"
                                                data-toggle="tab">Test
                                                configurations</a>
                                        </li>
                                        <li><a href="#tab3" class="nav-link" data-toggle="tab">Questions</a></li>
                                        <li><a href="#tab4" class="nav-link" data-toggle="tab">Branch/Sample</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body tabs-menu-body main-content-body-right border">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">
                                        <form action="{{ url('tests/update') }}" method="post" autocomplete="off">
                                            {{ method_field('patch') }}
                                            {{ csrf_field() }}
                                            {{-- 1 --}}

                                            <div class="row">
                                                <input type="hidden" class="form-control" name="test_id"
                                                    value="{{ $test->id }}" required>

                                                <div class="col">
                                                    <label for="inputName" class="control-label">Clinical Units:
                                                        <b class="text-danger fas">*</b></label>
                                                    <select required name="clinical_unit_id" class="form-control ">
                                                        @foreach ($clinical_units as $clinical_unit)
                                                            @if ($clinical_unit->id !== $test->clinical_unit->id)
                                                                <option value="{{ $clinical_unit->id }}">
                                                                    {{ $clinical_unit->name_en }}</option>
                                                            @else
                                                                <option value="{{ $test->clinical_unit->id }}" selected>
                                                                    {{ $test->clinical_unit->name_en }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <label for="inputName" class="control-label">English Name: <b
                                                            class="text-danger fas">*</b></label>
                                                    <input type="text" class="form-control" id="inputName" name="name_en"
                                                        title="Please enter the test Name" value="{{ $test->name_en }}"
                                                        required>
                                                </div>

                                                <div class="col">
                                                    <label for="inputName" class="control-label">Arabic Name: </label>
                                                    <input type="text" class="form-control" id="inputName" name="name_ar"
                                                        title="Please enter the test name in arabic"
                                                        value="{{ $test->name_ar }}">
                                                </div>

                                                <div class="col">
                                                    <label for="inputName" class="control-label">Code: <b
                                                            class="text-danger fas">*</b></label>
                                                    <input type="text" class="form-control" id="inputName" name="code"
                                                        title="Please enter the test code" required
                                                        value="{{ $test->code }}"
                                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                                </div>
                                            </div>
                                            <br>
                                            {{-- 2 --}}
                                            <div class="row">
                                                <div class="col">
                                                    <label for="inputName" class="control-label">Report name: <b
                                                            class="text-danger fas">*</b></label>
                                                    <input type="text" class="form-control" id="inputName"
                                                        name="report_name" title="Please enter the test report name"
                                                        value="{{ $test->report_name }}" required>
                                                </div>


                                                <div class="col">
                                                    <label for="inputName" class="control-label">Gender: </label>
                                                    <select required name="gender" class="form-control">
                                                        @foreach ($list_of_gender as $gender)
                                                            @if ($test->gender == $gender)
                                                                <option value="{{ $gender }}" selected>
                                                                    {{ $gender }}</option>
                                                            @else
                                                                <option value="{{ $gender }}">
                                                                    {{ $gender }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col">
                                                    <label for="inputName" class="control-label">Sample type: <b
                                                            class="text-danger fas">*</b></label>
                                                    <select required name="sample_type_id" class="form-control ">

                                                        @foreach ($sample_types as $sample_type)
                                                            @if ($sample_type->id !== $test->sample_type->id)
                                                                <option value="{{ $sample_type->id }}">
                                                                    {{ $sample_type->name_en }}</option>
                                                            @else
                                                                <option value="{{ $test->sample_type->id }}" selected>
                                                                    {{ $test->sample_type->name_en }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <label for="inputName" class="control-label">Sample condition: <b
                                                            class="text-danger fas">*</b></label>
                                                    <select required id="sample_condition_id" name="sample_condition_id"
                                                        class="form-control">
                                                        <option value="{{ $test->sample_condition->id }}" selected>
                                                            {{ $test->sample_condition->name_en }}</option>
                                                    </select>

                                                </div>

                                            </div>
                                            <br>
                                            {{-- 3 --}}
                                            <div class="row">
                                                <div class="col">
                                                    <label for="inputName" class="control-label">Primary UOM:
                                                        <b class="text-danger fas">*</b></label>
                                                    <select required name="unit_id" class="form-control ">
                                                        @foreach ($units as $unit)
                                                            @if ($unit->id !== $test->unit->id)
                                                                <option value="{{ $unit->id }}">
                                                                    {{ $unit->name_en }}</option>
                                                            @else
                                                                <option value="{{ $test->unit->id }}" selected>
                                                                    {{ $test->unit->name_en }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col">

                                                    <label for="inputName" class="control-label">Test type: </label>
                                                    <select name="test_type" class="form-control ">
                                                        @foreach ($list_of_test_types as $t)
                                                            @if ($test->test_type == $t)
                                                                <option value="{{ $t }}" selected>
                                                                    {{ $t }}</option>
                                                            @else
                                                                <option value="{{ $t }}">
                                                                    {{ $t }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    @if ($test->active)
                                                        <input type="checkbox" name="isActive" checked>
                                                    @else
                                                        <input type="checkbox" name="isActive">
                                                    @endif
                                                    <label for="inputName" class="control-label">Active</label>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="d-flex justify-content-center">

                                                <button type="submit" class="btn btn-primary">Save</button>&nbsp;&nbsp;
                                                <a href=" {{ url('tests') }}"> <button type="button"
                                                        class="btn btn-danger" data-dismiss="modal">Cancel</button></a>
                                            </div>

                                        </form>
                                    </div>
                                    <div class="tab-pane" id="tab2">
                                        <!-- add_configurations_numeric -->
                                        <div id="test_configuration_numeric">
                                            <div class="card-header pb-0">
                                                <a href="#" data-toggle="modal" data-test_id="{{ $test->id }}"
                                                    data-target="#add_configurations_numeric"
                                                    class="modal-effect btn btn-sm btn-primary" style="color:white"><i
                                                        class="fas fa-plus"></i>&nbsp; Add reference range</a>
                                            </div>
                                            <br>
                                            <div class="table-responsive">
                                                <table class="table table-bordered mg-b-0 text-md-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th style="text-align: center">Age from</th>
                                                            <th style="text-align: center">Age To</th>
                                                            <th style="text-align: center">Range From</th>
                                                            <th style="text-align: center">Range To</th>
                                                            <th style="text-align: center">Gender</th>
                                                            <th style="text-align: center">Reference range comment</th>
                                                            <th style="text-align: center">#</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($test_configurations_numeric as $test_conf_numeric)
                                                            <tr style="text-align: center">
                                                                <td>D: {{ $test_conf_numeric->age_Form_d }} | M:
                                                                    {{ $test_conf_numeric->age_Form_m }} | Y:
                                                                    {{ $test_conf_numeric->age_Form_y }}</td>

                                                                <td>D: {{ $test_conf_numeric->age_To_d }} | M:
                                                                    {{ $test_conf_numeric->age_To_m }} | Y:
                                                                    {{ $test_conf_numeric->age_To_y }}</td>

                                                                <td>{{ $test_conf_numeric->range_From }}</td>
                                                                <td>{{ $test_conf_numeric->range_To }}</td>
                                                                <td>{{ $test_conf_numeric->gender }}</td>
                                                                <td>{{ $test_conf_numeric->reference_range_comment }}
                                                                </td>
                                                                <td style="text-align: center">
                                                                    <a data-toggle="modal" data-effect="effect-scale"
                                                                        title="Edit test configurations" href="#"
                                                                        data-test_conf_numeric_data="{{ $test_conf_numeric }}"
                                                                        data-target="#edit_configurations_numeric"><i
                                                                            class="text-danger fas fa-edit"></i></a>
                                                                    &nbsp;&nbsp;
                                                                    <a data-test_conf_numeric_data="{{ $test_conf_numeric }}"
                                                                        title="Delete test configurations" href="#"
                                                                        data-toggle="modal"
                                                                        data-target="#delete_configurations_numeric"><i
                                                                            class="text-danger fas fa-trash-alt "></i>&nbsp;&nbsp;
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- configurations_option_list -->
                                        <div id="test_configuration_option_list">
                                            <div class="card-header pb-0">
                                                <a href="#" data-toggle="modal" data-test_id="{{ $test->id }}"
                                                    data-target="#add_configurations_option_list"
                                                    class="modal-effect btn btn-sm btn-primary" style="color:white"><i
                                                        class="fas fa-plus"></i>&nbsp; Add value</a>
                                            </div>
                                            <br>
                                            <div class="table-responsive">
                                                <table class="table table-bordered mg-b-0 text-md-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th style="text-align: center">Value</th>
                                                            <th style="text-align: center">Operation</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($test_configuration_option_list as $configuration_option_list)
                                                            <tr style="text-align: center">
                                                                <td>{{ $configuration_option_list->option_list_value }}
                                                                </td>
                                                                <td style="text-align: center">
                                                                    <a data-effect="effect-scale" href="#"
                                                                        data-test_conf_option_list_data="{{ $configuration_option_list }}"
                                                                        data-toggle="modal"
                                                                        data-target="#edit_configurations_option_list"
                                                                        title="Edit Sample type"><i
                                                                            class="text-danger fas fa-edit"></i></a>
                                                                    &nbsp;&nbsp;
                                                                    <a data-test_conf_option_list_data="{{ $configuration_option_list }}"
                                                                        title="Delete test question" href="#"
                                                                        data-toggle="modal"
                                                                        data-target="#delete_configurations_option_list"><i
                                                                            class="text-danger fas fa-trash-alt "></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab3">
                                        <div class="card-header pb-0">
                                            <a href="#" data-toggle="modal"
                                                data-preparation_questions="{{ $preparation_questions }}"
                                                data-test_id="{{ $test->id }}" data-target="#add_question"
                                                class="modal-effect btn btn-sm btn-primary" style="color:white"><i
                                                    class="fas fa-plus"></i>&nbsp; Add questions</a>
                                        </div>
                                        <br>
                                        <div class="table-responsive">
                                            <table class="table table-bordered mg-b-0 text-md-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center">Questions</th>
                                                        <th style="text-align: center">Operation</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($preparation_questions as $preparation_question)
                                                        @foreach ($test_questions as $test_question)
                                                            @if ($preparation_question->id == $test_question->question_id)
                                                                <tr style="text-align: center">
                                                                    <td>{{ $preparation_question->question_en }} /
                                                                        {{ $preparation_question->question_ar }}</td>
                                                                    <td style="text-align: center">
                                                                        <a data-question_id="{{ $test_question->id }}"
                                                                            title="Delete test question" href="#"
                                                                            data-toggle="modal"
                                                                            data-target="#delete_question"><i
                                                                                class="text-danger fas fa-trash-alt "></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab4">
                                        <div class="card-header pb-0">
                                            <a href="#" data-toggle="modal" data-target="#add_branch_sample"
                                                class="modal-effect btn btn-sm btn-primary" style="color:white"><i
                                                    class="fas fa-plus"></i>&nbsp; Add Branch/Sample</a>
                                        </div>

                                        <br>
                                        <p class="text-danger">This will make the test sample barcode printed alone for
                                            specific branch.</p>

                                        <div class="table-responsive">
                                            <table class="table table-bordered mg-b-0 text-md-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center">Sample type</th>
                                                        <th style="text-align: center">Sample condition</th>
                                                        <th style="text-align: center">Branches</th>
                                                        <th style="text-align: center">Operation</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($test_branch_samples as $test_branch_sample)
                                                        <tr style="text-align: center">
                                                            <td>{{ $test_branch_sample->sample_type->name_en }}
                                                            </td>
                                                            <td>{{ $test_branch_sample->sample_condition->name_en }}</td>
                                                            <td>
                                                                @foreach ($test_branch_samples_branches as $test_branch_samples_branche)
                                                                    @if ($test_branch_samples_branche->test_branch_sample_id == $test_branch_sample->id)
                                                                        -
                                                                        {{ $test_branch_samples_branche->branch->name_en }}(
                                                                        <a data-test_branch_samples_branche_id="{{ $test_branch_samples_branche->id }}"
                                                                            data-test_branch_sample="{{ $test_branch_sample->id }}"
                                                                            title="Delete this branch" href="#"
                                                                            data-toggle="modal"
                                                                            data-target="#delete_single_branch_sample"><i
                                                                                class="text-danger fas fa-trash-alt "></i>
                                                                        </a>)
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td style="text-align: center">
                                                                <a data-test_branch_sample_id="{{ $test_branch_sample->id }}"
                                                                    title="Delete test branch sample" href="#"
                                                                    data-toggle="modal"
                                                                    data-target="#delete_test_branch_sample"><i
                                                                        class="text-danger fas fa-trash-alt "></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
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


    <!-- add_configurations_numeric -->
    <div class="modal" id="add_configurations_numeric">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <form action="{{ route('add_configurations_numeric') }}" method="post" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h6 class="modal-title">Add reference range</h6><button aria-label="Close"
                            class="close" data-dismiss="modal" type="button"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="card card-body pd-20 pd-md-40 border shadow-none">
                                <h5 class="card-title mg-b-20">Age Form</h5>
                                <div class="row row-sm">

                                    <!-- test id -->
                                    <input type="hidden" name="test_id" id="test_id" value="">

                                    <div class="col-sm-3 mg-t-20 mg-sm-t-0">
                                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Day</label> <input
                                            class="form-control" required="" type="text" name="age_Form_d">
                                    </div>
                                    <div class="col-sm-3 mg-t-20 mg-sm-t-0">
                                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Month</label> <input
                                            class="form-control" required="" type="text" name="age_Form_m">
                                    </div>
                                    <div class="col-sm-3 mg-t-20 mg-sm-t-0">
                                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Year</label> <input
                                            class="form-control" required="" type="text" name="age_Form_y">
                                    </div>
                                </div>
                                <br><br>
                                <h5 class="card-title mg-b-20">Age To</h5>
                                <div class="row row-sm">
                                    <div class="col-sm-3 mg-t-20 mg-sm-t-0">
                                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Day</label> <input
                                            class="form-control" required="" type="text" name="age_To_d">
                                    </div>
                                    <div class="col-sm-3 mg-t-20 mg-sm-t-0">
                                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Month</label> <input
                                            class="form-control" required="" type="text" name="age_To_m">
                                    </div>
                                    <div class="col-sm-3 mg-t-20 mg-sm-t-0">
                                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Year</label> <input
                                            class="form-control" required="" type="text" name="age_To_y">
                                    </div>
                                </div>
                                <br><br>
                                <h5 class="card-title mg-b-20">Reference range</h5>
                                <div class="row row-sm">
                                    <div class="col-sm-3 mg-t-20 mg-sm-t-0">
                                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Range From</label>
                                        <input class="form-control" required="" type="text" name="range_From">
                                    </div>
                                    <div class="col-sm-3 mg-t-20 mg-sm-t-0">
                                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Range To</label>
                                        <input class="form-control" required="" type="text" name="range_To">
                                    </div>
                                </div>
                                <br><br>
                                <div class="row row-sm">
                                    <div class="col-sm-3 mg-t-20 mg-sm-t-0">
                                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Gender </label>
                                        <select name="gender" class="form-control ">
                                            @foreach ($list_of_gender as $gender)
                                                <option value="{{ $gender }}">
                                                    {{ $gender }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-3 mg-t-20 mg-sm-t-0">
                                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Reference range
                                            comment</label> <textarea class="form-control" id="exampleTextarea"
                                            name="reference_range_comment" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn ripple btn-primary">Add</button>
                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- edit_configurations_numeric -->
    <div class="modal" id="edit_configurations_numeric">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <form action="{{ route('edit_configurations_numeric') }}" method="post" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h6 class="modal-title">Edit reference range</h6><button aria-label="Close"
                            class="close" data-dismiss="modal" type="button"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="card card-body pd-20 pd-md-40 border shadow-none">
                                <h5 class="card-title mg-b-20">Age Form</h5>
                                <div class="row row-sm">

                                    <!-- test_conf_numeric_id -->
                                    <input type="hidden" name="test_conf_numeric_id" id="test_conf_numeric_id" value="">

                                    <div class="col-sm-3 mg-t-20 mg-sm-t-0">
                                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Day</label> <input
                                            class="form-control" required="" type="text" id="age_Form_d"
                                            name="age_Form_d">
                                    </div>
                                    <div class="col-sm-3 mg-t-20 mg-sm-t-0">
                                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Month</label> <input
                                            class="form-control" required="" type="text" id="age_Form_m"
                                            name="age_Form_m">
                                    </div>
                                    <div class="col-sm-3 mg-t-20 mg-sm-t-0">
                                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Year</label> <input
                                            class="form-control" required="" type="text" id="age_Form_y"
                                            name="age_Form_y">
                                    </div>
                                </div>
                                <br><br>
                                <h5 class="card-title mg-b-20">Age To</h5>
                                <div class="row row-sm">
                                    <div class="col-sm-3 mg-t-20 mg-sm-t-0">
                                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Day</label> <input
                                            class="form-control" required="" type="text" id="age_To_d" name="age_To_d">
                                    </div>
                                    <div class="col-sm-3 mg-t-20 mg-sm-t-0">
                                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Month</label> <input
                                            class="form-control" required="" type="text" id="age_To_m" name="age_To_m">
                                    </div>
                                    <div class="col-sm-3 mg-t-20 mg-sm-t-0">
                                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Year</label> <input
                                            class="form-control" required="" type="text" id="age_To_y" name="age_To_y">
                                    </div>
                                </div>
                                <br><br>
                                <h5 class="card-title mg-b-20">Reference range</h5>
                                <div class="row row-sm">
                                    <div class="col-sm-3 mg-t-20 mg-sm-t-0">
                                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Range From</label>
                                        <input class="form-control" required="" type="text" id="range_From"
                                            name="range_From">
                                    </div>
                                    <div class="col-sm-3 mg-t-20 mg-sm-t-0">
                                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Range To</label>
                                        <input class="form-control" required="" type="text" id="range_To"
                                            name="range_To">
                                    </div>
                                </div>
                                <br><br>
                                <div class="row row-sm">
                                    <div class="col-sm-3 mg-t-20 mg-sm-t-0">
                                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Gender </label>
                                        <select name="gender" id="gender" class="form-control ">
                                            @foreach ($list_of_gender as $gender)
                                                <option value="{{ $gender }}">
                                                    {{ $gender }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-3 mg-t-20 mg-sm-t-0">
                                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Reference range
                                            comment</label> <textarea class="form-control" name="reference_range_comment"
                                            id="reference_range_comment" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn ripple btn-primary">Save</button>
                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- delete_configurations_numeric -->
    <div class="modal fade" id="delete_configurations_numeric" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete test configuration</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <form action="{{ route('delete_configurations_numeric') }}" method="post">

                        @csrf
                </div>
                <div class="modal-body">
                    <div class="form-group">

                        <!-- test_conf_numeric_id -->
                        <input type="hidden" name="test_conf_numeric_id" id="test_conf_numeric_id" value=""> <label
                            for="recipient-name" class="col-form-label">Are you sure you want to delete this test
                            configurations?</label>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Confirm</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- add_configurations_option_list -->
    <div class="modal fade" id="add_configurations_option_list" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add test configuration value</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('add_configurations_option_list') }}" method="post"
                        enctype="multipart/form-data" autocomplete="off">
                        @csrf

                        <div class="form-group">
                            <input type="hidden" class="form-control" id="test_id" name="test_id">
                            <label for="recipient-name" class="col-form-label">Option list value</label>
                            <input class="form-control" name="option_list_value" id="option_list_value" type="text"
                                required>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>

                </form>
            </div>
        </div>
    </div>

    <!-- delete_configurations_option_list  -->
    <div class="modal fade" id="delete_configurations_option_list" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete test configuration value</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <form action="{{ route('delete_configurations_option_list') }}" method="post">

                        @csrf
                </div>
                <div class="modal-body">
                    <div class="form-group">

                        <input type="hidden" name="test_conf_option_list_id" id="test_conf_option_list_id" value="">
                        <label for="recipient-name" class="col-form-label">Are you sure you want to delete this
                            test configuration value?</label>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Confirm</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- edit_configurations_option_list -->
    <div class="modal fade" id="edit_configurations_option_list" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit test configuration value</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="{{ route('edit_configurations_option_list') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" name="test_conf_option_list_id" id="test_conf_option_list_id" value="">
                            <label for="recipient-name" class="col-form-label">Option list value</label>
                            <input class="form-control" name="option_list_value" id="option_list_value" type="text">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- add_question -->
    <div class="modal" id="add_question">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <form action="{{ route('add_question_to_test') }}" method="post" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h6 class="modal-title">Add question</h6><button aria-label="Close" class="close"
                            data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <!-- test_conf_numeric_id -->
                            <input type="hidden" name="test_id" id="test_id" value="">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">Question </label>
                            <select name="question_id" id="question_id" class="form-control ">
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn ripple btn-primary">Add</button>
                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- delete_question -->
    <div class="modal fade" id="delete_question" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete question</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <form action="{{ route('delete_question_from_test') }}" method="post">

                    @csrf
                    <div class="modal-body">
                        <div class="form-group">

                            <!-- test_conf_numeric_id -->
                            <input type="hidden" name="question_id" id="question_id" value=""> <label for="recipient-name"
                                class="col-form-label">Are you sure you want to delete the question from this test?</label>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- add_branch_sample -->
    <div class="modal" id="add_branch_sample">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Add branch sample</h6><button aria-label="Close" class="close"
                        data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('add_branch_sample') }}" method="post" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <!-- test_conf_numeric_id -->
                            <input type="hidden" name="test_id" id="test_id" value="{{ $test->id }}">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">Branches </label>
                            <select name="branches_ids[]" multiple="multiple" title="Please select branch you want to add"
                                required class="form-control ">
                                @foreach ($branches as $branche)
                                    <option value="{{ $branche->id }}">
                                        {{ $branche->name_en }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="form-group">
                            <label for="inputName" class="control-label">Sample type: <b
                                    class="text-danger fas">*</b></label>
                            <select required name="sample_type_id2" id="sample_type_id2" class="form-control ">
                                <option value="">
                                    Choose sample type</option>
                                @foreach ($sample_types as $sample_type)
                                    <option value="{{ $sample_type->id }}">
                                        {{ $sample_type->name_en }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputName" class="control-label">Sample condition: <b
                                    class="text-danger fas">*</b></label>
                            <select required id="sample_condition_id2" name="sample_condition_id2" class="form-control">

                            </select>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn ripple btn-primary">Add</button>
                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- test_branch_sample_id -->
    <div class="modal fade" id="delete_test_branch_sample" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete test branch sample</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('delete_test_branch_sample') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="test_branch_sample_id" id="test_branch_sample_id" value=""> <label
                                for="recipient-name" class="col-form-label">Are you sure you want to delete this test
                                branch sample?</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- delete_single_branch_sample -->
    <div class="modal fade" id="delete_single_branch_sample" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete branch</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('delete_single_branch_sample') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="test_branch_sample" id="test_branch_sample" value="">
                            <input type="hidden" name="test_branch_samples_branche_id" id="test_branch_samples_branche_id"
                                value=""> <label for="recipient-name" class="col-form-label">Are you sure you want to
                                delete this branch?</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Fileuploads js-->
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <!--Internal Fancy uploader js-->
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
    <!--Internal  Form-elements js-->
    <script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <!--Internal Sumoselect js-->
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
    <!--Internal  Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>

    <script>
        $('#add_configurations_numeric').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var test_id = button.data('test_id')
            var modal = $(this)
            modal.find('.modal-body #test_id').val(test_id);
        })
    </script>

    <!-- delete fill -->
    <script>
        $('#delete_configurations_numeric').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var test_conf_numeric_data = button.data('test_conf_numeric_data');
            var modal = $(this)
            modal.find('.modal-body #test_conf_numeric_id').val(test_conf_numeric_data['id']);
        })
    </script>
    <!-- edit fill -->
    <script>
        $('#edit_configurations_numeric').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var test_conf_numeric_data = button.data('test_conf_numeric_data');
            var modal = $(this)
            modal.find('.modal-body #test_conf_numeric_id').val(test_conf_numeric_data['id']);
            modal.find('.modal-body #age_Form_d').val(test_conf_numeric_data['age_Form_d']);
            modal.find('.modal-body #age_Form_m').val(test_conf_numeric_data['age_Form_m']);
            modal.find('.modal-body #age_Form_y').val(test_conf_numeric_data['age_Form_y']);
            modal.find('.modal-body #age_To_d').val(test_conf_numeric_data['age_To_d']);
            modal.find('.modal-body #age_To_m').val(test_conf_numeric_data['age_To_m']);
            modal.find('.modal-body #age_To_y').val(test_conf_numeric_data['age_To_y']);
            modal.find('.modal-body #range_From').val(test_conf_numeric_data['range_From']);
            modal.find('.modal-body #range_To').val(test_conf_numeric_data['range_To']);
            modal.find('.modal-body #gender').val(test_conf_numeric_data['gender']);
            modal.find('.modal-body #reference_range_comment').val(test_conf_numeric_data[
                'reference_range_comment']);
        })
    </script>

    <!-- get sample conditions by sample type -->
    <script>
        $(document).ready(function() {
            $('select[name="sample_type_id"]').on('change', function() {

                var sample_type_id = $(this).val();
                if (sample_type_id) {
                    $.ajax({
                        url: "{{ URL::to('get_sample_conditions') }}/" + sample_type_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="sample_condition_id"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="sample_condition_id"]').append(
                                    '<option value="' +
                                    value + '">' + value.name_en + '</option>');
                            });
                        },
                    });

                } else {
                    console.log('AJAX load did not work');
                }
            });

        });
    </script>

    <!-- show the test configuration based on test type -->
    <script>
        $(document).ready(function() {
            $('select[name="sample_type_id"]').on('change', function() {

                var sample_type_id = $(this).val();
                if (sample_type_id) {
                    $.ajax({
                        url: "{{ URL::to('get_sample_conditions') }}/" + sample_type_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="sample_condition_id"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="sample_condition_id"]').append(
                                    '<option value="' +
                                    value.id + '">' + value.name_en + '</option>');
                            });
                        },
                    });

                } else {
                    console.log('AJAX load did not work');
                }
            });

        });
    </script>


    <!-- add_question -->
    <script>
        $('#add_question').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var preparation_questions = button.data('preparation_questions');
            var test_id = button.data('test_id');
            var modal = $(this)
            modal.find('.modal-body #test_id').val(test_id);
            $.each(preparation_questions, function(key, value) {
                $('select[name="question_id"]').append(
                    '<option value="' +
                    value.id + '">' + value.question_en + ' / ' + value.question_ar + '</option>');
            });
        })
    </script>

    <!-- delete_question -->
    <script>
        $('#delete_question').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var question_id = button.data('question_id');
            var modal = $(this)
            modal.find('.modal-body #question_id').val(question_id);

        })
    </script>


    <!-- show the test configuration based on test type option -->
    <script>
        $(document).ready(function() {
            $("#view_test_type_configuration").click(function() {
                var test_type = $('select[name="test_type"]').val();
                if (test_type == 'Numeric') {
                    $("#test_configuration_numeric").show();
                    $("#test_configuration_option_list").hide();

                } else if (test_type == 'Optional List') {
                    $("#test_configuration_option_list").show();
                    $("#test_configuration_numeric").hide();

                } else {
                    $("#test_configuration_option_list").hide();
                    $("#test_configuration_numeric").hide();
                }
            });

        });
    </script>



    <!-- add_configurations_option_list -->
    <script>
        $('#add_configurations_option_list').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var test_id = button.data('test_id');
            var modal = $(this)
            modal.find('.modal-body #test_id').val(test_id);
        })
    </script>

    <!-- edit_configurations_option_list -->
    <script>
        $('#edit_configurations_option_list').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var test_conf_option_list_data = button.data('test_conf_option_list_data');
            var modal = $(this)
            modal.find('.modal-body #test_conf_option_list_id').val(test_conf_option_list_data['id']);
            modal.find('.modal-body #option_list_value').val(test_conf_option_list_data['option_list_value']);

        })
    </script>

    <!-- delete_configurations_option_list -->
    <script>
        $('#delete_configurations_option_list').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var test_conf_option_list_data = button.data('test_conf_option_list_data');
            var modal = $(this)
            modal.find('.modal-body #test_conf_option_list_id').val(test_conf_option_list_data['id']);
        })
    </script>


    <!-- delete_test_branch_sample  -->
    <script>
        $('#delete_test_branch_sample').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var test_branch_sample_id = button.data('test_branch_sample_id');
            var modal = $(this)
            modal.find('.modal-body #test_branch_sample_id').val(test_branch_sample_id);
        })
    </script>

    <script>
        $(document).ready(function() {
            $('select[name="sample_type_id2"]').on('change', function() {

                var sample_type_id = $(this).val();
                if (sample_type_id) {
                    $.ajax({
                        url: "{{ URL::to('get_sample_conditions') }}/" + sample_type_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="sample_condition_id2"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="sample_condition_id2"]').append(
                                    '<option value="' +
                                    value.id + '">' + value.name_en + '</option>');
                            });
                        },
                    });

                } else {
                    console.log('AJAX load did not work');
                }
            });

        });
    </script>

    <!-- delete_single_branch_sample  -->
    <script>
        $('#delete_single_branch_sample').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var test_branch_samples_branche_id = button.data('test_branch_samples_branche_id');
            var test_branch_sample = button.data('test_branch_sample');
            var modal = $(this)
            modal.find('.modal-body #test_branch_samples_branche_id').val(test_branch_samples_branche_id);
            modal.find('.modal-body #test_branch_sample').val(test_branch_sample);
        })
    </script>


@endsection
