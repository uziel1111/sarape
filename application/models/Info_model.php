<?php
class Info_model extends CI_Model
{
    function __construct(){
        parent::__construct();
    }

    function get_info_escuela($id_cct){
      $this->db->select('es.nombre_centro, es.cve_centro, tu.turno_single, n.nivel, m.modalidad, sos.sostenimiento, re.region, es.domicilio, l.localidad, mun.municipio, es.nombre_director, sta.estatus');
      $this->db->from('escuela es');
      $this->db->join('turno_single as tu', 'tu.id_turno_single = es.id_turno_single');
      $this->db->join('nivel as  n', 'n.id_nivel = es.id_nivel');
      $this->db->join('modalidad as m', 'm.id_modalidad = es.id_modalidad');
      $this->db->join('subsostenimiento as subs', 'subs.id_subsostenimiento = es.id_subsostenimiento');
      $this->db->join('sostenimiento as sos', 'sos.id_sostenimiento = subs.id_sostenimiento');

      $this->db->join('municipio as mun', 'mun.id_municipio = es.id_municipio');
      $this->db->join('localidad as l', 'mun.id_municipio = l.id_municipio and l.cve_localidad = es.id_localidad');
      $this->db->join('region as re', 're.id_region = es.id_region');
      $this->db->join('estatus as sta', 'sta.id_estatus = es.id_estatus');
      $this->db->where('es.id_cct', $id_cct);
      return  $this->db->get()->result_array();
    }// getmodali_xidmun_idnivel_idsost()

}// Sostenimiento_model
