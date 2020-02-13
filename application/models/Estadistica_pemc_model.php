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

    //revisar
    function getdatoscct_pemc($cct, $turno){
      $this->db->select('e.cct, e.nombre_centro, e.turno, e.desc_turno, e.desc_nivel_educativo, e.nombre_director,"upemc" as tipo_usuario_pemc');
      $this->db->from('centros_educativos.vista_cct e');
      $this->db->where("e.cct = '{$cct}'");
      $this->db->where("e.turno like %{$turno}%");

      return  $this->db->get()->result_array();
    }

    /*BK201 S*/
    
 function municipios()
 {
  $this->db->select('id_municipio, municipio');
  $this->db->from('municipio');

  return  $this->db->get()->result_array();
}
//listo
 function get_total($nivel, $municipio){

        switch ($nivel) {
            case '1':
                $nivel_desc = 'Especial'
                break;
            case '3':
                $nivel_desc = 'Preescolar'
                break;
            case '4':
                $nivel_desc = 'Primaria'
                break;
            case '5':
                $nivel_desc = 'Secundaria'
                break;
            default:
            $nivel_desc = 0;
                break;
        }

    $query = "SELECT sum(total.cct) as total from  (select count(obj.num_objetivos), obj.municipio, obj.num_objetivos, count(obj.cct) as cct ,obj.cct as id_cct  
        from (SELECT COUNT(DISTINCT o.id_objetivo) as num_objetivos, e.nombre_de_municipio as municipio, e.cct
        FROM rm_tema_prioritarioxcct tp
        INNER JOIN rm_c_prioridad p on tp.id_prioridad=p.id_prioridad
        LEFT JOIN rm_objetivo o ON tp.id_tprioritario=o.id_tprioritario
        LEFT JOIN rm_accionxtproritario a on o.id_objetivo=a.id_objetivos
        INNER JOIN vista_cct e ON e.cct = tp.cct #AND e.turno like '%tp.turno%'
        where  (e.status = 1 OR e.status = 4)
            AND e.desc_nivel_educativo <> 'INICIAL'
            AND e.cct NOT LIKE '05FUA%'
            AND desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL','MEDIA SUPERIOR','SUPERIOR')
            AND e.municipio = {$municipio}";
        if ($nivel_desc != 0) {
          $query .=" and e.desc_nivel_educativo = '{$nivel_desc}'";
        }
        $query .= " GROUP BY tp.cct
        ORDER BY tp.orden) AS obj
        GROUP BY obj.num_objetivos , obj.cct) AS total;";

        return $this->db->query($query)->result_array();
}

//LISTO
  function get_escuelasMun($nivel, $id_municipio)
 {
    switch ($nivel) {
        case '1':
            $nivel_desc = 'Especial'
            break;
        case '3':
            $nivel_desc = 'Preescolar'
            break;
        case '4':
            $nivel_desc = 'Primaria'
            break;
        case '5':
            $nivel_desc = 'Secundaria'
            break;
        default:
        $nivel_desc = 0;
            break;
    }

  $query = 'SELECT count(*) as total from vista_cct WHERE (status=1 OR status=4) AND desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL','MEDIA SUPERIOR','SUPERIOR')';
  if ($id_municipio != 0) {
   $query.= ' AND municipio = '.$id_municipio. '';
  }
  if ($nivel_desc != 0) {
   $query.= " AND desc_nivel_educativo = '{$nivel_desc}'";
  }
  return $this->db->query($query)->result_array();
  }

//LISTO
 function get_region(){
   $this->db->select('m.municipio, m.id_municipio, r.region, r.id_region');
  $this->db->from('municipio as m');
  $this->db->join('region as r', 'r.id_region = m.id_region');
  $this->db->order_by('m.id_region');

  return  $this->db->get()->result_array();
 }

 //LISTO
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

