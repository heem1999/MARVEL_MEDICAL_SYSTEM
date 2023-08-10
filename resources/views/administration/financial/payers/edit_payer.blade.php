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
                    Edit Payer -<b> {{ $payer->name_en }} </b>-</span>
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
                                        <li><a href="#tab1" class="nav-link active" data-toggle="tab">Payer Basic Data</a>
                                        </li>
                                        <li><a href="#tab2" class="nav-link" data-toggle="tab">Payer Contracts</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body tabs-menu-body main-content-body-right border">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">
                                        <form action="{{ url('payers/update') }}" method="post" autocomplete="off">
                                            {{ method_field('patch') }}
                                            {{ csrf_field() }}
                                            {{-- 1 --}}
                                            <input type="hidden" name="payer_id" id="payer_id" value="{{ $payer->id }}">

                                            <div class="row">

                                                <div class="col">
                                                    @if ($payer->active)
                                                        <input type="checkbox" name="isActive" checked>
                                                    @else
                                                        <input type="checkbox" name="isActive">
                                                    @endif
                                                    <label for="inputName" class="control-label">Active</label>
                                                    <br>
                                                    @if ($payer->is_insurance_ID_required)
                                                        <input type="checkbox" name="is_insurance_ID_required" checked>
                                                    @else
                                                        <input type="checkbox" name="is_insurance_ID_required">
                                                    @endif
                                                    <label for="inputName" class="control-label">Is insurance ID
                                                        required</label>
                                                    <br>
                                                    <label for="inputName" class="control-label">Currency: </label>
                                                    <select name="currency_id" class="form-control ">
                                                        <option value="{{ $payer->currency->id }}" selected>
                                                            {{ $payer->currency->code }} -
                                                            {{ $payer->currency->name_en }}
                                                        </option>
                                                        @foreach ($currencies as $currency)
                                                            @if ($currency->id !== $payer->currency->id)
                                                                <option value="{{ $currency->id }}">
                                                                    {{ $currency->code }} - {{ $currency->name_en }}
                                                                </option>
                                                            @endif

                                                        @endforeach

                                                    </select>
                                                </div>

                                                <div class="col">
                                                    <label for="inputName" class="control-label">Print Type: <b
                                                            class="text-danger fas">*</b></label>
                                                    <ul style="list-style: none">
                                                        <li>
                                                            @if ($payer->print_money_receipt)
                                                                <input type="checkbox" name="print_money_receipt" checked>
                                                            @else
                                                                <input type="checkbox" name="print_money_receipt">
                                                            @endif
                                                            Money Receipt
                                                        </li>
                                                        <li>
                                                            @if ($payer->print_result_receipt)
                                                                <input type="checkbox" name="print_result_receipt" checked>
                                                            @else
                                                                <input type="checkbox" name="print_result_receipt">
                                                            @endif Result
                                                            Receipt
                                                        </li>
                                                        <li>
                                                            @if ($payer->print_invoice)
                                                                <input type="checkbox" name="print_invoice" checked>
                                                            @else
                                                                <input type="checkbox" name="print_invoice">
                                                            @endif Invoice
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="col">
                                                    <label for="inputName" class="control-label">Apply Date <b
                                                            class="text-danger fas">*</b></label>
                                                    <div class="input-group ">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i
                                                                    class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                                            </div>
                                                        </div><input required class="form-control fc-datepicker"
                                                            placeholder="MM/DD/YYYY" type="text" name="apply_date"
                                                            value="{{ $payer->apply_date }}">
                                                    </div>
                                                </div>
                                                <div class="col">

                                                    <label for="inputName" class="control-label">Expiry Date</label>
                                                    <div class="input-group ">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i
                                                                    class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                                            </div>
                                                        </div><input class="form-control fc-datepicker"
                                                            placeholder="MM/DD/YYYY" type="text" name="expiry_date"
                                                            value="{{ $payer->expiry_date }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            {{-- 2 --}}
                                            <div class="row">
                                                <div class="col">
                                                    <label for="inputName" class="control-label">Name (EN): <b
                                                            class="text-danger fas">*</b></label>
                                                    <input type="text" class="form-control" id="inputName" name="name_en"
                                                        title="Please enter the payer Name" value="{{ $payer->name_en }}"
                                                        required>
                                                </div>
                                                <div class="col">
                                                    <label for="inputName" class="control-label">Name (AR): <b
                                                            class="text-danger fas">*</b></label>
                                                    <input type="text" class="form-control" id="inputName" name="name_ar"
                                                        title="Please enter the payer Name" value="{{ $payer->name_ar }}"
                                                        required>
                                                </div>
                                                <div class="col">
                                                    <label for="inputName" class="control-label">Code: <b
                                                            class="text-danger fas">*</b></label>
                                                    <input type="text" class="form-control" id="inputName" name="code"
                                                        title="Please enter the payer code" required
                                                        value="{{ $payer->code }}"
                                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                                </div>
                                                <div class="col">
                                                    <label for="inputName" class="control-label">Credit Limit: </label>
                                                    <input type="text" class="form-control" id="inputName"
                                                        name="credit_limit" value="{{ $payer->credit_limit }}"
                                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">

                                                </div>
                                            </div>
                                            {{-- 3 --}}
                                            <br>
                                            <div class="row">
                                                <div class="col">
                                                    <label for="inputName" class="control-label">Phone:</label>
                                                    <input type="text" class="form-control" id="inputName" name="phone"
                                                        value="{{ $payer->phone }}">
                                                </div>
                                                <div class="col">
                                                    <label for="inputName" class="control-label">Email:</label>
                                                    <input type="text" class="form-control" id="inputName" name="email"
                                                        value="{{ $payer->email }}">
                                                </div>
                                                <div class="col">

                                                    <label for="inputName" class="control-label">Web result
                                                        password:</label>
                                                    <input type="text" class="form-control" id="inputName"
                                                        name="web_result_password"
                                                        value="{{ $payer->web_result_password }}">

                                                </div>
                                                <div class="col">
                                                    <label for="inputName" class="control-label">Send Mail To:</label>
                                                    <ul style="list-style: none">
                                                        <li>
                                                            @if ($payer->is_insurance_ID_required)
                                                                <input type="checkbox" name="patient_email_is_required"
                                                                    checked>
                                                            @else
                                                                <input type="checkbox" name="patient_email_is_required">
                                                            @endif Patient
                                                            Mail Required
                                                        </li>
                                                        <li>
                                                            @if ($payer->is_insurance_ID_required)
                                                                <input type="checkbox" name="send_result_to_payer" checked>
                                                            @else
                                                                <input type="checkbox" name="send_result_to_payer">
                                                            @endif Payer
                                                        </li>
                                                        <li>
                                                            @if ($payer->is_insurance_ID_required)
                                                                <input type="checkbox" name="send_result_to_patient"
                                                                    checked>
                                                            @else
                                                                <input type="checkbox" name="send_result_to_patient">
                                                            @endif Patient
                                                        </li>
                                                    </ul>


                                                </div>


                                            </div>
                                            <br>
                                            <br>
                                            <div class="d-flex justify-content-center">
                                                <button type="submit" class="btn btn-primary">Save</button>&nbsp;&nbsp;
                                                <a href=" {{ url('payers') }}"> <button type="button"
                                                        class="btn btn-danger" data-dismiss="modal">Cancel</button></a>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane" id="tab2">
                                        <div class="card-header pb-0">
                                            <a href="#" data-target="#add_contract" data-toggle="modal"
                                                class="modal-effect btn btn-sm btn-primary" style="color:white"
                                                data-payer_id="{{ $payer->id }}" data-toggle="modal"><i
                                                    class="fas fa-plus"></i>&nbsp;
                                                Add contract</a>
                                        </div>
                                        <br>
                                        <div class="table-responsive">
                                            <table id="example1" class="table table-hover mb-0 text-md-nowrap"
                                                data-page-length='50' style="text-align: center">
                                                <thead>
                                                    <tr>
                                                        <th class="border-bottom-0">Active</th>
                                                        <th class="border-bottom-0">Code</th>
                                                        <th class="border-bottom-0">Contract Name</th>
                                                        <th class="border-bottom-0">classification</th>
                                                        <th class="border-bottom-0">Price list & Branches</th>
                                                        <th class="border-bottom-0">Operations</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($payer_contracts as $payer_contract)
                                                        <tr>
                                                            @if ($payer_contract->active == 1)
                                                                <td><i class="text-success fas fa-check-circle"></i></td>
                                                            @else
                                                                <td><i class="text-danger fas fa-minus-circle"></i></td>
                                                            @endif
                                                            <td>{{ $payer_contract->code }}</td>
                                                            <td>{{ $payer_contract->name_en }}</td>
                                                            <td>{{ $payer_contract->classification->name_en }}
                                                                
                                                            <td> <a href=" {{ url('/' . ($page = 'contract_price_list_settings')) }}/{{ $payer_contract->id }}" target="_blank"> <i
                                                                class="fas fa-hand-holding-usd "></i></a></td>
                                                            </td>
                                                            <td>
                                                                <a title="Edit contract" href="#"
                                                                    data-contract_data="{{ $payer_contract }}"
                                                                    data-contract_classifications="{{ $contract_classifications }}"
                                                                    data-toggle="modal" data-target="#edit_contract"><i
                                                                        class="text-danger fas fa-edit "></i>&nbsp;&nbsp;
                                                                </a>
                                                                &nbsp;&nbsp;
                                                                <a title="Delete contract" href="#"
                                                                    data-contract_id="{{ $payer_contract->id }}"
                                                                    data-toggle="modal" data-target="#delete_contract"><i
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
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>


    <!-- Add -->
    <div class="modal fade" id="add_contract" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add payer contract</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('add_payer_contract') }}" method="post" autocomplete="off">
                    {{ csrf_field() }}
                    {{-- 1 --}}
                    <div class="modal-body">
                        <input type="hidden" name="payer_id" id="payer_id" value="{{ $payer->id }}">
                        <div class="row">
                            <div class="col">
                                <input type="checkbox" name="isActive" checked>
                                <label for="inputName" class="control-label">Active</label>
                            </div>

                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">Name (EN): <b
                                        class="text-danger fas">*</b></label>
                                <input type="text" class="form-control" id="inputName" name="name_en"
                                    title="Please enter the contract Name" required>
                            </div>
                            <div class="col">
                                <label for="inputName" class="control-label">Name (AR): <b
                                        class="text-danger fas">*</b></label>
                                <input type="text" class="form-control" id="inputName" name="name_ar"
                                    title="Please enter the contract Name" required>
                            </div>
                            <div class="col">
                                <label for="inputName" class="control-label">Code: <b
                                        class="text-danger fas">*</b></label>
                                <input type="text" class="form-control" id="inputName" name="code"
                                    title="Please enter the contract code" required
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            </div>

                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">Classification: <b
                                        class="text-danger fas">*</b></label>
                                <select name="classification_id" class="form-control " required>
                                    <option value="" selected disabled>Select contract classification</option>
                                    </option>
                                    @foreach ($contract_classifications as $contract_classification)
                                        <option value="{{ $contract_classification->id }}">
                                            {{ $contract_classification->name_en }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <label for="inputName" class="control-label">Max Credit Amount Per Visit: </label>
                                <input type="text" class="form-control" id="inputName" name="max_credit_amount_per_visit"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">

                            </div>
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

    <!-- edit -->
    <div class="modal fade" id="edit_contract" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add payer contract</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('edit_payer_contract') }}" method="post" autocomplete="off">
                    @csrf
                    {{-- 1 --}}

                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="contract_id" id="contract_id" value="">
                        </div>
                        <div class="row">
                            <div class="col">
                                <input type="checkbox" name="isActive" id="isActive">
                                <label for="inputName" class="control-label">Active</label>
                            </div>

                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">Name (EN): <b
                                        class="text-danger fas">*</b></label>
                                <input type="text" class="form-control" name="name_en" id="name_en"
                                    title="Please enter the contract Name" required>
                            </div>
                            <div class="col">
                                <label for="inputName" class="control-label">Name (AR): <b
                                        class="text-danger fas">*</b></label>
                                <input type="text" class="form-control"  name="name_ar" id="name_ar"
                                    title="Please enter the contract Name" required>
                            </div>
                            <div class="col">
                                <label for="inputName" class="control-label">Code: <b
                                        class="text-danger fas">*</b></label>
                                <input type="text" class="form-control" name="code" id="code"
                                    title="Please enter the contract code" required
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            </div>

                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">Classification: <b
                                        class="text-danger fas">*</b></label>
                                <select name="classification_id" id="classification_id" class="form-control " required>
                                </select>
                            </div>
                            <div class="col">
                                <label for="inputName" class="control-label">Max Credit Amount Per Visit: </label>
                                <input type="text" class="form-control" name="max_credit_amount_per_visit"
                                    id="max_credit_amount_per_visit"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">

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


    <!-- حذف  -->
    <div class="modal fade" id="delete_contract" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete contract</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('delete_payer_contract') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        Are you sure you want to delete this contract?
                        <input type="hidden" name="contract_id" id="contract_id" value="">
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
        $('#edit_contract').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var contract_data = button.data('contract_data')
            var classification = contract_data['classification']
            var contract_classifications = button.data('contract_classifications')
            var modal = $(this)
            modal.find('.modal-body #contract_id').val(contract_data['id']);
            modal.find('.modal-body #code').val(contract_data['code']);
            modal.find('.modal-body #name_en').val(contract_data['name_en']);
            modal.find('.modal-body #name_ar').val(contract_data['name_ar']);
            modal.find('.modal-body #max_credit_amount_per_visit').val(contract_data[
                'max_credit_amount_per_visit']);
            $('select[id="classification_id"]').empty();
            $.each(contract_classifications, function(key, value) {
                if (value.id !== contract_data['classification_id']) {
                    $('select[id="classification_id"]').append(
                        '<option value="' + value.id + '">' + value.name_en + '</option>');
                } else {
                    $('select[id="classification_id"]').append(
                        '<option selected value="' + value.id + '">' + value.name_en + '</option>');
                }
            });

            var checkBox = document.getElementById("isActive");
            if (contract_data['active'] == 0) {
                checkBox.checked = false;
            } else {
                checkBox.checked = true;
            }
        })
    </script>

    <script>
        $('#delete_contract').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var contract_id = button.data('contract_id')
            var modal = $(this)
            modal.find('.modal-body #contract_id').val(contract_id);
        })
    </script>

@endsection
