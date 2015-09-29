<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        
        <title>Pruebas de concepto</title>
        
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/materialize.css">

        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/estilos.css">
        <!-- Site's designed for mobile -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        
        <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>

        <script src="<?php echo base_url(); ?>assets/js/materialize.min.js"></script>

        <script src="<?php echo base_url(); ?>assets/Chart.js"></script>  

        <script src="<?php echo base_url(); ?>assets/js/viajes.js"></script>

       <script src="<?php echo base_url(); ?>assets/js/incidentes.js"></script>

        <script async defer
        src="https://maps.googleapis.com/maps/api/js?key= AIzaSyCU2mXR2KQcfZdKKCfXKG05H9H-BMSzOOo&signed_in=true&callback=initialize"></script>

        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
        <script type ="text/javascript" src="http://www.geocodezip.com/scripts/v3_epoly.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/ruta.js"></script>



        <script>
            function cargar(div, desde)
            {
                $(div).load(desde);
            }
        </script>


    </head>
    <body>

        <header>
            <div class="navbar-fixed">
                <nav class="top-nav cyan lighten-2">
                    <div class="nav-wrapper">  
                        <a class="brand-logo center">Pruebas de concepto</a>
                        <!--<button onclick="link()" href="#">link</button>-->
                        <a href="#" data-activates="nav-mobile" class="button-collapse">
                            <i class="material-icons">menu</i>
                        </a>
                        <ul id="nav-mobile" class="side-nav fixed" style="width:220px;">
                            <li class="bold">
                                <a class="waves-effect waves-teal" href="#"><span class="l-menu">Estadisticas</span></a>
                            </li>
                            <li class="bold">
                                <a class="waves-effect waves-teal" href="#"><span class="l-menu">Mapas</span></a>
                            </li>
                            <li class="bold">
                                <a class="waves-effect waves-teal" href="<?php echo site_url('Proof/taxistas'); ?>" ><span class="l-menu">Taxistas</span></a>
                            </li>
                        </ul>                      
                    </div>
                </nav>
            </div>
        </header>

        <article id="cont">

            <div class="row">                        

                <div class="col l5 offset-l1 m6 s12">
                    
                    <div class="card">
                        <div class="card-image waves-effect waves-block waves-light circle-graph cyan lighten-3">
                            <!--<img class="activator" src="<?php echo base_url(); ?>assets/images/pie.png"/>-->
                            <div id="cont1">
                                <div style="width: 58%; margin:0 auto;">
                                    <div style="width: 100%; height: 40px; position: absolute; top: 48%; left: 0; margin-top: -20px; line-height:19px; text-align: center;">
                                        <span id="viajes"></span>               
                                    </div>
                                    <canvas id="doughnutChart" width="255" height="255"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="card-content circle-content cyan accent-4">
                            <span class="card-title activator grey-text text-darken-4">Viajes</span>
                            <p>Descripción</p>
                        </div>
                        <div class="card-reveal cyan lighten-3">
                            <span class="card-title grey-text text-darken-4">Card Title<i class="material-icons right">close</i></span>
                            <p>Here is some more information about this product that is only revealed once clicked on.</p>
                        </div>                         
                    </div>

                </div>

                <div class="col l5 m6 s12">

                    <div class="card">
                        <div class="card-image waves-effect waves-block waves-light circle-graph cyan lighten-3">
                            <div id="cont2">
                                <div style="width: 58%; margin:0 auto;">
                                    <div style="width: 100%; height: 40px; position: absolute; top: 48%; left: 0; margin-top: -20px; line-height:19px; text-align: center;">
                                        <span id="incidentes"></span>                                 
                                    </div>
                                    <canvas id="doughnutChart2" width="255" height="255"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="card-content circle-content cyan accent-4">
                            <span class="card-title activator grey-text text-darken-4">Incidentes</span>
                            <p>Descripción</p>
                        </div>
                        <div class="card-reveal cyan lighten-3">
                            <span class="card-title grey-text text-darken-4">Card Title<i class="material-icons right">close</i></span>
                            <p>Here is some more information about this product that is only revealed once clicked on.</p>
                        </div>                         
                    </div>

                </div>       

            </div>

            <div class="row">                   

                <div class="col l8 offset-l2 m12 s12">

                    <div class="card">
                        <div class="card-image waves-effect waves-block waves-light cyan lighten-3" id="mapa-card">
                          

                             <div id="map_canvas" style="width:50%;height:50%;"></div>

                        </div>
                        <div class="card-content cyan accent-4" id="content-mapa-card">
                            <span class="card-title activator grey-text text-darken-4">Mapa de los viajes actuales</span>
                            <p>Descripcion breve</p>
                        </div>
                        <div class="card-reveal cyan lighten-3">
                            <span class="card-title grey-text text-darken-4">Card Title<i class="material-icons right">close</i></span>
                            <p>Here is some more information about this product that is only revealed once clicked on.</p>
                        </div>                         
                    </div>

                </div>

            </div>

            <footer class="page-footer cyan lighten-2">

                <div class="container">

                    <div class="row">
                        <div class="col l6 s12">
                            <h5 class="white-text">CGMA</h5>
                            <p class="grey-text text-lighten-4">
                                 tecnologias de la información
                            </p>
                        </div>
                        <div class="col l3 s12">
                            <h5 class="white-text">Sitios web</h5>
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

        </article>

    </body>
</html>         