//listo
 function get_obj_acc_lae($nivel,$region,$municipio) {
  if ($nivel != 0) {
    switch ($nivel) {
        case '1':
            $nivel_desc = 'Especial'
            break;
        case '3':
            $nivel_desc = 'Preescolar'
            break;
        case '4':
            $nivel_desc = 'Primaria'
            break;
        case '5':
            $nivel_desc = 'Secundaria'
            break;
        default:
        $nivel_desc = 0;
            break;
    }
      $where_nivel= " and e.desc_nivel_educativo={$nivel_desc}";
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
  vista_cct e ON e.municipio = m.id_municipio
      INNER JOIN
  region r ON m.id_region = r.id_region
      INNER JOIN
  rm_tema_prioritarioxcct tp ON e.cct = tp.cct
      LEFT JOIN
  rm_accionxtproritario acc ON tp.id_tprioritario = acc.id_tprioritario
      LEFT JOIN
  rm_objetivo o ON o.id_tprioritario = tp.id_tprioritario
  WHERE
      (status = 1 OR status = 4)
          AND e.cct NOT LIKE '05FUA%'
          AND desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL', 'MEDIA SUPERIOR', 'SUPERIOR')
          {$where_nivel}
          {$where_region}
          {$where_municipio}
          AND tp.id_prioridad = 1
  GROUP BY e.municipio , tp.id_prioridad) AS l1
      INNER JOIN
  (SELECT
      COUNT(DISTINCT o.id_objetivo) AS total_objetivos,
          COUNT(DISTINCT acc.id_accion) AS total_acciones,
          tp.id_prioridad AS LAE,
          m.municipio
    FROM
  municipio m
      INNER JOIN
  vista_cct e ON e.municipio = m.id_municipio
      INNER JOIN
  region r ON m.id_region = r.id_region
      INNER JOIN
  rm_tema_prioritarioxcct tp ON e.cct = tp.cct
      LEFT JOIN
  rm_accionxtproritario acc ON tp.id_tprioritario = acc.id_tprioritario
      LEFT JOIN
  rm_objetivo o ON o.id_tprioritario = tp.id_tprioritario
  WHERE
      (status = 1 OR status = 4)
          AND e.cct NOT LIKE '05FUA%'
          AND desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL', 'MEDIA SUPERIOR', 'SUPERIOR')
          {$where_nivel}
          {$where_region}
          {$where_municipio}
          AND tp.id_prioridad = 2
  GROUP BY e.municipio , tp.id_prioridad) AS l2 ON l1.municipio = l2.municipio
      INNER JOIN
  (SELECT
      COUNT(DISTINCT o.id_objetivo) AS total_objetivos,
          COUNT(DISTINCT acc.id_accion) AS total_acciones,
          tp.id_prioridad AS LAE,
          m.municipio
   FROM
  municipio m
      INNER JOIN
  vista_cct e ON e.municipio = m.id_municipio
      INNER JOIN
  region r ON m.id_region = r.id_region
      INNER JOIN
  rm_tema_prioritarioxcct tp ON e.cct = tp.cct
      LEFT JOIN
  rm_accionxtproritario acc ON tp.id_tprioritario = acc.id_tprioritario
      LEFT JOIN
  rm_objetivo o ON o.id_tprioritario = tp.id_tprioritario
  WHERE
      (status = 1 OR status = 4)
          AND e.cct NOT LIKE '05FUA%'
          AND desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL', 'MEDIA SUPERIOR', 'SUPERIOR')
          {$where_nivel}
          {$where_region}
          {$where_municipio}
          AND tp.id_prioridad = 3
  GROUP BY e.municipio , tp.id_prioridad) AS l3 ON l1.municipio = l3.municipio
      INNER JOIN
  (SELECT
      COUNT(DISTINCT o.id_objetivo) AS total_objetivos,
          COUNT(DISTINCT acc.id_accion) AS total_acciones,
          tp.id_prioridad AS LAE,
          m.municipio
    FROM
  municipio m
      INNER JOIN
  vista_cct e ON e.municipio = m.id_municipio
      INNER JOIN
  region r ON m.id_region = r.id_region
      INNER JOIN
  rm_tema_prioritarioxcct tp ON e.cct = tp.cct
      LEFT JOIN
  rm_accionxtproritario acc ON tp.id_tprioritario = acc.id_tprioritario
      LEFT JOIN
  rm_objetivo o ON o.id_tprioritario = tp.id_tprioritario
  WHERE
      (status = 1 OR status = 4)
          AND e.cct NOT LIKE '05FUA%'
          AND desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL', 'MEDIA SUPERIOR', 'SUPERIOR')
          {$where_nivel}
          {$where_region}
          {$where_municipio}
          AND tp.id_prioridad = 4
  GROUP BY e.municipio , tp.id_prioridad) AS l4 ON l1.municipio = l4.municipio
      INNER JOIN
  (SELECT
      COUNT(DISTINCT o.id_objetivo) AS total_objetivos,
          COUNT(DISTINCT acc.id_accion) AS total_acciones,
          tp.id_prioridad AS LAE,
          m.municipio
   FROM
  municipio m
      INNER JOIN
  vista_cct e ON e.municipio = m.id_municipio
      INNER JOIN
  region r ON m.id_region = r.id_region
      INNER JOIN
  rm_tema_prioritarioxcct tp ON e.cct = tp.cct
      LEFT JOIN
  rm_accionxtproritario acc ON tp.id_tprioritario = acc.id_tprioritario
      LEFT JOIN
  rm_objetivo o ON o.id_tprioritario = tp.id_tprioritario
  WHERE
      (status = 1 OR status = 4)
          AND e.cct NOT LIKE '05FUA%'
          AND desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL', 'MEDIA SUPERIOR', 'SUPERIOR')
          {$where_nivel}
          {$where_region}
          {$where_municipio}
          AND tp.id_prioridad = 5
  GROUP BY e.municipio , tp.id_prioridad) AS l5 ON l1.municipio = l5.municipio
ORDER BY l1.id_region;";

  return $this->db->query($query)->result_array();
}

