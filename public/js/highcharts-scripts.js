$(document).ready(function() {
    $('#historical-chart').highcharts({
        chart: {
            backgroundColor: 'rgba(255, 255, 255, 0)'
        },
        title: {
            text: 'Historical Chart',
            x: -20 //center
        },
        subtitle: {
            text: '',
            x: -20
        },
        credits: {
            enabled: false
        },
        xAxis: {
            categories: ['1985-1990', '1990-1995', '1995-2000', '2000-2005', '2005-2010', '2010-2015',
                '2015-2020']
        },
        yAxis: {
            title: {
                text: 'Number of Stores'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: ''
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
            name: 'Branch',
            data: [7.0, 6.0, 9.0, 14.0, 18.0, 21.0, 25.0]
        }, {
            name: 'Satellite',
            data: [3.0, 2.0, 5.0, 11.0, 17.0, 22.0, 24.0]
        }]
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
            text: 'Stores Per Island Group'
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
            text: 'Stores Per Region'
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
            text: 'Stores Per Division'
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