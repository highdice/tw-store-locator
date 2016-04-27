@extends('layouts.app')

@section('content')
<aside>
    <div id="sidebar" class="col-lg-2 col-md-3 col-sm-3 hidden-xs">
        <div class="sidebar-divider"></div>
        <p>ACTION</p>
        <ul>
            <a href="{{ url('stores/add') }}">
              <li class="sidebar-js-button">
                  <i class="glyphicon glyphicon-plus"></i>
                  Add New Branch
              </li>
            </a>
            <li class="sidebar-js-button">
                <i class="glyphicon glyphicon-download"></i>
                Download CSV Report
            </li>
        </ul>
    </div>
</aside>

<div class="col-lg-offset-2 col-lg-10 col-md-offset-3 col-md-9 col-sm-offset-3 col-sm-9 no-padding">
<ol class="breadcrumb">
  <li class="active">Branches</li>
</ol>

<div class="page-title-container">
  <h3>Branches</h3>
  <p>This page shows you a list of existing branches</p>
</div>

<div class="inner-container top-30">
  <div class="col-lg-12 no-padding"> 
    <div class="input-group"> 
      <span class="input-group-addon" id="sizing-addon2"><i class="glyphicon glyphicon-search"></i></span>
      <input type="text" class="form-control" placeholder="Search filter"> 
      <div class="input-group-btn"> 
        <button type="button" class="btn btn-primary">Search</button> 
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
          <span class="search-by">By Any</span><span class="caret"></span>
        </button> 

        <ul class="dropdown-menu dropdown-menu-right">
          <li class="filter-item"><a href="javascript:void(0)">Branch Code</a></li>
          <li class="filter-item"><a href="javascript:void(0)">Trade Name</a></li>
          <li class="filter-item"><a href="javascript:void(0)">Branch Name</a></li>
          <li class="filter-item"><a href="javascript:void(0)">Area</a></li>
          <li class="filter-item"><a href="javascript:void(0)">Division</a></li>
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
          <th>Branch Code</th>
          <th>Trade Name</th>
          <th>Name</th>
          <th>Division</th>
          <th>Satellites</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @if (isset($data) && count($data) > 0 && !empty($data))
        <?php $x = 0; ?>
        @foreach ($data as $datum)
          <tr class="{{ ($x % 2) ? 'odd' : '' }}">
            <td>{{ $datum->branch_code }}</td>
            <td>{{ $datum->trade_name_prefix . ' - ' . $datum->getTradeName->description }}</td>
            <td>{{ $datum->name }}</td>
            <td>{{ $datum->division }}</td>
            <td>{{ count($datum->satellites) }}</td>
            <td>
              <a href="{{ url('/stores/' . $datum->id . '/satellite') }}" title="View Satellites" class="btn btn-warning action-button">
                  <i class="fa fa-btn fa-eye"></i>
              </a>
              <a href="{{ url('/stores/' . $datum->id . '/edit' ) }}" title="Update" class="btn btn-info action-button">
                  <i class="fa fa-btn fa-pencil"></i>
              </a>
              @if ($datum->status == 1)
                <a href="{{ url('/stores/' . $datum->id . '/status') }}" title="Deactivate" class="btn btn-danger action-button">
                    <i class="fa fa-btn fa-close"></i>
                </a>
              @else
                <a href="{{ url('/stores/' . $datum->id . '/status') }}" title="Activate" class="btn btn-success action-button">
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

<div id="bottom-nav" class="hidden-lg hidden-md hidden-sm">
    <ul class="bottom-nav-list">
        <li>
          <div class="btn-group dropup">
            <a class="btn dropdown-toggle" data-toggle="dropdown">
              <i class="glyphicon glyphicon-option-horizontal"></i>
            </a>
            <ul class="dropdown-menu">
                  <li class="dropdown-submenu"><a>Add New Branch</a></li>
                  <li class="dropdown-submenu"><a>Download CSV Report</a></li>
            </ul>
          </div>
        </li>
    </ul>
</div>
@endsection