function get_list_taxistas_reprobados(){    
    $.getJSON("http://127.0.0.1/proyecto/index.php/Dashboard_c/lista_taxistas_reprobados"
        ,function(data){
            $('#ident_b1').html(data.info_taxista1 + "<br />" + data.cal_1 + "<br />" + data.num_v1 + " viajes realizados");  
            $('#ident_b2').html(data.info_taxista2 + "<br />" + data.cal_2 + "<br />" + data.num_v2 + " viajes realizados");  
            $('#ident_b3').html(data.info_taxista3 + "<br />" + data.cal_3 + "<br />" + data.num_v3 + " viajes realizados");  
            $('#ident_b4').html(data.info_taxista4 + "<br />" + data.cal_4 + "<br />" + data.num_v4 + " viajes realizados");  
            $('#ident_b5').html(data.info_taxista5 + "<br />" + data.cal_5 + "<br />" + data.num_v5 + " viajes realizados");  
        });           
}

$(document).ready(
    function() {      
      setInterval(get_list_taxistas_reprobados, 5000);
    });