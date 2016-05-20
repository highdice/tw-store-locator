@extends('layouts.app')

@section('content')
<aside>
    <div id="sidebar" class="col-lg-2 col-md-3 col-sm-3 hidden-xs">
        <div class="sidebar-divider"></div>

        <div class="sidebar-search-container">
            <i class="glyphicon glyphicon-search"></i>
            <input type="text" id="search-input" placeholder="Search here" class="form-control">
            <center>
                <button id="search-button" class="btn btn-success">SEARCH</button>
            </center>
        </div>

        <p>CATEGORIES</p>
        <ul>
            <li id="show-branches" class="sidebar-js-button">
                <i class="glyphicon glyphicon-th"></i>
                Branch
            </li>
            <li id="show-satellites" class="sidebar-js-button">
                <i class="glyphicon glyphicon-th"></i>
                Satellite
            </li>
            <li id="show-island-groups" class="sidebar-js-button">
                <i class="glyphicon glyphicon-th"></i>
                Island Group
            </li>
            <li id="show-regions" class="sidebar-js-button">
                <i class="glyphicon glyphicon-th"></i>
                Region
            </li>
            <li class="sidebar-js-button">
                <i class="glyphicon glyphicon-th"></i>
                Division
            </li>
        </ul>
    </div>
</aside>

<div id="legend">
    <div class="legend-inner-container">
      <!-- <i class="glyphicon glyphicon-remove close-button"></i> -->
      <strong>LEGEND</strong>
      <div class="table-responsive legend-table"> 
        <table class="table">
          <thead>
            <tr>
              <th>Color</th>
              <th>Description</th>
              <th>Count</th>
            </tr>
          </thead>
          <tbody class="legend-body"></tbody>
        </table>
      </div>
    </div>
</div>

<div id="map" class="col-lg-offset-2 col-lg-10 col-md-offset-3 col-md-9 col-sm-offset-3 col-sm-9 no-padding"></div>

<div id="result-container">
    <div id="result-inner-container">
        <!-- <i class="glyphicon glyphicon-remove close-button"></i> -->
        <p class="result-title">RESULT <!--<span id="result-count" class="badge">--></span></p>
        <div class="result-body">
            <div class="result-dropdown">
                <select class="form-control"></select>
            </div>
            <ul id="result-list">
            </ul>
        </div>
    </div>
</div>

<div class="btn-group-vertical btn-group-sm locator-control" role="group" aria-label="...">
    <button type="button" class="btn btn-default result-hide-show" data-toggle="tooltip" data-placement="left" title="show / hide result">
        <i class="glyphicon glyphicon-th-list"></i>
    </button>
    <button type="button" class="btn btn-default legend-hide-show" data-toggle="tooltip" data-placement="left" title="show / hide legend">
        <i class="glyphicon glyphicon-th-large"></i>
    </button>
    <button type="button" class="btn btn-default highlights-hide-show" data-toggle="tooltip" data-placement="left" title="show / hide color highlights">
        <i class="glyphicon glyphicon-cog"></i>
    </button>
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

<input type="hidden" id="regions-path" value="{{ asset('js/regions.json') }}">

<div id="locator-loader">
    <div class="circles-loader"></div>
</div>
@endsection

@section('scripts')
    <script src="{{ elixir('js/all-mapbox.js') }}"></script>
@stop