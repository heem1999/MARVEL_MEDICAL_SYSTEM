@extends('layouts.master')
@section('title')
Manage House Call Technicians
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
                <h4 class="content-title mb-0 my-auto">Manage House Call Technicians</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    House Call Technicians
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
                    <a href="#" data-target="#add_Technician" data-toggle="modal"
                        class="modal-effect btn btn-sm btn-primary" style="color:white"><i class="fas fa-plus"></i>&nbsp;
                        Add House Call Technician</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'
                            style="text-align: center">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">Active</th>
                                    <th class="border-bottom-0">Technician Name(EN)</th>
                                    <th class="border-bottom-0">Technician Name(AR)</th>
                                    <th class="border-bottom-0">Area</th>
                                    <th class="border-bottom-0">Operations</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($Technicians as $Technician)
                                    @php
                                        $i++;
                                    @endphp
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>
                                            @if ($Technician->status == 1)
                                            <span class="label text-success ">
                                                <div class="dot-label bg-success ml-1"> </div> 
                                            </span>
                                            @else
                                            <span class="label text-danger ">
                                                <div class="dot-label bg-danger ml-1"></div> 
                                            </span>
                                            @endif
                                        </td>
                                        <td>{{ $Technician->name_en }} </td>
                                        <td>{{ $Technician->name_ar }} </td>
                                        <td>{{ $Technician->area->name_en }} </td>
                                        <td>
                                            <a data-effect="effect-scale" href="#"
                                            data-technician="{{ $Technician }}"
                                            data-areas="{{ $Areas }}"
                                            data-toggle="modal" data-target="#edit_Technician"
                                            title="Edit Technician"><i
                                                class="text-danger fas fa-edit"></i></a>

                                            &nbsp;&nbsp;
                                            <a title="Delete Technician" href="#" data-toggle="modal"
                                                data-target="#delete_Technician"
                                                data-id="{{ $Technician->id }}"><i
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
    <div class="modal fade" id="add_Technician" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Technician</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('add_LabTechDriver') }}" method="post" enctype="multipart/form-data"
                autocomplete="off">
                {{ csrf_field() }}

                <div class="modal-body">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Technician name(EN)<b class="text-danger fas">*</b></label>
                            <input class="form-control" name="name_en" id="name_en" type="text" required>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Technician name(AR)<b class="text-danger fas">*</b></label>
                            <input class="form-control" name="name_ar" id="name_ar" type="text" required>
                        </div>
                       
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Technician Phone<b class="text-danger fas">*</b></label>
                                    <input class="form-control" name="phone" id="phone" type="text" required>
                                </div>
                            </div>
                            <div class="col">
                                <p class="mg-b-10"> Select Area: <b class="text-danger fas">*</b>
                                </p>
                                <select name="area_id" class="form-control"
                                    title="Please select Area of the Technician" required>
                                    @foreach ($Areas as $Area)
                                        <option value="{{ $Area->id }}">
                                            * {{ $Area->name_en }} - {{ $Area->name_ar }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                           
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">
                                <b class="text-danger fas">Technician defalt password is (borg).</b>
                            </label>
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
    <div class="modal fade" id="delete_Technician" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Technician
                        unit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <form action="{{ route('delete_LabTechDriver') }}" method="post">
                        
                        @csrf
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="id" id="id" value="">
                        <label for="recipient-name" class="col-form-label">Are you sure you want to delete this Technician?</label>
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
    <div class="modal fade" id="edit_Technician" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Technician</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('update_LabTechDriver') }}" method="post" autocomplete="off">
                <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" id="id" value="">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Technician name(EN)<b class="text-danger fas">*</b></label>
                                <input class="form-control" name="name_en" id="name_en" type="text" required>
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Technician name(AR)<b class="text-danger fas">*</b></label>
                                <input class="form-control" name="name_ar" id="name_ar" type="text" required>
                            </div>
                           
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Technician Phone<b class="text-danger fas">*</b></label>
                                        <input class="form-control" name="phone" id="phone" type="text" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <p class="mg-b-10"> Select Area: <b class="text-danger fas">*</b>
                                    </p>
                                    <select name="area_id" id="area_id" class="form-control "
                                        title="Please select Area of the Technician" required>
                                    </select>
                                </div>
                               
                            </div>
                          
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
        $('#delete_Technician').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
        })
    </script>
    <!-- edit fill -->
    <script>
        $('#edit_Technician').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var Technician = button.data('technician')
            var Areas = button.data('areas')
           console.log(Technician);
            var modal = $(this)
            modal.find('.modal-body #id').val(Technician['id']);
            modal.find('.modal-body #name_en').val(Technician['name_en']);
            modal.find('.modal-body #name_ar').val(Technician['name_ar']);
            modal.find('.modal-body #phone').val(Technician['phone']);


            $.each(Areas, function(key, value) {
                if (value.id !== Technician['area_id']) {
                    $('select[id="area_id"]').append(
                        '<option value="' + value.id + '">' + value.name_en + '</option>');
                } else {
                    $('select[id="area_id"]').append(
                        '<option selected value="' + value.id + '">' + value.name_en + '</option>');
                }
            });
            
        })
    </script>








@endsection
