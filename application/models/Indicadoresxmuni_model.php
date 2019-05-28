<?php
class Indicadoresxmuni_model extends CI_Model
{
    function __construct(){
        parent::__construct();
    }



    function get_ind_asistenciaxmuniidciclo($id_municipio,$id_ciclo){
      if($id_municipio>0){
      $this->db->select('nivel, cobertura, absorcion');
      $this->db->from('indicadoresxmuni');
      $this->db->where('id_municipio', $id_municipio);
      $this->db->where('id_ciclo', $id_ciclo);
      return  $this->db->get()->result_array();
      }
      else {
        return array();
      }



    }// get_ind_asistenciaxmuniidciclo

    function get_ind_permanenciaxmuniidciclo($id_municipio,$id_ciclo){
      if($id_municipio>0){
      $this->db->select('nivel, retencion,aprobacion, et');
      $this->db->from('indicadoresxmuni');
      $this->db->where('id_municipio', $id_municipio);
      $this->db->where('id_ciclo', $id_ciclo);
      return  $this->db->get()->result_array();
      }
      else {
        return array();
      }



    }// get_ind_permanenciaxmuniidciclo

}// Municipio_model
