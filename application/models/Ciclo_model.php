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

    function getciclo_idnivel_xsost_xzona($id_nivel, $id_subsost, $id_zona){
      $this->db->select('ci.id_ciclo, ci.ciclo');
      $this->db->from('ciclo ci');
      $this->db->join('estadistica_e_indicadores_xcct as est ',' ci.id_ciclo = est.id_ciclo');
      $this->db->join('escuela as es','est.id_cct = es.id_cct');
      $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
      $this->db->join('subsostenimiento as sso', 'es.id_subsostenimiento = sso.id_subsostenimiento');
      if($id_nivel>0){
        $this->db->where('ni.id_nivel', $id_nivel);
      }
      if($id_subsost>0){
        $this->db->where('sso.id_subsostenimiento', $id_subsost);
      }
      if($id_zona>0){
        $this->db->where('es.id_supervision', $id_zona);
      }
      $this->db->where('ci.id_ciclo', 4);
      $this->db->group_by(" ci.id_ciclo");

      // $this->db->get();
      // $str = $this->db->last_query();
      // echo $str; die();
      return  $this->db->get()->result_array();

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
