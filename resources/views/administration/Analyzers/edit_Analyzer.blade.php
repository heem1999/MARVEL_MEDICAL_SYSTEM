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
    Edit Analyzer
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Analyzers</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    Edit Analyzer -<b> {{ $Analyzer->name_en }} </b>- </span>
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
                                                data-toggle="tab">Analyzer Tests</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body tabs-menu-body main-content-body-right border">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">
                                        <form action="{{ url('Analyzers/update') }}" method="post" autocomplete="off">
                                            {{ method_field('patch') }}
                                            {{ csrf_field() }}
                                            {{-- 1 --}}
                                            <input type="hidden" class="form-control" name="analyzer_id"
                                                    value="{{ $Analyzer->id }}" required>

                                            <div class="row">
                                                <div class="col">
                                                    <label for="inputName" class="control-label">Analyzer Name: <b
                                                            class="text-danger fas">*</b></label>
                                                    <input type="text" class="form-control" id="inputName" name="name_en"
                                                        title="Please enter the Analyzer Name" value="{{ $Analyzer->name_en }}" required>
                                                </div>

                                                <div class="col">
                                                    <label for="inputName" class="control-label">Comm port: <b
                                                            class="text-danger fas">*</b></label>
                                                    <input type="text" class="form-control" id="inputName" name="comm_port"
                                                        title="Please enter the Comm port" required value="{{ $Analyzer->comm_port }}"
                                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                                </div>
                                                <div class="col">
                                                    <label for="inputName" class="control-label">LMS code: <b
                                                            class="text-danger fas">*</b></label>
                                                            <input type="text" class="form-control" id="inputName"
                                                            name="lms_code" title="Please enter the LMS code" value="{{ $Analyzer->lms_code }}"
                                                            required>
                                                </div>
                                            </div>

                                            <br>
                                            {{-- 2 --}}
                                            <div class="row">
                                            
                                                <div class="col">
                                                    <label for="inputName" class="control-label">Branch: <b
                                                            class="text-danger fas">*</b></label>
                                                    <select required name="branch_id" class="form-control ">
                                                        @foreach ($Branches as $Branche)
                                                        @if ($Analyzer->branch_id == $Branche->id)
                                                            <option value="{{ $Branche->id }}" selected>
                                                                {{ $Branche->name_en }}</option>
                                                                @else
                                                                <option value="{{ $Branche->id }}" >
                                                                    {{ $Branche->name_en }}</option>
                                                                @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <label for="inputName" class="control-label">Processing unit: <b
                                                            class="text-danger fas">*</b></label>
                                                    <select required id="processing_units_id" name="processing_units_id"
                                                        class="form-control">
                                                        @foreach ($processing_units as $processing_unit)
                                                        @if ($Analyzer->processing_units_id == $processing_unit->id)
                                                            <option value="{{ $processing_unit->id }}" selected>
                                                                {{ $processing_unit->name_en }}</option>
                                                                @else
                                                                <option value="{{ $processing_unit->id }}" >
                                                                    {{ $processing_unit->name_en }}</option>
                                                                @endif
                                                        @endforeach
                                                    </select>

                                                </div>

                                            </div>
                                            <br>
                                            <div class="row">
                                              
                                                <div class="col">
                                                    <label for="inputName" class="control-label">Test Status: <b
                                                            class="text-danger fas">*</b> (Test status after analyzer saves the result)</label>
                                                    <select required name="test_status" class="form-control ">
                                                        @foreach ($test_status as $test_status)
                                                            @if ($test_status !== $Analyzer->test_status)
                                                                <option value="{{ $test_status }}">
                                                                    {{ $test_status }}</option>
                                                            @else
                                                                <option value="{{ $test_status }}" selected>
                                                                    {{ $test_status }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                             
                                                <div class="col">
                                                    @if ($Analyzer->active)
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
                                                <a href=" {{ url('Analyzers') }}"> <button type="button"
                                                        class="btn btn-danger" data-dismiss="modal">Cancel</button></a>
                                            </div>

                                        </form>
                                    </div>
                                     
                                    <div class="tab-pane" id="tab2">
                                            <form action="{{ route('addAnalyzer_test')}}" method="post" autocomplete="off">
                                               
                                                {{ csrf_field() }}
                                                {{-- 1 --}}
                                                <input type="hidden" class="form-control" name="analyzer_id"
                                                        value="{{ $Analyzer->id }}" required>
    
                                                        
                                                <div class="row">
                                                    <div class="col">
                                                        <label for="inputName" class="control-label">Tests: <b
                                                                class="text-danger fas">*</b></label>
                                                        <select required name="test_id"  class="form-control select2">
                                                            <option value="" selected disabled>Select Test</option>
                                                            @foreach ($Tests as $Test)
                                                                <option value="{{ $Test->id }}">
                                                                    {{ $Test->code }} - {{ $Test->name_en }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                      
                                                    <div class="col">
                                                        <label for="inputName" class="control-label">Analyzer Test Code: <b
                                                                class="text-danger fas">*</b></label>
                                                        <input type="text" class="form-control" id="inputName" name="analyzer_test_code"
                                                            title="Please enter the Analyzer Test Code" required
                                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                                    </div>
                                                </div>
                                               
                                                <br>
                                                <div class="d-flex justify-content-center">
                                                    <button type="submit" class="btn btn-primary">Add Test</button>&nbsp;&nbsp;
                                                </div>
                                            </form>
                                            <br>
                                            <div class="table-responsive">
                                                <table id="example1" class="table table-hover mb-0 text-md-nowrap" data-page-length='50'
                                                style="text-align: center">
                                                    <thead>
                                                        <tr>
                                                            <th style="text-align: center">Test name</th>
                                                            <th style="text-align: center">Analyzer Test Code</th>
                                                            <th style="text-align: center">Operations</th>
                                                           
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($Analyzer_tests as $analyzer_test)
                                 
                                                        <tr style="text-align: center">
                                                            <td>{{ $analyzer_test->test->code }} - {{ $analyzer_test->test->name_en }} </td>
                                                            <td>{{ $analyzer_test->analyzer_test_code }} </td>
                                                            
                                                            <td>
                                                               
                                                                <a title="Delete test" href="#" data-analyzer_test_id="{{ $analyzer_test->id }}"
                                                                    data-toggle="modal" data-target="#delete_test"><i
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


   

<!-- حذف  -->
<div class="modal fade" id="delete_test" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete analyzer test</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <form action="{{ route('delete_Analyzer_test') }}" method="post">
              
                {{ csrf_field() }}
        </div>
        <div class="modal-body">
            Are you sure you want to delete this test from analyzer?
            <input type="hidden" name="analyzer_test_id" id="analyzer_test_id" value="">
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
    $('#delete_test').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var analyzer_test_id = button.data('analyzer_test_id')
        var modal = $(this)
        modal.find('.modal-body #analyzer_test_id').val(analyzer_test_id);
    })
</script>

 

<script>
    $(document).ready(function() {
        $('select[name="branch_id"]').on('change', function() {
            var branch_id = $(this).val();
            if (branch_id) {
                $.ajax({
                    url: "{{ URL::to('get_branch_Processing_units') }}/" + branch_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="processing_units_id"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="processing_units_id"]').append(
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
