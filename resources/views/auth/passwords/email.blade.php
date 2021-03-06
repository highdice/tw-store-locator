@extends('layouts.app')

<!-- Main Content -->
@section('content')
<div class="container">
    <div class="col-lg-12 col-md-12 hidden-sm hidden-xs top-70"></div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3 top-30">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
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

                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary guest-button">
                                    <i class="fa fa-btn fa-send"></i>Reset
                                </button>
                                <a href="{{ url('/login') }}" class="btn btn-primary guest-button">
                                    <i class="fa fa-btn fa-arrow-left"></i>Back
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
