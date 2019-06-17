<?php
class Prioridad_model extends CI_Model
{
    function __construct(){
        parent::__construct();
    }

    function get_prioridades(){
      $str_query = "SELECT id_prioridad, prioridad FROM rm_c_prioridad";
      return $this->db->query($str_query)->result_array();
    }// get_prioridades()

    function get_prioridadesxnivel($idnivel){
      
      if ($idnivel == 'INICIAL') {
        $str_query = "SELECT id_prioridad, prioridad FROM rm_c_prioridad where id_prioridad>4";
      }
      else {
        $str_query = "SELECT id_prioridad, prioridad FROM rm_c_prioridad where id_prioridad<5";
      }

      return $this->db->query($str_query)->result_array();
    }// get_prioridadesxnivel()

}// Prioridad_model
