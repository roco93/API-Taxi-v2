<!DOCTYPE html>
<html>
<head>
<title>Principal</title>
<meta charset="UTF-8">
<!-- Le decimos al navegador que nuestra web esta optimizada para moviles -->
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<!-- Cargamos el CSS -->
<link type="text/css" rel="stylesheet" href="../css/materialize.min.css" media="screen,projection"/>
<link type="text/css" rel="stylesheet" href="../css/general.css"/>
    <!-- solo le dan estilo a los mapas para que encajen  -->
    <link rel="stylesheet" href="../css/google.css">
    <link rel="stylesheet" href="../css/google2.css">

</head>
<body>
<header class="">
<div class="navbar-fixed">
	<nav id="nav-principal">
	<div id="nav-menu" class="nav-wrapper pink">
		<a href="#" data-activates="nav-lateral" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
		<a href="#" class="brand-logo">CD MX</a>
		<ul id="nav-mobile" class="right hide-on-med-and-down">
			<li><a href="taxistas.html">Taxistas</a></li>
			<li><a href="../plantillas/estadisticas.html">Estadisticas</a></li>
			<li><a href="../plantillas/mapas.html">Mapas</a></li>
		</ul>
	</div>

</nav>
</div>
</header>
<main class="z-depth-4">
<div  class="nav-wrapper ">
	<ul class="side-nav fixed grey darken-3" id="nav-lateral">
		<li><a href="plantillas/#" class="waves-effect">Taxistas</a>
		</li>
		<li><a href="plantillas/estadisticas.html" class="waves-effect">Estadisticas</a>
		</li>
		<li><a href="plantillas/mapas.html" class="waves-effect">Mapas</a>
		</li>
		</li>
	</ul>
</div>
<div id="contenedor">
	<div class="container">
                <div class="row">
                    <div class="col s6">
                <h1> mapa solo </h1>
                <div id="map"></div>
      
                    </div>
                    
                    <div class="col s6">
                    <h1> mapa calor</h1>
                    <div id="map2"></div>

                         <!--  <div id="floating-panel">
      <button onclick="toggleHeatmap()">Toggle Heatmap</button>
      <button onclick="changeGradient()">Change gradient</button>
      <button onclick="changeRadius()">Change radius</button>
      <button onclick="changeOpacity()">Change opacity</button>
    </div> -->
      
    
                    </div>
                    
                    </div>
                <div class="row card pink lighten-2">
                    <h1> hola</h1>
                </div>
	</div>
	<footer class="page-footer pink darken-2">
	<div class="container">
		<div class="row">
			<div class="col l6 s12">
				<h5 class="white-text">CGMA</h5>
				<p class="grey-text text-lighten-4">
					 tecnologias de la información
				</p>
			</div>
			<div class="col l3 s12">
				<h5 class="white-text">Citios web</h5>
				<ul>
					<li><a class="white-text" href="http://www.df.gob.mx/ciudad/">Ciudad de México</a></li>
					<li><a class="white-text" href="http://www.df.gob.mx/dependencias/">Gobierno</a></li>
					<li><a class="white-text" href="http://www.transparencia.df.gob.mx/index.jsp">Transparencia</a></li>
				</ul>
			</div>
			<div class="col l3 s12">
				<h5 class="white-text">Contacto</h5>
				<ul>
					<li><a class="white-text" href="#!">Link 1</a></li>
					<li><a class="white-text" href="#!">Link 2</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="footer-copyright">
		<div class="container">
			 Gobierno <a class="orange-text text-lighten-3" href="http://www.df.gob.mx/"> CD MX</a>
		</div>
	</div>
	</footer>
</div>
</div>
</main>
<!-- Cargamos jQuery y materialize js -->
<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>
<script>
 $(document).ready(function () {
            //Menú responsivo
            $(".button-collapse").sideNav();

        });  

    </script>
    
         <!-- Api de google maps-->  
<script async defer
        src="https://maps.googleapis.com/maps/api/js?signed_in=true&libraries=visualization&callback=initMap">
    </script>

   

 <script src="../js/google2.js"></script>
</body>
</html>