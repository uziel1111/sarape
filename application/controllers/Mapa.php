<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mapa extends CI_Controller {

		function __construct() {
			parent::__construct();
			$this->load->library('Utilerias');
			$this->load->model('Escuela_model');
			$this->load->model('Municipio_model');
			$this->load->model('Nivel_model');
			$this->load->model('Sostenimiento_model');
			$this->load->helper('form');
		}

		public function busqueda_x_mapa(){
			$data = array();
			$data2 = array();
			$arr_municipios = array();
			$arr_niveles = array();
			$arr_sostenimientos = array();
			$arr_federales = array();

			
			$municipios = $this->Municipio_model->all();
			$arr_municipios['0'] = 'TODOS';
			foreach ($municipios as $municipio){
				 $arr_municipios[$municipio['id_municipio']] = $municipio['municipio'];
			}

			$niveles = $this->Nivel_model->all();
			$arr_niveles['0'] = 'TODOS';

			foreach ($niveles as $nivel){
				 $arr_niveles[$nivel['id_nivel']] = $nivel['nivel'];
			}

			$sostenimientos = $this->Sostenimiento_model->all();
			$arr_sostenimientos['0'] = 'TODOS';
			foreach ($sostenimientos as $sostenimiento){
				 $arr_sostenimientos[$sostenimiento['id_sostenimiento']] = $sostenimiento['sostenimiento'];
			}
			$arr_federales['0'] = 'TODOS';

			$data2['municipios'] = $arr_municipios;
			$data2['niveles'] = $arr_niveles;
			$data2['sostenimientos'] = $arr_sostenimientos;
			$data2['programas'] = $arr_federales;

			$string = $this->load->view('mapa/buscador_x_mapa', $data2, TRUE);
			$data['buscador'] = $string;
			Utilerias::pagina_basica($this, "mapa/index", $data);
		}// index()

		public function get_niveles(){
			$idmunicipio = $this->input->post('idmunicipio');

			$niveles = $this->Nivel_model->get_xidmunicipio($idmunicipio);

			$str_select = '<option value=-1>TODOS</option>';
			foreach ($niveles as $key => $value) {
				if ($value['nivel'] == 'CAM') {
				$str_select .= "<option value={$value['id_nivel']}> ESPECIAL </option>";	
				}else{
				$str_select .= "<option value={$value['id_nivel']}> {$value['nivel']} </option>";
				}
			}
			$response = array('options' => $str_select);
			Utilerias::enviaDataJson(200, $response, $this);
			exit;

		}

		public function get_sostenimientos(){
			$idnivel = $this->input->post('idnivel');

			$sostenimientos = $this->Sostenimiento_model->get_xidnivel($idnivel);
			$str_select = '<option value=-1>TODOS</option>';
			foreach ($sostenimientos as $key => $value) {
				$str_select .= "<option value={$value['id_sostenimiento']}> {$value['sostenimiento']} </option>";
			}
			$response = array('options' => $str_select);
			Utilerias::enviaDataJson(200, $response, $this);
			exit;
		}

		public function get_marcadores_filtro(){
			$idmunicipio       = $this->input->post("idmunicipio");
			$idnivel           = $this->input->post("idnivel");
			$id_sostenimiento  = $this->input->post("idsostenimiento");
			$nombre_centro     = $this->input->post("nombre");
			$cct               = $this->input->post("cct");

			$marcadorb = array();
			$vfinal = array();

			if(isset($cct) && $cct != ""){
				$escuelas = $this->Escuela_model->get_xcvecentro("05".$cct);
			}else{
				$escuelas = $this->Escuela_model->get_xparams($idmunicipio,$idnivel,$id_sostenimiento,$nombre_centro);
				
			}

			foreach ($escuelas as $marcador) {
	            array_push($marcadorb, $marcador['nombre_centro']);
	            array_push($marcadorb, (float) $marcador['latitud']);
	            array_push($marcadorb, (float) $marcador['longitud']);
	            array_push($marcadorb, $marcador['cve_centro']);
	            array_push($marcadorb, $marcador['id_nivel']);
	            array_push($marcadorb, $marcador['municipio']);
	            array_push($marcadorb, $marcador['turno_single']);
	            array_push($marcadorb, $marcador['subsostenimiento']);
	            array_push($marcadorb, $marcador['nivel']);
	            array_push($marcadorb, $marcador['localidad']);
	            array_push($marcadorb, $marcador['zona_escolar']);
	            array_push($marcadorb, $marcador['sostenimiento']);
	            array_push($vfinal, $marcadorb);
	            $marcadorb = array();
	        }
	        $response = array('response' => $vfinal);
	        Utilerias::enviaDataJson(200, $response, $this);
	        exit;
		}

		public function get_mismo_nivel(){

			$idcct = $this->input->post('idcct');
			$marcadorb = array();
			$vfinal = array();
			if($idcct != ""){
				$escuela = $this->Escuela_model->get_xidcct($idcct);
				$escuelas = $this->Escuela_model->get_mismo_nivel($escuela[0]['latitud'], $escuela[0]['longitud'], $escuela[0]['id_nivel'], false);

				foreach ($escuelas as $marcador) {
		            array_push($marcadorb, $marcador['nombre_centro']);
		            array_push($marcadorb, (float) $marcador['latitud']);
		            array_push($marcadorb, (float) $marcador['longitud']);
		            array_push($marcadorb, $marcador['cve_centro']);
		            array_push($marcadorb, $marcador['id_nivel']);
		            array_push($marcadorb, $marcador['municipio']);
								array_push($marcadorb, $marcador['turno_single']);
								array_push($marcadorb, $marcador['subsostenimiento']);
								array_push($marcadorb, $marcador['nivel']);
								array_push($marcadorb, $marcador['localidad']);
								array_push($marcadorb, $marcador['zona_escolar']);
								array_push($marcadorb, $marcador['sostenimiento']);
		            array_push($vfinal, $marcadorb);
		            $marcadorb = array();
		        }
		        $response = array('response' => $vfinal);
		        Utilerias::enviaDataJson(200, $response, $this);
		        exit;
			}
		}

		public function get_siguiente_nivel(){

			$idcct = $this->input->post('idcct');
			$marcadorb = array();
			$vfinal = array();
			if($idcct != ""){
				$escuela = $this->Escuela_model->get_xidcct($idcct);
				$escuelas = $this->Escuela_model->get_mismo_nivel($escuela[0]['latitud'], $escuela[0]['longitud'], $escuela[0]['id_nivel'], true);

				foreach ($escuelas as $marcador) {

		            array_push($marcadorb, $marcador['nombre_centro']);
		            array_push($marcadorb, (float) $marcador['latitud']);
		            array_push($marcadorb, (float) $marcador['longitud']);
		            array_push($marcadorb, $marcador['cve_centro']);
		            array_push($marcadorb, $marcador['id_nivel']);
		            array_push($marcadorb, $marcador['municipio']);
								array_push($marcadorb, $marcador['turno_single']);
								array_push($marcadorb, $marcador['subsostenimiento']);
								array_push($marcadorb, $marcador['nivel']);
								array_push($marcadorb, $marcador['localidad']);
								array_push($marcadorb, $marcador['zona_escolar']);
								array_push($marcadorb, $marcador['sostenimiento']);
		            array_push($vfinal, $marcadorb);
		            $marcadorb = array();
		        }
		        $response = array('response' => $vfinal);
		        Utilerias::enviaDataJson(200, $response, $this);
		        exit;
			}
		}

}// Mapa
