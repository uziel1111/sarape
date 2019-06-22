<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Info extends CI_Controller {

		function __construct() {
			parent::__construct();
			$this->load->library('Utilerias');
			$this->load->model('Info_model');
			$this->load->model('Estadistica_e_indicadores_xcct_model');
			$this->load->model('Escuela_model');
			$this->load->model('Planeaxescuela_model');
			$this->load->model('Planeaxestado_model');
			$this->load->model('Planea_nacionalxnivel_model');
			$this->load->model('Planeaxesc_reactivo_model');
			$this->load->model('Riesgo_alumn_esc_bim_model');
			$this->load->model('Recursos_model');
			$this->load->model('Propuestas_model');
			$this->load->model('Prog_apoyo_xcct_model');
		}

	public function index(){
		$id_cct = $this->input->post("id_cct");
		if(isset($id_cct) && $id_cct != ""){
			$data = array();
			$escuela = $this->Info_model->get_info_escuela($id_cct);
			// echo "<pre>";print_r($id_cct);die();
			$planea15_escuela = $this->Planeaxescuela_model->get_planea_xidcct($id_cct,'2015');
			$planea16_escuela = $this->Planeaxescuela_model->get_planea_xidcct($id_cct,'2016');
			$planea17_escuela = $this->Planeaxescuela_model->get_planea_xidcct($id_cct,'2017');
			$planea18_escuela = $this->Planeaxescuela_model->get_planea_xidcct($id_cct,'2018');
			$planea18_escuela = $this->Planeaxescuela_model->get_planea_xidcct($id_cct,'2019');

			$planea15_estado = $this->Planeaxestado_model->get_planea_xest($escuela[0]['nivel'],'2015');
			$planea16_estado = $this->Planeaxestado_model->get_planea_xest($escuela[0]['nivel'],'2016');
			$planea17_estado = $this->Planeaxestado_model->get_planea_xest($escuela[0]['nivel'],'2017');
			$planea18_estado = $this->Planeaxestado_model->get_planea_xest($escuela[0]['nivel'],'2018');
			$planea18_estado = $this->Planeaxestado_model->get_planea_xest($escuela[0]['nivel'],'2019');

			$planea15_nacional = $this->Planea_nacionalxnivel_model->get_planea_xnac($escuela[0]['nivel'],'14_15');
			$planea16_nacional = $this->Planea_nacionalxnivel_model->get_planea_xnac($escuela[0]['nivel'],'15_16');
			$planea17_nacional = $this->Planea_nacionalxnivel_model->get_planea_xnac($escuela[0]['nivel'],'16_17');
			$planea18_nacional = $this->Planea_nacionalxnivel_model->get_planea_xnac($escuela[0]['nivel'],'17_18');
			$planea18_nacional = $this->Planea_nacionalxnivel_model->get_planea_xnac($escuela[0]['nivel'],'18_19');

			$contenidos = $this->Recursos_model->get_tipo_contenidos();
			$arr_contenidos = array();
			$arr_contenidos[0] = "SELECCIONE";
			foreach ($contenidos as $contenido){
				 $arr_contenidos[$contenido['idtipo']] = $contenido['tipo'];
			}

			$data['contenidos'] = $arr_contenidos;
			// $data['trae_indicpeso'] = COUNT($this->Escuela_model->get_indicpeso_xidcct($id_cct,4));
			$arr_peso = $this->Escuela_model->get_indicpeso_xidcct($id_cct,4);
			if (COUNT($arr_peso)==1) {
				$data['trae_indicpeso'] = $arr_peso[0]['bajo']+$arr_peso[0]['Normal']+$arr_peso[0]['Sobrepeso']+$arr_peso[0]['Obesidad'];
			}
			else {
				$data['trae_indicpeso'] = 0;
			}
			// echo "<pre>";print_r($arr_peso[0]['bajo']+$arr_peso[0]['Normal']+$arr_peso[0]['Sobrepeso']+$arr_peso[0]['Obesidad']);die();
			// echo "<pre>";print_r($planea17_estado);die();
			$data['id_cct'] = $id_cct;
			$data['planea15_escuela'] = $planea15_escuela;
			$data['planea16_escuela'] = $planea16_escuela;
			$data['planea17_escuela'] = $planea17_escuela;
			$data['planea18_escuela'] = $planea18_escuela;
			$data['planea15_estado'] = $planea15_estado;
			$data['planea16_estado'] = $planea16_estado;
			$data['planea17_estado'] = $planea17_estado;
			$data['planea18_estado'] = $planea18_estado;
			$data['planea15_nacional'] = $planea15_nacional;
			$data['planea16_nacional'] = $planea16_nacional;
			$data['planea17_nacional'] = $planea17_nacional;
			$data['planea18_nacional'] = $planea18_nacional;
			$data['nombre_centro'] = $escuela[0]['nombre_centro'];
			$data['cve_centro'] = $escuela[0]['cve_centro'];
			$data['turno'] = $escuela[0]['turno_single'];
			$data['nivel'] = $escuela[0]['nivel'];
			$data['modalidad'] = $escuela[0]['modalidad'];
			$data['sostenimiento'] = $escuela[0]['sostenimiento'];
			$data['region'] = $escuela[0]['region'];
			$data['domicilio'] = $escuela[0]['domicilio'];
			$data['localidad'] = $escuela[0]['localidad'];
			$data['municipio'] = $escuela[0]['municipio'];
			$data['nombre_director'] = $escuela[0]['nombre_director'];
			$data['estatus'] = $escuela[0]['estatus'];
			Utilerias::pagina_basica($this, "info/index", $data);
		}

	}
	public function info_graficas(){
		$id_cct = $this->input->post("id_cct");

		$estadis_alumnos_escuela = $this->Estadistica_e_indicadores_xcct_model->get_nalumnos_xesc($id_cct);
		$estadis_docentes_escuela = $this->Estadistica_e_indicadores_xcct_model->get_ndocentes_xesc($id_cct);
		$estadis_grupos_escuela = $this->Estadistica_e_indicadores_xcct_model->get_ngrupos_xesc($id_cct);
		$nivel = $this->Escuela_model->get_nivel_xidcct($id_cct);

		$planea15_escuela = $this->Planeaxescuela_model->get_planea_xidcct($id_cct,'2015');
		$planea16_escuela = $this->Planeaxescuela_model->get_planea_xidcct($id_cct,'2016');
		$planea17_escuela = $this->Planeaxescuela_model->get_planea_xidcct($id_cct,'2017');
		$planea18_escuela = $this->Planeaxescuela_model->get_planea_xidcct($id_cct,'2018');

		$graph_cont_tema_lyc = $this->Planeaxesc_reactivo_model->get_planea_xconttem_reac($id_cct,1,2);
		$graph_cont_tema_mate = $this->Planeaxesc_reactivo_model->get_planea_xconttem_reac($id_cct,1,1);

		// $graph_pie_riesgo = $this->Riesgo_alumn_esc_bim_model->get_riesgo_pie_xidct($id_cct,1,"2017-2018");
		// $graph_bar_riesgo = $this->Riesgo_alumn_esc_bim_model->get_riesgo_bar_grados_xidct($id_cct,1,"2017-2018");
		// echo "<pre>";print_r($graph_bar_riesgo);die();

		// echo "<pre>";print_r($graph_cont_tema_lyc);die();
		$response = array(
			'id_cct'=>$id_cct,
			'nivel'=>$nivel,
			'estadis_alumnos_escuela'=>$estadis_alumnos_escuela,
			'estadis_docentes_escuela'=>$estadis_docentes_escuela,
			'estadis_grupos_escuela'=>$estadis_grupos_escuela,
			'planea15_escuela'=>$planea15_escuela,
			'planea16_escuela'=>$planea16_escuela,
			'planea17_escuela'=>$planea17_escuela,
			'planea18_escuela'=>$planea18_escuela,
			'graph_cont_tema_lyc'=>$graph_cont_tema_lyc,
			'graph_cont_tema_mate'=>$graph_cont_tema_mate
		);

		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}



	public function info_xcont_xcct(){
		$id_cont = $this->input->post("id_cont");
		$id_cct = $this->input->post("id_cct");
		$periodo = $this->input->post("periodo");
		$nombre = $this->input->post("nombre");
		$idcampodis = $this->input->post("idcampodis");

		$graph_cont_reactivos_xcctxcont = $this->Planeaxesc_reactivo_model->get_reactivos_xcctxcont($id_cct,$id_cont,$periodo,$idcampodis,$nombre);
		// echo "<pre>";print_r($graph_cont_reactivos_xcctxcont);die();
		/*
		$response = array(
			'graph_cont_reactivos_xcctxcont'=>$graph_cont_reactivos_xcctxcont
		);
		*/
		
		
		$data['graph_cont_reactivos_xcctxcont'] = $graph_cont_reactivos_xcctxcont;
		$data['periodo'] = $periodo;
		$data['nombre']=$nombre;

		$str_view = $this->load->view("info/visor_reactivos", $data, TRUE);

		$response = array(
			'str_view'=>$str_view,
			'longitud' =>count($graph_cont_reactivos_xcctxcont)
		);
		
		// echo $str_view;
		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function apoyos_academxid_reac(){
		$id_reactivo = $this->input->post("id_reactivo");

		$arr_apoyosacade_xidreact = $this->Planeaxesc_reactivo_model->get_apoyos_academ_xidreact($id_reactivo);
		// echo "<pre>";print_r($arr_apoyosacade_xidreact);die();
		$response = array(
			'arr_apoyosacade_xidreact'=>$arr_apoyosacade_xidreact
		);

		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	// public function propmapoyo(){
	// 	$id_reactivo = $this->input->post("id_reactivo");
	//
	// 	// $arr_apoyosacade_xidreact = $this->Planeaxesc_reactivo_model->get_apoyos_academ_xidreact($id_reactivo);
	// 	// echo "<pre>";print_r($arr_apoyosacade_xidreact);die();
	// 	$contenidos = $this->Recursos_model->get_tipo_contenidos();
	// 	$arr_contenidos = array();
	// 	$arr_contenidos[0] = "SELECCIONE";
	// 	foreach ($contenidos as $contenido){
	// 		 $arr_contenidos[$contenido['idtipo']] = $contenido['tipo'];
	// 	}
	//
	// 	$data['contenidos'] = $arr_contenidos;
	//
	// 	Utilerias::pagina_basica_panel($this, "info/modalprop_material", $data);
	// }

	public function info_riesgo_graf(){
		$id_cct = $this->input->post("id_cct");
		$id_bim = $this->input->post("id_bim");
		$ciclo = $this->input->post("ciclo");

		$nivel = $this->Escuela_model->get_nivel_xidcct($id_cct);
		// echo "<pre>";
		// print_r($nivel);
		// die();
		if($nivel == 4 || $nivel == 5){
			$graph_pie_riesgo = $this->Riesgo_alumn_esc_bim_model->get_riesgo_pie_xidct($id_cct,$id_bim,$ciclo, $nivel);
			$graph_bar_riesgo = $this->Riesgo_alumn_esc_bim_model->get_riesgo_bar_grados_xidct($id_cct,$id_bim,$ciclo, $nivel);
			$numero_bajas = $this->Riesgo_alumn_esc_bim_model->get_numero_bajas($id_cct, $nivel, $id_bim);

			$response = array(
				'id_cct'=>$id_cct,
				'nivel'=>$nivel,
				'graph_pie_riesgo'=>$graph_pie_riesgo,
				'graph_bar_riesgo'=>$graph_bar_riesgo,
				'numero_bajas'=>$numero_bajas
			);
		}else{
			$response = array(
				'id_cct'=>$id_cct,
				'nivel'=>$nivel,
				'graph_pie_riesgo'=>array(),
				'graph_bar_riesgo'=>array(),
				'numero_bajas'=>array()
			);
		}


		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function info_estadistica_graf(){
		$id_cct = $this->input->post("id_cct");

		$estadis_alumnos_escuela = $this->Estadistica_e_indicadores_xcct_model->get_nalumnos_xesc($id_cct);
		$estadis_docentes_escuela = $this->Estadistica_e_indicadores_xcct_model->get_ndocentes_xesc($id_cct);
		$estadis_grupos_escuela = $this->Estadistica_e_indicadores_xcct_model->get_ngrupos_xesc($id_cct);
		$nivel = $this->Escuela_model->get_nivel_xidcct($id_cct);

		$response = array(
			'id_cct'=>$id_cct,
			'nivel'=>$nivel,
			'estadis_alumnos_escuela'=>$estadis_alumnos_escuela,
			'estadis_docentes_escuela'=>$estadis_docentes_escuela,
			'estadis_grupos_escuela'=>$estadis_grupos_escuela
		);

		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function get_indice_peso(){
		$id_cct = $this->input->post("id_cct");

		$arr_indi_peso = $this->Escuela_model->get_indicpeso_xidcct($id_cct,4);
		// echo "<pre>";print_r($arr_indi_peso);die();
    $data['arr_indi_peso'] = $arr_indi_peso;
    $dom = $this->load->view("indice_peso/index",$data,TRUE);


		$response = array(
			'dom_view_indice_peso'=>$dom
		);

		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function info_indica_asis(){
		$id_cct = $this->input->post("id_cct");

		$nivel = $this->Escuela_model->get_nivel_xidcct($id_cct);
		if ($nivel == '4') {
			$indica_asisten = $this->Estadistica_e_indicadores_xcct_model->get_ind_asistenciaxcct($id_cct,1,1);
		}
		elseif ($nivel == '5' || $nivel == '6') {
			$indica_asisten = $this->Estadistica_e_indicadores_xcct_model->get_ind_asistenciaxcct($id_cct,1,1);
		}

		$response = array(
			'id_cct'=>$id_cct,
			'nivel'=>$nivel,
			'indica_asisten'=>$indica_asisten
		);

		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function info_indica_perma(){
		$id_cct = $this->input->post("id_cct");

		$nivel = $this->Escuela_model->get_nivel_xidcct($id_cct);

		if ($nivel == '4') {
				$indica_perma = $this->Estadistica_e_indicadores_xcct_model->get_ind_permananciaxcct($id_cct,2,1);
		}
		elseif ($nivel == '5' || $nivel == '6') {
				$indica_perma = $this->Estadistica_e_indicadores_xcct_model->get_ind_permananciaxcct($id_cct,2,1);
		}

		$response = array(
			'id_cct'=>$id_cct,
			'nivel'=>$nivel,
			'indica_perma'=>$indica_perma
		);

		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function info_prog_apoyo(){
		$id_cct = $this->input->post("id_cct");

		$progs = $this->Prog_apoyo_xcct_model->get_prog_apoyo_xcct($id_cct);


		$response = array(
			'programs'=>$progs
		);

		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function info_ete(){
		$id_cct = $this->input->post("id_cct");

		$nivel = $this->Escuela_model->get_nivel_xidcct($id_cct);
		if ($nivel == '4') {
			$indica_efi = $this->Estadistica_e_indicadores_xcct_model->get_ind_efixcct($id_cct,2,3);
			$indica_planea_superai = $this->Planeaxescuela_model->get_planeaarribai_xidcct($id_cct,2016);
		}
		elseif ($nivel == '5' || $nivel == '6') {
			$indica_efi = $this->Estadistica_e_indicadores_xcct_model->get_ind_efixcct($id_cct,2,1);
			$indica_planea_superai = $this->Planeaxescuela_model->get_planeaarribai_xidcct($id_cct,2017);
		}

		if (empty($indica_efi) || empty($indica_planea_superai)) {
			$ete=0;
		}
		else {
			if ($indica_planea_superai[0]['lyc']>$indica_planea_superai[0]['mat']) {
				$ete = round(($indica_planea_superai[0]['mat']*($indica_efi[0]['et']))/(100),2);
			}
			else {
				$ete = round(($indica_planea_superai[0]['lyc']*($indica_efi[0]['et']))/(100),2);
			}
		}



		$response = array(
			'id_cct'=>$id_cct,
			'nivel'=>$nivel,
			'ete'=>$ete
		);

		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function info_plaea_graf(){
		$id_cct = $this->input->post("id_cct");
		$nivel = $this->Escuela_model->get_nivel_xidcct($id_cct);

		$planea15_escuela = $this->Planeaxescuela_model->get_planea_xidcct($id_cct,'2015');
		$planea16_escuela = $this->Planeaxescuela_model->get_planea_xidcct($id_cct,'2016');
		$planea17_escuela = $this->Planeaxescuela_model->get_planea_xidcct($id_cct,'2017');
		$planea18_escuela = $this->Planeaxescuela_model->get_planea_xidcct($id_cct,'2018');
		if ($nivel==4) {
			$graph_cont_tema_lyc = $this->Planeaxesc_reactivo_model->get_planea_xconttem_reac($id_cct,3,1);
			$graph_cont_tema_mate = $this->Planeaxesc_reactivo_model->get_planea_xconttem_reac($id_cct,3,2);
		}
		elseif ($nivel==5) {
			$graph_cont_tema_lyc = $this->Planeaxesc_reactivo_model->get_planea_xconttem_reac($id_cct,2,1);
			$graph_cont_tema_mate = $this->Planeaxesc_reactivo_model->get_planea_xconttem_reac($id_cct,2,2);
		}
		elseif ($nivel==6) {
			$graph_cont_tema_lyc = $this->Planeaxesc_reactivo_model->get_planea_xconttem_reac($id_cct,2,1);
			$graph_cont_tema_mate = $this->Planeaxesc_reactivo_model->get_planea_xconttem_reac($id_cct,2,2);
		}



		$response = array(
			'id_cct'=>$id_cct,
			'nivel'=>$nivel,
			'planea15_escuela'=>$planea15_escuela,
			'planea16_escuela'=>$planea16_escuela,
			'planea17_escuela'=>$planea17_escuela,
			'planea18_escuela'=>$planea18_escuela,
			'graph_cont_tema_lyc'=>$graph_cont_tema_lyc,
			'graph_cont_tema_mate'=>$graph_cont_tema_mate
		);

		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function set_file(){
			$id_reactivo = $this->input->post('idreactivo');
			$idtipo = $this->input->post('tipo');
			$titulo = $this->input->post('titulo');
			$fuente = $this->input->post('fuentefile');
			$carpeta = ($idtipo == "1")?"pdf":"img";
			$ruta_archivos = "propuestas/{$id_reactivo}/{$carpeta}/";
			$nombre_archivo = str_replace(" ", "_", $_FILES['archivo']['name']);
			$ruta_archivos_save = "propuestas/{$id_reactivo}/{$carpeta}/$nombre_archivo";

			$insert = $this->Propuestas_model->inserta_url($id_reactivo, $ruta_archivos_save, $idtipo, $titulo, $fuente);

			if(!is_dir($ruta_archivos)){
				mkdir($ruta_archivos, 0777, true);}
															$_FILES['userFile']['name']     = $_FILES['archivo']['name'];
															$_FILES['userFile']['type']     = $_FILES['archivo']['type'];
															$_FILES['userFile']['tmp_name'] = $_FILES['archivo']['tmp_name'];
															$_FILES['userFile']['error']    = $_FILES['archivo']['error'];
															$_FILES['userFile']['size']     = $_FILES['archivo']['size'];

															$uploadPath              = $ruta_archivos;
															$config['upload_path']   = $uploadPath;
															$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';

															$this->load->library('upload', $config);
															$this->upload->initialize($config);
															if ($this->upload->do_upload('userFile')) {
																	$fileData = $this->upload->data();
																	$str_view = true;
															}

			$response = array('str_view' => $str_view);
			Utilerias::enviaDataJson(200, $response, $this);
			exit;

	}

	public function envia_url(){
			$id_reactivo = $this->input->post('id_reactivo');
			$url = $this->input->post('url');
			$idtipo = $this->input->post('tipo');
			$titulo = $this->input->post('titulo');
			$fuente = $this->input->post('fuenteurlvideo');

			$insert = $this->Propuestas_model->inserta_url($id_reactivo, $url, $idtipo, $titulo, $fuente);
			if($insert){
				$response = array('response' => "Se guardo correctamente");
				Utilerias::enviaDataJson(200, $response, $this);
				exit;
			}

	}

	public function get_nprop(){
			$id_reactivo = $this->input->post('id_reactivo');

			$n_prop = $this->Propuestas_model->n_propxreact($id_reactivo);

				$response = array('n_prop' => $n_prop);
				Utilerias::enviaDataJson(200, $response, $this);
				exit;


	}


}// Mapa
