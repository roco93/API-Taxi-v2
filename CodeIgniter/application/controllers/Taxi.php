<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Taxi extends CI_Controller {
	function _construct(){
		parent::_construct();
	}

	// Metodo que llama a la pagina principal
	public function index()
	{
		// URL para realizar el CURL
		$url = "http://www14.df.gob.mx/virtual/dashboard_cgma/smartCDMX/taxi/v1/index.php/Viajes";
		// Contador para los viajes en un lapso de 5 minutos
		$num_viajes = 0;
		// Contador para iterar y obtener datos de la API Taxi
		$num = 0;
		// Timestamp del servidor
		$date_server = date("Y-m-d H:i:s");
		// Convertir en un date para comparar
		$datediff_server = date_create($date_server);
		// Variable infViaje para obtener la información de la API Taxi
		$infoViaje = "viaje";

		while($infoViaje != NULL){
			$infoViaje=$this->curl_comentarios($url,$num);
			$hey = $infoViaje["fecha"];
			// Timestamp recuperado del CURL
			//echo $hey;
			$date = date($hey);
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
							$diffi = $diff->format("%i");
							if($diffi <= 5){ // Lapso de 5 min
								$num_viajes++;
								echo $num_viajes;
							}
						}
					}
				}
			}
			$num++;
		}

		//$num_viajes = 1400;
		$num_incidentes = 2;
		$data = array(
			'num_viajes' => $num_viajes,
			'num_incidentes' => $num_incidentes
		);
		$this->load->view('pagina_principal/index.php',$data);
	}

	// Metodo que llama a la seccion de taxistas
	public function seccion_taxistas(){
		// Debido a que la API Taxi no regresa un JSON con todos los taxistas,
		// se deben trabajar on datos crudos.
		$num_total_taxistas = 1000;
		$num_taxistas_aprobados = 450;
		$num_taxistas_reprobados = 550;
		$taxistas_aprobados = array('7845871','9.82','345','4132543','8.89','324','7623673','8.587','567','0992333','7.96','634','6734879','7.28','554');
		$taxistas_reprobados = array('8721482','4.88','776','7623123','4.12','763','7827322','3.68','555','2346297','3.33','345','5872374','2.56','765');
		// Crear el arreglo para dar a la vista los valores necesarios
		$data_taxista = array(
			'num_total_taxistas'  => $num_total_taxistas,
			'num_taxistas_aprobados' => $num_taxistas_aprobados,
			'num_taxistas_reprobados' => $num_taxistas_reprobados,
			'taxistas_aprobados' => $taxistas_aprobados,
			'taxistas_reprobados' => $taxistas_reprobados
			);
		$this->load->view('pagina_principal/taxistas.php',$data_taxista);
	}

	// Metodo que llama a la seccion de estadisticas
	public function seccion_estadisticas(){

	}

	// Metodo que llama a la seccion de mapas
	public function seccion_mapas(){

	}

	// Metodo que realiza el CURL a la API Taxi
	private function curl_comentarios($url,$num){
		// Realizar el CURL en base al url dado
		$json_rcb = file_get_contents($url);
		// Se convierte en un array asociativo
		$arr_rcb = json_decode($json_rcb,true);

		if (count($arr_rcb["response"] >= 1)) {  
			//Se separan los datos recibidos
			$arrDatosViaje = array(
				'id_viaje' => $arr_rcb["response"][$num]["id_viaje"],
				'id_taxi' => $arr_rcb["response"][$num]["id_taxi"],
				'id_comentarios' => $arr_rcb["response"][$num]["id_estatus_viaje"],
				'id_taxista' => $arr_rcb["response"][$num]["id_taxista"],
				'ident_dispositivo' => $arr_rcb["response"][$num]["ident_dispositivo"],
				'lat_origen' => $arr_rcb["response"][$num]["lat_origen"],
				'long_origen' => $arr_rcb["response"][$num]["long_origen"],
				'lat_destino' => $arr_rcb["response"][$num]["lat_destino"],
				'long_destino' => $arr_rcb["response"][$num]["long_destino"],
				'calificacion' => $arr_rcb["response"][$num]["calificacion"],
				'nivel_confianza' => $arr_rcb["response"][$num]["nivel_confianza"],
				'fecha' => $arr_rcb["response"][$num]["fecha"]
					);
			return $arrDatosViaje;
		}else{
			return NULL;		
		}
	}

	public function bryan182(){
		$num_viajes = 1400;
		$num_incidentes = 2;
		$data = array(
			'num_viajes' => $num_viajes,
			'num_incidentes' => $num_incidentes
		);
		$this->load->view('index.php',$data);
	}
}
