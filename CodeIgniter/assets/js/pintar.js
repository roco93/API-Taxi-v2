

  	function aleatorio(){
  		var randomnumber = Math.floor(Math.random() * (5000 - 1000) + 1000);
        $('#viajes').html(randomnumber+ "<br/><br/>Viajes");

        pinta_donut(randomnumber);
			
  	}
  		//var randomnumber = Math.floor(Math.random() * (5000 - 1000) + 1000);


  		$(document).ready(
            function() {
                setInterval(aleatorio, 5000);
            });


  	function pinta_donut(randomnumber){
	// Doughnut Chart Options
	var doughnutOptions = {
		//Boolean - Whether we should show a stroke on each segment
		segmentShowStroke : true,
		
		//String - The colour of each segment stroke
		segmentStrokeColor : "#fff",
		
		//Number - The width of each segment stroke
		segmentStrokeWidth : 2,
		
		//The percentage of the chart that we cut out of the middle.
		percentageInnerCutout : 50,
		
		//Boolean - Whether we should animate the chart	
		animation : true,
		
		//Number - Amount of animation steps
		animationSteps : 20,
		
		//String - Animation easing effect
		animationEasing : "easeOutExpo",
		
		//Boolean - Whether we animate the rotation of the Doughnut
		animateRotate : true,

		//Boolean - Whether we animate scaling the Doughnut from the centre
		animateScale : true,
		
		//Function - Will fire on animation completion.
		onAnimationComplete : null,
		responsive:true,
		percentageInnerCutout : 73
	
	}


	// Doughnut Chart Data
	var doughnutData = [
		{
			value: randomnumber,
			color:"#1E6188",
			//highlight: "#10384F",
			label:"Viajes actuales"
		},
		{
			value : 5000-randomnumber,
			color : "#10384F",
			label : "Viajes totales"
		}
	]


	//Get the context of the Doughnut Chart canvas element we want to select
	var ctx = document.getElementById("doughnutChart").getContext("2d");

	// Create the Doughnut Chart
	var mydoughnutChart = new Chart(ctx).Doughnut(doughnutData, doughnutOptions);
}

	function aleatorio2(){
		randomnumber2 = Math.floor(Math.random() * (1000 - 0) + 0);
        $('#incidentes').html(randomnumber2+ "<br/><br/>Incidentes");

        pinta_donut2(randomnumber2);
	}

  		$(document).ready(
            function() {
                setInterval(aleatorio2, 5000);
            });

    function pinta_donut2(randomnumber2){
	// Doughnut Chart Options
	var doughnutOptions2 = {
		//Boolean - Whether we should show a stroke on each segment
		segmentShowStroke : true,
		
		//String - The colour of each segment stroke
		segmentStrokeColor : "#fff",
		
		//Number - The width of each segment stroke
		segmentStrokeWidth : 2,
		
		//The percentage of the chart that we cut out of the middle.
		percentageInnerCutout : 50,
		
		//Boolean - Whether we should animate the chart	
		animation : false,
		
		//Number - Amount of animation steps
		animationSteps : 20,
		
		//String - Animation easing effect
		animationEasing : "easeOutExpo",
		
		//Boolean - Whether we animate the rotation of the Doughnut
		animateRotate : true,

		//Boolean - Whether we animate scaling the Doughnut from the centre
		animateScale : true,
		
		//Function - Will fire on animation completion.
		onAnimationComplete : null,
		responsive:true,
		percentageInnerCutout : 73
	
	}


	// Doughnut Chart Data
	var doughnutData2 = [
		{
			value: randomnumber2,
			color:"#CF2929",
			//highlight: "#10384F",
			label:"Incidentes"
		},
		{
			value : 5000-randomnumber2,
			color : "#7B1818",
			label : "Viajes sin incidente"
		}
	]



	}