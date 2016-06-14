@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
  <li><a href="/users">Users</a></li>
  <li class="active">Add</li>
</ol>

<div class="page-title-container">
  <h3>Add User</h3>
  <p>Fields with <i class="glyphicon glyphicon-certificate required"></i> are required.
</div>

<div class="container top-30">
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/api/v1/users/add') }}">
        {!! csrf_field() !!}
        <div class="panel panel-default">
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

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <div class="col-md-12 custom-form">
                            <span>Name</span>
                            <i class="glyphicon glyphicon-certificate input-icon"></i>
                            <input type="text" class="form-control" placeholder="Enter your name here" name="name" value="{{ old('name') }}">

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <!--
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <div class="col-md-12 custom-form">
                            <span>Password</span>
                            <i class="glyphicon glyphicon-certificate input-icon required"></i>
                            <input type="password" class="form-control" placeholder="Enter the password here" name="password">

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
                    -->

                    <div class="form-group{{ $errors->has('user_level') ? ' has-error' : '' }}">
                        <div class="col-md-12 custom-form">
                            <span>User Level</span>
                            <i class="glyphicon glyphicon-certificate input-icon required"></i>
                            
                            <select class="form-control" name="user_level" value="{{ old('user_level') }}">
                                @if (!old('user_level'))
                                        <option value="">Choose a user level</option>
                                @endif

                                @foreach ($user_levels as $user_level)
                                    @if (Auth::user()->user_level == 30)
                                        <option value="{{ $user_level->id }}" {{ (old('user_level') == $user_level->id) ? 'selected="selected"' : '' }}>{{ $user_level->title }}</option>
                                    @endif
                                    @if (Auth::user()->user_level == 31 && ($user_level->title == "Admin" || $user_level->title == "User"))
                                        <option value="{{ $user_level->id }}" {{ (old('user_level') == $user_level->id) ? 'selected="selected"' : '' }}>{{ $user_level->title }}</option>
                                    @endif
                                @endforeach
                            </select>

                            @if ($errors->has('user_level'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('user_level') }}</strong>
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
                            <a href="{{ url('/users') }}" class="btn btn-primary guest-button">
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
