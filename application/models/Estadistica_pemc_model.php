<?php

class Estadistica_pemc_model extends CI_Model
{
  function __construct(){
    parent::__construct();
  }

    function get_datos_sesion($usuario, $contrasena){
      $this->db->select('u.id_usuario, u.nombre, u.paterno, u.materno');
      $this->db->from('est_pemc_seguridad as s');
      $this->db->join('est_pemc_usuario as u', 'u.id_usuario = s.id_usuario');
      $this->db->where('s.user', $usuario);
      $this->db->where('s.clave', $contrasena);
      return  $this->db->get()->result_array();
    }// get_datos_sesion()

    function getdatoscct_pemc($cct, $turno){
      $this->db->select('e.id_cct, e.cve_centro, e.nombre_centro, e.id_turno_single, ts.turno_single, n.nivel, e.nombre_director,"upemc" as tipo_usuario_pemc');
      $this->db->from('escuela e');
      $this->db->join('turno_single AS ts ',' e.id_turno_single = ts.id_turno_single');
      $this->db->join('nivel AS n ', 'n.id_nivel = e.id_nivel');
      $this->db->where("e.cve_centro = '{$cct}'");
      $this->db->where("ts.id_turno_single = {$turno}");
      // $this->db->get();
      // echo $this->db->last_query();die();
      return  $this->db->get()->result_array();
    }

    /*BK201 S*/
    function get_cantidad_datos($nivel, $municipio){
        $query = 'select count(obj.num_objetivos) total_obj, obj.municipio, obj.num_objetivos  from (SELECT COUNT(DISTINCT o.id_objetivo) as num_objetivos, m.municipio
        FROM rm_tema_prioritarioxcct tp
        INNER JOIN rm_c_prioridad p on tp.id_prioridad=p.id_prioridad
        LEFT JOIN rm_objetivo o ON tp.id_tprioritario=o.id_tprioritario
        LEFT JOIN rm_accionxtproritario a on o.id_objetivo=a.id_objetivos
        INNER JOIN escuela e on e.id_cct = tp.id_cct
        INNER JOIN municipio m on e.id_municipio = m.id_municipio
        where  (e.id_estatus=1 OR e.id_estatus=4) AND e.id_nivel<6 and e.id_municipio = '.$municipio.'';
        if ($nivel != 0) {
        $query .=' and e.id_nivel = '.$nivel.'';
        }
        $query .= ' GROUP BY tp.id_tprioritario  ORDER by tp.orden) as obj group by obj.num_objetivos;';

     // echo '<pre>'; print_r($query);
      return $this->db->query($query)->result_array();



 }

 function municipios()
 {
  $this->db->select('id_municipio, municipio');
  $this->db->from('municipio');

  return  $this->db->get()->result_array();
}

 function get_total($nivel, $municipio){
    $query = 'select sum(total.cct) as total from  (select count(obj.num_objetivos), obj.municipio, obj.num_objetivos, count(obj.id_cct) as cct ,obj.id_cct  from (SELECT COUNT(DISTINCT o.id_objetivo) as num_objetivos, m.municipio, e.id_cct
        FROM rm_tema_prioritarioxcct tp
        INNER JOIN rm_c_prioridad p on tp.id_prioridad=p.id_prioridad
        LEFT JOIN rm_objetivo o ON tp.id_tprioritario=o.id_tprioritario
        LEFT JOIN rm_accionxtproritario a on o.id_objetivo=a.id_objetivos
        INNER JOIN escuela e on e.id_cct = tp.id_cct
        INNER JOIN municipio m on e.id_municipio = m.id_municipio
        where  (e.id_estatus=1 OR e.id_estatus=4) AND e.id_nivel<6 and e.id_municipio = '.$municipio.'';
        if ($nivel != 0) {
          $query .=' and e.id_nivel = '.$nivel.'';
        }
        $query .= ' GROUP BY tp.id_cct  ORDER by tp.orden) as obj group by obj.num_objetivos, obj.id_cct) as total;';

        return $this->db->query($query)->result_array();
}

  function get_escuelasMun($nivel, $id_municipio)
 {
  $query = 'SELECT count(*) as total from escuela WHERE (id_estatus=1 OR id_estatus=4) AND id_nivel<6';
  if ($id_municipio != 0) {
   $query.= ' and id_municipio = '.$id_municipio. '';
  }
  if ($nivel != 0) {
   $query.= ' and nivel = '.$nivel. '';
  }
  return $this->db->query($query)->result_array();
  }

 function get_region(){
   $this->db->select('m.municipio, m.id_municipio, r.region, r.id_region');
  $this->db->from('municipio as m');
  $this->db->join('region as r', 'r.id_region = m.id_region');
  $this->db->order_by('m.id_region');

  return  $this->db->get()->result_array();
 }

