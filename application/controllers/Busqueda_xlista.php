<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Busqueda_xlista extends CI_Controller {

		function __construct() {
			parent::__construct();
			$this->load->library('Utilerias');
			$this->load->model('Municipio_model');
			$this->load->model('Nivel_model');
			$this->load->model('CentrosE_model');
			$this->load->model('Sostenimiento_model');
			$this->load->model('Escuela_model');
		}

		public function index(){
			// $result_municipios = $this->Municipio_model->all();
			$result_municipios = $this->CentrosE_model->municipios();
			// echo "<pre>";
			// print_r($result_municipios);
			// die();
			$arr_municipios = array();
			$arr_sostenimientos = array();
			$arr_niveles = array();

			if(count($result_municipios)==0){
				$data['arr_municipios'] = array(	'-1' => 'Error recuperando los municipios' );
			}else{
				$arr_municipios['-1'] = 'TODOS';
				foreach ($result_municipios as $row){
					 $arr_municipios[$row['id_municipio']] = $row['municipio'];
				}
			}

			// $result_niveles = $this->Nivel_model->all();
			$result_niveles = $this->CentrosE_model->niveles();
			if(count($result_niveles)==0){
				$data['arr_niveles'] = array(	'-1' => 'Error recuperando los niveles' );
			}else{
				$arr_niveles['-1'] = 'TODOS';
				foreach ($result_niveles as $row){
					 $arr_niveles[$row['id_nivel']] = $row['nivel'];
				}
			}

			// $result_sostenimientos = $this->Sostenimiento_model->all();
			$result_sostenimientos = $this->CentrosE_model->sostenimientos();
			// echo "<pre>"; print_r($result_sostenimientos); die();
			if(count($result_sostenimientos)==0){
				$data['arr_sostenimientos'] = array(	'-1' => 'Error recuperando los sostenimientos' );
			}else{
				$arr_sostenimientos['-1'] = 'TODOS';
				foreach ($result_sostenimientos as $row){
					$arr_sostenimientos[$row['id_sostenimiento']] = $row['sostenimiento'];
				}
			}

			$data['arr_municipios'] = $arr_municipios;
			$data['arr_niveles'] = $arr_niveles;
			$data['arr_sostenimientos'] =$arr_sostenimientos;

			Utilerias::pagina_basica($this, "busqueda_xlista/buscador", $data);
		}// index()



		public function escuelas_xmunicipio($var_aux=0){

				$cve_municipio = $this->input->get('slc_busquedalista_municipio');
				$cve_nivel = $this->input->get('slc_busquedalista_nivel');
				$cve_sostenimiento = $this->input->get('slc_busquedalista_sostenimiento');
				$nombre_escuela = $this->input->get('itxt_busquedalista_nombreescuela');
				if($cve_municipio==""){
					$cve_municipio = $this->input->post('slc_busquedalista_municipio');
					$cve_nivel = $this->input->post('slc_busquedalista_nivel');
					$cve_sostenimiento = $this->input->post('slc_busquedalista_sostenimiento');
					$nombre_escuela = $this->input->post('itxt_busquedalista_nombreescuela');
				}

				$data['cve_municipio'] = $cve_municipio;
				$data['cve_nivel'] = $cve_nivel;
				$data['cve_sostenimiento'] = $cve_sostenimiento;
				$data['nombre_escuela'] = $nombre_escuela;

				$municipio = $this->input->get('hidden_municipio');
				$nivel = $this->input->get('hidden_nivel');
				$sostenimiento = $this->input->get('hidden_sostenimiento');


				$array=array();
				$result_escuelas = $this->CentrosE_model->filtro_escuela($cve_municipio,$cve_nivel,$cve_sostenimiento,$nombre_escuela);
						// echo "<pre>"; print_r($result_escuelas); die();
				for($i=0; $i<count($result_escuelas); $i++){
					if($result_escuelas[$i]['turno']==120){
						$result_escuelas[$i]['turno_n']=100;
						$result_escuelas[$i]['turno_single']='MATUTINO';
						array_push($array,$result_escuelas[$i]);
						$result_escuelas[$i]['turno_n']=200;
						$result_escuelas[$i]['turno_single']='VESPERTINO';
						array_push($array,$result_escuelas[$i]);
					}else if($result_escuelas[$i]['turno']==123){
						$result_escuelas[$i]['turno_n']=100;
						$result_escuelas[$i]['turno_single']='MATUTINO';
						array_push($array,$result_escuelas[$i]);
						$result_escuelas[$i]['turno_n']=200;
						$result_escuelas[$i]['turno_single']='VESPERTINO';
						array_push($array,$result_escuelas[$i]);
						$result_escuelas[$i]['turno_n']=300;
						$result_escuelas[$i]['turno_single']='NOCTURNO';
						array_push($array,$result_escuelas[$i]);

					}else if($result_escuelas[$i]['turno']==124){
						$result_escuelas[$i]['turno_n']=100;
						$result_escuelas[$i]['turno_single']='MATUTINO';
						array_push($array,$result_escuelas[$i]);
						$result_escuelas[$i]['turno_n']=200;
						$result_escuelas[$i]['turno_single']='VESPERTINO';
						array_push($array,$result_escuelas[$i]);
						$result_escuelas[$i]['turno_n']=400;
						$result_escuelas[$i]['turno_single']='DISCONTINUO';
						array_push($array,$result_escuelas[$i]);
					}else if($result_escuelas[$i]['turno']==130){
						$result_escuelas[$i]['turno_n']=100;
						$result_escuelas[$i]['turno_single']='MATUTINO';
						array_push($array,$result_escuelas[$i]);
						$result_escuelas[$i]['turno_n']=300;
						$result_escuelas[$i]['turno_single']='NOCTURNO';
						array_push($array,$result_escuelas[$i]);
					}else if($result_escuelas[$i]['turno']==230){
						$result_escuelas[$i]['turno_n']=200;
						$result_escuelas[$i]['turno_single']='VESPERTINO';
						array_push($array,$result_escuelas[$i]);
						$result_escuelas[$i]['turno_n']=300;
						$result_escuelas[$i]['turno_single']='NOCTURNO';
						array_push($array,$result_escuelas[$i]);
					}else{
						$result_escuelas[$i]['turno_n']=$result_escuelas[$i]['turno'];
						$result_escuelas[$i]['turno_single']=$result_escuelas[$i]['desc_turno'];
						array_push($array,$result_escuelas[$i]);
					}
				}

				$data['municipio'] = $municipio;
				$data['nivel'] = $nivel;
				$data['sostenimiento'] = $sostenimiento;
				$data['escuela'] = $nombre_escuela;

				$data['arr_escuelas'] = $array;
				$data['total_escuelas'] = count($result_escuelas);
				// echo "<pre>"; print_r($data); die();
				Utilerias::pagina_basica($this, "busqueda_xlista/escuelas", $data);

		}// escuelas_xmunicipio()

		public function escuelas_xcvecentro(){
			$cve_centro = $this->input->post('cve_centro');
			$cve_centro = '05'.trim($cve_centro);
			// echo "<pre>"; print_r($cve_centro); die();
			$result_escuelas = $this->CentrosE_model->get_xcvecentro($cve_centro);
			// echo "<pre>";
			// print_r($result_escuelas);
			// die();
			$array=array();
			for($i=0; $i<count($result_escuelas); $i++){
					if($result_escuelas[$i]['turno']==120){
						$result_escuelas[$i]['turno_n']=100;
						$result_escuelas[$i]['turno_single']='MATUTINO';
						array_push($array,$result_escuelas[$i]);
						$result_escuelas[$i]['turno_n']=200;
						$result_escuelas[$i]['turno_single']='VESPERTINO';
						array_push($array,$result_escuelas[$i]);
					}else if($result_escuelas[$i]['turno']==123){
						$result_escuelas[$i]['turno_n']=100;
						$result_escuelas[$i]['turno_single']='MATUTINO';
						array_push($array,$result_escuelas[$i]);
						$result_escuelas[$i]['turno_n']=200;
						$result_escuelas[$i]['turno_single']='VESPERTINO';
						array_push($array,$result_escuelas[$i]);
						$result_escuelas[$i]['turno_n']=300;
						$result_escuelas[$i]['turno_single']='NOCTURNO';
						array_push($array,$result_escuelas[$i]);

					}else if($result_escuelas[$i]['turno']==124){
						$result_escuelas[$i]['turno_n']=100;
						$result_escuelas[$i]['turno_single']='MATUTINO';
						array_push($array,$result_escuelas[$i]);
						$result_escuelas[$i]['turno_n']=200;
						$result_escuelas[$i]['turno_single']='VESPERTINO';
						array_push($array,$result_escuelas[$i]);
						$result_escuelas[$i]['turno_n']=400;
						$result_escuelas[$i]['turno_single']='DISCONTINUO';
						array_push($array,$result_escuelas[$i]);
					}else if($result_escuelas[$i]['turno']==130){
						$result_escuelas[$i]['turno_n']=100;
						$result_escuelas[$i]['turno_single']='MATUTINO';
						array_push($array,$result_escuelas[$i]);
						$result_escuelas[$i]['turno_n']=300;
						$result_escuelas[$i]['turno_single']='NOCTURNO';
						array_push($array,$result_escuelas[$i]);
					}else if($result_escuelas[$i]['turno']==230){
						$result_escuelas[$i]['turno_n']=200;
						$result_escuelas[$i]['turno_single']='VESPERTINO';
						array_push($array,$result_escuelas[$i]);
						$result_escuelas[$i]['turno_n']=300;
						$result_escuelas[$i]['turno_single']='NOCTURNO';
						array_push($array,$result_escuelas[$i]);
					}else{
						$result_escuelas[$i]['turno_n']=$result_escuelas[$i]['turno'];
						$result_escuelas[$i]['turno_single']=$result_escuelas[$i]['desc_turno'];
						array_push($array,$result_escuelas[$i]);
					}
				}


			// echo "<pre>"; print_r($array); die();
			$total_escuelas = count($array);

			$cct = 0;
			$turno = 0;
			$turno_single = 0;
			$str_select = '';
			if(count($array)>0){
				foreach ($array as $key => $value) {
					$cct = $value['cct'];
					$turno_single = $value['turno_single'];
					$turno = $value['turno_n'];
					$str_select .= "<option value={$value['cct']}{$value['turno']}{$value['turno_single']}>{$value['cct']}-{$value['turno_n']} - {$value['turno_single']}</option>";
				}
			}
			$response = array(
												'total_escuelas' => $total_escuelas,
												'str_select' => $str_select,
												'cct' => $cct,
												'turno' => $turno,
												'turno_single' => $turno_single
												);
			// echo "<pre>"; print_r($response); die();
			Utilerias::enviaDataJson(200, $response, $this);
			exit;
		}// escuelas_xcvecentro()

}// Busqueda_lista
