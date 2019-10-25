<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catalogos extends CI_Controller {

		function __construct() {
			parent::__construct();
			$this->load->library('Utilerias');
			$this->load->model('Nivel_model');
			$this->load->model('Sostenimiento_model');
		}

		public function getniveles_xcvemunicipio(){
			$cve_municipio  = $this->input->post('cve_municipio');
			// $result_niveles = $this->Nivel_model->get_xidmunicipio($cve_municipio);
			$result_niveles = $this->Nivel_model->get_xidmunicipio_vista_cct($cve_municipio);
			// echo "<pre>";
			// print_r($result_niveles);
			// die();
			$str_select = '<option value=-1>TODOS</option>';
			foreach ($result_niveles as $key => $value) {
				$str_select .= "<option value={$value['id_nivel']}> {$value['nivel']} </option>";
			}
			$response = array('str_select' => $str_select);
			Utilerias::enviaDataJson(200, $response, $this);
			exit;
		}// getniveles_xcvemunicipio()

		public function getsostenimientos_xcvenivel(){
			$cve_nivel  = $this->input->post('cve_nivel');
			// $result_sostenimientos = $this->Sostenimiento_model->get_xidnivel($cve_nivel);
			$result_sostenimientos = $this->Nivel_model->get_xidnivel_vista_cct($cve_nivel);

			$str_select = '<option value=-1>TODOS</option>';
			foreach ($result_sostenimientos as $key => $value) {
				$str_select .= "<option value={$value['id_sostenimiento']}> {$value['sostenimiento']} </option>";
			}
			$response = array('str_select' => $str_select);
			Utilerias::enviaDataJson(200, $response, $this);
			exit;
		}// getniveles_xcvemunicipio()
}// Catalogos