 function get_municipios($region){
   $this->db->select('m.municipio, m.id_municipio, r.region, r.id_region');
  $this->db->from('municipio as m');
  $this->db->join('region as r', 'r.id_region = m.id_region');

  if ($region != 0) {
  $this->db->where('m.id_region',$region);
  }
  $this->db->order_by('m.id_region');

  return  $this->db->get()->result_array();
 }


 function get_obj_acc_lae($nivel,$region,$municipio) {
  if ($nivel != 0) {
      $where_nivel= " and e.id_nivel={$nivel}";
     }
     else {
       $where_nivel= "";
     }
  if ($region != 0) {
      $where_region= " and m.id_region={$region}";
     }
     else {
       $where_region= "";
     }
   if ($municipio != 0) {
      $where_municipio= " and m.id_municipio={$municipio}";
     }
     else {
       $where_municipio= "";
     }
  
  $query = "SELECT 
    l1.region,
    l1.municipio,
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
            m.municipio,
            r.region,
            r.id_region
     FROM
    municipio m
        INNER JOIN
    escuela e ON e.id_municipio = m.id_municipio
        INNER JOIN
    region r ON m.id_region = r.id_region
        INNER JOIN
    rm_tema_prioritarioxcct tp ON e.id_cct = tp.id_cct
        LEFT JOIN
    rm_accionxtproritario acc ON tp.id_tprioritario = acc.id_tprioritario
        LEFT JOIN
    rm_objetivo o ON o.id_tprioritario = tp.id_tprioritario
    WHERE
        (e.id_estatus = 1 OR e.id_estatus = 4)
            AND e.id_nivel < 6
            {$where_nivel}
            {$where_region}
            {$where_municipio}
            AND tp.id_prioridad = 1
    GROUP BY e.id_municipio , tp.id_prioridad) AS l1
        INNER JOIN
    (SELECT 
        COUNT(DISTINCT o.id_objetivo) AS total_objetivos,
            COUNT(DISTINCT acc.id_accion) AS total_acciones,
            tp.id_prioridad AS LAE,
            m.municipio
      FROM
    municipio m
        INNER JOIN
    escuela e ON e.id_municipio = m.id_municipio
        INNER JOIN
    region r ON m.id_region = r.id_region
        INNER JOIN
    rm_tema_prioritarioxcct tp ON e.id_cct = tp.id_cct
        LEFT JOIN
    rm_accionxtproritario acc ON tp.id_tprioritario = acc.id_tprioritario
        LEFT JOIN
    rm_objetivo o ON o.id_tprioritario = tp.id_tprioritario
    WHERE
        (e.id_estatus = 1 OR e.id_estatus = 4)
            AND e.id_nivel < 6
            {$where_nivel}
            {$where_region}
            {$where_municipio}
            AND tp.id_prioridad = 2
    GROUP BY e.id_municipio , tp.id_prioridad) AS l2 ON l1.municipio = l2.municipio
        INNER JOIN
    (SELECT 
        COUNT(DISTINCT o.id_objetivo) AS total_objetivos,
            COUNT(DISTINCT acc.id_accion) AS total_acciones,
            tp.id_prioridad AS LAE,
            m.municipio
     FROM
    municipio m
        INNER JOIN
    escuela e ON e.id_municipio = m.id_municipio
        INNER JOIN
    region r ON m.id_region = r.id_region
        INNER JOIN
    rm_tema_prioritarioxcct tp ON e.id_cct = tp.id_cct
        LEFT JOIN
    rm_accionxtproritario acc ON tp.id_tprioritario = acc.id_tprioritario
        LEFT JOIN
    rm_objetivo o ON o.id_tprioritario = tp.id_tprioritario
    WHERE
        (e.id_estatus = 1 OR e.id_estatus = 4)
            AND e.id_nivel < 6
            {$where_nivel}
            {$where_region}
            {$where_municipio}
            AND tp.id_prioridad = 3
    GROUP BY e.id_municipio , tp.id_prioridad) AS l3 ON l1.municipio = l3.municipio
        INNER JOIN
    (SELECT 
        COUNT(DISTINCT o.id_objetivo) AS total_objetivos,
            COUNT(DISTINCT acc.id_accion) AS total_acciones,
            tp.id_prioridad AS LAE,
            m.municipio
      FROM
    municipio m
        INNER JOIN
    escuela e ON e.id_municipio = m.id_municipio
        INNER JOIN
    region r ON m.id_region = r.id_region
        INNER JOIN
    rm_tema_prioritarioxcct tp ON e.id_cct = tp.id_cct
        LEFT JOIN
    rm_accionxtproritario acc ON tp.id_tprioritario = acc.id_tprioritario
        LEFT JOIN
    rm_objetivo o ON o.id_tprioritario = tp.id_tprioritario
    WHERE
        (e.id_estatus = 1 OR e.id_estatus = 4)
            AND e.id_nivel < 6
            {$where_nivel}
            {$where_region}
            {$where_municipio}
            AND tp.id_prioridad = 4
    GROUP BY e.id_municipio , tp.id_prioridad) AS l4 ON l1.municipio = l4.municipio
        INNER JOIN
    (SELECT 
        COUNT(DISTINCT o.id_objetivo) AS total_objetivos,
            COUNT(DISTINCT acc.id_accion) AS total_acciones,
            tp.id_prioridad AS LAE,
            m.municipio
     FROM
    municipio m
        INNER JOIN
    escuela e ON e.id_municipio = m.id_municipio
        INNER JOIN
    region r ON m.id_region = r.id_region
        INNER JOIN
    rm_tema_prioritarioxcct tp ON e.id_cct = tp.id_cct
        LEFT JOIN
    rm_accionxtproritario acc ON tp.id_tprioritario = acc.id_tprioritario
        LEFT JOIN
    rm_objetivo o ON o.id_tprioritario = tp.id_tprioritario
    WHERE
        (e.id_estatus = 1 OR e.id_estatus = 4)
            AND e.id_nivel < 6
            {$where_nivel}
            {$where_region}
            {$where_municipio}
            AND tp.id_prioridad = 5
    GROUP BY e.id_municipio , tp.id_prioridad) AS l5 ON l1.municipio = l5.municipio
ORDER BY l1.id_region;";
//echo "<pre>"; print_r($query); die();
  return $this->db->query($query)->result_array();
}
  
  function grafica_obj_acc_lae($nivel, $region, $municipio)
  {
    if ($nivel != 0) {
      $where_nivel = " AND e.id_nivel = {$nivel}";
    }else{
      $where_nivel = " ";
    }
    if ($region != 0) {
      $where_region = " AND m.id_region = {$region}";
    }else{
      $where_region = " ";
    }
    if ($municipio != 0) {
      $where_municipio = " AND m.id_municipio = {$municipio}";
    }else{
      $where_municipio = " ";
    }


    $query = "SELECT 
    SUM(tl1.total_objetivos) AS obj,
    SUM(tl1.total_acciones) AS acc,
    tl1.LAE
FROM
    (SELECT 
        COUNT(DISTINCT o.id_objetivo) AS total_objetivos,
            COUNT(DISTINCT acc.id_accion) AS total_acciones,
            tp.id_prioridad AS LAE,
            m.municipio,
            r.region,
            r.id_region
    FROM
        municipio m
    INNER JOIN escuela e ON e.id_municipio = m.id_municipio
    INNER JOIN region r ON m.id_region = r.id_region
    INNER JOIN rm_tema_prioritarioxcct tp ON e.id_cct = tp.id_cct
    LEFT JOIN rm_accionxtproritario acc ON tp.id_tprioritario = acc.id_tprioritario
    LEFT JOIN rm_objetivo o ON o.id_tprioritario = tp.id_tprioritario
    WHERE
        (e.id_estatus = 1 OR e.id_estatus = 4)
            AND e.id_nivel < 6
            {$where_nivel}
            {$where_region}
            {$where_municipio}
    GROUP BY e.id_municipio , tp.id_prioridad) AS tl1
GROUP BY tl1.LAE";
return $this->db->query($query)->result_array();
  }
  
 function get_obj_acc_lae_zona_sost($nivel, $zona, $sostenimiento)
 {

   $query = 'SELECT tp.orden, COUNT(DISTINCT o.id_objetivo) as num_objetivos, COUNT(DISTINCT a.id_accion) as num_acciones,  group_concat(a.id_accion) as id_acciones, e.id_municipio
   FROM rm_tema_prioritarioxcct tp
   INNER JOIN rm_c_prioridad p on tp.id_prioridad=p.id_prioridad
   LEFT JOIN rm_objetivo o ON tp.id_tprioritario=o.id_tprioritario
   LEFT JOIN rm_accionxtproritario a on o.id_objetivo=a.id_objetivos
   inner join escuela e on e.id_cct = tp.id_cct
   inner join municipio m on m.id_municipio = e.id_municipio
   inner join subsostenimiento s on s.id_subsostenimiento = e.id_subsostenimiento
   inner join supervision su on su.id_supervision = e.id_supervision
   WHERE  (e.id_estatus=1 OR e.id_estatus=4) AND e.id_nivel<6 and m.id_municipio is not null  ';
   if ($nivel != 0) {
    $query .= ' and e.id_nivel = '.$nivel. '';
  }
   if ($zona != 0 && $sostenimiento != 0) {
     $query .= ' and su.zona_escolar = '.$zona.'';
   }
    if ($sostenimiento != 0) {
     $query .= ' and s.id_sostenimiento = '.$sostenimiento.'';
   }

  $query .= ' GROUP BY tp.orden  ORDER by tp.orden';

  return $this->db->query($query)->result_array();
}

