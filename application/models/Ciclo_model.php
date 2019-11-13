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

    function getciclo_xidmun_idnivel_xsost_idmod($id_municipio,$id_nivel,$id_sostenimiento,$id_modalidad){
      $this->db->select('ci.id_ciclo, ci.ciclo');
      $this->db->from('ciclo ci');
      $this->db->join('estadistica_e_indicadores_xcct as est ',' ci.id_ciclo = est.id_ciclo');
      $this->db->join('escuela as es','est.id_cct = es.id_cct');
      $this->db->join('municipio as mu', 'es.id_municipio = mu.id_municipio');
      $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
      $this->db->join('subsostenimiento as sso', 'es.id_subsostenimiento = sso.id_subsostenimiento');
      $this->db->join('sostenimiento as so', 'sso.id_sostenimiento = so.id_sostenimiento');
      $this->db->join('modalidad as mo', 'es.id_modalidad = mo.id_modalidad');
      if($id_municipio>0){
        $this->db->where('mu.id_municipio', $id_municipio);
      }
      if($id_nivel>0){
        $this->db->where('ni.id_nivel', $id_nivel);
      }
      if($id_sostenimiento>0){
        $this->db->where('so.id_sostenimiento', $id_sostenimiento);
      }
      if($id_modalidad>0){
        $this->db->where('mo.id_modalidad', $id_modalidad);
      }
      $this->db->group_by(" ci.id_ciclo");
      return  $this->db->get()->result_array();

    }// getciclo_xidmun_idnivel_xsost

    function getciclo_idnivel_xsost_xzona($nivel, $sostenimiento, $id_zona){
      // $this->db->select('ci.id_ciclo, ci.ciclo');
      // $this->db->from('ciclo ci');
      // $this->db->join('estadistica_e_indicadores_xcct as est ',' ci.id_ciclo = est.id_ciclo');
      // $this->db->join('escuela as es','est.id_cct = es.id_cct');
      // $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
      // $this->db->join('subsostenimiento as sso', 'es.id_subsostenimiento = sso.id_subsostenimiento');
      $filtro_nivel_sos = "";
      $filtro = "";
      if($nivel== 'PREESCOLAR'){
        $filtro_nivel_sos .= " AND v.desc_nivel_educativo LIKE '%PREESCOLAR%'";
      }else if($nivel=="PRIMARIA"){
        $filtro_nivel_sos .= " AND v.desc_nivel_educativo LIKE '%PRIMARIA%'";
      }else if($nivel== "SECUNDARIA"){
        $filtro_nivel_sos .= " AND v.desc_nivel_educativo LIKE '%SECUNDARIA%'";
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
      // $this->db->where('ci.id_ciclo', 4);
      // $this->db->group_by(" ci.id_ciclo");

      // $this->db->get();
      // $str = $this->db->last_query();
      // echo $str; die();
      
      $query = "SELECT ci.id_ciclo, ci.ciclo 
                FROM sarape.ciclo ci 
                INNER JOIN sarape.estadistica_e_indicadores_xcct AS est ON  ci.id_ciclo = est.id_ciclo
                INNER JOIN vista_cct AS v ON v.cct = est.cct 
                AND (v.status = 1 OR v.status = 4) AND v.tipo_centro= 9
                {$filtro_nivel_sos}
                INNER JOIN (SELECT cct, zona_escolar, sostenimiento, desc_nivel_educativo, 
                            SUBSTRING(cct, 3, 3) AS tipo
                        FROM vista_cct cct
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
