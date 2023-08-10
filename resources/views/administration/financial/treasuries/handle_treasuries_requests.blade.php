@extends('layouts.master')
@section('title')
    Treasuries
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
                <h4 class="content-title mb-0 my-auto">Treasuries</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    Handle Treasuries Requests </span>
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
                    <form action="" method="GET" enctype="multipart/form-data" autocomplete="off">
                        {{ csrf_field() }}
                        {{-- 1 --}}
                        <div class="row">

                            <div class="col">
                                <p class="mg-b-10"> Reg. Branch: <b class="text-danger fas">*</b></p>
                                <select class="form-control" name='branch_id' required>
                                    <option value="" selected disabled> --- Select Branch --- </option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">
                                            {{ $branch->code }} - {{ $branch->name_en }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <p class="mg-b-10"> Treasuries: <b class="text-danger fas">*</b></p>
                                <select class="form-control" name='treasury_id' required>
                                    <option value="" selected disabled> --- Select treasury --- </option>
                                </select>
                            </div>
                            <div class="col">
                                <br>
                                <div class="d-flex justify-content-center" style="">

                                    <a href="#" data-treasuries="{{ $treasuries }}" onclick="toggle()"
                                        data-target="#add_treasury" data-toggle="modal"
                                        class="modal-effect btn btn-sm btn-primary" style="color:white"><i
                                            class="fas fa-search"></i>&nbsp;
                                        Search</a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <br>


                </div>
            </div>
        </div>
        <!--/div-->
    </div>
    <!-- search result -->
    <div class="row">
        <!--div-->
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered mg-b-0 text-md-nowrap">
                            <thead>
                                <tr style="text-align: center">
                                    <th style="text-align: center">Active</th>
                                    <th style="text-align: center">Treasury name</th>
                                    <th style="text-align: center">Registration branch</th>
                                    <th class="border-bottom-0">MAC address</th>
                                    <th class="border-bottom-0">Operations</th>
                                </tr>
                            </thead>
                            <tbody class="requestDataTable" style="text-align: center">

                            </tbody>
                        </table>

                        <div class="error text-danger" style="text-align: center">
                            <b>No data found.</b>
                        </div>
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
                    <h5 class="modal-title" id="exampleModalLabel">Delete treasury</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <form action="{{ route('delete_treasury_request') }}" method="post">
                        {{ csrf_field() }}
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this treasury?
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
                    <h5 class="modal-title" id="exampleModalLabel">Update treasury status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <form action="{{ route('update_treasury_request') }}" method="post">
                        {{ csrf_field() }}
                </div>
                <div class="modal-body">
                    Are you sure you want to update this treasury status?
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
        $(document).ready(function() {
            $('select[name="branch_id"]').on('change', function() {

                var branch_id = $(this).val();
                if (branch_id) {
                    $.ajax({
                        url: "{{ URL::to('get_branch_treasuries') }}/" + branch_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="treasury_id"]').empty();

                            $.each(data, function(key, value) {
                                $('select[name="treasury_id"]').append(
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


    <script>
        window.onload = function(){
            $(".error").hide();
};

        function toggle() {
            $(".error").hide();
            $('.requestDataTable').empty();
            // var jobs = {!! json_encode($treasury_requests) !!}; 
            var branch_id = $('select[name="branch_id"]').val();
            var treasury_id = $('select[name="treasury_id"]').val();
            if (branch_id && treasury_id) {

                $.ajax({
                    url: "{{ URL::to('Search_treasuries_requests') }}/" + treasury_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        var x = '';
                        var request_status = '';
                        var ops_del = '';
                        var ops_up = '';
                        if (data) {
                            ops_del =
                                '&nbsp;&nbsp; <a title="Delete" href="#" data-rq_id="' + data.t_request.id +
                                '"data-toggle="modal" data-target="#delete_request"><i class="text-danger fas fa-trash-alt "></i></a>';
                            if (data.t_request.request_status == 1) {
                                request_status = '<td><i class="text-success fas fa-check-circle"></i></td>';
                                var ops_up =
                                    '<a title="Disapprove" href="#" data-rq_id="' + data.t_request.id +
                                    '" data-rq_old_value="' + data.t_request.request_status +
                                    '"data-toggle="modal" data-target="#update_request"><i class="text-danger fas fa-thumbs-down "></i></a>';
                            } else {
                                request_status = '<td><i class="text-danger fas fa-minus-circle"></i></td>';
                                var ops_up =
                                    '<a title="Approve" href="#" data-rq_id="' + data.t_request.id +
                                    '" data-rq_old_value="' + data.t_request.request_status +
                                    '"data-toggle="modal" data-target="#update_request"><i class="text-success fas fa-thumbs-up "></i></a>';
                            }
                            data.t_mac_address.forEach(element => {
                                x = x + ',' + element.mac_addres;
                            });
                            var newRow = '<tr> ' +
                                request_status +
                                '<td>' + data.Treasury.name_en + '</td>' +
                                '<td>' + data.treasury_branch.name_en + '</td>' +
                                '<td>' + x + '</td>' +
                                '<td>' + ops_up + ops_del + '</td></tr>';

                            $(".requestDataTable").append(newRow);
                        } else {
                            
                            $(".error").show();
                        }

                    },
                });
            }
        }
    </script>


    <script>
        $('#delete_request').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var rq_id = button.data('rq_id')
            var modal = $(this)
            modal.find('.modal-body #rq_id').val(rq_id);
        })
    </script>
    <script>
        $('#update_request').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var rq_id = button.data('rq_id')
            var rq_old_value = button.data('rq_old_value')


            var modal = $(this)
            modal.find('.modal-body #rq_id').val(rq_id);
            modal.find('.modal-body #rq_old_value').val(rq_old_value);

        })
    </script>

@endsection
