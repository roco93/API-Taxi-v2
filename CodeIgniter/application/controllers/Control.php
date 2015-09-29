<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Control extends CI_Controller {
	function _construct(){
		parent::_construct();
		

//Loading url helper
$this->load->helper('url');


	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		// URL para realizar el CURL
		$url = "http://www14.df.gob.mx/virtual/dashboard_cgma/smartCDMX/taxi/v1/index.php/Viajes";

		//echo "Hola...";
		$num=0;
		//$t=time();
			//echo($t . "<br>");
		//print_r(date_parse($date));
		$infoTaxista="hola";
	/*	while($infoTaxista != NULL){
			echo "hola";
			$infoTaxista=$this->curl_comentarios($url,$num);
			//r_dump($infoTaxista["response"][$num]["fecha"]);
			//var_dump($infoTaxista["fecha"]);
			// Result: string(26) "2014-10-18 14:02:39.449896"
			// Timestamp recuperado del CURL
			$date=date($infoTaxista["fecha"]);
			// Fecha normal
			echo $date;
			// Fecha en un arreglo asociativo
			$datearray = date_parse($date);
			$dateminute = $datearray["minute"];
			$datesecond = $datearray["second"];
			print_r($dateminute);
			print_r($datesecond);
			$num++;
		}*/
		// Date del servidor
		/*$date=date("Y-m-d H:i:s");
		echo $date;
		// Fecha en un arreglo asociativo
		$datearray = date_parse($date);
		echo $datearray["minute"];
		echo $datearray["second"];

		// Dato recuperado
		$daterecovery=strtotime("2013-03-15 17:10:56");
		$daterecovery2=strtotime("2013-12-12 17:10:55");
		// Fecha en un arreglo asociativo
		$datearrayr1 = date_parse($daterecovery);
		$datearrayr2 = date_parse($daterecovery2);
		echo $datearrayr1["minute"];
		echo $datearrayr1["second"];
		echo $datearrayr2["minute"];
		echo $datearrayr2["second"];*/

		//$diff=date_diff($date1,$date2);
		//echo $diff->format("%R%a days");
		// Prueba de pasar parametro a una vista
		$num_viajes = 14034;
		$num_incidentes = 2;
		$data = array(
			'num_viajes' => $num_viajes,
			'num_incidentes' => $num_incidentes
		);
		/*$this->load->view('proofh.php',$data);*/

			$this->load->view('/pagina_principal/index.php',$data);

		/*
		<?php
			$date1=date_create("2013-03-15");
			$date2=date_create("2013-12-12");
			$diff=date_diff($date1,$date2);
			echo $diff->format("%R%a days");

			Result: +272 days
		?>

		<?php
			$date=date_create("2013-03-15");
			echo date_format($date,"Y/m/d H:i:s");
		?>

		<?php
			$t=time();
			echo($t . "<br>");
			echo(date("Y-m-d H:i:s",$t));
		?>*/

	}

	public function mapas(){
		$this->load->view('pagina_principal/principal.php');
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

	public function bryan182(){
		$num_viajes = 1400;
		$num_incidentes = 2;
		$data = array(
			'num_viajes' => $num_viajes,
			'num_incidentes' => $num_incidentes
		);

		$this->response(array('response' => $data, 200));
	}

	public function seccion_estadisticas(){

	}

	// Metodo que realiza el CURL 
	private function curl_comentarios($url,$num){
		// Realizar el CURL en base al url dado
		$json_rcb = file_get_contents($url);
		// Se convierte en un array asociativo
		$obj_rcb = json_decode($json_rcb,true);

		if (count($obj_rcb["response"] >= 1)) {  
			//Se separan los datos recibidos
			$arrDatosViaje = array(
				'id_viaje' => $obj_rcb["response"][$num]["id_viaje"],
				'id_taxi' => $obj_rcb["response"][$num]["id_taxi"],
				'id_comentarios' => $obj_rcb["response"][$num]["id_estatus_viaje"],
				'id_taxista' => $obj_rcb["response"][$num]["id_taxista"],
				'ident_dispositivo' => $obj_rcb["response"][$num]["ident_dispositivo"],
				'lat_origen' => $obj_rcb["response"][$num]["lat_origen"],
				'long_origen' => $obj_rcb["response"][$num]["long_origen"],
				'lat_destino' => $obj_rcb["response"][$num]["lat_destino"],
				'long_destino' => $obj_rcb["response"][$num]["long_destino"],
				'calificacion' => $obj_rcb["response"][$num]["calificacion"],
				'nivel_confianza' => $obj_rcb["response"][$num]["nivel_confianza"],
				'fecha' => $obj_rcb["response"][$num]["fecha"]
					);
			return $arrDatosViaje;
		}else{
			return NULL;		
		}
	}
}
