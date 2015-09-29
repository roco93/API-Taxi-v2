function get_list_taxistas_aprobados(){    
    $.getJSON("http://localhost/proyecto/index.php/Dashboard_c/lista_taxistas_aprobados",{apellido:"figueroa Perez", nombre:"adamo "}
        ,function(data){
            $('#ident_a1').html(data.info_taxista1 + "<br />" + data.cal_1 + "<br />" + data.num_v1 + " viajes realizados");  
            $('#ident_a2').html(data.info_taxista2 + "<br />" + data.cal_2 + "<br />" + data.num_v2 + " viajes realizados");  
            $('#ident_a3').html(data.info_taxista3 + "<br />" + data.cal_3 + "<br />" + data.num_v3 + " viajes realizados");  
            $('#ident_a4').html(data.info_taxista4 + "<br />" + data.cal_4 + "<br />" + data.num_v4 + " viajes realizados");  
            $('#ident_a5').html(data.info_taxista5 + "<br />" + data.cal_5 + "<br />" + data.num_v5 + " viajes realizados");  
        });           
}

$(document).ready(
    function() {      
      setInterval(get_list_taxistas_aprobados, 5000);
    });