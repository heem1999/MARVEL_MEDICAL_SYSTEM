@extends('layouts.master')
@section('title')
    Samples
@stop
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Samples</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    Receive Sample</span>
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

    <!-- row -->
    <div class="row">
        <!--div-->
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-body">

                    @if ($sample_location_requests)
                        <div class="row">
                            <div class="col">
                                <p class="mg-b-10"> Reg. Branch:
                                    <b>{{ $sample_location_branch->branch->name_en }}</b>
                                </p>

                            </div>
                            <div class="col">
                                <p class="mg-b-10"> Location: <b>
                                        {{ $sample_location_requests->processing_unit->name_en }}</b></p>

                            </div>
                            <div class="col">
                                <p class="mg-b-10"> Previous sample status:
                                    <b>{{ $sample_location_requests->previous_status }}</b>
                                </p>

                            </div>
                            <div class="col">
                                <p class="mg-b-10"> Current sample status:
                                    <b class="text-success fas">{{ $sample_location_requests->current_status }}</b>
                                </p>

                            </div>

                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <p class="mg-b-10"> MAC Address: <b class="text-success fas">
                                        {{ $Sample_location_mac_address['mac'] }}
                                    </b></p>

                            </div>
                        </div>

                        <hr>
                        <div class="row">

                            <div class="col">
                                <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                                    <label for="inputName" class="control-label">Sample ID: <b
                                            class="text-danger fas">*</b></label>
                                    <input type="text" class="form-control autofocus" name="Sample_barcode"
                                        id="Sample_barcode" autofocus>
                                    <input type="hidden" class="form-control autofocus" id="sample_location_id"
                                        value="{{ $sample_location_requests->id }}">
                                </div>
                            </div>
                        </div>
                        <br>

                        <div id="msg">
                        </div>
                        <br>
                        <div id="SampleDetails">
                            <div style="width: 100%; height: 20px; border-bottom: 1px solid black; text-align: center">
                                <span style="font-size: 15px; background-color: #F3F5F6; padding: 0 10px;">
                                    Patient Details
                                </span>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col">
                                    <label for="inputName" class="control-label">Patient Name:
                                    </label>
                                    <b id="patient_name"></b>
                                </div>

                                <div class="col">
                                    <label for="inputName" class="control-label">Gender:
                                    </label>
                                    <b id="gender"></b>
                                </div>

                                <div class="col">
                                    <label for="inputName" class="control-label">Acc No.:
                                    </label>
                                    <b id="acc"></b>
                                </div>
                                <div class="col">
                                    <label for="inputName" class="control-label">Registration Date:
                                    </label>
                                    <b id="registrationDate"></b>
                                </div>
                            </div>
                        </div>

                        <div id="SampleServices">
                            <br> <br>
                            <div style="width: 100%; height: 20px; border-bottom: 1px solid black; text-align: center">
                                <span style="font-size: 15px; background-color: #F3F5F6; padding: 0 10px;">
                                    Sample Services
                                </span>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col">
                                    <div id="Services">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="error text-danger" style="text-align: center">
                                <b>This PC is not authorized to access this page.</b>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
        <!--/div-->
    </div>


@endsection
@section('js')
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
        window.onload = function() {
            document.getElementById("Sample_barcode").focus();
            $('#SampleDetails').hide();
            $('#SampleServices').hide();
            $('#msg').hide();
        };

        document.addEventListener("DOMContentLoaded", function() {
            $('#SampleDetails').hide();
            $('#SampleServices').hide();
            $('#msg').hide();
        });

        var input = document.getElementById("Sample_barcode");
        var sample_location_id = document.getElementById("sample_location_id");
        input.addEventListener("keyup", function(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                get_Sample_barcode_data(input.value, sample_location_id.value);
                input.value = '';
            }
        });


        function get_Sample_barcode_data(Sample_barcode, sample_location_id) {
            if (Sample_barcode) {
                $.ajax({
                    url: "{{ URL::to('receive_Sample_barcode') }}/" + Sample_barcode + '/' + sample_location_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#SampleDetails').hide();
                        $('#SampleServices').hide();
                        $('#msg').empty();
                        $('#patient_name').empty();
                        $('#gender').empty();
                        $('#registrationDate').empty();
                        $('#acc').empty();
                        $('#Services').empty();

                        if (data.status == 1) {
                            $('#SampleDetails').show();
                            $('#SampleServices').show();
                            $('#msg').show();

                            $("#msg").addClass('bg-success');
                            $("#msg").append(
                                '<div class="alert alert-success c-msg" role="alert"><i class="fas fa-check"></i> ' +
                                data['msg'] + ' </div>'
                            );

                            $('#patient_name').append(
                                '<label for="inputName" class="control-label" >' + data['patient_name'] +
                                '</label>'
                            );
                            $('#gender').append(
                                '<label for="inputName" class="control-label" >' + data['gender'] +
                                '</label>'
                            );
                            $('#registrationDate').append(
                                '<label for="inputName" class="control-label" >' + data[
                                    'registrationDate'] + '</label>'
                            );
                            $('#acc').append(
                                '<label for="inputName" class="control-label" >' + data['acc'] + '</label>'
                            );
                            let xx = '';
                            $.each(data['samples_services'], function(key1,
                                samples_service) {
                                xx = '<b>' + samples_service + "</b> ," + xx;
                            });

                            $('#Services').append(
                                '<label for="inputName" class="control-label" >' + xx + '</label>'
                            );
                        } else {
                            $('#msg').show();
                            $('#msg').addClass('bg-danger');
                            $("#msg").append(
                                '<div class="alert alert-danger c-msg" role="alert"><i class="fas fa-times"></i> </i>' +
                                data['msg'] + '</div>'
                            );
                        }

                    },
                });
            }
        }
    </script>


@endsection
