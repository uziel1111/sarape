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
      $this->db->select('e.cct, e.nombre, e.turno, e.desc_turno, e.desc_nivel_educativo, e.nombre_director,"upemc" as tipo_usuario_pemc,e.cct as cve_centro, "'.$turno.'" as id_turno_single, e.desc_nivel_educativo as nivel,e.nombre as nombre_centro');
      $this->db->from('vista_cct e');
      $this->db->where("e.cct = '{$cct}'");
      $this->db->where("e.turno like '%{$turno}%'");

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
                $nivel_desc = 'CAM';
                break;
            case '3':
                $nivel_desc = 'PREESCOLAR';
                break;
            case '4':
                $nivel_desc = 'PRIMARIA';
                break;
            case '5':
                $nivel_desc = 'SECUNDARIA';
                break;
            default:
            $nivel_desc = 0;
                break;
        }

    $query = "SELECT sum(total.cct) as total from  (select count(obj.num_objetivos), obj.municipio, obj.num_objetivos, count(obj.cct) as cct ,obj.cct as cct
        from (SELECT COUNT(DISTINCT o.id_objetivo) as num_objetivos, e.nombre_de_municipio as municipio, e.cct
        FROM rm_tema_prioritarioxcct tp
        INNER JOIN rm_c_prioridad p on tp.id_prioridad=p.id_prioridad
        LEFT JOIN rm_objetivo o ON tp.id_tprioritario=o.id_tprioritario
        LEFT JOIN rm_accionxtproritario a on o.id_objetivo=a.id_objetivos
        INNER JOIN vista_cct e ON e.cct = tp.cct #AND e.turno like '%tp.turno%'
        where  (e.status = 1 OR e.status = 4)
            AND e.desc_nivel_educativo <> 'INICIAL'
            AND e.cct NOT LIKE '05FUA%'
            AND e.desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL','MEDIA SUPERIOR','SUPERIOR')
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
            $nivel_desc = 'CAM';
            break;
        case '3':
            $nivel_desc = 'PREESCOLAR';
            break;
        case '4':
            $nivel_desc = 'PRIMARIA';
            break;
        case '5':
            $nivel_desc = 'SECUNDARIA';
            break;
        default:
        $nivel_desc = 0;
            break;
    }

  $query = "SELECT count(*) as total from vista_cct WHERE (status=1 OR status=4) AND desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL','MEDIA SUPERIOR','SUPERIOR')";
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
            $nivel_desc = 'CAM';
            break;
        case '3':
            $nivel_desc = 'PREESCOLAR';
            break;
        case '4':
            $nivel_desc = 'PRIMARIA';
            break;
        case '5':
            $nivel_desc = 'SECUNDARIA';
            break;
        default:
        $nivel_desc = 0;
            break;
    }
      $where_nivel= " and e.desc_nivel_educativo='{$nivel_desc}'";
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
  mun_reg_laes.region,
  mun_reg_laes.municipio,
  SUM(IFNULL(l1.total_objetivos,0)) AS obj1,
   SUM(IFNULL(l1.total_acciones,0)) AS acc1,
   SUM(IFNULL(l2.total_objetivos,0)) AS obj2,
   SUM(IFNULL(l2.total_acciones,0)) AS acc2,
   SUM(IFNULL(l3.total_objetivos,0)) AS obj3,
   SUM(IFNULL(l3.total_acciones,0)) AS acc3,
   SUM(IFNULL(l4.total_objetivos,0)) AS obj4,
   SUM(IFNULL(l4.total_acciones,0)) AS acc4,
   SUM(IFNULL(l5.total_objetivos,0)) AS obj5,
   SUM(IFNULL(l5.total_acciones,0)) AS acc5
FROM
(SELECT
m.id_municipio,m.municipio, m.id_region, r.region, laes.idlae
FROM c_pemc_laes laes
INNER JOIN municipio m ON 1=1
INNER JOIN region r ON m.id_region = r.id_region
where 1=1
{$where_region}
{$where_municipio}
GROUP BY m.municipio, r.region , laes.idlae) as mun_reg_laes
LEFT JOIN
  (SELECT
      COUNT(DISTINCT ro.idobjetivo) AS total_objetivos,
			COUNT(DISTINCT roa.idaccion) AS total_acciones,
			am.idlae AS LAE,
			m.municipio,
			r.region,
			r.id_region
   FROM municipio m
   INNER JOIN vista_cct e ON e.municipio = m.id_municipio
		INNER JOIN turno_temp t ON e.turno = t.idturno
   INNER JOIN region r ON m.id_region = r.id_region
		LEFT JOIN r_pemcxescuela rp ON e.cct = rp.cct AND t.idfederal = rp.id_turno_single
		LEFT JOIN r_pemc_objetivo ro ON rp.idpemc = ro.idpemc
		LEFT JOIN r_pemc_objetivo_accion roa ON ro.idobjetivo = roa.idobjetivo
		LEFT JOIN c_pemc_ambito am ON FIND_IN_SET(am.idambito, roa.idambitos) > 0
		LEFT JOIN c_pemc_laes laes	ON am.idlae = laes.idlae

  WHERE
      (status = 1 OR status = 4)
          AND e.cct NOT LIKE '05FUA%'
          AND desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL', 'MEDIA SUPERIOR', 'SUPERIOR')
          {$where_nivel}
          {$where_region}
          {$where_municipio}
          AND laes.idlae = 1
  GROUP BY e.municipio , laes.idlae) AS l1 ON mun_reg_laes.municipio = l1.municipio AND mun_reg_laes.id_region=l1.id_region AND mun_reg_laes.idlae = l1.LAE