/*function get_filtros($nivel, $municipio, $region)
 {
   $query = 'SELECT tp.orden, COUNT(DISTINCT o.id_objetivo) as num_objetivos, COUNT(DISTINCT a.id_accion) as num_acciones
   FROM rm_tema_prioritarioxcct tp
   INNER JOIN rm_c_prioridad p on tp.id_prioridad=p.id_prioridad
   LEFT JOIN rm_objetivo o ON tp.id_tprioritario=o.id_tprioritario
   LEFT JOIN rm_accionxtproritario a on o.id_objetivo=a.id_objetivos
   inner join escuela e on e.id_cct = tp.id_cct
   inner join municipio m on m.id_municipio = e.id_municipio
   WHERE  (e.id_estatus=1 OR e.id_estatus=4) AND e.id_nivel<6 and m.zona_economica = 5';
   if ($region =! 0) {
       $query .= ' and m.id_region = '.$region.'';
   }
   if ($municipio =! 0) {
     $query .= ' and m.id_municipio = '.$municipio.'';
   }
   if ($nivel != 0) {
    $query .= ' and e.id_nivel = '.$nivel. '';
  }

  $query .= ' GROUP BY tp.orden  ORDER by tp.orden';

   // echo '<pre>'; print_r($query); die();

  return $this->db->query($query)->result_array();
}*/

  function get_zonas($sostenimiento)
 {
   $str_query = 'SELECT DISTINCT zona_escolar, id_sostenimiento from supervision';
   if ($sostenimiento != 0) {

    $str_query .=' where id_sostenimiento ='.$sostenimiento.'';
   }
   $str_query .=' order by zona_escolar asc;';
   return $this->db->query($str_query)->result_array();
 }
  function get_todas_zonas()
 {
   $str_query = 'SELECT DISTINCT zona_escolar, id_sostenimiento from supervision';
   return $this->db->query($str_query)->result_array();
 }

    function get_porcent_zonas($sostenimiento, $zona, $nivel)
  {
    $str_query = 'SELECT lae1.promedio_cte as lae1, lae2.promedio_cte as lae2, lae3.promedio_cte as lae3, lae4.promedio_cte as lae4, lae5.promedio_cte as lae5, lae1.zona_escolar, lae1.id_sostenimiento, lae1.id_nivel from (SELECT
IFNULL(ROUND(avg(acct.cte1),1),0) AS promedio_cte,
tp.orden,
su.zona_escolar, su.id_sostenimiento, e.id_nivel
FROM supervision su
INNER JOIN escuela e ON su.id_supervision = e.id_supervision
INNER JOIN rm_tema_prioritarioxcct tp ON e.id_cct = tp.id_cct
LEFT JOIN rm_avance_xcctxtpxaccion acct ON tp.id_tprioritario = acct.id_tprioritario
WHERE (e.id_estatus=1 OR e.id_estatus=4) AND e.id_nivel<6 and tp.orden = 1
GROUP BY
su.zona_escolar, tp.orden) as lae1
inner join (SELECT
IFNULL(ROUND(avg(acct.cte1),1),0) AS promedio_cte,
tp.orden,
su.zona_escolar
FROM supervision su
INNER JOIN escuela e ON su.id_supervision = e.id_supervision
INNER JOIN rm_tema_prioritarioxcct tp ON e.id_cct = tp.id_cct
LEFT JOIN rm_avance_xcctxtpxaccion acct ON tp.id_tprioritario = acct.id_tprioritario
WHERE (e.id_estatus=1 OR e.id_estatus=4) AND e.id_nivel<6 and tp.orden = 2
GROUP BY
su.zona_escolar, tp.orden) as lae2 on lae1.zona_escolar = lae2.zona_escolar
inner join (SELECT
IFNULL(ROUND(avg(acct.cte1),1),0) AS promedio_cte,
tp.orden,
su.zona_escolar
FROM supervision su
INNER JOIN escuela e ON su.id_supervision = e.id_supervision
INNER JOIN rm_tema_prioritarioxcct tp ON e.id_cct = tp.id_cct
LEFT JOIN rm_avance_xcctxtpxaccion acct ON tp.id_tprioritario = acct.id_tprioritario
WHERE (e.id_estatus=1 OR e.id_estatus=4) AND e.id_nivel<6 and tp.orden = 3
GROUP BY
su.zona_escolar, tp.orden) as lae3 on lae1.zona_escolar = lae3.zona_escolar
inner join (SELECT
IFNULL(ROUND(avg(acct.cte1),1),0) AS promedio_cte,
tp.orden,
su.zona_escolar
FROM supervision su
INNER JOIN escuela e ON su.id_supervision = e.id_supervision
INNER JOIN rm_tema_prioritarioxcct tp ON e.id_cct = tp.id_cct
LEFT JOIN rm_avance_xcctxtpxaccion acct ON tp.id_tprioritario = acct.id_tprioritario
WHERE (e.id_estatus=1 OR e.id_estatus=4) AND e.id_nivel<6 and tp.orden = 4
GROUP BY
su.zona_escolar, tp.orden) as lae4 on lae1.zona_escolar = lae4.zona_escolar
inner join (SELECT
IFNULL(ROUND(avg(acct.cte1),1),0) AS promedio_cte,
tp.orden,
su.zona_escolar
FROM supervision su
INNER JOIN escuela e ON su.id_supervision = e.id_supervision
INNER JOIN rm_tema_prioritarioxcct tp ON e.id_cct = tp.id_cct
LEFT JOIN rm_avance_xcctxtpxaccion acct ON tp.id_tprioritario = acct.id_tprioritario
WHERE (e.id_estatus=1 OR e.id_estatus=4) AND e.id_nivel<6 and tp.orden = 5  GROUP BY
su.zona_escolar, tp.orden) as lae5 on lae1.zona_escolar = lae5.zona_escolar';
if ($sostenimiento != 0 || $nivel != 0) {
  $str_query .= ' where ';
}
if ( $nivel != 0) {
  $str_query .=' lae1.id_nivel ='.$nivel.'';
}
if ( $sostenimiento != 0 && $nivel != 0) {
 $str_query .=' and lae1.id_sostenimiento ='.$sostenimiento.'';
  if ($zona != 0) {
    $str_query .= ' and lae1.zona_escolar = '.$zona.'';
  }
} else {
  if ($sostenimiento != 0) {
   $str_query .=' lae1.id_sostenimiento ='.$sostenimiento.'';
  if ($zona != 0) {
    $str_query .= ' and lae1.zona_escolar = '.$zona.'';
  }
  }
}
// echo "<pre>"; print_r($str_query);
    return $this->db->query($str_query)->result_array();
  }

  function get_avance_accion($idaccion)
 {
   $str_query = 'SELECT * from rm_avance_xcctxtpxaccion where id_accion = '.$idaccion.'';
   return $this->db->query($str_query)->result_array();
 }