//listo
  function grafica_obj_acc_lae($nivel, $region, $municipio)
  {
    if ($nivel != 0) {
        switch ($nivel) {
            case '1':
                $nivel_desc = 'Especial'
                break;
            case '3':
                $nivel_desc = 'Preescolar'
                break;
            case '4':
                $nivel_desc = 'Primaria'
                break;
            case '5':
                $nivel_desc = 'Secundaria'
                break;
            default:
            $nivel_desc = 0;
                break;
        }
      $where_nivel = " AND e.desc_nivel_educativo = '{$nivel_desc}'";
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
    INNER JOIN vista_cct e ON e.municipio = m.id_municipio
    INNER JOIN region r ON m.id_region = r.id_region
    INNER JOIN rm_tema_prioritarioxcct tp ON e.cct = tp.cct
    LEFT JOIN rm_accionxtproritario acc ON tp.id_tprioritario = acc.id_tprioritario
    LEFT JOIN rm_objetivo o ON o.id_tprioritario = tp.id_tprioritario
    WHERE
        (status = 1 OR status = 4)
            AND e.cct NOT LIKE '05FUA%'
            AND desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL', 'MEDIA SUPERIOR', 'SUPERIOR')
            {$where_nivel}
            {$where_region}
            {$where_municipio}
    GROUP BY e.municipio , tp.id_prioridad) AS tl1
GROUP BY tl1.LAE";
return $this->db->query($query)->result_array();
  }

  //listo
 function get_obj_acc_lae_zona_sost($nivel, $zona, $sostenimiento)
 {

     $query = "SELECT tp.orden, COUNT(DISTINCT o.id_objetivo) as num_objetivos, COUNT(DISTINCT a.id_accion) as num_acciones,  group_concat(a.id_accion) as id_acciones, e.id_municipio
     FROM rm_tema_prioritarioxcct tp
     INNER JOIN rm_c_prioridad p on tp.id_prioridad=p.id_prioridad
     LEFT JOIN rm_objetivo o ON tp.id_tprioritario=o.id_tprioritario
     LEFT JOIN rm_accionxtproritario a on o.id_objetivo=a.id_objetivos
     inner join vista_cct e on e.cct = tp.cct
     inner join municipio m on m.id_municipio = e.municipio
     WHERE  (status = 1 OR status = 4) AND e.cct NOT LIKE '05FUA%' AND desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL', 'MEDIA SUPERIOR', 'SUPERIOR') and m.id_municipio is not null";
    if ($nivel != 0) {
        switch ($nivel) {
            case '1':
                $nivel_desc = 'Especial'
                break;
            case '3':
                $nivel_desc = 'Preescolar'
                break;
            case '4':
                $nivel_desc = 'Primaria'
                break;
            case '5':
                $nivel_desc = 'Secundaria'
                break;
            default:
            $nivel_desc = 0;
                break;
        }
        $query .= " and e.desc_nivel_educativo = '{$nivel_desc}'";
    }
    if ($zona != 0 && $sostenimiento != 0) {
       $query .= " and e.zona_escolar = {$zona}";
   }
   if ($sostenimiento != 0) {
       switch ($sostenimiento) {
           case '1':
            $query .= " AND e.sostenimiento NOT IN('61','41','92','96','51')";
                break;
            case '2':
            $query .= " AND e.sostenimiento IN ('61','41','92','96')";
                 break;
        
           default:
           $query .= "";
               break;
       }
     
   }

   $query .= " GROUP BY tp.orden  ORDER by tp.orden";

   return $this->db->query($query)->result_array();
}

