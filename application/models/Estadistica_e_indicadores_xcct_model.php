<?php

class Estadistica_e_indicadores_xcct_model extends CI_Model
{

  function __construct()
  {
    parent::__construct();
  }

  function get_nalumnos_xmunciclo($id_municipio, $id_ciclo){
    // echo '<pre>'; print_r($id_ciclo); die();
    // $this->db->select('ni.id_nivel,ni.nivel, "0" as id_sostenimiento, "total" as sostenimiento, "0" as id_modalidad, "total" as modalidad,
    // SUM(est.alumn_m_t) as alumn_m_t, SUM(est.alumn_h_t) as alumn_h_t, SUM(est.alumn_t_t) as alumn_t_t,
    // SUM(est.alumn_t_1) as alumn_t_1, SUM(est.alumn_t_2) as alumn_t_2, SUM(est.alumn_t_3) as alumn_t_3,
    // SUM(est.alumn_t_4) as alumn_t_4, SUM(est.alumn_t_5) as alumn_t_5, SUM(est.alumn_t_6) as alumn_t_6');
    // $this->db->from('escuela as es');
    // $this->db->join('estadistica_e_indicadores_xcct as est', 'es.id_cct = est.id_cct');
    // $this->db->join('municipio as mu', 'es.id_municipio = mu.id_municipio');
    // $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
    // $this->db->join('ciclo as ci', 'est.id_ciclo = ci.id_ciclo');
    // if($id_municipio>0){
    //   $this->db->where('mu.id_municipio', $id_municipio);
    // }
    // if($id_ciclo>0){
    //   $this->db->where('ci.id_ciclo', $id_ciclo);
    // }
    // $this->db->where('ni.id_nivel <',8);
    // $this->db->group_by("ni.nivel");

    // $query1 = $this->db->get_compiled_select();
    $filtro="";
    if($id_municipio>0){
      $filtro.=" AND v.municipio={$id_municipio}";
    }
    if($id_ciclo>0){
      $filtro.=" AND es.id_ciclo={$id_ciclo}";
    }

    $query1="SELECT 
              CASE  
                  WHEN a.nivel LIKE '%ESPECIAL%' THEN '1'
                  WHEN a.nivel LIKE '%INICIAL%' THEN '2'
                  WHEN a.nivel LIKE '%PREESCOLAR%' THEN '3'
                  WHEN a.nivel LIKE '%PRIMARIA%' THEN '4'
                  WHEN a.nivel LIKE '%SECUNDARIA%' THEN '5'
                  WHEN a.nivel LIKE '%MEDIA SUPERIOR%' THEN '6'
                  WHEN a.nivel LIKE '%SUPERIOR%' THEN '7'
                  END AS id_nivel,a.nivel,a.id_sostenimiento,a.sostenimiento,a.id_modalidad,a.modalidad,
                  alumn_m_t,alumn_h_t,alumn_t_t,alumn_t_1,alumn_t_2,alumn_t_3
                  ,alumn_t_4,alumn_t_5,alumn_t_6
               FROM (
              SELECT v.nivel_educativo,
                CASE  
                    WHEN v.desc_nivel_educativo LIKE '%CAM%' THEN 'ESPECIAL'
                    WHEN v.desc_nivel_educativo LIKE '%INICIAL%' THEN 'INICIAL'
                    WHEN v.desc_nivel_educativo LIKE '%PREESCOLAR%' THEN 'PREESCOLAR'
                    WHEN v.desc_nivel_educativo LIKE '%PRIMARIA%' THEN 'PRIMARIA'
                    WHEN v.desc_nivel_educativo LIKE '%SECUNDARIA%' THEN 'SECUNDARIA'
                    WHEN v.desc_nivel_educativo LIKE '%MEDIA SUPERIOR%' THEN 'MEDIA SUPERIOR'
                    WHEN v.desc_nivel_educativo LIKE '%SUPERIOR%' THEN 'SUPERIOR'
                    END AS nivel,'0' AS id_sostenimiento,'total' AS sostenimiento, '0' AS id_modalidad,
                    'total' AS modalidad,
                    SUM(es.alumn_m_t) AS alumn_m_t, SUM(es.alumn_h_t) AS alumn_h_t, SUM(es.alumn_t_t) AS alumn_t_t,
                    SUM(es.alumn_t_1) AS alumn_t_1, SUM(es.alumn_t_2) AS alumn_t_2, SUM(es.alumn_t_3) AS alumn_t_3,
                    SUM(es.alumn_t_4) AS alumn_t_4, SUM(es.alumn_t_5) AS alumn_t_5, SUM(es.alumn_t_6) AS alumn_t_6
                FROM vista_cct v
                INNER JOIN estadistica_e_indicadores_xcct es ON es.cct=v.cct
                WHERE (v.status= 1 OR v.status = 4) AND v.tipo_centro=9 
                AND v.desc_nivel_educativo NOT IN('FORMACION PARA EL TRABAJO','OTRO NIVEL EDUCATIVO','NO APLICA')
                {$filtro}               
                GROUP BY CASE  
                  WHEN v.desc_nivel_educativo LIKE '%CAM%' THEN 'ESPECIAL'
                  WHEN v.desc_nivel_educativo LIKE '%INICIAL%' THEN 'INICIAL'
                  WHEN v.desc_nivel_educativo LIKE '%PREESCOLAR%' THEN 'PREESCOLAR'
                  WHEN v.desc_nivel_educativo LIKE '%PRIMARIA%' THEN 'PRIMARIA'
                  WHEN v.desc_nivel_educativo LIKE '%SECUNDARIA%' THEN 'SECUNDARIA'
                  WHEN v.desc_nivel_educativo LIKE '%MEDIA SUPERIOR%' THEN 'MEDIA SUPERIOR'
                  WHEN v.desc_nivel_educativo LIKE '%SUPERIOR%' THEN 'SUPERIOR'
                  END
                  ) AS a ";



    // $this->db->select('ni.id_nivel,ni.nivel, so.id_sostenimiento, so.sostenimiento, "0" as id_modalidad, "total" as modalidad,
    // SUM(est.alumn_m_t) as alumn_m_t, SUM(est.alumn_h_t) as alumn_h_t, SUM(est.alumn_t_t) as alumn_t_t,
    // SUM(est.alumn_t_1) as alumn_t_1, SUM(est.alumn_t_2) as alumn_t_2, SUM(est.alumn_t_3) as alumn_t_3,
    // SUM(est.alumn_t_4) as alumn_t_4, SUM(est.alumn_t_5) as alumn_t_5, SUM(est.alumn_t_6) as alumn_t_6');
    // $this->db->from('escuela as es');
    // $this->db->join('estadistica_e_indicadores_xcct as est', 'es.id_cct = est.id_cct');
    // $this->db->join('municipio as mu', 'es.id_municipio = mu.id_municipio');
    // $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
    // $this->db->join('modalidad as mo', 'es.id_modalidad = mo.id_modalidad');
    // $this->db->join('subsostenimiento as sso', 'es.id_subsostenimiento = sso.id_subsostenimiento');
    // $this->db->join('sostenimiento as so', 'sso.id_sostenimiento = so.id_sostenimiento');
    // $this->db->join('ciclo as ci', 'est.id_ciclo = ci.id_ciclo');
    // if($id_municipio>0){
    //   $this->db->where('mu.id_municipio', $id_municipio);
    // }
    // if($id_ciclo>0){
    //   $this->db->where('ci.id_ciclo', $id_ciclo);
    // }
    // $this->db->where('ni.id_nivel <', 8);
    // $this->db->group_by("ni.nivel");
    // $this->db->group_by("so.sostenimiento");

    // $query2 = $this->db->get_compiled_select();

    $query2="SELECT 
              CASE  
                  WHEN a.nivel LIKE '%ESPECIAL%' THEN '1'
                  WHEN a.nivel LIKE '%INICIAL%' THEN '2'
                  WHEN a.nivel LIKE '%PREESCOLAR%' THEN '3'
                  WHEN a.nivel LIKE '%PRIMARIA%' THEN '4'
                  WHEN a.nivel LIKE '%SECUNDARIA%' THEN '5'
                  WHEN a.nivel LIKE '%MEDIA SUPERIOR%' THEN '6'
                  WHEN a.nivel LIKE '%SUPERIOR%' THEN '7'
                  END AS id_nivel,a.nivel,a.id_sostenimiento,a.sostenimiento,a.id_modalidad,a.modalidad,
                  alumn_m_t,alumn_h_t,alumn_t_t,alumn_t_1,alumn_t_2,alumn_t_3
                  ,alumn_t_4,alumn_t_5,alumn_t_6
               FROM (
              SELECT v.nivel_educativo,
                CASE  
                  WHEN v.desc_nivel_educativo LIKE '%CAM%' THEN 'ESPECIAL'
                  WHEN v.desc_nivel_educativo LIKE '%INICIAL%' THEN 'INICIAL'
                  WHEN v.desc_nivel_educativo LIKE '%PREESCOLAR%' THEN 'PREESCOLAR'
                  WHEN v.desc_nivel_educativo LIKE '%PRIMARIA%' THEN 'PRIMARIA'
                  WHEN v.desc_nivel_educativo LIKE '%SECUNDARIA%' THEN 'SECUNDARIA'
                  WHEN v.desc_nivel_educativo LIKE '%MEDIA SUPERIOR%' THEN 'MEDIA SUPERIOR'
                  WHEN v.desc_nivel_educativo LIKE '%SUPERIOR%' THEN 'SUPERIOR'
                  END AS nivel,
                    (SELECT CASE  
                          WHEN v.sostenimiento IN  ('51') THEN '3' 
                          WHEN v.sostenimiento IN ('61','41','92','96') THEN '2'
                          ELSE '1'
                     END) AS id_sostenimiento,
                     (SELECT CASE  
                          WHEN v.sostenimiento IN  ('51') THEN 'AUTONOMO' 
                          WHEN v.sostenimiento IN ('61','41','92','96') THEN 'PRIVADO'
                          ELSE 'PUBLICO'
                      END) AS sostenimiento
                  , '0' AS id_modalidad, 'total' AS modalidad,
                SUM(es.alumn_m_t) AS alumn_m_t, SUM(es.alumn_h_t) AS alumn_h_t, SUM(es.alumn_t_t) AS alumn_t_t,
                SUM(es.alumn_t_1) AS alumn_t_1, SUM(es.alumn_t_2) AS alumn_t_2, SUM(es.alumn_t_3) AS alumn_t_3,
                SUM(es.alumn_t_4) AS alumn_t_4, SUM(es.alumn_t_5) AS alumn_t_5, SUM(es.alumn_t_6) AS alumn_t_6
                FROM vista_cct v
                INNER JOIN estadistica_e_indicadores_xcct es ON es.cct=v.cct
                WHERE (v.status= 1 OR v.status = 4) AND v.tipo_centro=9 
                AND v.desc_nivel_educativo NOT IN('FORMACION PARA EL TRABAJO','OTRO NIVEL EDUCATIVO','NO APLICA')
                {$filtro}
                GROUP BY (CASE  
                  WHEN v.desc_nivel_educativo LIKE '%CAM%' THEN 'ESPECIAL'
                  WHEN v.desc_nivel_educativo LIKE '%INICIAL%' THEN 'INICIAL'
                  WHEN v.desc_nivel_educativo LIKE '%PREESCOLAR%' THEN 'PREESCOLAR'
                  WHEN v.desc_nivel_educativo LIKE '%PRIMARIA%' THEN 'PRIMARIA'
                  WHEN v.desc_nivel_educativo LIKE '%SECUNDARIA%' THEN 'SECUNDARIA'
                  WHEN v.desc_nivel_educativo LIKE '%MEDIA SUPERIOR%' THEN 'MEDIA SUPERIOR'
                  WHEN v.desc_nivel_educativo LIKE '%SUPERIOR%' THEN 'SUPERIOR'
                  END),(CASE  
                          WHEN v.sostenimiento IN  ('51') THEN 'AUTONOMO' 
                          WHEN v.sostenimiento IN ('61','41','92','96') THEN 'PRIVADO'
                          ELSE 'PUBLICO' END)
                  ) AS a ";


    // $this->db->select('ni.id_nivel,ni.nivel, so.id_sostenimiento, so.sostenimiento, mo.id_modalidad, mo.modalidad,
    // SUM(est.alumn_m_t) as alumn_m_t, SUM(est.alumn_h_t) as alumn_h_t, SUM(est.alumn_t_t) as alumn_t_t,
    // SUM(est.alumn_t_1) as alumn_t_1, SUM(est.alumn_t_2) as alumn_t_2, SUM(est.alumn_t_3) as alumn_t_3,
    // SUM(est.alumn_t_4) as alumn_t_4, SUM(est.alumn_t_5) as alumn_t_5, SUM(est.alumn_t_6) as alumn_t_6');
    // $this->db->from('escuela as es');
    // $this->db->join('estadistica_e_indicadores_xcct as est', 'es.id_cct = est.id_cct');
    // $this->db->join('municipio as mu', 'es.id_municipio = mu.id_municipio');
    // $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
    // $this->db->join('modalidad as mo', 'es.id_modalidad = mo.id_modalidad');
    // $this->db->join('subsostenimiento as sso', 'es.id_subsostenimiento = sso.id_subsostenimiento');
    // $this->db->join('sostenimiento as so', 'sso.id_sostenimiento = so.id_sostenimiento');
    // $this->db->join('ciclo as ci', 'est.id_ciclo = ci.id_ciclo');
    // if($id_municipio>0){
    //   $this->db->where('mu.id_municipio', $id_municipio);
    // }
    // if($id_ciclo>0){
    //   $this->db->where('ci.id_ciclo', $id_ciclo);
    // }
    // $this->db->where('ni.id_nivel <', 8);
    // $this->db->group_by("ni.nivel");
    // $this->db->group_by("so.sostenimiento");
    // $this->db->group_by("mo.modalidad");

    // $this->db->order_by("id_nivel");
    // $this->db->order_by("sostenimiento", "DESC");
    // $this->db->order_by("id_modalidad", "ASC");

    // $query3 = $this->db->get_compiled_select();

    $query3="SELECT 
            CASE  
                WHEN a.nivel LIKE '%ESPECIAL%' THEN '1'
                WHEN a.nivel LIKE '%INICIAL%' THEN '2'
                WHEN a.nivel LIKE '%PREESCOLAR%' THEN '3'
                WHEN a.nivel LIKE '%PRIMARIA%' THEN '4'
                WHEN a.nivel LIKE '%SECUNDARIA%' THEN '5'
                WHEN a.nivel LIKE '%MEDIA SUPERIOR%' THEN '6'
                WHEN a.nivel LIKE '%SUPERIOR%' THEN '7'
                END AS id_nivel,a.nivel,a.id_sostenimiento,a.sostenimiento,a.id_modalidad,a.modalidad,
                alumn_m_t,alumn_h_t,alumn_t_t,alumn_t_1,alumn_t_2,alumn_t_3,alumn_t_4,alumn_t_5,alumn_t_6
            FROM (
                SELECT v.nivel_educativo,
                    CASE  
                        WHEN v.desc_nivel_educativo LIKE '%CAM%' THEN 'ESPECIAL'
                        WHEN v.desc_nivel_educativo LIKE '%INICIAL%' THEN 'INICIAL'
                        WHEN v.desc_nivel_educativo LIKE '%PREESCOLAR%' THEN 'PREESCOLAR'
                        WHEN v.desc_nivel_educativo LIKE '%PRIMARIA%' THEN 'PRIMARIA'
                        WHEN v.desc_nivel_educativo LIKE '%SECUNDARIA%' THEN 'SECUNDARIA'
                        WHEN v.desc_nivel_educativo LIKE '%MEDIA SUPERIOR%' THEN 'MEDIA SUPERIOR'
                        WHEN v.desc_nivel_educativo LIKE '%SUPERIOR%' THEN 'SUPERIOR'
                        END AS nivel,
                        (SELECT CASE  
                            WHEN v.sostenimiento IN  ('51') THEN '3' 
                            WHEN v.sostenimiento IN ('61','41','92','96') THEN '2'
                            ELSE '1'
                        END) AS id_sostenimiento,
                        (SELECT CASE  
                            WHEN v.sostenimiento IN  ('51') THEN 'AUTONOMO' 
                            WHEN v.sostenimiento IN ('61','41','92','96') THEN 'PRIVADO'
                            ELSE 'PUBLICO'
                        END) AS sostenimiento
                        , v.servicio AS id_modalidad,v.desc_servicio AS modalidad,
                        SUM(es.alumn_m_t) AS alumn_m_t, SUM(es.alumn_h_t) AS alumn_h_t, SUM(es.alumn_t_t) AS alumn_t_t,
                        SUM(es.alumn_t_1) AS alumn_t_1, SUM(es.alumn_t_2) AS alumn_t_2, SUM(es.alumn_t_3) AS alumn_t_3,
                        SUM(es.alumn_t_4) AS alumn_t_4, SUM(es.alumn_t_5) AS alumn_t_5, SUM(es.alumn_t_6) AS alumn_t_6
                FROM vista_cct v
                INNER JOIN estadistica_e_indicadores_xcct es ON es.cct=v.cct
                WHERE (v.status= 1 OR v.status = 4) AND v.tipo_centro=9 
                AND v.desc_nivel_educativo NOT IN('FORMACION PARA EL TRABAJO','OTRO NIVEL EDUCATIVO','NO APLICA')
                {$filtro}
                GROUP BY (CASE  
                    WHEN v.desc_nivel_educativo LIKE '%CAM%' THEN 'ESPECIAL'
                    WHEN v.desc_nivel_educativo LIKE '%INICIAL%' THEN 'INICIAL'
                    WHEN v.desc_nivel_educativo LIKE '%PREESCOLAR%' THEN 'PREESCOLAR'
                    WHEN v.desc_nivel_educativo LIKE '%PRIMARIA%' THEN 'PRIMARIA'
                    WHEN v.desc_nivel_educativo LIKE '%SECUNDARIA%' THEN 'SECUNDARIA'
                    WHEN v.desc_nivel_educativo LIKE '%MEDIA SUPERIOR%' THEN 'MEDIA SUPERIOR'
                    WHEN v.desc_nivel_educativo LIKE '%SUPERIOR%' THEN 'SUPERIOR'
                    END),(CASE  
                          WHEN v.sostenimiento IN  ('51') THEN 'AUTONOMO' 
                          WHEN v.sostenimiento IN ('61','41','92','96') THEN 'PRIVADO'
                          ELSE 'PUBLICO' END),v.servicio
            ) AS a ORDER BY FIELD(nivel,'ESPECIAL','INICIAL','PREESCOLAR','PRIMARIA','SECUNDARIA','MEDIA SUPERIOR','SUPERIOR')
                ,id_sostenimiento,id_modalidad ";

    // $this->db->query($query1 . ' UNION ALL ' . $query2. ' UNION ALL ' . $query3)->result_array();
    // $str = $this->db->last_query();
    // echo $str; die();

// echo "<pre>"; print_r($query1 . ' UNION ALL ' . $query2. ' UNION ALL ' . $query3); die();
    return $this->db->query($query1 . ' UNION ALL ' . $query2. ' UNION ALL ' . $query3)->result_array();

  }// get_nalumnos_xmunciclo()



