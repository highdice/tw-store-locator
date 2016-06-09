$(document).ready(function() {
    var colors = ['#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4', '#203c73', '#002f2f', '#d9a441', '#e2c7b5', '#7a1b36', '#FF6633', '#00B88A', '#3366FF'],
    default_color = '#d0d0d0',
    hchartSeriesOptions = [],
    igchartSeriesOptions = [],
    rchartSeriesOptions = [],
    dchartSeriesOptions = [],
    achartSeriesOptions = [],
    hchartCounter = 0,
    igchartCounter = 0,
    rchartCounter = 0,
    dchartCounter = 0,
    achartCounter = 0,
    hchart = ['Branch', 'Satellite'];

    Highcharts.setOptions({
        colors: colors
    });
    
    $.each(hchart, function (i, name) {
        $.ajax({
          dataType: "json",
          url: 'api/v1/stores/' + name.toLowerCase() + '/date_opened',
          beforeSend: function(xhr){
            xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
          },
          success: function (data) {
            hchartSeriesOptions[i] = {
                name: name,
                data: data
            };

            hchartCounter += 1;

            if (hchartCounter === hchart.length) {
                createHistoricalChart();
            }
          }
        });
    });

    $.ajax({
      dataType: "json",
      url: 'api/v1/stores/count',
      beforeSend: function(xhr){
        xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
      },
      success: function (data) {
        $('.branch-count').text(data);
      }
    });

    $.ajax({
      dataType: "json",
      url: 'api/v1/satellite/count',
      beforeSend: function(xhr){
        xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
      },
      success: function (data) {
        $('.satellite-count').text(data);
      }
    });

    $.ajax({
      dataType: "json",
      url: 'api/v1/users/count',
      beforeSend: function(xhr){
        xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
      },
      success: function (data) {
        $('.user-count').text(data);
      }
    });

    $.ajax({
      dataType: "json",
      url: 'api/v1/stores/island_groups',
      beforeSend: function(xhr){
        xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
      },
      success: function (data) {
        count = data.length;

        $.each(data, function (i, row) {
            var store_count = (row['store_count']) ? row['store_count'] : null,
            is_default = (store_count == null) ? 'legend-default' : '',
            color = (store_count == null) ? default_color : colors[i] ;

            $('.island-groups-table tbody').append('<tr>'
                            + '<td><div class="legend-icon legend-content ' + is_default + '" style="background: ' + color + ';"></div></td>'
                            + '<td>' + row['title'] + '</td>'
                            + '<td>' + row['store_count'] + '</td>'
                        + '</tr>');

            igchartSeriesOptions[i] = {
                name: row['title'],
                y: store_count
            };

            igchartCounter += 1;

            if (igchartCounter === count) {
                createPieChart('island-groups', igchartSeriesOptions);
            }
        });
      }
    });

    $.ajax({
      dataType: "json",
      url: 'api/v1/stores/regions',
      beforeSend: function(xhr){
        xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
      },
      success: function (data) {
        count = data.length;

        $.each(data, function (i, row) {
            var store_count = (row['store_count']) ? row['store_count'] : null,
            is_default = (store_count == null) ? 'legend-default' : '',
            color = (store_count == null) ? default_color : colors[i] ;

            $('.regions-table tbody').append('<tr>'
                            + '<td><div class="legend-icon legend-content ' + is_default + '" style="background: ' + color + ';"></div></td>'
                            + '<td>' + row['title'] + '</td>'
                            + '<td>' + row['store_count'] + '</td>'
                        + '</tr>');

            rchartSeriesOptions[i] = {
                name: row['title'],
                y: store_count
            };

            rchartCounter += 1;

            if (rchartCounter === count) {
                createPieChart('regions', rchartSeriesOptions);
            }
        });
      }
    });

    $.ajax({
      dataType: "json",
      url: 'api/v1/stores/divisions',
      beforeSend: function(xhr){
        xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
      },
      success: function (data) {
        count = data.length;

        $.each(data, function (i, row) {
            var store_count = (row['store_count']) ? row['store_count'] : null,
            is_default = (store_count == null) ? 'legend-default' : '',
            color = (store_count == null) ? default_color : colors[i] ;

            $('.divisions-table tbody').append('<tr>'
                            + '<td><div class="legend-icon legend-content ' + is_default + '" style="background: ' + color + ';"></div></td>'
                            + '<td>' + row['title'] + '</td>'
                            + '<td>' + row['store_count'] + '</td>'
                        + '</tr>');

            dchartSeriesOptions[i] = {
                name: row['title'],
                y: store_count
            };

            dchartCounter += 1;

            if (dchartCounter === count) {
                createPieChart('divisions', dchartSeriesOptions);
            }
        });
      }
    });

    $.ajax({
      dataType: "json",
      url: 'api/v1/stores/areas',
      beforeSend: function(xhr){
        xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
      },
      success: function (data) {
        count = data.length;

        $.each(data, function (i, row) {
            var store_count = (row['store_count']) ? row['store_count'] : null,
            is_default = (store_count == null) ? 'legend-default' : '',
            color = (store_count == null) ? default_color : colors[i];

            $('.areas-table tbody').append('<tr>'
                            + '<td><div class="legend-icon legend-content ' + is_default + '" style="background: ' + color + ';"></div></td>'
                            + '<td>' + row['title'] + '</td>'
                            + '<td>' + row['store_count'] + '</td>'
                        + '</tr>');

            achartSeriesOptions[i] = {
                name: row['title'],
                y: store_count
            };

            achartCounter += 1;

            if (achartCounter === count) {
                createPieChart('areas', achartSeriesOptions);
            }
        });
      }
    });

    function createHistoricalChart() {
        $('#historical-chart').highcharts({
            chart: {
                zoomType: 'x'
            },
            title: {
                text: ''
            },
            credits: {
                enabled: false
            },
            subtitle: {
                text: document.ontouchstart === undefined ?
                        'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in'
            },
            xAxis: {
                type: 'datetime'
            },
            yAxis: {
                title: {
                    text: 'Number of Stores'
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            plotOptions: {
                area: {
                    fillColor: {
                        linearGradient: {
                            x1: 0,
                            y1: 0,
                            x2: 0,
                            y2: 1
                        },
                        stops: [
                            [0, Highcharts.getOptions().colors[0]],
                            [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                        ]
                    },
                    marker: {
                        radius: 2
                    },
                    lineWidth: 1,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },
                    threshold: null
                }
            },
            series : hchartSeriesOptions
        });
    }

    function createPieChart(category, seriesOptions) {
        $('#' + category + '-chart').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                backgroundColor: 'rgba(255, 255, 255, 0)',
                type: 'pie'
            },
            title: {
                text: ''
            },
            credits: {
                enabled: false
            },
            legend: {
                enabled: false
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        verticalAlign: 'top',
                        format: '{point.percentage:.1f}%',
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        },
                        distance: -30
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Stores',
                colorByPoint: true,
                data: seriesOptions
            }]
        });
    }

    $('.show-count-container').on('click', function() {
        $('.sidebar-js-button').removeClass('active');
        $(this).addClass('active');
        $('html, body').animate({scrollTop: 0}, 200);
    });

    $('.show-historical-chart').on('click', function() {
        var position = $('.historical-chart-container').position();

        $('.sidebar-js-button').removeClass('active');
        $(this).addClass('active');
        $('html, body').animate({scrollTop: position.top + 50}, 200);
    });

    $('.show-island-groups-chart').on('click', function() {
        var position = $('.island-groups-chart-container').position();

        $('.sidebar-js-button').removeClass('active');
        $(this).addClass('active');
        $('html, body').animate({scrollTop: position.top + 50}, 200);
    });

    $('.show-regions-chart').on('click', function() {
        var position = $('.regions-chart-container').position();

        $('.sidebar-js-button').removeClass('active');
        $(this).addClass('active');
        $('html, body').animate({scrollTop: position.top + 50}, 200);
    });

    $('.show-divisions-chart').on('click', function() {
        var position = $('.divisions-chart-container').position();

        $('.sidebar-js-button').removeClass('active');
        $(this).addClass('active');
        $('html, body').animate({scrollTop: position.top + 50}, 200);
    });

    $('.show-area-chart').on('click', function() {
        var position = $('.area-chart-container').position();

        $('.sidebar-js-button').removeClass('active');
        $(this).addClass('active');
        $('html, body').animate({scrollTop: position.top + 50}, 200);
    });

    //finish loading
    finishedLoading();
});