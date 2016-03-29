$(document).ready(function() {
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

  var map = L.mapbox.map('map', 'mapbox.streets', { zoomControl: false, maxBounds: [[-90,-180],[90,180]] }).setView([13, 122], 5);//.addLayer(L.mapbox.tileLayer('highdice.cifqlknit704qsikqrqp3peuo', {continuousWorld: 'true'}));

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
                var name = store['name'];
                var address = store['address'];
                var region = store['region'];
                var island_group = store['island_group'];

                var icon_color = '#0044FF';
                if(island_group == '2') { icon_color = '#D635AC'; }
                if(island_group == '3') { icon_color = '#DC3A3A'; }

                //set icon
                var icon = L.mapbox.marker.icon({
                              'marker-symbol': 'circle-stroked',
                              'marker-size': 'large',
                              'marker-color': icon_color
                            })

                //add markers
                var marker = L.marker(new L.LatLng(store['latitude'], store['longitude']), {
                    icon: icon,
                    title: name
                });
                
                //set popup
                var popup = L.popup({
                  autoPan: true
                }).setContent('<div class="popup-header"><h1>'+name+' - '+island_group+'</h1><p>'+address+', '+region+'</p></div><div class="popup-body"><p>Opening Hours: 10:00 AM to 9:00 PM</p></div>');

                //bind popup to marker
                marker.bindPopup(popup, {
                  //closeButton: false,
                  minWidth: 320
                }).openPopup();

                //add markers to marker cluster group
                markers.addLayer(marker);
            }

             map.addLayer(markers);
        },
        error: function (xhr, ajaxOptions, thrownError) { //Add these parameters to display the required response
        }
    });
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
});