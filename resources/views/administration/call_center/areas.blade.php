@extends('layouts.master')
@section('title')
Areas
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
                <h4 class="content-title mb-0 my-auto">Areas</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    Areas
                    List</span>
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
                <div class="card-header pb-0">
                    <a href="#" data-target="#add_area" data-toggle="modal"
                        class="modal-effect btn btn-sm btn-primary" style="color:white"><i class="fas fa-plus"></i>&nbsp;
                        Add Area</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'
                            style="text-align: center">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">Area Name (EN)</th>
                                    <th class="border-bottom-0">Home Service Price</th>
                                    <th class="border-bottom-0">Extra 1KM Price</th>
                                    <th class="border-bottom-0">Req. Zone Radius</th>
                                    <th class="border-bottom-0">Lab Location (lat,lng)</th>
                                    <th class="border-bottom-0">Operations</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($Areas as $area)
                                    @php
                                        $i++;
                                    @endphp
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $area->name_en }} </td>
                                        <td>{{ number_format($area->home_visit_fixed_price)}} </td>
                                        <td>{{number_format( $area->ex_km_price)}} </td>
                                        <td>{{ $area->zone_radius_km/1000}} KM </td>
                                        <td>({{ $area->zone_lat}},{{ $area->zone_lng}}) </td>
                                        <td>
                                            <a data-effect="effect-scale" href="#"
                                            data-area="{{ $area }}"
                                            data-toggle="modal" data-target="#edit_area"
                                            title="Edit Area"><i
                                                class="text-danger fas fa-edit"></i></a>

                                            &nbsp;&nbsp;
                                            <a title="Delete Area" href="#" data-toggle="modal"
                                                data-target="#delete_area"
                                                data-id="{{ $area->id }}"><i
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


    <!-- Add -->
    <div class="modal fade" id="add_area" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Area</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('add_Area') }}" method="post" enctype="multipart/form-data"
                        autocomplete="off">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Area name(EN)</label>
                            <input class="form-control" name="name_en" id="name_en" type="text" required>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Area name(AR)</label>
                            <input class="form-control" name="name_ar" id="name_ar" type="text" required>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">zone lat</label>
                            <input class="form-control" name="zone_lat" id="zone_lat" type="text" required>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">zone lng</label>
                            <input class="form-control" name="zone_lng" id="zone_lng" type="text" required>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">zone radius KM</label>
                            <input class="form-control" name="zone_radius_km" id="zone_radius_km" type="text" required>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Home visit initial price</label>
                            <input class="form-control" name="home_visit_fixed_price" id="home_visit_fixed_price" type="text" required>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Ex KM price</label>
                            <input class="form-control" name="ex_km_price" id="ex_km_price" type="text" required>
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
    <div class="modal fade" id="delete_area" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete area</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <form action="{{ route('delete_Area') }}" method="post">
                        
                        @csrf
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="id" id="id" value="">
                        <label for="recipient-name" class="col-form-label">Are you sure you want to delete this area?</label>
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
    <div class="modal fade" id="edit_area" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Area</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('update_Area') }}" method="post" autocomplete="off">
                <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" id="id" value="">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">English Name</label>
                            <input class="form-control" name="name_en" id="name_en" type="text" required>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Arabic Name</label>
                            <input class="form-control" name="name_ar" id="name_ar" type="text" required>
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">zone lat</label>
                            <input class="form-control" name="zone_lat" id="zone_lat" type="text" required>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">zone lng</label>
                            <input class="form-control" name="zone_lng" id="zone_lng" type="text" required>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">zone radius KM</label>
                            <input class="form-control" name="zone_radius_km" id="zone_radius_km" type="text" required>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Home visit initial price</label>
                            <input class="form-control" name="home_visit_fixed_price" id="home_visit_fixed_price" type="text" required>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Ex KM price</label>
                            <input class="form-control" name="ex_km_price" id="ex_km_price" type="text" required>
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
        $('#delete_area').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
        })
    </script>
    <!-- edit fill -->
    <script>
        $('#edit_area').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var area = button.data('area');
            var modal = $(this)
            modal.find('.modal-body #id').val(area['id']);
            modal.find('.modal-body #name_en').val(area['name_en']);
            modal.find('.modal-body #name_ar').val(area['name_ar']);
            modal.find('.modal-body #zone_lat').val(area['zone_lat']);
            modal.find('.modal-body #zone_lng').val(area['zone_lng']);
            modal.find('.modal-body #zone_radius_km').val(area['zone_radius_km']);
            modal.find('.modal-body #home_visit_fixed_price').val(area['home_visit_fixed_price']);
            modal.find('.modal-body #ex_km_price').val(area['ex_km_price']);
        })
    </script>








@endsection
