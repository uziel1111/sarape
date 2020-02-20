<?php
class Escuela_model extends CI_Model
{

  function __construct(){
    parent::__construct();
        ini_set('max_execution_time', 300); //300 seconds = 5 minutes
        $this->load->database();
      }

      function get_xparams($id_municipio,$id_nivel,$id_sostenimiento,$nombre_escuela){

      switch ($id_nivel) {
       case '1':
       $nivel = 'CAM';
       break;
       case '2':
       $nivel = 'INICIAL';
       break;
       case '3':
       $nivel = 'PREESCOLAR';
       break;
       case '4':
       $nivel = 'PRIMARIA';
       break;
       case '5':
       $nivel = 'SECUNDARIA';
       break;
       case '6':
       $nivel = 'MEDIA SUPERIOR';
       break;
       case '7':
       $nivel = 'SUPERIOR';
       break;
       case '8':
       $nivel = 'FORMACION PARA EL TRABAJO';
       break;
       case '9':
       $nivel = 'OTRO NIVEL EDUCATIVO';
       break;
       case '10':
       $nivel = 'NO APLICA';
       break;

     }



     switch ($id_sostenimiento) {
       case '1':
       $sostenimiento = "AND es.sostenimiento not in ('61','41','92','96', '51')";
       break;
       case '2':
       $sostenimiento = "AND es.sostenimiento in ('61','41','92','96')";
       break;
       case '3':
       $sostenimiento = "AND es.sostenimiento = '51'";
       break;
       default:
       $id_sostenimiento = 0;
       break;
     }

     if($id_municipio>0){
      $where_mun = " and es.municipio = {$id_municipio}";
    } else{
      $where_mun = ' ';
    }
    if($id_nivel>0){
      $where_niv = " and es.desc_nivel_educativo = '{$nivel}'";
    } else{
      $where_niv = ' ';
    }
    if($id_sostenimiento>0){
      $where_sos = " {$sostenimiento}";
    } else{
      $where_sos = ' ';
    }
    if($nombre_escuela!=''){
      $like = " and es.nombre LIKE '%{$nombre_escuela}%'";
    } else{
      $like = ' ';
    }

      $str_query = "SELECT 
      es.cct as cve_centro,
      es.turno as turno,
      es.desc_turno as turno_single,
      es.nombre as nombre_centro,
      es.desc_nivel_educativo as nivel,
      es.desc_sostenimiento as subsostenimiento,
      es.modalidad,
      es.nombre_de_municipio as municipio,
      es.nombre_de_localidad as localidad,
      concat_ws(' ', es.nombre_vialidad_principal, es.numero_exterior, es.numero_interior) as domicilio,
      es.latitud,
      es.longitud,
      CASE  WHEN desc_nivel_educativo ='NO APLICA'  THEN '10'
      WHEN desc_nivel_educativo ='CAM' THEN '1'
      WHEN desc_nivel_educativo ='INICIAL' THEN '2'
      WHEN desc_nivel_educativo ='PREESCOLAR' THEN '3'
      WHEN desc_nivel_educativo ='PRIMARIA' THEN '4'
      WHEN desc_nivel_educativo ='SECUNDARIA' THEN '5'
      WHEN desc_nivel_educativo ='MEDIA SUPERIOR' THEN '6'
      WHEN desc_nivel_educativo ='SUPERIOR' THEN '7'
      WHEN desc_nivel_educativo ='FORMACION PARA EL TRABAJO' THEN '8'
      WHEN desc_nivel_educativo ='OTRO NIVEL EDUCATIVO' THEN '9'
      WHEN nivel_educativo = null  THEN '0'
      END AS id_nivel,
      es.zona_escolar,
      es.sostenimiento
      FROM
      vista_cct AS es
      WHERE
      (es.status != 2
      AND es.status != 3)
      AND es.latitud != 0
      AND es.latitud != ''
      AND es.latitud != '#VALUE!'
      {$where_mun}
      {$where_niv}
      {$where_sos}
      {$like}
      GROUP BY es.cct
      ORDER BY es.nivel_educativo";

      return $this->db->query($str_query)->result_array();
    }// get_xparams()