LEFT JOIN
  (SELECT
      COUNT(DISTINCT ro.idobjetivo) AS total_objetivos,
			COUNT(DISTINCT roa.idaccion) AS total_acciones,
			am.idlae AS LAE,
			m.municipio,
			r.region,
			r.id_region
   FROM municipio m
   INNER JOIN vista_cct e ON e.municipio = m.id_municipio
		INNER JOIN turno_temp t ON e.turno = t.idturno
   INNER JOIN region r ON m.id_region = r.id_region
		LEFT JOIN r_pemcxescuela rp ON e.cct = rp.cct AND t.idfederal = rp.id_turno_single
		LEFT JOIN r_pemc_objetivo ro ON rp.idpemc = ro.idpemc
		LEFT JOIN r_pemc_objetivo_accion roa ON ro.idobjetivo = roa.idobjetivo
		LEFT JOIN c_pemc_ambito am ON FIND_IN_SET(am.idambito, roa.idambitos) > 0
		LEFT JOIN c_pemc_laes laes	ON am.idlae = laes.idlae

  WHERE
      (status = 1 OR status = 4)
          AND e.cct NOT LIKE '05FUA%'
          AND desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL', 'MEDIA SUPERIOR', 'SUPERIOR')
          {$where_nivel}
          {$where_region}
          {$where_municipio}
          AND laes.idlae = 2
  GROUP BY e.municipio , laes.idlae) AS l2 ON mun_reg_laes.municipio = l2.municipio AND mun_reg_laes.id_region=l2.id_region AND mun_reg_laes.idlae = l2.LAE
LEFT JOIN
  (SELECT
      COUNT(DISTINCT ro.idobjetivo) AS total_objetivos,
			COUNT(DISTINCT roa.idaccion) AS total_acciones,
			am.idlae AS LAE,
			m.municipio,
			r.region,
			r.id_region
   FROM municipio m
   INNER JOIN vista_cct e ON e.municipio = m.id_municipio
		INNER JOIN turno_temp t ON e.turno = t.idturno
   INNER JOIN region r ON m.id_region = r.id_region
		LEFT JOIN r_pemcxescuela rp ON e.cct = rp.cct AND t.idfederal = rp.id_turno_single
		LEFT JOIN r_pemc_objetivo ro ON rp.idpemc = ro.idpemc
		LEFT JOIN r_pemc_objetivo_accion roa ON ro.idobjetivo = roa.idobjetivo
		LEFT JOIN c_pemc_ambito am ON FIND_IN_SET(am.idambito, roa.idambitos) > 0
		LEFT JOIN c_pemc_laes laes	ON am.idlae = laes.idlae

  WHERE
      (status = 1 OR status = 4)
          AND e.cct NOT LIKE '05FUA%'
          AND desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL', 'MEDIA SUPERIOR', 'SUPERIOR')
          {$where_nivel}
          {$where_region}
          {$where_municipio}
          AND laes.idlae = 3
  GROUP BY e.municipio , laes.idlae) AS l3 ON mun_reg_laes.municipio = l3.municipio AND mun_reg_laes.id_region=l3.id_region AND mun_reg_laes.idlae = l3.LAE

LEFT JOIN
  (SELECT
      COUNT(DISTINCT ro.idobjetivo) AS total_objetivos,
			COUNT(DISTINCT roa.idaccion) AS total_acciones,
			am.idlae AS LAE,
			m.municipio,
			r.region,
			r.id_region
   FROM municipio m
   INNER JOIN vista_cct e ON e.municipio = m.id_municipio
		INNER JOIN turno_temp t ON e.turno = t.idturno
   INNER JOIN region r ON m.id_region = r.id_region
		LEFT JOIN r_pemcxescuela rp ON e.cct = rp.cct AND t.idfederal = rp.id_turno_single
		LEFT JOIN r_pemc_objetivo ro ON rp.idpemc = ro.idpemc
		LEFT JOIN r_pemc_objetivo_accion roa ON ro.idobjetivo = roa.idobjetivo
		LEFT JOIN c_pemc_ambito am ON FIND_IN_SET(am.idambito, roa.idambitos) > 0
		LEFT JOIN c_pemc_laes laes	ON am.idlae = laes.idlae

  WHERE
      (status = 1 OR status = 4)
          AND e.cct NOT LIKE '05FUA%'
          AND desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL', 'MEDIA SUPERIOR', 'SUPERIOR')
          {$where_nivel}
          {$where_region}
          {$where_municipio}
          AND laes.idlae = 4
  GROUP BY e.municipio , laes.idlae) AS l4 ON mun_reg_laes.municipio = l4.municipio AND mun_reg_laes.id_region=l4.id_region AND mun_reg_laes.idlae = l4.LAE

