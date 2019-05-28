<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supervisor extends CI_Controller {

		function __construct() {
			parent::__construct();
			$this->load->library('Utilerias');
			$this->load->helper('form');
		}

		public function supervision(){
			$data = array();

			Utilerias::pagina_basica($this, "supervision/index", $data);
		}// supervision()

		public function gettrayectoformativo(){

			$strView = $this->load->view("supervision/trayectoformativo", array(), TRUE);


			$response = array(
												'strView' => $strView
												);

			Utilerias::enviaDataJson(200, $response, $this);
			exit;
		}// gettrayectoformativo()

		public function getsuperenmundo(){

			$strView = $this->load->view("supervision/superenmundo", array(), TRUE);
			$response = array(
												'strView' => $strView
												);

			Utilerias::enviaDataJson(200, $response, $this);
			exit;
		}// getsuperenmundo()

		public function getsupercte(){

			$strView = $this->load->view("supervision/cte", array(), TRUE);
			$response = array(
												'strView' => $strView
												);

			Utilerias::enviaDataJson(200, $response, $this);
			exit;
		}// getsupercte()

}// Supervisor
