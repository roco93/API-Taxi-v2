<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        
        <title>Panel de control</title>

        <!--Declaso el base_url() como una variable "base" y asi ya despues ocuparla solo con este nombre-->
        <script>var base ='<?php echo base_url();?>';</script>

        <script type="text/javascript" src="<?php echo base_url();?>assets/js/ajax.js"></script>
        
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/materialize.css">

        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/estilos.css">

        <!--<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/drag-drop.css">-->

        <!-- Site's designed for mobile -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        
        <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>

        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/drag-drop.js"></script>

        <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/jquery-ui.min.js"></script> -->

        <script src="<?php echo base_url(); ?>assets/js/jquery-ui.min.js"></script>

        <script src="<?php echo base_url(); ?>assets/js/materialize.min.js"></script>

        <script src="<?php echo base_url(); ?>assets/js/viajes.js"></script>

        <script src="<?php echo base_url(); ?>assets/js/incidentes.js"></script>

        <script src="<?php echo base_url(); ?>assets/js/aprobados.js"></script>

        <script src="<?php echo base_url(); ?>assets/js/reprobados.js"></script>

        <script src="<?php echo base_url(); ?>assets/js/lista_aprobados.js"></script>

        <script src="<?php echo base_url(); ?>assets/js/lista_reprobados.js"></script>




        <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCU2mXR2KQcfZdKKCfXKG05H9H-BMSzOOo&signed_in=true&callback=initialize"></script>

        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
        
        <script type ="text/javascript" src="http://www.geocodezip.com/scripts/v3_epoly.js"></script>
        
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/ruta.js">
        </script>

        <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>-->


        <script type="text/javascript">
            $(document).ready(function(){
                 $(".button-collapse").sideNav();
        
                $(".dropp").droppable({
                    accept: ".drag",
                    activeClass: "gris",
                    tolerance: "intersect",
                    
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

        <!--<style type="text/css">
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
                
                width: 100%;
                text-align: center;

            }
            .gris{
                background: silver;
            }
        </style>-->
    </head>
    <body>