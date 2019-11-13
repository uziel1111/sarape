<?php
class Modalidad_model extends CI_Model
{
    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->ce_db = $this->load->database('ce_db', TRUE);
    }

    function all(){
      return  $this->db->get('modalidad')->result_array();
    }// all()

    function allest(){
      $this->db->select('mo.id_modalidad, mo.modalidad');
      $this->db->from('modalidad as mo');
      $this->db->where('mo.id_modalidad <', '10');
      return  $this->db->get()->result_array();
    }// all()



    function getmodali_xidmun_idnivel_idsost($id_municipio,$nivel,$sostenimiento){
      // $this->db->select('mo.id_modalidad, mo.modalidad');
      // $this->db->from('modalidad as mo');
      // $this->db->join('escuela as es', 'mo.id_modalidad = es.id_modalidad');
      // $this->db->join('estadistica_e_indicadores_xcct as  est', 'es.id_cct = est.id_cct');
      // $this->db->join('municipio as mu', 'es.id_municipio = mu.id_municipio');
      // $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
      // $this->db->join('subsostenimiento as sso', 'es.id_subsostenimiento = sso.id_subsostenimiento');
      // $this->db->join('sostenimiento as so', 'sso.id_sostenimiento = so.id_sostenimiento');
      $filtro="";
      if($id_municipio>0){
        $filtro.=" AND municipio={$id_municipio}";
      }
      if($nivel!="TODOS"){
        $filtro.=" AND desc_nivel_educativo LIKE '%{$nivel}%'";
      }
      if($sostenimiento!="TODOS"){
        if($sostenimiento=="PRIVADO"){
          $filtro.=" AND sostenimiento in('61','41','92','96')";
        }else if($sostenimiento=="AUTONOMO"){
          $filtro.="AND sostenimiento in(51)";
        }else {
          $filtro.="AND sostenimiento NOT IN('61','41','92','96','51')";
        }
      }
      // $this->db->group_by("mo.id_modalidad");
      // return  $this->db->get()->result_array();
      $query="SELECT cct,nivel_educativo AS nivel,desc_nivel_educativo,
              servicio AS id_modalidad,desc_servicio AS modalidad 
              FROM vista_cct WHERE status IN ('1','4') 
              AND tipo_centro='9' 
               {$filtro}
              GROUP BY desc_servicio";
      return $this->ce_db->query($query)->result_array();

    }// getmodali_xidmun_idnivel_idsost()


    function get_modalidad($id_modalidad,$nivel){
      if ($id_modalidad==0) {
        return "TODOS";
      }
      else {
        // $this->db->select('v.desc_servicio as modalidad');
        // $this->db->from('vista_cct as v');
        // $this->db->where('v.servicio', $id_modalidad);
        // return  $this->ce_db->get()->row('modalidad');
        $query = "SELECT desc_servicio as modalidad FROM vista_cct 
                  WHERE  servicio={$id_modalidad} 
                  AND desc_nivel_educativo LIKE '%{$nivel}%'";
                  // echo $query;
                  // die();
        return $this->ce_db->query($query)->row('modalidad');
      }

    }// get_modalidad()

}// Sostenimiento_model
