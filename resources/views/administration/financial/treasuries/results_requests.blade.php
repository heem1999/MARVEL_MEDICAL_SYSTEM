
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

