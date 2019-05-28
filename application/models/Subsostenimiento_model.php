<?php
class Subsostenimiento_model extends CI_Model
{
    function __construct(){
        parent::__construct();
    }

    function all(){
      return  $this->db->get('subsostenimiento')->result_array();
    }// all()

    function getsubsost_xidnivel($id_nivel){
      $this->db->select('sso.id_subsostenimiento, sso.subsostenimiento');
      $this->db->from('subsostenimiento as sso');
      $this->db->join('escuela as es', 'sso.id_subsostenimiento = es.id_subsostenimiento');
      $this->db->join('estadistica_e_indicadores_xcct as  est', 'es.id_cct = est.id_cct');
      $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
      if($id_nivel>0){
        $this->db->where('ni.id_nivel', $id_nivel);
      }
      $this->db->group_by(" sso.id_subsostenimiento");
      return  $this->db->get()->result_array();

    }// getsubsost_xidnivel

    function get_subsostenimiento($id_sostenimiento_z){
      if ($id_sostenimiento_z==0) {
        return "TODOS";
      }
      else {
        $this->db->select('sso.subsostenimiento');
        $this->db->from('subsostenimiento as sso');
        $this->db->where('sso.id_subsostenimiento', $id_sostenimiento_z);
        return  $this->db->get()->row('subsostenimiento');
      }

    }// get_subsostenimiento()

}// Municipio_model
