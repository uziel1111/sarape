<?php
class Municipio_model extends CI_Model
{
    function __construct(){
        parent::__construct();
    }

    function all(){
            return  $this->db->get('municipio')->result_array();
    }// all()

    function getall_xest_ind(){
      $this->db->select('mu.id_municipio, mu.municipio');
      $this->db->from('municipio mu');
      $this->db->join('escuela as es', 'mu.id_municipio = es.id_municipio');
      $this->db->join('estadistica_e_indicadores_xcct as  est', 'es.id_cct = est.id_cct');
      $this->db->group_by('mu.id_municipio');
      return  $this->db->get()->result_array();
    }// getall_xest_ind()

    function get_muncipio($id_municipio){
      if ($id_municipio==0) {
        return "TODOS";
      }
      else {
        $this->db->select(' mu.municipio');
        $this->db->from('municipio mu');
        $this->db->where('mu.id_municipio', $id_municipio);
        return  $this->db->get()->row('municipio');
      }

    }// get_muncipio()

}// Municipio_model
