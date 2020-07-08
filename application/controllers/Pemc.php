<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemc extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->data = array( );
		$this->logged_in = FALSE;
		$this->load->library('Utilerias');
		$this->load->model('Pemc_model');
		$this->load->database();
		$this->cct = array();
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
		$data = array('diagnostico' => $diagnostico);
		$str_vista = $this->load->view("pemc/diagnostico", $data, TRUE);
		$response = array('str_vista' => $str_vista);
		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function guarda_diagnostico(){
		$datos_sesion = Utilerias::get_cct_sesion($this);
		$diagnostico = $this->input->post('in_diag');
		$estatus = $this->Pemc_model->guarda_diagnostico(strip_tags($diagnostico),$datos_sesion['idpemc']);
		$response = array('estatus' => $estatus);
		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function obtiene_vista_objetivosymetas(){
		$datos_sesion = Utilerias::get_cct_sesion($this);
		// $diagnostico = $this->Pemc_model->obtener_diagnostico_xidpemc($datos_sesion['idpemc']);
		// $data = array('diagnostico' => $diagnostico);
		$data = array();
		$str_vista = $this->load->view("pemc/objetivos_metas_acciones", $data, TRUE);
		$response = array('str_vista' => $str_vista);
		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

		public function obtiene_vista_seguimiento(){
			$datos_sesion = Utilerias::get_cct_sesion($this);
			$seguimiento = $this->Pemc_model->obtener_seguimiento_xidpemc($datos_sesion['idpemc']);
			foreach ($seguimiento as $key => $value) {
				$seguimiento[$key]['ambitos']= $this->Pemc_model->obtener_ambitos_xidambitos($value['idambitos']);
			}
			// echo "<pre>";print_r($seguimiento);die();
			$data = array('seguimiento' => $seguimiento);
			// echo "<pre>";print_r($data);die();
			$str_vista = $this->load->view("pemc/seguimiento", $data, TRUE);
			$response = array('str_vista' => $str_vista);
			Utilerias::enviaDataJson(200, $response, $this);
			exit;
		}
}
