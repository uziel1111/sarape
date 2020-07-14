<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	
class Objetivos extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('Utilerias');
		$this->load->model('Objetivo_model');
	}


	public function get_objetivos_x_idpemc_tabla(){
		$datos_sesion = Utilerias::get_cct_sesion($this);

		$objetivos = $this->Objetivo_model->get_objetivos_x_idpemc($datos_sesion['idpemc']);

		$tabla = "";
		foreach ($objetivos as $objetivo) {
			$tabla .="<tr><th scope='row'>{$objetivo['orden']}</th>
				      <td>{$objetivo['objetivo']}</td>
				      <td>{$objetivo['fcreacion']}</td>
				      <td><button class='btn btn-primary' onclick='Objetivos.agreg_acciones({$objetivo['idobjetivo']})'>2</button></td>
				      <td>imagen1</td>
				      <td>imagen2</td>
				    </tr>";
		}
		$response = array('contenido_tabla' => $tabla);
		Utilerias::enviaDataJson(200,$response, $this);
		exit;
	}
	public function get_view_obj()
	{
		$data = array();
		$str_view = $this->load->view('pemc/objetivos_metas_acciones/crearobjetivo',$data, TRUE);
		$response = array('str_view' => $str_view);
		Utilerias::enviaDataJson(200,$response, $this);
		exit;
		
	}

	public function save_conf_objetivo(){
		// echo"<pre>";
		// print_r($_POST);
		// die();
		$text_objetivo_c = $this->input->post('text_objetivo_c');
		$text_meta_c = $this->input->post('text_meta_c');
		$text_comentariosG_c = $this->input->post('text_comentariosG_c');
		$datos_sesion = Utilerias::get_cct_sesion($this);
		// echo"<pre>";
		// print_r($datos_sesion['idpemc']);
		// die();
		$orden = $this->Objetivo_model->get_objetivos_x_idpemc($datos_sesion['idpemc']);
		$estatus = $this->Objetivo_model->save_objetivo($datos_sesion['idpemc'], $text_objetivo_c, $text_meta_c, $text_comentariosG_c, count($orden));
		$response = array('estatus' => $estatus);
		Utilerias::enviaDataJson(200,$response, $this);
		exit;
	}

	public function get_view_acciones(){
		$data = array();
		$data['ambitos']  = $this->Objetivo_model->get_ambitos();
		$str_view = $this->load->view('pemc/objetivos_metas_acciones/crearacciones',$data, TRUE);
		$response = array('str_view' => $str_view);
		Utilerias::enviaDataJson(200,$response, $this);
		exit;
	}



}