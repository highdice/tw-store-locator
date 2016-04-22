@extends('layouts.app')

@section('content')
<aside>
    <div id="sidebar" class="col-lg-1 col-md-2 col-sm-2 hidden-xs">
        <p>CHARTS</p>
        <ul>
            <li id="sidebar-result" class="sidebar-js-button active">
                <i class="glyphicon glyphicon-stats"></i>
                Charts
            </li>
        </ul>
    </div>
</aside>

<div class="col-lg-offset-1 col-lg-11 col-md-offset-2 col-lg-10 col-sm-offset-2 col-sm-10 no-padding">
    <div class="page-title-container">
        <h3>Dashboard</h3>
        <p>Lorem ipsum dolor kismet akhmet</p>
    </div>

    <div class="col-md-12 inner-container">
        <div id="historical-chart" class="line-chart"></div>
    </div>

    <div class="col-md-12 inner-container">
        <div class="col-md-4 no-padding">
            <div id="island-group-chart" class="pie-chart"></div>
        </div>

        <div class="col-md-4 no-padding">
            <div id="region-chart" class="pie-chart"></div>
        </div>

        <div class="col-md-4 no-padding">
            <div id="division-chart" class="pie-chart"></div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ elixir('js/all-highcharts.js') }}"></script>
@stop