  function get_nalumnos_xzona($nivel,$sostenimiento,$id_zona_z,$id_ciclo_z){
    // $this->db->select('ni.id_nivel,ni.nivel, "0" as id_subsostenimiento, "total" as subsostenimiento, "0" as id_modalidad, "total" as modalidad,
    // SUM(est.alumn_m_t) as alumn_m_t, SUM(est.alumn_h_t) as alumn_h_t, SUM(est.alumn_t_t) as alumn_t_t,
    // SUM(est.alumn_t_1) as alumn_t_1, SUM(est.alumn_t_2) as alumn_t_2, SUM(est.alumn_t_3) as alumn_t_3,
    // SUM(est.alumn_t_4) as alumn_t_4, SUM(est.alumn_t_5) as alumn_t_5, SUM(est.alumn_t_6) as alumn_t_6');
    // $this->db->from('escuela as es');
    // $this->db->join('estadistica_e_indicadores_xcct as est', 'es.id_cct = est.id_cct');
    // $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
    // $this->db->join('subsostenimiento as sso', '`es`.`id_subsostenimiento` = `sso`.`id_subsostenimiento`');
    // $this->db->join('supervision as su', '`es`.`id_supervision` = `su`.`id_supervision`');
    // $this->db->join('ciclo as ci', 'est.id_ciclo = ci.id_ciclo');
    // if($id_nivel_z>0){
    //   $this->db->where('ni.id_nivel', $id_nivel_z);
    // }
    // if($id_sostenimiento_z>0){
    //   $this->db->where('sso.id_subsostenimiento', $id_sostenimiento_z);
    // }
    // if($id_zona_z>0){
    //   $this->db->where('su.id_supervision', $id_zona_z);
    // }
    // if($id_ciclo_z>0){
    //   $this->db->where('ci.id_ciclo', $id_ciclo_z);
    // }
    // $this->db->where('ni.id_nivel <',8);
    // $this->db->group_by("ni.nivel");

    // $query1 = $this->db->get_compiled_select();
    $filtro = "";
    $filtro_nivel_sos = "";
    if($sostenimiento=="PRIVADO"){
        $filtro_nivel_sos .= " AND sostenimiento IN ('61','41','92','96')";
    }else if($sostenimiento=="AUTONOMO"){
        $filtro_nivel_sos .= " AND sostenimiento IN  ('51')";
    }else if($sostenimiento== "PUBLICO"){
        $filtro_nivel_sos .= " AND sostenimiento NOT IN('61','41','92','96','51')";
    }

    if($nivel=="PREESCOLAR"){
        $filtro .= " AND IF(escuelas.desc_servicio LIKE '%PREESCOLAR%' AND supervisiones.tipo='FZP',TRUE,FALSE)";
        $filtro_nivel_sos .= " AND desc_nivel_educativo LIKE '%PREESCOLAR%' ";
    }else if($nivel=="PRIMARIA"){
        $filtro .= " AND IF(escuelas.desc_servicio LIKE '%PRIMARIA%' AND supervisiones.tipo='FIZ',TRUE,FALSE)";
        $filtro_nivel_sos .= " AND desc_nivel_educativo LIKE '%PRIMARIA%'";
    }else if($nivel=="SECUNDARIA"){
        $filtro .= "AND 
            IF( (escuelas.desc_servicio='SECUNDARIA GENERAL' OR escuelas.desc_servicio='SECUNDARIA COMUNITARIA'
                OR (escuelas.desc_servicio='SECUNDARIA TECNICA INDUSTRIAL' AND escuelas.desc_sostenimiento='ESTATAL') 
                OR (escuelas.desc_servicio='SECUNDARIA TECNICA INDUSTRIAL' AND escuelas.desc_sostenimiento='PARTICULAR') ) 
                AND supervisiones.tipo='FIS',TRUE,
            IF( ((escuelas.desc_servicio='SECUNDARIA TECNICA INDUSTRIAL' AND escuelas.desc_sostenimiento='FEDERAL TRANSFERIDO')
                OR (escuelas.desc_servicio='SECUNDARIA TECNICA AGROPECUARIA' AND escuelas.desc_sostenimiento='FEDERAL TRANSFERIDO')) AND supervisiones.tipo='FZT',TRUE,
            IF(escuelas.desc_servicio='TELESECUNDARIA' AND supervisiones.tipo='FTV', TRUE, FALSE ) ) )";
        $filtro_nivel_sos .= " AND desc_nivel_educativo LIKE '%SECUNDARIA%'";
    }

    $filtro_zona = "";
    if($id_zona_z!=''){
        $filtro_zona .= " AND supervisiones.cct = '{$id_zona_z}'";
    }

    $filtro_ciclo = "";
    if($id_ciclo_z>0){
        $filtro_ciclo .= " AND est.id_ciclo = {$id_ciclo_z} ";
    }

    $query1=" SELECT
                CASE  
                    WHEN escuelas.nivel LIKE '%ESPECIAL%' THEN '1'
                    WHEN escuelas.nivel LIKE '%INICIAL%' THEN '2'
                    WHEN escuelas.nivel LIKE '%PREESCOLAR%' THEN '3'
                    WHEN escuelas.nivel LIKE '%PRIMARIA%' THEN '4'
                    WHEN escuelas.nivel LIKE '%SECUNDARIA%' THEN '5'
                    WHEN escuelas.nivel LIKE '%MEDIA SUPERIOR%' THEN '6'
                    WHEN escuelas.nivel LIKE '%SUPERIOR%' THEN '7'
                END AS id_nivel,escuelas.nivel,'0' AS id_sostenimiento,'total' AS sostenimiento,
                '0' AS id_modalidad, 'total' AS modalidad,
                SUM(est.alumn_m_t) AS alumn_m_t, SUM(est.alumn_h_t) AS alumn_h_t, 
                SUM(est.alumn_t_t) AS alumn_t_t,
                SUM(est.alumn_t_1) AS alumn_t_1, SUM(est.alumn_t_2) AS alumn_t_2, 
                SUM(est.alumn_t_3) AS alumn_t_3,
                SUM(est.alumn_t_4) AS alumn_t_4, SUM(est.alumn_t_5) AS alumn_t_5, 
                SUM(est.alumn_t_6) AS alumn_t_6
            FROM (SELECT cct, turno, sostenimiento,zona_escolar,desc_nivel_educativo,
                    desc_servicio, desc_sostenimiento,nivel_educativo,
                    CASE 
                      WHEN desc_nivel_educativo LIKE '%CAM%' THEN 'ESPECIAL'
                      WHEN desc_nivel_educativo LIKE '%INICIAL%' THEN 'INICIAL'
                      WHEN desc_nivel_educativo LIKE '%PREESCOLAR%' THEN 'PREESCOLAR'
                      WHEN desc_nivel_educativo LIKE '%PRIMARIA%' THEN 'PRIMARIA'
                      WHEN desc_nivel_educativo LIKE '%SECUNDARIA%' THEN 'SECUNDARIA'
                      WHEN desc_nivel_educativo LIKE '%MEDIA SUPERIOR%' THEN 'MEDIA SUPERIOR'
                      WHEN desc_nivel_educativo LIKE '%SUPERIOR%' THEN 'SUPERIOR'
                    END AS nivel
                    FROM vista_cct 
                    WHERE (`status` = 1 OR `status` = 4) AND tipo_centro = 9 
                    {$filtro_nivel_sos}
                ) AS escuelas
            INNER JOIN estadistica_e_indicadores_xcct AS est ON est.cct=escuelas.cct 
                        {$filtro_ciclo} 
            INNER JOIN (SELECT cct, zona_escolar, sostenimiento, desc_nivel_educativo, 
                        SUBSTRING(cct, 3, 3) AS tipo
                        FROM vista_cct cct
                        WHERE (`status` = 1 OR `status` = 4) AND tipo_centro = 1) AS supervisiones 
                        ON escuelas.zona_escolar = supervisiones.zona_escolar
                        AND escuelas.sostenimiento = supervisiones.sostenimiento
            {$filtro} {$filtro_zona}
            GROUP BY CASE   
                WHEN escuelas.desc_nivel_educativo LIKE '%CAM%' THEN 'ESPECIAL'
                WHEN escuelas.desc_nivel_educativo LIKE '%INICIAL%' THEN 'INICIAL'
                WHEN escuelas.desc_nivel_educativo LIKE '%PREESCOLAR%' THEN 'PREESCOLAR'
                WHEN escuelas.desc_nivel_educativo LIKE '%PRIMARIA%' THEN 'PRIMARIA'
                WHEN escuelas.desc_nivel_educativo LIKE '%SECUNDARIA%' THEN 'SECUNDARIA'
                WHEN escuelas.desc_nivel_educativo LIKE '%MEDIA SUPERIOR%' THEN 'MEDIA SUPERIOR'
                WHEN escuelas.desc_nivel_educativo LIKE '%SUPERIOR%' THEN 'SUPERIOR'
                END ";


    // $this->db->select('ni.id_nivel,ni.nivel, sso.id_subsostenimiento, sso.subsostenimiento, "0" as id_modalidad, "total" as modalidad,
    // SUM(est.alumn_m_t) as alumn_m_t, SUM(est.alumn_h_t) as alumn_h_t, SUM(est.alumn_t_t) as alumn_t_t,
    // SUM(est.alumn_t_1) as alumn_t_1, SUM(est.alumn_t_2) as alumn_t_2, SUM(est.alumn_t_3) as alumn_t_3,
    // SUM(est.alumn_t_4) as alumn_t_4, SUM(est.alumn_t_5) as alumn_t_5, SUM(est.alumn_t_6) as alumn_t_6');
    // $this->db->from('escuela as es');
    // $this->db->join('estadistica_e_indicadores_xcct as est', 'es.id_cct = est.id_cct');
    // $this->db->join('municipio as mu', 'es.id_municipio = mu.id_municipio');
    // $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
    // $this->db->join('modalidad as mo', 'es.id_modalidad = mo.id_modalidad');
    // $this->db->join('subsostenimiento as sso', 'es.id_subsostenimiento = sso.id_subsostenimiento');
    // $this->db->join('sostenimiento as so', 'sso.id_sostenimiento = so.id_sostenimiento');
    // $this->db->join('supervision as su', '`es`.`id_supervision` = `su`.`id_supervision`');
    // $this->db->join('ciclo as ci', 'est.id_ciclo = ci.id_ciclo');
    // if($id_nivel_z>0){
    //   $this->db->where('ni.id_nivel', $id_nivel_z);
    // }
    // if($id_sostenimiento_z>0){
    //   $this->db->where('sso.id_subsostenimiento', $id_sostenimiento_z);
    // }
    // if($id_zona_z>0){
    //   $this->db->where('su.id_supervision', $id_zona_z);
    // }
    // if($id_ciclo_z>0){
    //   $this->db->where('ci.id_ciclo', $id_ciclo_z);
    // }
    // $this->db->where('ni.id_nivel <', 8);
    // $this->db->group_by("ni.nivel");
    // $this->db->group_by("sso.subsostenimiento");

    // $query2 = $this->db->get_compiled_select();

    $query2 = " SELECT
                CASE  
                    WHEN escuelas.nivel LIKE '%ESPECIAL%' THEN '1'
                    WHEN escuelas.nivel LIKE '%INICIAL%' THEN '2'
                    WHEN escuelas.nivel LIKE '%PREESCOLAR%' THEN '3'
                    WHEN escuelas.nivel LIKE '%PRIMARIA%' THEN '4'
                    WHEN escuelas.nivel LIKE '%SECUNDARIA%' THEN '5'
                    WHEN escuelas.nivel LIKE '%MEDIA SUPERIOR%' THEN '6'
                    WHEN escuelas.nivel LIKE '%SUPERIOR%' THEN '7'
                END AS id_nivel,escuelas.nivel
                ,escuelas.id_sostenimiento, escuelas.sostenimiento2 as sostenimiento, '0' AS id_modalidad, 'total' AS modalidad,
                SUM(est.alumn_m_t) AS alumn_m_t, 
                SUM(est.alumn_h_t) AS alumn_h_t, 
                SUM(est.alumn_t_t) AS alumn_t_t,
                SUM(est.alumn_t_1) AS alumn_t_1, 
                SUM(est.alumn_t_2) AS alumn_t_2, 
                SUM(est.alumn_t_3) AS alumn_t_3,
                SUM(est.alumn_t_4) AS alumn_t_4, 
                SUM(est.alumn_t_5) AS alumn_t_5, 
                SUM(est.alumn_t_6) AS alumn_t_6
                FROM (SELECT cct, turno, zona_escolar, desc_nivel_educativo, desc_servicio, 
                        desc_sostenimiento,nivel_educativo,
                    CASE 
                       WHEN desc_nivel_educativo LIKE '%CAM%' THEN 'ESPECIAL'
                       WHEN desc_nivel_educativo LIKE '%INICIAL%' THEN 'INICIAL'
                       WHEN desc_nivel_educativo LIKE '%PREESCOLAR%' THEN 'PREESCOLAR'
                       WHEN desc_nivel_educativo LIKE '%PRIMARIA%' THEN 'PRIMARIA'
                       WHEN desc_nivel_educativo LIKE '%SECUNDARIA%' THEN 'SECUNDARIA'
                       WHEN desc_nivel_educativo LIKE '%MEDIA SUPERIOR%' THEN 'MEDIA SUPERIOR'
                       WHEN desc_nivel_educativo LIKE '%SUPERIOR%' THEN 'SUPERIOR'
                    END AS nivel,
                    (SELECT CASE  
                        WHEN sostenimiento IN  ('51') THEN '3'
                        WHEN sostenimiento IN ('61','41','92','96') THEN '2'
                        ELSE '1'
                    END) AS id_sostenimiento,
                    (SELECT CASE  
                        WHEN sostenimiento IN  ('51') THEN 'AUTONOMO'
                        WHEN sostenimiento IN ('61','41','92','96') THEN 'PRIVADO'
                        ELSE 'PUBLICO'
                    END) AS sostenimiento2,sostenimiento
                    FROM vista_cct 
                    WHERE (`status` = 1 OR `status` = 4) AND tipo_centro = 9  
                    {$filtro_nivel_sos}
                ) AS escuelas
                INNER JOIN estadistica_e_indicadores_xcct AS est ON est.cct=escuelas.cct
                {$filtro_ciclo}
                INNER JOIN (SELECT cct, zona_escolar, sostenimiento, desc_nivel_educativo, 
                                SUBSTRING(cct, 3, 3) AS tipo
                            FROM vista_cct cct
                            WHERE (`status` = 1 OR `status` = 4) AND tipo_centro = 1
                            ) AS supervisiones ON escuelas.zona_escolar = supervisiones.zona_escolar
                            AND escuelas.sostenimiento = supervisiones.sostenimiento
                {$filtro} {$filtro_zona}
                GROUP BY (CASE   
                            WHEN escuelas.desc_nivel_educativo LIKE '%CAM%' THEN 'ESPECIAL'
                            WHEN escuelas.desc_nivel_educativo LIKE '%INICIAL%' THEN 'INICIAL'
                            WHEN escuelas.desc_nivel_educativo LIKE '%PREESCOLAR%' THEN 'PREESCOLAR'
                            WHEN escuelas.desc_nivel_educativo LIKE '%PRIMARIA%' THEN 'PRIMARIA'
                            WHEN escuelas.desc_nivel_educativo LIKE '%SECUNDARIA%' THEN 'SECUNDARIA'
                            WHEN escuelas.desc_nivel_educativo LIKE '%MEDIA SUPERIOR%' THEN 'MEDIA SUPERIOR'
                            WHEN escuelas.desc_nivel_educativo LIKE '%SUPERIOR%' THEN 'SUPERIOR'
                        END), 
                        (CASE  
                            WHEN escuelas.sostenimiento IN  ('51') THEN 'AUTONOMO'
                            WHEN escuelas.sostenimiento IN ('61','41','92','96') THEN 'PRIVADO'
                            ELSE 'PUBLICO'
                        END) 
                        ";

    // $this->db->select('ni.id_nivel,ni.nivel, sso.id_subsostenimiento, sso.subsostenimiento, mo.id_modalidad, mo.modalidad,
    // SUM(est.alumn_m_t) as alumn_m_t, SUM(est.alumn_h_t) as alumn_h_t, SUM(est.alumn_t_t) as alumn_t_t,
    // SUM(est.alumn_t_1) as alumn_t_1, SUM(est.alumn_t_2) as alumn_t_2, SUM(est.alumn_t_3) as alumn_t_3,
    // SUM(est.alumn_t_4) as alumn_t_4, SUM(est.alumn_t_5) as alumn_t_5, SUM(est.alumn_t_6) as alumn_t_6');
    // $this->db->from('escuela as es');
    // $this->db->join('estadistica_e_indicadores_xcct as est', 'es.id_cct = est.id_cct');
    // $this->db->join('municipio as mu', 'es.id_municipio = mu.id_municipio');
    // $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
    // $this->db->join('modalidad as mo', 'es.id_modalidad = mo.id_modalidad');
    // $this->db->join('subsostenimiento as sso', 'es.id_subsostenimiento = sso.id_subsostenimiento');
    // $this->db->join('sostenimiento as so', 'sso.id_sostenimiento = so.id_sostenimiento');
    // $this->db->join('supervision as su', '`es`.`id_supervision` = `su`.`id_supervision`');
    // $this->db->join('ciclo as ci', 'est.id_ciclo = ci.id_ciclo');
    // if($id_nivel_z>0){
    //   $this->db->where('ni.id_nivel', $id_nivel_z);
    // }
    // if($id_sostenimiento_z>0){
    //   $this->db->where('sso.id_subsostenimiento', $id_sostenimiento_z);
    // }
    // if($id_zona_z>0){
    //   $this->db->where('su.id_supervision', $id_zona_z);
    // }
    // if($id_ciclo_z>0){
    //   $this->db->where('ci.id_ciclo', $id_ciclo_z);
    // }
    // $this->db->where('ni.id_nivel <', 8);
    // $this->db->group_by("ni.nivel");
    // $this->db->group_by("sso.subsostenimiento");
    // $this->db->group_by("mo.modalidad");

    // $this->db->order_by("id_nivel");
    // $this->db->order_by("subsostenimiento", "DESC");
    // $this->db->order_by("id_modalidad", "ASC");

    // $query3 = $this->db->get_compiled_select();

    // $this->db->query($query1 . ' UNION ALL ' . $query2. ' UNION ALL ' . $query3)->result_array();
    // $str = $this->db->last_query();
    // echo $str; die();
        $query3 = "SELECT CASE  
                    WHEN escuelas.nivel LIKE '%ESPECIAL%' THEN '1'
                    WHEN escuelas.nivel LIKE '%INICIAL%' THEN '2'
                    WHEN escuelas.nivel LIKE '%PREESCOLAR%' THEN '3'
                    WHEN escuelas.nivel LIKE '%PRIMARIA%' THEN '4'
                    WHEN escuelas.nivel LIKE '%SECUNDARIA%' THEN '5'
                    WHEN escuelas.nivel LIKE '%MEDIA SUPERIOR%' THEN '6'
                    WHEN escuelas.nivel LIKE '%SUPERIOR%' THEN '7'
                END AS id_nivel,escuelas.nivel
                ,escuelas.id_sostenimiento, escuelas.sostenimiento2 as sostenimiento, escuelas.servicio AS id_modalidad,
                escuelas.desc_servicio AS modalidad,
                SUM(est.alumn_m_t) AS alumn_m_t, 
                SUM(est.alumn_h_t) AS alumn_h_t, 
                SUM(est.alumn_t_t) AS alumn_t_t,
                SUM(est.alumn_t_1) AS alumn_t_1, 
                SUM(est.alumn_t_2) AS alumn_t_2, 
                SUM(est.alumn_t_3) AS alumn_t_3,
                SUM(est.alumn_t_4) AS alumn_t_4, 
                SUM(est.alumn_t_5) AS alumn_t_5, 
                SUM(est.alumn_t_6) AS alumn_t_6
                FROM (SELECT cct, turno, zona_escolar, desc_nivel_educativo, servicio,desc_servicio, 
                        desc_sostenimiento,nivel_educativo,
                    CASE 
                       WHEN desc_nivel_educativo LIKE '%CAM%' THEN 'ESPECIAL'
                       WHEN desc_nivel_educativo LIKE '%INICIAL%' THEN 'INICIAL'
                       WHEN desc_nivel_educativo LIKE '%PREESCOLAR%' THEN 'PREESCOLAR'
                       WHEN desc_nivel_educativo LIKE '%PRIMARIA%' THEN 'PRIMARIA'
                       WHEN desc_nivel_educativo LIKE '%SECUNDARIA%' THEN 'SECUNDARIA'
                       WHEN desc_nivel_educativo LIKE '%MEDIA SUPERIOR%' THEN 'MEDIA SUPERIOR'
                       WHEN desc_nivel_educativo LIKE '%SUPERIOR%' THEN 'SUPERIOR'
                    END AS nivel,
                    (SELECT CASE  
                        WHEN sostenimiento IN  ('51') THEN '3'
                        WHEN sostenimiento IN ('61','41','92','96') THEN '2'
                        ELSE '1'
                    END) AS id_sostenimiento,
                    (SELECT CASE  
                        WHEN sostenimiento IN  ('51') THEN 'AUTONOMO'
                        WHEN sostenimiento IN ('61','41','92','96') THEN 'PRIVADO'
                        ELSE 'PUBLICO'
                    END) AS sostenimiento2,sostenimiento
                    FROM vista_cct 
                    WHERE (`status` = 1 OR `status` = 4) AND tipo_centro = 9  
                    {$filtro_nivel_sos}
                ) AS escuelas
                INNER JOIN estadistica_e_indicadores_xcct AS est ON est.cct=escuelas.cct
                {$filtro_ciclo}
                INNER JOIN (SELECT cct, zona_escolar, sostenimiento, desc_nivel_educativo, 
                                SUBSTRING(cct, 3, 3) AS tipo
                            FROM vista_cct cct
                            WHERE (`status` = 1 OR `status` = 4) AND tipo_centro = 1
                            ) AS supervisiones ON escuelas.zona_escolar = supervisiones.zona_escolar
                            AND escuelas.sostenimiento = supervisiones.sostenimiento
                {$filtro} {$filtro_zona}
                GROUP BY (CASE   
                            WHEN escuelas.desc_nivel_educativo LIKE '%CAM%' THEN 'ESPECIAL'
                            WHEN escuelas.desc_nivel_educativo LIKE '%INICIAL%' THEN 'INICIAL'
                            WHEN escuelas.desc_nivel_educativo LIKE '%PREESCOLAR%' THEN 'PREESCOLAR'
                            WHEN escuelas.desc_nivel_educativo LIKE '%PRIMARIA%' THEN 'PRIMARIA'
                            WHEN escuelas.desc_nivel_educativo LIKE '%SECUNDARIA%' THEN 'SECUNDARIA'
                            WHEN escuelas.desc_nivel_educativo LIKE '%MEDIA SUPERIOR%' THEN 'MEDIA SUPERIOR'
                            WHEN escuelas.desc_nivel_educativo LIKE '%SUPERIOR%' THEN 'SUPERIOR'
                        END), 
                        (CASE  
                            WHEN escuelas.sostenimiento IN  ('51') THEN 'AUTONOMO'
                            WHEN escuelas.sostenimiento IN ('61','41','92','96') THEN 'PRIVADO'
                            ELSE 'PUBLICO'
                        END), escuelas.desc_servicio
                ORDER BY FIELD(nivel,'ESPECIAL','INICIAL','PREESCOLAR','PRIMARIA','SECUNDARIA','MEDIA SUPERIOR','SUPERIOR')
                ,id_sostenimiento,id_modalidad ";
    // echo $query1 . ' UNION ALL ' . $query2. ' UNION ALL ' . $query3;
    // die();

    return $this->db->query($query1 . ' UNION ALL ' . $query2. ' UNION ALL ' . $query3)->result_array();

  }// get_nalumnos_xzona()