/*BK201 E*/
  function getall_xest_ind(){
    $this->db->select('mu.id_municipio, mu.municipio');
    $this->db->from('municipio mu');
    $this->db->join('escuela as es', 'mu.id_municipio = es.id_municipio');
    $this->db->join('estadistica_e_indicadores_xcct as  est', 'es.id_cct = est.id_cct');
    $this->db->group_by('mu.id_municipio');
    return  $this->db->get()->result_array();
  }// getall_xest_ind()


  function get_xparams($id_municipio,$id_nivel,$id_sostenimiento,$nombre_escuela){
    // echo $id_municipio."\n";
    // echo $id_nivel."\n";
    // echo $id_sostenimiento."\n";
    // echo $nombre_escuela."\n";
    // die();
    $this->db->select('es.id_cct, es.cve_centro, tu.turno_single, es.nombre_centro,ni.nivel,sso.subsostenimiento, mo.modalidad,mu.municipio,loc.localidad,es.domicilio, es.latitud, es.longitud, es.id_nivel, s.zona_escolar, so.sostenimiento');
    $this->db->from('escuela as es');
    $this->db->join('turno_single as tu', 'es.id_turno_single = tu.id_turno_single');
    $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
    $this->db->join('subsostenimiento as sso', 'es.id_subsostenimiento = sso.id_subsostenimiento');
    $this->db->join('sostenimiento as so', 'sso.id_sostenimiento = so.id_sostenimiento');
    $this->db->join('modalidad as mo', 'es.id_modalidad = mo.id_modalidad');
    $this->db->join('municipio as mu', 'es.id_municipio = mu.id_municipio');
    $this->db->join('supervision as s', 'es.id_supervision = s.id_supervision');
    $this->db->join('localidad as loc', 'mu.id_municipio = loc.id_municipio AND es.id_localidad = loc.cve_localidad');
      $where_au = "(es.id_estatus !=2 AND es.id_estatus !=3)";
    $this->db->where($where_au);
    $this->db->where('es.latitud !=',0);
    $this->db->where('es.latitud !=','');
    $this->db->where('es.latitud !=','#VALUE!');
    if($id_municipio>0){
      $this->db->where('es.id_municipio', $id_municipio);
    }
    if($id_nivel>0){
      $this->db->where('es.id_nivel', $id_nivel);
    }
    if($id_sostenimiento>0){
      $this->db->where('so.id_sostenimiento', $id_sostenimiento);
    }
    if($nombre_escuela!=''){
      // $this->db->where('es.id_nivel !=','6');
      // $this->db->where('es.id_nivel !=','7');
      // $this->db->where('es.id_nivel !=','8');
      // $this->db->where('es.id_nivel !=','9');
      // $this->db->where('es.id_nivel !=','10');
      $this->db->like('es.nombre_centro', $nombre_escuela);
    }

    $this->db->group_by("es.id_cct");
    $this->db->order_by("ni.id_nivel");
    return  $this->db->get()->result_array();
  }// get_xparams()

  function get_escuelasMun_gen($nivel){
     if ($nivel != 0) {
      $where= " and e.id_nivel={$nivel}";
     }
     else {
       $where= "";
     }
    $query = "SELECT
              mastert.id_municipio, mastert.municipio, mastert.n_escxmuni,
              captobj.esc_que_capt, captobj.porcentaje,
              IFNULL(x0.esc_que_capt0,0) as esc_con0obj, IFNULL(x1.esc_que_capt1,0) as esc_con1obj,
              IFNULL(x2.esc_que_capt23,0) as esc_con2y3obj,IFNULL(x3.esc_que_captmay4,0) as esc_conmasde4obj
              FROM
              (
              	SELECT
              	m.id_municipio, m.municipio, COUNT(DISTINCT e.id_cct) n_escxmuni
              	FROM municipio m
              	INNER JOIN escuela e ON m.id_municipio = e.id_municipio
              	WHERE (e.id_estatus=1 OR e.id_estatus=4) AND e.id_nivel<6 {$where}
              	GROUP BY m.id_municipio
              ) as mastert
              INNER JOIN
              (
              	SELECT
              	m.id_municipio, COUNT(DISTINCT IF(ISNULL(o.id_cct),NULL, o.id_cct)) as esc_que_capt,
              	ROUND(IF(COUNT(DISTINCT IF(ISNULL(o.id_cct),NULL, o.id_cct))=0,0,(COUNT( DISTINCT IF(ISNULL(o.id_cct),NULL, o.id_cct))*100)/COUNT(DISTINCT e.id_cct)),1) as porcentaje
              	FROM municipio m
              	INNER JOIN escuela e ON m.id_municipio = e.id_municipio
              	LEFT JOIN rm_tema_prioritarioxcct tp ON e.id_cct = tp.id_cct
              	LEFT JOIN rm_objetivo o ON tp.id_tprioritario = o.id_tprioritario
              	WHERE (e.id_estatus=1 OR e.id_estatus=4) AND e.id_nivel<6 {$where}
              	GROUP BY m.id_municipio
              ) captobj on mastert.id_municipio = captobj.id_municipio
              LEFT JOIN
              (
              	SELECT
              	xcon0.id_municipio, COUNT(DISTINCT xcon0.id_cct) as esc_que_capt0
              	FROM
              	(
              	SELECT
              	m.id_municipio, e.id_cct,
              	COUNT(DISTINCT o.id_objetivo)
              	FROM municipio m
              	INNER JOIN escuela e ON m.id_municipio = e.id_municipio
              	LEFT JOIN rm_tema_prioritarioxcct tp ON e.id_cct = tp.id_cct
              	LEFT JOIN rm_objetivo o ON tp.id_tprioritario = o.id_tprioritario
              	WHERE (e.id_estatus=1 OR e.id_estatus=4) AND e.id_nivel<6 {$where}
              	GROUP BY m.id_municipio, e.id_cct
              	HAVING COUNT(DISTINCT o.id_objetivo)=0
              	) as xcon0
              	GROUP BY xcon0.id_municipio
              ) as x0 on mastert.id_municipio = x0.id_municipio

              LEFT JOIN
              (
              	SELECT
              	xcon0.id_municipio, COUNT(DISTINCT xcon0.id_cct) as esc_que_capt1
              	FROM
              	(
              	SELECT
              	m.id_municipio, e.id_cct,
              	COUNT(DISTINCT o.id_objetivo)
              	FROM municipio m
              	INNER JOIN escuela e ON m.id_municipio = e.id_municipio
              	LEFT JOIN rm_tema_prioritarioxcct tp ON e.id_cct = tp.id_cct
              	LEFT JOIN rm_objetivo o ON tp.id_tprioritario = o.id_tprioritario
              	WHERE (e.id_estatus=1 OR e.id_estatus=4) AND e.id_nivel<6 {$where}
              	GROUP BY m.id_municipio, e.id_cct
              	HAVING COUNT(DISTINCT o.id_objetivo)=1
              	) as xcon0
              	GROUP BY xcon0.id_municipio
              ) as x1 on mastert.id_municipio = x1.id_municipio

              LEFT JOIN
              (
              	SELECT
              	xcon0.id_municipio, COUNT(DISTINCT xcon0.id_cct) as esc_que_capt23
              	FROM
              	(
              	SELECT
              	m.id_municipio, e.id_cct,
              	COUNT(DISTINCT o.id_objetivo)
              	FROM municipio m
              	INNER JOIN escuela e ON m.id_municipio = e.id_municipio
              	LEFT JOIN rm_tema_prioritarioxcct tp ON e.id_cct = tp.id_cct
              	LEFT JOIN rm_objetivo o ON tp.id_tprioritario = o.id_tprioritario
              	WHERE (e.id_estatus=1 OR e.id_estatus=4) AND e.id_nivel<6 {$where}
              	GROUP BY m.id_municipio, e.id_cct
              	HAVING COUNT(DISTINCT o.id_objetivo)=2 OR COUNT(DISTINCT o.id_objetivo)=3
              	) as xcon0
              	GROUP BY xcon0.id_municipio
              ) as x2 on mastert.id_municipio = x2.id_municipio

              LEFT JOIN
              (
              	SELECT
              	xcon0.id_municipio, COUNT(DISTINCT xcon0.id_cct) as esc_que_captmay4
              	FROM
              	(
              	SELECT
              	m.id_municipio, e.id_cct,
              	COUNT(DISTINCT o.id_objetivo)
              	FROM municipio m
              	INNER JOIN escuela e ON m.id_municipio = e.id_municipio
              	LEFT JOIN rm_tema_prioritarioxcct tp ON e.id_cct = tp.id_cct
              	LEFT JOIN rm_objetivo o ON tp.id_tprioritario = o.id_tprioritario
              	WHERE (e.id_estatus=1 OR e.id_estatus=4) AND e.id_nivel<6 {$where}
              	GROUP BY m.id_municipio, e.id_cct
              	HAVING COUNT(DISTINCT o.id_objetivo)>3
              	) as xcon0
              	GROUP BY xcon0.id_municipio
              ) as x3 on mastert.id_municipio = x3.id_municipio
    ";

    return $this->db->query($query)->result_array();
  }//get_escuelasMun_gen()

  function get_toatalesc($nivel){
     if ($nivel != 0) {
      $where= " and e.id_nivel={$nivel}";
     }
     else {
       $where= "";
     }
    $query = "SELECT
              COUNT(DISTINCT e.id_cct) as n_esc
              FROM escuela as e
              WHERE (e.id_estatus=1 OR e.id_estatus=4) AND e.id_nivel<6 {$where}
              ";
    return $this->db->query($query)->row('n_esc');
  }//get_toatalesc()
  function get_total_gen($nivel){
    if ($nivel != 0) {
     $where= " and e.id_nivel={$nivel}";
    }
    else {
      $where= "";
    }
   $query = "SELECT
						 ROUND(((COUNT(DISTINCT IF(ISNULL(o.id_objetivo),NULL, e.id_cct)) * 100)/COUNT(DISTINCT e.id_cct)),1) as por_capt,
						 ROUND((100-((COUNT(DISTINCT IF(ISNULL(o.id_objetivo),NULL, e.id_cct)) * 100)/COUNT(DISTINCT e.id_cct))),1) as por_ncapt
             FROM escuela as e
						 LEFT JOIN rm_tema_prioritarioxcct tp on e.id_cct = tp.id_cct
						 LEFT JOIN rm_objetivo o ON tp.id_tprioritario = o.id_tprioritario
             WHERE (e.id_estatus=1 OR e.id_estatus=4) AND e.id_nivel<6 {$where}
             ";
  return $this->db->query($query)->result_array();
 }
}



