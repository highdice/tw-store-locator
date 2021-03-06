@extends('layouts.app')

@section('content')
<aside>
    <div id="sidebar" class="col-lg-2 col-md-3 col-sm-3 hidden-xs">
        <div class="sidebar-divider"></div>
        <p>ACTION</p>
        <ul>
            <a href="{{ url('users/add') }}">
              <li class="sidebar-js-button">
                  <i class="glyphicon glyphicon-plus"></i>
                  Add New User
              </li>
            </a>
        </ul>

        @if (Auth::user()->user_level == 30)
          <p>GENERATE REPORT (xls)</p>
          <ul>
              <a href="{{ url('users/export') }}">
                <li class="sidebar-js-button">
                    <i class="glyphicon glyphicon-download"></i>
                    Users
                </li>
              </a>
          </ul>
        @endif
    </div>
</aside>

<div class="col-lg-offset-2 col-lg-10 col-md-offset-3 col-md-9 col-sm-offset-3 col-sm-9 no-padding">
<ol class="breadcrumb">
  <li class="active">Users</li>
</ol>

<div class="page-title-container">
  <h3>Users</h3>
  <p>This page shows you a list of existing users</p>
</div>

<div class="inner-container top-30">
  @if (Session::has('error_message'))
      <div class="alert alert-danger" role="alert">{{ Session::get('error_message') }}</div>
  @elseif (Session::has('success_message'))
      <div class="alert alert-success" role="alert">{{ Session::get('success_message') }}</div>
  @endif

  <form class="form-horizontal" role="form" method="POST" action="{{ url('/users') }}">
    {!! csrf_field() !!}
    <div class="col-lg-12 no-padding"> 
      <div class="input-group"> 
        <span class="input-group-addon" id="sizing-addon2"><i class="glyphicon glyphicon-search"></i></span>
        <input type="text" class="form-control" name="search" placeholder="Search filter"> 
        <div class="input-group-btn"> 
          <button type="submit" class="btn btn-primary">Search</button>
        </div> 
      </div> 
    </div>
  </form>

  <div class="table-responsive"> 
    <table class="table">
      <thead>
        <tr>
          <th>User ID</th>
          <th>Email Address</th>
          <th>Name</th>
          <th>Default Password</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @if (isset($data) && count($data) > 0 && !empty($data))
        <?php $x = 0; ?>
        @foreach ($data as $datum)
          @if ($datum->id != Auth::user()->id && $datum->id != 1)
            <tr class="{{ ($x % 2) ? 'odd' : '' }} {{ ($datum->status == 0) ? ' deactivated' : ''  }}">
              <td>{{ $datum->id }}</td>
              <td>{{ $datum->email }}</td>
              <td>{{ $datum->name }}</td>
              <td>{{ (empty($datum->default_password)) ? 'Changed' : $datum->default_password }}</td>
              <td>
                <a href="{{ url('api/v1/users/' . $datum->id . '/reset' ) }}" title="Reset Password" class="btn btn-warning action-button">
                    <i class="fa fa-btn fa-lock"></i>
                </a>
                <a href="{{ url('/users/' . $datum->id . '/edit' ) }}" title="Update" class="btn btn-info action-button">
                    <i class="fa fa-btn fa-pencil"></i>
                </a>
                @if ($datum->status == 1)
                  <a href="{{ url('api/v1/users/' . $datum->id . '/status/0') }}" title="Deactivate" class="btn btn-danger action-button">
                      <i class="fa fa-btn fa-close"></i>
                  </a>
                @else
                  <a href="{{ url('api/v1/users/' . $datum->id . '/status/1') }}" title="Activate" class="btn btn-success action-button">
                    <i class="fa fa-btn fa-check"></i>
                  </a>
                @endif
              </td>
            </tr>
          @endif
        <?php $x++; ?>
        @endforeach
        @else 
          <tr><td colspan="5">No Records Available</td></tr>
        @endif
      </tbody>
    </table>
  </div>

  @if (isset($data) && count($data) > 0 && !empty($data))
    {{ $data->render() }}
  @endif
</div>
</div>

<div id="bottom-nav" class="hidden-lg hidden-md hidden-sm">
    <ul class="bottom-nav-list">
        <li>
          <div class="btn-group dropup">
            <a class="btn dropdown-toggle" data-toggle="dropdown">
              <i class="glyphicon glyphicon-option-horizontal"></i>
            </a>
            <ul class="dropdown-menu">
                  <li class="dropdown-submenu"><a href="{{ url('users/add') }}">Add New User</a></li>
                  <li class="dropdown-submenu"><a href="{{ url('users/export') }}">Download XLS Report</a></li>
            </ul>
          </div>
        </li>
    </ul>
</div>
@endsection