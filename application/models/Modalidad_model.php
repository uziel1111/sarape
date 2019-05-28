<?php
class Modalidad_model extends CI_Model
{
    function __construct(){
        parent::__construct();
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



    function getmodali_xidmun_idnivel_idsost($id_municipio,$id_nivel,$id_sost){
      $this->db->select('mo.id_modalidad, mo.modalidad');
      $this->db->from('modalidad as mo');
      $this->db->join('escuela as es', 'mo.id_modalidad = es.id_modalidad');
      $this->db->join('estadistica_e_indicadores_xcct as  est', 'es.id_cct = est.id_cct');
      $this->db->join('municipio as mu', 'es.id_municipio = mu.id_municipio');
      $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
      $this->db->join('subsostenimiento as sso', 'es.id_subsostenimiento = sso.id_subsostenimiento');
      $this->db->join('sostenimiento as so', 'sso.id_sostenimiento = so.id_sostenimiento');
      if($id_municipio>0){
        $this->db->where('mu.id_municipio', $id_municipio);
      }
      if($id_nivel>0){
        $this->db->where('ni.id_nivel', $id_nivel);
      }
      if($id_sost>0){
        $this->db->where('so.id_sostenimiento', $id_sost);
      }
      $this->db->group_by("mo.id_modalidad");
      return  $this->db->get()->result_array();
    }// getmodali_xidmun_idnivel_idsost()


    function get_modalidad($id_modalidad){
      if ($id_modalidad==0) {
        return "TODOS";
      }
      else {
        $this->db->select('mo.modalidad');
        $this->db->from('modalidad as mo');
        $this->db->where('mo.id_modalidad', $id_modalidad);
        return  $this->db->get()->row('modalidad');
      }

    }// get_modalidad()

}// Sostenimiento_model