  function get_pdocente_xmunciclo($id_municipio, $id_ciclo){

//     $this->db->select('ni.id_nivel,ni.nivel, "0" as id_sostenimiento, "total" as sostenimiento, "0" as id_modalidad, "total" as modalidad,
//     IF(ni.id_nivel=5, (SUM(est.docente_m)
// +SUM(est.docente_m_ef)
// +SUM(est.docente_m_artis)
// +SUM(est.docente_m_tecnolo)
// +SUM(est.docente_m_idiomas)) ,SUM(est.docente_m)) AS docente_m,
// 	IF(ni.id_nivel=5, (SUM(est.docente_h)
// +SUM(est.docente_h_ef)
// +SUM(est.docente_h_artis)
// +SUM(est.docente_h_tecnolo)
// +SUM(est.docente_h_idiomas)) ,SUM(est.docente_h)) AS docente_h,
// 	IF(ni.id_nivel=5, (SUM(est.docentes_t_g)
// +SUM(est.docente_h_ef)
// +SUM(est.docente_m_ef)
// +SUM(est.docente_h_artis)
// +SUM(est.docente_m_artis)
// +SUM(est.docente_h_tecnolo)
// +SUM(est.docente_m_tecnolo)
// +SUM(est.docente_h_idiomas)
// +SUM(est.docente_m_idiomas)) ,SUM(est.docentes_t_g)) AS docentes_t_g,
//     SUM(est.directivo_m_congrup) as directivo_m_congrup, SUM(est.directivo_h_congrup) as directivo_h_congrup, SUM(est.directivo_m_congrup)+SUM(est.directivo_h_congrup) as directivo_t_congrup,
//     SUM(est.directivo_m_singrup) as directivo_m_singrup, SUM(est.directivo_h_singrup) as directivo_h_singrup, SUM(est.directivo_m_singrup)+SUM(est.directivo_h_singrup) as directivo_t_singrup');
//     $this->db->from('escuela as es');
//     $this->db->join('estadistica_e_indicadores_xcct as est', 'es.id_cct = est.id_cct');
//     $this->db->join('municipio as mu', 'es.id_municipio = mu.id_municipio');
//     $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
//     $this->db->join('ciclo as ci', 'est.id_ciclo = ci.id_ciclo');
    $filtro="";
    if($id_municipio>0){
        $filtro.=" AND v.municipio = {$id_municipio}";
    }
    if($id_ciclo>0){
        $filtro.=" AND est.id_ciclo = {$id_ciclo}";
    }
    // $this->db->where('ni.id_nivel <',8);
    // $this->db->group_by("ni.id_nivel");

    // $query1 = $this->db->get_compiled_select();

    $query1 = "SELECT 
                CASE  
                    WHEN a.nivel LIKE '%ESPECIAL%' THEN '1'
                    WHEN a.nivel LIKE '%INICIAL%' THEN '2'
                    WHEN a.nivel LIKE '%PREESCOLAR%' THEN '3'
                    WHEN a.nivel LIKE '%PRIMARIA%' THEN '4'
                    WHEN a.nivel LIKE '%SECUNDARIA%' THEN '5'
                    WHEN a.nivel LIKE '%MEDIA SUPERIOR%' THEN '6'
                    WHEN a.nivel LIKE '%SUPERIOR%' THEN '7'
                END AS id_nivel,a.nivel,id_sostenimiento,sostenimiento
                ,id_modalidad,modalidad,docente_m,docente_h,docentes_t_g,
                directivo_m_congrup,directivo_h_congrup,directivo_t_congrup,
                directivo_m_singrup,directivo_h_singrup,directivo_t_singrup 
               FROM (
                SELECT v.nivel_educativo,
                CASE  
                    WHEN v.desc_nivel_educativo LIKE '%CAM%' THEN 'ESPECIAL'
                    WHEN v.desc_nivel_educativo LIKE '%INICIAL%' THEN 'INICIAL'
                    WHEN v.desc_nivel_educativo LIKE '%PREESCOLAR%' THEN 'PREESCOLAR'
                    WHEN v.desc_nivel_educativo LIKE '%PRIMARIA%' THEN 'PRIMARIA'
                    WHEN v.desc_nivel_educativo LIKE '%SECUNDARIA%' THEN 'SECUNDARIA'
                    WHEN v.desc_nivel_educativo LIKE '%MEDIA SUPERIOR%' THEN 'MEDIA SUPERIOR'
                    WHEN v.desc_nivel_educativo LIKE '%SUPERIOR%' THEN 'SUPERIOR'
                END AS nivel,'0' AS id_sostenimiento,
                'total' AS sostenimiento, '0' AS id_modalidad, 'total' AS modalidad,
                IF(v.desc_nivel_educativo LIKE '%SECUNDARIA%', (SUM(est.docente_m)+SUM(est.docente_m_ef)
                    +SUM(est.docente_m_artis)
                    +SUM(est.docente_m_tecnolo)
                    +SUM(est.docente_m_idiomas)) ,SUM(est.docente_m)) AS docente_m,
                IF(v.desc_nivel_educativo LIKE '%SECUNDARIA%', (SUM(est.docente_h)
                    +SUM(est.docente_h_ef)
                    +SUM(est.docente_h_artis)
                    +SUM(est.docente_h_tecnolo)
                    +SUM(est.docente_h_idiomas)) ,SUM(est.docente_h)) AS docente_h,
                IF(v.desc_nivel_educativo LIKE '%SECUNDARIA%', (SUM(est.docentes_t_g)
                    +SUM(est.docente_h_ef)
                    +SUM(est.docente_m_ef)
                    +SUM(est.docente_h_artis)
                    +SUM(est.docente_m_artis)
                    +SUM(est.docente_h_tecnolo)
                    +SUM(est.docente_m_tecnolo)
                    +SUM(est.docente_h_idiomas)
                    +SUM(est.docente_m_idiomas)) ,
                    SUM(est.docentes_t_g)) AS docentes_t_g,
                    SUM(est.directivo_m_congrup) AS directivo_m_congrup, 
                    SUM(est.directivo_h_congrup) AS directivo_h_congrup, 
                    SUM(est.directivo_m_congrup)+SUM(est.directivo_h_congrup) AS directivo_t_congrup,
                    SUM(est.directivo_m_singrup) AS directivo_m_singrup,
                    SUM(est.directivo_h_singrup) AS directivo_h_singrup, 
                    SUM(est.directivo_m_singrup)+SUM(est.directivo_h_singrup) AS directivo_t_singrup
                FROM vista_cct v
                INNER JOIN estadistica_e_indicadores_xcct est ON est.cct=v.cct
                WHERE (v.status= 1 OR v.status = 4) AND v.tipo_centro=9 
                AND v.desc_nivel_educativo NOT IN('FORMACION PARA EL TRABAJO','OTRO NIVEL EDUCATIVO','NO APLICA')
                {$filtro}            
                GROUP BY CASE  
                  WHEN v.desc_nivel_educativo LIKE '%CAM%' THEN 'ESPECIAL'
                  WHEN v.desc_nivel_educativo LIKE '%INICIAL%' THEN 'INICIAL'
                  WHEN v.desc_nivel_educativo LIKE '%PREESCOLAR%' THEN 'PREESCOLAR'
                  WHEN v.desc_nivel_educativo LIKE '%PRIMARIA%' THEN 'PRIMARIA'
                  WHEN v.desc_nivel_educativo LIKE '%SECUNDARIA%' THEN 'SECUNDARIA'
                  WHEN v.desc_nivel_educativo LIKE '%MEDIA SUPERIOR%' THEN 'MEDIA SUPERIOR'
                  WHEN v.desc_nivel_educativo LIKE '%SUPERIOR%' THEN 'SUPERIOR'
                  END
                  ) AS a";

//     $this->db->select('ni.id_nivel,ni.nivel, so.id_sostenimiento, so.sostenimiento, "0" as id_modalidad, "total" as modalidad,
//     IF(ni.id_nivel=5, (SUM(est.docente_m)
// +SUM(est.docente_m_ef)
// +SUM(est.docente_m_artis)
// +SUM(est.docente_m_tecnolo)
// +SUM(est.docente_m_idiomas)) ,SUM(est.docente_m)) AS docente_m,
// 	IF(ni.id_nivel=5, (SUM(est.docente_h)
// +SUM(est.docente_h_ef)
// +SUM(est.docente_h_artis)
// +SUM(est.docente_h_tecnolo)
// +SUM(est.docente_h_idiomas)) ,SUM(est.docente_h)) AS docente_h,
// 	IF(ni.id_nivel=5, (SUM(est.docentes_t_g)
// +SUM(est.docente_h_ef)
// +SUM(est.docente_m_ef)
// +SUM(est.docente_h_artis)
// +SUM(est.docente_m_artis)
// +SUM(est.docente_h_tecnolo)
// +SUM(est.docente_m_tecnolo)
// +SUM(est.docente_h_idiomas)
// +SUM(est.docente_m_idiomas)) ,SUM(est.docentes_t_g)) AS docentes_t_g,
// SUM(est.directivo_m_congrup) as directivo_m_congrup, SUM(est.directivo_h_congrup) as directivo_h_congrup, SUM(est.directivo_m_congrup)+SUM(est.directivo_h_congrup) as directivo_t_congrup,
// SUM(est.directivo_m_singrup) as directivo_m_singrup, SUM(est.directivo_h_singrup) as directivo_h_singrup, SUM(est.directivo_m_singrup)+SUM(est.directivo_h_singrup) as directivo_t_singrup');
//     $this->db->from('escuela as es');
//     $this->db->join('estadistica_e_indicadores_xcct as est', 'es.id_cct = est.id_cct');
//     $this->db->join('municipio as mu', 'es.id_municipio = mu.id_municipio');
//     $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
//     $this->db->join('modalidad as mo', 'es.id_modalidad = mo.id_modalidad');
//     $this->db->join('subsostenimiento as sso', 'es.id_subsostenimiento = sso.id_subsostenimiento');
//     $this->db->join('sostenimiento as so', 'sso.id_sostenimiento = so.id_sostenimiento');
//     $this->db->join('ciclo as ci', 'est.id_ciclo = ci.id_ciclo');
//     if($id_municipio>0){
//       $this->db->where('mu.id_municipio', $id_municipio);
//     }
//     if($id_ciclo>0){
//       $this->db->where('ci.id_ciclo', $id_ciclo);
//     }
//     $this->db->where('ni.id_nivel <',8);
//     $this->db->group_by("ni.nivel");
//     $this->db->group_by("so.sostenimiento");

//     $query2 = $this->db->get_compiled_select();

    $query2="SELECT 
                CASE  
                    WHEN a.nivel LIKE '%ESPECIAL%' THEN '1'
                    WHEN a.nivel LIKE '%INICIAL%' THEN '2'
                    WHEN a.nivel LIKE '%PREESCOLAR%' THEN '3'
                    WHEN a.nivel LIKE '%PRIMARIA%' THEN '4'
                    WHEN a.nivel LIKE '%SECUNDARIA%' THEN '5'
                    WHEN a.nivel LIKE '%MEDIA SUPERIOR%' THEN '6'
                    WHEN a.nivel LIKE '%SUPERIOR%' THEN '7'
                END AS id_nivel,a.nivel,id_sostenimiento,sostenimiento
                ,id_modalidad,modalidad,docente_m,docente_h,docentes_t_g,
                directivo_m_congrup,directivo_h_congrup,directivo_t_congrup,
                directivo_m_singrup,directivo_h_singrup,directivo_t_singrup
               FROM (
                SELECT v.nivel_educativo,
                    CASE  
                        WHEN v.desc_nivel_educativo LIKE '%CAM%' THEN 'ESPECIAL'
                        WHEN v.desc_nivel_educativo LIKE '%INICIAL%' THEN 'INICIAL'
                        WHEN v.desc_nivel_educativo LIKE '%PREESCOLAR%' THEN 'PREESCOLAR'
                        WHEN v.desc_nivel_educativo LIKE '%PRIMARIA%' THEN 'PRIMARIA'
                        WHEN v.desc_nivel_educativo LIKE '%SECUNDARIA%' THEN 'SECUNDARIA'
                        WHEN v.desc_nivel_educativo LIKE '%MEDIA SUPERIOR%' THEN 'MEDIA SUPERIOR'
                        WHEN v.desc_nivel_educativo LIKE '%SUPERIOR%' THEN 'SUPERIOR'
                    END AS nivel,
                    (SELECT CASE  
                        WHEN v.sostenimiento IN  ('51') THEN '3' 
                        WHEN v.sostenimiento IN ('61','41','92','96') THEN '2'
                        ELSE '1'
                    END) AS id_sostenimiento,
                    (SELECT CASE  
                        WHEN v.sostenimiento IN  ('51') THEN 'AUTONOMO' 
                        WHEN v.sostenimiento IN ('61','41','92','96') THEN 'PRIVADO'
                        ELSE 'PUBLICO'
                    END) AS sostenimiento, 
                    '0' AS id_modalidad, 'total' AS modalidad,
                    IF(v.desc_nivel_educativo LIKE '%SECUNDARIA%', (SUM(est.docente_m)+SUM(est.docente_m_ef)+SUM(est.docente_m_artis)
                        +SUM(est.docente_m_tecnolo)
                        +SUM(est.docente_m_idiomas)) ,SUM(est.docente_m)) AS docente_m,
                    IF(v.desc_nivel_educativo LIKE '%SECUNDARIA%', (SUM(est.docente_h)+SUM(est.docente_h_ef)
                        +SUM(est.docente_h_artis)
                        +SUM(est.docente_h_tecnolo)
                        +SUM(est.docente_h_idiomas)) ,SUM(est.docente_h)) AS docente_h,
                    IF(v.desc_nivel_educativo LIKE '%SECUNDARIA%', (SUM(est.docentes_t_g)+SUM(est.docente_h_ef)
                        +SUM(est.docente_m_ef)
                        +SUM(est.docente_h_artis)
                        +SUM(est.docente_m_artis)
                        +SUM(est.docente_h_tecnolo)
                        +SUM(est.docente_m_tecnolo)
                        +SUM(est.docente_h_idiomas)
                        +SUM(est.docente_m_idiomas)) ,
                    SUM(est.docentes_t_g)) AS docentes_t_g,
                    SUM(est.directivo_m_congrup) AS directivo_m_congrup, 
                    SUM(est.directivo_h_congrup) AS directivo_h_congrup, 
                    SUM(est.directivo_m_congrup)+SUM(est.directivo_h_congrup) AS directivo_t_congrup,
                    SUM(est.directivo_m_singrup) AS directivo_m_singrup, 
                    SUM(est.directivo_h_singrup) AS directivo_h_singrup, 
                    SUM(est.directivo_m_singrup)+SUM(est.directivo_h_singrup) AS directivo_t_singrup
                FROM vista_cct v
                INNER JOIN estadistica_e_indicadores_xcct est ON est.cct=v.cct
                WHERE (v.status= 1 OR v.status = 4) AND v.tipo_centro=9 
                AND v.desc_nivel_educativo NOT IN('FORMACION PARA EL TRABAJO','OTRO NIVEL EDUCATIVO','NO APLICA')
                {$filtro}         
                GROUP BY (CASE  
                              WHEN v.desc_nivel_educativo LIKE '%CAM%' THEN 'ESPECIAL'
                              WHEN v.desc_nivel_educativo LIKE '%INICIAL%' THEN 'INICIAL'
                              WHEN v.desc_nivel_educativo LIKE '%PREESCOLAR%' THEN 'PREESCOLAR'
                              WHEN v.desc_nivel_educativo LIKE '%PRIMARIA%' THEN 'PRIMARIA'
                              WHEN v.desc_nivel_educativo LIKE '%SECUNDARIA%' THEN 'SECUNDARIA'
                              WHEN v.desc_nivel_educativo LIKE '%MEDIA SUPERIOR%' THEN 'MEDIA SUPERIOR'
                              WHEN v.desc_nivel_educativo LIKE '%SUPERIOR%' THEN 'SUPERIOR'
                        END),
                    (CASE  
                        WHEN v.sostenimiento IN  ('51') THEN 'AUTONOMO' 
                        WHEN v.sostenimiento IN ('61','41','92','96') THEN 'PRIVADO'
                        ELSE 'PUBLICO'
                    END)
                  ) AS a";


//     $this->db->select('ni.id_nivel,ni.nivel, so.id_sostenimiento, so.sostenimiento, mo.id_modalidad, mo.modalidad,
//     IF(ni.id_nivel=5, (SUM(est.docente_m)
// +SUM(est.docente_m_ef)
// +SUM(est.docente_m_artis)
// +SUM(est.docente_m_tecnolo)
// +SUM(est.docente_m_idiomas)) ,SUM(est.docente_m)) AS docente_m,
// 	IF(ni.id_nivel=5, (SUM(est.docente_h)
// +SUM(est.docente_h_ef)
// +SUM(est.docente_h_artis)
// +SUM(est.docente_h_tecnolo)
// +SUM(est.docente_h_idiomas)) ,SUM(est.docente_h)) AS docente_h,
// 	IF(ni.id_nivel=5, (SUM(est.docentes_t_g)
// +SUM(est.docente_h_ef)
// +SUM(est.docente_m_ef)
// +SUM(est.docente_h_artis)
// +SUM(est.docente_m_artis)
// +SUM(est.docente_h_tecnolo)
// +SUM(est.docente_m_tecnolo)
// +SUM(est.docente_h_idiomas)
// +SUM(est.docente_m_idiomas)) ,SUM(est.docentes_t_g)) AS docentes_t_g,
// SUM(est.directivo_m_congrup) as directivo_m_congrup, SUM(est.directivo_h_congrup) as directivo_h_congrup, SUM(est.directivo_m_congrup)+SUM(est.directivo_h_congrup) as directivo_t_congrup,
// SUM(est.directivo_m_singrup) as directivo_m_singrup, SUM(est.directivo_h_singrup) as directivo_h_singrup, SUM(est.directivo_m_singrup)+SUM(est.directivo_h_singrup) as directivo_t_singrup');
//     $this->db->from('escuela as es');
//     $this->db->join('estadistica_e_indicadores_xcct as est', 'es.id_cct = est.id_cct');
//     $this->db->join('municipio as mu', 'es.id_municipio = mu.id_municipio');
//     $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
//     $this->db->join('modalidad as mo', 'es.id_modalidad = mo.id_modalidad');
//     $this->db->join('subsostenimiento as sso', 'es.id_subsostenimiento = sso.id_subsostenimiento');
//     $this->db->join('sostenimiento as so', 'sso.id_sostenimiento = so.id_sostenimiento');
//     $this->db->join('ciclo as ci', 'est.id_ciclo = ci.id_ciclo');
//     if($id_municipio>0){
//       $this->db->where('mu.id_municipio', $id_municipio);
//     }
//     if($id_ciclo>0){
//       $this->db->where('ci.id_ciclo', $id_ciclo);
//     }
//     $this->db->where('ni.id_nivel <',8);
//     $this->db->where('ni.id_nivel !=',6);
//     $this->db->where('ni.id_nivel !=',7);

//     $this->db->group_by("ni.id_nivel");
//     $this->db->group_by("so.sostenimiento");
//     $this->db->group_by("mo.modalidad");

//     $this->db->order_by("id_nivel");
//     $this->db->order_by("sostenimiento", "DESC");
//     $this->db->order_by("id_modalidad", "ASC");

//     $query3 = $this->db->get_compiled_select();

    $query3 = "SELECT 
                CASE  
                    WHEN a.nivel LIKE '%ESPECIAL%' THEN '1'
                    WHEN a.nivel LIKE '%INICIAL%' THEN '2'
                    WHEN a.nivel LIKE '%PREESCOLAR%' THEN '3'
                    WHEN a.nivel LIKE '%PRIMARIA%' THEN '4'
                    WHEN a.nivel LIKE '%SECUNDARIA%' THEN '5'
                END AS id_nivel,a.nivel,id_sostenimiento,sostenimiento
                ,id_modalidad,modalidad,docente_m,docente_h,docentes_t_g,
                directivo_m_congrup,directivo_h_congrup,directivo_t_congrup,
                directivo_m_singrup,directivo_h_singrup,directivo_t_singrup 
               FROM (
                SELECT v.nivel_educativo,
                    CASE  
                        WHEN v.desc_nivel_educativo LIKE '%CAM%' THEN 'ESPECIAL'
                        WHEN v.desc_nivel_educativo LIKE '%INICIAL%' THEN 'INICIAL'
                        WHEN v.desc_nivel_educativo LIKE '%PREESCOLAR%' THEN 'PREESCOLAR'
                        WHEN v.desc_nivel_educativo LIKE '%PRIMARIA%' THEN 'PRIMARIA'
                        WHEN v.desc_nivel_educativo LIKE '%SECUNDARIA%' THEN 'SECUNDARIA'
                    END AS nivel,
                        (SELECT CASE  
                              WHEN v.sostenimiento IN  ('51') THEN '3' 
                              WHEN v.sostenimiento IN ('61','41','92','96') THEN '2'
                              ELSE '1'
                        END) AS id_sostenimiento,
                        (SELECT CASE  
                            WHEN v.sostenimiento IN  ('51') THEN 'AUTONOMO' 
                            WHEN v.sostenimiento IN ('61','41','92','96') THEN 'PRIVADO'
                            ELSE 'PUBLICO'
                        END) AS sostenimiento, 
                    v.servicio AS id_modalidad,v.desc_servicio AS modalidad,
                    IF(v.desc_nivel_educativo LIKE '%SECUNDARIA%', (SUM(est.docente_m)
                        +SUM(est.docente_m_ef)
                        +SUM(est.docente_m_artis)
                        +SUM(est.docente_m_tecnolo)
                        +SUM(est.docente_m_idiomas)) ,SUM(est.docente_m)) AS docente_m,
                    IF(v.desc_nivel_educativo LIKE '%SECUNDARIA%', (SUM(est.docente_h)
                        +SUM(est.docente_h_ef)
                        +SUM(est.docente_h_artis)
                        +SUM(est.docente_h_tecnolo)
                        +SUM(est.docente_h_idiomas)),SUM(est.docente_h)) AS docente_h,
                    IF(v.desc_nivel_educativo LIKE '%SECUNDARIA%', (SUM(est.docentes_t_g)
                        +SUM(est.docente_h_ef)
                        +SUM(est.docente_m_ef)
                        +SUM(est.docente_h_artis)
                        +SUM(est.docente_m_artis)
                        +SUM(est.docente_h_tecnolo)
                        +SUM(est.docente_m_tecnolo)
                        +SUM(est.docente_h_idiomas)
                        +SUM(est.docente_m_idiomas)),
                        SUM(est.docentes_t_g)) AS docentes_t_g,
                    SUM(est.directivo_m_congrup) AS directivo_m_congrup, 
                    SUM(est.directivo_h_congrup) AS directivo_h_congrup, 
                    SUM(est.directivo_m_congrup)+SUM(est.directivo_h_congrup) AS directivo_t_congrup,
                    SUM(est.directivo_m_singrup) AS directivo_m_singrup, 
                    SUM(est.directivo_h_singrup) AS directivo_h_singrup, 
                    SUM(est.directivo_m_singrup)+SUM(est.directivo_h_singrup) AS directivo_t_singrup
                FROM vista_cct v
                INNER JOIN estadistica_e_indicadores_xcct est ON est.cct=v.cct
                WHERE (v.status= 1 OR v.status = 4) AND v.tipo_centro=9 
                AND v.desc_nivel_educativo NOT IN('FORMACION PARA EL TRABAJO','OTRO NIVEL EDUCATIVO','NO APLICA','MEDIA SUPERIOR','SUPERIOR')
                {$filtro}           
                GROUP BY (CASE  
                            WHEN v.desc_nivel_educativo LIKE '%CAM%' THEN 'ESPECIAL'
                            WHEN v.desc_nivel_educativo LIKE '%INICIAL%' THEN 'INICIAL'
                            WHEN v.desc_nivel_educativo LIKE '%PREESCOLAR%' THEN 'PREESCOLAR'
                            WHEN v.desc_nivel_educativo LIKE '%PRIMARIA%' THEN 'PRIMARIA'
                            WHEN v.desc_nivel_educativo LIKE '%SECUNDARIA%' THEN 'SECUNDARIA'
                        END),
                        (CASE  
                            WHEN v.sostenimiento IN  ('51') THEN '3' 
                            WHEN v.sostenimiento IN ('61','41','92','96') THEN '2'
                            ELSE '1'
                        END),v.servicio
                ) AS a ORDER BY FIELD(nivel,'ESPECIAL','INICIAL','PREESCOLAR','PRIMARIA','SECUNDARIA','MEDIA SUPERIOR','SUPERIOR')
                ,id_sostenimiento,id_modalidad ";

    // $this->db->query($query1 . ' UNION ALL ' . $query2. ' UNION ALL ' . $query3)->result_array();
    // $str = $this->db->last_query();
    // echo $str; die();
    // echo $query1 . ' UNION ALL ' . $query2. ' UNION ALL ' . $query3;
    // die();
    return $this->db->query($query1 . ' UNION ALL ' . $query2. ' UNION ALL ' . $query3)->result_array();

  }// get_pdocente_xmunciclo()



