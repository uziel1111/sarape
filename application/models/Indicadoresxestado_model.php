<?php
class Indicadoresxestado_model extends CI_Model
{
    function __construct(){
        parent::__construct();
    }



    function get_ind_asistenciaxestadoidciclo($id_ciclo){
      $this->db->select('nivel, cobertura, absorcion');
      $this->db->from('indicadoresxestado');
      $this->db->where('id_ciclo', $id_ciclo);
      return  $this->db->get()->result_array();
    }// get_ind_asistenciaxestadoidciclo

    function get_ind_permanenciaxestadoidciclo($id_ciclo){
      $this->db->select('nivel, retencion,aprobacion, et');
      $this->db->from('indicadoresxestado');
      $this->db->where('id_ciclo', $id_ciclo);
      return  $this->db->get()->result_array();
    }// get_ind_permanenciaxmuniidciclo

}// Indicadoresxestado_model
