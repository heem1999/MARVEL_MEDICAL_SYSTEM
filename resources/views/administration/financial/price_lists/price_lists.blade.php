@extends('layouts.master')
@section('title')
    Price lists
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
                <h4 class="content-title mb-0 my-auto">Price lists</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    Price Lists</span>
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
                    <a href="#" data-target="#add_price_list" data-toggle="modal"
                        class="modal-effect btn btn-sm btn-primary" style="color:white"><i class="fas fa-plus"></i>&nbsp;
                        Add price list</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-hover mb-0 text-md-nowrap" data-page-length='50'
                            style="text-align: center">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">price list</th>
                                    <th class="border-bottom-0">code</th>
                                    <th class="border-bottom-0">Operations</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($price_lists as $price_list)
                                    @php
                                        $i++;
                                    @endphp
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $price_list->name_en }} </td>
                                        <td>{{ $price_list->code }} </td>
                                        <td>
                                            <a data-effect="effect-scale"
                                                href=" {{ url('export_price_list') }}/{{ $price_list->id }}"
                                                title="Download price list"><i class=" fas fa-download"></i></a>
                                            &nbsp;&nbsp;

                                            <a data-effect="effect-scale" href="#"
                                                data-selected_price_list_data="{{ $price_list }}"
                                                data-price_lists_data="{{ $price_lists }}" data-toggle="modal"
                                                data-target="#copy_price_list" title="Copy price list"><i
                                                    class=" fas fa-copy"></i></a>
                                            &nbsp;&nbsp;

                                            <a data-effect="effect-scale" title="Edit price list"
                                                href=" {{ url('edit_price_lists') }}/{{ $price_list->id }}"><i
                                                    class="text-danger fas fa-edit"></i></a>
                                            &nbsp;&nbsp;
                                            <a title="Delete price list" href="#" data-toggle="modal"
                                                data-target="#delete_price_list"
                                                data-price_list_data="{{ $price_list }}"><i
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
    <div class="modal fade" id="add_price_list" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add price list</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('price_lists.store') }}" method="post" enctype="multipart/form-data"
                        autocomplete="off">
                        @csrf

                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Price list name <b
                                    class="text-danger fas">*</b></label>
                            <input class="form-control" name="name_en" id="name_en" type="text"
                                title="Pleas enter the price list name" required>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Code <b class="text-danger fas">*</b></label>
                            <input class="form-control" name="code" id="code" type="text"
                                title="Pleas enter the code name" required>
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
    <div class="modal fade" id="delete_price_list" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete price list</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <form action="{{ route('price_lists.destroy', 'test') }}" method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                </div>
                <div class="modal-body">
                    <div class="form-group">

                        <input type="hidden" name="price_list_data_id" id="price_list_data_id" value="">
                        <label for="recipient-name" class="col-form-label">Are you sure you want to delete this
                            price list?</label>
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



    <div class="modal fade" id="copy_price_list" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Copy price list</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('copy_price_list') }}" method="post" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="selected_price_list_id" id="selected_price_list_id" value="">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Copy services price list on <b
                                    name="selected_price_list_name" id="selected_price_list_name"> </b> to</label>
                        </div>

                        <div class="form-group">
                            <select required name="new_price_list" class="form-control ">
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
        $('#delete_price_list').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var price_list_data = button.data('price_list_data')
            var modal = $(this)
            modal.find('.modal-body #price_list_data_id').val(price_list_data['id']);
        })
    </script>

    <!--copy price_list -->
    <script>
        $('#copy_price_list').on('show.bs.modal', function(event) {

            var button = $(event.relatedTarget)
            var selected_price_list = button.data('selected_price_list_data')
            var price_lists_data = button.data('price_lists_data')
            var modal = $(this)
            modal.find('.modal-body #selected_price_list_id').val(selected_price_list['id']);
            modal.find('.modal-body #selected_price_list_name').text(selected_price_list['name_en']);

            $('select[name="new_price_list"]').empty();
            $.each(price_lists_data, function(key, value) {
                if (value.id !== selected_price_list['id']) { //do not add the selected price list
                    $('select[name="new_price_list"]').append(
                        '<option value="' + value.id + '">' + value.name_en + '</option>');
                }
            });


        })
    </script>

@endsection
