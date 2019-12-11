<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rutademejora extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->data = array( );
		$this->logged_in = FALSE;
		$this->load->library('Utilerias');
		$this->load->model('Prioridad_model');
		$this->load->model('Problematica_model');
		$this->load->model('Evidencia_model');
		$this->load->model('Prog_apoyo_xcct_model');
		$this->load->model('Apoyo_req_model');
		$this->load->model('Ambito_model');
		$this->load->model('Rutamejora_model');
		$this->cct = array();
	}

	public function index(){
		if(Utilerias::verifica_sesion_redirige($this)){
			$this->cct = Utilerias::get_cct_sesion($this);
			if(isset($this->cct[0]['tipo_usuario_pemc'])){
				Utilerias::destroy_all_session_cct($this);
				redirect('Rutademejora/index');
			}else{
				$this->index_new();
			}
			
		}else{
			$data = $this->data;
			$data['error'] = '';
			$this->load->view('ruta/login',$data);
		}
		}// index()

		public function cerrar_sesion(){
			Utilerias::destroy_all_session_cct($this);
			redirect('Rutademejora/index');
		}

		public function acceso(){
			if(Utilerias::verifica_sesion_redirige($this)){
				$this->cct = Utilerias::get_cct_sesion($this);
				if(isset($this->cct[0]['id_supervision'])){
					$this->generavistaSupervisor();
				}else{
					if(isset($this->cct[0]['tipo_usuario_pemc'])){
						Utilerias::destroy_all_session_cct($this);
						redirect('Rutademejora/index');
					}else{
						$this->index_new();
					}
				}

			}else{
				$usuario = strtoupper($this->input->post('usuario'));
				$pass = strtoupper($this->input->post('password'));
				$turno = $this->input->post('turno_id');

				if($this->verifica_supervisor($usuario) == TRUE){
					$datos_sesion = $this->iniciamos_sesion_supervisor($usuario, $pass, $turno);
					if($datos_sesion->procede == 1 && $datos_sesion->status == 1){					
						$datoscct = $this->Rutamejora_model->getdatossupervicion($usuario, $turno);
						$datoscct[0]['id_turno_single'] = $turno;
						Utilerias::set_cct_sesion($this, $datoscct);

						$this->generavistaSupervisor();																					    		    												
					}else{
						$mensaje = $response->statusText;
						$tipo    = ERRORMESSAGE;
						$this->session->set_flashdata(MESSAGEREQUEST, Utilerias::get_notification_alert($mensaje, $tipo));
						$this->load->view('ruta/login',$data);
					}
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
						$datoscct = $this->Rutamejora_model->getdatoscct($usuario, $turno);
						$datoscct[0]['id_turno_single'] = $turno;
							
						Utilerias::set_cct_sesion($this, $datoscct);

						
						$this->index_new();

						
					}else{
						$mensaje = $response->statusText;
						$tipo    = ERRORMESSAGE;
						$this->session->set_flashdata(MESSAGEREQUEST, Utilerias::get_notification_alert($mensaje, $tipo));
						$this->load->view('ruta/login',$data);
					}
				}
			}
		}// index()

		public function llenadatos(){
			$this->cct = Utilerias::get_cct_sesion($this);
			$usuario = $this->cct[0]['cve_centro'];
			$responsables = $this->getPersonal($usuario);
			
			if ($responsables->status==0) {
				$personas = array();
			}
			else {
				$personas = $responsables->Personal;
			}

			$options = "";
			if($responsables->procede == 1 && $responsables->status == 1){
				foreach ($personas as $persona) {
					$options .= "<option value='{$persona->rfc}'>".$persona->nombre_completo."</option>";
				}
				$options .="<option value='0'>OTRO</option>";
			}else{
				$options .="<option value='0'>OTRO</option>";
			}

			$data['responsables'] = $options;


			$mision = $this->Rutamejora_model->get_misionxcct($this->cct[0]['id_cct'],'4');
			$data['mision'] = $mision;
			$result_prioridades = $this->Prioridad_model->get_prioridadesxnivel($this->cct[0]['nivel']);
			
			if(count($result_prioridades)==0){
				$data['arr_prioridades'] = array(	'-1' => 'Error recuperando los prioridades' );
			}else{
				$data['arr_prioridades'] = $result_prioridades;
			}
			$result_problematicas = $this->Problematica_model->get_problematicas();
			if(count($result_problematicas)==0){
				$data['arr_problematicas'] = array(	'-1' => 'Error recuperando los problematicas' );
			}else{
				$data['arr_problematicas'] = $result_problematicas;
			}
			$result_evidencias = $this->Evidencia_model->get_evidencias();
			if(count($result_evidencias)==0){
				$data['arr_evidencias'] = array(	'-1' => 'Error recuperando los evidencias' );
			}else{
				$data['arr_evidencias'] = $result_evidencias;
			}
				
			$data['nivel'] = $this->cct[0]['nivel'];//$nivel;
			$data['nombreuser'] = $this->cct[0]['nombre_centro'];
			$data['turno'] = $this->cct[0]['turno_single'];
			$data['cct'] = $this->cct[0]['cve_centro'];
			Utilerias::pagina_basica_rm($this, "ruta/index", $data);
		}

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


		public function insert_tema_prioritario(){
			if(Utilerias::haySesionAbiertacct($this)){
				$this->cct = Utilerias::get_cct_sesion($this);
				
				$id_prioridad = $this->input->post("id_prioridad");
				$objetivo1 = $this->input->post("objetivo1");
				$meta1 = $this->input->post("meta1");
				$objetivo2 = $this->input->post("objetivo2");
				$meta2 = $this->input->post("meta2");
				$problematica = $this->input->post("problematica");
				$evidencia = $this->input->post("evidencia");
				$ids_progapoy = $this->input->post("ids_progapoy");
				$otro_pa = $this->input->post("otro_pa");
				$como_prog_ayuda = $this->input->post("como_prog_ayuda");
				$obs_direct = $this->input->post("obs_direct");
				$ids_apoyreq = $this->input->post("ids_apoyreq");
				$otroapoyreq = $this->input->post("otroapoyreq");
				$especifiqueapyreq = $this->input->post("especifiqueapyreq");

				$nombre_archivo = str_replace(" ", "_", $_FILES['archivo']['name']);
				$estatus = $this->Rutamejora_model->insert_tema_prioritario($id_cct,$id_prioridad,$objetivo1,$meta1,$objetivo2,$meta2,$problematica,$evidencia,$ids_progapoy,$otro_pa,$como_prog_ayuda,$obs_direct,$ids_apoyreq,$otroapoyreq,$especifiqueapyreq);
				if ($estatus != false) {
					if ($nombre_archivo!='') {
						$ruta_archivos = "evidencias_rm/{$id_cct}/{$estatus}/";
						$ruta_archivos_save = "evidencias_rm/{$id_cct}/{$estatus}/$nombre_archivo";
						$estatusinst_urlarch = $this->Rutamejora_model->insert_evidencia($id_cct,$estatus,$ruta_archivos_save);
						if(!is_dir($ruta_archivos)){
							mkdir($ruta_archivos, 0777, true);}
							$_FILES['userFile']['name']     = $_FILES['archivo']['name'];
							$_FILES['userFile']['type']     = $_FILES['archivo']['type'];
							$_FILES['userFile']['tmp_name'] = $_FILES['archivo']['tmp_name'];
							$_FILES['userFile']['error']    = $_FILES['archivo']['error'];
							$_FILES['userFile']['size']     = $_FILES['archivo']['size'];

							$uploadPath              = $ruta_archivos;
							$config['upload_path']   = $uploadPath;
							$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|xlsx|xls|doc|docx|txt|';

							$this->load->library('upload', $config);
							$this->upload->initialize($config);
							if ($this->upload->do_upload('userFile')) {
								$fileData = $this->upload->data();
								$str_view = true;
							}
						}
						$estatus = true;
					}
					$response = array('estatus' => $estatus);
					Utilerias::enviaDataJson(200, $response, $this);
					exit;
				}else{
					redirect('Rutademejora/index');
				}
			}

			public function insert_update_misioncct(){
				if(Utilerias::haySesionAbiertacct($this)){
					$this->cct = Utilerias::get_cct_sesion($this);
				
					
					$cct = $this->cct[0]['cve_centro'];
					$turno = $this->cct[0]['id_turno_single'];
					$misioncct = $this->input->post("misioncct");
					if ($this->Rutamejora_model->existe_misionxidcct($cct, $turno,'4')) {
						$estatus = $this->Rutamejora_model->update_misionxidcct($cct,$turno,$misioncct,'4');
					}
					else {
						$estatus = $this->Rutamejora_model->insert_misionxidcct($cct,$turno,$misioncct,'4');
					}

					$response = array('estatus' => $estatus);
					Utilerias::enviaDataJson(200, $response, $this);
					exit;
				}else{
					redirect('Rutademejora/index');
				}
			}

			public function bajarutamejora(){
				if(Utilerias::haySesionAbiertacct($this)){
					$this->cct = Utilerias::get_cct_sesion($this);
					
					$cct = $this->cct[0]['cve_centro'];
					$turno = $this->cct[0]['id_turno_single'];
					
					$tam = 0;
				
				$temas_prioritarios = $this->Rutamejora_model->getPrioridades($cct, $turno); //Verificamos si esa cct ya tiene temas prioritarios
				$tam = count($temas_prioritarios);

				if (count($temas_prioritarios)>0) {
					
					$tabla = "<div class='table-responsive' >
					<table id='id_tabla_rutas' class='table table-condensed table-hover  table-bordered'>
					<thead disabled>
					<tr class=info style='vertical-align:middle'>
					<th id='id_tprioritario' hidden><center>id_tprioritario</center></th>
					<th id='id_prioridad' hidden><center>id_prioridad</center></th>
					<th id='orden' style='width:3%; vertical-align:middle;'><center>#</center></th>
					<th id='tema' style='width:30%; vertical-align:middle;'><center>Líneas de Acción Estratégicas/Ámbitos PEMC</center></th>
					<th id='objetivos' style='width:10%; vertical-align:middle;'><center>Objetivos y metas</center></th>
					<th id='n_actividades' style='width:3%; vertical-align:middle;'><center>Acciones</center></th>
					</tr>
					</thead>
					<tbody id='id_tbody_demo'>";
					foreach ($temas_prioritarios as $tp) {
						$tabla .= "<tr>
						<td id='id_tprioritario' hidden><center>{$tp['id_tprioritario']}</center></td>
						<td id='id_prioridad' hidden>{$tp['id_prioridad']}</td>
						<td id='orden' style='vertical-align:middle;'><center>LAE-{$tp['orden']}</center></td>
						<td id='prioridad' style='vertical-align:middle;'>{$tp['prioridad']}<br> Ámbito(s): {$tp['ambito']}</td>
						<td id='num_objetivos' style='vertical-align:middle;'><center>{$tp['num_objetivos']}</center></td>
						<td id='num_acciones' style='vertical-align:middle;'><center>{$tp['num_acciones']}</center></td>
						</tr>";

					}

					$tabla .= "</tbody>
					</table>
					</div>  ";

				} else {
						
					$new_tprioritarios = $this->Rutamejora_model->insertaTprioritarios($cct, $turno);
					$temas_prioritarios = $this->Rutamejora_model->getPrioridades($cct, $turno);

					$tabla = "<div class='table-responsive text-center' >
					<table id='id_tabla_rutas' class='table table-condensed table-hover  table-bordered'>
					<thead>
					<tr class=info style='vertical-align:middle'>
					<th id='id_tprioritario' hidden><center>id_tprioritario</center></th>
					<th id='id_prioridad' hidden><center>id_prioridad</center></th>
					<th id='id_subprioridad' hidden><center>id_subprioridad</center></th>
					<th id='orden' style='width:7%; vertical-align:middle;'><center>#</center></th>
					<th id='tema' style='width:30%; vertical-align:middle;'><center>Plan de Mejora Continua</center></th>
					<th id='objetivos' style='width:10%; vertical-align:middle;'><center>Objetivos y metas</center></th>
					<th id='n_actividades' style='width:3%; vertical-align:middle;'><center>Actividades</center></th>
					</tr>
					</thead>
					<tbody id='id_tbody_demo'>";

					foreach ($temas_prioritarios as $tp) {
						$tabla .= "<tr>
						<td id='id_tprioritario' hidden><center>{$tp['id_tprioritario']}</center></td>
						<td id='id_prioridad' hidden>{$tp['id_prioridad']}</td>
						<td id='id_prioridad' hidden>{$tp['id_subprioridad']}</td>
						<td id='orden' style='vertical-align:middle;'>LAE-{$tp['orden']}</td>
						<td id='prioridad' style='vertical-align:middle;'>{$tp['prioridad']}</td>
						<td id='num_objetivos' style='vertical-align:middle;' >{$tp['num_objetivos']}</td>
						<td id='num_acciones' style='vertical-align:middle;' >{$tp['num_acciones']}</td>
						</tr>";
					}

					$tabla .= "</tbody>
					</table>
					</div>  ";
				}

				
				$response = array('tabla' => $tabla, 'tamanio' => $tam);
				Utilerias::enviaDataJson(200, $response, $this);
				exit;
			}else{
				redirect('Rutademejora/index');
			}
		}


		public function get_obs_super(){
			if(Utilerias::haySesionAbiertacct($this)){
				$id_tprioritario = $this->input->post('id_tprioritario');
				$str_obs_super = $this->Rutamejora_model->get_obs_super_tp($id_tprioritario);
				$response = array('str_obs_super' => $str_obs_super);
				Utilerias::enviaDataJson(200, $response, $this);
				exit;
			}else{
				redirect('Rutademejora/index');
			}
		}

		public function update_tema_prioritario(){
			$this->cct = Utilerias::get_cct_sesion($this);
			$id_cct = $this->cct[0]['id_cct'];
			$id_tprioritario = $this->input->post("id_id_tprioritario");
			$id_prioridad = $this->input->post("id_prioridad");
			$objetivo1 = $this->input->post("objetivo1");
			$meta1 = $this->input->post("meta1");
			$objetivo2 = $this->input->post("objetivo2");
			$meta2 = $this->input->post("meta2");
			$problematica = $this->input->post("problematica");
			$evidencia = $this->input->post("evidencia");
			$ids_progapoy = $this->input->post("ids_progapoy");
			$otro_pa = $this->input->post("otro_pa");
			$como_prog_ayuda = $this->input->post("como_prog_ayuda");
			$obs_direct = $this->input->post("obs_direct");
			$ids_apoyreq = $this->input->post("ids_apoyreq");
			$otroapoyreq = $this->input->post("otroapoyreq");
			$especifiqueapyreq = $this->input->post("especifiqueapyreq");
			$edit_img = $this->input->post("edit_img");

			$nombre_archivo = str_replace(" ", "_", $_FILES['archivo']['name']);

			if ($nombre_archivo=='') {
				if ($edit_img=='true') {
					$estatus = $this->Rutamejora_model->update_tema_prioritario($id_cct,$id_tprioritario,$id_prioridad,$objetivo1,$meta1,$objetivo2,$meta2,$problematica,$evidencia,$ids_progapoy,$otro_pa,$como_prog_ayuda,$obs_direct,$ids_apoyreq,$otroapoyreq,$especifiqueapyreq);
				}
				else {
					$url = $this->Rutamejora_model->get_url_evidencia($id_cct,$id_tprioritario);
					if ($url!='') {
						unlink($url);
					}
					$estatusinst_urlarch = $this->Rutamejora_model->insert_evidencia($id_cct,$id_tprioritario,'');
					$estatus = $this->Rutamejora_model->update_tema_prioritario($id_cct,$id_tprioritario,$id_prioridad,$objetivo1,$meta1,$objetivo2,$meta2,$problematica,$evidencia,$ids_progapoy,$otro_pa,$como_prog_ayuda,$obs_direct,$ids_apoyreq,$otroapoyreq,$especifiqueapyreq);
				}
			}
			else {
				$url = $this->Rutamejora_model->get_url_evidencia($id_cct,$id_tprioritario);
				if ($url!='') {
					unlink($url);
				}

				$estatus = $this->Rutamejora_model->update_tema_prioritario($id_cct,$id_tprioritario,$id_prioridad,$objetivo1,$meta1,$objetivo2,$meta2,$problematica,$evidencia,$ids_progapoy,$otro_pa,$como_prog_ayuda,$obs_direct,$ids_apoyreq,$otroapoyreq,$especifiqueapyreq);
				if ($estatus != false) {
					$ruta_archivos = "evidencias_rm/{$id_cct}/{$id_tprioritario}/";
					$ruta_archivos_save = "evidencias_rm/{$id_cct}/{$id_tprioritario}/$nombre_archivo";
					$estatusinst_urlarch = $this->Rutamejora_model->insert_evidencia($id_cct,$id_tprioritario,$ruta_archivos_save);
					if(!is_dir($ruta_archivos)){
						mkdir($ruta_archivos, 0777, true);}
						$_FILES['userFile']['name']     = $_FILES['archivo']['name'];
						$_FILES['userFile']['type']     = $_FILES['archivo']['type'];
						$_FILES['userFile']['tmp_name'] = $_FILES['archivo']['tmp_name'];
						$_FILES['userFile']['error']    = $_FILES['archivo']['error'];
						$_FILES['userFile']['size']     = $_FILES['archivo']['size'];

						$uploadPath              = $ruta_archivos;
						$config['upload_path']   = $uploadPath;
						$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|xlsx|xls|doc|docx|txt';

						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						if ($this->upload->do_upload('userFile')) {
							$fileData = $this->upload->data();
							$str_view = true;
						}
						$estatus = true;
					}
					else {
						$estatus = false;
					}
				}
				$response = array('estatus' => $estatus);
				Utilerias::enviaDataJson(200, $response, $this);
				exit;
			}

			public function eliminarTP(){
				if(Utilerias::haySesionAbiertacct($this)){
					$this->cct = Utilerias::get_cct_sesion($this);
					$id_cct = $this->cct[0]['id_cct'];
					$id_tprioritario = $this->input->post("id_tprioritario");
					$url = $this->Rutamejora_model->get_url_evidencia($id_cct,$id_tprioritario);
					$estatus = $this->Rutamejora_model->delete_tema_prioritario($id_cct,$id_tprioritario);

					if ($estatus) {
						$temasp = $this->Rutamejora_model->getTemasxcct($id_cct);
						$this->actualizaOrden($temasp);
						$temasp = $this->Rutamejora_model->getTemasxcct($id_cct);
						$this->actualizaOrden($temasp);
						if ($url!='') {
							unlink($url);
						}

					}
					$response = array('estatus' => $estatus);
					Utilerias::enviaDataJson(200, $response, $this);
					exit;
				}else{
					redirect('Rutademejora/index');
				}
			}

			public function actualizaOrden($temasp){
				$orden = 1;
				foreach ($temasp as $tema) {
					$actualiza = $this->Rutamejora_model->update_order((int)$orden, (int)$tema['id_tprioritario']);
					$orden = $orden +1;
				}
				$orden = 1;
			}

			public function get_view_acciones(){
				if(Utilerias::haySesionAbiertacct($this)){
					$id_tprioritario = $this->input->post('id_tprioritario');
					$data = array();
					$str_view = $this->load->view("ruta/acciones", $data, TRUE);
					$response = array('str_view' => $str_view);
					Utilerias::enviaDataJson(200, $response, $this);
					exit;
				}else{
					redirect('Rutademejora/index');
				}
			}

			public function save_accion(){
				if(Utilerias::haySesionAbiertacct($this)){
					$id_tprioritario = $this->input->post('id_tprioritario');
					$id_objetivo = $this->input->post('id_objetivo');
					$accion = $this->input->post('accion');
					$materiales = $this->input->post('materiales');
					$ids_responsables = $this->input->post('ids_responsables');
					$otroresponsable = $this->input->post('otroresp');
					$finicio = $this->input->post('finicio');
					$ffin = $this->input->post('ffin');
					$medicion = $this->input->post('medicion');
					$finicio = str_replace("/", "-", $finicio);
					$porciones = explode("-", $finicio);
					$finicio = $porciones[2]."-".$porciones[0]."-".$porciones[1];
					$ffin = str_replace("/", "-", $ffin);
					$porciones = explode("-", $ffin);
					$ffin = $porciones[2]."-".$porciones[0]."-".$porciones[1];
					$existotroresp = false;
					$strids_resp = "";

					$main_resp = $this->input->post('responsable');
					$otro_resp = $this->input->post('new_resp');

					foreach ($ids_responsables as $responsable) {
						if($responsable == 0){
							$existotroresp = true;
						}
						$strids_resp .= $responsable.",";
					}
					$strids_resp = substr($strids_resp, 0, -1);

					if(isset($_POST['id_accion'])){
						$update = $this->Rutamejora_model->update_accion($_POST['id_accion'], $id_tprioritario, $accion, $materiales, $strids_resp, $finicio, $ffin, $medicion, $otroresponsable, $existotroresp, $id_objetivo, $main_resp, $otro_resp);

						if($update){
							$acciones = $this->Rutamejora_model->getacciones($id_objetivo);

							$tabla = "<div class='table-responsive'>
							<table id='idtabla_accionestp' class='table table-condensed table-hover  table-bordered'>
							<thead>
							<tr class=info>
							<th id='orden' style='width:4%' hidden><center>Id accion</center></th>
							<th id='evidencias' style='width:25%; vertical-align: middle;' rowspan='2'><center>Acciones</center></th>
							<th id='evidencias' style='width:25%; vertical-align: middle;' rowspan='2'><center>Recursos</center></th>
							<th colspan='2' scope='col'><center>Fecha</center></th>
							</tr>
							<tr>
							<th id='tema' style='width:24%' scope='col'><center>Inicio</center></th>
							<th id='problemas' style='width:25%' scope='col'><center>Fin</center></th>
							</tr>
							</thead>
							<tbody>";
							if(count($acciones) > 0){
								foreach ($acciones as $accion) {
									$tabla .= "<tr>
									<td hidden>{$accion['id_accion']}</td>
									<td>{$accion['accion']}</td>
									<td>{$accion['mat_insumos']}</td>
									<td>{$accion['accion_f_inicio']}</td>
									<td>{$accion['accion_f_termino']}</td>
									<td hidden>{$accion['accion_f_termino']}</td>

									</tr>";
								}
							}else{
								$tabla .= "<tr>
								<td colspan='5'>No hay datos por mostrar</td>
								</tr>";
							}

							$tabla .= "</tbody>
							</table>
							</div>  ";
							$response = array('tabla' => $tabla);
						}else{
							$response = array('tabla' => '');
						}
					}else{
						$insert = $this->Rutamejora_model->insert_accion($id_tprioritario, $accion, $materiales, $strids_resp, $finicio, $ffin, $medicion, $otroresponsable, $existotroresp, $id_objetivo, $main_resp, $otro_resp);
						if($insert){
							$acciones = $this->Rutamejora_model->getacciones($id_tprioritario);

							$tabla = "<div class='table-responsive'>
							<table id='idtabla_accionestp' class='table table-condensed table-hover  table-bordered'>
							<thead>
							<tr class=info>
							<th id='orden' style='width:4%' hidden><center>Id accion</center></th>
							<th id='evidencias' style='width:25%; vertical-align: middle;' rowspan='2'><center>Acciones</center></th>
							<th id='evidencias' style='width:25%; vertical-align: middle;' rowspan='2'><center>Recursos</center></th>
							<th colspan='2' scope='col'><center>Fecha</center></th>
							</tr>
							<tr>
							<th id='tema' style='width:24%' scope='col'><center>Inicio</center></th>
							<th id='problemas' style='width:25%' scope='col'><center>Fin</center></th>
							</tr>
							</thead>
							<tbody>";
							if(count($acciones) > 0){
								foreach ($acciones as $accion) {
									$tabla .= "<tr>
									<td hidden>{$accion['id_accion']}</td>
									<td>{$accion['accion']}</td>
									<td>{$accion['mat_insumos']}</td>
									<td>{$accion['accion_f_inicio']}</td>
									<td>{$accion['accion_f_termino']}</td>

									</tr>";
								}
							}else{
								$tabla .= "<tr>
								<td colspan='5'>No hay datos por mostrar</td>
								</tr>";
							}

							$tabla .= "</tbody>
							</table>
							</div>  ";
							$response = array('tabla' => $tabla);
						}else{
							$response = array('tabla' => '');
						}
					}
					Utilerias::enviaDataJson(200, $response, $this);
					exit;
				}else{
					redirect('Rutademejora/index');
				}
			}

			public function get_table_acciones(){
				if(Utilerias::haySesionAbiertacct($this)){
					$this->cct = Utilerias::get_cct_sesion($this);
					$id_tprioritario = $this->input->post('id_tprioritario');
					$acciones = $this->Rutamejora_model->getacciones($id_tprioritario);

					$encabezado = $this->Rutamejora_model->get_problematica_ambito($id_tprioritario);

					$problematica = '';
					$ambito = '';
					foreach ($encabezado as $key => $value) {
						if ($value['tipo']  == 1) {
							$problematica .= $value['descripcion'];
						}else{
							$ambito .= $value['descripcion'];
						}

					}

					$tabla = "<div class='table-responsive'>
					<table id='idtabla_accionestp' class='table table-condensed table-hover  table-bordered'>
					<thead>
					<tr class=info>
					<th id='orden' style='width:4%' hidden><center>Id accion</center></th>
					<th id='evidencias' style='width:25%; vertical-align: middle;' rowspan='2'><center>Acciones</center></th>
					<th id='evidencias' style='width:25%; vertical-align: middle;' rowspan='2'><center>Recursos</center></th>
					<th colspan='2' scope='col'><center>Fecha</center></th>
					</tr>
					<tr>
					<th id='tema' style='width:24%' scope='col'><center>Inicio</center></th>
					<th id='problemas' style='width:25%' scope='col'><center>Fin</center></th>
					</tr>
					</thead>
					<tbody>";
					if(count($acciones) > 0){
						foreach ($acciones as $accion) {
							$tabla .= "<tr>
							<td hidden>{$accion['id_accion']}</td>
							<td>{$accion['accion']}</td>
							<td>{$accion['mat_insumos']}</td>
							<td>{$accion['accion_f_inicio']}</td>
							<td>{$accion['accion_f_termino']}</td>
							</tr>";
						}
					}else{
						$tabla .= "<tr>
						<td colspan='5'>No hay datos por mostrar</td>
						</tr>";
					}

					$tabla .= "</tbody>
					</table>
					</div>  ";

					$get_datos = $this->Rutamejora_model->get_datos_modal($id_tprioritario);
					$datos =array('escuela' => $this->cct[0]['nombre_centro'],'prioridad'=> $get_datos[0]['prioridad'],'problematicas'=> $problematica,'evidencias'=> $get_datos[0]['otro_evidencia'],'ambito'=> $ambito);
					$objetivos = $this->Rutamejora_model->getObjxTp($id_tprioritario);
			
					$option = "<option value='0'>SELECCIONE</option>";
					foreach ($objetivos as $objetivo) {
				
						$option .="<option value='{$objetivo['id_objetivo']}'>{$objetivo['objetivo']}</option>";
					}

					$response = array('tabla' => $tabla, 'datos' => $datos, 'stroption' => $option, 'titulo' => '<i class="far fa-lightbulb"></i> NADA');
			
					Utilerias::enviaDataJson(200, $response, $this);
					exit;
				}else{
					redirect('Rutademejora/index');
				}
			}

			public function delete_accion(){
				if(Utilerias::haySesionAbiertacct($this)){
					$id_tprioritario = $this->input->post('id_tprioritario');
					$idaccion = $this->input->post('idaccion');
			
					$delete = $this->Rutamejora_model->deleteaccion($idaccion, $id_tprioritario);
			
					if($delete){
						$tabla = $this->arma_tabla_acciones($id_tprioritario);
						$response = array("mensaje" => "ok", "tabla" => $tabla);
					}else{
						$response = array("mensaje" => "error", "tabla" => '');
					}
					Utilerias::enviaDataJson(200, $response, $this);
					exit;
				}else{
					redirect('Rutademejora/index');
				}
			}

			private function arma_tabla_acciones($id_tprioritario){
				if(Utilerias::haySesionAbiertacct($this)){
					$acciones = $this->Rutamejora_model->getacciones($id_tprioritario);
					$tabla = "<div class='table-responsive'>
					<table id='idtabla_accionestp' class='table table-condensed table-hover  table-bordered'>
					<thead>
					<tr class=info>
					<th id='orden' style='width:4%' hidden><center>Id accion</center></th>
					<th id='evidencias' style='width:25%; vertical-align: middle;' rowspan='2'><center>Acciones</center></th>
					<th id='evidencias' style='width:25%; vertical-align: middle;' rowspan='2'><center>Recursos</center></th>
					<th colspan='2' scope='col'><center>Fecha</center></th>
					</tr>
					<tr>
					<th id='tema' style='width:24%' scope='col'><center>Inicio</center></th>
					<th id='problemas' style='width:25%' scope='col'><center>Fin</center></th>
					</tr>
					</thead>
					<tbody>";
					if(count($acciones) > 0){
						foreach ($acciones as $accion) {
							$tabla .= "<tr>
							<td hidden>{$accion['id_accion']}</td>
							<td>{$accion['accion']}</td>
							<td>{$accion['accion_f_inicio']}</td>
							<td>{$accion['accion_f_termino']}</td>

							</tr>";
						}
					}else{
						$tabla .= "<tr>
						<td colspan='5'>No hay datos por mostrar</td>
						</tr>";
					}

					$tabla .= "</tbody>
					</table>
					</div>  ";
					return $tabla;
				}else{
					redirect('Rutademejora/index');
				}
			}

			public function set_avance(){
				if(Utilerias::haySesionAbiertacct($this)){
					$this->cct = Utilerias::get_cct_sesion($this);
					
					$val_slc = $this->input->post('val_slc');
					$var_id_cte = $this->input->post('var_id_cte');
					$var_id_cct = $this->input->post('var_id_cct');
					$var_id_idtp = $this->input->post('var_id_idtp');
					$var_id_idacc = $this->input->post('var_id_idacc');

					$exite_enavance = $this->Rutamejora_model->existe_avance($this->cct[0]['cve_centro'], $this->cct[0]['id_turno_single'],$var_id_idtp,$var_id_idacc);
					if (!$exite_enavance) {
						$estatusinsert = $this->Rutamejora_model->insert_avance($this->cct[0]['cve_centro'], $this->cct[0]['id_turno_single'],$var_id_idtp,$var_id_idacc);
					}
					$estatus = $this->Rutamejora_model->update_avance_xcte($val_slc,$var_id_cte,$this->cct[0]['cve_centro'], $this->cct[0]['id_turno_single'],$var_id_idtp,$var_id_idacc);

					$response = array('estatus' => $estatus);
					Utilerias::enviaDataJson(200, $response, $this);
					exit;
				}else{
					redirect('Rutademejora/index');
				}
			}

			public function edit_accion(){
				if(Utilerias::haySesionAbiertacct($this)){
					$id_tprioritario = $this->input->post('id_tprioritario');
					$idaccion = $this->input->post('idaccion');
					$editada = $this->Rutamejora_model->edit_accion($idaccion, $id_tprioritario);
			
					$response = array("editado" => $editada[0]);
					Utilerias::enviaDataJson(200, $response, $this);
					exit;
				}else{
					redirect('Rutademejora/index');
				}
			}
			public function get_avance(){
				if(Utilerias::haySesionAbiertacct($this)){
					$tipou_pemc_avances = $this->input->post('tipou_pemc_avances');
					$this->cct = Utilerias::get_cct_sesion($this);
					$id_cct_sup = $this->input->post('x');
					$cve_centro = $this->input->post('cve_centro');
					$turno = $this->input->post('turno');
					
					$data2 = array();
					if (isset($_POST['cve_centro'])) {	
					
					$arr_avances = $this->Rutamejora_model->get_avances_tp_accionxcct_super($cve_centro,$turno);
					}else{
						
					$arr_avances = $this->Rutamejora_model->get_avances_tp_accionxcct($this->cct[0]['cve_centro'], $this->cct[0]['id_turno_single']);
					}
					$data2['arr_avances'] = $arr_avances;
					$arr_avances_fechas = $this->Rutamejora_model->get_avances_tp_accionxcct_fechas(5);
					$data2['arr_avances_fechas'] = $arr_avances_fechas;
					$varaux_temp = explode("_", array_search('TRUE', $arr_avances_fechas[0]));
					$clave = $varaux_temp[0];
					$arr_avances_n = $this->asigna_icono($arr_avances, $clave);
					if($tipou_pemc_avances==1 || $tipou_pemc_avances=='1'){
						$data2['tipou_pemc_avances'] = $tipou_pemc_avances;
					}
					$data2['arr_avances'] = $arr_avances_n;
					$string_view_avance = $this->load->view('ruta/avances', $data2, TRUE);
					$response = array('srt_html' => $string_view_avance);
					Utilerias::enviaDataJson(200, $response, $this);
					exit;
				}else{
					redirect('Rutademejora/index');
				}
			}

			public function asigna_icono($arr_avances, $habilitado){
				$anterioraux = explode("cte", $habilitado);
				$anterior = $anterioraux[1];
				if ($anterior == 1) {
					$anterior = ((int)$anterior);
				}
				else{
					$anterior = ((int)$anterior-1);
				}
				
				$cadAnterior = "cte".$anterior;
				$arr_avancesCompleto = array();
				foreach ($arr_avances as $avance) {
					if($avance[$habilitado] != 0){
						$icono = $this->retorna_icono($avance[$habilitado]);
					}else{
						$icono = $this->retorna_icono($avance[$cadAnterior]);
					}
					$avance['icono'] = $icono;
					array_push($arr_avancesCompleto, $avance);
				}
				return $arr_avancesCompleto;
			}

			public function retorna_icono($porcentaje){
				if($porcentaje == 0){
					return "R0.png";
				}else if($porcentaje == 10 || $porcentaje == 20 || $porcentaje == 30){
					return "R1.png";
				}else if($porcentaje == 40 || $porcentaje == 50 || $porcentaje == 60 || $porcentaje == 70){
					return "Y2.png";
				}else if($porcentaje == 80 || $porcentaje == 90){
					return "G3.png";
				}else if($porcentaje == 100){
					return "G4.png";
				}
			}

			public function set_file(){
				if(Utilerias::haySesionAbiertacct($this)){
					$ruta_archivos = "prueba/id_cct/12/";
					$nombre_archivo = str_replace(" ", "_", $_FILES['archivo']['name']);
					$ruta_archivos_save = "prueba/id_cct/12/$nombre_archivo";

					if(!is_dir($ruta_archivos)){
						mkdir($ruta_archivos, 0777, true);}
						$_FILES['userFile']['name']     = $_FILES['archivo']['name'];
						$_FILES['userFile']['type']     = $_FILES['archivo']['type'];
						$_FILES['userFile']['tmp_name'] = $_FILES['archivo']['tmp_name'];
						$_FILES['userFile']['error']    = $_FILES['archivo']['error'];
						$_FILES['userFile']['size']     = $_FILES['archivo']['size'];

						$uploadPath              = $ruta_archivos;
						$config['upload_path']   = $uploadPath;
						$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|xlsx|xls|doc|docx|txt';

						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						if ($this->upload->do_upload('userFile')) {
							$fileData = $this->upload->data();
							$str_view = true;
						}

						$response = array('str_view' => $str_view);
						Utilerias::enviaDataJson(200, $response, $this);
						exit;
					}else{
						redirect('Rutademejora/index');
					}
				}

