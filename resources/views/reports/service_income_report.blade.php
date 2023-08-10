@extends('layouts.master')
@section('css')
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
Service income
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Reports</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> /
                    Service income</span>
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

    @if (session()->has('Error'))
        <div class="alert alert-danger" >
            <strong>{{ session()->get('Error') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">Search Criteria
                        </h4>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('view_service_income_report') }}" method="post" enctype="multipart/form-data"
                    autocomplete="off" target="_blank">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <label  for="inputName" class="control-label">Reg. Date From: <b
                                    class="text-danger fas" >*</b></label>
                            <div class="input-group ">
                                <input class="form-control" format="YYYY-MM-DD" min="2022-01-01T08:30"
                                    type="datetime-local" name="dateFrom" required>
                            </div>
                        </div>
                        <div class="col">
                            <label for="inputName" class="control-label">Reg. Date To: <b
                                    class="text-danger fas">*</b></label>
                            <div class="input-group ">
                                <input class="form-control" format="YYYY-MM-DD" min="2022-01-01T08:30"
                                    type="datetime-local" name="dateTo" required>
                            </div>
                        </div>
                        <div class="col">
                            <label for="inputName" class="control-label">Reg. Branch:</label>
                            <select name="branch_id" class="form-control">
                                <option value="" selected>
                                    -- Select branch --
                                </option>
                                @foreach ($Branches as $branche)
                                    <option value="{{ $branche->id }}">
                                        {{ $branche->name_en }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col">
                            <label for="inputName" class="control-label">Services: </label>
                            <select name="services_ids[]" class="form-control select2" multiple> 
                                <option label="-- Select payer --" >
                                </option>
                                        @foreach($Services as $Service)
                                        <option value="{{ $Service->id }}">{{ $Service['name_en'] }}</option>
                                        @endforeach
                                    </select>        
                        </div>

                        <div class="col">
                            <label for="inputName" class="control-label">Payer: </label>
                            <select name="payer_id" class="form-control select2" > 
                                <option value="all" >all</option>
                                        @foreach($Payers as $payer)
                                        <option value="{{ $payer->id }}">{{ $payer['name_en'] }}</option>
                                        @endforeach
                                    </select>        
                        </div>
                        <div class="col">
                            <label for="inputName" class="control-label">Contract: </label>
                            <select name="contract_id" class="select form-control">
                                <option value="" selected>
                                    -- Select contract --
                                </option>
                               
                            </select>
                        </div>
                    </div>
                
                    <br>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">View Report</button>
                    </div>
                </form>
    
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
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
    <!--Internal  Datatable js -->
    <script src="{{URL::asset('assets/js/table-data.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('select[name="payer_id"]').on('change', function() {

                var payer_id = $(this).val();
                if (payer_id) {
                    $.ajax({
                        url: "{{ URL::to('get_payer_contract_list') }}/" + payer_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="contract_id"]').empty();
                            $('select[name="contract_id"]').append(
                                    '<option value="">-- Select contract --</option>');
                            $.each(data, function(key, value) {
                                $('select[name="contract_id"]').append(
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
