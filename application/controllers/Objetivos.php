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
		$text_objetivo_c = $this->input->post('text_objetivo_c');
		$text_meta_c = $this->input->post('text_meta_c');
		$text_comentariosG_c = $this->input->post('text_comentariosG_c');
		$datos_sesion = Utilerias::get_cct_sesion($this);

		$orden = $this->Objetivo_model->get_objetivos_x_idpemc($datos_sesion['idpemc']);
		$estatus = $this->Objetivo_model->save_objetivo($datos_sesion['idpemc'], $text_objetivo_c, $text_meta_c, $text_comentariosG_c, count($orden));
		$response = array('estatus' => $estatus);
		Utilerias::enviaDataJson(200,$response, $this);
		exit;
	}

	public function get_view_acciones(){
		$data = array();
		$datos_sesion = Utilerias::get_cct_sesion($this);
		$idobjetivo = $this->input->post('idobjetivo');
		// echo"<pre>";
		// print_r($_POST);
		// die();
		$data['objetivo'] = $this->Objetivo_model->get_objetivo_x_idobjetivo($idobjetivo);
		$data['idobjetivo']  = $idobjetivo;
		$data['ambitos']  = $this->Objetivo_model->get_ambitos();
		$personal = $this->getPersonal($datos_sesion['cve_centro']);
		$data['responsables']  = $personal->Personal;
		$data['acciones']  = $this->Objetivo_model->get_acciones_x_idobjetivo($idobjetivo);
		// echo"<pre>";
		// print_r($data);
		// die();
		$str_view = $this->load->view('pemc/objetivos_metas_acciones/crearacciones',$data, TRUE);
		$response = array('str_view' => $str_view);
		Utilerias::enviaDataJson(200,$response, $this);
		exit;
	}

	private function getPersonal($cct){
		
		$curl = curl_init();
		$method = "POST";
		$url = "http://servicios.seducoahuila.gob.mx/wservice/personal/w_service_personal_by_cct.php";
		$data = array("cct" => $cct);

		switch ($method)
		{
			case "POST":
			curl_setopt($curl, CURLOPT_POST, 1);
			if ($data)
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			break;
			default:
			if ($data)
				$url = sprintf("%s?%s", $url, http_build_query($data));
		}

		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

		$result = curl_exec($curl);

		curl_close($curl);
		return $response = json_decode($result);
	}

	public function update_acciones(){
		$idaccion = $this->input->post('idaccion');
		$idobjetivo = $this->input->post('idobjetivo');
    	$accion = $this->input->post('accion');
    	$recurso = $this->input->post('recurso');
    	$ambitos = $this->input->post('ambitos');
        $responsables = $this->input->post('responsables');
    	$otro_responsable = $this->input->post('otro_responsable');
    	$finicio = $this->input->post('finicio');
    	$ffin = $this->input->post('ffin');
    	$cad_ambitos = "";
    	$cad_responsables = "";
    	if(count($ambitos) > 0){
    		foreach ($ambitos as $ambito) {
    			$cad_ambitos .= $ambito.",";
    		}
    		$cad_ambitos = substr($cad_ambitos, 0, -1);
    	}

    	if(count($responsables) > 0){
    		foreach ($responsables as $responsable) {
    			$cad_responsables .= "'". $responsable."',";
    		}
    	$cad_responsables = substr($cad_responsables, 0, -1);
    	}

    	$estatus = $this->Objetivo_model->update_accion($idaccion, $idobjetivo, $accion, $recurso, $cad_ambitos, $cad_responsables, $otro_responsable, $finicio, $ffin);

    	$response = array('estatus' => $estatus);
		Utilerias::enviaDataJson(200,$response, $this);
		exit;
	}

	public function insert_acciones(){
		$idobjetivo = $this->input->post('idobjetivo');
    	$accion = $this->input->post('accion');
    	$recurso = $this->input->post('recurso');
    	$ambitos = $this->input->post('ambitos');
        $responsables = $this->input->post('responsables');
    	$otro_responsable = $this->input->post('otro_responsable');
    	$finicio = $this->input->post('finicio');
    	$ffin = $this->input->post('ffin');
    	$cad_ambitos = "";
    	$cad_responsables = "";
    	if(count($ambitos) > 0){
    		foreach ($ambitos as $ambito) {
    			$cad_ambitos .= $ambito.",";
    		}
    		$cad_ambitos = substr($cad_ambitos, 0, -1);
    	}

    	if(count($responsables) > 0){
    		foreach ($responsables as $responsable) {
    			$cad_responsables .= "'". $responsable."',";
    		}
    	$cad_responsables = substr($cad_responsables, 0, -1);
    	}

    	$orden = $this->Objetivo_model->get_acciones_x_idobjetivo($idobjetivo);

    	$estatus = $this->Objetivo_model->insert_accion($idobjetivo, count($orden), $accion, $recurso, $cad_ambitos, $cad_responsables, $otro_responsable, $finicio, $ffin);

    	$response = array('estatus' => $estatus);
		Utilerias::enviaDataJson(200,$response, $this);
		exit;
	}



}