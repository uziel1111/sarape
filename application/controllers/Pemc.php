<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemc extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->data = array( );
		$this->logged_in = FALSE;
		$this->load->library('Utilerias');
		$this->load->model('Pemc_model');
		$this->load->model('Objetivo_model');
		$this->load->database();
		$this->cct = array();
		$this->load->library('PDF_MC_Table');
		date_default_timezone_set('America/Mexico_City');
	}

	public function index(){
		if(Utilerias::verifica_sesion_redirige($this)){
			$this->cct = Utilerias::get_cct_sesion($this);
			if(isset($this->cct[0]['tipo_usuario_pemc'])){
				Utilerias::destroy_all_session_cct($this);
				redirect('Pemc/index');
			}else{
				$this->vistas_pemc();
			}
		}else{
			$data = $this->data;
			$data['error'] = '';
			$this->load->view('pemc/login',$data);
		}
		}// index()

		public function cerrar_sesion(){
			Utilerias::destroy_all_session_cct($this);
			redirect('Pemc/index');
		}

		public function acceso(){
			if(Utilerias::verifica_sesion_redirige($this)){
				$this->cct = Utilerias::get_cct_sesion($this);
				if(isset($this->cct[0]['id_supervision'])){
					$mensaje = "Acceso Restringido.";
					$tipo    = ERRORMESSAGE;
					$this->session->set_flashdata(MESSAGEREQUEST, Utilerias::get_notification_alert($mensaje, $tipo));
					$this->load->view('pemc/login',$data);
				}else{
					if(isset($this->cct[0]['tipo_usuario_pemc'])){
						Utilerias::destroy_all_session_cct($this);
						redirect('Pemc/index');
					}else{
						$this->vistas_pemc();
					}
				}

			}else{
				$usuario = strtoupper($this->input->post('usuario'));
				$pass = strtoupper($this->input->post('password'));
				$turno = $this->input->post('turno_id');

				if($this->verifica_supervisor($usuario) == TRUE){
					$mensaje = "Acceso Restringido.";
					$tipo    = ERRORMESSAGE;
					$this->session->set_flashdata(MESSAGEREQUEST, Utilerias::get_notification_alert($mensaje, $tipo));
					$this->load->view('pemc/login',$data);
				}else{

					$curl = curl_init();
					$method = "POST";
					$url = "http://servicios.seducoahuila.gob.mx/wservice/w_service_login.php";
					$data = array("cct" => $usuario, 'turno' => $turno, 'pwd' => $pass);

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
					$response = json_decode($result);
					if($response->procede == 1 && $response->status == 1){
						$datoscct = $this->Pemc_model->getdatoscct($usuario, $turno)[0];
						$datoscct['id_turno_single'] = $turno;
						$idpemc = $this->Pemc_model->obtener_idpemc_xescuela($datoscct['cve_centro'],$turno);
						$datoscct['idpemc'] = $idpemc;
						Utilerias::set_cct_sesion($this, $datoscct);
						$this->vistas_pemc();
					}else{
						$mensaje = $response->statusText;
						$tipo    = ERRORMESSAGE;
						$this->session->set_flashdata(MESSAGEREQUEST, Utilerias::get_notification_alert($mensaje, $tipo));
						$this->load->view('pemc/login',$data);
					}
				}
			}
		}// index()

		public function getPersonal($cct){

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

//FUNCIONAMIENTO Y VALIDACION PARA SUPERVISOR BY LUIS SANCHEZ... all reserved rights
//
	public function verifica_supervisor($cct){
		$issuper = $this->Pemc_model->valida_supervisor($cct);
		if(count($issuper) > 0){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function vistas_pemc(){
		$this->cct = Utilerias::get_cct_sesion($this);
		$usuario = $this->cct['cve_centro'];
		$responsables = $this->getPersonal($usuario);
		$nomenclatura = substr($usuario,0,5);
		if ($responsables->status==0) {
			$personas = array();
		}
		else {
			$personas = $responsables->Personal;
		}

		$options = "";
		if($responsables->procede == 1 && $responsables->status == 1){
			foreach ($personas as $persona) {
				if ($nomenclatura != '05PJN' && $nomenclatura != '05PPR' && $nomenclatura != '05PPS') {
					$options .= "<option value='{$persona->rfc}'>".$persona->nombre_completo."</option>";
				}
			}
			$options .="<option value='0'>OTRO</option>";
		}else{
			$options .="<option value='0'>OTRO</option>";
		}
		$data['responsables'] = $options;
		$data['idpemc'] = $this->cct['idpemc'];
		$data['nivel'] = $this->cct['nivel'];//$nivel;
		$data['nombreuser'] = $this->cct['nombre_centro'];
		$data['turno'] = $this->cct['turno_single'];
		$data['cct'] = $this->cct['cve_centro'];
		$data['director'] = $this->cct['nombre_director'];
		Utilerias::pagina_basica_pemcv2($this, "pemc/index", $data);
	}

	public function obtiene_vista_diagnostico(){
		$datos_sesion = Utilerias::get_cct_sesion($this);
		$diagnostico = $this->Pemc_model->obtener_diagnostico_xidpemc($datos_sesion['idpemc']);
		$es_inicio = $this->Pemc_model->es_inicio_ciclo_actual();
		// echo "<pre>";print_r($es_inicio);die();
		$data = array('diagnostico' => $diagnostico, 'idpemc' => $datos_sesion['idpemc'], 'es_inicio' => $es_inicio);
		$str_vista = $this->load->view("pemc/diagnostico", $data, TRUE);
		$response = array('str_vista' => $str_vista);
		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function guarda_diagnostico(){
		echo"<pre>";
		print_r($_POST);
		die();
		$datos_sesion = Utilerias::get_cct_sesion($this);
		$diagnostico = mb_strtoupper($this->input->post('in_diag'));
		$estatus = $this->Pemc_model->guarda_diagnostico(strip_tags($diagnostico),$datos_sesion['idpemc']);
		$response = array('estatus' => $estatus);
		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function obtiene_vista_objetivosymetas(){
		$datos_sesion = Utilerias::get_cct_sesion($this);

		$objetivos = $this->Objetivo_model->get_objetivos_x_idpemc($datos_sesion['idpemc']);
		$data['objetivos'] = $objetivos;

		$str_vista = $this->load->view("pemc/objetivos_metas_acciones", $data, TRUE);
		$response = array('str_vista' => $str_vista);
		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

		public function obtiene_vista_seguimiento(){
			$datos_sesion = Utilerias::get_cct_sesion($this);
			$seguimiento = $this->Pemc_model->obtener_seguimiento_xidpemc($datos_sesion['idpemc']);
			// echo "<pre>";print_r($seguimiento);die();
			foreach ($seguimiento as $key => $value) {
				if ($value['idambitos'] != '') {
					$seguimiento[$key]['ambitos'] = $this->Pemc_model->obtener_ambitos_xidambitos($value['idambitos']);
				}
				else {
					$seguimiento[$key]['ambitos'] = '';
				}
			}
			// echo "<pre>";print_r($seguimiento);die();
			$data = array('seguimiento' => $seguimiento);
			// echo "<pre>";print_r($data);die();
			$str_vista = $this->load->view("pemc/seguimiento", $data, TRUE);
			$response = array('str_vista' => $str_vista);
			Utilerias::enviaDataJson(200, $response, $this);
			exit;
		}

		public function ir_a_guardar_avance(){
			$idaccion = $this->input->post('idaccion');
			$avance = $this->input->post('avance');
			$estatus = $this->Pemc_model->ir_a_guardar_avance($idaccion, $avance);
			$data = array('estatus' => $estatus);
			// echo "<pre>";print_r($idaccion);die();
			Utilerias::enviaDataJson(200, $data, $this);
			exit;
		}

		public function ver_avance(){
			$idaccion = $this->input->post('idaccion');
			$arr_datos_accion = $this->Pemc_model->ver_datos_accion($idaccion);
			foreach ($arr_datos_accion as $key => $value) {
				$arr_datos_accion[$key]['ambitos']= $this->Pemc_model->obtener_ambitos_xidambitos($value['idambitos']);
			}
			$arr_avances = $this->Pemc_model->ver_avance($idaccion);
			// $arr_avances = [];
			$data = array('arr_datos_accion' => $arr_datos_accion,'arr_avances' => $arr_avances);
			$str_avances = $this->load->view("pemc/seguimiento_modal_avances", $data, TRUE);
			$response = array('str_avances' => $str_avances);
			// echo "<pre>";print_r($idaccion);die();
			Utilerias::enviaDataJson(200, $response, $this);
			exit;
		}

		public function obtiene_vista_evaluacion(){
			$datos_sesion = Utilerias::get_cct_sesion($this);
			$idpemc = $datos_sesion['idpemc'];
			// $seguimiento = $this->Pemc_model->obtener_seguimiento_xidpemc($datos_sesion['idpemc']);
			// foreach ($seguimiento as $key => $value) {
			// 	$seguimiento[$key]['ambitos']= $this->Pemc_model->obtener_ambitos_xidambitos($value['idambitos']);
			// }
			$evaluacion = $this->Pemc_model->obtener_evaluacion_xidpemc($datos_sesion['idpemc']);
			$evaluaciones = $this->Pemc_model->obtener_evaluaciones_xidpemc($datos_sesion['idpemc']);
			// echo "<pre>";print_r($evaluacion);die();
			$es_fin = $this->Pemc_model->es_fin_ciclo_actual();
			$data = array('evaluaciones' => $evaluaciones,'evaluacion' => $evaluacion, "idpemc" => $idpemc, "es_fin" => $es_fin);
			// echo "<pre>";print_r($data);die();
			$str_vista = $this->load->view("pemc/evaluacion", $data, TRUE);
			$response = array('str_vista' => $str_vista);
			Utilerias::enviaDataJson(200, $response, $this);
			exit;
		}

		public function ver_reporte_xidpemc($idpemc, $url_save=null){
			if(Utilerias::haySesionAbiertacct($this)){
				$datos_sesion = Utilerias::get_cct_sesion($this);
				$cve_centro = $datos_sesion['cve_centro'];
				$turno = $datos_sesion['id_turno_single'];
				$str_cct = "CCT: {$datos_sesion['cve_centro']}";
				$str_nombre = "ESCUELA: {$datos_sesion['nombre_centro']}";
				$fecha = date("Y-m-d");
				$arr_aux = explode("-",$fecha);
				$anio_i = $arr_aux[0];
				$mes_i = $arr_aux[1];
				$dia_i = $arr_aux[2];
				$fecha = " Fecha: ".$dia_i."/".$mes_i."/".$anio_i;
				$ciclo =  $this->Pemc_model->trae_ciclo_actual();
				$ciclo = "CICLO: ".$ciclo;
				$pdf = new PDF_MC_Table($str_cct, $str_nombre, $ciclo);
				$pdf->SetvarHeader($str_cct, $str_nombre, $ciclo);
				$pdf->AliasNbPages();
				$pdf->AddPage('L','Legal');
				// $diagnostico = $this->Pemc_model->obtener_diagnostico_xidpemc($datos_sesion['idpemc']);
				// $pdf->Ln(5);
				// $pdf->SetFont('Arial','B',12);
				// $pdf->SetWidths(array(250)); // ancho de primer columna, segunda, tercera
				// $pdf->SetFillColor(255);
				// $pdf->SetAligns(array("L"));
				// $pdf->SetLineW(array(0.2));
				// $pdf->SetTextColor(0,0,0);
				// 	$pdf->Row1(array(
				// 		utf8_decode("Diagnóstico: ".$diagnostico)
				// 	));
				$seguimiento = $this->Pemc_model->obtener_seguimiento_xidpemc($datos_sesion['idpemc']);
					// echo "<pre>";print_r($seguimiento);die();
					foreach ($seguimiento as $key => $value) {
						if ($value['idambitos'] != '') {
							$seguimiento[$key]['ambitos'] = $this->Pemc_model->obtener_ambitos_xidambitos($value['idambitos']);
						}
						else {
							$seguimiento[$key]['ambitos'] = '';
						}
					}
				$aux_idobjetivo=0;
				foreach ($seguimiento as $key => $value) {
					if ($aux_idobjetivo!=$value['idobjetivo']) {
						$pdf->Ln(2);
						$pdf->SetFont('Arial','B',9);
						$pdf->SetWidths(array(250)); // ancho de primer columna, segunda, tercera
						$pdf->SetFillColor(255);
						$pdf->SetAligns(array("L"));
						$pdf->SetLineW(array(0.2));
						$pdf->SetTextColor(0,0,0);
							$pdf->Row1(array(
								utf8_decode("Objetivo: ".$value['objetivo'])
							));
						$pdf->Ln(2);
						$pdf->SetFont('Arial','',9);
						$pdf->SetWidths(array(250)); // ancho de primer columna, segunda, tercera
						$pdf->SetFillColor(255);
						$pdf->SetAligns(array("L"));
						$pdf->SetLineW(array(0.2));
						$pdf->SetTextColor(0,0,0);
							$pdf->Row1(array(
								utf8_decode("meta(s): ".$value['meta'])
							));
						$pdf->Ln(2);
						$pdf->SetFont('Arial','',9);
						$pdf->SetWidths(array(250)); // ancho de primer columna, segunda, tercera
						$pdf->SetFillColor(255);
						$pdf->SetAligns(array("L"));
						$pdf->SetLineW(array(0.2));
						$pdf->SetTextColor(0,0,0);
							$pdf->Row1(array(
								utf8_decode("Comentario general: ".$value['comentario_general'])
							));
						$pdf->Ln(2);
						$pdf->SetFont('Arial','B',9);
						$pdf->SetWidths(array(336)); // ancho de primer columna, segunda, tercera
						$pdf->SetFillColor(255);
						$pdf->SetAligns(array("C"));
						$pdf->SetLineW(array(0.2));
						$pdf->SetTextColor(0,0,0);
							$pdf->Row1(array(
								utf8_decode("____________________________________________________________________________________________________________________________________________________________________________________________")
							));
					}
					$pdf->Ln(2);
					$pdf->SetFont('Arial','B',9);
					$pdf->SetWidths(array(250)); // ancho de primer columna, segunda, tercera
					$pdf->SetFillColor(255);
					$pdf->SetAligns(array("L"));
					$pdf->SetLineW(array(0.2));
					$pdf->SetTextColor(0,0,0);
						$pdf->Row1(array(
							utf8_decode("Acción: ".$value['accion'])
						));
					$pdf->Ln(2);
					$pdf->SetFont('Arial','',9);
					$pdf->SetWidths(array(250)); // ancho de primer columna, segunda, tercera
					$pdf->SetFillColor(255);
					$pdf->SetAligns(array("L"));
					$pdf->SetLineW(array(0.2));
					$pdf->SetTextColor(0,0,0);
						$pdf->Row1(array(
							utf8_decode("Ámbito(s): ".$value['ambitos'])
						));
					$pdf->Ln(2);
					$pdf->SetFont('Arial','',9);
					$pdf->SetWidths(array(400)); // ancho de primer columna, segunda, tercera
					$pdf->SetFillColor(255);
					$pdf->SetAligns(array("c"));
					$pdf->SetLineW(array(0.2));
					$pdf->SetTextColor(0,0,0);
					$pdf->Row1(array(
						utf8_decode("Fecha inicio: ".$value['finicio']."                                                                                                             "."Fecha fin: ".$value['ffin'] )
					));
					$pdf->Ln(2);
					$pdf->SetFont('Arial','',9);
					$pdf->SetWidths(array(250)); // ancho de primer columna, segunda, tercera
					$pdf->SetFillColor(255);
					$pdf->SetAligns(array("L"));
					$pdf->SetLineW(array(0.2));
					$pdf->SetTextColor(0,0,0);
					// echo "<pre>";print_r($this->get_perosonal_mostrar($datos_sesion['cve_centro'],$value['responsables']));die();
						$pdf->Row1(array(
							utf8_decode("Responsable(s): ".(($value['otros_responsables']=='')?'':$value['otros_responsables'].', ').(($this->get_perosonal_mostrar($datos_sesion['cve_centro'],$value['responsables'])=='')?'': substr($this->get_perosonal_mostrar($datos_sesion['cve_centro'],$value['responsables']), 0, -2)))
						));
						$arr_avances = $this->Pemc_model->	ver_avance($value['idaccion']);
						$pdf->Ln(6);
						$pdf->SetFont('Arial','B',11);
						$pdf->SetWidths(array(110,10,60,60)); // ancho de primer columna, segunda, tercera y cuarta
						$pdf->SetFillColor(255,255,255);
						$pdf->SetAligns(array("L","L"));
						$pdf->SetLineW(array(0.2,0.2));
						$pdf->SetTextColor(0,0,0);
						$pdf->Row1(array(
							"",
							utf8_decode("#"),
							utf8_decode("Fecha"),
							utf8_decode("Porcentaje de avance"),
						));
						$pdf->SetFont('Arial','',10);
						$pdf->SetWidths(array(110,10,60,60));
						$pdf->SetAligns(array("L","L","L"));
						$pdf->SetColors(array(FALSE,FALSE,FALSE));
						$pdf->SetLineW(array(0.09,0.09,0.09));
						$cont=0;
						foreach($arr_avances as $item){
							$cont++;
							$pdf->Row1(array(
								"",
								$cont,
								utf8_decode($item["fcreacion"]),
								utf8_decode($item["avance"])."%"
							));
						}
						$pdf->Ln();
						// echo "<pre>";print_r($arr_avances);die();
						$aux_idobjetivo=$value['idobjetivo'];
				}
				if ($url_save==null) {
					$pdf->Output();
				}
				else {
					$pdf->AddPage('L','Legal');
					$diagnostico = $this->Pemc_model->obtener_diagnostico_xidpemc($datos_sesion['idpemc']);
					$pdf->Ln(5);
					$pdf->SetFont('Arial','B',12);
					$pdf->SetWidths(array(250)); // ancho de primer columna, segunda, tercera
					$pdf->SetFillColor(255);
					$pdf->SetAligns(array("L"));
					$pdf->SetLineW(array(0.2));
					$pdf->SetTextColor(0,0,0);
						$pdf->Row1(array(
							utf8_decode("Diagnóstico: ".$diagnostico)
						));

						$evaluacion = $this->Pemc_model->obtener_evaluacion_xidpemc($datos_sesion['idpemc']);
						$pdf->Ln(5);
						$pdf->SetFont('Arial','B',12);
						$pdf->SetWidths(array(250)); // ancho de primer columna, segunda, tercera
						$pdf->SetFillColor(255);
						$pdf->SetAligns(array("L"));
						$pdf->SetLineW(array(0.2));
						$pdf->SetTextColor(0,0,0);
							$pdf->Row1(array(
								utf8_decode("Evaluación: ".$evaluacion)
							));

					$pdf->Output($url_save,'F');
				}

			}
		}

		public function guarda_evaluacion(){
			$datos_sesion = Utilerias::get_cct_sesion($this);
			$evaluacion = mb_strtoupper($this->input->post('in_eval'));
			// date_default_timezone_set('America/Mexico_City');
			// $hoy = date("Y-m-d_H_i_s");
			// $path_eval = "assets/pdf/pemc_eval/".$datos_sesion['idpemc']."_".$hoy.".pdf";
			// $this->ver_reporte_xidpemc($datos_sesion['idpemc'],$path_eval);
			// echo "<pre>";print_r($evaluacion);die();
			$estatus = $this->Pemc_model->guarda_evaluacion(strip_tags($evaluacion),$datos_sesion['idpemc']);
			$response = array('estatus' => $estatus);
			Utilerias::enviaDataJson(200, $response, $this);
			exit;
		}
		public function guarda_cierre(){
			$datos_sesion = Utilerias::get_cct_sesion($this);
			date_default_timezone_set('America/Mexico_City');
			$hoy = date("Y-m-d_H_i_s");
			if(file_exists("assets/pdf/pemc_eval/".$this->Pemc_model->trae_ciclo_actual()."/".$datos_sesion['idpemc'])) {
				$files = glob("assets/pdf/pemc_eval/".$this->Pemc_model->trae_ciclo_actual()."/".$datos_sesion['idpemc']."/*"); //obtenemos todos los nombres de los ficheros
				foreach($files as $file){
				    if(is_file($file))
				    unlink($file); //elimino el fichero
				}
					// unlink("assets/pdf/pemc_eval/".$datos_sesion['idpemc'], 7777);
			    // mkdir("assets/pdf/pemc_eval/".$datos_sesion['idpemc'], 7777);
			}
			else {
				mkdir("assets/pdf/pemc_eval/".$this->Pemc_model->trae_ciclo_actual()."/".$datos_sesion['idpemc'], 7777,true);
			}

			$path_eval = "assets/pdf/pemc_eval/".$this->Pemc_model->trae_ciclo_actual()."/".$datos_sesion['idpemc']."/_".$hoy.".pdf";

			$this->ver_reporte_xidpemc($datos_sesion['idpemc'],$path_eval);
			// echo "<pre>";print_r($evaluacion);die();
			$estatus = $this->Pemc_model->guarda_cierre($datos_sesion['idpemc'],$path_eval);
			$response = array('estatus' => $estatus);
			Utilerias::enviaDataJson(200, $response, $this);
			exit;
		}




		public function get_perosonal_mostrar($cct, $ids_responsables){

			$ids_responsables = explode(",", $ids_responsables);

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
		    $response = json_decode($result);

				if ($response->status==0) {
					$personal = array();
				}
				else {
					$personal = $response->Personal;
				}

		    $listap = "";
		    foreach ($personal as $persona) {
			    for($i = 0; $i < count($ids_responsables); $i++){
			    	if("'".$persona->rfc."'" == $ids_responsables[$i]){
			    		$listap .= trim($persona->nombre_completo).", ";
			    	}
			    }
		    }
				// echo "<pre>";print_r($listap);die();
		    return $listap;
		}

		public function ver_reporte_diagnostico_xidpemc($idpemc){
			if(Utilerias::haySesionAbiertacct($this)){
				$datos_sesion = Utilerias::get_cct_sesion($this);
				$cve_centro = $datos_sesion['cve_centro'];
				$turno = $datos_sesion['id_turno_single'];
				$str_cct = "CCT: {$datos_sesion['cve_centro']}";
				$str_nombre = "ESCUELA: {$datos_sesion['nombre_centro']}";
				$fecha = date("Y-m-d");
				$arr_aux = explode("-",$fecha);
				$anio_i = $arr_aux[0];
				$mes_i = $arr_aux[1];
				$dia_i = $arr_aux[2];
				$fecha = " Fecha: ".$dia_i."/".$mes_i."/".$anio_i;
				$ciclo =  $this->Pemc_model->trae_ciclo_actual();
				$ciclo = "CICLO: ".$ciclo;
				$pdf = new PDF_MC_Table($str_cct, $str_nombre, $ciclo);
				$pdf->SetvarHeader($str_cct, $str_nombre, $ciclo);
				$pdf->AliasNbPages();

					$pdf->AddPage('L','Legal');
					$diagnostico = $this->Pemc_model->obtener_diagnostico_xidpemc($datos_sesion['idpemc']);
					$pdf->Ln(5);
					$pdf->SetFont('Arial','B',12);
					$pdf->SetWidths(array(250)); // ancho de primer columna, segunda, tercera
					$pdf->SetFillColor(255);
					$pdf->SetAligns(array("L"));
					$pdf->SetLineW(array(0.2));
					$pdf->SetTextColor(0,0,0);
						$pdf->Row1(array(
							utf8_decode("Diagnóstico: ".$diagnostico)
						));

					$pdf->Output();


			}
		}
}
