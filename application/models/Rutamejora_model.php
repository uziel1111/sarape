<?php
class Rutamejora_model extends CI_Model
{
  function __construct(){
    parent::__construct();
    date_default_timezone_set('America/Mexico_City');
  }

  function insert_tema_prioritario($id_cct,$id_prioridad,$objetivo1,$meta1,$objetivo2,$meta2,$problematica,$evidencia,$ids_progapoy,$otro_pa,$como_prog_ayuda,$obs_direct,$ids_apoyreq,$otroapoyreq,$especifiqueapyreq){
      // echo $ids_progapoy;die();
    $this->db->select('id_cct');
    $this->db->from('rm_tema_prioritarioxcct');
    $this->db->where("id_cct = '{$id_cct}'");
    $orden = $this->db->get()->num_rows()+1;

    $date=date("Y-m-d");
    $this->db->trans_start();
    $data = array(
     'orden' => $id_prioridad,
     'id_cct' => $id_cct,
     'id_prioridad' => $id_prioridad,
     'objetivo1' => $objetivo1,
     'objetivo2' => $objetivo2,
     'meta1' => $meta1,
     'meta2' => $meta2,
     'otro_problematica' => $problematica,
     'otro_evidencia' => $evidencia,
     'ids_programapoyo' => $ids_progapoy,
     'otro_pa' => $otro_pa,
     'como_ayudan_pa' => $como_prog_ayuda,
     'obs_direc' => $obs_direct,
     'ids_apoyo_req_se' => $ids_apoyreq,
     'otro_apoyo_req_se' => $otroapoyreq,
     'especifique_apoyo_req' => $especifiqueapyreq,
     'f_creacion' => $date,

   );
    
    $this->db->insert('rm_tema_prioritarioxcct', $data);
    $id_insertado_tmp = $this->db->insert_id();
    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE)
    {
      return false;
    }else{
      return $id_insertado_tmp;
    }
    $str_query = "";
					// echo $str_query; die();
    return $this->db->query($str_query)->result_array();
    }// guardaruta()

    function insert_accion($id_tprioritario, $accion, $materiales, $ids_responsables, $finicio, $ffin, $medicion, $otroresponsable, $existotroresp, $id_objetivo, $responsable, $otro_resp){
    	$data2 = array(
       'id_tprioritario' => $id_tprioritario,
       'accion' => $accion,
       'mat_insumos' => $materiales,
			'ids_responsables' => $ids_responsables,// el formato debe ser una cadena separa por comas ejem(1, 2, 3) =modificar el combo de responsable para multiselect=
			'otro_responsable' => ($existotroresp == true)? $otroresponsable : null,
			'f_creacion' => date("Y-m-d"),
			'f_mod' => date("Y-m-d"),
			'accion_f_inicio' => $finicio,
			'accion_f_termino' => $ffin,
			'indcrs_medicion' => $medicion,
      'id_objetivos' => $id_objetivo,
      'main_resp' => $responsable,
      'resp_apoyo' => $otro_resp
    );
    // echo "Inserta";echo "<pre>";print_r($this->db->insert('rm_accionxtproritario', $data2));die();
      return $this->db->insert('rm_accionxtproritario', $data2);
    }

    function getacciones($id_objetivo){
    	$str_query = "SELECT * FROM rm_accionxtproritario where id_objetivos = {$id_objetivo}";
            // echo "<pre>";print_r($str_query);die();
      return $this->db->query($str_query)->result_array();
    	// return $this->db->get_where('rm_accionxtproritario', array('id_tprioritario' => $id_tprioritario))->result_array();
    }

    function getacciones_supervisor($id_objetivo){
      $str_query = "SELECT * FROM rm_accionxtproritario where id_tprioritario = {$id_objetivo}";
            // echo "<pre>";print_r($str_query);die();
      return $this->db->query($str_query)->result_array();
      // return $this->db->get_where('rm_accionxtproritario', array('id_tprioritario' => $id_tprioritario))->result_array();
    }

    function guardaAvance($idactividad, $avance){
    	$data2 = array(
       'id_actividad' => $idactividad,
       'avance' => $avance,
       'f_mod_avance' => date(),
     );
      $this->db->insert('rm_avancexactividad', $data);
    }

    function deleteaccion($id_accion, $id_tprioritario){
    	$this->db->trans_start();
    	$this->db->where('id_accion', $id_accion);
    	$this->db->where('id_tprioritario', $id_tprioritario);
      $this->db->delete('rm_avance_xcctxtpxaccion');
      $this->db->where('id_accion', $id_accion);
      $this->db->where('id_tprioritario', $id_tprioritario);
      $this->db->delete('rm_accionxtproritario');
      // $str = $this->db->last_query();
      // echo $str; die();
      $this->db->trans_complete();

      if ($this->db->trans_status() === FALSE)
      {
       return false;
     }else{
       return true;
     }
   }

   function eliminaRuta($idruta){
     $this->db->trans_start();
     $this->db->where('id_actividad', $idactividad);
     $this->db->delete('rm_avancexactividad');
     $this->db->where('id_actividad', $idactividad);
     $this->db->delete('rm_tema_prioritarioxcct');
     $this->db->trans_complete();

     if ($this->db->trans_status() === FALSE)
     {
       return false;
     }else{
       return true;
     }
   }

   function recupera_ruta($idruta){

     $str_query = "SELECT * FROM rm_metaxcct mxcct
     INNER JOIN  rm_tema_prioritarioxcct temaxcct ON mxcct.id_cct = temaxcct.id_cct
     WHERE temaxcct.id_cct = 1";

     return $this->db->query($str_query)->result_array();
   }

   function getdatoscct($cct, $turno){
   /* $this->db->select('e.id_cct, e.cve_centro, e.nombre_centro, e.id_turno_single, ts.turno_single, n.nivel, e.nombre_director');
    $this->db->from('escuela e');
    $this->db->join('turno_single AS ts ',' e.id_turno_single = ts.id_turno_single');
    $this->db->join('nivel AS n ', 'n.id_nivel = e.id_nivel');
    $this->db->where("e.cve_centro = '{$cct}'");
    $this->db->where("ts.id_turno_single = {$turno}");*/

      // $this->db->get();
      // echo $this->db->last_query();die();
    // return  $this->db->get()->result_array();

    $str_query = "SELECT 
    #e.id_cct,
    e.cct as cve_centro,
    e.nombre as nombre_centro,
    e.turno as id_turno_single,
    e.desc_turno as turno_single,
    e.desc_nivel_educativo as nivel,
    CONCAT_WS(' ', e.nombre_director, e.apellido_paterno_director, e.apellido_materno_director) as nombre_director
    FROM
    centros_educativos.vista_cct e

    WHERE
    e.cct ='{$cct}'
    AND e.turno like '%{$turno}%'";
    return $this->db->query($str_query)->result_array();

  }

  function existe_misionxidcct($cct, $turno, $id_ciclo){
    $this->db->select('cct,turno');
    $this->db->from('rm_misionxcct');
    $this->db->where("cct = '{$cct}'");
    $this->db->where("turno = {$turno}");
    $this->db->where("id_ciclo = {$id_ciclo}");
    if ($this->db->get()->num_rows()>0) {
      return  true;
    }
    else {
      return false;
    }
  }

  function insert_misionxidcct($cct,$turno,$misioncct, $id_ciclo){
   $date=date("Y-m-d");
   $this->db->trans_start();
   /*$data = array(
          'id_cct' => $id_cct,//obtenemos el id de la cct cargada en la sesion
          'mision' => $misioncct,
          'id_ciclo' => $id_ciclo, //de donde obtenemos el idciclo?
          'f_crea' => $date,
        );*/

        $data = array(
          'cct' => $cct,//obtenemos el id de la cct cargada en la sesion
          'mision' => $misioncct,
          'id_ciclo' => $id_ciclo, //de donde obtenemos el idciclo?
          'f_crea' => $date,
          'turno' => $turno,
        );
   $this->db->insert('rm_misionxcct', $data);
   $this->db->trans_complete();
   if ($this->db->trans_status() === FALSE)
   {
    return false;
  }else{
    return true;
  }
}