  function get_pdocente_xzona($nivel,$sostenimiento,$id_zona_z,$id_ciclo_z){
    $filtro = "";
    $filtro_nivel_sos = "";
    if($sostenimiento=="PRIVADO"){
        $filtro_nivel_sos .= " AND sostenimiento IN ('61','41','92','96')";
    }else if($sostenimiento=="AUTONOMO"){
        $filtro_nivel_sos .= " AND sostenimiento IN  ('51')";
    }else if($sostenimiento== "PUBLICO"){
        $filtro_nivel_sos .= " AND sostenimiento NOT IN('61','41','92','96','51')";
    }

    if($nivel=="PREESCOLAR"){
        $filtro .= " AND IF(escuelas.desc_servicio LIKE '%PREESCOLAR%' AND supervisiones.tipo='FZP',TRUE,FALSE)";
        $filtro_nivel_sos .= " AND desc_nivel_educativo LIKE '%PREESCOLAR%' ";
    }else if($nivel=="PRIMARIA"){
        $filtro .= " AND IF(escuelas.desc_servicio LIKE '%PRIMARIA%' AND supervisiones.tipo='FIZ',TRUE,FALSE)";
        $filtro_nivel_sos .= " AND desc_nivel_educativo LIKE '%PRIMARIA%'";
    }else if($nivel=="SECUNDARIA"){
        $filtro .= "AND 
            IF( (escuelas.desc_servicio='SECUNDARIA GENERAL' OR escuelas.desc_servicio='SECUNDARIA COMUNITARIA'
                OR (escuelas.desc_servicio='SECUNDARIA TECNICA INDUSTRIAL' AND escuelas.desc_sostenimiento='ESTATAL') 
                OR (escuelas.desc_servicio='SECUNDARIA TECNICA INDUSTRIAL' AND escuelas.desc_sostenimiento='PARTICULAR') ) 
                AND supervisiones.tipo='FIS',TRUE,
            IF( ((escuelas.desc_servicio='SECUNDARIA TECNICA INDUSTRIAL' AND escuelas.desc_sostenimiento='FEDERAL TRANSFERIDO')
                OR (escuelas.desc_servicio='SECUNDARIA TECNICA AGROPECUARIA' AND escuelas.desc_sostenimiento='FEDERAL TRANSFERIDO')) AND supervisiones.tipo='FZT',TRUE,
            IF(escuelas.desc_servicio='TELESECUNDARIA' AND supervisiones.tipo='FTV', TRUE, FALSE ) ) )";
        $filtro_nivel_sos .= " AND desc_nivel_educativo LIKE '%SECUNDARIA%'";
    }


   $filtro_zona = "";
    if($id_zona_z!=''){
        $filtro_zona .= " AND supervisiones.cct = '{$id_zona_z}'";
    }

    $filtro_ciclo = "";
    if($id_ciclo_z>0){
        $filtro_ciclo .= " AND est.id_ciclo = {$id_ciclo_z} ";
    }

//     $this->db->select('ni.id_nivel,ni.nivel, "0" as id_subsostenimiento, "total" as subsostenimiento, "0" as id_modalidad, "total" as modalidad,
//     IF(ni.id_nivel=5, (SUM(est.docente_m)
// +SUM(est.docente_m_ef)
// +SUM(est.docente_m_artis)
// +SUM(est.docente_m_tecnolo)
// +SUM(est.docente_m_idiomas)) ,SUM(est.docente_m)) AS docente_m,
// 	IF(ni.id_nivel=5, (SUM(est.docente_h)
// +SUM(est.docente_h_ef)
// +SUM(est.docente_h_artis)
// +SUM(est.docente_h_tecnolo)
// +SUM(est.docente_h_idiomas)) ,SUM(est.docente_h)) AS docente_h,
// 	IF(ni.id_nivel=5, (SUM(est.docentes_t_g)
// +SUM(est.docente_h_ef)
// +SUM(est.docente_m_ef)
// +SUM(est.docente_h_artis)
// +SUM(est.docente_m_artis)
// +SUM(est.docente_h_tecnolo)
// +SUM(est.docente_m_tecnolo)
// +SUM(est.docente_h_idiomas)
// +SUM(est.docente_m_idiomas)) ,SUM(est.docentes_t_g)) AS docentes_t_g,
//     SUM(est.directivo_m_congrup) as directivo_m_congrup, SUM(est.directivo_h_congrup) as directivo_h_congrup, SUM(est.directivo_m_congrup)+SUM(est.directivo_h_congrup) as directivo_t_congrup,
//     SUM(est.directivo_m_singrup) as directivo_m_singrup, SUM(est.directivo_h_singrup) as directivo_h_singrup, SUM(est.directivo_m_singrup)+SUM(est.directivo_h_singrup) as directivo_t_singrup');
//     $this->db->from('escuela as es');
//     $this->db->join('estadistica_e_indicadores_xcct as est', 'es.id_cct = est.id_cct');
//     $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
//     $this->db->join('subsostenimiento as sso', '`es`.`id_subsostenimiento` = `sso`.`id_subsostenimiento`');
//     $this->db->join('supervision as su', '`es`.`id_supervision` = `su`.`id_supervision`');
//     $this->db->join('ciclo as ci', 'est.id_ciclo = ci.id_ciclo');
//     if($id_nivel_z>0){
//       $this->db->where('ni.id_nivel', $id_nivel_z);
//     }
//     if($id_sostenimiento_z>0){
//       $this->db->where('sso.id_subsostenimiento', $id_sostenimiento_z);
//     }
//     if($id_zona_z>0){
//       $this->db->where('su.id_supervision', $id_zona_z);
//     }
//     if($id_ciclo_z>0){
//       $this->db->where('ci.id_ciclo', $id_ciclo_z);
//     }
//     $this->db->where('ni.id_nivel <',8);
//     $this->db->group_by("ni.id_nivel");

//     $query1 = $this->db->get_compiled_select();
    $query1 = "SELECT CASE  
                    WHEN escuelas.nivel LIKE '%ESPECIAL%' THEN '1'
                    WHEN escuelas.nivel LIKE '%INICIAL%' THEN '2'
                    WHEN escuelas.nivel LIKE '%PREESCOLAR%' THEN '3'
                    WHEN escuelas.nivel LIKE '%PRIMARIA%' THEN '4'
                    WHEN escuelas.nivel LIKE '%SECUNDARIA%' THEN '5'
                    WHEN escuelas.nivel LIKE '%MEDIA SUPERIOR%' THEN '6'
                    WHEN escuelas.nivel LIKE '%SUPERIOR%' THEN '7'
                END AS id_nivel,escuelas.nivel,'0' AS id_sostenimiento, 'total' AS sostenimiento, '0' AS id_modalidad, 'total' AS modalidad,
                IF(escuelas.nivel LIKE '%SECUNDARIA%', (SUM(est.docente_m)+SUM(est.docente_m_ef)+SUM(est.docente_m_artis)+SUM(est.docente_m_tecnolo)+SUM(est.docente_m_idiomas)) ,
                    SUM(est.docente_m)) AS docente_m,
                IF(escuelas.nivel LIKE '%SECUNDARIA%', (SUM(est.docente_h)+SUM(est.docente_h_ef)+SUM(est.docente_h_artis)+SUM(est.docente_h_tecnolo)+SUM(est.docente_h_idiomas)) ,
                    SUM(est.docente_h)) AS docente_h,
                IF(escuelas.nivel LIKE '%SECUNDARIA%', (SUM(est.docentes_t_g)+SUM(est.docente_h_ef)+SUM(est.docente_m_ef)
                    +SUM(est.docente_h_artis)
                    +SUM(est.docente_m_artis)
                    +SUM(est.docente_h_tecnolo)
                    +SUM(est.docente_m_tecnolo)
                    +SUM(est.docente_h_idiomas)
                    +SUM(est.docente_m_idiomas)),SUM(est.docentes_t_g)) AS docentes_t_g,
                    SUM(est.directivo_m_congrup) AS directivo_m_congrup, 
                    SUM(est.directivo_h_congrup) AS directivo_h_congrup, 
                    SUM(est.directivo_m_congrup)+SUM(est.directivo_h_congrup) AS directivo_t_congrup,
                    SUM(est.directivo_m_singrup) AS directivo_m_singrup, 
                    SUM(est.directivo_h_singrup) AS directivo_h_singrup, 
                    SUM(est.directivo_m_singrup)+SUM(est.directivo_h_singrup) AS directivo_t_singrup
            FROM (SELECT cct, turno, sostenimiento, zona_escolar, desc_nivel_educativo,
                    desc_servicio,desc_sostenimiento,nivel_educativo,
                    CASE 
                        WHEN desc_nivel_educativo LIKE '%CAM%' THEN 'ESPECIAL'
                        WHEN desc_nivel_educativo LIKE '%INICIAL%' THEN 'INICIAL'
                        WHEN desc_nivel_educativo LIKE '%PREESCOLAR%' THEN 'PREESCOLAR'
                        WHEN desc_nivel_educativo LIKE '%PRIMARIA%' THEN 'PRIMARIA'
                        WHEN desc_nivel_educativo LIKE '%SECUNDARIA%' THEN 'SECUNDARIA'
                        WHEN desc_nivel_educativo LIKE '%MEDIA SUPERIOR%' THEN 'MEDIA SUPERIOR'
                        WHEN desc_nivel_educativo LIKE '%SUPERIOR%' THEN 'SUPERIOR'
                    END AS nivel
                FROM vista_cct 
                WHERE (`status` = 1 OR `status` = 4) AND tipo_centro = 9 
                {$filtro_nivel_sos}
            ) AS escuelas
            INNER JOIN estadistica_e_indicadores_xcct AS est ON est.cct=escuelas.cct
            {$filtro_ciclo}
            INNER JOIN (SELECT cct, zona_escolar, sostenimiento, desc_nivel_educativo, 
                            SUBSTRING(cct, 3, 3) AS tipo
                        FROM vista_cct cct
                        WHERE (`status` = 1 OR `status` = 4) AND tipo_centro = 1
            ) AS supervisiones ON escuelas.zona_escolar = supervisiones.zona_escolar
            AND escuelas.sostenimiento = supervisiones.sostenimiento
            {$filtro} {$filtro_zona}   
            GROUP BY CASE   
                WHEN escuelas.desc_nivel_educativo LIKE '%CAM%' THEN 'ESPECIAL'
                WHEN escuelas.desc_nivel_educativo LIKE '%INICIAL%' THEN 'INICIAL'
                WHEN escuelas.desc_nivel_educativo LIKE '%PREESCOLAR%' THEN 'PREESCOLAR'
                WHEN escuelas.desc_nivel_educativo LIKE '%PRIMARIA%' THEN 'PRIMARIA'
                WHEN escuelas.desc_nivel_educativo LIKE '%SECUNDARIA%' THEN 'SECUNDARIA'
                WHEN escuelas.desc_nivel_educativo LIKE '%MEDIA SUPERIOR%' THEN 'MEDIA SUPERIOR'
                WHEN escuelas.desc_nivel_educativo LIKE '%SUPERIOR%' THEN 'SUPERIOR'
            END ";

//     $this->db->select('ni.id_nivel,ni.nivel, sso.id_subsostenimiento, sso.subsostenimiento, "0" as id_modalidad, "total" as modalidad,
//     IF(ni.id_nivel=5, (SUM(est.docente_m)
// +SUM(est.docente_m_ef)
// +SUM(est.docente_m_artis)
// +SUM(est.docente_m_tecnolo)
// +SUM(est.docente_m_idiomas)) ,SUM(est.docente_m)) AS docente_m,
// 	IF(ni.id_nivel=5, (SUM(est.docente_h)
// +SUM(est.docente_h_ef)
// +SUM(est.docente_h_artis)
// +SUM(est.docente_h_tecnolo)
// +SUM(est.docente_h_idiomas)) ,SUM(est.docente_h)) AS docente_h,
// 	IF(ni.id_nivel=5, (SUM(est.docentes_t_g)
// +SUM(est.docente_h_ef)
// +SUM(est.docente_m_ef)
// +SUM(est.docente_h_artis)
// +SUM(est.docente_m_artis)
// +SUM(est.docente_h_tecnolo)
// +SUM(est.docente_m_tecnolo)
// +SUM(est.docente_h_idiomas)
// +SUM(est.docente_m_idiomas)) ,SUM(est.docentes_t_g)) AS docentes_t_g,
// SUM(est.directivo_m_congrup) as directivo_m_congrup, SUM(est.directivo_h_congrup) as directivo_h_congrup, SUM(est.directivo_m_congrup)+SUM(est.directivo_h_congrup) as directivo_t_congrup,
// SUM(est.directivo_m_singrup) as directivo_m_singrup, SUM(est.directivo_h_singrup) as directivo_h_singrup, SUM(est.directivo_m_singrup)+SUM(est.directivo_h_singrup) as directivo_t_singrup');
//     $this->db->from('escuela as es');
//     $this->db->join('estadistica_e_indicadores_xcct as est', 'es.id_cct = est.id_cct');
//     $this->db->join('municipio as mu', 'es.id_municipio = mu.id_municipio');
//     $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
//     $this->db->join('modalidad as mo', 'es.id_modalidad = mo.id_modalidad');
//     $this->db->join('subsostenimiento as sso', 'es.id_subsostenimiento = sso.id_subsostenimiento');
//     $this->db->join('sostenimiento as so', 'sso.id_sostenimiento = so.id_sostenimiento');
//     $this->db->join('supervision as su', '`es`.`id_supervision` = `su`.`id_supervision`');
//     $this->db->join('ciclo as ci', 'est.id_ciclo = ci.id_ciclo');
//     if($id_nivel_z>0){
//       $this->db->where('ni.id_nivel', $id_nivel_z);
//     }
//     if($id_sostenimiento_z>0){
//       $this->db->where('sso.id_subsostenimiento', $id_sostenimiento_z);
//     }
//     if($id_zona_z>0){
//       $this->db->where('su.id_supervision', $id_zona_z);
//     }
//     if($id_ciclo_z>0){
//       $this->db->where('ci.id_ciclo', $id_ciclo_z);
//     }
//     $this->db->where('ni.id_nivel <',8);
//     $this->db->group_by("ni.nivel");
//     $this->db->group_by("subsostenimiento");

//     $query2 = $this->db->get_compiled_select();
    $query2 = "SELECT CASE  
                        WHEN escuelas.nivel LIKE '%ESPECIAL%' THEN '1'
                        WHEN escuelas.nivel LIKE '%INICIAL%' THEN '2'
                        WHEN escuelas.nivel LIKE '%PREESCOLAR%' THEN '3'
                        WHEN escuelas.nivel LIKE '%PRIMARIA%' THEN '4'
                        WHEN escuelas.nivel LIKE '%SECUNDARIA%' THEN '5'
                        WHEN escuelas.nivel LIKE '%MEDIA SUPERIOR%' THEN '6'
                        WHEN escuelas.nivel LIKE '%SUPERIOR%' THEN '7'
                    END AS id_nivel,escuelas.nivel,
                    (SELECT CASE  
                        WHEN escuelas.sostenimiento IN  ('51') THEN '3'
                        WHEN escuelas.sostenimiento IN ('61','41','92','96') THEN '2'
                        ELSE '1'
                    END) AS id_sostenimiento,
                    (SELECT CASE  
                        WHEN escuelas.sostenimiento IN  ('51') THEN 'AUTONOMO'
                        WHEN escuelas.sostenimiento IN ('61','41','92','96') THEN 'PRIVADO'
                        ELSE 'PUBLICO'
                    END)  as sostenimiento
                    , '0' AS id_modalidad, 'total' AS modalidad,
                    IF(escuelas.nivel LIKE '%SECUNDARIA%', (SUM(est.docente_m)+SUM(est.docente_m_ef)+SUM(est.docente_m_artis)+SUM(est.docente_m_tecnolo)+SUM(est.docente_m_idiomas)) ,
                        SUM(est.docente_m)) AS docente_m,
                    IF(escuelas.nivel LIKE '%SECUNDARIA%', (SUM(est.docente_h)+SUM(est.docente_h_ef)+SUM(est.docente_h_artis)+SUM(est.docente_h_tecnolo)+SUM(est.docente_h_idiomas)) ,
                        SUM(est.docente_h)) AS docente_h,
                    IF(escuelas.nivel LIKE '%SECUNDARIA%', (SUM(est.docentes_t_g)+SUM(est.docente_h_ef)+SUM(est.docente_m_ef)+SUM(est.docente_h_artis)+SUM(est.docente_m_artis)+SUM(est.docente_h_tecnolo)
                        +SUM(est.docente_m_tecnolo)
                        +SUM(est.docente_h_idiomas)
                        +SUM(est.docente_m_idiomas)),SUM(est.docentes_t_g)) AS docentes_t_g,
                    SUM(est.directivo_m_congrup) AS directivo_m_congrup, 
                    SUM(est.directivo_h_congrup) AS directivo_h_congrup, 
                    SUM(est.directivo_m_congrup)+SUM(est.directivo_h_congrup) AS directivo_t_congrup,
                    SUM(est.directivo_m_singrup) AS directivo_m_singrup, 
                    SUM(est.directivo_h_singrup) AS directivo_h_singrup, 
                    SUM(est.directivo_m_singrup)+SUM(est.directivo_h_singrup) AS directivo_t_singrup
            FROM (SELECT cct, turno, sostenimiento, zona_escolar, desc_nivel_educativo,
                    desc_servicio, desc_sostenimiento,nivel_educativo,
                    CASE 
                        WHEN desc_nivel_educativo LIKE '%CAM%' THEN 'ESPECIAL'
                        WHEN desc_nivel_educativo LIKE '%INICIAL%' THEN 'INICIAL'
                        WHEN desc_nivel_educativo LIKE '%PREESCOLAR%' THEN 'PREESCOLAR'
                        WHEN desc_nivel_educativo LIKE '%PRIMARIA%' THEN 'PRIMARIA'
                        WHEN desc_nivel_educativo LIKE '%SECUNDARIA%' THEN 'SECUNDARIA'
                        WHEN desc_nivel_educativo LIKE '%MEDIA SUPERIOR%' THEN 'MEDIA SUPERIOR'
                        WHEN desc_nivel_educativo LIKE '%SUPERIOR%' THEN 'SUPERIOR'
                    END AS nivel
                FROM vista_cct 
                WHERE (status = 1 OR status = 4) AND tipo_centro = 9  
                {$filtro_nivel_sos}
            ) AS escuelas
            INNER JOIN estadistica_e_indicadores_xcct AS est ON est.cct=escuelas.cct
            {$filtro_ciclo}
            INNER JOIN (SELECT cct, zona_escolar,sostenimiento,desc_nivel_educativo,
                            SUBSTRING(cct, 3, 3) AS tipo
                        FROM vista_cct cct
                        WHERE (status = 1 OR status = 4) AND tipo_centro = 1
            ) AS supervisiones 
                        ON escuelas.zona_escolar = supervisiones.zona_escolar
                        AND escuelas.sostenimiento = supervisiones.sostenimiento
            {$filtro} {$filtro_zona}
            GROUP BY (CASE   
                        WHEN escuelas.desc_nivel_educativo LIKE '%CAM%' THEN 'ESPECIAL'
                        WHEN escuelas.desc_nivel_educativo LIKE '%INICIAL%' THEN 'INICIAL'
                        WHEN escuelas.desc_nivel_educativo LIKE '%PREESCOLAR%' THEN 'PREESCOLAR'
                        WHEN escuelas.desc_nivel_educativo LIKE '%PRIMARIA%' THEN 'PRIMARIA'
                        WHEN escuelas.desc_nivel_educativo LIKE '%SECUNDARIA%' THEN 'SECUNDARIA'
                        WHEN escuelas.desc_nivel_educativo LIKE '%MEDIA SUPERIOR%' THEN 'MEDIA SUPERIOR'
                        WHEN escuelas.desc_nivel_educativo LIKE '%SUPERIOR%' THEN 'SUPERIOR'
                    END),
                    (CASE  
                        WHEN escuelas.sostenimiento IN  ('51') THEN 'AUTONOMO'
                        WHEN escuelas.sostenimiento IN ('61','41','92','96') THEN 'PRIVADO'
                        ELSE 'PUBLICO'
                    END)";

//     $this->db->select('ni.id_nivel,ni.nivel, sso.id_subsostenimiento, sso.subsostenimiento, mo.id_modalidad, mo.modalidad,
//     IF(ni.id_nivel=5, (SUM(est.docente_m)
// +SUM(est.docente_m_ef)
// +SUM(est.docente_m_artis)
// +SUM(est.docente_m_tecnolo)
// +SUM(est.docente_m_idiomas)) ,SUM(est.docente_m)) AS docente_m,
// 	IF(ni.id_nivel=5, (SUM(est.docente_h)
// +SUM(est.docente_h_ef)
// +SUM(est.docente_h_artis)
// +SUM(est.docente_h_tecnolo)
// +SUM(est.docente_h_idiomas)) ,SUM(est.docente_h)) AS docente_h,
// 	IF(ni.id_nivel=5, (SUM(est.docentes_t_g)
// +SUM(est.docente_h_ef)
// +SUM(est.docente_m_ef)
// +SUM(est.docente_h_artis)
// +SUM(est.docente_m_artis)
// +SUM(est.docente_h_tecnolo)
// +SUM(est.docente_m_tecnolo)
// +SUM(est.docente_h_idiomas)
// +SUM(est.docente_m_idiomas)) ,SUM(est.docentes_t_g)) AS docentes_t_g,
// SUM(est.directivo_m_congrup) as directivo_m_congrup, SUM(est.directivo_h_congrup) as directivo_h_congrup, SUM(est.directivo_m_congrup)+SUM(est.directivo_h_congrup) as directivo_t_congrup,
// SUM(est.directivo_m_singrup) as directivo_m_singrup, SUM(est.directivo_h_singrup) as directivo_h_singrup, SUM(est.directivo_m_singrup)+SUM(est.directivo_h_singrup) as directivo_t_singrup');
//     $this->db->from('escuela as es');
//     $this->db->join('estadistica_e_indicadores_xcct as est', 'es.id_cct = est.id_cct');
//     $this->db->join('municipio as mu', 'es.id_municipio = mu.id_municipio');
//     $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
//     $this->db->join('modalidad as mo', 'es.id_modalidad = mo.id_modalidad');
//     $this->db->join('subsostenimiento as sso', 'es.id_subsostenimiento = sso.id_subsostenimiento');
//     $this->db->join('sostenimiento as so', 'sso.id_sostenimiento = so.id_sostenimiento');
//     $this->db->join('supervision as su', '`es`.`id_supervision` = `su`.`id_supervision`');
//     $this->db->join('ciclo as ci', 'est.id_ciclo = ci.id_ciclo');
//     if($id_nivel_z>0){
//       $this->db->where('ni.id_nivel', $id_nivel_z);
//     }
//     if($id_sostenimiento_z>0){
//       $this->db->where('sso.id_subsostenimiento', $id_sostenimiento_z);
//     }
//     if($id_zona_z>0){
//       $this->db->where('su.id_supervision', $id_zona_z);
//     }
//     if($id_ciclo_z>0){
//       $this->db->where('ci.id_ciclo', $id_ciclo_z);
//     }
//     $this->db->where('ni.id_nivel <',8);
//     $this->db->where('ni.id_nivel !=',6);
//     $this->db->where('ni.id_nivel !=',7);
//     $this->db->group_by("ni.id_nivel");
//     $this->db->group_by("sso.subsostenimiento");
//     $this->db->group_by("mo.modalidad");

//     $this->db->order_by("id_nivel");
//     $this->db->order_by("subsostenimiento", "DESC");
//     $this->db->order_by("id_modalidad", "ASC");

//     $query3 = $this->db->get_compiled_select();
    $query3 = "SELECT CASE  
                    WHEN escuelas.nivel LIKE '%ESPECIAL%' THEN '1'
                    WHEN escuelas.nivel LIKE '%INICIAL%' THEN '2'
                    WHEN escuelas.nivel LIKE '%PREESCOLAR%' THEN '3'
                    WHEN escuelas.nivel LIKE '%PRIMARIA%' THEN '4'
                    WHEN escuelas.nivel LIKE '%SECUNDARIA%' THEN '5'
                    WHEN escuelas.nivel LIKE '%MEDIA SUPERIOR%' THEN '6'
                    WHEN escuelas.nivel LIKE '%SUPERIOR%' THEN '7'
                END AS id_nivel,escuelas.nivel,
                (SELECT CASE  
                    WHEN escuelas.sostenimiento IN  ('51') THEN '3'
                    WHEN escuelas.sostenimiento IN ('61','41','92','96') THEN '2'
                    ELSE '1'
                END) AS id_sostenimiento,
                (SELECT CASE  
                    WHEN escuelas.sostenimiento IN  ('51') THEN 'AUTONOMO'
                    WHEN escuelas.sostenimiento IN ('61','41','92','96') THEN 'PRIVADO'
                    ELSE 'PUBLICO'
                END) AS sostenimiento, escuelas.servicio AS id_modalidad, 
                escuelas.desc_servicio AS modalidad,
                IF(escuelas.nivel LIKE '%SECUNDARIA%', (SUM(est.docente_m)+SUM(est.docente_m_ef)+SUM(est.docente_m_artis)
                +SUM(est.docente_m_tecnolo)+SUM(est.docente_m_idiomas)),
                SUM(est.docente_m)) AS docente_m,
                IF(escuelas.nivel LIKE '%SECUNDARIA%', (SUM(est.docente_h)+SUM(est.docente_h_ef)+SUM(est.docente_h_artis)+SUM(est.docente_h_tecnolo)+SUM(est.docente_h_idiomas)) ,
                    SUM(est.docente_h)) AS docente_h,
                IF(escuelas.nivel LIKE '%SECUNDARIA%', (SUM(est.docentes_t_g)+SUM(est.docente_h_ef)+SUM(est.docente_m_ef)+SUM(est.docente_h_artis)+SUM(est.docente_m_artis)+SUM(est.docente_h_tecnolo)
                    +SUM(est.docente_m_tecnolo)
                    +SUM(est.docente_h_idiomas)
                    +SUM(est.docente_m_idiomas)),
                SUM(est.docentes_t_g)) AS docentes_t_g,
                SUM(est.directivo_m_congrup) AS directivo_m_congrup, 
                SUM(est.directivo_h_congrup) AS directivo_h_congrup, 
                SUM(est.directivo_m_congrup)+SUM(est.directivo_h_congrup) AS directivo_t_congrup,
                SUM(est.directivo_m_singrup) AS directivo_m_singrup, 
                SUM(est.directivo_h_singrup) AS directivo_h_singrup, 
                SUM(est.directivo_m_singrup)+SUM(est.directivo_h_singrup) AS directivo_t_singrup
                FROM (SELECT cct, turno, sostenimiento, zona_escolar, desc_nivel_educativo,servicio,
                        desc_servicio, desc_sostenimiento,nivel_educativo,
                        CASE 
                            WHEN desc_nivel_educativo LIKE '%CAM%' THEN 'ESPECIAL'
                            WHEN desc_nivel_educativo LIKE '%INICIAL%' THEN 'INICIAL'
                            WHEN desc_nivel_educativo LIKE '%PREESCOLAR%' THEN 'PREESCOLAR'
                            WHEN desc_nivel_educativo LIKE '%PRIMARIA%' THEN 'PRIMARIA'
                            WHEN desc_nivel_educativo LIKE '%SECUNDARIA%' THEN 'SECUNDARIA'
                            WHEN desc_nivel_educativo LIKE '%MEDIA SUPERIOR%' THEN 'MEDIA SUPERIOR'
                            WHEN desc_nivel_educativo LIKE '%SUPERIOR%' THEN 'SUPERIOR'
                        END AS nivel
                    FROM vista_cct 
                    WHERE (`status` = 1 OR `status` = 4) AND tipo_centro = 9
                    {$filtro_nivel_sos} 
                ) AS escuelas
                INNER JOIN estadistica_e_indicadores_xcct AS est ON est.cct=escuelas.cct
                {$filtro_ciclo}
                INNER JOIN (SELECT cct, zona_escolar, sostenimiento, desc_nivel_educativo,
                                SUBSTRING(cct, 3, 3) AS tipo
                            FROM vista_cct cct
                            WHERE (`status` = 1 OR `status` = 4) AND tipo_centro = 1) AS supervisiones ON escuelas.zona_escolar = supervisiones.zona_escolar
                            AND escuelas.sostenimiento = supervisiones.sostenimiento
                {$filtro} {$filtro_zona}
                GROUP BY (CASE   
                            WHEN escuelas.desc_nivel_educativo LIKE '%CAM%' THEN 'ESPECIAL'
                            WHEN escuelas.desc_nivel_educativo LIKE '%INICIAL%' THEN 'INICIAL'
                            WHEN escuelas.desc_nivel_educativo LIKE '%PREESCOLAR%' THEN 'PREESCOLAR'
                            WHEN escuelas.desc_nivel_educativo LIKE '%PRIMARIA%' THEN 'PRIMARIA'
                            WHEN escuelas.desc_nivel_educativo LIKE '%SECUNDARIA%' THEN 'SECUNDARIA'
                            WHEN escuelas.desc_nivel_educativo LIKE '%MEDIA SUPERIOR%' THEN 'MEDIA SUPERIOR'
                            WHEN escuelas.desc_nivel_educativo LIKE '%SUPERIOR%' THEN 'SUPERIOR'
                        END),
                        (CASE  WHEN escuelas.sostenimiento IN  ('51') THEN 'AUTONOMO'
                            WHEN escuelas.sostenimiento IN ('61','41','92','96') THEN 'PRIVADO'
                            ELSE 'PUBLICO'
                        END),escuelas.desc_servicio
                ORDER BY FIELD(nivel,'ESPECIAL','INICIAL','PREESCOLAR','PRIMARIA','SECUNDARIA','MEDIA SUPERIOR','SUPERIOR')
                ,id_sostenimiento,id_modalidad ";


    return $this->db->query($query1 . ' UNION ALL ' . $query2. ' UNION ALL ' . $query3)->result_array();

  }// get_pdocente_xzona()

