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
      return  $this->db->get()->result_array();
    }// all()


    function get_ciclo_planea_prim($id_ciclo){
      $query="SELECT p.periodo
              FROM relacion_ciclo r
              INNER JOIN periodoplanea p ON r.id_periodo_planea_prim = p.id_periodo
              WHERE r.id_ciclo_est={$id_ciclo}";
      return $this->db->query($query)->row('periodo');
    }// get_ciclo_planea_prim
    function get_ciclo_planea_sec($id_ciclo){
      $query="SELECT p.periodo
              FROM relacion_ciclo r
              INNER JOIN periodoplanea p ON r.id_periodo_planea_secundaria = p.id_periodo
              WHERE r.id_ciclo_est={$id_ciclo}";
      return $this->db->query($query)->row('periodo');
    }// get_ciclo_planea_sec
    function get_ciclo_planea_ms($id_ciclo){
      $query="SELECT p.periodo
              FROM relacion_ciclo r
              INNER JOIN periodoplanea p ON r.id_periodo_planea_mediasuperior = p.id_periodo
              WHERE r.id_ciclo_est={$id_ciclo}";
      return $this->db->query($query)->row('periodo');
    }// get_ciclo_planea_ms

}// Planeaxmuni_model
