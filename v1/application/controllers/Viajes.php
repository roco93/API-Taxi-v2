
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . "/libraries/REST_Controller.php";
/**
 * Clase Viajes 
 * @author Lic. Efren Valdez J. <evaldezj[at]df.gob.mx> , 
 * 			 C.Cecilia Hernandez Vasquez <cecilia_hdz12[at]hotmail.com>
 * 			 C.Gilberto Aviles Acosta <gavilesac89[at]gmail.com>
 */

class Viajes extends REST_Controller {
	
	/**
	 * Constructor de la clase Viajes.
	 * Carga el modelo relacionado a este controlador.
	 */
	public function __construct() {
		parent::__construct();
		$this->load->model('viajes_m');
	}

	/**
	 * index_get Obtiene todos los viajes almacenados en la base de datos.
	 * @return JSON Envoltorio con los datos y un código con el resultado de la operación.
	 */
	public function index_get()	{
		$viajes = $this->viajes_m->get();

		if ( ! is_null($viajes)) {
			$this->response(array('response' => $viajes, 200));
		} else {
			$this->response(array('mensaje' => "No hay viajes", 404));
		}
	}

	/**
	 * Obtiene los datos del viaje en la base datos.
	 * @param  $id el identificador del viaje en la base de datos. 
	 * @return JSON Envoltorio con los datos y un código con el resultado de la operación.
	 */
	public function find_get($id)	{
		if ( ! $id) {
			$this->response(NULL, 400);
		}		

		$viaje = $this->viajes_m->get($id);

		if ( ! is_null($viaje)) {
			$this->response(array('response' => $viaje, 200));
		} else {
			$this->response(array('mensaje' => "No existe el viaje", 404));
		}
	}

	/**
	 * Guarda la informacion de un viaje a la base de datos.
	 * Para esta primera version, este metodo no estara en uso. Si se desea usar descomentar el codigo.
	 * @return JSON Envoltorio con los datos y un código con el resultado de la operación
	 */
	public function index_post()	{
		// if (! $this->post("id_viaje") && ! $this->post("lat_incidente") && ! $this->post("long_incidente") && ! $this->post("estatus_viaje")) {
		// 	$this->response(NULL, 400);
		// }

		// $arrIncidente = array('id_viaje' => $this->post("id_viaje"),
		// 					'lat_incidente' => $this->post("lat_incidente"), 
		// 					'long_incidente' => $this->post("long_incidente"));
		
		// $arrViaje = array('id_estatus_viaje' => $this->post("estatus_viaje"));
		
		// $id_incidente = $this->viajes_m->updateViaje_Incidente($this->post("id_viaje"),$arrIncidente,$arrViaje);

		// if ( ! is_null($id_incidente)) {
		// 	$this->response(array('response' => "La operacion a sido exitosa", 200));
		// } else {
		// 	$this->response(array('error' => "Ha ocurrido un error", 400));
		// }
		$this->response(array('Sin Contenido ' => " Reservado para uso futuro", 204));
	}

	/**
	 * Actualiza la informacion de un viaje en la base de datos.
	 * @param  $id El identificador del viaje a actualizar.
	 * @return JSON Envoltorio con los datos y un código con el resultado de la operación.
	 */
	public function index_put($id)	{
		$calificacion=0;
		$nivel_confianza=0;
		if ( ! $this->put("id_taxi") || ! $this->put("id_estatus_viaje") || ! $this->put("id_taxista") 
			|| ! $this->put("ident_dispositivo") || ! $this->put("lat_destino") || ! $this->put("long_destino") 
			|| ! $this->put("calificacion") || ! $this->put("nivel_confianza") || ! $this->put("fecha")) {
			$this->response(NULL, 400);
			// $this->response(array('cal' => $this->put("calificacion"),'idt' => $this->put("id_taxista"),'conf' => $this->put("nivel_confianza"), 400));
		}
		if ($this->put('calificacion')==-1) {
			$calificacion=0;
		}else{
			$calificacion=$this->put('calificacion');
		}
		if ($this->put('nivel_confianza')==-1) {
			$nivel_confianza=0;
		}else{
			$nivel_confianza=$this->put('nivel_confianza');
		}
		$arrViaje = array('id_taxi' => $this->put("id_taxi"),'id_estatus_viaje' => $this->put("id_estatus_viaje"), 'id_taxista' => $this->put("id_taxista"),
							'ident_dispositivo' => $this->put("ident_dispositivo"), 'lat_destino' => $this->put("lat_destino"), 
							'long_destino' => $this->put("long_destino"), 'calificacion' => $calificacion, 
							'nivel_confianza' => $nivel_confianza, 'fecha' => $this->put("fecha"));
		$update = $this->viajes_m->update($id, $arrViaje);

		if ( ! is_null($update)) {
			$this->response(array('response' => "Viaje actualizado", 200));
		} else {
			$this->response(array('error' => "Ha ocurrido un error a actu el viaje", 400));
		}
	}

	/**
	 * Permite eliminar un viaje de la base de datos.
	 * Este metodo no estara definido para esta primera version. Si se desea usar descomentar el codigo.
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function index_delete($id)	{
		// if (is_null($id)) {
		// 	$this->response(NULL, 400);
		// } else {
		// 	$delete = $this->viajes_m->delete($id);
		// 	if ( ! is_null($delete)) {
		// 		$this->response(array('response' => "Viaje eliminado", 200));
		// 	} else {
		// 		$this->response(array('error' => "Ha ocurrido un error", 400));
		// 	}
		// }
		$this->response(array('Sin Contenido ' => " Reservado para uso futuro", 204));
	}



}

/* End of file Viajes.php */
/* Location: ./application/controllers/Viajes.php */