  function get_infraest_xmunciclo($id_municipio, $id_ciclo){
    // $where_aux="(ci.id_ciclo= {$id_ciclo} OR ci.id_ciclo IS NULL)";
    // $this->db->select('ni.id_nivel,ni.nivel, "0" as id_sostenimiento, "total" as sostenimiento, "0" as id_modalidad, "total" as modalidad,
    // COUNT(es.id_cct) as nescuelas,
    // 	SUM(est.grupos_1) AS grupos_1,
    // 	SUM(est.grupos_2) grupos_2,
    // 	SUM(est.grupos_3) AS grupos_3,
    // 	SUM(est.grupos_4) AS grupos_4,
    // 	SUM(est.grupos_5) AS grupos_5,
    // 	SUM(est.grupos_6) AS grupos_6,
    // 	SUM(est.grupos_multi) AS grupos_multi,
    // 	SUM(est.grupos_t) AS grupos_t');
    // $this->db->from('escuela as es');
    // $this->db->join('estadistica_e_indicadores_xcct as est', 'es.id_cct = est.id_cct');
    // $this->db->join('municipio as mu', 'es.id_municipio = mu.id_municipio');
    // $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
    // $this->db->join('ciclo as ci', 'est.id_ciclo = ci.id_ciclo','left');

    // $this->db->where('ni.id_nivel <',8);
    // $this->db->group_by("ni.nivel");
    // $query1 = $this->db->get_compiled_select();
    
    $filtro="";
    if($id_municipio>0){
        $filtro.=" AND v.municipio={$id_municipio}";
    }
    if($id_ciclo>0){
        $filtro.=" AND est.id_ciclo={$id_ciclo}";
    }

    $query1="SELECT 
                CASE  
                    WHEN a.nivel LIKE '%ESPECIAL%' THEN '1'
                    WHEN a.nivel LIKE '%INICIAL%' THEN '2'
                    WHEN a.nivel LIKE '%PREESCOLAR%' THEN '3'
                    WHEN a.nivel LIKE '%PRIMARIA%' THEN '4'
                    WHEN a.nivel LIKE '%SECUNDARIA%' THEN '5'
                    WHEN a.nivel LIKE '%MEDIA SUPERIOR%' THEN '6'
                    WHEN a.nivel LIKE '%SUPERIOR%' THEN '7'
                    END AS id_nivel,a.nivel,id_sostenimiento,sostenimiento
                    ,id_modalidad,modalidad,nescuelas,grupos_1,grupos_2,
                    grupos_3,grupos_4,grupos_5,
                    grupos_6,grupos_multi,grupos_t 
            FROM (
                SELECT v.nivel_educativo,
                    CASE  
                        WHEN v.desc_nivel_educativo LIKE '%CAM%' THEN 'ESPECIAL'
                        WHEN v.desc_nivel_educativo LIKE '%INICIAL%' THEN 'INICIAL'
                        WHEN v.desc_nivel_educativo LIKE '%PREESCOLAR%' THEN 'PREESCOLAR'
                        WHEN v.desc_nivel_educativo LIKE '%PRIMARIA%' THEN 'PRIMARIA'
                        WHEN v.desc_nivel_educativo LIKE '%SECUNDARIA%' THEN 'SECUNDARIA'
                        WHEN v.desc_nivel_educativo LIKE '%MEDIA SUPERIOR%' THEN 'MEDIA SUPERIOR'
                        WHEN v.desc_nivel_educativo LIKE '%SUPERIOR%' THEN 'SUPERIOR'
                    END AS nivel, 
                    '0' AS id_sostenimiento, 'total' AS sostenimiento, '0' AS id_modalidad, 'total' AS modalidad,
                    COUNT(v.cct) AS nescuelas,
                    SUM(est.grupos_1) AS grupos_1,
                    SUM(est.grupos_2) grupos_2,
                    SUM(est.grupos_3) AS grupos_3,
                    SUM(est.grupos_4) AS grupos_4,
                    SUM(est.grupos_5) AS grupos_5,
                    SUM(est.grupos_6) AS grupos_6,
                    SUM(est.grupos_multi) AS grupos_multi,
                    SUM(est.grupos_t) AS grupos_t  
                FROM vista_cct v
                INNER JOIN estadistica_e_indicadores_xcct est ON est.cct=v.cct
                WHERE (v.status= 1 OR v.status = 4) AND v.tipo_centro=9 
                AND v.desc_nivel_educativo NOT IN('FORMACION PARA EL TRABAJO','OTRO NIVEL EDUCATIVO','NO APLICA')
                {$filtro}      
                GROUP BY (CASE  
                    WHEN v.desc_nivel_educativo LIKE '%CAM%' THEN 'ESPECIAL'
                    WHEN v.desc_nivel_educativo LIKE '%INICIAL%' THEN 'INICIAL'
                    WHEN v.desc_nivel_educativo LIKE '%PREESCOLAR%' THEN 'PREESCOLAR'
                    WHEN v.desc_nivel_educativo LIKE '%PRIMARIA%' THEN 'PRIMARIA'
                    WHEN v.desc_nivel_educativo LIKE '%SECUNDARIA%' THEN 'SECUNDARIA'
                    WHEN v.desc_nivel_educativo LIKE '%MEDIA SUPERIOR%' THEN 'MEDIA SUPERIOR'
                    WHEN v.desc_nivel_educativo LIKE '%SUPERIOR%' THEN 'SUPERIOR'
                    END)
            ) AS a";


 //    $this->db->select('ni.id_nivel,ni.nivel, so.id_sostenimiento, so.sostenimiento, "0" as id_modalidad, "total" as modalidad,
 //    COUNT(es.id_cct) as nescuelas,
	// SUM(est.grupos_1) AS grupos_1,
	// SUM(est.grupos_2) grupos_2,
	// SUM(est.grupos_3) AS grupos_3,
	// SUM(est.grupos_4) AS grupos_4,
	// SUM(est.grupos_5) AS grupos_5,
	// SUM(est.grupos_6) AS grupos_6,
	// SUM(est.grupos_multi) AS grupos_multi,
	// SUM(est.grupos_t) AS grupos_t');
 //    $this->db->from('escuela as es');
 //    $this->db->join('estadistica_e_indicadores_xcct as est', 'es.id_cct = est.id_cct');
 //    $this->db->join('municipio as mu', 'es.id_municipio = mu.id_municipio');
 //    $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
 //    $this->db->join('modalidad as mo', 'es.id_modalidad = mo.id_modalidad');
 //    $this->db->join('subsostenimiento as sso', 'es.id_subsostenimiento = sso.id_subsostenimiento');
 //    $this->db->join('sostenimiento as so', 'sso.id_sostenimiento = so.id_sostenimiento');
 //    $this->db->join('ciclo as ci', 'est.id_ciclo = ci.id_ciclo','left');
 //    if($id_municipio>0){
 //      $this->db->where('mu.id_municipio', $id_municipio);
 //    }
 //    if($id_ciclo>0){
 //      $this->db->where($where_aux);
 //    }
 //    $this->db->where('ni.id_nivel <',8);
 //    $this->db->group_by("ni.nivel");
 //    $this->db->group_by("so.sostenimiento");

 //    $query2 = $this->db->get_compiled_select();

    $query2 = "SELECT 
                CASE  
                    WHEN a.nivel LIKE '%ESPECIAL%' THEN '1'
                    WHEN a.nivel LIKE '%INICIAL%' THEN '2'
                    WHEN a.nivel LIKE '%PREESCOLAR%' THEN '3'
                    WHEN a.nivel LIKE '%PRIMARIA%' THEN '4'
                    WHEN a.nivel LIKE '%SECUNDARIA%' THEN '5'
                    WHEN a.nivel LIKE '%MEDIA SUPERIOR%' THEN '6'
                    WHEN a.nivel LIKE '%SUPERIOR%' THEN '7'
                    END AS id_nivel,a.nivel,id_sostenimiento,sostenimiento
                    ,id_modalidad,modalidad,nescuelas,grupos_1,grupos_2,grupos_3,
                    grupos_4,grupos_5,grupos_6,grupos_multi,grupos_t 
                FROM (
                    SELECT v.nivel_educativo,
                        CASE  
                            WHEN v.desc_nivel_educativo LIKE '%CAM%' THEN 'ESPECIAL'
                            WHEN v.desc_nivel_educativo LIKE '%INICIAL%' THEN 'INICIAL'
                            WHEN v.desc_nivel_educativo LIKE '%PREESCOLAR%' THEN 'PREESCOLAR'
                            WHEN v.desc_nivel_educativo LIKE '%PRIMARIA%' THEN 'PRIMARIA'
                            WHEN v.desc_nivel_educativo LIKE '%SECUNDARIA%' THEN 'SECUNDARIA'
                            WHEN v.desc_nivel_educativo LIKE '%MEDIA SUPERIOR%' THEN 'MEDIA SUPERIOR'
                            WHEN v.desc_nivel_educativo LIKE '%SUPERIOR%' THEN 'SUPERIOR'
                            END AS nivel,
                        (SELECT CASE  
                            WHEN v.sostenimiento IN  ('51') THEN '3' 
                            WHEN v.sostenimiento IN ('61','41','92','96') THEN '2'
                            ELSE '1'
                        END) AS id_sostenimiento,
                        (SELECT CASE  
                            WHEN v.sostenimiento IN  ('51') THEN 'AUTONOMO' 
                            WHEN v.sostenimiento IN ('61','41','92','96') THEN 'PRIVADO'
                            ELSE 'PUBLICO'
                        END) AS sostenimiento,
                        '0' AS id_modalidad, 'total' AS modalidad,
                        COUNT(v.cct) AS nescuelas,
                        SUM(est.grupos_1) AS grupos_1,
                        SUM(est.grupos_2) grupos_2,
                        SUM(est.grupos_3) AS grupos_3,
                        SUM(est.grupos_4) AS grupos_4,
                        SUM(est.grupos_5) AS grupos_5,
                        SUM(est.grupos_6) AS grupos_6,
                        SUM(est.grupos_multi) AS grupos_multi,
                        SUM(est.grupos_t) AS grupos_t 
                    FROM vista_cct v
                    INNER JOIN estadistica_e_indicadores_xcct est ON est.cct=v.cct
                    WHERE (v.status= 1 OR v.status = 4) AND v.tipo_centro=9 
                    AND v.desc_nivel_educativo NOT IN('FORMACION PARA EL TRABAJO','OTRO NIVEL EDUCATIVO','NO APLICA')
                    {$filtro}
                    GROUP BY (CASE  
                        WHEN v.desc_nivel_educativo LIKE '%CAM%' THEN 'ESPECIAL'
                        WHEN v.desc_nivel_educativo LIKE '%INICIAL%' THEN 'INICIAL'
                        WHEN v.desc_nivel_educativo LIKE '%PREESCOLAR%' THEN 'PREESCOLAR'
                        WHEN v.desc_nivel_educativo LIKE '%PRIMARIA%' THEN 'PRIMARIA'
                        WHEN v.desc_nivel_educativo LIKE '%SECUNDARIA%' THEN 'SECUNDARIA'
                        WHEN v.desc_nivel_educativo LIKE '%MEDIA SUPERIOR%' THEN 'MEDIA SUPERIOR'
                        WHEN v.desc_nivel_educativo LIKE '%SUPERIOR%' THEN 'SUPERIOR'
                        END),(CASE  
                            WHEN v.sostenimiento IN  ('51') THEN 'AUTONOMO' 
                            WHEN v.sostenimiento IN ('61','41','92','96') THEN 'PRIVADO'
                            ELSE 'PUBLICO'
                        END)
                ) AS a";

 //    $this->db->select('ni.id_nivel,ni.nivel, so.id_sostenimiento, so.sostenimiento, mo.id_modalidad, mo.modalidad,
 //    COUNT(es.id_cct) as nescuelas,
	// SUM(est.grupos_1) AS grupos_1,
	// SUM(est.grupos_2) grupos_2,
	// SUM(est.grupos_3) AS grupos_3,
	// SUM(est.grupos_4) AS grupos_4,
	// SUM(est.grupos_5) AS grupos_5,
	// SUM(est.grupos_6) AS grupos_6,
	// SUM(est.grupos_multi) AS grupos_multi,
	// SUM(est.grupos_t) AS grupos_t');
 //    $this->db->from('escuela as es');
 //    $this->db->join('estadistica_e_indicadores_xcct as est', 'es.id_cct = est.id_cct');
 //    $this->db->join('municipio as mu', 'es.id_municipio = mu.id_municipio');
 //    $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
 //    $this->db->join('modalidad as mo', 'es.id_modalidad = mo.id_modalidad');
 //    $this->db->join('subsostenimiento as sso', 'es.id_subsostenimiento = sso.id_subsostenimiento');
 //    $this->db->join('sostenimiento as so', 'sso.id_sostenimiento = so.id_sostenimiento');
 //    $this->db->join('ciclo as ci', 'est.id_ciclo = ci.id_ciclo','left');
 //    if($id_municipio>0){
 //      $this->db->where('mu.id_municipio', $id_municipio);
 //    }
 //    if($id_ciclo>0){
 //      $this->db->where($where_aux);
 //    }
 //    $this->db->where('ni.id_nivel <',8);
 //    $this->db->group_by("ni.nivel");
 //    $this->db->group_by("so.sostenimiento");
 //    $this->db->group_by("mo.modalidad");

 //    $this->db->order_by("id_nivel");
 //    $this->db->order_by("sostenimiento", "DESC");
 //    $this->db->order_by("id_modalidad", "ASC");

 //    $query3 = $this->db->get_compiled_select();
    $query3 = "SELECT 
                    CASE  
                        WHEN a.nivel LIKE '%ESPECIAL%' THEN '1'
                        WHEN a.nivel LIKE '%INICIAL%' THEN '2'
                        WHEN a.nivel LIKE '%PREESCOLAR%' THEN '3'
                        WHEN a.nivel LIKE '%PRIMARIA%' THEN '4'
                        WHEN a.nivel LIKE '%SECUNDARIA%' THEN '5'
                        WHEN a.nivel LIKE '%MEDIA SUPERIOR%' THEN '6'
                        WHEN a.nivel LIKE '%SUPERIOR%' THEN '7'
                        END AS id_nivel,a.nivel,id_sostenimiento,sostenimiento
                    ,id_modalidad,modalidad,nescuelas,grupos_1,grupos_2,
                    grupos_3,grupos_4,grupos_5,grupos_6,grupos_multi,grupos_t 
                FROM (
                    SELECT v.nivel_educativo,
                        CASE  
                        WHEN v.desc_nivel_educativo LIKE '%CAM%' THEN 'ESPECIAL'
                        WHEN v.desc_nivel_educativo LIKE '%INICIAL%' THEN 'INICIAL'
                        WHEN v.desc_nivel_educativo LIKE '%PREESCOLAR%' THEN 'PREESCOLAR'
                        WHEN v.desc_nivel_educativo LIKE '%PRIMARIA%' THEN 'PRIMARIA'
                        WHEN v.desc_nivel_educativo LIKE '%SECUNDARIA%' THEN 'SECUNDARIA'
                        WHEN v.desc_nivel_educativo LIKE '%MEDIA SUPERIOR%' THEN 'MEDIA SUPERIOR'
                        WHEN v.desc_nivel_educativo LIKE '%SUPERIOR%' THEN 'SUPERIOR'
                        END AS nivel,
                        (SELECT CASE  
                            WHEN v.sostenimiento IN  ('51') THEN '3' 
                            WHEN v.sostenimiento IN ('61','41','92','96') THEN '2'
                            ELSE '1'
                        END) AS id_sostenimiento,
                        (SELECT CASE  
                            WHEN v.sostenimiento IN  ('51') THEN 'AUTONOMO' 
                            WHEN v.sostenimiento IN ('61','41','92','96') THEN 'PRIVADO'
                            ELSE 'PUBLICO'
                        END) AS sostenimiento,
                        v.servicio AS id_modalidad,v.desc_servicio AS modalidad,
                        COUNT(v.cct) AS nescuelas,
                        SUM(est.grupos_1) AS grupos_1,
                        SUM(est.grupos_2) grupos_2,
                        SUM(est.grupos_3) AS grupos_3,
                        SUM(est.grupos_4) AS grupos_4,
                        SUM(est.grupos_5) AS grupos_5,
                        SUM(est.grupos_6) AS grupos_6,
                        SUM(est.grupos_multi) AS grupos_multi,
                        SUM(est.grupos_t) AS grupos_t 
                    FROM vista_cct v
                    INNER JOIN estadistica_e_indicadores_xcct est ON est.cct=v.cct
                    WHERE (v.status= 1 OR v.status = 4) AND v.tipo_centro=9 
                    AND v.desc_nivel_educativo NOT IN('FORMACION PARA EL TRABAJO','OTRO NIVEL EDUCATIVO','NO APLICA')
                    {$filtro}         
                    GROUP BY (CASE  
                            WHEN v.desc_nivel_educativo LIKE '%CAM%' THEN 'ESPECIAL'
                            WHEN v.desc_nivel_educativo LIKE '%INICIAL%' THEN 'INICIAL'
                            WHEN v.desc_nivel_educativo LIKE '%PREESCOLAR%' THEN 'PREESCOLAR'
                            WHEN v.desc_nivel_educativo LIKE '%PRIMARIA%' THEN 'PRIMARIA'
                            WHEN v.desc_nivel_educativo LIKE '%SECUNDARIA%' THEN 'SECUNDARIA'
                            WHEN v.desc_nivel_educativo LIKE '%MEDIA SUPERIOR%' THEN 'MEDIA SUPERIOR'
                            WHEN v.desc_nivel_educativo LIKE '%SUPERIOR%' THEN 'SUPERIOR'
                        END),(CASE  
                                WHEN v.sostenimiento IN  ('51') THEN 'AUTONOMO' 
                                WHEN v.sostenimiento IN ('61','41','92','96') THEN 'PRIVADO'
                                ELSE 'PUBLICO'
                            END),v.desc_servicio
                ) AS a ORDER BY FIELD(nivel,'ESPECIAL','INICIAL','PREESCOLAR','PRIMARIA','SECUNDARIA','MEDIA SUPERIOR','SUPERIOR')
                ,id_sostenimiento,id_modalidad"; 
    // $this->db->query($query1 . ' UNION ALL ' . $query2. ' UNION ALL ' . $query3)->result_array();
    // $str = $this->db->last_query();
    // echo $str; die();
    return $this->db->query($query1 . ' UNION ALL ' . $query2. ' UNION ALL ' . $query3)->result_array();

  }// get_infraest_xmunciclo


