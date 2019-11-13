<?php
class Supervision_model extends CI_Model
{
    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->ce_db = $this->load->database('ce_db', TRUE);
    }

    function allzonas(){
      // $this->db->select('su.id_supervision, su.zona_escolar');
      // $this->db->from('supervision as su');
      // $this->db->join('escuela as es','su.id_supervision = es.id_supervision');
      // $this->db->group_by(" su.id_supervision");

      $query="SELECT cct,zona_escolar FROM vista_cct 
              WHERE tipo_centro=1 AND (status != 2 AND status != 3) 
              AND zona_escolar IS NOT NULL 
              AND zona_escolar!=''";
      return $this->db->query($query)->result_array();
      // return  $this->db->get()->result_array();
    }// all()

    function getzona_idnivel_xsost($nivel,$sostenimiento){

      // $this->db->select('su.id_supervision, su.zona_escolar');
      // $this->db->from('escuela as es');
      // $this->db->join('estadistica_e_indicadores_xcct as est', 'es.id_cct = est.id_cct');
      // $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
      // $this->db->join('subsostenimiento as sso', 'es.id_subsostenimiento = sso.id_subsostenimiento');
      // $this->db->join('supervision as su', 'es.id_supervision = su.id_supervision');
      // if ($id_nivel>0) {
      //   $this->db->where('ni.id_nivel', $id_nivel);
      // }
      // $this->db->where('sso.id_subsostenimiento', $id_subsostenimiento);

      // $this->db->group_by("su.id_supervision");
      // $this->db->order_by("su.zona_escolar");
      // // $this->db->get();
      // // $str = $this->db->last_query();
      // // echo $str; die();
      // return  $this->db->get()->result_array();
      $filtro="";
      $filtro_nivel_sos="";
      if($sostenimiento=="PUBLICO"){
        $filtro_nivel_sos .= " AND sostenimiento NOT IN('61','41','92','96','51') ";
      }else if($sostenimiento=="PRIVADO"){
        $filtro_nivel_sos .= " AND sostenimiento IN ('61','41','92','96')";
      }else if($sostenimiento=="AUTONOMO"){
        $filtro_nivel_sos .= " AND sostenimiento IN  ('51')";
      }

      if($nivel=="PREESCOLAR"){
        $filtro .= " AND IF(escuelas.desc_servicio LIKE '%PREESCOLAR%' AND supervisiones.tipo='FZP',TRUE,FALSE)";
        $filtro_nivel_sos .= " AND desc_nivel_educativo LIKE '%PREESCOLAR%'";
      }else if($nivel="PRIMARIA"){
        $filtro .= " AND IF(escuelas.desc_servicio LIKE '%PRIMARIA%' AND supervisiones.tipo='FIZ',TRUE,FALSE)";
        $filtro_nivel_sos .= " AND desc_nivel_educativo LIKE '%PRIMARIA%'";
      }else if($nivel="SECUNDARIA"){
        $filtro .= "  AND
              IF((escuelas.desc_servicio='SECUNDARIA GENERAL' OR escuelas.desc_servicio='SECUNDARIA COMUNITARIA'
              OR(escuelas.desc_servicio='SECUNDARIA TECNICA INDUSTRIAL' AND escuelas.desc_sostenimiento='ESTATAL')
              OR (escuelas.desc_servicio='SECUNDARIA TECNICA INDUSTRIAL' AND escuelas.desc_sostenimiento='PARTICULAR')
              ) AND supervisiones.tipo='FIS',TRUE,
              IF(((escuelas.desc_servicio='SECUNDARIA TECNICA INDUSTRIAL' AND escuelas.desc_sostenimiento='FEDERAL TRANSFERIDO')
              OR (escuelas.desc_servicio='SECUNDARIA TECNICA AGROPECUARIA' AND escuelas.desc_sostenimiento='FEDERAL TRANSFERIDO')) AND supervisiones.tipo='FZT',TRUE,
              IF(escuelas.desc_servicio='TELESECUNDARIA' AND supervisiones.tipo='FTV', TRUE, FALSE) ))";
        $filtro_nivel_sos .= " AND desc_nivel_educativo LIKE '%SECUNDARIA%'";
      }

      $query="SELECT supervisiones.cct AS id_supervision,escuelas.zona_escolar
            FROM (SELECT
              cct, turno, sostenimiento, zona_escolar, desc_nivel_educativo, desc_servicio, desc_sostenimiento
              FROM vista_cct cct
              WHERE (status = 1 OR status = 4) AND tipo_centro = 9 {$filtro_nivel_sos} ) AS escuelas
              INNER JOIN (SELECT
                cct, zona_escolar, sostenimiento, desc_nivel_educativo, SUBSTRING(cct, 3, 3) AS tipo
                FROM vista_cct cct
                WHERE (status = 1 OR status = 4) AND tipo_centro = 1
                ) AS supervisiones ON escuelas.zona_escolar = supervisiones.zona_escolar
              AND escuelas.sostenimiento = supervisiones.sostenimiento
              {$filtro}
            GROUP BY supervisiones.zona_escolar";
      // echo $query; die();
      return $this->db->query($query)->result_array();

    }// getzona_idnivel_xsost

    function get_zona($nivel, $id_sostenimiento_z,$id_zona_z){
      if ($id_sostenimiento_z==0) {
        return "TODOS";
      }
      else {
        // $this->db->select('su.id_supervision, su.zona_escolar');
        // $this->db->from('escuela as es');
        // $this->db->join('estadistica_e_indicadores_xcct as est', 'es.id_cct = est.id_cct');
        // $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
        // $this->db->join('subsostenimiento as sso', 'es.id_subsostenimiento = sso.id_subsostenimiento');
        // $this->db->join('supervision as su', 'es.id_supervision = su.id_supervision');
        // $this->db->where('su.id_supervision', $id_zona_z);
        // $this->db->where('ni.id_nivel', $id_nivel_z);
        // $this->db->where('sso.id_subsostenimiento', $id_sostenimiento_z);
        $query = "SELECT zona_escolar from vista_cct 
                  WHERE (status = 1 OR status = 4) AND tipo_centro = 1
                  AND cct='{$id_zona_z}' ";
        return  $this->db->query($query)->row('zona_escolar');
      }

    }// get_zona()

}// Municipio_model
