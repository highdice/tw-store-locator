@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
  <li class="active">Branches</li>
</ol>

<div class="page-title-container">
  <h3>Branches</h3>
  <p>Lorem ipsum dolor kismet akhmet</p>
</div>

<div class="inner-container page-add-container">
  <a href="{{ url('stores/add') }}" class="btn btn-success add-button">
      <i class="fa fa-btn fa-plus"></i>Add Branch
  </a>
</div>

<div class="inner-container">
  <div class="col-lg-12 no-padding"> 
    <div class="input-group"> 
      <span class="input-group-addon" id="sizing-addon2"><i class="glyphicon glyphicon-search"></i></span>
      <input type="text" class="form-control" placeholder="Search filter"> 
      <div class="input-group-btn"> 
        <button type="button" class="btn btn-default">SEARCH</button> 
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
          <span class="search-by">BY</span><span class="caret"></span>
        </button> 

        <ul class="dropdown-menu dropdown-menu-right">
          <li><a href="#">Branch Code</a></li> 
          <li><a href="#">Trade Name</a></li> 
          <li><a href="#">Satellite Name</a></li> 
          <li><a href="#">Division</a></li> 
          <li role="separator" class="divider"></li> 
          <li><a href="#">Any</a></li> 
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
@endsection
