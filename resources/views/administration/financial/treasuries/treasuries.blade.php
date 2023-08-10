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
                    Treasuries Lists</span>
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
                    <a href="#" data-target="#add_treasury" data-toggle="modal" class="modal-effect btn btn-sm btn-primary"
                        style="color:white"><i class="fas fa-plus"></i>&nbsp;
                        Add Treasury</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-hover mb-0 text-md-nowrap" data-page-length='50'
                            style="text-align: center">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">Active</th>
                                    <th class="border-bottom-0">Treasury name</th>
                                    <th class="border-bottom-0">Registration branch</th>
                                    <th class="border-bottom-0">Operations</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($treasuries as $treasury)
                                    <tr>
                                        @if ($treasury->active == 1)
                                            <td><i class="text-success fas fa-check-circle"></i></td>
                                        @else
                                            <td><i class="text-danger fas fa-minus-circle"></i></td>
                                        @endif
                                        <td>{{ $treasury->name_en }} </td>
                                        <td>{{ $treasury->branch->name_en }} </td>
                                        <td>
                                            <a title="Edit" href="#" data-toggle="modal" data-target="#edit_treasury"
                                                data-branch_id="{{ $treasury->branch->id }}"
                                                data-active="{{ $treasury->active }}"
                                                data-treasury_id="{{ $treasury->id }}"
                                                data-branches="{{ $branches }}"
                                                data-treasury_name_en="{{ $treasury->name_en }}"><i
                                                    class="text-danger fas fa-edit "></i>&nbsp;&nbsp;
                                            </a>
                                            &nbsp;&nbsp;
                                            <a title="Delete" href="#" data-toggle="modal" data-target="#delete_treasury"
                                                data-treasury_id="{{ $treasury->id }}"><i
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
    <div class="modal fade" id="add_treasury" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add price list</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('treasuries.store') }}" method="post" enctype="multipart/form-data"
                    autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <input type="checkbox" name="isActive" checked>
                        <label for="inputName" class="control-label">Active</label>
                        <br>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Treasury name: <b
                                    class="text-danger fas">*</b></label>
                            <input class="form-control" name="name_en" type="text" required>
                        </div>
                        <div class="form-group">
                            <p class="mg-b-10"> Reg. Branch: <b class="text-danger fas">*</b></p>
                            <select class="form-control" name='branch_id' required>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">
                                        {{ $branch->code }} - {{ $branch->name_en }}
                                    </option>
                                @endforeach
                            </select>
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
    <div class="modal fade" id="delete_treasury" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete treasury</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('treasuries.destroy', 'test') }}" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="treasury_id" id="treasury_id" value="">
                            <label for="recipient-name" class="col-form-label">Are you sure you want to delete this
                                treasury?</label>
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

    <!-- EDIT -->
    <div class="modal fade" id="edit_treasury" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add price list</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('treasuries/update') }}" method="post" autocomplete="off">
                    {{ method_field('patch') }}
                    {{ csrf_field() }}
                   

                    <div class="modal-body">
                        <input type="hidden" name="treasury_id" id="treasury_id" value="">

                        <input type="checkbox" name="isActive" id="isActive" checked>
                        <label for="inputName" class="control-label">Active</label>
                        <br>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Treasury name: <b
                                    class="text-danger fas">*</b></label>
                            <input class="form-control" name="name_en" id="name_en" type="text" required>
                        </div>
                        <div class="form-group">
                            <p class="mg-b-10"> Reg. Branch: <b class="text-danger fas">*</b></p>
                            <select class="form-control" name='branch_id' id='branch_id'>
                            </select>
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
        $('#delete_treasury').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var treasury_id = button.data('treasury_id')

            var modal = $(this)
            modal.find('.modal-body #treasury_id').val(treasury_id);
        });
    </script>

    <script>
        $('#edit_treasury').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var treasury_id = button.data('treasury_id')
            var branch_id = button.data('branch_id')
            var branches = button.data('branches')
            var treasury_name_en = button.data('treasury_name_en')
            var active = button.data('active')

            var modal = $(this)
            modal.find('.modal-body #treasury_id').val(treasury_id);
            modal.find('.modal-body #name_en').val(treasury_name_en);

            var checkBox = document.getElementById("isActive");
            if (active == 0) {
                checkBox.checked = false;
            } else {
                checkBox.checked = true;
            }

            $('select[id="branch_id"]').empty();
            $.each(branches, function(key, value) {
                if (value.id !== branch_id) {
                    $('select[id="branch_id"]').append(
                        '<option value="' + value.id + '">' + value.name_en + '</option>');
                } else {
                    $('select[id="branch_id"]').append(
                        '<option selected value="' + value.id + '">' + value.name_en + '</option>');
                }
            });
        });
    </script>



@endsection
