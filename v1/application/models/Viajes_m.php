<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Clase del modelo Viajes
 * @author Lic. Efren Valdez J. <evaldezj[at]df.gob.mx> , 
 * 			 C.Cecilia Hernandez Vasquez <cecilia_hdz12[at]hotmail.com>
 * 			 C.Gilberto Aviles Acosta <gavilesac89[at]gmail.com>
 */

class Viajes_m extends CI_Model {
	/**
	 * Constructor de la clase
	 */
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * Obtiene los viajes de la base de datos. Si el id es distinto de nulo se obtiene la informacion de ese viaje
	 * @param  $id el identificador del viaje
	 * @return array arreglo con la informacion de la BD
	 */
	public function get($id = NULL) {
		if ( ! is_null($id)) {
			$query = $this->db->select("*")->from("viajes")->where("id_viaje", $id)->get();
			if ($query->num_rows() === 1) {
				return $query->row_array();
			} else {
				return NULL;
			}
		} else {
			$query = $this->db->select("*")->from("viajes")->get();
			if ($query->num_rows() > 0) {
				return $query->result_array();
			} else {
				return NULL;
			}
		}
		
	}

	/**
	 * Guarda la informacion del viaje
	 * @param  $viaje arreglo con la informacion del viaje a guardar
	 * @return id_viaje Identificador del viaje guardado en la BD. NULL si ocurrio un error
	 */
	public function save($viaje) {
		$this->db->set($viaje)
			->insert("viajes");

		if ($this->db->affected_rows() === 1) {
			return $this->db->insert_id();
		} else {
			return NULL;
		}
	}

	/**
	 * Actualiza la informacion del viaje
	 * @param  $id     identificador del viaje a actualizar
	 * @param  $viaje  arreglo con la informacion a actualizar
	 * @return <b>true</b> si la actualizacion se realizo correctamente. <b>false</b> en otro caso
	 */
	public function update($id, $viaje) {
		$this->db->set($viaje)
			->where("id_viaje", $id)
			->update("viajes");

		if ($this->db->affected_rows() === 1) {
			return TRUE;
		} else {
			return NULL;
		}
		
	}

	/**
	 * Elimina la informacion de un viaje
	 * @param  $id identificador del viaje a eliminar
	 * @return <b>true</b> si la eliminacion se realizo correctamente. <b>false</b> en otro caso
	 */
	public function delete($id) {
		$this->db->where("id_viaje", $id)->delete("viajes");

		if ($this->db->affected_rows() === 1) {
			return TRUE;
		} else {
			return NULL;
		}
	}

	/**
	 * Actualiza el estatus de un viaje y crea el incidente asociado al taxista
	 * @param  $id_viaje     identifiador del viaje a actualizar
	 * @param  $arrIncidente arreglo con la informacion del incidente a guardar
	 * @param  $arrViaje     arreglo con la informacion del viaje a actualizar
	 * @return $id_incidente identificador del incidente guardado en la base de datos
	 */
	public function updateViaje_Incidente($id_viaje,$arrIncidente,$arrViaje){
		$viaje=$this->db->select("*")->from("viajes")->where("id_viaje",$id_viaje)->get();

		if ($viaje->num_rows > 0) {
			$this->db->trans_start();//Iniciamos el query transaccional
			$this->db->set($arrViaje)->where("id_viaje",$id_viaje)->update("viajes");
			$id_incidente=$this->db->set($arrIncidente)->insert("incidentes");
			$this->db->trans_complete();//Finaliza el query transaccional
		}else{
			return NULL;
		}


		if ($this->db->affected_rows() === 1) {
			return TRUE;
		} else {
			return NULL;
		}
	}
}

/* End of file Viajes_m.php */
/* Location: ./application/models/Viajes_m.php */