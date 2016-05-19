$(document).ready(function() {
  /**
   * Set global variables
   */
  var zipLayer,
  gj,
  label,
  marker_color = ['#203c73', '#002f2f', '#d9a441', '#e2c7b5', '#7a1b36', '#FF6633', '#00B88A', '#3366FF'];

  /**
   * Initialize mapbox
   */
  L.mapbox.accessToken = 'pk.eyJ1IjoiaGlnaGRpY2UiLCJhIjoiY2lmcWxrcDB6am05MXN4bTdiZGlzcWtzeiJ9.HowS8sLtivG7hhhcWYZdig';
  var map = L.mapbox.map('map', 'mapbox.light', { zoomControl: false, minZoom: 6, maxBounds: [[-90,-180],[90,180]] }).setView([13, 122], 6);

  /**
   * Add zoom control with 0.5 sec delay
   */
  setTimeout(function() {
    new L.Control.Zoom({ position: 'topright' }).addTo(map);
  }, 500);

  /**
   * Add legend control then hide on load
   */
  map.legendControl.addLegend(document.getElementById('legend').innerHTML).setPosition('topleft');
  $('.map-legends, #result-container').hide();
  
  /**
   * Get regions geojson and add to gj variable
   */
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

  /**
   * Get marker grouping
   * @param {string} category, {undefined} callback
   * @return {object} data
   */
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

  /**
   * Insert markers to corresponding group
   * @param {string} category, {number} id, {object} group, {string} color, {undefined} callback
   */
  function insertMarkers(category, id, group, color, callback) {
    $.ajax({
        url: "/api/v1/stores/" + category + "/" + id,
        type: "GET",
        success: function (data) {
          var count = data.length;

          if (count != 0) {
            for (var i = 0, len = count; i < len; i++) {
              var store = data[i],
              code = store['code'],
              store_code = store['store_code'],
              trade_name_prefix = store['trade_name_prefix'],
              trade_name = store['trade_name'],
              name = store['name'],
              address = store['address'],
              region = store['region'],
              island_group = store['island_group'];
              store_category = store['category'];

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
              }).setContent('<div class="popup-header">'
                              +'<h1>'+name+'</h1>'
                              +'<p>'+address+', '+region+'</p>'
                            +'</div>'
                            +'<div class="popup-body">'
                              +'<p>Store Code: '+code+'</p>'
                              +'<p>Branch Code: '+store_code+'</p>'
                              +'<p>Trade Name: '+trade_name+'</p>'
                              +'<p>Open From: 10:00 AM to 9:00 PM</p>'
                            +'</div>');

              //bind popup to marker
              marker.bindPopup(popup, {
                //closeButton: false,
                minWidth: 320
              }).openPopup();

              //create result list and add onclick event
              var item_id = id + "-" + i;
              var item = $('<li id="result-item-' + item_id + '" class="sidebar-js-button result-item result-category-' + id + '"><i class="glyphicon glyphicon-th"></i>' + name + '<i class="fa fa-btn fa-check-circle selected hidden"></i></li>');
              var list = $('#result-list').append(item);
              item.click(resultZoom(marker, item_id));

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

  /**
   * Show all markers
   * @param {string} search, {number} zoom, {string} category
   */
  function showMarkers(search, zoom, category) {
      //reset sidebar and result
      reset();

      //clear all layers
      clearAllLayers();

      $.ajax({
          url: "/api/v1/stores",
          type: "POST",
          data: {'search': search, 'category': category},
          success: function (data) {
            var count = data.length,
            tw_id = 23,
            tw_color = '#BB3535',
            tw_description = "Tom's World",
            tw_count = 0,
            al_id = 24,
            al_color = '#35BB41',
            al_description = "Austin Land",
            al_count = 0,
            jp_id = 25,
            jp_color = '#B8BB35',
            jp_description = "Joy's Planet",
            jp_count = 0;

            //show result dropdown
            $('.result-dropdown select').show();
              
            //add markers
            asyncLoop(count, function(loop) {
              var i = loop.iteration();
              var store = data[i],
              code = store['code'],
              store_code = store['store_code'],
              trade_name_prefix = store['trade_name_prefix'],
              trade_name = store['trade_name'],
              name = store['name'],
              address = store['address'],
              region = store['region'],
              island_group = store['island_group'],
              store_category = store['category'];

              var color,
              legend_description;

              if(trade_name == 23) {
                color = tw_color;
                legend_description = tw_description;
                tw_count++;
              }
              else if(trade_name == 24) {
                color = al_color;
                legend_description = al_description;
                al_count++;
              }
              else {
                color = jp_color;
                legend_description = jp_description;
                jp_count++;
              }

              //set icon
              /* var icon = L.icon({
                            iconUrl: '/build/css/images/tomsworld-marker-min.png',
                            iconSize: [52, 77],
                            iconAnchor: [26, 33.5],
                            popupAnchor: [0, -40]
                          }); */

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
              marker.on('click', centerZoom(marker, i));

              //set popup
              var popup = L.popup({
                autoPan: true
              }).setContent('<div class="popup-header">'
                              +'<h1>'+name+'</h1>'
                              +'<p>'+address+', '+region+'</p>'
                            +'</div>'
                            +'<div class="popup-body">'
                              +'<p>Store Code: '+code+'</p>'
                              +'<p>Branch Code: '+store_code+'</p>'
                              +'<p>Trade Name: '+trade_name+'</p>'
                              +'<p>Open From: 10:00 AM to 9:00 PM</p>'
                            +'</div>');

              //bind popup to marker
              marker.bindPopup(popup, {
                //closeButton: false,
                minWidth: 320
              }).openPopup();

              //create result list and add onclick event
              var item = $('<li id="result-item-' + i + '" class="sidebar-js-button result-item result-category-' + trade_name + '"><i class="glyphicon glyphicon-th"></i>' + name + '<i class="fa fa-btn fa-check-circle selected hidden"></i></li>');
              var list = $('#result-list').append(item);
              item.click(resultZoom(marker, i));

              map.addLayer(marker);

              loop.next();

            }, function(){
                //pan to marker if count is only one
                if(count == 1) {
                  resultItemAnimation(0);

                  map.setView(marker.getLatLng(), 12);
                  marker.openPopup();
                }
                else {
                  //clear all layers and set to default location and zoom
                  map.setView([13, 122], 6);
                }

                //set legends
                setLegend(tw_color, tw_description, tw_count);
                setLegend(al_color, al_description, al_count);
                setLegend(jp_color, jp_description, jp_count);

                $('.result-dropdown select').append('<option value="' + tw_id + '">' + tw_description + '</option>')
                                            .append('<option value="' + al_id + '">' + al_description + '</option>')
                                            .append('<option value="' + jp_id + '">' + jp_description + '</option>');
                
                //hide loader, show result and legend containers
                $('#locator-loader').hide();
                $('.result-body').show();
                $('.legend-inner-container').show();
            });

          },
          error: function (xhr, ajaxOptions, thrownError) { //Add these parameters to display the required response
          }
      });

  }

  /**
   * Show markers by category
   * @param {string} category
   */
  function showMarkersByCategory(category) {
    //reset sidebar and result
    reset();

    //clear all layers and set to default location and zoom
    map.setView([13, 122], 6);
    clearAllLayers();

    getGroup(category, function(data) {
      //show result dropdown
      $('.result-dropdown select').show();

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

        setLegend(marker_color[index], data[index]['title'], data[index]['store_count']);

        if(data[index]['store_count'] > 0) {
          $('.result-dropdown select').append('<option value="' + data[index]['id'] + '">' + data[index]['description'] + '</option>');
        }

        insertMarkers(category, data[index]['id'], group, marker_color[index], function(result) {
            map.addLayer(group);
            loop.next();
        })}, function(){
          $('#locator-loader').hide();
          $('.result-body').show();
          $('.legend-inner-container').show();
      });
    });
  }

  /**
   * Set legend
   * @param {string} color, {string} description, {number} count
   */
  function setLegend(color, description, count) {
    $('.legend-body').append('<tr><td><div class="legend-icon legend-content" style="background: ' + color + ';"></div></td><td>' + description + '</td><td>' + count + '</td></tr>');
  }

  /**
   * Set result animation, zoom level, and map view
   * @param {object} e, {number|string} i
   */
  function resultZoom(e, i){
    return function(){
      resultItemAnimation(i);

      map.setView(e.getLatLng(), 12);
      e.openPopup();
    }
  }

  /**
   * Set animation
   * @param {object} e, {number|string} i
   */
  function centerZoom(e, i) {
    return function(){
      resultItemAnimation(i);

      //map.setView(e.getLatLng(), 12);
    }
  }

  /**
   * Animation for result items 
   * @param {number} i
   */
  function resultItemAnimation(i) {
    $('.result-item .selected').addClass('hidden');
    $('#result-item-' + i + ' .selected').removeClass('hidden');
  }

  /**
   * Random color generator
   * @param {string} format
   * @return {string}
   */
  function randomColor(format) {
      var randomizer = Math.round(0xffffff * Math.random());
      return ('#0' + randomizer.toString(16)).replace(/^#0([0-9a-f]{6})$/i, '#$1');
  }

  /**
   * Handles clearing of layers
   */
  function clearAllLayers() {
    map.eachLayer(function(layer) {
      if (layer instanceof L.MarkerClusterGroup || layer instanceof L.Marker) {
        map.removeLayer(layer);
      }
    });
  }

  /**
   * Reset sidebar, loader, and result
   */
  function reset() {
    $('#locator-loader').show();
    $('.sidebar-js-button').removeClass('active');
    $('.result-body').hide();
    $('.legend-inner-container').hide();
    $('.legend-body').html('');
    $('#result-list').html('');
    $('.result-dropdown select').html('');
  }

  /**
   * Aynchronous loop
   * @param {number} iterations, {function} func, {undefined} callback
   * @return {function} loop
   */
  function asyncLoop(iterations, func, callback) {
    var index = 0,
    done = false,
    loop = {
        next: function() {
          if(done) {
            return;
          }
          if(index < iterations) {
            index++;
            func(loop);
          }
          else {
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
   * Event for searching a marker upon hitting enter
   */
  $('#search-input').on('keydown', function(e) {
    if(e.keyCode == 13) {
      clearAllLayers();
      $('.sidebar-js-button').removeClass('active');
      $('.result-dropdown select').hide();
      $('.result-dropdown select').html('');
      $('#result-list').html('');
      $('.legend-body').html('');

      var data = document.getElementById('search-input').value;
      if(data.length != 0) {
        showMarkers(data, 8);
      }
      else {
        showMarkers();
      }
    }
  });

  /**
   * Event for searching a marker on search button click
   */
  $('#search-button').on('click', function() {
      clearAllLayers();
      $('.sidebar-js-button').removeClass('active');
      $('.result-dropdown select').hide();
      $('.result-dropdown select').html('');
      $('#result-list').html('');
      $('.legend-body').html('');

      var data = document.getElementById('search-input').value;
      if(data.length != 0) {
        showMarkers(data, 8);
      }
      else {
        showMarkers();
      }
  });

  /**
   * Event for showing markers based on region
   */
  $('#show-regions').on('click', function() {
    showMarkersByCategory('regions');
    $(this).addClass('active');
  });

  /**
   * Event for showing markers based on island groups
   */
  $('#show-island-groups').on('click', function() {
    showMarkersByCategory('island_groups');
    $(this).addClass('active');
  });

  /**
   * Event for showing markers based on branches
   */
  $('#show-branches').on('click', function() {
    showMarkers(undefined, undefined, 'branch');
    $(this).addClass('active');
  });

  /**
   * Event for showing markers based on satellites
   */
  $('#show-satellites').on('click', function() {
    showMarkers(undefined, undefined, 'satellite');
    $(this).addClass('active');
  });

  /**
   * Event for result dropdown on change
   */
  $('.result-dropdown select').on('change', function() {
    $('.result-item').addClass('hidden');
    $('.result-category-' + $(this).val()).removeClass('hidden');
  });

  /**
   * Show all markers on load
   */
  showMarkers();
});