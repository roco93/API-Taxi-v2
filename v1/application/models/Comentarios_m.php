<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * class Comentarios_m Se comunica con la base de datos
 * @author   C.Cecilia Hernandez Vasquez <cecilia_hdz12[at]hotmail.com>
 * 			 C.Gilberto Aviles Acosta <gavilesac89[at]gmail.com> 
 */
class Comentarios_m extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	/**
	 * get funcion que obtiene los comentarios del taxista
	 * @param   $id_taxista identificador del taxista 
	 * @return JSON Envoltorio con los datos y un código con el resultado de la operación
	 */
	public function get($id_taxista = NULL) {
		if ( ! is_null($id_taxista)) {

			$comentarios = $this->db->select("viajes.id_viaje,viajes.id_taxista,comentarios.id_comentarios,comentarios.comentarios")->from("viajes")->join("comentarios","viajes.id_viaje = comentarios.id_viaje")->where("viajes.id_taxista",$id_taxista)->get(); 
			
			if ($comentarios->num_rows() > 0) {
				return $comentarios->result_array();
			} else {
				return NULL;
			}
		} else {
			$comentarios = $this->db->select("*")->from("comentarios")->limit(5)->get();
			if ($comentarios->num_rows() > 0) {
				return $comentarios->result_array();
			} else {
				return NULL;
			}
		}
		
	} 	

	/**
	 * save guarda el comentario relacionado al viaje
	 * @param  [type] $comentario es un array con el comentario a guardar
	 * @return el identificador del comentario o null en caso de que no se guardo el comentario.
	 */
	public function save($comentario) {
		$this->db->set($comentario)->insert("comentarios");

		if ($this->db->affected_rows() === 1) {
			//echo "filas afectadas";
			return $this->db->insert_id();
		} else {
			return NULL;
		}
	}

	/**
	 * update actualiza el comentario del viaje
	 * @param   $id   identificador del comentario a actualizar
	 * @param   $comentario comentario a actualizar
	 * @return TRUE en caso de que se realizo la actualizacion
	 */
	public function update($id, $comentario) {
		$this->db->set($comentario)
			->where("id_comentarios", $id)
			->update("comentarios");

		if ($this->db->affected_rows() === 1) {
			return TRUE;
		} else {
			return NULL;
		}
		
	}

	/**
	 * delete borra el comentario realizado anteriormente
	 * @param   $id identificador del comentario a borrar
	 * @return TRUE en caso de realizar el borrado del comentario
	 */
	public function delete($id) {
		$this->db->where("id_comentarios", $id)->delete("comentarios");

		if ($this->db->affected_rows() === 1) {
			return TRUE;
		} else {
			return NULL;
		}
	}

}