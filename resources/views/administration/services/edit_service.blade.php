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
    Edit Service
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Services</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    Edit Service -<b> {{ $service->name_en }} </b>- </span>
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
                                        <li><a href="#tab1" class="nav-link active" data-toggle="tab">Basic Service Data</a>
                                        </li>

                                        @if ($service->is_nested_services == 0)
                                            <li><a href="#tab2" id='Service_Test' class="nav-link"
                                                    data-toggle="tab">Service Test</a>
                                            </li>
                                        @else
                                            <li><a href="#tab2" id='Nested_Services' class="nav-link"
                                                    data-toggle="tab">Nested Services</a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body tabs-menu-body main-content-body-right border">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">
                                        <form action="{{ url('services/update') }}" method="post" autocomplete="off">
                                            {{ method_field('patch') }}
                                            {{ csrf_field() }}
                                            {{-- 1 --}}

                                            <div class="row">
                                                <div class="col">
                                                    @if ($service->active)
                                                        <input type="checkbox" name="isActive" checked>
                                                    @else
                                                        <input type="checkbox" name="isActive">
                                                    @endif
                                                    <label for="inputName" class="control-label">Active</label>
                                                </div>

                                                <div class="col">
                                                    @if ($service->is_nested_services)
                                                        <input type="checkbox" name="is_nested_services"
                                                            id="is_nested_services" checked>
                                                    @else
                                                        <input type="checkbox" name="is_nested_services"
                                                            id="is_nested_services">
                                                    @endif
                                                    <label for="inputName" class="control-label">Have nested
                                                        services</label>
                                                </div>


                                            </div>
                                            <br>
                                            <div class="row">
                                                <input type="hidden" class="form-control" name="service_id"
                                                    value="{{ $service->id }}">

                                                <div class="col">
                                                    <label for="inputName" class="control-label">Service type: </label>
                                                    <select name="service_type" id="service_type" class="form-control "
                                                        disabled>
                                                        @if ($service->service_type == 'Test')
                                                            <option value="Test" selected>Test</option>
                                                            <option value="Package">Package</option>
                                                        @else
                                                            <option value="Package" selected>Package</option>
                                                            <option value="Test">Test</option>
                                                        @endif
                                                    </select>
                                                </div>

                                                <div class="col" id="clinical_unit">
                                                    <label for="inputName" class="control-label">Clinical Units:
                                                        <b class="text-danger fas">*</b></label>
                                                    <select name="clinical_unit_id" id="clinical_unit_id"
                                                        class="form-control ">
                                                        @if ($service->clinical_unit_id == null)
                                                            <option value="" selected>
                                                                Multi Clinical unit</option>
                                                            @foreach ($clinical_units as $clinical_unit)
                                                                <option value="{{ $clinical_unit->id }}">
                                                                    {{ $clinical_unit->name_en }}</option>
                                                            @endforeach
                                                        @else
                                                            <option value="">
                                                                Multi Clinical unit</option>
                                                            @foreach ($clinical_units as $clinical_unit)
                                                                @if ($clinical_unit->id !== $service->clinical_unit_id)
                                                                    <option value="{{ $clinical_unit->id }}">
                                                                        {{ $clinical_unit->name_en }}</option>
                                                                @else
                                                                    <option value="{{ $clinical_unit->id }}" selected>
                                                                        {{ $clinical_unit->name_en }}</option>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <label for="inputName" class="control-label">Code: <b
                                                            class="text-danger fas">*</b></label>
                                                    <input type="text" class="form-control" id="inputName" name="code"
                                                        title="Please enter the service code" required
                                                        value="{{ $service->code }}"
                                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                                </div>
                                            </div>
                                            <br>
                                            {{-- 2 --}}
                                            <div class="row">
                                                <div class="col">
                                                    <label for="inputName" class="control-label">English Name: <b
                                                            class="text-danger fas">*</b></label>
                                                    <input type="text" class="form-control" id="inputName" name="name_en"
                                                        title="Please enter the service Name"
                                                        value="{{ $service->name_en }}" required>
                                                </div>

                                                <div class="col">
                                                    <label for="inputName" class="control-label">Arabic Name: </label>
                                                    <input type="text" class="form-control" id="inputName" name="name_ar"
                                                        title="Please enter the service name in arabic"
                                                        value="{{ $service->name_ar }}">
                                                </div>



                                                <div class="col">
                                                    <label for="inputName" class="control-label">Report name: <b
                                                            class="text-danger fas">*</b></label>
                                                    <input type="text" class="form-control" id="inputName"
                                                        name="report_name" title="Please enter the service report name"
                                                        value="{{ $service->report_name }}" required>
                                                </div>

                                                <div class="col">
                                                    <label for="inputName" class="control-label">Processing time in lab: (Minute) <b
                                                            class="text-danger fas">*</b></label>
                                                    <input type="text" class="form-control" id="processing_time"
                                                        name="processing_time" title="Please the service processing time in minute"
                                                        value="{{ $service->processing_time }}" required>
                                                </div>


                                            </div>
                                            <br>

                                            <div class="d-flex justify-content-center">
                                                <button type="submit" class="btn btn-primary">Save</button>&nbsp;&nbsp;
                                                <a href=" {{ url('services') }}"> <button type="button"
                                                        class="btn btn-danger" data-dismiss="modal">Cancel</button></a>
                                            </div>

                                        </form>
                                    </div>
                                    <div class="tab-pane" id="tab2">
                                        @if ($service->service_type == 'Package' || count($service_tests) == 0)

                                            @if ($service->is_nested_services == 0)
                                                <form action="{{ route('add_service_test') }}" method="post"
                                                    autocomplete="off">
                                                    @csrf
                                                    <input type="hidden" name="service_id" id="service_id"
                                                        value="{{ $service->id }}">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="col-lg-4 mg-b-20 mg-lg-b-0">

                                                                <p class="mg-b-10"> Select tests you want to add to the service <b class="text-danger fas">*</b></p>

                                                                <select class="form-control select2" multiple="multiple"
                                                                    name='tests_ids[]'
                                                                    title="Please select tests you want to add" required>

                                                                    @foreach ($tests as $test)
                                                                        <option value="{{ $test->id }}">
                                                                            {{ $test->code }} - {{ $test->name_en }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-header pb-0">
                                                        <button type="submit" class="modal-effect btn btn-sm btn-primary"
                                                            style="color:white"><i class="fas fa-plus"></i>&nbsp; Add
                                                            test to service</button>

                                                    </div>
                                                </form>
                                            @else
                                                <form action="{{ route('add_service_package') }}" method="post"
                                                    autocomplete="off">
                                                    @csrf
                                                    <input type="hidden" name="service_id" id="service_id"
                                                        value="{{ $service->id }}">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="col-lg-4 mg-b-20 mg-lg-b-0">

                                                                <p class="mg-b-10"> Select services you want to
                                                                    add to the
                                                                    package <b class="text-danger fas">*</b></p>

                                                                <select class="form-control select2" multiple="multiple"
                                                                    name='package_services_ids[]'
                                                                    title="Please select tests you want to add" required>

                                                                    @foreach ($other_services as $other_service)
                                                                        <option value="{{ $other_service->id }}">
                                                                            {{ $other_service->code }} -
                                                                            {{ $other_service->name_en }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-header pb-0">
                                                        <button type="submit" class="modal-effect btn btn-sm btn-primary"
                                                            style="color:white"><i class="fas fa-plus"></i>&nbsp; Add
                                                            test to package</button>

                                                    </div>
                                                </form>
                                            @endif

                                            <br>
                                            <div class="modal-footer">
                                            </div>

                                        @endif
                                        <div class="table-responsive">
                                            @if ($service->is_nested_services == 0)
                                                <table id="example1" class="table table-hover mb-0 text-md-nowrap"
                                                    data-page-length='50' style="text-align: center">
                                                    <thead>
                                                        <tr>
                                                            <th class="border-bottom-0">Code</th>
                                                            <th class="border-bottom-0">English Name</th>
                                                            <th class="border-bottom-0">Clinical unit</th>
                                                            <th class="border-bottom-0">Operations</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($service_tests as $service_test)
                                                            <tr>
                                                                <td>{{ $service_test->test->code }}</td>
                                                                <td>{{ $service_test->test->name_en }} </td>
                                                                <td>{{ $service_test->test->clinical_unit->name_en }}
                                                                </td>
                                                                <td>
                                                                    <a title="Delete test" href="#"
                                                                        data-service_id="{{ $service->id }}"
                                                                        data-test_id="{{ $service_test->test->id }}"
                                                                        data-toggle="modal"
                                                                        data-target="#delete_service_test"><i
                                                                            class="text-danger fas fa-trash-alt "></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @else
                                                <table id="example1" class="table table-hover mb-0 text-md-nowrap"
                                                    data-page-length='50' style="text-align: center">
                                                    <thead>
                                                        <tr>
                                                            <th class="border-bottom-0">Code</th>
                                                            <th class="border-bottom-0">Service Name</th>
                                                            <th class="border-bottom-0">Operations</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($current_nested_services as $nested_service)
                                                            <tr>
                                                                <td>{{ $nested_service->nested_service->code }}</td>
                                                                <td>{{ $nested_service->nested_service->name_en }} </td>
                                                                <td>
                                                                    <a title="Delete service" href="#"
                                                                        data-service_id="{{ $service->id }}"
                                                                        data-nested_service_id="{{ $nested_service->nested_service->id }}"
                                                                        data-toggle="modal"
                                                                        data-target="#delete_nested_service"><i
                                                                            class="text-danger fas fa-trash-alt "></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
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
    </div>


    <!-- حذف  -->
    <div class="modal fade" id="delete_service_test" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete service test</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <form action="{{ route('delete_service_test') }}" method="post" autocomplete="off">
                        @csrf
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this test from this service?
                    <input type="hidden" name="service_id" id="service_id" value="">
                    <input type="hidden" name="test_id" id="test_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Confirm</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    
 <!--delete_nested_service حذف  -->
 <div class="modal fade" id="delete_nested_service" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
 aria-hidden="true">
 <div class="modal-dialog" role="document">
     <div class="modal-content">
         <div class="modal-header">
             <h5 class="modal-title" id="exampleModalLabel">Delete service from package</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
             </button>
             <form action="{{ route('delete_nested_service') }}" method="post" autocomplete="off">
                 @csrf
         </div>
         <div class="modal-body">
             Are you sure you want to delete this service from this package?
             <input type="hidden" name="service_id" id="service_id" value="">
             <input type="hidden" name="nested_service_id" id="nested_service_id" value="">
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
        $('#add_service_test').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var service_id = button.data('service_id')
            var modal = $(this)
            modal.find('.modal-body #service_id').val(service_id);
        })
    </script>

    <!-- delete fill -->
    <script>
        $('#delete_service_test').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var test_id = button.data('test_id')
            var service_id = button.data('service_id')
            var modal = $(this)
            modal.find('.modal-body #service_id').val(service_id);
            modal.find('.modal-body #test_id').val(test_id);
        })
    </script>


