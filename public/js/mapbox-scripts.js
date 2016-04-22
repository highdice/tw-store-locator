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

  var markers = new L.MarkerClusterGroup({
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
                    }
                });

  var map = L.mapbox.map('map', 'mapbox.light', { zoomControl: false, minZoom: 6, maxBounds: [[-90,-180],[90,180]] }).setView([13, 122], 6);//.addLayer(L.mapbox.tileLayer('highdice.cifqlknit704qsikqrqp3peuo', {continuousWorld: 'true'}));

  new L.Control.Zoom({ position: 'topright' }).addTo(map);

  //show all markers on load
  showMarkers();

  //show all markers
  function showMarkers(search, zoom) {
    $.ajax({
        url: "/api/v1/stores",
        type: "POST",
        data: {'search': search},
        success: function (data) {
            var count = data.length;
            for (var i = 0, len = count; i < len; i++) {
                var store = data[i];
                var code = store['code'];
                var branch_code = store['branch_code'];
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
                }).on('click', centerZoom);
                
                //set popup
                var popup = L.popup({
                  autoPan: true
                }).setContent('<div class="popup-header"><h1>'+name+'</h1><p>'+address+', '+region+'</p></div><div class="popup-body"><p>Store Code: '+code+'</p><p>Branch Code: '+branch_code+'</p><p>Trade Name: '+trade_name+'</p><p>Open From: 10:00 AM to 9:00 PM</p></div>');

                //bind popup to marker
                marker.bindPopup(popup, {
                  //closeButton: false,
                  minWidth: 320
                }).openPopup();

                //add markers to marker cluster group
                markers.addLayer(marker);
            }

            map.addLayer(markers);

            map.featureLayer.on('click', function(e) {
                map.panTo(e.layer.getLatLng());
            });
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
                  default: return {color: random_color(), opacity: 1, fillOpacity: 0.1, weight: 1};
              }
          },
          onEachFeature: function (feature, layer) {
          }
      });
  });
}

  function centerZoom(e) {
      map.setView(e.target.getLatLng());
  }

  function random_color(format)
  {
      var randomizer = Math.round(0xffffff * Math.random());
      return ('#0' + randomizer.toString(16)).replace(/^#0([0-9a-f]{6})$/i, '#$1');
  }

  /*
   * EVENTS
   */
  //event for searching location via main search input
  $('#search-button').on('click', function() {
    var data = document.getElementById('search-input').value;
    markers.clearLayers();
    showMarkers(data, 8);
  });

  $('#show-regions').on('click', function() {
      if (map.hasLayer(gj)) {
        map.removeLayer(gj);
      } else {
        map.addLayer(gj);
      }
  });
});