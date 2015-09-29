<!DOCTYPE html>
<html>
<head>
	<title>Prueba de Coordenadas</title>
	<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
	<script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCU2mXR2KQcfZdKKCfXKG05H9H-BMSzOOo&sensor=false"></script>
      <script src="<?php echo base_url(); ?>assets/js/coordenadas.js"></script>
</head>
<body>
	<h1>Prueba de Concepto</h1>
	<!-- 1. Descomentar la linea de arriba
		2. Probar el coordenadas.js, añadiendole el json que requiere (http://datos.labplc.mx/georeferencia.json?&latitud=19.443739&longitud=-99.182540&radio=500&jsonp=procesa_datos)
		3. Pedir a Bryan el KEY de google maps para poder usarlo
		4. Ver que es lo que resulta de todo ese procesamiento

		5. Verificar para que sirven las coordenadas que regresa el JSON (puede ser el cuadrante o el limite de toda la delegacion) -->
		<div id="map-canvas"></div>
</body>
</html>