function update_misionxidcct($cct,$turno,$misioncct, $id_ciclo){
  $date=date("Y-m-d");
  $this->db->trans_start();
  $data = array(
    'mision' => $misioncct,
    'id_ciclo' => $id_ciclo,
    'f_mod' => $date
  );

  $this->db->where('cct', $cct);
  $this->db->where('turno', $turno);
  $this->db->update('rm_misionxcct', $data);
  $this->db->trans_complete();
  if ($this->db->trans_status() === FALSE)
  {
   return false;
 }else{
   return true;
 }
}

function getTemasxcct($idcct){
  $str_query ="SELECT * FROM rm_tema_prioritarioxcct WHERE id_cct = {$idcct}";
    // echo $str_query;die();
  return $this->db->query($str_query)->result_array();
}

  // function actualizaTP(){
  //   $str_query ="SELECT * FROM rm_tema_prioritarioxcct WHERE id_cct = {$idcct}";
  //   return $this->db->query($str_query)->result_array();
  // }

function get_misionxcct($cct, $turno, $id_ciclo){
  $this->db->select('mision');
  $this->db->from('rm_misionxcct');
  $this->db->where("cct = '{$cct}'");
  $this->db->where("turno = {$turno}");
  $this->db->where("id_ciclo = {$id_ciclo}");

  return $this->db->get()->row('mision');

}

function update_order($orden, $idtema){
  $data = array(
    'orden' => $orden
  );

  $this->db->where('id_tprioritario', $idtema);
  $this->db->update('rm_tema_prioritarioxcct', $data);
}

