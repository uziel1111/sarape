<?php
class Sostenimiento_model extends CI_Model
{
    function __construct(){
        parent::__construct();
    }

    function all(){
      return  $this->db->get('sostenimiento')->result_array();
    }// all()

    function get_xidnivel($id_nivel){
      $this->db->select('so.id_sostenimiento, so.sostenimiento');
      $this->db->from('sostenimiento as so');
      $this->db->join('subsostenimiento as sso', 'so.id_sostenimiento = sso.id_sostenimiento');
      $this->db->join('escuela as es', 'sso.id_subsostenimiento = es.id_subsostenimiento');
      $this->db->join('estadistica_e_indicadores_xcct as  est', 'es.id_cct = est.id_cct');
      $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
      if($id_nivel>0){
        $this->db->where('ni.id_nivel', $id_nivel);
      }
      $this->db->group_by(" so.id_sostenimiento");
      return  $this->db->get()->result_array();
    }// get_xcvenivel()

    function getsost_xidmun_idnivel($id_municipio,$id_nivel){
      $this->db->select('so.id_sostenimiento, so.sostenimiento');
      $this->db->from('sostenimiento as so');
      $this->db->join('subsostenimiento as sso', 'so.id_sostenimiento = sso.id_sostenimiento');
      $this->db->join('escuela as es', 'sso.id_subsostenimiento = es.id_subsostenimiento');
      $this->db->join('estadistica_e_indicadores_xcct as  est', 'es.id_cct = est.id_cct');
      $this->db->join('municipio as mu', 'es.id_municipio = mu.id_municipio');
      $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
      if($id_municipio>0){
        $this->db->where('mu.id_municipio', $id_municipio);
      }
      if($id_nivel>0){
        $this->db->where('ni.id_nivel', $id_nivel);
      }
      $this->db->group_by(" so.id_sostenimiento");
      return  $this->db->get()->result_array();
    }// get_xcvenivel()

    function get_sostenimiento($id_sostenimiento){
      if ($id_sostenimiento==0) {
        return "TODOS";
      }
      else {
        $this->db->select('so.sostenimiento');
        $this->db->from('sostenimiento as so');
        $this->db->where('so.id_sostenimiento', $id_sostenimiento);
        return  $this->db->get()->row('sostenimiento');
      }

    }// get_sostenimiento()

}// Sostenimiento_model
