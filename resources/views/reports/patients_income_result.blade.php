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
Patients Income
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Reports</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> /
                    Patients Income</span>
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
                                    <label  for="inputName" class="control-label">Service Count: [<b
                                        class="text-danger fas" >{{ $service_count_total }}</b>]</label>
                            </caption>
                            <thead>
                                <tr style="text-align: center">
                                    <th class="border-bottom-0">Patient No.</th>
                                    <th class="border-bottom-0">Patient Name</th>
                                    <th class="border-bottom-0">Reg. Date</th>
                                    <th class="border-bottom-0">Service Count</th>
                                    <th class="border-bottom-0">Total Req.</th>
                                    <th class="border-bottom-0">Cash</th>
                                    <th class="border-bottom-0">Credit</th>
                                    <th class="border-bottom-0">Discount</th>
                                    <th class="border-bottom-0">Paid</th>
                                    <th class="border-bottom-0">Remaining</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $patient_count = 0;
                                $total_Cash = 0;
                                $total_Credit = 0;
                                $total_count = 0;
                                $total_discount = 0;
                                $total_paid = 0;
                                $total_remaining = 0;
                                ?>

                                @foreach ($registration_details as $registration_detail)
                                <tr style="text-align: center">
                                    <td>{{ $registration_detail->patient->patient_no }}</td>
                                    <td>{{ date('Y-m-d', strtotime($registration_detail->created_at)) }}</td>
                                    <td>{{ $registration_detail->patient->patient_name }}</td>
                                    <td>{{ $registered_serv_prices->where('acc',$registration_detail->acc)->count() }}</td>
                                    <td>{{ number_format($registration_detail->total_Cash_Required + $registration_detail->total_Credit_Required, 2)	 }}</td>
                                    <td>{{ number_format($registration_detail->total_Cash_Required, 2) }}</td>
                                    <td>{{ number_format($registration_detail->total_Credit_Required, 2) }}</td>
                                    <td>{{ number_format($registration_detail->discount, 2) }}</td>
                                    <td>{{ number_format($registration_detail->paid, 2)  }}</td>
                                    <td>{{ number_format($registration_detail->remaining, 2)   }}</td>
                                    <?php 
                                $patient_count++;
                                $total_Cash = $total_Cash+$registration_detail->total_Cash_Required ;
                                $total_Credit = $total_Credit+ $registration_detail->total_Credit_Required;
                                $total_count = $total_count +$registration_detail->total_Cash_Required + $registration_detail->total_Credit_Required;
                                $total_discount = $total_discount+$registration_detail->discount;
                                $total_paid = $total_paid+$registration_detail->paid;
                                $total_remaining = $total_remaining+$registration_detail->remaining;
                                ?>
                                </tr>
                                @endforeach
                                <tr style="text-align: center">
                                    <td colspan="2"><b>Grand Total</b></td>
                                    <td><b>{{$patient_count }}</b></td>
                                    <td><b>{{ $service_count_total }}</b></td>
                                    <td><b>{{ number_format($total_count, 2)}}</b></td>
                                    <td><b>{{ number_format($total_Cash, 2) }}</b></td>
                                    <td><b>{{ number_format($total_Credit, 2) }}</b></td>
                                    <td><b>{{ number_format($total_discount, 2) }}</b></td>
                                    <td><b>{{ number_format($total_paid, 2)  }}</b></td>
                                    <td><b> {{ number_format($total_remaining, 2)   }} </b></td>
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
