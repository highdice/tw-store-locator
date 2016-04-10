@extends('layouts.app')

@section('content')
<div class="container">
  <h3>Users</h3>
  <hr />
  <a href="{{ url('users/add') }}" class="btn btn-primary add-button">
      <i class="fa fa-btn fa-user"></i>Add User
  </a>
  <a href="javascript:void(0)" class="btn btn-primary show-filter-button">
      <i class="fa fa-btn fa-search"></i>Show Filter
  </a>
  <a href="javascript:void(0)" class="btn btn-primary hide-filter-button">
      <i class="fa fa-btn fa-search"></i>Hide Filter
  </a>
  <div class="panel panel-default search-filter-container">
      <div class="panel-body">
          <div class="col-md-6 no-padding">
              <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
                  <div class="col-md-12 custom-form">
                      <span>Search Criteria</span>
                      <i class="glyphicon glyphicon-certificate input-icon"></i>
                      <input type="text" class="form-control search-criteria" placeholder="Enter the search value here">
                  </div>
              </div>
            </div>

            <div class="col-md-6 no-padding">
                <div class="form-group{{ $errors->has('region') ? ' has-error' : '' }}">
                  <div class="col-md-12 custom-form">
                      <span>Search By</span>
                      <i class="glyphicon glyphicon-certificate input-icon"></i>
                      
                      <select class="form-control search-by">
                          <option value="">Any</option>
                          <option value="">User ID</option>
                          <option value="">Email Address</option>
                      </select>
                      @if ($errors->has('region'))
                          <span class="help-block">
                              <strong>{{ $errors->first('region') }}</strong>
                          </span>
                      @endif
                  </div>
              </div>
            </div>

            <div class="col-md-12 no-padding">
              <br />
              <div class="form-group">
                  <div class="col-md-12">
                      <a href="" class="btn btn-success guest-button">
                          <i class="fa fa-btn fa-check"></i>Search
                      </a>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <hr />
  <div class="table-responsive"> 
    <table class="table">
      <thead>
        <tr>
          <th>User ID</th>
          <th>Email Address</th>
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
@endsection