LEFT JOIN
  (SELECT
      COUNT(DISTINCT ro.idobjetivo) AS total_objetivos,
			COUNT(DISTINCT roa.idaccion) AS total_acciones,
			am.idlae AS LAE,
			m.municipio,
			r.region,
			r.id_region
   FROM municipio m
   INNER JOIN vista_cct e ON e.municipio = m.id_municipio
		INNER JOIN turno_temp t ON e.turno = t.idturno
   INNER JOIN region r ON m.id_region = r.id_region
		LEFT JOIN r_pemcxescuela rp ON e.cct = rp.cct AND t.idfederal = rp.id_turno_single
		LEFT JOIN r_pemc_objetivo ro ON rp.idpemc = ro.idpemc
		LEFT JOIN r_pemc_objetivo_accion roa ON ro.idobjetivo = roa.idobjetivo
		LEFT JOIN c_pemc_ambito am ON FIND_IN_SET(am.idambito, roa.idambitos) > 0
		LEFT JOIN c_pemc_laes laes	ON am.idlae = laes.idlae

  WHERE
      (status = 1 OR status = 4)
          AND e.cct NOT LIKE '05FUA%'
          AND desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL', 'MEDIA SUPERIOR', 'SUPERIOR')
          {$where_nivel}
          {$where_region}
          {$where_municipio}
          AND laes.idlae = 5
  GROUP BY e.municipio , laes.idlae) AS l5 ON mun_reg_laes.municipio = l5.municipio AND mun_reg_laes.id_region=l5.id_region AND mun_reg_laes.idlae = l5.LAE
GROUP BY mun_reg_laes.id_municipio, mun_reg_laes.id_region
ORDER BY l1.id_region;";
// echo "<pre>";print_r($query);die();
  return $this->db->query($query)->result_array();
}

//listo
  function grafica_obj_acc_lae($nivel, $region, $municipio)
  {
    if ($nivel != 0) {
        switch ($nivel) {
            case '1':
                $nivel_desc = 'CAM';
                break;
            case '3':
                $nivel_desc = 'PREESCOLAR';
                break;
            case '4':
                $nivel_desc = 'PRIMARIA';
                break;
            case '5':
                $nivel_desc = 'SECUNDARIA';
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
    IFNULL(tlae.objetivos,0) as obj, 
    IFNULL(tlae.acciones,0) as acc,
    l.idlae as LAE
    FROM c_pemc_laes l
    LEFT JOIN (
    SELECT
      COUNT(DISTINCT ro.idobjetivo)AS objetivos,
      COUNT(DISTINCT roa.idaccion) AS acciones,
      laes.idlae AS LAE
    FROM
        municipio m
        INNER JOIN vista_cct e ON e.municipio = m.id_municipio
        INNER JOIN turno_temp t ON e.turno = t.idturno
        INNER JOIN region r ON m.id_region = r.id_region
        INNER JOIN r_pemcxescuela rp ON e.cct = rp.cct AND t.idfederal = rp.id_turno_single
        INNER JOIN r_pemc_objetivo ro ON rp.idpemc = ro.idpemc
        INNER JOIN r_pemc_objetivo_accion roa ON ro.idobjetivo = roa.idobjetivo
        LEFT JOIN c_pemc_ambito am ON FIND_IN_SET(am.idambito, roa.idambitos) > 0
        LEFT JOIN c_pemc_laes laes  ON am.idlae = laes.idlae
    WHERE
      (status = 1 OR status = 4)
      AND e.cct NOT LIKE '05FUA%'
      AND e.desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL', 'MEDIA SUPERIOR', 'SUPERIOR')
       {$where_nivel}
       {$where_region}
       {$where_municipio}
      GROUP BY laes.idlae)
    as tlae ON l.idlae =tlae.LAE
    WHERE l.idlae!=6 AND l.idlae!=7";
        // echo "<pre>";print_r($query);die();
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
                $nivel_desc = 'CAM';
                break;
            case '3':
                $nivel_desc = 'PREESCOLAR';
                break;
            case '4':
                $nivel_desc = 'PRIMARIA';
                break;
            case '5':
                $nivel_desc = 'SECUNDARIA';
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
                $nivel_desc = 'CAM';
                break;
            case '3':
                $nivel_desc = 'PREESCOLAR';
                break;
            case '4':
                $nivel_desc = 'PRIMARIA';
                break;
            case '5':
                $nivel_desc = 'SECUNDARIA';
                break;
            default:
            $nivel_desc = 0;
                break;
        }
        $where_nivel = " and e.desc_nivel_educativo = '{$nivel_desc}'";
    } else {
        $where_nivel = ' ';
    }

    if ($sostenimiento != 0) {
        switch ($sostenimiento) {
            case '1':
             $where_sostenimiento = " AND e.sostenimiento NOT IN('61','41','92','96','51')";
                 break;
             case '2':
             $where_sostenimiento = " AND e.sostenimiento IN ('61','41','92','96')";
                  break;

            default:
            $where_sostenimiento= "";
                break;
        }
    } else {
        $where_sostenimiento = ' ';
    }
    $str_query = "SELECT
    DISTINCT(e.zona_escolar)
    FROM
    vista_cct e
    INNER JOIN turno_temp t ON e.turno = t.idturno
		INNER JOIN r_pemcxescuela rp ON e.cct = rp.cct AND t.idfederal = rp.id_turno_single
		INNER JOIN r_pemc_objetivo ro ON rp.idpemc = ro.idpemc
    INNER JOIN r_pemc_objetivo_accion roa ON ro.idobjetivo = roa.idobjetivo
    INNER JOIN r_pemc_accion_seguimiento seg ON roa.idaccion = seg.idaccion
    WHERE
    (e.status = 1 OR e.status = 4)
            AND e.desc_nivel_educativo <> 'INICIAL'
            AND e.cct NOT LIKE '05FUA%'
            AND desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL','MEDIA SUPERIOR','SUPERIOR')
            AND !ISNULL(e.zona_escolar)
    {$where_nivel}
    {$where_sostenimiento}
    ORDER BY e.zona_escolar ASC";
    return $this->db->query($str_query)->result_array();
 }

