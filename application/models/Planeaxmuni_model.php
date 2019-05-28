<?php
class Planeaxmuni_model extends CI_Model
{
    function __construct(){
        parent::__construct();
    }


    function get_planea_xmunciclo($id_municipio, $periodo, $nivel){
      if($id_municipio>0){
      $this->db->select('CONCAT(nivel, " (", periodo, ")") AS nivel, lyc_i, lyc_ii, lyc_iii, lyc_iv, mat_i, mat_ii, mat_iii, mat_iv');
      $this->db->from('planeaxmuni');
      $this->db->where('id_municipio', $id_municipio);
      $this->db->where('periodo', $periodo);
      $this->db->where('id_nivel', $nivel);
      return  $this->db->get()->result_array();
      }
      else {
      $this->db->select('CONCAT(nivel, " (", periodo, ")") AS nivel, lyc_i, lyc_ii, lyc_iii, lyc_iv, mat_i, mat_ii, mat_iii, mat_iv');
      $this->db->from('planeaxestado');
      $this->db->where('periodo', $periodo);
      $this->db->where('id_nivel', $nivel);
      return  $this->db->get()->result_array();
      }

    }// get_planea_xmunciclo()

    function allperiodos(){
      $this->db->select('id_periodo, periodo');
      $this->db->from('periodoplanea');
      // $this->db->order_by("id_periodo", "desc");
      return  $this->db->get()->result_array();
    }// all()

}// Planeaxmuni_model
