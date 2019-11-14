<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Planea extends CI_Controller {

		function __construct() {
			parent::__construct();
			$this->load->library('Utilerias');
			$this->load->model('CentrosE_model');
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
			$municipios = $this->CentrosE_model->municipios();
			$arr_municipios['0'] = 'TODOS';
			foreach ($municipios as $municipio){
				 $arr_municipios[$municipio['id_municipio']] = $municipio['municipio'];
			}
			// NIVEL POR PLANEA MUN
			$arr_niveles['0'] = 'SELECCIONE';
			$arr_niveles['4'] = 'PRIMARIA';
			$arr_niveles['5'] = 'SECUNDARIA';
			$arr_niveles['6'] = 'MEDIA SUPERIOR';

			// NIVEL POR PLANEA ZONA
			$arr_nivelesz['0'] = 'SELECCIONE';
			$arr_nivelesz['4'] = 'PRIMARIA';
			$arr_nivelesz['5'] = 'SECUNDARIA';


			//CAMPOS DICIPLINARIOS
			$arr_campod['0'] = 'SELECCIONE';
			$arr_campod['1'] = 'LENGUAJE Y COMUNICACIÓN';
			$arr_campod['2'] = 'MATEMÁTICAS';

			//CAMPO SUBSOSTENIMIENTO
			$arr_subsostenimientos['0'] = 'SELECCIONE';

			$periodos = $this->Planeaxmuni_model->allperiodos();
			$arr_periodos = array();
			foreach ($periodos as $periodo){
				 $arr_periodos[$periodo['id_periodo']] = $periodo['periodo'];
			}

			$result_nzonae = $this->Supervision_model->allzonas();
			$arr_zonas = array();
			$arr_zonas['0'] = 'TODAS';
			foreach ($result_nzonae as $zona){
				 $arr_zonas[$zona['cct']] = $zona['zona_escolar'];
			}

			$contenidos = $this->Recursos_model->get_tipo_contenidos();
			$arr_contenidos = array();
			$arr_contenidos[0] = "SELECCIONE";
			foreach ($contenidos as $contenido){
				 $arr_contenidos[$contenido['idtipo']] = $contenido['tipo'];
			}

			$data['contenidos'] = $arr_contenidos;

			$data['municipios'] = $arr_municipios;
			$data['niveles'] = $arr_niveles;
			$data['nivelesz'] = $arr_nivelesz;
			$data['periodos'] = $arr_periodos;
			$data['zonas'] = $arr_zonas;
			$data['camposd'] = $arr_campod;
			$data['subsostenimientos'] = $arr_subsostenimientos;
			Utilerias::pagina_basica($this, "planea/index", $data);
		}

		public function get_xmunicipio(){
			$municipio = $this->input->post("idmunicipio");
			$nivel = $this->input->post("nivel");
			$periodo = $this->input->post("periodo");
			$campodisip = $this->input->post("campodisip");
			if($campodisip == 1 || $campodisip == '1'){
				$datos = $this->Planeaxesc_reactivo_model->estadisticas_x_estadomunicipio($municipio, $nivel, $periodo, 1);
			}else{
				$datos = $this->Planeaxesc_reactivo_model->estadisticas_x_estadomunicipio($municipio, $nivel, $periodo, 2);
			}



			$response = array('datos' => $datos, 'id_municipio' => $municipio);
		        Utilerias::enviaDataJson(200, $response, $this);
		        exit;
		}

		public function get_xregion(){
			$region = $this->input->post("id_supervision");
			$nivel = $this->input->post("nivel");
			$periodo = $this->input->post("periodo");
			$campodisip = $this->input->post("campodisip");
			if($campodisip == 1 || $campodisip == '1'){
				$datos = $this->Planeaxesc_reactivo_model->estadisticas_x_region($region, $nivel, $periodo, 1);
			}else{
				$datos = $this->Planeaxesc_reactivo_model->estadisticas_x_region($region, $nivel, $periodo, 2);
			}

			$response = array('datos' => $datos, 'id_region' => $region);
		        Utilerias::enviaDataJson(200, $response, $this);
		        exit;
		}

		public function planea_xcont_xmunicipio(){
			// echo "<pre>";
			// print_r($_POST);
			// die();
			$id_contenido = $this->input->post("id_cont");
		    $id_zona_municipio = $this->input->post("id_xzona_o_municipio");
		    $id_perioso = $this->input->post("periodo");
		    $idcampodis = $this->input->post("idcampodis");
		    $tipo_filtro =$this->input->post("tipo_filtro");
		    if($tipo_filtro == "municipio"){
		    	$datos = $this->Planeaxesc_reactivo_model->get_reactivos_xcctxcont_municipio($id_zona_municipio,$id_contenido,$id_perioso,$idcampodis);
		    }else{
		    	$datos = $this->Planeaxesc_reactivo_model->get_reactivos_xcctxcont_zona($id_zona_municipio,$id_contenido,$id_perioso,$idcampodis);
		    }

		    $response = array('graph_cont_reactivos_xcctxcont' => $datos);
		        Utilerias::enviaDataJson(200, $response, $this);
		        exit;

		}

		public function get_zonaxnivel(){
			$nivel = $this->input->post("nivel");
			$nombre_nivel = $this->input->post("nombre_nivel");
			$idsubsostenimiento = $this->input->post('idsubsostenimiento');

			// $zonas = $this->Planeaxesc_reactivo_model->zonaxnivel($nombre_nivel, $idsubsostenimiento);
			$zonas = $this->Supervision_model->getzona_idnivel_xsost($nombre_nivel,$idsubsostenimiento);
			// echo "<pre>";
			// print_r($zonas);
			// die();
			$arr_zonas = array();
			array_push($arr_zonas, array("data" => 0, "label" => "SELECCIONE"));
			foreach ($zonas as $zona){
				 array_push($arr_zonas, array("data" => $zona['id_supervision'], "label" => $zona['zona_escolar']));
			}

			$response = array('zonas' => $arr_zonas);
		        Utilerias::enviaDataJson(200, $response, $this);
		        exit;
		}

		public function get_subsostenimientoxnivel(){
			$nivel = $this->input->post("nivel");
			$nombre_nivel = $this->input->post("nombre_nivel");
			$subsostenimientos = $this->Planeaxesc_reactivo_model->subsostenimientoxnivel($nombre_nivel);

			$arr_subsostenimientos = array();
			array_push($arr_subsostenimientos, array("data" => 0, "label" => "SELECCIONE"));
			foreach ($subsostenimientos as $subsostenimiento){
				array_push($arr_subsostenimientos, array("data" => $subsostenimiento['id_sostenimiento'], "label" => $subsostenimiento['sostenimiento2']));
			}

			$response = array('subsostenimientos' => $arr_subsostenimientos);
		        Utilerias::enviaDataJson(200, $response, $this);
		        exit;
		}

		public function apoyos_academxid_reac(){
			$id_reactivo = $this->input->post("id_reactivo");

			$arr_apoyosacade_xidreact = $this->Planeaxesc_reactivo_model->get_apoyos_academ_xidreact($id_reactivo);
			// echo "<pre>";print_r($arr_apoyosacade_xidreact);die();
			$response = array(
				'arr_apoyosacade_xidreact'=>$arr_apoyosacade_xidreact
			);

			Utilerias::enviaDataJson(200, $response, $this);
			exit;
		}



}// Planea
