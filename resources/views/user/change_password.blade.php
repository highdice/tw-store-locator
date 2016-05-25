@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
  <li><a href="/users">Users</a></li>
  <li class="active">Change Password</li>
</ol>

<div class="page-title-container">
  <h3>Change Password</h3>
  <p>Fields with <i class="glyphicon glyphicon-certificate required"></i> are required.
</div>

<div class="container top-30">
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/api/v1/users/change_password') }}">
        {!! csrf_field() !!}
        <div class="panel panel-default">
            <div class="panel-body">
                @if (Session::has('error_message'))
                    <div class="alert alert-danger" role="alert">{{ Session::get('error_message') }}</div>
                @elseif (Session::has('success_message'))
                    <div class="alert alert-success" role="alert">{{ Session::get('success_message') }}</div>
                @endif

                <input type="hidden" name="id" value="{{ $data->id }}">

                <div class="col-md-12">
                    <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
                        <div class="col-md-12 custom-form">
                            <span>Old Password</span>
                            <i class="glyphicon glyphicon-certificate input-icon required"></i>
                            <input type="password" class="form-control" placeholder="Enter your old password here" name="old_password">

                            @if ($errors->has('old_password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('old_password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <div class="col-md-12 custom-form">
                            <span>New Password</span>
                            <i class="glyphicon glyphicon-certificate input-icon required"></i>
                            <input type="password" class="form-control" placeholder="Enter your new password here" name="password">

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <div class="col-md-12 custom-form">
                            <span>Confirm Password</span>
                            <i class="glyphicon glyphicon-certificate input-icon required"></i>
                            <input type="password" class="form-control" placeholder="Confirm your password here" name="password_confirmation">

                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <br />
                    <div class="form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary guest-button">
                                <i class="fa fa-btn fa-check"></i>Submit
                            </button>
                        </div>
                    </div>
                </div>
          </div>
        </div>
    </form>
</div>
@endsection