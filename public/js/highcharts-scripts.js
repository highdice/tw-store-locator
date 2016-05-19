$(document).ready(function() {
    $(function () {
        $.getJSON('https://www.highcharts.com/samples/data/jsonp.php?filename=usdeur.json&callback=?', function (data) {

            $('#historical-chart').highcharts({
                chart: {
                    zoomType: 'x'
                },
                title: {
                    text: ''
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

                series: [{
                    name: 'Branch',
                    data: data
                }, {
                    name: 'Satellite',
                    data: [3.0, 2.0, 5.0, 11.0, 17.0, 22.0, 24.0]
                }]
            });
        });
    });

    $('#island-group-chart').highcharts({
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
            name: 'Brands',
            colorByPoint: true,
            data: [{
                name: 'Luzon',
                sliced: true,
                selected: true,
                y: 56
            }, {
                name: 'Visayas',
                y: 24
            }, {
                name: 'Mindanao',
                y: 10
            }]
        }]
    });

    $('#region-chart').highcharts({
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
            name: 'Brands',
            colorByPoint: true,
            data: [{
                name: 'Region I',
                y: 30
            }, {
                name: 'Region II',
                y: 25,
            }, {
                name: 'Region III',
                y: 10
            }, {
                name: 'Region IV',
                y: 20
            }]
        }]
    });

    $('#division-chart').highcharts({
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
            name: 'Brands',
            colorByPoint: true,
            data: [{
                name: 'Divison I',
                y: 50,
            }, {
                name: 'Divison II',
                y: 10
            }, {
                name: 'Divison III',
                y: 10
            }, {
                name: 'Divison IV',
                y: 20
            }]
        }]
    });

    //finish loading
    finishedLoading();
});

function requestData(url, type, data) {
    $.ajax({
        url: 'api/v1/stores/island_groups',
        type: "GET",
        dataType: "json",
        data : {},
        success: function(data) {
            chart.addSeries({
              name: "mentions",
              data: 1
            });
        },
        cache: false
    });
}