//listo
function get_zonas($sostenimiento, $nivel){
    if ($nivel != 0) {
        switch ($nivel) {
            case '1':
                $nivel_desc = 'Especial'
                break;
            case '3':
                $nivel_desc = 'Preescolar'
                break;
            case '4':
                $nivel_desc = 'Primaria'
                break;
            case '5':
                $nivel_desc = 'Secundaria'
                break;
            default:
            $nivel_desc = 0;
                break;
        }
        $query .= " and e.desc_nivel_educativo = '{$nivel_desc}'";
    } else {
        $where_nivel = ' ';
    }

    if ($sostenimiento != 0) {
        switch ($sostenimiento) {
            case '1':
             $query .= " AND e.sostenimiento NOT IN('61','41','92','96','51')";
                 break;
             case '2':
             $query .= " AND e.sostenimiento IN ('61','41','92','96')";
                  break;
         
            default:
            $query .= "";
                break;
        }
    } else {
        $where_sostenimiento = ' ';
    }
    $str_query = "SELECT

    e.zona_escolar

    FROM
    vista_cct e
    INNER JOIN
    rm_tema_prioritarioxcct tp ON e.cct = tp.cct
    LEFT JOIN
    rm_accionxtproritario acc ON tp.id_tprioritario = acc.id_tprioritario
    LEFT JOIN
    rm_avance_xcctxtpxaccion ava ON ava.id_accion = acc.id_accion
    WHERE
    (e.status = 1 OR e.status = 4)
            AND e.desc_nivel_educativo <> 'INICIAL'
            AND e.cct NOT LIKE '05FUA%'
            AND desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL','MEDIA SUPERIOR','SUPERIOR')
    {$where_nivel}
    {$where_sostenimiento}
    GROUP BY  e.zona_escolar
    ORDER BY e.zona_escolar ASC";
    return $this->db->query($str_query)->result_array();
 }

