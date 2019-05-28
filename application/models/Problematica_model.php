<?php
class Problematica_model extends CI_Model
{
    function __construct(){
        parent::__construct();
    }

    function get_problematicas(){
      $str_query = "SELECT id_problematica, problematica FROM rm_c_problematica ORDER BY id_problematica DESC";
      return $this->db->query($str_query)->result_array();
    }// get_prioridades()

}// Prioridad_model
