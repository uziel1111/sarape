<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {

		function __construct() {
			parent::__construct();
			$this->load->helper('url');
			$this->load->library('Utilerias');
			$this->load->model('Ciclo_model');
		}

	public function index()
	{
		$data = array();
		Utilerias::pagina_basica($this, "index", $data);
		
	}

	public function getReconocimientosEstatales(){

		$strView = $this->load->view("index/reconocimientosEstatales", array(), TRUE);


		$response = array(
											'strView' => $strView
											);

		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}// getReconocimientosEstatales()

	public function getMaterialesUtiles(){
		$strView = $this->load->view("index/materialesUtiles", array(), TRUE);
		$response = array(
											'strView' => $strView
											);
		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}// getMaterialesUtiles()

	public function getCalendarioEscolar(){
		$result_ciclo = $this->Ciclo_model->ultimo_ciclo_escolar();
		$data=array();
		$data['ciclo']=$result_ciclo;
		$strView = $this->load->view("index/calendarioEscolar", $data, TRUE);
		$response = array(
											'strView' => $strView,
											
											);
		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}// getCalendarioEscolar()

	public function sarapemsj(){
		$strView = $this->load->view("index/sarapemsj", array(), TRUE);
		$response = array(
											'strView' => $strView
											);
		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}// sarapemsj()

	public function guiaparapadres(){
		$strView = $this->load->view("index/guiaparapadres", array(), TRUE);
		$response = array(
											'strView' => $strView
											);
		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}// guiaparapadres()

	public function modeloeducativo(){
		$strView = $this->load->view("index/modeloeducativo", array(), TRUE);
		$response = array(
											'strView' => $strView
											);
		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}// modeloeducativo()

	public function getRevistaEscolar(){
		$strView = $this->load->view("index/revistaEscolar", array(), TRUE);
		$response = array(
											'strView' => $strView
											);
		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}// getRevistaEscolar()

	public function getinformese(){
		$num_ed = $this->input->post("num_ed");
		$data['num_ed'] = $num_ed;
		$strView = $this->load->view("index/informese", $data, TRUE);
		$response = array(
											'strView' => $strView
											);
		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}// getinformese()

}