//listo
    function get_porcent_zonas($sostenimiento, $zona, $nivel){

        if ($nivel != 0) {
            switch ($nivel) {
                case '1':
                    $nivel_desc = 'Especial'
                    break;
                case '3':
                    $nivel_desc = 'Preescolar'
                    break;
                case '4':
                    $nivel_desc = 'Primaria'
                    break;
                case '5':
                    $nivel_desc = 'Secundaria'
                    break;
                default:
                $nivel_desc = 0;
                    break;
            }
            $where_nivel = " AND e.desc_nivel_educativo = {$nivel_desc}";
        } else {
            $where_nivel = ' ';
        }

        if ($sostenimiento != 0) {
            switch ($sostenimiento) {
                case '1':
                 $query .= " AND e.sostenimiento NOT IN('61','41','92','96','51')";
                     break;
                 case '2':
                 $query .= " AND e.sostenimiento IN ('61','41','92','96')";
                      break;
             
                default:
                $query .= "";
                    break;
            }
        }

        if ($sostenimiento != 0 && $zona != 0) {
            $where_zona = " AND e.zona_escolar = {$zona}";
        } else {
            $where_zona = ' ';
        }

        $str_query = "SELECT
        zl1.nivel,
        zl1.id_sostenimiento,
        zl1.sostenimiento,
        zl1.zona_escolar,
        zl1.promedio AS lae1,
        zl2.promedio AS lae2,
        zl3.promedio AS lae3,
        zl4.promedio AS lae4,
        zl5.promedio AS lae5
        FROM
        (SELECT
        e.desc_nivel_educativo as nivel,
        e.sostenimiento as id_sostenimiento,
        e.desc_sostenimiento as sostenimiento,
        e.zona_escolar,
        tp.id_prioridad AS LAE,
        ROUND(IFNULL(AVG(ava.cte1), 0), 1) AS promedio
        FROM
		vista_cct e
        INNER JOIN rm_tema_prioritarioxcct tp ON e.cct = tp.cct
        LEFT JOIN rm_accionxtproritario acc ON tp.id_tprioritario = acc.id_tprioritario
        LEFT JOIN rm_avance_xcctxtpxaccion ava ON ava.id_accion = acc.id_accion
        WHERE
        (e.status = 1 OR e.status = 4)
            AND e.desc_nivel_educativo <> 'INICIAL'
            AND e.cct NOT LIKE '05FUA%'
            AND desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL','MEDIA SUPERIOR','SUPERIOR')
        AND tp.id_prioridad = 1
        {$where_nivel}
        {$where_sostenimiento}
        {$where_zona}
        GROUP BY e.nivel_educativo, e.sostenimiento, e.zona_escolar , tp.id_prioridad
        ORDER BY e.zona_escolar ASC) AS zl1
        INNER JOIN
        (SELECT
        e.desc_nivel_educativo as nivel,
        e.sostenimiento as id_sostenimiento,
        e.desc_sostenimiento as sostenimiento,
        e.zona_escolar,
        tp.id_prioridad AS LAE,
        ROUND(IFNULL(AVG(ava.cte1), 0), 1) AS promedio
        FROM
		vista_cct e
        INNER JOIN rm_tema_prioritarioxcct tp ON e.cct = tp.cct
        LEFT JOIN rm_accionxtproritario acc ON tp.id_tprioritario = acc.id_tprioritario
        LEFT JOIN rm_avance_xcctxtpxaccion ava ON ava.id_accion = acc.id_accion
        WHERE
        (e.status = 1 OR e.status = 4)
            AND e.desc_nivel_educativo <> 'INICIAL'
            AND e.cct NOT LIKE '05FUA%'
            AND desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL','MEDIA SUPERIOR','SUPERIOR')
        AND tp.id_prioridad = 2
        {$where_nivel}
        {$where_sostenimiento}
        {$where_zona}
        GROUP BY e.nivel_educativo, e.sostenimiento, e.zona_escolar , tp.id_prioridad
        ORDER BY e.zona_escolar ASC) AS zl2 ON zl1.zona_escolar = zl2.zona_escolar
        INNER JOIN
        (SELECT
        e.desc_nivel_educativo as nivel,
        e.sostenimiento as id_sostenimiento,
        e.desc_sostenimiento as sostenimiento,
        e.zona_escolar,
        tp.id_prioridad AS LAE,
        ROUND(IFNULL(AVG(ava.cte1), 0), 1) AS promedio
        FROM
		vista_cct e
        INNER JOIN rm_tema_prioritarioxcct tp ON e.cct = tp.cct
        LEFT JOIN rm_accionxtproritario acc ON tp.id_tprioritario = acc.id_tprioritario
        LEFT JOIN rm_avance_xcctxtpxaccion ava ON ava.id_accion = acc.id_accion
        WHERE
        (e.status = 1 OR e.status = 4)
            AND e.desc_nivel_educativo <> 'INICIAL'
            AND e.cct NOT LIKE '05FUA%'
            AND desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL','MEDIA SUPERIOR','SUPERIOR')
        AND tp.id_prioridad = 3
        {$where_nivel}
        {$where_sostenimiento}
        {$where_zona}
        GROUP BY e.nivel_educativo, e.sostenimiento, e.zona_escolar , tp.id_prioridad
        ORDER BY e.zona_escolar ASC) AS zl3 ON zl1.zona_escolar = zl3.zona_escolar
        INNER JOIN
        (SELECT
        e.desc_nivel_educativo as nivel,
        e.sostenimiento as id_sostenimiento,
        e.desc_sostenimiento as sostenimiento,
        e.zona_escolar,
        tp.id_prioridad AS LAE,
        ROUND(IFNULL(AVG(ava.cte1), 0), 1) AS promedio
        FROM
		vista_cct e
        INNER JOIN rm_tema_prioritarioxcct tp ON e.cct = tp.cct
        LEFT JOIN rm_accionxtproritario acc ON tp.id_tprioritario = acc.id_tprioritario
        LEFT JOIN rm_avance_xcctxtpxaccion ava ON ava.id_accion = acc.id_accion
        WHERE
        (e.status = 1 OR e.status = 4)
            AND e.desc_nivel_educativo <> 'INICIAL'
            AND e.cct NOT LIKE '05FUA%'
            AND desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL','MEDIA SUPERIOR','SUPERIOR')
        AND tp.id_prioridad = 4
        {$where_nivel}
        {$where_sostenimiento}
        {$where_zona}
        GROUP BY e.nivel_educativo, e.sostenimiento, e.zona_escolar , tp.id_prioridad
        ORDER BY e.zona_escolar ASC) AS zl4 ON zl1.zona_escolar = zl4.zona_escolar
        INNER JOIN
        (SELECT
        e.desc_nivel_educativo as nivel,
        e.sostenimiento as id_sostenimiento,
        e.desc_sostenimiento as sostenimiento,
        e.zona_escolar,
        tp.id_prioridad AS LAE,
        ROUND(IFNULL(AVG(ava.cte1), 0), 1) AS promedio
        FROM
		vista_cct e
        INNER JOIN rm_tema_prioritarioxcct tp ON e.cct = tp.cct
        LEFT JOIN rm_accionxtproritario acc ON tp.id_tprioritario = acc.id_tprioritario
        LEFT JOIN rm_avance_xcctxtpxaccion ava ON ava.id_accion = acc.id_accion
        WHERE
        (e.status = 1 OR e.status = 4)
            AND e.desc_nivel_educativo <> 'INICIAL'
            AND e.cct NOT LIKE '05FUA%'
            AND desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL','MEDIA SUPERIOR','SUPERIOR')
        AND tp.id_prioridad = 5
        {$where_nivel}
        {$where_sostenimiento}
        {$where_zona}
        GROUP BY e.nivel_educativo, e.sostenimiento, e.zona_escolar , tp.id_prioridad
        ORDER BY e.zona_escolar ASC) AS zl5 ON zl1.zona_escolar = zl5.zona_escolar
        GROUP BY zl1.zona_escolar , zl1.nivel";

        return $this->db->query($str_query)->result_array();
  }

