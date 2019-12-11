<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Indicepeso extends CI_Controller {

		function __construct() {
			parent::__construct();
			$this->load->library('Utilerias');
			$this->load->model('Nivel_model');
			$this->load->model('Municipio_model');
			$this->load->model('Sostenimiento_model');
			$this->load->model('Ciclo_model');
			$this->load->model('Escuela_model');
			$this->load->model('CentrosE_model');
		}

		public function index(){
			$data = array();
			$result_municipios = $this->Municipio_model->getall_xest_ind();
			if(count($result_municipios)==0){
				$data['arr_municipios'] = array(	'0' => 'Error recuperando los municipios' );
			}else{
				$arr_municipios['0'] = 'TODOS';
				foreach ($result_municipios as $row){
					 $arr_municipios[$row['id_municipio']] = $row['municipio'];
				}
			}

				$arr_niveles['4'] = 'PRIMARIA';
				$arr_niveles['5'] = 'SECUNDARIA';
				$arr_niveles['6'] = 'MEDIA SUPERIOR';

			$result_ciclo = $this->Ciclo_model->ciclo_est_e_ind();
			$arr_ciclo['2'] = '2017-2018';

			$data['arr_niveles'] = $arr_niveles;
			$data['arr_municipios'] = $arr_municipios;
			$data['arr_ciclos'] =$arr_ciclo;
			Utilerias::pagina_basica($this, "indice_peso/estadomunicipio", $data);
		}// getniveles_xcvemunicipio()

		public function get_escuelas(){
			$idmunicipio = $this->input->post("idmunicipio");
			$idnivel = $this->input->post("idnivel");
			$id_ciclo = $this->input->post("idperiodo");
			if($idmunicipio == 0){
				$final = $this->Escuela_model->get_indicpeso_xestado($idnivel, $id_ciclo);
			}else{
				$final = $this->Escuela_model->get_indicpeso_xmuni($idmunicipio, $idnivel, $id_ciclo);
			}
			
			$data['arr_indi_peso'] = $final;
    		$dom = $this->load->view("indice_peso/index",$data,TRUE);

    		$response = array(
				'dom_view_indice_peso'=>$dom
			);

			Utilerias::enviaDataJson(200, $response, $this);
			exit;
		}


}// Catalogos
