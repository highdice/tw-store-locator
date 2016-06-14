@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <center><img src="build/css/images/tw-logo.png" alt="" class="tw-logo img-responsive"></center>
            <div class="panel panel-default">
                <div class="panel-heading hide">Login</div>
                <div class="panel-body">
                    @if (Session::has('error_message'))
                        <div class="alert alert-danger" role="alert">{{ Session::get('error_message') }}</div>
                    @elseif (Session::has('success_message'))
                        <div class="alert alert-success" role="alert">{{ Session::get('success_message') }}</div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-md-12 custom-form">
                                <span>Email Address</span>
                                <i class="glyphicon glyphicon-envelope input-icon"></i>
                                <input type="email" class="form-control" placeholder="Enter your email address here" name="email" value="{{ old('email') }}">

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
                                <i class="glyphicon glyphicon-lock input-icon"></i>
                                <input type="password" class="form-control" placeholder="Enter your password here" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                              
                            </div>
                        </div>
                        
                        <!--
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Remember Me
                                    </label>
                                    |
                                    <label class="forgot-password-lbl">
                                        <a href="{{ url('/password/reset') }}">Forgot Password</a>
                                    </label>
                                </div>
                            </div>
                        </div>
                        -->

                        <div class="form-group no-margin-bottom">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary guest-button">
                                    <i class="fa fa-btn fa-sign-in"></i>Login
                                </button>
                                <a href="{{ url('/register') }}" class="btn btn-primary guest-button hidden">
                                    <i class="fa fa-btn fa-user"></i>Register
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
