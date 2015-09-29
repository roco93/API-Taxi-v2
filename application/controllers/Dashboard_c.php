<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    class Dashboard_c extends CI_Controller {

        function _construct(){
        parent::_construct();
        
    //Loading url helper
    //$this->load->helper('url');
    }

        public function estadisticas(){

            $this->load->view('dashboard_v.php');
            $this->load->view('dashboard_header.php');
            $this->load->view('dashboard_estadisticas.php');
            $this->load->view('dashboard_footer.php');
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