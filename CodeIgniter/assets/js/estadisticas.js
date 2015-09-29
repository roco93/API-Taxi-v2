$(document).ready(
    function() {
    
    getDatosGraficaRadar();

    // Graficas de barras de los viajes en la CDMX
    getDatosGraficaBarras_Anios();
    getDatosGraficaBarras_Meses();
    getDatosGraficaBarras_Dias();
    getDatosGraficaBarras_Horas();
});

function getDatosGraficaRadar(){
          $.getJSON
          ("http://localhost/CodeIgniter/index.php/Proof/getEstadisticas"
                  ,function(data){
               //ejemplos de que los datos se reciben , abajo 
            // alert("ejmplo datos viajes: " +data[0][0] + " "+data[0][1] + " "+ data[0][2] + " "+data[0][3] );
             // alert("ejemplo incidentes: "+data[1][0] + " "+ data[1][1] + " "+ data[1][2] + " "+data[1][3]);
              
            var datosViajes = [data[0][0],data[0][1],data[0][2],data[0][3],data[0][4],data[0][5],data[0][6],data[0][7],data[0][8],data[0][9],data[0][10],data[0][11],data[0][12],data[0][13],data[0][14],data[0][15]];
            var datosIncidentes =[ data[1][0],data[1][1],data[1][2],data[1][3],data[1][4],data[1][5],data[1][6],data[1][7],data[1][8],data[1][9],data[1][10],data[1][11],data[1][12],data[1][13],data[1][14],data[1][15]  ];
            

            dibujaRadar(datosIncidentes,datosViajes);
            });
      }

    // Funcion que dibuja la grafica de viajes por horas
    function getDatosGraficaBarras_Horas() {
        $.getJSON("http://localhost/CodeIgniter/index.php/Proof/getEstadisticasViajesPorHoras"
            ,function(data){
                datosViajesPorHoras = [data[9],data[8],data[7],data[6],data[5],data[4],data[3],data[2],data[1],data[0]];
                getDatos_Horas(datosViajesPorHoras);
            })
    }

    function getDatos_Horas(datosViajesPorHoras) {
        $.getJSON("http://localhost/CodeIgniter/index.php/Proof/get_horas_json"
            ,function(datos){
                datos_horas = [datos[9],datos[8],datos[7],datos[6],datos[5],datos[4],datos[3],datos[2],datos[1],datos[0]];
                dibujar_Grafica_Horas(datos_horas,datosViajesPorHoras);
            })
    }

    function dibujar_Grafica_Horas(datos_horas,datosViajesPorHoras){
        var data = {
            labels: datos_horas,
            datasets: [{
                label: "My Second dataset",
                fillColor: "rgba(151,187,205,0.5)",
                strokeColor: "rgba(151,187,205,0.8)",
                highlightFill: "rgba(151,187,205,0.75)",
                highlightStroke: "rgba(151,187,205,1)",
                data: datosViajesPorHoras,
            }]
        };

        var opciones = {
        //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
        scaleBeginAtZero : true,

        //Boolean - Whether grid lines are shown across the chart
        scaleShowGridLines : true,

        //String - Colour of the grid lines
        scaleGridLineColor : "rgba(0,0,0,.05)",

        //Number - Width of the grid lines
        scaleGridLineWidth : 1,

        //Boolean - Whether to show horizontal lines (except X axis)
        scaleShowHorizontalLines: true,

        //Boolean - Whether to show vertical lines (except Y axis)
        scaleShowVerticalLines: true,

        //Boolean - If there is a stroke on each bar
        barShowStroke : true,

        //Number - Pixel width of the bar stroke
        barStrokeWidth : 2,

        //Number - Spacing between each of the X value sets
        barValueSpacing : 5,

        //Number - Spacing between data sets within X values
        barDatasetSpacing : 1,

        //String - A legend template

        }
        
        var ctx = document.getElementById("viajesHora").getContext("2d");
        var myBarChart = new Chart(ctx).Bar(data, opciones);
    }

    // Funcion que dibuja la grafica de viajes por dias
    function getDatosGraficaBarras_Dias() {
        $.getJSON("http://localhost/CodeIgniter/index.php/Proof/getEstadisticasViajesPorDias"
            ,function(data){
                datosViajesPorDias= [data[9],data[8],data[7],data[6],data[5],data[4],data[3],data[2],data[1],data[0]];
                getDatos_Dias(datosViajesPorDias);
            })
    }

    function getDatos_Dias(datosViajesPorDias) {
        $.getJSON("http://localhost/CodeIgniter/index.php/Proof/get_dias_json"
            ,function(datos){
                datos_dias = [datos[9],datos[8],datos[7],datos[6],datos[5],datos[4],datos[3],datos[2],datos[1],datos[0]];
                dibujar_Grafica_Dias(datos_dias,datosViajesPorDias);
                  })
    }

    function dibujar_Grafica_Dias(datos_dias,datosViajesPorDias){
        var data = {
            labels: datos_dias,
            datasets: [{
                label: "My Second dataset",
                fillColor: "rgba(151,187,205,0.5)",
                strokeColor: "rgba(151,187,205,0.8)",
                highlightFill: "rgba(151,187,205,0.75)",
                highlightStroke: "rgba(151,187,205,1)",
                data: datosViajesPorDias,
            }]
        };

        var opciones = {
        //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
        scaleBeginAtZero : true,

        //Boolean - Whether grid lines are shown across the chart
        scaleShowGridLines : true,

        //String - Colour of the grid lines
        scaleGridLineColor : "rgba(0,0,0,.05)",

        //Number - Width of the grid lines
        scaleGridLineWidth : 1,

        //Boolean - Whether to show horizontal lines (except X axis)
        scaleShowHorizontalLines: true,

        //Boolean - Whether to show vertical lines (except Y axis)
        scaleShowVerticalLines: true,

        //Boolean - If there is a stroke on each bar
        barShowStroke : true,

        //Number - Pixel width of the bar stroke
        barStrokeWidth : 2,

        //Number - Spacing between each of the X value sets
        barValueSpacing : 5,

        //Number - Spacing between data sets within X values
        barDatasetSpacing : 1,

        //String - A legend template

        }
        
        var ctx = document.getElementById("viajesDia").getContext("2d");
        var myBarChart = new Chart(ctx).Bar(data, opciones);
    }

    // Funcion que dibuja la grafica de viajes por meses
    function getDatosGraficaBarras_Meses() {
        $.getJSON("http://localhost/CodeIgniter/index.php/Proof/getEstadisticasViajesPorMeses"
            ,function(data){
                datosViajesPorMeses= [data[9],data[8],data[7],data[6],data[5],data[4],data[3],data[2],data[1],data[0]];
                getDatos_Meses(datosViajesPorMeses);
            })
    }

    function getDatos_Meses(datosViajesPorMeses) {
        $.getJSON("http://localhost/CodeIgniter/index.php/Proof/get_meses_json"
            ,function(datos){
                datos_meses = [datos[9],datos[8],datos[7],datos[6],datos[5],datos[4],datos[3],datos[2],datos[1],datos[0]];
                dibujar_Grafica_Meses(datos_meses,datosViajesPorMeses);
                  })
    }

    function dibujar_Grafica_Meses(datos_meses,datosViajesPorMeses){
        var data = {
            labels: datos_meses,
            datasets: [{
                label: "My Second dataset",
                fillColor: "rgba(151,187,205,0.5)",
                strokeColor: "rgba(151,187,205,0.8)",
                highlightFill: "rgba(151,187,205,0.75)",
                highlightStroke: "rgba(151,187,205,1)",
                data: datosViajesPorMeses,
            }]
        };

        var opciones = {
        //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
        scaleBeginAtZero : true,

        //Boolean - Whether grid lines are shown across the chart
        scaleShowGridLines : true,

        //String - Colour of the grid lines
        scaleGridLineColor : "rgba(0,0,0,.05)",

        //Number - Width of the grid lines
        scaleGridLineWidth : 1,

        //Boolean - Whether to show horizontal lines (except X axis)
        scaleShowHorizontalLines: true,

        //Boolean - Whether to show vertical lines (except Y axis)
        scaleShowVerticalLines: true,

        //Boolean - If there is a stroke on each bar
        barShowStroke : true,

        //Number - Pixel width of the bar stroke
        barStrokeWidth : 2,

        //Number - Spacing between each of the X value sets
        barValueSpacing : 5,

        //Number - Spacing between data sets within X values
        barDatasetSpacing : 1,

        //String - A legend template

        }
        
        var ctx = document.getElementById("viajesMes").getContext("2d");
        var myBarChart = new Chart(ctx).Bar(data, opciones);
    }

    // Funcion que dibuja la grafica de viajes por años
    function getDatosGraficaBarras_Anios() {
        $.getJSON("http://localhost/CodeIgniter/index.php/Proof/getEstadisticasViajesPorAnios"
            ,function(data){
                datosViajesPorAnios= [data[9],data[8],data[7],data[6],data[5],data[4],data[3],data[2],data[1],data[0]];
                getDatos_Anios(datosViajesPorAnios);
            })
    }


    function getDatos_Anios(datosViajesPorAnios) {
        $.getJSON("http://localhost/CodeIgniter/index.php/Proof/get_anios_json"
            ,function(datos){
                datos_anios = [datos[9],datos[8],datos[7],datos[6],datos[5],datos[4],datos[3],datos[2],datos[1],datos[0]];
                dibujar_Grafica_Anios(datos_anios,datosViajesPorAnios);
                  })
    }

    function dibujar_Grafica_Anios(datos_anios,datosViajesPorAnios){
        var data = {
            labels: datos_anios,
            datasets: [{
                label: "My Second dataset",
                fillColor: "rgba(151,187,205,0.5)",
                strokeColor: "rgba(151,187,205,0.8)",
                highlightFill: "rgba(151,187,205,0.75)",
                highlightStroke: "rgba(151,187,205,1)",
                data: datosViajesPorAnios,
            }]
        };

        var opciones = {
        //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
        scaleBeginAtZero : true,

        //Boolean - Whether grid lines are shown across the chart
        scaleShowGridLines : true,

        //String - Colour of the grid lines
        scaleGridLineColor : "rgba(0,0,0,.05)",

        //Number - Width of the grid lines
        scaleGridLineWidth : 1,

        //Boolean - Whether to show horizontal lines (except X axis)
        scaleShowHorizontalLines: true,

        //Boolean - Whether to show vertical lines (except Y axis)
        scaleShowVerticalLines: true,

        //Boolean - If there is a stroke on each bar
        barShowStroke : true,

        //Number - Pixel width of the bar stroke
        barStrokeWidth : 2,

        //Number - Spacing between each of the X value sets
        barValueSpacing : 5,

        //Number - Spacing between data sets within X values
        barDatasetSpacing : 1,

        //String - A legend template

        }
        
        var ctx = document.getElementById("viajesAnio").getContext("2d");
        var myBarChart = new Chart(ctx).Bar(data, opciones);
    }