    function get_xcvecentro($cve_centro){
 
      $str_query = "SELECT 
      es.cct as cve_centro,
      es.nombre as nombre_centro,
      es.desc_nivel_educativo as nivel,
       es.turno as turno,
      es.desc_turno as turno_single,
      es.latitud,
      es.longitud,
      CASE  WHEN desc_nivel_educativo ='NO APLICA'  THEN '0'
      WHEN desc_nivel_educativo ='CAM' THEN '1'
      WHEN desc_nivel_educativo ='INICIAL' THEN '2'
      WHEN desc_nivel_educativo ='PREESCOLAR' THEN '3'
      WHEN desc_nivel_educativo ='PRIMARIA' THEN '4'
      WHEN desc_nivel_educativo ='SECUNDARIA' THEN '5'
      WHEN desc_nivel_educativo ='MEDIA SUPERIOR' THEN '6'
      WHEN desc_nivel_educativo ='SUPERIOR' THEN '7'
      WHEN desc_nivel_educativo ='FORMACION PARA EL TRABAJO' THEN '8'
      WHEN desc_nivel_educativo ='OTRO NIVEL EDUCATIVO' THEN '9'
      WHEN nivel_educativo = null  THEN '0'
      END AS id_nivel,
      es.nombre_de_municipio as municipio,
      es.nombre_de_localidad as localidad,
      es.zona_escolar,
      es.sostenimiento,
      es.desc_sostenimiento as subsostenimiento
      FROM
      vista_cct AS es
      WHERE
      es.cct = '{$cve_centro}'
      AND (es.status != 2
      AND es.status != 3)
      AND es.latitud != 0
      AND es.latitud != ''
      AND es.latitud != '#VALUE!'
      GROUP BY es.turno";
      return $this->db->query($str_query)->result_array();
    }// get_xcentro()

    function get_xcvecentro_turnosingle($cve_centro, $turno_single){
      if (strlen($turno_single)>4) {
        $where_turno = "AND es.desc_turno LIKE '%{$turno_single}%'";
      }else{
        $where_turno = "AND es.turno LIKE '%{$turno_single}%'";
      }

      $str_query = "SELECT 
      es.cct as cve_centro, es.nombre as nombre_centro, es.turno
      FROM
      vista_cct AS es
      WHERE
      es.cct = '{$cve_centro}'
      {$where_turno}";

      return $this->db->query($str_query)->result_array();


    }// get_xcvecentro_turnosingle()


    function get_marcadores(){
      $this->db->select('latitud, longitud, nombre_centro');
      $query = $this->db->get('escuela')->result_array();
      return $query;
    }


    function get_xidcct($idcct){

      $str_query = "SELECT es.cct as cve_centro ,es.nombre as nombre_centro, es.latitud, es.longitud,  CASE  WHEN desc_nivel_educativo ='NO APLICA'  THEN '0'
      WHEN desc_nivel_educativo ='CAM' THEN '1'
      WHEN desc_nivel_educativo ='INICIAL' THEN '2'
      WHEN desc_nivel_educativo ='PREESCOLAR' THEN '3'
      WHEN desc_nivel_educativo ='PRIMARIA' THEN '4'
      WHEN desc_nivel_educativo ='SECUNDARIA' THEN '5'
      WHEN desc_nivel_educativo ='MEDIA SUPERIOR' THEN '6'
      WHEN desc_nivel_educativo ='SUPERIOR' THEN '7'
      WHEN desc_nivel_educativo ='FORMACION PARA EL TRABAJO' THEN '8'
      WHEN desc_nivel_educativo ='OTRO NIVEL EDUCATIVO' THEN '9'
      WHEN nivel_educativo = null  THEN '0'
      END AS id_nivel
      from vista_cct as es
      where cct = '{$idcct}';";
      
      return $this->db->query($str_query)->result_array();

    }

    function get_mismo_nivel($latitud, $longitud, $id_nivel, $siguiente){
      if($siguiente == true && $id_nivel < 10){
        $id_nivel = $id_nivel+1;
      }
      switch ($id_nivel) {
       case '1':
       $nivel = 'CAM';
       break;
       case '2':
       $nivel = 'INICIAL';
       break;
       case '3':
       $nivel = 'PREESCOLAR';
       break;
       case '4':
       $nivel = 'PRIMARIA';
       break;
       case '5':
       $nivel = 'SECUNDARIA';
       break;
       case '6':
       $nivel = 'MEDIA SUPERIOR';
       break;
       case '7':
       $nivel = 'SUPERIOR';
       break;
       case '8':
       $nivel = 'FORMACION PARA EL TRABAJO';
       break;
       case '9':
       $nivel = 'OTRO NIVEL EDUCATIVO';
       break;
       case '10':
       $nivel = 'NO APLICA';
       break;
     }

      $str_query = "SELECT 
      es.cct as cve_centro,
      es.turno as turno,
      es.desc_turno as turno_single,
      es.nombre as nombre_centro,
      es.desc_nivel_educativo as nivel,
      es.desc_sostenimiento as subsostenimiento,
      es.modalidad,
      es.nombre_de_municipio as municipio,
      es.nombre_de_localidad as localidad,
      concat_ws(' ', es.nombre_vialidad_principal, es.numero_exterior, es.numero_interior) as domicilio,
      es.latitud,
      es.longitud,
      CASE  WHEN desc_nivel_educativo ='NO APLICA'  THEN '0'
      WHEN desc_nivel_educativo ='CAM' THEN '1'
      WHEN desc_nivel_educativo ='INICIAL' THEN '2'
      WHEN desc_nivel_educativo ='PREESCOLAR' THEN '3'
      WHEN desc_nivel_educativo ='PRIMARIA' THEN '4'
      WHEN desc_nivel_educativo ='SECUNDARIA' THEN '5'
      WHEN desc_nivel_educativo ='MEDIA SUPERIOR' THEN '6'
      WHEN desc_nivel_educativo ='SUPERIOR' THEN '7'
      WHEN desc_nivel_educativo ='FORMACION PARA EL TRABAJO' THEN '8'
      WHEN desc_nivel_educativo ='OTRO NIVEL EDUCATIVO' THEN '9'
      WHEN nivel_educativo = null  THEN '0'
      END AS id_nivel,
      es.zona_escolar,
      es.sostenimiento,
      (6371 * ACOS(COS(RADIANS(27.239658)) * COS(RADIANS(latitud)) * COS(RADIANS(longitud) - RADIANS(- 101.225968)) + SIN(RADIANS(27.239658)) * SIN(RADIANS(latitud)))) AS distance
      FROM
      vista_cct as es
      WHERE
      (es.status != 2
      AND es.status != 3)
      AND es.latitud != 0
      AND es.latitud != ''
      AND es.latitud != '#VALUE!'
      AND es.desc_nivel_educativo = '{$nivel}'
      HAVING distance < 1000
      ORDER BY distance
      LIMIT 6";

      return $this->db->query($str_query)->result_array();

    }
    function get_nivel_xidcct($id_cct){
      $this->db->select('id_nivel');
      $this->db->from('escuela');
      $this->db->where('id_cct', $id_cct);
      return  $this->db->get()->row('id_nivel');
    }// get_nivel()

 



