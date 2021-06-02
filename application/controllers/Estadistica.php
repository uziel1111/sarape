<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estadistica extends CI_Controller {

		function __construct() {
			parent::__construct();
			$this->load->library('Utilerias');
			$this->load->model('Municipio_model');
			$this->load->model('Nivel_model');
			$this->load->model('Sostenimiento_model');
			$this->load->model('Modalidad_model');
			$this->load->model('Ciclo_model');
			$this->load->model('Estadistica_e_indicadores_xcct_model');
			$this->load->model('Planeaxmuni_model');
			$this->load->model('Inegixmuni_model');
			$this->load->model('Supervision_model');
			$this->load->model('Indicadoresxmuni_model');
			$this->load->model('Indicadoresxestado_model');

		}

		public function estad_indi_generales($tipo='muni')
		{
			$arr_municipios = array();
			$arr_sostenimientos = array();
			$arr_subsostenimientos = array();
			$arr_modalidad = array();
			$arr_niveles = array();
			$arr_nivelesz = array();
			$arr_ciclo = array();
			//Para estadistica por municipio
			$result_municipios = $this->Municipio_model->getall_xest_ind();
			if(count($result_municipios)==0){
				$data['arr_municipios'] = array(	'0' => 'Error recuperando los municipios' );
			}else{
				$arr_municipios['0'] = 'TODOS';
				foreach ($result_municipios as $row){
					$arr_municipios[$row['id_municipio']] = $row['municipio'];
				}
			}
			$arr_sostenimientos['0'] = 'TODOS';
			$arr_modalidad['0'] = 'TODOS';
			$arr_niveles['0'] = 'TODOS';

			//Para estadistica por zona
			$result_nivelesz = $this->Nivel_model->getall_est_indz();
			if(count($result_nivelesz)==0){
				$data['arr_nivelesz'] = array(	'0' => 'Error recuperando los niveles' );
			}else{
				$arr_nivelesz['0'] = 'SELECCIONE UN NIVEL EDUCATIVO';
				foreach ($result_nivelesz as $row){
					$arr_nivelesz[$row['id_nivel']] = $row['nivel'];
				}
			}
			$arr_subsostenimientos['0'] = 'SELECCIONE SOSTENIMIENTO';
			$arr_nzonae['0'] = 'SELECCIONE UNA ZONA ESCOLAR';

			//Para ambas estasdisticas
			$result_ciclo = $this->Ciclo_model->ciclo_est_e_ind_dispo();
			if(count($result_ciclo)==0){
				$data['$arr_ciclo'] = array(	'0' => 'Error recuperando los ciclo' );
			}else{
				foreach ($result_ciclo as $row){
					$arr_ciclo[$row['id_ciclo']] = $row['ciclo'];
				}
			}
			// $arr_ciclo = array('2018-2019' => '2018-2019','2017-2018' => '2017-2018');

			$data['arr_municipios'] = $arr_municipios;
			$data['arr_niveles'] = $arr_niveles;
			$data['arr_nivelesz'] = $arr_nivelesz;
			$data['arr_sostenimientos'] =$arr_sostenimientos;
			$data['arr_modalidad'] =$arr_modalidad;
			$data['arr_subsostenimientos'] =$arr_subsostenimientos;
			$data['arr_nzonae'] =$arr_nzonae;
			$data['arr_ciclos'] =$arr_ciclo;

			//para estilo del tab seleccionado
			if ($tipo=="zona") {
				$data['tzona'] = 'nav-link nav-link-style-1 active';
				$data['tmuni'] = 'nav-link nav-link-style-1';
			}
			else {
				$data['tmuni'] = 'nav-link nav-link-style-1 active';
				$data['tzona'] = 'nav-link nav-link-style-1';
			}
			Utilerias::pagina_basica($this,"estadistica/estadi_e_indi_gen2", $data);
		}//estad_indi_generales()

		public function estad_indi_generales_getnivel()
		{
			$id_municipio = $this->input->post('id_municipio');
			$arr_niveles = array();
			$result_niveles = $this->Nivel_model->getall_est_indxmuni($id_municipio);
			if(count($result_niveles)==0){
				$data['arr_niveles'] = array(	'0' => 'Error recuperando los niveles' );
			}else{
				$arr_niveles['0'] = 'TODOS';
				foreach ($result_niveles as $row){
					 $arr_niveles[$row['id_nivel']] = $row['nivel'];
				}
			}
			Utilerias::enviaDataJson(200, $arr_niveles, $this);
			exit;
		}//estad_indi_generales_getnivel()

		public function estad_indi_generales_getsost()
		{
			$id_municipio = $this->input->post('id_municipio');
			$id_nivel = $this->input->post('id_nivel');
			$nivel = $this->input->post('nivel');

			$arr_sost = array();
			$result_sost = $this->Sostenimiento_model->getsost_xidmun_idnivel($id_municipio,$nivel);
			if(count($result_sost)==0){
				$data['arr_sost'] = array(	'0' => 'Error recuperando los niveles' );
			}else{
				$arr_sost['0'] = 'TODOS';
				foreach ($result_sost as $row){
					 $arr_sost[$row['id_sostenimiento']] = $row['sostenimiento'];
				}
			}
			Utilerias::enviaDataJson(200, $arr_sost, $this);
			exit;
		}//estad_indi_generales_getsost()

		public function estad_indi_generales_getmodali()
		{
			$id_municipio = $this->input->post('id_municipio');
			$id_nivel = $this->input->post('id_nivel');
			$id_sostenimiento = $this->input->post('id_sostenimiento');
			$sostenimiento = $this->input->post('sostenimiento');
			$nivel = $this->input->post('nivel');

			$arr_modali = array();
			$result_modali = $this->Modalidad_model->getmodali_xidmun_idnivel_idsost($id_municipio,$nivel,$sostenimiento);
			if(count($result_modali)==0){
				$data['arr_modali'] = array(	'0' => 'Error recuperando las modalidades' );
			}else{
				$arr_modali['0'] = 'TODOS';
				foreach ($result_modali as $row){
					$arr_modali[$row['id_modalidad']] = $row['modalidad'];
				}
			}
			Utilerias::enviaDataJson(200, $arr_modali, $this);
			exit;
		}//estad_indi_generales_getmodali()

		public function estad_indi_generales_getsubsost_zona()
		{
			$id_nivel = $this->input->post('id_nivel');
			$nivel = $this->input->post('nivel');
			$arr_subsost = array();

			$result_subsost= $this->Sostenimiento_model->getsost_xidmun_idnivel(0,$nivel);
			if(count($result_subsost)==0){
				$data['arr_subsost'] = array(	'0' => 'Error recuperando subsostenimientos' );
			}else{
				$arr_subsost['0'] = 'SELECCIONE SOSTENIMIENTO';
				foreach ($result_subsost as $row){
					 $arr_subsost[$row['id_sostenimiento']] = $row['sostenimiento'];
				}
			}
			Utilerias::enviaDataJson(200, $arr_subsost, $this);
			exit;
		}//estad_indi_generales_getsubsost_zona()

		public function estad_indi_generales_getzonassubsost_zona()
		{
			$id_nivel = $this->input->post('id_nivel');
			$nivel = $this->input->post('nivel');
			$id_subsost = $this->input->post('id_subsost');
			$sostenimiento = $this->input->post('sostenimiento');
			$arr_nzonae = array();
			$result_nzonae = $this->Supervision_model->getzona_idnivel_xsost($nivel, $sostenimiento);
			if(count($result_nzonae)==0){
				$data['arr_nzonae'] = array(	'0' => 'Error recuperando nuemro de zona escolar' );
			}else{
				$select = "";
				$arr_nzonae['0'] = 'SELECCIONE UNA ZONA ESCOLAR';
				$select .= "<option value = '0'>SELECCIONE UNA ZONA ESCOLAR</option>";
				foreach ($result_nzonae as $row){
					$select .= "<option value = '".$row['id_supervision']."'>".$row['zona_escolar']."</option>";
				}
			}

			$response= array("array" => $select);
			Utilerias::enviaDataJson(200, $response, $this);
			exit;
		}//estad_indi_generales_getzonassubsost_zona()

		public function estad_indi_generales_getcicloxnxsubxz_zona()
		{
			$id_nivel = $this->input->post('id_nivel');
			$id_subsost = $this->input->post('id_subsost');
			$id_zona = $this->input->post('id_zona');
			$nivel=$this->Nivel_model->get_nivel($id_nivel);
// echo "string";die();
			$sostenimiento= $this->Sostenimiento_model->get_sostenimiento($id_subsost);

			$arr_cicloe = array();
			$result_cicloe = $this->Ciclo_model->getciclo_idnivel_xsost_xzona($nivel, $sostenimiento, $id_zona);
			if(count($result_cicloe)==0){
				$data['arr_cicloe'] = array(	'0' => 'Error recuperando nuemro de zona escolar' );
			}else{
				$select = "";
				foreach ($result_cicloe as $row){
					 	$select .= "<option value = '".$row['id_ciclo']."'>".$row['ciclo']."</option>";
				}
			}


			$response= array("array" => $select);
			Utilerias::enviaDataJson(200, $response, $this);
			exit;
		}//estad_indi_generales_getcicloxnxsubxz_zona()

		public function xest_muni_x($tipo="muni"){
			$id_municipio = $this->input->post('id_municipio');
			$id_nivel = $this->input->post('id_nivel');
			$id_sostenimiento = $this->input->post('id_sostenimiento');
			$id_modalidad = $this->input->post('id_modalidad');
			$id_ciclo = $this->input->post('id_ciclo');

			$municipio = $this->input->post('municipio');
			$nivel = $this->input->post('nivel');
			$sostenimiento = $this->input->post('sostenimiento');
			$modalidad = $this->input->post('modalidad');
			$ciclo = $this->input->post('ciclo');

			$data["tipo_busqueda"] = "municipal";
			$data["id_municipio"] = $id_municipio;
			$data["id_nivel"] = $id_nivel;
			$data["id_sostenimiento"] = $id_sostenimiento;
			$data["id_modalidad"] = $id_modalidad;
			$data["id_ciclo"] = $id_ciclo;
			$data["municipio"] = $municipio;
			$data["nivel"] = $nivel;
			$data["sostenimiento"] = $sostenimiento;
			$data["modalidad"] = $modalidad;
			$data["ciclo"] = $ciclo;

			$data["srt_tab_alumnos"] = $this->tabla_alumnos($id_municipio,$id_nivel,$id_sostenimiento,$id_modalidad, $id_ciclo);
			$data["srt_tab_pdocentes"] = $this->tabla_pdocentes($id_municipio,$id_nivel,$id_sostenimiento,$id_modalidad, $id_ciclo);
			$data["srt_tab_infraestructura"] = $this->tabla_infraestructura($id_municipio,$id_nivel,$id_sostenimiento,$id_modalidad, $id_ciclo);
			$data["srt_tab_in_asis"] = $this->tabla_asistencia($id_municipio, $id_ciclo);
			$data["srt_tab_in_perm"] = $this->tabla_permanencia($id_municipio, $id_ciclo);
			$data["srt_tab_planea"] = $this->tabla_planea($id_municipio,$id_nivel,$id_sostenimiento,$id_modalidad, $id_ciclo);
			$data["srt_tab_rezag_inegi"] = $this->tabla_rezinegi($id_municipio,$id_nivel,$id_sostenimiento,$id_modalidad, $id_ciclo);
			$data["srt_tab_analf_inegi"] = $this->tabla_analfinegi($id_municipio,$id_nivel,$id_sostenimiento,$id_modalidad, $id_ciclo);

			$dom = $this->load->view("estadistica/estadi_e_indi_gen_tab2",$data,TRUE);

    		$response = array(
				'vista'=>$dom
			);

			Utilerias::enviaDataJson(200, $response, $this);
			exit;

		}//xest_muni_x

		function tabla_alumnos($id_municipio,$id_nivel,$id_sostenimiento,$id_modalidad, $id_ciclo){
			$result_alumnos = $this->Estadistica_e_indicadores_xcct_model->get_nalumnos_xmunciclo($id_municipio, $id_ciclo);

			$str_html_alumn='<table class="table table-style-1 table-striped table-hover">
          	<thead class="bg-info">
          		<tr>
          			<th rowspan="3" class="text-center align-middle">Nivel educativo</th>
          			<th colspan="21" class="text-center">Alumnos</th>
          		</tr>
          		<tr>
							<th><i class="fa fa-female"></i></th>
									<th><i class="fa fa-male"></i></th>
									<th><i class="fa fa-female"></i><i class="fa fa-male"></i></th>
									<th>1°</th>
									<th>2°</th>
									<th>3°</th>
									<th>4°</th>
									<th>5°</th>
									<th>6°</th>
          		</tr>
          	</thead>
						<tbody>';

			foreach ($result_alumnos as $row){
				if ($row['sostenimiento']=='total' && $row['modalidad']=='total') {
					if ($row['id_nivel']==$id_nivel) {
						$str_html_alumn.='<tr style="background-color:#FF8000" class="parent" id="'.str_replace(' ', '', $row['nivel']).'">';
					}
					else {
						$str_html_alumn.='<tr class="parent" id="'.str_replace(' ', '', $row['nivel']).'">';
					}

					$str_html_alumn.='<td class="pl-1"><img style="width:12px" class="mr-5" src="'.base_url("assets/img/expand-button.svg").'" >'.$row['nivel'].'</td>';
				}
				elseif ($row['sostenimiento']!='total' && $row['modalidad']=='total') {
					if ($row['id_nivel']==$id_nivel && $row['id_sostenimiento']==$id_sostenimiento) {
						$str_html_alumn.='<tr style="background-color:#FAAC58" class="child-'.str_replace(' ', '', $row['nivel']).' child-parent" id="'.str_replace(' ', '', $row['nivel']).$row['sostenimiento'].'">';
					}
					else {
						$str_html_alumn.='<tr class="child-'.str_replace(' ', '', $row['nivel']).' child-parent hide-ini" id="'.str_replace(' ', '', $row['nivel']).$row['sostenimiento'].'">';
					}

					$str_html_alumn.='<td class="pl-4"><img style="width:12px" class="mr-5" src="'.base_url("assets/img/expand-button.svg").'" >'.$row['sostenimiento'].'</td>';
				}
				elseif ($row['sostenimiento']!='total' && $row['modalidad']!='total') {
					if ($row['id_nivel']==$id_nivel && $row['id_sostenimiento']==$id_sostenimiento && $row['id_modalidad']==$id_modalidad) {
						$str_html_alumn.='<tr style="background-color:#F5D0A9" class="nieto-'.str_replace(' ', '', $row['nivel']).$row['sostenimiento'].'  class-hide-'.str_replace(' ', '', $row['nivel']).' ">';
					}
					else {
						$str_html_alumn.='<tr class="nieto-'.str_replace(' ', '', $row['nivel']).$row['sostenimiento'].'  class-hide-'.str_replace(' ', '', $row['nivel']).' hide-ini">';
					}

					$str_html_alumn.='<td class="pl-5">'.$row['modalidad'].'</td>';
				}
				($row['alumn_m_t']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['alumn_m_t']).'</td>';
				($row['alumn_h_t']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['alumn_h_t']).'</td>';
				($row['alumn_t_t']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['alumn_t_t']).'</td>';
				($row['alumn_t_1']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['alumn_t_1']).'</td>';
				($row['alumn_t_2']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['alumn_t_2']).'</td>';
				($row['alumn_t_3']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['alumn_t_3']).'</td>';
				($row['alumn_t_4']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['alumn_t_4']).'</td>';
				($row['alumn_t_5']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['alumn_t_5']).'</td>';
				($row['alumn_t_6']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['alumn_t_6']).'</td>';
			}
			$str_html_alumn.='</tbody>
          			</table>

          			<div class="pie_tabla">
          			        <div id="fuentes_pie">Fuente: SEDU (Formato 911).</div>
          			</div>';

			return $str_html_alumn;
		}//tabla_alumnos()


		function tabla_alumnos_z($id_nivel_z,$id_sostenimiento_z,$id_zona_z,$id_ciclo_z,$nivel,$sostenimiento){
			$result_alumnos = $this->Estadistica_e_indicadores_xcct_model->get_nalumnos_xzona($nivel,$sostenimiento,$id_zona_z,$id_ciclo_z);
			$array=array();
			for($i=0; $i<count($result_alumnos); $i++){
				 array_push($array,array("id_nivel" => $result_alumnos[$i]['id_nivel']
	            ,"nivel" => $result_alumnos[$i]['nivel']
	            ,"id_sostenimiento" => 0
	            ,"sostenimiento" => 'total'
	            ,"id_modalidad" => 0
	            ,"modalidad" => 'total'
	            ,"alumn_m_t" => $result_alumnos[$i]['alumn_m_t']
	            ,"alumn_h_t" => $result_alumnos[$i]['alumn_h_t']
	            ,"alumn_t_t" => $result_alumnos[$i]['alumn_t_t']
	            ,"alumn_t_1" => $result_alumnos[$i]['alumn_t_1']
	            ,"alumn_t_2" => $result_alumnos[$i]['alumn_t_2']
	            ,"alumn_t_3" => $result_alumnos[$i]['alumn_t_3']
	            ,"alumn_t_4" => $result_alumnos[$i]['alumn_t_4']
	            ,"alumn_t_5" => $result_alumnos[$i]['alumn_t_5']
	            ,"alumn_t_6" => $result_alumnos[$i]['alumn_t_6']));

	            array_push($array,array("id_nivel" => $result_alumnos[$i]['id_nivel']
	            ,"nivel" => $result_alumnos[$i]['nivel']
	            ,"id_sostenimiento" => $result_alumnos[$i]['id_sostenimiento']
	            ,"sostenimiento" => $result_alumnos[$i]['sostenimiento']
	            ,"id_modalidad" => 0
	            ,"modalidad" => 'total'
	             ,"alumn_m_t" => $result_alumnos[$i]['alumn_m_t']
	            ,"alumn_h_t" => $result_alumnos[$i]['alumn_h_t']
	            ,"alumn_t_t" => $result_alumnos[$i]['alumn_t_t']
	            ,"alumn_t_1" => $result_alumnos[$i]['alumn_t_1']
	            ,"alumn_t_2" => $result_alumnos[$i]['alumn_t_2']
	            ,"alumn_t_3" => $result_alumnos[$i]['alumn_t_3']
	            ,"alumn_t_4" => $result_alumnos[$i]['alumn_t_4']
	            ,"alumn_t_5" => $result_alumnos[$i]['alumn_t_5']
	            ,"alumn_t_6" => $result_alumnos[$i]['alumn_t_6']));

				array_push($array,$result_alumnos[$i]);

			}

			$str_html_alumn='<table class="table table-style-1 table-striped table-hover">
          	<thead class="bg-info">
          		<tr>
          			<th rowspan="3" class="text-center align-middle">Nivel educativo</th>
          			<th colspan="21" class="text-center">Alumnos</th>
          		</tr>
          		<tr>
								<th><i class="fa fa-female"></i></th>
								<th><i class="fa fa-male"></i></th>
								<th><i class="fa fa-female"></i><i class="fa fa-male"></i></th>
								<th>1°</th>
								<th>2°</th>
								<th>3°</th>
								<th>4°</th>
								<th>5°</th>
								<th>6°</th>
          		</tr>
          	</thead>
						<tbody>';

			foreach ($array as $row){
				if ($row['sostenimiento']=='total' && $row['modalidad']=='total') {
					if ($row['id_nivel']==$id_nivel_z) {
						$str_html_alumn.='<tr style="background-color:#FF8000" class="parent" id="'.str_replace(' ', '', $row['nivel']).'">';
					}
					else {
						$str_html_alumn.='<tr class="parent" id="'.str_replace(' ', '', $row['nivel']).'">';
					}

					$str_html_alumn.='<td class="pl-1"><img style="width:12px" class="mr-5" src="'.base_url("assets/img/expand-button.svg").'" >'.$row['nivel'].'</td>';
				}
				elseif ($row['sostenimiento']!='total' && $row['modalidad']=='total') {
					if ($row['id_nivel']==$id_nivel_z && $row['id_sostenimiento']==$id_sostenimiento_z) {
						$str_html_alumn.='<tr style="background-color:#FAAC58" class="child-'.str_replace(' ', '', $row['nivel']).' child-parent" id="'.str_replace(' ', '', $row['nivel']).$row['sostenimiento'].'">';
					}
					else {
						$str_html_alumn.='<tr class="child-'.str_replace(' ', '', $row['nivel']).' child-parent hide-ini" id="'.str_replace(' ', '', $row['nivel']).$row['sostenimiento'].'">';
					}

					$str_html_alumn.='<td class="pl-4"><img style="width:12px" class="mr-5" src="'.base_url("assets/img/expand-button.svg").'" >'.$row['sostenimiento'].'</td>';
				}
				elseif ($row['sostenimiento']!='total' && $row['modalidad']!='total') {
					if ($row['id_nivel']==$id_nivel_z && $row['id_sostenimiento']==$id_sostenimiento_z ) {
						$str_html_alumn.='<tr style="background-color:#F5D0A9" class="nieto-'.str_replace(' ', '', $row['nivel']).$row['sostenimiento'].'  class-hide-'.str_replace(' ', '', $row['nivel']).' ">';
					}
					else {
						$str_html_alumn.='<tr class="nieto-'.str_replace(' ', '', $row['nivel']).$row['sostenimiento'].'  class-hide-'.str_replace(' ', '', $row['nivel']).' hide-ini">';
					}

					$str_html_alumn.='<td class="pl-5">'.$row['modalidad'].'</td>';
				}
				($row['alumn_m_t']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['alumn_m_t']).'</td>';
				($row['alumn_h_t']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['alumn_h_t']).'</td>';
				($row['alumn_t_t']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['alumn_t_t']).'</td>';
				($row['alumn_t_1']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['alumn_t_1']).'</td>';
				($row['alumn_t_2']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['alumn_t_2']).'</td>';
				($row['alumn_t_3']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['alumn_t_3']).'</td>';
				($row['alumn_t_4']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['alumn_t_4']).'</td>';
				($row['alumn_t_5']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['alumn_t_5']).'</td>';
				($row['alumn_t_6']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['alumn_t_6']).'</td>';
			}
			$str_html_alumn.='</tbody>
          			</table>

          			<div class="pie_tabla">
          			        <div id="fuentes_pie">Fuente: SEDU (Formato 911).</div>
          			</div>';

			return $str_html_alumn;
		}//tabla_alumnos_z()

		function tabla_pdocentes($id_municipio,$id_nivel,$id_sostenimiento,$id_modalidad, $id_ciclo){
			$result_alumnos = $this->Estadistica_e_indicadores_xcct_model->get_pdocente_xmunciclo($id_municipio, $id_ciclo);

			$str_html_alumn='<table class="table table-style-1 table-striped table-hover">
          	<thead class="bg-info">
							<tr>
								<th rowspan="2" class="text-center align-middle">Nivel educativo</th>
								<th colspan="3" class="text-center align-middle">Docentes</th>
								<th colspan="3" class="text-center align-middle">Directivo con grupo</th>
								<th colspan="3" class="text-center align-middle">Directivo sin grupo</th>
							</tr>
							<tr>
								<th><i class="fa fa-female"></i></th>
								<th><i class="fa fa-male"></i></th>
								<th><i class="fa fa-female"></i><i class="fa fa-male"></i></th>
								<th><i class="fa fa-female"></i></th>
								<th><i class="fa fa-male"></i></th>
								<th><i class="fa fa-female"></i><i class="fa fa-male"></i></th>
								<th><i class="fa fa-female"></i></th>
								<th><i class="fa fa-male"></i></th>
								<th><i class="fa fa-female"></i><i class="fa fa-male"></i></th>
							</tr>
						</thead>
						<tbody>';

			foreach ($result_alumnos as $row){
				if ($row['sostenimiento']=='total' && $row['modalidad']=='total') {
					if ($row['id_nivel']==$id_nivel) {
						$str_html_alumn.='<tr style="background-color:#FF8000" class="parent" id="'.str_replace(' ', '', $row['nivel']).'">';
					}
					else {
						$str_html_alumn.='<tr class="parent" id="'.str_replace(' ', '', $row['nivel']).'">';
					}

					$str_html_alumn.='<td class="pl-1"><img style="width:12px" class="mr-5" src="'.base_url("assets/img/expand-button.svg").'" >'.$row['nivel'].'</td>';
				}
				elseif ($row['sostenimiento']!='total' && $row['modalidad']=='total') {
					if ($row['id_nivel']==$id_nivel && $row['id_sostenimiento']==$id_sostenimiento) {
						$str_html_alumn.='<tr style="background-color:#FAAC58" class="child-'.str_replace(' ', '', $row['nivel']).' child-parent" id="'.str_replace(' ', '', $row['nivel']).$row['sostenimiento'].'">';
					}
					else {
						$str_html_alumn.='<tr class="child-'.str_replace(' ', '', $row['nivel']).' child-parent hide-ini" id="'.str_replace(' ', '', $row['nivel']).$row['sostenimiento'].'">';
					}

					$str_html_alumn.='<td class="pl-4"><img style="width:12px" class="mr-5" src="'.base_url("assets/img/expand-button.svg").'" >'.$row['sostenimiento'].'</td>';
				}
				elseif ($row['sostenimiento']!='total' && $row['modalidad']!='total') {
					if ($row['id_nivel']==$id_nivel && $row['id_sostenimiento']==$id_sostenimiento && $row['id_modalidad']==$id_modalidad) {
						$str_html_alumn.='<tr style="background-color:#F5D0A9" class="nieto-'.str_replace(' ', '', $row['nivel']).$row['sostenimiento'].'  class-hide-'.str_replace(' ', '', $row['nivel']).' ">';
					}
					else {
						$str_html_alumn.='<tr class="nieto-'.str_replace(' ', '', $row['nivel']).$row['sostenimiento'].'  class-hide-'.str_replace(' ', '', $row['nivel']).' hide-ini">';
					}

					$str_html_alumn.='<td class="pl-5">'.$row['modalidad'].'</td>';
				}

				($row['docente_m']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['docente_m']).'</td>';
				($row['docente_h']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['docente_h']).'</td>';
				($row['docentes_t_g']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['docentes_t_g']).'</td>';
				($row['directivo_m_congrup']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['directivo_m_congrup']).'</td>';
				($row['directivo_h_congrup']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['directivo_h_congrup']).'</td>';
				($row['directivo_t_congrup']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['directivo_t_congrup']).'</td>';
				($row['directivo_m_singrup']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['directivo_m_singrup']).'</td>';
				($row['directivo_h_singrup']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['directivo_h_singrup']).'</td>';
				($row['directivo_t_singrup']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['directivo_t_singrup']).'</td>';

			}
			$str_html_alumn.='</tbody>
								</table>

								<div class="pie_tabla">
												<div id="fuentes_pie">Fuente: SEDU (Formato 911).</div>
								</div>';

			return $str_html_alumn;
		}//tabla_pdocentes()


		function tabla_pdocentes_z($id_nivel_z,$id_sostenimiento_z,$id_zona_z,$id_ciclo_z,$nivel,$sostenimiento){
			$result_alumnos = $this->Estadistica_e_indicadores_xcct_model->get_pdocente_xzona($nivel,$sostenimiento,$id_zona_z,$id_ciclo_z);

			$array=array();
			for($i=0; $i<count($result_alumnos); $i++){
				array_push($array,array("id_nivel" => $result_alumnos[$i]['id_nivel']
	            ,"nivel" => $result_alumnos[$i]['nivel']
	            ,"id_sostenimiento" => 0
	            ,"sostenimiento" => 'total'
	            ,"id_modalidad" => 0
	            ,"modalidad" => 'total'
	            ,"docente_m" => $result_alumnos[$i]['docente_m']
	            ,"docente_h" => $result_alumnos[$i]['docente_h']
	            ,"docentes_t_g" => $result_alumnos[$i]['docentes_t_g']
	            ,"directivo_m_congrup" => $result_alumnos[$i]['directivo_m_congrup']
	            ,"directivo_h_congrup" => $result_alumnos[$i]['directivo_h_congrup']
	            ,"directivo_t_congrup" => $result_alumnos[$i]['directivo_t_congrup']
	            ,"directivo_m_singrup" => $result_alumnos[$i]['directivo_m_singrup']
	            ,"directivo_h_singrup" => $result_alumnos[$i]['directivo_h_singrup']
	            ,"directivo_t_singrup" => $result_alumnos[$i]['directivo_t_singrup']));

	            array_push($array,array("id_nivel" => $result_alumnos[$i]['id_nivel']
	            ,"nivel" => $result_alumnos[$i]['nivel']
	            ,"id_sostenimiento" => $result_alumnos[$i]['id_sostenimiento']
	            ,"sostenimiento" => $result_alumnos[$i]['sostenimiento']
	            ,"id_modalidad" => 0
	            ,"modalidad" => 'total'
	            ,"docente_m" => $result_alumnos[$i]['docente_m']
	            ,"docente_h" => $result_alumnos[$i]['docente_h']
	            ,"docentes_t_g" => $result_alumnos[$i]['docentes_t_g']
	            ,"directivo_m_congrup" => $result_alumnos[$i]['directivo_m_congrup']
	            ,"directivo_h_congrup" => $result_alumnos[$i]['directivo_h_congrup']
	            ,"directivo_t_congrup" => $result_alumnos[$i]['directivo_t_congrup']
	            ,"directivo_m_singrup" => $result_alumnos[$i]['directivo_m_singrup']
	            ,"directivo_h_singrup" => $result_alumnos[$i]['directivo_h_singrup']
	            ,"directivo_t_singrup" => $result_alumnos[$i]['directivo_t_singrup']));

				array_push($array,$result_alumnos[$i]);

			}

			$str_html_alumn='<table class="table table-style-1 table-striped table-hover">
						<thead class="bg-info">
							<tr>
								<th rowspan="2" class="text-center align-middle">Nivel educativo</th>
								<th colspan="3" class="text-center align-middle">Docentes</th>
								<th colspan="3" class="text-center align-middle">Directivo con grupo</th>
								<th colspan="3" class="text-center align-middle">Directivo sin grupo</th>
							</tr>
							<tr>
								<th><i class="fa fa-female"></i></th>
								<th><i class="fa fa-male"></i></th>
								<th><i class="fa fa-female"></i><i class="fa fa-male"></i></th>
								<th><i class="fa fa-female"></i></th>
								<th><i class="fa fa-male"></i></th>
								<th><i class="fa fa-female"></i><i class="fa fa-male"></i></th>
								<th><i class="fa fa-female"></i></th>
								<th><i class="fa fa-male"></i></th>
								<th><i class="fa fa-female"></i><i class="fa fa-male"></i></th>
							</tr>
						</thead>
						<tbody>';

			foreach ($array as $row){
				if ($row['sostenimiento']=='total' && $row['modalidad']=='total') {
					if ($row['id_nivel']==$id_nivel_z) {
						$str_html_alumn.='<tr style="background-color:#FF8000" class="parent" id="'.str_replace(' ', '', $row['nivel']).'">';
					}
					else {
						$str_html_alumn.='<tr class="parent" id="'.str_replace(' ', '', $row['nivel']).'">';
					}

					$str_html_alumn.='<td class="pl-1"><img style="width:12px" class="mr-5" src="'.base_url("assets/img/expand-button.svg").'" >'.$row['nivel'].'</td>';
				}
				elseif ($row['sostenimiento']!='total' && $row['modalidad']=='total') {
					if ($row['id_nivel']==$id_nivel_z && $row['id_sostenimiento']==$id_sostenimiento_z) {
						$str_html_alumn.='<tr style="background-color:#FAAC58" class="child-'.str_replace(' ', '', $row['nivel']).' child-parent" id="'.str_replace(' ', '', $row['nivel']).$row['sostenimiento'].'">';
					}
					else {
						$str_html_alumn.='<tr class="child-'.str_replace(' ', '', $row['nivel']).' child-parent hide-ini" id="'.str_replace(' ', '', $row['nivel']).$row['sostenimiento'].'">';
					}

					$str_html_alumn.='<td class="pl-4"><img style="width:12px" class="mr-5" src="'.base_url("assets/img/expand-button.svg").'" >'.$row['sostenimiento'].'</td>';
				}
				elseif ($row['sostenimiento']!='total' && $row['modalidad']!='total') {
					if ($row['id_nivel']==$id_nivel_z && $row['id_sostenimiento']==$id_sostenimiento_z ) {
						$str_html_alumn.='<tr style="background-color:#F5D0A9" class="nieto-'.str_replace(' ', '', $row['nivel']).$row['sostenimiento'].'  class-hide-'.str_replace(' ', '', $row['nivel']).' ">';
					}
					else {
						$str_html_alumn.='<tr class="nieto-'.str_replace(' ', '', $row['nivel']).$row['sostenimiento'].'  class-hide-'.str_replace(' ', '', $row['nivel']).' hide-ini">';
					}

					$str_html_alumn.='<td class="pl-5">'.$row['modalidad'].'</td>';
				}
				($row['docente_m']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['docente_m']).'</td>';
				($row['docente_h']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['docente_h']).'</td>';
				($row['docentes_t_g']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['docentes_t_g']).'</td>';
				($row['directivo_m_congrup']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['directivo_m_congrup']).'</td>';
				($row['directivo_h_congrup']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['directivo_h_congrup']).'</td>';
				($row['directivo_t_congrup']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['directivo_t_congrup']).'</td>';
				($row['directivo_m_singrup']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['directivo_m_singrup']).'</td>';
				($row['directivo_h_singrup']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['directivo_h_singrup']).'</td>';
				($row['directivo_t_singrup']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['directivo_t_singrup']).'</td>';
			}
			$str_html_alumn.='</tbody>
								</table>

								<div class="pie_tabla">
												<div id="fuentes_pie">Fuente: SEDU (Formato 911).</div>
								</div>';

			return $str_html_alumn;
		}//tabla_pdocentes_z()


		function tabla_infraestructura($id_municipio,$id_nivel,$id_sostenimiento,$id_modalidad, $id_ciclo){
			$result_alumnos = $this->Estadistica_e_indicadores_xcct_model->get_infraest_xmunciclo($id_municipio, $id_ciclo);
			$str_html_alumn='<table class="table table-style-1 table-striped table-hover">
          	<thead class="bg-info">
						<tr>
							<th rowspan="2" class="text-center align-middle">Nivel educativo</th>
							<th rowspan="2" class="text-center align-middle">Escuelas</th>
							<th colspan="8" class="text-center align-middle">Grupos</th>
						</tr>
						<tr>
								<th>1°</th>
								<th>2°</th>
								<th>3°</th>
								<th>4°</th>
								<th>5°</th>
								<th>6°</th>
								<th class="text-center align-middle">Multigrado</th>
								<th class="text-center">Total</th>
						</tr>
          	</thead>
						<tbody>';

			foreach ($result_alumnos as $row){
				if ($row['sostenimiento']=='total' && $row['modalidad']=='total') {
					if ($row['id_nivel']==$id_nivel) {
						$str_html_alumn.='<tr style="background-color:#FF8000" class="parent" id="'.str_replace(' ', '', $row['nivel']).'">';
					}
					else {
						$str_html_alumn.='<tr class="parent" id="'.str_replace(' ', '', $row['nivel']).'">';
					}

					$str_html_alumn.='<td class="pl-1"><img style="width:12px" class="mr-5" src="'.base_url("assets/img/expand-button.svg").'" >'.$row['nivel'].'</td>';
				}
				elseif ($row['sostenimiento']!='total' && $row['modalidad']=='total') {
					if ($row['id_nivel']==$id_nivel && $row['id_sostenimiento']==$id_sostenimiento) {
						$str_html_alumn.='<tr style="background-color:#FAAC58" class="child-'.str_replace(' ', '', $row['nivel']).' child-parent" id="'.str_replace(' ', '', $row['nivel']).$row['sostenimiento'].'">';
					}
					else {
						$str_html_alumn.='<tr class="child-'.str_replace(' ', '', $row['nivel']).' child-parent hide-ini" id="'.str_replace(' ', '', $row['nivel']).$row['sostenimiento'].'">';
					}

					$str_html_alumn.='<td class="pl-4"><img style="width:12px" class="mr-5" src="'.base_url("assets/img/expand-button.svg").'" >'.$row['sostenimiento'].'</td>';
				}
				elseif ($row['sostenimiento']!='total' && $row['modalidad']!='total') {
					if ($row['id_nivel']==$id_nivel && $row['id_sostenimiento']==$id_sostenimiento && $row['id_modalidad']==$id_modalidad) {
						$str_html_alumn.='<tr style="background-color:#F5D0A9" class="nieto-'.str_replace(' ', '', $row['nivel']).$row['sostenimiento'].'  class-hide-'.str_replace(' ', '', $row['nivel']).' ">';
					}
					else {
						$str_html_alumn.='<tr class="nieto-'.str_replace(' ', '', $row['nivel']).$row['sostenimiento'].'  class-hide-'.str_replace(' ', '', $row['nivel']).' hide-ini">';
					}

					$str_html_alumn.='<td class="pl-5">'.$row['modalidad'].'</td>';
				}

				($row['nescuelas']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['nescuelas']).'</td>';
				($row['grupos_1']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['grupos_1']).'</td>';
				($row['grupos_2']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['grupos_2']).'</td>';
				($row['grupos_3']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['grupos_3']).'</td>';
				($row['grupos_4']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['grupos_4']).'</td>';
				($row['grupos_5']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['grupos_5']).'</td>';
				($row['grupos_6']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['grupos_6']).'</td>';
				($row['grupos_multi']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['grupos_multi']).'</td>';
				($row['grupos_t']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['grupos_t']).'</td>';

			}
			$str_html_alumn.='</tbody>
								</table>

								<div class="pie_tabla">
												<div id="fuentes_pie">Fuente: SEDU (Formato 911).</div>
								</div>';

			return $str_html_alumn;
		}//tabla_infraestructura()


		function tabla_infraestructura_z($id_nivel_z,$id_sostenimiento_z,$id_zona_z,$id_ciclo_z,$nivel,$sostenimiento){
			$result_alumnos = $this->Estadistica_e_indicadores_xcct_model->get_infraest_xzona($nivel,$sostenimiento,$id_zona_z,$id_ciclo_z);

			$array=array();
			for($i=0; $i<count($result_alumnos); $i++){
				array_push($array,array("id_nivel" => $result_alumnos[$i]['id_nivel']
	            ,"nivel" => $result_alumnos[$i]['nivel']
	            ,"id_sostenimiento" => 0
	            ,"sostenimiento" => 'total'
	            ,"id_modalidad" => 0
	            ,"modalidad" => 'total'
	            ,"nescuelas" => $result_alumnos[$i]['nescuelas']
	            ,"grupos_1" => $result_alumnos[$i]['grupos_1']
	            ,"grupos_2" => $result_alumnos[$i]['grupos_2']
	            ,"grupos_3" => $result_alumnos[$i]['grupos_3']
	            ,"grupos_4" => $result_alumnos[$i]['grupos_4']
	            ,"grupos_5" => $result_alumnos[$i]['grupos_5']
	            ,"grupos_6" => $result_alumnos[$i]['grupos_6']
	            ,"grupos_multi" => $result_alumnos[$i]['grupos_multi']
	            ,"grupos_t" => $result_alumnos[$i]['grupos_t']));

	            array_push($array,array("id_nivel" => $result_alumnos[$i]['id_nivel']
	            ,"nivel" => $result_alumnos[$i]['nivel']
	            ,"id_sostenimiento" => $result_alumnos[$i]['id_sostenimiento']
	            ,"sostenimiento" => $result_alumnos[$i]['sostenimiento']
	            ,"id_modalidad" => 0
	            ,"modalidad" => 'total'
	            ,"nescuelas" => $result_alumnos[$i]['nescuelas']
	            ,"grupos_1" => $result_alumnos[$i]['grupos_1']
	            ,"grupos_2" => $result_alumnos[$i]['grupos_2']
	            ,"grupos_3" => $result_alumnos[$i]['grupos_3']
	            ,"grupos_4" => $result_alumnos[$i]['grupos_4']
	            ,"grupos_5" => $result_alumnos[$i]['grupos_5']
	            ,"grupos_6" => $result_alumnos[$i]['grupos_6']
	            ,"grupos_multi" => $result_alumnos[$i]['grupos_multi']
	            ,"grupos_t" => $result_alumnos[$i]['grupos_t']));

				array_push($array,$result_alumnos[$i]);

			}

			$str_html_alumn='<table class="table table-style-1 table-striped table-hover">
						<thead class="bg-info">
						<tr>
							<th rowspan="2" class="text-center align-middle">Nivel educativo</th>
							<th rowspan="2" class="text-center align-middle">Escuelas</th>
							<th colspan="8" class="text-center align-middle">Grupos</th>
						</tr>
						<tr>
								<th>1°</th>
								<th>2°</th>
								<th>3°</th>
								<th>4°</th>
								<th>5°</th>
								<th>6°</th>
								<th class="text-center align-middle">Multigrado</th>
								<th class="text-center">Total</th>
						</tr>
						</thead>
						<tbody>';

			foreach ($array as $row){
				if ($row['sostenimiento']=='total' && $row['modalidad']=='total') {
					if ($row['id_nivel']==$id_nivel_z) {
						$str_html_alumn.='<tr style="background-color:#FF8000" class="parent" id="'.str_replace(' ', '', $row['nivel']).'">';
					}
					else {
						$str_html_alumn.='<tr class="parent" id="'.str_replace(' ', '', $row['nivel']).'">';
					}

					$str_html_alumn.='<td class="pl-1"><img style="width:12px" class="mr-5" src="'.base_url("assets/img/expand-button.svg").'" >'.$row['nivel'].'</td>';
				}
				elseif ($row['sostenimiento']!='total' && $row['modalidad']=='total') {
					if ($row['id_nivel']==$id_nivel_z && $row['id_sostenimiento']==$id_sostenimiento_z) {
						$str_html_alumn.='<tr style="background-color:#FAAC58" class="child-'.str_replace(' ', '', $row['nivel']).' child-parent" id="'.str_replace(' ', '', $row['nivel']).$row['sostenimiento'].'">';
					}
					else {
						$str_html_alumn.='<tr class="child-'.str_replace(' ', '', $row['nivel']).' child-parent hide-ini" id="'.str_replace(' ', '', $row['nivel']).$row['sostenimiento'].'">';
					}

					$str_html_alumn.='<td class="pl-4"><img style="width:12px" class="mr-5" src="'.base_url("assets/img/expand-button.svg").'" >'.$row['sostenimiento'].'</td>';
				}
				elseif ($row['sostenimiento']!='total' && $row['modalidad']!='total') {
					if ($row['id_nivel']==$id_nivel_z && $row['id_sostenimiento']==$id_sostenimiento_z ) {
						$str_html_alumn.='<tr style="background-color:#F5D0A9" class="nieto-'.str_replace(' ', '', $row['nivel']).$row['sostenimiento'].'  class-hide-'.str_replace(' ', '', $row['nivel']).' ">';
					}
					else {
						$str_html_alumn.='<tr class="nieto-'.str_replace(' ', '', $row['nivel']).$row['sostenimiento'].'  class-hide-'.str_replace(' ', '', $row['nivel']).' hide-ini">';
					}

					$str_html_alumn.='<td class="pl-5">'.$row['modalidad'].'</td>';
				}

				($row['nescuelas']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['nescuelas']).'</td>';
				($row['grupos_1']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['grupos_1']).'</td>';
				($row['grupos_2']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['grupos_2']).'</td>';
				($row['grupos_3']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['grupos_3']).'</td>';
				($row['grupos_4']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['grupos_4']).'</td>';
				($row['grupos_5']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['grupos_5']).'</td>';
				($row['grupos_6']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['grupos_6']).'</td>';
				($row['grupos_multi']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['grupos_multi']).'</td>';
				($row['grupos_t']==0)?$str_html_alumn.='<td>-</td>':$str_html_alumn.='<td>'.number_format($row['grupos_t']).'</td>';

			}
			$str_html_alumn.='</tbody>
								</table>

								<div class="pie_tabla">
												<div id="fuentes_pie">Fuente: SEDU (Formato 911).</div>
								</div>';

			return $str_html_alumn;
		}//tabla_infraestructura_z()

		function tabla_planea($id_municipio,$id_nivel,$id_sostenimiento,$id_modalidad, $id_ciclo){
			$result_planea = array();
			$result_ciclo_planea_prim = $this->Planeaxmuni_model->get_ciclo_planea_prim($id_ciclo);
			$result_ciclo_planea_sec = $this->Planeaxmuni_model->get_ciclo_planea_sec($id_ciclo);
			$result_ciclo_planea_ms = $this->Planeaxmuni_model->get_ciclo_planea_ms($id_ciclo);

			$result_planea_prim = $this->Planeaxmuni_model->get_planea_xmunciclo($id_municipio, $result_ciclo_planea_prim, PRIMARIA);
			$result_planea_sec = $this->Planeaxmuni_model->get_planea_xmunciclo($id_municipio, $result_ciclo_planea_sec,SECUNDARIA);
			$result_planea_msuperior = $this->Planeaxmuni_model->get_planea_xmunciclo($id_municipio, $result_ciclo_planea_ms, MEDIA_SUPERIOR);
			array_push($result_planea, $result_planea_prim[0]);
			array_push($result_planea, $result_planea_sec[0]);
			array_push($result_planea, $result_planea_msuperior[0]);
			$str_html_alumn='<table class="table table-style-1 table-striped table-hover">
							<thead class="bg-info">
							<tr>
								<th rowspan="2" class="text-center align-middle">Resultados de la prueba Planea</th>
								<th colspan="5" class="text-center align-middle">Lenguaje y Comunicación</th>
								<th colspan="5" class="text-center align-middle">Matemáticas</th>
							</tr>
							<tr>
								<th colspan="4" class="text-center align-middle">Nivel de dominio</th>
								<th rowspan="2" class="text-center align-middle">Alumnos que superaron el nivel I</th>
								<th colspan="4" class="text-center align-middle">Nivel de dominio</th>
								<th rowspan="2" class="text-center align-middle">Alumnos que superaron el nivel I</th>
							</tr>
							<tr>
								<th class="text-center align-middle">Nivel</th>
								<th class="text-center align-middle">I<br><sub>Insuficiente</sub></th>
								<th class="text-center align-middle">II<br><sub>Elemental</sub></th>
								<th class="text-center align-middle">III<br><sub>Bueno</sub></th>
								<th class="text-center align-middle">IV<br><sub>Excelente</sub></th>
								<th class="text-center align-middle">I<br><sub>Insuficiente</sub></th>
								<th class="text-center align-middle">II<br><sub>Elemental</sub></th>
								<th class="text-center align-middle">III<br><sub>Bueno</sub></th>
								<th class="text-center align-middle">IV<br><sub>Excelente</sub></th>
							</tr>
				</thead>
				<tbody>';
				// echo "<pre>"; print_r($result_planea); die();
			foreach ($result_planea as $row){

				$str_html_alumn.='
				<tr>
				<td>'.$row['nivel'].'</td>
				<td style="text-align: center;">'.($row['lyc_i']).'%</td><td style="text-align: center;">'.($row['lyc_ii']).'%</td><td  style="text-align: center;">'.($row['lyc_iii']).'%</td><td style="text-align: center;">'.($row['lyc_iv']).'%</td>
				<td style="text-align: center;">'.(intval($row['lyc_ii'])+intval($row['lyc_iii'])+intval($row['lyc_iv'])).'%</td>
				<td style="text-align: center;">'.($row['mat_i']).'%</td><td style="text-align: center;">'.($row['mat_ii']).'%</td><td style="text-align: center;">'.($row['mat_iii']).'%</td><td style="text-align: center;">'.($row['mat_iv']).'%</td>
				<td style="text-align: center;">'.(intval($row['mat_ii'])+intval($row['mat_iii'])+intval($row['mat_iv'])).'%</td>
				</tr>';
			}
			$str_html_alumn.='</tbody>
								</table>

								<div class="pie_tabla">
												<div id="fuentes_pie">Fuente: SEP Federal.</div>
								</div>';

			return $str_html_alumn;
		}//tabla_planea()

		function tabla_asistencia($id_municipio, $id_ciclo){
			$result_asistencia = array();
			$result_ciclo_ind = $this->Indicadoresxestado_model->get_ciclo_ind($id_ciclo);
			if ($id_municipio==0) {
				$result_asistencia_nv = $this->Indicadoresxestado_model->get_ind_asistenciaxestadoidciclo($result_ciclo_ind);
			}
			else {
				$result_asistencia_nv = $this->Indicadoresxmuni_model->get_ind_asistenciaxmuniidciclo($id_municipio, $result_ciclo_ind);
			}

			$str_html_alumn='<table class="table table-style-1 table-striped table-hover">
							<thead class="bg-info">
							<tr>
							<th class="text-center align-middle">Nivel</th>
							<th class="text-center align-middle">Cobertura</th>
							<th class="text-center align-middle">Absorción</th>
							</tr>
				</thead>
				<tbody>';

			foreach ($result_asistencia_nv as $row){

				$str_html_alumn.='
				<tr>
				<td>'.$row['nivel'].'</td>
				<td style="text-align: center;">'.($row['cobertura']).'%</td>
				<td style="text-align: center;">'.($row['absorcion']).'%</td>
				</tr>';
			}
			$str_html_alumn.='</tbody>
								</table>

								<div class="pie_tabla">
												<div id="fuentes_pie">Fuente: SEDU (Formato 911).</div>
								</div>';

			return $str_html_alumn;
		}//tabla_asistencia()

		function tabla_permanencia($id_municipio, $id_ciclo){
			$result_planea = array();
			$result_ciclo_ind = $this->Indicadoresxestado_model->get_ciclo_ind($id_ciclo);

			$result_ciclo = $this->Indicadoresxestado_model->get_ciclo($id_ciclo);

			if ($id_municipio==0) {
				$result_permanencia_nv = $this->Indicadoresxestado_model->get_ind_permanenciaxestadoidciclo($result_ciclo_ind);
			}
			else {
				$result_permanencia_nv = $this->Indicadoresxmuni_model->get_ind_permanenciaxmuniidciclo($id_municipio, $result_ciclo_ind);
			}

			$str_html_alumn='<table class="table table-style-1 table-striped table-hover">
							<thead class="bg-info">
							<tr>
								<th class="text-center align-middle">Nivel</th>
								<th class="text-center align-middle">Retención</th>
								<th class="text-center align-middle">Aprobación</th>
								<th class="text-center align-middle">Eficiencia Terminal</th>
							</tr>
				</thead>
				<tbody>';

			foreach ($result_permanencia_nv as $row){

				$str_html_alumn.='
				<tr>
				<td>'.$row['nivel'].'</td>
				<td style="text-align: center;">'.($row['retencion']).'%</td>
				<td style="text-align: center;">'.($row['aprobacion']).'%</td>
				<td style="text-align: center;">'.(($row['et']=='0.00')?'N/D':$row['et'].'%').'</td>
				</tr>';
			}
			$str_html_alumn.='</tbody>
								</table>

								<div class="pie_tabla">
												<div id="fuentes_pie">Fuente: SEDU (Formato 911) - ciclo escolar 
												'.$result_ciclo.'</div>
												<div id="">N/D : Dato no disponible</div>
								</div>';

			return $str_html_alumn;
		}//tabla_permanencia()




		function tabla_rezinegi($id_municipio,$id_nivel,$id_sostenimiento,$id_modalidad, $id_ciclo){
			$result_periodo_inegi = $this->Inegixmuni_model->get_ciclo_inegi($id_ciclo);
			 $result_rezinegi = $this->Inegixmuni_model->get_rezago_xmunciclo($id_municipio, $result_periodo_inegi);

			$str_html_rezinegi='<table class="table table-style-1 table-striped table-hover">
				<thead class="bg-info">
					<tr>
            <th>Inasistencia escolar</th>
            <th colspan="3">Población total</th>
            <th colspan="3">Población que no asiste a la escuela</th>
          </tr>
          <tr>
            <th id="rezago">Población por grupo de edad<br> que no asiste a la escuela</th>
						<th><i class="fa fa-male"></i></th>
						<th><i class="fa fa-female"></i></th>
						<th><i class="fa fa-female"></i><i class="fa fa-male"></i></th>
						<th><i class="fa fa-male"></i></th>
						<th><i class="fa fa-female"></i></th>
						<th><i class="fa fa-female"></i><i class="fa fa-male"></i></th>
          </tr>
	</thead>
	<tbody>';

			foreach ($result_rezinegi as $row){

				$str_html_rezinegi.='
				<tr>
				<td>3 a 5 años</td>
				<td>'.number_format($row['P_3A5_M']).'</td><td>'.number_format($row['P_3A5_F']).'</td><td>'.number_format($row['P_3A5_M']+$row['P_3A5_F']).'</td>
				<td>'.number_format($row['P3A5_NOA_M']).'</td><td>'.number_format($row['P3A5_NOA_F']).'</td><td>'.number_format($row['P3A5_NOA_M']+$row['P3A5_NOA_F']).'</td>
				</tr>
				<tr>
				<td>6 a 11 años</td>
				<td>'.number_format($row['P_6A11_M']).'</td><td>'.number_format($row['P_6A11_F']).'</td><td>'.number_format($row['P_6A11_M']+$row['P_6A11_F']).'</td>
				<td>'.number_format($row['P6A11_NOAM']).'</td><td>'.number_format($row['P6A11_NOAF']).'</td><td>'.number_format($row['P6A11_NOAM']+$row['P6A11_NOAF']).'</td>
				</tr>
				<tr>
				<td>12 a 14 años</td>
				<td>'.number_format($row['P_12A14_M']).'</td><td>'.number_format($row['P_12A14_F']).'</td><td>'.number_format($row['P_12A14_M']+$row['P_12A14_F']).'</td>
				<td>'.number_format($row['P12A14NOAM']).'</td><td>'.number_format($row['P12A14NOAF']).'</td><td>'.number_format($row['P12A14NOAM']+$row['P12A14NOAF']).'</td>
				</tr>
				<tr>
				<td>15 a 17 años</td>
				<td>'.number_format($row['P_15A17_M']).'</td><td>'.number_format($row['P_15A17_F']).'</td><td>'.number_format($row['P_15A17_M']+$row['P_15A17_F']).'</td>
				<td>'.number_format($row['P_15A17_M']-$row['P15A17A_M']).'</td><td>'.number_format($row['P_15A17_F']-$row['P15A17A_F']).'</td><td>'.number_format(($row['P_15A17_M']+$row['P_15A17_F'])-$row['P15A17A_M']+$row['P15A17A_F']).'</td>
				</tr>
				<tr>
				<td>18 a 22 años</td>
				<td>'.number_format($row['P_18A24_M']).'</td><td>'.number_format($row['P_18A24_F']).'</td><td>'.number_format($row['P_18A24_M']+$row['P_18A24_F']).'</td>
				<td>'.number_format($row['P_18A24_M']-$row['P18A24A_M']).'</td><td>'.number_format($row['P_18A24_F']-$row['P18A24A_F']).'</td><td>'.number_format(($row['P_18A24_M']+$row['P_18A24_F'])-$row['P18A24A_M']+$row['P18A24A_F']).'</td>
				</tr>
				';
			}
			$str_html_rezinegi.='</tbody>
								</table>

								<div class="pie_tabla">
												<div id="fuentes_pie">Fuente: INEGI, '.$result_periodo_inegi.'</div>
								</div>';

			return $str_html_rezinegi;
		}//tabla_rezinegi()


		function tabla_analfinegi($id_municipio,$id_nivel,$id_sostenimiento,$id_modalidad, $id_ciclo){
			$result_periodo_inegi = $this->Inegixmuni_model->get_ciclo_inegi($id_ciclo);
			 $result_analfinegi = $this->Inegixmuni_model->get_analf_xmunciclo($id_municipio, $result_periodo_inegi);
			$str_html_analfinegi='<table class="table table-style-1 table-striped table-hover">
			<thead class="bg-info">
			<tr>
				<th>Población</th>
					 <th><i class="fa fa-male"></i></th>
					 <th><i class="fa fa-female"></i></th>
					 <th><i class="fa fa-female"></i><i class="fa fa-male"></i></th>
			</tr>
	</thead>
	<tbody>';

			foreach ($result_analfinegi as $row){

				$str_html_analfinegi.='
				<tr>
				<td>De 8 a 14 años que no saben leer y escribir</td>
				<td>'.number_format($row['P8A14AN_M']).'</td><td>'.number_format($row['P8A14AN_F']).'</td><td>'.number_format($row['P8A14AN_M']+$row['P8A14AN_F']).'</td>
				</tr>
				<tr>
				<td>Mayor de 15 años que no saben leer y escribir</td>
				<td>'.number_format($row['P15YM_AN_M']).'</td><td>'.number_format($row['P15YM_AN_F']).'</td><td>'.number_format($row['P15YM_AN_M']+$row['P15YM_AN_F']).'</td>
				</tr>
				';
			}
			$str_html_analfinegi.='</tbody>
								</table>

								<div class="pie_tabla">
												<div id="fuentes_pie">Fuente: INEGI, '.$result_periodo_inegi.'</div>
								</div>';

			return $str_html_analfinegi;
		}//tabla_analfinegi()

		public function xest_zona_x($tipo="zona"){
			$id_nivel_z = $this->input->post('id_nivel');
			$nivel = $this->input->post('nivel');
			$id_sostenimiento_z = $this->input->post('id_sostenimiento');
			$sostenimiento = $this->input->post('sostenimiento');
			$id_zona_z = $this->input->post('id_zona');
			$id_ciclo_z = $this->input->post('ciclo');

				$data["tipo_busqueda"] = "zona";
				$data["id_nivel_z"] = $id_nivel_z;
				$data["id_sostenimiento_z"] = $id_sostenimiento_z;
				$data["id_zona_z"] = $id_zona_z;
				$data["id_ciclo_z"] = $id_ciclo_z;
				$data["nivel_z"] = $nivel;
				$data["sostenimiento_z"] = $sostenimiento;
				$data["zona_z"] = $this->Supervision_model->get_zona($id_nivel_z, $id_sostenimiento_z,$id_zona_z);
				$data["ciclo_z"] = $this->Ciclo_model->get_ciclo($id_ciclo_z);

				$data["srt_tab_alumnos"] = $this->tabla_alumnos_z($id_nivel_z,$id_sostenimiento_z,$id_zona_z,$id_ciclo_z,$nivel,$sostenimiento);
				$data["srt_tab_pdocentes"] = $this->tabla_pdocentes_z($id_nivel_z,$id_sostenimiento_z,$id_zona_z,$id_ciclo_z,$nivel,$sostenimiento);
				$data["srt_tab_infraestructura"] =$this->tabla_infraestructura_z($id_nivel_z,$id_sostenimiento_z,$id_zona_z,$id_ciclo_z,$nivel,$sostenimiento);
				$data["srt_tab_planea"] = "";
				$data["srt_tab_rezag_inegi"] = "";
				$data["srt_tab_analf_inegi"] = "";

				$dom = $this->load->view("estadistica/estadi_e_indi_gen_tab2",$data,TRUE);
	    		$response = array(
					'vista'=>$dom
				);

				Utilerias::enviaDataJson(200, $response, $this);
				exit;


		}//xest_zona_x

}//Estadistica
