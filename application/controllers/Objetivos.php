<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	
class Objetivos extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('Utilerias');

	}


	public function get_view_obj()
	{
		$data = array();
		$str_view = $this->load->view('pemc/objetivos_metas_acciones/crearobjetivo',$data, TRUE);
		$response = array('str_view' => $str_view);
		Utilerias::enviaDataJson(200,$response, $this);
		exit;
		
	}



}