    function get_indicpeso_xmuni($id_municipio, $idnivel, $id_ciclo){
      $this->db->select('
        ROUND(`Bajo-peso`*100,1) as `bajo`,
        ROUND(`Normal`*100,1) as Normal,
        ROUND(`Sobrepeso`*100,1) as Sobrepeso,
        ROUND(`Obesidad`*100,1) as Obesidad,
        ROUND(GREATEST(`Bajo-peso`,Normal,Sobrepeso,Obesidad)*100,1) as predom,
        IF(ROUND(GREATEST(`Bajo-peso`,Normal,Sobrepeso,Obesidad)*100,1)=ROUND(`Bajo-peso`*100,1),1,0) as t_bajo,
        IF(ROUND(GREATEST(`Bajo-peso`,Normal,Sobrepeso,Obesidad)*100,1)=ROUND(`Normal`*100,1),1,0) as t_normal,
        IF(ROUND(GREATEST(`Bajo-peso`,Normal,Sobrepeso,Obesidad)*100,1)=ROUND(`Sobrepeso`*100,1),1,0) as t_sobrepeso,
        IF(ROUND(GREATEST(`Bajo-peso`,Normal,Sobrepeso,Obesidad)*100,1)=ROUND(`Obesidad`*100,1),1,0) as t_obesidad
        ');
      $this->db->from('pesoxmuni');
      $this->db->where('id_municipio', $id_municipio);
      $this->db->where('id_ciclo', $id_ciclo);
      $this->db->where('idnivel', $idnivel);
      return  $this->db->get()->result_array();
    }// get_indicpeso_xmuni()

    function get_indicpeso_xestado($idnivel, $id_ciclo){
      $this->db->select('
        ROUND(`Bajo-peso`*100,1) as `bajo`,
        ROUND(`Normal`*100,1) as Normal,
        ROUND(`Sobrepeso`*100,1) as Sobrepeso,
        ROUND(`Obesidad`*100,1) as Obesidad,
        ROUND(GREATEST(`Bajo-peso`,Normal,Sobrepeso,Obesidad)*100,1) as predom,
        IF(ROUND(GREATEST(`Bajo-peso`,Normal,Sobrepeso,Obesidad)*100,1)=ROUND(`Bajo-peso`*100,1),1,0) as t_bajo,
        IF(ROUND(GREATEST(`Bajo-peso`,Normal,Sobrepeso,Obesidad)*100,1)=ROUND(`Normal`*100,1),1,0) as t_normal,
        IF(ROUND(GREATEST(`Bajo-peso`,Normal,Sobrepeso,Obesidad)*100,1)=ROUND(`Sobrepeso`*100,1),1,0) as t_sobrepeso,
        IF(ROUND(GREATEST(`Bajo-peso`,Normal,Sobrepeso,Obesidad)*100,1)=ROUND(`Obesidad`*100,1),1,0) as t_obesidad
        ');
      $this->db->from('pesoxestado');
      $this->db->where('id_ciclo', $id_ciclo);
      $this->db->where('idnivel', $idnivel);
      return  $this->db->get()->result_array();
    }// get_indicpeso_xestado()
}// Municipio_model
