<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Generico extends CI_Controller {

		function __construct() {
			parent::__construct();
			$this->load->library('Utilerias');
			$this->load->model('Municipio_model');
			$this->load->model('Nivel_model');
			$this->load->model('Supervision_model');
			$this->load->model('Planeaxmuni_model');
			$this->load->model('Planeaxesc_reactivo_model');
			$this->load->helper('form');

			$this->load->model('Recursos_model');
			$this->load->model('Propuestas_model');
		}

		public function index(){
			$data=array();
			Utilerias::pagina_basica($this, "new/index", $data);
		}



}// Planea
