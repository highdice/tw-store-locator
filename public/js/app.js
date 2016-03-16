//INITIALIZATION
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

var loader = document.getElementById('loader');

startLoading();

var map = L.mapbox.map('map', 'mapbox.streets', { zoomControl: false, maxBounds: [[-90,-180],[90,180]] }).setView([13, 122], 5).on('load', finishedLoading());//.addLayer(L.mapbox.tileLayer('highdice.cifqlknit704qsikqrqp3peuo', {continuousWorld: 'true'}));

new L.Control.Zoom({ position: 'topright' }).addTo(map);

//show all markers on load
$(document).ready(function() {
  showMarkers(5);
});

//EVENTS
//event for searching location via main search input
$('#search-button').on('click', function() {
  var data = document.getElementById('search-input').value;
  startLoading();
  markers.clearLayers();
  showMarkers(8, data);
  finishedLoading();
});

//event for sidebar animation 
$('#sidebar li').on('click', function () {
  var container = $('#sidebar-content-container');
  var items = $('#sidebar li');
  var selected = $(this);

  items.removeClass('sidebar-item-active');
  selected.addClass('sidebar-item-active');

  if(container.is(':visible')) {
    if(selected.hasClass('selected')) {
      container.stop(false, true).toggle('slide', 200);
      selected.removeClass('selected');
      selected.removeClass('sidebar-item-active');
    }
    else {
      items.removeClass('selected');
      selected.addClass('selected');
    }
  }
  else {
    container.stop(false, true).toggle('slide', 200);
    selected.addClass('selected');
  }
});

//METHODS
//function to show all markers
function showMarkers(zoom, search) {
$.ajax({
    url: "/api/stores",
    type: "POST",
    dataType: 'json',
    data: {},
    success: function (data) {
       var points = {};
        points['type'] = 'FeatureCollection';
        points['features'] = [];

        var count = data.length;
        for (var i = 0, len = count; i < len; i++) {
            var store = data[i];
            var name = store['name'];
            var address = store['address'];
            var barangay = store['barangay'];
            var district = store['district'];
            var city = store['city'];
            var region = store['region'];

            var marker = L.marker(new L.LatLng(store['latitude'], store['longitude']), {
                icon: L.mapbox.marker.icon({
                            'marker-symbol': 'building',
                            'marker-size': 'large',
                            'marker-color': '0044FF'
                }),
                title: name
            });
            
            //set popup
            var popup = L.popup({
              autoPan: true
            }).setContent('<div style="text-align:center;padding:20px 10px 10px 10px;background:#aaa51d;color:white;width:100%;"><h1 style="font-size:25px;text-transform:uppercase;">'+name+'</h1><p style="color:#f8f48c;">'+address+', '+barangay+', '+district+', '+city+', '+region+'</p></div><div style="padding: 20px 15px 10px 15px;"><p>Opening Hours: 10:00 AM to 9:00 PM</p></div>');

            marker.bindPopup(popup, {
              //closeButton: false,
              minWidth: 320
            }).openPopup();

            markers.addLayer(marker);

            if(i == 0){
              var lat = store['latitude']; 
              var lng = store['longitude'];

              map.setView(new L.LatLng(store['latitude'], store['longitude']), zoom);
            }
        }

         map.addLayer(markers);
    },
    error: function (xhr, ajaxOptions, thrownError) { //Add these parameters to display the required response
    }
});
}

//function to start loading
function startLoading() {
    loader.className = '';
}

//function to end loading
function finishedLoading() {
    loader.className = 'done';
    setTimeout(function() {
        loader.className = 'hide';
    }, 300);
}