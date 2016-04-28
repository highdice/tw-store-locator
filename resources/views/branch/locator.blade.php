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

        <p>BY CATEGORY</p>
        <ul>
            <li class="sidebar-js-button">
                <i class="glyphicon glyphicon-map-marker"></i>
                Branch
            </li>
            <li class="sidebar-js-button">
                <i class="glyphicon glyphicon-map-marker"></i>
                Satellite
            </li>
            <li class="sidebar-js-button active">
                <i class="glyphicon glyphicon-map-marker"></i>
                Island Group
            </li>
            <li id="show-regions" class="sidebar-js-button">
                <i class="glyphicon glyphicon-map-marker"></i>
                Region
            </li>
            <li class="sidebar-js-button">
                <i class="glyphicon glyphicon-map-marker"></i>
                Area
            </li>
            <li class="sidebar-js-button">
                <i class="glyphicon glyphicon-map-marker"></i>
                Division
            </li>
        </ul>

        <p>RESULT <span id="result-count" class="badge"></span></p>
        <ul id="result-list">
        </ul>
    </div>
</aside>

<div id="map" class="col-lg-offset-2 col-lg-10 col-md-offset-3 col-md-9 col-sm-offset-3 col-sm-9 no-padding"></div>

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
@endsection

@section('scripts')
    <script src="{{ elixir('js/all-mapbox.js') }}"></script>
@stop