  function get_infraest_xzona($nivel,$sostenimiento,$id_zona_z,$id_ciclo_z){
    // $where_aux="(ci.id_ciclo= {$id_ciclo_z} OR ci.id_ciclo IS NULL)";
    // $this->db->select('ni.id_nivel,ni.nivel, "0" as id_subsostenimiento, "total" as subsostenimiento, "0" as id_modalidad, "total" as modalidad,
    // COUNT(es.id_cct) as nescuelas,
    //   SUM(est.grupos_1) AS grupos_1,
    //   SUM(est.grupos_2) grupos_2,
    //   SUM(est.grupos_3) AS grupos_3,
    //   SUM(est.grupos_4) AS grupos_4,
    //   SUM(est.grupos_5) AS grupos_5,
    //   SUM(est.grupos_6) AS grupos_6,
    //   SUM(est.grupos_multi) AS grupos_multi,
    //   SUM(est.grupos_t) AS grupos_t');
    // $this->db->from('escuela as es');
    // $this->db->join('estadistica_e_indicadores_xcct as est', 'es.id_cct = est.id_cct');
    // $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
    // $this->db->join('subsostenimiento as sso', 'es.id_subsostenimiento = sso.id_subsostenimiento');
    // $this->db->join('supervision as su', '`es`.`id_supervision` = `su`.`id_supervision`');
    // $this->db->join('ciclo as ci', 'est.id_ciclo = ci.id_ciclo','left');
    // if($id_nivel_z>0){
    //   $this->db->where('ni.id_nivel', $id_nivel_z);
    // }
    // if($id_sostenimiento_z>0){
    //   $this->db->where('sso.id_subsostenimiento', $id_sostenimiento_z);
    // }
    // if($id_zona_z>0){
    //   $this->db->where('su.id_supervision', $id_zona_z);
    // }
    // if($id_ciclo_z>0){
    //   $this->db->where($where_aux);
    // }
    // $this->db->where('ni.id_nivel <',8);
    // $this->db->group_by("ni.nivel");

    // $query1 = $this->db->get_compiled_select();
    $filtro = "";
    $filtro_nivel_sos = "";
    if($sostenimiento=="PRIVADO"){
        $filtro_nivel_sos .= " AND sostenimiento IN ('61','41','92','96')";
    }else if($sostenimiento=="AUTONOMO"){
        $filtro_nivel_sos .= " AND sostenimiento IN  ('51')";
    }else if($sostenimiento== "PUBLICO"){
        $filtro_nivel_sos .= " AND sostenimiento NOT IN('61','41','92','96','51')";
    }

    if($nivel=="PREESCOLAR"){
        $filtro .= " AND IF(escuelas.desc_servicio LIKE '%PREESCOLAR%' AND supervisiones.tipo='FZP',TRUE,FALSE)";
        $filtro_nivel_sos .= " AND desc_nivel_educativo LIKE '%PREESCOLAR%' ";
    }else if($nivel=="PRIMARIA"){
        $filtro .= " AND IF(escuelas.desc_servicio LIKE '%PRIMARIA%' AND supervisiones.tipo='FIZ',TRUE,FALSE)";
        $filtro_nivel_sos .= " AND desc_nivel_educativo LIKE '%PRIMARIA%'";
    }else if($nivel=="SECUNDARIA"){
        $filtro .= "AND 
            IF( (escuelas.desc_servicio='SECUNDARIA GENERAL' OR escuelas.desc_servicio='SECUNDARIA COMUNITARIA'
                OR (escuelas.desc_servicio='SECUNDARIA TECNICA INDUSTRIAL' AND escuelas.desc_sostenimiento='ESTATAL') 
                OR (escuelas.desc_servicio='SECUNDARIA TECNICA INDUSTRIAL' AND escuelas.desc_sostenimiento='PARTICULAR') ) 
                AND supervisiones.tipo='FIS',TRUE,
            IF( ((escuelas.desc_servicio='SECUNDARIA TECNICA INDUSTRIAL' AND escuelas.desc_sostenimiento='FEDERAL TRANSFERIDO')
                OR (escuelas.desc_servicio='SECUNDARIA TECNICA AGROPECUARIA' AND escuelas.desc_sostenimiento='FEDERAL TRANSFERIDO')) AND supervisiones.tipo='FZT',TRUE,
            IF(escuelas.desc_servicio='TELESECUNDARIA' AND supervisiones.tipo='FTV', TRUE, FALSE ) ) )";
        $filtro_nivel_sos .= " AND desc_nivel_educativo LIKE '%SECUNDARIA%'";
    }

   $filtro_zona = "";
    if($id_zona_z!=''){
        $filtro_zona .= " AND supervisiones.cct = '{$id_zona_z}'";
    }

    $filtro_ciclo = "";
    if($id_ciclo_z>0){
        $filtro_ciclo .= " AND est.id_ciclo = {$id_ciclo_z} ";
    }

    $query1 = "SELECT CASE  
                    WHEN escuelas.nivel LIKE '%ESPECIAL%' THEN '1'
                    WHEN escuelas.nivel LIKE '%INICIAL%' THEN '2'
                    WHEN escuelas.nivel LIKE '%PREESCOLAR%' THEN '3'
                    WHEN escuelas.nivel LIKE '%PRIMARIA%' THEN '4'
                    WHEN escuelas.nivel LIKE '%SECUNDARIA%' THEN '5'
                    WHEN escuelas.nivel LIKE '%MEDIA SUPERIOR%' THEN '6'
                    WHEN escuelas.nivel LIKE '%SUPERIOR%' THEN '7'
                END AS id_nivel,escuelas.nivel,'0' as id_sostenimiento, 'total' as sostenimiento, '0' as id_modalidad, 'total' as modalidad,
                COUNT(escuelas.cct) as nescuelas,
                SUM(est.grupos_1) AS grupos_1,
                SUM(est.grupos_2) grupos_2,
                SUM(est.grupos_3) AS grupos_3,
                SUM(est.grupos_4) AS grupos_4,
                SUM(est.grupos_5) AS grupos_5,
                SUM(est.grupos_6) AS grupos_6,
                SUM(est.grupos_multi) AS grupos_multi,
                SUM(est.grupos_t) AS grupos_t
            FROM (SELECT cct, turno, sostenimiento, zona_escolar, desc_nivel_educativo,
                    desc_servicio,desc_sostenimiento,nivel_educativo,
                    CASE 
                        WHEN desc_nivel_educativo LIKE '%CAM%' THEN 'ESPECIAL'
                        WHEN desc_nivel_educativo LIKE '%INICIAL%' THEN 'INICIAL'
                        WHEN desc_nivel_educativo LIKE '%PREESCOLAR%' THEN 'PREESCOLAR'
                        WHEN desc_nivel_educativo LIKE '%PRIMARIA%' THEN 'PRIMARIA'
                        WHEN desc_nivel_educativo LIKE '%SECUNDARIA%' THEN 'SECUNDARIA'
                        WHEN desc_nivel_educativo LIKE '%MEDIA SUPERIOR%' THEN 'MEDIA SUPERIOR'
                        WHEN desc_nivel_educativo LIKE '%SUPERIOR%' THEN 'SUPERIOR'
                    END AS nivel
                FROM vista_cct 
                WHERE (`status` = 1 OR `status` = 4) AND tipo_centro = 9 
                {$filtro_nivel_sos}
            ) AS escuelas
            INNER JOIN estadistica_e_indicadores_xcct AS est ON est.cct=escuelas.cct
            {$filtro_ciclo}
            INNER JOIN (SELECT cct, zona_escolar, sostenimiento, desc_nivel_educativo, 
                            SUBSTRING(cct, 3, 3) AS tipo
                        FROM vista_cct cct
                        WHERE (`status` = 1 OR `status` = 4) AND tipo_centro = 1
            ) AS supervisiones ON escuelas.zona_escolar = supervisiones.zona_escolar
            AND escuelas.sostenimiento = supervisiones.sostenimiento
            {$filtro} {$filtro_zona}   
            GROUP BY CASE   
                WHEN escuelas.desc_nivel_educativo LIKE '%CAM%' THEN 'ESPECIAL'
                WHEN escuelas.desc_nivel_educativo LIKE '%INICIAL%' THEN 'INICIAL'
                WHEN escuelas.desc_nivel_educativo LIKE '%PREESCOLAR%' THEN 'PREESCOLAR'
                WHEN escuelas.desc_nivel_educativo LIKE '%PRIMARIA%' THEN 'PRIMARIA'
                WHEN escuelas.desc_nivel_educativo LIKE '%SECUNDARIA%' THEN 'SECUNDARIA'
                WHEN escuelas.desc_nivel_educativo LIKE '%MEDIA SUPERIOR%' THEN 'MEDIA SUPERIOR'
                WHEN escuelas.desc_nivel_educativo LIKE '%SUPERIOR%' THEN 'SUPERIOR'
            END ";

  //   $this->db->select('ni.id_nivel,ni.nivel, sso.id_subsostenimiento, sso.subsostenimiento, "0" as id_modalidad, "total" as modalidad,
  //   COUNT(es.id_cct) as nescuelas,
  // SUM(est.grupos_1) AS grupos_1,
  // SUM(est.grupos_2) grupos_2,
  // SUM(est.grupos_3) AS grupos_3,
  // SUM(est.grupos_4) AS grupos_4,
  // SUM(est.grupos_5) AS grupos_5,
  // SUM(est.grupos_6) AS grupos_6,
  // SUM(est.grupos_multi) AS grupos_multi,
  // SUM(est.grupos_t) AS grupos_t');
  //   $this->db->from('escuela as es');
  //   $this->db->join('estadistica_e_indicadores_xcct as est', 'es.id_cct = est.id_cct');
  //   $this->db->join('municipio as mu', 'es.id_municipio = mu.id_municipio');
  //   $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
  //   $this->db->join('modalidad as mo', 'es.id_modalidad = mo.id_modalidad');
  //   $this->db->join('subsostenimiento as sso', 'es.id_subsostenimiento = sso.id_subsostenimiento');
  //   $this->db->join('sostenimiento as so', 'sso.id_sostenimiento = so.id_sostenimiento');
  //   $this->db->join('supervision as su', '`es`.`id_supervision` = `su`.`id_supervision`');
  //   $this->db->join('ciclo as ci', 'est.id_ciclo = ci.id_ciclo','left');
  //   if($id_nivel_z>0){
  //     $this->db->where('ni.id_nivel', $id_nivel_z);
  //   }
  //   if($id_sostenimiento_z>0){
  //     $this->db->where('sso.id_subsostenimiento', $id_sostenimiento_z);
  //   }
  //   if($id_zona_z>0){
  //     $this->db->where('su.id_supervision', $id_zona_z);
  //   }
  //   if($id_ciclo_z>0){
  //     $this->db->where($where_aux);
  //   }
  //   $this->db->where('ni.id_nivel <',8);
  //   $this->db->group_by("ni.nivel");
  //   $this->db->group_by("sso.subsostenimiento");

  //   $query2 = $this->db->get_compiled_select();
    $query2 = "SELECT CASE  
                        WHEN escuelas.nivel LIKE '%ESPECIAL%' THEN '1'
                        WHEN escuelas.nivel LIKE '%INICIAL%' THEN '2'
                        WHEN escuelas.nivel LIKE '%PREESCOLAR%' THEN '3'
                        WHEN escuelas.nivel LIKE '%PRIMARIA%' THEN '4'
                        WHEN escuelas.nivel LIKE '%SECUNDARIA%' THEN '5'
                        WHEN escuelas.nivel LIKE '%MEDIA SUPERIOR%' THEN '6'
                        WHEN escuelas.nivel LIKE '%SUPERIOR%' THEN '7'
                    END AS id_nivel,escuelas.nivel,
                    (SELECT CASE  
                        WHEN escuelas.sostenimiento IN  ('51') THEN '3'
                        WHEN escuelas.sostenimiento IN ('61','41','92','96') THEN '2'
                        ELSE '1'
                    END) AS id_sostenimiento,
                    (SELECT CASE  
                        WHEN escuelas.sostenimiento IN  ('51') THEN 'AUTONOMO'
                        WHEN escuelas.sostenimiento IN ('61','41','92','96') THEN 'PRIVADO'
                        ELSE 'PUBLICO'
                    END)  as sostenimiento
                    , '0' AS id_modalidad, 'total' AS modalidad,
                    COUNT(escuelas.cct) as nescuelas,
                    SUM(est.grupos_1) AS grupos_1,
                    SUM(est.grupos_2) grupos_2,
                    SUM(est.grupos_3) AS grupos_3,
                    SUM(est.grupos_4) AS grupos_4,
                    SUM(est.grupos_5) AS grupos_5,
                    SUM(est.grupos_6) AS grupos_6,
                    SUM(est.grupos_multi) AS grupos_multi,
                    SUM(est.grupos_t) AS grupos_t
            FROM (SELECT cct, turno, sostenimiento, zona_escolar, desc_nivel_educativo,
                    desc_servicio, desc_sostenimiento,nivel_educativo,
                    CASE 
                        WHEN desc_nivel_educativo LIKE '%CAM%' THEN 'ESPECIAL'
                        WHEN desc_nivel_educativo LIKE '%INICIAL%' THEN 'INICIAL'
                        WHEN desc_nivel_educativo LIKE '%PREESCOLAR%' THEN 'PREESCOLAR'
                        WHEN desc_nivel_educativo LIKE '%PRIMARIA%' THEN 'PRIMARIA'
                        WHEN desc_nivel_educativo LIKE '%SECUNDARIA%' THEN 'SECUNDARIA'
                        WHEN desc_nivel_educativo LIKE '%MEDIA SUPERIOR%' THEN 'MEDIA SUPERIOR'
                        WHEN desc_nivel_educativo LIKE '%SUPERIOR%' THEN 'SUPERIOR'
                    END AS nivel
                FROM vista_cct 
                WHERE (status = 1 OR status = 4) AND tipo_centro = 9  
                {$filtro_nivel_sos}
            ) AS escuelas
            INNER JOIN estadistica_e_indicadores_xcct AS est ON est.cct=escuelas.cct
            {$filtro_ciclo}
            INNER JOIN (SELECT cct, zona_escolar,sostenimiento,desc_nivel_educativo,SUBSTRING(cct, 3, 3) AS tipo
                        FROM vista_cct cct
                        WHERE (status = 1 OR status = 4) AND tipo_centro = 1) AS supervisiones 
                        ON escuelas.zona_escolar = supervisiones.zona_escolar
                        AND escuelas.sostenimiento = supervisiones.sostenimiento
            {$filtro} {$filtro_zona}
            GROUP BY (CASE   
                        WHEN escuelas.desc_nivel_educativo LIKE '%CAM%' THEN 'ESPECIAL'
                        WHEN escuelas.desc_nivel_educativo LIKE '%INICIAL%' THEN 'INICIAL'
                        WHEN escuelas.desc_nivel_educativo LIKE '%PREESCOLAR%' THEN 'PREESCOLAR'
                        WHEN escuelas.desc_nivel_educativo LIKE '%PRIMARIA%' THEN 'PRIMARIA'
                        WHEN escuelas.desc_nivel_educativo LIKE '%SECUNDARIA%' THEN 'SECUNDARIA'
                        WHEN escuelas.desc_nivel_educativo LIKE '%MEDIA SUPERIOR%' THEN 'MEDIA SUPERIOR'
                        WHEN escuelas.desc_nivel_educativo LIKE '%SUPERIOR%' THEN 'SUPERIOR'
                    END),
                    (CASE  
                        WHEN escuelas.sostenimiento IN  ('51') THEN 'AUTONOMO'
                        WHEN escuelas.sostenimiento IN ('61','41','92','96') THEN 'PRIVADO'
                        ELSE 'PUBLICO'
                    END)";
  //   $this->db->select('ni.id_nivel,ni.nivel, sso.id_subsostenimiento, sso.subsostenimiento, mo.id_modalidad, mo.modalidad,
  //   COUNT(es.id_cct) as nescuelas,
  // SUM(est.grupos_1) AS grupos_1,
  // SUM(est.grupos_2) grupos_2,
  // SUM(est.grupos_3) AS grupos_3,
  // SUM(est.grupos_4) AS grupos_4,
  // SUM(est.grupos_5) AS grupos_5,
  // SUM(est.grupos_6) AS grupos_6,
  // SUM(est.grupos_multi) AS grupos_multi,
  // SUM(est.grupos_t) AS grupos_t');
  //   $this->db->from('escuela as es');
  //   $this->db->join('estadistica_e_indicadores_xcct as est', 'es.id_cct = est.id_cct');
  //   $this->db->join('municipio as mu', 'es.id_municipio = mu.id_municipio');
  //   $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
  //   $this->db->join('modalidad as mo', 'es.id_modalidad = mo.id_modalidad');
  //   $this->db->join('subsostenimiento as sso', 'es.id_subsostenimiento = sso.id_subsostenimiento');
  //   $this->db->join('sostenimiento as so', 'sso.id_sostenimiento = so.id_sostenimiento');
  //   $this->db->join('supervision as su', '`es`.`id_supervision` = `su`.`id_supervision`');
  //   $this->db->join('ciclo as ci', 'est.id_ciclo = ci.id_ciclo','left');
  //   if($id_nivel_z>0){
  //     $this->db->where('ni.id_nivel', $id_nivel_z);
  //   }
  //   if($id_sostenimiento_z>0){
  //     $this->db->where('sso.id_subsostenimiento', $id_sostenimiento_z);
  //   }
  //   if($id_zona_z>0){
  //     $this->db->where('su.id_supervision', $id_zona_z);
  //   }
  //   if($id_ciclo_z>0){
  //     $this->db->where($where_aux);
  //   }
  //   $this->db->where('ni.id_nivel <',8);
  //   $this->db->group_by("ni.nivel");
  //   $this->db->group_by("sso.subsostenimiento");
  //   $this->db->group_by("mo.modalidad");

  //   $this->db->order_by("id_nivel");
  //   $this->db->order_by("subsostenimiento", "DESC");
  //   $this->db->order_by("id_modalidad", "ASC");

    // $query3 = $this->db->get_compiled_select();
    // $this->db->query($query1 . ' UNION ALL ' . $query2. ' UNION ALL ' . $query3)->result_array();
    // $str = $this->db->last_query();
    // echo $str; die();
    $query3 = "SELECT CASE  
                        WHEN escuelas.nivel LIKE '%ESPECIAL%' THEN '1'
                        WHEN escuelas.nivel LIKE '%INICIAL%' THEN '2'
                        WHEN escuelas.nivel LIKE '%PREESCOLAR%' THEN '3'
                        WHEN escuelas.nivel LIKE '%PRIMARIA%' THEN '4'
                        WHEN escuelas.nivel LIKE '%SECUNDARIA%' THEN '5'
                        WHEN escuelas.nivel LIKE '%MEDIA SUPERIOR%' THEN '6'
                        WHEN escuelas.nivel LIKE '%SUPERIOR%' THEN '7'
                    END AS id_nivel,escuelas.nivel,
                    (SELECT CASE  
                        WHEN escuelas.sostenimiento IN  ('51') THEN '3'
                        WHEN escuelas.sostenimiento IN ('61','41','92','96') THEN '2'
                        ELSE '1'
                    END) AS id_sostenimiento,
                    (SELECT CASE  
                        WHEN escuelas.sostenimiento IN  ('51') THEN 'AUTONOMO'
                        WHEN escuelas.sostenimiento IN ('61','41','92','96') THEN 'PRIVADO'
                        ELSE 'PUBLICO'
                    END)  as sostenimiento
                    , escuelas.servicio AS id_modalidad, escuelas.desc_servicio AS modalidad,
                    COUNT(escuelas.cct) as nescuelas,
                    SUM(est.grupos_1) AS grupos_1,
                    SUM(est.grupos_2) grupos_2,
                    SUM(est.grupos_3) AS grupos_3,
                    SUM(est.grupos_4) AS grupos_4,
                    SUM(est.grupos_5) AS grupos_5,
                    SUM(est.grupos_6) AS grupos_6,
                    SUM(est.grupos_multi) AS grupos_multi,
                    SUM(est.grupos_t) AS grupos_t
            FROM (SELECT cct, turno, sostenimiento,servicio, zona_escolar, desc_nivel_educativo,
                    desc_servicio, desc_sostenimiento,nivel_educativo,
                    CASE 
                        WHEN desc_nivel_educativo LIKE '%CAM%' THEN 'ESPECIAL'
                        WHEN desc_nivel_educativo LIKE '%INICIAL%' THEN 'INICIAL'
                        WHEN desc_nivel_educativo LIKE '%PREESCOLAR%' THEN 'PREESCOLAR'
                        WHEN desc_nivel_educativo LIKE '%PRIMARIA%' THEN 'PRIMARIA'
                        WHEN desc_nivel_educativo LIKE '%SECUNDARIA%' THEN 'SECUNDARIA'
                        WHEN desc_nivel_educativo LIKE '%MEDIA SUPERIOR%' THEN 'MEDIA SUPERIOR'
                        WHEN desc_nivel_educativo LIKE '%SUPERIOR%' THEN 'SUPERIOR'
                    END AS nivel
                FROM vista_cct 
                WHERE (status = 1 OR status = 4) AND tipo_centro = 9  
                {$filtro_nivel_sos}
            ) AS escuelas
            INNER JOIN estadistica_e_indicadores_xcct AS est ON est.cct=escuelas.cct
            {$filtro_ciclo}
            INNER JOIN (SELECT cct, zona_escolar,sostenimiento,desc_nivel_educativo,SUBSTRING(cct, 3, 3) AS tipo
                        FROM vista_cct cct
                        WHERE (status = 1 OR status = 4) AND tipo_centro = 1) AS supervisiones 
                        ON escuelas.zona_escolar = supervisiones.zona_escolar
                        AND escuelas.sostenimiento = supervisiones.sostenimiento
            {$filtro} {$filtro_zona}
            GROUP BY (CASE   
                        WHEN escuelas.desc_nivel_educativo LIKE '%CAM%' THEN 'ESPECIAL'
                        WHEN escuelas.desc_nivel_educativo LIKE '%INICIAL%' THEN 'INICIAL'
                        WHEN escuelas.desc_nivel_educativo LIKE '%PREESCOLAR%' THEN 'PREESCOLAR'
                        WHEN escuelas.desc_nivel_educativo LIKE '%PRIMARIA%' THEN 'PRIMARIA'
                        WHEN escuelas.desc_nivel_educativo LIKE '%SECUNDARIA%' THEN 'SECUNDARIA'
                        WHEN escuelas.desc_nivel_educativo LIKE '%MEDIA SUPERIOR%' THEN 'MEDIA SUPERIOR'
                        WHEN escuelas.desc_nivel_educativo LIKE '%SUPERIOR%' THEN 'SUPERIOR'
                    END),
                    (CASE  
                        WHEN escuelas.sostenimiento IN  ('51') THEN 'AUTONOMO'
                        WHEN escuelas.sostenimiento IN ('61','41','92','96') THEN 'PRIVADO'
                        ELSE 'PUBLICO'
                    END),escuelas.servicio";
    // echo $query1 . ' UNION ALL ' . $query2. ' UNION ALL ' . $query3;
    // die();
    return $this->db->query($query1 . ' UNION ALL ' . $query2. ' UNION ALL ' . $query3)->result_array();

  }// get_infraest_xzona

