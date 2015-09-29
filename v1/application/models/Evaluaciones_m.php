<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Clase para conexion a la BD.
 * @author C.Cecilia Hernandez Vasquez <cecilia_hdz12[at]hotmail.com>
 *         C.Gilberto Aviles Acosta <gavilesac89[at]gmail.com>
 */
class Evaluaciones_m extends CI_Model {
	/**
	 * Constructor de la clase
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Obtiene la informacion del taxi a tra vez de las placas.
	 * @param  $placas Las pacas del taxi
	 * @return array arreglo con la informacion del taxi de la BD o NULL si no se encuentran datos
	 */
	public function get($placas) {
		if ( ! is_null($placas)) {

			$calificacion = $this->db->select("nivel_confianza,id_taxi")->from("taxis")->where("placas",$placas)->get(); 
			
			if ($calificacion->num_rows() === 1) {
				return $calificacion->row_array();
			} else {
				return NULL;
			}
		} 
	}

	/**
	 * Guarda la informacion del taxi a la base de datos.
	 * @param  $arrayTaxi La informacion del taxi a guardar
	 * @return id_taxi el identificador de la BD del taxi guardado o NULL si ocurrio un error
	 */
	public function saveTaxi($arrayTaxi){
		$this->db->set($arrayTaxi)->insert("taxis");

		if ($this->db->affected_rows() === 1) {
			return $this->db->insert_id();
		} else {
			return NULL;
		}

	} 

	/**
	 * Obtiene los taxista relacionados al taxi
	 * @param  $placas Las placas del taxi
	 * @return array El arreglo con los datos de los taxistas de la BD relacionados al taxi
	 */
	public function getTaxistas($placas){	
		$taxistas=$this->db->select("taxistas.id_taxista,taxistas.identificador,taxistas.acumulado_calificacion,taxistas.numero_viajes")->from("taxis")->join("taxi_has_taxista","taxis.id_taxi=taxi_has_taxista.id_taxi")
																														   ->join("taxistas","taxistas.id_taxista=taxi_has_taxista.id_taxista")
																															->where("taxis.placas",$placas)->get();		
		if ($taxistas->num_rows() > 0) {
			return $taxistas->result_array();
		} else {
			return NULL;
		}																														   
	}

	/**
	 * Actualiza la informacion del taxi en la BD
	 * @param  $placas Las placas del taxi
	 * @param  $taxi   El arreglo con la informacion a actualizar
	 * @return <b>true</b> si la actualizacion se realizo correctamente. <b>false</b> en otro caso
	 */
	public function updateTaxi($placas,$taxi){
		$this->db->set($taxi)
		->where("placas", $placas)
		->update("taxis");

		if ($this->db->affected_rows() === 1) {
			return TRUE;
		} else {
			return NULL;
		}
	}

}

/* End of file Evaluaciones_m.php */
/* Location: ./application/models/Evaluaciones_m.php */