<?php

class Estadistica_e_indicadores_xcct_model extends CI_Model
{

  function __construct()
  {
    parent::__construct();
  }

  function get_nalumnos_xmunciclo($id_municipio, $id_ciclo){
    $this->db->select('ni.id_nivel,ni.nivel, "0" as id_sostenimiento, "total" as sostenimiento, "0" as id_modalidad, "total" as modalidad,
    SUM(est.alumn_m_t) as alumn_m_t, SUM(est.alumn_h_t) as alumn_h_t, SUM(est.alumn_t_t) as alumn_t_t,
    SUM(est.alumn_t_1) as alumn_t_1, SUM(est.alumn_t_2) as alumn_t_2, SUM(est.alumn_t_3) as alumn_t_3,
    SUM(est.alumn_t_4) as alumn_t_4, SUM(est.alumn_t_5) as alumn_t_5, SUM(est.alumn_t_6) as alumn_t_6');
    $this->db->from('escuela as es');
    $this->db->join('estadistica_e_indicadores_xcct as est', 'es.id_cct = est.id_cct');
    $this->db->join('municipio as mu', 'es.id_municipio = mu.id_municipio');
    $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
    $this->db->join('ciclo as ci', 'est.id_ciclo = ci.id_ciclo');
    if($id_municipio>0){
      $this->db->where('mu.id_municipio', $id_municipio);
    }
    if($id_ciclo>0){
      $this->db->where('ci.id_ciclo', $id_ciclo);
    }
    $this->db->where('ni.id_nivel <',8);
    $this->db->group_by("ni.nivel");

    $query1 = $this->db->get_compiled_select();

    $this->db->select('ni.id_nivel,ni.nivel, so.id_sostenimiento, so.sostenimiento, "0" as id_modalidad, "total" as modalidad,
    SUM(est.alumn_m_t) as alumn_m_t, SUM(est.alumn_h_t) as alumn_h_t, SUM(est.alumn_t_t) as alumn_t_t,
    SUM(est.alumn_t_1) as alumn_t_1, SUM(est.alumn_t_2) as alumn_t_2, SUM(est.alumn_t_3) as alumn_t_3,
    SUM(est.alumn_t_4) as alumn_t_4, SUM(est.alumn_t_5) as alumn_t_5, SUM(est.alumn_t_6) as alumn_t_6');
    $this->db->from('escuela as es');
    $this->db->join('estadistica_e_indicadores_xcct as est', 'es.id_cct = est.id_cct');
    $this->db->join('municipio as mu', 'es.id_municipio = mu.id_municipio');
    $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
    $this->db->join('modalidad as mo', 'es.id_modalidad = mo.id_modalidad');
    $this->db->join('subsostenimiento as sso', 'es.id_subsostenimiento = sso.id_subsostenimiento');
    $this->db->join('sostenimiento as so', 'sso.id_sostenimiento = so.id_sostenimiento');
    $this->db->join('ciclo as ci', 'est.id_ciclo = ci.id_ciclo');
    if($id_municipio>0){
      $this->db->where('mu.id_municipio', $id_municipio);
    }
    if($id_ciclo>0){
      $this->db->where('ci.id_ciclo', $id_ciclo);
    }
    $this->db->where('ni.id_nivel <', 8);
    $this->db->group_by("ni.nivel");
    $this->db->group_by("so.sostenimiento");

    $query2 = $this->db->get_compiled_select();

    $this->db->select('ni.id_nivel,ni.nivel, so.id_sostenimiento, so.sostenimiento, mo.id_modalidad, mo.modalidad,
    SUM(est.alumn_m_t) as alumn_m_t, SUM(est.alumn_h_t) as alumn_h_t, SUM(est.alumn_t_t) as alumn_t_t,
    SUM(est.alumn_t_1) as alumn_t_1, SUM(est.alumn_t_2) as alumn_t_2, SUM(est.alumn_t_3) as alumn_t_3,
    SUM(est.alumn_t_4) as alumn_t_4, SUM(est.alumn_t_5) as alumn_t_5, SUM(est.alumn_t_6) as alumn_t_6');
    $this->db->from('escuela as es');
    $this->db->join('estadistica_e_indicadores_xcct as est', 'es.id_cct = est.id_cct');
    $this->db->join('municipio as mu', 'es.id_municipio = mu.id_municipio');
    $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
    $this->db->join('modalidad as mo', 'es.id_modalidad = mo.id_modalidad');
    $this->db->join('subsostenimiento as sso', 'es.id_subsostenimiento = sso.id_subsostenimiento');
    $this->db->join('sostenimiento as so', 'sso.id_sostenimiento = so.id_sostenimiento');
    $this->db->join('ciclo as ci', 'est.id_ciclo = ci.id_ciclo');
    if($id_municipio>0){
      $this->db->where('mu.id_municipio', $id_municipio);
    }
    if($id_ciclo>0){
      $this->db->where('ci.id_ciclo', $id_ciclo);
    }
    $this->db->where('ni.id_nivel <', 8);
    $this->db->group_by("ni.nivel");
    $this->db->group_by("so.sostenimiento");
    $this->db->group_by("mo.modalidad");

    $this->db->order_by("id_nivel");
    $this->db->order_by("sostenimiento", "DESC");
    $this->db->order_by("id_modalidad", "ASC");

    $query3 = $this->db->get_compiled_select();
    //
    // $this->db->query($query1 . ' UNION ALL ' . $query2. ' UNION ALL ' . $query3)->result_array();
    // $str = $this->db->last_query();
    // echo $str; die();


    return $this->db->query($query1 . ' UNION ALL ' . $query2. ' UNION ALL ' . $query3)->result_array();

  }// get_nalumnos_xmunciclo()



  function get_nalumnos_xzona($id_nivel_z,$id_sostenimiento_z,$id_zona_z,$id_ciclo_z){
    $this->db->select('ni.id_nivel,ni.nivel, "0" as id_subsostenimiento, "total" as subsostenimiento, "0" as id_modalidad, "total" as modalidad,
    SUM(est.alumn_m_t) as alumn_m_t, SUM(est.alumn_h_t) as alumn_h_t, SUM(est.alumn_t_t) as alumn_t_t,
    SUM(est.alumn_t_1) as alumn_t_1, SUM(est.alumn_t_2) as alumn_t_2, SUM(est.alumn_t_3) as alumn_t_3,
    SUM(est.alumn_t_4) as alumn_t_4, SUM(est.alumn_t_5) as alumn_t_5, SUM(est.alumn_t_6) as alumn_t_6');
    $this->db->from('escuela as es');
    $this->db->join('estadistica_e_indicadores_xcct as est', 'es.id_cct = est.id_cct');
    $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
    $this->db->join('subsostenimiento as sso', '`es`.`id_subsostenimiento` = `sso`.`id_subsostenimiento`');
    $this->db->join('supervision as su', '`es`.`id_supervision` = `su`.`id_supervision`');
    $this->db->join('ciclo as ci', 'est.id_ciclo = ci.id_ciclo');
    if($id_nivel_z>0){
      $this->db->where('ni.id_nivel', $id_nivel_z);
    }
    if($id_sostenimiento_z>0){
      $this->db->where('sso.id_subsostenimiento', $id_sostenimiento_z);
    }
    if($id_zona_z>0){
      $this->db->where('su.id_supervision', $id_zona_z);
    }
    if($id_ciclo_z>0){
      $this->db->where('ci.id_ciclo', $id_ciclo_z);
    }
    $this->db->where('ni.id_nivel <',8);
    $this->db->group_by("ni.nivel");

    $query1 = $this->db->get_compiled_select();

    $this->db->select('ni.id_nivel,ni.nivel, sso.id_subsostenimiento, sso.subsostenimiento, "0" as id_modalidad, "total" as modalidad,
    SUM(est.alumn_m_t) as alumn_m_t, SUM(est.alumn_h_t) as alumn_h_t, SUM(est.alumn_t_t) as alumn_t_t,
    SUM(est.alumn_t_1) as alumn_t_1, SUM(est.alumn_t_2) as alumn_t_2, SUM(est.alumn_t_3) as alumn_t_3,
    SUM(est.alumn_t_4) as alumn_t_4, SUM(est.alumn_t_5) as alumn_t_5, SUM(est.alumn_t_6) as alumn_t_6');
    $this->db->from('escuela as es');
    $this->db->join('estadistica_e_indicadores_xcct as est', 'es.id_cct = est.id_cct');
    $this->db->join('municipio as mu', 'es.id_municipio = mu.id_municipio');
    $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
    $this->db->join('modalidad as mo', 'es.id_modalidad = mo.id_modalidad');
    $this->db->join('subsostenimiento as sso', 'es.id_subsostenimiento = sso.id_subsostenimiento');
    $this->db->join('sostenimiento as so', 'sso.id_sostenimiento = so.id_sostenimiento');
    $this->db->join('supervision as su', '`es`.`id_supervision` = `su`.`id_supervision`');
    $this->db->join('ciclo as ci', 'est.id_ciclo = ci.id_ciclo');
    if($id_nivel_z>0){
      $this->db->where('ni.id_nivel', $id_nivel_z);
    }
    if($id_sostenimiento_z>0){
      $this->db->where('sso.id_subsostenimiento', $id_sostenimiento_z);
    }
    if($id_zona_z>0){
      $this->db->where('su.id_supervision', $id_zona_z);
    }
    if($id_ciclo_z>0){
      $this->db->where('ci.id_ciclo', $id_ciclo_z);
    }
    $this->db->where('ni.id_nivel <', 8);
    $this->db->group_by("ni.nivel");
    $this->db->group_by("sso.subsostenimiento");

    $query2 = $this->db->get_compiled_select();

    $this->db->select('ni.id_nivel,ni.nivel, sso.id_subsostenimiento, sso.subsostenimiento, mo.id_modalidad, mo.modalidad,
    SUM(est.alumn_m_t) as alumn_m_t, SUM(est.alumn_h_t) as alumn_h_t, SUM(est.alumn_t_t) as alumn_t_t,
    SUM(est.alumn_t_1) as alumn_t_1, SUM(est.alumn_t_2) as alumn_t_2, SUM(est.alumn_t_3) as alumn_t_3,
    SUM(est.alumn_t_4) as alumn_t_4, SUM(est.alumn_t_5) as alumn_t_5, SUM(est.alumn_t_6) as alumn_t_6');
    $this->db->from('escuela as es');
    $this->db->join('estadistica_e_indicadores_xcct as est', 'es.id_cct = est.id_cct');
    $this->db->join('municipio as mu', 'es.id_municipio = mu.id_municipio');
    $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
    $this->db->join('modalidad as mo', 'es.id_modalidad = mo.id_modalidad');
    $this->db->join('subsostenimiento as sso', 'es.id_subsostenimiento = sso.id_subsostenimiento');
    $this->db->join('sostenimiento as so', 'sso.id_sostenimiento = so.id_sostenimiento');
    $this->db->join('supervision as su', '`es`.`id_supervision` = `su`.`id_supervision`');
    $this->db->join('ciclo as ci', 'est.id_ciclo = ci.id_ciclo');
    if($id_nivel_z>0){
      $this->db->where('ni.id_nivel', $id_nivel_z);
    }
    if($id_sostenimiento_z>0){
      $this->db->where('sso.id_subsostenimiento', $id_sostenimiento_z);
    }
    if($id_zona_z>0){
      $this->db->where('su.id_supervision', $id_zona_z);
    }
    if($id_ciclo_z>0){
      $this->db->where('ci.id_ciclo', $id_ciclo_z);
    }
    $this->db->where('ni.id_nivel <', 8);
    $this->db->group_by("ni.nivel");
    $this->db->group_by("sso.subsostenimiento");
    $this->db->group_by("mo.modalidad");

    $this->db->order_by("id_nivel");
    $this->db->order_by("subsostenimiento", "DESC");
    $this->db->order_by("id_modalidad", "ASC");

    $query3 = $this->db->get_compiled_select();

    // $this->db->query($query1 . ' UNION ALL ' . $query2. ' UNION ALL ' . $query3)->result_array();
    // $str = $this->db->last_query();
    // echo $str; die();

    return $this->db->query($query1 . ' UNION ALL ' . $query2. ' UNION ALL ' . $query3)->result_array();

  }// get_nalumnos_xzona()

  function get_pdocente_xmunciclo($id_municipio, $id_ciclo){
    $this->db->select('ni.id_nivel,ni.nivel, "0" as id_sostenimiento, "total" as sostenimiento, "0" as id_modalidad, "total" as modalidad,
    IF(ni.id_nivel=5, (SUM(est.docente_m)
+SUM(est.docente_m_ef)
+SUM(est.docente_m_artis)
+SUM(est.docente_m_tecnolo)
+SUM(est.docente_m_idiomas)) ,SUM(est.docente_m)) AS docente_m,
	IF(ni.id_nivel=5, (SUM(est.docente_h)
+SUM(est.docente_h_ef)
+SUM(est.docente_h_artis)
+SUM(est.docente_h_tecnolo)
+SUM(est.docente_h_idiomas)) ,SUM(est.docente_h)) AS docente_h,
	IF(ni.id_nivel=5, (SUM(est.docentes_t_g)
+SUM(est.docente_h_ef)
+SUM(est.docente_m_ef)
+SUM(est.docente_h_artis)
+SUM(est.docente_m_artis)
+SUM(est.docente_h_tecnolo)
+SUM(est.docente_m_tecnolo)
+SUM(est.docente_h_idiomas)
+SUM(est.docente_m_idiomas)) ,SUM(est.docentes_t_g)) AS docentes_t_g,
    SUM(est.directivo_m_congrup) as directivo_m_congrup, SUM(est.directivo_h_congrup) as directivo_h_congrup, SUM(est.directivo_m_congrup)+SUM(est.directivo_h_congrup) as directivo_t_congrup,
    SUM(est.directivo_m_singrup) as directivo_m_singrup, SUM(est.directivo_h_singrup) as directivo_h_singrup, SUM(est.directivo_m_singrup)+SUM(est.directivo_h_singrup) as directivo_t_singrup');
    $this->db->from('escuela as es');
    $this->db->join('estadistica_e_indicadores_xcct as est', 'es.id_cct = est.id_cct');
    $this->db->join('municipio as mu', 'es.id_municipio = mu.id_municipio');
    $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
    $this->db->join('ciclo as ci', 'est.id_ciclo = ci.id_ciclo');
    if($id_municipio>0){
      $this->db->where('mu.id_municipio', $id_municipio);
    }
    if($id_ciclo>0){
      $this->db->where('ci.id_ciclo', $id_ciclo);
    }
    $this->db->where('ni.id_nivel <',8);
    $this->db->group_by("ni.id_nivel");

    $query1 = $this->db->get_compiled_select();

    $this->db->select('ni.id_nivel,ni.nivel, so.id_sostenimiento, so.sostenimiento, "0" as id_modalidad, "total" as modalidad,
    IF(ni.id_nivel=5, (SUM(est.docente_m)
+SUM(est.docente_m_ef)
+SUM(est.docente_m_artis)
+SUM(est.docente_m_tecnolo)
+SUM(est.docente_m_idiomas)) ,SUM(est.docente_m)) AS docente_m,
	IF(ni.id_nivel=5, (SUM(est.docente_h)
+SUM(est.docente_h_ef)
+SUM(est.docente_h_artis)
+SUM(est.docente_h_tecnolo)
+SUM(est.docente_h_idiomas)) ,SUM(est.docente_h)) AS docente_h,
	IF(ni.id_nivel=5, (SUM(est.docentes_t_g)
+SUM(est.docente_h_ef)
+SUM(est.docente_m_ef)
+SUM(est.docente_h_artis)
+SUM(est.docente_m_artis)
+SUM(est.docente_h_tecnolo)
+SUM(est.docente_m_tecnolo)
+SUM(est.docente_h_idiomas)
+SUM(est.docente_m_idiomas)) ,SUM(est.docentes_t_g)) AS docentes_t_g,
SUM(est.directivo_m_congrup) as directivo_m_congrup, SUM(est.directivo_h_congrup) as directivo_h_congrup, SUM(est.directivo_m_congrup)+SUM(est.directivo_h_congrup) as directivo_t_congrup,
SUM(est.directivo_m_singrup) as directivo_m_singrup, SUM(est.directivo_h_singrup) as directivo_h_singrup, SUM(est.directivo_m_singrup)+SUM(est.directivo_h_singrup) as directivo_t_singrup');
    $this->db->from('escuela as es');
    $this->db->join('estadistica_e_indicadores_xcct as est', 'es.id_cct = est.id_cct');
    $this->db->join('municipio as mu', 'es.id_municipio = mu.id_municipio');
    $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
    $this->db->join('modalidad as mo', 'es.id_modalidad = mo.id_modalidad');
    $this->db->join('subsostenimiento as sso', 'es.id_subsostenimiento = sso.id_subsostenimiento');
    $this->db->join('sostenimiento as so', 'sso.id_sostenimiento = so.id_sostenimiento');
    $this->db->join('ciclo as ci', 'est.id_ciclo = ci.id_ciclo');
    if($id_municipio>0){
      $this->db->where('mu.id_municipio', $id_municipio);
    }
    if($id_ciclo>0){
      $this->db->where('ci.id_ciclo', $id_ciclo);
    }
    $this->db->where('ni.id_nivel <',8);
    $this->db->group_by("ni.nivel");
    $this->db->group_by("so.sostenimiento");

    $query2 = $this->db->get_compiled_select();

    $this->db->select('ni.id_nivel,ni.nivel, so.id_sostenimiento, so.sostenimiento, mo.id_modalidad, mo.modalidad,
    IF(ni.id_nivel=5, (SUM(est.docente_m)
+SUM(est.docente_m_ef)
+SUM(est.docente_m_artis)
+SUM(est.docente_m_tecnolo)
+SUM(est.docente_m_idiomas)) ,SUM(est.docente_m)) AS docente_m,
	IF(ni.id_nivel=5, (SUM(est.docente_h)
+SUM(est.docente_h_ef)
+SUM(est.docente_h_artis)
+SUM(est.docente_h_tecnolo)
+SUM(est.docente_h_idiomas)) ,SUM(est.docente_h)) AS docente_h,
	IF(ni.id_nivel=5, (SUM(est.docentes_t_g)
+SUM(est.docente_h_ef)
+SUM(est.docente_m_ef)
+SUM(est.docente_h_artis)
+SUM(est.docente_m_artis)
+SUM(est.docente_h_tecnolo)
+SUM(est.docente_m_tecnolo)
+SUM(est.docente_h_idiomas)
+SUM(est.docente_m_idiomas)) ,SUM(est.docentes_t_g)) AS docentes_t_g,
SUM(est.directivo_m_congrup) as directivo_m_congrup, SUM(est.directivo_h_congrup) as directivo_h_congrup, SUM(est.directivo_m_congrup)+SUM(est.directivo_h_congrup) as directivo_t_congrup,
SUM(est.directivo_m_singrup) as directivo_m_singrup, SUM(est.directivo_h_singrup) as directivo_h_singrup, SUM(est.directivo_m_singrup)+SUM(est.directivo_h_singrup) as directivo_t_singrup');
    $this->db->from('escuela as es');
    $this->db->join('estadistica_e_indicadores_xcct as est', 'es.id_cct = est.id_cct');
    $this->db->join('municipio as mu', 'es.id_municipio = mu.id_municipio');
    $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
    $this->db->join('modalidad as mo', 'es.id_modalidad = mo.id_modalidad');
    $this->db->join('subsostenimiento as sso', 'es.id_subsostenimiento = sso.id_subsostenimiento');
    $this->db->join('sostenimiento as so', 'sso.id_sostenimiento = so.id_sostenimiento');
    $this->db->join('ciclo as ci', 'est.id_ciclo = ci.id_ciclo');
    if($id_municipio>0){
      $this->db->where('mu.id_municipio', $id_municipio);
    }
    if($id_ciclo>0){
      $this->db->where('ci.id_ciclo', $id_ciclo);
    }
    $this->db->where('ni.id_nivel <',8);
    $this->db->where('ni.id_nivel !=',6);
    $this->db->where('ni.id_nivel !=',7);

    $this->db->group_by("ni.id_nivel");
    $this->db->group_by("so.sostenimiento");
    $this->db->group_by("mo.modalidad");

    $this->db->order_by("id_nivel");
    $this->db->order_by("sostenimiento", "DESC");
    $this->db->order_by("id_modalidad", "ASC");

    $query3 = $this->db->get_compiled_select();
    // $this->db->query($query1 . ' UNION ALL ' . $query2. ' UNION ALL ' . $query3)->result_array();
    // $str = $this->db->last_query();
    // echo $str; die();

    return $this->db->query($query1 . ' UNION ALL ' . $query2. ' UNION ALL ' . $query3)->result_array();

  }// get_pdocente_xmunciclo()



  function get_pdocente_xzona($id_nivel_z,$id_sostenimiento_z,$id_zona_z,$id_ciclo_z){
    $this->db->select('ni.id_nivel,ni.nivel, "0" as id_subsostenimiento, "total" as subsostenimiento, "0" as id_modalidad, "total" as modalidad,
    IF(ni.id_nivel=5, (SUM(est.docente_m)
+SUM(est.docente_m_ef)
+SUM(est.docente_m_artis)
+SUM(est.docente_m_tecnolo)
+SUM(est.docente_m_idiomas)) ,SUM(est.docente_m)) AS docente_m,
	IF(ni.id_nivel=5, (SUM(est.docente_h)
+SUM(est.docente_h_ef)
+SUM(est.docente_h_artis)
+SUM(est.docente_h_tecnolo)
+SUM(est.docente_h_idiomas)) ,SUM(est.docente_h)) AS docente_h,
	IF(ni.id_nivel=5, (SUM(est.docentes_t_g)
+SUM(est.docente_h_ef)
+SUM(est.docente_m_ef)
+SUM(est.docente_h_artis)
+SUM(est.docente_m_artis)
+SUM(est.docente_h_tecnolo)
+SUM(est.docente_m_tecnolo)
+SUM(est.docente_h_idiomas)
+SUM(est.docente_m_idiomas)) ,SUM(est.docentes_t_g)) AS docentes_t_g,
    SUM(est.directivo_m_congrup) as directivo_m_congrup, SUM(est.directivo_h_congrup) as directivo_h_congrup, SUM(est.directivo_m_congrup)+SUM(est.directivo_h_congrup) as directivo_t_congrup,
    SUM(est.directivo_m_singrup) as directivo_m_singrup, SUM(est.directivo_h_singrup) as directivo_h_singrup, SUM(est.directivo_m_singrup)+SUM(est.directivo_h_singrup) as directivo_t_singrup');
    $this->db->from('escuela as es');
    $this->db->join('estadistica_e_indicadores_xcct as est', 'es.id_cct = est.id_cct');
    $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
    $this->db->join('subsostenimiento as sso', '`es`.`id_subsostenimiento` = `sso`.`id_subsostenimiento`');
    $this->db->join('supervision as su', '`es`.`id_supervision` = `su`.`id_supervision`');
    $this->db->join('ciclo as ci', 'est.id_ciclo = ci.id_ciclo');
    if($id_nivel_z>0){
      $this->db->where('ni.id_nivel', $id_nivel_z);
    }
    if($id_sostenimiento_z>0){
      $this->db->where('sso.id_subsostenimiento', $id_sostenimiento_z);
    }
    if($id_zona_z>0){
      $this->db->where('su.id_supervision', $id_zona_z);
    }
    if($id_ciclo_z>0){
      $this->db->where('ci.id_ciclo', $id_ciclo_z);
    }
    $this->db->where('ni.id_nivel <',8);
    $this->db->group_by("ni.id_nivel");

    $query1 = $this->db->get_compiled_select();

    $this->db->select('ni.id_nivel,ni.nivel, sso.id_subsostenimiento, sso.subsostenimiento, "0" as id_modalidad, "total" as modalidad,
    IF(ni.id_nivel=5, (SUM(est.docente_m)
+SUM(est.docente_m_ef)
+SUM(est.docente_m_artis)
+SUM(est.docente_m_tecnolo)
+SUM(est.docente_m_idiomas)) ,SUM(est.docente_m)) AS docente_m,
	IF(ni.id_nivel=5, (SUM(est.docente_h)
+SUM(est.docente_h_ef)
+SUM(est.docente_h_artis)
+SUM(est.docente_h_tecnolo)
+SUM(est.docente_h_idiomas)) ,SUM(est.docente_h)) AS docente_h,
	IF(ni.id_nivel=5, (SUM(est.docentes_t_g)
+SUM(est.docente_h_ef)
+SUM(est.docente_m_ef)
+SUM(est.docente_h_artis)
+SUM(est.docente_m_artis)
+SUM(est.docente_h_tecnolo)
+SUM(est.docente_m_tecnolo)
+SUM(est.docente_h_idiomas)
+SUM(est.docente_m_idiomas)) ,SUM(est.docentes_t_g)) AS docentes_t_g,
SUM(est.directivo_m_congrup) as directivo_m_congrup, SUM(est.directivo_h_congrup) as directivo_h_congrup, SUM(est.directivo_m_congrup)+SUM(est.directivo_h_congrup) as directivo_t_congrup,
SUM(est.directivo_m_singrup) as directivo_m_singrup, SUM(est.directivo_h_singrup) as directivo_h_singrup, SUM(est.directivo_m_singrup)+SUM(est.directivo_h_singrup) as directivo_t_singrup');
    $this->db->from('escuela as es');
    $this->db->join('estadistica_e_indicadores_xcct as est', 'es.id_cct = est.id_cct');
    $this->db->join('municipio as mu', 'es.id_municipio = mu.id_municipio');
    $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
    $this->db->join('modalidad as mo', 'es.id_modalidad = mo.id_modalidad');
    $this->db->join('subsostenimiento as sso', 'es.id_subsostenimiento = sso.id_subsostenimiento');
    $this->db->join('sostenimiento as so', 'sso.id_sostenimiento = so.id_sostenimiento');
    $this->db->join('supervision as su', '`es`.`id_supervision` = `su`.`id_supervision`');
    $this->db->join('ciclo as ci', 'est.id_ciclo = ci.id_ciclo');
    if($id_nivel_z>0){
      $this->db->where('ni.id_nivel', $id_nivel_z);
    }
    if($id_sostenimiento_z>0){
      $this->db->where('sso.id_subsostenimiento', $id_sostenimiento_z);
    }
    if($id_zona_z>0){
      $this->db->where('su.id_supervision', $id_zona_z);
    }
    if($id_ciclo_z>0){
      $this->db->where('ci.id_ciclo', $id_ciclo_z);
    }
    $this->db->where('ni.id_nivel <',8);
    $this->db->group_by("ni.nivel");
    $this->db->group_by("subsostenimiento");

    $query2 = $this->db->get_compiled_select();

    $this->db->select('ni.id_nivel,ni.nivel, sso.id_subsostenimiento, sso.subsostenimiento, mo.id_modalidad, mo.modalidad,
    IF(ni.id_nivel=5, (SUM(est.docente_m)
+SUM(est.docente_m_ef)
+SUM(est.docente_m_artis)
+SUM(est.docente_m_tecnolo)
+SUM(est.docente_m_idiomas)) ,SUM(est.docente_m)) AS docente_m,
	IF(ni.id_nivel=5, (SUM(est.docente_h)
+SUM(est.docente_h_ef)
+SUM(est.docente_h_artis)
+SUM(est.docente_h_tecnolo)
+SUM(est.docente_h_idiomas)) ,SUM(est.docente_h)) AS docente_h,
	IF(ni.id_nivel=5, (SUM(est.docentes_t_g)
+SUM(est.docente_h_ef)
+SUM(est.docente_m_ef)
+SUM(est.docente_h_artis)
+SUM(est.docente_m_artis)
+SUM(est.docente_h_tecnolo)
+SUM(est.docente_m_tecnolo)
+SUM(est.docente_h_idiomas)
+SUM(est.docente_m_idiomas)) ,SUM(est.docentes_t_g)) AS docentes_t_g,
SUM(est.directivo_m_congrup) as directivo_m_congrup, SUM(est.directivo_h_congrup) as directivo_h_congrup, SUM(est.directivo_m_congrup)+SUM(est.directivo_h_congrup) as directivo_t_congrup,
SUM(est.directivo_m_singrup) as directivo_m_singrup, SUM(est.directivo_h_singrup) as directivo_h_singrup, SUM(est.directivo_m_singrup)+SUM(est.directivo_h_singrup) as directivo_t_singrup');
    $this->db->from('escuela as es');
    $this->db->join('estadistica_e_indicadores_xcct as est', 'es.id_cct = est.id_cct');
    $this->db->join('municipio as mu', 'es.id_municipio = mu.id_municipio');
    $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
    $this->db->join('modalidad as mo', 'es.id_modalidad = mo.id_modalidad');
    $this->db->join('subsostenimiento as sso', 'es.id_subsostenimiento = sso.id_subsostenimiento');
    $this->db->join('sostenimiento as so', 'sso.id_sostenimiento = so.id_sostenimiento');
    $this->db->join('supervision as su', '`es`.`id_supervision` = `su`.`id_supervision`');
    $this->db->join('ciclo as ci', 'est.id_ciclo = ci.id_ciclo');
    if($id_nivel_z>0){
      $this->db->where('ni.id_nivel', $id_nivel_z);
    }
    if($id_sostenimiento_z>0){
      $this->db->where('sso.id_subsostenimiento', $id_sostenimiento_z);
    }
    if($id_zona_z>0){
      $this->db->where('su.id_supervision', $id_zona_z);
    }
    if($id_ciclo_z>0){
      $this->db->where('ci.id_ciclo', $id_ciclo_z);
    }
    $this->db->where('ni.id_nivel <',8);
    $this->db->where('ni.id_nivel !=',6);
    $this->db->where('ni.id_nivel !=',7);
    $this->db->group_by("ni.id_nivel");
    $this->db->group_by("sso.subsostenimiento");
    $this->db->group_by("mo.modalidad");

    $this->db->order_by("id_nivel");
    $this->db->order_by("subsostenimiento", "DESC");
    $this->db->order_by("id_modalidad", "ASC");

    $query3 = $this->db->get_compiled_select();


    return $this->db->query($query1 . ' UNION ALL ' . $query2. ' UNION ALL ' . $query3)->result_array();

  }// get_pdocente_xzona()

  function get_infraest_xmunciclo($id_municipio, $id_ciclo){
    $where_aux="(ci.id_ciclo= {$id_ciclo} OR ci.id_ciclo IS NULL)";
    $this->db->select('ni.id_nivel,ni.nivel, "0" as id_sostenimiento, "total" as sostenimiento, "0" as id_modalidad, "total" as modalidad,
    COUNT(es.id_cct) as nescuelas,
    	SUM(est.grupos_1) AS grupos_1,
    	SUM(est.grupos_2) grupos_2,
    	SUM(est.grupos_3) AS grupos_3,
    	SUM(est.grupos_4) AS grupos_4,
    	SUM(est.grupos_5) AS grupos_5,
    	SUM(est.grupos_6) AS grupos_6,
    	SUM(est.grupos_multi) AS grupos_multi,
    	SUM(est.grupos_t) AS grupos_t');
    $this->db->from('escuela as es');
    $this->db->join('estadistica_e_indicadores_xcct as est', 'es.id_cct = est.id_cct');
    $this->db->join('municipio as mu', 'es.id_municipio = mu.id_municipio');
    $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
    $this->db->join('ciclo as ci', 'est.id_ciclo = ci.id_ciclo','left');
    if($id_municipio>0){
      $this->db->where('mu.id_municipio', $id_municipio);
    }
    if($id_ciclo>0){
      $this->db->where($where_aux);
    }
    $this->db->where('ni.id_nivel <',8);
    $this->db->group_by("ni.nivel");

    $query1 = $this->db->get_compiled_select();

    $this->db->select('ni.id_nivel,ni.nivel, so.id_sostenimiento, so.sostenimiento, "0" as id_modalidad, "total" as modalidad,
    COUNT(es.id_cct) as nescuelas,
	SUM(est.grupos_1) AS grupos_1,
	SUM(est.grupos_2) grupos_2,
	SUM(est.grupos_3) AS grupos_3,
	SUM(est.grupos_4) AS grupos_4,
	SUM(est.grupos_5) AS grupos_5,
	SUM(est.grupos_6) AS grupos_6,
	SUM(est.grupos_multi) AS grupos_multi,
	SUM(est.grupos_t) AS grupos_t');
    $this->db->from('escuela as es');
    $this->db->join('estadistica_e_indicadores_xcct as est', 'es.id_cct = est.id_cct');
    $this->db->join('municipio as mu', 'es.id_municipio = mu.id_municipio');
    $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
    $this->db->join('modalidad as mo', 'es.id_modalidad = mo.id_modalidad');
    $this->db->join('subsostenimiento as sso', 'es.id_subsostenimiento = sso.id_subsostenimiento');
    $this->db->join('sostenimiento as so', 'sso.id_sostenimiento = so.id_sostenimiento');
    $this->db->join('ciclo as ci', 'est.id_ciclo = ci.id_ciclo','left');
    if($id_municipio>0){
      $this->db->where('mu.id_municipio', $id_municipio);
    }
    if($id_ciclo>0){
      $this->db->where($where_aux);
    }
    $this->db->where('ni.id_nivel <',8);
    $this->db->group_by("ni.nivel");
    $this->db->group_by("so.sostenimiento");

    $query2 = $this->db->get_compiled_select();

    $this->db->select('ni.id_nivel,ni.nivel, so.id_sostenimiento, so.sostenimiento, mo.id_modalidad, mo.modalidad,
    COUNT(es.id_cct) as nescuelas,
	SUM(est.grupos_1) AS grupos_1,
	SUM(est.grupos_2) grupos_2,
	SUM(est.grupos_3) AS grupos_3,
	SUM(est.grupos_4) AS grupos_4,
	SUM(est.grupos_5) AS grupos_5,
	SUM(est.grupos_6) AS grupos_6,
	SUM(est.grupos_multi) AS grupos_multi,
	SUM(est.grupos_t) AS grupos_t');
    $this->db->from('escuela as es');
    $this->db->join('estadistica_e_indicadores_xcct as est', 'es.id_cct = est.id_cct');
    $this->db->join('municipio as mu', 'es.id_municipio = mu.id_municipio');
    $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
    $this->db->join('modalidad as mo', 'es.id_modalidad = mo.id_modalidad');
    $this->db->join('subsostenimiento as sso', 'es.id_subsostenimiento = sso.id_subsostenimiento');
    $this->db->join('sostenimiento as so', 'sso.id_sostenimiento = so.id_sostenimiento');
    $this->db->join('ciclo as ci', 'est.id_ciclo = ci.id_ciclo','left');
    if($id_municipio>0){
      $this->db->where('mu.id_municipio', $id_municipio);
    }
    if($id_ciclo>0){
      $this->db->where($where_aux);
    }
    $this->db->where('ni.id_nivel <',8);
    $this->db->group_by("ni.nivel");
    $this->db->group_by("so.sostenimiento");
    $this->db->group_by("mo.modalidad");

    $this->db->order_by("id_nivel");
    $this->db->order_by("sostenimiento", "DESC");
    $this->db->order_by("id_modalidad", "ASC");

    $query3 = $this->db->get_compiled_select();
    // $this->db->query($query1 . ' UNION ALL ' . $query2. ' UNION ALL ' . $query3)->result_array();
    // $str = $this->db->last_query();
    // echo $str; die();
    return $this->db->query($query1 . ' UNION ALL ' . $query2. ' UNION ALL ' . $query3)->result_array();

  }// get_infraest_xmunciclo


  function get_infraest_xzona($id_nivel_z,$id_sostenimiento_z,$id_zona_z,$id_ciclo_z){
    $where_aux="(ci.id_ciclo= {$id_ciclo_z} OR ci.id_ciclo IS NULL)";
    $this->db->select('ni.id_nivel,ni.nivel, "0" as id_subsostenimiento, "total" as subsostenimiento, "0" as id_modalidad, "total" as modalidad,
    COUNT(es.id_cct) as nescuelas,
      SUM(est.grupos_1) AS grupos_1,
      SUM(est.grupos_2) grupos_2,
      SUM(est.grupos_3) AS grupos_3,
      SUM(est.grupos_4) AS grupos_4,
      SUM(est.grupos_5) AS grupos_5,
      SUM(est.grupos_6) AS grupos_6,
      SUM(est.grupos_multi) AS grupos_multi,
      SUM(est.grupos_t) AS grupos_t');
    $this->db->from('escuela as es');
    $this->db->join('estadistica_e_indicadores_xcct as est', 'es.id_cct = est.id_cct');
    $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
    $this->db->join('subsostenimiento as sso', 'es.id_subsostenimiento = sso.id_subsostenimiento');
    $this->db->join('supervision as su', '`es`.`id_supervision` = `su`.`id_supervision`');
    $this->db->join('ciclo as ci', 'est.id_ciclo = ci.id_ciclo','left');
    if($id_nivel_z>0){
      $this->db->where('ni.id_nivel', $id_nivel_z);
    }
    if($id_sostenimiento_z>0){
      $this->db->where('sso.id_subsostenimiento', $id_sostenimiento_z);
    }
    if($id_zona_z>0){
      $this->db->where('su.id_supervision', $id_zona_z);
    }
    if($id_ciclo_z>0){
      $this->db->where($where_aux);
    }
    $this->db->where('ni.id_nivel <',8);
    $this->db->group_by("ni.nivel");

    $query1 = $this->db->get_compiled_select();

    $this->db->select('ni.id_nivel,ni.nivel, sso.id_subsostenimiento, sso.subsostenimiento, "0" as id_modalidad, "total" as modalidad,
    COUNT(es.id_cct) as nescuelas,
  SUM(est.grupos_1) AS grupos_1,
  SUM(est.grupos_2) grupos_2,
  SUM(est.grupos_3) AS grupos_3,
  SUM(est.grupos_4) AS grupos_4,
  SUM(est.grupos_5) AS grupos_5,
  SUM(est.grupos_6) AS grupos_6,
  SUM(est.grupos_multi) AS grupos_multi,
  SUM(est.grupos_t) AS grupos_t');
    $this->db->from('escuela as es');
    $this->db->join('estadistica_e_indicadores_xcct as est', 'es.id_cct = est.id_cct');
    $this->db->join('municipio as mu', 'es.id_municipio = mu.id_municipio');
    $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
    $this->db->join('modalidad as mo', 'es.id_modalidad = mo.id_modalidad');
    $this->db->join('subsostenimiento as sso', 'es.id_subsostenimiento = sso.id_subsostenimiento');
    $this->db->join('sostenimiento as so', 'sso.id_sostenimiento = so.id_sostenimiento');
    $this->db->join('supervision as su', '`es`.`id_supervision` = `su`.`id_supervision`');
    $this->db->join('ciclo as ci', 'est.id_ciclo = ci.id_ciclo','left');
    if($id_nivel_z>0){
      $this->db->where('ni.id_nivel', $id_nivel_z);
    }
    if($id_sostenimiento_z>0){
      $this->db->where('sso.id_subsostenimiento', $id_sostenimiento_z);
    }
    if($id_zona_z>0){
      $this->db->where('su.id_supervision', $id_zona_z);
    }
    if($id_ciclo_z>0){
      $this->db->where($where_aux);
    }
    $this->db->where('ni.id_nivel <',8);
    $this->db->group_by("ni.nivel");
    $this->db->group_by("sso.subsostenimiento");

    $query2 = $this->db->get_compiled_select();

    $this->db->select('ni.id_nivel,ni.nivel, sso.id_subsostenimiento, sso.subsostenimiento, mo.id_modalidad, mo.modalidad,
    COUNT(es.id_cct) as nescuelas,
  SUM(est.grupos_1) AS grupos_1,
  SUM(est.grupos_2) grupos_2,
  SUM(est.grupos_3) AS grupos_3,
  SUM(est.grupos_4) AS grupos_4,
  SUM(est.grupos_5) AS grupos_5,
  SUM(est.grupos_6) AS grupos_6,
  SUM(est.grupos_multi) AS grupos_multi,
  SUM(est.grupos_t) AS grupos_t');
    $this->db->from('escuela as es');
    $this->db->join('estadistica_e_indicadores_xcct as est', 'es.id_cct = est.id_cct');
    $this->db->join('municipio as mu', 'es.id_municipio = mu.id_municipio');
    $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
    $this->db->join('modalidad as mo', 'es.id_modalidad = mo.id_modalidad');
    $this->db->join('subsostenimiento as sso', 'es.id_subsostenimiento = sso.id_subsostenimiento');
    $this->db->join('sostenimiento as so', 'sso.id_sostenimiento = so.id_sostenimiento');
    $this->db->join('supervision as su', '`es`.`id_supervision` = `su`.`id_supervision`');
    $this->db->join('ciclo as ci', 'est.id_ciclo = ci.id_ciclo','left');
    if($id_nivel_z>0){
      $this->db->where('ni.id_nivel', $id_nivel_z);
    }
    if($id_sostenimiento_z>0){
      $this->db->where('sso.id_subsostenimiento', $id_sostenimiento_z);
    }
    if($id_zona_z>0){
      $this->db->where('su.id_supervision', $id_zona_z);
    }
    if($id_ciclo_z>0){
      $this->db->where($where_aux);
    }
    $this->db->where('ni.id_nivel <',8);
    $this->db->group_by("ni.nivel");
    $this->db->group_by("sso.subsostenimiento");
    $this->db->group_by("mo.modalidad");

    $this->db->order_by("id_nivel");
    $this->db->order_by("subsostenimiento", "DESC");
    $this->db->order_by("id_modalidad", "ASC");

    $query3 = $this->db->get_compiled_select();
    // $this->db->query($query1 . ' UNION ALL ' . $query2. ' UNION ALL ' . $query3)->result_array();
    // $str = $this->db->last_query();
    // echo $str; die();
    return $this->db->query($query1 . ' UNION ALL ' . $query2. ' UNION ALL ' . $query3)->result_array();

  }// get_infraest_xzona

  function get_nalumnos_xesc($id_cct){
    $this->db->select('alumn_t_1,alumn_t_2,alumn_t_3,alumn_t_4,alumn_t_5,alumn_t_6,alumn_t_t');
    $this->db->from('estadistica_e_indicadores_xcct');
    $this->db->where('id_cct', $id_cct);
    $this->db->where('id_corte', 2);
    $this->db->where('id_ciclo', 2);
    // $this->db->get();
    // $str = $this->db->last_query();
    // echo $str; die();
    return  $this->db->get()->result_array();
  }//get_nalumnos_xesc()


  function get_ndocentes_xesc($id_cct){
    $this->db->select('docentes_1_g,docentes_2_g,docentes_3_g,docentes_4_g,docentes_5_g,docentes_6_g');
    $this->db->from('estadistica_e_indicadores_xcct');
    $this->db->where('id_cct', $id_cct);
    $this->db->where('id_corte', 2);
    $this->db->where('id_ciclo', 2);
    // $this->db->get();
    // $str = $this->db->last_query();
    // echo $str; die();
    return  $this->db->get()->result_array();
  }//get_ndocentes_xesc()

  function get_ngrupos_xesc($id_cct){
    $this->db->select('grupos_1,grupos_2,grupos_3,grupos_4,grupos_5,grupos_6');
    $this->db->from('estadistica_e_indicadores_xcct');
    $this->db->where('id_cct', $id_cct);
    $this->db->where('id_corte', 2);
    $this->db->where('id_ciclo', 2);
    // $this->db->get();
    // $str = $this->db->last_query();
    // echo $str; die();
    return  $this->db->get()->result_array();
  }//get_ngrupos_xesc()

  function get_ind_asistenciaxcct($id_cct,$id_corte,$id_ciclo){

    $this->db->select('REPLACE(cobertura,"%","") as cobertura, REPLACE(absorcion,"%","") as absorcion');
    $this->db->from('indicadores_x_esc');
    $this->db->where('id_cct', $id_cct);
    $this->db->where('id_ciclo', $id_ciclo);
    $this->db->where('id_corte', $id_corte);
    return  $this->db->get()->result_array();
  }// get_ind_asistenciaxcct

  function get_ind_permananciaxcct($id_cct,$id_corte,$id_ciclo){

    $this->db->select('REPLACE(retencion,"%","") as retencion,REPLACE(aprobacion,"%","") as aprobacion, IF(REPLACE(et, "%", "")>100, 100,REPLACE(et, "%", "")) as et');
    $this->db->from('indicadores_x_esc');
    $this->db->where('id_cct', $id_cct);
    $this->db->where('id_ciclo', $id_ciclo);
    $this->db->where('id_corte', $id_corte);
    //
    // $this->db->get();
    // $str = $this->db->last_query();
    // echo $str; die();
    return  $this->db->get()->result_array();
  }// get_ind_asistenciaxcct

  function get_ind_efixcct($id_cct,$id_corte,$id_ciclo){

    $this->db->select('IF(REPLACE(et, "%", "")>100, 100,REPLACE(et, "%", "")) as et');
    $this->db->from('indicadores_x_esc');
    $this->db->where('id_cct', $id_cct);
    $this->db->where('id_ciclo', $id_ciclo);
    $this->db->where('id_corte', $id_corte);
    // $this->db->get();
    // $str = $this->db->last_query();
    // echo $str; die();
    return  $this->db->get()->result_array();
  }// get_ind_efixcct



}
