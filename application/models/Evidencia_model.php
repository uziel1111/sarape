<?php
class Evidencia_model extends CI_Model
{
    function __construct(){
        parent::__construct();
    }

    function get_evidencias(){
      $str_query = "SELECT id_evidencia, evidencia FROM rm_c_evidencia ORDER BY id_evidencia DESC";
      return $this->db->query($str_query)->result_array();
    }// get_prioridades()

}// Prioridad_model
