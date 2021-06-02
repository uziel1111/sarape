<?php
class Pemc_model extends CI_Model
{
  function __construct(){
    parent::__construct();
    date_default_timezone_set('America/Mexico_City');
    // $this->db = $this->load->database('default', TRUE);
    $this->load->database();

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
    return $this->db->query($str_query)->result_array();

  }

    //FUNCIONAMIENTO Y VALIDACION PARA SUPERVISOR BY LUIS SANCHEZ... all reserved rights

function valida_supervisor($cct){
 $str_query = "SELECT * FROM vista_cct WHERE cct = '{$cct}' and tipo_centro = 1";
 return $this->db->query($str_query)->result_array();
}

function obtener_idpemc_xescuela($cct, $turno){
  $str_query = "SELECT idpemc FROM r_pemcxescuela WHERE cct ='{$cct}' AND id_turno_single = {$turno}";

  $idpemc = $this->db->query($str_query)->row('idpemc');
  if ($idpemc=='') {
    date_default_timezone_set('America/Monterrey');
		setlocale(LC_TIME, 'es_MX.UTF-8');
		$fecha = date("Y-m-d H:i:s");
		$data_req = array(
			'cct' =>$cct,
			'id_turno_single' =>$turno,
			'fcreacion' =>$fecha
		);
      $this->db->insert('r_pemcxescuela', $data_req);
			$idpemc = $this->db->insert_id();
  }
  return $idpemc;
}


function obtener_diagnostico_xidpemc($idpemc){
 $str_query = "SELECT diagnostico FROM r_pemc_diagnostico WHERE idpemc={$idpemc}";
 return $this->db->query($str_query)->row('diagnostico');
}

function guarda_diagnostico($diagnostico, $idpemc){
  $status=false;
  $str_query = "SELECT idpemc FROM r_pemc_diagnostico WHERE idpemc = {$idpemc}";
  $idpemc_rtn = $this->db->query($str_query)->row('idpemc');
  if ($idpemc_rtn=='') {
    date_default_timezone_set('America/Monterrey');
		setlocale(LC_TIME, 'es_MX.UTF-8');
		$fecha = date("Y-m-d H:i:s");
		$data_req = array(
			'idpemc' =>$idpemc,
			'diagnostico' =>$diagnostico,
			'fcreacion' =>$fecha
		);
      $status = $this->db->insert('r_pemc_diagnostico', $data_req);
  }
  else {
    $this->db->set('diagnostico', $diagnostico);
    $this->db->where('idpemc', $idpemc);
    $status = $this->db->update('r_pemc_diagnostico');
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
 return $this->db->query($str_query)->result_array();
}

function obtener_ambitos_xidambitos($idambitos){
 $str_query = "SELECT ambitos.a as ambitos FROM(SELECT 1, GROUP_CONCAT(ambito) as a FROM c_pemc_ambito WHERE idambito in({$idambitos}) GROUP BY 1) as ambitos";
 return $this->db->query($str_query)->row('ambitos');
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
  return $this->db->insert('r_pemc_accion_seguimiento', $data_req);
}
function ver_avance($idaccion){
 $str_query = "SELECT avance, fcreacion FROM r_pemc_accion_seguimiento WHERE idaccion ={$idaccion}";
 return $this->db->query($str_query)->result_array();
}

function ver_datos_accion($idaccion){
 $str_query = "SELECT
obj.objetivo, obj.meta, obj.comentario_general, acc.idambitos, acc.accion
FROM r_pemc_objetivo obj
INNER JOIN r_pemc_objetivo_accion acc ON obj.idobjetivo = acc.idobjetivo
WHERE acc.idaccion={$idaccion}";
 return $this->db->query($str_query)->result_array();
}

function guarda_evaluacion($evaluacion, $idpemc){
  $status=false;
  $str_query = "SELECT idpemc FROM r_pemc_evaluacion WHERE idpemc = {$idpemc}";
  $idpemc_rtn = $this->db->query($str_query)->row('idpemc');
  date_default_timezone_set('America/Monterrey');
  setlocale(LC_TIME, 'es_MX.UTF-8');
  $fecha = date("Y-m-d H:i:s");
  if ($idpemc_rtn=='') {
		$data_req = array(
			'idpemc' =>$idpemc,
			'evaluacion' =>$evaluacion,
			'fcreacion' =>$fecha
		);
      $status = $this->db->insert('r_pemc_evaluacion', $data_req);
  }
  else {
    $this->db->set('evaluacion', $evaluacion);
    $this->db->set('fcreacion', $fecha);
    $this->db->where('idpemc', $idpemc);
    $status = $this->db->update('r_pemc_evaluacion');
  }
  return $status;
}

function guarda_cierre($idpemc,$path_eval){
  $status=false;
  $str_query = "SELECT idpemc FROM r_pemc_cierre WHERE idpemc = {$idpemc} AND ciclo_escolar = "."'". $this->trae_ciclo_actual()."'";
  $idpemc_rtn = $this->db->query($str_query)->row('idpemc');
  date_default_timezone_set('America/Monterrey');
  setlocale(LC_TIME, 'es_MX.UTF-8');
  $fecha = date("Y-m-d H:i:s");
  if ($idpemc_rtn=='') {

		$data_req = array(
			'idpemc' =>$idpemc,
      'url_reporte' =>$path_eval,
			'ciclo_escolar' => $this->trae_ciclo_actual(),
			'fcreacion' =>$fecha
		);
      $status = $this->db->insert('r_pemc_cierre', $data_req);
  }
  else {
    $this->db->set('url_reporte', $path_eval);
    $this->db->set('fcreacion', $fecha);
    $this->db->where('idpemc', $idpemc);
    $this->db->where('ciclo_escolar', $this->trae_ciclo_actual());
    $status = $this->db->update('r_pemc_cierre');
  }
  return $status;
}


function obtener_evaluaciones_xidpemc($idpemc){
 $str_query = "SELECT
idpemc, url_reporte, ciclo_escolar, fcreacion
FROM r_pemc_cierre WHERE idpemc={$idpemc}";
 return $this->db->query($str_query)->result_array();
}

function obtener_evaluacion_xidpemc($idpemc){
 $str_query = "SELECT evaluacion,observacion_supervision FROM r_pemc_evaluacion WHERE idpemc={$idpemc}";
 return $this->db->query($str_query)->row_array();
}

function trae_ciclo_actual(){
 $str_query = "SELECT descr as ciclo_escolar FROM c_pemc_ciclo WHERE estatus=1";
 return $this->db->query($str_query)->row('ciclo_escolar');
}

function es_inicio_ciclo_actual(){
  date_default_timezone_set('America/Monterrey');
  setlocale(LC_TIME, 'es_MX.UTF-8');
  $fecha = date("Y-m-d");
  // echo "<pre>";print_r($fecha);die();
   $str_query = "SELECT
   descr as ciclo_escolar
   FROM c_pemc_ciclo
   WHERE estatus=1
   AND ('{$fecha}' BETWEEN f_abre_inicio AND f_cierra_inicio)";
   if ($this->db->query($str_query)->row('ciclo_escolar')=='') {
     return false;
   }
   else {
     return true;
   }

}

function es_fin_ciclo_actual(){
  date_default_timezone_set('America/Monterrey');
  setlocale(LC_TIME, 'es_MX.UTF-8');
  $fecha = date("Y-m-d");
  // echo "<pre>";print_r($fecha);die();
   $str_query = "SELECT
   descr as ciclo_escolar
   FROM c_pemc_ciclo
   WHERE estatus=1
   AND ('{$fecha}' BETWEEN f_abre_fin AND f_cierra_fin)";
   if ($this->db->query($str_query)->row('ciclo_escolar')=='') {
     return false;
   }
   else {
     return true;
   }
}

function esta_cerrado_ciclo_actual($idpemc){
  // echo "<pre>";print_r($fecha);die();
   $str_query = "SELECT idpemc FROM r_pemc_cierre WHERE idpemc={$idpemc} AND ciclo_escolar="."'".$this->trae_ciclo_actual()."'";
   if ($this->db->query($str_query)->row('idpemc')=='') {
     return false;
   }
   else {
     return true;
   }
}

function get_cte(){
  $str_query = "SELECT num_cte FROM c_pemc_cte WHERE NOW()  BETWEEN finicio AND ffin";
  return $this->db->query($str_query)->row('num_cte');
}

function obtener_n_acciones_pemc_ant($cct,$turno){
  $str_query = "SELECT
      	COUNT(DISTINCT acc.id_accion) as n_acciones
      FROM
      	rm_tema_prioritarioxcct rtp
      INNER JOIN rm_c_prioridad p ON p.id_prioridad = rtp.id_prioridad
      INNER JOIN rm_objetivo o ON rtp.id_tprioritario=o.id_tprioritario
			INNER JOIN rm_accionxtproritario acc ON rtp.id_tprioritario = acc.id_tprioritario
      WHERE rtp.cct = '{$cct}' AND rtp.turno = {$turno}
      ORDER BY orden ASC";
  return $this->db->query($str_query)->row('n_acciones');
}

function consulta_tipo_usuario($cct){
 $str_query = "SELECT
              IF(cct='05FJS0042U','jefe_sector',
              (CASE tipo_centro
                  WHEN 1 THEN 'supervision'
                  WHEN 9 THEN 'escuela'
              		WHEN 2 THEN 'jefe_sector'
                  ELSE 'otro'
              END)) as tipo
              FROM vista_cct
              WHERE cct= ?";
 return $this->db->query($str_query,array($cct))->row('tipo');
}

function getdatossupervicion($cct, $turno){
  $str_query = "SELECT cct AS cve_centro,zona_escolar,nombre AS nombre_supervision,desc_turno
                  FROM vista_cct
                  WHERE tipo_centro=1
                  AND  cct = ? AND turno like '%{$turno}%' AND (status='1' OR status='4')";
  return $this->db->query($str_query,array($cct))->result_array();
}

function getdatosjefe_sector($cct, $turno){
  $str_query = "SELECT cct AS cve_centro,jefatura_de_sector,nombre AS nombre_jefe_sector,desc_turno
                  FROM vista_cct
                  WHERE (tipo_centro=2 or tipo_centro=10)
                  AND  cct = ? AND turno like '%{$turno}%' AND (status='1' OR status='4')";
  return $this->db->query($str_query,array($cct))->result_array();
}

function obtener_idpemc_xescuela_super($cct, $turno){
  $str_query = "SELECT idpemc FROM r_pemcxescuela WHERE cct ='{$cct}' AND id_turno_single = {$turno}";
   return  $this->db->query($str_query)->row('idpemc');
}
function obtener_objyacc_xidpemc($idpemc){
  $str_query="SELECT IFNULL(COUNT(total.idobjetivo),0) as objetivos,IFNULL(SUM(total.num_acciones),0)as acciones
FROM
(
SELECT obj.idobjetivo as idobjetivo,COUNT(acc.idaccion) as num_acciones FROM r_pemc_objetivo obj
        LEFT JOIN r_pemc_objetivo_accion acc ON acc.idobjetivo = obj.idobjetivo
        WHERE idpemc = '{$idpemc}'
        GROUP BY obj.idobjetivo)as total";
  return $this->db->query($str_query)->row_array();


}
function obtener_cct_xidpemc($idpemc){
  $str_query="SELECT cct,id_turno_single FROM r_pemcxescuela WHERE idpemc='{$idpemc}'";
  return $this->db->query($str_query)->row_array();
}
public function getTablasGraficas($idspemc,$ccts){
    $str_query = "SELECT
l1.nombre_centro as nombre_centro,
l1.cve_centro as cve_centro,
IFNULL(l1.total_obj,0) as obj1,
IFNULL(l1.total_acc,0) as acc1,
IFNULL(l2.total_obj,0) as obj2,
IFNULL(l2.total_acc,0) as acc2,
IFNULL(l3.total_obj,0) as obj3,
IFNULL(l3.total_acc,0)as acc3,
IFNULL(l4.total_obj,0) as obj4,
IFNULL(l4.total_acc,0) as acc4,
IFNULL(l5.total_obj,0) as obj5,
IFNULL(l5.total_acc,0) as acc5
FROM
(SELECT
v.cct as cve_centro,
v.nombre as nombre_centro,
t.total_objetivos as total_obj,
t.total_acciones as total_acc
FROM   vista_cct v
LEFT JOIN
(SELECT
COUNT(DISTINCT o.idobjetivo) as total_objetivos,
COUNT(DISTINCT a.idaccion) as total_acciones,
l.idlae as lae,
v.cct as cve_centro,
v.nombre as nombre_centro
FROM vista_cct v
INNER JOIN r_pemcxescuela e ON v.cct = e.cct
LEFT JOIN r_pemc_objetivo o ON e.idpemc = o.idpemc
LEFT JOIN  r_pemc_objetivo_accion a ON o.idobjetivo = a.idobjetivo
INNER JOIN c_pemc_ambito am ON FIND_IN_SET(am.idambito, a.idambitos) > 0
INNER JOIN c_pemc_laes l ON am.idlae = l.idlae
WHERE
o.idpemc IN('{$idspemc}')
AND l.idlae=1
GROUP BY v.cct,l.idlae)
as t ON v.cct =t.cve_centro
WHERE v.cct IN('{$ccts}'))as l1
INNER JOIN
(SELECT
v.cct as cve_centro,
v.nombre as nombre_centro,
t.total_objetivos as total_obj,
t.total_acciones as total_acc
FROM   vista_cct v
LEFT JOIN
(SELECT
COUNT(DISTINCT o.idobjetivo) as total_objetivos,
COUNT(DISTINCT a.idaccion) as total_acciones,
l.idlae as lae,
v.cct as cve_centro,
v.nombre as nombre_centro
FROM vista_cct v
INNER JOIN r_pemcxescuela e ON v.cct = e.cct
LEFT JOIN r_pemc_objetivo o ON e.idpemc = o.idpemc
LEFT JOIN  r_pemc_objetivo_accion a ON o.idobjetivo = a.idobjetivo
INNER JOIN c_pemc_ambito am ON FIND_IN_SET(am.idambito, a.idambitos) > 0
INNER JOIN c_pemc_laes l ON am.idlae = l.idlae
WHERE
o.idpemc IN('{$idspemc}')
AND l.idlae=2
GROUP BY v.cct,l.idlae)
as t ON v.cct =t.cve_centro
WHERE v.cct IN('{$ccts}'))as l2 ON l1.cve_centro =l2.cve_centro
INNER JOIN
(SELECT
v.cct as cve_centro,
v.nombre as nombre_centro,
t.total_objetivos as total_obj,
t.total_acciones as total_acc
FROM   vista_cct v
LEFT JOIN
(SELECT
COUNT(DISTINCT o.idobjetivo) as total_objetivos,
COUNT(DISTINCT a.idaccion) as total_acciones,
l.idlae as lae,
v.cct as cve_centro,
v.nombre as nombre_centro
FROM vista_cct v
INNER JOIN r_pemcxescuela e ON v.cct = e.cct
LEFT JOIN r_pemc_objetivo o ON e.idpemc = o.idpemc
LEFT JOIN  r_pemc_objetivo_accion a ON o.idobjetivo = a.idobjetivo
INNER JOIN c_pemc_ambito am ON FIND_IN_SET(am.idambito, a.idambitos) > 0
INNER JOIN c_pemc_laes l ON am.idlae = l.idlae
WHERE
o.idpemc IN('{$idspemc}')
AND l.idlae=3
GROUP BY v.cct,l.idlae)
as t ON v.cct =t.cve_centro
WHERE v.cct IN('{$ccts}'))as l3 ON l1.cve_centro =l3.cve_centro
INNER JOIN
(SELECT
v.cct as cve_centro,
v.nombre as nombre_centro,
t.total_objetivos as total_obj,
t.total_acciones as total_acc
FROM   vista_cct v
LEFT JOIN
(SELECT
COUNT(DISTINCT o.idobjetivo) as total_objetivos,
COUNT(DISTINCT a.idaccion) as total_acciones,
l.idlae as lae,
v.cct as cve_centro,
v.nombre as nombre_centro
FROM vista_cct v
INNER JOIN r_pemcxescuela e ON v.cct = e.cct
LEFT JOIN r_pemc_objetivo o ON e.idpemc = o.idpemc
LEFT JOIN  r_pemc_objetivo_accion a ON o.idobjetivo = a.idobjetivo
INNER JOIN c_pemc_ambito am ON FIND_IN_SET(am.idambito, a.idambitos) > 0
INNER JOIN c_pemc_laes l ON am.idlae = l.idlae
WHERE
o.idpemc IN('{$idspemc}')
AND l.idlae=4
GROUP BY v.cct,l.idlae)
as t ON v.cct =t.cve_centro
WHERE v.cct IN('{$ccts}'))as l4 ON l1.cve_centro =l4.cve_centro
INNER JOIN
(SELECT
v.cct as cve_centro,
v.nombre as nombre_centro,
t.total_objetivos as total_obj,
t.total_acciones as total_acc
FROM   vista_cct v
LEFT JOIN
(SELECT
COUNT(DISTINCT o.idobjetivo) as total_objetivos,
COUNT(DISTINCT a.idaccion) as total_acciones,
l.idlae as lae,
v.cct as cve_centro,
v.nombre as nombre_centro
FROM vista_cct v
INNER JOIN r_pemcxescuela e ON v.cct = e.cct
LEFT JOIN r_pemc_objetivo o ON e.idpemc = o.idpemc
LEFT JOIN  r_pemc_objetivo_accion a ON o.idobjetivo = a.idobjetivo
INNER JOIN c_pemc_ambito am ON FIND_IN_SET(am.idambito, a.idambitos) > 0
INNER JOIN c_pemc_laes l ON am.idlae = l.idlae
WHERE
o.idpemc IN('{$idspemc}')
AND l.idlae=5
GROUP BY v.cct,l.idlae)
as t ON v.cct =t.cve_centro
WHERE v.cct IN('{$ccts}'))as l5 ON l1.cve_centro =l5.cve_centro";
  return $this->db->query($str_query)->result_array();
}

public function getGraficas($idspemc){
  $str_query = "SELECT
l.idlae, IFNULL(tlae.objetivos_r, 0) as obj, IFNULL(tlae.acciones_r, 0) as acc
FROM c_pemc_laes l
LEFT JOIN (
SELECT
laes.idlae, COUNT(DISTINCT am.idambito) as ambito_c, COUNT(a.idambitos) as ambitos_r,
COUNT(DISTINCT o.idobjetivo) as objetivos_r, COUNT(DISTINCT a.idaccion) as acciones_r
FROM c_pemc_laes laes
INNER JOIN c_pemc_ambito am ON laes.idlae = am.idlae
LEFT JOIN r_pemc_objetivo_accion a ON FIND_IN_SET(am.idambito, a.idambitos) > 0
LEFT JOIN r_pemc_objetivo o ON a.idobjetivo = o.idobjetivo
WHERE
 o.idpemc IN('{$idspemc}')
GROUP BY laes.idlae
) as tlae ON l.idlae =tlae.idlae
WHERE l.idlae!=6 AND l.idlae!=7";
return $this->db->query($str_query)->result_array();

}
function guarda_observacion_super($observacion, $idpemc){
  $status=false;
  $str_query = "SELECT idpemc FROM r_pemc_evaluacion WHERE idpemc = {$idpemc}";
  $idpemc_rtn = $this->db->query($str_query)->row('idpemc');
  date_default_timezone_set('America/Monterrey');
  setlocale(LC_TIME, 'es_MX.UTF-8');
  $fecha = date("Y-m-d H:i:s");
  if ($idpemc_rtn=='') {
    $data_req = array(
      'idpemc' =>$idpemc,
      'fcreacion_observacion' =>$fecha,
      'observacion_supervision' =>$observacion
    );
      $status = $this->db->insert('r_pemc_evaluacion', $data_req);
  }
  else {
    $this->db->set('observacion_supervision', $observacion);
    $this->db->set('fcreacion_observacion',$fecha);
    $this->db->where('idpemc', $idpemc);
    $status = $this->db->update('r_pemc_evaluacion');
  }
  return $status;
}
function obtener_supervision_xjefsector($jefatura){
  $str_query = "SELECT cct, turno, nombre, jefatura_de_sector
  FROM vista_cct
  WHERE (status='1' OR status ='4')
  AND tipo_centro=1
  AND jefatura_de_sector={$jefatura}";
  return  $this->db->query($str_query)->result_object();
}
function getGraficasxjefsector($jefatura){
  $str_query ="SELECT
l.idlae, IFNULL(tlae.objetivos, 0) as obj, IFNULL(tlae.acciones, 0) as acc
FROM c_pemc_laes l
LEFT JOIN (
SELECT
laes.idlae,COUNT(DISTINCT o.idobjetivo) as objetivos, COUNT(DISTINCT a.idaccion) as acciones
FROM c_pemc_laes laes
INNER JOIN c_pemc_ambito am ON laes.idlae = am.idlae
LEFT JOIN r_pemc_objetivo_accion a ON FIND_IN_SET(am.idambito, a.idambitos) > 0
LEFT JOIN r_pemc_objetivo o ON a.idobjetivo = o.idobjetivo
INNER JOIN r_pemcxescuela esc ON o.idpemc = esc.idpemc
INNER JOIN vista_cct v ON esc.cct = v.cct
WHERE v.tipo_centro=9
AND jefatura_de_sector='{$jefatura}'
AND (status='1' OR status ='4')
GROUP BY laes.idlae
) as tlae ON l.idlae =tlae.idlae
WHERE l.idlae!=6 AND l.idlae!=7";
  return $this->db->query($str_query)->result_array();
}
function getTablasGraficasxjefsector($jefatura){
  $str_query ="SELECT
l1.nombre_centro as nombre_centro,
l1.cve_centro as cve_centro,
IFNULL(l1.total_objetivos,0) as obj1,
IFNULL(l1.total_acciones,0) as acc1,
IFNULL(l2.total_objetivos,0) as obj2,
IFNULL(l2.total_acciones,0) as acc2,
IFNULL(l3.total_objetivos,0) as obj3,
IFNULL(l3.total_acciones,0) as acc3,
IFNULL(l4.total_objetivos,0) as obj4,
IFNULL(l4.total_acciones,0) as acc4,
IFNULL(l5.total_objetivos,0) as obj5,
IFNULL(l5.total_acciones,0) as acc5
FROM
(
SELECT
v.cct as cve_centro,
v.nombre as nombre_centro,
t.total_objetivos,
t.total_acciones
FROM vista_cct v
LEFT JOIN
(SELECT
v.cct as cve_centro,
v.nombre as nombre_centro,
COUNT(DISTINCT o.idobjetivo) as total_objetivos,
COUNT(DISTINCT a.idaccion) as total_acciones,
laes.idlae
FROM c_pemc_laes laes
INNER JOIN c_pemc_ambito am ON laes.idlae = am.idlae
LEFT JOIN r_pemc_objetivo_accion a ON FIND_IN_SET(am.idambito, a.idambitos) > 0
LEFT JOIN r_pemc_objetivo o ON a.idobjetivo = o.idobjetivo
INNER JOIN r_pemcxescuela esc ON o.idpemc = esc.idpemc
INNER JOIN vista_cct v ON esc.cct = v.cct
WHERE v.tipo_centro=9
AND jefatura_de_sector='{$jefatura}'
AND (status='1' OR status ='4')
AND laes.idlae =1
GROUP BY v.cct,laes.idlae)as t ON v.cct =t.cve_centro
WHERE (status='1' OR status ='4')
AND tipo_centro=9
AND jefatura_de_sector='{$jefatura}')as l1
INNER JOIN
(
SELECT
v.cct as cve_centro,
v.nombre as nombre_centro,
t.total_objetivos,
t.total_acciones
FROM vista_cct v
LEFT JOIN
(SELECT
v.cct as cve_centro,
v.nombre as nombre_centro,
COUNT(DISTINCT o.idobjetivo) as total_objetivos,
COUNT(DISTINCT a.idaccion) as total_acciones,
laes.idlae
FROM c_pemc_laes laes
INNER JOIN c_pemc_ambito am ON laes.idlae = am.idlae
LEFT JOIN r_pemc_objetivo_accion a ON FIND_IN_SET(am.idambito, a.idambitos) > 0
LEFT JOIN r_pemc_objetivo o ON a.idobjetivo = o.idobjetivo
INNER JOIN r_pemcxescuela esc ON o.idpemc = esc.idpemc
INNER JOIN vista_cct v ON esc.cct = v.cct
WHERE v.tipo_centro=9
AND jefatura_de_sector='{$jefatura}'
AND (status='1' OR status ='4')
AND laes.idlae =2
GROUP BY v.cct,laes.idlae)as t ON v.cct =t.cve_centro
WHERE (status='1' OR status ='4')
AND tipo_centro=9
AND jefatura_de_sector='{$jefatura}')as l2 ON l1.cve_centro =l2.cve_centro
INNER JOIN
(
SELECT
v.cct as cve_centro,
v.nombre as nombre_centro,
t.total_objetivos,
t.total_acciones
FROM vista_cct v
LEFT JOIN
(SELECT
v.cct as cve_centro,
v.nombre as nombre_centro,
COUNT(DISTINCT o.idobjetivo) as total_objetivos,
COUNT(DISTINCT a.idaccion) as total_acciones,
laes.idlae
FROM c_pemc_laes laes
INNER JOIN c_pemc_ambito am ON laes.idlae = am.idlae
LEFT JOIN r_pemc_objetivo_accion a ON FIND_IN_SET(am.idambito, a.idambitos) > 0
LEFT JOIN r_pemc_objetivo o ON a.idobjetivo = o.idobjetivo
INNER JOIN r_pemcxescuela esc ON o.idpemc = esc.idpemc
INNER JOIN vista_cct v ON esc.cct = v.cct
WHERE v.tipo_centro=9
AND jefatura_de_sector='{$jefatura}'
AND (status='1' OR status ='4')
AND laes.idlae =3
GROUP BY v.cct,laes.idlae)as t ON v.cct =t.cve_centro
WHERE (status='1' OR status ='4')
AND tipo_centro=9
AND jefatura_de_sector='{$jefatura}')as l3 ON l1.cve_centro =l3.cve_centro
INNER JOIN
(
SELECT
v.cct as cve_centro,
v.nombre as nombre_centro,
t.total_objetivos,
t.total_acciones
FROM vista_cct v
LEFT JOIN
(SELECT
v.cct as cve_centro,
v.nombre as nombre_centro,
COUNT(DISTINCT o.idobjetivo) as total_objetivos,
COUNT(DISTINCT a.idaccion) as total_acciones,
laes.idlae
FROM c_pemc_laes laes
INNER JOIN c_pemc_ambito am ON laes.idlae = am.idlae
LEFT JOIN r_pemc_objetivo_accion a ON FIND_IN_SET(am.idambito, a.idambitos) > 0
LEFT JOIN r_pemc_objetivo o ON a.idobjetivo = o.idobjetivo
INNER JOIN r_pemcxescuela esc ON o.idpemc = esc.idpemc
INNER JOIN vista_cct v ON esc.cct = v.cct
WHERE v.tipo_centro=9
AND jefatura_de_sector='{$jefatura}'
AND (status='1' OR status ='4')
AND laes.idlae =4
GROUP BY v.cct,laes.idlae)as t ON v.cct =t.cve_centro
WHERE (status='1' OR status ='4')
AND tipo_centro=9
AND jefatura_de_sector='{$jefatura}')as l4 ON l1.cve_centro =l4.cve_centro
INNER JOIN
(
SELECT
v.cct as cve_centro,
v.nombre as nombre_centro,
t.total_objetivos,
t.total_acciones
FROM vista_cct v
LEFT JOIN
(SELECT
v.cct as cve_centro,
v.nombre as nombre_centro,
COUNT(DISTINCT o.idobjetivo) as total_objetivos,
COUNT(DISTINCT a.idaccion) as total_acciones,
laes.idlae
FROM c_pemc_laes laes
INNER JOIN c_pemc_ambito am ON laes.idlae = am.idlae
LEFT JOIN r_pemc_objetivo_accion a ON FIND_IN_SET(am.idambito, a.idambitos) > 0
LEFT JOIN r_pemc_objetivo o ON a.idobjetivo = o.idobjetivo
INNER JOIN r_pemcxescuela esc ON o.idpemc = esc.idpemc
INNER JOIN vista_cct v ON esc.cct = v.cct
WHERE v.tipo_centro=9
AND jefatura_de_sector='{$jefatura}'
AND (status='1' OR status ='4')
AND laes.idlae =5
GROUP BY v.cct,laes.idlae)as t ON v.cct =t.cve_centro
WHERE (status='1' OR status ='4')
AND tipo_centro=9
AND jefatura_de_sector='{$jefatura}')as l5 ON l1.cve_centro =l5.cve_centro";
return $this->db->query($str_query)->result_array();
}
function pemc_xesc(){
  $str_query ="SELECT
             ct.nivel, ct.cct, ct.turno ,ct.zona_economica ,ct.zona_escolar, ct.cct_supervisor,ct.municipio,
             COUNT(DISTINCT obj.idobjetivo) as num_objetivos, COUNT(DISTINCT acc.idaccion) as num_acciones
            FROM
            (
            				SELECT
            				e.cct, t.idfederal,  t.descripcion as turno,
            				e.desc_nivel_educativo as nivel,
                    e.sostenimiento as id_sostenimiento,
                    e.desc_sostenimiento as sostenimiento,
                    e.zona_escolar,
            				m.municipio, m.zona_economica,
            				supervisiones.cct as cct_supervisor
                    FROM vista_cct e
                    INNER JOIN turno_temp t ON e.turno = t.idturno
            				LEFT JOIN municipio m ON e.municipio = m.id_vista_muni
            				LEFT JOIN (SELECT
            										cct, zona_escolar, sostenimiento, desc_nivel_educativo,SUBSTRING(cct, 3, 3) AS tipo
            									 FROM vista_cct cct
            									 WHERE (`status` = 1 OR `status` = 4) AND tipo_centro = 1
            									 ) AS supervisiones ON e.zona_escolar = supervisiones.zona_escolar AND e.sostenimiento = supervisiones.sostenimiento
                    WHERE
                    (e.status = 1 OR e.status = 4) AND e.tipo_centro=9
                    AND ((e.desc_nivel_educativo = 'CAM' AND (e.cct LIKE '05EML%' OR e.cct LIKE '05DML%' OR e.cct LIKE '05PML%'))
                    OR (e.desc_nivel_educativo = 'INICIAL')
                    OR (e.desc_nivel_educativo = 'PREESCOLAR' AND (e.cct LIKE '05DJN%' OR e.cct LIKE '05EJN%' OR e.cct LIKE '05PJN%'))
                    OR (e.desc_nivel_educativo = 'PRIMARIA' AND (e.cct LIKE '05DPR%' OR e.cct LIKE '05EPR%' OR e.cct LIKE '05PPR%'))
                    OR (e.desc_nivel_educativo = 'SECUNDARIA' AND (e.cct LIKE '05DES%' OR e.cct LIKE '05DST%' OR e.cct LIKE '05DTV%' OR e.cct LIKE '05PES%' OR e.cct LIKE '05EES%' OR e.cct LIKE '05EST%' OR e.cct LIKE '05ETV%'))
                    )
                    GROUP BY e.cct, t.idfederal
            ) AS ct
            LEFT JOIN r_pemcxescuela pemcxesc ON ct.cct = pemcxesc.cct AND ct.idfederal = pemcxesc.id_turno_single
            LEFT JOIN r_pemc_objetivo obj on pemcxesc.idpemc = obj.idpemc
            LEFT JOIN r_pemc_objetivo_accion acc ON obj.idobjetivo = acc.idobjetivo
            GROUP BY ct.cct, ct.turno";
    return $this->db->query($str_query)->result_array();
  }
}