function dibujaRadar(datosIncidentes,datosViajes){

var data = {
    labels: ["Azcapotzalco", "Alvaro Obregon", "Benito Juarez", "Coyoacan", "Cuauhtémoc", "Iztapalapa", "Gustavo A. Madero","Venustiano Carranza","Iztacalco","Tlahuac","Coyoacan", "Tlalpan","Cuajimalpa","Milpalta","Magdalena Contreras","Miguel Hidalgo"],
    datasets: [
        {
            label: "Viajes",
            fillColor: "rgba(156, 101, 0, 0.3)",
            strokeColor: "rgba(156, 120, 0, 0.9)",
            pointColor: "rgba(156, 120, 0, 0.9)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(220,220,220,1)",
            data: datosIncidentes,
        },
        {
            label: "My Second dataset",
            fillColor: "rgba(151,187,205,0.2)",
            strokeColor: "rgba(151,187,205,1)",
            pointColor: "rgba(151,187,205,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(151,187,205,1)",
            data: datosViajes,
        }
    ]
}


var opciones = {
	animation: true,

    // Number - Number of animation steps
    animationSteps: 60,

    // String - Animation easing effect
    // Possible effects are:
    // [easeInOutQuart, linear, easeOutBounce, easeInBack, easeInOutQuad,
    //  easeOutQuart, easeOutQuad, easeInOutBounce, easeOutSine, easeInOutCubic,
    //  easeInExpo, easeInOutBack, easeInCirc, easeInOutElastic, easeOutBack,
    //  easeInQuad, easeInOutExpo, easeInQuart, easeOutQuint, easeInOutCirc,
    //  easeInSine, easeOutExpo, easeOutCirc, easeOutCubic, easeInQuint,
    //  easeInElastic, easeInOutSine, easeInOutQuint, easeInBounce,
    //  easeOutElastic, easeInCubic]
    animationEasing: "easeInCubic",
    //Boolean - Whether to show lines for each scale point
    scaleShowLine : true,

    //Boolean - Whether we show the angle lines out of the radar
    angleShowLineOut : true,

    //Boolean - Whether to show labels on the scale
    scaleShowLabels : false,

    // Boolean - Whether the scale should begin at zero
    scaleBeginAtZero : true,

    //String - Colour of the angle line
    angleLineColor : "rgba(0,0,0,.1)",

    //Number - Pixel width of the angle line
    angleLineWidth : 1,

    //String - Point label font declaration
    pointLabelFontFamily : "'Arial'",

    //String - Point label font weight
    pointLabelFontStyle : "normal",

    //Number - Point label font size in pixels
    pointLabelFontSize : 10,

    //String - Point label font colour
    pointLabelFontColor : "#666",

    //Boolean - Whether to show a dot for each point
    pointDot : true,

    //Number - Radius of each point dot in pixels
    pointDotRadius : 3,

    //Number - Pixel width of point dot stroke
    pointDotStrokeWidth : 1,

    //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
    pointHitDetectionRadius : 20,

    //Boolean - Whether to show a stroke for datasets
    datasetStroke : true,

    //Number - Pixel width of dataset stroke
    datasetStrokeWidth : 2,

    //Boolean - Whether to fill the dataset with a colour
    datasetFill : true,

    //String - A legend template

}

var ctx = document.getElementById("delegaciones").getContext("2d");

var misDelegaciones = new Chart(ctx).Radar(data, opciones);



}