  function get_nalumnos_xesc($cct,$id_turno_single){
    $this->db->select('alumn_t_1,alumn_t_2,alumn_t_3,alumn_t_4,alumn_t_5,alumn_t_6,alumn_t_t');
    $this->db->from('estadistica_e_indicadores_xcct');
    $this->db->where('cct', $cct);
    $this->db->where('id_turno_single', $id_turno_single);
    $this->db->where('id_corte', 2);
    $this->db->where('id_ciclo', 4);
    // $this->db->get();
    // $str = $this->db->last_query();
    // echo $str; die();
    return  $this->db->get()->result_array();
  }//get_nalumnos_xesc()


  function get_ndocentes_xesc($cct,$id_turno_single){
    $this->db->select('docentes_1_g,docentes_2_g,docentes_3_g,docentes_4_g,docentes_5_g,docentes_6_g');
    $this->db->from('estadistica_e_indicadores_xcct');
    $this->db->where('cct', $cct);
    $this->db->where('id_turno_single', $id_turno_single);
    $this->db->where('id_corte', 2);
    $this->db->where('id_ciclo', 4);
    // $this->db->get();
    // $str = $this->db->last_query();
    // echo $str; die();
    return  $this->db->get()->result_array();
  }//get_ndocentes_xesc()

  function get_ngrupos_xesc($cct,$id_turno_single){
    $this->db->select('grupos_1,grupos_2,grupos_3,grupos_4,grupos_5,grupos_6');
    $this->db->from('estadistica_e_indicadores_xcct');
    $this->db->where('cct', $cct);
    $this->db->where('id_turno_single', $id_turno_single);
    $this->db->where('id_corte', 2);
    $this->db->where('id_ciclo', 4);
    // $this->db->get();
    // $str = $this->db->last_query();
    // echo $str; die();
    return  $this->db->get()->result_array();
  }//get_ngrupos_xesc()

