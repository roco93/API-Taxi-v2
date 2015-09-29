<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . "/libraries/REST_Controller.php";


/**
 * class Comentarios_m Se comunica con la base de datos
 * @author   C.Cecilia Hernandez Vasquez <cecilia_hdz12[at]hotmail.com>
 * 			 C.Gilberto Aviles Acosta <gavilesac89[at]gmail.com> 
 */
class Comentarios extends REST_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('comentarios_m');
	}

	/**
	 * index_get obtiene los 5 primeros comentarios 
	 * @return JSON envolutorio con los comentraios
	 */
	public function index_get()	{
		$comentarios = $this->comentarios_m->get();

		if ( ! is_null($comentarios)) {
			$this->response(array('response' => $comentarios, 200));
		} else {
			$this->response(array('mensaje' => "No hay comentarios", 404));
		}
	}

	/**
	 * find_get
	 * @param $id_taxista identificador del taxista que se desea obtener los comentarios
	 * @return JSON envolutorio con los comentarios relacionados con el taxista
	 */
	public function find_get($id_taxista)	{
		if ( ! $id_taxista) {
			$this->response(NULL, 400);
		}		

		$comentario = $this->comentarios_m->get($id_taxista);

		if ( ! is_null($comentario)) {
			$this->response(array('response' => $comentario, 200));
		} else {
			$this->response(array('mensaje' => "No existe el comentario", 404));
		}
	}

	/**
	 * index_post inserta un comentario a la base de datos comentarios
	 * @return identificador del comentario
	 */
	public function index_post()	{
		if ( ! $this->post('comentarios') && ! $this->post('id_viaje')) {
			// $this->response(NULL, 400);
			// echo "entre en el if-1";
			$this->response($_POST['comentarios']);
		}

		$comentarioArr = array( 'id_viaje' => $this->post('id_viaje'),'comentarios' => $this->post('comentarios'));
		$id_comentario = $this->comentarios_m->save($comentarioArr);

		if ( ! is_null($id_comentario)) {
			$this->response(array('response' => $id_comentario, 200));
		} else {
			$this->response(array('error' => "Ha ocurrido un error al insertar comentario", 400));
		}
		//echo "Entre en el  post";
	}

	/**
	 * index_put actualiza el comentario 
	 * @param   $id identificador del comentario a actualizar
	 * @return JSON Envoltorio con los datos y un código con el resultado de la operación
	 */
	public function index_put($id)	{
		if ( ! $this->put("id_viaje") || ! $id || ! $this->put("comentarios")) {
			$this->response(NULL, 400);
		}

		$arrComentario = array('id_viaje' => $this->put("id_viaje"), 'comentarios' => $this->put("comentarios"));
		$update = $this->comentarios_m->update($id, $arrComentario);

		if ( ! is_null($update)) {
			$this->response(array('response' => "Comentario actualizado", 200));
		} else {
			$this->response(array('error' => "Ha ocurrido un error", 400));
		}

		
	}
	/**
	 * index_delete  borra el comentario de la base de datos
	 * @param  $id  identificador del comentario a borrar
	 * @return JSON Envoltorio con los datos y un código con el resultado de la operación
	 */
	public function index_delete($id)	{
		if ( is_null($id)) {
			$this->response(NULL, 400);
		} else {
			
			$delete = $this->comentarios_m->delete($id);
			
			if ( ! is_null($delete)) {
				$this->response(array('response' => "Comentario eliminado", 200));
			} else {
				$this->response(array('error' => "Ha ocurrido un error", 400));
			}
		}
	}
}