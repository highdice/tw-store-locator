$(document).ready(function() {
  var zipLayer;
  var gj;
  var label;

  var region1_swatch = '#e74c3c';
  var region2_swatch = '#167439';
  var region3_swatch = '#e8522e';
  var region4a_swatch = '#b81a41';
  var region4b_swatch = '#f5812a';
  var region6_swatch = '#3498db';
  var region9_swatch = '#ffb32f';

  //initialize mapbox
  L.mapbox.accessToken = 'pk.eyJ1IjoiaGlnaGRpY2UiLCJhIjoiY2lmcWxrcDB6am05MXN4bTdiZGlzcWtzeiJ9.HowS8sLtivG7hhhcWYZdig';

  var map = L.mapbox.map('map', 'mapbox.light', { zoomControl: false, minZoom: 6, maxBounds: [[-90,-180],[90,180]] }).setView([13, 122], 6);

  new L.Control.Zoom({ position: 'topright' }).addTo(map);

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

  function insertMarkers(category, id, group, callback) {
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

              var icon_color = '#0044FF';
              if(island_group == '2') { icon_color = '#D635AC'; }
              if(island_group == '3') { icon_color = '#DC3A3A'; }

              //set icon
              var icon = L.icon({
                            iconUrl: '/build/css/images/tomsworld-marker-min.png',
                            iconSize: [52, 77],
                            iconAnchor: [26, 33.5],
                            popupAnchor: [0, -40]
                          })

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
              var item = $('<li id="result-item-' + code + '" class="sidebar-js-button result-item"><i class="glyphicon glyphicon-th"></i>' + name + '<i class="fa fa-btn fa-check-circle selected hidden"></i></li>');
              var list = $('#result-list').append(item);
              item.click(resultZoom(marker, code));

              //add markers to marker cluster group
              group.addLayer(marker);

              //pan to marker if count is only one
              if(count == 1) {
                resultItemAnimation(code);

                map.setView(marker.getLatLng(), 12);
                marker.openPopup();
              }
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
                        //'marker-symbol': 'bus',
                        'marker-symbol': cluster.getChildCount(),
                        'marker-color': '#545cef'
                      });
                    },
                    zoomToBoundsOnClick: true
                });

      $.ajax({
          url: "/api/v1/stores",
          type: "POST",
          data: {'search': search},
          success: function (data) {
              var count = data.length;
              $('#result-count').text(count);

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

                  var icon_color = '#0044FF';
                  if(island_group == '2') { icon_color = '#D635AC'; }
                  if(island_group == '3') { icon_color = '#DC3A3A'; }

                  //set icon
                  var icon = L.icon({
                                iconUrl: '/build/css/images/tomsworld-marker-min.png',
                                iconSize: [52, 77],
                                iconAnchor: [26, 33.5],
                                popupAnchor: [0, -40]
                              })

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
                  group.addLayer(marker);
                  //createGroup(marker, region);

                  //pan to marker if count is only one
                  if(count == 1) {
                    resultItemAnimation(i);

                    map.setView(marker.getLatLng(), 12);
                    marker.openPopup();
                  }
              }

              map.addLayer(group);
          },
          error: function (xhr, ajaxOptions, thrownError) { //Add these parameters to display the required response
          }
      });

      $.getJSON('/js/regions.50m.json', function(data) {
        //zipLayer = L.mapbox.featureLayer(data);

        gj = L.geoJson(data, {
            style: function(feature) {
                switch (feature.properties.name) {
                    case 'Ilocos Region (Region I)': return {color: region1_swatch, opacity: 1, fillOpacity: 0.1, weight: 1};
                    case 'Cagayan Valley (Region II)': return {color: region2_swatch, opacity: 1, fillOpacity: 0.1, weight: 1};
                    case 'Central Luzon (Region III)': return {color: region3_swatch, opacity: 1, fillOpacity: 0.1, weight: 1};
                    case 'CALABARZON (Region IV-A)': return {color: region4a_swatch, opacity: 1, fillOpacity: 0.1, weight: 1};
                    case 'MIMAROPA (Region IV-B)': return {color: region4b_swatch, opacity: 1, fillOpacity: 0.1, weight: 1};
                    case 'Western Visayas (Region VI)': return {color: region6_swatch, opacity: 1, fillOpacity: 0.1, weight: 1};
                    case 'Caraga (Region XIII)': return {color: region9_swatch, opacity: 1, fillOpacity: 0.1, weight: 1};
                    default: return {color: randomColor(), opacity: 1, fillOpacity: 0.1, weight: 1};
                }
            },
            onEachFeature: function (feature, layer) {
            }
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

      map.setView(e.getLatLng(), 12);
    }
  }

  function resultItemAnimation(i) {
    $('.result-item .selected').addClass('hidden');
    $('#result-item-' + i + ' .selected').removeClass('hidden');
  }

  function randomColor(format)
  {
      var randomizer = Math.round(0xffffff * Math.random());
      return ('#0' + randomizer.toString(16)).replace(/^#0([0-9a-f]{6})$/i, '#$1');
  }

  function clearAllLayers() {
    map.eachLayer(function(layer) {
      if (layer instanceof L.MarkerClusterGroup) {
        map.removeLayer(layer);
      }
    });
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
      $('.sidebar-js-button').removeClass('active');
      $('#result-list').html('');
      var data = document.getElementById('search-input').value;
      clearAllLayers();
      showMarkers(data, 8);
    }
  });

  //event for searching a marker on search button click
  $('#search-button').on('click', function() {
      $('.sidebar-js-button').removeClass('active');
      $('#result-list').html('');
      var data = document.getElementById('search-input').value;
      clearAllLayers();
      showMarkers(data, 8);
  });

  $('#show-regions').on('click', function() {
      //reset sidebar and result list
      $('.sidebar-js-button').removeClass('active');
      $(this).addClass('active');
      $('#result-list').html('');

      //for category color separator
      //if (map.hasLayer(gj)) {
      //  map.removeLayer(gj);
      //} else {
      //  map.addLayer(gj);
      //}

      clearAllLayers();

      color = ['#6633FF', '#CC33FF', '#FF33CC', '#FF3366', '#F5003D', '#FF6633', '#00B88A', '#3366FF'];

      var category = 'regions'
      getGroup(category, function(data) {
        asyncLoop(data.length, function(loop) {
          var index = loop.iteration();
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
                        'marker-color': color[index]
                      });
                    },
                    zoomToBoundsOnClick: true,
                    spiderfyOnMaxZoom: true
                });

          insertMarkers(category, data[index]['id'], group, function(result) {
              map.addLayer(group);
              loop.next();
          })}, function(){
            console.log('cycle ended')
        });
      });

  });

  //create marker groups
  //createGroups();

  //show all markers on load
  showMarkers();
});