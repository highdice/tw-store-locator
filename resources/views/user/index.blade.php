@extends('layouts.app')

@section('content')
<aside>
    <div id="sidebar" class="col-lg-2 col-md-3 col-sm-3 hidden-xs">
        <div class="sidebar-divider"></div>
        <p>ACTION</p>
        <ul>
            <a href="{{ url('users/add') }}">
              <li id="sidebar-result" class="sidebar-js-button">
                  <i class="glyphicon glyphicon-plus"></i>
                  Add New User
              </li>
            </a>
            <li id="sidebar-result" class="sidebar-js-button">
                <i class="glyphicon glyphicon-download"></i>
                Download CSV Report
            </li>
        </ul>
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
  <div class="col-lg-12 no-padding"> 
    <div class="input-group"> 
      <span class="input-group-addon" id="sizing-addon2"><i class="glyphicon glyphicon-search"></i></span>
      <input type="text" class="form-control" placeholder="Search filter"> 
      <div class="input-group-btn"> 
        <button type="button" class="btn btn-primary">SEARCH</button> 
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
          <span class="search-by">By Any</span><span class="caret"></span>
        </button> 

        <ul class="dropdown-menu dropdown-menu-right">
          <li class="filter-item"><a href="javascript:void(0)">Email Address</a></li>
          <li class="filter-item"><a href="javascript:void(0)">Name</a></li>
          <li role="separator" class="divider"></li>
          <li class="filter-item"><a href="javascript:void(0)">Any</a></li>
        </ul>
      </div> 
    </div> 
  </div>

  <div class="table-responsive"> 
    <table class="table">
      <thead>
        <tr>
          <th>User ID</th>
          <th>Email Address</th>
          <th>Name</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @if (isset($data) && count($data) > 0 && !empty($data))
        <?php $x = 0; ?>
        @foreach ($data as $datum)
          <tr class="{{ ($x % 2) ? 'odd' : '' }}">
            <td>{{ $datum->id }}</td>
            <td>{{ $datum->email }}</td>
            <td>{{ $datum->name }}</td>
            <td>
              <a href="{{ url('/users/' . $datum->id . '/edit' ) }}" title="Update" class="btn btn-info action-button">
                  <i class="fa fa-btn fa-pencil"></i>
              </a>
              @if ($datum->status == 1)
                <a href="{{ url('/users/' . $datum->id . '/status') }}" title="Deactivate" class="btn btn-danger action-button">
                    <i class="fa fa-btn fa-close"></i>
                </a>
              @else
                <a href="{{ url('/users/' . $datum->id . '/status') }}" title="Activate" class="btn btn-success action-button">
                  <i class="fa fa-btn fa-close"></i>
                </a>
              @endif
            </td>
          </tr>
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
@endsection