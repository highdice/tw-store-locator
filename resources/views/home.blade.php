@extends('layouts.app')

@section('content')
<aside>
    <div id="sidebar" class="col-lg-2 col-md-3 col-sm-3 hidden-xs">
        <div class="sidebar-divider"></div>
        <p>GENERAL</p>
        <ul>
            <li id="sidebar-result" class="sidebar-js-button active">
                <i class="glyphicon glyphicon-stats"></i>
                Historical
            </li>
        </ul>

        <p>BY CATEGORY</p>
        <ul>
            <li id="sidebar-result" class="sidebar-js-button">
                <i class="glyphicon glyphicon-list-alt"></i>
                Island Group
            </li>
            <li id="sidebar-result" class="sidebar-js-button">
                <i class="glyphicon glyphicon-list-alt"></i>
                Region
            </li>
            <li id="sidebar-result" class="sidebar-js-button">
                <i class="glyphicon glyphicon-list-alt"></i>
                Area
            </li>
            <li id="sidebar-result" class="sidebar-js-button">
                <i class="glyphicon glyphicon-list-alt"></i>
                Division
            </li>
        </ul>
    </div>
</aside>

<div class="col-lg-offset-2 col-lg-10 col-md-offset-3 col-md-9 col-sm-offset-3 col-sm-9 no-padding">
    <div class="page-title-container">
        <h3>Dashboard</h3>
        <p>This page contains a list of statistical charts and tables</p>
    </div>

    <div class="col-md-12 inner-container">
        <div id="historical-chart" class="line-chart"></div>
    </div>

    <div class="col-md-12 inner-container">
        <div class="col-md-4 no-padding">
            <div id="island-group-chart" class="pie-chart"></div>
        </div>

        <div class="col-md-8 no-padding">
            <div class="table-responsive"> 
                <table class="table">
                  <thead>
                    <tr>
                      <th>Description</th>
                      <th>Total Number</th>
                      <th>Percentage</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                        <td>Luzon</td>
                        <td>100</td>
                        <td>30%</td>
                    </tr>
                    <tr>
                        <td>Visayas</td>
                        <td>100</td>
                        <td>30%</td>
                    </tr>
                    <tr>
                        <td>Mindanao</td>
                        <td>100</td>
                        <td>30%</td>
                    </tr>
                  </tbody>
                </table>
              </div>
        </div>
    </div>

    <div class="col-md-12 inner-container">
        <div class="col-md-4 no-padding">
            <div id="region-chart" class="pie-chart"></div>
        </div>

        <div class="col-md-8 no-padding">
            <div class="table-responsive"> 
                <table class="table">
                  <thead>
                    <tr>
                      <th>Description</th>
                      <th>Total Number</th>
                      <th>Percentage</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                        <td>Region I</td>
                        <td>100</td>
                        <td>30%</td>
                    </tr>
                    <tr>
                        <td>Region II</td>
                        <td>100</td>
                        <td>30%</td>
                    </tr>
                    <tr>
                        <td>Region III</td>
                        <td>100</td>
                        <td>30%</td>
                    </tr>
                    <tr>
                        <td>Region IV</td>
                        <td>100</td>
                        <td>30%</td>
                    </tr>
                    <tr>
                        <td>Region V</td>
                        <td>100</td>
                        <td>30%</td>
                    </tr>
                  </tbody>
                </table>
              </div>
        </div>
    </div>

    <div class="col-md-12 inner-container">
        <div class="col-md-4 no-padding">
            <div id="division-chart" class="pie-chart"></div>
        </div>

        <div class="col-md-8 no-padding">
            <div class="table-responsive"> 
                <table class="table">
                  <thead>
                    <tr>
                      <th>Description</th>
                      <th>Total Number</th>
                      <th>Percentage</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                        <td>Division 1</td>
                        <td>100</td>
                        <td>30%</td>
                    </tr>
                    <tr>
                        <td>Division 2</td>
                        <td>100</td>
                        <td>30%</td>
                    </tr>
                    <tr>
                        <td>Division 3</td>
                        <td>100</td>
                        <td>30%</td>
                    </tr>
                    <tr>
                        <td>Division 4</td>
                        <td>100</td>
                        <td>30%</td>
                    </tr>
                  </tbody>
                </table>
              </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ elixir('js/all-highcharts.js') }}"></script>
@stop