<script>
    $('#delete_nested_service').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var nested_service_id = button.data('nested_service_id')
        var service_id = button.data('service_id')
        var modal = $(this)
        modal.find('.modal-body #service_id').val(service_id);
        modal.find('.modal-body #nested_service_id').val(nested_service_id);
    })
</script>


    <script>
        $('#clinical_unit_id').change(function() {
            if ($(this).val() == '') {
                $('select[name="service_type"]').val('Package');
            } else {
                $('select[name="service_type"]').val('Test');
            }
        })
    </script>

    <script>
        $('#is_nested_services').change(function() {
            var x = document.getElementById("is_nested_services").checked;
            if (x == true) {
                $('select[name="service_type"]').val('Package');
                $('select[name="clinical_unit_id"]').val('');
                document.getElementById("clinical_unit_id").disabled = true;
                document.getElementById("processing_time").disabled = true;
                // document.getElementById("Nested_Services").disabled = false;
                //  document.getElementById("Service_Test").disabled = true;

            } else {
                $('select[name="service_type"]').val('Test');
                document.getElementById("clinical_unit_id").disabled = false;
                document.getElementById("processing_time").disabled = false;

                //  document.getElementById("Nested_Services").disabled = true;
                //  document.getElementById("Service_Test").disabled = false;

            }
        })

        //when you load page make the effect 
        window.addEventListener("load", afterLoaded, false);

        function afterLoaded() {
            var x = document.getElementById("is_nested_services").checked;
            if (x == true) {
                $('select[name="service_type"]').val('Package');
                $('select[name="clinical_unit_id"]').val('');
                document.getElementById("clinical_unit_id").disabled = true;
                document.getElementById("processing_time").disabled = true;
                
                //document.getElementById("Service_Test").disabled = true;

            } else {
                $('select[name="service_type"]').val('Test');
                document.getElementById("clinical_unit_id").disabled = false;
                document.getElementById("processing_time").disabled = false;

                //   document.getElementById("Nested_Services").disabled = true;
                //  document.getElementById("Service_Test").disabled = false;
            }
        }
    </script>


@endsection
