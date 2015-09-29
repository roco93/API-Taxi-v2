<!doctype html>
<html lang="en">
    <head>
        <title>Pruebas de concepto</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <script src="<?php echo base_url(); ?> assets/js/jquery.min.js"></script>        
        
        <!-- draggable -->
        <link rel="stylesheet" href="<?php echo base_url(); ?> assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?> assets/css/layout-grid.min.css">
        <script src="<?php echo base_url(); ?> assets/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?> assets/js/layout-grid.min.js"></script>
        <script src="<?php echo base_url(); ?> assets/js/mresize.js"></script>

        <!-- graficas -->
        <script src="http://cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
        <link href="http://cdn.jsdelivr.net/chartist.js/latest/chartist.min.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div class="contenedor">
            <div
                data-arrange="lt-grid"                     
                class="lt-container
                lt-xs-h-3
                lt-sm-h-6
                lt-md-h-3
                lt-lg-h-4">
                <div
                    draggable="true"
                    class="lt
                    lt-xs-x-0
                    lt-xs-y-0
                    lt-xs-w-1
                    lt-xs-h-1
                    lt-sm-x-0
                    lt-sm-y-0
                    lt-sm-w-2
                    lt-sm-h-2
                    lt-md-x-0
                    lt-md-y-0
                    lt-md-w-1
                    lt-md-h-1
                    lt-lg-x-0
                    lt-lg-y-0
                    lt-lg-w-2
                    lt-lg-h-2">
                        <div class="lt-body bg-info text-center">
                            <!--Aqui va el contenido: graficas,tablas,etc  -->                            
                            <div class="ct-chart ct-golden-section"></div>
                        </div>
                </div>
                <div
                    draggable="true"
                    class="lt
                    lt-xs-x-0
                    lt-xs-y-1
                    lt-xs-w-1
                    lt-xs-h-1
                    lt-sm-x-0
                    lt-sm-y-2
                    lt-sm-w-2
                    lt-sm-h-2
                    lt-md-x-2
                    lt-md-y-0
                    lt-md-w-1
                    lt-md-h-1
                    lt-lg-x-2
                    lt-lg-y-0
                    lt-lg-w-2
                    lt-lg-h-2">
                    <div class="lt-body bg-info text-center">  
                        <!--Aqui va el contenido: graficas,tablas,etc  -->
                        <div class="ct-chartt ct-golden-section"></div>
                    </div>
                </div>
                <div
                    draggable="true"
                    class="lt
                    lt-xs-x-0
                    lt-xs-y-2
                    lt-xs-w-1
                    lt-xs-h-1
                    lt-sm-x-0
                    lt-sm-y-4
                    lt-sm-w-2
                    lt-sm-h-2
                    lt-md-x-0
                    lt-md-y-1
                    lt-md-w-2
                    lt-md-h-2
                    lt-lg-x-1
                    lt-lg-y-2
                    lt-lg-w-2
                    lt-lg-h-2">
                    <div class="lt-body bg-info text-center">
                        <!--Aqui va el contenido: graficas,tablas,etc  -->                    
                        <div class="ct-charttt ct-golden-section"></div>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            new Chartist.Line('.ct-chart', {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
            series: [
            [5, 0, 0, 0, 0],
            [0, 2.5, 3, 2, 3],
            [1, 2, 2.5, 3.5, 4]
            ]
            });

            new Chartist.Line('.ct-chartt', {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
            series: [
            [1, 5, 2, 3, 7],
            [0, 2.5, 3, 3, 3],
            [1, 4, 2.5, 3.5, 6]
            ]
            });

            new Chartist.Line('.ct-charttt', {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
            series: [
            [1, 5, 2, 3, 1],
            [0, 2.5, 5, 2, 3],
            [1, 4, 2.5, 3.5, 0]
            ]
            });

            //funcion que avisa que el tamaño a cambiado
            $(".lt-container").on("mresize",function(){
                window.parent.cambios();
            });

        </script> 
    </body>
</html>