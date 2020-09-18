<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cuda extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('Utilerias');
		$this->load->model('Cuda_model');

	}

	function index()
	{
		$data = array();
		$array_detalles = array();
		if (isset($_GET['idcuda'])) {
		$idaplicar = $this->input->get('idcuda');
		$array_detalles = $this->Cuda_model->getDetalles($idaplicar);
		echo "<pre>";print_r($array_detalles);die();
		$data['array_detalles'] = $array_detalles;
		Utilerias::pagina_basica($this,"cuda/detalles_get", $data);
		}else{
			Utilerias::pagina_basica($this, "cuda/cuda", $data);
		}

	}

	public function getEncuestas()
	{
		$idusuario = $this->input->post('idusuario');
		$array_encuestas = $this->Cuda_model->getEncuesta($idusuario);
		$data['array_encuestas'] = $array_encuestas;
		$str_view = $this->load->view('cuda/tabla_encuestas',$data, TRUE);
		$response = array('str_view' => $str_view);
		Utilerias::enviaDataJson(200,$response, $this);
		exit;

	}
	public function getObjetivo(){
		$idsubsecretaria = $this->input->post('idsubsecretaria');
		$array_datos = $this->Cuda_model->getObjetivos($idsubsecretaria);

		$data['array_datos'] = $array_datos;

		$str_view = $this->load->view("cuda/tabla_subsecretaria", $data, TRUE);
		$response = array('str_view' => $str_view);
		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function getDetalles(){
		$idaplicar = $this->input->post('idaplicar');

		$array_detalles = $this->Cuda_model->getDetalles($idaplicar);
		$data['array_detalles'] = $array_detalles;
		$str_view = $this->load->view("cuda/modal_detalles", $data, TRUE);
		$response = array('str_view' => $str_view);
		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function getDocumentoDescarga(){
		$idaplicar = $this->input->post('idaplicar');
		$array_descarga = $this->Cuda_model->getDocumentoDescarga($idaplicar);
		$data['array_descarga'] = $array_descarga;
		$str_view = $this->load->view("cuda/modal_documentos", $data, TRUE);
		$response = array('str_view' => $str_view);
		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function getContacto(){
		$idusuario = $this->input->post('idusuario');
		$tipo_busqueda = $this->input->post('tipo_busqueda');
		$array_usuario = $this->Cuda_model->getContacto($idusuario);
		$data['array_usuario'] = $array_usuario;
		if ($tipo_busqueda == 1) {
		$str_view = $this->load->view('cuda/contacto', $data, TRUE);
		}else{
		$str_view = $this->load->view('cuda/modal_contacto', $data, TRUE);
		}
		$response = array('str_view' => $str_view);
		Utilerias::enviaDataJson(200,$response, $this);
		exit;

	}

	public function getEstadistica()
	{
		$idusuario = $this->input->post('idusuario');
		$idsubsecretaria = $this->input->post('idsubsecretaria');

		$array_estadistica = $this->Cuda_model->getEstadisticaUsuario($idusuario);
		$array_total = $this->Cuda_model->getEstadisticaGeneral($idsubsecretaria);
		$array_global =  $this->Cuda_model->getEstadisticaGlobal();
		foreach ($array_estadistica as $key => $value) {
			$estadistica = $value['encuestasUsuario'];
		}
		foreach ($array_total as $key => $value) {
			$total = $value['total'];
		}

		foreach ($array_global as $key => $value) {
			$global = $value['global'];
		}
		$grafica1 = ($estadistica * 100) / $total;
		$grafica2 = ($estadistica * 100) / $global;

		$data['grafica2'] =  round($grafica2,0);
		$data['grafica1'] =  round($grafica1,0);
		$data['sub'] = $total;
		$data['universo'] = $global;
		$data['propio'] = $estadistica;
		$str_view = $this->load->view('cuda/estadistica', $data, TRUE);
		$response = array('str_view' => $str_view);
		Utilerias::enviaDataJson(200,$response,$this);
		exit;
	}

	function consultaNivel(){
		$nivel = $this->input->post('nivel');
		$mes = $this->input->post('mes');
		$tema1 = 0;
		$titulotema1 = 'Administración de Personal / '.$tema1;
		$tema2 = 0;
		$titulotema2 = 'Participación Social / '.$tema2;
		$tema3 = 0;
		$titulotema3 = 'Gestión Escolar / '.$tema3;
		$tema4 = 0;
		$titulotema4 = 'Recursos Materiales / '.$tema4;
		$tema5 = 0;
		$titulotema5 = 'Planeación y Estadística / '.$tema5;
		$tema6 = 0;
		$titulotema6 = 'Protección Civil / '.$tema6;
		$tema7 = 0;
		$titulotema7 = 'Recursos Financieros / '.$tema7;
		$tema8 = 0;
		$titulotema8 = 'Programas Federales / '.$tema8;
		$tema9 = 0;
		$titulotema9 = 'Control Escolar / '.$tema9;
		$tema10 = 0;
		$titulotema10 = 'Cooperativas y Tiendas Escolares / '.$tema10;

		$respuestaArray = array();

		$idEncuesta = $this->Cuda_model->idEncuestaNivel($nivel, $mes);
		foreach ($idEncuesta as $key => $value) {
			switch ($value['tema']) {
				case '1':
				$tema1 ++;
				$titulotema1 = 'Administración de Personal / '.$tema1;

				break;
				case '2':
				$tema2 ++;
				$titulotema2 = 'Participación Social / '.$tema2;

				break;
				case '3':
				$tema3 ++;
				$titulotema3 = 'Gestión Escolar / '.$tema3;

				break;
				case '4':
				$tema4 ++;
				$titulotema4 = 'Recursos Materiales / '.$tema4;

				break;
				case '5':
				$tema5 ++;
				$titulotema5 = 'Planeación y Estadística / '.$tema5;

				break;
				case '6':
				$tema6 ++;
				$titulotema6 = 'Protección Civil / '.$tema6;

				break;
				case '7':
				$tema7 ++;
				$titulotema7 = 'Recursos Financieros / '.$tema7;

				break;
				case '8':
				$tema8 ++;
				$titulotema8 = 'Programas Federales / '.$tema8;

				break;
				case '9':
				$tema9 ++;
				$titulotema9 = 'Control Escolar / '.$tema9;
				break;
				case '10':
				$tema10 ++;
				$titulotema10 = 'Cooperativas y Tiendas Escolares / '.$tema10;

				break;

			}

		}


		$temas = array('tema1'=>$titulotema1, 'tema2'=>$titulotema2, 'tema3'=>$titulotema3, 'tema4'=>$titulotema4, 'tema5'=>$titulotema5, 'tema6'=>$titulotema6, 'tema7'=>$titulotema7, 'tema8'=>$titulotema8, 'tema9'=>$titulotema9, 'tema10'=>$titulotema10);

		$data['temas'] = $temas;
		$data['nivel'] = $nivel;
		$totalTemas = $tema1 + $tema2 +$tema3+$tema4+$tema5+$tema6+$tema7+$tema8+$tema9+$tema10;

		$str_view = $this->load->view('cuda/consultaNivel', $data, TRUE);
		$total = $totalTemas;
		$response = array('str_view' => $str_view, 'total'=>$total);
		Utilerias::enviaDataJson(200,$response,$this);
		exit;
	}

	function getFormatoTema()
	{

		$tema = $this->input->post('tema');
		$nivel = $this->input->post('nivel');
		$encuestas = array();
		$formatos = $this->Cuda_model->getFormatoTema($tema,$nivel);

		foreach ($formatos as $key => $value) {
			$encuesta = $this->Cuda_model->getDetalles($value['idaplicar']);
			array_push($encuestas, $encuesta);
		}


		$data['formato'] = $encuestas;

		$str_view = $this->load->view('cuda/tabla_encuestas_tema', $data, TRUE);
		$response = array('str_view' => $str_view);
		Utilerias::enviaDataJson(200,$response,$this);
		exit;
	}

	function getFormatoTemaMes()
	{

		$tema = $this->input->post('tema');
		$nivel = $this->input->post('nivel');
		$mes = $this->input->post('mes');

		$encuestas = array();
		$formatosMesArray = array();
		$formatos = $this->Cuda_model->getFormatoTema($tema,$nivel);
		foreach ($formatos as $key => $value) {
			$formatosMes = $this->Cuda_model->getFormatoTemaMes($value['idaplicar'], $mes);
			if (!empty($formatosMes)) {
			array_push($formatosMesArray, $formatosMes);
			}

		}


		foreach ($formatosMesArray as $key => $value) {
			$encuesta = $this->Cuda_model->getDetalles($value[0]['idaplicar']);
			array_push($encuestas, $encuesta);
		}

		$data['formato'] = $encuestas;
		$str_view = $this->load->view('cuda/tabla_encuestas_tema', $data, TRUE);
		$response = array('str_view' => $str_view);
		Utilerias::enviaDataJson(200,$response,$this);
		exit;
	}

}
