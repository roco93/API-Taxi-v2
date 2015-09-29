//google maps, marker Central
var map;
var centro_latlng = new google.maps.LatLng(19.443739,-99.182540);
var centro_marker = new google.maps.Marker({
	title:"Mi Ubicacion",
	position:centro_latlng,
	draggable:false
});

function coordenada(){    
    $.getJSON("http://localhost/CodeIgniter/index.php/Proof/coordenadas",{apellido:"figueroa Perez", nombre:"adamo "}
        ,function(data){

    
            procesa_datos(data);
        });           
}

//la funcion que recibe los datos de jsonp

function procesa_datos(datos) {
	
	var mapOptions = {
	  //utilizamos como centro la ubicacion central
	  center: new google.maps.LatLng(19.443739,-99.182540),
	  zoom: 16,
	  mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	
	//inicializar el mapa
	map = new google.maps.Map(document.getElementById("map-canvas"),
	    mapOptions);
	
	//agregamos el marker al mapa
	centro_marker.setMap(map);

	var x = 0;
	for(x=0; x<datos.consulta.ubicaciones.length;x++) {
		console.log("adasdasd");
		
		//alert(datos.consulta.ubicaciones[x].latitud);
		console.log(datos.consulta.ubicaciones[x].latitud);
		console.log(datos.consulta.ubicaciones[x].longitud);
		
		var nuevo_punto = new google.maps.LatLng(datos.consulta.ubicaciones[x].latitud, datos.consulta.ubicaciones[x].longitud);
		console.log(nuevo_punto);
		var nuevo_marker = new google.maps.Marker({
			title:datos.consulta.ubicaciones[x].nombre,
			position:nuevo_punto,
			draggable:false
		});

		nuevo_marker.setMap(map);
	
	}
}

$(document).ready(
    function() {     
     setInterval(coordenada, 5000);
    });