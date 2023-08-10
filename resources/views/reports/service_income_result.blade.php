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
                        <h4 class="card-title mg-b-0">Search Results
                        </h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table key-buttons text-md-nowrap table-bordered" >
                            <caption style="caption-side: top;">
                                <label  for="inputName" class="control-label">Reg. Date From: [<b
                                    class="text-danger fas" >{{ $dateFrom }}</b>]</label> -
                                <label  for="inputName" class="control-label">Reg. Date To: [<b
                                    class="text-danger fas" >{{ $dateTo }}</b>]</label>
                                    
                                <label  for="inputName" class="control-label">Reg. Branch: [<b
                                    class="text-danger fas" >{{ $branch_name }}</b>]</label>
                                    &nbsp;&nbsp;
                                <label  for="inputName" class="control-label">Payer: [<b
                                    class="text-danger fas" >{{ $payer_name }}</b>]</label>
                                    &nbsp;&nbsp;
                                <label  for="inputName" class="control-label">Contract: [<b
                                    class="text-danger fas" >{{ $contract_name }}</b>]</label>
                                    &nbsp;&nbsp;
                                <label  for="inputName" class="control-label">Services: [<b
                                    class="text-danger fas" >
                                    @foreach ($services_names as $service_name)
                                    {{ $service_name }}, 
                                    @endforeach</b>]</label>                                       
                            </caption>
                            <thead>
                                <tr style="text-align: center">
                                    <th class="border-bottom-0">Service Code</th>
                                    <th class="border-bottom-0">Service Name</th>
                                    <th class="border-bottom-0">Service Count</th>
                                    <th class="border-bottom-0">Cash</th>
                                    <th class="border-bottom-0">Credit</th>
                                    <th class="border-bottom-0">Total</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $total_Cash = 0;
                                $total_Credit = 0;
                                $total_count = 0;
                                $service_count_total = 0;
                                ?>
                                @foreach ($rsp_collection as $rsp)
                                <tr style="text-align: center">
                                    <td>{{ $rsp->service->code }}</td>
                                    <td>{{ $rsp->service->name_en }}</td>
                                    <td>{{ $rsp->service_count }}</td>
                                    <td>{{ number_format($rsp->Cash, 2)}}</td>
                                    <td>{{ number_format($rsp->Credit , 2) }}</td>
                                    <td>{{ number_format($rsp->Credit + $rsp->Cash, 2)  }}</td>
                                </tr>
                                <?php 
                                $total_Cash = $total_Cash+$rsp->Cash;
                                $total_Credit = $total_Credit+$rsp->Credit;
                                $total_count = $total_count+ $rsp->Credit + $rsp->Cash;
                                $service_count_total= $service_count_total+$rsp->service_count;
                                ?>
                                @endforeach

                                <tr style="text-align: center">
                                    <td colspan="2"><b>Grand Total</b></td>
                                   
                                    <td><b>{{ $service_count_total }}</b></td>
                                    <td><b>{{ number_format($total_Cash, 2) }}</b></td>
                                    <td><b>{{ number_format($total_Credit, 2)  }}</b></td>
                                    <td><b> {{ number_format($total_count, 2)   }} </b></td>
                                </tr>

                            </tbody>
                        </table>
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
