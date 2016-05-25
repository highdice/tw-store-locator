@extends('layouts.app')

@section('content')
<aside>
    <div id="sidebar" class="col-lg-2 col-md-3 col-sm-3 hidden-xs">
        <div class="sidebar-divider"></div>
        <p>GENERAL</p>
        <ul>
            <li id="show-historical-chart" class="sidebar-js-button active">
                <i class="fa fa-btn fa-line-chart"></i>
                Development
            </li>
        </ul>

        <p>CATEGORIES</p>
        <ul>
            <li id="show-island-groups-chart" class="sidebar-js-button">
                <i class="glyphicon glyphicon-th"></i>
                Island Group
            </li>
            <li id="show-regions-chart" class="sidebar-js-button">
                <i class="glyphicon glyphicon-th"></i>
                Region
            </li>
            <li id="show-divisions-chart" class="sidebar-js-button">
                <i class="glyphicon glyphicon-th"></i>
                Division
            </li>
            <li id="show-area-chart" class="sidebar-js-button">
                <i class="glyphicon glyphicon-th"></i>
                Area
            </li>      
        </ul>
    </div>
</aside>

<div class="col-lg-offset-2 col-lg-10 col-md-offset-3 col-md-9 col-sm-offset-3 col-sm-9 no-padding">
    <div class="page-title-container">
        <h3>Dashboard</h3>
        <p>This page contains a list of statistical charts and tables</p>
    </div>

    <div class="col-md-12 inner-container historical-chart-container">
        <div id="historical-chart" class="line-chart"></div>
    </div>

    <div class="col-md-12 inner-container island-groups-chart-container">
        <div class="col-md-12 no-padding chart-title">
            <h4>Island Groups</h4>
        </div>

        <div class="col-md-4 no-padding">
            <div id="island-groups-chart" class="pie-chart"></div>
        </div>

        <div class="col-md-8 no-padding">
            <div class="table-responsive island-groups-table"> 
                <table class="table">
                  <thead>
                    <tr>
                      <th>Legend</th>
                      <th>Description</th>
                      <th>Total Count</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
        </div>
    </div>

    <div class="col-md-12 inner-container regions-chart-container">
        <div class="col-md-12 no-padding chart-title">
            <h4>Regions</h4>
        </div>

        <div class="col-md-4 no-padding">
            <div id="regions-chart" class="pie-chart"></div>
        </div>

        <div class="col-md-8 no-padding">
            <div class="table-responsive regions-table"> 
                <table class="table">
                  <thead>
                    <tr>
                      <th>Legend</th>
                      <th>Description</th>
                      <th>Total Count</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
        </div>
    </div>

    <div class="col-md-12 inner-container divisions-chart-container">
        <div class="col-md-12 no-padding chart-title">
            <h4>Divisions</h4>
        </div>

        <div class="col-md-4 no-padding">
            <div id="divisions-chart" class="pie-chart"></div>
        </div>

        <div class="col-md-8 no-padding">
            <div class="table-responsive divisions-table"> 
                <table class="table">
                  <thead>
                    <tr>
                      <th>Legend</th>
                      <th>Description</th>
                      <th>Total Count</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
        </div>
    </div>

    <div class="col-md-12 inner-container area-chart-container">
        <div class="col-md-12 no-padding chart-title">
            <h4>Areas</h4>
        </div>

        <div class="col-md-4 no-padding">
            <div id="area-chart" class="pie-chart"></div>
        </div>

        <div class="col-md-8 no-padding">
            <div class="table-responsive area-table"> 
                <table class="table">
                  <thead>
                    <tr>
                      <th>Legend</th>
                      <th>Description</th>
                      <th>Total Count</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
        </div>
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

@section('scripts')
    <script src="{{ elixir('js/all-highcharts.js') }}"></script>
@stop