@extends('layouts.master')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
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
    Edit Price list
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Edit Prices</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    Edit Edit Price -<b> {{ $price_list->name_en }} </b> - </span>
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

    <div class="row row-sm">
        <div class="col-xl-12">
            <!-- div -->
            <div class="card mg-b-20" id="tabs-style2">
                <div class="text-wrap">
                    <div class="example">
                        <div class="panel panel-primary tabs-style-2">
                            <div class=" tab-menu-heading">
                                <div class="tabs-menu1">
                                    <!-- Tabs -->
                                    <ul class="nav panel-tabs main-nav-line">
                                        <li><a href="#tab1" class="nav-link active" data-toggle="tab">Basic price list
                                                Data</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body tabs-menu-body main-content-body-right border">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">
                                        <form action="{{ url('price_lists/update') }}" method="post" autocomplete="off">
                                            {{ method_field('patch') }}
                                            {{ csrf_field() }}

                                            <div class="row">
                                                <input type="hidden" class="form-control" name="price_list_id"
                                                    value="{{ $price_list->id }}">
                                                <div class="col">
                                                    <label for="inputName" class="control-label">Price list name: <b
                                                            class="text-danger fas">*</b></label>
                                                    <input type="text" class="form-control" id="inputName" name="name_en"
                                                        title="Please enter the price list Name"
                                                        value="{{ $price_list->name_en }}" required>
                                                </div>


                                                <div class="col">
                                                    <label for="inputName" class="control-label">Code: <b
                                                            class="text-danger fas">*</b></label>
                                                    <input class="form-control" name="code" id="code" type="text"
                                                        title="Pleas enter the code name" value="{{ $price_list->code }}"
                                                        required>
                                                </div>

                                            </div>
                                            <br>

                                            <div class="d-flex justify-content-center">
                                                <button type="submit" class="btn btn-primary">Save</button>&nbsp;&nbsp;
                                                <a href=" {{ url('price_lists') }}"> <button type="button"
                                                        class="btn btn-danger" data-dismiss="modal">Cancel</button></a>
                                            </div>

                                        </form>
                                        <br>
                                        <div class="modal-footer">
                                        </div>
                                        <br>

                                        <div class="table-responsive">
                                            <p class="text-muted card-sub-title">
                                                You can download full list as Excel Sheet for editing
                                                <a data-effect="effect-scale"
                                                    href=" {{ url('export_price_list') }}/{{ $price_list->id }}"
                                                    title="Download price list"><i class=" fas fa-download"></i> Download
                                                    price list</a>

                                            </p>
                                            <table id="example1" class="table table-hover mb-0 text-md-nowrap"
                                                data-page-length='50' style="text-align: center">
                                                <thead>
                                                    <tr>
                                                        <th class="border-bottom-0">Active</th>
                                                        <th class="border-bottom-0">Service code</th>
                                                        <th class="border-bottom-0">Service name</th>
                                                        <th class="border-bottom-0">Clinical unit</th>
                                                        <th class="border-bottom-0">Current price</th>
                                                        <th class="border-bottom-0">Operations</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($price_list_services as $price_list_service)
                                                        @if ($price_list_service->service_id > 0)
                                                            <tr>
                                                                @if ($price_list_service->service->active == 1)
                                                                    <td><i class="text-success fas fa-check-circle"></i>
                                                                    </td>
                                                                @else
                                                                    <td><i class="text-danger fas fa-minus-circle"></i></td>
                                                                @endif
                                                                <td>{{ $price_list_service->service->code }}</td>
                                                                <td>{{ $price_list_service->service->name_en }} </td>
                                                                <td>
                                                                    @if ($price_list_service->service->clinical_unit_id !== 0)
                                                                        {{ $price_list_service->service->clinical_unit->name_en }}
                                                                    @else
                                                                        Multi Clinical unit
                                                                    @endif
                                                                </td>
                                                                <td>{{ $price_list_service->current_price }}</td>
                                                                <td>
                                                                    <a title="edit service price" href="#"
                                                                        data-service_id="{{ $price_list_service->service_id }}"
                                                                        data-service_name="{{ $price_list_service->service->name_en }}"
                                                                        data-price_list_id="{{ $price_list->id }}"
                                                                        data-current_price="{{ $price_list_service->current_price }}"
                                                                        data-toggle="modal"
                                                                        data-target="#edit_service_price"><i
                                                                            class="text-danger fas fa-edit "></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @elseif ($price_list_service->ex_code !== '-')
                                                            @foreach ($extra_services_all->where('ex_code', $price_list_service->ex_code) as $extra_services_all1)
                                                                <tr>
                                                                    @if ($extra_services_all1->active == 1)
                                                                        <td><i class="text-success fas fa-check-circle"></i>
                                                                        </td>
                                                                    @else
                                                                        <td><i class="text-danger fas fa-minus-circle"></i>
                                                                        </td>
                                                                    @endif
                                                                    <td>-</td>
                                                                    <td>{{ $extra_services_all1->name_en }}
                                                                    </td>
                                                                    <td>{{ $extra_services_all1->service_type }} </td>
                                                                    <td>{{ $price_list_service->current_price }}</td>
                                                                    <td>
                                                                        <a title="edit service price" href="#"
                                                                            data-extra_service_ex_code="{{ $extra_services_all1->ex_code }}"
                                                                            data-extra_service_name="{{ $extra_services_all1->name_en }}"
                                                                            data-price_list_id="{{ $price_list->id }}"
                                                                            data-current_price="{{ $price_list_service->current_price }}"
                                                                            data-toggle="modal"
                                                                            data-target="#edit_extra_service_price"><i
                                                                                class="text-danger fas fa-edit "></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    @endforeach

                                                    @foreach ($services as $service)
                                                        <tr>
                                                            @if ($service->active == 1)
                                                                <td><i class="text-success fas fa-check-circle"></i></td>
                                                            @else
                                                                <td><i class="text-danger fas fa-minus-circle"></i></td>
                                                            @endif
                                                            <td>{{ $service->code }}</td>
                                                            <td>{{ $service->name_en }} </td>
                                                            <td>
                                                                @if ($service->clinical_unit_id !== 0)
                                                                    {{ $service->clinical_unit->name_en }}
                                                                @else
                                                                    Multi Clinical unit
                                                                @endif
                                                            </td>
                                                            <td>0</td>
                                                            <td>
                                                                <a title="edit service price" href="#"
                                                                    data-service_id="{{ $service->id }}"
                                                                    data-service_name="{{ $service->name_en }}"
                                                                    data-price_list_id="{{ $price_list->id }}"
                                                                    data-current_price="0" data-toggle="modal"
                                                                    data-target="#edit_service_price"><i
                                                                        class="text-danger fas fa-edit "></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                    @foreach ($extra_services as $extra_service)
                                                        <tr>
                                                            @if ($extra_service->active == 1)
                                                                <td><i class="text-success fas fa-check-circle"></i></td>
                                                            @else
                                                                <td><i class="text-danger fas fa-minus-circle"></i></td>
                                                            @endif
                                                            <td>-</td>
                                                            <td>{{ $extra_service->name_en }} </td>
                                                            <td>{{ $extra_service->service_type }} </td>
                                                            <td>0</td>
                                                            <td>
                                                                <a title="edit service price" href="#"
                                                                    data-extra_service_ex_code="{{ $extra_service->ex_code }}"
                                                                    data-extra_service_name="{{ $extra_service->name_en }}"
                                                                    data-price_list_id="{{ $price_list->id }}"
                                                                    data-current_price="0" data-toggle="modal"
                                                                    data-target="#edit_extra_service_price"><i
                                                                        class="text-danger fas fa-edit "></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>

                                        <br>
                                        <div class="modal-footer">
                                        </div>
                                        <br>

                                        <div class="row">
                                            <div class="col-lg-12 col-md-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <form action="{{ route('import_price_list') }}" method="post"
                                                            enctype="multipart/form-data" autocomplete="off">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="col">
                                                                        <h6 class="card-title mb-1">Upload Price list File
                                                                        </h6>
                                                                    </div>
                                                                    <input type="hidden" name="price_list_id"
                                                                        value="{{ $price_list->id }}">
                                                                    <input type="file" class="dropify"
                                                                        data-height="100" name="price_list_file" required />
                                                                    <br>
                                                                    <div class="d-flex justify-content-center">
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Upload</button>&nbsp;&nbsp;
                                                                        <a href=" {{ url('price_lists') }}"> <button
                                                                                type="button" class="btn btn-danger"
                                                                                data-dismiss="modal">Cancel</button></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- edit -->
    <div class="modal fade" id="edit_service_price" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update service price</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="{{ route('edit_service_price') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" name="service_id" id="service_id" value="">
                            <input type="hidden" name="price_list_id" id="price_list_id" value="">

                            <label for="recipient-name" class="col-form-label">Service name: </label>
                            <input class="form-control" name="service_name" id="service_name" type="text" disabled>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Current price: </label>
                            <input class="form-control" name="current_price" id="current_price" type="text" disabled>
                            <label for="recipient-name" class="col-form-label">New price: </label>
                            <input class="form-control" name="new_price" id="new_price" type="text"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>



    <div class="modal fade" id="edit_extra_service_price" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update service price</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="{{ route('edit_extra_service_price') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" name="extra_service_ex_code" id="extra_service_ex_code" value="">
                            <input type="hidden" name="price_list_id" id="price_list_id" value="">

                            <label for="recipient-name" class="col-form-label">Service name: </label>
                            <input class="form-control" name="extra_service_name" id="extra_service_name" type="text"
                                disabled>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Current price: </label>
                            <input class="form-control" name="current_price" id="current_price" type="text" disabled>
                            <label for="recipient-name" class="col-form-label">New price: </label>
                            <input class="form-control" name="new_price" id="new_price" type="text"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                </form>
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
        $('#edit_service_price').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var price_list_id = button.data('price_list_id')
            var service_id = button.data('service_id')
            var current_price = button.data('current_price')
            var service_name = button.data('service_name')

            var modal = $(this)
            modal.find('.modal-body #service_id').val(service_id);
            modal.find('.modal-body #price_list_id').val(price_list_id);
            modal.find('.modal-body #current_price').val(current_price);
            modal.find('.modal-body #service_name').val(service_name);
        })
    </script>



    <script>
        $('#edit_extra_service_price').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var price_list_id = button.data('price_list_id')
            var extra_service_ex_code = button.data('extra_service_ex_code')
            var current_price = button.data('current_price')
            var extra_service_name = button.data('extra_service_name')

            var modal = $(this)
            modal.find('.modal-body #extra_service_ex_code').val(extra_service_ex_code);
            modal.find('.modal-body #price_list_id').val(price_list_id);
            modal.find('.modal-body #current_price').val(current_price);
            modal.find('.modal-body #extra_service_name').val(extra_service_name);
        })
    </script>

@endsection
