
function aleatorio(){
    var randomnumber = 0;
    //Math.floor(Math.random() * (5000 - 1000) + 1000);
    $('#viajes').html(randomnumber+ "<br/><br/>Viajes");
    draw_donut(randomnumber);         
}


 function get(){    $.get("http://localhost/CodeIgniter/index.php/Proof/getViajes",{apellido:"figueroa Perez", nombre:"adamo "}
                  ,function(data){
             $('#viajes').html(data + "<br/><br/>Viajes");
             draw_donut(data);  
            });
            
                   
     }
             //setInterval(get, 2000);
         
// Funcion para extraer los datos de taxistas
function getTaxistas(){
    $.getJSON("http://localhost/CodeIgniter/index.php/Proof/getTaxistas"
        ,function(data){
            $('#aprobados').html(data.num_taxistas_aprobados + "<br/>Taxistas<br/>Aprobados");
            $('#reprobados').html(data.num_taxistas_reprobados + "<br/>Taxistas<br/>Reprobados")
            draw_donut(data.num_taxistas_aprobados);  
        });
}

$(document).ready(
    function() {
        
       // aleatorio();
           
     setInterval(get, 5000);
        //setInterval(getTaxistas,3000);

    });


function draw_donut(randomnumber){
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
    var ctx = document.getElementById("doughnutChart").getContext("2d");

    // Create the Doughnut Chart
    var mydoughnutChart = new Chart(ctx).Doughnut(doughnutData, doughnutOptions);
}
