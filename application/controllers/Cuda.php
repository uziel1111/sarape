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
		// echo "<pre>";print_r($array_detalles);die();
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
		

		$idEncuesta = $this->Cuda_model->idEncuestaNivel($nivel, $mes);
		// echo '<pre>'; print_r($idEncuesta); die();
		
		$data['temas'] = $idEncuesta;
		$data['nivel'] = $nivel;

		$str_view = $this->load->view('cuda/consultaNivel', $data, TRUE);
		$total = $idEncuesta[0]['total_general'];
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
		$formatos = $this->Cuda_model->getFormatoTemaMes($tema,$nivel,$mes);

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

}