//listo
  function getall_xest_ind(){
    $this->db->select('mu.id_municipio, mu.municipio');
    $this->db->from('municipio mu');
    $this->db->group_by('mu.id_municipio');
    return  $this->db->get()->result_array();
  }// getall_xest_ind()

  //listo
  function get_escuelasMun_gen($nivel){
     if ($nivel != 0) {
        switch ($nivel) {
            case '1':
                $nivel_desc = 'Especial'
                break;
            case '3':
                $nivel_desc = 'Preescolar'
                break;
            case '4':
                $nivel_desc = 'Primaria'
                break;
            case '5':
                $nivel_desc = 'Secundaria'
                break;
            default:
            $nivel_desc = 0;
                break;
        }
     $where= " and e.desc_nivel_educativo= '{$nivel_desc}'";
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
        m.id_municipio, m.municipio, COUNT(DISTINCT e.cct) n_escxmuni
        FROM municipio m
        INNER JOIN escuela e ON m.id_municipio = e.id_municipio
        WHERE (e.id_estatus=1 OR e.id_estatus=4) AND e.id_nivel <> 2 AND e.cve_centro NOT LIKE '05FUA%' AND e.id_nivel<6 {$where}
        GROUP BY m.id_municipio
    ) as mastert
    INNER JOIN
    (
        SELECT
        m.id_municipio, COUNT(DISTINCT IF(ISNULL(o.id_cct),NULL, o.id_cct)) as esc_que_capt,
        ROUND(IF(COUNT(DISTINCT IF(ISNULL(o.id_cct),NULL, o.id_cct))=0,0,(COUNT( DISTINCT IF(ISNULL(o.id_cct),NULL, o.id_cct))*100)/COUNT(DISTINCT e.cct)),1) as porcentaje
        FROM municipio m
    INNER JOIN vista_cct e ON m.id_municipio = e.municipio
        LEFT JOIN rm_tema_prioritarioxcct tp ON e.cct = tp.cct
        LEFT JOIN rm_objetivo o ON tp.id_tprioritario = o.id_tprioritario
        WHERE (e.status = 1 OR e.status = 4)
  AND e.desc_nivel_educativo <> 'INICIAL'
  AND e.cct NOT LIKE '05FUA%'
  AND desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL','MEDIA SUPERIOR','SUPERIOR') {$where}
        GROUP BY m.id_municipio
    ) captobj on mastert.id_municipio = captobj.id_municipio
    LEFT JOIN
    (
        SELECT
        xcon0.id_municipio, COUNT(DISTINCT xcon0.id_cct) as esc_que_capt0
        FROM
        (
        SELECT
        m.id_municipio, e.cct,
        COUNT(DISTINCT o.id_objetivo)
        FROM municipio m
    INNER JOIN vista_cct e ON m.id_municipio = e.municipio
        LEFT JOIN rm_tema_prioritarioxcct tp ON e.cct = tp.cct
        LEFT JOIN rm_objetivo o ON tp.id_tprioritario = o.id_tprioritario
        WHERE (e.status = 1 OR e.status = 4)
  AND e.desc_nivel_educativo <> 'INICIAL'
  AND e.cct NOT LIKE '05FUA%'
  AND desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL','MEDIA SUPERIOR','SUPERIOR') {$where}
        GROUP BY m.id_municipio, e.cct
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
        m.id_municipio, e.cct,
        COUNT(DISTINCT o.id_objetivo)
        FROM municipio m
    INNER JOIN vista_cct e ON m.id_municipio = e.municipio
        LEFT JOIN rm_tema_prioritarioxcct tp ON e.cct = tp.cct
        LEFT JOIN rm_objetivo o ON tp.id_tprioritario = o.id_tprioritario
        WHERE (e.status = 1 OR e.status = 4)
  AND e.desc_nivel_educativo <> 'INICIAL'
  AND e.cct NOT LIKE '05FUA%'
  AND desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL','MEDIA SUPERIOR','SUPERIOR') {$where}
        GROUP BY m.id_municipio, e.cct
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
        m.id_municipio, e.cct,
        COUNT(DISTINCT o.id_objetivo)
        FROM municipio m
    INNER JOIN vista_cct e ON m.id_municipio = e.municipio
        LEFT JOIN rm_tema_prioritarioxcct tp ON e.cct = tp.cct
        LEFT JOIN rm_objetivo o ON tp.id_tprioritario = o.id_tprioritario
        WHERE (e.status = 1 OR e.status = 4)
  AND e.desc_nivel_educativo <> 'INICIAL'
  AND e.cct NOT LIKE '05FUA%'
  AND desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL','MEDIA SUPERIOR','SUPERIOR') {$where}
        GROUP BY m.id_municipio, e.cct
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
        m.id_municipio, e.cct,
        COUNT(DISTINCT o.id_objetivo)
        FROM municipio m
    INNER JOIN vista_cct e ON m.id_municipio = e.municipio
        LEFT JOIN rm_tema_prioritarioxcct tp ON e.cct = tp.cct
        LEFT JOIN rm_objetivo o ON tp.id_tprioritario = o.id_tprioritario
        WHERE (e.status = 1 OR e.status = 4)
  AND e.desc_nivel_educativo <> 'INICIAL'
  AND e.cct NOT LIKE '05FUA%'
  AND desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL','MEDIA SUPERIOR','SUPERIOR') {$where}
        GROUP BY m.id_municipio, e.cct
        HAVING COUNT(DISTINCT o.id_objetivo)>3
        ) as xcon0
        GROUP BY xcon0.id_municipio
    ) as x3 on mastert.id_municipio = x3.id_municipio
    ";

    return $this->db->query($query)->result_array();
  }//get_escuelasMun_gen()

  //listo
  function get_toatalesc($nivel){
     if ($nivel != 0) {
        switch ($nivel) {
            case '1':
                $nivel_desc = 'Especial'
                break;
            case '3':
                $nivel_desc = 'Preescolar'
                break;
            case '4':
                $nivel_desc = 'Primaria'
                break;
            case '5':
                $nivel_desc = 'Secundaria'
                break;
            default:
            $nivel_desc = 0;
                break;
        }
     $where= " and e.desc_nivel_educativo= '{$nivel_desc}'";
     }
     else {
       $where= "";
     }
    $query = "SELECT
              COUNT(DISTINCT e.cct) as n_esc
              FROM vista_cct as e
              WHERE (e.status = 1 OR e.status = 4)
            AND e.desc_nivel_educativo <> 'INICIAL'
            AND e.cct NOT LIKE '05FUA%'
            AND desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL','MEDIA SUPERIOR','SUPERIOR') {$where}
              ";
    return $this->db->query($query)->row('n_esc');
  }//get_toatalesc()

  //listo
  function get_total_gen($nivel){
    if ($nivel != 0) {
        switch ($nivel) {
            case '1':
                $nivel_desc = 'Especial'
                break;
            case '3':
                $nivel_desc = 'Preescolar'
                break;
            case '4':
                $nivel_desc = 'Primaria'
                break;
            case '5':
                $nivel_desc = 'Secundaria'
                break;
            default:
            $nivel_desc = 0;
                break;
        }
     $where= " and e.desc_nivel_educativo= '{$nivel_desc}'";
    }
    else {
      $where= "";
    }
   $query = "SELECT
						 ROUND(((COUNT(DISTINCT IF(ISNULL(o.id_objetivo),NULL, e.cct)) * 100)/COUNT(DISTINCT e.cct)),1) as por_capt,
						 ROUND((100-((COUNT(DISTINCT IF(ISNULL(o.id_objetivo),NULL, e.cct)) * 100)/COUNT(DISTINCT e.cct))),1) as por_ncapt,
             COUNT(DISTINCT IF(ISNULL(o.id_objetivo),NULL, e.cct)) as n_esccapt,
             COUNT(DISTINCT e.cct)-COUNT(DISTINCT IF(ISNULL(o.id_objetivo),NULL, e.cct)) as n_escncapt
             FROM vista_cct as e
						 LEFT JOIN rm_tema_prioritarioxcct tp on e.cct = tp.cct
						 LEFT JOIN rm_objetivo o ON tp.id_tprioritario = o.id_tprioritario
                         WHERE  (status = 1 OR status = 4) AND e.cct NOT LIKE '05FUA%' AND desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL', 'MEDIA SUPERIOR', 'SUPERIOR') {$where}
             ";
  return $this->db->query($query)->result_array();
 }
}
