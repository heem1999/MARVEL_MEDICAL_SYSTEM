@extends('layouts.master')
@section('css')
<!-- Internal Nice-select css  -->
<link href="{{URL::asset('assets/plugins/jquery-nice-select/css/nice-select.css')}}" rel="stylesheet" />
@section('title')
Users
@stop


@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Manage Users</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                Edit User</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    <div class="col-lg-12 col-md-12">

        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="card">
            <div class="card-body">


                {!! Form::model($user, ['method' => 'PATCH','enctype' => 'multipart/form-data','route' =>
                ['users.update', $user->id]]) !!}
                <div class="">

                    <div class="row mg-b-20">
                        <div class="parsley-input col-md-6" id="fnWrapper">
                            <label>Full Name: <span class="tx-danger">*</span></label>

                            {!! Form::text('full_name', null, array('class' => 'form-control','required')) !!}
                        </div>
                        <div class="parsley-input col-md-6" id="fnWrapper">
                            <label>User Name: <span class="tx-danger">*</span></label>
                            {!! Form::text('name', null, array('class' => 'form-control','required')) !!}
                        </div>
                    </div>
                    <div class="row mg-b-20">
                        <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                            <label>Email: <span class="tx-danger">*</span></label>
                            {!! Form::text('email', null, array('class' => 'form-control','required')) !!}
                        </div>

                        <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                            <label class="form-label">User Branch: <span class="tx-danger">*</span></label>
                            <select name="branch_id" id="select-beast" class="form-control  nice-select  custom-select"
                                required="">
                                @foreach ($branches as $branche)
                                @if ($user->branch_id==$branche->id)
                                <option selected value="{{ $branche->id }}">
                                    {{ $branche->name_en }}
                                </option>
                                @else
                                <option value="{{ $branche->id }}">
                                    {{ $branche->name_en }}
                                </option>
                                @endif

                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>

                <div class="row mg-b-20">
                    <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                        <label> Password: <span class="tx-danger">*</span></label>
                        {!! Form::password('password', array('class' => 'form-control')) !!}
                    </div>

                    <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                        <label> Confirm Password: <span class="tx-danger">*</span></label>
                        {!! Form::password('confirm-password', array('class' => 'form-control')) !!}
                    </div>
                </div>

                <div class="row row-sm mg-b-20">
                    <div class="col-lg-6">
                        <label class="form-label">User Status:</label>
                        <select name="Status" id="select-beast" class="form-control  nice-select  custom-select">
                            <option value="{{ $user->Status}}">{{ $user->Status}}</option>
                            <option value="Active">Active</option>
                            <option value="Not Active">Not Active</option>
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">Clinic Rule: (<span class="tx-danger">used by clinic only</span>)</label>
                                <select name="user_titile" id="select-beast"
                                    class="form-control  nice-select  custom-select">
                                    <option {{ $user->user_titile=='admin'?'selected':''}} value="admin">admin</option>
                                    <option {{ $user->user_titile=='reception'?'selected':''}} value="reception">reception</option>
                                    <option {{ $user->user_titile=='pharmacy'?'selected':''}} value="pharmacy">pharmacy</option>
                                </select>
                    </div>
                </div>

                <div class="row mg-b-20">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>User Roles:</strong>
                            {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control','multiple'))
                            !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label class="form-label"> Upload signature:</label>
                            <input type="file" name="signature" placeholder="Upload signature" id="signature">
                            @error('signature')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <b class="label text-danger ">
                            Recommended Dimensions ( 2 * 4 cm) or (66 * 132 px)
                        </b>
                        @if ($user->signature)
                        <div height="66" width="132">
                            <img height="66" width="132"
                                src="{{ 'data:image/png;base64,' .base64_encode(file_get_contents(public_path($user->signature))) }}" />
                        </div>
                        @endif
                    </div>
                </div>
                <div class="mg-t-30">
                    <button class="btn btn-main-primary pd-x-20" type="submit">Update</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>




</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')

<!-- Internal Nice-select js-->
<script src="{{URL::asset('assets/plugins/jquery-nice-select/js/jquery.nice-select.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery-nice-select/js/nice-select.js')}}"></script>

<!--Internal  Parsley.min js -->
<script src="{{URL::asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
<!-- Internal Form-validation js -->
<script src="{{URL::asset('assets/js/form-validation.js')}}"></script>
@endsection