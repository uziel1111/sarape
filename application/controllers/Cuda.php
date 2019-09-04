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
		 $nivel = $this->input->post('nivel');
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
		$titulotema10 = 'Personal / '.$tema10;
		$tema0 = 0;
		$titulotema0 = 'Sin tema asignado / '.$tema0;
		$respuestaArray = [];

		$idEncuesta = $this->Cuda_model->idEncuestaNivel($nivel);
		foreach ($idEncuesta as $key => $value) {
			switch ($value['tema']) {
				case '1':
				$respuesta = $this->Cuda_model->getDetalles($value['idaplicar']);
				$tema1 ++;
				$titulotema1 = 'Administración de Personal / '.$tema1;

				break;
				case '2':
				$respuesta = $this->Cuda_model->getDetalles($value['idaplicar']);
				$tema2 ++;
				$titulotema2 = 'Participación Social / '.$tema2;

				break;
				case '3':
				$respuesta = $this->Cuda_model->getDetalles($value['idaplicar']);
				$tema3 ++;
				$titulotema3 = 'Gestión Escolar / '.$tema3;

				break;
				case '4':
				$respuesta = $this->Cuda_model->getDetalles($value['idaplicar']);
				$tema4 ++;
				$titulotema4 = 'Recursos Materiales / '.$tema4;

				break;
				case '5':
				$respuesta = $this->Cuda_model->getDetalles($value['idaplicar']);
				$tema5 ++;
				$titulotema5 = 'Planeación y Estadística / '.$tema5;

				break;
				case '6':
				$respuesta = $this->Cuda_model->getDetalles($value['idaplicar']);
				$tema6 ++;
				$titulotema6 = 'Protección Civil / '.$tema6;

				break;
				case '7':
				$respuesta = $this->Cuda_model->getDetalles($value['idaplicar']);
				$tema7 ++;
				$titulotema7 = 'Recursos Financieros / '.$tema7;

				break;
				case '8':
				$respuesta = $this->Cuda_model->getDetalles($value['idaplicar']);
				$tema8 ++;
				$titulotema8 = 'Programas Federales / '.$tema8;

				break;
				case '9':
				$respuesta = $this->Cuda_model->getDetalles($value['idaplicar']);
				$tema9 ++;
				$titulotema9 = 'Control Escolar / '.$tema9;
				// echo "<pre>"; print_r($respuesta); 
				break;
				case '10':
				$respuesta = $this->Cuda_model->getDetalles($value['idaplicar']);
				$tema10 ++;
				$titulotema10 = 'Personal / '.$tema10;

				break;
				default:
				$respuesta = $this->Cuda_model->getDetalles($value['idaplicar']);
				$tema0 ++;
				$titulotema0 = 'Sin tema asignado / '.$tema0;

				break;
			}
				
			array_push($respuestaArray, $respuesta);

		}

		
		$temas = array('tema1'=>$titulotema1, 'tema2'=>$titulotema2, 'tema3'=>$titulotema3, 'tema4'=>$titulotema4, 'tema5'=>$titulotema5, 'tema6'=>$titulotema6, 'tema7'=>$titulotema7, 'tema8'=>$titulotema8, 'tema9'=>$titulotema9, 'tema1'=>$titulotema1, 'tema0'=>$titulotema0);

		$data['temas'] = $temas;
		$data['formato'] = $respuestaArray;
		$data['temaid'] = $idEncuesta;

		// echo "<pre>"; print_r($respuestaArray[5][0]['respuesta']); die();

		$str_view = $this->load->view('cuda/consultaNivel', $data, TRUE);
		$response = array('str_view' => $str_view);
		Utilerias::enviaDataJson(200,$response,$this);
		exit;
	}

	function index()
	{	
		$data = 0;
		// $this->consultaNivel();
		Utilerias::pagina_basica($this, "cuda/cuda", $data);
	}
}