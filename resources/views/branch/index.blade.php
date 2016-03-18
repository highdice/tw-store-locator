@extends('layouts.app')

@section('content')
<div class="container">
  <h3>Branches</h3>
  <hr />
  <a href="{{ url('stores/add') }}" class="btn btn-primary action-button">
      <i class="fa fa-btn fa-plus"></i>Add Branch
  </a>
  <hr />
  <div class="table-responsive"> 
    <table class="table">
      <thead>
        <tr>
          <th>Branch Code</th>
          <th>Trade Name</th>
          <th>Name</th>
          <th>Division</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @if (isset($data))
        @foreach ($data as $datum)
          <tr>
            <td>{{ $datum->branch_code }}</td>
            <td>{{ $datum->trade_name }}</td>
            <td>{{ $datum->name }}</td>
            <td>{{ $datum->division }}</td>
            <td>
              <a href="{{ url('/satellite/'.$datum->branch_code ) }}" class="btn btn-primary action-button">
                  <i class="fa fa-btn fa-eye"></i>
              </a>
              <a href="{{ url('/satellite/'.$datum->branch_code ) }}" class="btn btn-primary action-button">
                  <i class="fa fa-btn fa-pencil"></i>
              </a>
              <a href="{{ url('/satellite/'.$datum->branch_code ) }}" class="btn btn-primary action-button">
                  <i class="fa fa-btn fa-close"></i>
              </a>
            </td>
          </tr>
        @endforeach
        @else 
          <tr><td colspan="5">No Records Available</td></tr>
        @endif
      </tbody>
    </table>
  </div>

  <?php echo $data->render(); ?>
</div>
@endsection
