<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Busqueda_xlista extends CI_Controller {

		function __construct() {
			parent::__construct();
			$this->load->library('Utilerias');
			$this->load->model('Municipio_model');
			$this->load->model('Nivel_model');
			$this->load->model('Sostenimiento_model');
			$this->load->model('Escuela_model');
		}

		public function index(){
			$result_municipios = $this->Municipio_model->all();
			$arr_municipios = array();
			$arr_sostenimientos = array();
			$arr_niveles = array();

			if(count($result_municipios)==0){
				$data['arr_municipios'] = array(	'-1' => 'Error recuperando los municipios' );
			}else{
				$arr_municipios['-1'] = 'TODOS';
				foreach ($result_municipios as $row){
					 $arr_municipios[$row['id_municipio']] = $row['municipio'];
				}
			}

			$result_niveles = $this->Nivel_model->all();
			if(count($result_niveles)==0){
				$data['arr_niveles'] = array(	'-1' => 'Error recuperando los niveles' );
			}else{
				$arr_niveles['-1'] = 'TODOS';
				foreach ($result_niveles as $row){
					 $arr_niveles[$row['id_nivel']] = $row['nivel'];
				}
			}

			$result_sostenimientos = $this->Sostenimiento_model->all();
			// echo "<pre>"; print_r($result_sostenimientos); die();
			if(count($result_sostenimientos)==0){
				$data['arr_sostenimientos'] = array(	'-1' => 'Error recuperando los sostenimientos' );
			}else{
				$arr_sostenimientos['-1'] = 'TODOS';
				foreach ($result_sostenimientos as $row){
					 $arr_sostenimientos[$row['id_sostenimiento']] = $row['sostenimiento'];
				}
			}

			$data['arr_municipios'] = $arr_municipios;
			$data['arr_niveles'] = $arr_niveles;
			$data['arr_sostenimientos'] =$arr_sostenimientos;

			Utilerias::pagina_basica($this, "busqueda_xlista/buscador", $data);
		}// index()



		public function escuelas_xmunicipio($var_aux=0){

				$cve_municipio = $this->input->get('slc_busquedalista_municipio');
				$cve_nivel = $this->input->get('slc_busquedalista_nivel');
				$cve_sostenimiento = $this->input->get('slc_busquedalista_sostenimiento');
				$nombre_escuela = $this->input->get('itxt_busquedalista_nombreescuela');

				$data['cve_municipio'] = $cve_municipio;
				$data['cve_nivel'] = $cve_nivel;
				$data['cve_sostenimiento'] = $cve_sostenimiento;
				$data['nombre_escuela'] = $nombre_escuela;

				//hidden
				$municipio = $this->input->get('hidden_municipio');
				$nivel = $this->input->get('hidden_nivel');
				$sostenimiento = $this->input->get('hidden_sostenimiento');
				$result_escuelas = $this->Escuela_model->get_xparams($cve_municipio,$cve_nivel,$cve_sostenimiento,$nombre_escuela);
				// echo "<pre>"; print_r($result_escuelas); die();
				$data['municipio'] = $municipio;
				$data['nivel'] = $nivel;
				$data['sostenimiento'] = $sostenimiento;
				$data['escuela'] = $nombre_escuela;

				$data['arr_escuelas'] = $result_escuelas;
				$data['total_escuelas'] = count($result_escuelas);
				// echo "<pre>"; print_r($data); die();
				Utilerias::pagina_basica($this, "busqueda_xlista/escuelas", $data);

		}// escuelas_xmunicipio()

		public function escuelas_xcvecentro(){
			$cve_centro = $this->input->post('cve_centro');
			$cve_centro = '05'.trim($cve_centro);
			// echo "<pre>"; print_r($cve_centro); die();
			$result_escuelas = $this->Escuela_model->get_xcvecentro($cve_centro);
			// echo "<pre>"; print_r($result_escuelas); die();
			$total_escuelas = count($result_escuelas);

			$id_cct = 0;
			$str_select = '';
			if(count($result_escuelas)>0){
				foreach ($result_escuelas as $key => $value) {
					$id_cct = $value['id_cct'];
					$str_select .= "<option value={$value['id_cct']}>{$value['cve_centro']} - {$value['turno_single']}</option>";
				}
			}
			// echo "<pre>"; print_r($id_cct); die();
			$response = array(
												'total_escuelas' => $total_escuelas,
												'str_select' => $str_select,
												'id_cct' => $id_cct
												);
			Utilerias::enviaDataJson(200, $response, $this);
			exit;
		}// escuelas_xcvecentro()

}// Busqueda_lista