function getrutasxcct($cct, $turno){
	$this->db->select("tpxcct.id_tprioritario, rmp.ambito, tpxcct.orden, tpxcct.id_cct, tpxcct.id_prioridad, tpxcct.otro_problematica, tpxcct.otro_evidencia, rmp.prioridad,
   SUM(IF(ISNULL(acc.id_accion),0,1)) as n_acciones,  IF((ISNULL(obj.id_objetivo) || obj.id_objetivo = ''), '','fas fa-check-circle') AS objetivos,IF((ISNULL(tpxcct.obs_supervisor) || tpxcct.obs_supervisor = ''),'','fas fa-check-circle') AS obs_supervisor,tpxcct.path_evidencia,
   IF ((ISNULL(tpxcct.path_evidencia) || tpxcct.path_evidencia = ''),'none','') as trae_path");
 $this->db->from('rm_tema_prioritarioxcct tpxcct');
 $this->db->join('rm_c_prioridad AS rmp ',' rmp.id_prioridad = tpxcct.id_prioridad');
 $this->db->join('rm_accionxtproritario as acc', 'tpxcct.id_tprioritario = acc.id_tprioritario', 'left');
 $this->db->join('rm_objetivo AS obj', 'tpxcct.id_tprioritario = obj.id_tprioritario', 'left');
 $this->db->where("tpxcct.cct = '{$cct}'");
 $this->db->where("tpxcct.turno = {$turno}");
 $this->db->group_by("tpxcct.id_tprioritario");
 $this->db->order_by("tpxcct.orden", "asc");
         // $this->db->get();
    // $str = $this->db->last_query();
    // echo $str; die();
 return  $this->db->get()->result_array();
}

function  get_datos_edith_tp($id_tprioritario){
  $this->db->select('
    id_tprioritario,
    id_prioridad,
    objetivo1,
    objetivo2,
    meta1,
    meta2,
    otro_problematica,
    otro_evidencia,
    ids_programapoyo,
    otro_pa,
    como_ayudan_pa,
    obs_direc,
    obs_supervisor,
    ids_apoyo_req_se,
    otro_apoyo_req_se,
    especifique_apoyo_req,
    path_evidencia
    ');
  $this->db->from('rm_tema_prioritarioxcct');
  $this->db->where("id_tprioritario = {$id_tprioritario}");
  return  $this->db->get()->result_array();
}

function  get_obs_super_tp($id_tprioritario){
  $this->db->select('
    obs_supervisor
    ');
  $this->db->from('rm_tema_prioritarioxcct');
  $this->db->where("id_tprioritario = {$id_tprioritario}");
  return  $this->db->get()->row('obs_supervisor');

}

function update_tema_prioritario($id_cct,$id_tprioritario,$id_prioridad,$objetivo1,$meta1,$objetivo2,$meta2,$problematica,$evidencia,$ids_progapoy,$otro_pa,$como_prog_ayuda,$obs_direct,$ids_apoyreq,$otroapoyreq,$especifiqueapyreq){
    // echo $ids_progapoy;die();

  $date=date("Y-m-d");
  $this->db->trans_start();
  $data = array(
    'id_prioridad' => $id_prioridad,
    'objetivo1' => $objetivo1,
    'objetivo2' => $objetivo2,
    'meta1' => $meta1,
    'meta2' => $meta2,
    'otro_problematica' => $problematica,
    'otro_evidencia' => $evidencia,
    'ids_programapoyo' => $ids_progapoy,
    'otro_pa' => $otro_pa,
    'como_ayudan_pa' => $como_prog_ayuda,
    'obs_direc' => $obs_direct,
    'ids_apoyo_req_se' => $ids_apoyreq,
    'otro_apoyo_req_se' => $otroapoyreq,
    'especifique_apoyo_req' => $especifiqueapyreq,
    'f_mod' => $date,
  );
  $this->db->where('id_tprioritario', $id_tprioritario);
  $this->db->where('id_cct', $id_cct);
  $this->db->update('rm_tema_prioritarioxcct', $data);
  $this->db->trans_complete();

  if ($this->db->trans_status() === FALSE)
  {
    return false;
  }else{
    return true;
  }
  $str_query = "";
        // echo $str_query; die();
  return $this->db->query($str_query)->result_array();
}

function delete_tema_prioritario($id_cct,$id_tprioritario){

  $this->db->trans_start();
  $tables = array('rm_avance_xcctxtpxaccion','rm_accionxtproritario', 'rm_objetivo', 'rm_tema_prioritarioxcct');
  $this->db->where('id_tprioritario', $id_tprioritario);
  $this->db->delete($tables);
  $this->db->trans_complete();
  if ($this->db->trans_status() === FALSE)
  {
    return false;
  }else{
    return true;
  }
    // $str_query = "";
    //     // echo $str_query; die();
    //   return $this->db->query($str_query)->result_array();
}

function get_avances_tp_accionxcct($cct, $turno){
  $str_query = "SELECT
  tp.id_tprioritario, p.prioridad, o.id_objetivo, upper(o.objetivo) as objetivo, o.id_tprioritario as ob_tp, a.id_accion, a.accion, a.id_objetivos, tp.id_cct,
  IFNULL(av.cte1,0) as cte1,IFNULL(av.cte2,0) as cte2,IFNULL(av.cte3,0) as cte3,
  IFNULL(av.cte4,0) as cte4,IFNULL(av.cte5,0) as cte5,IFNULL(av.cte6,0) as cte6,
  IFNULL(av.cte7,0) as cte7,IFNULL(av.cte8,0) as cte8, '' as icono,
  datediff(a.accion_f_termino, a.accion_f_inicio) as 'periodo', 
  datediff(a.accion_f_termino, now()) as 'restante'
  FROM rm_tema_prioritarioxcct tp
  INNER JOIN rm_c_prioridad p on tp.id_prioridad=p.id_prioridad
  LEFT JOIN rm_objetivo o ON tp.id_tprioritario=o.id_tprioritario
  LEFT JOIN rm_accionxtproritario a on o.id_objetivo=a.id_objetivos
  LEFT JOIN rm_avance_xcctxtpxaccion av ON tp.cct = av.cct AND tp.id_tprioritario = av.id_tprioritario AND a.id_accion = av.id_accion
  WHERE tp.cct = '{$cct}' AND tp.turno = {$turno} AND a.accion is not null
  ORDER BY tp.orden, tp.id_tprioritario, a.id_accion DESC";
        // echo "<pre>";print_r($str_query); die();
  return $this->db->query($str_query)->result_array();

}

/*111019*/
function get_avances_tp_accionxcct_super($id_cct,$turno){
  $str_query = "SELECT
  tp.id_tprioritario, p.prioridad, o.id_objetivo, upper(o.objetivo) as objetivo, o.id_tprioritario as ob_tp, a.id_accion, a.accion, a.id_objetivos, tp.id_cct,
  IFNULL(av.cte1,0) as cte1,IFNULL(av.cte2,0) as cte2,IFNULL(av.cte3,0) as cte3,
  IFNULL(av.cte4,0) as cte4,IFNULL(av.cte5,0) as cte5,IFNULL(av.cte6,0) as cte6,
  IFNULL(av.cte7,0) as cte7,IFNULL(av.cte8,0) as cte8, '' as icono,
  datediff(a.accion_f_termino, a.accion_f_inicio) as 'periodo', 
  datediff(a.accion_f_termino, now()) as 'restante'
  FROM rm_tema_prioritarioxcct tp
  INNER JOIN rm_c_prioridad p on tp.id_prioridad=p.id_prioridad
  LEFT JOIN rm_objetivo o ON tp.id_tprioritario=o.id_tprioritario
  LEFT JOIN rm_accionxtproritario a on o.id_objetivo=a.id_objetivos
  LEFT JOIN rm_avance_xcctxtpxaccion av ON tp.id_cct = av.id_cct AND tp.id_tprioritario = av.id_tprioritario AND a.id_accion = av.id_accion
  #INNER JOIN centros_educativos.vista_cct e on e.cct = tp.cct AND e.turno = tp.turno
  WHERE av.cct = '{$id_cct}' and av.turno = {$turno}
  ORDER BY tp.orden, tp.id_tprioritario, a.id_accion DESC";
        // echo "<pre>";print_r($str_query); die();
  return $this->db->query($str_query)->result_array();

}
/*111019*/


function accionesRezagadas($id_cct,$turno,$cte_vigente){
  $str_query = "SELECT 
  IFNULL(av.{$cte_vigente},0) as porcentaje,a.accion,a.id_accion,
  (datediff(a.accion_f_termino, a.accion_f_inicio)*24) as 'total_horas',
  ((datediff(a.accion_f_termino, a.accion_f_inicio)*24)/3) as 'dias_restantes', 
  (datediff(a.accion_f_termino, now())*24) as 'dias_restantes_hoy'
  ,DATE_FORMAT(a.accion_f_termino,'%m-%d-%Y') AS f_termino, DATE_FORMAT(a.accion_f_inicio,'%m-%d-%Y') AS f_inicio
  FROM rm_tema_prioritarioxcct tp
  INNER JOIN rm_c_prioridad p on tp.id_prioridad=p.id_prioridad
  INNER JOIN rm_objetivo o ON tp.id_tprioritario=o.id_tprioritario
  INNER JOIN rm_accionxtproritario a on o.id_objetivo=a.id_objetivos
  LEFT JOIN rm_avance_xcctxtpxaccion av on tp.id_tprioritario = av.id_tprioritario 
  AND a.id_accion = av.id_accion
  WHERE tp.cct = '{$id_cct}' AND tp.turno = {$turno}
  ORDER BY tp.orden, tp.id_tprioritario, a.id_accion DESC";
        // echo "<pre>";print_r($str_query); die();
  return $this->db->query($str_query)->result_array();
}

function existe_avance($var_id_cct,$turno,$var_id_idtp,$var_id_idacc){
  $this->db->select('cct, turno');
  $this->db->from('rm_avance_xcctxtpxaccion');
  $this->db->where("cct = '{$var_id_cct}'");
  $this->db->where("turno = '{$turno}'");
  $this->db->where("id_tprioritario = '{$var_id_idtp}'");
  $this->db->where("id_accion = '{$var_id_idacc}'");
  if ($this->db->get()->num_rows() == 0)
  {
   return false;
 }else{
   return true;
 }

}

function insert_avance($var_id_cct,$turno,$var_id_idtp,$var_id_idacc){
 $this->db->trans_start();
 $data = array(
           'cct' => $var_id_cct,//obtenemos el id de la cct cargada en la sesion
           'id_tprioritario' => $var_id_idtp,
           'id_accion' => $var_id_idacc, //de donde obtenemos el idciclo?
           'turno' => $turno,
         );
 $this->db->insert('rm_avance_xcctxtpxaccion', $data);
 $this->db->trans_complete();
 if ($this->db->trans_status() === FALSE)
 {
   return false;
 }else{
   return true;
 }

}

function update_avance_xcte($val_slc,$var_id_cte,$var_id_cct,$turno,$var_id_idtp,$var_id_idacc){
  $date=date("Y-m-d");
  $this->db->trans_start();
  $data = array(
           "cte{$var_id_cte}" => $val_slc,//
           "f_mod{$var_id_cte}" => $date,
         );
  $this->db->where("cct = '{$var_id_cct}'");
  $this->db->where("turno = '{$turno}'");
  $this->db->where("id_tprioritario = '{$var_id_idtp}'");
  $this->db->where("id_accion = '{$var_id_idacc}'");
  $this->db->update('rm_avance_xcctxtpxaccion', $data);
  $this->db->trans_complete();
  if ($this->db->trans_status() === FALSE)
  {
   return false;
 }else{
   return true;
 }

}

function edit_accion($id_accion, $id_tprioritario){
  	// echo $id_accion; die();
 return $this->db->get_where('rm_accionxtproritario', array('id_accion' => $id_accion, 'id_tprioritario' => $id_tprioritario))->result_array();
}

function update_accion($id_accion, $id_tprioritario, $accion, $materiales, $ids_responsables, $finicio, $ffin, $medicion, $otroresponsable, $existotroresp, $id_objetivo, $main_resp, $otro_resp){
 $data2 = array(
   'id_tprioritario' => $id_tprioritario,
   'accion' => $accion,
   'mat_insumos' => $materiales,
			'ids_responsables' => $ids_responsables,// el formato debe ser una cadena separa por comas ejem(1, 2, 3) =modificar el combo de responsable para multiselect=
			'otro_responsable' => ($existotroresp == true)? $otroresponsable : null,
			'f_creacion' => date("Y-m-d"),
			'f_mod' => date("Y-m-d"),
			'accion_f_inicio' => $finicio,
			'accion_f_termino' => $ffin,
			'indcrs_medicion' => $medicion,
      'id_objetivos' => $id_objetivo,
      'main_resp' => $main_resp,
      'resp_apoyo' => $otro_resp
    );
 $this->db->where('id_accion', $id_accion);
    // echo "<pre>";print_r($data2);die();
    // echo "Actualiza";echo "<pre>";print_r($this->db->update('rm_accionxtproritario', $data2));die();
 return $this->db->update('rm_accionxtproritario', $data2);
}
function get_indicadoresxcct($id_cct,$nombre_nivel,$bimestre,$anio){
  $data = array();
  $str_query1 = "SELECT alumn_t_t as n_alumn911 FROM estadistica_e_indicadores_xcct WHERE id_cct={$id_cct} and id_ciclo=2";
  $str_query2 = "SELECT
  COUNT(curp) as n_alumn_ce,
  IFNULL(SUM(IF(((IF(extraedad>1,1,0)) + (IF(falta_bim1>7, 2,IF(falta_bim1>3, 1,0))) + (IF(espanol_b1<6 AND espanol_b1>0,1,0)) + (IF(matematicas_b1<6 and matematicas_b1>0,1,0)))>2,1,0)), 0) as muy_alto,
  SUM(extraedad) as n_alum_extraedad
  FROM alumnos_riesgo_primaria WHERE id_cct={$id_cct} AND ciclo='2017-2018'";
  $str_query3 = "SELECT lyc_i, mat_i FROM planeaxescuela WHERE id_cct={$id_cct} AND periodo='2016'";


  $data['n_alum911'] = $this->db->query($str_query1)->row('n_alumn911');
  $data['n_alumct'] = $this->db->query($str_query2)->row('n_alumn_ce');
  $data['n_alum_muyaltoriesgo'] = $this->db->query($str_query2)->row('muy_alto');
  $data['n_alum_extraedad'] = $this->db->query($str_query2)->row('n_alum_extraedad');
  $data['lyc1'] = $this->db->query($str_query3)->row('lyc_i');
  $data['mat1'] = $this->db->query($str_query3)->row('mat_i');

  return $data;
}

function get_datos_modal($id_tprioritario){
 $str_query = "SELECT p.prioridad, txcct.otro_problematica, txcct.otro_evidencia, txcct.ambito FROM rm_tema_prioritarioxcct txcct
 INNER JOIN rm_c_prioridad p ON p.id_prioridad = txcct.id_prioridad
 WHERE id_tprioritario = {$id_tprioritario}";
 return $this->db->query($str_query)->result_array();
}

function insert_evidencia($id_cct,$estatus,$ruta_archivos_save){
  $this->db->trans_start();
  $data = array(
    "path_evidencia" => $ruta_archivos_save,
  );
      // echo "<pre>";print_r($data);die();
  $this->db->where("id_cct = '{$id_cct}'");
  $this->db->where("id_tprioritario = '{$estatus}'");
  $this->db->update('rm_tema_prioritarioxcct', $data);
  $this->db->trans_complete();

  if ($this->db->trans_status() === FALSE) {
    return false;
  }else{
    return true;
  }
}

function get_url_evidencia($id_cct,$id_tprioritario){
  $this->db->select('path_evidencia');
  $this->db->from('rm_tema_prioritarioxcct');
  $this->db->where("id_cct = '{$id_cct}'");
  $this->db->where("id_tprioritario = {$id_tprioritario}");

  return $this->db->get()->row('path_evidencia');

}

function get_avances_tp_accionxcct_fechas($id_ciclo){
  $date=date("Y-m-d");
  $str_query = "SELECT
  IF(NOW()>cte1_f_ini AND NOW()<cte1_f_fin, 'TRUE', 'FALSE') AS cte1_var,
  IF(NOW()>cte2_f_ini AND NOW()<cte2_f_fin, 'TRUE', 'FALSE') AS cte2_var,
  IF(NOW()>cte3_f_ini AND NOW()<cte3_f_fin, 'TRUE', 'FALSE') AS cte3_var,
  IF(NOW()>cte4_f_ini AND NOW()<cte4_f_fin, 'TRUE', 'FALSE') AS cte4_var,
  IF(NOW()>cte5_f_ini AND NOW()<cte5_f_fin, 'TRUE', 'FALSE') AS cte5_var,
  IF(NOW()>cte6_f_ini AND NOW()<cte6_f_fin, 'TRUE', 'FALSE') AS cte6_var,
  IF(NOW()>cte7_f_ini AND NOW()<cte7_f_fin, 'TRUE', 'FALSE') AS cte7_var,
  IF(NOW()>cte8_f_ini AND NOW()<cte8_f_fin, 'TRUE', 'FALSE') AS cte8_var,
  IF(NOW()>cte9_f_ini AND NOW()<cte9_f_fin, 'TRUE', 'FALSE') AS cte9_var,
  IF(NOW()>cte10_f_ini AND NOW()<cte10_f_fin, 'TRUE', 'FALSE') AS cte10_var
  FROM rm_f_mod_avancexaccionxcte WHERE id_ciclo={$id_ciclo} ";
          // echo "<pre>";print_r($str_query); die();
  return $this->db->query($str_query)->result_array();

}


    //FUNCIONAMIENTO Y VALIDACION PARA SUPERVISOR BY LUIS SANCHEZ... all reserved rights

function valida_supervisor($cct){
 $str_query = "SELECT * FROM supervision WHERE cct_supervision = '{$cct}'";
 return $this->db->query($str_query)->result_array();
}

function inserta_mensaje_super($idtema, $mensaje_super){
 $data = array(
   'obs_supervisor' => $mensaje_super
 );

 $this->db->where('id_tprioritario', $idtema);
 return $this->db->update('rm_tema_prioritarioxcct', $data);
}

function getdatossupervicion($cct){
  $str_query = "SELECT s.id_supervision, s.zona_escolar, s.nombre_supervision, '{$cct}' AS cve_centro
  FROM supervision s
  WHERE s.id_supervision = '{$cct}'";
  return $this->db->query($str_query)->result_array();
}

function get_coment_super($idtemap){
 $str_query = "SELECT obs_supervisor FROM rm_tema_prioritarioxcct WHERE id_tprioritario = {$idtemap}";
 return $this->db->query($str_query)->result_array();
}

    //Nuevas funciones para RM Ismael Castillo
function insertaObjetivo($cct, $turno, $id_prioridad, $objetivo, $id_tprioritario){
  $date=date("Y-m-d");

  $objetivos = array(
    'objetivo' => $objetivo,
    'id_tprioritario' => $id_tprioritario,
    'cct'=> $cct,
    'turno' => $turno, 
    'fecha_creacion' => $date
  );
        // echo "<pre>";print_r($this->db->insert('rm_objetivo', $objetivos));die();
  if($this->db->insert('rm_objetivo', $objetivos)){
    $response = array(
      'status' => true,
      'idtemaprioritario' => $id_tprioritario
    );
  }else{
    $response = array(
      'status' => false,
      'idtemaprioritario' => 0
    );
  }
  return $response;
}

function insertaCreaObjetivo($id_cct, $id_prioridad, $objetivo, $id_subprioridad){
  $this->db->select('id_cct');
  $this->db->from('rm_tema_prioritarioxcct');
  $this->db->where('id_cct', $id_cct);
  $orden = $this->db->get()->num_rows()+1;

  $this->db->trans_start();
  if($id_prioridad == 1){
    $datos = array(
      'id_cct' => $id_cct,
      'id_prioridad' => $id_prioridad,
      'id_subprioridad' => $id_subprioridad,
      'orden' => $orden
    );
  }else{
    $datos = array(
      'id_cct' => $id_cct,
      'id_prioridad' => $id_prioridad,
      'orden' => $orden
    );
  }

      // echo "<pre>";print_r($datos);die();
  $this->db->insert('rm_tema_prioritarioxcct', $datos);
      //$id_tprioritario = $this->db->insert_id(); // Recuperamos el ultimo id generado

  $this->db->trans_complete();
  $response = array();

  if ($this->db->trans_status() === FALSE)
  {
    $response = array(
      'status' => false,
      'idtemaprioritario' => 0
    );
    return $response;
  }else{
    $objetivos = array(
      'objetivo' => $objetivo,
      'id_tprioritario' => $id_tprioritario,
      'orden' => $orden,
      'id_cct'=> $id_cct
    );
    $this->db->insert('rm_objetivo', $objetivos);
    $response = array(
      'status' => true,
      'idtemaprioritario' => $id_tprioritario
    );
    return $response;
  }
}

function actualizaObjetivo($id_objetivo, $objetivo){
  $datos = array('objetivo' => $objetivo );

      // echo "<pre>";print_r($datos);die();
  $this->db->where('id_objetivo', $id_objetivo);
  $this->db->update('rm_objetivo', $datos);
}



function getSubprioridad($idprioridad){
  $str_query ="select id_subprioridad, subprioridad from rm_c_subprioridad where id_prioridad = {$idprioridad}";
  return $this->db->query($str_query)->result_array();
}

function getIndicadorEspecial($id_prioridad, $id_nivel, $id_subprioridad){
      // $especial = "";
      // $condicion = "";
      // if ($id_prioridad == 1) {
      //   $especial = "inner join rm_c_subprioridad subp on ind.id_subprioridad = subp.id_subprioridad";
      //   $condicion = " and ind.id_subprioridad = {$id_subprioridad}";
      // }

  $str_query = "SELECT ind.id_indicador, ind.indicador FROM rm_c_indicador ind
  WHERE ind.id_c_prioridad = {$id_prioridad} AND ind.nivel = {$id_nivel}";

      // $str_query = "select ind.id_indicador, ind.indicador from rm_c_indicador ind
      //               {$especial}
      //               where ind.id_c_prioridad = {$id_prioridad} and ind.nivel = {$id_nivel} {$condicion}";
      // echo "<pre>";print_r($str_query);die();
  return $this->db->query($str_query)->result_array();
}

function getMetricas($id_indicador){
  $str_query = "select ind.formula from rm_c_indicador ind where ind.id_indicador = {$id_indicador}";
  return $this->db->query($str_query)->result_array();
}

function getObjetivos($cct, $turno, $id_tprioritario, $idprioridad){
  $str_query = "SELECT * FROM rm_tema_prioritarioxcct tprio
  LEFT JOIN rm_objetivo obj ON obj.id_tprioritario = tprio.id_tprioritario
  WHERE tprio.cct = '{$cct}' AND tprio.turno = {$turno} AND tprio.id_tprioritario = {$id_tprioritario} AND tprio.id_prioridad = {$idprioridad} ORDER BY obj.id_objetivo DESC";
      // echo "<pre>";print_r($str_query);die();
  return $this->db->query($str_query)->result_array();
}

function getObjetivosSuper($id_cct, $turno ,$id_tprioritario){
  $str_query = "SELECT * FROM rm_tema_prioritarioxcct tprio
  LEFT JOIN rm_objetivo obj ON obj.id_tprioritario = tprio.id_tprioritario
  #INNER JOIN escuela e on e.id_cct = tprio.id_cct
  WHERE tprio.cct = '{$id_cct}' AND  tprio.turno = {$turno} AND tprio.id_tprioritario = {$id_tprioritario} ORDER BY obj.id_objetivo DESC";
      // echo "<pre>";print_r($str_query);die();
  return $this->db->query($str_query)->result_array();
}

function grabarTema($cct, $turno,$id_tprioritario, $problematica, $evidencia, $comentario_dir){
  $date = date("Y-m-d");

      //Iniciar transaccion
  $datos = array(
    'id_tprioritario' => $id_tprioritario,
    'otro_problematica' => $problematica,
    'otro_evidencia' => $evidencia,
    'obs_direc' => $comentario_dir,
    'f_creacion' => $date
  );

      // echo "<pre>";print_r($datos);die();
  $this->db->where('id_tprioritario', $id_tprioritario);
  $this->db->where('cct', $cct);
  $this->db->where('turno', $turno);
  $this->db->update('rm_tema_prioritarioxcct', $datos);
      // $id_insertado_tmp = $this->db->insert_id();

  return true;

}

function edith_tp($id_tprioritario){
  $str_query = "SELECT obj.id_tprioritario, tprioritario.id_prioridad, tprioritario.id_subprioridad,  tprioritario.otro_problematica,
  tprioritario.otro_evidencia, tprioritario.path_evidencia,
  tprioritario.obs_supervisor, tprioritario.obs_direc, obj.id_objetivo, obj.objetivo, tprioritario.ambito
  FROM rm_tema_prioritarioxcct tprioritario
  LEFT JOIN rm_objetivo obj ON obj.id_tprioritario = tprioritario.id_tprioritario
  WHERE tprioritario.id_tprioritario = {$id_tprioritario}
  ";
    // echo "<pre>";print_r($str_query); die();
  return $this->db->query($str_query)->result_array();
}


function getObjetivo($id_objetivo){
  $str_query = "SELECT objetivo FROM rm_objetivo WHERE id_objetivo = {$id_objetivo}";
      // echo "<pre>";print_r($str_query); die();

  return $this->db->query($str_query)->result_array();
}

function borrarObjetivo($id_objetivo){

      //Este query hay que arreglarlo, debe recibir el id_tpriotario

  $str_query = "SELECT id_accion FROM rm_accionxtproritario WHERE id_objetivos = {$id_objetivo}";
  $idsacciones = $this->db->query($str_query)->result_array();
      // echo "<pre>"; print_r($idsacciones); die();
  $cadena = "";
  foreach ($idsacciones as $accion) {
    $cadena .= $accion['id_accion'].",";
  }
  $cadena = substr($cadena, 0, -1);
      // echo $cadena; die();
  $this->db->where_in('id_accion', explode(",", $cadena));
  if($this->db->delete('rm_avance_xcctxtpxaccion')){
    $this->db->where('id_objetivos', $id_objetivo);
    if($this->db->delete('rm_accionxtproritario')){
      $this->db->where('id_objetivo', $id_objetivo);
      return $this->db->delete('rm_objetivo');
    }else{
      return false;
    }
  }else{
    return false;
  }



      //$this->db->reset_query();



}

function deleteTP($id_tprioritario){
      // echo $id_tprioritario;die();
  $this->db->trans_start();
  $tables = array('rm_avance_xcctxtpxaccion','rm_accionxtproritario', 'rm_objetivo', 'rm_tema_prioritarioxcct');
  $this->db->where('id_tprioritario', $id_tprioritario);
  $this->db->delete($tables);
  $this->db->trans_complete();

  if ($this->db->trans_status() === FALSE){
    return false;
  }else{
    return true;
  }
}

function getEvidencia($id_tprioritario){
  $str_query = "SELECT path_evidencia FROM rm_tema_prioritarioxcct WHERE id_tprioritario = {$id_tprioritario}";

  return $this->db->query($str_query)->result_array();
}

function deleteEvidencia($id_tprioritario){
  $data = array(
    'path_evidencia' => ''
  );
  $this->db->where('id_tprioritario', $id_tprioritario);
  return $this->db->update('rm_tema_prioritarioxcct', $data);
}

function getPrioridades($cct, $turno){
  $str_query = "SELECT tp.id_tprioritario, p.ambito, o.id_objetivo, a.id_accion, tp.orden, p.prioridad, p.id_prioridad,
  COUNT(DISTINCT o.id_objetivo) as num_objetivos, COUNT(DISTINCT a.id_accion) as num_acciones
  FROM rm_tema_prioritarioxcct tp
  INNER JOIN rm_c_prioridad p on tp.id_prioridad=p.id_prioridad
  LEFT JOIN rm_objetivo o ON tp.id_tprioritario=o.id_tprioritario
  LEFT JOIN rm_accionxtproritario a on o.id_objetivo=a.id_objetivos
  WHERE tp.cct = '{$cct}'
  AND tp.turno = {$turno}
  GROUP BY tp.id_tprioritario
  ORDER by tp.orden";
      // echo "<pre>";print_r($str_query);die();
  return $this->db->query($str_query)->result_array();
}

function insertaTprioritarios($cct, $turno){

  /*$data = array (
    array(  'orden'=> 1,
      'id_cct' => $id_cct,
      'id_prioridad'=> 1,
      'id_subprioridad'=> 1,
    ),


    array(  'orden'=> 2,
      'id_cct' => $id_cct,
      'id_prioridad'=> 2,
      'id_subprioridad'=> '',
    ),

    array(  'orden'=> 3,
      'id_cct' => $id_cct,
      'id_prioridad'=> 3,
      'id_subprioridad'=> '',
    ),

    array(  'orden'=> 4,
      'id_cct' => $id_cct,
      'id_prioridad'=> 4,
      'id_subprioridad'=> '',
    ),

    array(  'orden'=> 5,
      'id_cct' => $id_cct,
      'id_prioridad'=> 5,
      'id_subprioridad'=> '',
    ),
  );*/

  $data = array (
    array(  'orden'=> 1,
      'id_prioridad'=> 1,
      'id_subprioridad'=> 1,
      'cct' => $cct,
      'turno' => $turno,
    ),


    array(  'orden'=> 2,
      'id_prioridad'=> 2,
      'id_subprioridad'=> '',
      'cct' => $cct,
      'turno' => $turno,
    ),

    array(  'orden'=> 3,
      'id_prioridad'=> 3,
      'id_subprioridad'=> '',
      'cct' => $cct,
      'turno' => $turno,
    ),

    array(  'orden'=> 4,
      'id_prioridad'=> 4,
      'id_subprioridad'=> '',
      'cct' => $cct,
      'turno' => $turno,
    ),

    array(  'orden'=> 5,
      'id_prioridad'=> 5,
      'id_subprioridad'=> '',
      'cct' => $cct,
      'turno' => $turno,
    ),
  );

  $this->db->insert_batch('rm_tema_prioritarioxcct',$data);

}

function evidenciaObjInicio($id_objetivo, $ruta_archivos_save, $id_tprioritario){

  $data = array(
    "path_ev_inicio" => $ruta_archivos_save,
  );

  $this->db->where("id_objetivo = '{$id_objetivo}'");
  return $this->db->update('rm_objetivo', $data);
        // echo "<pre>";print_r($this->db->update('rm_objetivo', $data));die();

}

function evidenciaObjFin($id_objetivo, $ruta_archivos_save, $id_tprioritario){
  $data = array(
    "path_ev_fin" => $ruta_archivos_save,
  );

  $this->db->where("id_objetivo = '{$id_objetivo}'");
        // echo "<pre>";print_r($this->db->update('rm_objetivo', $data));die();
  return $this->db->update('rm_objetivo', $data);

}

function getEvidenciaInicio($id_objetivo){
  $str_query = "SELECT path_ev_inicio FROM rm_objetivo WHERE id_objetivo = {$id_objetivo}";
      // echo "<pre>";print_r($str_query);die();
  return $this->db->query($str_query)->result_array();
}

function getEvidenciaFin($id_objetivo){
  $str_query = "SELECT path_ev_fin FROM rm_objetivo WHERE id_objetivo = {$id_objetivo}";
      // echo "<pre>";print_r($str_query);die();
  return $this->db->query($str_query)->result_array();
}

function getActxObj($id_tprioritario){
  $str_query = "SELECT ob.id_objetivo, ob.id_tprioritario, ob.objetivo FROM rm_objetivo ob
  INNER JOIN rm_accionxtproritario acp ON ob.id_tprioritario = acp.id_tprioritario
  WHERE ob.id_tprioritario = {$id_tprioritario}";
  return $this->db->query($str_query)->result_array();
}

function getObjxTp($id_tprioritario){
  $str_query = "SELECT id_objetivo, objetivo, id_tprioritario FROM rm_objetivo WHERE id_tprioritario = {$id_tprioritario} ";
  return $this->db->query($str_query)->result_array();
}

function deleteEvidenciaObjIni($id_objetivo){
  $data = array(
    'path_ev_inicio' => ''
  );
  $this->db->where('id_objetivo', $id_objetivo);
      // echo "<pre>";print_r($this->db->update('rm_objetivo', $data));die();
  return $this->db->update('rm_objetivo', $data);
}

function deleteEvidenciaObjFin($id_objetivo){
  $data = array(
    'path_ev_fin' => ''
  );
  $this->db->where('id_objetivo', $id_objetivo);
      // echo "<pre>";print_r($this->db->update('rm_objetivo', $data));die();
  return $this->db->update('rm_objetivo', $data);
}

function getAccxObj($id_objetivo){
  $str_query = "SELECT acc.id_accion, acc.accion, acc.mat_insumos, acc.accion_f_inicio, acc.accion_f_termino
  FROM rm_accionxtproritario acc
  INNER JOIN rm_objetivo obj ON acc.id_objetivos = obj.id_objetivo
  WHERE acc.id_objetivos = {$id_objetivo}";
      // echo "<pre>";print_r($str_query);die();
  return $this->db->query($str_query)->result_array();
}

function getObjetivosxTp($id_cct){
  $str_query = "SELECT tp.id_tprioritario, ob.id_objetivo, ob.objetivo FROM rm_tema_prioritarioxcct tp
  INNER JOIN rm_objetivo ob ON ob.id_tprioritario = tp.id_tprioritario
  WHERE tp.id_cct = {$id_cct}
  ORDER BY tp.id_tprioritario";
  return $this->db->query($str_query)->result_array();
}

public function publicar_objetivo($data)
{
  $this->db->query("UPDATE rm_objetivo SET estado_publicacion = {$data['estado_publicacion']} WHERE id_objetivo = {$data['id']};"); 
}

public function set_observacion($objetivo, $resultados, $obstaculos, $ventajas, $ajustes) {
  $this->db->query("UPDATE rm_avance_xcctxtpxaccion SET obs_resultado = '{$resultados}', obs_obstaculo = '{$obstaculos}', obs_beneficio = '{$ventajas}', obs_ajuste = '{$ajustes}' WHERE id_accion = {$objetivo}; ");

       // echo "<pre>";print_r($str_query);die();
      // return $this->db->query($str_query)->result_array();
}

public function avancesxcctxaccion($id_cct,$turno,$cte_vigente){

  $str_query = "SELECT ac.id_accion,IF(LENGTH(ac.accion)>32,CONCAT(SUBSTRING(ac.accion,1,28),'...'),
                ac.accion) AS accion,
                ac.accion AS ac,
                REPLACE(ac.accion_f_inicio,'-','/')AS accion_f_inicio,
                REPLACE(ac.accion_f_termino,'-','/')AS accion_f_termino
                ,DATE_FORMAT(ac.accion_f_inicio,'%m-%d-%Y') AS fechainicio,
                DATE_FORMAT(ac.accion_f_termino,'%m-%d-%Y') AS fechafin,
                av.id_cct,av.cte3 AS porcentaje,
                DATEDIFF(ac.accion_f_termino, ac.accion_f_inicio) AS 'periodo'
              FROM rm_tema_prioritarioxcct w
              INNER JOIN rm_accionxtproritario ac ON ac.id_tprioritario= w.id_tprioritario
              LEFT JOIN rm_avance_xcctxtpxaccion av ON  ac.id_tprioritario = av.id_tprioritario and ac.id_accion = av.id_accion
              WHERE w.cct='{$id_cct}' AND w.turno={$turno}";
        // echo $str_query;
      // die();
  return $this->db->query($str_query)->result_array();
}

public function fechaMaxMin($id_cct,$turno,$cte_vigente){
  $str_query = "SELECT 
                  MIN(ac.accion_f_inicio) AS inicio,
                  MAX(ac.accion_f_termino)AS fin
                FROM rm_tema_prioritarioxcct w
                INNER JOIN rm_accionxtproritario ac ON ac.id_tprioritario= w.id_tprioritario
                LEFT JOIN rm_avance_xcctxtpxaccion av ON ac.id_accion = av.id_accion
                WHERE w.cct='{$id_cct}' AND w.turno={$turno}";
      // echo $str_query;
      // die();
  return $this->db->query($str_query)->result_array();
}

public function pieAccion($id_cct,$cte_vigente){
  $str_query = "SELECT ac.id_accion,ac.accion,av.id_cct,
  ROUND(SUM(IFNULL(av.{$cte_vigente},0))/COUNT(ac.id_accion),2)AS porcentaje       
  FROM rm_avance_xcctxtpxaccion av
  INNER JOIN rm_accionxtproritario ac ON ac.id_accion=av.id_accion
  WHERE av.id_cct={$id_cct} ";
      // echo $str_query;
      // die();
  return $this->db->query($str_query)->result_array();
}

public function pieObjetivos($id_cct,$cte_vigente){
  $str_query = "SELECT ROUND(SUM(a.porcentaje)/COUNT(a.id_objetivos),2) AS porc 
  FROM (
  SELECT ac.id_accion,ac.accion,av.id_cct,(SUM(IFNULL(av.{$cte_vigente},0)))/COUNT(ac.id_accion) AS porcentaje,ac.id_objetivos    
  FROM rm_avance_xcctxtpxaccion av
  INNER JOIN rm_accionxtproritario ac ON ac.id_accion=av.id_accion
  WHERE av.id_cct={$id_cct}
  GROUP BY ac.id_objetivos) AS a ";
      // echo $str_query;
      // die();
  return $this->db->query($str_query)->result_array();
}

public function pieLAE($id_cct,$cte_vigente){
  $str_query = "SELECT ROUND(SUM(b.porcentaje_obj)/5,2) porc_p 
  FROM (
  SELECT SUM(a.porcentaje)/COUNT(a.id_objetivos) AS porcentaje_obj,a.id_prioridad FROM (
  SELECT ac.id_accion,ac.accion,av.id_cct,(SUM(IFNULL(av.{$cte_vigente},0)))/COUNT(ac.id_accion) AS porcentaje,ac.id_objetivos,rm.id_prioridad  
  FROM rm_avance_xcctxtpxaccion av
  INNER JOIN rm_accionxtproritario ac ON ac.id_accion=av.id_accion
  INNER JOIN rm_tema_prioritarioxcct rm ON rm.id_tprioritario=av.id_tprioritario
  INNER JOIN rm_c_prioridad rmp ON rmp.id_prioridad=rm.id_prioridad
  WHERE av.id_cct={$id_cct}
  GROUP BY ac.id_objetivos,rm.id_prioridad ) AS a 
  GROUP BY a.id_prioridad ) AS b";
      // echo $str_query;
      // die();
  return $this->db->query($str_query)->result_array();
}

public function momentoActual()
{
  // $str_query = 'call proye7nb_pruebas.cteActual();';
    $str_query = 'call sarape.cteActual();';
  return $this->db->query($str_query)->result_array();
}

public function getTablasGraficas($ccts)
{
  $str_query = "SELECT 
  l1.nombre_centro,
  l1.cve_centro,
  l1.total_objetivos AS obj1,
  l1.total_acciones AS acc1,
  l2.total_objetivos AS obj2,
  l2.total_acciones AS acc2,
  l3.total_objetivos AS obj3,
  l3.total_acciones AS acc3,
  l4.total_objetivos AS obj4,
  l4.total_acciones AS acc4,
  l5.total_objetivos AS obj5,
  l5.total_acciones AS acc5
  FROM
  (SELECT 
  COUNT(DISTINCT o.id_objetivo) AS total_objetivos,
  COUNT(DISTINCT acc.id_accion) AS total_acciones,
  tp.id_prioridad AS LAE,
  e.cve_centro,
  e.nombre_centro
  FROM
  escuela e
  LEFT JOIN rm_tema_prioritarioxcct tp ON e.id_cct = tp.id_cct
  LEFT JOIN rm_accionxtproritario acc ON tp.id_tprioritario = acc.id_tprioritario
  LEFT JOIN rm_objetivo o ON o.id_tprioritario = tp.id_tprioritario
  WHERE
  (e.id_estatus = 1 OR e.id_estatus = 4)
  AND e.id_nivel < 6
  AND e.id_nivel <> 2
  AND e.cve_centro NOT LIKE '05FUA%'
  AND e.cve_centro IN ('{$ccts}')
  AND tp.id_prioridad = 1
  GROUP BY e.id_cct , tp.id_prioridad) AS l1
  INNER JOIN
  (SELECT 
  COUNT(DISTINCT o.id_objetivo) AS total_objetivos,
  COUNT(DISTINCT acc.id_accion) AS total_acciones,
  tp.id_prioridad AS LAE,
  e.cve_centro
  FROM
  escuela e
  LEFT JOIN rm_tema_prioritarioxcct tp ON e.id_cct = tp.id_cct
  LEFT JOIN rm_accionxtproritario acc ON tp.id_tprioritario = acc.id_tprioritario
  LEFT JOIN rm_objetivo o ON o.id_tprioritario = tp.id_tprioritario
  WHERE
  (e.id_estatus = 1 OR e.id_estatus = 4)
  AND e.id_nivel < 6
  AND e.id_nivel <> 2
  AND e.cve_centro NOT LIKE '05FUA%'
  AND e.cve_centro IN ('{$ccts}')
  AND tp.id_prioridad = 2
  GROUP BY e.id_cct , tp.id_prioridad) AS l2 ON l1.cve_centro = l2.cve_centro
  INNER JOIN
  (SELECT 
  COUNT(DISTINCT o.id_objetivo) AS total_objetivos,
  COUNT(DISTINCT acc.id_accion) AS total_acciones,
  tp.id_prioridad AS LAE,
  e.cve_centro
  FROM
  escuela e
  LEFT JOIN rm_tema_prioritarioxcct tp ON e.id_cct = tp.id_cct
  LEFT JOIN rm_accionxtproritario acc ON tp.id_tprioritario = acc.id_tprioritario
  LEFT JOIN rm_objetivo o ON o.id_tprioritario = tp.id_tprioritario
  WHERE
  (e.id_estatus = 1 OR e.id_estatus = 4)
  AND e.id_nivel < 6
  AND e.id_nivel <> 2
  AND e.cve_centro NOT LIKE '05FUA%'
  AND e.cve_centro IN ('{$ccts}')
  AND tp.id_prioridad = 3
  GROUP BY e.id_cct , tp.id_prioridad) AS l3 ON l1.cve_centro = l3.cve_centro
  INNER JOIN
  (SELECT 
  COUNT(DISTINCT o.id_objetivo) AS total_objetivos,
  COUNT(DISTINCT acc.id_accion) AS total_acciones,
  tp.id_prioridad AS LAE,
  e.cve_centro
  FROM
  escuela e
  LEFT JOIN rm_tema_prioritarioxcct tp ON e.id_cct = tp.id_cct
  LEFT JOIN rm_accionxtproritario acc ON tp.id_tprioritario = acc.id_tprioritario
  LEFT JOIN rm_objetivo o ON o.id_tprioritario = tp.id_tprioritario
  WHERE
  (e.id_estatus = 1 OR e.id_estatus = 4)
  AND e.id_nivel < 6
  AND e.id_nivel <> 2
  AND e.cve_centro NOT LIKE '05FUA%'
  AND e.cve_centro IN ('{$ccts}')
  AND tp.id_prioridad = 4
  GROUP BY e.id_cct , tp.id_prioridad) AS l4 ON l1.cve_centro = l4.cve_centro
  INNER JOIN
  (SELECT 
  COUNT(DISTINCT o.id_objetivo) AS total_objetivos,
  COUNT(DISTINCT acc.id_accion) AS total_acciones,
  tp.id_prioridad AS LAE,
  e.cve_centro
  FROM
  escuela e
  LEFT JOIN rm_tema_prioritarioxcct tp ON e.id_cct = tp.id_cct
  LEFT JOIN rm_accionxtproritario acc ON tp.id_tprioritario = acc.id_tprioritario
  LEFT JOIN rm_objetivo o ON o.id_tprioritario = tp.id_tprioritario
  WHERE
  (e.id_estatus = 1 OR e.id_estatus = 4)
  AND e.id_nivel < 6
  AND e.id_nivel <> 2
  AND e.cve_centro NOT LIKE '05FUA%'
  AND e.cve_centro IN ('{$ccts}')
  AND tp.id_prioridad = 5
  GROUP BY e.id_cct , tp.id_prioridad) AS l5 ON l1.cve_centro = l5.cve_centro";

  return $this->db->query($str_query)->result_array();
}

public function getGraficas($ccts)
{
  $str_query = "SELECT 
  SUM(tl1.total_objetivos) AS obj,
  SUM(tl1.total_acciones) AS acc,
  tl1.LAE
  FROM
  (SELECT 
  COUNT(DISTINCT o.id_objetivo) AS total_objetivos,
  COUNT(DISTINCT acc.id_accion) AS total_acciones,
  tp.id_prioridad AS LAE,
  e.cve_centro
  FROM
  escuela e
  INNER JOIN rm_tema_prioritarioxcct tp ON e.id_cct = tp.id_cct
  LEFT JOIN rm_accionxtproritario acc ON tp.id_tprioritario = acc.id_tprioritario
  LEFT JOIN rm_objetivo o ON o.id_tprioritario = tp.id_tprioritario
  WHERE
  (e.id_estatus = 1 OR e.id_estatus = 4)
  AND e.id_nivel < 6
  AND e.id_nivel <> 2
  AND e.cve_centro NOT LIKE '05FUA%'
  AND e.cve_centro IN ('{$ccts}')
  GROUP BY e.id_municipio , tp.id_prioridad) AS tl1
  GROUP BY tl1.LAE";
  return $this->db->query($str_query)->result_array();

}

function catalogo_problematica_ambitos($id_prioridad)
{
 $str_query = "SELECT * FROM rm_c_problematica_ambito where lae = {$id_prioridad}";
 return $this->db->query($str_query)->result_array();
}

function grabar_ambito($id_tprioritario, $ambito_prom)
{
  $data = array (
    array('id_tprioritario' => $id_tprioritario,
      'problematica' => $ambito_prom,)
  );
  // echo "<pre>";print_r($data); 
  $this->db->insert_batch('rm_problematica_ambito_xtprioritario',$data);

}

function limpiar_ambito($id_tprioritario){
  $this->db->delete('rm_problematica_ambito_xtprioritario', array('id_tprioritario' => $id_tprioritario)); 
}

function get_problematica_ambito($id_tprioritario)
{
  $str_query = "SELECT cap.descripcion, cap.tipo from rm_problematica_ambito_xtprioritario pat
  inner join rm_c_problematica_ambito cap on cap.idrm_c_problematica_ambito = pat.problematica
  where pat.id_tprioritario = {$id_tprioritario};";
  // echo "<pre>"; print_r($str_query); die();
  return $this->db->query($str_query)->result_array();
}

function get_problematica_ambito_ids($id_tprioritario)
{
  $str_query = "SELECT pat.problematica from rm_problematica_ambito_xtprioritario pat
  inner join rm_c_problematica_ambito cap on cap.idrm_c_problematica_ambito = pat.problematica
  where pat.id_tprioritario = {$id_tprioritario};";
  // echo "<pre>"; print_r($str_query); die();
  return $this->db->query($str_query)->result_array();
}

}// Rutamejora_model
