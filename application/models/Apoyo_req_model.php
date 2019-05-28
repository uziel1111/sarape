<?php
class Apoyo_req_model extends CI_Model
{
    function __construct(){
        parent::__construct();
    }

    function get_apoyo_req(){
      $str_query = "SELECT id_apoyo_req_se, apoyo_req_se FROM rm_c_apoyo_req ORDER BY id_apoyo_req_se DESC";
      return $this->db->query($str_query)->result_array();
    }// get_prioridades()

}// Prioridad_model