  function get_ind_asistenciaxcct($cct,$id_turno_single,$id_corte,$id_ciclo){
    $this->db->select('REPLACE(cobertura,"%","") as cobertura, REPLACE(absorcion,"%","") as absorcion');
    $this->db->from('indicadores_x_esc');
    $this->db->where('cct', $cct);
    $this->db->where('id_turno_single', $id_turno_single);
    $this->db->where('id_ciclo', $id_ciclo);
    $this->db->where('id_corte', $id_corte);
    return  $this->db->get()->result_array();
  }// get_ind_asistenciaxcct

  function get_ind_permananciaxcct($cct,$id_turno_single,$id_corte,$id_ciclo){
    // echo $turno;
    // die();
    $this->db->select('REPLACE(retencion,"%","") as retencion,REPLACE(aprobacion,"%","") as aprobacion, IF(REPLACE(et, "%", "")>100, 100,REPLACE(et, "%", "")) as et');
    $this->db->from('indicadores_x_esc');
    $this->db->where('cct', $cct);
    $this->db->where('id_turno_single', $id_turno_single);
    $this->db->where('id_ciclo', $id_ciclo);
    $this->db->where('id_corte', $id_corte);
    //
    // $this->db->get();
    // $str = $this->db->last_query();
    // echo $str; die();
    return  $this->db->get()->result_array();
  }// get_ind_asistenciaxcct

  function get_ind_efixcct($cct,$id_turno_single,$id_corte,$id_ciclo){

    $this->db->select('IF(REPLACE(et, "%", "")>100, 100,REPLACE(et, "%", "")) as et');
    $this->db->from('indicadores_x_esc');
    $this->db->where('cct', $cct);
    $this->db->where('id_turno_single', $id_turno_single);
    $this->db->where('id_ciclo', $id_ciclo);
    $this->db->where('id_corte', $id_corte);
    // $this->db->get();
    // $str = $this->db->last_query();
    // echo $str; die();
    return  $this->db->get()->result_array();
  }// get_ind_efixcct



}
