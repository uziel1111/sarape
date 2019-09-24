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
        $this->load->model('Evidencia_model');
        $this->load->model('Prog_apoyo_xcct_model');
        $this->load->model('Apoyo_req_model');
        $this->load->model('Ambito_model');
        $this->datos = array();
    }

    function index()
    {   
      $data = $this->data;
      $data['error'] = '';
      $this->load->view( "Estadistica_pemc/login", $data);
  }

  public function login_action(){
    $user = $this->input->post('usuario');
    $pwd = $this->input->post('password');

    $user_data = $this->Estadistica_pemc_model->get_datos_sesion($user, md5($pwd));

    if(count($user_data) > 0){
        $data = 0;
        Utilerias::set_usuario_sesion($this, $user_data);
        if(Utilerias::haySesionAbierta($this)){
           Utilerias::pagina_basica_pemc($this, 'Estadistica_pemc/index',$data);
                // $this->load->view('Estadistica_pemc/index',$data);  
       }
   }else{
    $data = $this->data;
    $data['error'] = 'Usuario o contraseña incorrecta';
    $data['login_failed'] = TRUE;
    $this->load->view('Estadistica_pemc/login',$data); 
}
}

public function busquedaxct(){
    $user = $this->input->post('cct');
    $turno = $this->input->post('turno');
    $cct="05".$user;

        // echo $turno."\n";
        // echo $cct."\n";
        // die();
    $datoscct = $this->Estadistica_pemc_model->getdatoscct_pemc($cct, $turno);
    Utilerias::set_cct_sesion($this, $datoscct);
        // echo "<pre>";
        // print_r($datoscct);
        // die();
    $this->datos = Utilerias::get_cct_sesion($this);
        // echo "<pre>";
        // print_r($this->datos);
        // die();
    $usuario = $this->datos[0]['cve_centro'];
    $id_cct = $this->datos[0]['id_cct'];
    $responsables = $this->getPersonal($usuario);
    $nomenclatura = substr($usuario,0,5);

    if ($responsables->status==0) {
       $personas = array();
   }else {
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

$mision = $this->Rutamejora_model->get_misionxcct($this->datos[0]['id_cct'],'4');
$data['mision'] = $mision;
$result_prioridades = $this->Prioridad_model->get_prioridadesxnivel($this->datos[0]['nivel']);

if(count($result_prioridades)==0){
    $data['arr_prioridades'] = array(   '-1' => 'Error recuperando los prioridades' );
}else{
    $data['arr_prioridades'] = $result_prioridades;
}

$result_problematicas = $this->Problematica_model->get_problematicas();
if(count($result_problematicas)==0){
    $data['arr_problematicas'] = array( '-1' => 'Error recuperando los problematicas' );
}else{
    $data['arr_problematicas'] = $result_problematicas;
}

$result_evidencias = $this->Evidencia_model->get_evidencias();
if(count($result_evidencias)==0){
    $data['arr_evidencias'] = array(    '-1' => 'Error recuperando los evidencias' );
}else{
    $data['arr_evidencias'] = $result_evidencias;
}

        $result_progsapoyo = $this->Prog_apoyo_xcct_model->get_prog_apoyo_xcctxciclo($this->datos[0]['id_cct'],4);//id_cct, id_ciclo
        if(count($result_progsapoyo)==0){
            $data['arr_progsapoyo'] = '';
        }else{
            $data['arr_progsapoyo'] = $result_progsapoyo;
        }
        $result_apoyosreq = $this->Apoyo_req_model->get_apoyo_req();
        
        if(count($result_apoyosreq)==0){
            $data['arr_apoyosreq'] = array( '-1' => 'Error recuperando los apoyosreq' );
        }else{
            $data['arr_apoyosreq'] = $result_apoyosreq;
        }
        
        $result_ambitos = $this->Ambito_model->get_ambitos();
        if(count($result_ambitos)==0){
            $data['arr_ambitos'] = array(   '-1' => 'Error recuperando los ambitos' );
        }else{
            $data['arr_ambitos'] = $result_ambitos;
        }

        $data3 = array();
        $arr_indicadoresxct = $this->Rutamejora_model->get_indicadoresxcct($this->datos[0]['id_cct'],$this->datos[0]['nivel'],'1', '2018');//id_cct,nombre_nivel,bimestre,año
        $data3['arr_indicadores'] = $arr_indicadoresxct;
        $string_view_indicadores = $this->load->view('ruta/indicadores', $data3, TRUE);
        $data['tab_indicadores'] = $string_view_indicadores;

        $data4 = array();
        $string_view_instructivo = $this->load->view('ruta/instructivo', $data4, TRUE);
        $data['tab_instructivo'] = $string_view_instructivo;

        $data['nivel'] = $this->datos[0]['nivel'];
        $data['nombreuser'] = $this->datos[0]['nombre_centro'];
        $data['turno'] = $this->datos[0]['turno_single'];
        $data['cct'] = $this->datos[0]['cve_centro'];
        $data['director'] = $this->datos[0]['nombre_director'];
        $data['tipo_usuario_pemc']=$this->datos[0]['tipo_usuario_pemc'];
        $data['vista_avance'] = $this->load->view("ruta/rutademejora/avances", $data, TRUE);
        $data['vista_indicadores'] = $this->load->view("ruta/rutademejora/indicadores", $data, TRUE);
        $data['vista_ayuda'] = $this->load->view("ruta/rutademejora/ayuda", $data, TRUE);

        // Utilerias::pagina_basica_rm($this, "ruta/rutademejora/index", $data);
        $dom = $this->load->view("ruta/rutademejora/index",$data,TRUE);
        $response = array('vista' => $dom);
        Utilerias::enviaDataJson(200, $response, $this);
        exit;
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
            //  redirect('Rutademejora/index');
            // }
    }

    /*BK201 S*/

    public function getEstadistica(){
        $result = array();
        $nivel = $this->input->post('nivel');
       
        $totalPorcentaje = 0;
        $tabla = '';

        $municipios = $this->Estadistica_pemc_model->municipios();

        foreach ($municipios as $key => $value) {
            $tabla .= "<tr>
                      <td>{$value['nombre']}</td>";
            $datos = $this->Estadistica_pemc_model->get_cantidad_datos($nivel, $value['idmunicipio']);
            $total = $this->Estadistica_pemc_model->get_total($nivel, $value['idmunicipio']);
            
            foreach ($total as $key => $value) {
                if ($value['total'] == NULL) {
                    $tabla .= "<td>0</td>";
                }else{

                $tabla .= "<td>{$value['total']}</td>";
                }
                $totalPorcentaje += $value['total'];
            }

            $rango0 = 0;
            $rango1 = 0;
            $rango2 = 0;
            $rango3 = 0;

                foreach ($datos as $key => $value) {
                   if ($value['num_objetivos'] == 0) {
                        $rango0 += $value['total_obj'];
                   }

                   if ($value['num_objetivos'] == 1) {
                       $rango1 += $value['total_obj'];
                   }

                   if ($value['num_objetivos'] == 2 || $value['num_objetivos'] == 3) {
                       $rango2 += $value['total_obj'];
                   }

                   if ($value['num_objetivos'] >= 4) {
                       $rango3 += $value['total_obj'];
                   }
                }
            $tabla .= "<td>{$rango0}</td>
                       <td>{$rango1}</td>
                       <td>{$rango2}</td>
                       <td>{$rango3}</td>
                       </tr>";
            
        }


     $pC = (($totalPorcentaje * 100) / 7871);
     $pNC = 100 - $pC;

     $porcentajeC = $this->truncar($pC, '2');
     $porcentajeNC = $this->truncar($pNC, '2');

     $result = ['tabla' => $tabla, 'total' => $totalPorcentaje];

     $data['result'] = $result;
     $str_view = $this->load->view("Estadistica_pemc/grid_general", $data, TRUE);
     $response = array('str_view' => $str_view, 'porcentajeC' =>$porcentajeC, 'porcentajeNC' =>$porcentajeNC);
     Utilerias::enviaDataJson(200, $response, $this);
     exit;
 }

 function truncar($numero, $digitos) {
    $truncar = 10**$digitos;
    return intval($numero * $truncar) / $truncar;
}

public function getEstadisticaLAE(){
  $nivel = $this->input->post('nivel');
  $result = array();
     // echo '<pre>'; print_r($nivel); die();
  switch ($nivel) {
    case '4':
    $result+=['obj1'=>15];
    $result+=['obj2'=>12];
    $result+=['obj3'=>26];
    $result+=['obj4'=>8];
    $result+=['obj5'=>40];
    $result+=['total'=>101];
    break;
    case '2':
    $result+=['obj1'=>5];
    $result+=['obj2'=>2];
    $result+=['obj3'=>6];
    $result+=['obj4'=>8];
    $result+=['obj5'=>0];
    $result+=['total'=>21];
    break;
    case '3':
    $result+=['obj1'=>1];
    $result+=['obj2'=>2];
    $result+=['obj3'=>2];
    $result+=['obj4'=>5];
    $result+=['obj5'=>4];
    $result+=['total'=>14];
    break;
    case '1':
    $result+=['obj1'=>1];
    $result+=['obj2'=>2];
    $result+=['obj3'=>0];
    $result+=['obj4'=>1];
    $result+=['obj5'=>3];
    $result+=['total'=>7];
    break;
    case '5':
    $result+=['obj1'=>10];
    $result+=['obj2'=>20];
    $result+=['obj3'=>0];
    $result+=['obj4'=>21];
    $result+=['obj5'=>13];
    $result+=['total'=>64];
    break;
    default:
    $result+=['obj1'=>15];
    $result+=['obj2'=>12];
    $result+=['obj3'=>26];
    $result+=['obj4'=>8];
    $result+=['obj5'=>40];
    $result+=['total'=>101];
    break;
}



$data['result'] = $result;
$str_view = $this->load->view("Estadistica_pemc/grid_LAE", $data, TRUE);
$response = array('str_view' => $str_view, 'result'=>$result);
Utilerias::enviaDataJson(200, $response, $this);
exit;
}


/*BK201 E*/
}