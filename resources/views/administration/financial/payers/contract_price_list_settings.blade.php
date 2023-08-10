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
    <!--Internal  Datetimepicker-slider css -->
    <!-- Internal Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!--Internal  Datetimepicker-slider css -->
    <link href="{{ URL::asset('assets/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css') }}"
        rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.css') }}"
        rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/pickerjs/picker.min.css') }}" rel="stylesheet">
    <!-- Internal Spectrum-colorpicker css -->
    <link href="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.css') }}" rel="stylesheet">
@endsection
@section('title')
    Edit Payer
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Payers</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    Contract price list setting -<b> {{ $contract->name_en }} </b>-</span>
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
                                        <li><a href="#tab1" class="nav-link active" data-toggle="tab">Price List & Branches
                                                Configuration</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body tabs-menu-body main-content-body-right border">
                                <div class="tab-content">
                                    <!-- THIS CONTRACT HAS ALLREADY BRANCH -->
                                    @if (count($contract_price_list_settings) == 0)
                                        <div class="card-header pb-0">
                                            <a href="#" data-target="#add_price_list" data-toggle="modal"
                                                class="modal-effect btn btn-sm btn-primary" style="color:white"
                                                data-contract_id="{{ $contract->id }}" data-toggle="modal"><i
                                                    class="fas fa-plus"></i>&nbsp;
                                                Add price list</a>
                                        </div>
                                    @endif

                                    <br>
                                    <div class="tab-pane active" id="tab1">
                                        <div class="table-responsive">
                                            <table id="example1" class="table table-hover mb-0 text-md-nowrap"
                                                data-page-length='50' style="text-align: center">
                                                <thead>
                                                    <tr>

                                                        <th class="border-bottom-0">price list</th>
                                                        <th class="border-bottom-0">Branches name</th>
                                                        <th class="border-bottom-0">Operations</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($contract_price_list_settings as $cpls)
                                                        <tr>
                                                            <td>{{ $cpls->price_list->name_en }}</td>
                                                            <td>
                                                                @foreach ($Contract_branches as $Contract_branche)
                                                                    @if ($Contract_branche->contract_price_list_setting_id == $cpls->id)
                                                                        - {{ $Contract_branche->branch->name_en }}
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                <a title="Edit price list config." href="#"
                                                                    data-cpls="{{ $cpls }}"
                                                                    data-price_lists="{{ $price_lists }}"
                                                                    data-contract_branches="{{ $Contract_branches }}"
                                                                    data-all_branches="{{ $branches }}"
                                                                    data-toggle="modal"
                                                                    data-target="#edit_price_list_contract"><i
                                                                        class="text-danger fas fa-edit "></i>
                                                                </a>
                                                                &nbsp;&nbsp;
                                                                <a title="Delete price list config." href="#"
                                                                    data-cpls_id="{{ $cpls->id }}" data-toggle="modal"
                                                                    data-target="#delete_price_list_from_contract"><i
                                                                        class="text-danger fas fa-trash-alt "></i>
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
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>


    <!-- Add -->
    <div class="modal fade" id="add_price_list" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add price list to contract</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('add_price_list_to_contract') }}" method="post" autocomplete="off">
                    {{ csrf_field() }}
                    {{-- 1 --}}
                    <div class="modal-body">
                        <input type="hidden" name="contract_id" id="contract_id" value="{{ $contract->id }}">

                        <div class="row">
                            <div class="col">
                                <p class="mg-b-10"> Select branch: <b class="text-danger fas">*</b>
                                    (ctrl+click to select multiple branch)
                                </p>
                                <select name="branches_ids[]" class="form-control " multiple="multiple"
                                    title="Please select branch you want to add" required>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">
                                            * {{ $branch->name_en }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <p class="mg-b-10"> Select price list want to add to the
                                    contract <b class="text-danger fas">*</b></p>
                                <select class="form-control" name='price_list_id'
                                    title="Please select price list you want to add" required>
                                    @foreach ($price_lists as $price_list)
                                        <option value="{{ $price_list->id }}">
                                            {{ $price_list->code }} - {{ $price_list->name_en }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">Cash Ratio (0 to 1): <b
                                        class="text-danger fas">*</b></label>
                                <input type="text" class="form-control" id="cash_ratio" name="cash_ratio"
                                    title="Please enter the contract code" required onchange="calculate();"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            </div>
                            <div class="col">
                                <label for="inputName" class="control-label">Credit Ratio: <b
                                        class="text-danger fas">*</b></label>
                                <input value="1" readonly type="text" class="form-control" id="credit_ratio"
                                    name="credit_ratio" title="Please enter the contract code"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            </div>
                            <label for="inputName" class="control-label"><b class="text-danger fas" id="error">
                                </b>

                            </label>
                        </div>
                        <br>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Add</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- edit -->
    <div class="modal fade" id="edit_price_list_contract" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add price list to contract</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('edit_price_list_contract') }}" method="post" autocomplete="off">
                    {{ csrf_field() }}
                    {{-- 1 --}}
                    <div class="modal-body">
                        <input type="hidden" name="cpls_id" id="cpls_id" value="">

                        <div class="row">
                            <div class="col">
                                <p class="mg-b-10"> Select branch: <b class="text-danger fas">*</b>
                                    (ctrl+click to select multiple branch)
                                </p>
                                <select name="branches_ids[]" id='branches_ids' class="form-control " multiple="multiple"
                                    title="Please select branch you want to add" required>

                                </select>
                            </div>

                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <p class="mg-b-10"> Select price list want to add to the
                                    contract <b class="text-danger fas">*</b></p>
                                <select class="form-control" name='price_list_id' id='price_list_id'
                                    title="Please select price list you want to add">

                                </select>
                            </div>

                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">Cash Ratio (0 to 1): <b
                                        class="text-danger fas">*</b></label>
                                <input type="text" class="form-control" id="cash_ratio_e" name="cash_ratio"
                                    title="Please enter the contract code" required onchange="calculate2();"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            </div>
                            <div class="col">
                                <label for="inputName" class="control-label">Credit Ratio: <b
                                        class="text-danger fas">*</b></label>
                                <input readonly type="text" class="form-control" id="credit_ratio_e" name="credit_ratio"
                                    title="Please enter the contract code"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            </div>
                            <label for="inputName" class="control-label"><b class="text-danger fas" id="error_e">
                                </b>

                            </label>
                        </div>
                        <br>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Edit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- حذف  -->
    <div class="modal fade" id="delete_price_list_from_contract" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete price list config.</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('delete_price_list_from_contract') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        Are you sure you want to delete this price list config. from contract?
                        <input type="hidden" name="cpls_id" id="cpls_id" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Confirm</button>
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
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal Select2.min js -->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Ion.rangeSlider.min js -->
    <script src="{{ URL::asset('assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
    <!--Internal  jquery-simple-datetimepicker js -->
    <script src="{{ URL::asset('assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js') }}"></script>
    <!-- Ionicons js -->
    <script src="{{ URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js') }}"></script>
    <!--Internal  pickerjs js -->
    <script src="{{ URL::asset('assets/plugins/pickerjs/picker.min.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
    <!-- hide / show clinical_units -->
    <script>
        $('#edit_price_list_contract').on('show.bs.modal', function(event) {


            var button = $(event.relatedTarget)
            var cpls = button.data('cpls')

            var contract_branches = button.data('contract_branches')
            var price_lists = button.data('price_lists')
            var all_branches = button.data('all_branches')


            var modal = $(this)
            modal.find('.modal-body #cpls_id').val(cpls['id']);
            modal.find('.modal-body #cash_ratio_e').val(cpls['cash_ratio'] / 100);
            modal.find('.modal-body #credit_ratio_e').val(cpls['credit_ratio'] / 100);

            $('select[id="price_list_id"]').empty();

            $.each(price_lists, function(key, value) {
                if (value.id !== cpls['price_list']['id']) {
                    $('select[id="price_list_id"]').append(
                        '<option value="' + value.id + '">' + value.name_en + '</option>');
                } else {


                    $('select[id="price_list_id"]').append(
                        '<option selected value="' + value.id + '">' + value.name_en + '</option>');
                }
            });

            $('select[id="branches_ids"]').empty();
            /*  $.each(contract_branches, function(key, value) {
                    if (value.contract_price_list_setting_id !== cpls['id']) {

                        $('select[id="branches_ids"]').append(
                            '<option value="' + value.branch.id + '">' + value.branch.name_en + '</option>');
                    } else {
                        all_branches = all_branches.filter(city => city.id !== value.branch.id);

                        $('select[id="branches_ids"]').append(
                            '<option selected value="' + value.branch.id + '">' + value.branch.name_en +
                            '</option>');
                    }
                });
    */
            //append the rest branches
            $.each(all_branches, function(key, value) {
                $('select[id="branches_ids"]').append(
                    '<option value="' + value.id + '">' + value.name_en + '</option>');
            });

        })
    </script>

    <script>
        $('#delete_price_list_from_contract').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var cpls_id = button.data('cpls_id')
            var modal = $(this)
            modal.find('.modal-body #cpls_id').val(cpls_id);
        })
    </script>


    <script>
        document.getElementsByName("cash_ratio")[0].addEventListener('change', calculate);
        document.getElementsByName("cash_ratio_e")[0].addEventListener('change', calculate2);

        function calculate() {
            var cash_ratio = parseFloat(document.getElementById("cash_ratio").value);
            $("#error").empty();
            if (cash_ratio > 1) {
                document.getElementById("credit_ratio").value = 0;
                document.getElementById("error").append('Sorry, cash percentage should not be greater than 1.');
            } else if (cash_ratio < 0) {
                document.getElementById("credit_ratio").value = 0;
                document.getElementById("error").append('Sorry, cash percentage should not be less than 0.');
            } else {
                var sum = parseFloat(1 - cash_ratio).toFixed(1);;
                document.getElementById("credit_ratio").value = sum;
            }
        }

        function calculate2() {
            var cash_ratio = parseFloat(document.getElementById("cash_ratio_e").value);
            $("#error_e").empty();
            if (cash_ratio > 1) {
                document.getElementById("cash_ratio_e").value = 0;
                document.getElementById("error_e").append('Sorry, cash percentage should not be greater than 1.');
            } else if (cash_ratio < 0) {
                document.getElementById("cash_ratio_e").value = 0;
                document.getElementById("error_e").append('Sorry, cash percentage should not be less than 0.');
            } else {
                var sum = parseFloat(1 - cash_ratio).toFixed(1);;
                document.getElementById("credit_ratio_e").value = sum;
            }
        }
    </script>

@endsection
