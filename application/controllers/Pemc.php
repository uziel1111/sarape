<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header("Content-Type: text/html;charset=utf-8");

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
		// $this->load->library('PDF_MC_Table');
		$this->load->library('My_tcpdf');
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
					// echo"es super"; die();
					$mensaje = "Acceso Restringido.";
					$tipo    = ERRORMESSAGE;
					$this->session->set_flashdata(MESSAGEREQUEST, Utilerias::get_notification_alert($mensaje, $tipo));
					$this->load->view('pemc/login',$data);
				}else{
					// echo"else super"; die();
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
						$datoscct = $this->Pemc_model->getdatoscct($usuario, $turno);
						$datoscct = $datoscct[0];
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
		$esta_cerrado_ciclo = $this->Pemc_model->esta_cerrado_ciclo_actual($datos_sesion['idpemc']);

		$data = array('diagnostico' => $diagnostico, 'idpemc' => $datos_sesion['idpemc'], 'es_inicio' => $es_inicio, 'esta_cerrado_ciclo' => $esta_cerrado_ciclo);
		$str_vista = $this->load->view("pemc/diagnostico", $data, TRUE);
		$response = array('str_vista' => $str_vista);
		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function guarda_diagnostico(){
		// echo"<pre>";
		// print_r($_POST);
		// die();
		$datos_sesion = Utilerias::get_cct_sesion($this);
		$diagnostico = $this->input->post('in_diag');
		$estatus = $this->Pemc_model->guarda_diagnostico($diagnostico,$datos_sesion['idpemc']);
		$response = array('estatus' => $estatus);
		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function obtiene_vista_objetivosymetas(){
		$datos_sesion = Utilerias::get_cct_sesion($this);

		$objetivos = $this->Objetivo_model->get_objetivos_x_idpemc($datos_sesion['idpemc']);
		$data['objetivos'] = $objetivos;
		$esta_cerrado_ciclo = $this->Pemc_model->esta_cerrado_ciclo_actual($datos_sesion['idpemc']);
		$data['esta_cerrado_ciclo'] = $esta_cerrado_ciclo;
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
			$esta_cerrado_ciclo = $this->Pemc_model->esta_cerrado_ciclo_actual($datos_sesion['idpemc']);
			$data['esta_cerrado_ciclo'] = $esta_cerrado_ciclo;
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
			// echo "<pre>";print_r($datos_sesion);die();
			$es_fin = $this->Pemc_model->es_fin_ciclo_actual();

			$data = array('evaluaciones' => $evaluaciones,'evaluacion' => $evaluacion, "idpemc" => $idpemc, "es_fin" => $es_fin);
			$esta_cerrado_ciclo = $this->Pemc_model->esta_cerrado_ciclo_actual($datos_sesion['idpemc']);
			$data['esta_cerrado_ciclo'] = $esta_cerrado_ciclo;
			$data['cve_centro'] = $datos_sesion['cve_centro'];
			$data['id_turno_single'] = $datos_sesion['id_turno_single'];
			$data['n_acciones_pemc_ant'] = $this->Pemc_model->obtener_n_acciones_pemc_ant($datos_sesion['cve_centro'],$datos_sesion['id_turno_single']);
			// echo "<pre>";print_r($data);die();
			$str_vista = $this->load->view("pemc/evaluacion", $data, TRUE);
			$response = array('str_vista' => $str_vista);
			Utilerias::enviaDataJson(200, $response, $this);
			exit;
		}

		public function guarda_evaluacion(){
			$datos_sesion = Utilerias::get_cct_sesion($this);
			$evaluacion = $this->input->post('in_eval');
			// date_default_timezone_set('America/Mexico_City');
			// $hoy = date("Y-m-d_H_i_s");
			// $path_eval = "assets/pdf/pemc_eval/".$datos_sesion['idpemc']."_".$hoy.".pdf";
			// $this->ver_te_xidpemc($datos_sesion['idpemc'],$path_eval);
			// echo "<pre>";print_r($evaluacion);die();
			$estatus = $this->Pemc_model->guarda_evaluacion($evaluacion,$datos_sesion['idpemc']);
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
				mkdir("assets/pdf/pemc_eval/".$this->Pemc_model->trae_ciclo_actual()."/".$datos_sesion['idpemc'], 0777,true);
			}

			$path_eval = "assets/pdf/pemc_eval/".$this->Pemc_model->trae_ciclo_actual()."/".$datos_sesion['idpemc']."/_".$hoy.".pdf";

			$this->reporte_pemc($datos_sesion['idpemc'],$path_eval);
			// echo "<pre>";print_r($evaluacion);die();
			$estatus = $this->Pemc_model->guarda_cierre($datos_sesion['idpemc'],$path_eval);
			$response = array('estatus' => $estatus);
			Utilerias::enviaDataJson(200, $response, $this);
			exit;
		}

		function reporte_detalle($idpemc){
			if(Utilerias::haySesionAbiertacct($this)){
			$datos_sesion = Utilerias::get_cct_sesion($this);


			$pdf = new My_tcpdf_page(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('PE');
			$pdf->SetTitle('Diagnostico');
			$pdf->SetSubject('');
			$pdf->SetKeywords('');
			$this->pinta_encabezado_pemc($pdf,$datos_sesion);
			$pdf->CreateTextBox('Diagnóstico: ', 0, 18, 10, 70, 14, 'B', 'L');
			$y2=$pdf->GetY()+6;
			$pdf->SetFont('arial', '', 8);
			$diagnostico = $this->Pemc_model->obtener_diagnostico_xidpemc($datos_sesion['idpemc']);
			$pdf->writeHTMLCell($w=0,$h=55,$x=10,$y=60, $diagnostico, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);
			$pdf->Output('diagnostico.pdf', 'I');

		}
	}// reporte_acceso_dia()


	function reporte_pemc($idpemc, $url_save=null){
		if(Utilerias::haySesionAbiertacct($this)){
			$pdf = new My_tcpdf_page(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Alex');
			$pdf->SetTitle('Reporte PEMC');
			$pdf->SetSubject('');
			$pdf->SetKeywords('');
			$datos_sesion = Utilerias::get_cct_sesion($this);
			$this->pinta_encabezado_pemc($pdf,$datos_sesion);
			$pdf->SetAutoPageBreak(FALSE, 0);
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
			// echo "<pre>";print_r($aux_idobjetivo);die();
			$y2=52;
			// echo "<pre>";print_r($y2);die();
			foreach ($seguimiento as $key => $value) {

				if ($aux_idobjetivo!=$value['idobjetivo']) {
					$pdf->SetTextColor(0,0,0);
					$pdf->SetFont('arial', '', 8);
					$pdf->writeHTMLCell($w=0,$h=55,$x=10,$y=$y2, "_______________________________________________________________________________________________________________________________________________________________________________", $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);
					$y2=$y2+4;
					if ($y2>=200) {
						$this->pinta_encabezado_pemc($pdf,$datos_sesion);
						$pdf->SetAutoPageBreak(FALSE, 0);
						$y2=52;
					}

					$pdf->SetTextColor(0,0,0);
					$pdf->SetFont('arialb', '', 8);
					$pdf->writeHTMLCell($w=0,$h=55,$x=10,$y=$y2, "Objetivo: ".$value['objetivo'], $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);
					$y2=$y2+8;
					if ($y2>=200) {
						$this->pinta_encabezado_pemc($pdf,$datos_sesion);
						$pdf->SetAutoPageBreak(FALSE, 0);
						$y2=52;
					}
					// echo "<pre>";print_r($y2);die();
					$pdf->SetTextColor(0,0,0);
					$pdf->SetFont('arial', '', 8);
					$pdf->writeHTMLCell($w=0,$h=55,$x=10,$y=$y2, "Meta(s): ".$value['meta'], $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);
					$y2=$y2+8;
					if ($y2>=200) {
						$this->pinta_encabezado_pemc($pdf,$datos_sesion);
						$pdf->SetAutoPageBreak(FALSE, 0);
						$y2=52;
					}

					$pdf->SetTextColor(0,0,0);
					$pdf->SetFont('arial', '', 8);
					$pdf->writeHTMLCell($w=0,$h=55,$x=10,$y=$y2, "Comentario general: ".$value['comentario_general'], $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);
					$y2=$y2+8;
					if ($y2>=200) {
						$this->pinta_encabezado_pemc($pdf,$datos_sesion);
						$pdf->SetAutoPageBreak(FALSE, 0);
						$y2=52;
					}

					$pdf->SetTextColor(0,0,0);
					$pdf->SetFont('arial', '', 8);
					$pdf->writeHTMLCell($w=0,$h=55,$x=10,$y=$y2, "_______________________________________________________________________________________________________________________________________________________________________________", $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);
					$y2=$y2+5;
					if ($y2>=200) {
						$this->pinta_encabezado_pemc($pdf,$datos_sesion);
						$pdf->SetAutoPageBreak(FALSE, 0);
						$y2=52;
					}
				}
				$pdf->SetTextColor(0,0,0);
				$pdf->SetFont('arial', '', 8);
				$pdf->writeHTMLCell($w=0,$h=55,$x=10,$y=$y2, "Acción: ".$value['accion'], $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);
				$y2=$y2+8;
				if ($y2>=200) {
					$this->pinta_encabezado_pemc($pdf,$datos_sesion);
					$pdf->SetAutoPageBreak(FALSE, 0);
					$y2=52;
				}

				$pdf->SetTextColor(0,0,0);
				$pdf->SetFont('arial', '', 8);
				$pdf->writeHTMLCell($w=0,$h=55,$x=10,$y=$y2, "Ámbito(s): ".$value['ambitos'], $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);
				$y2=$y2+8;
				if ($y2>=200) {
					$this->pinta_encabezado_pemc($pdf,$datos_sesion);
					$pdf->SetAutoPageBreak(FALSE, 0);
					$y2=52;
				}

				$pdf->SetTextColor(0,0,0);
				$pdf->SetFont('arial', '', 8);
				$pdf->writeHTMLCell($w=0,$h=55,$x=10,$y=$y2, "Fecha inicio: ".$value['finicio']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"."Fecha fin: ".$value['ffin'], $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);
				$y2=$y2+5;
				if ($y2>=200) {
					$this->pinta_encabezado_pemc($pdf,$datos_sesion);
					$pdf->SetAutoPageBreak(FALSE, 0);
					$y2=52;
				}

				$pdf->SetTextColor(0,0,0);
				$pdf->SetFont('arial', '', 8);
				$pdf->writeHTMLCell($w=0,$h=55,$x=10,$y=$y2, "Responsable(s): ".(($value['otros_responsables']=='')?'':$value['otros_responsables'].', ').(($this->get_perosonal_mostrar($datos_sesion['cve_centro'],$value['responsables'])=='')?'': substr($this->get_perosonal_mostrar($datos_sesion['cve_centro'],$value['responsables']), 0, -2)), $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);
				$y2=$y2+10;
				if ($y2>=200) {
					$this->pinta_encabezado_pemc($pdf,$datos_sesion);
					$pdf->SetAutoPageBreak(FALSE, 0);
					$y2=52;
				}

				$pdf->SetTextColor(0,0,0);
		  	$pdf->SetFont('arialb', '', 10);


					$arr_avances = $this->Pemc_model->	ver_avance($value['idaccion']);
					if (count($arr_avances)>0) {
						$str_html = <<<EOT
						<style>
						table td{
							border: 1px solid #E6E7E9;
							padding: 2px !important;
						}

						</style>
							<table style="padding: 7px; border-left: 40px; border-right: 40px; border-top: 40px; border-bottom: 40px;">
						<tr style="background-color:#414143">
							<td style="text-align:center" width="5%" height="28px"><font color="white"><b>#</b></font></td>
							<td style="text-align:center" width="52%" height="28px"><font color="white"><b>Fecha</b></font></td>
							<td style="text-align:center" width="45%" height="28px"><font color="white"><b>Porcentaje de avance</b></font></td>
						</tr>
EOT;

					$cont=0;
					foreach($arr_avances as $item){
						$fcreacion = $item['fcreacion'];
						$avance = $item['avance'];
						$cont++;
						if($cont % 2 == 0){
						$color="#F7F9F9";
						}
						else {
							$color="#FFFFFF";
						}
						  		$str_html .= <<<EOD
						  		<tr bgcolor="$color">
									<td style="text-align:center" height="18px">&nbsp;$cont</td>
						  		<td height="18px">&nbsp;$fcreacion</td>
						  		<td style="text-align:center" height="18px">$avance%</td>
						  </tr>
EOD;

					}
					$str_html .= '</table>';
					$html= <<<EOT
					$str_html
EOT;
					// $y2=$y2+3;
						if (($y2+($cont*10))>=200) {
							$this->pinta_encabezado_pemc($pdf,$datos_sesion);
							$pdf->SetAutoPageBreak(TRUE, 10);
							// $pdf->SetAutoPageBreak(FALSE, 0);
							$y2=52;
						}
						$pdf->writeHTMLCell($w=0,$h=20,$x=10,$y=$y2, $html, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);
						// $y2=$y2+5;
						$pdf->SetAutoPageBreak(FALSE, 0);
						$y2=$y2+($cont*10)+10;
						if ($y2>=200) {
							$this->pinta_encabezado_pemc($pdf,$datos_sesion);
							$pdf->SetAutoPageBreak(FALSE, 0);
							$y2=52;
						}
					}
					else {
						$str_html= <<<EOT
						<div>Acción sin avances</div>
EOT;
$html= <<<EOT
$str_html
EOT;
						// $y2=$y2+2;
						if ($y2>=200) {
							$this->pinta_encabezado_pemc($pdf,$datos_sesion);
							$pdf->SetAutoPageBreak(FALSE, 0);
							$y2=52;
						}
						$pdf->writeHTMLCell($w=0,$h=20,$x=10,$y=$y2, $html, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);
						// $y2=$y2+5;
						// $y2=$y2+($cont*15);
						$y2=$y2+10;
						if ($y2>=200) {
							$this->pinta_encabezado_pemc($pdf,$datos_sesion);
							$pdf->SetAutoPageBreak(FALSE, 0);
							$y2=52;
						}
					}
				$aux_idobjetivo=$value['idobjetivo'];
			}

// die();
			if ($url_save==null) {
				$pdf->Output();
			}
			else {
				$this->pinta_encabezado_pemc($pdf,$datos_sesion);
				$y2=52;
				$pdf->SetTextColor(0,0,0);
				$pdf->SetFont('arialb', '', 8);
				$diagnostico = $this->Pemc_model->obtener_diagnostico_xidpemc($datos_sesion['idpemc']);
				$pdf->writeHTMLCell($w=0,$h=55,$x=10,$y=$y2, "Diagnóstico: ".$diagnostico, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

				$this->pinta_encabezado_pemc($pdf,$datos_sesion);
				$y2=52;
				$pdf->SetTextColor(0,0,0);
				$pdf->SetFont('arialb', '', 8);
				$evaluacion = $this->Pemc_model->obtener_evaluacion_xidpemc($datos_sesion['idpemc']);
				$pdf->writeHTMLCell($w=0,$h=55,$x=10,$y=$y2, "Evaluación: ".$evaluacion, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);
				if ($_SERVER["HTTP_HOST"]=='localhost') {
					$ruta=$_SERVER["DOCUMENT_ROOT"]."/sarape/".$url_save;
				}
				else {
					$ruta=$_SERVER["DOCUMENT_ROOT"].$url_save;
				}
				$pdf->Output($ruta,'F');
			}
	}
}// reporte_acceso_dia()

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

	public function pinta_encabezado_pemc($pdf,$datos_sesion){

		$cve_centro = $datos_sesion['cve_centro'];
		$turno = $datos_sesion['id_turno_single'];
		$str_cct = "CCT: {$datos_sesion['cve_centro']}";
		$str_nombre = $datos_sesion['nombre_centro'];
		$cte = $this->Pemc_model->get_cte();
		$str_cte = "Consejo técnico escolar: {$cte}";
		$fecha = date("Y-m-d");
		$arr_aux = explode("-",$fecha);
		$anio_i = $arr_aux[0];
		$mes_i = $arr_aux[1];
		$dia_i = $arr_aux[2];
		$fecha = " Fecha: ".$dia_i."/".$mes_i."/".$anio_i;
		$ciclo =  $this->Pemc_model->trae_ciclo_actual();
		$pdf->SetTextColor(65, 65, 67);
		$pdf->SetMargins(10, 10, 10, true); // set the margins
		// $pdf->SetFooterMargin(50); // set the margins
		$pdf->AddPage('L', 'Legal');
		$pdf->SetAutoPageBreak(TRUE, 10);
		$pdf->SetFont('montserratb', '', 17);
		$pdf->Cell(0, 60, 'Programa Escolar de Mejora Continua (PEMC)', 0, 1, 'C');
		$cte = $this->Pemc_model->get_cte();
		$pdf->CreateTextBox('Consejo técnico escolar: '.$cte, 95, 13, 10, 70, 14, 'B', 'L');


		$pdf->Image($file='assets/img/logoreporte.png', $x=7, $y=12, $w=65, $h=12, $type='', $link='', $align='', $resize=true, $dpi=100, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false);

		$pdf->SetTextColor(65, 65, 67);
		$pdf->CreateTextBox('CCT: ', 220, 8, 180, 10, 9, 'B', 'L');
		$pdf->CreateTextBox('Escuela: ', 220, 13, 180, 10, 9, 'B', 'L');
		$pdf->SetFont('montserrat', '', 17);
		$pdf->CreateTextBox($cve_centro, 229, 8, 180, 10, 9, '', 'L');
		$long_nombre=strlen($str_nombre);
		$pdf->MultiCell(0, 12, $str_nombre, 0, 'L', 0, 0, 255, 16, true);
		if ($long_nombre>=20){
			$y=$pdf->GetY()+12;
		}
		else {
			$y=$pdf->GetY()+3;
		}
		$pdf->SetFont('montserratb', '', 17);
		$pdf->CreateTextBox('Ciclo:', 220,$y,180, 10, 9, 'B', 'L');
		$pdf->SetFont('montserrat', '', 17);
		$pdf->CreateTextBox($ciclo, 229,$y,180, 10, 9, '', 'L');

	}


}
