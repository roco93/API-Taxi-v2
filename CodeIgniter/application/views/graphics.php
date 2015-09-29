<!DOCTYPE html>
<html>
  	<head>
    	<title>My first Chartist Tests</title>
    	<link rel="stylesheet"
          href="bower_components/chartist/dist/chartist.min.css">

		<link rel="stylesheet" type="text/css" href="estilo.css">
		          <script src="Chart.js"></script>
  	</head>
  	<body>

<!--  	    <div class= "contenedor"><canvas class= "lienzo" id= "lienzo1" width= "170" height= "170">Su navegador no soporta canvas :( </canvas></div>
    	<div class= "contenedor"><canvas class= "lienzo" id= "lienzo2" width= "190" height= "190">Su navegador no soporta canvas :( </canvas></div>-->

    	<div class="contenedor">
			<canvas id="canvas" class="lienzo2"/>
		</div>
		<script>
	var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
	var barChartData = {
		labels : ["January","February","March","April","May","June","July"],
		datasets : [
			{
				fillColor : "rgba(220,220,220,0.5)",
				strokeColor : "rgba(220,220,220,0.8)",
				highlightFill: "rgba(220,220,220,0.75)",
				highlightStroke: "rgba(220,220,220,1)",
				data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),100,randomScalingFactor(),randomScalingFactor()]
			},
			{
				fillColor : "rgba(151,187,205,0.5)",
				strokeColor : "rgba(151,187,205,0.8)",
				highlightFill : "rgba(151,187,205,0.75)",
				highlightStroke : "rgba(151,187,205,1)",
				data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),100]
			}
		]
	}
	window.onload = function(){
		var ctx = document.getElementById("canvas").getContext("2d");
		window.myBar = new Chart(ctx).Bar(barChartData, {
			responsive : true
		});
	}
	</script>

  	</body>
</html>