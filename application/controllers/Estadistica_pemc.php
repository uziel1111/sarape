<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Estadistica_pemc extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->data = array( );
        $this->load->library('Utilerias');
        $this->load->model('Estadistica_pemc_model');
        $this->load->model('Rutamejora_model');
        $this->load->model('Prioridad_model');
        $this->load->model('Problematica_model');
        $this->load->model('Sostenimiento_model');
        $this->load->model('Nivel_model');
        $this->load->model('CentrosE_model');
        $this->load->model('Pemc_model');

        $this->datos = array();
    }

    function index()
    {
      $data = $this->data;
      $data['error'] = '';
      $this->load->view( "estadistica_pemc/login", $data);
  }

  public function login_action(){
        $user = $this->input->post('usuario');
        $pwd = $this->input->post('password');

        $user_data = $this->Estadistica_pemc_model->get_datos_sesion($user, md5($pwd));
        if(count($user_data) > 0){
            $data = array();
            Utilerias::set_usuario_sesion($this, $user_data);
            $result_municipios = $this->Estadistica_pemc_model->getall_xest_ind();
            $arr_municipios = array();
            if(count($result_municipios)==0){
                $data['arr_municipios'] = array(    '0' => 'Error recuperando los municipios' );
            }else{
                $arr_municipios['0'] = 'TODOS';
                foreach ($result_municipios as $row){
                     $arr_municipios[$row['id_municipio']] = $row['municipio'];
                }
            }

            $arr_niveles = array();
            $result_niveles = $this->Nivel_model->all();
            // echo "<pre>";print_r($result_niveles);die();
            if(count($result_niveles)==0){
                $data['arr_niveles'] = array(   '0' => 'Error recuperando los niveles' );
            }else{
                $arr_niveles['0'] = 'TODOS';
                foreach ($result_niveles as $row){
                  if ($row['id_nivel'] > 0 && $row['id_nivel'] < 6) {
                    $arr_niveles[$row['id_nivel']] = $row['nivel'];
                  }
                }
                $data['arr_niveles'] =$arr_niveles;
            }

            $result_sostenimientos = $this->Sostenimiento_model->all();
            if(count($result_sostenimientos)==0){
                $data['arr_sostenimientos'] = array(    '0' => 'Error recuperando los sostenimientos' );
            }else{
                $arr_sostenimientos['0'] = 'TODOS';
                foreach ($result_sostenimientos as $row){
                        $arr_sostenimientos[$row['id_sostenimiento']] = $row['sostenimiento'];
                }
            }

            $data['arr_municipios'] = $arr_municipios;
            $data['arr_sostenimientos'] =$arr_sostenimientos;

            if(Utilerias::haySesionAbierta($this)){

                 Utilerias::pagina_basica_pemc($this, 'estadistica_pemc/index',$data);
            }
        }else{
            $data = $this->data;
            $data['error'] = 'Usuario o contraseña incorrecta';
            $data['login_failed'] = TRUE;
            $this->load->view('estadistica_pemc/login',$data);
        }
    }


