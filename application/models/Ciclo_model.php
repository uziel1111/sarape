<?php
class Ciclo_model extends CI_Model
{
    function __construct(){
        parent::__construct();
    }

    function all(){
      $this->db->select('id_ciclo, ciclo');
      $this->db->from('ciclo');
      $this->db->order_by("id_ciclo", "desc");
            return  $this->db->get()->result_array();
    }// all()

    function ciclo_est_e_ind(){
      $this->db->select('id_ciclo, ciclo');
      $this->db->from('ciclo');
      $this->db->order_by("id_ciclo", "desc");
      $this->db->where('id_ciclo', 4);
            return  $this->db->get()->result_array();
    }// all()

    function ultimo_ciclo_escolar(){
      $this->db->select('ciclo');
      $this->db->from('ciclo');
      $this->db->order_by("id_ciclo", "desc");
      $this->db->limit(1);
      return  $this->db->get()->row('ciclo');
    }


    function getciclo_idnivel_xsost_xzona($nivel, $sostenimiento, $id_zona){
      $filtro_nivel_sos = "";
      $filtro = "";
      if($nivel== 'PREESCOLAR'){
        $filtro_nivel_sos .= " AND v.desc_nivel_educativo = 'PREESCOLAR'";
      }else if($nivel=="PRIMARIA"){
        $filtro_nivel_sos .= " AND v.desc_nivel_educativo = 'PRIMARIA'";
      }else if($nivel== "SECUNDARIA"){
        $filtro_nivel_sos .= " AND v.desc_nivel_educativo = 'SECUNDARIA'";
      }

      if($sostenimiento=="PRIVADO"){
          $filtro_nivel_sos .= " AND v.sostenimiento IN ('61','41','92','96')";
      }else if($sostenimiento=="AUTONOMO"){
          $filtro_nivel_sos .= " AND v.sostenimiento IN  ('51')";
      }else if($sostenimiento== "PUBLICO"){
          $filtro_nivel_sos .= " AND v.sostenimiento NOT IN('61','41','92','96','51')";
      }

      $filtro_zona = "";
      if($id_zona!=''){
          $filtro_zona .= " AND supervisiones.cct = '{$id_zona}'";
      }

      $query = "SELECT ci.id_ciclo, ci.ciclo
                FROM ciclo ci
                INNER JOIN sarape.estadistica_e_indicadores_xcct AS est ON  ci.id_ciclo = est.id_ciclo
                INNER JOIN centros_educativos.vista_cct AS v ON v.cct = est.cct
                AND (v.status = 1 OR v.status = 4) AND v.tipo_centro= 9
                {$filtro_nivel_sos}
                INNER JOIN (SELECT cct, zona_escolar, sostenimiento, desc_nivel_educativo,
                            SUBSTRING(cct, 3, 3) AS tipo
                        FROM centros_educativos.vista_cct cct
                        WHERE (status = 1 OR status = 4) AND tipo_centro = 1
                ) AS supervisiones ON v.zona_escolar = supervisiones.zona_escolar
                AND v.sostenimiento = supervisiones.sostenimiento
                {$filtro} {$filtro_zona}
                WHERE ci.id_ciclo=4
                GROUP BY ci.id_ciclo";
      return  $this->db->query($query)->result_array();
    }// getciclo_idnivel_xsost_xzona


    function get_ciclo($id_ciclo){
      if ($id_ciclo==0) {
        return "TODOS";
      }
      else {
        $this->db->select('ci.ciclo');
        $this->db->from('ciclo ci');
        $this->db->where('ci.id_ciclo', $id_ciclo);
        return  $this->db->get()->row('ciclo');
      }

    }// get_ciclo()

}// Municipio_model