//FUNCIONAMIENTO Y VALIDACION PARA SUPERVISOR BY LUIS SANCHEZ... all reserved rights
//
				public function verifica_supervisor($cct){
					$issuper = $this->Rutamejora_model->valida_supervisor($cct);
					if(count($issuper) > 0){
						return TRUE;
					}else{
						return FALSE;
					}
				}

				public function generavistaSupervisor(){
					$this->cct = Utilerias::get_cct_sesion($this);
					$curl = curl_init();
					$method = "POST";
					$url = "http://servicios.seducoahuila.gob.mx/wservice/w_service_escuelas_por_supervision.php";
					$data = array("cct" => $this->cct[0]['cve_centro']);

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
					$escuelas = json_decode($result);

					$data = array();
					$data['nombreuser'] = $this->cct[0]['nombre_supervision'];
					$data['nivel'] = $this->cct[0]['zona_escolar'];
					$data['turno'] = "";
					$data['cct'] = $this->cct[0]['cve_centro'];
					$data['escuelas'] = $escuelas->Escuelas;

					$this->session->set_userdata('escuela_supervisor', $escuelas->Escuelas);
					Utilerias::pagina_basica_rm($this, "ruta/supervisor/index", $data);
				}

				public function graficas_supervisor()
				{
					$escuelas = $this->session->userdata('escuela_supervisor');
					$ccts = array();
					for ($i=0; $i < sizeof($escuelas) ; $i++) { 
						array_push($ccts, $escuelas[$i]->b_cct);
					}
					
					$ccts_sup = implode( "', '", $ccts ); 

					$graficas = $this->Rutamejora_model->getGraficas($ccts_sup);
					$tabla = $this->Rutamejora_model->getTablasGraficas($ccts_sup);
					$data['tabla'] = $tabla;
				
					$str_view = $this->load->view("ruta/supervisor/grafica_modal", $data, TRUE);
					$response = array('str_view' => $str_view, 'grafica'=>$graficas);
					Utilerias::enviaDataJson(200, $response, $this);
					exit;
				}

				public function get_rutas_xcctsuper(){
					$cct = $this->input->post("cct");
					$turno = $this->input->post("turno");
					$idturno = 0;
					if($turno == "MATUTINO"){
						$idturno = 1;
					}else if($turno == "VESPERTINO"){
						$idturno = 2;
					}else if($turno == "NOCTURNO"){
						$idturno = 3;
					}else if($turno == "DISCONTINUO"){
						$idturno = 4;
					}else if($turno == "CONTINUO"){
						$idturno = 5;
					}else if($turno == "COMPLEMENTARIO"){
						$idturno = 6;
					}else if($turno == "CONTINUO (JORNADA AMPLIA)"){
						$idturno = 7;
					}else if($turno == "CONTINUO (DE 7:00 A 22:00 HRS)"){
						$idturno = 8;
					}
					$datos_cct = $this->Rutamejora_model->getdatoscct($cct, $idturno);
					$tabla_rutas = $this->get_table_rutas($datos_cct[0]['cve_centro'],$idturno);

					$response = array('tabla' => $tabla_rutas, 'cct_escuela' => $cct);
					Utilerias::enviaDataJson(200, $response, $this);
					exit;
				}

				public function get_table_rutas($idcct, $turno){
					$rutas = $this->Rutamejora_model->getrutasxcct($idcct, $turno);

					$tabla = "<div class='table-responsive'>
					<table id='id_tabla_rutas_super' class='table table-condensed table-hover  table-bordered'>
					<thead>
					<tr class=info>
					<th id='idrutamtema' hidden><center>id</center></th>
					<th id='orden' style='width:4%'><center>Orden</center></th>
					<th id='tema' style='width:20%'><center>Líneas de Acción Estratégica</center></th>
					<th id='ambito' style='width:20%'><center>Ámbitos</center></th>
					<th id='problemas' style='width:31%'><center>Problemáticas</center></th>
					<th id='evidencias' style='width:31%'><center>Evidencias</center></th>
					<th id='n_actividades' style='width:8%'><center>Acciones</center></th>
					<th id='objetivo' style='width:6%'><center>Objetivo</center></th>
					<th id='objetivo' style='width:6%'><center>Observación</center></th>
					
					</tr>
					</thead>
					<tbody id='id_tbody_demo'>";


					foreach ($rutas as $ruta) {
						$tabla .= "<tr>
						<td id='id_tprioritario' hidden><center>{$ruta['id_tprioritario']}</center></td>
						<td id='orden' data='1'>LAE-{$ruta['orden']}</td>
						<td id='tema' data='Normalidad mínima'>{$ruta['prioridad']}</td>
						<td id='ambito' data=''>{$ruta['ambito']}</td>
						<td id='problemas' data='Asistencia de profesores' >{$ruta['otro_problematica']}</td>
						<td id='evidencias' data='SISAT'>{$ruta['otro_evidencia']}</td>
						<td id='n_actividades' data='0'>{$ruta['n_acciones']}</td>
						<td id=''><center><i class='{$ruta['objetivos']}'></i></center></td>
						<td id=''><center><i class='{$ruta['obs_supervisor']}'></i></center></td>
						
						</tr>";
					}

					$tabla .= "</tbody>
					</table>
					</div>  ";
					return $tabla;
				}

				public function get_mensaje_super(){
					$idtema = $this->input->post("idruta");
					$mensajesuper = $this->input->post("mensaje");
					$mensajeguardado = $this->Rutamejora_model->inserta_mensaje_super($idtema, $mensajesuper);
					if($mensajeguardado){
						$estatus = "El mensaje se guardo correctamente";
					}else{
						$estatus = "El mensaje no pudo guardarse, intente nuevamente";
					}
					$response = array('mensaje' => $estatus);
					Utilerias::enviaDataJson(200, $response, $this);
					exit;
				}

				public function get_vista_acciones(){
					if(Utilerias::haySesionAbiertacct($this)){
						$id_tprioritario = $this->input->post('idruta');
						$nombreescuela = $this->input->post('nombreescuela');
						$acciones = $this->Rutamejora_model->getacciones_supervisor($id_tprioritario);
						$encabezado = $this->Rutamejora_model->get_problematica_ambito($id_tprioritario);

					$problematica = '';
					$ambito = '';
					foreach ($encabezado as $key => $value) {
						if ($value['tipo']  == 1) {
							$problematica .= $value['descripcion'];
						}else{
							$ambito .= $value['descripcion'];
						}

					}
						$tabla = "<div class='table-responsive'>
						<table id='idtabla_accionestp_super' class='table table-condensed table-hover  table-bordered'>
						<thead>
						<tr class=info>
						<th id='orden' style='width:4%' hidden><center>Id accion</center></th>
						
						<th id='tema' style='width:20%'><center>Fecha de inicio</center></th>
						<th id='problemas' style='width:31%'><center>Fecha de término</center></th>
						<th id='evidencias' style='width:39%'><center>Acción</center></th>
						</tr>
						</thead>
						<tbody>";
						if(count($acciones) > 0){
							foreach ($acciones as $accion) {
								$tabla .= "<tr>
								<td hidden>{$accion['id_accion']}</td>
								
								<td>{$accion['accion_f_inicio']}</td>
								<td>{$accion['accion_f_termino']}</td>
								<td>{$accion['accion']}</td>
								</tr>";
							}
						}else{
							$tabla .= "<tr>
							<td colspan='5'>No hay datos por mostrar</td>
							</tr>";
						}

						$tabla .= "</tbody>
						</table>
						</div>  ";
						$get_datos = $this->Rutamejora_model->get_datos_modal($id_tprioritario);

						$data['escuela'] = $nombreescuela;
						$data['prioridad'] = $get_datos[0]['prioridad'];
						$data['problematicas'] = $problematica;
						$data['ambito'] = $ambito;
						$data['evidencias'] = $get_datos[0]['otro_evidencia'];
						$data['tacciones'] = $tabla;
						$data['arr_ambitos'] = $this->Ambito_model->get_ambitos();

						$dom = $this->load->view("ruta/supervisor/visor_actividades",$data,TRUE);
						$response = array('vista' => $dom);
						Utilerias::enviaDataJson(200, $response, $this);
						exit;
					}else{
						redirect('Rutademejora/index');
					}
				}

				public function edit_accion_super(){
					if(Utilerias::haySesionAbiertacct($this)){
						$id_tprioritario = $this->input->post('id_tprioritario');
						$idaccion = $this->input->post('idaccion');
						$cct_log = $this->input->post('cct');
						$editada = $this->Rutamejora_model->edit_accion($idaccion, $id_tprioritario);
						$ids_responsables = $editada[0]['ids_responsables'];
						$ids_responsables = explode(",", $ids_responsables);
						$responsables = $this->getPersonal($cct_log);
						if (count($responsables)==0) {
							$responsables = array();
						}
						$listap = "";
						foreach ($responsables->Personal as $persona) {

							for($i = 0; $i < count($ids_responsables); $i++){
								if($persona->rfc == $ids_responsables[$i]){
									$listap .= trim($persona->nombre_completo).", ";
								}
							}
						}
						$response = array("editado" => $editada[0], "personal" => $listap);
						Utilerias::enviaDataJson(200, $response, $this);
						exit;
					}else{
						redirect('Rutademejora/index');
					}
				}

				function iniciamos_sesion_supervisor($usuario, $pass, $turno){
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
					return $response = json_decode($result);
				}

				public function get_comentario_super(){

					$idtemap = $this->input->post("idtemarp");
					$mensaje = $this->Rutamejora_model->get_coment_super($idtemap);
					$response = array('mensaje' => $mensaje[0]['obs_supervisor']);
					Utilerias::enviaDataJson(200, $response, $this);
					exit;
				}

	// Nuevo codigo ruta mejora Ismael

				public function index_new(){
					$this->cct = Utilerias::get_cct_sesion($this);
					$usuario = $this->cct[0]['cve_centro'];
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


					$mision = $this->Rutamejora_model->get_misionxcct($this->cct[0]['cve_centro'],$this->cct[0]['id_turno_single'],'4');
					$data['mision'] = $mision;
					$result_prioridades = $this->Prioridad_model->get_prioridadesxnivel($this->cct[0]['nivel']);
					if(count($result_prioridades)==0){
						$data['arr_prioridades'] = array(	'-1' => 'Error recuperando los prioridades' );
					}else{
						$data['arr_prioridades'] = $result_prioridades;
					}
					$result_problematicas = $this->Problematica_model->get_problematicas();
					if(count($result_problematicas)==0){
						$data['arr_problematicas'] = array(	'-1' => 'Error recuperando los problematicas' );
					}else{
						$data['arr_problematicas'] = $result_problematicas;
					}
					$result_evidencias = $this->Evidencia_model->get_evidencias();
					if(count($result_evidencias)==0){
						$data['arr_evidencias'] = array(	'-1' => 'Error recuperando los evidencias' );
					}else{
						$data['arr_evidencias'] = $result_evidencias;
					}
		$data['nivel'] = $this->cct[0]['nivel'];//$nivel;
		$data['nombreuser'] = $this->cct[0]['nombre_centro'];
		$data['turno'] = $this->cct[0]['turno_single'];
		$data['cct'] = $this->cct[0]['cve_centro'];
		$data['director'] = $this->cct[0]['nombre_director'];
		$data['vista_avance'] = $this->load->view("ruta/rutademejora/avances", $data, TRUE);
		$data['vista_indicadores'] = $this->load->view("ruta/rutademejora/indicadores", $data, TRUE);
		$data['vista_ayuda'] = $this->load->view("ruta/rutademejora/ayuda", $data, TRUE);

		Utilerias::pagina_basica_rm($this, "ruta/rutademejora/index", $data);
	}

	public function modal_recomendacion(){
		$data = array();
		$this->cct = Utilerias::get_cct_sesion($this);
		$mision = $this->Rutamejora_model->get_misionxcct($this->cct[0]['cve_centro'], $this->cct[0]['id_turno_single'],'4');
		$data['mision'] = $mision;

		$strView = $this->load->view("ruta/modals_new/modal_ruta", $data, TRUE);

		$response = array('strView' => $strView, 'titulo' => '<i class="far fa-lightbulb"></i> Recomendación');

		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function modal_mision(){
		$data = array();
		$this->cct = Utilerias::get_cct_sesion($this);

		$mision = $this->Rutamejora_model->get_misionxcct($this->cct[0]['cve_centro'],$this->cct[0]['id_turno_single'],'4');
		$data['mision'] = $mision;

		$strView = $this->load->view("ruta/modals_new/modal_mision", $data, TRUE);

		$response = array('strView' => $strView, 'titulo' => '<i class="fas fa-flag"></i> Misión');

		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function tabla_rm(){
		if(Utilerias::haySesionAbiertacct($this)){
			$data = array();
			$this->cct = Utilerias::get_cct_sesion($this);
			$tam = 0;
			$rutas = $this->Rutamejora_model->getrutasxcct($id_cct);

			$data['rutas'] = $rutas;
			$data['tam'] = $tam;


			$strView = $this->load->view("ruta/rutademejora/tabla_rm", $data, TRUE);

			$response = array('strView' => $strView);
			Utilerias::enviaDataJson(200, $response, $this);
			exit;
		}else{
			redirect('Rutademejora/index');
		}
	}

	public function eliminaEvidencia(){
		$id_tprioritario = $this->input->post('id_tprioritario');
		$path_archivo_aux = $this->Rutamejora_model->getEvidencia($id_tprioritario);
		$path_archivo = $path_archivo_aux[0]['path_evidencia'];

		$status = $this->Rutamejora_model->deleteEvidencia($id_tprioritario);
		unlink($path_archivo);
		$response = array('status' => $status);
		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function tabla_up(){
		if(Utilerias::haySesionAbiertacct($this)){
			$this->cct = Utilerias::get_cct_sesion($this);
			$datos = $this->input->post('orden');
			for($i = 0; $i < count($datos); $i++){
				$arr_datos = $this->Rutamejora_model->update_order($datos[$i][1], $datos[$i][0]);
			}
			$rutas = $this->Rutamejora_model->getrutasxcct($id_cct);
		}else{
			redirect('Rutademejora/index');
		}
	}

	public function modal_prioridad(){
		$data = array();
		$this->cct = Utilerias::get_cct_sesion($this);
		$id_nivel = $this->cct[0]['nivel'];
		$result_prioridades = $this->Prioridad_model->get_prioridadesxnivel($this->cct[0]['nivel']);
		$data['prioridades'] = $result_prioridades;

		$strView = $this->load->view("ruta/modals_new/modal_prioridad", $data, TRUE);

		$response = array('strView' => $strView, 'titulo' => 'Agrega prioridad');

		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function agregarObjetivo(){
		$this->cct = Utilerias::get_cct_sesion($this);
		$id_tprioritario = $this->input->post("id_tprioritario");
		
		$id_prioridad = $this->input->post('id_prioridad');
		$objetivo = $this->input->post('objetivo');
		$otra_fecha = $this->input->post('otra_fecha');
		$estatus = $this->Rutamejora_model->insertaObjetivo($this->cct[0]['cve_centro'],$this->cct[0]['id_turno_single'], $id_prioridad, strtoupper($objetivo), $id_tprioritario);
		$response = array('estatus' => $estatus['status'], 'idtemaprioritario' =>$estatus['idtemaprioritario']);
		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function actualizarObjetivo(){

		$id_objetivo = $this->input->post('id_objetivo');
		$objetivo = $this->input->post('objetivo');
		
		$estatus = $this->Rutamejora_model->actualizaObjetivo($id_objetivo, strtoupper($objetivo));

		$response = array('estatus' => $estatus);
		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

// get
	public function getObjetivos(){
		$this->cct = Utilerias::get_cct_sesion($this);

		$id_tprioritario = $this->input->post('id_tpriotario');
		$idprioridad = $this->input->post('id_prioridad');
		$tipou_pemc = $this->input->post('tipou_pemc');
		$cve_centro = $this->input->post('cve');
		$turno_sup = $this->input->post('turno');
		$encabezado = $this->Rutamejora_model->get_problematica_ambito_ids($id_tprioritario);

		$orden = 0;
		if (isset($_POST['cve'])) {
			$datos = $this->Rutamejora_model->getObjetivosSuper($cve_centro,$turno_sup, $id_tprioritario);
		}else{
			$cct = $this->cct[0]['cve_centro'];
			$turno = $this->cct[0]['id_turno_single'];
		$datos = $this->Rutamejora_model->getObjetivos($cct, $turno, $id_tprioritario, $idprioridad);
		}
		
		$idobjetivo = 0;
		if(!isset($datos[0]) || $datos[0]['id_objetivo'] == NULL){
			$tabla = "<table id='metas_objetivos' class='table table-condensed table-hover table-light table-bordered'>
			<thead>
			<tr class='info'>
			<th id='idrutamtema' hidden>
			<center>id</center>
			</th>
			<th id='num_rutamtema' style='width:5%; vertical-align:middle;'>
			<center>#</center>
			</th>
			<th id='des_rutamtema' style='width:75%; vertical-align:middle;' >
			<center>Objetivos y metas</center>
			</th>
			<th id='op_rutamtema' style='width:20%'>
			<center>Opciones</center>
			</th>
			</tr>
			</thead>
			<tbody>";

			$tabla .= "<tr>
			<td colspan='4'>Sin datos que mostrar</td>
			</tr>";

			$tabla .= "</tbody></table>";

		}else{
			$tabla = "<table id='id_tabla_objetivos' class='table table-condensed table-hover table-light table-bordered'>
			<thead>
			<tr class='info'>
			<th id='idrutamtema' hidden>
			<center>id</center>
			</th>
			<th id='num_rutamtema' style='width:5%; vertical-align:middle;%' rowspan='2'>
			<center>#</center>
			</th>
			<th id='des_rutamtema' style='width:65%; vertical-align:middle;' rowspan='2'>
			<center>Objetivos y metas</center>
			</th>
			<th colspan='2'>
			<center>Evidencias</center>
			</th>
			</tr>
			<tr>
			<th id='evidencia_inico' style='width:15%'>
			<center>Antes</center>
			</th>
			<th id='evidencia_fin' style='width:15%'>
			<center>Después</center>
			</th>
			</tr>
			</thead>
			<tbody>";

			foreach ($datos as $dato) {
				$orden = $orden +1;
				$idobjetivo = $dato['id_objetivo'];
				$idprioridad = $dato['id_tprioritario'];

				$tabla .= "<tr>
				<td id='id_objetivo' hidden><center>{$dato['id_objetivo']}</center></td>
				<td id='id_tprioritario' hidden><center>{$dato['id_tprioritario']}</center></td>
				<td id='num_rutamtema' data='1' class='text-center'>{$orden}

				<a hidden onclick='publicar({$dato['id_objetivo']})' data-estado='{$dato['estado_publicacion']}' id='aPublicar_{$dato['id_objetivo']}'><i id='publicar_{$dato['id_objetivo']}'";
				if ($dato['estado_publicacion'] == 0) {
					$tabla.="class='fas fa-user-secret'></i></a>";
				}else{
					$tabla.="class='fas fa-globe-americas'></i></a>";
				}

				$tabla.= "</td>
				<td id='objetivo' data='Normalidad mínima'>{$dato['objetivo']}</td>
				<td>
				<div class='text-center'>

				<div style='margin-bottom: 10px;'>";
				
				if($tipou_pemc=="" && $dato['path_ev_inicio'] != "" && $dato['path_ev_inicio'] != null){
					$tabla.= "<button type='button' id='elimina_ini' class='float-right btn btn-sm '
					onclick='eliminaEvidencia({$dato['id_objetivo']}, this)'>
					<i class='far fa-trash-alt'></i>
					</button>";
				}
				
				$extension = substr($dato['path_ev_inicio'],-3);

				if ( $extension == 'pdf' || $extension == 'xsl'  || $extension == 'doc'  || $extension == 'ppt'  || $extension == 'slx'  || $extension == 'ocx'  || $extension == 'ptx'  ) {
					$tabla.="<a id='preview{$dato['id_objetivo']}'
					href='../../{$dato['path_ev_inicio']}' target='_blank' alt='Archivo' width='' height='50px'
					class='img img-thumbnail'> Archivo de Texto </a>
					</div>";
				} else{
					$tabla.="<img id='preview{$dato['id_objetivo']}'
					src='../../{$dato['path_ev_inicio']}' alt='Archivo' width='' height='50px'
					class='img img-thumbnail' onclick='imgPreview({$dato['id_objetivo']})' />
					</div>";
				}
				if($tipou_pemc==""){
					$tabla.="<span class='btn btn-primary btn-file'>
					<i class='fas fa-paperclip'></i>

					<form enctype='multipart/form-data' id='form_evidencia_{$dato['id_objetivo']}' >
					<input type='file' id='imgIni' name='arch1'
					onchange='cargarEvidencia({$dato['id_objetivo']}, {$dato['id_tprioritario']}, this)' accept='application/pdf, image/*' multiple data-toggle='tooltip' data-placement='top' title='Guarda la evidencia al inicio de su objetivo'>
					</form>
					</span>";
				}
				$tabla.="</div>
				</td>
				<td>
				<div class='text-center'>

				<div style='margin-bottom: 10px;'>";
				if($tipou_pemc=="" && $dato['path_ev_fin'] != "" && $dato['path_ev_fin'] != null){
					$tabla.="<button type='button' value='Quack_2' class='float-right btn btn-sm '
					onclick='eliminaEvidenciaFin({$dato['id_objetivo']}, this)'>
					<i class='far fa-trash-alt'></i>
					</button>";
				}
				$extension = substr($dato['path_ev_fin'],-3);
				if ($extension == 'pdf' || $extension == 'xsl'  || $extension == 'doc'  || $extension == 'ppt'  || $extension == 'slx'  || $extension == 'ocx'  || $extension == 'ptx') {
					$tabla.="<a id='preview{$dato['id_objetivo']}'
					href='../../{$dato['path_ev_fin']}' target='_blank' alt='Archivo' width='' height='50px'
					class='img img-thumbnail'> Archivo de Texto </a>
					</div>";
				} else{
					$tabla.="<img id='preview_fin{$dato['id_objetivo']}' src='../../{$dato['path_ev_fin']}' alt='Archivo' width='' height='50px' class='img img-thumbnail'
					onclick='imgPreviewFin({$dato['id_objetivo']})' />
					</div>";
				}
				if($tipou_pemc==""){
					$tabla .= "<span class='btn btn-primary btn-file'>
					<i class='fas fa-paperclip'></i>
					<form enctype='multipart/form-data' id='form_evidencia_fin_{$dato['id_objetivo']}'>
					<input type='file' id='imgFin' name='arch2' onchange='cargarEvidenciaFin({$dato['id_objetivo']}, {$dato['id_tprioritario']}, this)'  accept='application/pdf, image/*' multiple data-toggle='tooltip' data-placement='top' title='Guarda la evidencial al final de su objetivo'>
					</form>
					</span>";
				}
				$tabla.="</div>
				</td>
				</tr>";


			}

			$tabla .= "</tbody></table>";
		}

		$response = array('table' => $tabla, 'id_objetivo' => $idobjetivo, 'encabezado' => $encabezado);

		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function modal_actividades(){
		$strView = $this->load->view("ruta/modals_new/modal_actividades", array(), TRUE);

		$response = array('strView' => $strView, 'titulo' => 'Edición de prioridad del Sistema Básico de Mejora');

		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function getsubEspecial(){
		$id_prioridad = $this->input->post('idprioridad');
		$datos = $this->Rutamejora_model->getSubprioridad($id_prioridad);
		$option = "<option value='0'>SELECCIONE</option>";
		foreach ($datos as $dato) {
			$option .="<option value='{$dato['id_subprioridad']}'>{$dato['subprioridad']}</option>";
		}

		$response = array('stroption' => $option);

		Utilerias::enviaDataJson(200, $response, $this);
		exit;

	}

	public function llenaIndicador(){
		$this->cct = Utilerias::get_cct_sesion($this);
		$id_nivel = $this->cct[0]['nivel'];
		$id_prioridad = $this->input->post('id_prioridad');
		$id_subprioridad = $this->input->post('id_subprioridad');

		switch ($id_nivel) {
			case 'ESPECIAL':
			$id_nivel = 1;
			break;
			case 'INICIAL':
			$id_nivel = 2;
			break;
			case 'PREESCOLAR' :
			$id_nivel = 3;
			break;
			case 'PRIMARIA' :
			$id_nivel = 4;
			break;
			case 'SECUNDARIA' :
			$id_nivel = 5;
			break;
			case 'MEDIA SUPERIOR' :
			$id_nivel = 6;
			break;
			case 'SUPERIOR' :
			$id_nivel = 7;
			break;
			case 'FORMACION PARA EL TRABAJO' :
			$id_nivel = 8;
			break;
			case 'OTRO NIVEL EDUCATIVO' :
			$id_nivel = 9;
			break;
			case 'NO APLICA' :
			$id_nivel = 10;
			break;
		}

		if ( isset( $_POST['id_subprioridad'] ) ) {
			$datos = $this->Rutamejora_model->getIndicadorEspecial($id_prioridad, $id_nivel, $id_subprioridad);
		}else {
			$datos = $this->Rutamejora_model->getIndicadorEspecial($id_prioridad, $id_nivel, 0);
		}

		$option = "<option selected='selected' value='0'>SELECCIONAR</option>";
		foreach ($datos as $dato) {
			$option .="<option value='{$dato['id_indicador']}'>{$dato['indicador']}</option>";
		}

		$response = array('stroption' => $option);

		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function getMetrica(){
		$id_indicador = $this->input->post('id_indicador');

		$datos = $this->Rutamejora_model->getMetricas($id_indicador);
		$option = "<option value='0'>SELECCIONE</option>";
		$option .="<option value=''>% Porcentaje</option>";
		$option .="<option value=''># Cantidad</option>";

		$response = array('stroption' => $option);

		Utilerias::enviaDataJson(200, $response, $this);
		exit;

	}

	public function grabarTema(){
		$this->cct = Utilerias::get_cct_sesion($this);
		
		$cct = $this->cct[0]['cve_centro'];
		$turno = $this->cct[0]['id_turno_single'];

		$id_tprioritario = $this->input->post('id_tprioritario');
		$problematica = $this->input->post('problematica');
		$evidencia = $this->input->post('evidencias');
		$comentario_dir = $this->input->post('txt_rm_obs_direc');
		$ambito = $this->input->post('ambito');
		$limpiar_ambito = $this->Rutamejora_model->limpiar_ambito($id_tprioritario);
		for ($i=0; $i < sizeof($ambito) ; $i++) { 
			if (!empty($ambito[$i]) && $ambito[$i] != null && $ambito[$i] != '') {
			
				$guarda_ambito = $this->Rutamejora_model->grabar_ambito($id_tprioritario, $ambito[$i]);
			}
		}
		
		$encabezado = $this->Rutamejora_model->get_problematica_ambito_ids($id_tprioritario);

		$estatus = $this->Rutamejora_model->grabarTema($cct, $turno, $id_tprioritario, $problematica, $evidencia, $comentario_dir);


		$estatus = true;

		$response = array('estatus' => $estatus, 'encabezado'=>$encabezado);

		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function btnEditar(){
		$id_objetivo = $this->input->post('id_objetivo');
		$id_tprioritario = $this->input->post('id_tprioritario'); // este dato no viene

		$datos_aux = $this->Rutamejora_model->getObjetivo($id_objetivo);
		$datos = $datos_aux[0];
		$idobj = $id_objetivo;

		$response = array('datos' => $datos, 'idobj' => $idobj);

		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function btnEliminar(){
		$id_objetivo = $this->input->post('id_objetivo');

		$datos = $this->Rutamejora_model->borrarObjetivo($id_objetivo);

		$response = array('datos' => $datos);

		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	//Edicion/incerción de datos
	public function get_datos_edith_tp(){
		if(Utilerias::haySesionAbiertacct($this)){
			$this->cct = Utilerias::get_cct_sesion($this);
			$id_tprioritario = $this->input->post('id_tprioritario');
			$titulo = $this->input->post('txttp');
			$id_prioritario = $this->input->post('id_prioritario');
			$id_prioridad = $this->input->post('id_prioridad');
			$id_nivel = $this->cct[0]['nivel'];

			switch ($id_nivel) {
				case 'ESPECIAL':
				$id_nivel = 1;
				break;
				case 'INICIAL':
				$id_nivel = 2;
				break;
				case 'PREESCOLAR' :
				$id_nivel = 3;
				break;
				case 'PRIMARIA' :
				$id_nivel = 4;
				break;
				case 'SECUNDARIA' :
				$id_nivel = 5;
				break;
				case 'MEDIA SUPERIOR' :
				$id_nivel = 6;
				break;
				case 'SUPERIOR' :
				$id_nivel = 7;
				break;
				case 'FORMACION PARA EL TRABAJO' :
				$id_nivel = 8;
				break;
				case 'OTRO NIVEL EDUCATIVO' :
				$id_nivel = 9;
				break;
				case 'NO APLICA' :
				$id_nivel = 10;
				break;
			}
			$result_prioridades = $this->Prioridad_model->get_prioridadesxnivel($this->cct[0]['nivel']);
			$datos = $this->Rutamejora_model->edith_tp($id_tprioritario);
			$cat_prom_amb = $this->Rutamejora_model->catalogo_problematica_ambitos($id_prioridad);
			$encabezado = $this->Rutamejora_model->get_problematica_ambito_ids($id_tprioritario);
			
			$data['cat_select'] = $cat_prom_amb;
			$data['prioridad'] = $datos[0]['id_prioridad'];
			$data['ambito'] = $datos[0]['ambito'];
			$data['subprioridad'] = $datos[0]['id_subprioridad'];
			$data['problematica'] = $datos[0]['otro_problematica'];
			$data['evidencia'] = $datos[0]['otro_evidencia'];
			$data['director'] = $datos[0]['obs_direc'];
			$data['supervisor'] = $datos[0]['obs_supervisor'];
			
			$data['t_objetivos'] = "tabla";
			$data['prioridades'] = $result_prioridades;
			$data['idtemaprioritario'] = $id_tprioritario;
			$data['nivel_escolar'] = $id_nivel;
			$indicadores = $this->Rutamejora_model->getIndicadorEspecial($data['prioridad'], $id_nivel, $data['subprioridad']);
			$data['indicadores'] = $indicadores;

			$datos = $this->Rutamejora_model->getSubprioridad($datos[0]['id_prioridad']);
			$data['subprioridades'] = $datos;

			$strView = $this->load->view("ruta/modals_new/modal_prioridad", $data, TRUE);

			
			$head = $titulo;

			$response = array('strView' => $strView, 'titulo' => $head, 'data'=>$data, 'encabezado'=>$encabezado);
			Utilerias::enviaDataJson(200, $response, $this);
			exit;
		}else{
			redirect('Rutademejora/index');
		}
	}

	public function cargarEvidencia($id_objetivo, $id_tprioritario){
		$nombre_archivo = str_replace(" ", "_", $_FILES['arch1']['name']);
		$this->cct = Utilerias::get_cct_sesion($this);
		$id_cct = $this->cct[0]['cve_centro'];

		if ( $nombre_archivo != '' ) {
			$ruta_archivos = "evidencias_rm/{$id_cct}/{$id_tprioritario}/{$id_objetivo}";
			$ruta_archivos_save = "evidencias_rm/{$id_cct}/{$id_tprioritario}/{$id_objetivo}/$nombre_archivo";
			
			$ev_obj = $this->Rutamejora_model->evidenciaObjInicio($id_objetivo, $ruta_archivos_save, $id_tprioritario);
			

			if(!is_dir($ruta_archivos)){
				mkdir($ruta_archivos, 0777, true);
			}

			$_FILES['userFile']['name']     = $_FILES['arch1']['name'];
			$_FILES['userFile']['type']     = $_FILES['arch1']['type'];
			$_FILES['userFile']['tmp_name'] = $_FILES['arch1']['tmp_name'];
			$_FILES['userFile']['error']    = $_FILES['arch1']['error'];
			$_FILES['userFile']['size']     = $_FILES['arch1']['size'];

			$uploadPath              = $ruta_archivos;
			$config['upload_path']   = $uploadPath;
			$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|xlsx|xls|doc|docx|txt';

			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if ($this->upload->do_upload('userFile')) {
				$fileData = $this->upload->data();
				$str_view = true;
			}
			$ev_obj = true;
		}

		$response = array('evidencias' => $ev_obj);

		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function cargarEvidenciaFin($id_objetivo, $id_tprioritario){
		$nombre_archivo = str_replace(" ", "_", $_FILES['arch2']['name']);
		
		$this->cct = Utilerias::get_cct_sesion($this);
		$id_cct = $this->cct[0]['cve_centro'];

		if ( $nombre_archivo != '' ) {
			$ruta_archivos = "evidencias_rm/{$id_cct}/{$id_tprioritario}/{$id_objetivo}";
			$ruta_archivos_save = "evidencias_rm/{$id_cct}/{$id_tprioritario}/{$id_objetivo}/$nombre_archivo";
			$ev_obj = $this->Rutamejora_model->evidenciaObjFin($id_objetivo, $ruta_archivos_save, $id_tprioritario);

			if(!is_dir($ruta_archivos)){
				mkdir($ruta_archivos, 0777, true);
			}

			$_FILES['userFile']['name']     = $_FILES['arch2']['name'];
			$_FILES['userFile']['type']     = $_FILES['arch2']['type'];
			$_FILES['userFile']['tmp_name'] = $_FILES['arch2']['tmp_name'];
			$_FILES['userFile']['error']    = $_FILES['arch2']['error'];
			$_FILES['userFile']['size']     = $_FILES['arch2']['size'];

			$uploadPath              = $ruta_archivos;
			$config['upload_path']   = $uploadPath;
			$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|xlsx|xls|doc|docx|txt';

			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if ($this->upload->do_upload('userFile')) {
				$fileData = $this->upload->data();
				$str_view = true;
			}
			$ev_obj = true;
		}

		$response = array('evidencias' => $ev_obj);

		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	//Eliminar evidencia inicio
	public function eliminaEvObjIn($id_objetivo){
		$path_archivo_aux = $this->Rutamejora_model->getEvidenciaInicio($id_objetivo);
		$path_archivo = $path_archivo_aux[0]['path_ev_inicio'];

		if ($path_archivo != '' ) {
			unlink($path_archivo);
			$status = $this->Rutamejora_model->deleteEvidenciaObjIni($id_objetivo);
		}

		$response = array('status' => $status);
		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}


	//Eliminar evidencia fin
	public function eliminaEvObjFin($id_objetivo){
		$path_archivo_aux = $this->Rutamejora_model->getEvidenciaFin($id_objetivo);
		$path_archivo = $path_archivo_aux[0]['path_ev_fin'];

		if ($path_archivo != '' ) {
			unlink($path_archivo);
			$status = $this->Rutamejora_model->deleteEvidenciaObjFin($id_objetivo);
		}

		$response = array('status' => $status);
		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function getAccxObj(){
		$id_objetivo = $this->input->post('id_objetivo');
		
		$acciones = $this->Rutamejora_model->getAccxObj($id_objetivo);

		$tabla = "<div class='table-responsive'>
		<table id='idtabla_accionestp' class='table table-condensed table-hover  table-bordered'>
		<thead>
		<tr class=info>
		<th id='orden' style='width:4%' hidden><center>Id accion</center></th>
		<th id='evidencias' style='width:25%; vertical-align: middle;' rowspan='2'><center>Acciones</center></th>
		<th id='evidencias' style='width:25%; vertical-align: middle;' rowspan='2'><center>Recursos</center></th>
		<th colspan='2' scope='col'><center>Fecha</center></th>
		</tr>
		<tr>
		<th id='tema' style='width:24%' scope='col'><center>Inicio</center></th>
		<th id='problemas' style='width:25%' scope='col'><center>Fin</center></th>
		</tr>
		</thead>
		<tbody>";
		if(count($acciones) > 0){
			foreach ($acciones as $accion) {
				$tabla .= "<tr>
				<td hidden>{$accion['id_accion']}</td>
				<td hidden>{$accion['id_tprioritario']}</td>
				<td>{$accion['accion']}</td>
				<td>{$accion['mat_insumos']}</td>
				<td>{$accion['accion_f_inicio']}</td>
				<td>{$accion['accion_f_termino']}</td>
				</tr>";
			}
		}else{
			$tabla .= "<tr>
			<td colspan='5'>No hay datos por mostrar</td>
			</tr>";
		}

		$tabla .= "</tbody>
		</table>
		</div>  ";

		$response = array('acciones' => $acciones, 'tabla' => $tabla);
		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	function getTablaAccxObj($id_objetivo){
		
		$acciones = $this->Rutamejora_model->getAccxObj($id_objetivo);
		$tabla = "<div class='table-responsive'>
		<table id='idtabla_accionestp' class='table table-condensed table-hover  table-bordered'>
		<thead>
		<tr class=info>
		<th id='orden' style='width:4%' hidden><center>Id accion</center></th>
		<th id='evidencias' style='width:25%; vertical-align: middle;' rowspan='2'><center>Acciones</center></th>
		<th id='evidencias' style='width:25%; vertical-align: middle;' rowspan='2'><center>Recursos</center></th>
		<th colspan='2' scope='col'><center>Fecha</center></th>
		</tr>
		<tr>
		<th id='tema' style='width:24%' scope='col'><center>Inicio</center></th>
		<th id='problemas' style='width:25%' scope='col'><center>Fin</center></th>
		</tr>
		</thead>
		<tbody>";

		if(count($acciones) > 0){
			foreach ($acciones as $accion) {
				$tabla .= "<tr>
				<td hidden>{$accion['id_accion']}</td>
				<td>{$accion['accion']}</td>
				<td>{$accion['mat_insumos']}</td>
				<td>{$accion['accion_f_inicio']}</td>
				<td>{$accion['accion_f_termino']}</td>
				</tr>";
			}
		}else{
			$tabla .= "<tr>
			<td colspan='5'>No hay datos por mostrar</td>
			</tr>";
		}

		$tabla .= "</tbody>
		</table>
		</div>  ";

		$response = array('acciones' => $acciones, 'tabla' => $tabla);
		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}
	public function publicar()
	{
		$estado_publicacion = $this->input->post('estado_publicacion');
		$id= $this->input->post('id_publicacion');
		$data = array('estado_publicacion' => $estado_publicacion, 'id' => $id );
		$publicar = $this->Rutamejora_model->publicar_objetivo($data);

		$response = array('id' => $id, 'estado' => $estado_publicacion);
		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function set_observacion(){
		$objetivo = $this->input->post('idaccion');
		$resultados = $this->input->post('resultados');
		$obstaculos = $this->input->post('obstaculos');
		$ventajas = $this->input->post('ventajas');
		$ajustes = $this->input->post('ajustes');

		$todo = $resultados .' obstaculos: '.$obstaculos .' ventajas: '.$ventajas. 'ajuste: ' .$ajustes;

		$result = $this->Rutamejora_model->set_observacion($objetivo, $resultados, $obstaculos, $ventajas, $ajustes);
	}

	public function avancesxcctxaccion(){
		
		$this->cct = Utilerias::get_cct_sesion($this);
		$cctS = $this->cct[0]['cve_centro'];
		$turnoS = $this->cct[0]['id_turno_single'];
		$id_cct = $this->input->post('id_cct');
		$arr_avances_fechas = $this->Rutamejora_model->get_avances_tp_accionxcct_fechas(5);
		$cte_vigente=$this->cteVigente($arr_avances_fechas);
		$datos=$this->Rutamejora_model->avancesxcctxaccion($cctS, $turnoS,$cte_vigente);
		$fechas=$this->Rutamejora_model->fechaMaxMin($cctS,$turnoS,$cte_vigente);
		$porcentaje=0;
		$acciones=array();
		$data_ac=array();
		$acciones = array();
      	for($i=0; $i<count($datos); $i++){
      		$porcentaje=0;
      		if($datos[$i]['porcentaje']!=0 && $datos[$i]['porcentaje']!=null){
      			$porcentaje= $datos[$i]['porcentaje'];
      		}
      		if($datos[$i]['periodo']+1==1){
      			$duracion="1 día";
      		}else{
      			$duracion=($datos[$i]['periodo']+1)." días";
      		}
      			$accion=array(
				    "title"=> $datos[$i]['accion'],
				    "startdate"=> $datos[$i]['accion_f_inicio'],
				    "enddate"=> $datos[$i]['accion_f_termino'],
				    "type"=> "Tur",
				    "minNight"=>$datos[$i]['periodo'],
				    "minNight2"=>$porcentaje,
				    "tooltipData"=>array(
				        "title"=>$datos[$i]['accion'],
				        "desc"=> array(" Acción: ".$datos[$i]['ac'],"Duración: ".$duracion, "Fecha Inicio: ".$datos[$i]['fechainicio'], "Fecha Término: " .$datos[$i]['fechafin'], " Porcentaje de Avance:  ".$porcentaje."%") 
				    ),
				    "dateorder"=> "\/Date(1469048400000)\/"
				);	
				array_push($acciones,$accion);
      	}
      	$data_ac['acciones']=$acciones;
      	$data_ac['inicio']=$fechas[0]['inicio'];
      	$data_ac['fin']=$fechas[0]['fin'];
      	if($fechas[0]['dias_dif']<=10){
      		$nuevafecha = strtotime ( '+50 day' , strtotime ( $fechas[0]['fin'] ) );
      		$nuevafecha = date ( 'Y-m-d' , $nuevafecha);
      	}else if($fechas[0]['dias_dif']>10 && $fechas[0]['dias_dif']<=20 ){
      		$nuevafecha = strtotime ( '+40 day' , strtotime ( $fechas[0]['fin'] ) );
      		$nuevafecha = date ( 'Y-m-d' , $nuevafecha);
      	}else if($fechas[0]['dias_dif']>20 && $fechas[0]['dias_dif']<=30 ){
      		$nuevafecha = strtotime ( '+30 day' , strtotime ( $fechas[0]['fin'] ) );
      		$nuevafecha = date ( 'Y-m-d' , $nuevafecha);
      	}else if($fechas[0]['dias_dif']>30 && $fechas[0]['dias_dif']<=40 ){
      		$nuevafecha = strtotime ( '+20 day' , strtotime ( $fechas[0]['fin'] ) );
      		$nuevafecha = date ( 'Y-m-d' , $nuevafecha);
      	}else if($fechas[0]['dias_dif']>40 && $fechas[0]['dias_dif']<=50 ){
      		$nuevafecha = strtotime ( '+10 day' , strtotime ( $fechas[0]['fin'] ) );
      		$nuevafecha = date ( 'Y-m-d' , $nuevafecha);
      	}else{
      		$nuevafecha = strtotime ( '+3 day' , strtotime ( $fechas[0]['fin'] ) );
      		$nuevafecha = date ( 'Y-m-d' , $nuevafecha);
      	}
      	$dom=$this->load->view("ruta/ejemplo", $data_ac, TRUE);
		$response = array('datos' => $datos,'acciones'=>$acciones,'fechaMin'=>$fechas[0]['inicio'],'fechaMax'=>$nuevafecha,'dom'=>$dom);
		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function pieAccion(){
		if(Utilerias::haySesionAbiertacct($this)){
			$id_cct = $this->input->post('id_cct');
			$arr_avances_fechas = $this->Rutamejora_model->get_avances_tp_accionxcct_fechas(5);
			$cte_vigente=$this->cteVigente($arr_avances_fechas);

			$datos=$this->Rutamejora_model->pieAccion($id_cct,$cte_vigente);
			$response = array('datos' => $datos);
			Utilerias::enviaDataJson(200, $response, $this);
			exit;
		}
	}
	public function cteVigente($arr_avances_fechas){
		$cte_vigente="";
		if($arr_avances_fechas[0]['cte1_var']=='TRUE'){
			$cte_vigente="cte1";
		}else if($arr_avances_fechas[0]['cte2_var']=='TRUE'){
			$cte_vigente="cte2";
		}else if($arr_avances_fechas[0]['cte3_var']=='TRUE'){
			$cte_vigente="cte3";
		}else if($arr_avances_fechas[0]['cte4_var']=='TRUE'){
			$cte_vigente="cte4";
		}else if($arr_avances_fechas[0]['cte5_var']=='TRUE'){
			$cte_vigente="cte5";
		}else if($arr_avances_fechas[0]['cte6_var']=='TRUE'){
			$cte_vigente="cte6";
		}else if($arr_avances_fechas[0]['cte7_var']=='TRUE'){
			$cte_vigente="cte7";
		}else if($arr_avances_fechas[0]['cte8_var']=='TRUE'){
			$cte_vigente="cte8";
		}else if($arr_avances_fechas[0]['cte9_var']=='TRUE'){
			$cte_vigente="cte9";
		}else if($arr_avances_fechas[0]['cte10_var']=='TRUE'){
			$cte_vigente="cte10";
		}

		return $cte_vigente;
	}

	public function pieObjetivos(){
		if(Utilerias::haySesionAbiertacct($this)){
			$id_cct = $this->input->post('id_cct');
			$arr_avances_fechas = $this->Rutamejora_model->get_avances_tp_accionxcct_fechas(5);
			$cte_vigente=$this->cteVigente($arr_avances_fechas);
			$datos=$this->Rutamejora_model->pieObjetivos($id_cct,$cte_vigente);
			$response = array('datos' => $datos);
			Utilerias::enviaDataJson(200, $response, $this);
			exit;
		}
	}

	public function pieLAE(){
		if(Utilerias::haySesionAbiertacct($this)){
			$id_cct = $this->input->post('id_cct');
			$arr_avances_fechas = $this->Rutamejora_model->get_avances_tp_accionxcct_fechas(5);
			$cte_vigente=$this->cteVigente($arr_avances_fechas);
			$datos=$this->Rutamejora_model->pieLAE($id_cct,$cte_vigente);
			$response = array('datos' => $datos);
			Utilerias::enviaDataJson(200, $response, $this);
			exit;
		}
	}

	public function accionesRezagadas(){
		if(Utilerias::haySesionAbiertacct($this)){
			$this->cct = Utilerias::get_cct_sesion($this);
			$cctS = $this->cct[0]['cve_centro'];
			$turnoS = $this->cct[0]['id_turno_single'];
			$id_cct = $this->input->post('id_cct');
			$arr_avances_fechas = $this->Rutamejora_model->get_avances_tp_accionxcct_fechas(5);
			$cte_vigente=$this->cteVigente($arr_avances_fechas);
			$datos=$this->Rutamejora_model->accionesRezagadas($cctS,$turnoS,$cte_vigente);
			$response = array('datos' => $datos);
			Utilerias::enviaDataJson(200, $response, $this);
			exit;
		}
	}

	public function momentoActual()
	{
		$momentoActual = $this->Rutamejora_model->momentoActual();

		foreach ($momentoActual as $key => $value) {
			
				if ($value['cte'] > 0) {
					$cteActual = $value['cte'];
				
			}
		}
		$response = array('cte' => $cteActual);
		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

}// Rutamedejora
