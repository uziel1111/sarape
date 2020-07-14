<?php
class Pemc_model extends CI_Model
{
  function __construct(){
    parent::__construct();
    date_default_timezone_set('America/Mexico_City');
    $this->pemc_db = $this->load->database('pemc_db', TRUE);
  }


 function getdatoscct($cct, $turno){

    $str_query = "SELECT
    e.cct as cve_centro,
    e.nombre as nombre_centro,
    e.turno as id_turno_single,
    e.desc_turno as turno_single,
    e.desc_nivel_educativo as nivel,
    CONCAT_WS(' ', e.nombre_director, e.apellido_paterno_director, e.apellido_materno_director) as nombre_director
    FROM
    vista_cct e
    WHERE
    e.cct ='{$cct}'
    AND e.turno like '%{$turno}%'";
    return $this->pemc_db->query($str_query)->result_array();

  }

    //FUNCIONAMIENTO Y VALIDACION PARA SUPERVISOR BY LUIS SANCHEZ... all reserved rights

function valida_supervisor($cct){
 $str_query = "SELECT * FROM vista_cct WHERE cct = '{$cct}' and tipo_centro = 1";
 return $this->pemc_db->query($str_query)->result_array();
}

function obtener_idpemc_xescuela($cct, $turno){
  $str_query = "SELECT idpemc FROM r_pemcxescuela WHERE cct ='{$cct}' AND id_turno_single = {$turno}";
  $idpemc = $this->pemc_db->query($str_query)->row('idpemc');
  if ($idpemc=='') {
    date_default_timezone_set('America/Monterrey');
		setlocale(LC_TIME, 'es_MX.UTF-8');
		$fecha = date("Y-m-d H:i:s");
		$data_req = array(
			'cct' =>$cct,
			'id_turno_single' =>$turno,
			'fcreacion' =>$fecha
		);
      $this->pemc_db->insert('r_pemcxescuela', $data_req);
			$idpemc = $this->pemc_db->insert_id();
  }
  return $idpemc;
}


function obtener_diagnostico_xidpemc($idpemc){
 $str_query = "SELECT diagnostico FROM r_pemc_diagnostico WHERE idpemc={$idpemc}";
 return $this->pemc_db->query($str_query)->row('diagnostico');
}

function guarda_diagnostico($diagnostico, $idpemc){
  $status=false;
  $str_query = "SELECT idpemc FROM r_pemc_diagnostico WHERE idpemc = {$idpemc}";
  $idpemc_rtn = $this->pemc_db->query($str_query)->row('idpemc');
  if ($idpemc_rtn=='') {
    date_default_timezone_set('America/Monterrey');
		setlocale(LC_TIME, 'es_MX.UTF-8');
		$fecha = date("Y-m-d H:i:s");
		$data_req = array(
			'idpemc' =>$idpemc,
			'diagnostico' =>$diagnostico,
			'fcreacion' =>$fecha
		);
      $status = $this->pemc_db->insert('r_pemc_diagnostico', $data_req);
  }
  else {
    $this->pemc_db->set('diagnostico', $diagnostico);
    $this->pemc_db->where('idpemc', $idpemc);
    $status = $this->pemc_db->update('r_pemc_diagnostico');
  }
  return $status;
}
function obtener_seguimiento_xidpemc($idpemc){
 $str_query = "SELECT
              obj.idobjetivo, obj.orden as orden_objetivo, obj.objetivo, obj.meta, obj.comentario_general,
              acc.idaccion, acc.orden as orden_accion, acc.accion, acc.idambitos, acc.finicio,  acc.ffin,
              seguimineto.avance, acc.responsables, acc.otros_responsables
              FROM r_pemc_objetivo obj
              INNER JOIN r_pemc_objetivo_accion acc ON obj.idobjetivo = acc.idobjetivo
              LEFT JOIN (SELECT
              					seg.idaccion, seg.avance
              					FROM r_pemc_accion_seguimiento seg
              					INNER JOIN (SELECT idaccion, MAX(fcreacion) AS fcreacion FROM r_pemc_accion_seguimiento GROUP BY idaccion) as aux ON seg.idaccion = aux.idaccion AND seg.fcreacion = aux.fcreacion
              					GROUP BY seg.idaccion
              					) as seguimineto ON acc.idaccion = seguimineto.idaccion
              WHERE obj.idpemc= {$idpemc}
              GROUP BY obj.idobjetivo, acc.idaccion
              ORDER BY obj.orden, acc.orden";
 return $this->pemc_db->query($str_query)->result_array();
}

function obtener_ambitos_xidambitos($idambitos){
 $str_query = "SELECT ambitos.a as ambitos FROM(SELECT 1, GROUP_CONCAT(ambito) as a FROM c_pemc_ambito WHERE idambito in({$idambitos}) GROUP BY 1) as ambitos";
 return $this->pemc_db->query($str_query)->row('ambitos');
}


function ir_a_guardar_avance($idaccion, $avance){
  date_default_timezone_set('America/Monterrey');
  setlocale(LC_TIME, 'es_MX.UTF-8');
  $fecha = date("Y-m-d H:i:s");
  $data_req = array(
    'idaccion' =>$idaccion,
    'avance' =>$avance,
    'fcreacion' =>$fecha
  );
  return $this->pemc_db->insert('r_pemc_accion_seguimiento', $data_req);
}
function ver_avance($idaccion){
 $str_query = "SELECT avance, fcreacion FROM r_pemc_accion_seguimiento WHERE idaccion ={$idaccion}";
 return $this->pemc_db->query($str_query)->result_array();
}

function ver_datos_accion($idaccion){
 $str_query = "SELECT
obj.objetivo, obj.meta, obj.comentario_general, acc.idambitos, acc.accion
FROM r_pemc_objetivo obj
INNER JOIN r_pemc_objetivo_accion acc ON obj.idobjetivo = acc.idobjetivo
WHERE acc.idaccion={$idaccion}";
 return $this->pemc_db->query($str_query)->result_array();
}

function guarda_evaluacion($evaluacion, $idpemc,$path_eval){
  $status=false;
    date_default_timezone_set('America/Monterrey');
		setlocale(LC_TIME, 'es_MX.UTF-8');
		$fecha = date("Y-m-d H:i:s");
		$data_req = array(
			'idpemc' =>$idpemc,
			'evaluacion' =>$evaluacion,
      'url_reporte' =>$path_eval,
      'ciclo_escolar' =>Utilerias::trae_ciclo_actual(),
			'fcreacion' =>$fecha
		);
      $status = $this->pemc_db->insert('r_pemc_evaluacion', $data_req);
  return $status;
}

function obtener_evaluaciones_xidpemc($idpemc){
 $str_query = "SELECT
idpemc, evaluacion, url_reporte, ciclo_escolar, fcreacion
FROM r_pemc_evaluacion WHERE idpemc={$idpemc}";
 return $this->pemc_db->query($str_query)->result_array();
}

}// Rutamejora_model
