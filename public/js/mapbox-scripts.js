$(document).ready(function() {
  var zipLayer;
  var gj;
  var label;
  var marker_color = ['#203c73', '#002f2f', '#d9a441', '#e2c7b5', '#7a1b36', '#FF6633', '#00B88A', '#3366FF'];

  //initialize mapbox
  L.mapbox.accessToken = 'pk.eyJ1IjoiaGlnaGRpY2UiLCJhIjoiY2lmcWxrcDB6am05MXN4bTdiZGlzcWtzeiJ9.HowS8sLtivG7hhhcWYZdig';

  var map = L.mapbox.map('map', 'mapbox.light', { zoomControl: false, minZoom: 6, maxBounds: [[-90,-180],[90,180]] }).setView([13, 122], 6);

  new L.Control.Zoom({ position: 'topright' }).addTo(map);

  $.getJSON('/js/regions.50m.json', function(data) {
      //zipLayer = L.mapbox.featureLayer(data);

      gj = L.geoJson(data, {
          style: function(feature) {
              switch (feature.properties.name) {
                  case 'Ilocos Region (Region I)': return {color: marker_color[0], opacity: 1, fillOpacity: 0.1, weight: 1};
                  case 'Cagayan Valley (Region II)': return {color: marker_color[1], opacity: 1, fillOpacity: 0.1, weight: 1};
                  case 'Central Luzon (Region III)': return {color: marker_color[2], opacity: 1, fillOpacity: 0.1, weight: 1};
                  case 'CALABARZON (Region IV-A)': return {color: marker_color[3], opacity: 1, fillOpacity: 0.1, weight: 1};
                  case 'MIMAROPA (Region IV-B)': return {color: marker_color[4], opacity: 1, fillOpacity: 0.1, weight: 1};
                  case 'Western Visayas (Region VI)': return {color: marker_color[5], opacity: 1, fillOpacity: 0.1, weight: 1};
                  case 'Caraga (Region XIII)': return {color: marker_color[6], opacity: 1, fillOpacity: 0.1, weight: 1};
                  default: return {color: randomColor(), opacity: 1, fillOpacity: 0.1, weight: 1};
              }
          },
          onEachFeature: function (feature, layer) {
          }
      });
  });

  function getGroup(category, callback) {
    $.ajax({
        url: "/api/v1/stores/" + category,
        type: "GET",
        success: function (data) {
            callback(data);
        },
        error: function (xhr, ajaxOptions, thrownError) { //Add these parameters to display the required response
        }
    });
  }

  function insertMarkers(category, id, group, color, callback) {
    $.ajax({
        url: "/api/v1/stores/" + category + "/" + id,
        type: "GET",
        success: function (data) {
          var count = data.length;

          if (count != 0) {
            for (var i = 0, len = count; i < len; i++) {
              var store = data[i];
              var code = store['code'];
              var branch_code = store['branch_code'];
              var trade_name_prefix = store['trade_name_prefix'];
              var trade_name = store['trade_name'];
              var name = store['name'];
              var address = store['address'];
              var region = store['region'];
              var island_group = store['island_group'];

              //set icon
              var icon = L.mapbox.marker.icon({
                  'marker-size': 'large',
                  'marker-symbol': 'circle-stroked',
                  'marker-color': color
              });

              //add markers
              var marker = L.marker(new L.LatLng(store['latitude'], store['longitude']), {
                  icon: icon,
                  title: name
              });

              //add marker onclick event
              marker.on('click', centerZoom(marker, code));

              //set popup
              var popup = L.popup({
                autoPan: true
              }).setContent('<div class="popup-header"><h1>'+name+'</h1><p>'+address+', '+region+'</p></div><div class="popup-body"><p>Store Code: '+code+'</p><p>Branch Code: '+branch_code+'</p><p>Trade Name: '+trade_name+'</p><p>Open From: 10:00 AM to 9:00 PM</p></div>');

              //bind popup to marker
              marker.bindPopup(popup, {
                //closeButton: false,
                minWidth: 320
              }).openPopup();

              //create result list and add onclick event
              var item = $('<li id="result-item-' + code + '" class="sidebar-js-button result-item result-category-' + id + '"><i class="glyphicon glyphicon-th"></i>' + name + '<i class="fa fa-btn fa-check-circle selected hidden"></i></li>');
              var list = $('#result-list').append(item);
              item.click(resultZoom(marker, code));

              //add markers to marker cluster group
              group.addLayer(marker);
            }
          }

          callback();
        },
        error: function (xhr, ajaxOptions, thrownError) { //Add these parameters to display the required response
        }
    });
  }

  //show all markers
  function showMarkers(search, zoom) {
      /*
      var group = new L.MarkerClusterGroup({
                    polygonOptions: {
                        fillColor: '#3887be',
                        color: '#3887be',
                        weight: 2,
                        opacity: 0.7,
                        fillOpacity: 0.3
                    },
                    iconCreateFunction: function(cluster) {
                      return L.mapbox.marker.icon({
                        'marker-size': 'large',
                        'marker-symbol': cluster.getChildCount(),
                        'marker-color': '#545cef'
                      });
                    },
                    zoomToBoundsOnClick: true
                });
      */

      $.ajax({
          url: "/api/v1/stores",
          type: "POST",
          data: {'search': search},
          success: function (data) {
              var count = data.length;
              $('#result-count').text(count);

              if (count != 0) {
                for (var i = 0, len = count; i < len; i++) {
                    var store = data[i];
                    var code = store['code'];
                    var branch_code = store['branch_code'];
                    var trade_name_prefix = store['trade_name_prefix'];
                    var trade_name = store['trade_name'];
                    var name = store['name'];
                    var address = store['address'];
                    var region = store['region'];
                    var island_group = store['island_group'];

                    //set icon
                    var icon = L.icon({
                                  iconUrl: '/build/css/images/tomsworld-marker-min.png',
                                  iconSize: [52, 77],
                                  iconAnchor: [26, 33.5],
                                  popupAnchor: [0, -40]
                                });

                    //add markers
                    var marker = L.marker(new L.LatLng(store['latitude'], store['longitude']), {
                        icon: icon,
                        title: name
                    });

                    //add marker onclick event
                    marker.on('click', centerZoom(marker, i));

                    //set popup
                    var popup = L.popup({
                      autoPan: true
                    }).setContent('<div class="popup-header"><h1>'+name+'</h1><p>'+address+', '+region+'</p></div><div class="popup-body"><p>Store Code: '+code+'</p><p>Branch Code: '+branch_code+'</p><p>Trade Name: '+trade_name+'</p><p>Open From: 10:00 AM to 9:00 PM</p></div>');

                    //bind popup to marker
                    marker.bindPopup(popup, {
                      //closeButton: false,
                      minWidth: 320
                    }).openPopup();

                    //create result list and add onclick event
                    var item = $('<li id="result-item-' + i + '" class="sidebar-js-button result-item"><i class="glyphicon glyphicon-th"></i>' + name + '<i class="fa fa-btn fa-check-circle selected hidden"></i></li>');
                    var list = $('#result-list').append(item);
                    item.click(resultZoom(marker, i));

                    //add markers to marker cluster group
                    //group.addLayer(marker);

                    //pan to marker if count is only one
                    if(count == 1) {
                      resultItemAnimation(i);

                      map.setView(marker.getLatLng(), 12);
                      marker.openPopup();
                    }

                    map.addLayer(marker);
                }
              }
              else {
                var item = $('<li class="sidebar-js-button result-item none">No records found</li>');
                var list = $('#result-list').append(item);
              }
              //map.addLayer(group);
          },
          error: function (xhr, ajaxOptions, thrownError) { //Add these parameters to display the required response
          }
      });
  }

  function showMarkersByCategory(category) {
    //reset sidebar and result
    reset();

    //clear all layers and set to default location and zoom
    map.setView([13, 122], 6);
    clearAllLayers();

    getGroup(category, function(data) {
      //show result dropdown
      $('.result-dropdown select').show();
      for (var i = 0, len = data.length; i < len; i++) {
        $('.result-dropdown select').append('<option value="' + data[i]['id'] + '">' + data[i]['description'] + '</option>');
      }

      //add markers to every group
      asyncLoop(data.length, function(loop) {
        var index = loop.iteration();
        var group = new L.MarkerClusterGroup({
                  iconCreateFunction: function(cluster) {
                    return L.mapbox.marker.icon({
                      'marker-size': 'large',
                      'marker-symbol': cluster.getChildCount(),
                      'marker-color': marker_color[index]
                    });
                  },
                  zoomToBoundsOnClick: true,
                  spiderfyOnMaxZoom: true
              });

        insertMarkers(category, data[index]['id'], group, marker_color[index], function(result) {
            map.addLayer(group);
            loop.next();
        })}, function(){
          $('#locator-loader').hide();
          $('.result-body').show();
      });
    });
  }

  function resultZoom(e, i){
    return function(){
      resultItemAnimation(i);

      map.setView(e.getLatLng(), 12);
      e.openPopup();
    }
  }

  function centerZoom(e, i) {
    return function(){
      resultItemAnimation(i);

      //map.setView(e.getLatLng(), 12);
    }
  }

  function resultItemAnimation(i) {
    $('.result-item .selected').addClass('hidden');
    $('#result-item-' + i + ' .selected').removeClass('hidden');
  }

  function randomColor(format) {
      var randomizer = Math.round(0xffffff * Math.random());
      return ('#0' + randomizer.toString(16)).replace(/^#0([0-9a-f]{6})$/i, '#$1');
  }

  function clearAllLayers() {
    map.eachLayer(function(layer) {
      if (layer instanceof L.MarkerClusterGroup || layer instanceof L.Marker) {
        map.removeLayer(layer);
      }
    });
  }

  function reset() {
    $('#locator-loader').show();
    $('.sidebar-js-button').removeClass('active');
    $('.result-body').hide();
    $('#result-list').html('');
    $('.result-dropdown select').html('');
  }

  function asyncLoop(iterations, func, callback) {
    var index = 0;
    var done = false;
    var loop = {
        next: function() {
            if (done) {
                return;
            }

            if (index < iterations) {
                index++;
                func(loop);

            } else {
                done = true;
                callback();
            }
        },

        iteration: function() {
            return index - 1;
        },

        break: function() {
            done = true;
            callback();
        }
    };
    loop.next();
    return loop;
  }

  /**
   * EVENTS
   */

  //event for searching a marker upon hitting enter 
  $('#search-input').on('keydown', function(e) {
    if(e.keyCode == 13) {
      var data = document.getElementById('search-input').value;
      if(data.length != 0) {
        $('.sidebar-js-button').removeClass('active');
        $('.result-dropdown select').hide();
        $('.result-dropdown select').html('');
        $('#result-list').html('');
        clearAllLayers();
        showMarkers(data, 8);
      }
    }
  });

  //event for searching a marker on search button click
  $('#search-button').on('click', function() {
      var data = document.getElementById('search-input').value;
      if(data.length != 0) {
        $('.sidebar-js-button').removeClass('active');
        $('.result-dropdown select').hide();
        $('.result-dropdown select').html('');
        $('#result-list').html('');
        clearAllLayers();
        showMarkers(data, 8);
      }
  });

  $('#show-regions').on('click', function() {
    showMarkersByCategory('regions');
    $(this).addClass('active');
  });

  $('#show-island-groups').on('click', function() {
    showMarkersByCategory('island_groups');
    $(this).addClass('active');
  });

  $('.result-dropdown select').on('change', function() {
    $('.result-item').hide();
    $('.result-category-' + $(this).val()).show();
  });

  //create marker groups
  //createGroups();

  //show all markers on load
  showMarkers();
});