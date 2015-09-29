<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('prueba');
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
	public function index()	{
		$this->load->view('welcome_message');
	}

	public function prueba() {
		$cryptoConfig =  array(
                'cipher' => 'aes-128',
                'mode' => 'cbc',
                'key' => '1234567891234567'
        );
		//$this->encryption->initialize([]);
		$this->encryption->initialize($cryptoConfig);

        $plainTextMessage = "Mensaje a cifrar";

        $cipherText = $this->encryption->encrypt($plainTextMessage);

		echo "<pre>";
		print_r("Texto original " . $plainTextMessage);
		echo "</pre>";
		echo "<pre>";
		print_r("Texto cifrado " . $cipherText);
		echo "</pre>";
		echo "<pre>";
		print_r("Texto descifrado " . $this->encryption->decrypt($cipherText));
		echo "</pre>";
	}
}
