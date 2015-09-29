function get_num_taxistas_aprobados(){    
    $.get("http://localhost/proyecto/index.php/Dashboard_c/taxistas_aprobados",{apellido:"figueroa Perez", nombre:"adamo "}
        ,function(data){
            $('#aprobados').html(data + "<br/>Taxistas<br/>Aprobados");
            draw_donut3(data);  
        });           
}

$(document).ready(
    function() {      
      setInterval(get_num_taxistas_aprobados, 5000);
    });

function draw_donut3(randomnumber){
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
        animation : false,
        
        //Number - Amount of animation steps
        animationSteps : 15,
        
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
    var ctx = document.getElementById("doughnutChar3").getContext("2d");

    // Create the Doughnut Chart
    var mydoughnutChart = new Chart(ctx).Doughnut(doughnutData, doughnutOptions);
}