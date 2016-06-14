@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
  <li><a href="/users">Users</a></li>
  <li class="active">Edit</li>
</ol>

<div class="page-title-container">
  <h3>Edit User Details</h3>
  <p>Fields with <i class="glyphicon glyphicon-certificate required"></i> are required.
</div>

<div class="container top-30">
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/api/v1/users/edit') }}">
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
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <div class="col-md-12 custom-form">
                            <span>Email Address</span>
                            <i class="glyphicon glyphicon-certificate input-icon required"></i>
                            <input type="text" class="form-control" placeholder="Enter the email address here" name="email" value="{{ $data->email }}">

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
                            <input type="text" class="form-control" placeholder="Enter your name here" name="name" value="{{ $data->name }}">

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('user_level') ? ' has-error' : '' }}">
                        <div class="col-md-12 custom-form">
                            <span>User Level</span>
                            <i class="glyphicon glyphicon-certificate input-icon required"></i>
                            
                            <select class="form-control" name="user_level" value="{{ $data->user_level }}">
                                @foreach ($user_levels as $user_level)
                                    @if (Auth::user()->user_level == 30)
                                        <option value="{{ $user_level->id }}" {{ ($user_level->id == $data->getUserLevel->id) ? 'selected="selected"' : '' }}>{{ $user_level->title }}</option>
                                    @endif
                                    @if (Auth::user()->user_level == 31 && ($user_level->title == "Admin" || $user_level->title == "User"))
                                        <option value="{{ $user_level->id }}" {{ ($user_level->id == $data->getUserLevel->id) ? 'selected="selected"' : '' }}>{{ $user_level->title }}</option>
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
