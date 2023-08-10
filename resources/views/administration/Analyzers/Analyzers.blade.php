@extends('layouts.master')
@section('title')
    Analyzers
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
                <h4 class="content-title mb-0 my-auto">Analyzers</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Analyzers
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

    @if (session()->has('edit'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('edit') }}</strong>
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

                    <a href="Analyzers/create" class="modal-effect btn btn-sm btn-primary" style="color:white"><i
                            class="fas fa-plus"></i>&nbsp; Add analyzer</a>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-hover mb-0 text-md-nowrap" data-page-length='50'
                            style="text-align: center">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">Active</th>
                                    <th class="border-bottom-0">Analyzer Name</th>
                                    <th class="border-bottom-0">Branch Name</th>
                                    <th class="border-bottom-0">Processing unit</th>
                                    <th class="border-bottom-0">Operations</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($Analyzers as $analyzer)
                                 
                                    <tr>
                                        @if ($analyzer->active == 1)
                                            <td><i class="text-success fas fa-check-circle"></i></td>
                                        @else
                                            <td><i class="text-danger fas fa-minus-circle"></i></td>
                                        @endif
                                       
                                        <td>{{ $analyzer->name_en }} </td>
                                        <td>{{ $analyzer->branch->name_en }} </td>
                                        <td>{{ $analyzer->processing_unit->name_en }} </td>
                                        <td>
                                                <a data-effect="effect-scale" href="#"
                                                data-selected_analyzer_data="{{ $analyzer }}"
                                                data-analyzers_data="{{ $Analyzers }}" data-toggle="modal"
                                                data-target="#copy_analyzer_tests" title="Copy analyzer tests"><i
                                                    class=" fas fa-copy"></i></a>
                                        &nbsp;&nbsp;

                                            <a data-effect="effect-scale" title="Edit analyzer"
                                                href=" {{ url('edit_analyzer') }}/{{ $analyzer->id }}"><i
                                                    class="text-danger fas fa-edit"></i></a>
                                            &nbsp;&nbsp;
                                            <a title="Delete analyzer" href="#" data-analyzer_id="{{ $analyzer->id }}"
                                                data-toggle="modal" data-target="#delete_analyzer"><i
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
    <div class="modal fade" id="delete_analyzer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete analyzer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <form action="{{ route('Analyzers.destroy', 'test') }}" method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this analyzer?
                    <input type="hidden" name="analyzer_id" id="analyzer_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Confirm</button>
                </div>
                </form>
            </div>
        </div>
    </div>

   
    <div class="modal fade" id="copy_analyzer_tests" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Copy analyzer tests</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('copy_analyzer_tests') }}" method="post" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="selected_analyzer_id" id="selected_analyzer_id" value="">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Copy analyzer tests list on <b
                                    name="selected_analyzer_name" id="selected_analyzer_name"> </b> to</label>
                        </div>

                        <div class="form-group">
                            <select required name="new_analyzer" class="form-control ">
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
        $('#delete_analyzer').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var analyzer_id = button.data('analyzer_id')
            var modal = $(this)
            modal.find('.modal-body #analyzer_id').val(analyzer_id);
        })
    </script>


<script>
    $('#copy_analyzer_tests').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var selected_analyzer_data = button.data('selected_analyzer_data')
        var analyzers_data = button.data('analyzers_data')
        var modal = $(this)
        modal.find('.modal-body #selected_analyzer_id').val(selected_analyzer_data['id']);
        modal.find('.modal-body #selected_analyzer_name').text(selected_analyzer_data['name_en']);

        $('select[name="new_analyzer"]').empty();
        $.each(analyzers_data, function(key, value) {
            if (value.id !== selected_analyzer_data['id']) { //do not add the selected analyzer tests
                $('select[name="new_analyzer"]').append(
                    '<option value="' + value.id + '">' + value.name_en + '</option>');
            }
        });
    })
</script>
   
@endsection
