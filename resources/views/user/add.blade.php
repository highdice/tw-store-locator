@extends('layouts.app')

@section('content')
<div class="container">
    <h3><i class="glyphicon glyphicon-plus header-icon"></i> Add New User</h3>
    <p class="sub-header">Fields with <i class="glyphicon glyphicon-certificate required"></i> are required.
    <hr />

    <form class="form-horizontal" role="form" method="POST" action="{{ url('/api/v1/users/add') }}">
        {!! csrf_field() !!}
        <div class="panel panel-default col-md-6">
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <div class="col-md-12 custom-form">
                            <span>Email Address</span>
                            <i class="glyphicon glyphicon-certificate input-icon required"></i>
                            <input type="text" class="form-control" placeholder="Enter the email address here" name="email" value="{{ old('email') }}">

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <div class="col-md-12 custom-form">
                            <span>Password</span>
                            <i class="glyphicon glyphicon-certificate input-icon required"></i>
                            <input type="password" class="form-control" placeholder="Enter the password here" name="password" value="{{ old('password') }}">

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
                            <input type="password" class="form-control" placeholder="Confirm your password here" name="password_confirmation" value="{{ old('password_confirmation') }}">

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
                            <a href="{{ url('/stores') }}" class="btn btn-primary guest-button">
                                <i class="fa fa-btn fa-arrow-left"></i>Back
                            </a>
                        </div>
                    </div>
                </div>
          </div>
        </div>
    </form>
</div>
@endsection
