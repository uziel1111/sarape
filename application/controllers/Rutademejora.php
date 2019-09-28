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
				// $this->llenadatos();
			$this->index_new();

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
					// $this->llenadatos();
					$this->index_new();
				}

			}else{
				$usuario = strtoupper($this->input->post('usuario'));
				$pass = strtoupper($this->input->post('password'));
				$turno = $this->input->post('turno_id');

				if($this->verifica_supervisor($usuario) == TRUE){
					$datos_sesion = $this->iniciamos_sesion_supervisor($usuario, $pass, $turno);
					if($datos_sesion->procede == 1 && $datos_sesion->status == 1){
					// if(1 == 1 && 1 == 1){
						$datoscct = $this->Rutamejora_model->getdatossupervicion($usuario, $turno);
						Utilerias::set_cct_sesion($this, $datoscct);


					    // if($response->procede == 1 && $response->status == 1){
							// $datoscct = $this->Rutamejora_model->getdatoscct($usuario, $turno);
							// Utilerias::set_cct_sesion($this, $datoscct);
						$this->generavistaSupervisor();
							///Aqui llenamos los datos
						// }else{
						// 	$mensaje = $response->statusText;
		    //         		$tipo    = ERRORMESSAGE;
		    //         		$this->session->set_flashdata(MESSAGEREQUEST, Utilerias::get_notification_alert($mensaje, $tipo));
						// 	$this->load->view('ruta/login',$data);
						// }
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
						Utilerias::set_cct_sesion($this, $datoscct);

						// $this->llenadatos();
						$this->index_new();

						///Aqui llenamos los datos
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
			// echo "<pre>";print_r($responsables);die();
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
			// echo "<pre>";print_r($this->cct[0]['nivel']);die();
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
				// echo "<pre>";print_r($this->cct[0]['id_cct']);die();
			  $result_progsapoyo = $this->Prog_apoyo_xcct_model->get_prog_apoyo_xcctxciclo($this->cct[0]['id_cct'],4);//id_cct, id_ciclo
			  if(count($result_progsapoyo)==0){
			  	$data['arr_progsapoyo'] = '';
			  }else{
			  	$data['arr_progsapoyo'] = $result_progsapoyo;
			  }
			  $result_apoyosreq = $this->Apoyo_req_model->get_apoyo_req();
			  if(count($result_apoyosreq)==0){
			  	$data['arr_apoyosreq'] = array(	'-1' => 'Error recuperando los apoyosreq' );
			  }else{
			  	$data['arr_apoyosreq'] = $result_apoyosreq;
			  }
			  $result_ambitos = $this->Ambito_model->get_ambitos();
			  if(count($result_ambitos)==0){
			  	$data['arr_ambitos'] = array(	'-1' => 'Error recuperando los ambitos' );
			  }else{
			  	$data['arr_ambitos'] = $result_ambitos;
			  }

			  $data3 = array();
			$arr_indicadoresxct = $this->Rutamejora_model->get_indicadoresxcct($this->cct[0]['id_cct'],$this->cct[0]['nivel'],'1', '2018');//id_cct,nombre_nivel,bimestre,año
			$data3['arr_indicadores'] = $arr_indicadoresxct;
			// echo "<pre>";print_r($arr_avances);die();
			$string_view_indicadores = $this->load->view('ruta/indicadores', $data3, TRUE);
			$data['tab_indicadores'] = $string_view_indicadores;

			$data4 = array();
			$string_view_instructivo = $this->load->view('ruta/instructivo', $data4, TRUE);
			$data['tab_instructivo'] = $string_view_instructivo;

			$data['nivel'] = $this->cct[0]['nivel'];//$nivel;
			$data['nombreuser'] = $this->cct[0]['nombre_centro'];
			$data['turno'] = $this->cct[0]['turno_single'];
			$data['cct'] = $this->cct[0]['cve_centro'];
			Utilerias::pagina_basica_rm($this, "ruta/index", $data);
		}

		public function getPersonal($cct){
			// if(Utilerias::haySesionAbiertacct($this)){
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
			// }else{
			// 	redirect('Rutademejora/index');
			// }
		}


		public function insert_tema_prioritario(){
			if(Utilerias::haySesionAbiertacct($this)){
				$this->cct = Utilerias::get_cct_sesion($this);
				$id_cct = $this->cct[0]['id_cct'];
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
				// echo "<pre>";print_r($_POST);die();
					$id_cct = $this->cct[0]['id_cct'];
					$misioncct = $this->input->post("misioncct");
					if ($this->Rutamejora_model->existe_misionxidcct($id_cct,'4')) {
						$estatus = $this->Rutamejora_model->update_misionxidcct($id_cct,$misioncct,'4');
					}
					else {
						$estatus = $this->Rutamejora_model->insert_misionxidcct($id_cct,$misioncct,'4');
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
					$id_cct = $this->cct[0]['id_cct'];
					$tam = 0;
				// $rutas = $this->Rutamejora_model->getrutasxcct($id_cct);
				$temas_prioritarios = $this->Rutamejora_model->getPrioridades($id_cct); //Verificamos si esa cct ya tiene temas prioritarios
				$tam = count($temas_prioritarios);
					//echo"<pre>";print_r($tam);  die();


				if (count($temas_prioritarios)>0) {
					//echo "if"; die();
					$tabla = "<div class='table-responsive' >
					<table id='id_tabla_rutas' class='table table-condensed table-hover  table-bordered'>
					<thead>
					<tr class=info style='vertical-align:middle' disable='true'>
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
													//echo "<pre>"; print_r($temas_prioritarios); die();
						$tabla .= "<tr>
						<td id='id_tprioritario' hidden><center>{$tp['id_tprioritario']}</center></td>
						<td id='id_prioridad' hidden>{$tp['id_prioridad']}</td>
						<td id='orden' style='vertical-align:middle;'><center>LAE-{$tp['orden']}</center></td>
						<td id='prioridad' style='vertical-align:middle;'>{$tp['prioridad']}</td>
						<td id='num_objetivos' style='vertical-align:middle;'><center>{$tp['num_objetivos']}</center></td>
						<td id='num_acciones' style='vertical-align:middle;'><center>{$tp['num_acciones']}</center></td>
						</tr>";

					}

					$tabla .= "</tbody>
					</table>
					</div>  ";

				} else {
						//echo "else";  die();
					$new_tprioritarios = $this->Rutamejora_model->insertaTprioritarios($id_cct);
					$temas_prioritarios = $this->Rutamejora_model->getPrioridades($id_cct);

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

				// echo "<pre>";print_r($data['temas_prioritarios']);die();
				$response = array('tabla' => $tabla, 'tamanio' => $tam);
				Utilerias::enviaDataJson(200, $response, $this);
				exit;
			}else{
				redirect('Rutademejora/index');
			}
		}


		//FUNCIONAMIENTO de DRAG and DROP
	// public function update_order(){
	// 	if(Utilerias::haySesionAbiertacct($this)){
	// 		$this->cct = Utilerias::get_cct_sesion($this);
	// 		$id_cct = $this->cct[0]['id_cct'];
	// 		$datos = $this->input->post('orden');
	// 		for($i = 0; $i < count($datos); $i++){
	// 			$arr_datos = $this->Rutamejora_model->update_order($datos[$i][1], $datos[$i][0]);
	// 		}
	// 		$id_cct = $this->cct[0]['id_cct'];
	// 		// $rutas = $this->Rutamejora_model->getrutasxcct($id_cct);
	// 		$temas_prioritarios = $this->Rutamejora_model->getPrioridades($id_cct);
	//
	// 		$tabla = "<div class='table-responsive text-center'>
	// 			           <table id='id_tabla_rutas' class='table table-condensed table-hover  table-bordered'>
	// 			            <thead>
	// 									<tr class=info style='vertical-align:middle'>
	// 										<th id='id_tprioritario' hidden><center>id_tprioritario</center></th>
	// 										<th id='id_prioridad' hidden><center>id_prioridad</center></th>
	// 										<th id='id_subprioridad' hidden><center>id_subprioridad</center></th>
	// 										<th id='orden' style='width:3%; vertical-align:middle;'><center>Orden</center></th>
	// 										<th id='tema' style='width:30%; vertical-align:middle;'><center>Lineas de acción</center></th>
	// 										<th id='objetivos' style='width:10%; vertical-align:middle;'><center>Objetivos y metas</center></th>
	// 										<th id='n_actividades' style='width:3%; vertical-align:middle;'><center>Actividades</center></th>
	// 									</tr>
  //                   </thead>
  //                   <tbody id='id_tbody_demo'>";
	//
	// 			foreach ($temas_prioritarios as $tp) {
	// 				$tabla .= "<tr>
	// 						<td id='id_tprioritario' hidden><center>{$tp['id_tprioritario']}</center></td>
	// 						<td id='id_prioridad' hidden>{$tp['id_prioridad']}</td>
	// 						<td id='id_prioridad' hidden>{$tp['id_subprioridad']}</td>
	// 						<td id='orden'>{$tp['orden']}</td>
	// 						<td id='prioridad'>{$tp['prioridad']}</td>
	// 						<td id='num_objetivos'>{$tp['num_objetivos']}</td>
	// 						<td id='num_acciones'>{$tp['num_acciones']}</td>
	// 					</tr>";
	// 				}
	//
	// 		$tabla .= "</tbody></table></div>";
	//
	// 		$response = array('tabla' => $tabla);
	// 		Utilerias::enviaDataJson(200, $response, $this);
	// 		exit;
	// 		}else{
	// 			redirect('Rutademejora/index');
	// 		}
	// 	}


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
			// echo "<pre>";print_r($edit_img);die();

			if ($nombre_archivo=='') {
			// echo "<pre>";print_r($edit_img);die();
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
			// echo "<pre>";print_r($ruta_archivos_save);die();
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
				// echo "<pre>";
				// print_r($_POST);
				// die();
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
			// echo "<pre>";
			// print_r($_POST);
			// die();

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

							/*$tabla = "<div class='table-responsive'>
							<table id='idtabla_accionestp' class='table table-condensed table-hover  table-bordered'>
							<thead>
							<tr class=info>
							<th id='orden' style='width:4%' hidden><center>Id accion</center></th>
							<th id='evidencias' style='width:39%; vertical-align: middle;'><center>Acción</center></th>
							<th id='evidencias' style='width:39%; vertical-align: middle;'><center>Recursos</center></th>
							<th id='tema' style='width:20%'><center>Fecha de inicio</center></th>
							<th id='problemas' style='width:31%'><center>Fecha de término</center></th>

							</tr>
							</thead>
							<tbody>";*/
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

							/*$tabla = "<div class='table-responsive'>
							<table id='idtabla_accionestp' class='table table-condensed table-hover  table-bordered'>
							<thead>
							<tr class=info>
							<th id='orden' style='width:4%' hidden><center>Id accion</center></th>
							<th id='evidencias' style='width:39%; vertical-align: middle;'><center>Acción</center></th>
							<th id='evidencias' style='width:39%; vertical-align: middle;' ><center>Recursos</center></th>
							<th id='tema' style='width:20%'><center>Fecha de inicio</center></th>
							<th id='problemas' style='width:31%'><center>Fecha de término</center></th>

							</tr>
							</thead>
							<tbody>";*/
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

				/*	$tabla = "<div class='table-responsive'>
					<table id='idtabla_accionestp' class='table table-condensed table-hover  table-bordered'>
					<thead>
					<tr class=info>
					<th id='orden' style='width:4%' hidden><center>Id accion</center></th>
					<th id='evidencias' style='width:39%; vertical-align: middle;'><center>Acción</center></th>
					<th id='evidencias' style='width:39%; vertical-align: middle;'><center>Recursos</center></th>
					<th id='tema' style='width:20%'><center>Fecha de inicio</center></th>
					<th id='problemas' style='width:31%'><center>Fecha de término</center></th>
					</tr>
					</thead>
					<tbody>"; */
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
					$datos =array('escuela' => $this->cct[0]['nombre_centro'],'prioridad'=> $get_datos[0]['prioridad'],'problematicas'=> $get_datos[0]['otro_problematica'],'evidencias'=> $get_datos[0]['otro_evidencia']);
			// $strView = $this->load->view("ruta/modals_new/modal_actividades", $datos, TRUE);
			// $response = array('tabla' => $tabla, 'datos' => $datos, 'strView' => $strView);
					$objetivos = $this->Rutamejora_model->getObjxTp($id_tprioritario);
			// echo "<pre>";print_r($objetivos);die();
					$option = "<option value='0'>SELECCIONE</option>";
					foreach ($objetivos as $objetivo) {
				// $option .="<option value='{$dato['id_indicador']}'>{$dato['formula']}</option>";
						$option .="<option value='{$objetivo['id_objetivo']}'>{$objetivo['objetivo']}</option>";
					}

					$response = array('tabla' => $tabla, 'datos' => $datos, 'stroption' => $option, 'titulo' => '<i class="far fa-lightbulb"></i> NADA');
			// echo "<pre>";print_r($response);die();
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
			// echo "<pre>";print_r($_POST);die();
					$delete = $this->Rutamejora_model->deleteaccion($idaccion, $id_tprioritario);
			// echo "<pre>";print_r($delete);die();
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
					/*$tabla = "<div class='table-responsive'>
					<table id='idtabla_accionestp' class='table table-condensed table-hover  table-bordered'>
					<thead>
					<tr class=info>
					<th id='orden' style='width:4%' hidden><center>Id accion</center></th>
					<th id='evidencias' style='width:39%'><center>Acción</center></th>
					<th id='tema' style='width:20%'><center>Fecha de inicio</center></th>
					<th id='problemas' style='width:31%'><center>Fecha de término</center></th>

					</tr>
					</thead>
					<tbody>";*/
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
					$val_slc = $this->input->post('val_slc');
					$var_id_cte = $this->input->post('var_id_cte');
					$var_id_cct = $this->input->post('var_id_cct');
					$var_id_idtp = $this->input->post('var_id_idtp');
					$var_id_idacc = $this->input->post('var_id_idacc');

					$exite_enavance = $this->Rutamejora_model->existe_avance($var_id_cct,$var_id_idtp,$var_id_idacc);
					if (!$exite_enavance) {
						$estatusinsert = $this->Rutamejora_model->insert_avance($var_id_cct,$var_id_idtp,$var_id_idacc);
					}
					$estatus = $this->Rutamejora_model->update_avance_xcte($val_slc,$var_id_cte,$var_id_cct,$var_id_idtp,$var_id_idacc);

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
			// echo "<pre>";print_r($editada);die();
					$response = array("editado" => $editada[0]);
					Utilerias::enviaDataJson(200, $response, $this);
					exit;
				}else{
					redirect('Rutademejora/index');
				}
			}
			public function get_avance(){
				if(Utilerias::haySesionAbiertacct($this)){
					$this->cct = Utilerias::get_cct_sesion($this);
					$data2 = array();
					$arr_avances = $this->Rutamejora_model->get_avances_tp_accionxcct($this->cct[0]['id_cct']);
				// echo "<pre>";print_r($arr_avances);die();
					$data2['arr_avances'] = $arr_avances;
					$arr_avances_fechas = $this->Rutamejora_model->get_avances_tp_accionxcct_fechas(5);
					$data2['arr_avances_fechas'] = $arr_avances_fechas;
				// echo "<pre>";print_r($data2);die();
				// explode(" ", $pizza);
					$varaux_temp = explode("_", array_search('TRUE', $arr_avances_fechas[0]));
					// echo "<pre>"; print_r($varaux_temp); die();
					$clave = $varaux_temp[0];
				// $clave = "cte4_var";
				// echo $clave; die();
					$arr_avances_n = $this->asigna_icono($arr_avances, $clave);
					$data2['arr_avances'] = $arr_avances_n;
				// echo "<pre>";print_r($data2);die();
					$string_view_avance = $this->load->view('ruta/avances', $data2, TRUE);
					$response = array('srt_html' => $string_view_avance);
				// echo "<pre>";print_r($response);die();
					Utilerias::enviaDataJson(200, $response, $this);
					exit;
				}else{
					redirect('Rutademejora/index');
				}
			}

			public function asigna_icono($arr_avances, $habilitado){
			// echo $habilitado;die();
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
					return "0.png";
				}else if($porcentaje == 10 || $porcentaje == 20 || $porcentaje == 30){
					return "1.png";
				}else if($porcentaje == 40 || $porcentaje == 50 || $porcentaje == 60 || $porcentaje == 70){
					return "2.png";
				}else if($porcentaje == 80 || $porcentaje == 90){
					return "3.png";
				}else if($porcentaje == 100){
					return "4.png";
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
	// echo "<pre>";print_r($escuelas->Escuelas[0]->b_cct);die();
					Utilerias::pagina_basica_rm($this, "ruta/supervisor/index", $data);
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
	// echo "<pre>";
	// print_r($datos_cct[0]['id_cct']);
	// die();
					$tabla_rutas = $this->get_table_rutas($datos_cct[0]['id_cct']);

					$response = array('tabla' => $tabla_rutas, 'cct_escuela' => $cct);
					Utilerias::enviaDataJson(200, $response, $this);
					exit;
				}

				public function get_table_rutas($idcct){
					$rutas = $this->Rutamejora_model->getrutasxcct($idcct);

					$tabla = "<div class='table-responsive'>
					<table id='id_tabla_rutas_super' class='table table-condensed table-hover  table-bordered'>
					<thead>
					<tr class=info>
					<th id='idrutamtema' hidden><center>id</center></th>
					<th id='orden' style='width:4%'><center>Orden</center></th>
					<th id='tema' style='width:20%'><center>Prioridad</center></th>
					<th id='problemas' style='width:31%'><center>Problemáticas</center></th>
					<th id='evidencias' style='width:31%'><center>Evidencias</center></th>
					<th id='n_actividades' style='width:8%'><center>Acciones</center></th>
					<th id='objetivo' style='width:6%'><center>Objetivo</center></th>
					<th id='objetivo' style='width:6%'><center>Observación</center></th>
					<th id='objetivo' style='width:6%'><center>Archivo evidencia</center></th>
					</tr>
					</thead>
					<tbody id='id_tbody_demo'>";


					foreach ($rutas as $ruta) {
						$tabla .= "<tr>
						<td id='id_tprioritario' hidden><center>{$ruta['id_tprioritario']}</center></td>
						<td id='orden' data='1'>{$ruta['orden']}</td>
						<td id='tema' data='Normalidad mínima'>{$ruta['prioridad']}</td><td id='problemas' data='Asistencia de profesores' >{$ruta['otro_problematica']}</td>
						<td id='evidencias' data='SISAT'>{$ruta['otro_evidencia']}</td>
						<td id='n_actividades' data='0'>{$ruta['n_acciones']}</td>
						<td id=''><center><i class='fas fa-check-circle'></i></center></td>
						<td id=''><center><i class='{$ruta['obs_supervisor']}'></i></center></td>
						<td id=''><center><button  style='display:{$ruta['trae_path']};' type='button' class='btn btn-primary btn-style-1 mr-1' onclick=obj_supervisor.ver_archivo_evidencia('{$ruta['path_evidencia']}')>Ver</button></center></td>
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
	// echo $mensajeguardado; die();
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
	// 		$this->cct = Utilerias::get_cct_sesion($this);
						$id_tprioritario = $this->input->post('idruta');
						$nombreescuela = $this->input->post('nombreescuela');
						$acciones = $this->Rutamejora_model->getacciones($id_tprioritario);
						$tabla = "<div class='table-responsive'>
						<table id='idtabla_accionestp_super' class='table table-condensed table-hover  table-bordered'>
						<thead>
						<tr class=info>
						<th id='orden' style='width:4%' hidden><center>Id accion</center></th>
						<th id='orden' style='width:20%'><center>Ámbito</center></th>
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
								<td>{$accion['ambito']}</td>
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
						$data['problematicas'] = $get_datos[0]['otro_problematica'];
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
			// echo "<pre>";
			// print_r($editada);
			// die();
						$responsables = $this->getPersonal($cct_log);
						if (count($responsables)==0) {
							$responsables = array();
						}
	// 		echo "<pre>";
	// print_r($responsables->Personal);
	// die();
						$listap = "";
						foreach ($responsables->Personal as $persona) {

							for($i = 0; $i < count($ids_responsables); $i++){
								if($persona->rfc == $ids_responsables[$i]){
									$listap .= trim($persona->nombre_completo).", ";
								}
							}
						}
		    // echo $listap; die();
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
		// echo "<pre>";
		// print_r($mensaje);
		// die();
					$response = array('mensaje' => $mensaje[0]['obs_supervisor']);
					Utilerias::enviaDataJson(200, $response, $this);
					exit;
				}

	// Nuevo codigo ruta mejora Ismael

				public function index_new(){
					$this->cct = Utilerias::get_cct_sesion($this);
					$usuario = $this->cct[0]['cve_centro'];
					$id_cct = $this->cct[0]['id_cct'];
					$responsables = $this->getPersonal($usuario);
					$nomenclatura = substr($usuario,0,5);
		 // echo "<pre>";print_r($nomenclatura);die();
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


					$mision = $this->Rutamejora_model->get_misionxcct($this->cct[0]['id_cct'],'4');
					$data['mision'] = $mision;
					$result_prioridades = $this->Prioridad_model->get_prioridadesxnivel($this->cct[0]['nivel']);
		 //echo "<pre>";print_r($result_prioridades);die();
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
			// echo "<pre>";print_r($this->cct[0]['id_cct']);die();
			$result_progsapoyo = $this->Prog_apoyo_xcct_model->get_prog_apoyo_xcctxciclo($this->cct[0]['id_cct'],4);//id_cct, id_ciclo
			if(count($result_progsapoyo)==0){
				$data['arr_progsapoyo'] = '';
			}else{
				$data['arr_progsapoyo'] = $result_progsapoyo;
			}
			$result_apoyosreq = $this->Apoyo_req_model->get_apoyo_req();
			if(count($result_apoyosreq)==0){
				$data['arr_apoyosreq'] = array(	'-1' => 'Error recuperando los apoyosreq' );
			}else{
				$data['arr_apoyosreq'] = $result_apoyosreq;
			}
			$result_ambitos = $this->Ambito_model->get_ambitos();
			if(count($result_ambitos)==0){
				$data['arr_ambitos'] = array(	'-1' => 'Error recuperando los ambitos' );
			}else{
				$data['arr_ambitos'] = $result_ambitos;
			}

			$data3 = array();
		$arr_indicadoresxct = $this->Rutamejora_model->get_indicadoresxcct($this->cct[0]['id_cct'],$this->cct[0]['nivel'],'1', '2018');//id_cct,nombre_nivel,bimestre,año
		$data3['arr_indicadores'] = $arr_indicadoresxct;
		// echo "<pre>";print_r($arr_avances);die();
		$string_view_indicadores = $this->load->view('ruta/indicadores', $data3, TRUE);
		$data['tab_indicadores'] = $string_view_indicadores;

		$data4 = array();
		$string_view_instructivo = $this->load->view('ruta/instructivo', $data4, TRUE);
		$data['tab_instructivo'] = $string_view_instructivo;

		$data['nivel'] = $this->cct[0]['nivel'];//$nivel;
		$data['nombreuser'] = $this->cct[0]['nombre_centro'];
		$data['turno'] = $this->cct[0]['turno_single'];
		$data['cct'] = $this->cct[0]['cve_centro'];
		$data['director'] = $this->cct[0]['nombre_director'];
		$data['id_cct_rm'] =$this->cct[0]['id_cct'];
		$data['vista_avance'] = $this->load->view("ruta/rutademejora/avances", $data, TRUE);
		$data['vista_indicadores'] = $this->load->view("ruta/rutademejora/indicadores", $data, TRUE);
		$data['vista_ayuda'] = $this->load->view("ruta/rutademejora/ayuda", $data, TRUE);
		// $data['vista_resultados'] = $this->load->view("ruta/rutademejora/resultados", array(), TRUE);

		Utilerias::pagina_basica_rm($this, "ruta/rutademejora/index", $data);
	}

	public function modal_recomendacion(){
		$data = array();
		$this->cct = Utilerias::get_cct_sesion($this);
		$id_cct = $this->cct[0]['id_cct'];
		$mision = $this->Rutamejora_model->get_misionxcct($this->cct[0]['id_cct'],'4');
		$data['mision'] = $mision;

		$strView = $this->load->view("ruta/modals_new/modal_ruta", $data, TRUE);

		$response = array('strView' => $strView, 'titulo' => '<i class="far fa-lightbulb"></i> Recomendación');

		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function modal_mision(){
		$data = array();
		$this->cct = Utilerias::get_cct_sesion($this);

		$mision = $this->Rutamejora_model->get_misionxcct($this->cct[0]['id_cct'],'4');
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
			$id_cct = $this->cct[0]['id_cct'];
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
		// echo"<pre>";
		// print_r($_POST);
		// die();
		$id_tprioritario = $this->input->post('id_tprioritario');
		$path_archivo_aux = $this->Rutamejora_model->getEvidencia($id_tprioritario);
		$path_archivo = $path_archivo_aux[0]['path_evidencia'];
		// echo"<pre>";  print_r($path_archivo);die();

		$status = $this->Rutamejora_model->deleteEvidencia($id_tprioritario);
		unlink($path_archivo);
		$response = array('status' => $status);
		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function tabla_up(){
		if(Utilerias::haySesionAbiertacct($this)){
			$this->cct = Utilerias::get_cct_sesion($this);
			$id_cct = $this->cct[0]['id_cct'];
			$datos = $this->input->post('orden');
			for($i = 0; $i < count($datos); $i++){
				$arr_datos = $this->Rutamejora_model->update_order($datos[$i][1], $datos[$i][0]);
			}


			$id_cct = $this->cct[0]['id_cct'];
			$rutas = $this->Rutamejora_model->getrutasxcct($id_cct);
		}else{
			redirect('Rutademejora/index');
		}
	}

	public function modal_prioridad(){
		$data = array();
		$this->cct = Utilerias::get_cct_sesion($this);
		$id_nivel = $this->cct[0]['nivel'];
		// $idtemaprioritario = $this->input->post('idtemaprioritario');
		$result_prioridades = $this->Prioridad_model->get_prioridadesxnivel($this->cct[0]['nivel']);
		$data['prioridades'] = $result_prioridades;

		// $data['idtemaprioritario'] = $idtemaprioritario;

		$strView = $this->load->view("ruta/modals_new/modal_prioridad", $data, TRUE);

		$response = array('strView' => $strView, 'titulo' => 'Agrega prioridad');

		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function agregarObjetivo(){
		$this->cct = Utilerias::get_cct_sesion($this);
		// echo "<pre>";
		// print_r($_POST);
		// print_r($_FILES);
		// die();
		$id_tprioritario = $this->input->post("id_tprioritario");
		$id_cct = $this->cct[0]['id_cct'];
		$id_prioridad = $this->input->post('id_prioridad');
		$objetivo = $this->input->post('objetivo');
		$otra_fecha = $this->input->post('otra_fecha');

		// echo "<pre>";
		// print_r($_POST);
		// die();

		// if($id_tprioritario == 0){
		// 		$estatus = $this->Rutamejora_model->insertaCreaObjetivo($id_cct, $id_prioridad, $objetivo, $id_subprioridad);
		// }else{
		$estatus = $this->Rutamejora_model->insertaObjetivo($id_cct, $id_prioridad, strtoupper($objetivo), $id_tprioritario);
		// }

		$response = array('estatus' => $estatus['status'], 'idtemaprioritario' =>$estatus['idtemaprioritario']);
		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function actualizarObjetivo(){

		$id_objetivo = $this->input->post('id_objetivo');
		$objetivo = $this->input->post('objetivo');
		// echo $objetivo;die();
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
		// echo "<pre>";print_r($_POST);die();

		$id_cct = $this->cct[0]['id_cct'];
		$orden = 0;
		$datos = $this->Rutamejora_model->getObjetivos($id_cct, $id_tprioritario, $idprioridad);
		// echo "<pre>";print_r($datos);die();
		$idobjetivo = 0;
		if($datos[0]['id_objetivo'] == NULL){
			// echo 'if'; die();
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
				// echo "<pre>";print_r($dato);die();
				$orden = $orden +1;
				$idobjetivo = $dato['id_objetivo'];
				$idprioridad = $dato['id_tprioritario'];

				// echo "Entramos al IF";die();
				$tabla .= "<tr>
				<td id='id_objetivo' hidden><center>{$dato['id_objetivo']}</center></td>
				<td id='id_tprioritario' hidden><center>{$dato['id_tprioritario']}</center></td>
				<td id='num_rutamtema' data='1' class='text-center'>{$orden}

				<a onclick='publicar({$dato['id_objetivo']})' data-estado='{$dato['estado_publicacion']}' id='aPublicar_{$dato['id_objetivo']}'><i id='publicar_{$dato['id_objetivo']}'";
				if ($dato['estado_publicacion'] == 0) {
					 	// echo "<pre>";print_r($dato);die();
					$tabla.="class='fas fa-user-secret'></i></a>";
				}else{
					$tabla.="class='fas fa-globe-americas'></i></a>";
				}

				$tabla.= "</td>
				<td id='objetivo' data='Normalidad mínima'>{$dato['objetivo']}</td>
				<td>
				<div class='text-center'>

				<div style='margin-bottom: 10px;'>";
				
				if($tipou_pemc==""){
					$tabla.= "<button type='button' id='elimina_ini' class='btn btn-sm cerrar'
						onclick='eliminaEvidencia({$dato['id_objetivo']}, this)'>
						<i class='fas fa-times-circle'></i>
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

							// if (($dato['path_ev_fin']) != 'evidencias_rm/4237/8183/iron.jpg') {
							// 	$tabla.= "<span class='btn btn-primary btn-file' id='otroboton'  onclick='subirImg($idobjetivo,1)'>
							// 	 <i class='fas fa-paperclip'></i>
							// </span>";
							// }


				$tabla.="<span class='btn btn-primary btn-file'>
				<i class='fas fa-paperclip'></i>

				<form enctype='multipart/form-data' id='form_evidencia_{$dato['id_objetivo']}' >
				<input type='file' id='imgIni' name='arch1'
				onchange='cargarEvidencia({$dato['id_objetivo']}, {$dato['id_tprioritario']}, this)' accept='application/pdf, image/*' multiple data-toggle='tooltip' data-placement='top' title='Guarda la evidencia al inicio de su objetivo'>
				</form>
				</span>
				</div>
				</td>

				<td>
				<div class='text-center'>

				<div style='margin-bottom: 10px;'>";
				if($tipou_pemc==""){
					$tabla.="<button type='button' value='Quack_2' class='btn btn-sm cerrar'
					onclick='eliminaEvidenciaFin({$dato['id_objetivo']}, this)'>
					<i class='fas fa-times-circle'></i>
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


							// if (($dato['path_ev_fin']) != 'evidencias_rm/4237/8183/iron.jpg') {
							// 	$tabla.= "<span class='btn btn-primary btn-file' id='otroboton'  onclick='subirImg($idobjetivo,2)'>
							// 	 <i class='fas fa-paperclip'></i>
							// </span>";
							// }


				$tabla .= "<span class='btn btn-primary btn-file'>
				<i class='fas fa-paperclip'></i>
				<form enctype='multipart/form-data' id='form_evidencia_fin_{$dato['id_objetivo']}'>
				<input type='file' id='imgFin' name='arch2' onchange='cargarEvidenciaFin({$dato['id_objetivo']}, {$dato['id_tprioritario']}, this)'  accept='application/pdf, image/*' multiple data-toggle='tooltip' data-placement='top' title='Guarda la evidencial al final de su objetivo'>
				</form>
				</span>
				</div>
				</td>
				</tr>";

			}

			$tabla .= "</tbody></table>";
		}

		$response = array('table' => $tabla, 'id_objetivo' => $idobjetivo);

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
		// foreach ($datos as $dato) {
			// $option .="<option value='{$dato['id_indicador']}'>{$dato['formula']}</option>";
			// $option .="<option value=''>{$dato['formula']}</option>";
		$option .="<option value=''>% Porcentaje</option>";
		$option .="<option value=''># Cantidad</option>";
		// }

		$response = array('stroption' => $option);

		Utilerias::enviaDataJson(200, $response, $this);
		exit;

	}

	public function grabarTema(){
		$this->cct = Utilerias::get_cct_sesion($this);
		// echo "<pre>";print_r($_POST);print_r($_FILES);die();
		$id_cct = $this->cct[0]['id_cct'];

		$id_tprioritario = $this->input->post('id_tprioritario');
		$problematica = $this->input->post('problematica');
		$evidencia = $this->input->post('evidencias');
		$comentario_dir = $this->input->post('txt_rm_obs_direc');


		$estatus = $this->Rutamejora_model->grabarTema($id_cct, $id_tprioritario, $problematica, $evidencia, $comentario_dir);


		$estatus = true;

		$response = array('estatus' => $estatus);

		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function btnEditar(){
		$id_objetivo = $this->input->post('id_objetivo');
		$id_tprioritario = $this->input->post('id_tprioritario'); // este dato no viene

		$datos_aux = $this->Rutamejora_model->getObjetivo($id_objetivo);
		$datos = $datos_aux[0];
// echo "<pre>";print_r($datos); die();

		$response = array('datos' => $datos);

		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function btnEliminar(){
		$id_objetivo = $this->input->post('id_objetivo');

		// echo $id_objetivo;die();
		$datos = $this->Rutamejora_model->borrarObjetivo($id_objetivo);

		$response = array('datos' => $datos);

		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	//Edicion/incerción de datos
	public function get_datos_edith_tp(){
		if(Utilerias::haySesionAbiertacct($this)){
			//echo "<pre>";
			//print_r($_POST);
			//die();
			$this->cct = Utilerias::get_cct_sesion($this);
			$id_tprioritario = $this->input->post('id_tprioritario');
			$titulo = $this->input->post('txttp');
			$id_prioritario = $this->input->post('id_prioritario');

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

			// echo "<pre>";
			// print_r($_POST);
			// die();
			$result_prioridades = $this->Prioridad_model->get_prioridadesxnivel($this->cct[0]['nivel']);
			$datos = $this->Rutamejora_model->edith_tp($id_tprioritario);

			// echo "<pre>";print_r($datos);die();

			$data['prioridad'] = $datos[0]['id_prioridad'];
			$data['subprioridad'] = $datos[0]['id_subprioridad'];
			$data['problematica'] = $datos[0]['otro_problematica'];
			$data['evidencia'] = $datos[0]['otro_evidencia'];
			$data['director'] = $datos[0]['obs_direc'];
			$data['supervisor'] = $datos[0]['obs_supervisor'];
			// $data['path'] = $datos[0]['path_evidencia'];
			$data['t_objetivos'] = "tabla";
			$data['prioridades'] = $result_prioridades;
			$data['idtemaprioritario'] = $id_tprioritario;
			$data['nivel_escolar'] = $id_nivel;
			$indicadores = $this->Rutamejora_model->getIndicadorEspecial($data['prioridad'], $id_nivel, $data['subprioridad']);
			$data['indicadores'] = $indicadores;

			$datos = $this->Rutamejora_model->getSubprioridad($datos[0]['id_prioridad']);
			$data['subprioridades'] = $datos;

			$strView = $this->load->view("ruta/modals_new/modal_prioridad", $data, TRUE);

			// $head = 'DOCUMENTAR LA PROBLEMÁTICA: ';
			$head = $titulo;

			$response = array('strView' => $strView, 'titulo' => $head, 'data'=>$data);
			Utilerias::enviaDataJson(200, $response, $this);
			exit;
		}else{
			redirect('Rutademejora/index');
		}
	}

	public function cargarEvidencia($id_objetivo, $id_tprioritario){
		// echo "<pre>";print_r($_FILES);die();
		// echo "<pre>";print_r($id_objetivo);echo "<br>"; print_r($id_tprioritario);die();

		$nombre_archivo = str_replace(" ", "_", $_FILES['arch1']['name']);
		// echo "<pre>";print_r($nombre_archivo);die();
		$this->cct = Utilerias::get_cct_sesion($this);
		$id_cct = $this->cct[0]['id_cct'];

		if ( $nombre_archivo != '' ) {
			$ruta_archivos = "evidencias_rm/{$id_cct}/{$id_tprioritario}/{$id_objetivo}";
			$ruta_archivos_save = "evidencias_rm/{$id_cct}/{$id_tprioritario}/{$id_objetivo}/$nombre_archivo";
			// echo "<pre>";print_r($ruta_archivos_save);die();
			$ev_obj = $this->Rutamejora_model->evidenciaObjInicio($id_objetivo, $id_cct, $ruta_archivos_save, $id_tprioritario);
			// echo "<pre>";print_r($ev_obj);die();

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
		// echo "<pre>";print_r($_FILES);die();
		// echo "<pre>";print_r($id_objetivo);echo "<br>"; print_r($id_tprioritario);die();
		$nombre_archivo = str_replace(" ", "_", $_FILES['arch2']['name']);
		// echo "<pre>";print_r($nombre_archivo);die();
		$this->cct = Utilerias::get_cct_sesion($this);
		$id_cct = $this->cct[0]['id_cct'];

		if ( $nombre_archivo != '' ) {
			$ruta_archivos = "evidencias_rm/{$id_cct}/{$id_tprioritario}/{$id_objetivo}";
			$ruta_archivos_save = "evidencias_rm/{$id_cct}/{$id_tprioritario}/{$id_objetivo}/$nombre_archivo";
			// echo "<pre>";print_r($ruta_archivos_save);die();
			$ev_obj = $this->Rutamejora_model->evidenciaObjFin($id_objetivo, $id_cct, $ruta_archivos_save, $id_tprioritario);
			// echo "<pre>";print_r($ev_obj);die();

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
		// echo"<pre>";print_r($path_archivo);die();

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
		// echo"<pre>";print_r($path_archivo);die();

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
		// echo "<pre>";print_r($id_objetivo);die();
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

	function getTablaAccxObj($id_objetivo){
		// echo "<pre>";print_r($id_objetivo);die();
		$acciones = $this->Rutamejora_model->getAccxObj($id_objetivo);

		// $tabla = "<div class='table-responsive'>
		// <table id='idtabla_accionestp' class='table table-condensed table-hover  table-bordered'>
		// <thead>
		// <tr class=info>
		// <th id='orden' style='width:4%' hidden><center>Id accion</center></th>
		// <th id='evidencias' style='width:39%; vertical-align: middle;'><center>Actividad</center></th>
		// <th id='evidencias' style='width:39%; vertical-align: middle;'><center>Recursos</center></th>
		// <th id='tema' style='width:20%'><center>Fecha de inicio</center></th>
		// <th id='problemas' style='width:31%'><center>Fecha de término</center></th>
		// </tr>
		// </thead>
		// <tbody>";
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
		//echo "<pre>"; print_r($publicar); die();

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
		if(Utilerias::haySesionAbiertacct($this)){
			$id_cct = $this->input->post('id_cct');
  			$datos=$this->Rutamejora_model->avancesxcctxaccion($id_cct);
  			$response = array('datos' => $datos);
			Utilerias::enviaDataJson(200, $response, $this);
			exit;
		}
	}

	public function pieAccion(){
		if(Utilerias::haySesionAbiertacct($this)){
			$id_cct = $this->input->post('id_cct');
  			$datos=$this->Rutamejora_model->pieAccion($id_cct);
  			$response = array('datos' => $datos);
			Utilerias::enviaDataJson(200, $response, $this);
			exit;
		}
	}

	public function pieObjetivos(){
		if(Utilerias::haySesionAbiertacct($this)){
			$id_cct = $this->input->post('id_cct');
  			$datos=$this->Rutamejora_model->pieObjetivos($id_cct);
  			$response = array('datos' => $datos);
			Utilerias::enviaDataJson(200, $response, $this);
			exit;
		}
	}

	public function pieLAE(){
		if(Utilerias::haySesionAbiertacct($this)){
			$id_cct = $this->input->post('id_cct');
  			$datos=$this->Rutamejora_model->pieLAE($id_cct);
  			$response = array('datos' => $datos);
			Utilerias::enviaDataJson(200, $response, $this);
			exit;
		}
	}

}// Rutamedejora