/**
 * Query para la zona
 *
 * SELECT 
    zl1.zona_escolar,
    zl1.id_nivel,
    zl1.id_sostenimiento,
    IFNULL(zl1.promedio, 0) AS lae1,
    IFNULL(zl2.promedio, 0) AS lae2,
    IFNULL(zl3.promedio, 0) AS lae3,
    IFNULL(zl4.promedio, 0) AS lae4,
    IFNULL(zl5.promedio, 0) AS lae5
FROM
    (SELECT 
        s.zona_escolar,
            s.id_sostenimiento,
            e.id_nivel,
            acc.id_accion,
            AVG(ava.cte1) AS promedio,
            tp.id_prioridad AS LAE
    FROM
        supervision s
    INNER JOIN escuela e ON e.id_supervision = s.id_supervision
    INNER JOIN rm_tema_prioritarioxcct tp ON e.id_cct = tp.id_cct
    LEFT JOIN rm_accionxtproritario acc ON tp.id_tprioritario = acc.id_tprioritario
    LEFT JOIN rm_avance_xcctxtpxaccion ava ON ava.id_accion = acc.id_accion
    WHERE
        (e.id_estatus = 1 OR e.id_estatus = 4)
            AND e.id_nivel < 6
            AND tp.id_prioridad = 1
    GROUP BY s.zona_escolar
    ORDER BY s.zona_escolar ASC) AS zl1
        INNER JOIN
    (SELECT 
        s.zona_escolar,
            s.id_sostenimiento,
            acc.id_accion,
            AVG(ava.cte1) AS promedio,
            tp.id_prioridad AS LAE
    FROM
        supervision s
    INNER JOIN escuela e ON e.id_supervision = s.id_supervision
    INNER JOIN rm_tema_prioritarioxcct tp ON e.id_cct = tp.id_cct
    LEFT JOIN rm_accionxtproritario acc ON tp.id_tprioritario = acc.id_tprioritario
    LEFT JOIN rm_avance_xcctxtpxaccion ava ON ava.id_accion = acc.id_accion
    WHERE
        (e.id_estatus = 1 OR e.id_estatus = 4)
            AND e.id_nivel < 6
            AND tp.id_prioridad = 2
    GROUP BY s.zona_escolar) AS zl2 ON zl1.zona_escolar = zl2.zona_escolar
        INNER JOIN
    (SELECT 
        s.zona_escolar,
            s.id_sostenimiento,
            acc.id_accion,
            AVG(ava.cte1) AS promedio,
            tp.id_prioridad AS LAE
    FROM
        supervision s
    INNER JOIN escuela e ON e.id_supervision = s.id_supervision
    INNER JOIN rm_tema_prioritarioxcct tp ON e.id_cct = tp.id_cct
    LEFT JOIN rm_accionxtproritario acc ON tp.id_tprioritario = acc.id_tprioritario
    LEFT JOIN rm_avance_xcctxtpxaccion ava ON ava.id_accion = acc.id_accion
    WHERE
        (e.id_estatus = 1 OR e.id_estatus = 4)
            AND e.id_nivel < 6
            AND tp.id_prioridad = 3
    GROUP BY s.zona_escolar) AS zl3 ON zl1.zona_escolar = zl3.zona_escolar
        INNER JOIN
    (SELECT 
        s.zona_escolar,
            s.id_sostenimiento,
            acc.id_accion,
            AVG(ava.cte1) AS promedio,
            tp.id_prioridad AS LAE
    FROM
        supervision s
    INNER JOIN escuela e ON e.id_supervision = s.id_supervision
    INNER JOIN rm_tema_prioritarioxcct tp ON e.id_cct = tp.id_cct
    LEFT JOIN rm_accionxtproritario acc ON tp.id_tprioritario = acc.id_tprioritario
    LEFT JOIN rm_avance_xcctxtpxaccion ava ON ava.id_accion = acc.id_accion
    WHERE
        (e.id_estatus = 1 OR e.id_estatus = 4)
            AND e.id_nivel < 6
            AND tp.id_prioridad = 4
    GROUP BY s.zona_escolar) AS zl4 ON zl1.zona_escolar = zl4.zona_escolar
        INNER JOIN
    (SELECT 
        s.zona_escolar,
            s.id_sostenimiento,
            acc.id_accion,
            AVG(ava.cte1) AS promedio,
            tp.id_prioridad AS LAE
    FROM
        supervision s
    INNER JOIN escuela e ON e.id_supervision = s.id_supervision
    INNER JOIN rm_tema_prioritarioxcct tp ON e.id_cct = tp.id_cct
    LEFT JOIN rm_accionxtproritario acc ON tp.id_tprioritario = acc.id_tprioritario
    LEFT JOIN rm_avance_xcctxtpxaccion ava ON ava.id_accion = acc.id_accion
    WHERE
        (e.id_estatus = 1 OR e.id_estatus = 4)
            AND e.id_nivel < 6
            AND tp.id_prioridad = 5
    GROUP BY s.zona_escolar) AS zl5 ON zl1.zona_escolar = zl5.zona_escolar
 */