public function busquedaxct(){
    $datos_admin = Utilerias::get_usuario_sesion($this);
    $datos_admin=$datos_admin[0];
    $cct = $this->input->post('cct');
    $turno = $this->input->post('turno');
    if($turno=="MATUTINO"){
        $turno_single=1;
    }else if($turno=="VESPERTINO"){
        $turno_single=2;
    }else if($turno=="NOCTURNO"){
        $turno_single=3;
    }else if($turno=="DISCONTINUO"){
        $turno_single=4;
    }else if($turno=="CONTINUO"){
        $turno_single=5;
    }

    $datoscct = $this->Pemc_model->getdatoscct($cct, $turno_single);
    $datoscct = $datoscct[0];
    $datoscct['id_turno_single'] = $turno_single;
    $idpemc = $this->Pemc_model->obtener_idpemc_xescuela($datoscct['cve_centro'],$turno_single);
    $datoscct['idpemc'] = $idpemc;
    // echo "<pre>";print_r($datoscct);die();
    // Utilerias::destroy_all_session($this);
    // Utilerias::set_cct_sesion($this, $datoscct);

    $this->cct = $datoscct;

    $tmp_usuario = $datos_admin['nombre'];
    $this->cct['tipo_usuario']=$tmp_usuario;

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
		$data['id_turno'] = $this->cct['id_turno_single'];
		$data['cct'] = $this->cct['cve_centro'];
		$data['director'] = $this->cct['nombre_director'];
		$data['tipo_usuario'] = $this->cct['tipo_usuario'];

    // echo "<pre>";print_r($data);die();
		// Utilerias::pagina_basica_pemcv2($this, "pemc/index", $data);
    $dom = $this->load->view("pemc/index",$data,TRUE);
    $response = array('vista' => $dom);
    Utilerias::enviaDataJson(200, $response, $this);
    exit;

    // $datoscct = $this->Estadistica_pemc_model->getdatoscct_pemc($cct, $turno_single);
    // Utilerias::set_cct_sesion($this, $datoscct);
    //
    // $this->datos = Utilerias::get_cct_sesion($this);
    //
    // $usuario = $this->datos[0]['cct'];
    // // $id_cct = $this->datos[0]['id_cct'];
    // $responsables = $this->getPersonal($usuario);
    // $nomenclatura = substr($usuario,0,5);
    //
    // if ($responsables->status==0) {
    //    $personas = array();
    // }else {
    //     $personas = $responsables->Personal;
    // }
    //
    // $options = "";
    // if($responsables->procede == 1 && $responsables->status == 1){
    //     foreach ($personas as $persona) {
    //         if ($nomenclatura != '05PJN' && $nomenclatura != '05PPR' && $nomenclatura != '05PPS') {
    //             $options .= "<option value='{$persona->rfc}'>".$persona->nombre_completo."</option>";
    //         }
    //     }
    //     $options .="<option value='0'>OTRO</option>";
    // }else{
    //     $options .="<option value='0'>OTRO</option>";
    // }
    //
    // $data['responsables'] = $options;
    //
    // $mision = $this->Rutamejora_model->get_misionxcct($usuario,$turno_single,'4');
    // $data['mision'] = $mision;
    // $result_prioridades = $this->Prioridad_model->get_prioridadesxnivel($this->datos[0]['desc_nivel_educativo']);
    //
    // if(count($result_prioridades)==0){
    //     $data['arr_prioridades'] = array(   '-1' => 'Error recuperando los prioridades' );
    // }else{
    //     $data['arr_prioridades'] = $result_prioridades;
    // }
    //
    // $result_problematicas = $this->Problematica_model->get_problematicas();
    // if(count($result_problematicas)==0){
    //     $data['arr_problematicas'] = array( '-1' => 'Error recuperando los problematicas' );
    // }else{
    //     $data['arr_problematicas'] = $result_problematicas;
    // }
    //
    // $data['nivel'] = $this->datos[0]['desc_nivel_educativo'];
    // $data['nombreuser'] = $this->datos[0]['nombre'];
    // $data['turno'] = $this->datos[0]['turno'];
    // $data['desc_turno'] = $this->datos[0]['desc_turno'];
    // $data['cct'] = $this->datos[0]['cct'];
    // // $data['id_cct_rm'] =$this->datos[0]['id_cct'];
    // $data['director'] = $this->datos[0]['nombre_director'];
    // $data['tipo_usuario_pemc']=$this->datos[0]['tipo_usuario_pemc'];
    // $data['vista_avance'] = $this->load->view("ruta/avances", $data, TRUE);
    // $data['vista_indicadores'] = $this->load->view("ruta/rutademejora/indicadores", $data, TRUE);
    // $data['vista_ayuda'] = $this->load->view("ruta/rutademejora/ayuda", $data, TRUE);
    //
    // $dom = $this->load->view("ruta/rutademejora/index",$data,TRUE);
    // $response = array('vista' => $dom);
    // Utilerias::enviaDataJson(200, $response, $this);
    // exit;
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

    public function escuelas_xmunicipio(){
        if(Utilerias::haySesionAbierta($this)){
            $cve_municipio = $this->input->post('cve_municipio');
            $cve_nivel = $this->input->post('cve_nivel');
            $cve_sostenimiento = $this->input->post('cve_sostenimiento');
            $nombre_escuela = $this->input->post('nombre_escuela');
            $this->datos = Utilerias::get_cct_sesion($this);

            $data['tipou_pemc']="upemc";

            $data['cve_municipio'] = $cve_municipio;
            $data['cve_nivel'] = $cve_nivel;
            $data['cve_sostenimiento'] = $cve_sostenimiento;
            $data['nombre_escuela'] = $nombre_escuela;

            $municipio = $this->input->post('municipio_pemc');
            $nivel = $this->input->post('nivel_pemc');
            $sostenimiento = $this->input->post('sostenimiento_pemc');
            $result_escuelas = $this->Estadistica_pemc_model->filtro_escuela($cve_municipio,$cve_nivel,$cve_sostenimiento,$nombre_escuela);

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

            $data['municipio'] = $municipio;
            $data['nivel'] = $nivel;
            $data['sostenimiento'] = $sostenimiento;
            $data['escuela'] = $nombre_escuela;
            $data['arr_escuelas'] = $array;
            $data['total_escuelas'] = count($array);
            $str_view = $this->load->view("busqueda_xlista/escuelas", $data, TRUE);
            $response = array('vista' => $str_view);
            Utilerias::enviaDataJson(200, $response, $this);
            exit;
        }
    }// escuelas_xmunicipio()


function truncar($numero, $digitos) {
    $truncar = pow(10, $digitos);
    return intval($numero * $truncar) / $truncar;
}

    public function getEstadistica(){
          if(Utilerias::haySesionAbierta($this)){
        $result = array();
        $nivel = $this->input->post('nivel');
        $modalidad = $this->input->post('modalidad');
        $sostenimiento = $this->input->post('sostenimiento');

        $arr_modalidad = $this->Estadistica_pemc_model->get_modalidad_gen($nivel);
        $arr_sostenimiento = $this->Estadistica_pemc_model->get_sostenimiento_gen($nivel,$modalidad);

        $tabla = $this->Estadistica_pemc_model->get_escuelasMun_gen($nivel, $modalidad, $sostenimiento);
        $totalEscuelas = $this->Estadistica_pemc_model->get_toatalesc($nivel, $modalidad, $sostenimiento);


     $porcentajeC = $this->Estadistica_pemc_model->get_total_gen($nivel, $modalidad, $sostenimiento);
     $porcentajeNC = $this->Estadistica_pemc_model->get_total_gen($nivel, $modalidad, $sostenimiento);
     $n_porcentajeC = $this->Estadistica_pemc_model->get_total_gen($nivel, $modalidad, $sostenimiento);
     $n_porcentajeNC = $this->Estadistica_pemc_model->get_total_gen($nivel, $modalidad, $sostenimiento);

     $porcentajeC = (float)$porcentajeC[0]['por_capt'];
     $porcentajeNC = (float)$porcentajeNC[0]['por_ncapt'];
     $n_porcentajeC = (float)$n_porcentajeC[0]['n_esccapt'];
     $n_porcentajeNC = (float)$n_porcentajeNC[0]['n_escncapt'];

     $result = array('tabla' => $tabla, 'total' => $totalEscuelas);

     $data['result'] = $result;
     $data['modalidad'] = $arr_modalidad;
     $data['sostenimiento'] = $arr_sostenimiento;
     $str_view = $this->load->view("estadistica_pemc/grid_general", $data, TRUE);
     $response = array('str_view' => $str_view, 'porcentajeC' =>$porcentajeC, 'porcentajeNC' =>$porcentajeNC, 'n_porcentajeC' =>$n_porcentajeC, 'n_porcentajeNC' =>$n_porcentajeNC);
     Utilerias::enviaDataJson(200, $response, $this);
     exit;
    } else {
        $this->index();
    }
 }



public function getEstadisticaLAE(){
      if(Utilerias::haySesionAbierta($this)){
$nivel = $this->input->post('nivel');
$region = $this->input->post('region');
$municipio = $this->input->post('municipio');

$munxregion = $this->Estadistica_pemc_model->get_municipios($region);
$tabla = $this->Estadistica_pemc_model->get_obj_acc_lae($nivel, $region, $municipio);
$grafica = $this->Estadistica_pemc_model->grafica_obj_acc_lae($nivel, $region, $municipio);

$data['tabla'] = $tabla;
$data['municipio'] = $munxregion;
$str_view = $this->load->view("estadistica_pemc/grid_LAE", $data, TRUE);
$response = array('str_view' => $str_view, 'grafica'=>$grafica);
Utilerias::enviaDataJson(200, $response, $this);
exit;
 } else {
        $this->index();
    }
}


function getTablaZona()
{
     if(Utilerias::haySesionAbierta($this)){
   $sostenimiento = $this->input->post('sostenimiento');
   $zonaPost = $this->input->post('zona');
   $nivel = $this->input->post('nivel');

   $zonas= $this->Estadistica_pemc_model->get_zonas($sostenimiento, $nivel);

   $porcentajeZona = $this->Estadistica_pemc_model->get_porcent_zonas($sostenimiento, $zonaPost, $nivel);
   $porcctZona = $this->Estadistica_pemc_model->get_cct_xzonas($sostenimiento, $zonaPost, $nivel);
   // echo "<pre>";print_r($porcctZona);die();
   $data['zonas'] = $zonas;
   $data['tabla'] = $porcentajeZona;
   $data['tabla_esc'] = $porcctZona;
   $str_view = $this->load->view("estadistica_pemc/grid_zona", $data, TRUE);
   $response = array('str_view' => $str_view);
   Utilerias::enviaDataJson(200, $response, $this);
   exit;
    } else {
        $this->index();
    }
}

public function cerrar_sesion(){
    Utilerias::destroy_all_session($this);
    $data = $this->data;
    $data['error'] = '';
    $this->load->view( "estadistica_pemc/login", $data);
}


}
