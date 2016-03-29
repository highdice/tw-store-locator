@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Dashboard</h3>
    <hr />

    <div id="historical-chart" class="line-chart"></div>

    <div class="col-md-4 chart-container">
        <div id="island-group-chart" class="pie-chart"></div>
    </div>

    <div class="col-md-4 chart-container">
        <div id="region-chart" class="pie-chart"></div>
    </div>

    <div class="col-md-4 chart-container">
        <div id="division-chart" class="pie-chart"></div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ elixir('js/all-highcharts.js') }}"></script>
@stop