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


	// public function get_objetivos_x_idpemc_tabla(){
	// 	$datos_sesion = Utilerias::get_cct_sesion($this);

	// 	$objetivos = $this->Objetivo_model->get_objetivos_x_idpemc($datos_sesion['idpemc']);

	// 	$tabla = "";
	// 	foreach ($objetivos as $objetivo) {
	// 		$tabla .="<tr><th scope='row'>{$objetivo['orden']}</th>
	// 			      <td>{$objetivo['objetivo']}</td>
	// 			      <td>{$objetivo['fcreacion']}</td>
	// 			      <td><button class='btn btn-primary btn-block' onclick='Objetivos.agreg_acciones({$objetivo['idobjetivo']})'>{$objetivo['num_acciones']}</button></td>
	// 			      <td><input type='file' name='file_evidencia_antes' id='file_evidencia_antes' onchange='Objetivos.carga_archivos(this, 1, {$objetivo['idobjetivo']})'></td>
	// 			      <td><input type='file' name='file_evidencia_despues' id='file_evidencia_despues' onchange='Objetivos.carga_archivos(this, 2, {$objetivo['idobjetivo']})'></td>
	// 			    </tr>";
	// 	}
	// 	$response = array('contenido_tabla' => $tabla);
	// 	Utilerias::enviaDataJson(200,$response, $this);
	// 	exit;
	// }
	public function get_view_obj()
	{
		$idobjetivo = $this->input->post('idobjetivo');
		$data = array();
		if($idobjetivo != 0){
			$data['info_objetivo'] = $this->Objetivo_model->get_objetivo_x_idobjetivo($idobjetivo);
		}
		// echo"<pre>";
		// print_r($data);
		// die();
		$str_view = $this->load->view('pemc/objetivos_metas_acciones/crearobjetivo',$data, TRUE);
		$response = array('str_view' => $str_view);
		Utilerias::enviaDataJson(200,$response, $this);
		exit;

	}

	public function save_conf_objetivo(){
		// echo"<pre>";
		// print_r($_POST);
		// die();
		$idobjetivo = (int)$this->input->post('idobjetivoupdate');
		$text_objetivo_c = (strip_tags($this->input->post('text_objetivo_c')));
		$text_meta_c = (strip_tags($this->input->post('text_meta_c')));
		$text_comentariosG_c = (strip_tags($this->input->post('text_comentariosG_c')));
		$datos_sesion = Utilerias::get_cct_sesion($this);
		if($idobjetivo != 0){
			$estatus = $this->Objetivo_model->update_objetivo($datos_sesion['idpemc'], $text_objetivo_c, $text_meta_c, $text_comentariosG_c, $idobjetivo);
		}else{
			$orden = $this->Objetivo_model->get_objetivos_x_idpemc($datos_sesion['idpemc']);
			$estatus = $this->Objetivo_model->save_objetivo($datos_sesion['idpemc'], $text_objetivo_c, $text_meta_c, $text_comentariosG_c, count($orden));
		}

		$response = array('estatus' => $estatus);
		Utilerias::enviaDataJson(200,$response, $this);
		exit;
	}

	public function delete_objetivo(){
		$datos_sesion = Utilerias::get_cct_sesion($this);
		$idobjetivo = $this->input->post('idobjetivo');
		$acciones = $this->Objetivo_model->get_acciones_x_idobjetivo($idobjetivo);
		$cad_acciones = "";
		foreach ($acciones as $accion) {
    		$cad_acciones .= $accion['idaccion'].",";
		}
		$cad_acciones = substr($cad_acciones, 0, -1);
		// die($cad_acciones);
		$delete_seg = $this->Objetivo_model->delete_linea_objetivo($cad_acciones, $idobjetivo, $datos_sesion['idpemc']);

		$objetivos = $this->Objetivo_model->get_objetivos_x_idpemc($datos_sesion['idpemc']);
		$orden = 1;
		foreach ($objetivos as $objetivo) {
			$estatus = $this->Objetivo_model->update_orden_objetivos($objetivo['idobjetivo'], $datos_sesion['idpemc'], $orden);
			$orden = $orden + 1;
		}

		$response = array('estatus' => $delete_seg);
		Utilerias::enviaDataJson(200,$response, $this);
		exit;
	}

	public function delete_imagen(){
		$idobjetivo = $this->input->post('idobjetivo');
		$tipo_evidencia = $this->input->post('tipo_img');
		$url = $this->Objetivo_model->get_url($idobjetivo, $tipo_evidencia);
		$delete_img = $this->Objetivo_model->inserta_ruta($idobjetivo, '', $tipo_evidencia);
		unlink($url->url);
		$response = array('estatus' => $delete_img);
		Utilerias::enviaDataJson(200,$response, $this);
		exit;
	}

	public function get_evidencia(){
		$idobjetivo = $this->input->post('idobjetivo');
		$tipo_evidencia = $this->input->post('tipo_evidencia');
		$evidencia = '';
		switch ($tipo_evidencia) {
			case 1:
				$evidencia = 'url_evidencia_antes';
				break;

			case 2:
				$evidencia = 'url_evidencia_despues';
				break;
		}
		$info_objetivo = $this->Objetivo_model->get_objetivo_x_idobjetivo($idobjetivo);
		$data['ruta_evidencia'] = $info_objetivo->$evidencia;

		$str_view = $this->load->view('pemc/frame_evidencia',$data, TRUE);
		$response = array('str_view' => $str_view);
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
		$data['responsables']  = (isset($personal->Personal)?$personal->Personal:array());
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
		// echo"<pre>";
		// print_r($_POST);
		// die();
		$idaccion = $this->input->post('idaccion');
		$idobjetivo = $this->input->post('idobjetivo');
    	$accion = (strip_tags($this->input->post('accion')));
    	$recurso = (strip_tags($this->input->post('recurso')));
    	$ambitos = $this->input->post('ambitos');
        $responsables = (($this->input->post('responsables')=='')?array():$this->input->post('responsables'));
    	$otro_responsable = (strip_tags($this->input->post('otro_responsable')));
    	$finicio = $this->input->post('finicio');
			$comentarios_finicio = $this->input->post('comentarios_finicio');
    	$ffin = $this->input->post('ffin');
			$comentarios_ffin = $this->input->post('comentarios_ffin');
    	$cad_ambitos = "";
    	$cad_responsables = "";
    	if(count($ambitos) > 0){
    		foreach ($ambitos as $ambito) {
    			$cad_ambitos .= $ambito.",";
    		}
    		$cad_ambitos = substr($cad_ambitos, 0, -1);
    	}

			// echo "<pre>";print_r($responsables);die();
    	if(count($responsables) > 0){
    		foreach ($responsables as $responsable) {
    			$cad_responsables .= "'". $responsable."',";
    		}
    	$cad_responsables = substr($cad_responsables, 0, -1);
    	}

    	$estatus = $this->Objetivo_model->update_accion($idaccion, $idobjetivo, $accion, $recurso, $cad_ambitos, $cad_responsables, $otro_responsable, $finicio,$comentarios_finicio, $ffin,$comentarios_ffin);

    	$response = array('estatus' => $estatus);
		Utilerias::enviaDataJson(200,$response, $this);
		exit;
	}

	public function insert_acciones(){
		$idobjetivo = $this->input->post('idobjetivo');
    	$accion = (strip_tags($this->input->post('accion')));
    	$recurso = (strip_tags($this->input->post('recurso')));
    	$ambitos = $this->input->post('ambitos');
        $responsables = $this->input->post('responsables');
    	$otro_responsable = (strip_tags($this->input->post('otro_responsable')));
    	$finicio = $this->input->post('finicio');
			$comentarios_finicio = $this->input->post('comentarios_finicio');
    	$ffin = $this->input->post('ffin');
			$comentarios_ffin = $this->input->post('comentarios_ffin');
    	$cad_ambitos = "";
    	$cad_responsables = "";
    	if(count($ambitos) > 0){
    		foreach ($ambitos as $ambito) {
    			$cad_ambitos .= $ambito.",";
    		}
    		$cad_ambitos = substr($cad_ambitos, 0, -1);
    	}

    	if(isset($responsables) && count($responsables) > 0){
    		foreach ($responsables as $responsable) {
    			$cad_responsables .= "'". $responsable."',";
    		}
    	$cad_responsables = substr($cad_responsables, 0, -1);
    	}

    	$orden = $this->Objetivo_model->get_acciones_x_idobjetivo($idobjetivo);

    	$estatus = $this->Objetivo_model->insert_accion($idobjetivo, count($orden), $accion, $recurso, $cad_ambitos, $cad_responsables, $otro_responsable, $finicio,$comentarios_finicio, $ffin,$comentarios_ffin);

    	$response = array('estatus' => $estatus);
		Utilerias::enviaDataJson(200,$response, $this);
		exit;
	}

	public function delete_accion(){
		$idobjetivo = $this->input->post('idobjetivo');
		$idaccion = $this->input->post('idaccion');
		$estatus_delete = $this->Objetivo_model->delete_accion($idaccion, $idobjetivo);
		if($estatus_delete){
			// echo"vamos a ordenar";
			$acciones = $this->Objetivo_model->get_acciones_x_idobjetivo($idobjetivo);
			$orden = 1;
			$estatus = true;
			foreach ($acciones  as $accion) {
				$estatus = $this->Objetivo_model->update_orden_accion($accion['idaccion'], $idobjetivo, $orden);
				$orden = $orden + 1;
			}
		}

		$response = array('estatus' => $estatus);
		Utilerias::enviaDataJson(200,$response, $this);
		exit;
	}

	public function insert_evidencias(){
		$idobjetivo = $this->input->post('idobjetivo');
		$tipo_evidencia = $this->input->post('tipo_evidencia');
		$datos_sesion = Utilerias::get_cct_sesion($this);
		$cct = $datos_sesion['cve_centro'];
		$turno = $datos_sesion['turno_single'];
		$ruta_imagenes = "pemc/".$cct."/".$turno."/".$idobjetivo;

		if (!file_exists($ruta_imagenes)) {
		    mkdir($ruta_imagenes, 0777, true);
		}
		if ($_FILES["file"]['name'] != "") {
			$config['upload_path']   = $ruta_imagenes;
			$config['allowed_types'] = 'gif|jpg|png|pdf|jpeg';

			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if ($this->upload->do_upload("file")) {
				$fileData = $this->upload->data();
				$url = $this->Objetivo_model->get_url($idobjetivo, $tipo_evidencia);
				if($url->url != ''){
					unlink($url->url);
				}
				$estatus = $this->Objetivo_model->inserta_ruta($idobjetivo, $ruta_imagenes . "/" . $fileData['file_name'], $tipo_evidencia);

			}
		}

		$response = array('estatus' => $estatus);
		Utilerias::enviaDataJson(200,$response, $this);
		exit;
	}



}
