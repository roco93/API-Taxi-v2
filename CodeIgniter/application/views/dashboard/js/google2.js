
var map, heatmap;

function initMap() {
  map = new google.maps.Map(document.getElementById('map2'), {
     center: {lat: 19.42, lng: -99.138},
    zoom: 11,
  <!--  mapTypeId: google.maps.MapTypeId.SATELLITE -->
  });

  heatmap = new google.maps.visualization.HeatmapLayer({
    data: getPoints(),
    map: map
  });

var mapsolo;
mapsolo = new google.maps.Map(document.getElementById('map'), {
    center: {lat: 19.42, lng: -99.138},
    zoom: 11
  });

}








function toggleHeatmap() {
  heatmap.setMap(heatmap.getMap() ? null : map);
}

function changeGradient() {
  var gradient = [
    'rgba(0, 255, 255, 0)',
    'rgba(0, 255, 255, 1)',
    'rgba(0, 191, 255, 1)',
    'rgba(0, 127, 255, 1)',
    'rgba(0, 63, 255, 1)',
    'rgba(0, 0, 255, 1)',
    'rgba(0, 0, 223, 1)',
    'rgba(0, 0, 191, 1)',
    'rgba(0, 0, 159, 1)',
    'rgba(0, 0, 127, 1)',
    'rgba(63, 0, 91, 1)',
    'rgba(127, 0, 63, 1)',
    'rgba(191, 0, 31, 1)',
    'rgba(255, 0, 0, 1)'
  ]
  heatmap.set('gradient', heatmap.get('gradient') ? null : gradient);
}

function changeRadius() {
  heatmap.set('radius', heatmap.get('radius') ? null : 20);
}

function changeOpacity() {
  heatmap.set('opacity', heatmap.get('opacity') ? null : 0.2);
}

// Heatmap data: 500 Points
function getPoints() {
  return [
    new google.maps.LatLng(19.4321, -99.12),
    new google.maps.LatLng(19.4321, -99.126),
    new google.maps.LatLng(19.4321, -99.126),
    new google.maps.LatLng(19.4321, -99.126),
    new google.maps.LatLng(19.4321, -99.16),
    new google.maps.LatLng(19.4321, -99.116),
    new google.maps.LatLng(19.4321, -99.106),
    new google.maps.LatLng(19.4321, -99.116),
    new google.maps.LatLng(19.4321, -99.156),
    new google.maps.LatLng(19.4321, -99.136),
    new google.maps.LatLng(19.4321, -99.1086),
    new google.maps.LatLng(19.4321, -99.110),
    new google.maps.LatLng(19.4321, -99.12),
    new google.maps.LatLng(19.4321, -99.126),
    new google.maps.LatLng(19.4321, -99.12),
    new google.maps.LatLng(19.4321, -99.126),
    new google.maps.LatLng(19.42921, -99.126),
    new google.maps.LatLng(19.4291, -99.126),
    new google.maps.LatLng(19.4221, -99.16),
    new google.maps.LatLng(19.4111, -99.116),
    new google.maps.LatLng(19.4511, -99.106),
    new google.maps.LatLng(19.4451, -99.116),
    new google.maps.LatLng(19.43551, -99.156),
    new google.maps.LatLng(19.4341, -99.136),
    new google.maps.LatLng(19.4321, -99.1086),
    new google.maps.LatLng(19.4281, -99.110),
    new google.maps.LatLng(19.4291, -99.12),
    new google.maps.LatLng(19.4301, -99.126),
   

  
  

  ];
}
