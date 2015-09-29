<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        
        <title>Panel de control</title>
        
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/materialize.css">

        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/estilos.css">

        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/drag.css">
        <!-- Site's designed for mobile -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        
        <!--<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>-->

        <script src="<?php echo base_url(); ?>assets/js/materialize.min.js"></script>

        <script src="<?php echo base_url(); ?>assets/Chart.js"></script>  

        <script src="<?php echo base_url(); ?>assets/js/viajes.js"></script>

        <script src="<?php echo base_url(); ?>assets/js/incidentes.js"></script>

        <script src="<?php echo base_url(); ?>assets/drag.js"></script>

        <script async defer
        src="https://maps.googleapis.com/maps/api/js?key= AIzaSyCU2mXR2KQcfZdKKCfXKG05H9H-BMSzOOo&signed_in=true&callback=initialize"></script>

        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
        
        <script type ="text/javascript" src="http://www.geocodezip.com/scripts/v3_epoly.js"></script>
        
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/ruta.js">
        </script>

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>

        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>

     

        <script type="text/javascript">
            $(document).ready(function(){
        $(".dropp").droppable({
            accept: ".drag",
            activeClass: "gris",
            tolerance: "fit",
            drop:function(event,ui){                                
                if(!$(this).data("ocupado")){                   
                    ui.draggable.draggable("option","revert",false);
                    $("#"+event.target.id).data("ocupado",true);                    
                }else{
                    ui.draggable.draggable("option","revert",true);
                    ocupa();                    
                }
                origen=true;                                
            },

            out:function(event,ui){ 
                if(origen){
                    inicio=event.target.id;
                    origen=false;                                   
                }               
                $("#"+event.target.id).data("ocupado",false);                                   
            },          
        });

        function ocupa(){
            $("#"+inicio).data("ocupado",true);
        }

        $(".dropp").data("ocupado",false);      

        $(".drag").draggable({
            containment:"#matriz",
            opacity: 0.7,
            revert: false,
            cursor:"move",          
            create:function(){
                $("#"+$(this).parent().get(0).id).data("ocupado",true);
            },          
        });

        var origen=true;
        var inicio="";

    });
        </script>

        <style type="text/css">


.dropp{
    height: 200px;
    width: 30%;
    border:1px solid black;
    float: left;
    padding: 10px;


}
.drag{
    height: 150px;
    width: 200px;
    background: red;
    margin: auto;           
}
#matriz{
    height: 600px;
    width: 100%;
    text-align: center;

}
.gris{
    background: silver;
}</style>

    </head>
    <body>

    <header>
    <div class="navbar-fixed">
        <nav class="top-nav cyan lighten-2">
            <div class="nav-wrapper">  
                <a class="brand-logo center">Pruebas de concepto</a>
                <a href="#" data-activates="nav-mobile" class="button-collapse">
                    <i class="material-icons">menu</i>
                </a>
                <ul class="left hide-on-med-and-down">
                    <li><a href="<?php echo site_url('Dashboard_c/index'); ?>">
                    <img src="<?php echo base_url('assets/images/home.png'); ?>" height='60' width='60'>
                    </a></li>
                </ul>
                <ul id="nav-mobile" class="side-nav fixed" style="width:220px;">
                    <li class="bold">
                        <a class="waves-effect waves-teal" href="<?php echo site_url('Dashboard_c/estadisticas'); ?>"><span class="l-menu">Estadisticas</span></a>
                    </li>
                    <li class="bold">
                        <a class="waves-effect waves-teal" href="<?php echo site_url('Dashboard_c/mapas'); ?>"><span class="l-menu">Mapas</span></a>
                    </li>
                    <li class="bold">
                        <a id="fun" class="waves-effect waves-teal" href="<?php echo site_url('Dashboard_c/taxistas'); ?>" ><span class="l-menu">Taxistas</span></a>
                    </li>
                </ul> 
            </div>      
        </nav>
    </div>
</header>

<div id="matriz">
        <div id="s1" class="dropp">
            <div id="a1" class="drag">div1</div>
        </div>
        <div id="s2" class="dropp"></div>
        <div id="s3" class="dropp"></div>

        <div id="s4" class="dropp"></div>
        <div id="s5" class="dropp">
            <div id="a2" class="drag">div2</div>
        </div>
        <div id="s6" class="dropp"></div>

        <div id="s7" class="dropp"></div>
        <div id="s8" class="dropp"></div>
        <div id="s9" class="dropp">
            <div id="a3" class="drag">div3</div>
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


</body>
</html>