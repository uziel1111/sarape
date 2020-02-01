<?php
class Supervision_model extends CI_Model
{
    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->ce_db = $this->load->database('ce_db', TRUE);
    }

    function allzonas(){
      $query="SELECT cct,zona_escolar FROM centros_educativos.vista_cct 
              WHERE tipo_centro=1 AND (status != 2 AND status != 3) 
              AND zona_escolar IS NOT NULL 
              AND zona_escolar!=''";
      return $this->db->query($query)->result_array();
      // return  $this->db->get()->result_array();
    }// all()

    function getzona_idnivel_xsost($nivel,$sostenimiento){

      $filtro="";
      $filtro_nivel_sos="";
      if(trim($sostenimiento)=="PUBLICO"){
        $filtro_nivel_sos .= " AND sostenimiento NOT IN('61','41','92','96','51') ";
      }else if(trim($sostenimiento)=="PRIVADO"){
        $filtro_nivel_sos .= " AND sostenimiento IN ('61','41','92','96')";
      }else if(trim($sostenimiento)=="AUTONOMO"){
        $filtro_nivel_sos .= " AND sostenimiento IN  ('51')";
      }

      if(trim($nivel)=="PREESCOLAR"){
        $filtro .= " AND IF(escuelas.desc_servicio LIKE '%PREESCOLAR%' AND supervisiones.tipo='FZP',TRUE,FALSE)";
        $filtro_nivel_sos .= " AND desc_nivel_educativo = 'PREESCOLAR'";
      }else if(trim($nivel)=="PRIMARIA"){
        $filtro .= " AND IF(escuelas.desc_servicio LIKE '%PRIMARIA%' AND supervisiones.tipo='FIZ',TRUE,FALSE)";
        $filtro_nivel_sos .= " AND desc_nivel_educativo = 'PRIMARIA'";
      }else if(trim($nivel)=="SECUNDARIA"){
        $filtro .= "  AND
              IF((escuelas.desc_servicio='SECUNDARIA GENERAL' OR escuelas.desc_servicio='SECUNDARIA COMUNITARIA'
              OR(escuelas.desc_servicio='SECUNDARIA TECNICA INDUSTRIAL' AND escuelas.desc_sostenimiento='ESTATAL')
              OR (escuelas.desc_servicio='SECUNDARIA TECNICA INDUSTRIAL' AND escuelas.desc_sostenimiento='PARTICULAR')
              ) AND supervisiones.tipo='FIS',TRUE,
              IF(((escuelas.desc_servicio='SECUNDARIA TECNICA INDUSTRIAL' AND escuelas.desc_sostenimiento='FEDERAL TRANSFERIDO')
              OR (escuelas.desc_servicio='SECUNDARIA TECNICA AGROPECUARIA' AND escuelas.desc_sostenimiento='FEDERAL TRANSFERIDO')) AND supervisiones.tipo='FZT',TRUE,
              IF(escuelas.desc_servicio='TELESECUNDARIA' AND supervisiones.tipo='FTV', TRUE, FALSE) ))";
        $filtro_nivel_sos .= " AND desc_nivel_educativo = 'SECUNDARIA'";
      }

      $query="SELECT supervisiones.cct AS id_supervision,escuelas.zona_escolar
            FROM (SELECT
              cct, turno, sostenimiento, zona_escolar, desc_nivel_educativo, desc_servicio, desc_sostenimiento
              FROM centros_educativos.vista_cct cct
              WHERE (status = 1 OR status = 4) AND tipo_centro = 9 {$filtro_nivel_sos} ) AS escuelas
              INNER JOIN (SELECT
                cct, zona_escolar, sostenimiento, desc_nivel_educativo, SUBSTRING(cct, 3, 3) AS tipo
                FROM centros_educativos.vista_cct cct
                WHERE (status = 1 OR status = 4) AND tipo_centro = 1
                ) AS supervisiones ON escuelas.zona_escolar = supervisiones.zona_escolar
              AND escuelas.sostenimiento = supervisiones.sostenimiento
              {$filtro}
            GROUP BY supervisiones.zona_escolar";

      return $this->db->query($query)->result_array();

    }// getzona_idnivel_xsost

    function get_zona($nivel, $id_sostenimiento_z,$id_zona_z){
      if ($id_sostenimiento_z==0) {
        return "TODOS";
      }
      else {
        $query = "SELECT zona_escolar from centros_educativos.vista_cct 
                  WHERE (status = 1 OR status = 4) AND tipo_centro = 1
                  AND cct='{$id_zona_z}' ";
        return  $this->db->query($query)->row('zona_escolar');
      }

    }// get_zona()

}// Municipio_model
