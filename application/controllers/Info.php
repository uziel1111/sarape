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
			$this->load->model('CentrosE_model');
		}

	public function index(){
		$turno = $this->input->post("turno");
		$turno_single = $this->input->post("turno_single");
		$cct= $this->input->post("id_cct");

		if(strlen($cct)>10){
			$cadena=substr ($cct ,0 , 10);
			$cadena2=substr ($cct ,10 ,3);
			$cadena3=substr ($cct ,13);
			$cct=$cadena;
			$turno=$cadena2;
			$turno_single=$cadena3;
		}else{
			$cct=$cct;

		}

		$turno_e=$this->getTurno($turno_single);
		if(isset($cct) && $cct != ""){
			$data = array();
			$array = array();

			$escuela = $this->CentrosE_model->get_info_escuela($cct,$turno);

			$planea15_escuela = $this->CentrosE_model->get_planea_xidcct($cct,$turno_e,'2015');
			$planea16_escuela = $this->CentrosE_model->get_planea_xidcct($cct,$turno_e,'2016');
			$planea17_escuela = $this->CentrosE_model->get_planea_xidcct($cct,$turno_e,'2017');
			$planea18_escuela = $this->CentrosE_model->get_planea_xidcct($cct,$turno_e,'2018');
			$planea19_escuela = $this->CentrosE_model->get_planea_xidcct($cct,$turno_e,'2019');

			$planea15_estado = $this->Planeaxestado_model->get_planea_xest($escuela[0]['nivel'],'2015');
			$planea16_estado = $this->Planeaxestado_model->get_planea_xest($escuela[0]['nivel'],'2016');
			$planea17_estado = $this->Planeaxestado_model->get_planea_xest($escuela[0]['nivel'],'2017');
			$planea18_estado = $this->Planeaxestado_model->get_planea_xest($escuela[0]['nivel'],'2018');
			$planea19_estado = $this->Planeaxestado_model->get_planea_xest($escuela[0]['nivel'],'2019');

			$planea15_nacional = $this->Planea_nacionalxnivel_model->get_planea_xnac($escuela[0]['nivel'],'14_15');
			$planea16_nacional = $this->Planea_nacionalxnivel_model->get_planea_xnac($escuela[0]['nivel'],'15_16');
			$planea17_nacional = $this->Planea_nacionalxnivel_model->get_planea_xnac($escuela[0]['nivel'],'16_17');
			$planea18_nacional = $this->Planea_nacionalxnivel_model->get_planea_xnac($escuela[0]['nivel'],'17_18');
			$planea19_nacional = $this->Planea_nacionalxnivel_model->get_planea_xnac($escuela[0]['nivel'],'18_19');

			$contenidos = $this->Recursos_model->get_tipo_contenidos();
			$arr_contenidos = array();
			$arr_contenidos[0] = "SELECCIONE";
			foreach ($contenidos as $contenido){
				 $arr_contenidos[$contenido['idtipo']] = $contenido['tipo'];
			}

			$data['contenidos'] = $arr_contenidos;

			$arr_peso = $this->CentrosE_model->get_indicpeso_xidcct($cct,$turno_e,4);
			if (COUNT($arr_peso)==1) {
				$data['trae_indicpeso'] = $arr_peso[0]['bajo']+$arr_peso[0]['Normal']+$arr_peso[0]['Sobrepeso']+$arr_peso[0]['Obesidad'];
			}
			else {
				$data['trae_indicpeso'] = 0;
			}

			$data['planea15_escuela'] = $planea15_escuela;
			$data['planea16_escuela'] = $planea16_escuela;
			$data['planea17_escuela'] = $planea17_escuela;
			$data['planea18_escuela'] = $planea18_escuela;
			$data['planea19_escuela'] = $planea19_escuela;
			$data['planea15_estado'] = $planea15_estado;
			$data['planea16_estado'] = $planea16_estado;
			$data['planea17_estado'] = $planea17_estado;
			$data['planea18_estado'] = $planea18_estado;
			$data['planea19_estado'] = $planea19_estado;
			$data['planea15_nacional'] = $planea15_nacional;
			$data['planea16_nacional'] = $planea16_nacional;
			$data['planea17_nacional'] = $planea17_nacional;
			$data['planea18_nacional'] = $planea18_nacional;
			$data['planea19_nacional'] = $planea19_nacional;
			$data['nombre_centro'] = $escuela[0]['nombre_centro'];
			$data['cve_centro'] = $escuela[0]['cve_centro'];
			if($turno==120 || $turno==123 || $turno==124 || $turno==130 || $turno==230){
				$data['turno'] = $turno_single;
				$data['desc_turno'] = $turno_single;
			}else{
				$data['turno'] = $escuela[0]['turno'];
				$data['desc_turno'] = $this->getTurnoDes($escuela[0]['turno']);
			}

			$data['nivel'] = $escuela[0]['nivel'];
			$data['modalidad'] = $escuela[0]['modalidad'];
			$data['sostenimiento'] = $escuela[0]['desc_sostenimiento'];
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
		$planea19_escuela = $this->Planeaxescuela_model->get_planea_xidcct($id_cct,'2019');

		$graph_cont_tema_lyc = $this->Planeaxesc_reactivo_model->get_planea_xconttem_reac($id_cct,4,2);
		$graph_cont_tema_mate = $this->Planeaxesc_reactivo_model->get_planea_xconttem_reac($id_cct,4,1);

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
			'planea19_escuela'=>$planea19_escuela,
			'graph_cont_tema_lyc'=>$graph_cont_tema_lyc,
			'graph_cont_tema_mate'=>$graph_cont_tema_mate
		);

		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}



	public function info_xcont_xcct(){
		$id_cont = $this->input->post("id_cont");
		$cct = $this->input->post("cct");
		$turno = $this->input->post("turno");
		$nivel_e = $this->input->post("nivel");

		$nivel=$this->getNivel($nivel_e);
		$periodo = $this->input->post("periodo");
		$nombre = $this->input->post("nombre");
		$idcampodis = $this->input->post("idcampodis");

		$graph_cont_reactivos_xcctxcont = $this->Planeaxesc_reactivo_model->get_reactivos_xcctxcont($cct,$turno,$nivel,$id_cont,$periodo,$idcampodis,$nombre);

		$data['graph_cont_reactivos_xcctxcont'] = $graph_cont_reactivos_xcctxcont;
		$data['periodo'] = $periodo;
		$data['nombre']=$nombre;

		$str_view = $this->load->view("info/visor_reactivos", $data, TRUE);

		$response = array(
			'str_view'=>$str_view,
			'longitud' =>count($graph_cont_reactivos_xcctxcont)
		);


		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function apoyos_academxid_reac(){
		$id_reactivo = $this->input->post("id_reactivo");

		$arr_apoyosacade_xidreact = $this->Planeaxesc_reactivo_model->get_apoyos_academ_xidreact($id_reactivo);

		$response = array(
			'arr_apoyosacade_xidreact'=>$arr_apoyosacade_xidreact
		);

		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function info_riesgo_graf(){
		$cct = $this->input->post("cct");
		$turno_e = $this->input->post("turno");
		$nivel_e = $this->input->post("nivel");
		$id_bim = $this->input->post("id_bim");
		$ciclo = $this->input->post("ciclo");

		$nivel=$this->getNivel($nivel_e);
		$turno=$this->getTurno($turno_e);


		if($nivel == 4 || $nivel == 5){
			$graph_pie_riesgo = $this->Riesgo_alumn_esc_bim_model->get_riesgo_pie_xidct($cct,$turno,$id_bim,$ciclo, $nivel);
			$graph_bar_riesgo = $this->Riesgo_alumn_esc_bim_model->get_riesgo_bar_grados_xidct($cct,$turno,$id_bim,$ciclo, $nivel);
			$numero_bajas = $this->Riesgo_alumn_esc_bim_model->get_numero_bajas($cct,$turno, $nivel, $id_bim);

			$response = array(
				'cct'=>$cct,
				'nivel'=>$nivel,
				'graph_pie_riesgo'=>$graph_pie_riesgo,
				'graph_bar_riesgo'=>$graph_bar_riesgo,
				'numero_bajas'=>$numero_bajas
			);
		}else{
			$response = array(
				'cct'=>$cct,
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
		$cct = $this->input->post("cct");
		$turno_e = $this->input->post("turno");
		$nivel_e = $this->input->post("nivel");
		$turno=$this->getTurno($turno_e);

		$nivel=$this->getNivel($nivel_e);

		$estadis_alumnos_escuela = $this->Estadistica_e_indicadores_xcct_model->get_nalumnos_xesc($cct,$turno);
		$estadis_docentes_escuela = $this->Estadistica_e_indicadores_xcct_model->get_ndocentes_xesc($cct,$turno);
		$estadis_grupos_escuela = $this->Estadistica_e_indicadores_xcct_model->get_ngrupos_xesc($cct,$turno);

		$response = array(
			'cct'=>$cct,
			'nivel'=>$nivel,
			'estadis_alumnos_escuela'=>$estadis_alumnos_escuela,
			'estadis_docentes_escuela'=>$estadis_docentes_escuela,
			'estadis_grupos_escuela'=>$estadis_grupos_escuela
		);

		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function get_indice_peso(){
		$cct = $this->input->post("cct");
		$turno_e = $this->input->post("turno");
		$nivel_e = $this->input->post("nivel");
		$nivel=$this->getNivel($nivel_e);
		$turno=$this->getTurno($turno_e);
		$arr_indi_peso = $this->CentrosE_model->get_indicpeso_xidcct($cct,$turno,4);

	    $data['arr_indi_peso'] = $arr_indi_peso;
	    $dom = $this->load->view("indice_peso/index",$data,TRUE);


		$response = array(
			'dom_view_indice_peso'=>$dom
		);

		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function info_indica_asis(){
		$cct = $this->input->post("cct");
		$turno_e = $this->input->post("turno");
		$nivel_e = $this->input->post("nivel");
		$nivel=$this->getNivel($nivel_e);
		$turno=$this->getTurno($turno_e);
		$indica_asisten= array();
		if ($nivel == 4) {
			$indica_asisten = $this->Estadistica_e_indicadores_xcct_model->get_ind_asistenciaxcct($cct,$turno,1,1);
		}
		elseif ($nivel == 5 || $nivel == 6) {
			$indica_asisten = $this->Estadistica_e_indicadores_xcct_model->get_ind_asistenciaxcct($cct,$turno,1,1);
		}

		$response = array(
			'cct'=>$cct,
			'nivel'=>$nivel,
			'indica_asisten'=>$indica_asisten
		);

		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function info_indica_perma(){
		$cct = $this->input->post("cct");
		$turno_e = $this->input->post("turno");
		$nivel_e = $this->input->post("nivel");
		$nivel=$this->getNivel($nivel_e);
		$turno=$this->getTurno($turno_e);

		$indica_perma=array();
		if ($nivel == 4) {
				$indica_perma = $this->Estadistica_e_indicadores_xcct_model->get_ind_permananciaxcct($cct,$turno,2,1);
		}
		elseif ($nivel == 5 || $nivel == 6) {
				$indica_perma = $this->Estadistica_e_indicadores_xcct_model->get_ind_permananciaxcct($cct,$turno,2,1);
		}

		$response = array(
			'cct'=>$cct,
			'nivel'=>$nivel,
			'indica_perma'=>$indica_perma
		);

		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function info_prog_apoyo(){
		$cct = $this->input->post("cct");
		$turno_e = $this->input->post("turno");
		$turno=$this->getTurno($turno_e);
		$progs = $this->Prog_apoyo_xcct_model->get_prog_apoyo_xcct($cct,$turno);


		$response = array(
			'programs'=>$progs
		);

		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function info_ete(){
		$cct = $this->input->post("cct");
		$turno_e = $this->input->post("turno");
		$nivel_e = $this->input->post("nivel");
		$nivel=$this->getNivel($nivel_e);
		$turno=$this->getTurno($turno_e);

		if ($nivel == 4) {
			$indica_efi = $this->Estadistica_e_indicadores_xcct_model->get_ind_efixcct($cct,$turno,2,3);
			$indica_planea_superai = $this->Planeaxescuela_model->get_planeaarribai_xidcct($cct,$turno,2016);
		}
		elseif ($nivel == 5 || $nivel == 6) {
			$indica_efi = $this->Estadistica_e_indicadores_xcct_model->get_ind_efixcct($cct,$turno,2,1);
			$indica_planea_superai = $this->Planeaxescuela_model->get_planeaarribai_xidcct($cct,$turno,2017);
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
			'cct'=>$cct,
			'nivel'=>$nivel,
			'ete'=>$ete
		);

		Utilerias::enviaDataJson(200, $response, $this);
		exit;
	}

	public function getNivel($nivel_e){

		$nivel=0;
		if($nivel_e=='ESPECIAL'){
			$nivel=1;
		}else if($nivel_e=='INICIAL'){
			$nivel=2;
		}else if($nivel_e=='PREESCOLAR'){
			$nivel=3;
		}else if($nivel_e=='PRIMARIA'){
			$nivel=4;
		}else if($nivel_e=='SECUNDARIA'){
			$nivel=5;
		}else if($nivel_e=='MEDIA SUPERIOR'){
			$nivel=6;
		}else if($nivel_e=='SUPERIOR'){
			$nivel=7;
		}else if($nivel_e=='FORMACION PARA EL TRABAJO'){
			$nivel=8;
		}else if($nivel_e=='OTRO NIVEL EDUCATIVO'){
			$nivel=9;
		}else if($nivel_e=='NO APLICA'){
			$nivel=10;
		}

		return $nivel;
	}

	public function getTurno($turno){
		$id_turno_single=0;
		if($turno=='MATUTINO' || $turno==100){
	        $id_turno_single=1;
	    }else if($turno=='VESPERTINO' || $turno==200){
	        $id_turno_single=2;
	    }else if($turno=='NOCTURNO' || $turno==300){
	        $id_turno_single=3;
	    }else if($turno=='DISCONTINUO' || $turno==400){
	        $id_turno_single=4;
	    }else if($turno=="CONTINUO" || $turno==500){
	        $id_turno_single=5;
	    }else if($turno=="COMPLEMENTARIO" || $turno==600){
	        $id_turno_single=6;
	    }else if($turno=="CONTINUO (JORNADA AMPLIADA)" || $turno==700){
	        $id_turno_single=7;
	    }else if($turno=="CONTINUO (DE 7:00 A 22:00 HRS)" || $turno==800){
	        $id_turno_single=8;
	    }

	    return $id_turno_single;
	}

	public function getTurnoDes($turno){
		$turnoDes="";
		if($turno==1 || $turno==100){
	        $turnoDes="MATUTINO";
	    }else if($turno==2 || $turno==200){
	        $turnoDes="VESPERTINO";
	    }else if($turno==3 || $turno==300){
	        $turnoDes="NOCTURNO";
	    }else if($turno==4 || $turno==400){
	        $turnoDes="DISCONTINUO";
	    }else if($turno==5 || $turno==500){
	        $turnoDes="CONTINUO";
	    }else if($turno==6 || $turno==600){
	        $turnoDes="COMPLEMENTARIO";
	    }else if($turno==7 || $turno==700){
	        $turnoDes="CONTINUO (JORNADA AMPLIADA)";
	    }else if($turno==8 || $turno==800){
	        $turnoDes="CONTINUO (DE 7:00 A 22:00 HRS)";
	    }

	    return $turnoDes;
	}

	public function info_plaea_graf(){
		$cct = $this->input->post("cct");
		$turno_e = $this->input->post("turno");
		$nivel_e = $this->input->post("nivel");
		$nivel=$this->getNivel($nivel_e);
		$turno=$this->getTurno($turno_e);


		$planea15_escuela = $this->CentrosE_model->get_planea_xidcct($cct,$turno,'2015');
		$planea16_escuela = $this->CentrosE_model->get_planea_xidcct($cct,$turno,'2016');
		$planea17_escuela = $this->CentrosE_model->get_planea_xidcct($cct,$turno,'2017');
		$planea18_escuela = $this->CentrosE_model->get_planea_xidcct($cct,$turno,'2018');
		$planea19_escuela = $this->CentrosE_model->get_planea_xidcct($cct,$turno,'2019');

		$graph_cont_tema_lyc=array();
		$graph_cont_tema_mate=array();
		if ($nivel==4) {
			$graph_cont_tema_lyc = $this->Planeaxesc_reactivo_model->get_planea_xconttem_reac($cct,$turno,3,1);
			$graph_cont_tema_mate = $this->Planeaxesc_reactivo_model->get_planea_xconttem_reac($cct,$turno,3,2);
		}
		elseif ($nivel==5) {
			$graph_cont_tema_lyc = $this->Planeaxesc_reactivo_model->get_planea_xconttem_reac($cct,$turno,4,1);
			$graph_cont_tema_mate = $this->Planeaxesc_reactivo_model->get_planea_xconttem_reac($cct,$turno,4,2);

		}
		elseif ($nivel==6) {
			$graph_cont_tema_lyc = $this->Planeaxesc_reactivo_model->get_planea_xconttem_reac($cct,$turno,2,1);
			$graph_cont_tema_mate = $this->Planeaxesc_reactivo_model->get_planea_xconttem_reac($cct,$turno,2,2);
		}



		$response = array(
			'cct'=>$cct,
			'turno'=>$turno_e,
			'nivel'=>$nivel,
			'planea15_escuela'=>$planea15_escuela,
			'planea16_escuela'=>$planea16_escuela,
			'planea17_escuela'=>$planea17_escuela,
			'planea18_escuela'=>$planea18_escuela,
			'planea19_escuela'=>$planea19_escuela,
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
