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
    Add Test
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Tests</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    Add Test</span>
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
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body tabs-menu-body main-content-body-right border">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">
                                        <form action="{{ route('tests.store') }}" method="post" autocomplete="off">
                                            {{ csrf_field() }}
                                            {{-- 1 --}}

                                            <div class="row">
                                                <div class="col">
                                                    <label for="inputName" class="control-label">Clinical Units:
                                                        <b class="text-danger fas">*</b></label>
                                                    <select required name="clinical_unit_id" class="form-control ">
                                                        <option value="" selected disabled>Select clinical unit</option>
                                                        @foreach ($clinical_units as $clinical_unit)
                                                            <option value="{{ $clinical_unit->id }}">
                                                                {{ $clinical_unit->name_en }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <label for="inputName" class="control-label">English Name: <b
                                                            class="text-danger fas">*</b></label>
                                                    <input type="text" class="form-control" id="inputName" name="name_en"
                                                        title="Please enter the test Name" required>
                                                </div>

                                                <div class="col">
                                                    <label for="inputName" class="control-label">Arabic Name: </label>
                                                    <input type="text" class="form-control" id="inputName" name="name_ar"
                                                        title="Please enter the test name in arabic">
                                                </div>

                                                <div class="col">
                                                    <label for="inputName" class="control-label">Code: <b
                                                            class="text-danger fas">*</b></label>
                                                    <input type="text" class="form-control" id="inputName" name="code"
                                                        title="Please enter the test code" required
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
                                                        required>
                                                </div>

                                                <div class="col">
                                                    <label for="inputName" class="control-label">Gender: </label>
                                                    <select required name="gender" class="form-control ">
                                                        <option value="All">All</option>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                    </select>
                                                </div>

                                                <div class="col">
                                                    <label for="inputName" class="control-label">Sample type: <b
                                                            class="text-danger fas">*</b></label>
                                                    <select required name="sample_type_id" class="form-control ">
                                                        <option value="" selected disabled>Select Sample type</option>
                                                        @foreach ($sample_types as $sample_type)
                                                            <option value="{{ $sample_type->id }}">
                                                                {{ $sample_type->name_en }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <label for="inputName" class="control-label">Sample condition: <b
                                                            class="text-danger fas">*</b></label>
                                                    <select required id="sample_condition_id" name="sample_condition_id"
                                                        class="form-control">
                                                        <option value="" selected disabled>Select Sample condition</option>
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
                                                        @if ($unit->name_en=='.')
                                                        <option selected value="{{ $unit->id }}">
                                                            {{ $unit->name_en }}</option>
                                                        @else
                                                        <option value="{{ $unit->id }}">
                                                            {{ $unit->name_en }}</option>
                                                        @endif
                                                            
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <label for="inputName" class="control-label">Test type: </label>
                                                    <select name="test_type" class="form-control ">
                                                        <option value="Numeric">Numeric</option>
                                                        <option value="Optional_List">Optional List</option>
                                                        <option value="Culture">Culture</option>
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <input type="checkbox" name="isActive" checked>
                                                    <label for="inputName" class="control-label">Active</label>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="d-flex justify-content-center">
                                                <button type="submit" class="btn btn-primary">Save</button>&nbsp;&nbsp;
                                                <a href=" {{ url('tests') }}"> <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button></a>
                                            </div>
                                        </form>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>

                </div>

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

@endsection
