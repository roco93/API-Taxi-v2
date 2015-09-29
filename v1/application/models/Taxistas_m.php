<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Clase Taxistas_m elaborada por el C. Roberto Carlos Espinoza Santiago y 
* el C. Bryan Velazquez Moreno
*/

class Taxistas_m extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * get Obtiene un/los taxista(s) de la base de datos
	 * @return ARRAY con los datos de el/los taxista(s) encontrado(s)
	 */

	public function get($identificador = NULL) {
		$ident = "".$identificador;
		// return $ident;
		if ( ! is_null($identificador)) {
			$taxista=$this->db->select("identificador,id_taxista")->from("taxistas")->where("identificador", $ident)->get();
			if ($taxista->num_rows() > 0) {
				return $taxista->result_array();
			} else {
				return NULL;
			}
		} else {
			return NULL;
		}
	}

	/**
	 * save Inserta un taxista en la base de datos
	 * @return ARRAY con los datos del taxista añadido
	 */

	public function save($infoTaxista) {
		$this->db->set($infoTaxista)->insert("taxistas");
		
		if ($this->db->affected_rows() === 1) {
			return $this->db->insert_id();
		} else {
			return NULL;
		}
	}

	/**
	 * update Actualiza un taxista en la base de datos
	 * @return TRUE/FALSE si la operación tuvo éxito o no
	 */

	public function update($id, $taxista) {
		$this->db->set($taxista)
			->where("id_taxista", $id)
			->update("taxistas");

		if ($this->db->affected_rows() === 1) {
			return TRUE;
		} else {
			return NULL;
		}	
	}

	/**
	 * delete Elimina un taxista de la base de datos
	 * @return TRUE/FALSE si la operación tuvo éxito o no
	 */

	public function delete($id) {



		$this->db->trans_start();//Iniciamos el query transaccional
		
		$this->db->where("id_taxista", $id)->delete("taxi_has_taxista");
		$this->db->where("id_taxista", $id)->delete("taxistas");

		$this->db->trans_complete();//Finaliza el query transaccional
		

		if ($this->db->affected_rows() === 1) {
			return TRUE;
		} else {
			return NULL;
		}
	}

	public function saveRelacion($relacion){
		$this->db->set($relacion)->insert("taxi_has_taxista");
		
		if ($this->db->affected_rows() === 1) {
			return $this->db->insert_id();
		} else {
			return NULL;
		}
	}

	public function getInfoTaxista($id_taxista){
		$taxista;
		if ( ! is_null($id_taxista)) {
			$taxista=$this->db->select("acumulado_calificacion,numero_viajes")->from("taxistas")->where("id_taxista", $id_taxista)->get();
			if ($taxista->num_rows() > 0) {
				return $taxista->result_array();
			} else {
				return NULL;
			}
		} else {
			return NULL;
		}
	}

	public function getRelacion($id_taxista,$id_taxi){
		$relacion;
		if ( ! is_null($id_taxista)) {
			$relacion=$this->db->select("id_taxi_has_taxista")->from("taxi_has_taxista")->where("id_taxista", $id_taxista)->where("id_taxi",$id_taxi)->get();
			if ($relacion->num_rows() > 0) {
				return $relacion->result_array();
			} else {
				return NULL;
			}
		} else {
			return NULL;
		}
	}
}

/* End of file Taxistas_m.php */
/* Location: ./application/models/Taxistas_m.php */