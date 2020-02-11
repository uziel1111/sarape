<?php
class Subsostenimiento_model extends CI_Model
{
    function __construct(){
        parent::__construct();
    }

    function all(){
      return  $this->db->get('subsostenimiento')->result_array();
    }// all()

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
