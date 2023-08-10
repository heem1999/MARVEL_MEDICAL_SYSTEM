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
    Edit Branches
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Branches</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    Edit Branches</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

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
                                        <li><a href="#tab2" class="nav-link" data-toggle="tab">Processing Units</a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body tabs-menu-body main-content-body-right border">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">
                                        <form action="{{ url('branches/update') }}" method="post" autocomplete="off">
                                            {{ method_field('patch') }}
                                            {{ csrf_field() }}
                                            {{-- 1 --}}

                                            <div class="row">
                                                <input type="hidden" class="form-control" id="branch_id" name="branch_id"
                                                    value="{{ $branches->id }}">
                                                <div class="col">
                                                    <label for="inputName" class="control-label"> Name</label>
                                                    <input type="text" class="form-control" id="inputName" name="name_en"
                                                        title="Pleas enter the Branche Name"
                                                        value="{{ $branches->name_en }}" required>
                                                </div>

                                                <div class="col">
                                                    <label for="inputName" class="control-label">Code</label>
                                                    <input type="text" class="form-control" id="inputName" name="code"
                                                        title="Pleas enter the Branche Name"
                                                        value="{{ $branches->code }}" required>
                                                </div>
                                                <div class="col">
                                                    <label for="inputName" class="control-label">Region</label>
                                                    <select required name="region_id" class="form-control SlectBox"
                                                        onclick="console.log($(this).val())"
                                                        onchange="console.log('change is firing')">
                                                        <!--placeholder-->
                                                        <option value=" {{ $branches->region->id }}">
                                                            {{ $branches->region->name_en }}
                                                        </option>
                                                        @foreach ($regions as $regions)
                                                            <option value="{{ $regions->id }}">
                                                                {{ $regions->name_en }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    @if ($branches->show_time_to_receive_result)
                                                        <input type="checkbox" name="show_time_to_receive_result" checked>
                                                    @else
                                                        <input type="checkbox" name="show_time_to_receive_result">
                                                    @endif
                                                    <label for="inputName" class="control-label">Show the result date on registration comment</label>
                                                </div>
                                                <div class="col">
                                                    @if ($branches->show_result_date_receipt)
                                                        <input type="checkbox" name="show_result_date_receipt" checked>
                                                    @else
                                                        <input type="checkbox" name="show_result_date_receipt">
                                                    @endif
                                                    <label for="inputName" class="control-label">Show the result date at patient receipt</label>
                                                </div>
                                            </div>

                                            {{-- 2 --}}
                                            <div class="row">

                                                <div class="col">
                                                    <label for="inputName" class="control-label">Phone</label>
                                                    <input type="text" class="form-control" id="inputName" name="phone"
                                                        title="Pleas enter the Branche Name"
                                                        value="{{ $branches->phone }}">
                                                </div>
                                                <div class="col">
                                                    <label for="inputName" class="control-label">Email</label>
                                                    <input type="text" class="form-control" id="inputName" name="email"
                                                        title="Pleas enter the Branche Name"
                                                        value="{{ $branches->email }}">
                                                </div>
                                                <div class="col">
                                                    <label for="inputName" class="control-label">latitude</label>
                                                    <input type="text" class="form-control" id="inputName" name="lat"
                                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                        value="{{ $branches->lacation_lat }}">
                                                </div>

                                                <div class="col">
                                                    <label for="inputName" class="control-label">longitude</label>
                                                    <input type="text" class="form-control" id="inputName" name="lng"
                                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                        value="{{ $branches->lacation_lng }}">
                                                </div>
                                            </div>


                                            {{-- 5 --}}
                                            <div class="row">
                                                <div class="col">
                                                    <label for="exampleTextarea">Address</label>
                                                    <textarea class="form-control" id="exampleTextarea" name="address" rows="3">
                                                          {{ $branches->Address }}</textarea>
                                                </div>
                                            </div><br>

                                            <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                            <h5 class="card-title">المرفقات</h5>

                                            <div class="col-sm-12 col-md-12">
                                                <input type="file" name="pic" class="dropify"
                                                    accept=".pdf,.jpg, .png, image/jpeg, image/png" data-height="70" />
                                            </div><br>

                                            <div class="d-flex justify-content-center">
                                                <button type="submit" class="btn btn-primary">Save</button>&nbsp;&nbsp;
                                                <a href=" {{ url('branches') }}"> <button type="button"
                                                        class="btn btn-danger" data-dismiss="modal">Cancel</button></a>
                                            </div>


                                        </form>
                                    </div>
                                    <div class="tab-pane" id="tab2">
                                        <div class="card-header pb-0">
                                            <a href="#" data-toggle="modal" data-branch_id="{{ $branches->id }}"
                                                data-target="#add_processing_unit"
                                                class="modal-effect btn btn-sm btn-primary" style="color:white"><i
                                                    class="fas fa-plus"></i>&nbsp; Add Processing
                                                Unit</a>
                                        </div>
                                        <br>
                                        <div class="table-responsive">
                                            <table id="example1" class="table key-buttons text-md-nowrap"
                                                data-page-length='50' style="text-align: center">
                                                <thead>
                                                    <tr>
                                                        <th class="border-bottom-0">#</th>
                                                        <th class="border-bottom-0">English Name</th>
                                                        <th class="border-bottom-0">defualt samble status</th>
                                                        <th class="border-bottom-0">Operations</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $i = 0;
                                                    @endphp
                                                    @foreach ($processing_units as $Processing_unit)
                                                        @php
                                                            $i++;
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $i }}</td>
                                                            <td>{{ $Processing_unit->name_en }} </td>
                                                            <td>{{ $Processing_unit->defualt_samble_status }} </td>
                                                            <td>
                                                                <a data-effect="effect-scale" href="#"
                                                                    data-id="{{ $Processing_unit->id }}"
                                                                    data-name_en="{{ $Processing_unit->name_en }}"
                                                                    data-defualt_samble_status="{{ $Processing_unit->defualt_samble_status }}"
                                                                    data-toggle="modal" data-target="#edit_processing_unit"
                                                                    title="Edit Processing unit"><i
                                                                        class="text-danger fas fa-edit"></i></a>
                                                                &nbsp;&nbsp;
                                                                <a title="Delete Processing unit" href="#"
                                                                    data-processing_unit_id="{{ $Processing_unit->id }}"
                                                                    data-branch_id="{{ $branches->id }}"
                                                                    data-toggle="modal"
                                                                    data-target="#delete_processing_unit"><i
                                                                        class="text-danger fas fa-trash-alt "></i>&nbsp;&nbsp;
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


    <!-- Add -->
    <div class="modal fade" id="add_processing_unit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add processing unit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('add_Processing_units') }}" method="get" enctype="multipart/form-data"
                        autocomplete="off">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <input type="hidden" name="branch_id" id="branch_id" value="">
                            <label for="recipient-name" class="col-form-label">Processing unit name</label>
                            <input class="form-control" name="name_en" id="name_en" type="text">
                        </div>
                        <div class="form-group">
                            <p class="mg-b-10"> Defualt samble status: <b class="text-danger fas">*</b></p>
                            <select class="form-control" name='defualt_samble_status' required>
                                @foreach ($samble_status as $samble_stat)
                                    <option value="{{ $samble_stat }}">
                                        {{ $samble_stat }}
                                    </option>
                                @endforeach
                            </select>
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

    <!-- حذف  -->
    <div class="modal fade" id="delete_processing_unit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete processing
                        unit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <form action="{{ route('delete_processing_unit') }}" method="post">
                        @csrf
                </div>
                <div class="modal-body">
                    <div class="form-group">

                        <input type="hidden" name="Processing_unit_id" id="Processing_unit_id" value="">
                        <label for="recipient-name" class="col-form-label">Are you sure you want to delete this processing
                            unit?</label>
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

    <!-- edit -->
    <div class="modal fade" id="edit_processing_unit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit processing
                        unit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="{{ route('update_processing_unit') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" name="id" id="id" value="">
                            <label for="recipient-name" class="col-form-label">English Name</label>
                            <input class="form-control" name="name_en" id="name_en" type="text">
                        </div>
                        <div class="form-group">
                            <p class="mg-b-10"> Defualt samble status: <b class="text-danger fas">*</b></p>
                            <select class="form-control" name='defualt_samble_status' required>
                                @foreach ($samble_status as $samble_stat)
                                    <option value="{{ $samble_stat }}">
                                        {{ $samble_stat }}
                                    </option>
                                @endforeach
                            </select>
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
        var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();
    </script>

    <script>
        $('#add_processing_unit').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var branch_id = button.data('branch_id')
            var name_en = button.data('name_en')
            var modal = $(this)
            modal.find('.modal-body #branch_id').val(branch_id);
        })
    </script>


    <script>
        $('#delete_processing_unit').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var Processing_unit_id = button.data('processing_unit_id')
            var modal = $(this)
            modal.find('.modal-body #Processing_unit_id').val(Processing_unit_id);
        })
    </script>
    <!-- edit fill -->
    <script>
        $('#edit_processing_unit').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var name_en = button.data('name_en')
            var defualt_samble_status = button.data('defualt_samble_status')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #name_en').val(name_en);
            modal.find('.modal-body #defualt_samble_status').val(defualt_samble_status);
        })
    </script>

@endsection
