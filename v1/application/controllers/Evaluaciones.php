<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*Descomentar la siguiente linea para poder hacer uso de hilos en esta API.*/
//include 'curlConductores.php';

require APPPATH . "/libraries/REST_Controller.php";
/**
 * Clase que se encarga de obtener la evaluacion del taxi solicitado.
 * @author C.Cecilia Hernandez Vasquez <cecilia_hdz12[at]hotmail.com>
 *         C.Gilberto Aviles Acosta <gavilesac89[at]gmail.com>
 */
class Evaluaciones extends REST_Controller {
	/**
	 * Contructor de la clase Evaluaciones. 
	 * Carga el modelo necesario para este controlador.
	 */
	public function __construct() {
		parent::__construct();
		$this->load->model('evaluaciones_m');
	}

	/**
	 * index_get() Metodo que podra ser usado en el futuro. En esta primera version no esta definido aun.
	 * 				se reserva para su uso futuro.
	 * @return JSON Envoltorio con los datos y un código con el resultado de la operación.
	 */
	public function index_get()	{
		
		$this->response(array('Sin Contenido ' => " Reservado para uso futuro", 204));
	}

	/**
	 * find_get() Se encarga de obtener el nivel de confianza del taxi, 
	 * 				ademas de crear el viaje para el usuario en la BD.
	 * @param  String $placas      Las placas del taxi.
	 * @param  String $lat_origen  La latidud del origen del viaje.
	 * @param  String $long_origen la longitud del origen del viaje.
	 * @return JSON Envoltorio con los datos y un código con el resultado de la operación.
	 */
	public function find_get($placas = NULL, $lat_origen = NULL, $long_origen = NULL)	{
		if (is_null($lat_origen) || is_null($long_origen)) {
			$this->response(array('Solicitud Incorrecta ' => " Parametros incompletos, favor de verificar", 400));
		}
		$calificacionTaxi=0;
		$nivelConfianza=95;
		$arrDatosTaxi=[];
		$arrDatosConcesionario=[];
		$arrayTaxistas=[];

		$url_taxi="http://datos.labplc.mx/movilidad/taxis/".$placas.".json";
		$json_placas = $this->conexionLABPLC($url_taxi);
		
		if (count($json_placas["Taxi"]["concesion"])>1) {
			//Separamos datos del concesionario y del taxi
			$arrDatosConcesionario = array('nombre' => $json_placas["Taxi"]["concesion"]["nombre"],
											'ap_paterno' => $json_placas["Taxi"]["concesion"]["apellido_paterno"],
											'ap_materno' => $json_placas["Taxi"]["concesion"]["apellido_materno"] );

			$arrDatosTaxi = array('placas' => $json_placas["Taxi"]["concesion"]["placa"],
									'marca' => $json_placas["Taxi"]["concesion"]["marca"],
									'modelo' => $json_placas["Taxi"]["concesion"]["submarca"],
									'anio' => $json_placas["Taxi"]["concesion"]["anio"]);
		}else{
			$nivelConfianza=$nivelConfianza-50;
		}
		
		$url_vehiculo="http://datos.labplc.mx/movilidad/vehiculos/".$placas.".json";
		$json_vehiculo = $this->conexionLABPLC($url_vehiculo);
		
		$calificacionTaxi=$this->generarCalificacionTaxi($json_vehiculo,$nivelConfianza,$arrDatosTaxi);

		$arrayTaxi = array('placas' => $placas,'nivel_confianza'=>$nivelConfianza );
		
		$consultaTaxi=$this->evaluaciones_m->updateTaxi($placas,$arrayTaxi);

		if(is_null($consultaTaxi)){
			$this->evaluaciones_m->saveTaxi($arrayTaxi);
		}
		
		$id_taxi = $this->evaluaciones_m->get($placas);
		$arrDatosTaxi['id_taxi']=$id_taxi['id_taxi'];
		
		$sumaCalificacionTaxistas=0;
		$calificacionPromedioTaxistas=0;

		$identificadores=$this->evaluaciones_m->getTaxistas($placas);
		$calificacionTaxistas=0;
		$totalTaxistas=count($identificadores);
		if ($totalTaxistas>0) {
			for ($i=0; $i < $totalTaxistas; $i++) {
				$acumulado=$identificadores[$i]["acumulado_calificacion"];
				$viajes=$identificadores[$i]["numero_viajes"];
				if ($viajes>0) {
				 	$sumaCalificacionTaxistas = $sumaCalificacionTaxistas+($acumulado/$viajes);
				 } 
			}
			$calificacionPromedioTaxistas = ($sumaCalificacionTaxistas/$totalTaxistas)*20;
		}

		// /**
		//  * Aqui usamos hilos para conocer los datos de los taxistas asociados al taxi.
		//  * Descomentamos la siguiente linea para el uso con hilos en la API y comentamos la linea 103.
		//  */
		// // $arrayTaxistas=$this->obtenerDatosTaxistaHilos($identificadores);
		
		/*La siguiente linea de codigo es para el uso de esta API obteniendo los datos de los taxistas 
		  la comentamos si se desea usar hilos.*/
		$arrayTaxistas=$this->obtenerDatosTaxistaSecuencial($identificadores);

		$nivelConfianza=$this->generaEvaluacion($calificacionTaxi,$calificacionPromedioTaxistas);

		//Cargamos el modelo de viajes
		$this->load->model('viajes_m');
		$posData = array('lat_origen' => $lat_origen, 'long_origen' => $long_origen);
		$id_viaje=$this->viajes_m->save($posData);

		$this->response(array('concesionario' => $arrDatosConcesionario,
		 					'taxi'=> $arrDatosTaxi,
		 					'taxistas' => $arrayTaxistas,
		 					'nivelConfianza' => $nivelConfianza,
		 					'id_viaje' => $id_viaje));
		
	}//find_get

