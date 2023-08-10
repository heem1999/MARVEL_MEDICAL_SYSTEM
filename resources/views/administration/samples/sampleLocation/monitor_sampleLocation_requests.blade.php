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
                    Monitor Requests </span>
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


    <div class="row">
        <!--div-->
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-hover mb-0 text-md-nowrap" data-page-length='50'
                            style="text-align: center">
                            <thead>
                                <tr style="text-align: center">
                                    <th style="text-align: center">Active</th>
                                    <th style="text-align: center">name</th>
                                    <th style="text-align: center">previous status</th>
                                    <th style="text-align: center">current status</th>
                                    <th style="text-align: center">Location</th>
                                    <th class="border-bottom-0">MAC address</th>
                                    <th class="border-bottom-0">Request Date</th>
                                    <th class="border-bottom-0">Operations</th>
                                </tr>
                            </thead>
                            <tbody >
                                @foreach ($sample_location_requests as $sample_location_request)
                                    <tr>
                                        @if ($sample_location_request->request_status == 1)
                                            <td><i class="text-success fas fa-check-circle"></i></td>
                                        @else
                                            <td><i class="text-danger fas fa-minus-circle"></i></td>
                                        @endif
                                        <td>{{ $sample_location_request->user->name }} </td>
                                        <td>{{ $sample_location_request->previous_status }} </td>
                                        <td>{{ $sample_location_request->current_status }} </td>
                                        <td>{{ $sample_location_request->processing_unit->name_en }} </td>
                                        <td>
                                            @foreach ($Sample_location_mac_address->where('sampleLocReq_id', $sample_location_request->id) as $Sample_location_mac_addres)
                                                {{ $Sample_location_mac_addres->mac }} ,
                                            @endforeach
                                        </td>
                                        <td>{{ $sample_location_request->created_at }} </td>
                                        <td>
                                            @if ($sample_location_request->request_status == 1)
                                                <a title="Rejected" href="#" data-toggle="modal" data-target="#update_request"
                                                    data-sample_location_request_id="{{ $sample_location_request->id }}" data-rq_old_value="1">
                                                    <i class="text-danger fas fa-thumbs-down "></i>
                                                </a>
                                            @else
                                                <a title="Approved" href="#" data-toggle="modal" data-target="#update_request"
                                                    data-sample_location_request_id="{{ $sample_location_request->id }}"  data-rq_old_value="0">
                                                    <i class="text-success fas fa-thumbs-up "></i>
                                                </a>
                                            @endif

                                            &nbsp;&nbsp;
                                            <a title="Delete" href="#" data-toggle="modal" data-target="#delete_request"
                                                data-sample_location_request_id="{{ $sample_location_request->id }}"><i
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
        <!--/div-->
    </div>



    <!-- حذف  -->
    <div class="modal fade" id="delete_request" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete sample location request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <form action="{{ route('delete_sampleLocation_request') }}" method="post">
                        {{ csrf_field() }}
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this sample location request?
                    <input type="hidden" name="rq_id" id="rq_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Confirm</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- update_request  -->
    <div class="modal fade" id="update_request" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update sample request status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <form action="{{ route('update_sampleLocation_request_status') }}" method="post">
                        {{ csrf_field() }}
                </div>
                <div class="modal-body">
                    Are you sure you want to update this sample request status?
                    <input type="hidden" name="rq_id" id="rq_id" value="">
                    <input type="hidden" name="rq_old_value" id="rq_old_value" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Confirm</button>
                </div>
                </form>
            </div>
        </div>
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
        $('#delete_request').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var rq_id = button.data('sample_location_request_id')
            var modal = $(this)
            modal.find('.modal-body #rq_id').val(rq_id);
        })
    </script>
    <script>
        $('#update_request').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var rq_id = button.data('sample_location_request_id')
            var rq_old_value = button.data('rq_old_value')
            var modal = $(this)
            modal.find('.modal-body #rq_id').val(rq_id);
            modal.find('.modal-body #rq_old_value').val(rq_old_value);

        })
    </script>

@endsection
