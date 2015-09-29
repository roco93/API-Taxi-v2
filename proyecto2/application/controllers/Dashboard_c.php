<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    class Dashboard_c extends CI_Controller {

        function _construct(){
        parent::_construct();
        
    //Loading url helper
    //$this->load->helper('url');
    }

        
        
        /*public function get() 
        {
            echo " esto esta en controlador y :D   ..";
            $algo= $_GET["nombre"];
            echo $algo;
        }*/

    public function index(){

            $this->load->view('dashboard_v.php');
            $this->load->view('dashboard_header.php');
            $this->load->view('dashboard_index.php');
            $this->load->view('dashboard_footer.php');
            //$this->load->view('dash_p.php');
    }

    public function getViajes()
    {
        // URL para realizar el CURL
        $url = "http://www14.df.gob.mx/virtual/dashboard_cgma/smartCDMX/taxi/v1/index.php/Viajes";
        // Contador para los viajes realizados en un lapso de 5 minutos
        $num_viajes = 0;
        // Timestamp del servidor (string)
        $date_server = date("Y-m-d H:i:s");
        // Convertir en un date para comparar
        $datediff_server = date_create($date_server);
        // Realizar el CURL a la API Taxi y recuperar un arreglo
        $infoViaje = $this->curl_API_Taxi($url);
        // Bandera para controlar realizar el conteo de viajes 
        $flag = 0;
        // Iteramos el arreglo recuperado
        foreach ($infoViaje as $val) {
            if(($flag == 1)&&($val != "null::")){
                // Separar las comillas
                $fecha = explode('"', $val);
                // Contador necesario
                $cont = 0;
                foreach ($fecha as $f) {
                    if($cont == 1){
                        // Llamar al metodo que checara si fue un viaje hace 5 min
                        $resultado = $this->checarlapso($datediff_server,$f);
                        //var_dump($f."<br />");
                        // Sumar lo que regrese el metodo
                        $num_viajes = $num_viajes + $resultado;
                        //echo $num_viajes;
                    }
                    $cont++;
                }
                $flag = 0;
            }
            if($val == "null::"){
                $flag = 0;
            }
            if($val == '"fecha"'){
                $flag = 1;
            }
            //var_dump($val);
        }
    /*  echo "hey2: ".$cont2;
        echo "hey3: ".$cont3;
        echo "hey4: ".$cont4;*/
        // Descomentar en caso de que sean datos estaticos 
    /*  $num_viajes = 1400; */
        // Debido a que no se pueden recuperar los indicentes, se dejara estatico
        $num_incidentes = 2;
        // Enviar el valor por medio de AJAX
        echo $num_viajes;   
    }

//*********************************** Taxistas ********************************************//
    // Metodo que carga la pagina de taxistas
        public function taxistas(){

            $this->load->view('dashboard_v.php');
            $this->load->view('dashboard_header.php');
            $this->load->view('dashboard_taxistas.php');
            $this->load->view('dashboard_footer.php');
        }

    //  Metodo que muestra el numero de taxistas aprobados
    public function taxistas_aprobados(){
        $data_taxista = $this->proceso_taxistas();
        $taxistas_aprobados= $data_taxista["num_taxistas_aprobados"];
        echo $taxistas_aprobados;
    }

    // Metodo que muestra el numero de taxistas reprobados
    public function taxistas_reprobados(){
        $data_taxista = $this->proceso_taxistas();
        $taxistas_reprobados = $data_taxista["num_taxistas_reprobados"];
        echo $taxistas_reprobados;
    }

    // Metodo que muestra el nombre del taxista, calificacion y los viajes realizados de 
    // los taxistas aprobados
    public function lista_taxistas_aprobados(){
        // Obtener arreglo de los taxistas mejor calficados
        $data_taxista = $this->proceso_taxistas();
        // Obtener lista de los taxistas mejor calificados
        $lista_taxistas_a = $data_taxista["taxistas_aprobados"];
        // Iterar el arreglo para recuperar los datos de cada taxista
        $arr_taxista_a = $this->recuperar_datos_taxista($lista_taxistas_a);

        echo json_encode($arr_taxista_a);
    }

    // Metodo que muestra el nombre del taxista, calificacion y los viajes realizados de 
    // los taxistas reprobados
    public function lista_taxistas_reprobados(){
        // Obtener arreglo de los taxistas peor calficados
        $data_taxista = $this->proceso_taxistas();
        // Obtener lista de los taxistas peor calificados
        $lista_taxistas_r = $data_taxista["taxistas_reprobados"];
        // Iterar el arreglo para recuperar los datos de cada taxista
        $arr_taxista_r = $this->recuperar_datos_taxista($lista_taxistas_r);

        echo json_encode($arr_taxista_r);
    }

    // Metodo que recupera la informacion de cada taxista mediante un CURL
    private function recuperar_datos_taxista($lista_taxistas){
        // Bandera a usar en el momento de la iteracion
        $flag = 0;
        // Contador a usar en el momento de la iteracion
        $cont = 0;
        $val = "";
        // Iterar para realizar un CURL a la API Taxi y recuperar los datos del taxista
        foreach ($lista_taxistas as $value) {
            if($cont == 0){ // Realizar CURL 
                $info_tax1 = $this->curl_Taxistas($value);
                if(! is_null($info_tax1)){
                    foreach ($info_tax1 as $val_tax1) {
                        $val = $val." ".$val_tax1;
                    }
                    $info_taxista1 = $val;
                }else{
                    $info_taxista1 = $value;
                }
            }elseif ($cont == 1) {
                $cal_1 = $value;
            }elseif ($cont == 2) {
                $num_v1 = $value;
            }elseif ($cont == 3) { // Realizar CURL 
                $info_tax2 = $this->curl_Taxistas($value);
                if(! is_null($info_tax2)){
                    $val = "";
                    foreach ($info_tax2 as $val_tax2) {
                        $val = $val." ".$val_tax2;
                    }
                    $info_taxista2 = $val;
                }else{
                    $info_taxista2 = $value;
                }
            }elseif ($cont == 4) {
                $cal_2 = $value;
            }elseif ($cont == 5) {
                $num_v2 = $value;
            }elseif ($cont == 6) { // Realizar CURL 
                $info_tax3 = $this->curl_Taxistas($value);
                if(! is_null($info_tax3)){
                    $val = "";
                    foreach ($info_tax3 as $val_tax3) {
                        $val = $val." ".$val_tax3;
                    }
                    $info_taxista3 = $val;
                }else{
                    $info_taxista3 = $value;
                }
            }elseif ($cont == 7) {
                $cal_3 = $value;
            }elseif ($cont == 8) {
                $num_v3 = $value;
            }elseif ($cont == 9) { // Realizar CURL 
                $info_tax4 = $this->curl_Taxistas($value);
                if(! is_null($info_tax4)){
                    $val = "";
                    foreach ($info_tax4 as $val_tax4) {
                        $val = $val." ".$val_tax4;
                    }
                    $info_taxista4 = $val;
                }else{
                    $info_taxista4 = $value;
                }
            }elseif ($cont == 10) {
                $cal_4 = $value;
            }elseif ($cont == 11) {
                $num_v4 = $value;
            }elseif ($cont == 12) { // Realizar CURL 
                $info_tax5 = $this->curl_Taxistas($value);
                if(! is_null($info_tax5)){
                    $val = "";
                    foreach ($info_tax5 as $val_tax5) {
                        $val = $val." ".$val_tax5;
                    }
                    $info_taxista5 = $val;
                }else{
                    $info_taxista5 = $value;
                }
            }elseif ($cont == 13) {
                $cal_5 = $value;
            }elseif ($cont == 14) {
                $num_v5 = $value;
            }

            $cont++;
        }
        // Array a devolver
        $arr_taxista = array(
            'info_taxista1' => $info_taxista1,
            'cal_1' => $cal_1,
            'num_v1' => $num_v1, 
            'info_taxista2' => $info_taxista2,
            'cal_2' => $cal_2,
            'num_v2' => $num_v2,
            'info_taxista3' => $info_taxista3,
            'cal_3' => $cal_3,
            'num_v3' => $num_v3,
            'info_taxista4' => $info_taxista4,
            'cal_4' => $cal_4,
            'num_v4' => $num_v4,
            'info_taxista5' => $info_taxista5,
            'cal_5' => $cal_5,
            'num_v5' => $num_v5
            );

        return $arr_taxista;
    }

    // Metodo que realizara un CURL a la API Taxi para obtener la informacion de un taxista en
    // especifico usando su identificador
    private function curl_Taxistas($taxista){
        // URL para realizar el CURL
        $url = "http://www14.df.gob.mx/virtual/dashboard_cgma/smartCDMX/taxi/v1/index.php/Taxistas/find/".$taxista;
        // Inicializar CURL para pedir la informacion 
        $respuesta_Taxista = curl_init();
        curl_setopt($respuesta_Taxista,CURLOPT_URL, $url);
        // Procesar el JSON
        curl_setopt($respuesta_Taxista, CURLOPT_RETURNTRANSFER, true);
        // Ejecutar el CURL
        $JSON_recuperado = curl_exec($respuesta_Taxista);
        // Cerrar el CURL
        curl_close($respuesta_Taxista);
        // Convertir el json de respuesta en un array asociativo
        $info_Taxista = json_decode($JSON_recuperado, true);

        //var_dump($info_Taxista);
        if (! $info_Taxista["error"]) { 
            $datos_Taxista = array (
                'nombre' => $info_Taxista["response"]["nombre"],
                'ap_paterno' => $info_Taxista["response"]["apellido_paterno"],
                'ap_materno' => $info_Taxista["response"]["apellido_materno"]
                );
            return $datos_Taxista;
        }else{
            return NULL;
        }
    }
    
    // Metodo que procesa la informacion recibida de la API Taxista
    private function proceso_taxistas(){
        // Debido a que la API Taxi no regresa un JSON con todos los taxistas,
        // se deben trabajar con datos crudos (Se intento ingresar datos a la BD de la API Taxi
        // usando los CURL de las pruebas, los resultados fueron negativos).
        $num_total_taxistas = 1000;
        $num_taxistas_aprobados = "450";
        $num_taxistas_reprobados = 550;
        $taxistas_aprobados = array('15676','9.82','345','14510','8.89','324','13255','8.58','567','87342','7.96','634','65232','7.28','554');
        $taxistas_reprobados = array('34723','4.88','776','41333','4.12','763','92433','3.68','555','72341','3.33','345','52239','2.56','765');
        // Crear el arreglo para dar a la vista los valores necesarios
        $data_taxista = array(
            'num_total_taxistas'  => $num_total_taxistas,
            'num_taxistas_aprobados' => $num_taxistas_aprobados,
            'num_taxistas_reprobados' => $num_taxistas_reprobados,
            'taxistas_aprobados' => $taxistas_aprobados,
            'taxistas_reprobados' => $taxistas_reprobados
            );
        
        return $data_taxista;
    //  $this->load->view('pagina_principal/taxistas.php',$data_taxista);

        // Nota: En caso de que hubieran taxistas en la API Taxi, entonces se realizaria lo 
        // siguiente.....
        //  1. Hacer un CURL al controlador Taxistas en la API Taxi
        //  2. En base a su nivel_confianza, ver cuantos taxistas estan aprobados y reprobados
        //  3. Hacer un conteo total, conteo de taxistas aprobados y reprobados
        //  4. De la misma forma, en base a s nivel_Confianza, checar los mejores aprobados y 
        //  los mejores reprobados.
        //
        // Se sugiere realizar un CURL a LPLC para recuperar los nombres de los taxistas, y asi
        // que este dashboard sea mas ilustrativo.
    }

    /******************************* Estadisticas **********************************************/

    public function estadisticas(){

            $this->load->view('dashboard_v.php');
            $this->load->view('dashboard_header.php');
            $this->load->view('dashboard_estadisticas.php');
            $this->load->view('dashboard_footer.php');
        }

    public function getEstadisticas() {
    // se hace el backend y se obtiene el arreglo con los viajes totales por delegacion 
            // el resultado final es un arreglo solo con datos
            $viajesPorDelegacion = array(28, 48, 40, 25, 96, 27, 90,65, 59, 87, 81, 56, 55, 40,50,35);
            // backend para obtener incidentes por delegacion, resultado es parecida a 
            $incidentesPorDelegacion = array(4, 10, 20, 11, 16, 15, 4,5,5,6,9,15,12,13,6,4);   
    // se envia un solo arreglo codificado en json con los datos de las 2 graficas para envitar doble recarga

    $viajesFinal = array($viajesPorDelegacion,$incidentesPorDelegacion);   
        echo json_encode($viajesFinal);
    }

    // ************** Viajes por Años
    public function getEstadisticasViajesPorAnios() {
        // Obtener los años dependiendo del servidor
        $arr_anios = $this->get_anios();
        // Arreglo a devolver
        $arr_viajes_anio = array();
        // Iterar arreglo obtenido
        foreach ($arr_anios as $value) {
            // Calcular cuantos viajes por año se realizan 
            $num_viaje_anio = $this->viaje_anio($value);
            // Agregar al arreglo al devolver
            array_push($arr_viajes_anio, $num_viaje_anio);
        }
        
        echo json_encode($arr_viajes_anio);

    }

    public function viaje_anio($anio){
        // URL para realizar el CURL
        $url = "http://www14.df.gob.mx/virtual/dashboard_cgma/smartCDMX/taxi/v1/index.php/Viajes";
        // Realizar el CURL a la API Taxi y recuperar un arreglo
        $infoViaje = $this->curl_API_Taxi($url);
        // Bandera para controlar realizar el conteo de viajes 
        $flag = 0;
        // Numero total de viajes respecto al año dado
        $num_viajes_anio = 0;
        // Iteramos el arreglo recuperado
        foreach ($infoViaje as $val) {
            if(($flag == 1)&&($val != "null::")){
                // Separar las comillas
                $fecha = explode('"', $val);
                // Contador necesario
                $cont = 0;
                foreach ($fecha as $f) {
                    if($cont == 1){
                        // Convertimor el string en un date
                        $date = date_create($f);
                        // Obtenemos el año
                        $anio_viaje = date_format($date, 'Y');
                        if($anio == $anio_viaje){
                            // Corresponde al año
                            $num_viajes_anio++;
                        }
                    }
                    $cont++;
                }
                $flag = 0;
            }
            if($val == "null::"){
                $flag = 0;
            }
            if($val == '"fecha"'){
                $flag = 1;
            }
        }

        return $num_viajes_anio;
    }

    private function get_anios(){
        // Timestamp del servidor (string)
        $date_server = date("Y");
        // Arreglo con los años anteriores al actual
        $arr_anios = array();
        // Contador para la iteracion de 10 años anteriores
        $cont = 10;
        while($cont != 0){
            array_push($arr_anios, $date_server);
            $date_server--;
            $cont--;
        }

        return $arr_anios;
    }

    public function get_anios_json(){
        // Obtener los años dependiendo del servidor
        $arr_anios = $this->get_anios();
        echo json_encode($arr_anios);
    }

    // ******************************** Viajes por meses
    public function getEstadisticasViajesPorMeses() {
        // Obtener los meses dependiendo del servidor
        $arr_meses_anio = $this->get_meses_anio();
        // Arreglo a devolver
        $arr_viajes_meses = array();
        // Contador para recuperar año y mes
        $cont = 0;
        // Iterar arreglo obtenido
        foreach ($arr_meses_anio as $value) {
            if($cont == 2){
                $cont = 0;
            }
            if($cont == 0){
                $anio = $value;
            }elseif($cont == 1){
                $mes = $value;
                // Calcular cuantos viajes por mes se realizan 
                $num_viaje_meses = $this->viaje_meses($anio,$mes);
                // Agregar al arreglo al devolver
                array_push($arr_viajes_meses, $num_viaje_meses);        
            }
            $cont++;
        }
        
        echo json_encode($arr_viajes_meses);
    }

    private function viaje_meses($anio,$meses){
        // URL para realizar el CURL
        $url = "http://www14.df.gob.mx/virtual/dashboard_cgma/smartCDMX/taxi/v1/index.php/Viajes";
        // Realizar el CURL a la API Taxi y recuperar un arreglo
        $infoViaje = $this->curl_API_Taxi($url);
        // Bandera para controlar realizar el conteo de viajes 
        $flag = 0;
        // Numero total de viajes respecto al mes dado
        $num_viajes_meses = 0;
        // Iteramos el arreglo recuperado
        foreach ($infoViaje as $val) {
            if(($flag == 1)&&($val != "null::")){
                // Separar las comillas
                $fecha = explode('"', $val);
                // Contador necesario
                $cont = 0;
                foreach ($fecha as $f) {
                    if($cont == 1){
                        // Convertimor el string en un date
                        $date = date_create($f);
                        // Obtenemos el año
                        $anio_viaje = date_format($date, 'Y');
                        
                        if($anio == $anio_viaje){
                            // Obtenemos el mes
                            $mes_viaje = date_format($date, 'm');
                            if($meses == $mes_viaje){
                                // Corresponde al mes
                                $num_viajes_meses++;
                            }
                        }
                    }
                    $cont++;
                }
                $flag = 0;
            }
            if($val == "null::"){
                $flag = 0;
            }
            if($val == '"fecha"'){
                $flag = 1;
            }
        }

        return $num_viajes_meses;
    }

    private function get_meses_anio(){
        // Timestamp del servidor (mes)
        $date_server_mes = date("m");
        // Timestamp del servidor (anio)
        $date_server_anio = date("Y");
        // Arreglo con los meses anteriores al actual
        $arr_meses_anio = array();
        // Contador para la iteracion de 10 meses anteriores
        $cont = 10;
        while($cont != 0){
            if($date_server_mes == 0){
                $date_server_mes = 12;
                $date_server_anio--;
            }
            array_push($arr_meses_anio, $date_server_anio);
            array_push($arr_meses_anio, $date_server_mes);
            $date_server_mes--;
            $cont--;
        }

        return $arr_meses_anio;
    }

    private function get_meses(){
        // Timestamp del servidor (string)
        $date_server = date("m");
        // Arreglo con los meses anteriores al actual
        $arr_meses = array();
        // Contador para la iteracion de 10 meses anteriores
        $cont = 10;
        while($cont != 0){
            if($date_server == 0){
                $date_server = 12;
            }
            array_push($arr_meses, $date_server);
            $date_server--;
            $cont--;
        }

        return $arr_meses;
    }

    public function get_meses_json(){
        // Obtener los meses dependiendo del servidor
        $arr_meses = $this->get_meses();
        // Convertir el numero de mes a su nombre respectivo
        $arr_nomb_meses = array();
        // Iterar el arreglo para asignar los nombres
        foreach ($arr_meses as $value) {
            if($value == 1){
                array_push($arr_nomb_meses, "Enero");
            }elseif($value == 2){
                array_push($arr_nomb_meses, "Febrero");
            }elseif($value == 3){
                array_push($arr_nomb_meses, "Marzo");
            }elseif($value == 4){
                array_push($arr_nomb_meses, "Abril");
            }elseif($value == 5){
                array_push($arr_nomb_meses, "Mayo");
            }elseif($value == 6){
                array_push($arr_nomb_meses, "Junio");
            }elseif($value == 7){
                array_push($arr_nomb_meses, "Julio");
            }elseif($value == 8){
                array_push($arr_nomb_meses, "Agosto");
            }elseif($value == 9){
                array_push($arr_nomb_meses, "Septiembre");
            }elseif($value == 10){
                array_push($arr_nomb_meses, "Octubre");
            }elseif($value == 11){
                array_push($arr_nomb_meses, "Noviembre");
            }elseif($value == 12){
                array_push($arr_nomb_meses, "Diciembre");
            }
        }
        echo json_encode($arr_nomb_meses);
    }

    // ******************************** Viajes por dias

    public function getEstadisticasViajesPorDias() {
        // Obtener los dias dependiendo del servidor
        $arr_meses_dias = $this->get_meses_anio_dia();
        // Arreglo a devolver
        $arr_viajes_dias = array();
        // Contador para recuperar año y mes
        $cont = 0;
        // Iterar arreglo obtenido
        foreach ($arr_meses_dias as $value) { 
            if($cont == 2){
                $dia = $value;
                // Calcular cuantos viajes por dia se realizan 
                $num_viaje_dias = $this->viajes_dias($anio,$mes,$dia);
                // Agregar al arreglo al devolver
                array_push($arr_viajes_dias, $num_viaje_dias);
                $cont = -1;
            }
            if($cont == 0){
                $anio = $value;
            }elseif($cont == 1){
                $mes = $value;      
            }
            $cont++;
        }
        
        echo json_encode($arr_viajes_dias);
    }

    private function viajes_dias($anio,$meses,$dia){
        // URL para realizar el CURL
        $url = "http://www14.df.gob.mx/virtual/dashboard_cgma/smartCDMX/taxi/v1/index.php/Viajes";
        // Realizar el CURL a la API Taxi y recuperar un arreglo
        $infoViaje = $this->curl_API_Taxi($url);
        // Bandera para controlar realizar el conteo de viajes 
        $flag = 0;
        // Numero total de viajes respecto al mes dado
        $num_viajes_dias = 0;
        // Iteramos el arreglo recuperado
        foreach ($infoViaje as $val) {
            if(($flag == 1)&&($val != "null::")){
                // Separar las comillas
                $fecha = explode('"', $val);
                // Contador necesario
                $cont = 0;
                foreach ($fecha as $f) {
                    if($cont == 1){
                        // Convertimor el string en un date
                        $date = date_create($f);
                        // Obtenemos el año
                        $anio_viaje = date_format($date, 'Y');  
                        if($anio == $anio_viaje){
                            // Obtenemos el mes
                            $mes_viaje = date_format($date, 'm');
                            if($meses == $mes_viaje){
                                // Obtenemos el dia
                                $dia_viaje = date_format($date, 'd');
                                if($dia == $dia_viaje){
                                    // Corresponde al dia
                                    $num_viajes_dias++;
                                }
                            }
                        }
                    }
                    $cont++;
                }
                $flag = 0;
            }
            if($val == "null::"){
                $flag = 0;
            }
            if($val == '"fecha"'){
                $flag = 1;
            }
        }

        return $num_viajes_dias;
    } 

    private function get_meses_anio_dia(){
        // Timestamp del servidor (anio)
        $date_server_dia = date("d");
        // Timestamp del servidor (mes)
        $date_server_mes = date("m");
        // Timestamp del servidor (anio)
        $date_server_anio = date("Y");
        // Arreglo con los meses anteriores al actual
        $arr_meses_anio_dia = array();
        // Contador para la iteracion de 10 meses anteriores
        $cont = 10;
        while($cont != 0){
            if($date_server_dia == 0){
                $date_server_dia = 31; // Puede variar dependiendo del mes con 30 o 31 dias
                $date_server_mes--;
            }
            if($date_server_mes == 0){
                $date_server_mes = 12;
                $date_server_anio--;
            }
            array_push($arr_meses_anio_dia, $date_server_anio);
            array_push($arr_meses_anio_dia, $date_server_mes);
            array_push($arr_meses_anio_dia, $date_server_dia);
            $date_server_dia--;
            $cont--;
        }

        return $arr_meses_anio_dia;
    }

    public function get_dias_json(){
        // Formatea una fecha/hora local según la configuración regional (dias en español)
        setlocale(LC_ALL,"es_ES");
        // Obtener los dias previos al dia actual
        $arr_dias = $this->get_meses_anio_dia();
        // Contador para poder concatenarEstadisticasViajesPorDias
        $cont = 0;
        // Variable para ir guardando las estampillas de tiempo
        $timestamp = "";
        // Arreglo con el nombre de los dias previos al actual
        $dias_arr = array();
        // Bandera para poder iterar
        $flag = 0;
        // Iterar para convertir en timestamp
        foreach ($arr_dias as $value) {
            if($cont == 0){
                $flag = 1;
                
            }
            if($flag = 1){
                // Concatenar y crear un timestamp
                if(($cont == 0)||($cont == 1)){
                    $timestamp = $timestamp.$value."-";
                }else{
                    $timestamp = $timestamp.$value;     
                }
            }
            if($cont == 2){
                $date_dia = date($timestamp);
                // Obtener el nombre de lo dias en base al timestamp
                $dia = strftime("%A",strtotime($date_dia));
                // Codificar en utf8 para los dias como sábado o miércoles
                $d = utf8_encode ($dia);
                // Agregar al arreglo
                array_push($dias_arr, $d);
                // Limpiar las variables
                $timestamp = "";
                $flag = 0;
                $cont = -1;
            }
            $cont++;
        }
        
        echo json_encode($dias_arr);
    }

    // ******************************** Viajes por horas

    public function getEstadisticasViajesPorHoras() {
        // Obtener las horas dependiendo del servidor
        $arr_meses_dias_horas = $this->get_meses_anio_dia_hora();
        // Arreglo a devolver
        $arr_viajes_horas = array();
        // Contador para recuperar año,mes,dia y hora
        $cont = 0;
        // Iterar arreglo obtenido
        foreach ($arr_meses_dias_horas as $value) { 
            if($cont == 3){
                $hora = $value;
                // Calcular cuantos viajes por hora se realizan 
                $num_viaje_horas = $this->viajes_horas($anio,$mes,$dia,$hora);
                // Agregar al arreglo al devolver
                array_push($arr_viajes_horas, $num_viaje_horas);
                $cont = -1;
            }
            if($cont == 0){
                $anio = $value;
            }elseif($cont == 1){
                $mes = $value;      
            }elseif($cont == 2){
                $dia = $value;
            }
            $cont++;
        }
        
        echo json_encode($arr_viajes_horas);
    }

    private function viajes_horas($anio,$meses,$dia,$hora){
        // URL para realizar el CURL
        $url = "http://www14.df.gob.mx/virtual/dashboard_cgma/smartCDMX/taxi/v1/index.php/Viajes";
        // Realizar el CURL a la API Taxi y recuperar un arreglo
        $infoViaje = $this->curl_API_Taxi($url);
        // Bandera para controlar realizar el conteo de viajes 
        $flag = 0;
        // Numero total de viajes respecto a la hora dada
        $num_viajes_horas = 0;
        // Iteramos el arreglo recuperado
        foreach ($infoViaje as $val) {
            if(($flag == 1)&&($val != "null::")){
                // Separar las comillas
                $fecha = explode('"', $val);
                // Contador necesario
                $cont = 0;
                foreach ($fecha as $f) {
                    if($cont == 1){
                        // Convertimor el string en un date
                        $date = date_create($f);
                        // Obtenemos el año
                        $anio_viaje = date_format($date, 'Y');  
                        if($anio == $anio_viaje){
                            // Obtenemos el mes
                            $mes_viaje = date_format($date, 'm');
                            if($meses == $mes_viaje){
                                // Obtenemos el dia
                                $dia_viaje = date_format($date, 'd');
                                if($dia == $dia_viaje){
                                    // Obtenemos la hora
                                    $hora_viaje = date_format($date, 'H');
                                    if($hora == $hora_viaje){
                                        // Corresponde a la hora
                                        $num_viajes_horas++;
                                    }
                                }
                            }
                        }
                    }
                    $cont++;
                }
                $flag = 0;
            }
            if($val == "null::"){
                $flag = 0;
            }
            if($val == '"fecha"'){
                $flag = 1;
            }
        }

        return $num_viajes_horas;
    } 

    private function get_meses_anio_dia_hora(){
        // Timestamp del servidor (hora)
        $date_server_hora = date("H");
        // Timestamp del servidor (dia)
        $date_server_dia = date("d");
        // Timestamp del servidor (mes)
        $date_server_mes = date("m");
        // Timestamp del servidor (anio)
        $date_server_anio = date("Y");
        // Arreglo con las hora anteriores al actual
        $arr_meses_anio_dia_hora = array();
        // Contador para la iteracion de 10 horas anteriores
        $cont = 10;
        while($cont != 0){
            if($date_server_hora == -1){
                $date_server_hora = 23;
                $date_server_dia--;
            }
            if($date_server_dia == 0){
                $date_server_dia = 31; // Puede variar dependiendo del mes con 30 o 31 dias
                $date_server_mes--;
            }
            if($date_server_mes == 0){
                $date_server_mes = 12;
                $date_server_anio--;
            }
            array_push($arr_meses_anio_dia_hora, $date_server_anio);
            array_push($arr_meses_anio_dia_hora, $date_server_mes);
            array_push($arr_meses_anio_dia_hora, $date_server_dia);
            array_push($arr_meses_anio_dia_hora, $date_server_hora);
            $date_server_hora--;
            $cont--;
        }

        return $arr_meses_anio_dia_hora;
    }

    public function get_horas_json(){
        // Obtener los dias previos al dia actual
        $arr_horas = $this->get_meses_anio_dia_hora();
        // Contador para poder unir al arreglo
        $cont = 0;
        // Variable para ir guardando las estampillas de tiempo
        $timestamp = "";
        // Arreglo con el nombre de los dias previos al actual
        $horas_arr = array();
        // Bandera para poder iterar
        $flag = 0;
        // Iterar para convertir en timestamp
        foreach ($arr_horas as $value) {
            if($cont == 3){
                // Recuperar la hora
                $hora = $value;
                // Concatenar para mostrar en la vista
                $hora = $hora.":00 hrs.";
                // Agregar al arreglo
                array_push($horas_arr, $hora);
                $cont = -1;
            }
            $cont++;
        }
        
        echo json_encode($horas_arr);
    }

/*********************************************************************************************/


    // Metodo que checa si el viaje entra en un lapso de 5 min
    private function checarlapso($datediff_server,$fecha_recuperada){
        $date = date($fecha_recuperada);
        // Convertir en un date para comparar
        $datediff = date_create($date);
        // Comparar la diferencia entre el date del servidor y el obtenido
        $diff = date_diff($datediff_server,$datediff);
        $diffy = $diff->format("%y");
        if($diffy == 0){ // Mismo año
            $diffm = $diff->format("%m");
            if($diffm == 0){ // Mismo mes
                $diffd = $diff->format("%d");
                if($diffd == 0){ // Mismo dia
                    $diffh = $diff->format("%h");
                    if($diffh == 0){ // Misma hora
                        return 1;
                    /*  $diffi = $diff->format("%i");
                        if($diffi <= 5){ // Lapso de 5 min
                            return 1;
                        }*/
                    }else{
                        return 0;
                    }
                }else{
                    return 0;
                }
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }



    // Metodo que llama a la seccion de mapas
    public function seccion_mapas(){


        $this->load->view('dashboard_v.php');
            $this->load->view('dashboard_header.php');

            
            $this->load->view('dashboard_footer.php');
        // URL para realizar el CURL
        $url = "http://www14.df.gob.mx/virtual/dashboard_cgma/smartCDMX/taxi/v1/index.php/Viajes";
        // Contador para los viajes realizados en un lapso de 5 minutos
        $num_viajes = 0;
        // Timestamp del servidor
        $date_server = date("Y-m-d H:i:s");
        // Convertir en un date para comparar
        $datediff_server = date_create($date_server);
        // Realizar el CURL a la API Taxi y recuperar un arreglo
        $info_lat_long = $this->curl_API_Taxi($url);
        // Arreglo para enviar a la vista
        $data_lat_long = array();
        // Bandera para controlar los viajes en un lapso de 5 min 
        $flag = 0;

        /*************************************************************************************/
        /* Esta seccion es para obtener latitudes y longitudes mas recientes (hace 5 min) ****/

        // Bandera para checar las latitudes 
        $flag2 = 0;
        // Bandera para checar las longitudes
        $flag3 = 0;
        // Iteramos el arreglo recuperado
        foreach ($info_lat_long as $val) {
            if(($flag == 1)&&($val != "null::")){
                // Separar las comillas
                $fecha = explode('"', $val);
                // Contador necesario
                $cont = 0;
                foreach ($fecha as $f) {
                    if($cont == 1){
                        // Llamar al metodo que checara si fue un viaje hace 5 min
                        $resultado = $this->checarlapso($datediff_server,$f);
                        if($resultado == 1){ // Entra en el lapso de 5 min
                            // Separar las comillas de latitud
                            $lat = explode('"', $latitud);
                            // Contador necesario
                            $cont = 0;
                            foreach ($lat as $val_lat) {
                                if($cont == 1){
                                // Insertar latitud en el arreglo
                                    array_push($data_lat_long, $val_lat);
                                }
                                $cont++;
                            }
                            // Separar comillas de longitud
                            $long = explode('"', $longitud);
                            // Contador necesario
                            $cont = 0;
                            foreach ($long as $val_long) {
                                if($cont == 1){
                                // Insertar longitud en el arreglo
                                    array_push($data_lat_long, $val_long);
                                }
                                $cont++;
                            }
                        }
                    }
                    $cont++;
                }
                $flag = 0;
            }elseif ($flag2 == 1) { // Guardar valor de latitud
                $latitud = $val;
                $flag2 = 0;
            }elseif ($flag3 == 1) { // Guardar valor de longitud
                $longitud = $val;
                $flag3 = 0;
            }
            
            if($val == "null::"){
                $flag = 0;
            }elseif($val == '"fecha"'){ // Encontrar fechas
                $flag = 1;
            }elseif($val == '"lat_origen"'){ // Encontrar latitudes
                $flag2 = 1;
            }elseif($val == '"long_origen"'){ // Encontrar longitudes
                $flag3 = 1;
            }
        } 
        /**************************************************************************************/

        /*************************************************************************************/
        /* Esta seccion es para recuperar todas las latitudes y longitudes (no es dinamico) **/

        // Iterar el arreglo recuperado
    /*  foreach ($info_lat_long as $val) {
            if($flag == 1){
                // Separar las comillas
                $lat = explode('"', $val);
                // Contador necesario
                $cont = 0;
                foreach ($lat as $value) {
                    if($cont == 1){
                        // Insertar latitud o longitud en el arreglo
                        array_push($data_lat_long, $value);
                    }
                    $cont++;
                }
                $flag = 0;
            }
            // Encontrar latitudes y longitudes
            if(($val == '"lat_origen"')||($val == '"long_origen"')){
                $flag = 1;
            }
        }*/

        /************************************************************************************/
        // Añadir el arreglo al arreglo final
        $data = array(
            'data_lat_long' => $data_lat_long
            );           
            
            $this->load->view('dashboard_mapas.php', $data);
        }



        // Metodo que realiza el CURL a la API Taxi
        private function curl_API_Taxi($url){
            // Inicializar CURL para pedir la informacion 
            $respuesta_APITaxi = curl_init();
            curl_setopt($respuesta_APITaxi,CURLOPT_URL, $url);
            // Procesar el JSON
            curl_setopt($respuesta_APITaxi, CURLOPT_RETURNTRANSFER, true);
            // Ejecutar el CURL
            $JSON_recuperado = curl_exec($respuesta_APITaxi);
            // Cerrar el CURL
            curl_close($respuesta_APITaxi);

            // Se recupero un JSON de la API Taxi
            if(! is_null($JSON_recuperado)){
                // Tratar el JSON, quitando caracteres: ","
                $arr_sin_comas = explode(",", $JSON_recuperado);
                // Bandera inicializada en 0
                $flag = 0;
                // Inicializar valor de fecha
                $fecha = "";
                // Contador a usar 
                $cont = 0;
                // Crear arreglo para regresar
                $nuevo_arr = array();

                foreach($arr_sin_comas as $val_sin_comas) {
                    // Tratar el JSON, quitando caracteres: ":"
                    $arr_sin_doble_punto = explode(":", $val_sin_comas);
                    foreach ($arr_sin_doble_punto as $val_sin_doble_punto) {
                        // Tratar el JSON, quitando caracteres: "{"
                        $arr_sin_llaves_i = explode("{", $val_sin_doble_punto);
                        foreach ($arr_sin_llaves_i as $val_sin_llaves_i) {
                            // Tratar el JSON, quitando caracteres: "}"
                            $arr_sin_llaves_f = explode("}", $val_sin_llaves_i);
                            foreach ($arr_sin_llaves_f as $val2) {
                                // Calcular el largo del valor del arreglo
                                $large = strlen($val2);
                                // Si la bandera esta levantada, se va a tratar el valor de la fecha
                                if($flag == 1){
                                    if(($cont == 0)||($cont == 1)){
                                        $fecha = $fecha.$val2.":";
                                    }else{
                                        $fecha = $fecha.$val2;
                                    }
                                    $cont++;
                                }else{
                                    // Unir el valor de la fecha al arreglo 
                                    array_push($nuevo_arr, $val2);
                                }
                                // Encontro el valor "fecha"
                                if($large == 7){ 
                                    $flag = 1;
                                }
                                // Agregar el timestamp al arreglo
                                if($cont == 3){ 
                                    $flag = 0; // Valor inicializado nuevamente
                                    $cont = 0; // Valor inicializado nuevamente
                                    array_push($nuevo_arr, $fecha);
                                    $fecha = ""; // Valor inicializado nuevamente
                                }
                            }
                        }
                    }
                }

                //return $nuevo_arr;
                $arr_return = array(); // Arreglo a devolver
                $flag2 = 0;
                $flag3 = 0;
                $flag4 = 0;
                $flag5 = 0;
                $cont2 = 0;
                foreach ($nuevo_arr as $val_narr) {
                    if($flag3 == 1){ 
                        if($val_narr != '"fecha"'){
                            // Tratar el JSON, quitando el ":" de las fechas
                            $arr_sin_doble_punto = explode(":", $val_narr);
                            foreach ($arr_sin_doble_punto as $val_s_doble_punto) {
                                if($cont2 == 0){ // Agrego fecha
                                    array_push($arr_return, $val_s_doble_punto);
                                }elseif($cont2 == 1){ // Concatenar para timestamp (horas)
                                    $valor = $val_s_doble_punto.":";
                                }elseif($cont2 == 2){ // Concatenar para timestamp (minutos)
                                    $valor2 = $valor.$val_s_doble_punto;
                                    array_push($arr_return, $valor2);
                                }
                                $cont2++;
                            }
                            $flag4 = 1;
                            $cont2 = 0;
                        }
                        $flag3 = 0;
                    }
                    if ($flag4 == 0) {
                        array_push($arr_return, $val_narr);
                    }
                    if($flag2 == 1){
                        $flag3 = 1;
                        $flag2 = 0;
                    }
                    if($val_narr == '"nivel_confianza"'){
                        $flag2 = 1;
                    }
                    $flag4 = 0;
                }
                return $arr_return;
            }else{
                return NULL;
            }
            
        }
    }

     
?>