<?php
class Supervision_model extends CI_Model
{
    function __construct(){
        parent::__construct();
    }

    function allzonas(){
      $this->db->select('su.id_supervision, su.zona_escolar');
      $this->db->from('supervision as su');
      $this->db->join('escuela as es','su.id_supervision = es.id_supervision');
      $this->db->group_by(" su.id_supervision");
      return  $this->db->get()->result_array();
    }// all()

    function getzona_idnivel_xsost($id_nivel,$id_subsostenimiento){

      $this->db->select('su.id_supervision, su.zona_escolar');
      $this->db->from('escuela as es');
      $this->db->join('estadistica_e_indicadores_xcct as est', 'es.id_cct = est.id_cct');
      $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
      $this->db->join('subsostenimiento as sso', 'es.id_subsostenimiento = sso.id_subsostenimiento');
      $this->db->join('supervision as su', 'es.id_supervision = su.id_supervision');
      if ($id_nivel>0) {
        $this->db->where('ni.id_nivel', $id_nivel);
      }
      $this->db->where('sso.id_subsostenimiento', $id_subsostenimiento);

      $this->db->group_by("su.id_supervision");
      $this->db->order_by("su.zona_escolar");
      // $this->db->get();
      // $str = $this->db->last_query();
      // echo $str; die();
      return  $this->db->get()->result_array();

    }// getzona_idnivel_xsost

    function get_zona($id_nivel_z, $id_sostenimiento_z,$id_zona_z){
      if ($id_sostenimiento_z==0) {
        return "TODOS";
      }
      else {
        $this->db->select('su.id_supervision, su.zona_escolar');
        $this->db->from('escuela as es');
        $this->db->join('estadistica_e_indicadores_xcct as est', 'es.id_cct = est.id_cct');
        $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
        $this->db->join('subsostenimiento as sso', 'es.id_subsostenimiento = sso.id_subsostenimiento');
        $this->db->join('supervision as su', 'es.id_supervision = su.id_supervision');
        $this->db->where('su.id_supervision', $id_zona_z);
        $this->db->where('ni.id_nivel', $id_nivel_z);
        $this->db->where('sso.id_subsostenimiento', $id_sostenimiento_z);
        return  $this->db->get()->row('zona_escolar');
      }

    }// get_zona()

}// Municipio_model