	/**
	 * index_post() Este metodo permitira guardar datos en la base de datos relacionada a esta API.
	 * 				Se reserva su uso futuro.
	 * @return JSON Envoltorio con los datos y un código con el resultado de la operación.
	 */
	public function index_post(){
		$this->response(array('Sin Contenido ' => " Reservado para uso futuro", 204));
	}

	/**
	 * index_put() Este metodo permitira la actualizacion de datos a traves de un id.
	 * 				Se reserva para su uso futuro.
	 * @param  num $id el id relacionado a los datos a actualizar.
	 * @return JSON Envoltorio con los datos y un código con el resultado de la operación.
	 */
	public function index_put($id){
		$this->response(array('Sin Contenido ' => " Reservado para uso futuro", 204));
	}

	/**
	 * index_delete() Este metodo permitira la eliminacion de datos a traves de in id.
	 * 				Se reserva para su uso futuro.
	 * @param  num $id el id relacionado a los datos a eliminar.
	 * @return JSON Envoltorio con los datos y un código con el resultado de la operación.
	 */
	public function index_delete($id){
		$this->response(array('Sin Contenido ' => " Reservado para uso futuro", 204));
	}

	/**
	 * Genera la calificacion del taxi, basada en el algoritmo de TRAXI
	 * @param  JSON   $json_vehiculo  JSON con los datos del vehiculo
	 * @param  double $nivelConfianza Variable donde se guardara el nivel de confianza
	 * @param  array  $arrDatosTaxi   Los datos del tipo de vehiculo del taxi
	 * @return double El nivel de confianza del taxi
	 */
	private function generarCalificacionTaxi($json_vehiculo,$nivelConfianza,$arrDatosTaxi){
		if ($json_vehiculo["consulta"]["tenencias"]["tieneadeudos"]!==0) {
			$nivelConfianza=$nivelConfianza-5;
		}
		if (! $this->infraccionesf($json_vehiculo)) {
			$nivelConfianza=$nivelConfianza-25;
		}
		if ($this->verificaciones($json_vehiculo)) {
			$nivelConfianza=$nivelConfianza-5;
		}
		$hoy=getdate();
		$anioModelo=0;
		if (count($arrDatosTaxi)>0) {
			$anioModelo= strtotime($arrDatosTaxi["anio"]); 
		}
		if (($hoy[0]-$anioModelo) > 8) {
			$nivelConfianza=$nivelConfianza-10;
		}

		return $nivelConfianza;
	}

	/**
	 * Conecta con las API's del Laboratorio para la Ciudad
	 * @param  String $urlApi URL al cual nos queremos conectar
	 * @return JSON Envoltorio con los datos
	 */
	private function conexionLABPLC ($urlApi){
		$request = curl_init();
		curl_setopt($request,CURLOPT_URL,$urlApi);

		//esta linea es importante para poder procesar la respuesta json
		curl_setopt($request, CURLOPT_RETURNTRANSFER, true);

		//ejecutamos
		$respuesta = curl_exec($request);
		curl_close($request);
		
		//convertimos el json de respuesta en un array asociativo
		$json = json_decode($respuesta, true);
		return $json;
	}

	/**
	 * Permite obtener los datos del taxista usando hilos
	 * @param  array $identificadores arreglo con los identificadores de los taxistas relacionados con el taxi
	 * @return array arreglo con los datos de los taxistas
	 */
	private function obtenerDatosTaxistaHilos($identificadores){
		$urls=[];
		for ($i=0; $i <count($identificadores) ; $i++) { 
			$url="http://datos.labplc.mx/movilidad/taxis/conductor.json?identificador=".$identificadores[$i]["identificador"];
			array_push($urls,$url);
		}
		$g = new AsyncWebRequest($urls);
		$g->start();

		return $g->arrayT;

	}

