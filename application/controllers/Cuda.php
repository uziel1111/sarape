<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Cuda extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('Utilerias');
		$this->load->model('Cuda_model');

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
		$array_usuario = $this->Cuda_model->getContacto($idusuario);
		$data['array_usuario'] = $array_usuario;
		$str_view = $this->load->view('cuda/contacto', $data, TRUE);
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

		$data['grafica1'] =  bcdiv($grafica1,'1',0);
		$data['grafica2'] =  bcdiv($grafica2,'1',0);
		$data['sub'] = $total;
		$data['universo'] = $global;
		$data['propio'] = $estadistica;
		$str_view = $this->load->view('cuda/estadistica', $data, TRUE);
		$response = array('str_view' => $str_view);
		Utilerias::enviaDataJson(200,$response,$this);
		exit;
	}

	function consultaNivel(){
		// $nivel = $this->input->post('nivel');
		$idEncuesta = $this->Cuda_model->idEncuestaNivel('Secundaria');
		// $id = 0;
		foreach ($idEncuesta as $key => $value) {
			$id[]=$value['idaplicar'];

		}
		$encuestas = array('inicial' => 0);
		for ($i=0; $i < sizeof($id) ; $i++) { 
			$encuesta = $this->Cuda_model->EncuestaNivel($id[$i]);
			array_push($encuestas, $encuesta);
		}

		foreach ($encuestas as $key => $value) {
			
		print_r($value[0]); die();
		}

	}

	function index()
	{	
		$data = 0;
		$this->consultaNivel();
		Utilerias::pagina_basica($this, "cuda/cuda", $data);
	}
}