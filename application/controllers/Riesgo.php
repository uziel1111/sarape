<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Riesgo extends CI_Controller {

		function __construct() {
			parent::__construct();
			$this->load->library('Utilerias');
			$this->load->model('Escuela_model');
			$this->load->model('Municipio_model');
			$this->load->model('Nivel_model');
			$this->load->model('Sostenimiento_model');
			$this->load->model('Riesgo_alumn_esc_bim_model');
			$this->load->helper('form');
		}

		public function riesgo_x_muni_zona(){
			$data = array();
			$data2 = array();
			$arr_municipios = array();
			$arr_niveles = array();
			$arr_sostenimientos = array();
			$arr_federales = array();

			// echo "<pre>";
			// print_r($options);
			// die();
			$municipios = $this->Municipio_model->all();
			$arr_municipios['0'] = 'TODOS';
			foreach ($municipios as $municipio){
				 $arr_municipios[$municipio['id_municipio']] = $municipio['municipio'];
			}

			$niveles = $this->Nivel_model->get_xidmunicipio_riesgo(0);
			foreach ($niveles as $nivel){
				 $arr_niveles[$nivel['id_nivel']] = $nivel['nivel'];
			}

			$arr_bimestres['1'] = '1er Periodo';
			$arr_bimestres['2'] = '2do Periodo';
			$arr_bimestres['3'] = '3er Periodo';

			
			$arr_ciclos['1'] = '2018-2019';
			$arr_ciclos['2'] = '2017-2018';

			$data2['municipios'] = $arr_municipios;
			$data2['niveles'] = $arr_niveles;
			$data2['bimestres'] = $arr_bimestres;
			$data2['ciclos'] = $arr_ciclos;
			$string = $this->load->view('riesgo/buscador_riesgo_muni_zona', $data2, TRUE);
			$data['buscador'] = $string;
			Utilerias::pagina_basica($this, "riesgo/index", $data);
		}// riesgo_x_muni_zona()

		public function riesgoxmuni_graf(){
			$id_municipio = $this->input->post("id_minicipio");
			$id_nivel = $this->input->post("id_nivel");
			$id_bim = $this->input->post("id_bimestre");
			$ciclo = $this->input->post("ciclo");

			$graph_pie_riesgo = $this->Riesgo_alumn_esc_bim_model->get_riesgo_pie_xidmuni($id_municipio,$id_nivel,$id_bim,$ciclo);
			$graph_bar_riesgo = $this->Riesgo_alumn_esc_bim_model->get_riesgo_bar_grados_xidmuni($id_municipio,$id_nivel,$id_bim,$ciclo);
			$numero_total_bajas = $this->Riesgo_alumn_esc_bim_model->get_riesgo_totalb_xidmuni($id_municipio,$id_nivel,$id_bim);

			$response = array(
				'graph_pie_riesgo'=>$graph_pie_riesgo,
				'graph_bar_riesgo'=>$graph_bar_riesgo,
				'total_bajas'=>$numero_total_bajas
			);

			Utilerias::enviaDataJson(200, $response, $this);
			exit;

		}//riesgoxmuni_graf

}// Riesgo
