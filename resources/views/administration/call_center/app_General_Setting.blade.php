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
App General Setting
@stop
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Application Setting</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    General Setting</span>
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
                                        <li><a href="#tab1" class="nav-link active" data-toggle="tab">Basic Data</a></li>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body tabs-menu-body main-content-body-right border">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">
                                        <form action="{{ route('update_App_General_Setting') }}" method="post" autocomplete="off">
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <div class="col">
                                                    @if ($app_General_Setting->booking_is_block)
                                                        <input type="checkbox" name="booking_is_block" checked>
                                                    @else
                                                        <input type="checkbox" name="booking_is_block">
                                                    @endif
                                                    <label for="inputName" class="control-label">Booking is Blocked</label>
                                                </div>
                                               
                                                <div class="col">
                                                    <label for="inputName" class="control-label">Booking Message (EN): <b
                                                        class="text-danger fas">*</b></label>
                                                        <input type="text" class="form-control" id="inputName" name="booking_is_block_msg_en"
                                                        value="{{ $app_General_Setting->booking_is_block_msg_en }}" >
                                                </div>
                                               
                                                <div class="col">
                                                    <label for="inputName" class="control-label">Booking Message (AR): <b
                                                        class="text-danger fas">*</b></label>
                                                    <input type="text" class="form-control" id="inputName" name="booking_is_block_msg_ar"
                                                    value="{{ $app_General_Setting->booking_is_block_msg_ar }}" >
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col">
                                                    @if ($app_General_Setting->sysytem_is_block)
                                                        <input type="checkbox" name="sysytem_is_block" checked>
                                                    @else
                                                        <input type="checkbox" name="sysytem_is_block">
                                                    @endif
                                                    <label for="inputName" class="control-label">App. System is Blocked</label>
                                                </div>
                                               
                                                <div class="col">
                                                    <label for="inputName" class="control-label">Booking Message (EN): <b
                                                        class="text-danger fas">*</b></label>
                                                        <input type="text" class="form-control" id="inputName" name="sysytem_is_block_msg_en"
                                                        value="{{ $app_General_Setting->sysytem_is_block_msg_en }}" >
                                                </div>
                                               
                                                <div class="col">
                                                    <label for="inputName" class="control-label">Booking Message (AR): <b
                                                        class="text-danger fas">*</b></label>
                                                    <input type="text" class="form-control" id="inputName" name="sysytem_is_block_msg_ar"
                                                    value="{{ $app_General_Setting->sysytem_is_block_msg_ar }}" >
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col">
                                                    <label for="inputName" class="control-label">Application version numbers: </label>
                                                </div>
                                               
                                                <div class="col">
                                                    <label for="inputName" class="control-label">IOS version number: <b
                                                        class="text-danger fas">*</b></label>
                                                        <input type="text" class="form-control" id="inputName" name="ios_version"
                                                        value="{{ $app_General_Setting->ios_version }}" >
                                                </div>
                                               
                                                <div class="col">
                                                    <label for="inputName" class="control-label">Android version number: <b
                                                        class="text-danger fas">*</b></label>
                                                    <input type="text" class="form-control" id="inputName" name="android_version"
                                                    value="{{ $app_General_Setting->android_version }}" >
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <label for="inputName" class="control-label">App. About (EN): <b
                                                    class="text-danger fas">*</b></label>
                                                <div class="col">
                                                   
                                                  <textarea required class="form-control" name="about_en" id="" cols="30" rows="10">
                                                    {{ $app_General_Setting->about_en }}
                                                  </textarea>
                                                </div>
                                                <br>
                                                <label for="inputName" class="control-label">App. About (AR): <b
                                                    class="text-danger fas">*</b></label>
                                                <div class="col">
                                                   
                                                  <textarea  required class="form-control" name="about_ar" id="" cols="30" rows="10">
                                                    {{ $app_General_Setting->about_ar }}
                                                  </textarea>
                                                </div>

                                                
                                            </div>
                                            

<br>
<div class="card mg-b-20" id="image2">
    <div class="card-body">
        <div class="main-content-label mg-b-5">
            ATTACH LOGO
        </div>
        <p class="mg-b-20">It is Very Easy to Customize and it uses in your website apllication.</p>
        <div class="text-wrap">
            <div class="example">
                <img alt="Responsive image" class="img-thumbnail wd-100p wd-sm-200" src="{{ $app_General_Setting->logo }}">
            </div>
        </div>
    </div>
</div>

                                            {{--
                                                <br>
                                            <div class="row">
                                            <div class="col">
                                                <h5 class="card-title">Attach LOGO</h5>
    
                                                <input type="file" name="icon"
                                                class="form-control file-input  @error('icon') invalid-input @enderror"
                                                 accept="image/*">
                                                </div>
                                            </div>  --}}
                                            <br>
                                            <br>
                                            <div class="d-flex justify-content-center">

                                                <button type="submit" class="btn btn-primary">Save</button>&nbsp;&nbsp;
                                                <a href=" {{ url('App_General_Setting') }}"> <button type="button"
                                                        class="btn btn-danger" data-dismiss="modal">Cancel</button></a>
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

    <!-- get sample conditions by sample type -->
    <script>
        $(document).ready(function() {
            $('select[name="branch_id"]').on('change', function() {
                 
                var branch_id = $(this).val();
                if (branch_id) {
                    $.ajax({
                        url: "{{ URL::to('get_branch_Processing_units') }}/" + branch_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="processing_units_id"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="processing_units_id"]').append(
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

@endsection