//listo
    function get_porcent_zonas($sostenimiento, $zona, $nivel){

        if ($nivel != 0) {
            switch ($nivel) {
                case '1':
                    $nivel_desc = 'CAM';
                    break;
                case '3':
                    $nivel_desc = 'PREESCOLAR';
                    break;
                case '4':
                    $nivel_desc = 'PRIMARIA';
                    break;
                case '5':
                    $nivel_desc = 'SECUNDARIA';
                    break;
                default:
                $nivel_desc = 0;
                    break;
            }
            $where_nivel = " AND e.desc_nivel_educativo = '{$nivel_desc}'";
        } else {
            $where_nivel = ' ';
        }

        if ($sostenimiento != 0) {
            switch ($sostenimiento) {
                case '1':
                 $where_sostenimiento = " AND e.sostenimiento NOT IN('61','41','92','96','51')";
                     break;
                 case '2':
                 $where_sostenimiento = " AND e.sostenimiento IN ('61','41','92','96')";
                      break;

                default:
                $where_sostenimiento = "";
                    break;
            }
        } else {
              $where_sostenimiento = "";
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
        laes.idlae AS LAE,
        ROUND(IFNULL(seg.avance, 0), 1) AS promedio
        FROM vista_cct e
        INNER JOIN turno_temp t ON e.turno = t.idturno
				INNER JOIN r_pemcxescuela rp ON e.cct = rp.cct AND t.idfederal = rp.id_turno_single
				INNER JOIN r_pemc_objetivo ro ON rp.idpemc = ro.idpemc
				INNER JOIN r_pemc_objetivo_accion roa ON ro.idobjetivo = roa.idobjetivo
				LEFT JOIN r_pemc_accion_seguimiento seg ON roa.idaccion = seg.idaccion
				LEFT JOIN c_pemc_ambito am ON FIND_IN_SET(am.idambito, roa.idambitos) > 0
				LEFT JOIN c_pemc_laes laes	ON am.idlae = laes.idlae
        WHERE
        (e.status = 1 OR e.status = 4)
            AND e.desc_nivel_educativo <> 'INICIAL'
            AND e.cct NOT LIKE '05FUA%'
            AND e.desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL','MEDIA SUPERIOR','SUPERIOR')
        AND laes.idlae = 1
        {$where_nivel}
        {$where_sostenimiento}
        {$where_zona}
        GROUP BY e.nivel_educativo, e.sostenimiento, e.zona_escolar , laes.idlae
				HAVING MAX(seg.fcreacion)
				ORDER BY e.zona_escolar ASC) AS zl1
        INNER JOIN
        (SELECT
        e.desc_nivel_educativo as nivel,
        e.sostenimiento as id_sostenimiento,
        e.desc_sostenimiento as sostenimiento,
        e.zona_escolar,
        laes.idlae AS LAE,
        ROUND(IFNULL(seg.avance, 0), 1) AS promedio
        FROM vista_cct e
        INNER JOIN turno_temp t ON e.turno = t.idturno
				INNER JOIN r_pemcxescuela rp ON e.cct = rp.cct AND t.idfederal = rp.id_turno_single
				INNER JOIN r_pemc_objetivo ro ON rp.idpemc = ro.idpemc
				INNER JOIN r_pemc_objetivo_accion roa ON ro.idobjetivo = roa.idobjetivo
				LEFT JOIN r_pemc_accion_seguimiento seg ON roa.idaccion = seg.idaccion
				LEFT JOIN c_pemc_ambito am ON FIND_IN_SET(am.idambito, roa.idambitos) > 0
				LEFT JOIN c_pemc_laes laes	ON am.idlae = laes.idlae
        WHERE
        (e.status = 1 OR e.status = 4)
            AND e.desc_nivel_educativo <> 'INICIAL'
            AND e.cct NOT LIKE '05FUA%'
            AND e.desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL','MEDIA SUPERIOR','SUPERIOR')
        AND laes.idlae = 2
        {$where_nivel}
        {$where_sostenimiento}
        {$where_zona}
        GROUP BY e.nivel_educativo, e.sostenimiento, e.zona_escolar , laes.idlae
				HAVING MAX(seg.fcreacion)
				ORDER BY e.zona_escolar ASC) AS zl2 ON zl1.zona_escolar = zl2.zona_escolar
        INNER JOIN
        (SELECT
        e.desc_nivel_educativo as nivel,
        e.sostenimiento as id_sostenimiento,
        e.desc_sostenimiento as sostenimiento,
        e.zona_escolar,
        laes.idlae AS LAE,
        ROUND(IFNULL(seg.avance, 0), 1) AS promedio
        FROM vista_cct e
        INNER JOIN turno_temp t ON e.turno = t.idturno
				INNER JOIN r_pemcxescuela rp ON e.cct = rp.cct AND t.idfederal = rp.id_turno_single
				INNER JOIN r_pemc_objetivo ro ON rp.idpemc = ro.idpemc
				INNER JOIN r_pemc_objetivo_accion roa ON ro.idobjetivo = roa.idobjetivo
				LEFT JOIN r_pemc_accion_seguimiento seg ON roa.idaccion = seg.idaccion
				LEFT JOIN c_pemc_ambito am ON FIND_IN_SET(am.idambito, roa.idambitos) > 0
				LEFT JOIN c_pemc_laes laes	ON am.idlae = laes.idlae
        WHERE
        (e.status = 1 OR e.status = 4)
            AND e.desc_nivel_educativo <> 'INICIAL'
            AND e.cct NOT LIKE '05FUA%'
            AND e.desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL','MEDIA SUPERIOR','SUPERIOR')
        AND laes.idlae = 3
        {$where_nivel}
        {$where_sostenimiento}
        {$where_zona}
        GROUP BY e.nivel_educativo, e.sostenimiento, e.zona_escolar , laes.idlae
				HAVING MAX(seg.fcreacion)
				ORDER BY e.zona_escolar ASC) AS zl3 ON zl1.zona_escolar = zl3.zona_escolar
        INNER JOIN
        (SELECT
        e.desc_nivel_educativo as nivel,
        e.sostenimiento as id_sostenimiento,
        e.desc_sostenimiento as sostenimiento,
        e.zona_escolar,
        laes.idlae AS LAE,
        ROUND(IFNULL(seg.avance, 0), 1) AS promedio
        FROM vista_cct e
        INNER JOIN turno_temp t ON e.turno = t.idturno
				INNER JOIN r_pemcxescuela rp ON e.cct = rp.cct AND t.idfederal = rp.id_turno_single
				INNER JOIN r_pemc_objetivo ro ON rp.idpemc = ro.idpemc
				INNER JOIN r_pemc_objetivo_accion roa ON ro.idobjetivo = roa.idobjetivo
				LEFT JOIN r_pemc_accion_seguimiento seg ON roa.idaccion = seg.idaccion
				LEFT JOIN c_pemc_ambito am ON FIND_IN_SET(am.idambito, roa.idambitos) > 0
				LEFT JOIN c_pemc_laes laes	ON am.idlae = laes.idlae
        WHERE
        (e.status = 1 OR e.status = 4)
            AND e.desc_nivel_educativo <> 'INICIAL'
            AND e.cct NOT LIKE '05FUA%'
            AND e.desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL','MEDIA SUPERIOR','SUPERIOR')
        AND laes.idlae = 4
        {$where_nivel}
        {$where_sostenimiento}
        {$where_zona}
        GROUP BY e.nivel_educativo, e.sostenimiento, e.zona_escolar , laes.idlae
				HAVING MAX(seg.fcreacion)
				ORDER BY e.zona_escolar ASC) AS zl4 ON zl1.zona_escolar = zl4.zona_escolar
        INNER JOIN
        (SELECT
        e.desc_nivel_educativo as nivel,
        e.sostenimiento as id_sostenimiento,
        e.desc_sostenimiento as sostenimiento,
        e.zona_escolar,
        laes.idlae AS LAE,
        ROUND(IFNULL(seg.avance, 0), 1) AS promedio
        FROM vista_cct e
        INNER JOIN turno_temp t ON e.turno = t.idturno
				INNER JOIN r_pemcxescuela rp ON e.cct = rp.cct AND t.idfederal = rp.id_turno_single
				INNER JOIN r_pemc_objetivo ro ON rp.idpemc = ro.idpemc
				INNER JOIN r_pemc_objetivo_accion roa ON ro.idobjetivo = roa.idobjetivo
				LEFT JOIN r_pemc_accion_seguimiento seg ON roa.idaccion = seg.idaccion
				LEFT JOIN c_pemc_ambito am ON FIND_IN_SET(am.idambito, roa.idambitos) > 0
				LEFT JOIN c_pemc_laes laes	ON am.idlae = laes.idlae
        WHERE
        (e.status = 1 OR e.status = 4)
            AND e.desc_nivel_educativo <> 'INICIAL'
            AND e.cct NOT LIKE '05FUA%'
            AND e.desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL','MEDIA SUPERIOR','SUPERIOR')
        AND laes.idlae = 5
        {$where_nivel}
        {$where_sostenimiento}
        {$where_zona}
        GROUP BY e.nivel_educativo, e.sostenimiento, e.zona_escolar , laes.idlae
				HAVING MAX(seg.fcreacion)
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
  function get_escuelasMun_gen($nivel, $modalidad, $sostenimiento){
     if ($nivel != 0) {
        switch ($nivel) {
            case '1':
                $nivel_desc = 'CAM';
                break;
            case '3':
                $nivel_desc = 'PREESCOLAR';
                break;
            case '4':
                $nivel_desc = 'PRIMARIA';
                break;
            case '5':
                $nivel_desc = 'SECUNDARIA';
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
     if ($modalidad != 0) {
       $where_m= " and e.subnivel_educativo= '{$modalidad}'";
     }
     else {
       $where_m= " ";
     }
     if ($sostenimiento != 0) {
       $where_s= " and e.sostenimiento= '{$sostenimiento}'";
     }
     else {
       $where_s= " ";
     }
    $query = "SELECT
    mastert.id_municipio, mastert.municipio, mastert.n_escxmuni,
    mastert.esc_que_capt, mastert.porcentaje,
    IFNULL(x0.esc_que_capt0,0) as esc_con0obj, IFNULL(x1.esc_que_capt1,0) as esc_con1obj,
    IFNULL(x2.esc_que_capt23,0) as esc_con2y3obj,IFNULL(x3.esc_que_captmay4,0) as esc_conmasde4obj
    FROM
    (
    SELECT
    m.id_municipio,
    m.municipio, 
    COUNT(DISTINCT CONCAT(e.cct, t.idfederal)) n_escxmuni,
    COUNT(DISTINCT ro.idpemc) as esc_que_capt,
    ROUND(IF(COUNT(DISTINCT ro.idpemc)=0,0,(COUNT(DISTINCT ro.idpemc)*100)/COUNT(DISTINCT CONCAT(e.cct,t.idfederal))),1) as porcentaje
    FROM municipio m
    INNER JOIN vista_cct e ON m.id_municipio = e.municipio
    INNER JOIN turno_temp t ON e.turno = t.idturno
    LEFT JOIN r_pemcxescuela rp ON e.cct = rp.cct AND t.idfederal = rp.id_turno_single
    LEFT JOIN r_pemc_objetivo ro ON rp.idpemc = ro.idpemc
    WHERE (e.status = 1 OR e.status = 4)
    AND e.desc_nivel_educativo <> 'INICIAL'
    AND e.cct NOT LIKE '05FUA%'
    AND e.desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL','MEDIA SUPERIOR','SUPERIOR') {$where}
    {$where_m}
    {$where_s}
     GROUP BY m.id_municipio
    ) as mastert
    
    LEFT JOIN
    (
        SELECT
        xcon0.id_municipio, COUNT(DISTINCT xcon0.cct) as esc_que_capt0
        FROM
        (
        SELECT
        m.id_municipio, CONCAT(e.cct,t.idfederal) as cct
        FROM municipio m
        INNER JOIN vista_cct e ON m.id_municipio = e.municipio
        INNER JOIN turno_temp t ON e.turno = t.idturno
        LEFT JOIN r_pemcxescuela rp ON e.cct = rp.cct AND t.idfederal = rp.id_turno_single
        LEFT JOIN r_pemc_objetivo ro ON rp.idpemc = ro.idpemc
        WHERE (e.status = 1 OR e.status = 4)
  AND e.desc_nivel_educativo <> 'INICIAL'
  AND e.cct NOT LIKE '05FUA%'
  AND desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL','MEDIA SUPERIOR','SUPERIOR') {$where}
  {$where_m}
  {$where_s}
        GROUP BY m.id_municipio, CONCAT(e.cct,t.idfederal)
        HAVING COUNT(DISTINCT ro.idobjetivo)=0
        ) as xcon0
        GROUP BY xcon0.id_municipio
    ) as x0 on mastert.id_municipio = x0.id_municipio

    LEFT JOIN
    (
        SELECT
        xcon0.id_municipio, COUNT(DISTINCT xcon0.cct) as esc_que_capt1
        FROM
        (
        SELECT
        m.id_municipio, 
        CONCAT(e.cct,t.idfederal) as cct
        FROM municipio m
        INNER JOIN vista_cct e ON m.id_municipio = e.municipio
        INNER JOIN turno_temp t ON e.turno = t.idturno
        LEFT JOIN r_pemcxescuela rp ON e.cct = rp.cct AND t.idfederal = rp.id_turno_single
        LEFT JOIN r_pemc_objetivo ro ON rp.idpemc = ro.idpemc
        WHERE (e.status = 1 OR e.status = 4)
  AND e.desc_nivel_educativo <> 'INICIAL'
  AND e.cct NOT LIKE '05FUA%'
  AND desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL','MEDIA SUPERIOR','SUPERIOR') {$where}
  {$where_m}
  {$where_s}
        GROUP BY m.id_municipio, CONCAT(e.cct,t.idfederal)
        HAVING COUNT(DISTINCT ro.idobjetivo)=1
        ) as xcon0
        GROUP BY xcon0.id_municipio
    ) as x1 on mastert.id_municipio = x1.id_municipio

    LEFT JOIN
    (
       SELECT
        xcon0.id_municipio, COUNT(DISTINCT xcon0.cct) as esc_que_capt23
        FROM
        (
        SELECT
        m.id_municipio,
        CONCAT(e.cct,t.idfederal) as cct       
        FROM municipio m
        INNER JOIN vista_cct e ON m.id_municipio = e.municipio
        INNER JOIN turno_temp t ON e.turno = t.idturno
        LEFT JOIN r_pemcxescuela rp ON e.cct = rp.cct AND t.idfederal = rp.id_turno_single
        LEFT JOIN r_pemc_objetivo ro ON rp.idpemc = ro.idpemc
        WHERE (e.status = 1 OR e.status = 4)
  AND e.desc_nivel_educativo <> 'INICIAL'
  AND e.cct NOT LIKE '05FUA%'
  AND desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL','MEDIA SUPERIOR','SUPERIOR') {$where}
  {$where_m}
  {$where_s}
        GROUP BY m.id_municipio, CONCAT(e.cct,t.idfederal)
        HAVING (COUNT(DISTINCT ro.idobjetivo)=2 OR COUNT(DISTINCT ro.idobjetivo)=3)
        ) as xcon0
        GROUP BY xcon0.id_municipio
    ) as x2 on mastert.id_municipio = x2.id_municipio

    LEFT JOIN
    (
        SELECT
        xcon0.id_municipio, COUNT(DISTINCT xcon0.cct) as esc_que_captmay4
        FROM
        (
        SELECT
        m.id_municipio, 
        CONCAT(e.cct,t.idfederal) as cct
        FROM municipio m
        INNER JOIN vista_cct e ON m.id_municipio = e.municipio
        INNER JOIN turno_temp t ON e.turno = t.idturno
        LEFT JOIN r_pemcxescuela rp ON e.cct = rp.cct AND t.idfederal = rp.id_turno_single
        LEFT JOIN r_pemc_objetivo ro ON rp.idpemc = ro.idpemc
        WHERE (e.status = 1 OR e.status = 4)
  AND e.desc_nivel_educativo <> 'INICIAL'
  AND e.cct NOT LIKE '05FUA%'
  AND desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL','MEDIA SUPERIOR','SUPERIOR') {$where}
  {$where_m}
  {$where_s}
        GROUP BY m.id_municipio, CONCAT(e.cct,t.idfederal)
        HAVING COUNT(DISTINCT ro.idobjetivo)>3
        ) as xcon0
        GROUP BY xcon0.id_municipio
    ) as x3 on mastert.id_municipio = x3.id_municipio
    ";
    return $this->db->query($query)->result_array();
  }//get_escuelasMun_gen()

  //listo
  function get_toatalesc($nivel, $modalidad, $sostenimiento){
     if ($nivel != 0) {
        switch ($nivel) {
            case '1':
                $nivel_desc = 'CAM';
                break;
            case '3':
                $nivel_desc = 'PREESCOLAR';
                break;
            case '4':
                $nivel_desc = 'PRIMARIA';
                break;
            case '5':
                $nivel_desc = 'SECUNDARIA';
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
     if ($modalidad != 0) {
       $where_m= " and e.subnivel_educativo= '{$modalidad}'";
     }
     else {
       $where_m= " ";
     }
     if ($sostenimiento != 0) {
       $where_s= " and e.sostenimiento= '{$sostenimiento}'";
     }
     else {
       $where_s= " ";
     }
    $query = "SELECT
              COUNT(DISTINCT CONCAT(e.cct,t.idfederal)) as n_esc
              FROM vista_cct as e
              INNER JOIN turno_temp t ON e.turno = t.idturno
              WHERE (e.status = 1 OR e.status = 4)
            AND e.desc_nivel_educativo <> 'INICIAL'
            AND e.cct NOT LIKE '05FUA%'
            AND desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL','MEDIA SUPERIOR','SUPERIOR') {$where}
            {$where_m}
            {$where_s}
              ";
    return $this->db->query($query)->row('n_esc');
  }//get_toatalesc()

  //listo
  function get_total_gen($nivel, $modalidad, $sostenimiento){
    if ($nivel != 0) {
        switch ($nivel) {
            case '1':
                $nivel_desc = 'CAM';
                break;
            case '3':
                $nivel_desc = 'PREESCOLAR';
                break;
            case '4':
                $nivel_desc = 'PRIMARIA';
                break;
            case '5':
                $nivel_desc = 'SECUNDARIA';
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
    if ($modalidad != 0) {
      $where_m= " and e.subnivel_educativo= '{$modalidad}'";
    }
    else {
      $where_m= " ";
    }
    if ($sostenimiento != 0) {
      $where_s= " and e.sostenimiento= '{$sostenimiento}'";
    }
    else {
      $where_s= " ";
    }
   $query = "SELECT
						 ROUND(IF(COUNT(DISTINCT ro.idpemc)=0,0,(COUNT(DISTINCT ro.idpemc)*100)/COUNT(DISTINCT CONCAT(e.cct,t.idfederal))),1) as por_capt,
						 ROUND((100-IF(COUNT(DISTINCT ro.idpemc)=0,0,(COUNT(DISTINCT ro.idpemc)*100)/COUNT(DISTINCT CONCAT(e.cct,t.idfederal)))),1) as por_ncapt,
             COUNT(DISTINCT ro.idpemc) as n_esccapt,
             ((COUNT(DISTINCT CONCAT(e.cct,t.idfederal)))-(COUNT(DISTINCT ro.idpemc))) as n_escncapt
             FROM vista_cct as e
						 INNER JOIN turno_temp t ON e.turno = t.idturno
						LEFT JOIN r_pemcxescuela rp ON e.cct = rp.cct AND t.idfederal = rp.id_turno_single
						LEFT JOIN r_pemc_objetivo ro ON rp.idpemc = ro.idpemc
						WHERE  (status = 1 OR status = 4) AND e.cct NOT LIKE '05FUA%' AND desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL', 'MEDIA SUPERIOR', 'SUPERIOR') {$where}
            {$where_m}
            {$where_s}
             ";
  return $this->db->query($query)->result_array();
 }

 function get_modalidad_gen($nivel){
   if ($nivel != 0) {
       switch ($nivel) {
           case '1':
               $nivel_desc = 'CAM';
               break;
           case '3':
               $nivel_desc = 'PREESCOLAR';
               break;
           case '4':
               $nivel_desc = 'PRIMARIA';
               break;
           case '5':
               $nivel_desc = 'SECUNDARIA';
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
e.subnivel_educativo as idmodalidad, e.desc_subnivel_educativo as modalidad
FROM vista_cct e
where  (e.status = 1 OR e.status = 4)
            AND e.desc_nivel_educativo <> 'INICIAL'
            AND e.cct NOT LIKE '05FUA%'
            AND e.desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL','MEDIA SUPERIOR','SUPERIOR') {$where}
GROUP BY e.subnivel_educativo";
 return $this->db->query($query)->result_array();
}

function get_sostenimiento_gen($nivel,$modalidad){
  if ($nivel != 0) {
      switch ($nivel) {
          case '1':
              $nivel_desc = 'CAM';
              break;
          case '3':
              $nivel_desc = 'PREESCOLAR';
              break;
          case '4':
              $nivel_desc = 'PRIMARIA';
              break;
          case '5':
              $nivel_desc = 'SECUNDARIA';
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
  if ($modalidad != 0) {
    $where_m= " and e.subnivel_educativo= '{$modalidad}'";
  }
  else {
    $where_m= " ";
  }
 $query = "SELECT
e.sostenimiento as idsostenimiento, e.desc_sostenimiento as sostenimiento
FROM vista_cct e
where  (e.status = 1 OR e.status = 4)
            AND e.desc_nivel_educativo <> 'INICIAL'
            AND e.cct NOT LIKE '05FUA%'
            AND e.desc_nivel_educativo NOT IN ('FORMACION PARA EL TRABAJO' , 'OTRO NIVEL EDUCATIVO', 'NO APLICA', 'INICIAL','MEDIA SUPERIOR','SUPERIOR') {$where} {$where_m}
GROUP BY e.sostenimiento";
return $this->db->query($query)->result_array();
}

}