	/**
	 * Permite obtener los datos del taxista 
	 * @param  array $identificadores arreglo con los identificadores de los taxistas relacionados con el taxi
	 * @return array arreglo con los datos de los taxistas
	 */
	private function obtenerDatosTaxistaSecuencial($identificadores){
		$arrayTaxistasM=[];
		for ($i=0; $i < count($identificadores); $i++) { 
			$url="http://datos.labplc.mx/movilidad/taxis/conductor.json?identificador=".$identificadores[$i]["identificador"];
			$json_taxista=$this->conexionLABPLC($url);
			$nombre = $this->quitaEspacios($json_taxista["Taxi"]["conductor"]["nombre"]);
			$apellido_paterno = $this->quitaEspacios($json_taxista["Taxi"]["conductor"]["apellido_paterno"]);
			$apellido_materno = $this->quitaEspacios($json_taxista["Taxi"]["conductor"]["apellido_materno"]);
			array_push($arrayTaxistasM, $json_taxista["Taxi"]);
			$arrayTaxistasM[$i]['conductor']['id_taxista'] = $identificadores[$i]["id_taxista"];
			$arrayTaxistasM[$i]['conductor']['nombre'] = $nombre;
			$arrayTaxistasM[$i]['conductor']['apellido_paterno'] = $apellido_paterno;
			$arrayTaxistasM[$i]['conductor']['apellido_materno'] = $apellido_materno;
		}
		return $arrayTaxistasM;
	}

	/**
	 * Permite conocer si un vehiculo tiene infracciones
	 * @param  JSON $json_vehiculo JSON con la informacion del vehiculo
	 * @return <b>true</b> si el vehiculo tiene infracciones. <b>false</b> en otro caso
	 */
	private function infraccionesf($json_vehiculo) {
	 	$bandera=false;
		$infracciones=$json_vehiculo["consulta"]["infracciones"];
		if (count($infracciones) >0) {
			foreach ($infracciones as $key => $value) {
				if (strcmp($value["situacion"],'Pagada')!==0) {
					$bandera=true;	
				}
				
				
			}
		}
		return $bandera;

	}

	/**
	 * Permite conocer si un vehiculo paso sus verificaciones
	 * @param  JSON $json_vehiculo JSON con la informacion del vehiculo
	 * @return <b>true</b> si el vehiculo no paso las verificaciones. 
	 *         <b>false</b> si paso sus verificaciones
	 */
	private function verificaciones($json_vehiculo){
		$bandera=false;
		$cont=0;
		$verificacion=$json_vehiculo["consulta"]["verificaciones"];
		if ($verificacion === 'intente_mas_tarde') {
			return $bandera;
		}
		if (count($verificacion)>0) {
			foreach ($verificacion as $key => $value) {
				$hoy=getdate();
				$fechaVerificacion= strtotime($value["fecha_verificacion"]); 
				$fechaVigencia=strtotime($value["vigencia"]); 

				if ($hoy[0]-$fechaVerificacion< 31556926) {
					$bandera=false;
					$cont =$cont+1;
					if (strcmp($value["resultado"],'RECHAZO')===0) {
						$bandera=true;
					}
				}
				else {
					if ($cont==0) {
						$bandera=true;
					}
					
				}
			}
		}
		return $bandera;

	}

	/**
	 * generaEvaluacion Genera el nivel de confianza total para el usuario
	 * @param  $y Valor de la calificacion del taxi
	 * @param  $x Valor de la calificacion del taxista
	 * @return El nivel de confianza total para ese viaje
	 */
	private function  generaEvaluacion($y, $x){
	
		if($x==0 && $y==0){
			$n=0;
		}
		if($x==0 && $y!=0){
			$n=($y/2)+10;
		}
		if($x!=0 && $y==0){
			$n=$x/2;
		}
		if($x>0 && $y>0){
			$alfa=$this->peso($x);
			$ganma=$this->peso($y);
			$n=(((($alfa*$x)+($ganma*$y))/($x+$y)))*10;
		}
		$n = number_format($n,2);
		return $n;
	}
	
	/**
	 * Permite conocer el "peso" de la variable para el modelo
	 * @param  double $x la variable de la cual se quiere conocer su peso
	 * @return double el valor del peso para la variable
	 */
	private function  peso($x) {
		
		if($x>=0 && $x<=10){
			$peso=1;
		}else if($x>10 && $x<=20){
			$peso=2;
		}else if($x>20 && $x<=30){
			$peso=3;
		}else if($x>30 && $x<=40){
			$peso=4;
		}else if($x>40 && $x<=50){
			$peso=5;
		}else if($x>50 && $x<=60){
			$peso=6; 
		}else if($x>60 && $x<=70){
			$peso=7;
		}else if($x>70 && $x<=80){
			$peso=8;
		}else if($x>80 && $x<=90){
			$peso=9;
		}else if($x>90 && $x<=100){
			$peso=10;
		}
		return $peso;
	}

	/**
	 * Elimina los espacios adicionales que se agregan en las API's del LABPLC
	 * @param  $datos La variable a la cual se le quitaran los espacios adicionales
	 * @return La informacion del taxista sin espacios adicionales
	 */
	private function quitaEspacios($datos){
		
		$dato = trim($datos);
		
		return $dato;
	}
	
}

/* End of file Evaluaciones.php */
/* Location: ./application/controllers/Evaluaciones.php */