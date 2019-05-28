<?php
class Ambito_model extends CI_Model
{
    function __construct(){
        parent::__construct();
    }

    function get_ambitos(){
      $str_query = "SELECT id_ambito, ambito FROM rm_c_ambito ORDER BY id_ambito DESC";
      return $this->db->query($str_query)->result_array();
    }// get_prioridades()

}// Prioridad_model
