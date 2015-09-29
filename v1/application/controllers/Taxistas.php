<?php 
	defined('BASEPATH') OR exit('No direct script access allowed');

	require APPPATH . "/libraries/REST_Controller.php";

	/**
	 * Clase Taxistas elaborada por el C. Roberto Carlos Espinoza Santiago y 
	 * el C. Bryan Velazquez Moreno
	 */

	class Taxistas extends REST_Controller{
		function __construct(){
			parent::__construct();
			$this->load->model('taxistas_m');
		}

		/**
	 	* index_get Obtiene todos los taxistas almacenados en la base de datos
	 	* @return JSON Envoltorio con los datos y un código con el resultado de la operación
	 	*/

		public function index_get()	{
			$taxistas = $this->taxistas_m->get();

			if ( ! is_null($taxistas)) {
				$this->response(array('response' => $taxistas, 200));
			} else {
				$this->response(array('mensaje' => "No hay taxistas", 404));
			}
		}

		/**
	 	* find_get Obtiene un taxista a partir de su id almacenado en la base de datos
	 	* @return JSON Envoltorio con los datos y un código con el resultado de la operación
	 	*/

		public function find_get($nombre=NULL,$apellido_paterno=NULL,$apellido_materno=NULL,$id_taxi=NULL)	{
			$url = "http://datos.labplc.mx/movilidad/taxis/conductor.json?";

			$nombres=preg_split("/%20/", $nombre);
			if (count($nombres)>1) {
				$nombre=$nombres[0]." ".$nombres[1];
			}else{
				$nombre=$nombres[0];
			}
			
			$vars = array('nombre' => $nombre,
						'apellido_paterno' => $apellido_paterno,
						'apellido_materno' => $apellido_materno,
						'id_taxi' => $id_taxi
						);
			switch ($vars) {

				case !is_null($vars['apellido_materno']): 
					// echo 'caso 1 Buscar nombre: '.$vars['nombre'].', apellido paterno:'.$vars['apellido_paterno'].' y apellido materno: '.$vars['apellido_materno'];
			
					// //En este caso si identificador es null, concatenamos apellidos y nombre
					$url=$url."nombre=".$nombre."&apellido_paterno=".$apellido_paterno."&apellido_materno=".$apellido_materno;
					//Funcion que realizara el curl
					$infoTaxista=$this->consulta_labpc($url);

					$identTaxista;
					$idtaxi_has_taxista;
					if ( ! is_null($infoTaxista)) {
						$resulTaxista = $this->taxistas_m->get($infoTaxista['identificador']);

						$altaTaxista = array('identificador' => $infoTaxista['identificador'],
									'acumulado_calificacion' => 0,
									'numero_viajes' => 0
									);
						// Si no existe en la base de datos, lo guardamos
						if( is_null($resulTaxista) ){
							$identTaxista = $this->taxistas_m->save($altaTaxista);
							// Al gusrdarlo, tambien creamos la relacion del taxista con el taxi
							if (!is_null($identTaxista)) {
								$relacion = array('id_taxi' => $id_taxi,
													'id_taxista' => $identTaxista,
													'fecha' => $this->obtenerFecha());
								$idtaxi_has_taxista = $this->taxistas_m->saveRelacion($relacion); 
							}
						}else{
							$identTaxista = $resulTaxista[0]['id_taxista'];
							$idtaxi_has_taxista = $this->taxistas_m->getRelacion($identTaxista,$id_taxi);
							if (is_null($idtaxi_has_taxista)) {
								$relacion = array('id_taxi' => $id_taxi,
													'id_taxista' => $identTaxista,
													'fecha' => $this->obtenerFecha());
								$idtaxi_has_taxista = $this->taxistas_m->saveRelacion($relacion); 
							}
						}
						$infoTaxista['id_taxista'] = $identTaxista;
						$this->response(array('response' => $infoTaxista, 200));
					} 
					else {
						$this->response(array('error' => "Ha ocurrido un error", 400));
					}																																																																																																																																																																																																																																																		
				break;

				case is_null($vars['apellido_materno']):			
					// caso 2 Buscar identificadoris_null($vars['identificador'])

					//En este caso si apellidos y nombre son null, concatenamos el identificador
					$url=$url."identificador=".$nombre;
					
					//Funcion que realizara el curl
					$infoTaxista=$this->consulta_labpc($url);
					$identTaxista;
					$idtaxi_has_taxista;
					if ( ! is_null($infoTaxista)) {
					/*** Consulta a BD ***/
						$resulTaxista = $this->taxistas_m->get($infoTaxista['identificador']);

						$altaTaxista = array('identificador' => $infoTaxista['identificador'],
									'acumulado_calificacion' => 0,
									'numero_viajes' => 0
									);

						//Si no existe en la base de datos
						if( is_null($resulTaxista) ){
							$identTaxista = $this->taxistas_m->save($altaTaxista);
							if (!is_null($identTaxista)) {
								$relacion = array('id_taxi' => $apellido_paterno,
													'id_taxista' => $identTaxista);
								$idtaxi_has_taxista = $this->taxistas_m->saveRelacion($relacion); 
							}
						}else{
							$identTaxista = $resulTaxista[0]['id_taxista'];
							$idtaxi_has_taxista = $this->taxistas_m->getRelacion($identTaxista,$id_taxi);
							if (is_null($idtaxi_has_taxista)){
								$relacion = array('id_taxi' => $id_taxi,
													'id_taxista' => $identTaxista,
													'fecha' => $this->obtenerFecha());
								$idtaxi_has_taxista = $this->taxistas_m->saveRelacion($relacion); 
							}
						}
						$infoTaxista['id_taxista'] = $identTaxista;

						$this->response(array('response' => $infoTaxista, 200));
					} else {
						$this->response(array('error' => "Ha ocurrido un error", 400));
				}
				break;
				
				default:
					$this->response(array('error' => "Taxista no encontrado", 400));
				break;
			}
			
		}
	

		/**
	 	* index_post Inserta un nuevo taxista en la base de datos
	 	* @return JSON Envoltorio con los datos y un código con el resultado de la operación
	 	*/

		public function index_post()	{
			if ( ! $this->post('identificador') && ! $this->post('acumulado_calificacion') && ! $this->post('num_viajes')) {
				$this->response(NULL, 400);
			}

			$TaxistaArr = array('identificador' => $this->post('identificador'),'acumulado_calificacion' => $this->post('acumulado_calificacion'),'numero_viajes' => $this->post('numero_viajes'));
			$publish = $this->taxistas_m->save($TaxistaArr);

			if ( ! is_null($publish)) {
				$this->response(array('response' => $publish, 200));
			} else {
				$this->response(array('error' => "Ha ocurrido un error", 400));
			}
		}

		/**
	 	* index_put Actualiza un taxista almacenado en la base de datos
	 	* @return STRING Mensaje y un código con el resultado de la operación
	 	*/

		public function index_put($id)	{
			if ( ! $id || ! $this->put("acumulado_calificacion") || ! $this->put("num_viajes")) {
				$this->response(NULL, 400);
			}
			$taxistaDB = $this->taxistas_m->getInfoTaxista($id);
			
			$newAcumulado = $taxistaDB[0]['acumulado_calificacion'] + $this->put("acumulado_calificacion");
			$newNumeroViajes = $taxistaDB[0]['numero_viajes'] + $this->put("num_viajes");
			
			$TaxistaArr = array('acumulado_calificacion' => $newAcumulado,
								'numero_viajes' => $newNumeroViajes);
			$update = $this->taxistas_m->update($id, $TaxistaArr);

			if ( ! is_null($update)) {
				$this->response(array('response' => "Taxista actualizado", 200));
			} else {
				$this->response(array('error' => "Ha ocurrido un error", 400));
			}
		}

		/**
	 	* index_delete Elimina un taxista almacenado en la base de datos
	 	* @return STRING Mensaje y un código con el resultado de la operación
	 	*/		

		public function index_delete($id)	{
			if ( is_null($id)) {
				$this->response(NULL, 400);
			} else {
				$delete = $this->taxistas_m->delete($id);
				if ( ! is_null($delete)) {
					$this->response(array('response' => "Taxista eliminado", 200));
				} else {
					$this->response(array('error' => "Ha ocurrido un error", 400));
				}
			}
		}

		/**
		 * consulta_labplc Se comunica con la API del Lapc para extraer los datos del taxista
		 * @return ARRAY Información del taxista 
		 */

		private function consulta_labpc($url){
			// inicializar CURL para pedir la informacion 
			$request_infotaxista = curl_init();
			curl_setopt($request_infotaxista,CURLOPT_URL, $url);
			// esta linea es importante para poder procesar la respuesta json
			curl_setopt($request_infotaxista, CURLOPT_RETURNTRANSFER, true);
			// ejecutamos
			$respuesta_taxista = curl_exec($request_infotaxista);
			curl_close($request_infotaxista);
			// convertimos el json de respuesta en un array asociativo
			$json_infotaxista = json_decode($respuesta_taxista, true);
				
			if (count($json_infotaxista["Taxi"]["conductor"]) > 1) {  
				//Separamos datos del taxista y del taxi
				$arrDatosTaxista = array('nombre' => $json_infotaxista["Taxi"]["conductor"]["nombre"],
										'apellido_paterno' => $json_infotaxista["Taxi"]["conductor"]["apellido_paterno"],
										'apellido_materno' => $json_infotaxista["Taxi"]["conductor"]["apellido_materno"],
										'identificador' => $json_infotaxista["Taxi"]["conductor"]["identificador"],
										'vigencia' => $json_infotaxista["Taxi"]["conductor"]["vigencia"],
										'antiguedad' => $json_infotaxista["Taxi"]["conductor"]["antiguedad"]
										);
				return $arrDatosTaxista;
			}else{
				return NULL;
				
			}
		}

		private function obtenerFecha(){
			$currentDay = getdate();
			$year = $currentDay['year'];
			$month = $currentDay['mon'];
			$day = $currentDay['mday'];
			$hrs = $currentDay['hours'];
			$mins = $currentDay['minutes'];
			$secs = $currentDay['seconds'];
			if ($month < 10) {
				$month = '0'.$month;
			}
			if ($day < 10) {
				$day = '0'.$day;
			}
			if($hrs < 10){
				$hrs = '0'.$hrs;
			}
			if ($mins < 10) {
				$mins = '0'.$mins;
			}
			if ($secs < 10) {
				$secs = '0'.$secs;
			}
			$fecha = $year.'-'.$month.'-'.$day.' '.$hrs.':'.$mins.':'.$secs;
			return $fecha;
		}	
	}

/* End of file Taxistas.php */
/* Location: ./application/controllers/Taxistas.php */
 ?>